<?php
require_once("../control_db.php");

class Escritorio extends SNTE{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}
	public function datos_ahorro($anio_tmp){
		try{

			$sql="select idfolio,anio,ahorrototal,saldofinal,saldo_anterior,monto,interes,montointeres,interestotal,
			if (retiro=1,'R',ROUND(quincena,0)) as quin_nombre,observaciones from registro where idfolio=:idfolio and anio=:anio_tmp
			order by anio,quincena,idregistro asc";
			$sth = $this->dbh->prepare($sql);

			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->bindValue(":anio_tmp",$anio_tmp);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function ahorro($anio_tmp){
		try{
			$sql="select sum(monto) as monto,sum(montointeres) as interesx from registro where idfolio=:idfolio and anio=:anio_tmp";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->bindValue(":anio_tmp",$anio_tmp);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function anio_ant_interes($anio_tmp){
		try{
			$ANIX=$anio_tmp-1;
			$sql="select SUM(montointeres) as interestotal from registro where idfolio=:idfolio and anio=:anio_tmp order by anio,quincena";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->bindValue(":anio_tmp",$ANIX);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function xahorro_anterior($anio_tmp){
		try{
			$sql="select * from registro where idfolio=:idfolio and anio<:anio_tmp order by anio desc,quincena desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->bindValue(":anio_tmp",$anio_tmp);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function ahorro_tmp($anio_tmp){
		try{
			$sql="select sum(monto) as monto from registro where idfolio=:idfolio and anio=:anio_tmp and monto>=0";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->bindValue(":anio_tmp",$anio_tmp);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function retiro_tmp($anio_tmp){
		try{
			$sql="select sum(monto) as montoxy from registro where idfolio=:idfolio and anio=:anio_tmp and registro.monto<0";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->bindValue(":anio_tmp",$anio_tmp);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function ahorro_anual($anio_tmp){
		try{
			$sql="select sum(monto) as ahorroanual from registro where idfolio=:idfolio and anio=:anio_tmp and registro.monto>0";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->bindValue(":anio_tmp",$anio_tmp);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function saldofinal($anio_tmp){
		try{
			$sql="select idfolio,anio,ahorrototal,saldofinal,saldo_anterior,monto,interes,montointeres,interestotal,if (retiro=1,'R',ROUND(quincena,0)) as quin_nombre,observaciones from registro where idfolio=:idfolio order by anio desc,quincena desc,idregistro desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
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
