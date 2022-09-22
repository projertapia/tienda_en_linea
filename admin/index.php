<?php

	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	include('functions/calculadoracomision.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hola <?php echo USERADMIN?> | Ecommerce</title>
<?php include("parts/header.php");?>
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
			<section id="info-content">
				<div class="row">
					<div class="col-12">
						<h1 id="titlesection">Inicio</h1>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Ventas</strong>
							<?php $sqlventas="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito IS NOT NULL AND  status_carrito != 3";
							$ventas=mysqli_query($conex, $sqlventas);?>
							<h1><?php echo $ventas->num_rows;?></h1>
						</div>
					</div>
					<div class=" col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Envíos pendientes</strong>
							<?php $sqlenvio="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito = 1";
							$envio=mysqli_query($conex, $sqlenvio);?>
							<h1><?php echo $envio->num_rows;?></h1>
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Envíos realizados</strong>
							<?php $sqlenvio="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito = 2";
							$envio=mysqli_query($conex, $sqlenvio);?>
							<h1><?php echo $envio->num_rows;?></h1>
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-3 hot-box">
						<div class="card-header lista-prodcutos box-status">
							<strong>Pedidos cancelados</strong>
							<?php $sqlenvio="SELECT id_vendedor_carrito, status_carrito FROM carrito WHERE status_carrito = 3";
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
										<th scope="col">Producto/Envío</th>
										<th scope="col">Comisión</th>
										<th scope="col">IVA</th>
										<th scope="col">Total</th>
										<th scope="col">Cantidad</th>
										<th scope="col">Escaparate</th>
										<th scope="col" colspan="2">Fecha</th>
									</tr>
								</thead>
							<tbody>
							<?php
							$sqlVentas="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.fecha_entrega_carrito, c.status_carrito, c.cancelacion_carrito, c.precioart_carrito, c.costo_envio_carrito,
							p.id_producto, p.nombre_producto, p.img_a_producto, p.categoria_producto,
							z.id_cliente, z.nombre_cliente, z.apellidos_cliente, z.email_cliente,
							t.id_tienda, t.nombre_tienda, t.nick_tienda, t.categoria_tienda
							FROM carrito c, productos p, clientes z,  tiendas t
							WHERE c.id_vendedor_carrito = t.id_tienda AND (c.status_carrito = 1) AND p.id_producto = c.id_producto_carrito AND z.id_cliente = c.id_user_carrito ORDER BY c.fecha_compra_carrito";
							$reqVentas=mysqli_query($conex, $sqlVentas);
							while($resulVentas = mysqli_fetch_object($reqVentas)){
								$id_carrito = $resulVentas->id_carrito;
								$nick_tienda= $resulVentas->nick_tienda;
								$nombre_tienda = $resulVentas->nombre_tienda;
								$id_tienda = $resulVentas->id_tienda;
								$clave_carrito = $resulVentas->clave_carrito;
								$status_carrito = $resulVentas->status_carrito;
								$talla_producto_carrito = $resulVentas->talla_producto_carrito;
								$color_producto_carrito = $resulVentas->color_producto_carrito;
								$cantidad_producto_carrito = $resulVentas->cantidad_producto_carrito;
								$date_compra_periodo = $resulVentas->fecha_compra_carrito;
								$fecha_compra_carrito = date_create($resulVentas->fecha_compra_carrito);
								$fecha_entrega_carrito = date_create($resulVentas->fecha_entrega_carrito);
								$precio_producto = $resulVentas->precioart_carrito;
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
								
								if($costo_envio_carrito== null OR $costo_envio_carrito =="" OR $costo_envio_carrito == NULL){
									$costo_envio_carrito = 0;
								};
								//GET PERIODO CARRITO
								$comisionactual=comision($id_tienda,$date_compra_periodo);
								$porcentaje=$comisionactual->porc_com;
								$comisionactual->nombre_com;
								$subtotal= ($cantidad_producto_carrito * $precio_producto);
								$total = $subtotal + $costo_envio_carrito;
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
							?>
							<tr>
								<th  class="id-box" scope="row"><?php echo $id_carrito.' - '.$clave_carrito?></th>
								<td><img src="../img/tiendas/<?php echo $nick_tienda.'/'.$img_a_producto?>" alt="" class="img-fluid" width="80px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
								<td><?php echo $nombre_producto?></td>
								<td><span>$<?php echo number_format($producto_precio_vendedor, 2, '.', ',')?></span><span>$<?php echo number_format($envio_menos_iva, 2, '.', ',')?></span></td>
								<td>$<?php echo number_format($comision_sin_iva, 2, '.', ',')?></td>
								<td>$<?php echo number_format($iva_Total, 2, '.', ',')?></td>
								<td>$<?php echo number_format($total, 2, '.', ',')?></td>
								<td><?php echo $cantidad_producto_carrito?></td>
								<td><?php echo $nick_tienda?><br><small><?php echo $nombre_tienda?></small></td>
								<td><?php HaceCuanto::imprimirTiempo($fecha,$hora)?><span><?php echo $fecha?></span></td>
								<td><a href="<?php echo SITE.'admin/escaparates/detalle-de-venta?id='.$id_carrito.'&v='.$clave_carrito?>">Ver Detalle</a></td>
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
										<th scope="col">Escaparate</th>
										<th scope="col">Razón</th>
										<th scope="col" colspan="2">Fecha</th>
									</tr>
								</thead>
							<tbody>
							<?php
							$sqlVentas="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.fecha_entrega_carrito, c.status_carrito, c.cancelacion_carrito, c.razoncancelado_carrito, c.precioart_carrito,
							p.id_producto, p.nombre_producto, p.img_a_producto, p.categoria_producto,
							z.id_cliente, z.nombre_cliente, z.apellidos_cliente, z.email_cliente,
							t.id_tienda, t.nombre_tienda, t.nick_tienda, t.categoria_tienda
							FROM carrito c, productos p, clientes z,  tiendas t
							WHERE c.id_vendedor_carrito = t.id_tienda AND (c.status_carrito = 3) AND p.id_producto = c.id_producto_carrito AND z.id_cliente = c.id_user_carrito ORDER BY c.fecha_compra_carrito";
							$reqVentas=mysqli_query($conex, $sqlVentas);
							while($resulVentas = mysqli_fetch_object($reqVentas)){
								$id_carrito = $resulVentas->id_carrito;
								$nick_tienda= $resulVentas->nick_tienda;
								$nombre_tienda = $resulVentas->nombre_tienda;
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
								<th  class="id-box" scope="row"><?php echo $id_carrito.' - '.$clave_carrito?></th>
								<td><img src="../img/tiendas/<?php echo $nick_tienda.'/'.$img_a_producto?>" alt="" class="img-fluid" width="80px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
								<td><?php echo $nombre_cliente?></td>
								<td><a href="mailto:<?php echo $email_cliente?>"><?php echo $email_cliente?></a></td>
								<td><?php echo $nick_tienda?><br><small><?php echo $nombre_tienda?></small></td>
								<td><span><?php echo $razoncancelado_carrito?></span></td>
								<td><?php HaceCuanto::imprimirTiempo($fecha,$hora)?><span><?php echo $fecha?></span></td>
								<td><a href="<?php echo SITE.'admin/escaparates/detalle-de-venta?id='.$id_carrito.'&v='.$clave_carrito?>">Ver Detalle</a></td>
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
							<strong>TOP 10 Más comprados</strong>
							<div class="table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">Código<br>de producto</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre de producto</th>
										<th scope="col">Color/Variante</th>
										<th scope="col">Talla/Tamaño</th>
										<th scope="col">Escaparate</th>
										<th scope="col">Ventas</th>										
									</tr>
									<tbody>
										<?php
											$SQLMasVendido="SELECT c.color_producto_carrito, c.id_vendedor_carrito, c.id_producto_carrito, COUNT(c.cantidad_producto_carrito) AS total, SUM(c.cantidad_producto_carrito) AS cventas, c.talla_producto_carrito,
											p.id_producto, p.nombre_producto, p.img_a_producto, p.codigo_producto,
											t.id_tienda, t.nombre_tienda, t.nick_tienda, t.categoria_tienda
											FROM carrito c, productos p, tiendas t
											WHERE c.id_vendedor_carrito = t.id_tienda AND c.id_producto_carrito = p.id_producto AND (c.status_carrito = 1 OR c.status_carrito = 2) GROUP BY c.id_producto_carrito ORDER BY cventas DESC LIMIT 10";
											$reqMasVendido=mysqli_query($conex, $SQLMasVendido);
											while($resulMasVendido = mysqli_fetch_object($reqMasVendido)){
												$id_producto_carrito = $resulMasVendido->id_producto_carrito;
												$total = $resulMasVendido->total;
												$cventas = $resulMasVendido->cventas;
												$nombre_tienda = $resulMasVendido->nombre_tienda;
												$nick_tienda = $resulMasVendido->nick_tienda;
												$nombre_producto = $resulMasVendido->nombre_producto;
												$img_a_producto= $resulMasVendido->img_a_producto;
												$codigo_producto= $resulMasVendido->codigo_producto;
												$talla_producto_carrito= $resulMasVendido->talla_producto_carrito;
												$color_producto_carrito= $resulMasVendido->color_producto_carrito;
										?>
										<tr>
											<td class="id-box" scope="row"><?php echo $codigo_producto?></td>
											<td><img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$img_a_producto?>" class="img-fluid" width="120px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
											<td><?php echo $nombre_producto?></td>
											<td><?php echo $color_producto_carrito?></td>
											<td><?php echo $talla_producto_carrito?></td>
											<td><?php echo $nick_tienda?><br><small><?php echo $nombre_tienda?></small></td>
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
</body>
</html>