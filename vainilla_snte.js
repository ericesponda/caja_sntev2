function ver_cita(id){
	$('#myModal').modal('show');
	$("#modal_form").load("citas/info.php?id="+id);
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
