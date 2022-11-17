
<dialog id=addActivityDialog class="dialogForm centered" open>
    <div class="dialog-content">
        <div class="modal-header">
            <h4 class="titleDialog">Añadir actividad</h4>
        </div>
        <div class="dialog-content">
            <form method="dialog" id="addActivity">

                <label for="nombre" aria-placeholder="Viaje a Ibiza">Nombre:</label>
                <input type="text" id="name" name="name" required>

                <label for="moneda">Moneda:</label>
                <input type="text" id="moneda" name="moneda" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" placeholder="Descripción de la actividad"></textarea>
    
                <button type="submit" form="addActivity" value="Add" name="add">Añadir</button>
            </form>
        </div>
    </div>
</dialog>
