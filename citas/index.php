<?php
require_once("../control_db.php");

class Escritorio extends SNTE{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}
	public function citas(){
		$arreglo=array();
		$maxcitas_retiros=5;   /////////////variable para maximo numero de citas
		$maxcitas_creditos=3;   /////////////variable para maximo numero de citas
		$max=0;

		try{
			$desde=clean_var($_REQUEST['desde']);
			$hora=clean_var($_REQUEST['hora']);
			$tipo=clean_var($_REQUEST['tipo']);

			$dia_semana=date("w", strtotime($desde));

			////////////para bloquear sabados y domingos
			if($dia_semana==0 or $dia_semana==6){
				$arreglo=array('activo'=>0, 'dato'=>"0", 'tipo'=>$tipo,'texto'=>"No hay horarios de atención sabados y domingos");
				return json_encode($arreglo);
			}
			//////////termina bloqueo

			///////////retiro=1
			///////////credito=2
			////////////////////////////para asignar automaticamente
			if($hora=="asignar"){
				$fec=explode("-",clean_var($_REQUEST['desde']));
				$x="";
				$query="select count(fecha) as numero, fecha, TIME(fecha) as hora from citas where year(fecha)=".$fec[2]." and month(fecha)=".$fec[1]." and day(fecha)=".$fec[0]." and tipo='$tipo' and apartado=2 group by fecha order by fecha asc";
				$sth = $this->dbh->prepare($query);
				$sth->execute();
				$resp=$sth->fetchAll();
				$x="";
				$arr_hora=array();
				foreach($resp as $key){
					$arr_hora[$key['hora']]=$key['numero'];
				}
				$sale=1;
				if($tipo==1){	//////////////retiro
					for($i=10; $i<=13 and $sale==1; $i++){
						for($j=0; $j<=55 and $sale==1; $j=$j+5){
							$h=str_pad($i,2,"0",STR_PAD_LEFT);
							$t=str_pad($j,2,"0",STR_PAD_LEFT);
							$hora="$h:$t:00";
							if(isset($arr_hora[$hora])){
								if($arr_hora[$hora]<5){ //maximo numero de citas de retiro en busqueda automatica
									$sale=0;
								}
							}
							else{
								$sale=0;
							}
						}
					}
				}
				if($tipo==2){	//////////////credito
					for($i=10; $i<=13 and $sale==1; $i++){
						for($j=0; $j<=45 and $sale==1; $j=$j+10){
							$h=str_pad($i,2,"0",STR_PAD_LEFT);
							$t=str_pad($j,2,"0",STR_PAD_LEFT);
							$hora="$h:$t:00";
							if(isset($arr_hora[$hora])){
								if($arr_hora[$hora]<3){ //maximo numero de citas de creditos en busqueda automatica
									$sale=0;
								}
							}
							else{
								$sale=0;
							}
						}
					}
				}
				if($sale==1){
					$arreglo=array('activo'=>0, 'dato'=>"0", 'tipo'=>$tipo,'texto'=>"No hay disponibilidad para el dia seleccionado");
					return json_encode($arreglo);
				}
			}
			else{
				$hora.=":00";
			}
			///////////////////////////hasta aqui

			$verifica = date("Y-m-d", strtotime($desde));
			if($tipo==1){
				$max=$maxcitas_retiros;
				$bloq="select * from diasno where fecha='$verifica'";
			}
			if($tipo==2){
				$max=$maxcitas_creditos;
				$bloq="select * from diasnocred where fecha='$verifica'";
			}
			//////////////////comprueba que efectivamente no este el dia bloqueado;
			$sth = $this->dbh->prepare($bloq);
			$sth->execute();
			if($sth->rowCount()>0){
				$arreglo=array('activo'=>0, 'dato'=>"0", 'tipo'=>$tipo,'texto'=>"No hay disponibilidad para el horario seleccionado");
				return json_encode($arreglo);
			}
			////////////////hasta aqui

			$actual=date('Y-m-d H:i:s');
			$fechax = date("Y-m-d", strtotime($desde))." $hora";
			$limite=new DateTime();
			$limite->modify("+6 minute");

			$sql="select * from citas where tipo='$tipo' and fecha='$fechax' and (apartado=2 or (apartado=1 and limite>'$actual'))";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$reg=$sth->rowCount();

			if($reg<$max){
				$sql="select * from citas where tipo='$tipo' and fecha='$fechax' and (apartado=1 and limite<'$actual')";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();

				$arreglo+=array('idfolio'=>$_SESSION['idfolio']);
				$arreglo+=array('fecha'=>$fechax);
				$arreglo+=array('caja'=>1);
				$arreglo+=array('apartado'=>1);
				$arreglo+=array('limite'=>$limite->format('Y-m-d H:i:s'));
				$arreglo+=array('fcreado'=>$actual);
				$arreglo+=array('tipo'=>$tipo);

				if($sth->rowCount()==0){
					$arreglo+=array('caja'=>1);
					$x=$this->insert('citas', $arreglo);
				}
				else{
					$tmp=$sth->fetch(PDO::FETCH_OBJ);
					$x=$this->update('citas',array('id'=>$tmp->id), $arreglo);
				}
				$cita=json_decode($x);

				$t="<div class='card'>";
					$t.="<div class='card-header'>";
						$t.="Confirmar";
					$t.="</div>";
					$t.="<div class='card-body'>";
					$t.= "<input class='form-control' type='hidden' id='tipo' name='tipo' value='$tipo' readonly>";
						$t.="<div class='row'>";
							$t.= "<div class='col-3'>";
									$t.= "<label># Cita</label>";
									$t.= "<input class='form-control' type='text' id='cita' name='cita' value='$cita->id' readonly>";
							$t.= "</div>";
							$t.= "<div class='col-3'>";
									$t.= "<label>Fecha</label>";
									$t.= "<input class='form-control' type='text' id='desde' name='desde' value='$desde' readonly>";
							$t.= "</div>";
							$t.= "<div class='col-3'>";
									$t.= "<label>Hora</label>";
									$t.= "<input class='form-control' type='text' id='hora' name='hora' value='$hora' readonly>";
							$t.= "</div>";
							$t.= "<div class='col-12'>";
									$t.= "<label>Observaciones</label>";
									$t.= "<input class='form-control' type='text' id='observaciones' name='observaciones' value='' placeholder='Observaciones'>";
							$t.= "</div>";
						$t.= "</div>";
						$t.="<div class='row'>";
							$t.= "<div class='col-12'>";
								$t.="<div class='btn-group'>";
									$t.= "<button class='btn btn-danger btn-sm' type='button' onclick='confirmar_cita()'><i class='far fa-calendar-check'></i>Confirmar cita</button>";
									$t.= "<button class='btn btn-warning btn-sm' type='button' onclick='cancela_previo()'><i class='far fa-trash-alt'></i>Cancelar</button>";
								$t.="</div>";
							$t.="</div>";
						$t.="</div>";
					$t.="</div>";
				$t.="</div>";
				$arreglo=array('activo'=>1, 'dato'=>$x, 'tipo'=>$tipo, 'texto'=>$t);
			}
			else{
				$arreglo=array('activo'=>0, 'dato'=>"0", 'tipo'=>$tipo,'texto'=>"No hay disponibilidad para el horario seleccionado");
			}
			return json_encode($arreglo);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function confirmar(){
		try{
			$cita=clean_var($_REQUEST['cita']);
			$observaciones=clean_var($_REQUEST['observaciones']);
			$actual=date('Y-m-d H:i:s');
			$arreglo=array();
			$arreglo+=array('idfolio'=>$_SESSION['idfolio']);
			$arreglo+=array('fcreado'=>$actual);
			$arreglo+=array('apartado'=>2);
			$arreglo+=array('observaciones'=>$observaciones);
			$x=$this->update('citas',array('id'=>$cita), $arreglo);
			if($x){
				$arreglo=array('id'=>0,'error'=>0, 'terror'=>"");
			}
			else{
				$arreglo=array('id'=>0,'error'=>1, 'terror'=>$x);
			}
			return json_encode($arreglo);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function citas_lista($tipo){
		try{

			$fecha=date('Y-m-d')." 00:00:00";
			$sql="select * from citas left outer join afiliados on afiliados.idfolio=citas.idfolio
			where apartado=2 and tipo='$tipo' and fecha>='$fecha'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function citas_bloqueo(){	//para los dias de retiro
		try{
			$sql="select * from diasno";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function citas_bloqueocred(){ //para los dias de creditos
		try{

			$sql="select * from diasnocred";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function cita_ver($id){
		try{

			$fecha=date('Y-m-d')." 00:00:00";
			$sql="select citas.*, afiliados.nombre, afiliados.ape_pat, afiliados.ape_mat, afiliados.Filiacion from citas left outer join afiliados on afiliados.idfolio=citas.idfolio
			where citas.id='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function citas_afiliados(){
		try{
			$fecha=date('Y-m-d')." 00:00:00";
		//	$sql="select * from citas where idfolio=:idfolio and (apartado=2 or apartado=3) and fecha>='$fecha' order by fecha desc";
			$sql="select * from citas where idfolio=:idfolio and (apartado=2 or apartado=3) order by fecha desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function cancelar_cita(){
		$cita=clean_var($_REQUEST['cita']);
		$arreglo=array();
		$arreglo+=array('apartado'=>3);
		$arreglo+=array('realizada'=>2);
		$x=$this->update('citas',array('id'=>$cita), $arreglo);
		return $x;
	}
	public function pre_cancela(){
		$cita=clean_var($_REQUEST['cita']);
		$x=$this->borrar('citas',"id",$cita);
		return $x;
	}
}

$db = new Escritorio();
if(strlen($function)>0){
  echo $db->$function();
}


?>
