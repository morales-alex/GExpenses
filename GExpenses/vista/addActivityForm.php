<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <dialog id=addActivityDialog class="dialogForm centered">
        <div id="dialog-activityForm" class="dialog-header">
            <h4>Añadir actividad</h4>
            <span>x</span>
        </div>
        <form method="post" action="actividad-action.php" id="addActivity">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <label for="moneda" >Moneda:</label>
            <input type="text" name="moneda" placeholder="€,$.."required>
            <label for="descripcion">Descripción:</label>
            <textarea for="descripcion" name="descripcion" placeholder="Definicion de la actividad..."></textarea>
            
        </form>
        <?php
        if (isset($_SESSION["mensajeError"])) {
        ?>
            <div class="error-message"><?php echo $_SESSION["mensajeError"]; ?></div>
        <?php
            unset($_SESSION["mensajeError"]);
        }
        ?>
    <div class="dialog-footer">
        <input type="button" class="boton-aceptar" value="Cerrar"></input>
        <input type="submit" name="enviar" value="Enviar" class="boton-aceptar">
        
      </div>
    </dialog>
</body>

</html>