<?php

require '../modelo/tablesMap.php';

if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./login.php');
}

require '../controlador/BbddConfig.php';

try {
    $sql = "SELECT * FROM Gastos INNER JOIN Usuarios on Usuarios.u_id = Gastos.g_idUsu INNER JOIN Actividades ON Actividades.a_id = gastos.g_idAct WHERE g_idAct = :g_idAct order by g_fecCrea";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':g_idAct', $_GET["a_id"]);

    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}


try {

    $sql = "SELECT u_username FROM UsuariosActividades INNER JOIN Usuarios ON usuarios.u_id = UsuariosActividades.ua_idUsu WHERE ua_idAct = :ua_idAct";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ua_idAct', $_GET["a_id"]);

    $stmt->execute();
    $participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

try {

    $sql = "SELECT sum(g_precio) as total FROM Gastos INNER JOIN Actividades ON Actividades.a_id = gastos.g_idAct  WHERE g_idAct = :ua_idAct";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ua_idAct', $_GET["a_id"]);

    $stmt->execute();
    $gastoTotal = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<?php include_once './Header.php' ?>

<body>

    <?php include_once './addParticipanteForm.php' ?>

    <div id="contenidoActividad">



        <div id="actividadMain">

            <h1 id="tituloActividad"> <?php echo $datos[0]['a_nombre'] ?></h1>


            <div id="gastoWrapper">

                <div id="tituloGasto">
                    <h3 id="tituloCampoConcepto">CONCEPTO:</h3>
                    <h3 id="tituloCampo">PAGÓ:</h3>
                    <h3 id="tituloCampo">Fecha:</h3>
                    <h3 id="tituloCampoPrecio">PRECIO:</h3>
                </div>

                <?php


                if ($datos) {
                    foreach ($datos as $gasto) {
                ?>

                        <div id="gasto">
                            <div class="campoGastoIzq"><?php echo $gasto['g_concepto'] ?></div>
                            <div class="campoGastoCent"><?php echo $gasto['u_username'] ?></div>
                            <div class="campoGastoCent"><?php echo $gasto['g_fecCrea'] ?></div>
                            <div class="campoGastoDer"><?php echo $gasto['g_precio'] . $gasto['a_moneda'] ?></div>
                        </div>

                <?php
                    }
                }

                ?>

                <div id="totalActividad">
                    <div id="tituloTotal">TOTAL:</div>
                    <div id="campoTotal"><?php echo $gastoTotal['total'] . $gasto['a_moneda'] ?></div>
                </div>
            </div>


        </div>

        <div id="linea"></div>

        <div id="participantes">
            <div id="tituloParticipantes">
                <h2>Participantes</h2>
                <input id="addParticipantes" type="button" value="Añadir">
            </div>

            <?php

            foreach ($participantes as $participante) {
            ?>
                <p id="participante"><?php echo $participante['u_username'] ?></p>

            <?php
            }
            $pdo = null;
            ?>


            <?php

            if (isset($_SESSION["errorCorreos"])) {
            ?>
                <div class="error-message-correos"><?php echo $_SESSION["errorCorreos"]; ?></div>
            <?php
                unset($_SESSION["errorCorreos"]);
            }
            ?>

        </div>



    </div>

</body>

<?php include_once './Footer.php' ?>

<script src="../script/crearParticipantes.js"></script>


</html>