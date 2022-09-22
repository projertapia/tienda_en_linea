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
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.$server.'entrar');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mis ventas - <?php echo NICKTIENDA?> | Ecommerce</title>
<?php include("parts/header.php");?>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light right-content">
				<div class="container">
					<div class="nav justify-content-end w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'mi-escaparate'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce.svg" alt="Ecommerce" width="82px"></a> 
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lateralpanel" aria-controls="lateralpanel" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
				</div>
			</nav>
			<section id="info-content">
				<div class="row">
					<div class="col-12">
						<h1 id="titlesection">Mis Ventas</h1>
					</div>
					<div class="clearfix"></div>
					<div class="col-12">
						<?php
							$id_tienda = IDTIENDA;
							$sqlVentas="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.fecha_entrega_carrito, c.status_carrito, c.cancelacion_carrito, c.precioart_carrito,
							p.id_producto, p.nombre_producto, p.img_a_producto,
							z.id_cliente, z.nombre_cliente, z.apellidos_cliente, z.email_cliente
							FROM carrito c, productos p, clientes z
							WHERE c.id_vendedor_carrito = $id_tienda AND c.status_carrito IS NOT NULL AND p.id_producto = c.id_producto_carrito AND z.id_cliente = c.id_user_carrito";
							$reqVentas=mysqli_query($conex, $sqlVentas);
							while($resulVentas = mysqli_fetch_object($reqVentas)){
								$id_carrito = $resulVentas->id_carrito;
								$clave_carrito = $resulVentas->clave_carrito;
								$status_carrito = $resulVentas->status_carrito;
								$talla_producto_carrito = $resulVentas->talla_producto_carrito;
								$color_producto_carrito = $resulVentas->color_producto_carrito;
								$cantidad_producto_carrito = $resulVentas->cantidad_producto_carrito;
								$fecha_compra_carrito = date_create($resulVentas->fecha_compra_carrito);
								$fecha_entrega_carrito = date_create($resulVentas->fecha_entrega_carrito);
								$precio_producto = $resulVentas->precioart_carrito;
								$cancelacion_carrito = $resulVentas->cancelacion_carrito;
								
								$img_a_producto = $resulVentas->img_a_producto;
								$nombre_cliente = $resulVentas->nombre_cliente;
								$nombre_producto = $resulVentas->nombre_producto;
								
								$nombre_cliente = $resulVentas->nombre_cliente;
								$apellidos_cliente = $resulVentas->apellidos_cliente;
								$email_cliente = $resulVentas->email_cliente;
								
								$nombre_cliente=$nombre_cliente.' '.$apellidos_cliente;
								switch ($status_carrito){
									case 1:
										$Status="Pagado";
										$Fecha= date_format($fecha_compra_carrito,'d-m-Y');
									break;
									case 2:
										$Status="Enviado";
										$Fecha= date_format($fecha_entrega_carrito,'d-m-Y');
									break;
									case 3:
										$Status="Cancelado";
										$Fecha= "-";
									break;
								}
						?>
						<div class="card-header lista-prodcutos table-responsive">
							<div class="box-status row">
								<div class="col-sm-7">
									<span class="Vstatus">Status: <?php echo $Status?></span>
									<span class="Vfecha">Fecha:<?php echo $Fecha?></span>
									<span class="Vpedidos">Pedido:<?php echo $clave_carrito?></span>
								</div>
								<div class="col-sm-2">
									<a href="mis-ventas/detalle-de-venta?id=<?php echo $id_carrito.'&v='.$clave_carrito?>" class="btn btn-outline-primary btn-detalle">Ver detalle</a>
								</div>
								<div class="col-sm-3">
									<div class="contact-info-V">
										<span class="Vnombrec"><?php echo $nombre_cliente?></span>
										<a class="Vemailc" href="mailto:<?php echo $email_cliente?>?subject=Informaci%C3%B3n%20sobre%20su%20pedido%20%23%20<?php echo $clave_carrito?>%20del%20escaparate%20<?php echo NICKTIENDA?>&body=Hola%20tenemos%20informaci%C3%B3n%20sobre%20tu%20pedido" target="_blank"><?php echo $email_cliente?></a>
									</div>
								</div>
							</div>
							<hr>
							<table class="table table-striped mysalesprodcut">
								<tbody>
									<tr>
										<th scope="row" class="img"><img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_a_producto?>" class="img-fluid" alt="<?php echo $nombre_producto?>" width="50px"></th>
										<td class="name" valign="middle" align="left"><?php echo $nombre_producto?></td>
										<td class="precio" valign="middle" align="center">$<?php echo $cantidad_producto_carrito * $precio_producto?></td>
										<td class="cantidad" valign="middle" align="center"><?php echo $cantidad_producto_carrito?>u.</td>
										<td class="variante" valign="middle" align="left"><span>Tamaño / Variante: <strong><?php echo $talla_producto_carrito?></strong></span><span>Color / Atributos: <strong><?php echo $color_producto_carrito?></strong></span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php }?>
					</div>
				</div>
			</section>
		</div>
	</section>
	<?php include('parts/footer.php');?>
</body>
</html>