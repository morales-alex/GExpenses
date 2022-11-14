<?php

session_start();

if (isset($_POST["login"])) {


    if (compruebaUsuario(htmlentities($_POST["usuario"]), htmlentities($_POST["password"]))) {

        $_SESSION["mensajeError"] = null;
        header("Location: ./home.php"); // LOGIN CORRECTO
    } else {

        $_SESSION["mensajeError"] = "Credenciales Inválidos!";
        header("Location: ./login.php"); // LOGIN INCORRECTO
    }
}


function compruebaUsuario($username, $password) {

    require '../controlador/BbddConfig.php';

    try {
        $sql = "SELECT u_username, u_correo, u_password FROM Usuarios where (u_username = :u_username OR u_correo = :u_correo) AND u_password = :u_password";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':u_username', $username);
        $stmt->bindParam(':u_correo', $username);
        $stmt->bindParam(':u_password', $password);

        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    if (($username === $datos['u_username'] or $username === $datos['u_correo']) and $password === $datos['u_password']) {
        return true;
    } else {
        return false;
    }

    $pdo = null;


}
