const abrirFormulariBalance = document.querySelector(".balance");
const balanceDialog = document.querySelector("#balanceDialog");
const xBalance = document.querySelector("#xBalance");
const valoresBalance = document.querySelectorAll('.importe-balance');

valoresBalance.forEach((valorBalance) => {
  //  console.log(parseInt(valorBalance.textContent));

  if (parseInt(valorBalance.textContent) > 0) {
    valorBalance.innerHTML = '+' + valorBalance.textContent;
    valorBalance.setAttribute('class', 'positivo');
  } else if (parseInt(valorBalance.textContent) < 0) {
    valorBalance.setAttribute('class', 'negativo');
  } else {
    valorBalance.setAttribute('class', 'cero');
  }
});

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