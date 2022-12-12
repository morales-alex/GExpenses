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


function procesarInvitacion() {

    require '../controlador/BbddConfig.php';

    $a_id = $_GET['a_id'];
    $token = $_GET['invitacion'];

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

    try {
        $sql = "SELECT u_id FROM usuarios WHERE u_correo = :u_correo;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':u_correo', $correoInvitado);

        $stmt->execute();
        $idInvitado = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    $correoUsuario = $_SESSION["usuario"]->getU_correo();

    $idInvitado = implode($idInvitado);

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
        } catch (PDOException $ex) {
            $pdo->rollBack();

        }
    }
}