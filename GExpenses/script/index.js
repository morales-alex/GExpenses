const addActivityButton = document.getElementById('addActivityButton');

const dialog = document.getElementById('addActivityDialog');
const aceptar = document.getElementById('addActivityForm');

const cancelar = document.getElementById('cancelDialogForm');
const cancelarX = document.getElementById('cancelarX');


addActivityButton.addEventListener("click", function(e) {
    e.preventDefault();

    const dialog = document.getElementById('addActivityDialog');

    dialog.showModal();
});





cancelar.addEventListener("click", function(e) {
    e.preventDefault();

    dialog.close('Dialogo cerrado');
});
cancelarX.addEventListener("click", function(e) {
    e.preventDefault();

    dialog.close('Dialogo cerrado');
});


const cerrar = document.querySelector('html');

cerrar.addEventListener('click', function(e) {
    e.preventDefault();

    console.log(e.target);
});

// aceptar.addEventListener("click", function(e) {
//     e.preventDefault();

//     console.log('datos formulario');
// });







