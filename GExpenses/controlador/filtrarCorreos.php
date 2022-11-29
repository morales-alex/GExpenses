<?php
require_once './BbddConfig.php';
require_once "../vista/compruebaEmail.php";

$correosNoValidos = [];
$mailEnviat = false;
foreach ($_POST["correos"] as $correo) {

    if (filter_var($correo, FILTER_VALIDATE_EMAIL)) { //validar formato correo

        if (compruebaEmail($correo, $pdo)) {
            require_once '../mail-templates/invitacion-template.php';
        } else {
            require_once '../mail-templates/registro-template.php'; 
        }
    if($mailEnviat == true){
        require_once 'invitacion-action.php';
    }
    } else {
        array_push($correosNoValidos, $correo);
    }
}

unset($_POST["correos"]); 

SESSION_START();

if (sizeof($correosNoValidos) != 0) {

    $_SESSION["errorCorreos"] = "Los siguientes Emails no se han enviado:<br>";

    foreach ($correosNoValidos as $correoInvalido) {
        $_SESSION["errorCorreos"] = $_SESSION["errorCorreos"].$correoInvalido."<br>";
    }
}

$destino = '../vista/Actividad.php?a_id='.$_SESSION["usuario"]->getU_id();

header('location: '.$destino);
