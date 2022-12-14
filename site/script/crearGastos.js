import {ValidacionCuantiaAvanzado} from '../script/validacionGastos.js'; //importacion de la classe
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

const formularioGasto = document.querySelector("#addGastos");

const errorConcepto = document.querySelector("#nombreErrorConcepto");
const errorCuantias = document.querySelector("#nombreErrorCuantias");

const abrirFormularioGastos = document.querySelector("#addGasto");
const dialogGastos = document.querySelector("#addGastoDialog");

const addGasto = document.querySelector("#boton-aceptar-gastos");
const cancelarGastos = document.querySelector("#cancelGastoForm");
const cancelarXGastos = document.querySelector("#cancelarGastoX");

const precioTotal = document.querySelector(".cuantia");

const aPagar = document.querySelectorAll(".paga");
const importeProporcional = document.querySelectorAll('.importeProporcional');
const importeLabelProporcional = document.querySelectorAll('.labelImporteProporcional');
const proporcionesForm = document.querySelectorAll('.gastosFormColProp');
const divididoEntre = aPagar.length;
const opcionDePago = document.querySelector("#opcionDePago");
let opcionSeleccionada;
let validacionCuantiaAvanzado;

function opcionAvanzadaLogica(){
  const inputs = Array.from(aPagar);
  validacionCuantiaAvanzado = new ValidacionCuantiaAvanzado(precioTotal.value);
  validacionCuantiaAvanzado.calcTotalSuma(inputs);
  validacionCuantiaAvanzado.logicaRetroaccionUsuario(addGasto);
}

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



const controladorGastos = () => {
  opcionSeleccionada = opcionDePago.value;

  if (opcionSeleccionada == 1) {
    opcionGeneral();
  } else if (opcionSeleccionada == 2) {
    opcionAvanzada();
  } else if (opcionSeleccionada == 3) {
    opcionProporcion();
  } else {
    console.info("Seleccionada invalida");
  }
}
opcionDePago.addEventListener("change", (e) => {
  e.preventDefault();
  controladorGastos();
});

precioTotal.addEventListener("keyup", (e) => {
  e.preventDefault();
  controladorGastos();
});



//  Divide entre partes iguales el importe del gasto
const opcionGeneral = () => {
  // Habilita todos los readonly del elemento "aPagar"
  [].forEach.call(aPagar, function (habilitarReadonly) {
    habilitarReadonly.setAttribute('readonly', true);
  });
  [].forEach.call(proporcionesForm, function (mostrarImporteProporcion) {
    mostrarImporteProporcion.style.display = 'none';
  });

  for (let i = 0; i < aPagar.length; i++) {
    aPagar[i].value =
      Math.round((precioTotal.value / divididoEntre) * 100) / 100;
  }
}

// Divide el importe del gasto a gusto del usuario
const opcionAvanzada = () => {
  // Deshabilita todos los readonly del elemento "aPagar"
  aPagar.forEach(inputs =>{
    inputs.removeAttribute('readonly');
  });
  proporcionesForm.forEach(mostrarImporteProporcion =>{
    mostrarImporteProporcion.style.display = 'none';
  });
}

// Divide el importe del gasto por proporciones
const opcionProporcion = () => {
  // Deshabilita todos los readonly del elemento "aPagar"
  [].forEach.call(aPagar, function (habilitarReadonly) {
    habilitarReadonly.setAttribute('readonly', true);
  });
  [].forEach.call(proporcionesForm, function (mostrarImporteProporcion) {
    mostrarImporteProporcion.style.display = 'flex';
  });

  let sumadorProporcions = 0;
  let proporcion = [];

  importeProporcional.forEach((valor, index) => {
    sumadorProporcions += parseInt(valor.value);
    proporcion[index] = parseInt(valor.value);
  });

  let numeroParticipantes = aPagar.length;

  aPagar.forEach((valor, index) => {
    valor.value = proporcion[index] / numeroParticipantes * precioTotal.value;
  });

}


aPagar.forEach(inputProporcion => {
  inputProporcion.addEventListener('keyup', (e) => {
    controladorGastos();
    
    opcionAvanzadaLogica();
  });
});


importeProporcional.forEach(valorProporcion => {
  valorProporcion.addEventListener('keyup', (e) => {
    controladorGastos();

  });
});


addGasto.addEventListener("click", (e) => {
   e.preventDefault();

  if (addGastos()) {

    const conceptoPOST = document.querySelector("#conceptoValue").name = "conceptoGastoSencillo";

    errorConcepto.style.display = "none";
    errorCuantias.style.display = "none";

    formularioGasto.submit();

    conceptoPOST.name = "";
  }
});

