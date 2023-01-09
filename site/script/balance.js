const abrirFormulariBalance = document.querySelector(".balance");
const balanceDialog = document.querySelector("#balanceDialog");
const xBalance = document.querySelector("#xBalance");

abrirFormulariBalance.addEventListener("click", function (e) {
    e.preventDefault();
  
    /*nombreActividad.value = "";*/
  
    nombreError.style.display = "none";
  
    balanceDialog.showModal();
  });

  xBalance.addEventListener("click", function (e) {
    e.preventDefault();
  
    nombreActividad.value = "";
  
    nombreError.style.display = "none";
  
    balanceDialog.close("Dialogo cerrado");
  });