<?php
	require_once("index.php");

		$clv_cred = $_REQUEST['cred'];
		$id=$_SESSION['idfolio'];

		$row=$db->afiliado();

		$sql="SELECT clv_cred,crx.idfolio,fecha,crx.monto,observa,crx.estado,plazo,if(crx.estado=1,'ACTIVO','INACTIVO') as cred_esta,interes,crx.total,crx.quin_ini,crx.anio_ini,crx.quin_fin,crx.anio_fin,nocheque,aportacion,(select saldo_actual from detallepago where idcredito=crx.clv_cred order by anio desc,quincena desc,iddetalle limit 1) as saldo_actual FROM creditos	crx where crx.clv_cred='$clv_cred'";
		$dat_credito=$db->general_($sql,1);

		$sql="select SUM(monto) as aporta from detallepago where idcredito='$clv_cred' order by anio,quincena,iddetalle";
		$aportax=$db->general_($sql,1);

		$txt_saldo=$dat_credito->total-$aportax->aporta;

		include '../vendor/autoload.php';

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
		$pdf->addText(310,735,12,"REPORTE DE DESCUENTOS POR CREDITO",0,'center');
		$pdf->addText(310,720,12,"CAJA DE AHORRO Y CREDITOS",0,'center');

		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 658, 535, 13);
		$pdf->setColor(0,0,0);

		$pdf->addText(310,660,12,"DATOS DEL ASOCIADO",0,'center');
		$pdf->addText(460,660,12,date("d/m/Y"),100,'right');

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


		$pdf->addText(40,595,10,"PLAZO:",0,'left');
		$pdf->addText(100,595,10,$dat_credito->plazo,0,'left');
		$pdf->line(100,592,190,592);


		$pdf->addText(200,595,10,"QUIN. INI:",0,'left');
		$pdf->addText(250,595,10,$dat_credito->quin_ini."/".$dat_credito->anio_ini,0,'left');
		$pdf->line(250,592,380,592);


		$pdf->addText(400,595,10,"QUIN. FIN:",0,'left');
		$pdf->addText(460,595,10,$dat_credito->quin_fin."/".$dat_credito->anio_fin,0,'left');
		$pdf->line(460,592,570,592);

		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 563, 535, 13);
		$pdf->setColor(0,0,0);


		$pdf->addText(310,565,12,"DETALLE DE DESCUENTOS",0,'center');

		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 108, 535, 13);
		$pdf->setColor(0,0,0);
		$pdf->addText(310,110,12,"RESUMEN ESTADO DE CUENTA",0,'center');

		$pdf->addText(400,88,11,"PRESTAMO:",200,'left');
		$pdf->addText(400,88,11,"".number_format($dat_credito->monto,2)."",150,'right');

		$pdf->addText(400,76,11,"INTERES:",200,'left');
		$pdf->addText(400,76,11,"".number_format($dat_credito->interes,2)."",150,'right');

		$pdf->addText(400,64,11,"TOTAL:",200,'left');
		$pdf->addText(400,64,11,"".number_format($dat_credito->total,2)."",150,'right');

		$pdf->addText(400,52,11,"ABONO:",200,'left');
		$pdf->addText(400,52,11,"".number_format($aportax->aporta,2)."",150,'right');

		$pdf->addText(400,40,11,"SALDO:",200,'left');
		$pdf->addText(400,40,11,"".number_format($txt_saldo,2)."",150,'right');

		$pdf->setColor(0.9,0.9,0.9);
		$pdf->filledRectangle(40, 20, 535, 13);
		$pdf->setColor(0,0,0);



		$data=array();
		$cols = array('anio'=>'AÑO',
					'quin'=>'QUINCENA',
					'apor'=>'APORTACION'
					);

		$sql="select anio,if (estado=1,'A',if(estado=6,'Inicial',if(estado=7,'Reim',ROUND(quincena,0)))) as quin_nombre,saldo_anterior,monto,saldo_actual, observaciones from detallepago where idfolio='$id' and	idcredito='".$dat_credito->clv_cred."' order by anio,quincena,iddetalle";
		$resp=$db->general_($sql,2);

		$i=0;
		foreach($resp as $key){
			$data[$i]=array('anio'=>$key->anio,'quin'=>$key->quin_nombre,'apor'=>number_format($key->monto,2));
			$i++;
		}

		$pdf->ezTable($data,$cols,"",array('xPos'=>'left','rowGrap'=>55,
		'shadeHeadingCol'=>array(0.7,0.7,0.7),
		'xOrientation'=>'right','width'=>700,'shaded'=>0,'showHeadings'=>1,'gridlines'=>31,'innerLineThickness' => 0.5,'outerLineThickness' =>0.5,
		'cols'=>array(
		'anio'=>array('width'=>100,'justification'=>'center')
		,'quin'=>array('width'=>200,'justification'=>'center')
		,'apor'=>array('width'=>180,'justification'=>'right')
		),'fontSize' => 10));

		$pdf->ezStream(array('compress'=>0));
?>
