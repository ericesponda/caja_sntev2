<?php
require_once("../control_db.php");

class Escritorio extends SNTE{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}
	public function guardar_beneficiarios(){	/////////////////////////////////////PARA CAMBIOS DE beneficiarios
		$x="";
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
		$BA=clean_var($_REQUEST['ben1']);
		$PA=clean_var($_REQUEST['parentesco1']);
		$BFA=clean_var($_REQUEST['porcentaje1']);

		$BB=clean_var($_REQUEST['ben2']);
		$PB=clean_var($_REQUEST['parentesco2']);
		$BFB=clean_var($_REQUEST['porcentaje2']);

		$BC=clean_var($_REQUEST['ben3']);
		$PC=clean_var($_REQUEST['parentesco3']);
		$BFC=clean_var($_REQUEST['porcentaje3']);

		$BD=clean_var($_REQUEST['ben4']);
		$PD=clean_var($_REQUEST['parentesco4']);
		$BFD=clean_var($_REQUEST['porcentaje4']);

		$BE=clean_var($_REQUEST['ben5']);
		$PE=clean_var($_REQUEST['parentesco5']);
		$BFE=clean_var($_REQUEST['porcentaje5']);

		if($row['BA']!=$BA){
			$cambios.=" BA:".trim($BA);
		}
		if($row['PA']!=$PA){
			$cambios.=" PA:".trim($PA);
		}
		if($row['BFA']!=$BFA){
			$cambios.=" BFA:".trim($BFA);
		}

		if($row['BB']!=$BB){
			$cambios.=" BB:".trim($BB);
		}
		if($row['PB']!=$PB){
			$cambios.=" PB:".trim($PB);
		}
		if($row['BFB']!=$BFB){
			$cambios.=" BFB:".trim($BFB);
		}

		if($row['BC']!=$BC){
			$cambios.=" BC:".trim($BC);
		}
		if($row['PC']!=$PC){
			$cambios.=" PC:".trim($PC);
		}
		if($row['BFC']!=$BFC){
			$cambios.=" BFC:".trim($BFC);
		}

		if($row['BD']!=$BD){
			$cambios.=" BD:".trim($BD);
		}
		if($row['PD']!=$PD){
			$cambios.=" PD:".trim($PD);
		}
		if($row['BFD']!=$BFD){
			$cambios.=" BFD:".trim($BFD);
		}

		if($row['BE']!=$BE){
			$cambios.=" BE:".trim($BE);
		}
		if($row['PE']!=$PE){
			$cambios.=" PE:".trim($PE);
		}
		if($row['BFE']!=$BFE){
			$cambios.=" BFE:".trim($BFE);
		}

		if(strlen($cambios)>0){
			$arreglo =array();
			/////BEN1
			$arreglo+=array('BA'=>trim($BA));
			$arreglo+=array('PA'=>trim($PA));
			$arreglo+=array('BFA'=>trim($BFA));

			/////BEN 2
			$arreglo+=array('BB'=>trim($BB));
			$arreglo+=array('PB'=>trim($PB));
			$arreglo+=array('BFB'=>trim($BFB));

			/////BEN 3
			$arreglo+=array('BC'=>trim($BC));
			$arreglo+=array('PC'=>trim($PC));
			$arreglo+=array('BFC'=>trim($BFC));

			/////BEN 4
			$arreglo+=array('BD'=>trim($BD));
			$arreglo+=array('PD'=>trim($PD));
			$arreglo+=array('BFD'=>trim($BFD));

			/////BEN 5
			$arreglo+=array('BE'=>trim($BE));
			$arreglo+=array('PE'=>trim($PE));
			$arreglo+=array('BFE'=>trim($BFE));

			$fecha=date("Y-m-d H:i:s");
			$arreglo+=array('fbene_sol'=>$fecha);
			$arreglo+=array('up_bene'=>1);

			$arreglo+=array('idfolio'=>$row['idfolio']);
			$arreglo+=array('filiacion'=>$row['Filiacion']);
			$arreglo+=array('tipo'=>"BENEFICIARIOS");
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
	public function cancela_bene(){
		$x="";
		$arreglo =array();
		$arreglo+=array('up_bene'=>0);

		$sql="select * from bit_datos where idfolio=:idfolio and up_bene=1";
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
