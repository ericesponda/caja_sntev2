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

	

	public function guardar_datos(){			/////////////////////////////////////PARA CAMBIOS DE DATOS
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
		$d_dom=clean_var($_REQUEST['d_dom']);
		$e_civ=clean_var($_REQUEST['e_civ']);
		$n_con=clean_var($_REQUEST['n_con']);
		$l_loc=clean_var($_REQUEST['l_loc']);
		$m_mun=clean_var($_REQUEST['m_mun']);
		$c_c_t=clean_var($_REQUEST['c_c_t']);
		$u_bic=clean_var($_REQUEST['u_bic']);
		$d_sin=clean_var($_REQUEST['d_sin']);
		$r_rrg=clean_var($_REQUEST['r_rrg']);
		$c_psp=clean_var($_REQUEST['c_psp']);

		//$correo=$_REQUEST['correo'];
		//$celular=$_REQUEST['celular'];

		if($row['d_dom']!=$d_dom){
			$cambios.=" d_dom:".trim($d_dom);
		}
		if($row['e_civ']!=$e_civ){
			$cambios.=" e_civ:".trim($e_civ);
		}
		if($row['n_con']!=$n_con){
			$cambios.=" n_con:".trim($n_con);
		}
		if($row['l_loc']!=$l_loc){
			$cambios.=" l_loc:".trim($l_loc);
		}
		if($row['m_mun']!=$m_mun){
			$cambios.=" m_mun:".trim($m_mun);
		}
		if($row['c_c_t']!=$c_c_t){
			$cambios.=" c_c_t:".trim($c_c_t);
		}
		if($row['u_bic']!=$u_bic){
			$cambios.=" u_bic:".trim($u_bic);
		}
		if($row['d_sin']!=$d_sin){
			$cambios.=" d_sin:".trim($d_sin);
		}
		if($row['r_rrg']!=$r_rrg){
			$cambios.=" r_rrg:".trim($r_rrg);
		}
		if($row['c_psp']!=$c_psp){
			$cambios.=" c_psp:".trim($c_psp);
		}
		/*
			$cambio_cel=0;
			if($row['correo']!=$correo){
				$cambios.=" correo:".trim($correo);
				$cambio_cel=1;
			}

			if($row['celular']!=$celular){
				$cambios.=" celular:".trim($celular);
				$cambio_cel=1;
			}
		*/
		if(strlen($cambios)>1){
			$arreglo+=array('d_dom'=>trim($d_dom));
			$arreglo+=array('e_civ'=>trim($e_civ));
			$arreglo+=array('n_con'=>trim($n_con));
			$arreglo+=array('l_loc'=>trim($l_loc));
			$arreglo+=array('m_mun'=>trim($m_mun));
			$arreglo+=array('c_c_t'=>trim($c_c_t));
			$arreglo+=array('u_bic'=>trim($u_bic));
			$arreglo+=array('d_sin'=>trim($d_sin));
			$arreglo+=array('r_rrg'=>trim($r_rrg));
			$arreglo+=array('c_psp'=>trim($c_psp));

			$fecha=date("Y-m-d H:i:s");
			$arreglo+=array('fdatos_sol'=>$fecha);
			$arreglo+=array('up_datos'=>1);
			$arreglo+=array('tipo'=>"DATOS");
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
	public function cancela_datos(){
		$x="";
		$sql="select * from bit_datos where idfolio=:idfolio and up_datos=1";
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

	public function guardar_acceso(){			/////////////////////////////////////PARA CAMBIOS DE ACCESO
		$x="";
		$arreglo =array();
		$idfolio=clean_var($_REQUEST['id']);
		if(strlen($idfolio)==0){
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"Error de sesión, favor de verificar o reingresar");
			return json_encode($arr);
		}

		$sql="select * from afiliados where idfolio=:idfolio";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$idfolio);
		$sth->execute();
		$row=$sth->fetch();

		$cambios="";
		$correo=clean_var($_REQUEST['correo']);
		$celular=clean_var($_REQUEST['celular']);
		if($row['correo']!=$correo){
			$cambios.=" d_dom:".trim($correo);
		}
		if($row['celular']!=$celular){
			$cambios.=" e_civ:".trim($celular);
		}
		if(strlen($cambios)>1){

			$fecha=date("Y-m-d H:i:s");
			$arreglo =array();
			$arreglo+=array('tipo'=>"CORREO");
			$arreglo+=array('fcorreo_sol'=>$fecha);
			$arreglo+=array('up_correo'=>1);
			$arreglo+=array('correo'=>clean_var($_REQUEST['correo']));
			$arreglo+=array('celular'=>clean_var($_REQUEST['celular']));

			$arreglo+=array('idfolio'=>$row['idfolio']);
			$arreglo+=array('filiacion'=>$row['Filiacion']);
			$arreglo+=array('nombre'=>$row['nombre']);
			$arreglo+=array('ape_pat'=>$row['ape_pat']);
			$arreglo+=array('ape_mat'=>$row['ape_mat']);
			$x=$this->insert('bit_datos', $arreglo);

			return $x;
		}
		else{
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"No hay cambios");
			return json_encode($arr);
		}
	}
	public function cancela_acceso(){
		$x="";
		$sql="select * from bit_datos where idfolio=:idfolio and up_correo=1";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$_SESSION['idfolio']);
		$sth->execute();
		$row=$sth->fetch();
		$contar=$sth->rowCount();

		$x=$this->borrar('bit_datos','id',$row['id']);
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

	public function guardar_pass(){				/////////////////////////////////////PARA CAMBIOS DE CONTRASEÑA
		$x="";
		$arreglo =array();
		$idfolio=clean_var($_REQUEST['id']);
		if(strlen($idfolio)==0){
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"Error de sesión, favor de verificar o reingresar");
			return json_encode($arr);
		}

		$sql="select * from afiliados where idfolio=:idfolio";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$idfolio);
		$sth->execute();
		$row=$sth->fetch();

		if(trim($_REQUEST['pass1'])==trim($_REQUEST['pass2'])){
			$arreglo+=array('password'=>trim(clean_var($_REQUEST['pass1'])));

			$fecha=date("Y-m-d H:i:s");
			$arreglo+=array('tipo'=>"PASSWORD");
			$arreglo+=array('fpass_sol'=>$fecha);
			$arreglo+=array('up_pass'=>1);

			$arreglo+=array('idfolio'=>$idfolio);
			$arreglo+=array('filiacion'=>$row['Filiacion']);
			$arreglo+=array('nombre'=>$row['nombre']);
			$arreglo+=array('ape_pat'=>$row['ape_pat']);
			$arreglo+=array('ape_mat'=>$row['ape_mat']);
			$x=$this->insert('bit_datos', $arreglo);
			return $x;
		}
		else{
			$arr=array();
			$arr+=array('error'=>1);
			$arr+=array('terror'=>"No coinciden contraseñas");
			return json_encode($arr);
		}
	}
	public function cancela_pass(){
		$x="";
		$sql="select * from bit_datos where idfolio=:idfolio and up_pass=1";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":idfolio",$_SESSION['idfolio']);
		$sth->execute();
		$row=$sth->fetch();
		$contar=$sth->rowCount();

		$x=$this->borrar('bit_datos','id',$row['id']);
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
