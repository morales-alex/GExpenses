<?php

if (!empty($_POST["login"])) {

    session_start();
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    if (compruebaUsuario($username, $password)) {

        $_SESSION["mensajeError"] = null;
        header("Location: ./index.php"); // LOGIN CORRECTO
    } else {

        $_SESSION["mensajeError"] = "Credenciales Inválidos!";
        header("Location: ./login.php"); // LOGIN INCORRECTO
    }
}


function compruebaUsuario($username, $password)
{
    require '../modelo/usuariosMap.php';

    require '../controlador/BbddConfig.php';

    try {
        $sql = "SELECT TOP 1 u_username, u_password FROM Usuarios where u_username = '$username' AND u_password = '$password'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    if ($username === $datos['u_username'] and $password === $datos['u_password']) {
        return true;
    } else {
        return false;
    }
}
