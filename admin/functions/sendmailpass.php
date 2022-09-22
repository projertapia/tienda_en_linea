<?php
	function sendmailpass($mail,$clave){
		$to = $mail;
		$subjectTXT = 'Ecommerce, restablecer tu contraseña';
		$subject="=?UTF-8?B?".base64_encode($subjectTXT)."=?=";
		$from = 'contacto@ecommerce.com';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit\r\n";
		$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$cuerpoMensaje = '<html><body>';
		$cuerpoMensaje .= '<center style="width:100%;table-layout:fixed;background-color:#e4e3e4">
<table width="600px" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="font-family:Ember,Arial,sans-serif;">
<tbody>
<tr><td valign="middle" height="80px" align="center">
<a href="'.SITE.'admin" target="_blank"><img src="'.SITE.'img/ecommerce_logo-ml.jpg" width="67"></a>
</td></tr>
<tr><td style="border-bottom: 1pt solid black;"></td></tr>
<tr><td height="15px"></td></tr>
<tr><td><h2 style="margin: 5px 15px">Hola</h2></td></tr>
<tr><td><p style="margin: 5px 15px">Recibimos una solicitud de cambio de contraseña. Para confirmar tu nueva contraseña haz click en el siguiente enlace:</p></td></tr>
<tr><td><p style="margin: 5px 15px"><a href="'.SITE.'admin/recuperar/'.$clave.'" target="_blank">'.SITE.'admin/recuperar/'.$clave.'</a></p></td></tr>
<tr><td><p style="margin: 5px 15px">Por favor, ignora este mensaje en el caso que no hayas solicitado un cambio de contraseña de tu cuenta.</p></td></tr>
<tr><td height="15px"></td></tr>
<tr><td style="border-top: 1px solid black" height="15px"></td></tr>
<tr><td>
<table width="100%" align="center" cellspacing="0"  cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
<tbody>
<tr>
<td valign="middle" height="80px" width="350px"><a href="'.SITE.'admin" target="_blank"><img src="'.SITE.'img/ecommerce_logo-ml.jpg" width="67"></a></td>
<td align="center">
<a href="https://www.facebook.com/ecommerce/" title="Facebook" style="margin: 5px 5px 5px 5px"><img src="'.SITE.'img/fb.jpg" alt="Facebook" width="25px"></a>
<a href="https://www.instagram.com/ecommerce/" title="Instagram" style="margin: 5px 5px 5px 5px"><img src="'.SITE.'img/insta.jpg" alt="Instagram" width="25px"></a>
<a href="https://twitter.com/ecommerce" title="Twitter" style="margin: 5px 5px 5px 5px"><img src="'.SITE.'img/tw.jpg" alt="Twitter" width="25px"></a>
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
		//echo 1;
	} else{
		//echo 2;
	};
}
?>