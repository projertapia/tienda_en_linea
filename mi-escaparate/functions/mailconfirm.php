<?php
	function sendMailCliente($id_tienda , $nick_tienda,$email_tienda,$new){
		if (isset($_SERVER['HTTPS'])) {
		$httpadsC="https://";}else{
		$httpadsC="http://";
		}
		$_SERVER['HTTP_HOST'];
		dirname($_SERVER['PHP_SELF']);
		$UrlServerMailC=$httpadsC.$_SERVER['HTTP_HOST']."/";
		//PARA TIENDA
		$toC = $email_tienda;
		$fromC = 'contacto@ecommerce.com';
		
		$headersC  = 'MIME-Version: 1.0' . "\r\n";
		$headersC .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
		$headersC .= "Content-Transfer-Encoding: 8bit\r\n";
		$headersC .= 'From: '.$fromC."\r\n".
			'Reply-To: '.$fromC."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$cuerpoMensajeC = '<html><body>';
		if($new == "primermail"){
			
			$subjectC= 'Bienvenido a Ecommerce.';
			$subjectC="=?UTF-8?B?".base64_encode($subjectC)."=?=";
			$txt = 'Bienvenido a tu nuevo escaparate '.$nick_tienda.'.';
		};
		if($new == "segundomail"){
			$subjectC= 'Tu escaparate esta listo para comenzar a vender.';
			$subjectC="=?UTF-8?B?".base64_encode($subjectC)."=?=";
			$txt = 'El escaparate '.$nick_tienda.' esta listo para comenzar a vender.';
		}
		
		
		
		$cuerpoMensajeC .= '<center style="width:100%;table-layout:fixed;background-color:#e4e3e4">
<table width="600px" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="font-family:Ember,Arial,sans-serif;">
	<tbody>
	<tr><td valign="middle" height="80px" align="center">
	<a href="'.$UrlServerMailC.'" target="_blank"><img src="'.$UrlServerMailC.'img/ecommerce_logo-ml.jpg" width="67"></a>
	</td></tr>
	<tr><td style="border-bottom: 1pt solid black;"></td></tr>
	<tr><td height="15px"></td></tr>
	<tr><td valign="middle" height="25px" align="left"><h3 style="margin: 10px 0 0 15; color: #e63425;">'.$txt.' </h3></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td style="border-top: 1px solid black" height="15px"></td></tr>
	<tr><td>
		<table width="100%" align="center" cellspacing="0"  cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
			<tbody>
				<tr>
					<td valign="middle" height="80px" width="350px"><a href="'.$UrlServerMailC.'" target="_blank"><img src="'.$UrlServerMailC.'img/ecommerce_logo-ml.jpg" width="67"></a></td>
					<td align="center">
						<a href="https://www.facebook.com/ecommerce/" title="Facebook" style="margin: 5px 5px 5px 5px"><img src="'.$UrlServerMailC.'img/fb.jpg" alt="Facebook" width="25px"></a>
						<a href="https://www.instagram.com/ecommerce/" title="Instagram" style="margin: 5px 5px 5px 5px"><img src="'.$UrlServerMailC.'img/insta.jpg" alt="Instagram" width="25px"></a>
						<a href="https://twitter.com/ecommerce" title="Twitter" style="margin: 5px 5px 5px 5px"><img src="'.$UrlServerMailC.'img/tw.jpg" alt="Twitter" width="25px"></a>
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
		$cuerpoMensajeC .= '</body></html>';
		// ENVIAR CORREO A TIENDA
		if(mail($toC, $subjectC, $cuerpoMensajeC, $headersC)){
			//echo  1;
		} else{
			//echo  2;
		};

	}
?>