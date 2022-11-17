<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <dialog id=addActivityDialog class="dialogForm centered" open>
        <h5>Añadir actividad</h5>
        <form method="post" action="actividad-action.php" id="addActivity">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <label for="moneda">Moneda:</label>
            <input type="text" name="moneda" required>
            <label for="descripcion">Descripción:</label>
            <textarea for="descripcion" name="descripcion"></textarea>
            <input type="submit" name="enviar" value="Enviar">
        </form>
        <?php

        session_start();

        if (isset($_SESSION["mensajeError"])) {
        ?>
            <div class="error-message"><?php echo $_SESSION["mensajeError"]; ?></div>
        <?php
            unset($_SESSION["mensajeError"]);
        }
        ?>
    </dialog>
</body>

</html>