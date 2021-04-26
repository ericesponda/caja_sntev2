<?php
	require_once("db_.php");
	if(!isset($_SESSION['filiacion']) or strlen($_SESSION['filiacion'])==0 or $_SESSION['autoriza_SNTE']==0){
		header("location: login/");
	}
	$v="16.2";
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<title>Caja Seccion 15 SNTE</title>
	<link rel="icon" type="image/png" href="../img/favicon.ico">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">

	<link rel="stylesheet" href="lib/load/dist/css-loader.css">
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

	<div class="loader loader-bar-ping-pong is-active" id='inicial_div' style='background-color: rgba(255,255,255,1);'>
	</div>

	<div class="loader loader-double" id='cargando_div' style='background-color: rgba(0,0,0,.3);'>
	</div>

<header class="d-block p-2" id='header'>
	<?php
		include 'dash/menu.php';
	?>
</header>

<div class="page-wrapper d-block p-2" id='bodyx'>
	<div class='wrapper'>
		<div class='content navbar-default'>
			<div class='container-fluid' id='side_nav'>
				<?php
					include 'dash/side.php';
				?>
			</div>
			<div class='fijaproceso main' id='contenido'>
			</div>
		</div>
	</div>
</div>



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

	<!--   Cuadros de confirmación y dialogo   -->
	<link rel="stylesheet" href="lib/jqueryconfirm/css/jquery-confirm.css">
	<script src="lib/jqueryconfirm/js/jquery-confirm.js"></script>

	<!--   iconos   -->
	<link rel="stylesheet" href="lib/fontawesome-free-5.12.1-web/css/all.css">

	<!--   carrusel de imagenes   -->
	<script src="lib/baguetteBox.js-dev/baguetteBox.js" async></script>

	<script src="lib/popper.js"></script>
	<script src="lib/tooltip.js"></script>

	<!--   Chat   -->
	<script src="chat/chat.js<?php echo "?v=$v"; ?>" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="chat/chat.css<?php echo "?v=$v"; ?>"/>

	<!--   Propios   -->
	<link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">
	<script src="salud.js<?php echo "?v=$v"; ?>"></script>
	<script src="mila.js<?php echo "?v=$v"; ?>"></script>
	<script src="vainilla.js<?php echo "?v=$v"; ?>"></script>


	<script src="lib/chartjs/Chart.js"></script>
	<link href='lib/fullcalendar-4.0.1/packages/core/main.css' rel='stylesheet' />
	<link href='lib/fullcalendar-4.0.1/packages/daygrid/main.css' rel='stylesheet' />
	<script src='lib/fullcalendar-4.0.1/packages/core/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/interaction/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/daygrid/main.js'></script>

	<!--   Boostrap   -->
	<link rel="stylesheet" href="lib/css/bootstrap.min.css">
	<script src="lib/js/bootstrap.js"></script>

</html>
