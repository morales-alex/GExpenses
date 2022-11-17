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
    <title>Login</title>
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
                <label for="orden-actividad">Ordenar por: </label>
                <select name="orden-actividad" id="orden-actividad">
                    <option value="fecha-creacion">Fecha de creación</option>
                    <option value="fecha-modificacion">Fecha de modificación</option>
                </select>
            </div>
        </div>
        <hr>
        <div id="caja-actividades">
            <?php
            require '../controlador/BbddConfig.php';
            // fetchAll() con PDO::FETCH_ASSOC
            $stmt = $pdo->prepare("SELECT * FROM Actividades");
            $stmt->execute();
            $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($actividades as $actividad) {
            ?>
                <div class="actividad">
                    <div class="caja-interior-actividad">
                        <div class="caja-titulo-actividad">
                            <h3><?= $actividad['a_nombre'] ?></h3>
                        </div>
                        <div class="caja-boton-actividad">
                            <a href="#">VER ACTIVIDAD</a>
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

<script src="../script/index.js"></script>

</html>