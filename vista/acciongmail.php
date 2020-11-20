<html>
    <head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<?php
include_once "../configuracion.php";



$datos = data_submitted();
$archiv= new AbmArchivo();
if(isset($_FILES['file']))
{
$archiv->UploadFile($datos);
}

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// $mail->Host='smtp.live.com'; hotmail
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Whether to use SMTP authentication

$mail->SMTPAuth = true;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//Username to use for SMTP authentication
$mail->Username = '@gmail.com'; //ACA VA LA DIRECCION DE CORREO
//Password to use for SMTP authentication
$mail->Password = '';  //ACA VA LA CONTRASEÑA
//Set who the message is to be sent from
$mail->setFrom('@gmail.com', 'Nombre');
//Set an alternative reply-to address
$mail->addReplyTo('@gmail.com', 'Nombre');
// //Set who the message is to be sent to

// //Set an alternative reply-to address

//Set who the message is to be sent to
$mail->addAddress($datos['email'], 'Nombre'); //Esta es la direccion que viene del formulario
//Set the subject line
$mail->Subject = $datos['asunto']; // EL asunto viene del formulario

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);  // UTILIZAR PARA ENVIAR CORREO HTML

$mail->Body=$datos['cuerpoEmail']; //EL CUERPO VIENE DEL FORMULARIO
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment($datos['file']);
if(isset($_FILES['file']))
{
    $mail->addAttachment('../archivos/'.$_FILES['file']['name']);
}
//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}
?>
<a href="test.php"><button class="btn btn-primary">Volver</button></a>

</body>
</html>