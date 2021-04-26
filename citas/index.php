<?php
	require_once("db_.php");
  $row=$db->afiliado();
  $folio=$row['idfolio'];
  $filiacion=$row['Filiacion'];
  $ape_pat=$row['ape_pat'];
  $ape_mat=$row['ape_mat'];
  $nombre=$row['nombre'];
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
  	  <input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $row['idfolio']; ?>' placeholder='No. Empleado' readonly>
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
	              <input class='form-control form-control-sm' type='text' id='idfolio' NAME='idfolio' value='<?php echo $row['idfolio']; ?>' placeholder='No. Empleado' readonly>
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
        echo "<div class='btn-group'>";
        echo "<button class='btn btn-warning btn-sm' type='button' onclick='citas_listas()'><i class='fas fa-history'></i>Bitacora de citas</button>";
		      echo "<button class='btn btn-warning btn-sm' type='button' onclick='credito_p()'><i class='fas fa-money-check-alt'></i>Generar cita de Crédito</button>";
		      echo "<button class='btn btn-warning btn-sm' type='button' onclick='retiro_p()'><i class='fas fa-university'></i>Generar cita de Retiro</button>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
	  echo "<br>";


		echo "<div id='checar'>";

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

<script>
$(function(){
	citas_listas();
});
function ver_cita(id){
	$('#myModal').modal('show');
	$("#modal_form").load("citas/info.php?id="+id);
}
function citas_listas(){
  $.ajax({
    url: "citas/citas.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#checar').html(response);
      $("#cargando").removeClass("is-active");
    }
  });
}
function retiro_p(){
  $.ajax({
    url: "citas/retiro.php",
    type: "POST",
    timeout:10000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      clearInterval(timerUpdate);
      $("#reloj").hide();
      $('#checar').html(response);
      $("#cargando").removeClass("is-active");
    },
		error: function(jqXHR, textStatus, errorThrown) {
			if(textStatus==="timeout") {
				$("#cargando").removeClass("is-active");
				$("#checar").html("<div class='container' style='background-color:white; width:300px'><center><img src='img/giphy.gif' width='300px'></center></div><br><center><div class='alert alert-danger' role='alert'>Ocurrio un error intente de nuevo en unos minutos, vuelva a entrar o presione ctrl + F5, para reintentar</div></center> ");
			}
		}
  });
}
function credito_p(){
  $.ajax({
    url: "citas/credito.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      clearInterval(timerUpdate);
      $("#reloj").hide();
      $('#checar').html(response);
      $("#cargando").removeClass("is-active");
    }
  });
}
function confirmar_cita(){
  var cita=$("#cita").val();
  var tipo=$("#tipo").val();
  var observaciones=$("#observaciones").val();
  $.confirm({
    icon: 'far fa-calendar-check',
    title: 'Confirmar',
    type: 'orange',
    boxWidth: '800px',
    content: '¿Desea confirmar la cita?',
    buttons: {
      Confirmar: function () {
        $.ajax({
          data: {
            "function":"confirmar",
            "observaciones":observaciones,
            "cita":cita,
            "tipo":tipo
          },
          url: "citas/db_.php",
          type: "POST",
          timeout:1000,
          beforeSend: function () {
          },
          success:function(response){
            var datos = JSON.parse(response);
            if (datos.error==0){
              Swal.fire({
								type: 'success',
								title: "Fecha confirmada",
								showConfirmButton: false,
								timer: 3000
  						});
              $.ajax({
                url: "citas/citas.php",
                type: "POST",
                timeout:1000,
                beforeSend: function () {
                  $("#cargando").addClass("is-active");
                },
                success:function(response){
                  $('#checar').html(response);
                  $("#cargando").removeClass("is-active");
                }
              });
							$("#reloj").hide();
							clearInterval(timerUpdate);
            }
            else{
              Swal.fire({
								type: 'error',
								title: "Error intente nuevamente",
								showConfirmButton: false,
								timer: 3000
  						});
            }
          }
        });
      },
      Cancelar: function () {

      }
    }
  });
}
function verificar(tipo){
  var desde=$("#desde").val();
  var hora=$("#hora").val();
  var minuto=$("#minuto").val();
  $.confirm({
    icon: 'far fa-calendar-check',
    title: 'Programar',
    type: 'orange',
    boxWidth: '800px',
    content: '¿Programar una cita para el dia seleccionado?, <br>si se encuentra displonible tendrá 3 minutos para confirmar',
    buttons: {
      Programar: function () {
        $.ajax({
          data:  {
            "function":"citas",
            "desde":desde,
            "hora":hora,
            "minuto":minuto,
            "tipo":tipo
          },
          url:   'citas/db_.php',
          type:  'post',
          success:  function (response) {
            clearInterval(timerUpdate);
            var datos = JSON.parse(response);
            if (datos.activo==1){
              $('#checar').html(datos.texto);
              var fecha = new Date();
              fecha.setMinutes(fecha.getMinutes() + 3);
              countdown(fecha, 'reloj', '¡Finalizó!', datos.tipo);
              $("#reloj").show();
              Swal.fire({
  								type: 'success',
  								title: "Fecha disponible, tiene 3 minutos para confirmar",
  								showConfirmButton: false,
  								timer: 3000
  						});
            }
            else{
              Swal.fire({
  								type: 'error',
  								title: datos.texto,
  								showConfirmButton: false,
  								timer: 3000
  						});
            }
          }
        });
      },
      Cancelar: function () {

      }
    }
  });
}
function cancela_cita(cita){
  $.confirm({
    icon: 'far fa-calendar-check',
    title: 'Cancelar cita',
    type: 'orange',
    boxWidth: '800px',
    content: '¿Desea cancelar la cita programada',
    buttons: {
      Aceptar: function () {
        $.ajax({
          data:  {
            "function":"cancelar_cita",
            "cita":cita
          },
          url:   'citas/db_.php',
          type:  'post',
          success:  function (response) {
						var datos = JSON.parse(response);
            if (datos.error==0){
              Swal.fire({
  								type: 'success',
  								title: "Fecha cancelada correctamente",
  								showConfirmButton: false,
  								timer: 3000
  						});
              $.ajax({
                url: "citas/citas.php",
                type: "POST",
                timeout:1000,
                beforeSend: function () {
                  $("#cargando").addClass("is-active");
                },
                success:function(response){
                  $('#checar').html(response);
                  $("#cargando").removeClass("is-active");
                }
              });
            }
            else{
              Swal.fire({
  								type: 'error',
  								title: "error, favor de verificar",
  								showConfirmButton: false,
  								timer: 3000
  						});
            }
          }
        });
      },
      Salir: function () {

      }
    }
  });
}
function cancela_previo(cita){
	var cita=$("#cita").val();
	var tipo=$("#tipo").val();

	$.confirm({
		icon: 'far fa-calendar-check',
		title: 'Cancelar',
		type: 'orange',
		boxWidth: '800px',
		content: '¿Desea cancelar la cita?',
		buttons: {
			Si: function () {
				$.ajax({
					data: {
						"function":"pre_cancela",
						"cita":cita,
						"tipo":tipo
					},
					url: "citas/db_.php",
					type: "POST",
					timeout:1000,
					beforeSend: function () {

					},
					success:function(response){
						console.log(response);
						if(response==1){
							clearInterval(timerUpdate);
							$("#reloj").hide();
							Swal.fire({
								type: 'success',
								title: "Canceló",
								showConfirmButton: false,
								timer: 3000
							});

							$.ajax({
								url: "citas/citas.php",
								type: "POST",
								timeout:1000,
								beforeSend: function () {
									$("#cargando").addClass("is-active");
								},
								success:function(response){
									$('#checar').html(response);
									$("#cargando").removeClass("is-active");
								}
							});

						}
						else{
							Swal.fire({
								type: 'error',
								title: "Error, favor de intentar nuevamente",
								showConfirmButton: false,
								timer: 3000
							});
						}
					}
				});
			},
			No: function () {

			}
		}
	});
}

</script>
