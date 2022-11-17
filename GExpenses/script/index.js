const addActivityButton = document.getElementById('addActivity');

const dialog = document.getElementById('addActivityDialog');

const aceptar = document.getElementById('addActivityForm');
const cancelar = document.getElementById('cancelDialogForm');

addActivityButton.addEventListener("click", function(e) {
    e.preventDefault();

    const dialog = document.getElementById('addActivityDialog');

    dialog.showModal();
});

cancelar.addEventListener("click", function(e) {
    e.preventDefault();

    dialog.close('Dialogo cerrado');
});


aceptar.addEventListener("click", function(e) {
    e.preventDefault();

    console.log('datos formulario');
});







// const cerrar = document.querySelector('html');

// cerrar.addEventListener('click', function(e) {
//     e.preventDefault();

//     console.log(e.target);
// });