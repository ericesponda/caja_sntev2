<?php
	require_once("index.php");



	if(!isset($_REQUEST['clv_cred']) or strlen($_REQUEST['clv_cred'])==0){
		echo "Debe seleccionar un crédito";
		die();
	}

	$clv_cred = $_REQUEST['clv_cred'];

	$id=$_SESSION['idfolio'];

	$dat_credito=$db->datos_credito($clv_cred);
	$aportax=$db->aporta($clv_cred);
	$c_detalle=$db->credito_detalle($clv_cred);

	/////////////////////////////////////////////////
	$txt_estado=$dat_credito['cred_esta'];
	$txt_plazo=$dat_credito['plazo'];
	$txt_cheque=$dat_credito['nocheque'];

	$txt_monto=$dat_credito['monto'];
	$P_MONTO=$dat_credito['monto'];

	$txt_interes=$dat_credito['interes'];
	$P_INTERES=$dat_credito['interes'];

	$txt_total=$dat_credito['total'];
	$P_TOTAL=$dat_credito['total'];

	$txt_qini=$dat_credito['quin_ini']."/".$dat_credito['anio_ini'];
	$txt_qfin=$dat_credito['quin_fin']."/".$dat_credito['anio_fin'];

	$txt_credito=$dat_credito['clv_cred'];
	$txt_observaciones=$dat_credito['observa'];

	$txt_aportacion=$dat_credito['aportacion'];

	$txt_abono=$aportax['aporta'];
	$s_saldo=$dat_credito['total']-$aportax['aporta'];
	$txt_saldo=$s_saldo;

		echo "<div class='card mt-3'>";
			echo "<div class='card-body'>";
					echo "<button type='button' class='btn btn-warning btn-sm ml-1' id='imprimex' title='Imprimir'	xapp='print' title='Imprimir' xdes='creditos/imprimir' v_tipo='1' v_cred='$clv_cred'><i class='fas fa-print'></i><br><small>Imprimir</small></button>";
			echo "</div>";
		echo "</div>";

		echo "<div class='card mt-3'>";
			echo "<div class='card-body'>";
				echo "<input class='form-control' type='hidden' id='id' NAME='id' value='".$txt_credito."' placeholder='Crédito' readonly>";

				echo "<div class='row'>";
					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_credito'><b>Crédito</b></label>";
							echo "<input class='form-control' type='text' id='txt_credito' NAME='txt_credito' value='".$txt_credito."' placeholder='Crédito' readonly>";
						echo "</div>";
					echo "</div>";
					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_qini'><b>Q.Inicial</b></label>";
							echo "<input class='form-control' type='text' id='txt_qini' NAME='txt_qini' value='".$txt_qini."' placeholder='Q.Inicial' readonly>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_qfin'><b>Q.Final</b></label>";
							echo "<input class='form-control' type='text' id='txt_qfin' NAME='txt_qfin' value='".$txt_qfin."' placeholder='Q.Final' readonly>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_monto'><b>Monto Crédito</b></label>";
							echo "<input class='form-control moneda' type='text' id='txt_monto' NAME='txt_monto' value='".number_format($txt_monto,2)."' placeholder='Monto Crédito' readonly>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_interes'><b>Interés</b></label>";
							echo "<input class='form-control moneda' type='text' id='txt_interes' NAME='txt_interes' value='".number_format($txt_interes,2)."' placeholder='Interés' readonly>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_total'><b>Crédito total</b></label>";
							echo "<input class='form-control moneda' type='text' id='txt_total' NAME='txt_total' value='".number_format($txt_total,2)."' placeholder='Crédito total' readonly>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_abono'><b>Abono</b></label>";
							echo "<input class='form-control moneda' type='text' id='txt_abono' NAME='txt_abono' value='".number_format($txt_abono,2)."' placeholder='Abono' readonly>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_saldo'><b>Saldo</b></label>";
							echo "<input class='form-control moneda' type='text' id='txt_saldo' NAME='txt_saldo' value='".number_format($txt_saldo,2)."' placeholder='Saldo' readonly>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_plazo'><b>Plazo</b></label>";
							echo "<input class='form-control' type='text' id='txt_plazo' NAME='txt_plazo' value='".$txt_plazo."' placeholder='Plazo' readonly dir=rtl>";
						echo "</div>";
					echo "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<div class='form-group'>";
							echo "<label for='txt_estado' hidden><b>Estado</b></label>";
							echo "<input  type='hidden' class='form-control' type='text' id='txt_estado' NAME='txt_estado' value='".$txt_estado."' placeholder='Estado' readonly >";
						echo "</div>";
					echo "</div>";


				echo "</div>";

			echo "</div>";
		echo "</div>";

		echo "<div class='card mt-3'>";
			echo "<div class='card-body'>";

			echo "<div class='tabla_v mt-2' id='tabla_css'>";
				echo "<div class='header-row'>";
					echo "<div class='cell'>Año</div>";
					echo "<div class='cell'>Quincena</div>";
					echo "<div class='cell'>Monto</div>";
					echo "<div class='cell'>Saldo actual</div>";
				echo "</div>";

				foreach($c_detalle as $key){
					echo "<div class='body-row'>";
						echo "<div class='cell text-center' data-titulo='Año'>";
						echo $key['anio'];
						echo "</div>";

						echo "<div class='cell text-center' data-titulo='Quincena'>";
						echo $key['quin_nombre'];
						echo "</div>";

						echo "<div class='cell text-right' data-titulo='Monto'>$";
						echo number_format($key['monto'],2);
						echo "</div>";

						echo "<div class='cell text-right' data-titulo='Saldo'>$";
						echo number_format($key['saldo_actual'],2);
						echo "</div>";

					echo "</div>";
				}
				echo "</div>";
			echo "</div>";
		echo "</div>";
?>
