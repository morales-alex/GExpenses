<?php

if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<?php include_once './Header.php' ?>

<body>

    <?php include_once './addActivityForm.php' ?>

    <div id="main">
        <div id="titulo-pagina">
            <div>
                <h1>Actividades</h1>
            </div>
            <div class="ordenar">
                <div class="boton-nueva-actividad" id='addActivityButton'>Añadir actividad +</div>
                <form method="post" action="home.php">
                    <select name="ordenActividad">
                        <option value="fechaCreacion">Fecha de creación</option>
                        <option value="fechaModificacion">Fecha de modificacion</option>
                    </select>
                    <button type="submit" name="enviar" value="enviar">OK</button>
                </form>
            </div>
        </div>
        <hr>
        <div id="caja-actividades">
            <?php

            require '../controlador/BbddConfig.php';

            if (!empty($_POST["ordenActividad"])) {
                $seleccion = $_POST["ordenActividad"];
            } else {
                $seleccion = 'fechaModificacion';
            }

            if ($seleccion == 'fechaCreacion') {
                $stmt = $pdo->prepare("SELECT * FROM Actividades ORDER BY a_fecCreacion DESC");
                $stmt->execute();
                $consultaOrdenada = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $pdo->prepare("SELECT * FROM Actividades ORDER BY a_fecUltMod DESC;");
                $stmt->execute();
                $consultaOrdenada = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }


            $pdo = null;

            foreach ($consultaOrdenada as $actividad) {
            ?>
                <div class="actividad" id="<?php echo $actividad['a_id'] ?>">
                    <div class="caja-interior-actividad">
                        <div class="caja-titulo-actividad">
                            <h3><?php echo $actividad['a_nombre'] ?></h3>
                            <p>F. crea: <?php echo $actividad['a_fecCreacion'] ?></p>
                            <p>F. modif: <?php echo $actividad['a_fecUltMod'] ?></p>
                        </div>
                        <div class="caja-boton-actividad">
                            <a href="./Actividad.php?a_id=<?php echo $actividad['a_id']?>">VER ACTIVIDAD</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

<?php include_once './Footer.php' ?>

<script src="../script/crearFormulario.js"></script>
<script src="../script/actividad.js"></script>

</html>