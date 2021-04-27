<?php
	require_once("index.php");
  $row=$db->afiliado();
  $folio=$row->idfolio;
  $filiacion=$row->Filiacion;
  $ape_pat=$row->ape_pat;
  $ape_mat=$row->ape_mat;
  $nombre=$row->nombre;
?>
  <div id='reloj' style='display:none;
        position:absolute;
        float:right;
        top:100;
        right: 100px;
        border-radius:10px;
        background-color: #ffd6bb;
        width:100px;
        color:black;
        padding:10px;
        z-index:1000;
        box-shadow: 10px 2px 5px #999;
        -webkit-box-shadow: 10px 2px 5px #999;
        -moz-box-shadow: 10px 2px 5px #999;
        filter: shadow(color=#999999, direction=135, strength=2);'>
  </div>

  <div class='container'>
  	<form id='form_comision' action='' data-lugar='control_db' data-funcion='guardar_datos' data-destino='afiliado/datos'>
  	  <input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $row->idfolio; ?>' placeholder='No. Empleado' readonly>
    	<div class='card'>
	  		<div class='card-header'>
	  			<img src='img/caja.png' width='20' alt='logo'> -
	  			Programar cita
	  		</div>
	      <div class='card-body'>
	        <div class='row'>
	          <div class='col-xl-2 col-lg-2 col-md-2 col-sm-2'>
	            <div class='form-group'>
	              <label for='idfolio'>Socio</label>
	              <input class='form-control form-control-sm' type='text' id='idfolio' NAME='idfolio' value='<?php echo $row->idfolio; ?>' placeholder='No. Empleado' readonly>
	            </div>
	          </div>

          <div class='col-xl-3 col-lg-3 col-md-3 col-sm-3'>
            <div class='form-group'>
              <label for='Filiacion'>Filiación</label>
              <input class='form-control form-control-sm' type='text' id='Filiacion' NAME='Filiacion' value='<?php echo $filiacion; ?>' placeholder='Filiacion' readonly>
            </div>
          </div>

					<?php
          echo "<div class='col-xl-2 col-lg-4 col-md-4 col-sm-4'>";
            echo "<div class='form-group'>";
              echo "<label for='ape_pat'>A. Paterno</label>";
              echo "<input class='form-control form-control-sm' type='text' id='ape_pat' NAME='ape_pat' value='$ape_pat' placeholder='APELLIDO PATERNO' readonly>";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-2 col-lg-4 col-md-4 col-sm-4'>";
            echo "<div class='form-group'>";
              echo "<label for='ape_mat'>A. Materno</label>";
              echo "<input class='form-control form-control-sm' type='text' id='ape_mat' NAME='ape_mat' value='$ape_mat' placeholder='APELLIDO MATERNO' readonly>";
            echo "</div>";
          echo "</div>";

          echo "<div class='col-xl-3 col-lg-4 col-md-4 col-sm-4'>";
            echo "<div class='form-group'>";
              echo "<label for='nombre'>Nombre (s):</label>";
              echo "<input class='form-control form-control-sm' type='text' id='nombre' NAME='nombre' value='$nombre' placeholder='NOMBRE (S)' readonly>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
      echo "<div class='card-footer'>";

        echo "<button class='btn btn-warning btn-sm ml-1' type='button' xapp='btn' xdes='citas/citas' xdiv='checar'><i class='fas fa-history'></i><br><small>Bitacora de citas</small></button>";
		    echo "<button class='btn btn-warning btn-sm ml-1' type='button' onclick='credito_p()'><i class='fas fa-money-check-alt'></i>Generar cita de Crédito</button>";
		    echo "<button class='btn btn-warning btn-sm ml-1' type='button' onclick='retiro_p()'><i class='fas fa-university'></i>Generar cita de Retiro</button>";
      echo "</div>";
    echo "</div>";
	  echo "<br>";


		echo "<div id='checar'>";
			include "citas.php";
		echo "</div>";


		echo "<div class='card'>";
			echo "<div class='card-header'>";
				echo "Recuerda que solo tienes derecho a una cancelación y a una cita, procura no faltar y llegar a tiempo por favor.";
				echo "<br>";
				echo"Todas las citas aquí generadas serán atendidas exclusivamente en las oficinas centrales de Pachuca.";
			echo "</div>";
		echo "</div>";
	echo "</div>";
?>
