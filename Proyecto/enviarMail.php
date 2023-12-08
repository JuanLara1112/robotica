<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master\Exception.php';
require  'PHPMailer-master\PHPMailer.php';
require 'PHPMailer-master\SMTP.php';

$mail = new PHPMailer(true);
$mail ->isSMTP();
$mail ->Host = 'smpt.example.com';
$mail ->SMTPAuth = true;
$mail -> Username = 'user@example.com';
$mail -> Password = 'email_password';
$mail -> SMTPSecure = 'ssl';
$mail -> Port = 465;

$mail -> setFrom('usersverification@example.com', 'RoboTec');
$mail -> addAddress('juanitobegue@hotmail.com');
$mail -> Subject = 'Email de verificacion de Robotec';
$mail -> Body = 'Prueba osiosi';

if($mail -> send())
{
    echo 'Email enviado';
}
else
{
    echo 'Email no pudo ser enviado. Mailer Error: '.$mail ->ErrorInfo;
}

$to = 'juanitobegue@hotmail.com';
$subject = 'prueba';
$message = 'mensaje de prueba para la configuracion de mails php';
$headers = 'From: juanj.l.hdz@gmail.com' . "\r\n".
    'Reply-to: juanj.l.hdz@gmail.com' . "\r\n".
    'content-type: text/html; charset=UTF-8'. "\r\n";
mail($to,$subject,$message,$headers);