onload = ()=> {
  cargando_div(false);
};
document.addEventListener('submit', function (e) {
  e.preventDefault();
  let elemento = document.getElementById(e.target.id);
  switch (e.target.id) {
    case 'form_login':
      login(elemento);
      break;
    case 'form_rec':
      recuperar(elemento);
      break;
  }
}, false);

document.addEventListener('click', function (e) {
  if (e.target.attributes.xc) {
    e.preventDefault();
    xf = e.target.attributes.xf.nodeValue;
    switch (xf) {
      case 'recuperar':
        recuperar_form();
        break;
      case 'reg':
        regresar_form();
        break;
      default:
        break;
    }
  }
}, false);
const login = (elemento) => {
  cargando_div(true);
  const formData = new FormData(elemento);
  formData.append("function", "acceso");

  let xhr = new XMLHttpRequest();
  xhr.open('POST',"db_.php");
  xhr.addEventListener('load', (data) => {
    if (!isJSON(data.target.response)) {
        console.log(data.target.response);
        cargando_div(false);
        Swal.fire({
            icon: 'error',
            title: "Error favor de verificar",
            showConfirmButton: false,
            timer: 1000
        });
        return;
    }
    else{
        console.log(data.target.response);
        let respon = JSON.parse(data.target.response);
        if (respon.acceso == 1) {
          location.href = "../";
        }
        else {
          cargando_div(false);
          Swal.fire({
            icon: 'error',
            title: 'Usuario o contraseña incorrecta',
            showConfirmButton: false,
            timer: 1000
          })
        }
    }
  });
  xhr.onerror = () => {
      console.log("error");
      cargando_div(false);
  };
  xhr.send(formData);

}
const recuperar = (elemento) => {
  cargando_div(true);
  const formData = new FormData(elemento);
  formData.append("function", "rec");
  fetch('db_.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.ok ? Promise.resolve(res) : Promise.reject(res))
    .then(res => res.json())
    .then(res => {
      if (res.error == 0) {
        cargando_div(false);
        Swal.fire({
          icon: 'success',
          title: "Enviado",
          text: res.terror
        }).then((result) => {
          if (result.value) {
            regresar();
          }
        });
      }
      else {
        cargando_div(false);
        Swal.fire({
          icon: 'error',
          title: 'Usuario o contraseña incorrecta',
          showConfirmButton: false,
          timer: 1000
        })
      }
    });
}
const cargando_div = (valor) => {
  let element = document.getElementById("cargando_div");
  if(valor){
    element.classList.add("is-active");
  }
  else{
    element.classList.remove("is-active");
  }
}
const regresar_form = () => {
  fetch('log.php')
  .then(response => response.text())
  .then(response =>{
    document.getElementById("login").innerHTML = response;
  });
}
const recuperar_form= () => {
  fetch('recuperar.php')
  .then(response => response.text())
  .then(response => {
    document.getElementById("login").innerHTML = response;
  });
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
