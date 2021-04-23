if (typeof db_inicial == 'undefined') {
    db_inicial = "control_db.php";
}
if (typeof debugx == 'undefined') {
    debugx = 1;
}



///////////////////////////////////////////////NUEVAS OPCIONES
document.addEventListener('click', function (e) {
    if (e.target.parentNode.attributes.xapp) {
        if (debugx == 1)
            console.log("--->APP CLICK");

        preproceso_db(e.target.parentElement);
    }
    else if (e.target.attributes.xapp) {
        if (debugx == 1)
            console.log("--->APP CLICK");

        preproceso_db(e.target);
    }
}, false);

document.addEventListener('submit', function (e) {
    if (e.target.attributes.xform) {
        e.preventDefault();
        let ele = document.getElementById(e.target.attributes.id.nodeValue);
        sagyc(ele);
    }
}, false);

document.addEventListener('change', function (e) {
    /////////////////////////onchange y manda todo el formulario
    if (e.target.attributes.xchange) {
        switch (e.target.attributes.xchange.nodeValue) {
            case 'all':
                let formx = document.getElementById(e.target.form.id);
                sagyc(formx);
                break;
            case 'uno':
                let inpt = document.getElementById(e.target.id);
                change_one(inpt);
                break;
        }
    }
}, false);

////////////////////////solo manda datos del input
const change_one = (ele) => {
    if (debugx == 1)
        console.log("--->change_one");


    let xdes;
    (ele.attributes.xdes !== undefined) ? xdes = ele.attributes.xdes.nodeValue : xdes = "";

    let xdiv;
    (ele.attributes.xdiv !== undefined) ? xdiv = ele.attributes.xdiv.nodeValue : xdiv = "trabajo";

    let xopt;
    (ele.attributes.xopt !== undefined) ? xopt = ele.attributes.xopt.nodeValue : xopt = "";

    let datos = new Object();
    datos.xdes = xdes;
    datos.xdiv = xdiv;
    datos.xopt = xopt;

    var formData = new FormData();
    formData.append('function', datos.xopt);
    formData.append('valor', ele.value);

    fetch(xdes + ".php", {
        method: 'POST',
        body: formData
    })
        .then(res => res.text())
        .then(res => {
            document.getElementById(datos.xdiv).innerHTML = res;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

////////////////////////SUBMIT GENERAL
const sagyc = (ele) => {
    if (debugx == 1)
        console.log("--->SAGYC");

    /////////API que procesa el form
    console.log(ele);

    let xctrl;
    (ele.attributes.xctrl !== undefined) ? xctrl = ele.attributes.xctrl.nodeValue : xctrl = "";

    /////////funcion del api que procesa el form
    let xopt;
    (ele.attributes.xopt !== undefined) ? xopt = ele.attributes.xopt.nodeValue : xopt = "";

    /////////Div de destino despues de guardar
    let xdiv;
    (ele.attributes.xdiv !== undefined) ? xdiv = ele.attributes.xdiv.nodeValue : xdiv = "trabajo";

    /////////div destino despues de guardar
    let xdes;
    (ele.attributes.xdes !== undefined) ? xdes = ele.attributes.xdes.nodeValue : xdes = "";

    let xid;
    (ele.attributes.xid !== undefined) ? xid = ele.attributes.xid.nodeValue : xid = "";

    ////////FORM pertenece a ventanamodal
    let xmodal;
    (ele.attributes.xmodal !== undefined) ? xmodal = ele.attributes.xmodal.nodeValue : xmodal = "";

    ////////confirmar de guardado
    let xconfirm;
    (ele.attributes.xconfirm !== undefined) ? xconfirm = ele.attributes.xconfirm.nodeValue : xconfirm = "";

    let datos = new Object();
    datos.xdes = xdes;
    datos.xid = xid;
    datos.xctrl = xctrl;
    datos.xdiv = xdiv;
    datos.xopt = xopt;
    datos.xmodal = xmodal;
    datos.xconfirm = xconfirm;

    if (ele.attributes.xform.nodeValue == "print") {
        var formData = new FormData(ele);
        let cadena = "?";
        for (var pair of formData.entries()) {
            cadena += pair[0] + "=" + pair[1] + "&";
        }
        for (let contar = 0; contar < ele.attributes.length; contar++) {
            let arrayDeCadenas = ele.attributes[contar].name.split("_");
            if (arrayDeCadenas.length > 1) {
                cadena += arrayDeCadenas[1] + "=" + ele.attributes[contar].value + "&";
            }
        }
        VentanaCentrada(datos.xdes + ".php" + cadena, 'Impresion', '', '1024', '768', 'true');
        return;
    }

    var formDestino = new FormData();
    var formData = new FormData(ele);
    formData.append("function", datos.xopt);

    /////////esto es para todas las variables
    for (let contar = 0; contar < ele.attributes.length; contar++) {
        let arrayDeCadenas = ele.attributes[contar].name.split("_");
        if (arrayDeCadenas.length > 1) {
            formData.append(arrayDeCadenas[1], ele.attributes[contar].value);
            formDestino.append(arrayDeCadenas[1], ele.attributes[contar].value);
        }
    }

    if (xctrl.length > 4) {

        if (datos.xconfirm == "") {
            Swal.fire({
                title: '¿Desea procesar los cambios realizados?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Guardar'
            }).then((result) => {
                if (result.value) {
                    sagyc_procesar(datos, formData, formDestino);
                }
            });
        }
        else {
            sagyc_procesar(datos, formData, formDestino);
        }
    }
    else {
        cargando_div(true);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', datos.xdes + ".php");
        xhr.addEventListener('load', (data) => {
            if (datos.xmodal == 1) {
                $('#myModal').modal('show');
                datos.xdiv = "modal_form";
            }
            $("#" + datos.xdiv).html(data.target.response);
            cargando_div(false);
        });
        xhr.onerror = () => {
            console.log("error");
            cargando_div(false);
        };
        xhr.send(formData);
    }
}

//////////////////////////PROCESA EL FORM
const sagyc_procesar = (datos, formData, formDestino) => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', datos.xctrl + ".php");
    xhr.addEventListener('load', (data) => {
        if (!isJSON(data.target.response)) {
            console.log(data.target.response);
            Swal.fire({
                icon: 'error',
                title: "Error favor de verificar",
                showConfirmButton: false,
                timer: 1000
            });
            return;
        }

        var respon = JSON.parse(data.target.response);
        if (respon.error == 0) {
            if (datos.xid !== undefined && datos.xid.length > 0) {
                document.getElementById(datos.xid).value = respon.id1;
                formDestino.append(datos.xid, respon.id1);
            }
            if (datos.xdes !== undefined && datos.xdes.length > 4) {
                redirige_div(formDestino, datos);
            }
            if (datos.xmodal == 2) {
                $('#myModal').modal('hide');
                document.getElementById("modal_form").innerHTML = "";
                ////////cierra y procesa
            }
            if (respon.terror !== undefined && respon.terror.length > 0) {
                Swal.fire({
                    icon: 'success',
                    title: respon.terror,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
            else {
                Swal.fire({
                    icon: 'success',
                    position: 'bottom-start',
                    showConfirmButton: false,
                    timer: 700
                });
            }
        }
        else {
            Swal.fire({
                icon: 'info',
                title: respon.terror,
                showConfirmButton: false,
                timer: 1000
            });
        }
    });
    xhr.onerror = () => {
        console.log("error");
    };
    xhr.send(formData);
}
const preproceso_db = (e) => {
    if (debugx == 1)
        console.log("--->PREPROCESO ENTRA");

    let xapp;	/////////////el destino
    e.attributes.xapp !== undefined ? xapp = e.attributes.xapp.nodeValue : xapp = "";

    let xdes;	/////////////el destino
    e.attributes.xdes !== undefined ? xdes = e.attributes.xdes.nodeValue : xdes = "";

    let xdiv; 	/////////////	el div donde se pone el destino
    e.attributes.xdiv !== undefined ? xdiv = e.attributes.xdiv.nodeValue : xdiv = "";

    let xctrl;		/////////////en caso de base de datos
    e.attributes.xctrl !== undefined ? xctrl = e.attributes.xctrl.nodeValue : xctrl = "";

    let xopt;	///////////// la funcion a ejecutar
    e.attributes.xopt !== undefined ? xopt = e.attributes.xopt.nodeValue : xopt = "";

    let xqa;	///////////// la funcion a ejecutar
    e.attributes.xqa !== undefined ? xqa = e.attributes.xqa.nodeValue : xqa = "";

    let xqb;	///////////// la funcion a ejecutar
    e.attributes.xqb !== undefined ? xqb = e.attributes.xqb.nodeValue : xqb = "";

    let tt;	///////////// la funcion a ejecutar
    e.attributes.tt !== undefined ? tt = e.attributes.tt.nodeValue : tt = "";

    let xid;
    e.attributes.xid !== undefined ? xid = e.attributes.xid.nodeValue : xid = "";

    let xmodal;
    (e.attributes.xmodal !== undefined) ? xmodal = e.attributes.xmodal.nodeValue : xmodal = "";

    let datos = new Object();

    datos.xdes = xdes;
    datos.xctrl = xctrl;
    datos.xdiv = xdiv;
    datos.xopt = xopt;
    datos.xqa = xqa;
    datos.xqb = xqb;
    datos.tt = tt;
    datos.xid = xid;
    datos.xmodal = xmodal;

    if (debugx == 1) {
        console.log("Datos");
        console.log(datos);
    }

    /////////esto es para todas las variables
    var formData = new FormData();
    formData.append("function", datos.xopt);

    for (let contar = 0; contar < e.attributes.length; contar++) {
        let arrayDeCadenas = e.attributes[contar].name.split("_");
        if (arrayDeCadenas.length > 1) {
            formData.append(arrayDeCadenas[1], e.attributes[contar].value);
        }
    }

    if (xapp == "print") {
        cargando_div(true);
        let cadena = "?";
        for (let contar = 0; contar < e.attributes.length; contar++) {
            let arrayDeCadenas = e.attributes[contar].name.split("_");
            if (arrayDeCadenas.length > 1) {
                cadena += arrayDeCadenas[1] + "=" + e.attributes[contar].value + "&";
            }
        }
        VentanaCentrada(xdes + ".php" + cadena, 'Impresion', '', '1024', '768', 'true');
        cargando_div(false);
        return;
    }
    if (xapp == "menu") {
        console.log("menu");
        location.hash = xdes;
        loadContent(xdes);
        return;
    }

    if (datos.xmodal === "0") {
        $('#myModal').modal('hide');
        document.getElementById("modal_form").innerHTML = "";
        return;
    }
    if (datos.xmodal === "2") {
        $('#myModal').modal('hide');
        document.getElementById("modal_form").innerHTML = "";
    }

    //////////////poner aqui proceso en caso de existir funcion
    if (xopt.length > 0) {
        if (datos.xqa.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: datos.xqa,
                text: datos.xqb,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                focusCancel: true
            }).then((result) => {
                if (result.value) {
                    if (debugx == 1)
                        console.log("PREGUNTA CONFIRMA");

                    proceso_fx(formData, datos);
                }
            });
        }
        else {
            if (debugx == 1)
                console.log("SIN PREGUNTA");

            proceso_fx(formData, datos);
        }
    }
    else {
        redirige_div(formData, datos);
    }
}
const proceso_fx = (formData, datos) => {
    if (debugx == 1) {
        console.log("--->PROCESO ENTRA");
    }

    if (debugx == 1) {
        console.log("\t variables:");
        for (var pair of formData.entries()) {
            console.log("\t" + pair[0] + '->' + pair[1]);
        }
    }
    let variable = 0;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', datos.xctrl + ".php");
    xhr.addEventListener('load', (data) => {
        if (!isJSON(data.target.response)) {
            Swal.fire({
                icon: 'error',
                title: "Error favor de verificar",
                showConfirmButton: false,
                timer: 1000
            });
            console.log(data.target.response);
            return;
        }
        if (debugx == 1) {
            console.log("\t RESULTADO PROCESO:");
            console.log(data.target.response);
        }
        var respon = JSON.parse(data.target.response);
        if (respon.error == 0) {

            if (datos.xid !== undefined && datos.xid.length > 0) {
                formData.append(datos.xid, respon.id1);
            }

            if (respon.terror !== undefined && respon.terror.length > 0) {
                Swal.fire({
                    icon: 'success',
                    title: respon.terror,
                    showConfirmButton: false,
                    timer: 1000
                });
            }
            else {
                Swal.fire({
                    icon: 'success',
                    title: "Listo",
                    showConfirmButton: false,
                    timer: 500
                });
            }
            if (datos.xdes.length > 0) {
                redirige_div(formData, datos);
            }
        }
        else {
            Swal.fire({
                icon: 'info',
                title: respon.terror,
                showConfirmButton: false,
                timer: 1000
            });
        }
    });
    xhr.onerror = (e) => {
    };
    xhr.send(formData);
}
//////////////////////////redirige si es necesario
const redirige_div = (formData, datos) => {
    cargando_div(true);
    formData.delete("function");

    if (debugx == 1) {
        console.log("--->REDIRIGE");
    }

    if (debugx == 1) {
        console.log("\t variables:");

        for (var pair of formData.entries()) {
            console.log("\t " + pair[0] + "->" + pair[1]);
        }
    }
    let xhr = new XMLHttpRequest();
    xhr.open('POST', datos.xdes + ".php");
    xhr.addEventListener('load', (datares) => {
        if (datares.target.status == "404") {
            Swal.fire({
                icon: 'error',
                title: "No encontrado: " + datos.xdes,
                showConfirmButton: false,
            })
            cargando_div(false);
            return 0;
        }
        else {
            if (datos.xmodal == 1) {
                $('#myModal').modal('show');
                datos.xdiv = "modal_form";
            }
            if (isJSON(datares.target.responseText)) {
                alert("JSON");
            }
            else {
                if (debugx == 1) {
                    console.log("\t PRESENTA");
                    //console.log(datares.target.responseText);
                }

                $("#" + datos.xdiv).html(datares.target.responseText);
            }
        }
        cargando_div(false);
    });
    xhr.onerror = (e) => {
        cargando_div(false);
    };
    xhr.send(formData);
}
const cargando_div = (valor) => {
    let element = document.getElementById("cargando_div");
    if (valor) {
        element.classList.add("is-active");
    }
    else {
        element.classList.remove("is-active");
    }
}
const inicial_div = (valor) => {
    let element = document.getElementById("inicial_div");
    if (valor) {
        element.classList.add("is-active");
    }
    else {
        element.classList.remove("is-active");
    }
}
const isJSON = (something) => {
    if (typeof something != 'string')
        something = JSON.stringify(something);
    try {
        JSON.parse(something);
        return true;
    } catch (e) {
        return false;
    }
}