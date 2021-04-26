<?php
	require_once("db_.php");

	$periodo = $_REQUEST['id'];
	$id=$_SESSION['idfolio'];
	$anio_tmp=date("Y");

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

		$all = $pdf->openObject();
		$pdf->saveState();

		$pdf->addJpegFromFile("../img/logosnte2013.jpg",30,680,70);
		$pdf->addJpegFromFile("../img/cajax.jpg",510,690,50);

		$pdf->addText(310,760,14,"SINDICATO NACIONAL DE TRABAJADORES DE LA EDUCACION",0,'center');
		$pdf->addText(310,735,12,"REPORTE DE APORTACIONES POR SOCIO",0,'center');
		$pdf->addText(310,720,12,"CAJA DE AHORRO Y CRÉDITOS",0,'center');

		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 658, 535, 13);
		$pdf->setColor(0,0,0);

		$pdf->addText(310,660,12,"DATOS DEL ASOCIADO",0,'center');
		$pdf->addText(460,660,12,date("d/m/Y"),100,'right');


		$row=$db->afiliado();
		$pdf->addText(40,640,10,"SOCIO:",0,'left');
		$pdf->addText(100,640,10,trim($row['nombre'])." ".trim($row['ape_pat'])." ".trim($row['ape_mat']));
		$pdf->line(100,637,570,637);

		$pdf->addText(40,625,10,"R.F.C.: ",0,'left');
		$pdf->addText(100,625,10,$row['Filiacion'],0,'left');
		$pdf->line(100,623,570,623);

		$pdf->addText(40,610,10,"NO. SOCIO:",0,'left');
		$pdf->addText(100,610,10,$row['idfolio'],0,'left');
		$pdf->line(100,607,230,607);

		$pdf->addText(250,610,10,"CLAVE PRES:",0,'left');
		$pdf->addText(330,610,10,$row['c_psp'],0,'left');
		$pdf->line(330,607,570,607);

		$pdf->addText(40,595,10,"APORTACION:",0,'left');
		$pdf->addText(100,595,10,number_format($row['a_qui']),70,'right');
		$pdf->line(100,592,190,592);

		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 563, 535, 13);
		$pdf->setColor(0,0,0);

		$pdf->addText(310,565,12,"DETALLE DE APORTACIONES",0,'center');

		$pdf->ezStartPageNumbers($pdf->ez['pageWidth']/2, $pdf->ez['bottomMargin']-178,12, 'PAGINA', '{PAGENUM} de {TOTALPAGENUM}',1);

		$pdf->restoreState();
		$pdf->closeObject();
		$pdf->addObject($all,'all');


		$pdf->ezSetMargins(230,200,60,40);
		$pdf->openHere('Fit');
		$pdf->selectFont('Helvetica');

	///////////////////////////////////////////////////////////////////////////

		$cols = array('anio'=>'AÑO',
					'quin'=>'QUINCENA',
					'ret'=>'RETIRO',
					'apor'=>'APORTACION'
					);
		$i=0;

		while($periodo<=$anio_tmp){

			$data=array();
			$i=0;
			$sql="select idfolio,anio,ahorrototal,saldofinal,saldo_anterior,monto,interes,montointeres,interestotal,
			if (retiro=1,'R',ROUND(quincena,0)) as quin_nombre,observaciones from registro where idfolio='$id' and '$periodo'=anio
			order by anio,quincena,idregistro asc";
			$resp=$db->general($sql,1);

			$monto=0;
			$anio=0;
			$ahorrop=0;
			$int_ant=0;
			$s_final=0;

			foreach($resp as $key){
				if($anio!=$key['anio']){
					$anio=$key['anio'];
					$monto=0;
				}
				$int_ant=$int_ant+$key['montointeres'];
				$s_final=$key['saldofinal'] - $int_ant;


				$totala="";
				$totalr="";
				$entra=0;
				if ($key['monto']>0){
					$totala=number_format($key['monto'],2);
					$entra=1;
					$ahorrop+=$key['monto'];
				}
				else if($key['monto']<0){
					$monto=$key['saldofinal']-$monto;
					$ahorrop=$monto;
					$totalr=number_format($key['monto'],2);
					$totala=number_format($s_final,2)."<-Saldo despues del retiro";
					$entra=1;
				}


				if($entra==1){
					$data[$i]=array('anio'=>$key['anio'],'quin'=>$key['quin_nombre'],'ret'=>$totalr,'apor'=>$totala);
					$i++;
				}
			}

			$pdf->ezTable($data,$cols,"",array('xPos'=>'left','rowGrap'=>55,'shadeHeadingCol'=>array(0.7,0.7,0.7),'xOrientation'=>'right','width'=>700,'shaded'=>0,'showHeadings'=>1,'gridlines'=>31,'innerLineThickness' => 0.5,'outerLineThickness' =>0.5,'cols'=>array(
			'anio'=>array('width'=>70,'justification'=>'center')
			,'quin'=>array('width'=>70,'justification'=>'center')
			,'ret'=>array('width'=>150,'justification'=>'right')
			,'apor'=>array('width'=>190,'justification'=>'right')
			),'fontSize' => 8));

			$periodo++;
			if($periodo<=$anio_tmp){
				$pdf->ezNewPage();
			}
		}

		//$pdf->addText(48,140,10,"Ahorro total ciclo (año anterior actual) despues de retiros: ".number_format($ahorrop),0,'left');
		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 108, 535, 13);
		$pdf->setColor(0,0,0);
		$pdf->addText(310,110,12,"RESUMEN ESTADO DE CUENTA",0,'center');

		/////////////////////////////////////////////////////

			/////////INTERES AÑO Anterior
			$ANIX=$anio_tmp-1;
			$sql="select SUM(montointeres) as interestotal from registro where idfolio='$id' and anio='$ANIX' order by anio,quincena";
			$anio_ant_interes=$db->general($sql,2);
			$interes_anio_ant=number_format($anio_ant_interes['interestotal'],2);

			//////////////////////////Ahorro anterior
			$P_INTERESANTERIOR=$anio_ant_interes['interestotal'];
			$sql="select * from registro where idfolio='$id' and anio<$anio_tmp order by anio desc,quincena desc";
			$anio_ant=$db->general($sql,2);
			$xahorro_anterior=number_format($anio_ant['saldofinal']-$P_INTERESANTERIOR,2);


			/////////////saldo año anterior
			$saldo_anterior=number_format($anio_ant['saldofinal'],2);

			//////Ahorro actual
			$sql="select sum(monto) as monto from registro where idfolio='$id' and anio='$anio_tmp' and monto>=0";
			$ahorro_tmp=$db->general($sql,2);
			$actual=number_format($ahorro_tmp['monto'],2);


			////retiro actual
			$sql="select sum(monto) as montoxy from registro where idfolio='$id' and anio='$anio_tmp' and registro.monto<0";
			$retiro_tmp=$db->general($sql,2);
			$r_actual=number_format($retiro_tmp['montoxy'],2);

			///////////AHORRO TOTAL
			$sql="select sum(monto) as ahorroanual from registro where idfolio='$id' and anio='$anio_tmp' and registro.monto>0";
			$ahorro_anual=$db->general($sql,2);
			$ahorro_total=number_format($ahorro_anual['ahorroanual'],2);

			//////////////DISPONIBLE
			$sql="select sum(monto) as monto,sum(montointeres) as interesx from registro where idfolio='$id' and anio='$anio_tmp'";
			$ahorro=$db->general($sql,2);
			$ahorronum=count($ahorro);


			$sql="select idfolio,anio,ahorrototal,saldofinal,saldo_anterior,monto,interes,montointeres,interestotal,if (retiro=1,'R',ROUND(quincena,0)) as quin_nombre,observaciones from registro where idfolio='$id' order by anio desc,quincena desc,idregistro desc";
			$saldofinal=$db->general($sql,2);

			if ($ahorronum==0){
				$val=$saldofinal['saldofinal'];
			}
			else{
				$val=$saldofinal['saldofinal']-$ahorro['interesx'];
			}
			$disponible=$val;


			////////interes
			$interes=number_format($ahorro['interesx'],2);
		/////////////////////////////////////////////////////

		$sfinal=$disponible-500;


		$pdf->addText(48,130,10,"Retiro maximo: ".number_format($sfinal,2),0,'left');

		$pdf->addText(290,88,11,"AHORRO CICLO ANTERIOR:",200,'left');
		$pdf->addText(400,88,11,"$xahorro_anterior",150,'right');


		$pdf->addText(290,76,11,"INTERES CICLO ANTERIOR:",200,'left');
		$pdf->addText(400,76,11,"$interes_anio_ant",150,'right');

		$pdf->addText(290,64,11,"APORTACION TOTAL DEL CICLO ACTUAL:",200,'left');
		$pdf->addText(400,64,11,"$actual",150,'right');

		$sql="select sum(monto) as montoxy from registro where idfolio='$id' and anio='$anio_tmp' and registro.monto<0";
		$retiro_tmp=$db->general($sql,2);
		$pdf->addText(290,52,11,"RETIRO TOTAL DEL CICLO ACTUAL:",200,'left');
		$pdf->addText(400,52,11,"$r_actual",150,'right');


		$pdf->addText(290,40,11,"SALDO:",200,'left');
		$pdf->addText(400,40,11,"".number_format($disponible,2)."",150,'right');

		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 20, 535, 13);
		$pdf->setColor(0,0,0);


		$pdf->ezStream(array('compress'=>0));
?>
