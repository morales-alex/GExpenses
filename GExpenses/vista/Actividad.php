<?php

require '../modelo/tablesMap.php';
require '../controlador/BbddConfig.php';

$bytes = random_bytes(20);
var_dump(bin2hex($bytes));


if (isset($_GET["a_id"])) {
    $codigoActividad = $_GET["a_id"];
    $_SESSION['actividad_id'] = $codigoActividad;
};


if (session_status() !== 2) { // SI VALE DOS SIGNIFICA QUE LA SESIÓN ESTÁ INICIADA
    SESSION_START();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./login.php');
}

if (isset($_GET['invitacion'])) {

    $token = $_GET['invitacion'];
    $correoUsuario = $_SESSION["usuario"]->getU_correo();

    // Consulta TOKEN existe
    try {
        $sql = "SELECT i_correoUsuarioInvitado FROM Invitaciones WHERE i_token = :i_token";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':i_token', $token);

        $stmt->execute();
        $correoInvitado = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    $correoUsuario = $_SESSION["usuario"]->getU_correo();
    $usuario = $_SESSION["usuario"]->getU_id();

    // Si el token introducido coincide con el mail correspondiente en la base de datos lo inserta
    if ($correoUsuario == implode($correoInvitado)) {

        try {

            $sql = "INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) 
                    VALUES (:ua_idUsu, :ua_idAct)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':ua_idUsu', $usuario);
            $stmt->bindParam(':ua_idAct', $codigoActividad);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            $stmt->execute();

            $pdo->commit();

            header('Location: ' . $_SERVER['PHP_SELF'] . '?a_id=' . $codigoActividad);
            die;
        } catch (PDOException $ex) {
            $pdo->rollBack();
            header('Location: ' . $_SERVER['PHP_SELF'] . '?a_id=' . $codigoActividad);
            die;
        }
        unset($_GET["invitacion"]);
    }

    unset($_GET["invitacion"]);
}

// CONSULTA GASTOS
try {
    $sql = "SELECT * FROM Gastos INNER JOIN Usuarios on Usuarios.u_id = Gastos.g_idUsu INNER JOIN Actividades ON Actividades.a_id = gastos.g_idAct WHERE g_idAct = :g_idAct order by g_fecCrea";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':g_idAct', $codigoActividad);

    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

// CONSULTA PARTICIPANTES ACTIVIDAD
try {
    $sql = "SELECT u_username FROM UsuariosActividades INNER JOIN Usuarios ON usuarios.u_id = UsuariosActividades.ua_idUsu WHERE ua_idAct = :ua_idAct";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ua_idAct', $codigoActividad);

    $stmt->execute();
    $participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

// CONSULTA SUMA TOTAL GASTOS
try {
    $sql = "SELECT sum(g_precio) as total FROM Gastos INNER JOIN Actividades ON Actividades.a_id = gastos.g_idAct  WHERE g_idAct = :ua_idAct";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ua_idAct', $_GET["a_id"]);

    $stmt->execute();
    $gastoTotal = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

// Invitacion de registro o actividad
$correosNoValidos = [];

if (isset($_POST['correos'])) {

    require_once "compruebaEmail.php";

    foreach ($_POST["correos"] as $correo) {

        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) { //validar formato correo

            if (compruebaEmail($correo, $pdo)) {
                // Generamos un nuevo token
                $nuevoToken = random_bytes(20);
                $nuevoToken = bin2hex($nuevoToken);

                // Insertamos la invitación con el token en la base de datos
                try {

                    $sql = "INSERT INTO Invitaciones (i_idUsu, i_idAct, i_token, i_correoUsuarioInvitado) VALUES (:i_idUsu, :i_idAct, :i_token, :i_correoUsuarioInvitado)";
                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':i_idUsu', $usuario);
                    $stmt->bindParam(':i_idAct', $codigoActividad);
                    $stmt->bindParam(':i_token', $nuevoToken);
                    $stmt->bindParam(':i_correoUsuarioInvitado', $correo);

                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->beginTransaction();

                    $stmt->execute();

                    $pdo->commit();

                    /*header('Location: ' . $_SERVER['PHP_SELF'] . '?a_id=' . $codigoActividad);
                    die;*/
                } catch (PDOException $ex) {
                    $pdo->rollBack();
                    /*header('Location: ' . $_SERVER['PHP_SELF'] . '?a_id=' . $codigoActividad);
                    die;*/
                }
                require_once '../mail-templates/invitacion-template.php';
            } else {
                require_once '../mail-templates/registro-template.php';
            }
            if($mailEnviat){
                require '../controlador/invitacion-action.php';
            }else{
                array_push($correosNoValidos, $correo);
            }
        } else {
            array_push($correosNoValidos, $correo);
        }
    }

    unset($_POST["correos"]);

    if (sizeof($correosNoValidos) != 0) {

        $_SESSION["errorCorreos"] = "Los siguientes Emails no se han enviado:<br>";

        foreach ($correosNoValidos as $correoInvalido) {
            $_SESSION["errorCorreos"] = $_SESSION["errorCorreos"] . $correoInvalido . "<br>";
        }
    }
}

// CONSULTA NOMBRE ACTIVIDAD
try {

    $sql = "SELECT a_nombre FROM Actividades WHERE a_id = :a_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':a_id', $_GET["a_id"]);

    $stmt->execute();
    $actividad = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

$pdo = null;

//$destino = '../vista/Actividad.php?a_id='.$_SESSION["a_id"];

//header('location: '.$destino);
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

    <dialog id='addParticipanteDialog' class="dialogForm centered" close>
        <div id="dialog-activityForm" class="dialog-header">
            <h5>Invitar Usuarios a la Actividad</h5>
            <span id='cancelarX'>x</span>
        </div>
        <form method="post" action="" id="addActivity" class="formAddParticipantes">

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

    <div id="contenidoActividad">



        <div id="actividadMain">

            <h1 id="tituloActividad">

                <?php
                if (count($actividad) > 0) {
                    echo $actividad['a_nombre'];
                } else {
                    echo 'Sin título';
                }
                ?></h1>



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
                } else {
                    ?>
                    <div>
                        <p class ='sinDatos'>Aún no se han añadido gastos</p>
                    </div>
                <?php
                }

                if ($gastoTotal['total'] !== null) {
                ?>
                    <div id="totalActividad">
                        <div id="tituloTotal">TOTAL:</div>
                        <div id="campoTotal"><?php echo $gastoTotal['total'] . $gasto['a_moneda'] ?></div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div id="linea"></div>

        <div id="participantes">
            <div id="tituloParticipantes">
                <h2>Participantes</h2>
                <!--<input id="addParticipantes" type="button" value="Añadir">
                //<img class="addUserIcon" src="../img/add-user-icon.png" alt="Icono Add user">-->

                <input class="addUserIcon" type="image" alt="Icono Add user" src="../img/add-user-icon.png">
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