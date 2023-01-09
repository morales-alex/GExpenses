const abrirFormulariBalance = document.querySelector(".balance");
const balanceDialog = document.querySelector("#balanceDialog");

abrirFormulariBalance.addEventListener("click", function (e) {
    e.preventDefault();
  
    /*nombreActividad.value = "";*/
  
    nombreError.style.display = "none";
  
    balanceDialog.showModal();
  });