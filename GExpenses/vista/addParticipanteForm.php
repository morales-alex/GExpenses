<dialog id='addParticipanteDialog' class="dialogForm centered" close>
    <div id="dialog-activityForm" class="dialog-header">
        <h5>Añadir actividad</h5>
        <span id='cancelarX'>x</span>
    </div>
    <form method="post" action="actividad-action.php" id="addActivity">
        <label for="nombre">Correo Electrónico:</label>
        <input type="text" name="nombre" id="nombreValue" required>
        
        <p id='nombreError' class='error-messageForm'>EL CAMPO DEBE TENER MENOS DE 30 CARÁCTERES</p>
        <label for="descripcion">Invitaciones:</label>

        <p id='descripcionError' class='error-messageForm'>LA DESCRIPCIÓN DEBE TENER MENOS DE 130 CARÁCTERES</p>

        <div class="dialog-footer">
            <input type="button" class="boton-aceptar" value="Cerrar" id="cancelDialogForm"></input>
            <input type="submit" name="enviar" value="Enviar" id="boton-aceptar" class="boton-aceptar">
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