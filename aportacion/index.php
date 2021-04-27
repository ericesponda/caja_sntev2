<?php
require_once("../control_db.php");


if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert' style='font-size:10px'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "<br>";
	echo print_r($_REQUEST);
	echo "</div>";
}


class Escritorio extends SNTE{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}
	public function guardar_aportacion(){			/////////////////////////////////////PARA CAMBIOS DE APORTACIONES
		if(strlen($_SESSION['idfolio'])==0){
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"Error de sesión, favor de verificar o reingresar");
			return json_encode($arr);
		}
		
		$sql="select * from afiliados where idfolio=:idfolio";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$_SESSION['idfolio']);
		$sth->execute();
		$row=$sth->fetch();

		$cambios="";
		$a_qui=clean_var($_REQUEST['a_qui']);
		if($a_qui<100){
			return "la aportación no puede ser menor de 100";
		}
		if($row['a_qui']!=$a_qui){
			////////////////////consulto saldo de afiliado
			$sql="SELECT *,round((SELECT SUM(monto) FROM detallepago WHERE detallepago.idcredito=cred.clv_cred ),2) AS abono,
			(cred.total-round((SELECT SUM(monto) FROM detallepago WHERE detallepago.idcredito=cred.clv_cred ),2)) as saldo FROM creditos cred
			left outer join afiliados on afiliados.idfolio=cred.idfolio where cred.idfolio=:folio";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":folio",$_SESSION['idfolio']);
			$sth->execute();
			$cuenta = $sth->rowCount();
			$saldos=$sth->fetchAll();
			$entra=0;
			if($a_qui<$row['a_qui']){
				if($cuenta==0){			//////////////no hay creditos entonces puede pasar
					$entra=1;
				}
				else{
					////////////hay creditos entonces checar si alguno tiene mas de 100 pesos en saldo para mandarlo alv...
					foreach ($saldos as $key) {
						if($key['saldo']>=100){
							$entra=1; ////////////con el primero que se encuentre con mas de 100 pesos basta..
							return "imposible disminuir aportación, por saldo en creditos";
						}
						else {
							$entra=1;
						}
					}
				}
				if($entra==0){
					return "Imposible disminuir aportación";
				}
			}

			$arreglo =array();
			$arreglo+=array('up_aportacion'=>1);
			$arreglo+=array('a_qui'=>$a_qui);
			$fecha=date("Y-m-d H:i:s");
			$arreglo+=array('faport_sol'=>$fecha);
			$arreglo+=array('up_aportacion'=>1);
			$arreglo+=array('tipo'=>"APORTACION");
			$arreglo+=array('idfolio'=>$row['idfolio']);
			$arreglo+=array('filiacion'=>$row['Filiacion']);
			$arreglo+=array('nombre'=>$row['nombre']);
			$arreglo+=array('ape_pat'=>$row['ape_pat']);
			$arreglo+=array('ape_mat'=>$row['ape_mat']);
			$x=$this->insert_('bit_datos', $arreglo);
			return $x;
		}
		else{
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"No hay cambios");
			return json_encode($arr);
		}
	}
	public function cancela_aporta(){
		$x="";
		$arreglo =array();
		$arreglo+=array('up_aportacion'=>0);

		$sql="select * from bit_datos where idfolio=:idfolio and up_aportacion=1";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$_SESSION['idfolio']);
		$sth->execute();
		$row=$sth->fetch();

		$x=$this->borrar_('bit_datos','id',$row['id']);
		if($x){
			$arr=array();
			$arr+=array('error'=>0);
			$arr+=array('terror'=>"");
		}
		else{
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"Error favor de verificar");
		}
		return json_encode($arr);
	}
}

$db = new Escritorio();
if(strlen($function)>0){
  echo $db->$function();
}


?>
