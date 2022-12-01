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
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Escriba su nombre">
                            <p class="error-messageForm">No has introducido un nombre valido</p>
                        </div>
                        <div class="col">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" id="apellidos" name="apellidos" placeholder="Escriba sus apellidos">
                            <p class="error-messageForm">No has introducido apellidos validos</p>
                        </div>
                    </div>
                    <div class="row-registro">
                        <div class="col">
                            <label for="usuario">Usuario</label>
                            <input type="text" id="usuario" name="usuario" placeholder="Escriba su nombre de usuario">
                            <p class="error-messageForm">No has introducido un usuario valido</p>
                        </div>
                        <div class="col">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" placeholder="Escriba su correo eletrónico">
                            <p class="error-messageForm">No has introducido un correo eletrónico valido</p>
                        </div>
                    </div>
                    <div class="row-registro">
                        <div class="col">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" placeholder="Escriba su contraseña">
                            <p class="error-messageForm">No has introducido una contraseña valida</p>
                        </div>
                        <div class="col">
                            <label for="password-confirm">Repetir contraseña</label>
                            <input type="password" id="password-confirm" name="password-confirm" placeholder="Confirme su contraseña">
                            <p class="error-messageForm">Las contraseñas no coinciden</p>
                        </div>
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