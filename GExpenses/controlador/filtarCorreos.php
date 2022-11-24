<?php
require '../controlador/BbddConfig.php';
require "compruebaEmail.php";
$arrayEmail = ['a@gmail.com', 'b@gmail.com'];
foreach ($_POST["Correos"] as $correo){
    if(filter_var($correo, FILTER_VALIDATE_EMAIL)){//validar formato correo
        
        if(compruebaEmail($correo, $pdo)){
            //emai SI exsiste
            //enviar invitacion actividad
        }else{
            //email NO exisiste
            //enviar 
        }
    }else{
        array_push($_POST["errCorreo"],$correo);
    }
}
unset($arrayEmail);