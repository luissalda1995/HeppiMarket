<?php
require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer

$mail = new PHPMailer();

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
$mail->Username = "webmaster@drink.com.co"; // Cuenta de e-mail
$mail->Password = "23camilo"; // Password


$mail->Host = "localhost";
$mail->From = "yo@cosas.com.co";
$mail->FromName = "cosas";
$mail->Subject = "prueba";
$mail->AddAddress("juan1387@gmail.com","juan camilo noriega");

$mail->WordWrap = 50;

$body  = "Hola, este es un…";
$body .= "<font color='red'> mensaje de prueba</font>";

$mail->Body = $body;

$mail->Send();


// Notificamos al usuario del estado del mensaje

if(!$mail->Send()){
   echo "No se pudo enviar el Mensaje.";
}else{
   echo "Mensaje enviado";
}

?>