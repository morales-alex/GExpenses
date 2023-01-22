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

        // Si el login es valido comprueba si hay invitación, si la hay inserta en actividad
        // SI HI HA CAMPS DE INVITACIO I L'USUARI CORRESPON AMB EL TOKEM CONVIDAT REGISTRAL DIRECTAMENT A L'ACTIVITAT =============
        if (!empty($_POST['a-id']) && !empty($_POST['invitacion'])) {
            procesarInvitacion();
        }
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


function procesarInvitacion() {

    require '../controlador/BbddConfig.php';

    $a_id = $_POST['a-id'];
    $token = $_POST['invitacion'];
    $correoUsuario = $_SESSION["usuario"]->getU_correo();

        // Consulta TOKEN existe
        try {
            $sql = "SELECT i_correoUsuarioInvitado, u_id
                        FROM Invitaciones
                            INNER JOIN Usuarios ON Usuarios.u_correo = Invitaciones.i_correoUsuarioInvitado 
                    WHERE i_token = :i_token AND DATE_ADD(i_fecinv, INTERVAL +3 MINUTE) > sysdate()"; // LA INVITACION CADUCA EN 3 MINUTOS
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

            $_SESSION["mensajeError"] = '¡Enhorabuena! Te has unido a la actividad satisfactoriamente!';

        } catch (PDOException $ex) {
            $pdo->rollBack();
            $_SESSION["mensajeError"] = '¡Cuidado! No te has podido unir a la actividad porque ha caducado!';
            echo 'Error: ' . $ex->getMessage();
        }
    } else {
        $_SESSION["mensajeError"] = '¡Cuidado! No te has podido unir a la actividad!';
    }
}
