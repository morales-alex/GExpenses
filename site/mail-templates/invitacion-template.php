<?php
// https://mailtrap.io/blog/phpmailer/#SMTP-configuration

require "../vendor/autoload.php";

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

    $mail->Subject = '¡Te han invitado a unirte a una Actividad!';
    $mail->isHTML(true);
    $mail->AddEmbeddedImage('../img/LOGO_ESTIRADO.png', 'logoEmpresa');
    $mailContent = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <style>
        
            html,
            body {
                height: 100%;
                width: 100%;
                margin: 0;
                font-family: "Montserrat", serif;
                background-color: #EEE;
                color: #171717;
            }

            #proteccion-de-datos {
                font-size: 12px;
                color: rgb(102, 102, 102);
                line-height: 1;
            }

            #caja-mail {
                background-color: #fff;
                display: flex;
                flex-direction: column;
                width: 85%;
                max-width: 600px;
                padding: 20px;
                border-radius: 10px;
                box-shadow: rgba(0, 0, 0, 0.2) 0px 8px 24px;
            }

            #container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }

            #logo {
                justify-content: center;
                display: flex;
            }

            a {
                padding: 8px 12px;
                border-radius: 10px;
                font-weight: 600;
                margin-right: 15px;
                background-color: #4E729A;
                color: #FFF;
                border: none;
                text-decoration: none;
            }

            .caja-boton {
                margin: 10px 0;
            }

            #logo img {
                max-width: 400px;
            }

        </style>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    </head>
    
    <body>
        <div id="container">
            <div id="caja-mail">
                <div id="logo">
                    <img src="cid:logoEmpresa" style="width:200px;" alt="Logo GExpenses">
                </div>
                <div id="mensaje">
    
                    <h1>¡Hola!</h1>
                    <p style="font-size:14px;padding-bottom:10px;margin:0">¡Te han invitado a unirte a una Actividad!</p>
                    <p style="font-size:14px;padding-bottom:10px;margin:0">Haz click al siguiente enlace para unirte a esta actividad y empezar a repartir gastos con tus amigos.</p>
                    <div class="caja-boton">
                    <a href="http://192.168.50.237/vista/index.php?a_id=' . $codigoActividad . '&invitacion=' . $nuevoToken . '">Unirme ahora!</a>
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
    $mail->msgHTML($mailContent);

    if ($mail->send()) {
        $mailEnviat = true;
    } else {
        $mailEnviat = false;
    }
} catch (Exception $ex) {
}
