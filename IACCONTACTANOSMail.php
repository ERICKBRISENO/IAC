<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/DirConfig.php');
include_once(APP_MAILER . 'PHPMailerAutoload.php');


$NOMBRE = $_POST['NOMBRE'];
$TELEFONO = $_POST['TELEFONO'];
$MAIL = $_POST['MAIL'];
$MENSAJE = $_POST['MENSAJE'];

$mail = new PHPMailer();

$mail->FromName = "iac.direccion@hotmail.com";
$mail->Username = "iac.direccion@hotmail.com";
$mail->Password = "direccion123";
$mail->Host = "smtp.office365.com";
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPOptions = array('ssl' =>
    array('verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true));
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->AddAddress("iac.direccion@hotmail.com");
$mail->AddAddress("direccion@sistemaiac.com");
$mail->Subject = "Contactanos {$NOMBRE} {$TELEFONO} {$MAIL}";
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Body = $MENSAJE;
$mail->From = "iac.direccion@hotmail.com";

//$mail->IsSMTP(); // habilita SMTP
/*
$mail->SMTPDebug = 1; // debugging: 1 = errores y mensajes, 2 = sólo mensajes
$mail->SMTPAuth = true; // auth habilitada
$mail->SMTPSecure = 'ssl'; // transferencia segura REQUERIDA para Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "direccion@sistemaiac.com";
$mail->Password = "SARadmon123";
$mail->SetFrom("direccion@sistemaiac.com");
$mail->Subject = "Contactanos {$NOMBRE} {$TELEFONO} {$MAIL}";
$mail->Body = $MENSAJE;
$mail->AddAddress("direccion@sistemaiac.com");
//$mail->addAttachment($file, $filename);
*/
if(!$mail->Send()) {
    $mailMSG = "Mailer Error: " . $mail->ErrorInfo;
} else {
    $mailMSG = "GRACIAS POR CONTACTARNOS, ATENDEREMOS TU PETICION A LA BREVEDAD.";
}

echo xmlShow("ContenedorCentral",$mailMSG);

function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}
