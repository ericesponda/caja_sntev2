<?php
	require_once("index.php");
	$anio_tmp=date("Y");

	$alerta=$db->blog_alerta();
	echo "<div class='container' id='trabajo'>";
	foreach($alerta as $key){
		echo "<div class='alert alert-success'>";
		echo $key['corto'];
		echo "</div>";
	}

	$resp=$db->datos_ahorro($anio_tmp);
	$ahorro=$db->ahorro($anio_tmp);
	$ahorronum=count($db->ahorro($anio_tmp));

	echo "<div class='container'>";
		echo "<div class='card mt-3'>";
			echo "<div class='card-body'>";
				echo "<img src='img/caja.png' width='20' alt='logo'> - ";
				echo "Caja de ahorro";
			echo "</div>";
		echo "</div>";

		echo "<div class='card mt-3'>";
			echo "<div class='card-body'>";
				echo "<div class='row'>";
					/////////INTERES AÑO Anterior
					$anio_ant_interes=$db->anio_ant_interes($anio_tmp);

					$P_INTERESANTERIOR=$anio_ant_interes['interestotal'];
					$xahorro_anterior=$db->xahorro_anterior($anio_tmp);
					$xahorro_anterior=$xahorro_anterior['saldofinal']-$P_INTERESANTERIOR;

					///////////////////
					$ahorro_tmp=$db->ahorro_tmp($anio_tmp);
					$retiro_tmp=$db->retiro_tmp($anio_tmp);
					$ahorro_anual=$db->ahorro_anual($anio_tmp);
					$saldofinal=$db->saldofinal($anio_tmp);

					if ($ahorronum==0){
						$val=number_format($saldofinal['saldofinal'],2);
					}
					else{
						$val=number_format($saldofinal['saldofinal']-$ahorro['interesx'],2);
					}
					//////////////DISPONIBLE
					echo  "<div class='col-sm-3'>";
						echo "<div class='form-group'>";
							echo "<label for='idfolio'>Disponible anual</label>";
							echo "<input class='form-control text-right' type='text' id='idfolio' NAME='idfolio' value='$ ".$val."' placeholder='Disponible anual' readonly>";
						echo "</div>";
					echo "</div>";

					////////interes
					echo  "<div class='col-sm-3'>";
						echo "<div class='form-group'>";
							echo "<label for='idfolio'>Interes anual</label>";
							echo "<input class='form-control text-right' type='text' id='idfolio' NAME='idfolio' value='$ ".number_format($ahorro['interesx'],2)."' placeholder='Interes anual' readonly>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

			echo "<div class='card-footer'>";
				echo "<div class='row'>";

					echo "<div class='col-sm-2'>";
					echo "<label for='idfolio'>Periodo:</label>";
					echo "</div>";
					echo "<div class='col-sm-2'>";
					echo "<select class='form-control form-select' name='periodo' id='periodo' class='form-control'>";
					echo "<option value='' disabled selected style='color: silver;'>Seleccione un periodo</option>";
						$contar=date("Y")-1;
						while ($contar<=date("Y")){
							echo  "<option value='$contar' selected>$contar</option>";
							$contar++;
						}
					echo  "</select>";
					echo "</div>";
					echo "<div class='col-sm-2'>";
						echo "<button type='button' class='btn btn-warning btn-sm' id='imprime' xapp='printcmb' title='Imprimir' xdes='ahorro/imprimir' v_tipo='1' xcmb='periodo' ><i class='fas fa-print'></i>Imprimir</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<br>";
		echo "<div class='card'>
		  <div class='card-header'>Registro</div>";

				echo "<table class='table table-striped table-sm'>";
				echo "<tr>";
				echo "<th><center>Año</center></th>";
				echo "<th><center>Quincena</center></th>";
				echo "<th><center>Saldo</center></th>";
				echo "<th><center>Monto</center></th>";
				echo "</tr>";
				echo "</thead><tbody>";
				$anio=0;
				$monto=0;
				$int_ant=0;
				foreach($resp as $key){
					if($anio!=$key['anio']){
						$anio=$key['anio'];
						$int_ant=0;
					}
					$int_ant=$int_ant+$key['montointeres'];
					$s_final=$key['saldofinal'] - $int_ant;

					echo "<tr>";
						echo "<td><center>";
						echo $key['anio'];
						echo "</center></td>";

						echo "<td><center>";
						echo $key['quin_nombre'];
						echo "</center></td>";

						if ($key['monto']>0){
							echo "<td>";
							echo "</left></td>";
							echo "<td style='text-align: center;'>";
							echo number_format($key['monto'],2);
							echo "</td>";
						}
						else{
							echo "<td style='text-align: right;'>";
							echo $s_final;
							echo "</td>";
						}

					echo "</tr>";
				}

				echo "</table>";
		echo "</div>";
echo "</div>";

?>
