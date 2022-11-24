<dialog id='addParticipanteDialog' class="dialogForm centered" close>
    <div id="dialog-activityForm" class="dialog-header">
        <h5>Invitar Usuarios a la Actividad</h5>
        <span id='cancelarX'>x</span>
    </div>
    <form method="post" action="./test.php" id="addActivity" class="formAddParticipantes">

        <label for="nombre">Correo Electrónico:</label>
        <div id="addParticipante">
            <input type="text" id="nombreValue">
            <input type="button" value="Añadir" id="addCorreo">
        </div>



        <p id='nombreError' class='error-messageForm'>El formato de correo no es correcto...</p>
        <label for="descripcion">Invitaciones:</label>

        <div id="correoInvitaciones">

            <div id="dialogFooterParticipante">
                <input type="button" class="boton-aceptar" value="Cerrar" id="cancelDialogForm"></input>
                <input type="submit" name="enviar" value="Enviar" id="boton-aceptar" class="boton-aceptar">
            </div>

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