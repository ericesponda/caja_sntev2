<?php
	require_once("db_.php");

	$alerta=$db->blog_alerta();
	echo "<div class='container' id='trabajo'>";
	foreach($alerta as $key){
		echo "<div class='alert alert-success'>";
		echo $key['corto'];
		echo "</div>";
	}

	$noticia=$db->blog_noticia();

	echo "<div class='row'>";
	foreach($noticia as $key){
		echo "<div class='col-sm-6'>
			<div class='card'>
				<div class='card-body'>";
					$imagen=$key['imagen'];
					echo "<h5 class='card-title'><b>".$key['nombre']."</b></h5>";
					echo "<div class='row'>";
						echo "<div class='col-12'>";
							echo "<p class='card-text'>".$key['corto']."</p>";
							echo "<button class='btn btn-warning btn-sm' id='edit_".$key['id']."' title='Editar' data-lugar='admin/blog_leer'  data-id='".$key['id']."'><i class='fas fa-pencil-alt'></i>Leer</button>";
							if(strlen($key['adjunto'])>0){
								echo "<a class='btn btn-warning btn-sm' id='adjunto_".$key['id']."' title='Editar' href='archivos/".$key['adjunto']."' target='_blank' download='".$key['adjunto']."'><i class='fas fa-paperclip'></i>Adjunto</a>";
							}
						echo "</div>";

					echo "</div>";
				echo "</div>
			</div>
		</div>";
	}
	echo "</div>";

	echo "<hr>";

	/*<div class='container'>
		<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
		  <div class='carousel-inner'>
		    <div class='carousel-item active'>
		      <img class='d-block w-100' height='400px' src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQ2TSnUJUflEJdnfIu1oW6cs6yJftEe0UgaZrmri20270ODlBzY' alt='First slide'>
				  <div class='carousel-caption d-none d-md-block'>
				    <h5>texto 1</h5>
				    <p>asunto</p>
				  </div>
		    </div>
		    <div class='carousel-item'>
		      <img class='d-block w-100' height='400px' src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTBAEzBYSDsSDCr-VU2Lkf92mAGzaBnX2TWUqvknzL1FkSw2K4A' alt='Second slide'>
		    </div>
		    <div class='carousel-item'>
		      <img class='d-block w-100' height='400px' src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQ5jhvNlr5LhxePfXrbTK2uE3yTZXwUvC9tl-10him0b8GwuYt7' alt='Third slide'>
		    </div>
		  </div>
		  <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
		    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
		    <span class='sr-only'>Previous</span>
		  </a>
		  <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
		    <span class='carousel-control-next-icon' aria-hidden='true'></span>
		    <span class='sr-only'>Next</span>
		  </a>
		</div>
	</div>*/
?>

<div align="center">
	<div class='row'>
		<div class='col-12'>
			<img src='img/aviso15abril.jpeg' width='50%'>
		</div>
	</div>
</div>
<div align="center">
	<div class='row'>
		<div class='col-12'>
			<img src='img/snte.jpeg' max-width='300px'>
		</div>
	</div>
</div>


<!--<video src="img/edit1.mp4" poster="img/editdatos.jpg" width="360" height="315" controls></video>
<video src="img/caportacion.mp4" poster="img/editaporta.jpg" width="360" height="315" controls></video>
<video src="img/cbenef.mp4" poster="img/editbene.jpg" width="360" height="315" controls></video>

 <iframe width="960" height="615" src="https://www.youtube.com/embed/XaP-63SYRbo"
frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
</iframe>-->
