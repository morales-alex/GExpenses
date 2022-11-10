<?php

if (isset($_POST["login"])) {

    session_start();
    $username = htmlentities($_POST["usuario"]);
    $password = htmlentities($_POST["password"]);

    if (compruebaUsuario($username, $password)) {

        $_SESSION["mensajeError"] = null;
        header("Location: ./index.php"); // LOGIN CORRECTO
    } else {

        $_SESSION["mensajeError"] = "Credenciales Inválidos!";
        header("Location: ./login.php"); // LOGIN INCORRECTO
    }
}


function compruebaUsuario($username, $password) {

    require '../controlador/BbddConfig.php';

    try {
        $sql = "SELECT TOP 1 u_username, u_correo, u_password FROM Usuarios where u_username = '$username' OR u_correo = '$username' AND u_password = '$password'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    if ($username === $datos['u_username'] or $username === $datos['u_correo'] and $password === $datos['u_password']) {
        return true;
    } else {
        return false;
    }
}
