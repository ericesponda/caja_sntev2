<?php
require_once("control_db.php");

class dashboard extends SNTE{
	public function __construct(){
		parent::__construct();
	}
	public function blo_lista(){
		$sql="select * from bit_bloques limit 1";
		return $this::general_($sql,1);
	}
	
}

$db = new dashboard();
