	var intval="";
	var intvalx="";
	var chatx="";
	var cuenta="";
	var notif="";
	var monit="";

	let db_inicial = "control_db.php";
	let debugx = 1;

	onload = () => {
		inicial_div(true);
		//fondos();
		//chat_inicia();

		notifyMe();
		loadContent(location.hash.slice(1));

		const formData = new FormData();
		formData.append('function', 'login');
		formData.append("ctrl", "control");
		fetch(db_inicial, {
			method: 'POST',
			body: formData
		})
		.then(res => res.ok ? Promise.resolve(res) : Promise.reject(res))
		.then(res => res.json())
		.then(res => {
			if (res.admin == "1") {
				if (notif == "") {
					notif = window.setInterval("notificarx()", 30000);
				}
			}
			inicial_div(false);
		})
		.catch(function (err) {

		});
	};

	var url = window.location.href;
	var hash = url.substring(url.indexOf("#") + 1);

	if (hash === url || hash === '') {
		hash = 'dash/dashboard';
	}
	const loadContent= (hash) => {
		cargando_div(true);
		if (hash === '') {
			hash = 'dash/dashboard';
		}
		var destino = hash + '.php';

		fetch(destino, { timeout: 100 })
		.then(res => res.text())
		.then(res => {
			let globalelem = document.getElementById('global');
			if (globalelem !== null) {
				globalelem.remove();
			}
			document.getElementById("contenido").innerHTML = res;

			var g = document.createElement('script');
			g.setAttribute("id", "global");

			var scripts = document.getElementById("contenido").getElementsByTagName("script");
			for (var i = 0; i < scripts.length; i++) {
				g.text += scripts[i].innerText;
			}

			////////borra el script del modulo
			let scriptElem = document.getElementById('modulo');
			if (scriptElem !== null){
				scriptElem.remove();
			}

			document.body.append(g);
			cargando_div(false);
		})
		.catch(error => {
			cargando_div(false);
			location.href = "login/";-
			console.error('Error:', error);
		});
	}
	const notifyMe = () => {
		if (!("Notification" in window)) {

		}
		else if (Notification.permission === "granted") {

		}
		else if (Notification.permission !== 'denied') {
			Notification.requestPermission(function (permission) {
				if (!('permission' in Notification)) {
					Notification.permission = permission;
				}
				if (permission === "granted") {

				}
			});
		}
	}
	const salir = () => {
		cargando_div(true);
		const formData = new FormData();
		formData.append('function', 'salir');
		formData.append("ctrl", "control");
		fetch(db_inicial,{
			method: 'POST',
			body: formData
		})
		.then(function () {
			location.href = "login/";
		})
		.catch(function (err) {
			location.href = "login/";
			cargando_div(false);
			console.error(err);
		});
	}
	const copiar = (id) => {
		var codigoACopiar = document.getElementById(id);
		var seleccion = document.createRange();
		seleccion.selectNodeContents(codigoACopiar);
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(seleccion);
		var res = document.execCommand('copy');
		if (res) {
			Swal.fire({
				icon:'success',
				title: "Se copio correctamente",
				showConfirmButton: false,
				timer: 2000
			});
		}
		else {
			Swal.fire({
				icon:'error',
				title: "Error favor de verificar",
				showConfirmButton: false,
				timer: 3000
			});
		}
		window.getSelection().removeRange(seleccion);
	}



	var html5_audiotypes={
		"mp3": "audio/mpeg",
		"mp4": "audio/mp4",
		"ogg": "audio/ogg",
		"wav": "audio/wav"
	}
	function createsoundbite(sound){
		var html5audio=document.createElement('audio')
		if (html5audio.canPlayType){ //Comprobar soporte para audio HTML5
			for (var i=0; i<arguments.length; i++){
				var sourceel=document.createElement('source')
				sourceel.setAttribute('src', arguments[i])
				if (arguments[i].match(/.(w+)$/i))
				sourceel.setAttribute('type', html5_audiotypes[RegExp.$1])
				html5audio.appendChild(sourceel)
			}
			html5audio.load()
			html5audio.playclip=function(){
				html5audio.pause()
				html5audio.currentTime=0
				html5audio.play()
			}
			return html5audio
		}
		else{
		return {playclip:function(){throw new Error('Su navegador no soporta audio HTML5')}}
		}
	}
	var hover2 = createsoundbite('chat/newmsg.mp3');
	var hover3 = createsoundbite('chat/010762485_prev.mp3');

	////////////////////////////////
	const fondos = () =>{
		const formData = new FormData();
		formData.append('function', 'fondo_carga');
		formData.append("ctrl", "control");
		fetch(db_inicial, {
			method: 'POST',
			body: formData
		})
		.then(res => res.ok ? Promise.resolve(res) : Promise.reject(res))
		.then(res => res.text())
		.then(res => {
			document.getElementById("fondo").innerHTML = res;
		})
	}

	const msg_notificacion = (texto) => {
		if (Notification.permission === "granted") {
			var options = {
				body: texto,
				icon: "img/escudo.jpg",
				dir: "ltr"
			};
			var notification = new Notification("Sistema Administrativo de Salud Pública", options);
			//hover2.playclip();
		}
	}


	async function notificarx() {
		/*
		var notif = new FormData();
		notif.append("function", "notificarx");
		notif.append("ctrl", "control");

		fetch(db_inicial, {
			method: 'POST',
			body: notif
		})
			.then(res => res.ok ? Promise.resolve(res) : Promise.reject(res))
			.then(res => res.json())
			.then(res => {
				console.log(res);
			})
			.catch(error => {
				console.error('Error:', error);
			});
			*/


			$.ajax({
				data:  {
					"ctrl":"control",
					"function":"notificarx"
				},
				url:   db_inicial,
				type:  'post',
				timeout:3000,
				success:  function (response) {
					console.log(response);
					var data = JSON.parse(response);
					if(data.correo==1){
						msg_notificacion(data.texto);
					}

				}	,
				error: function(jqXHR, textStatus, errorThrown) {
					if(textStatus==="timeout") {
					}
				}
			});



		var formturno = new FormData();
		formturno.append("function", "alertas");
		formturno.append("ctrl", "control");

		fetch(db_inicial, {
			method: 'POST',
			body: formturno
		})
		.then(res => res.ok ? Promise.resolve(res) : Promise.reject(res))
		.then(res => res.json())
		.then(data => {

			if (data.entra == 1) {
				msg_notificacion(data.texto);

				Swal.fire({
					icon: 'info',
					title: '¿Aprobar correspondencia?',
					text: data.numero + " - >" + data.nombre + " <----> " + data.asunto,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Turnar',
					showDenyButton: true,
					denyButtonText: 'Eliminar'

				}).then((result) => {
					if (data.tipo == 1) {
						lugar = "a_corresp/db_.php";
					}
					if (data.tipo == 2) {
						lugar = "a_corresps/db_.php";
					}

					if (result.value == true) {

						/////////////////////////////////////////////////////////////////////////////////////
						var formturna = new FormData();
						formturna.append("idoficio", data.idoficio);
						formturna.append("idrel", data.id);
						formturna.append("function", "turnasol");

						fetch(lugar, {
							method: 'POST',
							body: formturna
						})
						.then(res => res.ok ? Promise.resolve(res) : Promise.reject(res))
						.then(res => {
							Swal.fire({
								icon: 'success',
								title: "Turnado!",
								showConfirmButton: false,
								timer: 1000
							});

							var formmanda = new FormData();
							formmanda.append("texto", "Oficio No:" + data.numero + " Turnado ");
							formmanda.append("id", data.idpersona);
							formmanda.append("opt", "manda");

							fetch("chat/", {
								method: 'POST',
								body: formmanda
							})
						})
						.catch(error => {
							console.error('Error:', error);
						});

					}
					else if (result.value == false) {
						var formturna = new FormData();
						formturna.append("idoficio", data.idoficio);
						formturna.append("idrel", data.id);
						formturna.append("function", "cancelasol");

						fetch(lugar, {
							method: 'POST',
							body: formturna
						})
						.then(res => res.ok ? Promise.resolve(res) : Promise.reject(res))
						.then(res => {
							Swal.fire({
								icon: 'success',
								title: "Solicitud eliminada",
								showConfirmButton: false,
								timer: 1000
							});
						})
						.catch(error => {
							console.error('Error:', error);
						});
					}
				});

			}
		})
		.catch(error => {
			console.error('Error:', error);
		});
	}
