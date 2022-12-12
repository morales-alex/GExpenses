// Verifica que el password es seguro, debe contener mayuscula, minuscula, simbolo y numero
const validarPassword = () => {
    var regexPassword = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!#.$%&'@*+/=?])");
    var comprovacionPassword = regexPassword.test(passwordInput.value);

    if (comprovacionPassword == true) {
        console.log("Password vàlid");
        passwordInput.nextElementSibling.classList.remove("mostrar");
        return true;
    } else {
        passwordInput.nextElementSibling.classList.add("mostrar");
    }
}

// Confirma que los dos password sean iguales
const confirmarPassword = () => {
    if (passwordInput.value == confirmarPasswordInput.value) {
        console.log("Passowrd ok");
        confirmarPasswordInput.nextElementSibling.classList.remove("mostrar");
        return true;
    } else {
        console.log("Passowrd NO ok");
        confirmarPasswordInput.nextElementSibling.classList.add("mostrar");
    }
}

// Validar que el email és un email correcte
function validarEmail() {
    var mailformato = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (emailInput.value.match(mailformato)) {
        console.log("Correo eletrónico valido");
        emailInput.nextElementSibling.classList.remove("mostrar");
        return true;
    }
    else {
        console.log("Correo eletrónico NO valido");
        emailInput.nextElementSibling.classList.add("mostrar");
    }
}

// Validar que haya minimo dos apellidos y no contengan caracteres inválidos
function validarApellidos() {
    var apellidosformato = /^[a-zA-Z]+( [a-zA-Z]+)+$/;
    if (apellidosInput.value.match(apellidosformato)) {
        console.log("Apellidos validos");
        apellidosInput.nextElementSibling.classList.remove("mostrar");
        return true;
    }
    else {
        console.log("Apellido NO validos");
        apellidosInput.nextElementSibling.classList.add("mostrar");
    }
}

// Validamos que haya un nombre sin caracteres invalidos
function validarNombre() {
    var nombreformato = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
    if (nombreInput.value.match(nombreformato)) {
        console.log("Nombre valido");
        nombreInput.nextElementSibling.classList.remove("mostrar");
        return true;
    }
    else {
        console.log("Nombre NO valido");
        nombreInput.nextElementSibling.classList.add("mostrar");
    }
}

// Validamos usuario
function validarUsuario() {
    var usuarioformato = /^[A-Za-z][A-Za-z0-9_]{4,30}$/;
    if (usuarioInput.value.match(usuarioformato)) {
        console.log("Ususario valido");
        usuarioInput.nextElementSibling.classList.remove("mostrar");
        return true;
    }
    else {
        console.log("Usuario NO valido");
        usuarioInput.nextElementSibling.classList.add("mostrar");
    }
}

function validarRegistro() {

    if (validarNombre() && validarApellidos() && validarUsuario() && validarEmail() && validarPassword() && confirmarPassword()) {
        console.log("Todos campos OK");
        return true;
    } else {
        return false;
    }
}

const passwordInput = document.querySelector("#password");
const confirmarPasswordInput = document.querySelector("#password-confirm");
const emailInput = document.querySelector("#email");
const apellidosInput = document.querySelector("#apellidos");
const nombreInput = document.querySelector("#nombre");
const usuarioInput = document.querySelector("#usuario");
const formulario = document.querySelector("#formulario");

passwordInput.addEventListener('focusout', validarPassword);
confirmarPasswordInput.addEventListener('focusout', confirmarPassword);
emailInput.addEventListener('focusout', validarEmail);
apellidosInput.addEventListener('focusout', validarApellidos);
nombreInput.addEventListener('focusout', validarNombre);
usuarioInput.addEventListener('focusout', validarUsuario);
//formulario.addEventListener('submit', validarRegistro);

formulario.addEventListener('submit', function (e) {
    e.preventDefault();
    console.log(validarEmail());

    if (validarRegistro()) {
        formulario.submit();
    }
});