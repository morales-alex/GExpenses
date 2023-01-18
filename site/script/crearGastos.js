import { ValidacionCuantiaAvanzado } from '../script/validacionGastos.js'; //importacion de la classe

const formularioGasto = document.querySelector("#addGastos");

const errorConcepto = document.querySelector("#nombreErrorConcepto");
const errorCuantias = document.querySelector("#nombreErrorCuantias");

const abrirFormularioGastos = document.querySelector("#addGasto");
const dialogGastos = document.querySelector("#addGastoDialog");

const addGasto = document.querySelector("#boton-aceptar-gastos");
const cancelarGastos = document.querySelector("#cancelGastoForm");
const cancelarXGastos = document.querySelector("#cancelarGastoX");

const precioTotal = document.querySelector(".cuantia");
const errorDecimales = document.querySelector(".error-decimales");
const errorVacio = document.querySelector(".error-vacio");

const aPagar = document.querySelectorAll(".paga");
const importeProporcional = document.querySelectorAll('.importeProporcional');
const proporcionesForm = document.querySelectorAll('.gastosFormColProp');

const opcionDePago = document.querySelector("#opcionDePago");
const numeroParticipantes = aPagar.length;
let opcionSeleccionada;
let validacionCuantiaAvanzado;
let proporcion = [];

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

  if (suma + 0.02 < total || suma > total + 0.02) {
    gastoValido = false;
    errorCuantias.style.display = "block";
  } else if (total < 0) {
    gastoValido = false;
    errorCuantias.style.display = "block";
  } else {
    errorCuantias.style.display = "none";
  }

  return gastoValido;
}

function limpiarMensaje() {
  const div = document.getElementsByClassName('mensaje-dinamico-avanzado')[0];
  if (div) {
    div.remove();
  }
}
function opcionAvanzadaLogica() {
  limpiarMensaje();
  const inputs = Array.from(aPagar);
  validacionCuantiaAvanzado = new ValidacionCuantiaAvanzado(precioTotal.value);
  validacionCuantiaAvanzado.calcTotalSuma(inputs);
  const mensaje = validacionCuantiaAvanzado.logicaRetroaccionUsuario(addGasto);
  const div = document.createElement('div');
  if (typeof mensaje === 'string') {
    div.setAttribute('class', 'error-messageForm mensaje-dinamico-avanzado');
    div.style.display = "block";
    document.getElementsByClassName('cuantiaPorUsuario')[0].insertAdjacentElement('afterend', div)
    div.innerText = mensaje;
  }
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
  limpiarMensaje();
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
  validarDecimales();
});


/// VALIDAR ENTRADA DE 2 DECIMALES MAXIMO
const validarDecimales = () => {
  var regexDecimales = new RegExp(
    "^\-?[0-9]+(?:\.[0-9]{1,2})?$"
  );
  var comprovacionDecimales = regexDecimales.test(precioTotal.value);
  let vacio = document.querySelector('.cuantia').value;

  if (vacio == "") {
    precioTotal.setAttribute("style", "border-color:red;");
    errorVacio.setAttribute("style", "display: block;");
  } else {
    precioTotal.setAttribute("style", "border-color:black;");
    errorVacio.setAttribute("style", "display: none;");
    if (comprovacionDecimales) {
      precioTotal.setAttribute("style", "border-color:black;");
      errorDecimales.setAttribute("style", "display: none");
      return true;
    } else {
      precioTotal.setAttribute("style", "border-color:red;");
      errorDecimales.setAttribute("style", "display: block");
    }
  }
};

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
      Math.round((precioTotal.value / numeroParticipantes) * 100) / 100;
  }
}

// Divide el importe del gasto a gusto del usuario
const opcionAvanzada = () => {
  // Deshabilita todos los readonly del elemento "aPagar"
  aPagar.forEach(inputs => {
    inputs.removeAttribute('readonly');
  });
  proporcionesForm.forEach(mostrarImporteProporcion => {
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

  const valorCadaUnidad = precioTotal.value / sumadorProporcions

  aPagar.forEach((valor, index) => {
    valor.value = parseFloat((proporcion[index] * valorCadaUnidad)).toFixed(2);
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
  ;
  // PONERLO TIPO SUBMIT@@@@!!!
  e.preventDefault;


  if (addGastos()) {

    addGasto.name = "DatosEnviosCorrectos";
    errorConcepto.style.display = "none";
    errorCuantias.style.display = "none";

    formularioGasto.submit();
  }
});

// Girar fechas
const fecha = document.querySelectorAll(".fecha");
const fechaTitulo = document.querySelector(".fecha-titulo");

fechaTitulo.innerHTML = (fechaTitulo.innerText).split('-').reverse().join('-');

fecha.forEach(fechaValor => {
  let fechaGirada = (fechaValor.innerText).split('-').reverse().join('-');
  fechaValor.innerHTML = fechaGirada;
});

//
