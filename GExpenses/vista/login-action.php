<?php

require '../modelo/usuariosMap.php';

if (!empty($_POST["login"])) {

    session_start();
    $username = $_POST["usuario"];
    $password = $_POST["password"];

    if ($username === '123' and $password === '123') {

        $_SESSION["mensajeError"] = null;
        header("Location: ./index.php"); // LOGIN CORRECTO
    } else {

        $_SESSION["mensajeError"] = "Credenciales Inválidos!";
        header("Location: ./login.php"); // LOGIN INCORRECTO
    }
}
