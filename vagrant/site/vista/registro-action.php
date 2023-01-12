<?php

session_start();
require '../controlador/compruebaEmail.php';
require '../controlador/BbddConfig.php';
require '../modelo/tablesMap.php';

if (isset($_POST)) {

    $password_hasheado = htmlentities($_POST["password"]);
    $usuarioCorreoExiste = false;

    try {
        $sql = "SELECT u_username 
                    FROM Usuarios
                WHERE u_username = :u_username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':u_username', htmlentities($_POST["usuario"]));
        $stmt->execute();
        $usernameExists = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }


    try {
        $sql = "SELECT u_correo
                    FROM Usuarios
                WHERE u_correo = :u_correo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':u_correo', htmlentities($_POST["email"]));
        $stmt->execute();
        $correoExists = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    if ($usernameExists['u_username'] !== null && $correoExists['u_correo'] !== null) {

        $_SESSION['err']['USERNAME_EXISTS'] = 'Ya existe ese usuario. Prueba otro!';
        $_SESSION['err']['MAIL_EXISTS'] = 'Ya existe ese correo. Prueba otro!';

        $usuarioCorreoExiste = true;
    } else if ($usernameExists['u_username']) {

        $_SESSION['err']['USERNAME_EXISTS'] = 'Ya existe ese usuario. Prueba otro!';
        $usuarioCorreoExiste = true;
    } else if ($correoExists['u_correo']) {

        $_SESSION['err']['MAIL_EXISTS'] = 'Ya existe ese correo. Prueba otro!';
        $usuarioCorreoExiste = true;
    } else {


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


            try {
                $sql = "SELECT u_id
                        FROM Usuarios
                    WHERE u_username = :u_username;";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':u_username', $dades[0]);

                $stmt->execute();
                $idUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo 'Error: ' . $ex->getMessage();
            }

            session_unset();
            $_SESSION['usuario'] = new usuarios($idUsuario['u_id'], $_POST["usuario"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"]);

            $_SESSION["mensajeError"] = "¡Enhorabuena! Usuario registrado correctamente!";
        } catch (PDOException $ex) {
            $pdo->rollBack();
            $_SESSION["mensajeError"] = 'Error: ' . $ex->getMessage();
            header("Location: ./registro.php"); // INSERCION DE DATOS INCORRECTO
        }

        // SI HI HA CAMPS DE INVITACIO I L'USUARI CORRESPON AMB EL TOKEM CONVIDAT REGISTRAL DIRECTAMENT A L'ACTIVITAT =============
        if ($_POST['a-id'] !== '' && $_POST['invitacion'] !== '') {

            $a_id = $_POST['a-id'];
            $token = $_POST['invitacion'];
            $correoUsuario = $_POST["email"];
            $correoInvitado = null;

            // Consulta TOKEN existe
            try {
                $sql = "SELECT i_correoUsuarioInvitado, u_id
                        FROM Invitaciones
                            INNER JOIN Usuarios ON Usuarios.u_correo = Invitaciones.i_correoUsuarioInvitado 
                    WHERE i_token = :i_token AND DATE_ADD(i_fecinv, INTERVAL +1 MINUTE) > sysdate()"; // LA INVITACION CADUCA EN 2 MINUTOS
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':i_token', $token);

                $stmt->execute();
                $correoInvitado = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo 'Error: ' . $ex->getMessage();
            }


            // Si el token introducido coincide con el mail correspondiente en la base de datos lo inserta
            if ($correoUsuario == $correoInvitado['i_correoUsuarioInvitado']) {

                try {

                    $sql = "INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) 
                            VALUES (:ua_idUsu, :ua_idAct)";
                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':ua_idUsu', $correoInvitado['u_id']);
                    $stmt->bindParam(':ua_idAct', $a_id);

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->beginTransaction();

                    $stmt->execute();

                    $pdo->commit();

                    $_SESSION["mensajeError"] = $_SESSION["mensajeError"] . ' . Ha sido añadido a la actividad a la que has sido invitado!';
                } catch (PDOException $ex) {
                    $pdo->rollBack();
                    $_SESSION["mensajeError"] = 'Error: ' . $ex->getMessage();
                    header("Location: ./registro.php"); // INSERCION DE DATOS INCORRECTO

                }
                unset($_GET["invitacion"]);
            } else {
                $_SESSION["mensajeError"] = '¡Cuidado! Usuario registrado correctamente, pero lamentablemente no hemos podido añadirte a la actividad a la que has sido invitado.';
            }
            unset($_GET["invitacion"]);
        }
    }
}

if ($usuarioCorreoExiste) {
    header("Location: ./registro.php");
} else {
    header("Location: ./home.php");
}