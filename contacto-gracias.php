<?php
	session_start();
	require('connect/conect_usrer.php');
	date_default_timezone_set('America/Mexico_City');
	if(isset($_POST['nombre']) AND isset($_POST['asunto']) AND isset($_POST['email']) AND isset($_POST['mensaje']) AND ($_POST['key'] == $_SESSION["keymail"])){
		function filtrado($datos){
			$datos = trim($datos); // Elimina espacios antes y después de los datos
			$datos = stripslashes($datos); // Elimina backslashes \
			$datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
			return $datos;
		}
		$nombre= filtrado($_POST['nombre']);
		$asunto=filtrado($_POST['asunto']);
		$email=filtrado($_POST['email']);
		$mensaje=filtrado($_POST['mensaje']);
		$aviso="";
		
		
		$from = "contacto@ecommerce.com";
		$to = 'ventas@ecommerce.com';
		//$to ='projerdj@gmail.com';
		$subjectTXT = "Tienes un mensaje de $nombre  sobre $asunto en Ecommerce.";
		$subject="=?UTF-8?B?".base64_encode($subjectTXT)."=?=";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit\r\n";
		$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$email."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$cuerpoMensaje = '<html><body>';
		$cuerpoMensaje .= '<center style="width:100%;table-layout:fixed;background-color:#e4e3e4">
<table width="600px" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="font-family:Ember,Arial,sans-serif;">
<tbody>
<tr><td valign="middle" height="80px" align="center">
<a href="'.SITEUSER.'" target="_blank"><img src="'.SITEUSER.'img/ecommerce_logo-ml.jpg" width="67"></a>
</td></tr>
<tr><td style="border-bottom: 1pt solid black;"></td></tr>
<tr><td height="15px"></td></tr>
<tr><td><h2 style="margin: 5px 15px">Hola tienes un mensaje de '.$nombre.' con el asunto '.$asunto.'</h2></td></tr>
<tr><td><p style="margin: 5px 15px">El mensaje es el siguiente:</p></td></tr>
<tr><td><p style="margin: 5px 15px">'.$mensaje.'</p></td></tr>
<tr><td><p style="margin: 5px 15px">Responder al correo: '.$email.'</p></td></tr>
<tr><td><p style="margin: 5px 15px">'.date("d/m/Y h:i:s A").'</p></td></tr>
<tr><td height="15px"></td></tr>
<tr><td style="border-top: 1px solid black" height="15px"></td></tr>
<tr><td>
<table width="100%" align="center" cellspacing="0"  cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
<tbody>
<tr>
<td valign="middle" height="80px" width="350px"><a href="'.SITEUSER.'mi-escaparate" target="_blank"><img src="'.SITEUSER.'img/ecommerce_logo-ml.jpg" width="67"></a></td>
<td align="center">
<a href="https://www.facebook.com/ecommerce/" title="Facebook" style="margin: 5px 5px 5px 5px"><img src="'.SITEUSER.'img/fb.jpg" alt="Facebook" width="25px"></a>
<a href="https://www.instagram.com/ecommerce/" title="Instagram" style="margin: 5px 5px 5px 5px"><img src="'.SITEUSER.'img/insta.jpg" alt="Instagram" width="25px"></a>
<a href="https://twitter.com/ecommerce" title="Twitter" style="margin: 5px 5px 5px 5px"><img src="'.SITEUSER.'img/tw.jpg" alt="Twitter" width="25px"></a>
</td>
</tr>
</tbody>
</table>
</td></tr>
<tr><td height="25px"></td></tr>
<tr><td style="background-color:#fdeb00" height="20px"></td></tr>
</tboby>
</table>
</center>';
	$cuerpoMensaje .= '</body></html>';
	// ENVIAR CORREO A TIENDA
	if(mail($to, $subject, $cuerpoMensaje, $headers)){
		$aviso = "Nos pondremos en contacto lo más pronto posible.";
		$btn='<a href="'.SITEUSER.'" title="INICIO">Continuar navegando</a>';
	} else{
		$aviso = "No fue posible enviar tu correo, intenta nuevamente";
		$btn='<a href="'.SITEUSER.'contactanos" title="Contáctanos">Intentar nuevamente.</a>';
	};
	}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Gracias por escríbirnos | Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="home-producto" style="background-image: linear-gradient(rgba(255, 255, 255, 0.0) 50%, rgba(255, 255, 255, 1) 100%), url(../img/cover_busqueda.png)">
		<div class="container">
			<h2 id="title-escaparate">Gracias por escríbirnos</h2>
		</div>
	</section>
	<section id="faq">
		<div class="container">
			<div class="row">
				<h3 class="text-center" style="width: 100%;"><?php echo $aviso?></h3>
				<br>
				<p style="width: 100%;" class="text-center"><?php echo $btn?></p>
			</div>
		</div>
	</section>
	<?php include("parts/footer.php"); ?>
	<script>
		
	</script>
</body>
</html>