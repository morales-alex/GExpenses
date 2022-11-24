<?php
require './BbddConfig.php';
require "../Vista/compruebaEmail.php";

$correosNoValidos = [];


foreach ($_POST["correos"] as $correo) {

    if (filter_var($correo, FILTER_VALIDATE_EMAIL)) { //validar formato correo

        if (compruebaEmail($correo, $pdo)) {
            //emai SI exsiste
            //enviar invitacion actividad
        } else {
            //email NO exisiste
            //enviar 
        }
    } else {
        array_push($correosNoValidos, $correo);
    }
}

SESSION_START();

if (sizeof($correosNoValidos) != 0) {

    $_SESSION["errorCorreos"] = "Los siguientes Emails no se han enviado:<br>";

    foreach ($correosNoValidos as $correoInvalido) {
        $_SESSION["errorCorreos"] = $_SESSION["errorCorreos"].$correoInvalido."<br>";
    }
}

$destino = '../vista/Actividad.php?a_id='.$_SESSION["a_id"];

header('location: '.$destino);