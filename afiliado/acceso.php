<?php
	require_once("index.php");
  $row=$db->afiliado();
	$idfolio=$row->idfolio;
	$filiacion=$row->Filiacion;
	$ape_pat=$row->ape_pat;
	$ape_mat=$row->ape_mat;
	$nombre=$row->nombre;

	$correo=$row->correo;
	$celular=$row->celular;
 ?>
<div class='container' id='div_trabajo'>
  <form id='formcorrep' xform='form' xctrl='afiliado/' xopt='guardar_acceso' xdes='afiliado/acceso' xdiv='contenido'>
    <div class='card'>
      <div class='card-header'>
        <img src='img/caja.png' width='20' alt='logo'> -
        Cambiar acceso
      </div>
      <div class='card-body'>
				<?php
				echo "<div class='row'>";
					echo "<div class='col-xl-2 col-lg-2 col-md-2 col-sm-3'>";
						echo "<div class='form-group'>";
							echo "<label for='idfolio'>Socio</label>";
							echo "<input class='form-control form-control-sm' type='text' id='idfolio' NAME='idfolio' value='".$row->idfolio."' placeholder='No. Empleado' readonly>";
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
					echo "<div class='col-6'>";
						echo "<div class='form-group'>";
							echo "<label for='correo'>Correo</label>";
							echo "<input class='form-control form-control-sm' type='text' id='correo' NAME='correo' value='".$row->correo."' placeholder='Correo o email' maxlength='95'>";
						echo "</div>";
					echo "</div>";

					echo "<div class='col-6'>";
						echo "<div class='form-group'>";
							echo "<label for='celular'>Telefono Celular</label>";
							echo "<input class='form-control form-control-sm' type='text' id='celular' NAME='celular' value='".$row->celular."' placeholder='Celular' maxlength='20'>";
						echo "</div>";
					echo "</div>";
				echo "</div>";

      echo "</div>";
      echo "<div class='card-footer'>";
				$cambio=$db->cambios(2,$_SESSION['idfolio']);
        echo "<div class='btn-group'>";
					if (!$cambio){
	          echo "<button class='btn btn-warning btn-sm' type='submit'><i class='fas fa-sync'></i>Enviar cambios</button>";
					}
					else{
						echo "<b>Información pendiente por actualizar</b>";
					}
        echo "</div>";
      echo "</div>";
    echo "</div>";
  echo "</form>";


if ($cambio){
	echo "<br><div class='card' id='datos_c'>";
		echo "<div class='card-header'>";
			echo "<i class='fas fa-exclamation'></i> Datos de acceso - en breve serán actualizados en las oficinas de caja de ahorro";
		echo "</div>";
		echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-6'>";
					echo "<label for='c2'>Correo</label>";
					echo "<input class='form-control form-control-sm' type='text' id='e_civ1' NAME='e_civ1' value='".$cambio->correo."' readonly>";
				echo "</div>";

				echo "<div class='col-6'>";
					echo "<label for='c1'>Celular</label>";
					echo "<input class='form-control form-control-sm' type='text' id='d_dom1' NAME='d_dom1' value='".$cambio->celular."' readonly>";
				echo "</div>";

					////////////////////
			echo "</div>";
		echo "</div>";
				//////////////////////////////
			echo "<div class='card-footer'>";
				echo "<div class='row'>";
					echo "<div class='col-6'>";
						echo "<button type='button' class='btn btn-warning btn-sm' xapp='btn' xctrl='afiliado/' xopt='cancela_acceso' xdes='afiliado/acceso' xdiv='contenido' xqa='¿Desea cancelar los cambios solicitados?'><i class='fas fa-eraser'></i>Cancelar cambios</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

	echo "</div>";

}
 ?>
</div>
