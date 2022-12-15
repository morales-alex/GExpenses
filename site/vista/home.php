<?php

require '../modelo/tablesMap.php';
require '../controlador/BbddConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (isset($_SESSION["mensajeError"])) {
        $mensajeDeError = $_SESSION["mensajeError"];
    }
}


if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./index.php');
}


if (!empty($_POST["ordenActividad"])) {
    $seleccion = $_POST["ordenActividad"];
} else {
    $seleccion = 'fechaModificacion';
}

$idUsuario = $_SESSION["usuario"]->getU_id();

if ($seleccion == 'fechaCreacion') {

    $stmt = $pdo->prepare("SELECT * FROM Actividades as a INNER JOIN UsuariosActividades as ua ON ua.ua_idAct = a.a_id WHERE ua_idUsu = :u_usernameID ORDER BY a_fecCreacion DESC");

    $stmt->bindParam(':u_usernameID', $idUsuario);

    $stmt->execute();
    $consultaOrdenada = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT * FROM Actividades as a INNER JOIN UsuariosActividades as ua ON ua.ua_idAct = a.a_id WHERE ua_idUsu = :u_usernameID ORDER BY a_fecUltMod DESC;");

    $stmt->bindParam(':u_usernameID', $idUsuario);

    $stmt->execute();
    $consultaOrdenada = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$pdo = null;


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
    <link rel="shortcut icon" type="image/x-icon" href="../img/LOGO_VENTANA.ico" />
</head>

<?php include_once './Header.php' ?>

<body>

    <?php include_once './addActivityForm.php' ?>

    <div id="main">
        <div id="titulo-pagina">
            <div>
                <h1>Actividades</h1>
                <?php
                if (isset($mensajeDeError)) {
                    if (str_starts_with($mensajeDeError, "¡Enhorabuena!")) {
                ?>

                        <div class="ok-message"><?php echo $mensajeDeError ?></div>
                    <?php
                    } elseif (str_starts_with($mensajeDeError, "¡Cuidado!")) {

                    ?>

                        <div class="warning-message"><?php echo $mensajeDeError ?></div>
                <?php

                    }
                    unset($mensajeDeError);
                }
                ?>

            </div>
            <div class="ordenar">
                <div class="boton-nueva-actividad" id='addActivityButton'>Añadir actividad +</div>
                <form method="post" action="home.php" name="orden">
                    <select name="ordenActividad" onchange="orden.submit();">
                        <?php
                        if ($seleccion === 'fechaCreacion') {
                        ?>
                            <option value="fechaCreacion" selected>Fecha de creación</option>
                            <option value="fechaModificacion">Fecha de modificacion</option>
                        <?php
                        } else {
                        ?>
                            <option value="fechaCreacion">Fecha de creación</option>
                            <option value="fechaModificacion" selected>Fecha de modificacion</option>
                        <?php
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>
        <hr>
        <div id="caja-actividades">
            <?php


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
                            <a href="./Actividad.php?a_id=<?php echo $actividad['a_id'] ?>">VER ACTIVIDAD</a>
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

<script src="../script/crearActividad.js"></script>

</html>