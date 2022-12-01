<?php

session_start();
require '../controlador/compruebaEmail.php';
require '../controlador/BbddConfig.php';
require 'compruebaEmail.php';

if (isset($_POST) && !compruebaEmail(htmlentities($_POST["email"]), $pdo)) {
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
        header("Location: ./home.php");

    } catch (PDOException $ex) {
        $pdo->rollBack();
        $_SESSION["mensajeError"] = 'Error: ' . $ex->getMessage();
        header("Location: ./registro.php"); // INSERCION DE DATOS INCORRECTO
    }

    // SI HI HA CAMPS DE INVITACIO I L'USUARI CORRESPON AMB EL TOKEM CONVIDAT REGISTRAL DIRECTAMENT A L'ACTIVITAT =============
    if (isset($_POST['a-id']) && isset($_POST['invitacion'])) {

        $a_id = $_POST['a-id'];
        $token = $_POST['invitacion'];

        // Consulta TOKEN existe
        try {
            $sql = "SELECT i_correoUsuarioInvitado FROM Invitaciones WHERE i_token = :i_token";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':i_token', $token);

            $stmt->execute();
            $correoInvitado = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo 'Error: ' . $ex->getMessage();
        }

        $correoInvitado = implode($correoInvitado);
        var_dump($correoInvitado);

        try {
            $sql = "SELECT u_id FROM usuarios WHERE u_correo = :u_correo;";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':u_correo', $correoInvitado);

            $stmt->execute();
            $idInvitado = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo 'Error: ' . $ex->getMessage();
        }

        $correoUsuario = $_POST["email"];
        var_dump($correoUsuario);

        $idInvitado = implode($idInvitado);
        var_dump($idInvitado);

        // Si el token introducido coincide con el mail correspondiente en la base de datos lo inserta
        if ($correoUsuario == $correoInvitado) {

            try {

                $sql = "INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) 
                            VALUES (:ua_idUsu, :ua_idAct)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':ua_idUsu', $idInvitado);
                $stmt->bindParam(':ua_idAct', $a_id);

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();

                $stmt->execute();

                $pdo->commit();

                header('Location: ' . $_SERVER['PHP_SELF'] . '?a_id=' . $a_id);
                die;
            } catch (PDOException $ex) {
                $pdo->rollBack();
                header('Location: ' . $_SERVER['PHP_SELF'] . '?a_id=' . $a_id);
                die;
            }
            unset($_GET["invitacion"]);
        }
        unset($_GET["invitacion"]);
        header("Location: ./home.php");
    }
} else {
    $_SESSION["mensajeError"] = "Usuario registrado correctamente";
    header("Location: ./login.php"); // INSERCION DE DATOS INCORRECTO
}

require 'compruebaEmail.php';