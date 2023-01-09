// Verifica que el password es seguro, debe contener mayuscula, minuscula, simbolo y numero
const validarPassword = () => {
  var regexPassword = new RegExp(
    "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!#.$%&'@*+/=?])"
  );
  var comprovacionPassword = regexPassword.test(passwordInput.value);

  if (comprovacionPassword) {
    passwordInput.setAttribute("style", "border-color:black;");
    return true;
  } else {
    passwordInput.setAttribute("style", "border-color:red;");
  }
};

// Confirma que los dos password sean iguales
const confirmarPassword = () => {
  var regexPassword = new RegExp(
    "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!#.$%&'@*+/=?])"
  );
  var comprovacionPassword = regexPassword.test(confirmarPasswordInput.value);

  if (
    passwordInput.value == confirmarPasswordInput.value &&
    comprovacionPassword
  ) {
    confirmarPasswordInput.setAttribute("style", "border-color:black;");
    return true;
  } else {
    confirmarPasswordInput.setAttribute("style", "border-color:red;");
  }
};

// Validar que el email és un email correcte
function validarEmail() {
  mailExists.style.display = "none";

  var mailformato = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (emailInput.value.match(mailformato)) {
    emailInput.setAttribute("style", "border-color:black;");
    return true;
  } else {
    emailInput.setAttribute("style", "border-color:red;");
  }
}

// Validar que haya minimo dos apellidos y no contengan caracteres inválidos
function validarApellidos() {
  var apellidosformato = /^[a-zA-Z]+( [a-zA-Z]+)+$/;
  if (apellidosInput.value.match(apellidosformato)) {
    apellidosInput.setAttribute("style", "border-color:black;");
    return true;
  } else {
    apellidosInput.setAttribute("style", "border-color:red;");
  }
}

// Validamos que haya un nombre sin caracteres invalidos
function validarNombre() {
  var nombreformato = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
  if (nombreInput.value.match(nombreformato)) {
    nombreInput.setAttribute("style", "border-color:black;");
    return true;
  } else {
    nombreInput.setAttribute("style", "border-color:red;");
  }
}

// Validamos usuario
function validarUsuario() {
  usernameExists.style.display = "none";

  var usuarioformato = /^[A-Za-z][A-Za-z0-9_]{4,30}$/;
  if (usuarioInput.value.match(usuarioformato)) {
    usuarioInput.setAttribute("style", "border-color:black;");
    return true;
  } else {
    usuarioInput.setAttribute("style", "border-color:red;");
  }
}

function validarRegistro() {
  if (
    validarNombre() &&
    validarApellidos() &&
    validarUsuario() &&
    validarEmail() &&
    validarPassword() &&
    confirmarPassword()
  ) {
    return true;
  } else {
    return false;
  }
}

const passwordInput = document.querySelector("#password");
const confirmarPasswordInput = document.querySelector("#password-confirm");
const emailInput = document.querySelector("#email");

const mailExists = document.querySelector(".mailExists");

const apellidosInput = document.querySelector("#apellidos");
const nombreInput = document.querySelector("#nombre");
const usuarioInput = document.querySelector("#usuario");

const usernameExists = document.querySelector(".usernameExists");

const formulario = document.querySelector("#formulario");

passwordInput.addEventListener("focusout", validarPassword);
confirmarPasswordInput.addEventListener("focusout", confirmarPassword);
emailInput.addEventListener("focusout", validarEmail);
apellidosInput.addEventListener("focusout", validarApellidos);
nombreInput.addEventListener("focusout", validarNombre);
usuarioInput.addEventListener("focusout", validarUsuario);

formulario.addEventListener("submit", function (e) {

    e.preventDefault();

  if (validarRegistro()) {
    formulario.submit();
  } else {
    usernameExists.style.display = "none";
    mailExists.style.display = "none";
  }
});
