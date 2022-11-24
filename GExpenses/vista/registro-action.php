<?php

session_start();


if (isset($_POST) && !compruebaEmail(htmlentities($_POST["email"]))) {

    require '../controlador/BbddConfig.php';

    $password_hasheado = htmlentities($_POST["password"]);

    $dades = [htmlentities($_POST["usuario"]), htmlentities($_POST["nombre"]), htmlentities($_POST["apellidos"]), htmlentities($_POST["email"]), password_hash($password_hasheado, PASSWORD_DEFAULT)];

    try {
        $sql = "INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) 
                        VALUES (:u_username, :u_nombre, :u_apellidos, :u_correo, :u_password)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':u_username', $dades[0]);
        $stmt->bindParam(':u_nombre', $dades[1]);
        $stmt->bindParam(':u_apellidos', $dades[2]);
        $stmt->bindParam(':u_correo', $dades[3]);
        $stmt->bindParam(':u_password', $dades[4]);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();

        $stmt->execute();

        $pdo->commit();
        $_SESSION["mensajeError"] = "Usuario registrado correctamente!";
        header("Location: ./login.php"); // INSERCION DE DATOS INCORRECTA

    } catch (PDOException $ex) {
        $pdo->rollBack();
        $_SESSION["mensajeError"] = 'Error: ' . $ex->getMessage();
        header("Location: ./registro.php"); // INSERCION DE DATOS INCORRECTO
    } finally {
        $pdo = null;
    }
} else {
    $_SESSION["mensajeError"] = "Error: Este correo electrónico ya está registrado";
    header("Location: ./registro.php"); // INSERCION DE DATOS INCORRECTO
}

function compruebaEmail($correo) {

    require '../controlador/BbddConfig.php';

    try {
        $sql = "SELECT u_correo FROM Usuarios where u_correo = :u_correo";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':u_correo', $correo);

        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($datos == false) {
            return false;
        } else {
            return true;
        }
    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
}
