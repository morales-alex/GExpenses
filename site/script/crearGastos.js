function addGastos() {
  let gastoValido = true;
  const concepto = document.querySelector("#conceptoValue").value;

  if (concepto.length > 50) {
    gastoValido = false;
    errorConcepto.style.display = "block";
  } else if (concepto.length <= 0) {
    gastoValido = false;
    errorConcepto.style.display = "block";
  } else {
    errorConcepto.style.display = "none";
  }

  let suma = 0;
  const total = parseFloat(precioTotal.value);

  aPagar.forEach((pago) => {
    suma += parseFloat(pago.value);
  });

  if (suma < total || suma > total + 0.02) {
    gastoValido = false;
    errorCuantias.style.display = "block";
  } else {
    errorCuantias.style.display = "none";
  }

  return gastoValido;
}

const formularioGasto = document.querySelector("#addGastoForm");

const errorConcepto = document.querySelector("#nombreErrorConcepto");
const errorCuantias = document.querySelector("#nombreErrorCuantias");

const abrirFormularioGastos = document.querySelector("#addGasto");
const dialogGastos = document.querySelector("#addGastoDialog");

const addGasto = document.querySelector("#boton-aceptar-gastos");
const cancelarGastos = document.querySelector("#cancelGastoForm");
const cancelarXGastos = document.querySelector("#cancelarGastoX");

const precioTotal = document.querySelector(".cuantia");

abrirFormularioGastos.addEventListener("click", function (e) {
  e.preventDefault();

  dialogGastos.showModal();
});

cancelarGastos.addEventListener("click", function (e) {
  e.preventDefault();

  errorConcepto.style.display = "none";
  errorCuantias.style.display = "none";

  dialogGastos.close("Dialogo cerrado");
});

cancelarXGastos.addEventListener("click", function (e) {
  e.preventDefault();

  errorConcepto.style.display = "none";
  errorCuantias.style.display = "none";

  dialogGastos.close("Dialogo cerrado");
});

const aPagar = document.querySelectorAll(".paga");
const divididoEntre = aPagar.length;

precioTotal.addEventListener("keyup", (e) => {
  for (i = 0; i < aPagar.length; i++) {
    aPagar[i].value =
      Math.round((precioTotal.value / divididoEntre) * 100) / 100;
  }
});

addGasto.addEventListener("click", (e) => {
  // e.preventDefault();

  console.log(addGastos());

  if (addGastos()) {

    const conceptoPOST = document.querySelector("#conceptoValue").name = "conceptoGastoSencillo";

    errorConcepto.style.display = "none";
    errorCuantias.style.display = "none";

    formularioGasto.submit();

    conceptoPOST.name = "";
  }
});

