<?php
	require_once("db_.php");
	$resp=$db->creditos();

	$alerta=$db->blog_alerta();
	echo "<div class='container' id='trabajo'>";
	foreach($alerta as $key){
		echo "<div class='alert alert-success'>";
		echo $key['corto'];
		echo "</div>";
	}
?>
<div class='container'>
	<div class='card'>
		<?php

		echo "<div class='card-header'>";
			echo "<img src='img/caja.png' width='20' alt='logo'> - ";
			echo "Creditos";
		echo "</div>";
		echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo  "<div class='col-sm-3'>";
					echo "Seleccione un crédito:";
				echo "</div>";
				echo  "<div class='col-sm-9'>";
					echo "<select class='form-control form-control-sm' name='clv_cred' id='clv_cred' class='form-control' onchange='clv_cred()'>";
					echo "<option value='' disabled selected style='color: silver;'>Seleccione un credito</option>";
					foreach($resp as $key){
					echo  "<option value='".$key['clv_cred']."'>#".$key['clv_cred']." ".fecha($key['fecha'])." : $".number_format($key['monto'],2)."</option>";
					}
					echo  "</select>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div class='card-body'>";
			echo "<div class='btn-group'>";
				echo "<button class='btn btn-warning btn-sm' type='button' onclick='clv_cred()'><i class='fas fa-sync-alt'></i>Consultar</a>";
				echo "<button class='btn btn-warning btn-sm' id='imprime_comision' title='Imprimir' data-lugar='creditos/imprimir' data-tipo='1' type='button'><i class='fas fa-print'></i>Imprimir</button>";
			echo "</div>";
		echo "</div>";
		?>

		<div class='card-body' id='datos_cred'>
		</div>
	</div>
</div>
	<script type="text/javascript">

	function clv_cred(){
		var id=$("#clv_cred").val();
		if(id>0){
			var xyId = 0;
			 $.ajax({
					data:  {
						"clv_cred":id
					},
					url:  "creditos/datos.php",
					type:  'post',
				beforeSend: function () {
					$("#datos_cred").html("<div class='container' style='background-color:white; width:300px'><center><img src='img/carga1.gif' width='100px'></center></div>");
				},
				success:  function (response) {
					$("#datos_cred").html('');
					$("#datos_cred").html(response);
				}
			});
		}
		else{
			Swal.fire({
				type: 'error',
				title: "Seleccionar un crédito",
				showConfirmButton: false,
				timer: 1000
			})
		}
	}

	</script>
