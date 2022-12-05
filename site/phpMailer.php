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

    //$mail = new PHPMailer();
    $mail->setFrom('auto@freixa.cat', 'proves');
    // $mail->addReplyTo('info@mailtrap.io', 'Mailtrap');
    $mail->addAddress('freixa.sureda.max@alumnat.copernic.cat', 'Max');
    // $mail->addCC('cc1@example.com', 'Elena');
    // $mail->addBCC('bcc1@example.com', 'Alex');

    $mail->Subject = 'Test Email via Mailtrap SMTP using PHPMailer';
    $mail->isHTML(true);
    $mailContent = "<h1>Send HTML Email using SMTP in PHP</h1>
    <p>This is a test email I’m sending using SMTP mail server with PHPMailer.</p>";
    $mail->Body = $mailContent;

    $mail->send();
} catch (Exception $ex) {
    echo $ex->message;
}

if ($mail->send()) {
    echo 'Message has been sent';
} else {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
