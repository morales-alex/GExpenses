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
  
  const correos = [];

  const abrirFormulario = document.querySelector("#addParticipantes");
  
  const dialog = document.querySelector("#addParticipanteDialog");
  
  const formulario = document.querySelector("#addParticipantes");
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
  