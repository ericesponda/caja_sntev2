<?php
	require_once("db_.php");
	$citas=$db->citas_bloqueocred();
	$arreglo=array();
	$i=0;
	foreach($citas as $key){
		$fecha=explode("-",$key['fecha']);
		if($key['recurrente']==1){
			$date=date("Y")."-".$fecha[1]."-".$fecha[2];
		}
		else{
			$date=$key['fecha'];
		}
		$arreglo[$i]=array(
			'dia'=>$date
		);
		$i++;
	}
	echo json_encode($arreglo);
?>
