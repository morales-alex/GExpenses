<?php



unset($_SESSION["mensajeError"]);

    
$_SESSION["mensajeError"] = "Los siguientes Emails no se han enviado:<br>";


echo $_SESSION['mensajeError'];