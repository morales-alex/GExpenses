<?php

require '../modelo/tablesMap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario'])) {

    if (isset($_GET['a_id']) && isset($_GET['invitacion'])) {
        procesarInvitacion();
    }
    header('Location: ./home.php');
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" type="image/x-icon" href="../img/LOGO_VENTANA.ico" />
    </head>

    <body>

        <div id="container">
            <div id="caja-principal">
                <div id="intro">
                    <h1>Bienvenido a <span class="negrita">GExpenses</span></h1>
                    <p>Con una flota de programadores a su espalda. GExpenses ha abierto sus puertas este año para todas los grupos de personas que quieran dividir sus gastos de manera fácil y sencilla.</p>
                    <span>Entre otras funcionalidades ofrecemos:</span>
                    <ul>
                        <li>Creación de actividades en las que se podrán añadir varios gastos.</li>
                        <li>Añadir/Quitar a tus amigos de una actividad.</li>
                        <li>Invitar a todos tus amigos en las actividades que participaréis.</li>
                        <li>Crear invitaciones por correo electrónico para poder agilizar todo el proceso.</li>
                    </ul>
                    

                </div>

                <div id="formulario">
                    <h2 class="center">Login</h2>
                    <form action="login-action.php" method="post" id="frmLogin">
                        <div class="row">
                            <label for="usuario">Usuario</label>
                            <input type="text" name="usuario" placeholder="Introduzca usuario o correo electrónico">
                        </div>
                        <div class="row">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" placeholder="Escriba su contraseña">

                            <?php
                            if (isset($_GET['a_id']) && isset($_GET['invitacion'])) {
                                $a_id = $_GET['a_id'];
                                $invitacion = $_GET['invitacion'];
                            ?>
                                <input type="hidden" id="a-id" name="a-id" value="<?= $a_id ?>">
                                <input type="hidden" id="invitacion" name="invitacion" value="<?= $invitacion ?>">
                            <?php
                            } ?>
                        </div>
                        <div class="row">
                            <input type="submit" class="btn-login" name="login" value="Iniciar sesión">

                            <?php

                            if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
                                SESSION_START();
                            }

                            if (isset($_SESSION["mensajeError"])) {
                            ?>
                                <div class="error-message"><?php echo $_SESSION["mensajeError"]; ?></div>
                            <?php
                                unset($_SESSION["mensajeError"]);
                            }
                            ?>
                        </div>
                    </form>

                    <div id="no-registrado">
                        <div class="row">
                            <p>¿No tienes una cuenta?</p>
                            <a class="btn" href="registro.php">Registrate aqui</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>

<?php

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

    $a_id = $_GET['a-id'];
    $token = $_GET['invitacion'];
    $correoUsuario = $_SESSION["usuario"]->getU_correo();

        // Consulta TOKEN existe
        try {
            $sql = "SELECT i_correoUsuarioInvitado, u_id, i_idAct
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
            $stmt->bindParam(':ua_idAct', $correoInvitado['i_idAct']);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            $stmt->execute();
            $pdo->commit();

            $_SESSION["mensajeError"] = '¡Enhorabuena! Te has unido a la actividad satisfactoriamente!';

        } catch (PDOException $ex) {
            $pdo->rollBack();
            $_SESSION["mensajeError"] = '¡Cuidado! Ha sucedido un error con la base de datos. Contacta con el soporte técnico.';
            echo 'Error: ' . $ex->getMessage();
        }
    } else {
        $_SESSION["mensajeError"] = '¡Cuidado! No te has podido unir a la actividad porque ha caducado!';
    }
}
