<?php
session_start();
if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
}
$_SERVER['HTTP_HOST'];
dirname($_SERVER['PHP_SELF']);
$server=$http.$_SERVER['HTTP_HOST']."/";
	require('../connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (!$conex) {
		die('No pudo conectarse: ');
	}else{
		date_default_timezone_set('America/Mexico_City');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		setlocale(LC_TIME, 'spanish');
		
		if((isset($_POST['iduser-can']) AND $_POST['iduser-can'] != "") AND (isset($_POST['idproduct-can']) AND $_POST['idproduct-can'] != "") AND (isset($_POST['idcarrito-can']) AND $_POST['idcarrito-can'] != "") ){
			$idUser = $_POST['iduser-can'];
			$idProducto = $_POST['idproduct-can'];
			$idCarrito = $_POST['idcarrito-can'];
			$razon = $_POST['razon-can'];
			$info = $_POST['info-can'];
			$sqlArticulos="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.notas_carrito, c.fecha_compra_carrito, c.precioart_carrito, 
			p.id_producto, p.nombre_producto, p.id_tienda_producto, p.img_a_producto, p.codigo_producto,
			t.id_tienda,  t.nombre_tienda, t.nick_tienda, t.categoria_tienda, t.email_tienda,
			r.id_cliente, r.nombre_cliente, r.apellidos_cliente, r.email_cliente
			FROM carrito c, productos p, tiendas t, clientes r
			WHERE c.id_user_carrito = $idUser AND c.clave_carrito = $idCarrito AND p.id_producto = c.id_producto_carrito AND c.id_vendedor_carrito = t.id_tienda AND c.id_carrito = $idProducto AND r.id_cliente = $idUser";
			$reqArticulos=mysqli_query($conex, $sqlArticulos);
			while($result = mysqli_fetch_object($reqArticulos)){
				$id_carrito = $result->id_carrito;
				$id_producto = $result->id_producto;
				$nombre_producto = $result->nombre_producto;
				$codigo_producto = $result->codigo_producto;
				$talla_producto_carrito = $result->talla_producto_carrito;
				$color_producto_carrito = $result->color_producto_carrito;
				$cantidad_producto_carrito = $result->cantidad_producto_carrito;
				$img_a_producto = $result->img_a_producto;
				$fecha_compra_carrito = date_create($result->fecha_compra_carrito);
				$precioart_carrito = $result->precioart_carrito;	
				$nombre_tienda = $result->nombre_tienda;	
				$nick_tienda = $result->nick_tienda;	
				$categoria_tienda = $result->categoria_tienda;
				$nombre_cliente = $result->nombre_cliente;
				$apellidos_cliente = $result->apellidos_cliente;
				$email_cliente = $result->email_cliente;
				$email_tienda = $result->email_tienda;
				$nombre_completo = $nombre_cliente.' '.$apellidos_cliente;
				$fechaPag = date_format($fecha_compra_carrito, 'd/m/Y');
			}
			//UPDATEINFO
			$updatecarrito="UPDATE carrito SET status_carrito = 3, razoncancelado_carrito = 'Razón del cliente: $razon' WHERE id_carrito = $id_carrito AND id_user_carrito = $idUser";
			if ($conex->query($updatecarrito) === TRUE) {
				echo 1;
			}else{
				echo 4;
			}
			
?>
<?php
//PARA TIENDA
$to = $email_tienda.',pedidos@ecommerce.com';
$subjectTXT = 'Lo sentimos '.$nombre_completo.' ha solicitado cancelar parte de su pedido #'.$idCarrito;
$subject="=?UTF-8?B?".base64_encode($subjectTXT)."=?=";			
$from = 'pedidos@ecommerce.com';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$email_cliente."\r\n" .
    'X-Mailer: PHP/' . phpversion();
$cuerpoMensaje = '<html><body>';
$cuerpoMensaje .= '
<center style="width:100%;table-layout:fixed;background-color:#e4e3e4">
<table width="600px" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="font-family:Ember,Arial,sans-serif;">
	<tbody>
	<tr><td valign="middle" height="80px" align="center">
	<a href="'.$server.'" target="_blank"><img src="'.$server.'img/ecommerce_logo-ml.jpg" width="67"></a>
	</td></tr>
	<tr><td style="border-bottom: 1pt solid black;"></td></tr>
	<tr><td height="15px"></td></tr>
	<tr><td valign="middle" height="25px" align="center"><h3 style="margin: 10px 0 0 5px">Lo sentimos '.$nombre_completo.' ha solicitado cancelar parte de su pedido #'.$idCarrito.'</h3></td></tr>
	<tr><td align="center"><p>Número de pedido: '.$idCarrito.'</p></td></tr>
	<tr><td height="10px"></td></tr>
	<tr><td align="center"><p>Fecha de pedido: '.$fechaPag.'</p></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td>
		<table width="100%" align="center" cellspacing="0" cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
		<tbody><tr>
		<td align="left" nowrap="" style="width:10%;border-top:2px solid #ccc;border-bottom:2px solid #ccc">Unidad</td>
		<td align="left" colspan="2" style="border-top:2px solid #ccc;border-bottom:2px solid #ccc">Nombre del producto y código de producto </td>
		<td align="left" colspan="1" style="border-top:2px solid #ccc;border-bottom:2px solid #ccc">Precio</td>
		</tr>
		<tr style="border-top:2px solid #ccc">
		<td align="center"> 
		'.$cantidad_producto_carrito.'
		</td>
		<td>
		<img style="float:left" src="'.$server.'img/tiendas/'.$nick_tienda.'/'.$img_a_producto.'" alt="product image" width="80px"> 
		</td>
		<td>
		<span style="display:table-cell;vertical-align:top;height:100%">
		'.$nombre_producto.' '.$color_producto_carrito.' '.$talla_producto_carrito.'
		<br>
		<span style="color:#808080">
		Código de producto: '.$codigo_producto.'
		</span>
		</span>
		</td>
		<td>$'.$precioart_carrito.'</td>
		</tr>
		</tbody></table>
	</td></tr>
	<tr><td style="border-bottom: 1px solid black" height="25px"></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td>
		<h3 style="margin-left: 15px">Nombre completo: '.$nombre_completo.'</h3>
		<h4 style="margin-left: 15px">Razón de la cancelación: '.$razon.'.</h4>
		<p style="margin-left: 15px"><strong>'.$info.'</strong></p>
		<p style="margin-left: 15px">'.$email_cliente.'</p>
	</td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td style="border-top: 1px solid black" height="15px"></td></tr>
	<tr><td>
		<table width="100%" align="center" cellspacing="0" cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
			<tbody>
				<tr>
					<td valign="middle" height="80px" width="350px"><a href="'.$server.'" target="_blank"><img src="'.$server.'img/ecommerce_logo-ml.jpg" width="67"></a></td>
					<td align="center">
						<a href="https://www.facebook.com/ecommerce/" title="Facebook" style="margin: 5px 5px 5px 5px"><img src="'.$server.'img/fb.jpg" alt="Facebook" width="25px"></a>
						<a href="https://www.instagram.com/ecommerce/" title="Instagram" style="margin: 5px 5px 5px 5px"><img src="'.$server.'img/insta.jpg" alt="Instagram" width="25px"></a>
						<a href="https://twitter.com/ecommerce" title="Twitter" style="margin: 5px 5px 5px 5px"><img src="'.$server.'img/tw.jpg" alt="Twitter" width="25px"></a>
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
    echo 2;
} else{
    echo 5;
}

//PARA CLIENTE
$toC = $email_cliente;
$subjectC = 'Hola '.$nombre_cliente.' lamentamos que quieras cancelar parte de tu pedido #'.$idCarrito;
$subjectC="=?UTF-8?B?".base64_encode($subjectC)."=?=";
$fromC = 'pedidos@ecommerce.com';
$headersC  = 'MIME-Version: 1.0' . "\r\n";
$headersC .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headersC .= 'From: '.$fromC."\r\n".
    'Reply-To: '.$email_tienda."\r\n" .
    'X-Mailer: PHP/' . phpversion();
$cuerpoMensajeC = '<html><body>';
$cuerpoMensajeC .= '
<center style="width:100%;table-layout:fixed;background-color:#e4e3e4">
<table width="600px" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="font-family:Ember,Arial,sans-serif;">
	<tbody>
	<tr><td valign="middle" height="80px" align="center">
	<a href="'.$server.'" target="_blank"><img src="'.$server.'img/ecommerce_logo-ml.jpg" width="67"></a>
	</td></tr>
	<tr><td style="border-bottom: 1pt solid black;"></td></tr>
	<tr><td height="15px"></td></tr>
	<tr><td valign="middle" height="25px" align="center"><h3 style="margin: 10px 0 0 5px">Esta es una copia del correo electrónico que enviaste a '.$nombre_tienda.'. No se requiere ninguna otra acción por tu parte. El vendedor se comunicará contigo si tiene alguna pregunta o comentario.</h3></td></tr>
	<tr><td align="center"><p>Número de pedido: '.$idCarrito.'</p></td></tr>
	<tr><td height="10px"></td></tr>
	<tr><td align="center"><p>Fecha de pedido: '.$fechaPag.'</p></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td>
		<table width="100%" align="center" cellspacing="0" cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
		<tbody><tr>
		<td align="left" nowrap="" style="width:10%;border-top:2px solid #ccc;border-bottom:2px solid #ccc">Unidad</td>
		<td align="left" colspan="2" style="border-top:2px solid #ccc;border-bottom:2px solid #ccc">Nombre del producto y código de producto </td>
		<td align="left" colspan="1" style="border-top:2px solid #ccc;border-bottom:2px solid #ccc">Precio</td>
		</tr>
		<tr style="border-top:2px solid #ccc">
		<td align="center"> 
		'.$cantidad_producto_carrito.'
		</td>
		<td>
		<img style="float:left" src="'.$server.'img/tiendas/'.$nick_tienda.'/'.$img_a_producto.'" alt="product image" width="80px"> 
		</td>
		<td>
		<span style="display:table-cell;vertical-align:top;height:100%">
		'.$nombre_producto.' '.$color_producto_carrito.' '.$talla_producto_carrito.'
		<br>
		<span style="color:#808080">
		Código de producto: '.$codigo_producto.'
		</span>
		</span>
		</td>
		<td>$'.$precioart_carrito.'</td>
		</tr>
		</tbody></table>
	</td></tr>
	<tr><td style="border-bottom: 1px solid black" height="25px"></td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td>
		<span>------------- Iniciar mensaje -------------</span>
		<h4 style="margin-left: 15px">Razón de cancelación: '.$razon.'.</h4>
		<p style="margin-left: 15px"><strong>'.$info.'</strong></p>
		<span>------------- Finalizar mensaje -------------</span>
	</td></tr>
	<tr><td height="25px"></td></tr>
	<tr><td style="border-top: 1px solid black" height="15px"></td></tr>
	<tr><td>
		<table width="100%" align="center" cellspacing="0" cellpadding="10" style="color:#000000;font-family:Ember,Arial,sans-serif;font-size:13px">
			<tbody>
				<tr>
					<td valign="middle" height="80px" width="350px"><a href="'.$server.'" target="_blank"><img src="'.$server.'img/ecommerce_logo-ml.jpg" width="67"></a></td>
					<td align="center">
						<a href="https://www.facebook.com/ecommerce/" title="Facebook" style="margin: 5px 5px 5px 5px"><img src="'.$server.'img/fb.jpg" alt="Facebook" width="25px"></a>
						<a href="https://www.instagram.com/ecommerce/" title="Instagram" style="margin: 5px 5px 5px 5px"><img src="'.$server.'img/insta.jpg" alt="Instagram" width="25px"></a>
						<a href="https://twitter.com/ecommerce" title="Twitter" style="margin: 5px 5px 5px 5px"><img src="'.$server.'img/tw.jpg" alt="Twitter" width="25px"></a>
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
// ENVIAR CORREO AL CLIENTE
if(mail($toC, $subjectC, $cuerpoMensajeC, $headersC)){
    echo 3;
} else{
    echo 6;
}

/*IF INFO IF CONECT*/
		}
}
?>