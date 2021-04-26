<?php
require_once("../control_db.php");

class Escritorio extends Sagyc{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}

	public function afiliado(){
		try{

			$sql="select * from afiliados where idfolio=:idfolio";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function creditos(){
		try{

			$sql="select * from creditos where filiacion=:filiacion";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":filiacion",$_SESSION['filiacion']);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function datos_credito($clv_cred){
		try{

			$sql="SELECT clv_cred,crx.idfolio,fecha,crx.monto,observa,crx.estado,plazo,if(crx.estado=1,'ACTIVO','INACTIVO') as cred_esta,interes,crx.total,crx.quin_ini,crx.anio_ini,crx.quin_fin,crx.anio_fin,nocheque,aportacion,(select saldo_actual from detallepago where idcredito=crx.clv_cred order by anio desc,quincena desc,iddetalle limit 1) as saldo_actual FROM creditos crx where crx.clv_cred=:clv_cred";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":clv_cred",$clv_cred);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function credito_detalle($clv_cred){
		try{

			$sql="select anio,if (estado=1,'A',if(estado=6,'Inicial',if(estado=7,'Reim',ROUND(quincena,0)))) as quin_nombre,saldo_anterior,monto,saldo_actual, observaciones from detallepago where idcredito=:clv_cred order by anio,quincena,iddetalle";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":clv_cred",$clv_cred);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function aporta($clv_cred){
		try{

			$sql="select SUM(monto) as aporta from detallepago where idcredito=:clv_cred order by anio,quincena,iddetalle";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":clv_cred",$clv_cred);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}


}

$db = new Escritorio();
if(strlen($function)>0){
  echo $db->$function();
}


?>
