<?php
	require_once("index.php");
	$resp=$db->creditos();

	$alerta=$db->blog_alerta();
	echo "<div class='container' id='trabajo'>";
	foreach($alerta as $key){
		echo "<div class='alert alert-success'>";
		echo $key['corto'];
		echo "</div>";
	}

echo "<div class='container'>";
	echo "<form xform='form' id='varx' xdes='creditos/datos' xdiv='datos_cred'>";
		echo "<div class='card mt-3'>";
			echo "<div class='card-body'>";
				echo "<img src='img/caja.png' width='20' alt='logo'> - ";
				echo "Creditos";
			echo "</div>";
		echo "</div>";

		echo "<div class='card mt-3'>";
			echo "<div class='card-body'>";
				echo "<div class='row'>";
					echo  "<div class='col-sm-3'>";
						echo "Seleccione un crédito:";
					echo "</div>";
					echo  "<div class='col-sm-7'>";
						echo "<select class='form-control form-select' name='clv_cred' id='clv_cred' class='form-control' xchange='all'>";
						echo "<option value='' disabled selected style='color: silver;'>Seleccione un credito</option>";
						foreach($resp as $key){
						echo  "<option value='".$key['clv_cred']."'>#".$key['clv_cred']." ".fecha($key['fecha'])." : $".number_format($key['monto'],2)."</option>";
						}
						echo  "</select>";
					echo "</div>";
					echo  "<div class='col-sm-2'>";
							echo "<button class='btn btn-warning btn-sm ml-1' type='submit' ><i class='fas fa-sync-alt'></i><br><small>Consultar</small></a>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</form>";

		?>
	<div id='datos_cred'>
	</div>

</div>
