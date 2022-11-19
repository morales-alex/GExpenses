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
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
                    </div>
                    <div class="row">
                        <input type="submit" class="btn-login" name="login" value="Iniciar sesión">

                        <?php
                        
                        session_start();
                        
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