<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <div>
        <form action="login-action.php" method="post" id="frmLogin">
            <div class="login-form-container">

                <div class="form-head">Login</div>
                <?php

                session_start();

                if (isset($_SESSION["mensajeError"])) {
                ?>
                    <div class="error-message"><?php echo $_SESSION["mensajeError"]; ?></div>
                <?php
                    unset($_SESSION["mensajeError"]);
                }
                ?>
                <div class="field-column">
                    <div>
                        <label for="username">Username</label><span id="user_info" class="error-info"></span>
                    </div>
                    <div>
                        <input name="user_name" id="user_name" type="text" class="demo-input-box" placeholder="Introduce Usuario o Contraseña">
                    </div>
                </div>
                <div class="field-column">
                    <div>
                        <label for="password">Password</label><span id="password_info" class="error-info"></span>
                    </div>
                    <div>
                        <input name="password" id="password" type="password" class="demo-input-box" placeholder="Introduce Contraseña">
                    </div>
                </div>
                <div class=field-column>
                    <div>
                        <input type="submit" name="login" value="Login" class="btnLogin"></span>
                    </div>
                </div>

            </div>
        </form>
    </div>

</body>

</html>