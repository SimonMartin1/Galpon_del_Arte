<?php
$nombre = $_POST['nombre'];
$mail = $_POST['email'];
$asunto = $_POST['asunto'];
$empresa = $_POST['mensaje'];

$header = 'From: ' . $mail . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";

$mensaje = "Este mensaje fue enviado por " . $nombre . ",\r\n";
$mensaje .= "Su e-mail es: " . $mail . " \r\n";
$mensaje .= "Asunto: " . $asunto . " \r\n";
$mensaje .= "Mensaje: " . $_POST['mensaje'] . " \r\n";
$mensaje .= "Enviado el " . date('d/m/Y', time());

$para = 'simonmartinsposito08@gmail.com , galpon.arte@hotmail.com , chuecomartin@hotmail.com ';
$asunto = 'Mensaje de la web de GalponDelArte';

mail($para, $asunto,($mensaje), $header);
header("Location:../contactanos.html");
$redireccion= header("Location:../contactanos.html");
?>

<script type="text/javascript">
    const redireccionar = "<?php echo $redireccion; ?>" ; 
    if (redireccionar ==1) {
alert("mensaje envia")
    }
    </script>
