<?php
	require_once("db_.php");
	if(!isset($_SESSION['filiacion']) or strlen($_SESSION['filiacion'])==0 or $_SESSION['autoriza_SNTE']==0){
		header("location: login/");
	}

	$v="18";
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<title>Caja Seccion 15 SNTE</title>
	<link rel="icon" type="image/png" href="img/favicon.ico">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">

	<link rel="stylesheet" href="lib/load/dist/css-loader.css">
	<link rel="stylesheet" href="lib/fontawesome-free-5.12.1-web/css/all.css">
	<link rel="stylesheet" href="lib/swal/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="lib/baguetteBox.js-dev/baguetteBox.css">

	<link rel="stylesheet" type="text/css" href="lib/modulos.css<?php echo "?v=$v"; ?>"/>


</head>
<?php
	$valor=$_SESSION['idfondo'];
	echo "<body style='background-image: url(\"$valor\")'>";
?>

	<div class="modal " tabindex="-1" role="dialog" id="myModal">
		<div class="modal-dialog modal-lg" role="document" id='modal_dispo'>
			<div class="modal-content" id='modal_form'>

			</div>
		</div>
	</div>

	<div class="loader loader-bar-ping-pong " id='inicial_div' style='background-color: rgba(255,255,255,1);'>
	</div>

	<div class="loader loader-double" id='cargando_div' style='background-color: rgba(0,0,0,.3);'>
	</div>

<div class="grid-container">
  <header class="header">
	<div class="text">Caja de Ahorro y Crédito</div>
  </header>
  <aside class="sidebar">
    <div class="logo_content">
		<div class="logo">
			<img src='img/caja.png' width='20' alt='logo'>
			<div class="logo_name">Caja de Ahorro y Crédito</div>
		</div>
		<i class="fas fa-bars" id="btn"></i>
    </div>
    <ul class="nav_list">
			<!--
      <li>
          <i class='bx bx-search' ></i>
          <input type="text" placeholder="Search...">
        <span class="tooltip">Search</span>
      </li>
		-->
      <li>
        <a xapp='menu' xdes='dash/index'>
          <i class='fas fa-home'></i>
          <span class="links_name">Inicio</span>
        </a>
        <span class="tooltip">Inicio x</span>
      </li>

			<?php
				if($_SESSION['administrador']==1){

				}
				else{
					$row=$db->blo_lista();
					echo "<li>";
						echo "<a xapp='menu' xdes='afiliado/datos' title='Datos'>";
							echo "<i class='fas fa-user-shield'></i>";
							echo "<span class='links_name'>Datos";
							$fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
							$fecha_entrada = strtotime(fecha($row->fusuario));
							if($fecha_actual <= $fecha_entrada){
									echo "<span class='badge badge-pill badge-warning'><i class='fas fa-pencil-alt'></i></span>";
							}
							echo "</span>";
						echo "</a>";
						echo "<span class='tooltip'>Datos</span>";
					echo "</li>";


					/////////////////aportacion
					echo "<li>";
						echo "<a xapp='menu' xdes='aportacion/aportacion'>";
						echo "<i class='far fa-money-bill-alt'></i>";
						echo "<span class='links_name'>Aportación";
						$fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
						$fecha_entrada = strtotime(fecha($row->faportacion));
						if($fecha_actual <= $fecha_entrada){
								echo "<span class='badge badge-pill badge-warning'><i class='fas fa-pencil-alt'></i></span>";
						}
						echo "</span>";
						echo "</a>";
						echo "<span class='tooltip'>Aportación</span>";
					echo "</li>";

					//////////////////beneficiarios
					echo "<li>";
						echo "<a xapp='menu' xdes='beneficiarios/beneficiarios'>";
						echo "<i class='fas fa-users'></i>";
						echo "<span class='links_name'>Beneficiarios";
						$fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
						$fecha_entrada = strtotime(fecha($row->fbeneficiarios));
						if($fecha_actual <= $fecha_entrada){
								echo "<span class='badge badge-pill badge-warning'><i class='fas fa-pencil-alt'></i></span>";
						}
						echo "</span>";
						echo "</a>";
						echo "<span class='tooltip'>Beneficiarios</span>";
					echo "</li>";

					echo "<li>";
						echo "<a xapp='menu' xdes='afiliado/acceso'>";
						echo "<i class='fas fa-at'></i>";
						echo "<span class='links_name'>Cambiar Correo</span>";
						echo "</a>";
						echo "<span class='tooltip'>Correo</span>";
					echo "</li>";

					echo "<li>";
						echo "<a xapp='menu' xdes='afiliado/pass'>";
						echo "<i class='fas fa-key'></i>";
						echo "<span class='links_name'>Contraseña</span>";
						echo "</a>";
						echo "<span class='tooltip'>Contraseña</span>";
					echo "</li>";

					echo "<li>";
						echo "<a xapp='menu' xdes='creditos/credito'>";
						echo "<i class='fas fa-money-check-alt'></i>";
						echo "<span class='links_name'>Créditos</span>";
						echo "</a>";
						echo "<span class='tooltip'>Créditos</span>";
					echo "</li>";

					echo "<li>";
						echo "<a xapp='menu' xdes='ahorro/ahorro'>";
						echo "<i class='fas fa-university'></i>";
						echo "<span class='links_name'>Ahorro</span>";
						echo "</a>";
						echo "<span class='tooltip'>Ahorro</span>";
					echo "</li>";

					echo "<hr>";

					echo "<li>";
						echo "<a xapp='menu' xdes='citas/index'>";
						echo "<i class='far fa-calendar-check'></i>";
						echo "<span class='links_name'>Citas</span>";
						echo "</a>";
						echo "<span class='tooltip'>Citas</span>";
					echo "</li>";

					echo "<li>";
						echo "<a xapp='menu' xdes='bancos/datos'>";
						echo "<i class='fas fa-university'></i>";
						echo "<span class='links_name'>Bancos</span>";
						echo "</a>";
						echo "<span class='tooltip'>Bancos</span>";
					echo "</li>";

					$fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
					$fecha_entrada = strtotime(fecha($row->fretiro));
					if($fecha_actual <= $fecha_entrada){
						echo"<a href='#formatos/format' title='Formatos'><i class='fas fa-print'></i><span>Formatos de retiro</span></a>";
					}
				}
			?>
    </ul>
    <div class="profile_content">
      <div class="profile">
        <div class="profile_details">
          <img src="profile.jpg" alt="">
          <div class="name_job">
            <div class="name">Prem Shahi</div>
            <div class="job">Web Designer</div>
          </div>
        </div>
				<a class='nav-link pull-left' onclick='salir()' id="log_out" >
					<i class="fas fa-door-open"></i>
				</a>
      </div>
    </div>
  


  </aside>
  <main class="main"  id='contenido'>


  </main>
  <footer class="footer">
	   
  </footer>
</div>





	<script>
	 let btn = document.querySelector("#btn");
	 let sidebar = document.querySelector(".grid-container");
	 let searchBtn = document.querySelector(".bx-search");

	 btn.onclick = function() {
		 sidebar.classList.toggle("active");
		 if(btn.classList.contains("bx-menu")){
			 btn.classList.replace("bx-menu" , "bx-menu-alt-right");
		 }else{
			 btn.classList.replace("bx-menu-alt-right", "bx-menu");
		 }
	 }
	 searchBtn.onclick = function() {
		 sidebar.classList.toggle("active");
	 }
	</script>


</body>

	<!--   Core JS Files   -->

	<script src="lib/jquery-3.5.1.js" type="text/javascript"></script>
	<script src="lib/jquery/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="lib/jquery/jquery-ui.min.css" />

	<!--   url   -->

	<!-- Animation library for notifications   -->
  <link href="lib/animate.css" rel="stylesheet"/>

	<!-- WYSWYG   -->
	<link href="lib/summernote8.12/summernote-lite.css" rel="stylesheet" type="text/css">
  <script src="lib/summernote8.12/summernote-lite.js"></script>
	<script src="lib/summernote8.12/lang/summernote-es-ES.js"></script>

	<!--   Alertas   -->
	<script src="lib/swal/dist/sweetalert2.js"></script>


	<!--   para imprimir   -->
	<script src="lib/VentanaCentrada.js" type="text/javascript"></script>



	<!--   carrusel de imagenes   -->
	<script src="lib/baguetteBox.js-dev/baguetteBox.js" async></script>

	<script src="lib/popper.js"></script>
	<script src="lib/tooltip.js"></script>


	<!--   Propios   -->

	<script src="sagyc_snte.js<?php echo "?v=$v"; ?>"></script>
	<script src="mila_snte.js<?php echo "?v=$v"; ?>"></script>
	<script src="vainilla_snte.js<?php echo "?v=$v"; ?>"></script>


	<link href='lib/fullcalendar-4.0.1/packages/core/main.css' rel='stylesheet' />
	<link href='lib/fullcalendar-4.0.1/packages/daygrid/main.css' rel='stylesheet' />
	<script src='lib/fullcalendar-4.0.1/packages/core/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/interaction/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/daygrid/main.js'></script>

	<!--   Boostrap   -->
	<link rel="stylesheet" href="lib/boostrap/css/bootstrap.css">
	<script src="lib/boostrap/js/bootstrap.js"></script>

</html>
