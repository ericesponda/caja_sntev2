<?php
require_once("../control_db.php");

class Escritorio extends Sagyc{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}
	public function catalogo(){
		try{
			$sql="select * from cat_bancos order by nombre asc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function guardar_bancos(){			////////PARA CAMBIOS DE DATOS
		$x="";
		$arreglo =array();
		$id=clean_var($_REQUEST['id']);
		if(strlen($id)==0){
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"Error de sesión, favor de verificar o reingresar");
			return json_encode($arr);
		}


		$sql="select * from afiliados where idfolio=:idfolio";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$id);
		$sth->execute();
		$row=$sth->fetch();

		$cambios="";
		$tipo_lay_out="";
		$tipo_cuenta=clean_var($_REQUEST['tipo_cuenta']);

		if($tipo_cuenta=="SANTAN"){
			$tipo_lay_out="LA001";
			$clave_banco="";
			$num=11;
			$bancon="SANTANDER";
		}
		else{
			$num=18;
			$sql="select * from cat_bancos where clave='$tipo_cuenta'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$banco=$sth->fetch();
			$bancon=$banco['nombre'];

			$clave_banco=$tipo_cuenta;
			$tipo_cuenta="EXTRNA";
			$tipo_lay_out="LA002";
		}

		$num_cuenta=clean_var($_REQUEST['num_cuenta']);
		$num_cuenta2=clean_var($_REQUEST['num_cuenta2']);
		if($num_cuenta!=$num_cuenta2){
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"la cuenta no coincide, favor de verificar");
			return json_encode($arr);
		}

		if(strlen($num_cuenta)!=$num){
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"Número de cuenta incorrecto son $num digitos");
			return json_encode($arr);
		}

		$cambios="";
		if($row['tipo_cuenta']!=$tipo_cuenta){
			$cambios.=" tipo_cuenta:".trim($tipo_cuenta);
		}
		if($row['num_cuenta']!=$num_cuenta){
			$cambios.=" num_cuenta:".trim($num_cuenta);
		}
		if($row['clave_banco']!=$clave_banco){
			$cambios.=" clave_banco:".trim($clave_banco);
		}



		if(strlen($cambios)>1){
			$arr=array();
			$fecha=date("Y-m-d H:i:s");
			$arreglo+=array('up_date'=>1);
			$arreglo+=array('fup'=>$fecha);
			$arreglo+=array('idfolio'=>$row['idfolio']);
			$arreglo+=array('filiacion'=>$row['Filiacion']);
			$arreglo+=array('nombre'=>$row['nombre']);
			$arreglo+=array('ape_pat'=>$row['ape_pat']);
			$arreglo+=array('ape_mat'=>$row['ape_mat']);
			$arreglo+=array('tipo_lay_out'=>trim($tipo_lay_out));

			$arreglo+=array('tipo_cuenta'=>trim($tipo_cuenta));
			$arreglo+=array('num_cuenta'=>trim($num_cuenta));
			$arreglo+=array('clave_banco'=>trim($clave_banco));
			$arreglo+=array('banco'=>$bancon);

			$x=$this->insert('bit_bancos', $arreglo);
			return $x;
		}
		else{
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"No hay cambios");
			return json_encode($arr);
		}
	}
	public function cancela_datos(){
		$x="";
		$sql="select * from bit_bancos where idfolio=:idfolio and up_date=1";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$_SESSION['idfolio']);
		$sth->execute();
		$row=$sth->fetch();

		$x=$this->borrar('bit_bancos','idbanco',$row['idbanco']);
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
