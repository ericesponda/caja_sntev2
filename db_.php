<?php
require_once("control_db.php");

class dashboard extends SNTE{
	public function __construct(){
		parent::__construct();
	}
}

$db = new dashboard();
