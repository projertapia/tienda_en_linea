<?php
	function sendmailcf($mailFC){
		$toFC = $mailFC;
		$subjectFC = 'Ecommerce, su contraseña se cambio.';
		$subjectFC="=?UTF-8?B?".base64_encode($subjectFC)."=?=";
		$fromFC = 'contacto@ecommerce.com';
		$headersFC  = 'MIME-Version: 1.0' . "\r\n";
		$headersFC .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headersFC .= "Content-Transfer-Encoding: 8bit\r\n";
		$headersFC .= 'From: '.$fromFC."\r\n".
		'Reply-To: '.$fromFC."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$cuerpoMensajeFC = '<html><body>';
		$cuerpoMensajeFC .= '<center style="width:100%;table-layout:fixed;background-color:#e4e3e4">
<table width="600px" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="font-family:Ember,Arial,sans-serif;">
<tbody>
<tr><td valign="middle" height="80px" align="center">
<a href="'.SITEUSER.'" target="_blank"><img src="'.SITEUSER.'img/ecommerce_logo-ml.jpg" width="67"></a>
</td></tr>
<tr><td style="border-bottom: 1pt solid black;"></td></tr>
<tr><td height="15px"></td></tr>
<tr><td><h2 style="margin: 5px 15px">Hola</h2></td></tr>
<tr><td><p style="margin: 5px 15px">Se cambio exitósamente su contraseña</p></td></tr>
<tr><td height="15px"></td></tr>
<tr><td style="border-top: 1px solid black" height="15px"></td></tr>
<tr><td>
<table width="100%" align="center" cellspacing="0"  cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
<tbody>
<tr>
<td valign="middle" height="80px" width="350px"><a href="'.SITEUSER.'" target="_blank"><img src="'.SITEUSER.'img/ecommerce_logo-ml.jpg" width="67"></a></td>
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
	$cuerpoMensajeFC .= '</body></html>';
	// ENVIAR CORREO A TIENDA
	if(mail($toFC, $subjectFC, $cuerpoMensajeFC, $headersFC)){
		//echo 1;
	} else{
		//echo 2;
	};
}
?>