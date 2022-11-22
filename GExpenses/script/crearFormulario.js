function compruebaDatosForm() {
  let envio = true;

  const valorNombre = nombreActividad.value;
  const valorMoneda = monedaActividad.value;
  const valorDescripcion = descripcionActividad.value;

  if (valorNombre.length > 30) {
    nombreError.innerText = "EL CAMPO DEBE TENER MENOS DE 30 CARÁCTERES";
    nombreError.style.display = "block";
    envio = false;
  } else if (valorNombre.length === 0) {
    nombreError.innerText = "EL NOMBRE NO PUEDE ESTAR VACÍO";
    nombreError.style.display = "block";
    envio = false;
  } else {
    nombreError.style.display = "none";
  }

  if (valorMoneda !== "€" && valorMoneda !== "$") {
    envio = false;
  }

  if (valorDescripcion.length > 130) {
    descripcionError.style.display = "block";
    envio = false;
  } else {
    descripcionError.style.display = "none";
  }

  return envio ? true : false;
}

const abrirFormulario = document.querySelector("#addActivityButton");

const dialog = document.querySelector("#addActivityDialog");

const formulario = document.querySelector("#addActivity");
const aceptar = document.querySelector("#boton-aceptar");
const cancelar = document.querySelector("#cancelDialogForm");
const cancelarX = document.querySelector("#cancelarX");

const nombreActividad = document.querySelector("#nombreValue");
const monedaActividad = document.querySelector("#monedaValue");
const descripcionActividad = document.querySelector("#descripcionValue");

const descripcionError = document.querySelector("#descripcionError");
const nombreError = document.querySelector("#nombreError");

abrirFormulario.addEventListener("click", function (e) {
  e.preventDefault();

  nombreActividad.value = "";
  monedaActividad.value = "€";
  descripcionActividad.value = "";

  nombreError.style.display = "none";
  descripcionError.style.display = "none";

  dialog.showModal();
});

cancelar.addEventListener("click", function (e) {
  e.preventDefault();

  nombreActividad.value = "";
  monedaActividad.value = "€";
  descripcionActividad.value = "";

  nombreError.style.display = "none";
  descripcionError.style.display = "none";

  dialog.close("Dialogo cerrado");
});

cancelarX.addEventListener("click", function (e) {
  e.preventDefault();

  nombreActividad.value = "";
  monedaActividad.value = "€";
  descripcionActividad.value = "";

  nombreError.style.display = "none";
  descripcionError.style.display = "none";

  dialog.close("Dialogo cerrado");
});

aceptar.addEventListener("click", function (e) {
  e.preventDefault();

  if (compruebaDatosForm()) {
    nombreError.style.display = "none";
    descripcionError.style.display = "none";
    formulario.submit();
  }
});
