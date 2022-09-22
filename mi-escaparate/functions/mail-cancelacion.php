<?php
	function sendMailStatus($nombrecliente,$mail,$clave_carrito,$razon,$paqueteria,$guia,$status){
	$now= date("Y d m, H:m");
	$mailresponder = $_SESSION['tiendauser'];
	if (isset($_SERVER['HTTPS'])) {
		$httpads="https://";}else{
		$httpads="http://";
		}
		$_SERVER['HTTP_HOST'];
		dirname($_SERVER['PHP_SELF']);
		$UrlServerMail=$httpads.$_SERVER['HTTP_HOST']."/";	
		
	//CHECAMOS EL STATUS Y CAMBIAMOS LA INFO status=1 pagado, status=2enviado, status=3 cancelado
		if($status==2){
			$subjectTXT = 'Buenas noticias. El pedido n.º'.$clave_carrito.' ha sido enviado.';
			$cuerpotxt='<p style="padding:5px 15px">El vendedor ha enviado parte de tu pedido n.º '.$clave_carrito.'.</p><p style="padding:5px 15px">La paqueteria es: '.$paqueteria.' y el númeró de gúia es: '.$guia.'</p>';
			$infoadd='<p style="font-size: 12px; padding: 5px 15px">Es posible que la información de rastreo tarde de 5 a 12 hrs, en verse actualizada en la pagina de la paquetería.</p>';
		}else if($status==3){
			$subjectTXT = 'El pedido n.º'.$clave_carrito.' ha sido cerrado';
			$cuerpotxt='<p style="padding:5px 15px">El vendedor aceptó tu solicitud de cancelación y el pedido n.º '.$clave_carrito.' ha sido cerrado. El pago se te reembolsará lo antes posible.</p><p style="padding:5px 15px">Recuerda: Deberías recibir tu reembolso en un plazo de 7-10 días hábiles. Si se retrasa, consulta con tu banco o con nosotros.</p>';
			$infoadd='<p style="font-size: 12px; padding: 5px 15px">Razón de cancelación:'.$razon.'</p>';
		}
	//CHECAMOS EL STATUS Y CAMBIAMOS LA INFO status=1 pagado, status=2enviado, status=3 cancelado
	//PARA CLIENTE
	$to = $mail;
	$subject="=?UTF-8?B?".base64_encode($subjectTXT)."=?=";
	$from = 'pedidos@ecommerce.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "Content-Transfer-Encoding: 8bit\r\n";
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$mailresponder."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$cuerpoMensaje = '<html><body>';
	$cuerpoMensaje .= '<center style="width:100%;table-layout:fixed;background-color:#e4e3e4">
<table width="600px" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="font-family:Ember,Arial,sans-serif;">
	<tbody>
	<tr><td valign="middle" height="80px" align="center">
	<a href="'.$UrlServerMail.'" target="_blank"><img src="'.$UrlServerMail.'img/ecommerce-ml.jpg" width="67"></a>
	</td></tr>
	<tr><td style="border-bottom: 1pt solid black;"></td></tr>
	<tr><td height="15px"></td></tr>
	<tr><td valign="middle" height="25px" align="center"><h3 style="margin: 10px 0 0 5px">'.$subjectTXT.'</h3></td></tr>
	<tr><td align="center"><p>Hola : '.$nombrecliente.'</p></td></tr>
	<tr><td height="10px"></td></tr>
	<tr><td align="center">'.$cuerpotxt.'</td></tr>
	<tr><td>'.$infoadd.'</tr></td>
	<tr><td height="25px"></td></tr>
	<tr><td><p style="padding: 5px 15px">Un saludo, ecommerce.com '.$now.'</p><p style=";padding: 5px 15px">Este email fue generado de manera automática. Por favor no lo respondas.</p></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td style="border-top: 1px solid black" height="15px"></td></tr>
	<tr><td>
		<table width="100%" align="center" cellspacing="0"  cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
			<tbody>
				<tr>
					<td valign="middle" height="80px" width="350px"><a href="'.$UrlServerMail.'" target="_blank"><img src="'.$UrlServerMail.'img/ecommerce-ml.jpg" width="67"></a></td>
					<td align="center">
						<a href="https://www.facebook.com/ecommerce/" title="Facebook" style="margin: 5px 5px 5px 5px"><img src="'.$UrlServerMail.'img/fb.jpg" alt="Facebook" width="25px"></a>
						<a href="https://www.instagram.com/ecommerce/" title="Instagram" style="margin: 5px 5px 5px 5px"><img src="'.$UrlServerMail.'img/insta.jpg" alt="Instagram" width="25px"></a>
						<a href="https://twitter.com/ecommerce" title="Twitter" style="margin: 5px 5px 5px 5px"><img src="'.$UrlServerMail.'img/tw.jpg" alt="Twitter" width="25px"></a>
					</td>
				</tr>
			</tbody>
		</table>
	</td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td style="background-color:#fdeb00" height="20px"></td></tr>
	</tbody>
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
