<?php
	require_once("db_.php");

  $alerta=$db->blog_alerta();
  echo "<div class='container' id='trabajo'>";
  foreach($alerta as $key){
    echo "<div class='alert alert-success'>";
    echo $key['corto'];
    echo "</div>";
  }

  $row=$db->afiliado();
  $idfolio=$row['idfolio'];
  $filiacion=$row['Filiacion'];
  $ape_pat=$row['ape_pat'];
  $ape_mat=$row['ape_mat'];
  $nombre=$row['nombre'];
  $a_qui=$row['a_qui'];

    echo "<div class='container' id='div_trabajo'>";
    	echo "<form id='form_comision' action='' data-lugar='aportacion/db_' data-funcion='guardar_aportacion' data-destino='aportacion/aportacion' data-div='div_trabajo'>";
      echo "<input class='form-control' type='hidden' id='id' NAME='id' value='$idfolio' placeholder='No. Empleado' readonly>";

      echo "<div class='card'>";
    		echo "<div class='card-header'>";
          echo "<img src='img/caja.png' width='20' alt='logo'> - ";
    			echo "Aportacion";
    		echo "</div>";

        echo "<div class='card-body'>";
          echo "<div class='row'>";
            echo "<div class='col-xl-2 col-lg-2 col-md-2 col-sm-3'>";
              echo "<div class='form-group'>";
                echo "<label for='idfolio'>Socio</label>";
                echo "<input class='form-control' type='text' id='idfolio' NAME='idfolio' value='".$row['idfolio']."' placeholder='No. Empleado' readonly>";
              echo "</div>";
            echo "</div>";

            echo "<div class='col-xl-3 col-lg-4 col-md-4 col-sm-4'>";
              echo "<div class='form-group'>";
                echo "<label for='Filiacion'>Filiación</label>";
                echo "<input class='form-control' type='text' id='Filiacion' NAME='Filiacion' value='$filiacion' placeholder='Filiacion' readonly>";
              echo "</div>";
            echo "</div>";

            echo "<div class='col-xl-2 col-lg-4 col-md-4 col-sm-4'>";
              echo "<div class='form-group'>";
                echo "<label for='ape_pat'>A. PATERNO</label>";
                echo "<input class='form-control' type='text' id='ape_pat' NAME='ape_pat' value='$ape_pat' placeholder='APELLIDO PATERNO' readonly>";
              echo "</div>";
            echo "</div>";

            echo "<div class='col-xl-2 col-lg-4 col-md-4 col-sm-4'>";
              echo "<div class='form-group'>";
                echo "<label for='ape_mat'>A. MATERNO</label>";
                echo "<input class='form-control' type='text' id='ape_mat' NAME='ape_mat' value='$ape_mat' placeholder='APELLIDO MATERNO' readonly>";
              echo "</div>";
            echo "</div>";

            echo "<div class='col-xl-3 col-lg-4 col-md-4 col-sm-4'>";
              echo "<div class='form-group'>";
                echo "<label for='nombre'>NOMBRE (S)</label>";
                echo "<input class='form-control' type='text' id='nombre' NAME='nombre' value='$nombre' placeholder='NOMBRE (S)' readonly>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
					echo "<hr>";
          echo "<div class='row'>";
            echo "<div class='col-4'>";
              echo "<div class='form-group'>";
                echo "<label>Aportación Total Para Ahorro:</label>";
                echo "<input class='form-control' type='text' id='a_qui' NAME='a_qui' value='".$a_qui."' placeholder='Aportacion Ahorro'>";
                echo "<small id='a_qui' class='form-text text-muted'>Por favor modifique o actualice la aportación TOTAL para su ahorro (Solo cuando este disponible dicho cambio)</small>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";

        $row=$db->blo_lista();
        $faportacion=fecha($row['faportacion']);
        $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
        $fecha_entrada = strtotime($faportacion);

    		echo "<div class='card-footer'>";
					$cambio=$db->cambios(4,$idfolio);
					if(!$cambio){
						if($fecha_actual <= $fecha_entrada ){
	            echo "<div class='btn-group'>";
	              echo "<button class='btn btn-warning btn-sm' type='submit'><i class='fas fa-sync'></i>Enviar cambios</button>";
	            echo "</div>";
	          }
	          else{
	    				echo "<b>Lo sentimos, por el momento no se pueden actualizar estos datos en Caja de Ahorro</b>";
	    			}
					}
          else{
    				echo "<b>Información pendiente por actualizar</b>";
    			}
    		echo "</div>";
      echo "</div>";
    	echo "</form>";

      if(is_array($cambio)){
        echo "<br><div class='card' id='datos_c'>";
          echo "<div class='card-header'>";
            echo "<i class='fas fa-exclamation'></i> Datos generales actuales pendientes por actualizar - en breve serán actualizados en las oficinas de caja de ahorro";
          echo "</div>";
          echo "<div class='card-body'>";
            echo "<div class='row'>";
              echo "<div class='col-4'>";
              echo "<label>Aportación Total Para Ahorro</label>";
              echo "<input class='form-control' type='text' id='a_qui1' NAME='a_qui1' value='" .number_format($cambio['a_qui'],2)."' placeholder='Aportacion Ahorro' readonly>";
              echo "</div>";
              ///////////////////////////////
            echo "</div>";
          echo "</div>";
          echo "<div class='card-footer'>";
            echo "<div class='row'>";
              echo "<div class='col-6'>";
                echo "<button class='btn btn-warning btn-sm' type='button' onclick='cancela_aporta()'><i class='fas fa-eraser'></i>Cancelar cambios</button>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      }
    echo "</div>";
?>

<script type="text/javascript">

  function cancela_aporta(){
    $.confirm({
      title: 'Cancelar',
      content: '¿Desea cancelar la actualización de información?',
      buttons: {
        Aceptar: function () {
          $.ajax({
            data:  {
              "function":"cancela_aporta"
            },
            url:  "aportacion/db_.php",
            type:  'post',
            success:  function (response) {
							$("#div_trabajo").load("aportacion/aportacion.php");
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
