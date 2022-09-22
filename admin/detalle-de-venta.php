<?php
	session_start();
	require('connect/conect_usrer.php');
	if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
	}
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
	$last = explode("/", $server, 5);
	$urlparts = $http.$last[2].'/'.$last[3].'/';
	$conex->query("SET lc_time_names = 'es_MX';");
	date_default_timezone_set('America/Mexico_City');
	// Unix
	setlocale(LC_TIME, 'es_ES.UTF-8');
	// En windows
	setlocale(LC_TIME, 'spanish');
	setlocale(LC_MONETARY, 'es_MX');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['id']) AND $_GET['id']!=""){
		$totalcomision=0;
		$idProdcutoTienda = $_GET['id'];
		$sqlVentas="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.fecha_entrega_carrito, c.status_carrito, c.cancelacion_carrito, c.precioart_carrito, c.id_direccion, c.notas_carrito, c.paypal_orderID, c.costo_envio_carrito, c.empresa_envio_carrito, c.guia_envio_carrito, c.razoncancelado_carrito,
		p.id_producto, p.nombre_producto, p.img_a_producto,
		z.id_cliente, z.nombre_cliente, z.apellidos_cliente, z.email_cliente,
		d.id_direccion, d.id_cliente_direccion, d.nombre_direccion, d.num_cont_direccion, d.ref_direccion, d.calle_direccion, d.numero_direccion, d.estado_direccion, d.municipio_direccion, d.colonia_direccion, d.cp_direccion,
		t.id_tienda, t.nombre_tienda, t.nick_tienda, t.categoria_tienda
		FROM carrito c, productos p, clientes z, direcciones d, tiendas t
		WHERE c.id_vendedor_carrito = t.id_tienda AND c.status_carrito IS NOT NULL AND p.id_producto = c.id_producto_carrito AND z.id_cliente = c.id_user_carrito AND c.id_carrito = $idProdcutoTienda AND d.id_direccion = c.id_direccion AND d.id_cliente_direccion = c.id_user_carrito";
		$reqVentas=mysqli_query($conex, $sqlVentas);
		while($resulVentas = mysqli_fetch_object($reqVentas)){
			$id_carrito = $resulVentas->id_carrito;
			$clave_carrito= $resulVentas->clave_carrito;
			$status_carrito = $resulVentas->status_carrito;
			$talla_producto_carrito = $resulVentas->talla_producto_carrito;
			$color_producto_carrito = $resulVentas->color_producto_carrito;
			$cantidad_producto_carrito = $resulVentas->cantidad_producto_carrito;
			$fecha_compra_carrito = $resulVentas->fecha_compra_carrito;
			$fecha_entrega_carrito = $resulVentas->fecha_entrega_carrito;
			$precio_producto = $resulVentas->precioart_carrito;
			$cancelacion_carrito = $resulVentas->cancelacion_carrito;
			$notas_carrito = $resulVentas->notas_carrito;
			$paypal_orderID = $resulVentas->paypal_orderID;
			$costo_envio_carrito = $resulVentas->costo_envio_carrito;
			$empresa_envio_carrito = $resulVentas->empresa_envio_carrito;
			$guia_envio_carrito = $resulVentas->guia_envio_carrito;
			$razoncancelado_carrito = $resulVentas->razoncancelado_carrito;
			$nick_tienda = $resulVentas->nick_tienda;
			$nombre_tienda = $resulVentas->nombre_tienda;
			$categoria_tienda = $resulVentas->categoria_tienda;
			$id_tienda = $resulVentas->id_tienda;

			$img_a_producto = $resulVentas->img_a_producto;
			$nombre_cliente = $resulVentas->nombre_cliente;
			$nombre_producto = $resulVentas->nombre_producto;

			$nombre_cliente = $resulVentas->nombre_cliente;
			$apellidos_cliente = $resulVentas->apellidos_cliente;
			$email_cliente = $resulVentas->email_cliente;

			$nombre_cliente=$nombre_cliente.' '.$apellidos_cliente;
			
			//DATOS ENTREGA
			$nombre_direccion = $resulVentas->nombre_direccion;
			$num_cont_direccion = $resulVentas->num_cont_direccion;
			$calle_direccion = $resulVentas->calle_direccion;
			$ref_direccion = $resulVentas->ref_direccion;
			$numero_direccion = $resulVentas->numero_direccion;
			$estado_direccion = $resulVentas->estado_direccion;
			$municipio_direccion = $resulVentas->municipio_direccion;
			$colonia_direccion = $resulVentas->colonia_direccion;
			$cp_direccion = $resulVentas->cp_direccion;
			
		}
		
		//GET PERIODO CARRITO
		$SQLPercentReport="SELECT s.id_tienda_suscripcion, s.tipo_suscripcion, s.porcentaje_suscripcion_tiendas, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, t.id_tipo_tienda, t.nombre_tipo_tienda FROM suscripcion_tiendas s, tipos_tienda t WHERE s.id_tienda_suscripcion = $id_tienda AND (s.inicio_suscripcion <= '$fecha_compra_carrito' AND s.fin_suscripcion >= '$fecha_compra_carrito') AND t.id_tipo_tienda  = s.tipo_suscripcion";
		$reqPercentReport=mysqli_query($conex, $SQLPercentReport);
		if($reqPercentReport->num_rows !=0){
			while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
				$porcentaje = $resulPercentReport->porcentaje_suscripcion_tiendas;
				$nombre_tipo = $resulPercentReport->nombre_tipo_tienda;
			}
		}else{
			$SQLPercentReport="SELECT * FROM tipos_tienda WHERE id_tipo_tienda = 1";
			$reqPercentReport=mysqli_query($conex, $SQLPercentReport);
			while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
				$porcentaje = $resulPercentReport->porcentaje_tienda;
				$nombre_tipo = $resulPercentReport->nombre_tipo_tienda;
			}
		}
		
		
		switch ($status_carrito){
			case 1:
				$Status="Pagado";
			break;
			case 2:
				$Status="Enviado";
			break;
			case 3:
				$Status="Cancelado";
			break;
		}
		if($costo_envio_carrito =="" OR $costo_envio_carrito ==NULL){
			$costo_envio_carrito=0;
		}
		
		//SUB TOTAL CON IVA
		$subtotal = ($cantidad_producto_carrito * $precio_producto);		
		//TOTAL CON IVA
		$total = $subtotal+$costo_envio_carrito;		
		//PRODUCTO MENOS IVA
		$producto_menos_iva= $subtotal/1.16;		
		//ENVIO - IVA
		$envio_menos_iva = $costo_envio_carrito /1.16;
		//PRODUCTO SIN COMISION
		$producto_precio_vendedor = $producto_menos_iva / (1+($porcentaje/100));		
		//COMISION
		$comision_sin_iva = ($producto_menos_iva - $producto_precio_vendedor);			
		//IVA TOTAL
		$iva_Total = $total - ($producto_menos_iva+$envio_menos_iva);
		//TOTAL RECEPCIÓN VENDEDOR
		$total_recepcion= ($producto_precio_vendedor+$envio_menos_iva);	
		
		$prod_fact = $total_recepcion - $envio_menos_iva;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ver detalla del pedido <?php echo $id_carrito.' - '.$clave_carrito?> | Ecommerce</title>
<?php include("parts/header.php");?>
<style>
	.mysalesprodcut th.img {width: 100px;}
</style>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light right-content">
				<div class="container">
					<div class="nav justify-content-end w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'admin'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lateralpanel" aria-controls="lateralpanel" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
				</div>
			</nav>
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
				 <li class="breadcrumb-item"><a href="<?php echo SITE?>admin/escaparates">Escaparates</a></li>
				  <li class="breadcrumb-item"><a href="<?php echo SITE?>admin/escaparates/reportes?id=<?php echo $id_tienda ?>&escaparate=<?php echo $nick_tienda?>&cat=<?php echo $categoria_tienda?>"><?php echo $nick_tienda?></a></li>
				 <li class="breadcrumb-item active" aria-current="page">Detalle de la venta</li>
			  </ol>
			</nav>
			<section id="info-content">
			<div class="row">
			<div class="col-md-9 col-sm-8">
				<h1 id="titlesection"><?php echo $nombre_producto?></h1>
				<small>Venta #<?php echo $clave_carrito?> | <?php echo strftime("%d de %B de %Y", strtotime($fecha_compra_carrito))?></small>
				<div class="card" style="margin-bottom: 15px">
  					<div class="card-body">
						<h3><?php echo $nombre_cliente?></h3>
						<p class="Vemailc"><?php echo $email_cliente?></p>
					</div>
				</div>
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<strong><?php echo $Status?></strong>
						<?php if($fecha_entrega_carrito!= ""){
						?>
						<span style="display: block"><?php echo strftime("%d de %B de %Y", strtotime($fecha_entrega_carrito))?></span>
						<?php
						}?>
						<hr>
						<table class="table table-striped mysalesprodcut">
							<tbody>
								<tr>
									<th scope="row" class="img"><img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$img_a_producto?>" class="img-fluid" alt="<?php echo $nombre_producto?>" height="80px"></th>
									<td class="name" valign="middle" align="left"><?php echo $nombre_producto?></td>
									<td class="precio" valign="middle" align="center">Precio:<br>$<?php echo number_format($producto_precio_vendedor, 2, '.', ',');?></td>
									<td class="cantidad" valign="middle" align="center"><?php echo $cantidad_producto_carrito?>u.</td>
									<td class="variante" valign="middle" align="left"><span>Tamaño / Variante: <strong><?php echo $talla_producto_carrito?></strong></span><span>Color / Atributos: <strong><?php echo $color_producto_carrito?></strong></span>
									<td valign="middle" align="center">Envío:<br>$<?php echo number_format($envio_menos_iva, 2, '.', ',');?></td>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										<p style="font-size: 12px; font-weight: bold">Datos del envío</p>
										<ul class="list-unstyled">
											<?php if($empresa_envio_carrito !=""){
											?>
											<li><?php echo $empresa_envio_carrito?></li>
											<li><?php echo $guia_envio_carrito?></li>
											<hr>
											<?php } ?>
											<li>Nombre de receptor: <?php echo $nombre_direccion?></li>
											<li>Número de contacto: <?php echo $num_cont_direccion?></li>
											<li>CP <?php echo $cp_direccion?></li>
											<li><?php echo $calle_direccion?> <?php echo $numero_direccion?> <?php echo $colonia_direccion?> - <?php echo $municipio_direccion?> <?php echo $estado_direccion?></li>		
											<li>Referencias: <?php echo $ref_direccion?> </li>
										</ul>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<strong>Notas</strong>
						<hr>
						<p><?php echo $notas_carrito ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-4">
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<strong>Cobro aprobado</strong>
						<hr>
						<p>ID PayPal: <a href="#" style="font-weight: bold" data-toggle="modal" data-target="#infopaypal-<?php echo $clave_carrito?>"><?php echo $paypal_orderID?></a></p>
						<table class="table">
							<tbody id="list-ticket">
								<tr>
									<td>Producto:</td>
									<td align="right">$<?php echo number_format($prod_fact, 2, '.', ',')?></td>
								</tr>
								<tr>
									<td>Envío:</td>
									<td align="right">$<?php echo number_format($envio_menos_iva, 2, '.', ',');?>
									</td>
								</tr>
								<tr>
									<td>Comisión <?php echo $porcentaje.'%'?>:</td>
									<td align="right">$<?php echo number_format($comision_sin_iva, 2, '.', ','); ?></td>
								</tr>
								<tr>
									<td><strong>Subtotal:</strong></td>
									<?php $subtotal_sin_iva=$prod_fact+$envio_menos_iva+$comision_sin_iva;?>
									<td align="right">$<?php echo number_format($subtotal_sin_iva, 2, '.', ','); ?></td>
								</tr>
								<tr>
									<td>IVA:</td>
									<td align="right">$<?php echo number_format($iva_Total, 2, '.', ',');?>
									</td>
								</tr>
								<tr id="total-box-carrito">
									<td valign="middle" id="totalbox">Total: </td>
									<td valign="middle" align="right" id="totalnum">$<?php echo number_format($total, 2, '.', ',')?></td>
								</tr>
							</tbody>
						</table>
					</div>					
				</div>
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<strong>Status:</strong>
						<hr>
						<?php
							$hiddenclass;
							
							switch ($status_carrito){
								case 1:
									$txtStatus="Pagado";
								break;
								case 2:
									$txtStatus="Enviado";
								break;
								case 3:
									$txtStatus="Cancelado";
								break;
							}
								
						
						?>
						<p><?php echo $txtStatus?></p>
						<?php if($status_carrito==1 OR $status_carrito ==2){?>
						<p><?php echo $empresa_envio_carrito?></p>
						<p><?php echo $guia_envio_carrito?></p>
							
						<?php }else{?>
							<h3>Cancelado</h3>
							<p><?php echo $razoncancelado_carrito?></p>
						<?php } ?>
						</form>
					</div>
				</div>
			</div>
			<!--INFO PAYPAL-->
				<div class="modal fade" tabindex="-1" role="dialog" id="infopaypal-<?php echo $clave_carrito?>">
				  <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title">Información PayPal <i class="fab fa-paypal"></i></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						  <?php 
							$sqlPayPal="SELECT * FROM pagos_tienda WHERE clave_pedido_pago_tienda = $clave_carrito";
							$reqPayPal=mysqli_query($conex, $sqlPayPal);
							$row_cnt = $reqPayPal->num_rows;
							if($row_cnt !=0){
								while($resultPayPal = mysqli_fetch_object($reqPayPal)){
									$clave_pedido_pago_tienda = $resultPayPal->clave_pedido_pago_tienda;
									$fecha_pago_tienda = $resultPayPal->fecha_pago_tienda;
									$orderID_paypal = $resultPayPal->orderID_paypal;
									$email_paypal = $resultPayPal->email_paypal;
									$status_paypal = $resultPayPal->status_paypal;
									$transaccionID_paypal = $resultPayPal->transaccionID_paypal;
									$cantidadPago_paypal = $resultPayPal->cantidadPago_paypal;
									$fechaPago_paypal = $resultPayPal->fechaPago_paypal;
									$direccion_paypal = $resultPayPal->direccion_paypal;
								}
							}
						  ?>
						<p>Clave de pedido: <?php echo $clave_pedido_pago_tienda?></p>
						  <p>Id Orden Paypal: <?php echo $orderID_paypal?></p>
						  <p>Id de trasacción: <?php echo $transaccionID_paypal?></p>
						  <p>Recibido: $<?php echo number_format($cantidadPago_paypal, 2, '.', ',');?></p>
						  <p>Pago recibido: <?php echo $fechaPago_paypal?></p>
						  <p>Dirección de PayPal: <?php echo $direccion_paypal?></p>
					  </div>
					</div>
				  </div>
				</div>
			<!--INFO PAYPAL-->
			</div>
			</section>	
	</div>
	</section>
</body>
</html>