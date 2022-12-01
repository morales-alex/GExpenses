<?php

require '../modelo/tablesMap.php';

if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}


if (isset($_POST["login"])) {
    
    // AÑADIR EN EL REGISTRO.PHP
    //$passwordEncriptada = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (compruebaUsuario(htmlentities($_POST["usuario"]), htmlentities($_POST['password']))) {

        $_SESSION["mensajeError"] = null;
        header("Location: ./home.php"); // LOGIN CORRECTO

    } else {

        $_SESSION["mensajeError"] = "Credenciales Inválidos!";
        header("Location: ./index.php"); // LOGIN INCORRECTO
    }
} else {
    $_SESSION["mensajeError"] = "Credenciales Inválidos!";
    header("Location: ./index.php"); // LOGIN INCORRECTO
}

function compruebaUsuario($username, $password)
{

    require '../controlador/BbddConfig.php';

    try {
        $sql = "SELECT u_id, u_username, u_correo, u_password, u_nombre, u_apellidos FROM Usuarios where (u_username = :u_username OR u_correo = :u_correo)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':u_username', $username);
        $stmt->bindParam(':u_correo', $username);

        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();

    }

    if (($username === $datos['u_username'] or $username === $datos['u_correo']) AND password_verify($password, $datos['u_password'])
    ) {

        $_SESSION['usuario'] = new usuarios($datos['u_id'], $datos['u_username'], $datos['u_nombre'], $datos['u_apellidos'], $datos['u_correo']);

        return true;
    } else {
        return false;
    }

    $pdo = null;
}
