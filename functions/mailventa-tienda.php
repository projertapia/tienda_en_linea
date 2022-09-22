<?php
	function sendMailTienda($user_id, $clave_carrito,$id_vendedor_carrito){
		
	if (isset($_SERVER['HTTPS'])) {
		$httpads="https://";}else{
		$httpads="http://";
		}
		$_SERVER['HTTP_HOST'];
		dirname($_SERVER['PHP_SELF']);
		$UrlServerMail=$httpads.$_SERVER['HTTP_HOST']."/";
		$mailconectT = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
		
	$sqlcarritoT ="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.status_carrito, c.id_producto_carrito, c.id_vendedor_carrito, c.precioart_carrito, c.cantidad_producto_carrito, c.color_producto_carrito, c.talla_producto_carrito, c.notas_carrito, c.costo_envio_carrito, c.id_direccion, c.fecha_compra_carrito,
	p.id_producto, p.nombre_producto, p.img_a_producto, p.id_tienda_producto, p.precio_producto, p.precio_promo_producto, p.talla_producto, p.color_tallas, p.activo_producto, p.tarifa_envio_producto, p.costo_envio_productos, p.codigo_producto,
	t.categoria_tienda, t.id_tienda, t.nick_tienda, t.email_tienda	
	FROM carrito c, productos p, tiendas t
	WHERE c.id_user_carrito = '$user_id' AND c.clave_carrito = '$clave_carrito' AND c.id_producto_carrito = p.id_producto AND t.id_tienda = p.id_tienda_producto AND c.id_vendedor_carrito = '$id_vendedor_carrito' AND c.status_carrito IS NOT NULL";
	$reqProductosT=mysqli_query($mailconectT, $sqlcarritoT);
	$reqDateT=mysqli_query($mailconectT, $sqlcarritoT);
	$reqData=mysqli_query($mailconectT, $sqlcarritoT);	
	while($dateT = mysqli_fetch_object($reqDateT)){
		$fecha_compra_carrito = date_create($dateT->fecha_compra_carrito);
		$id_direccion = $dateT->id_direccion;
		$notas_carrito = $dateT->notas_carrito;
		$email_tienda =$dateT->email_tienda;
		$fechaPag = date_format($fecha_compra_carrito, 'd/m/Y');
	}
	$sqlDirT="SELECT d.id_cliente_direccion, d.nombre_direccion, d.num_cont_direccion, d.ref_direccion, d.calle_direccion, d.numero_direccion, d.estado_direccion, d.municipio_direccion, d.colonia_direccion, d.cp_direccion,
	w.id_cliente, w.email_cliente, w.nombre_cliente, w.apellidos_cliente
	FROM direcciones d, clientes w WHERE d.id_cliente_direccion = $user_id AND d.id_direccion = $id_direccion AND w.id_cliente = $user_id";
	$reqDirT=mysqli_query($mailconectT, $sqlDirT);
	while($dataT = mysqli_fetch_object($reqDirT)){
		$nombre_direccion = $dataT->nombre_direccion;
		$num_cont_direccion = $dataT->num_cont_direccion;
		$ref_direccion = $dataT->ref_direccion;
		$calle_direccion = $dataT->calle_direccion;
		$numero_direccion = $dataT->numero_direccion;
		$estado_direccion = $dataT->estado_direccion;
		$municipio_direccion = $dataT->municipio_direccion;
		$colonia_direccion = $dataT->colonia_direccion;
		$cp_direccion = $dataT->cp_direccion;	
		$email_cliente = $dataT->email_cliente;
		$nombre_cliente = $dataT-> nombre_cliente;
		$apellidos_cliente = $dataT->apellidos_cliente;	
		$nombre_completo = $nombre_cliente.' '.$apellidos_cliente;
	}
	
	//PARA TIENDA
	$to = $email_tienda;
	$subject = 'Tienes una nueva compra de '.$nombre_completo.' No. de pedido: '.$clave_carrito;
	$subject="=?UTF-8?B?".base64_encode($subject)."=?=";
	$from = 'pedidos@ecommerce.com';
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
	<a href="'.SITEUSER.'" target="_blank"><img src="'.SITEUSER.'img/ecommerce_logo-ml.jpg" width="67"></a>
	</td></tr>
	<tr><td style="border-bottom: 1pt solid black;"></td></tr>
	<tr><td height="15px"></td></tr>
	<tr><td valign="middle" height="25px" align="center"><h3 style="margin: 10px 0 0 5px">Felicidades '.$nombre_completo.' te ha hecho un pedido.</h3></td></tr>
	<tr><td align="center"><p>Número de pedido: '.$clave_carrito.'</p></td></tr>
	<tr><td height="10px"></td></tr>
	<tr><td align="center"><p>Fecha de pedido: '.$fechaPag.'</p></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td>
		<table width="100%" align="center" cellspacing="0" cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
		<tbody><tr>
		<td align="left" nowrap="" style="width:10%;border-top:2px solid #ccc;border-bottom:2px solid #ccc">Unidad</td>
		<td align="left" colspan="2" style="border-top:2px solid #ccc;border-bottom:2px solid #ccc">Nombre del producto y código de producto </td>
		<td align="left" colspan="1" style="border-top:2px solid #ccc;border-bottom:2px solid #ccc">Precio</td>
		<td align="left" colspan="1" style="border-top:2px solid #ccc;border-bottom:2px solid #ccc">Envío</td>
		</tr>
		';
		while($result = mysqli_fetch_object($reqProductosT)){
			$id_producto = $result->id_producto;
			$cantidad_producto_carrito = $result->cantidad_producto_carrito;
			$nick_tienda = $result->nick_tienda;
			$img_a_producto = $result->img_a_producto;
			$nombre_producto = $result->nombre_producto;
			$color_producto_carrito = $result->color_producto_carrito;
			$talla_producto_carrito = $result->talla_producto_carrito;
			$codigo_producto = $result->codigo_producto;
			$precioart_carrito = $result->precioart_carrito;
			$costo_envio_carrito = $result ->costo_envio_carrito;
		$cuerpoMensaje .='
		<tr style="border-top:2px solid #ccc">
			<td align="center">'.$cantidad_producto_carrito.'</td>
			<td>
				<img style="float:left" src="'.SITEUSER.'img/tiendas/'.$nick_tienda.'/'.$img_a_producto.'" alt="product image" width="80px"> 
			</td>
			<td>
				<span style="display:table-cell;vertical-align:top;height:100%">
				'.$nombre_producto.', '.$color_producto_carrito.', '.$talla_producto_carrito.'
				<br>
				<span style="color:#808080">
				Código de producto: '.$codigo_producto.'
				</span>
				</span>
			</td>
			<td>$'.$precioart_carrito.'</td>
			<td>$'.$costo_envio_carrito.'</td>
		</tr>
		';
		}
		$cuerpoMensaje .='
		</tbody></table>
	</td></tr>
	<tr><td style="border-bottom: 1px solid black" height="25px"></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td>
		<h3 style="margin-left: 15px">Nombre de cliente: '.$nombre_completo.'</h3>
		<hr>
		<h3 style="margin-left: 15px">Nombre de quien recibe: '.$nombre_direccion .'</h3>
		<h4 style="margin-left: 15px">Dirección de envio:</h4>
		<p style="margin-left: 15px">Calle: '.$calle_direccion.'.</p>
		<p style="margin-left: 15px">Número: '.$num_cont_direccion.'.</p>
		<p style="margin-left: 15px">Municipio: '.$municipio_direccion.'.</p>
		<p style="margin-left: 15px">Colonia: '.$colonia_direccion.'.</p>
		<p style="margin-left: 15px">CP: '.$cp_direccion.'.</p>
		<p style="margin-left: 15px">Referencias: '.$ref_direccion.'.</p>
		<p style="margin-left: 15px">Estado: '.$estado_direccion.'.</p>	
		<p style="margin-left: 15px">Teléfono de contacto:<strong>'.$num_cont_direccion.'</strong></p>
		<p style="margin-left: 15px">Email de contacto:<strong>'.$email_cliente.'</strong></p>
		<hr>
		<p style="margin-left: 15px"><strong>Notas de pedido:</strong></p>
		<p style="margin-left: 15px">'.$notas_carrito.'</p>
	</td></tr>
	<tr><td height="25px"></td></tr>
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
