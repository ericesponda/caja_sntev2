<?php
require_once("../control_db.php");

class Escritorio extends SNTE{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}
	public function blog_alerta(){
			$sql="select * from bit_blog where alerta=1";
			return $this::general_($sql,2);
	}
	public function blog_noticia(){
			$sql="select * from bit_blog where noticia=1";
			return $this::general_($sql,2);
	}
	
}

$db = new Escritorio();
if(strlen($function)>0){
  echo $db->$function();
}


?>
