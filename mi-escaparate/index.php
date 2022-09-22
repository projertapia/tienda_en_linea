<?php

	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');
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
<title><?php echo NICKTIENDA?> en | Ecommerce</title>
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
						<h1 id="titlesection">Inicio</h1>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Mis ventas</strong>
							<?php $sqlventas="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito IS NOT NULL AND  status_carrito != 3 AND id_vendedor_carrito = $id_tienda";
							$ventas=mysqli_query($conex, $sqlventas);?>
							<h1><?php echo $ventas->num_rows;?></h1>
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Envíos pendientes</strong>
							<?php $sqlenvio="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito = 1 AND id_vendedor_carrito = $id_tienda";
							$envio=mysqli_query($conex, $sqlenvio);?>
							<h1><?php echo $envio->num_rows;?></h1>
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Envíos realizados</strong>
							<?php $sqlenvio="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito = 2 AND id_vendedor_carrito = $id_tienda";
							$envio=mysqli_query($conex, $sqlenvio);?>
							<h1><?php echo $envio->num_rows;?></h1>
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Pedidos cancelados</strong>
							<?php $sqlenvio="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito = 3 AND id_vendedor_carrito = $id_tienda";
							$envio=mysqli_query($conex, $sqlenvio);?>
							<h1><?php echo $envio->num_rows;?></h1>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-12">
						<div class="card-header lista-prodcutos box-status">
							<strong>Pendientes de envío</strong>
							<div class="table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">№ Pedido</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre</th>
										<th scope="col">Categorías</th>
										<th scope="col">Precio</th>
										<th scope="col">Cantidad</th>
										<th scope="col" colspan="2">Fecha</th>
									</tr>
								</thead>
							<tbody>
							<?php
							$id_tienda = IDTIENDA;
							$sqlVentas="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.fecha_entrega_carrito, c.status_carrito, c.cancelacion_carrito, c.precioart_carrito, c.costo_envio_carrito,
							p.id_producto, p.nombre_producto, p.img_a_producto, p.categoria_producto,
							z.id_cliente, z.nombre_cliente, z.apellidos_cliente, z.email_cliente
							FROM carrito c, productos p, clientes z
							WHERE c.id_vendedor_carrito = $id_tienda AND (c.status_carrito = 1) AND p.id_producto = c.id_producto_carrito AND z.id_cliente = c.id_user_carrito ORDER BY c.fecha_compra_carrito";
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
								$precio_producto = ($cantidad_producto_carrito * $resulVentas->precioart_carrito);
								$costo_envio_carrito = $resulVentas->costo_envio_carrito;
								$cancelacion_carrito = $resulVentas->cancelacion_carrito;
								$categoria_producto = $resulVentas->categoria_producto;
								
								$img_a_producto = $resulVentas->img_a_producto;
								$nombre_cliente = $resulVentas->nombre_cliente;
								$nombre_producto = $resulVentas->nombre_producto;
								
								$nombre_cliente = $resulVentas->nombre_cliente;
								$apellidos_cliente = $resulVentas->apellidos_cliente;
								$email_cliente = $resulVentas->email_cliente;
								
								$nombre_cliente=$nombre_cliente.' '.$apellidos_cliente;
								$fecha = date_format($fecha_compra_carrito, 'Y-m-d');
								$hora = date_format($fecha_compra_carrito, ' H:i:s');
								
								$precioFinal=$precio_producto+$costo_envio_carrito;
							?>
							<tr>
								<th scope="row"><?php echo $clave_carrito?></th>
								<td><img src="../img/tiendas/<?php echo $nick_tienda.'/'.$img_a_producto?>" alt="" class="img-fluid" width="80px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
								<td><?php echo $nombre_producto?></td>
								<td><?php echo $categoria_producto?></td>
								<td><span>$<?php echo $precioFinal?><small> mxn.</small></span><span></span></td>
								<td><?php echo $cantidad_producto_carrito?> u.</td>
								<td><?php HaceCuanto::imprimirTiempo($fecha,$hora)?><span><?php echo $fecha?></span></td>
								<td><a href="mis-ventas/detalle-de-venta?id=<?php echo $id_carrito.'&v='.$clave_carrito?>">Ver Detalle</a></td>
							</tr>
							<?php
							}
							?>
								</tbody>
							</table>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="card-header lista-prodcutos box-status">
							<strong>Últimos pedidos cancelados</strong>
							<div class="table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">№ Pedido</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre cliente</th>
										<th scope="col">Email cliente</th>
										<th scope="col">Razón</th>
										<th scope="col" colspan="2">Fecha</th>
									</tr>
								</thead>
							<tbody>
							<?php
							$id_tienda = IDTIENDA;
							$sqlVentas="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.fecha_entrega_carrito, c.status_carrito, c.cancelacion_carrito, c.razoncancelado_carrito, c.precioart_carrito,
							p.id_producto, p.nombre_producto, p.img_a_producto, p.categoria_producto,
							z.id_cliente, z.nombre_cliente, z.apellidos_cliente, z.email_cliente
							FROM carrito c, productos p, clientes z
							WHERE c.id_vendedor_carrito = $id_tienda AND (c.status_carrito = 3) AND p.id_producto = c.id_producto_carrito AND z.id_cliente = c.id_user_carrito ORDER BY c.fecha_compra_carrito";
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
								$categoria_producto = $resulVentas->categoria_producto;
								$razoncancelado_carrito= $resulVentas->razoncancelado_carrito;
								if($razoncancelado_carrito==""){$razoncancelado_carrito='-';};
								
								$img_a_producto = $resulVentas->img_a_producto;
								$nombre_cliente = $resulVentas->nombre_cliente;
								$nombre_producto = $resulVentas->nombre_producto;
								
								$nombre_cliente = $resulVentas->nombre_cliente;
								$apellidos_cliente = $resulVentas->apellidos_cliente;
								$email_cliente = $resulVentas->email_cliente;
								
								$nombre_cliente=$nombre_cliente.' '.$apellidos_cliente;
								$fecha = date_format($fecha_compra_carrito, 'Y-m-d');
								$hora = date_format($fecha_compra_carrito, ' H:i:s');
							?>
							<tr>
								<th scope="row"><?php echo $clave_carrito?></th>
								<td><img src="../img/tiendas/<?php echo $nick_tienda.'/'.$img_a_producto?>" alt="" class="img-fluid" width="80px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
								<td><?php echo $nombre_cliente?></td>
								<td><a href="mailto:<?php echo $email_cliente?>"><?php echo $email_cliente?></a></td>
								<td><span><?php echo $razoncancelado_carrito?></span></td>
								<td><?php HaceCuanto::imprimirTiempo($fecha,$hora)?><span><?php echo $fecha?></span></td>
								<td><a href="mis-ventas/detalle-de-venta?id=<?php echo $id_carrito.'&v='.$clave_carrito?>">Ver Detalle</a></td>
							</tr>
							<?php
							}
							?>
								</tbody>
							</table>
						</div>
						</div>
					</div>
					<div class="col-12">
						<div class="card-header lista-prodcutos box-status">
							<strong>Los más comprados</strong>
							<div class="table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">№ Producto</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre de producto</th>
										<th scope="col">Color/Variante</th>
										<th scope="col">Talla/Tamaño</th>
										<th scope="col">Ventas</th>
									</tr>
									<tbody>
										<?php
											$SQLMasVendido="SELECT c.color_producto_carrito, c.id_vendedor_carrito, c.id_producto_carrito, COUNT(c.cantidad_producto_carrito) AS total, SUM(c.cantidad_producto_carrito) AS cventas, c.talla_producto_carrito,
											p.id_producto, p.nombre_producto, p.img_a_producto, p.codigo_producto
											FROM carrito c, productos p
											WHERE c.id_vendedor_carrito = $id_tienda AND c.id_producto_carrito = p.id_producto AND (c.status_carrito = 1 OR c.status_carrito = 2) GROUP BY c.id_producto_carrito ORDER BY cventas DESC";
											$reqMasVendido=mysqli_query($conex, $SQLMasVendido);
											while($resulMasVendido = mysqli_fetch_object($reqMasVendido)){
												$id_producto_carrito = $resulMasVendido->id_producto_carrito;
												$total = $resulMasVendido->total;
												$cventas = $resulMasVendido->cventas;
												$nombre_producto = $resulMasVendido->nombre_producto;
												$img_a_producto= $resulMasVendido->img_a_producto;
												$codigo_producto= $resulMasVendido->codigo_producto;
												$talla_producto_carrito= $resulMasVendido->talla_producto_carrito;
												$color_producto_carrito= $resulMasVendido->color_producto_carrito;
										?>
										<tr>
											<td><?php echo $codigo_producto?></td>
											<td><img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_a_producto?>" class="img-fluid" width="120px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
											<td><?php echo $nombre_producto?></td>
											<td><?php echo $color_producto_carrito?></td>
											<td><?php echo $talla_producto_carrito?></td>
											<td><?php echo $cventas?></td>
										</tr>
										<?php } ?>
									</tbody>
								</thead>
							</table>
						</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<?php include('parts/footer.php');?>
</body>
</html>