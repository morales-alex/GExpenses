<?php


require '../modelo/tablesMap.php';
require '../controlador/BbddConfig.php';

if (isset($_GET["a_id"])) {
    $codigoActividad = $_GET["a_id"];
    $_SESSION['actividad_id'] = $codigoActividad;
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    SESSION_DESTROY();
    header('location: ./index.php');
}

if (isset($_GET['invitacion'])) {

    $token = $_GET['invitacion'];

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

// SI HAS ENVIADO EL FORMULARIO DE AÑADIR GASTO CREA EL REGISTRO EN LA BBDD
if (isset($_POST['DatosEnviosCorrectos'])) {

    $concepto = $_POST['conceptoGastoSencillo'];
    $usuarioPagador = $_POST['usuarioPagador'];
    $cuantiaGastoSencillo = $_POST['cuantiaGastoSencillo'];

    if (strlen($concepto > 1) && $cuantiaGastoSencillo >= 0) {

        try {

            $sql = "INSERT INTO Gastos (g_idUsu, g_idAct, g_precio, g_concepto, g_fecCrea) 
                    SELECT (SELECT u_id from Usuarios where u_username = :g_username), :g_idAct, :g_precio, :g_concepto, sysdate();";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':g_username', $usuarioPagador);
            $stmt->bindParam(':g_idAct', $codigoActividad);
            $stmt->bindParam(':g_precio', $cuantiaGastoSencillo);
            $stmt->bindParam(':g_concepto', $concepto);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            $stmt->execute();
            $pdo->commit();
        } catch (PDOException $ex) {
            $pdo->rollBack();
        }
    }

    unset($_POST['conceptoGastoSencillo']);
    unset($_POST['usuarioPagador']);
    unset($_POST['cuantiaGastoSencillo']);
    unset($_POST['enviar']);
}

// CONSULTA GASTOS
try {
    $sql = "SELECT * FROM Gastos INNER JOIN Usuarios on Usuarios.u_id = Gastos.g_idUsu INNER JOIN Actividades ON Actividades.a_id = Gastos.g_idAct WHERE g_idAct = :g_idAct order by g_fecCrea";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':g_idAct', $codigoActividad);

    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

// CONSULTA PARTICIPANTES ACTIVIDAD
try {
    $sql = "SELECT u_username FROM UsuariosActividades INNER JOIN Usuarios ON Usuarios.u_id = UsuariosActividades.ua_idUsu WHERE ua_idAct = :ua_idAct";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ua_idAct', $codigoActividad);

    $stmt->execute();
    $participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo 'Error: ' . $ex->getMessage();
}

// CONSULTA SUMA TOTAL GASTOS
try {
    $sql = "SELECT sum(g_precio) as total FROM Gastos INNER JOIN Actividades ON Actividades.a_id = Gastos.g_idAct  WHERE g_idAct = :ua_idAct";
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

    require_once '../controlador/compruebaEmail.php';

    $idUsuarioInvita = $_SESSION["usuario"]->getU_id();

    foreach ($_POST["correos"] as $correo) {


        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) { //validar formato correo

            // CONSULTA SI EL CORREO YA PARTICIPA EN ESTA ACTIVIDAD
            try {
                $sql = "SELECT Usuarios.u_correo FROM UsuariosActividades ua INNER JOIN Usuarios ON Usuarios.u_id = ua.ua_idUsu WHERE Usuarios.u_correo = :u_correo AND ua_idAct = :ua_idAct";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':ua_idAct', $codigoActividad);
                $stmt->bindParam(':u_correo', $correo);

                $stmt->execute();
                $correoYaParticipa = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo 'Error: ' . $ex->getMessage();
            }

            if ($correoYaParticipa) {
                array_push($correosNoValidos, $correo);
            } else {


                // Generamos un nuevo token
                $nuevoToken = random_bytes(20);
                $nuevoToken = bin2hex($nuevoToken);

                if (compruebaEmail($correo, $pdo)) {
                    require '../mail-templates/invitacion-template.php';
                } else {
                    require '../mail-templates/registro-template.php';
                }

                if ($mailEnviat) {

                    // Insertamos la invitación con el token en la base de datos
                    try {

                        $sql = "INSERT INTO Invitaciones (i_idUsu, i_idAct, i_token, i_correoUsuarioInvitado, i_fecInv) 
                    VALUES (:i_idUsu, :i_idAct, :i_token, :i_correoUsuarioInvitado, sysdate())";

                        $stmt = $pdo->prepare($sql);

                        $stmt->bindParam(':i_idUsu', $idUsuarioInvita);
                        $stmt->bindParam(':i_idAct', $codigoActividad);
                        $stmt->bindParam(':i_token', $nuevoToken);
                        $stmt->bindParam(':i_correoUsuarioInvitado', $correo);

                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->beginTransaction();

                        $stmt->execute();

                        $pdo->commit();
                    } catch (PDOException $ex) {
                        $pdo->rollBack();
                    }

                    if (compruebaEmail($correo, $pdo)) {
                        require_once '../mail-templates/invitacion-template.php';
                    } else {
                        require_once '../mail-templates/registro-template.php';
                    }
                    if (!$mailEnviat) {
                        array_push($correosNoValidos, $correo);
                    }
                } else {
                    array_push($correosNoValidos, $correo);
                }
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

// CONSULTA NOMBRE, FECHA ACTIVIDAD
try {

    $sql = "SELECT a_nombre, a_fecCreacion FROM Actividades WHERE a_id = :a_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':a_id', $_GET["a_id"]);

    $stmt->execute();
    $datosActividad = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <link rel="shortcut icon" type="image/x-icon" href="../img/LOGO_VENTANA.ico" />
</head>

<?php include_once './Header.php' ?>

<body>

    <div id="main">

        <dialog id='addParticipanteDialog' class="dialogForm centered" close>
            <div id="dialog-activityForm" class="dialog-header">
                <h5>Invitar Usuarios a la Actividad</h5>
                <span id='cancelarX'>x</span>
            </div>
            <form method="post" autocomplete="off" action="" id="addActivity" class="formAddParticipantes">

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

        <dialog id='addGastoDialog' class="dialogForm centered" close>
            <div id="dialog-gastoForm" class="dialog-header">
                <h5>Añadir gasto a la actividad</h5>
                <span id='cancelarGastoX'>x</span>
            </div>
            <form method="post" autocomplete="off" action="" id="addGastos" class="formAddParticipantes">

                <label for="nombre">Concepto del gasto:</label>
                <div id="addParticipante">
                    <input type="text" id="conceptoValue" name="conceptoGastoSencillo">
                </div>

                <p id='nombreErrorConcepto' class='error-messageForm'>El concepto debe tener entre 1 y 50 carácteres</p>
                <div class="pagadorGasto">

                    <div class="container-gasto">
                        <label class="labelGasto" for="usuarioPagador">Pagador:</label>
                        <select name="usuarioPagador" id="usuarioPagador">
                            <?php
                            foreach ($participantes as $participante) {
                            ?>
                                <option value="<?php echo $participante['u_username'] ?>"><?php echo $participante['u_username'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="container-opcion-pago">
                        <label for="opcionDePago" class="labelGasto">Repartición:</label>
                        <select name="opcionDePago" id="opcionDePago">
                            <option value="1">General</option>
                            <option value="2">Avanzado</option>
                            <option value="3">Proporción</option>
                        </select>
                    </div>
                    <div class="container-tipo-gasto">
                        <label for="cuantia" class="labelGasto">Cuantía:</label>
                        <input type="number" name="cuantiaGastoSencillo" class="cuantia" value="0">
                    </div>
                </div>

                <label for="cuantia" class="labelGasto">Participantes:</label>

                <div class="cuantiaPorUsuario">
                    <?php
                    foreach ($participantes as $participante) {
                        $usuarioParticipante = $participante['u_username'];
                    ?>

                        <div class="cuantiaUsuario">
                            <div class="gastosFormCol">
                                <span class="usuarioPaga" for=""><?php echo $usuarioParticipante ?></span>
                            </div>
                            <div class="gastosFormCol">
                                <label class="proporcion" style="display: block;">Pagará:</label>
                                <input type="number" class="paga" id="echo $usuarioParticipante" value="0" readonly="readonly"></input>
                            </div>
                            <div class="gastosFormColProp" style="display: none;">
                                <label class="labelImporteProporcional" for="importeProporcional">Proporción:</label>
                                <input class="importeProporcional" value="1"></input>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                    <p id='nombreErrorCuantias' class='error-messageForm'>La suma de cuantías debe dar el total y el número debe ser mayor a 0.</p>

                </div>

                <div id="dialogFooterParticipante">
                    <input type="button" class="boton-aceptar" value="Cerrar" id="cancelGastoForm"></input>
                    <input type="button" name="enviar" id="boton-aceptar-gastos" value="Añadir" class="boton-aceptar">
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

        <dialog id='balanceDialog' class="dialogForm centered" close>
            <div id="dialog-activityForm" class="dialog-header">
                <h3>Balance</h3>
                <span id='cancelarX'>x</span>
            </div>
            <div class="resumen-balance">
                <h5>Resumen balance</h5>
            </div>
            <div class="calculo-deudas">
                <h5>Calculo de deudas</h5>
            </div>
        </dialog>

        <h1 id="tituloActividad">

            <?php
            if (count($datosActividad) > 0) {
                echo $datosActividad['a_nombre'] . " <span class='fecha-titulo'>" . $datosActividad['a_fecCreacion'] . "</span>";
            } else {
                echo 'Sin título';
            }
            ?></h1>

        <div id="contenidoActividad">
            <div id="actividadMain">
                <div id="gastoWrapper">

                    <div id="tituloGasto">
                        <h3 id="tituloCampoConcepto">Concepto</h3>
                        <h3 id="tituloCampo">Pagó</h3>
                        <h3 id="tituloCampo">Fecha</h3>
                        <h3 id="tituloCampoPrecio">Precio</h3>
                    </div>

                    <?php
                    if ($datos) {
                        foreach ($datos as $gasto) {
                    ?>

                            <div id="gasto">
                                <div class="campoGastoIzq"><?php echo $gasto['g_concepto'] ?></div>
                                <div class="campoGastoCent"><?php echo $gasto['u_username'] ?></div>
                                <div class="campoGastoCent fecha"><?php echo $gasto['g_fecCrea'] ?></div>
                                <div class="campoGastoDer"><?php echo $gasto['g_precio'] . $gasto['a_moneda'] ?></div>
                            </div>

                        <?php
                        }
                    } else {
                        ?>
                        <div>
                            <p class='sinDatos'>Aún no se han añadido gastos</p>
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
            <div id="seccion-lateral">
                <div id="opciones">
                    <div id="tituloParticipantes">
                        <h2>Editar actividad</h2>
                    </div>
                    <div class="lista-opciones addGasto" id="addGasto">
                        <img id="addParticipantes" class="estilo-icono-opcion" type="image" alt="Icono Add user" src="../img/afegir-despsa.png">
                        <a href="#" class="titulo-opcion">Añadir gasto</a>
                    </div>
                    <div class="lista-opciones balance">
                        <img id="addParticipantes" class="estilo-icono-opcion" type="image" alt="Icono Add user" src="../img/balance.png">
                        <a href="#" class="titulo-opcion">Ver balance</a>
                    </div>
                    <div class="lista-opciones addUser">
                        <img id="addParticipantes" class="estilo-icono-opcion" type="image" alt="Icono Add user" src="../img/add-user-icon.png">
                        <a href="#" class="titulo-opcion">Invitar usuarios</a>
                    </div>
                    <div class="lista-opciones editUser">
                        <img id="addParticipantes" class="estilo-icono-opcion" type="image" alt="Icono Add user" src="../img/editar-usuari.png">
                        <a href="#" class="titulo-opcion">Gestionar usuarios</a>
                    </div>
                </div>
                <div id="participantes">
                    <div id="tituloParticipantes">
                        <h2>Participantes</h2>
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

        </div>

    </div>
</body>

<?php include_once './Footer.php' ?>

<script type="module" src="../script/crearGastos.js"></script>
<script src="../script/crearParticipantes.js"></script>
<script type="module" src="../script/validacionGastos.js"></script>
<script type="module" src="../script/balance.js"></script>
<script>
    // CONDICIONAL PARA EVITAR QUE AL REFRESCAR LA PÁGINA SE VUELVA A ENVIAR UN FORMULARIO
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


</html>