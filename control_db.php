<?php
	session_name("snte_app");
	@session_start();

	if (isset($_REQUEST['function'])){$function=clean_var($_REQUEST['function']);}	else{ $function="";}
	if (isset($_REQUEST['ctrl'])){$ctrl=clean_var($_REQUEST['ctrl']);}	else{ $ctrl="";}

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	date_default_timezone_set("America/Mexico_City");

	require_once("init.php");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	class SNTE{
		public $nivel_personal;
		public $nivel_captura;
		public $derecho=array();
		public $lema;
		public $personas;
		public $arreglo;
		public $limite=300;


		public function __construct(){
			date_default_timezone_set("America/Mexico_City");

			$this->dbh = new PDO("mysql:host=".SERVIDOR.";port=".PORT.";dbname=".BDD, MYSQLUSER, MYSQLPASS);
			$this->dbh->query("SET NAMES 'utf8'");

			if (isset($_SESSION['idpersona'])){
				$sql="select * from personal_permiso where idpersona='".$_SESSION['idpersona']."'";
				foreach ($this->dbh->query($sql) as $res){
					$this->derecho[$res['nombre']]['nombre']=$res['nombre'];
					$this->derecho[$res['nombre']]['acceso']=$res['acceso'];
				}
			}
		}

		public function insert_($DbTableName, $values = array()){
			$arreglo=array();
			try{
				$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				foreach ($values as $field => $v)
				$ins[] = ':' . $field;

				$ins = implode(',', $ins);
				$fields = implode(',', array_keys($values));
				$sql="INSERT INTO $DbTableName ($fields) VALUES ($ins)";
				$sth = $this->dbh->prepare($sql);
				foreach ($values as $f => $v){
					$sth->bindValue(':' . $f, $v);
				}
				if ($sth->execute()){
					$arreglo+=array('id1'=>$this->lastId = $this->dbh->lastInsertId());
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}
		public function update_($DbTableName, $id = array(), $values = array()){
			$arreglo=array();
			try{
				$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$x="";
				$idx="";
				foreach ($id as $field => $v){
					$condicion[] = $field.'= :' . $field."_c";
				}
				$condicion = implode(' and ', $condicion);
				foreach ($values as $field => $v){
					$ins[] = $field.'= :' . $field;
				}
				$ins = implode(',', $ins);

				$sql2="update $DbTableName set $ins where $condicion";
				$sth = $this->dbh->prepare($sql2);
				foreach ($values as $f => $v){
					$sth->bindValue(':' . $f, $v);
				}
				foreach ($id as $f => $v){
					if(strlen($idx)==0){
						$idx=$v;
					}
					$sth->bindValue(':' . $f."_c", $v);
				}
				if($sth->execute()){
					$arreglo+=array('id1'=>$idx);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}
		public function borrar_($DbTableName, $key, $id){
			$arreglo=array();
			try{
				$sql="delete from $DbTableName where $key=$id";
				$sth = $this->dbh->prepare($sql);
				$a=$sth->execute();
				if($a){
					$arreglo+=array('id1'=>$id);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					return json_encode($arreglo);
				}
				else{
					$arreglo+=array('id1'=>$id);
					$arreglo+=array('error'=>1);
					$b=$sth->errorInfo();
					$arreglo+=array('terror'=>$b[2]);
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}
		public function general_($sql,$tipo=0){
			try{
				if($tipo==0){
					return $this->dbh->query($sql);
				}
				if($tipo=="1"){
					$sth=$this->dbh->query($sql);
					return $sth->fetch(PDO::FETCH_OBJ);
				}
				if($tipo=="2"){
					$sth=$this->dbh->query($sql);
					return $sth->fetchAll(PDO::FETCH_OBJ);
				}

				if($tipo=="3"){
					return $sql->fetch(PDO::FETCH_OBJ);
				}
				if($tipo=="4"){
					return $sql->fetchAll(PDO::FETCH_OBJ);
				}

			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function paginar($paginas,$pag_actual,$des,$div,$var=array()){
			$pagx=$paginas-1;
			echo "<div class='pag_sagyc'>";
				echo "<div class='paginas'>";
			    echo "<a xapp='btn' title='Editar' xdes='$des' xdiv='$div'";
					if(is_array($var)){
						foreach($var as $key => $value){
							$mykey = $key;
							echo " v_".$key."='".$value."'";
						}
					}

					echo "><i class='fas fa-angle-double-left'></i></a>";
					$max=$pag_actual+4;
					$min=$pag_actual-4;

					$pre=0;
					$pos=0;
					for($i=0;$i<$paginas;$i++){
						////////para las anteriores a la selecionada
						$ant=$pag_actual-1;
						$desp=$pag_actual+1;

						$b=$i+1;

							if($i==0 or $i==($paginas-1) or $ant==$i or $desp==$i or $pag_actual==$i or $paginas<7){
								echo "<a "; if($pag_actual==$i){ echo "class='active'";} echo " xapp='btn' title='Editar' xdes='$des' xdiv='$div' v_pagina='$i' ";
								if(is_array($var)){
									foreach($var as $key => $value){
									$mykey = $key;
										echo " v_".$key."='".$value."'";
									}
								}
								echo ">$b</a>";
							}
							else{
								if(($pre==0) or ($pos==0 and $pre==1 and $i>$pag_actual)){
									echo "<a>...</a>";
									if($pre==0)
									$pre=1;
									if ($pos==0 and $pre==1 and $i>$pag_actual){
										$pos=1;
									}
								}
							}

					}
			    echo "<a class='paginacion-item' xapp='btn' title='Editar' xdes='$des' xdiv='$div' v_pagina='$pagx' ";
					if(is_array($var)){
						foreach($var as $key => $value){
							$mykey = $key;
							echo " v_".$key."='".$value."'";
						}
					}
					echo "><i class='fas fa-angle-double-right'></i></a>";
				echo "</div>";
			echo "</div>";
		}
		public function salir(){
			$_SESSION['autoriza'] = 0;
			$_SESSION['idpersona']="";
			$_SESSION = array();
			session_unset();
			session_destroy();

			$arreglo =array();
			$arreglo+=array('error'=>0);
			$arreglo+=array('terror'=>"Adios");
			return json_encode($arreglo);
		}
		public function login(){
			$arreglo=array();
			if(isset($_SESSION['idpersona']) and $_SESSION['autoriza'] == 1) {
				$arreglo=array('sess'=>"abierta",'admin'=>$_SESSION['administrador']);
			}
			else {
				$arreglo=array('sess'=>"cerrada");
			}
			return json_encode($arreglo);
		}



		public function fondo(){
			$_SESSION['idfondo']=$_REQUEST['imagen'];
			$this->update('personal',array('idpersona'=>$_SESSION['idpersona']), array('idfondo'=>$_SESSION['idfondo']));
		}
		public function fondo_carga(){
			$x="";
			$directory="fondo/";
			$dirint = dir($directory);
			$x.= "<ul class='nav navbar-nav navbar-right'>";
				$x.= "<li class='nav-item dropdown'>";
					$x.= "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-desktop'></i>Fondos</a>";
					$x.= "<div class='dropdown-menu' aria-labelledby='navbarDropdown' style='width: 200px;max-height: 400px !important;overflow: scroll;overflow-x: scroll;overflow-x: hidden;'>";
						while (($archivo = $dirint->read()) !== false){
							if ($archivo != "." && $archivo != ".." && $archivo != "" && substr($archivo,-4)==".jpg"){
								$x.= "<a class='dropdown-item' href='#' id='fondocambia' title='Click para aplicar el fondo'><img src='$directory".$archivo."' alt='Fondo' class='rounded' style='width:140px;height:80px'></a>";
							}
						}
					$x.= "</div>";
				$x.= "</li>";
			$x.= "</ul>";
			$dirint->close();
			return $x;
		}
		public function leerfondo(){
			return $_SESSION['idfondo'];
		}
	}

	if(strlen($ctrl)>0){
		$db = new snte();
		if(strlen($function)>0){
			echo $db->$function();
		}
	}
	function clean_var($val){
		$val=htmlspecialchars(strip_tags(trim($val)));
		return $val;
	}

	function moneda($valor){
		return "$ ".number_format( $valor, 2, "." , "," );
	}
	function fecha($fecha,$key=""){
		$mesn=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		if(strlen($fecha)>0){
			$fecha = new DateTime($fecha);
			if ($key==""){
				return $fecha->format('d-m-Y');
			}
			if($key==1){
				$mes=$fecha->format('n');
				return $fecha->format('d')." de $mesn[$mes] de ".$fecha->format('Y');
			}
			if($key==2){
				return $fecha->format('d-m-Y H:i:s');
			}
			if($key==3){
				$mes=$fecha->format('n');
				return $fecha->format('d')." de ". $mesn[$mes] ." de ".$fecha->format('Y')." ".$fecha->format('H:i:s');
			}
			if ($key=="4"){
				return $fecha->format('d/m/Y');
			}
			if ($key=="5"){
				$mes=$fecha->format('n');
				return $fecha->format('d')." de $mesn[$mes]";
			}
		}
	}


		//////////////////1078 LINEAS
?>
