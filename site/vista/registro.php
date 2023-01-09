<?php

$registroConInvitacion = false;

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

    if (isset($_GET['a_id']) && isset($_GET['invitacion'])) {
        $a_id = $_GET['a_id'];
        $invitacion = $_GET['invitacion'];
        $registroConInvitacion = true;
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro</title>
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


                <div>
                    <h2 class="center">Registro</h2>
                    <form method="post" id="formulario" action="registro-action.php">
                        <div class="row-registro">
                            <div class="col">
                                <label for="nombre">Nombre<div class="tooltip">?
                                        <span class="tooltiptext">Debe contener una letra como mínimo</span>
                                    </div></label>
                                <input type="text" id="nombre" name="nombre" placeholder="Mombre">
                            </div>
                            <div class="col">
                                <label for="apellidos">Apellidos <div class="tooltip">?
                                        <span class="tooltiptext">Debes introducir los dos apellidos.</span>
                                    </div></label>
                                <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos">
                            </div>
                        </div>
                        <div class="row-registro">
                            <div class="col">
                                <label for="usuario">Usuario <div class="tooltip">?
                                        <span class="tooltiptext">El usuario debe contener 5 caracteres como mínimo</span>
                                    </div></label>
                                <input type="text" id="usuario" name="usuario" placeholder="Usuario">

                                <div class="usernameExists">
                                    <?php
                                    if (isset($_SESSION['err']['USERNAME_EXISTS'])) {
                                    ?>
                                        Ese usuario ya existe!
                                    <?php
                                        unset($_SESSION['err']['USERNAME_EXISTS']);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col">
                                <label for="email">Correo electrónico <div class="tooltip">?
                                        <span class="tooltiptext">El correo debe tener un formato válido </span>
                                    </div></label>
                                <input type="email" id="email" name="email" placeholder="Correo eletrónico">
                                <div class="mailExists">
                                    <?php
                                    if (isset($_SESSION['err']['MAIL_EXISTS'])) {
                                    ?>
                                        Ese correo ya existe!
                                    <?php
                                        unset($_SESSION['err']['MAIL_EXISTS']);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row-registro">
                            <div class="col">
                                <label for="password">Contraseña <div class="tooltip">?
                                        <span class="tooltiptext">Debe incluir letras minusculas, mayusculas, números y alguno de los siguientes simbolos: !#.$%@&'*+/=? </span>
                                    </div></label>
                                <input type="password" id="password" name="password" placeholder="Contraseña">
                            </div>
                            <div class="col">
                                <label for="password-confirm">Repetir contraseña <div class="tooltip">?
                                        <span class="tooltiptext">Las dos contraseñas deben coincidir </span>
                                    </div></label>
                                <input type="password" id="password-confirm" name="password-confirm" placeholder="Confirmar contraseña">
                            </div>

                            <input type="hidden" id="a-id" name="a-id" value="<?= $registroConInvitacion ? $a_id : null ?>">
                            <input type="hidden" id="invitacion" name="invitacion" value="<?= $registroConInvitacion ? $invitacion : null ?>">

                        </div>


                        <div class="row">
                            <button class="btn-login" type="submit">Registrarse</button>
                        </div>
                        <?php



                        if (isset($_SESSION["mensajeError"])) {
                        ?>
                            <div class="error-message"><?php echo $_SESSION["mensajeError"]; ?></div>
                        <?php
                            unset($_SESSION["mensajeError"]);
                        }
                        ?>
                    </form>

                    <div id="no-registrado">
                        <div class="row">
                            <p>¿Ya tienes cuenta?</p>
                            <a class="btn" href="index.php">Iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="../script/registro.js"></script>

    </html>


<?php

}
