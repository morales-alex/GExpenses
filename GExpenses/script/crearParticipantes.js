function validarEmail(email) {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

function compruebaDatosForm() {
  let envio = true;

  const valorNombre = nombreActividad.value;

  if (valorNombre.length > 30) {
    nombreError.innerText = "EL FORMATO DEL CORREO NO ES VÁLIDO";
    nombreError.style.display = "block";
    envio = false;
  } else if (valorNombre.length === 0) {
    nombreError.innerText = "EL NOMBRE NO PUEDE ESTAR VACÍO";
    nombreError.style.display = "block";
    envio = false;
  } else {
    nombreError.style.display = "none";
  }

  return envio ? true : false;
}

function addCorreoParticipante() {
  if (!validarEmail(nombreActividad.value)) {
    nombreError.innerText = "EL FORMATO DEL CORREO NO ES VÁLIDO";
    nombreError.style.display = "block";
  } else if (correos.includes(nombreActividad.value)) {
    nombreError.innerText = "YA HAS AÑADIDO ESE CORREO";
    nombreError.style.display = "block";
  } else {
    const box = document.querySelector("#correoInvitaciones");

    const correoWrapper = document.createElement("div");
    correoWrapper.setAttribute("id", "correoInvWrapper");

    const nombreCorreo = document.createElement("div");
    nombreCorreo.setAttribute("id", "correo");

    nombreCorreo.innerText = nombreActividad.value;

    const deleteCorreo = document.createElement("input");
    deleteCorreo.setAttribute("type", "button");
    deleteCorreo.setAttribute("id", "deleteCorreo");
    deleteCorreo.setAttribute("value", "Eliminar");

    correoWrapper.appendChild(nombreCorreo);
    correoWrapper.appendChild(deleteCorreo);

    box.appendChild(correoWrapper);

    correos.push(nombreActividad.value);
  }
}

const correos = [];

const abrirFormulario = document.querySelector("#addParticipantes");

const dialog = document.querySelector("#addParticipanteDialog");

const formulario = document.querySelector("#addParticipantes");

const addParticipante = document.querySelector("#addCorreo");

const deleteParticipante = document.querySelector("#correoInvitaciones");

const aceptar = document.querySelector("#boton-aceptar");
const cancelar = document.querySelector("#cancelDialogForm");
const cancelarX = document.querySelector("#cancelarX");

const nombreActividad = document.querySelector("#nombreValue");

const nombreError = document.querySelector("#nombreError");

abrirFormulario.addEventListener("click", function (e) {
  e.preventDefault();

  nombreActividad.value = "";

  nombreError.style.display = "none";

  dialog.showModal();
});

addParticipante.addEventListener("click", function (e) {
  e.preventDefault();

  addCorreoParticipante();
});

deleteParticipante.addEventListener("click", function (e) {
  e.preventDefault();
  if (e.target.id == "deleteCorreo") {
    e.target.parentElement.remove();

    var index = correos.indexOf(e.target.parentNode.firstChild.innerText);

    if (index != -1) {
      correos.splice(index, 1);
    }
  }
});

cancelar.addEventListener("click", function (e) {
  e.preventDefault();

  nombreActividad.value = "";

  nombreError.style.display = "none";

  dialog.close("Dialogo cerrado");
});

cancelarX.addEventListener("click", function (e) {
  e.preventDefault();

  nombreActividad.value = "";

  nombreError.style.display = "none";

  dialog.close("Dialogo cerrado");
});

aceptar.addEventListener("click", function (e) {
  e.preventDefault();

  if (compruebaDatosForm()) {
    nombreError.style.display = "none";
    formulario.submit();
  }
});
