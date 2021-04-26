<?php
	require_once("db_.php");

	$cita = $_REQUEST['id'];
	$resp=$db->cita_ver($cita);


		set_include_path('../librerias15/pdf2/src/'.PATH_SEPARATOR.get_include_path());
		include 'Cezpdf.php';

		$pdf = new Cezpdf('letter','portrait','color',array(255,255,255));
		$pdf->selectFont('Helvetica');

		// Set pdf Bleedbox

		//$pdf->ezSetMargins(20,20,20,20);
		// Use one of the pdf core fonts
		$mainFont = 'Times-Roman';
		// Select the font
		$pdf->selectFont($mainFont);
		// Define the font size
		$size=12;
		// Modified to use the local file if it can
		$pdf->openHere('Fit');
		$pdf->ezSetMargins(230,200,60,40);

		$pdf->addJpegFromFile("../img/logosnte2013.jpg",30,680,70);
		$pdf->addJpegFromFile("../img/cajax.jpg",510,690,50);

		$pdf->addText(310,760,14,"SINDICATO NACIONAL DE TRABAJADORES DE LA EDUCACION",0,'center');
		$pdf->addText(310,735,12,"TICKET PARA CITA",0,'center');
		$pdf->addText(310,720,12,"CAJA DE AHORRO Y CREDITOS",0,'center');
		$pdf->addText(50,660,16,"Ticket no:".$resp->id,590,'left');
		$pdf->addText(50,640,14,"Nombre: ".trim($resp->nombre)." ".trim($resp->ape_pat)." ".trim($resp->ape_mat),590,'left');
		$pdf->addText(50,620,16,"Filiación: ".$resp->Filiacion,590,'left');
		$pdf->addText(50,600,16,"Fecha y hora de la cita: ".$resp->fecha,590,'left');

		if ($resp->tipo==2){
			$pdf->addText(50,580,16,"Tipo de cita: CITA PARA SOLICITUD DE CREDITO",590,'left');
		}

		else {
			$pdf->addText(50,580,16,"Tipo de cita: CITA PARA RETIRO DE AHORRO",590,'left');

		}

		$pdf->addText(40,540,12,"*********** IMPORTANTE, NO OLVIDES TRAER LOS SIGUIENTES DOCUMENTOS **************",590,'left');

		if ($resp->tipo==2){
			$pdf->addText(40,500,12,"Último comprobante de pago a la fecha de su cita, Original y copia de identificación.",590,'left');
			$pdf->addText(40,480,12,"Favor de presentarse 5 min. antes de su cita.",590,'left');
		}
		else {
		$pdf->addText(40,500,12,"* Original INE o credencial del SNTE",590,'left');
		$pdf->addText(40,480,12,"* Traer el formato REQUISITADO de retiro y estado de cta. de retiro",590,'left');
		$pdf->addText(40,440,12,"* Recuerda que solo puedes realizar un movimiento por quincena y por periodo.",590,'left');
		}


		$pdf->ezStream(array('compress'=>0));

?>
