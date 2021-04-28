<?php
	session_name("snte_app");
	@session_start();

	$function=clean_var($_REQUEST['function']);
	if($_SERVER['REQUEST_METHOD']!="POST"){
		return 0;
	}

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	require_once("../init.php");
	class sagyc{
		public $nivel_personal;
		public $nivel_captura;

		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			try{
				$this->dbh = new PDO("mysql:host=".SERVIDOR.";dbname=".BDD, MYSQLUSER, MYSQLPASS);
				$this->dbh->query("SET NAMES 'utf8'");
			}
			catch(PDOException $e){
				return "Database access FAILED!";
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
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function acceso(){
			try{

				$token=clean_var($_REQUEST['token']);
				$us_fake=clean_var($_REQUEST['userAcceso']);
				$pa_fake=clean_var($_REQUEST['passAcceso']);


				$sql="select idfolio, Filiacion, password, nombre, ape_pat, ape_mat from afiliados where Filiacion='$us_fake' and password='$pa_fake'";
				$sth = $this::general_($sql);
				if($sth->rowCount()>0){
					$CLAVE=$sth->fetch(PDO::FETCH_OBJ);
					$userBD = trim($CLAVE->Filiacion);
					$passwordBD = trim($CLAVE->password);

					if($userBD == $us_fake and $passwordBD==$pa_fake){
						$_SESSION['autoriza_SNTE']=1;
						$_SESSION['filiacion']=$CLAVE->Filiacion;
						$_SESSION['nombre']=$CLAVE->nombre;
						$_SESSION['ape_pat']=$CLAVE->ape_pat;
						$_SESSION['ape_mat']=$CLAVE->ape_mat;
						$_SESSION['idfolio']=$CLAVE->idfolio;
						$_SESSION['llave']=md5(rand(10000,99999).$passwordBD);

						$_SESSION['administrador']=0;
						$_SESSION['hasta']=date("Y");
						$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

						$arr=array();
						$arr+=array('acceso'=>1);
						return json_encode($arr);
					}
				}
				else {
					$sql="select * from usuarios where NOMBRE='$us_fake' and CLAVE_ACC='$pa_fake'";
					$sth = $this::general_($sql);
					if($sth->rowCount()>0){
						$CLAVE=$sth->fetch(PDO::FETCH_OBJ);

						$userBD = trim($CLAVE->NOMBRE);
						$passwordBD = trim($CLAVE->CLAVE_ACC);
						if($userBD == $us_fake and $passwordBD==$pa_fake){
							$_SESSION['autoriza_SNTE']=1;
							$_SESSION['filiacion']=$CLAVE->RFC;
							$_SESSION['nombre']=$CLAVE->NOMBRE;
							$_SESSION['idfolio']=$CLAVE->CLV_PER;
							$_SESSION['ape_pat']="";
							$_SESSION['ape_mat']="";

							$_SESSION['administrador']=1;
							$_SESSION['hasta']=date("Y");
							$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

							$arr=array();
							$arr+=array('acceso'=>1);
							return json_encode($arr);
						}
					}
					else{
						$arr=array();
						$arr=array('acceso'=>0);
						return json_encode($arr);
					}
				}
			}catch(PDOException $e){
				return "Database access FAILED!";
			}
		}

		public function rec(){
			$userPOST = htmlspecialchars($_REQUEST["userAcceso"]);
			$sql="select idpersona, usuario, correo, correoinstitucional from personal where usuario=:usuario or correo=:correo";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":usuario",$userPOST);
			$sth->bindValue(":correo",$userPOST);
			$sth->execute();
			$res=$sth->fetch(PDO::FETCH_OBJ);

			if($sth->rowCount()>0){
				if(strlen(trim($res->correo))>0){
					$pass=self::genera_random(8);
					$passg=md5(trim($pass));

					$sql="update personal set pass=:pass where idpersona=:id";
					$sth = $this->dbh->prepare($sql);
					$sth->bindValue(":pass",$passg);
					$sth->bindValue(":id",$res->idpersona);
					$sth->execute();

					$texto="La nueva contraseña es: <br> $pass";
					$texto.="<br></a>";
					return self::correo($res->correo,$texto,"Cambio de contraseña");
				}
				else{
					$arreglo=array();
					$arreglo+=array('error'=>1);
					$arreglo+=array('terror'=>"no tiene correo registrado en la base de datos");
				}
				return json_encode($arreglo);
			}
			else{
				return 0;
			}
		}
		public function correo($correo, $texto, $asunto){
			/////////////////////////////////////////////Correo
			require '../vendor/autoload.php';
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';

			$mail->Body    = $asunto;
			$mail->Subject = $asunto;
			$mail->AltBody = $asunto;

			$mail->isSMTP();

			////////////cambiar esta configuracion
				$mail->Host = "smtp.gmail.com";						  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication

				$mail->Username = "sistema.subsaludpublicahgo@gmail.com";       // SMTP username
				$mail->Password = "TEUFEL123";


				$mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 465;                                    // TCP port to connect to
				$mail->CharSet = 'UTF-8';

				$mail->From = "sistema.subsaludpublicahgo@gmail.com";   //////////esto solo muestra el remitente
				$mail->FromName = "Recuperar contraseña";			//////////// remitente
			//////////hasta aca

			$mail->IsHTML(true);
			$mail->addAddress($correo);

			$mail->msgHTML($texto);
			$arreglo=array();

			if (!$mail->send()) {
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$mail->ErrorInfo);
				return json_encode($arreglo);
			} else {
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>'Se nofiticó al correo: '.$correo.' la nueva contraseña');
				return json_encode($arreglo);
			}
		}
		public function genera_random($length = 15) {
    		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		}
	}
	function clean_var($val){
		$val=htmlspecialchars(strip_tags(trim($val)));
		return $val;
	}

	$db = new sagyc();
	if(strlen($function)>0){
		echo $db->$function();
	}
//250
?>
