<?php
	 require_once("index.php");
    $row=$db->afiliado();
    echo "<div class='container' id='trabajo'>";
    $idfolio=$row->idfolio;
    $filiacion=$row->Filiacion;
    $ape_pat=$row->ape_pat;
    $ape_mat=$row->ape_mat;
    $nombre=$row->nombre;

    $ben1=$row->BA;
    $parentesco1=$row->PA;
    $porcentaje1=$row->BFA;

    $ben2=$row->BB;
    $parentesco2=$row->PB;
    $porcentaje2=$row->BFB;

    $ben3=$row->BC;
    $parentesco3=$row->PC;
    $porcentaje3=$row->BFC;

    $ben4=$row->BD;
    $parentesco4=$row->PD;
    $porcentaje4=$row->BFD;

    $ben5=$row->BE;
    $parentesco5=$row->PE;
    $porcentaje5=$row->BFE;

    echo "<div class='container' id='div_trabajo'>";

      echo "<form id='form_benef' action='' data-lugar='beneficiarios/db_' data-funcion='guardar_beneficiarios' data-destino='beneficiarios/beneficiarios' data-div='div_trabajo'>";
      echo "<input class='form-control' type='hidden' id='id' NAME='id' value='$idfolio'  >";
      echo "<div class='card mt-3'>";
    		echo "<div class='card-header'>";
          echo "<img src='img/caja.png' width='20' alt='logo'> - ";
    			echo "Beneficiarios";
    		echo "</div>";
      echo "</div>";


      echo "<div class='card mt-3'>";
        echo "<div class='card-body'>";
          echo "<div class='row'>";
            echo "<div class='col-xl-2 col-lg-2 col-md-2 col-sm-3'>";
              echo "<div class='form-group'>";
                echo "<label for='idfolio'>Socio</label>";
                echo "<input class='form-control' type='text' id='idfolio' NAME='idfolio' value='".$row->idfolio."' placeholder='No. Empleado' readonly>";
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
          //////////bloque beneficiario 1
          echo "<div class='row'>";
            echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
              echo "<div class='form-group'>";
                echo "<label for='ben1'>Beneficiario 1</label>";
                echo "<input class='form-control' type='text' id='ben1' NAME='ben1' value='$ben1'  >";
              echo "</div>";
            echo "</div>";

            echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
              echo "<div class='form-group'>";
                echo "<label for='parentesco1'>Parentesco</label>";
                echo "<input class='form-control' type='text' id='parentesco1' NAME='parentesco1' value='$parentesco1' maxlength='25' >";
              echo "</div>";
            echo "</div>";

            echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
              echo "<div class='form-group'>";
                echo "<label for='porcentaje1'>Porcentaje</label>";
                echo "<input class='form-control' type='text' id='porcentaje1' NAME='porcentaje1' value='$porcentaje1'  >";
              echo "</div>";
            echo "</div>";
    			echo "</div>";

        //////////bloque beneficiario 2
        echo "<div class='row'>";
          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='ben2'>Beneficiario 2</label>";
              echo "<input class='form-control' type='text' id='ben2' NAME='ben2' value='$ben2'  >";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='parentesco2'>Parentesco</label>";
              echo "<input class='form-control' type='text' id='parentesco2' NAME='parentesco2' value='$parentesco2'  maxlength='25'>";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='porcentaje2'>Porcentaje</label>";
              echo "<input class='form-control' type='text' id='porcentaje2' NAME='porcentaje2' value='$porcentaje2'  >";
            echo "</div>";
          echo "</div>";
        echo "</div>";

        //////////bloque beneficiario 3
        echo "<div class='row'>";
          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='ben3'>Beneficiario 3</label>";
              echo "<input class='form-control' type='text' id='ben3' NAME='ben3' value='$ben3'  >";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='parentesco3'>Parentesco</label>";
              echo "<input class='form-control' type='text' id='parentesco3' NAME='parentesco3' value='$parentesco3' maxlength='25' >";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='porcentaje3'>Porcentaje</label>";
              echo "<input class='form-control' type='text' id='porcentaje3' NAME='porcentaje3' value='$porcentaje3'  >";
            echo "</div>";
          echo "</div>";
        echo "</div>";

        /////////bloque beneficiario 4
        echo "<div class='row'>";
          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='ben4'>Beneficiario 4</label>";
              echo "<input class='form-control' type='text' id='ben4' NAME='ben4' value='$ben4'  >";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='parentesco4'>Parentesco</label>";
              echo "<input class='form-control' type='text' id='parentesco4' NAME='parentesco4' value='$parentesco4' maxlength='25' >";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='porcentaje4'>Porcentaje</label>";
              echo "<input class='form-control' type='text' id='porcentaje4' NAME='porcentaje4' value='$porcentaje4'  >";
            echo "</div>";
          echo "</div>";
        echo "</div>";


        //////////bloque beneficiario 4
        echo "<div class='row'>";
          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='ben5'>Beneficiario 5</label>";
              echo "<input class='form-control' type='text' id='ben5' NAME='ben5' value='$ben5'  >";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='parentesco5'>Parentesco</label>";
              echo "<input class='form-control' type='text' id='parentesco5' NAME='parentesco5' value='$parentesco5'  >";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-3'>";
            echo "<div class='form-group'>";
              echo "<label for='porcentaje5'>Porcentaje</label>";
              echo "<input class='form-control' type='text' id='porcentaje5' NAME='porcentaje5' value='$porcentaje5'  >";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";

      $row=$db->blo_lista();
      $fbeneficiarios=fecha($row->fbeneficiarios);
      $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
      $fecha_entrada = strtotime($fbeneficiarios);

        echo "<div class='card-footer'>";
					$cambio=$db->cambios(5,$idfolio);
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
						echo "<b>Información pendiente por actualizar/b>";
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
                echo "<label>Beneficiario 1</label>";
                echo "<input class='form-control' type='text' id='ben1_1' NAME='ben1_1' value='".$cambio['BA']."' ' readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label >Parentesco 1</label>";
                echo "<input class='form-control' type='text' id='parentesco1_1' NAME='parentesco1_1' value='".$cambio['PA']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Porcentaje 1</label>";
                echo "<input class='form-control' type='text' id='porcentaje1_1' NAME='porcentaje1_1' value='".$cambio['BFA']."' readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Beneficiario 2</label>";
                echo "<input class='form-control' type='text' id='ben1_2' NAME='ben1_1' value='".$cambio['BB']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label >Parentesco 2</label>";
                echo "<input class='form-control' type='text' id='parentesco1_2' NAME='parentesco1_1' value='".$cambio['PB']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Porcentaje 2</label>";
                echo "<input class='form-control' type='text' id='porcentaje1_2' NAME='porcentaje1_1' value='".$cambio['BFB']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Beneficiario 3</label>";
                echo "<input class='form-control' type='text' id='ben1_2' NAME='ben1_1' value='".$cambio['BC']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label >Parentesco 3</label>";
                echo "<input class='form-control' type='text' id='parentesco1_2' NAME='parentesco1_1' value='".$cambio['PC']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Porcentaje 3</label>";
                echo "<input class='form-control' type='text' id='porcentaje1_2' NAME='porcentaje1_1' value='".$cambio['BFC']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Beneficiario 4</label>";
                echo "<input class='form-control' type='text' id='ben1_2' NAME='ben1_1' value='".$cambio['BD']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label >Parentesco 4</label>";
                echo "<input class='form-control' type='text' id='parentesco1_2' NAME='parentesco1_1' value='".$cambio['PD']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Porcentaje 4</label>";
                echo "<input class='form-control' type='text' id='porcentaje1_2' NAME='porcentaje1_1' value='".$cambio['BFD']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Beneficiario 5</label>";
                echo "<input class='form-control' type='text' id='ben1_2' NAME='ben1_1' value='".$cambio['BE']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label >Parentesco 5</label>";
                echo "<input class='form-control' type='text' id='parentesco1_2' NAME='parentesco1_1' value='".$cambio['PE']."'  readonly>";
              echo "</div>";

              echo "<div class='col-4'>";
                echo "<label>Porcentaje 5</label>";
                echo "<input class='form-control' type='text' id='porcentaje1_2' NAME='porcentaje1_1' value='".$cambio['BFE']."'  readonly>";
              echo "</div>";

    				echo "</div>";
          echo "</div>";

          echo "<div class='card-footer'>";
            echo "<div class='row'>";
              echo "<div class='col-6'>";
                echo "<button class='btn btn-warning btn-sm' type='button' onclick='cancela_bene()'><i class='fas fa-eraser'></i>Cancelar cambios</button>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
    		echo "</div>";
      }
    echo "</div>";
  echo "</div>";
?>


<script type="text/javascript">

  function cancela_bene(){
    $.confirm({
      title: 'Cancelar',
      content: '¿Desea cancelar la actualización de información?',
      buttons: {
        Aceptar: function () {
          $.ajax({
            data:  {
              "function":"cancela_bene"
            },
            url:  "beneficiarios/db_.php",
            type:  'post',
            success:  function (response) {
							$("#div_trabajo").load("beneficiarios/beneficiarios.php");
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


