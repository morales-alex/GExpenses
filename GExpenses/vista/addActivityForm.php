<dialog id='addActivityDialog' class="dialogForm centered" close>
    <div id="dialog-activityForm" class="dialog-header">
        <h5>Añadir actividad</h5>
        <span id='cancelarX'>x</span>
    </div>
    <form method="post" action="actividad-action.php" id="addActivity">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <label for="moneda">Moneda:</label>
        <input type="text" name="moneda" placeholder="€,$.." required>
        <label for="descripcion">Descripción:</label>
        <textarea for="descripcion" name="descripcion" placeholder="Definicion de la actividad..."></textarea>
        <div class="dialog-footer">
            <input type="button" class="boton-aceptar" value="Cerrar" id="cancelDialogForm"></input>
            <input type="submit" name="enviar" value="Enviar" class="boton-aceptar">

        </div>
    </form>
    <?php
    if (isset($_SESSION["mensajeError"])) {
    ?>
        <div class="error-message"><?php echo $_SESSION["mensajeError"]; ?></div>
    <?php
        unset($_SESSION["mensajeError"]);
    }
    ?>
</dialog>