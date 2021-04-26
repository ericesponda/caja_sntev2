<?php
	require_once("db_.php");

	$row=$db->afiliado();
	$idfolio=$row['idfolio'];
	$filiacion=$row['Filiacion'];
	$ape_pat=$row['ape_pat'];
	$ape_mat=$row['ape_mat'];
	$nombre=$row['nombre'];

	$tipo_cuenta=$row['tipo_cuenta'];
	$num_cuenta=$row['num_cuenta'];
	$clave_banco=$row['clave_banco'];

	echo "<div class='container' id='div_trabajo'>";
	echo "<form id='form_comision' action='' data-lugar='bancos/db_' data-funcion='guardar_bancos' data-destino='bancos/datos' data-div='div_trabajo'>";
	  echo "<input class='form-control form-control-sm' type='hidden' id='id' NAME='id' value='$idfolio' readonly>";
  echo "<div class='card'>";
		echo "<div class='card-header'>";
			echo "<img src='img/caja.png' width='20' alt='logo'> - ";
			echo "Datos generales actuales";
		echo "</div>";
    echo "<div class='card-body'>";
      echo "<div class='row'>";
        echo "<div class='col-xl-2 col-lg-2 col-md-2 col-sm-3'>";
          echo "<div class='form-group'>";
            echo "<label for='idfolio'>Socio</label>";
            echo "<input class='form-control form-control-sm' type='text' id='idfolio' NAME='idfolio' value='".$row['idfolio']."' placeholder='No. Empleado' readonly>";
          echo "</div>";
        echo "</div>";

        echo "<div class='col-xl-3 col-lg-4 col-md-4 col-sm-4'>";
          echo "<div class='form-group'>";
            echo "<label for='Filiacion'>Filiación</label>";
            echo "<input class='form-control form-control-sm' type='text' id='Filiacion' NAME='Filiacion' value='$filiacion' placeholder='Filiacion' readonly>";
          echo "</div>";
        echo "</div>";

        echo "<div class='col-xl-2 col-lg-4 col-md-4 col-sm-4'>";
          echo "<div class='form-group'>";
            echo "<label for='ape_pat'>A. PATERNO</label>";
            echo "<input class='form-control form-control-sm' type='text' id='ape_pat' NAME='ape_pat' value='$ape_pat' placeholder='APELLIDO PATERNO' readonly>";
          echo "</div>";
        echo "</div>";

        echo "<div class='col-xl-2 col-lg-4 col-md-4 col-sm-4'>";
          echo "<div class='form-group'>";
            echo "<label for='ape_mat'>A. MATERNO</label>";
            echo "<input class='form-control form-control-sm' type='text' id='ape_mat' NAME='ape_mat' value='$ape_mat' placeholder='APELLIDO MATERNO' readonly>";
          echo "</div>";
        echo "</div>";

        echo "<div class='col-xl-3 col-lg-4 col-md-4 col-sm-4'>";
          echo "<div class='form-group'>";
            echo "<label for='nombre'>NOMBRE (S)</label>";
            echo "<input class='form-control form-control-sm' type='text' id='nombre' NAME='nombre' value='$nombre' placeholder='NOMBRE (S)' readonly>";
          echo "</div>";
        echo "</div>";
			echo "</div>";

			echo "<hr>";
			echo "<div class='row'>";
				echo "<div class='col-4'>";
					echo "<div class='form-group'>";
						echo "<label for='e_civ'>Banco</label>";
						echo "<select class='form-control form-control-sm' name='tipo_cuenta' id='tipo_cuenta'>";
							echo  "<option value='SANTAN'"; if ($tipo_cuenta=='SANTAN'){echo  " selected";} echo  "> SANTANDER</option>";
							$res=$db->catalogo();
							foreach($res as $key){
								echo  "<option value='".$key->clave."' ";
									if ($clave_banco==$key->clave){ echo  " selected";}
								echo  ">".$key->nombre."</option>";
							}
						echo  "</select>";
					echo "</div>";
				echo "</div>";

				echo "<div class='col-4'>";
					echo "<div class='form-group'>";
						echo "<label for='n_con'>No. de cuenta (11 digitos para Santander)</label>";
						echo "<input class='form-control form-control-sm' type='text' id='num_cuenta' NAME='num_cuenta' value='$num_cuenta' placeholder='Número de cuenta' maxlength=20 required>";
						echo "<small id='a_qui' class='form-text text-muted'><b>Si tu banco NO ES SANTANDER, favor de poner la cuenta CLABE de 18 digitos</b></small>";
					echo "</div>";
				echo "</div>";

				echo "<div class='col-4'>";
					echo "<div class='form-group'>";
						echo "<label for='n_con'>Confirmar cuenta</label>";
						echo "<input class='form-control form-control-sm' type='text' id='num_cuenta2' NAME='num_cuenta2' value='' placeholder='Número de cuenta' maxlength=20 required>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
  echo "</div>";

		$cambio=$db->cambios(6,$idfolio);

		echo "<div class='card-footer'>";
			if(!$cambio){
				//if($fecha_actual <= $fecha_entrada){
					echo "<div class='btn-group'>";
						echo "<button class='btn btn-warning btn-sm' type='submit'><i class='fas fa-sync'></i>Enviar cambios</button>";
					echo "</div>";
				//}
				//else{
					//echo "<b>Lo sentimos, por el momento no se pueden actualizar estos datos en Caja de Ahorro</b>";
				//}
			}
			else{
				echo "<b>Información pendiente por actualizar</b>";
			}
		echo "</div>";
  echo "</div>";
	echo "</form>";
	echo "<br>";
	echo "<div class='container'>";
	echo "<div class='card'>";
		echo "<div class='card-header'>";
			echo"Cuando ingreses tu información de la cuenta, esta puede tardar hasta <b>24 horas</b> en actualizarse en las oficinas de caja de ahorro, por favor se paciente.";
		echo "</div>";
	echo "</div>";
	echo "</div>";

	if ($cambio){
	echo "<br>";
		echo "<div class='card' id='datos_c'>";
			echo "<div class='card-header'>";
				echo "<i class='fas fa-exclamation'></i> Datos generales actuales pendientes por actualizar - en breve serán actualizados en las oficinas de caja de ahorro";
			echo "</div>";
			echo "<div class='card-body'>";
				echo "<div class='row'>";
					echo "<div class='col-4'>";
						echo "<div class='form-group'>";
							echo "<label for='e_civ'>Banco</label>";
							echo "<input class='form-control form-control-sm' type='text' id='tipo_cuenta' NAME='tipo_cuenta' value='";
								if ($cambio['tipo_cuenta']=='SANTAN'){echo  "SANTANDER"; } else{
									echo $cambio['banco'];
								}
							echo "' placeholder='Número de cuenta' maxlength=20 readonly>";
						echo "</div>";
					echo "</div>";

					echo "<div class='col-4'>";
						echo "<div class='form-group'>";
							echo "<label for='n_con'>Número de cuenta</label>";
							echo "<input class='form-control form-control-sm' type='text' id='num_cuenta' NAME='num_cuenta' value='".$cambio['num_cuenta']."' placeholder='Número de cuenta' maxlength=20 readonly>";
						echo "</div>";
					echo "</div>";
				echo "</div>";

			echo "</div>";
				//////////////////////////////
			echo "<div class='card-footer'>";
				echo "<div class='row'>";
					echo "<div class='col-6'>";
						echo "<button class='btn btn-warning btn-sm' type='button' onclick='cancela_bancos()'><i class='fas fa-eraser'></i>Cancelar cambios</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

		echo "</div>";
	}

	echo "</div>";
echo "</div>";

?>

<script type="text/javascript">
	function cancela_bancos(){
		$.confirm({
			title: 'Cancelar',
			content: '¿Desea cancelar la actualización de información?',
			buttons: {
				Aceptar: function () {
					$.ajax({
	 					data:  {
							"function":"cancela_datos"
	 					},
	 					url:  "bancos/db_.php",
	 					type:  'post',
		 				success:  function (response) {
							console.log(response);
							$("#div_trabajo").load("bancos/datos.php");
							var datos = JSON.parse(response);
							if (datos.error==0){
								$("#datos_c").remove();
								Swal.fire({
									type: 'success',
									title: "Se canceló correctamente",
									showConfirmButton: false,
									timer: 1000
								});
							}
							else{
								Swal.fire({
									type: 'error',
									title: "Error favor de verificar",
									showConfirmButton: false,
									timer: 2000
								});
							}
		 				}
	 				});
				},
				Regresar: function () {

				}
			}
		});
	}

</script>
