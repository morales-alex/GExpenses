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
                <form id="">
                    <div class="row">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" placeholder="Introduzca usuario o correo electrónico">
                    </div>
                    <div class="row">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" placeholder="Escriba su contraseña">
                    </div>
                    <div class="row">
                        <button class="btn-login" type="submit">Iniciar sessión</button>
                    </div>
                </form>

                <div id="no-registrado">
                    <div class="row">
                        <p>¿No tienes una cuenta?</p>
                        <a class="btn" href="#">Registrate aqui</a>
                    </div>
                </div>
            </div>            

            <!--<div id="formulario">
                <h2 class="center">Registro</h2>
                <form id="">
                    <div class="row-registro">
                        <div class="col">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" placeholder="Escriba su nombre">
                        </div>
                        <div class="col">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" id="apellidos" placeholder="Escriba sus apellidos">
                        </div>
                    </div>
                    <div class="row-registro">
                        <div class="col">
                            <label for="usuario">Usuario</label>
                            <input type="text" id="usuario" placeholder="Escriba su nombre de usuario">
                        </div>
                        <div class="col">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" placeholder="Escriba su correo eletrónico">
                        </div>
                    </div>
                    <div class="row-registro">
                        <div class="col">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" placeholder="Escriba su contraseña">
                        </div>
                        <div class="col">
                            <label for="password-confirm">Repetir contraseña</label>
                            <input type="password" id="password-confirm" placeholder="Confirme su contraseña">
                        </div>
                    </div>


                    <div class="row">
                        <button class="btn-login" type="submit">Iniciar sessión</button>
                    </div>
                </form>

                <div id="no-registrado">
                    <div class="row">
                        <p>¿Ya tienes cuenta?</p>
                        <a class="btn" href="#">Iniciar sesión</a>
                    </div>
                </div>
            </div>-->

            <!--
            <div>
                <div id="formulario" class="landing">
                    <div class="row"><button class="btn-login">Iniciar sesión</button></div>
                    <div class="row"><button class="btn-registro">Registrate</button></div>
                </div>
                
            </div>
-->

        </div>
    </div>
</body>

</html>