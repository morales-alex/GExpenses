// Verifica que el password es seguro, debe contener mayuscula, minuscula, simbolo y numero
const validarPassword = () => {
    var regexPassword = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!#.$%&'*+/=?])");
    var comprovacionPassword = regexPassword.test(passwordInput.value);

    if (comprovacionPassword == true) {
        console.log("Password vàlid");
        return true;
    } else {
        console.log("Password invàlid");
    }
}

// Confirma que los dos password sean iguales
const confirmarPassword = () => {
    if (passwordInput.value == confirmarPasswordInput.value) {
        console.log("Los password son iguales");
        return true;
    } else {
        console.log("Los password no son iguales");
    }
}

// Validar que el email és un email correcte
function validarEmail() {
    var mailformato = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (emailInput.value.match(mailformato)) {
        console.log("Correo eletrónico valido");
        return true;
    }
    else {
        console.log("Correo eletrónico NO valido");
    }
}

// Validar que haya minimo dos apellidos y no contengan caracteres inválidos
function validarApellidos() {
    var apellidosformato = /^[a-zA-Z]+( [a-zA-Z]+)+$/;
    if (apellidosInput.value.match(apellidosformato)) {
        console.log("Apellidos validos");
        return true;
    }
    else {
        console.log("Apellido NO validos");
    }
}

// Validamos que haya un nombre sin caracteres invalidos
function validarNombre() {
    var nombreformato = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
    if (nombreInput.value.match(nombreformato)) {
        console.log("Nombre valido");
        return true;
    }
    else {
        console.log("Nombre NO valido");
    }
}

// Validamos usuario
function validarUsuario() {
    var usuarioformato = /^[A-Za-z][A-Za-z0-9_]{4,30}$/;
    if (usuarioInput.value.match(usuarioformato)) {
        console.log("Ususario valido");
        return true;
    }
    else {
        console.log("Usuario NO valido");
    }
}


const passwordInput = document.querySelector("#password");
const confirmarPasswordInput = document.querySelector("#password-confirm");
const emailInput = document.querySelector("#email");
const apellidosInput = document.querySelector("#apellidos");
const nombreInput = document.querySelector("#nombre");
const usuarioInput = document.querySelector("#usuario");
const formuario = document.querySelector("#formulario");

passwordInput.addEventListener('keyup', validarPassword);
confirmarPasswordInput.addEventListener('keyup', confirmarPassword);
emailInput.addEventListener('keyup', validarEmail);
apellidosInput.addEventListener('keyup', validarApellidos);
nombreInput.addEventListener('keyup', validarNombre);
usuarioInput.addEventListener('keyup', validarUsuario);
//formuario.addEventListener('submit', validarCampos);

formuario.addEventListener('submit', function(e) {
    e.preventDefault();

    console.log(validarEmail());

});