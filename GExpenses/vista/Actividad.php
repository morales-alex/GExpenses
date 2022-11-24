<?php

if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./login.php');
}

$codigoActividad = $_GET["a_id"];
$_SESSION["a_id"] = $_GET["a_id"];
require '../controlador/BbddConfig.php';



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

    <?php include_once './addParticipanteForm.php' ?>

    <div id="contenidoActividad">



        <div id="actividadMain">

            <h1 id="tituloActividad">Viaje al congo</h1>


            <div id="gastoWrapper">

                <div id="tituloGasto">
                    <h3 id="tituloCampo">NOMBRE:</h3>
                    <h3 id="tituloCampo">PAGÓ:</h3>
                    <h3 id="tituloCampo">PRECIO:</h3>
                </div>

                <?php

                try {
                    $sql = "SELECT * FROM Gastos WHERE g_idAct = :g_idAct";
                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':g_idAct', $codigoActividad);

                    $stmt->execute();
                    $datos = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $ex) {
                    echo 'Error: ' . $ex->getMessage();
                }
                if ($datos) {
                    foreach ($datos as $gasto) {
                ?>

                        <div id="gasto">
                            <div id="campoGasto"><?php echo $datos['g_concepto'] ?></div>
                            <div id="campoGasto">F. crea: <?php echo $datos['g_precio'] ?></div>
                            <div id="campoGasto">F. modif: <?php echo $datos['g_precio'] ?></div>
                        </div>

                <?php
                    }
                }

                ?>


            </div>


        </div>

        <div id="linea"></div>

        <div id="participantes">
            <div id="tituloParticipantes">
                <h2>Participantes</h2>
                <input id="addParticipantes" type="button" value="Añadir">
            </div>

            <?php

            try {
                //$sql = "SELECT ua_idUsu FROM UsuariosActividades WHERE ua_idAct = :ua_idAct";
                $sql = "SELECT u_username FROM UsuariosActividades INNER JOIN Usuarios ON usuarios.u_id = UsuariosActividades.ua_idUsu WHERE ua_idAct = :ua_idAct";

                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':ua_idAct', $codigoActividad);

                $stmt->execute();
                $datos = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo 'Error: ' . $ex->getMessage();
            }

            foreach ($datos as $participantes) {
            ?>
                <p id="participante"><?php echo $datos['u_username'] ?></p>

            <?php
            }
            $pdo = null;
            ?>


            <?php

            if (isset($_SESSION["errorCorreos"])) {
            ?>
                <div class="error-message"><?php echo $_SESSION["errorCorreos"]; ?></div>
            <?php
                unset($_SESSION["errorCorreos"]);
            }
            ?>

        </div>



    </div>

</body>

<?php include_once './Footer.php' ?>

<script src="../script/crearParticipantes.js"></script>
<script src="../script/actividad.js"></script>

</html>