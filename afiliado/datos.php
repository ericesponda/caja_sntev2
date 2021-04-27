<?php
	require_once("db_.php");

	$row=$db->afiliado();
	$idfolio=$row->idfolio;
	$filiacion=$row->Filiacion;
	$ape_pat=$row->ape_pat;
	$ape_mat=$row->ape_mat;
	$nombre=$row->nombre;

	$d_dom=$row->d_dom;
	$l_loc=$row->l_loc;
	$m_mun=$row->m_mun;

	$e_civ=$row->e_civ;
	$conyuge=$row->n_con;

	$c_c_t=$row->c_c_t;
	$d_sin=$row->d_sin;
	$u_bic=$row->u_bic;
	$r_rrg=$row->r_rrg;
	$c_psp=$row->c_psp;

	$correo=$row->correo;
	$celular=$row->celular;

echo "<div class='container' id='div_trabajo'>";
	echo "<form id='formafiliado' xform='form' xctrl='afiliado/db_' xopt='guardar_datos' xdes='afiliado/datos' xdiv='div_trabajo'>";
	echo "<input class='form-control form-control-sm' type='hidden' id='id' NAME='id' value='$idfolio' readonly>";
 	
	echo "<div class='card mt-3'>";
		echo "<div class='card-body'>";
			echo "<img src='img/caja.png' width='20' alt='logo'> - ";
			echo "Datos generales actuales";
		echo "</div>";
	echo "</div>";

	echo "<div class='card mt-3'>";
		echo "<div class='card-body'>";
		echo "<div class='row'>";
			echo "<div class='col-xl-2 col-lg-2 col-md-2 col-sm-3 '>";
				echo "<label for='idfolio'>Socio</label>";
				echo "<input class='form-control form-control-sm' type='text' id='idfolio' NAME='idfolio' value='".$row->idfolio."' placeholder='No. Empleado' readonly>";
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
        echo "<div class='col-12'>";
          echo "<div class='form-group'>";
            echo "<label for='d_dom'>Domicilio</label>";
            echo "<input class='form-control form-control-sm' type='text' id='d_dom' NAME='d_dom' value='".$row->d_dom."' placeholder='Dirección' maxlength='200'>";
          echo "</div>";
        echo "</div>";

				echo "<div class='col-4'>";
					echo "<div class='form-group'>";
						echo "<label for='e_civ'>Estado civil</label>";

						echo "<select class='form-control form-control-sm' name='e_civ' id='e_civ'>";
						echo "<option value='' selected style='color: silver;'>Seleccione...</option>";
							echo  "<option value='CASADA'"; if ($e_civ=='CASADA'){echo  " selected";}			echo  ">CASADA</option>";
							echo  "<option value='CASADO'"; if ($e_civ=='CASADO'){echo  " selected";}			echo  ">CASADO</option>";
							echo  "<option value='CONCUBINATO'"; if ($e_civ=='CONCUBINATO'){echo  " selected";}			echo  ">CONCUBINATO</option>";
							echo  "<option value='DIVORCIADA'"; if ($e_civ=='DIVORCIADA'){echo  " selected";}			echo  ">DIVORCIADA</option>";
							echo  "<option value='DIVORCIADO'"; if ($e_civ=='DIVORCIADO'){echo  " selected";}			echo  ">DIVORCIADO</option>";
							echo  "<option value='MADRE SOLTERA'"; if ($e_civ=='MADRE SOLTERA'){echo  " selected";}			echo  ">MADRE SOLTERA</option>";
							echo  "<option value='PADRE SOLTERO'"; if ($e_civ=='PADRE SOLTERO'){echo  " selected";}			echo  ">PADRE SOLTERO</option>";
							echo  "<option value='SEPARADA'"; if ($e_civ=='SEPARADA'){echo  " selected";}			echo  ">SEPARADA</option>";

							echo  "<option value='SEPARADO'"; if ($e_civ=='SEPARADO'){echo  " selected";}			echo  ">SEPARADO</option>";
							echo  "<option value='SOLTERA'"; if ($e_civ=='SOLTERA'){echo  " selected";}			echo  ">SOLTERA</option>";
							echo  "<option value='SOLTERO'"; if ($e_civ=='SOLTERO'){echo  " selected";}			echo  ">SOLTERO</option>";
							echo  "<option value='UNIÓN LIBRE'"; if ($e_civ=='UNIÓN LIBRE'){echo  " selected";}			echo  ">UNIÓN LIBRE</option>";
							echo  "<option value='VIUDA'"; if ($e_civ=='VIUDA'){echo  " selected";}			echo  ">VIUDA</option>";
							echo  "<option value='VIUDO'"; if ($e_civ=='VIUDO'){echo  " selected";}			echo  ">VIUDO</option>";
						echo  "</select>";
					echo "</div>";
				echo "</div>";

				echo "<div class='col-8'>";
          echo "<div class='form-group'>";
            echo "<label for='n_con'>Nombre del conyugue</label>";
            echo "<input class='form-control form-control-sm' type='text' id='n_con' NAME='n_con' value='".$row->n_con."' placeholder='Conyugue' maxlength='100'>";
          echo "</div>";
        echo "</div>";

				echo "<div class='col-4'>";
          echo "<div class='form-group'>";
            echo "<label for='l_loc'>Localidad</label>";
            echo "<input class='form-control form-control-sm' type='text' id='l_loc' NAME='l_loc' value='".$row->l_loc."' placeholder='Localidad' maxlength='80'>";
          echo "</div>";
        echo "</div>";

				echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-4'>";
          echo "<div class='form-group'>";
            echo "<label for='m_mun'>Municipio</label>";
            echo "<input class='form-control form-control-sm' type='text' id='m_mun' NAME='m_mun' value='".$row->m_mun."' placeholder='Municipio' maxlength='80'>";
          echo "</div>";
        echo "</div>";

////////////////////////
				echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-4'>";
          echo "<div class='form-group'>";
            echo "<label for='c_c_t'>Clave Centro de Trabajo</label>";
							echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_tema1' data-id='0' data-lugar='ayuda/tema1' title='Ubicación Clave Centro de Trabajo' ><i class='far fa-question-circle'></i> </button>";
            echo "<input class='form-control form-control-sm' type='text' id='c_c_t' NAME='c_c_t' value='".$row->c_c_t."' placeholder='Clave Centro de Trabajo' maxlength='100'>";

          echo "</div>";
        echo "</div>";

				echo "<div class='col-3'>";
					echo "<div class='form-group'>";
						echo "<label for='u_bic'>Ubicación</label>";
						echo "<input class='form-control form-control-sm' type='text' id='u_bic' NAME='u_bic' value='".$row->u_bic."' placeholder='Ubicación' maxlength='150'>";
					echo "</div>";
				echo "</div>";

				echo "<div class='col-3'>";
					echo "<div class='form-group'>";
						echo "<label for='d_sin'>Delegación / CT</label>";
						echo "<input class='form-control form-control-sm' type='text' id='d_sin' NAME='d_sin' value='".$row->d_sin."' placeholder='Delegación' maxlength='150'>";
					echo "</div>";
				echo "</div>";

				echo "<div class='col-3'>";
					echo "<div class='form-group'>";
						echo "<label for='r_rrg'>Región</label>";
						echo "<input class='form-control form-control-sm' type='text' id='r_rrg' NAME='r_rrg' value='".$row->r_rrg."' placeholder='Región' maxlength='40'>";
					echo "</div>";
				echo "</div>";

				echo "<div class='col-3'>";
					echo "<div class='form-group'>";
						echo "<label for='c_psp'>Clave Presupuestal</label>";
							echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_tema2' data-id='0' data-lugar='ayuda/tema2' title='Ubicación Clave Presupuestal' ><i class='far fa-question-circle'></i> </button>";
						echo "<input class='form-control form-control-sm' type='text' id='c_psp' NAME='c_psp' value='".$row->c_psp."' placeholder='Clave Presupuestal' maxlength='150'>";
					echo "</div>";
				echo "</div>";
      echo "</div>";
    echo "</div>";

		$row=$db->blo_lista();
		$fusuario=fecha($row->fusuario);
		$fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
		$fecha_entrada = strtotime($fusuario);
		$cambio=$db->cambios(3,$idfolio);

		echo "<div class='card-footer'>";
			if(!$cambio){
				if($fecha_actual <= $fecha_entrada){
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


	if ($cambio){
		echo "<br><div class='card' id='datos_c'>";
			echo "<div class='card-header'>";
				echo "<i class='fas fa-exclamation'></i> Datos generales actuales pendientes por actualizar - en breve serán actualizados en las oficinas de caja de ahorro";
			echo "</div>";
			echo "<div class='card-body'>";
				echo "<div class='row'>";
					echo "<div class='col-12'>";
						echo "<label for='c1'>Domicilio</label>";
						echo "<input class='form-control form-control-sm' type='text' id='d_dom1' NAME='d_dom1' value='".$cambio['d_dom']."' readonly>";
					echo "</div>";

					echo "<div class='col-4'>";
						echo "<label for='c2'>Estado civil</label>";
						echo "<input class='form-control form-control-sm' type='text' id='e_civ1' NAME='e_civ1' value='".$cambio['e_civ']."' readonly>";
					echo "</div>";
						////////////////////

						echo "<div class='col-8'>";
		          echo "<div class='form-group'>";
		            echo "<label for='n_con'>Nombre del conyugue</label>";
		            echo "<input class='form-control form-control-sm' type='text' id='n_con1' NAME='n_con1' value='".$cambio['n_con']."' placeholder='Conyugue' readonly>";
		          echo "</div>";
		        echo "</div>";

						echo "<div class='col-4'>";
		          echo "<div class='form-group'>";
		            echo "<label for='l_loc'>Localidad</label>";
		            echo "<input class='form-control form-control-sm' type='text' id='l_loc1' NAME='l_loc1' value='".$cambio['l_loc']."' placeholder='Localidad' readonly>";
		          echo "</div>";
		        echo "</div>";

						echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-4'>";
		          echo "<div class='form-group'>";
		            echo "<label for='m_mun'>Municipio</label>";
		            echo "<input class='form-control form-control-sm' type='text' id='m_mun1' NAME='m_mun1' value='".$cambio['m_mun']."' placeholder='Municipio' readonly>";
		          echo "</div>";
		        echo "</div>";

						echo "<div class='col-xl-4 col-lg-4 col-md-4 col-sm-4'>";
		          echo "<div class='form-group'>";
		            echo "<label for='c_c_t'>Clave Centro de Trabajo</label>";
		            echo "<input class='form-control form-control-sm' type='text' id='c_c_t1' NAME='c_c_t1' value='".$cambio['c_c_t']."' placeholder='Clave Centro de Trabajo' readonly>";
		          echo "</div>";
		        echo "</div>";

						echo "<div class='col-3'>";
							echo "<div class='form-group'>";
								echo "<label for='u_bic'>Ubicación</label>";
								echo "<input class='form-control form-control-sm' type='text' id='u_bic1' NAME='u_bic1' value='".$cambio['u_bic']."' placeholder='Ubicación' readonly>";
							echo "</div>";
						echo "</div>";

						echo "<div class='col-3'>";
							echo "<div class='form-group'>";
								echo "<label for='d_sin'>Delegación</label>";
								echo "<input class='form-control form-control-sm' type='text' id='d_sin1' NAME='d_sin1' value='".$cambio['d_sin']."' placeholder='Delegación' readonly>";
							echo "</div>";
						echo "</div>";

						echo "<div class='col-3'>";
							echo "<div class='form-group'>";
								echo "<label for='r_rrg'>Región</label>";
								echo "<input class='form-control form-control-sm' type='text' id='r_rrg1' NAME='r_rrg1' value='".$cambio['r_rrg']."' placeholder='Región' readonly>";
							echo "</div>";
						echo "</div>";

						echo "<div class='col-3'>";
							echo "<div class='form-group'>";
								echo "<label for='c_psp'>Clave Presupuestal</label>";
								echo "<input class='form-control form-control-sm' type='text' id='c_psp1' NAME='c_psp1' value='".$cambio['c_psp']."' placeholder='Clave Presupuestal' readonly>";
							echo "</div>";
						echo "</div>";
						/*
						echo "<div class='col-3'>";
							echo "<div class='form-group'>";
								echo "<label for='correo'>Correo</label>";
								echo "<input class='form-control form-control-sm' type='text' id='correo' NAME='correo' value='".$cambio['correo']."' placeholder='Correo o email' readonly>";
							echo "</div>";
						echo "</div>";

						echo "<div class='col-3'>";
							echo "<div class='form-group'>";
								echo "<label for='celular'>Telefono Celular</label>";
								echo "<input class='form-control form-control-sm' type='text' id='celular' NAME='celular' value='".$cambio['celular']."' placeholder='Celular' readonly>";
							echo "</div>";
						echo "</div>";
						*/
					echo "</div>";
				echo "</div>";
					//////////////////////////////
				echo "<div class='card-footer'>";
					echo "<div class='row'>";
						echo "<div class='col-6'>";
							echo "<button class='btn btn-warning btn-sm' type='button' onclick='cancela_datos()'><i class='fas fa-eraser'></i>Cancelar cambios</button>";
						echo "</div>";
					echo "</div>";
				echo "</div>";

		echo "</div>";
	}

echo "</div>";

?>

<script type="text/javascript">

	function cancela_datos(){
		$.confirm({
			title: 'Cancelar',
			content: '¿Desea cancelar la actualización de información?',
			buttons: {
				Aceptar: function () {
					$.ajax({
	 					data:  {
							"function":"cancela_datos"
	 					},
	 					url:  "afiliado/db_.php",
	 					type:  'post',
		 				success:  function (response) {
							$("#div_trabajo").load("afiliado/datos.php");
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
