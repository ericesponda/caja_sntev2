	var intval="";
	var intvalx="";
	var chatx="";
	var cuenta="";
	var notif="";
	var monit="";

	let db_inicial = "control_db.php";
	let debugx = 1;

	onload = () => {
		inicial_div(false);
		loadContent(location.hash.slice(1));
	};

	var url = window.location.href;
	var hash = url.substring(url.indexOf("#") + 1);

	if (hash === url || hash === '') {
		hash = 'dash/dashboard';
	}
	const loadContent= (hash) => {
		cargando_div(true);
		if (hash === '') {
			hash = 'dash/index';
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
