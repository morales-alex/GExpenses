<?php
// https://mailtrap.io/blog/phpmailer/#SMTP-configuration

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

try {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '1f8bed0fca18c4';
    $mail->Password = 'e54eb581efe56d';
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('auto@freixa.cat', 'proves');
    $mail->addAddress($correo, 'Max');

    $mail->Subject = '¡Te han invitacdo a GExpenses!';
    $mail->isHTML(true);
    $mailContent = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="../css/style-mails.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    </head>
    
    <body>
        <div id="container">
            <div id="caja-mail">
                <div id="logo">
                    <img src="../img/LOGO_ESTIRADO.png" alt="Logo GExpenses">
                </div>
                <div id="mensaje">
    
                    <h1>¡Hola!</h1>
                    <p style="font-size:14px;padding-bottom:10px;margin:0">¡Te han invitado a <strong>GExpenses!</strong></p>
                    <p style="font-size:14px;padding-bottom:10px;margin:0">La mejor aplicación que calcula los gastos de tus planes favoritos por ti!</p>
                    <p style="font-size:14px;padding-bottom:10px;margin:0">Haz click al siguiente enlace para iniciar el proceso de registro y empezar a repartir gastos con tus amigos.</p>
                    <div class="caja-boton">
                        <a href="http://localhost/Copernic/abp/GExpenses_3p1/site/vista/registro.php?&ref=1&a_id='.$codigoActividad.'&invitacion='.$nuevoToken.'">Registrarse</a>
                        <a href="http://localhost:3000/site/vista/registro.php?&ref=1&a_id='.$codigoActividad.'&invitacion='.$nuevoToken.'">Unirme ahora!</a>
                    </div>
    
                </div>
                <div id="proteccion-de-datos">
                    <p>Esta comunicación va dirigida de manera exclusiva a su destinatario y puede contener información confidencial y/o sujeta a secreto profesional, cuya divulgación no está permitida por la Ley. Si ha recibido este mensaje por error, le rogamos que a la menor brevedad posible, se comunique mediante correo electrónico remitido a nuestra atención y proceda a su eliminación, así como cualquier documento adjunto al mismo. </p>
                    <p>En cumplimiento del RGPD en materia de protección de datos personales, le informamos de que recibe este email por estar suscrito a GExpenses. </p>
                    <p>El responsable del tratamiento de sus datos es GExpenses, con NIF B67550046 y domicilio fiscal Carrer Sant Joan 13. </p>
                    <p>La finalidad para la que se recogen sus datos es enviarle notificaciones de los cambios en su cuenta.</p>
                    <p>Su información permanecerá en nuestra base de datos hasta que no diga lo contrario y no será cedida a terceros. </p>
                    <p>Puede ejercer sus derechos de acceso, rectificación, cancelación, oposición o limitación del tratamiento poniéndose en contacto con nosotros a través de info@gexpenses.com</p>
                </div>
            </div>
        </div>
    </body>
    </html>';
    $mail->Body = $mailContent;
    
    if($mail->send()){
        $mailEnviat = true;
    } else {
        $mailEnviat = false;
    }
} catch (Exception $ex) {
    echo $ex->message;
}