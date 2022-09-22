<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
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
	if(isset($_GET['in']) && isset($_GET['out']) AND $_GET['in'] != "" AND $_GET['out'] !=""){
		$in=$_GET['in'];
		$out=$_GET['out'];
		$infil=$in.' 00:00:00';
		$outfil=$out.' 23:59:59';
		$filtroFechas="AND c.fecha_compra_carrito >= '$infil' AND c.fecha_compra_carrito <= '$outfil'";
	}else{
		$filtroFechas="";
		$out=date('Y-m-d');
		$in=date('Y-m-d',strtotime($out."- 1 month"));
		$infil=$in.' 00:00:00';
		$outfil=$out.' 23:59:59';
		$filtroFechas="AND c.fecha_compra_carrito >= '$infil' AND c.fecha_compra_carrito <= '$outfil'";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte de ventas | <?php echo NICKTIENDA?> en | Ecommerce</title>
<?php include("parts/header.php");?>
<!--CSS EXPORTER-->
<link href="<?php echo SITE?>css/tableexport.css" rel="stylesheet" type="text/css" >
<script src="<?php echo SITE?>js/FileSaver.min.js"></script> 
<script src="<?php echo SITE?>js/Blob.min.js"></script>
<script src="<?php echo SITE?>js/xls.core.min.js"></script>
<script src="<?php echo SITE?>js/tableexport.js"></script>
</head>

<body>
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
					<div class="col-lg-12 col-xl-6 my-3">
						<h1 id="titlesection">Reporte de ventas</h1>
						<small></small>
						<br>
					</div>
					<div class="col-lg-12 col-xl-6 my-3">
						<form action="<?php echo SITE.'mi-escaparate/mis-reportes'?>" accept-charset="UTF-8" method="get" class="form-inline">
							<div class="form-group mx-sm-3 mb-2 filter">
								<label for="in">Desde el</label>
							    <input name="in" type="date" class="form-control-plaintext" step="1" max="<?php echo date('Y-m-d')?>" value="<?php echo $in?>" required>
							</div>
							<div class="form-group mx-sm-3 mb-2 filter">
								<label for="out">Hasta el</label>
								 <input name="out" type="date" class="form-control-plaintext" step="1" max="<?php echo date('Y-m-d')?>" value="<?php echo $out?>" required>
							</div>
							 <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
						</form>
					</div>
					<div class="col-12">
						<div class="card-header lista-prodcutos box-status">
							<strong>Reporte de <?php echo $in .' al '. $out?></strong>
							<div class="table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">№ Venta</th>
										<th scope="col" style="text-align: center"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre Producto</th>
										<th scope="col" align="center" style="text-align: center">Fecha compra</th>
										<th scope="col" align="center" style="text-align: center">Precio venta</th>
										<th scope="col" align="center" style="text-align: center">Cantidad</th>
										<th scope="col" align="center" style="text-align: right">Comisión de venta</th>
										<th scope="col" align="center" style="text-align: center">IVA</th>
										<th scope="col" align="center" style="text-align: center">Total</th>
									</tr>
								</thead>
							<tbody>
								<?php
								$SQLreport="SELECT c.id_carrito, c.clave_carrito, c.id_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.status_carrito, c.precioart_carrito, c.costo_envio_carrito,
								p.id_producto, p.nombre_producto, p.id_tienda_producto, p.img_a_producto
								FROM carrito c, productos p
								WHERE p.id_producto= c.id_producto_carrito AND c.id_vendedor_carrito = $id_tienda AND  p.id_tienda_producto = $id_tienda AND (c.status_carrito = 2 OR c.status_carrito = 1) $filtroFechas";
								$totalmes=0;
								$totalcomision=0;
						   		$totaliva=0;
								$reqReport=mysqli_query($conex, $SQLreport);
								while($resulReport = mysqli_fetch_object($reqReport)){
									$id_carrito = $resulReport->id_carrito;
									$clave_carrito = $resulReport->clave_carrito;
									$img_a_producto = $resulReport->img_a_producto;
									$nombre_producto = $resulReport->nombre_producto;
									$fecha_compra = $resulReport->fecha_compra_carrito;
									$costo_envio_carrito = $resulReport->costo_envio_carrito;
									$cantidad_producto_carrito = $resulReport->cantidad_producto_carrito;
									$fecha_compra_carrito = date_create($resulReport->fecha_compra_carrito);
									$fecha = date_format($fecha_compra_carrito, 'Y-m-d');
									$precio_producto = $resulReport->precioart_carrito;
									$precio_producto= $precio_producto* $cantidad_producto_carrito;
									$status_carrito = $resulReport->status_carrito;
									//GET PERIODO CARRITO
									$SQLPercentReport="SELECT s.id_tienda_suscripcion, s.tipo_suscripcion, s.porcentaje_suscripcion_tiendas, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, t.id_tipo_tienda, t.nombre_tipo_tienda FROM suscripcion_tiendas s, tipos_tienda t WHERE s.id_tienda_suscripcion = $id_tienda AND (s.inicio_suscripcion <= '$fecha_compra' AND s.fin_suscripcion >= '$fecha_compra') AND t.id_tipo_tienda  = s.tipo_suscripcion";
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
									if($costo_envio_carrito=="" OR $costo_envio_carrito ==null OR $costo_envio_carrito==NULL){
										$costo_envio_carrito = 0;
									}
									//SUB TOTAL CON IVA
									$subtotal = ($cantidad_producto_carrito * $precio_producto);		
									//TOTAL CON IVA
									$total = $subtotal+$costo_envio_carrito;	
									$producto_menos_iva= number_format($precio_producto/1.16, 2, '.', ',');
									$producto_precio_vendedor = $producto_menos_iva / (1+($porcentaje/100));
									$envio_menos_iva = number_format($costo_envio_carrito /1.16, 2, '.', ',');
									$comision_sin_iva = number_format($producto_menos_iva - $producto_precio_vendedor, 2, '.', ',');;
									$iva_Total = number_format($total - ($producto_menos_iva+$envio_menos_iva), 2, '.', ',');
									$total_recepcion= number_format($producto_precio_vendedor+$envio_menos_iva, 2, '.', ',');
									
									$totalcomision= $totalcomision + $comision_sin_iva;
									$totalmes = $totalmes + $total_recepcion;	
									$totaliva = $totaliva + $iva_Total;
									if($status_carrito==1){
										$statusTXT="Vendido";
									}else{
										$statusTXT="Enviado";
									}
								?>
								<tr>
									<td valign="middle"><?php echo $id_carrito.'-'.$clave_carrito?></td>
									<td valign="middle" align="center"><img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_a_producto?>" class="img-fluid" width="100px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
									<td valign="middle"><?php echo $nombre_producto?></td>
									<td valign="middle" align="center"><?php echo $fecha?><br><span>Status: <?php echo $statusTXT?></span></td>
									<td valign="middle" align="center">$<?php echo $precio_producto?> <small>mxn.</small></td>
									<td valign="middle" align="center"><?php echo $cantidad_producto_carrito?><small>u.</small></td>
									<td valign="middle" align="right"><?php echo $porcentaje?>% <span style="display: block; text-align: right">- $<?php echo $totalcomision?> <small>mxn.</small><br><?php echo $nombre_tipo?></span></td>
									<td valign="middle" align="center">- $<?php echo $iva_Total?> <small>mxn.</small></td>
									<td valign="middle" align="center">$<?php echo $total_recepcion?> <small>mxn.</small></td>
								</tr>
								<?php
								}
								?>
							</tbody>
								<tfoot>
									<tr class="table-success"><td colspan="8" align="right" class="font-weight-bold">Comisión total del periodo:</td><td align="left">$<?php echo $totalcomision?></td></tr>
									<tr class="table-warning"><td colspan="8" align="right" class="font-weight-bold">IVA total del periodo:</td><td align="left">$<?php echo $totaliva?></td></tr>
									<tr class="table-info"><td colspan="8" align="right" class="font-weight-bold">Total del perido:</td><td align="left">$<?php echo $totalmes?></td></tr>
								</tfoot>
							</table>
								</div>
							</div>
						</div>
					<hr>
					<div class="col-12">
						<div class="card-header lista-prodcutos box-status">
							<strong>Cancelados de <?php echo $in .' al '. $out?></strong>
							<div class="table-responsive">
							<table class="table table-striped" id="productscancelados">
								<thead>
									<tr>
										<th scope="col">№ Venta</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre Producto</th>
										<th scope="col" style="text-align: center">Fecha compra</th>
										<th scope="col" style="text-align: center">Precio venta</th>
										<th scope="col" style="text-align: center">Cantidad</th>
										<th scope="col" style="text-align: center">Status</th>
										<th scope="col" style="text-align: center">Envío</th>
										<th scope="col" style="text-align: center">Comisión<br>de venta</th>
										<th scope="col" align="center" style="text-align: center">IVA</th>
										<th scope="col" style="text-align: center">Total</th>
									</tr>
								</thead>
							<tbody>
								<?php
								$SQLreport="SELECT c.id_carrito, c.clave_carrito, c.id_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.status_carrito, c.precioart_carrito, c.costo_envio_carrito,
								p.id_producto, p.nombre_producto, p.id_tienda_producto, p.img_a_producto
								FROM carrito c, productos p
								WHERE p.id_producto= c.id_producto_carrito AND c.id_vendedor_carrito = $id_tienda AND  p.id_tienda_producto = $id_tienda AND (c.status_carrito = 3) $filtroFechas";
								$totalmes=0;
								$totalcomision=0;
								$totaliva = 0;
								$reqReport=mysqli_query($conex, $SQLreport);
								while($resulReport = mysqli_fetch_object($reqReport)){
									$id_carrito = $resulReport->id_carrito;
									$clave_carrito = $resulReport->clave_carrito;
									$img_a_producto = $resulReport->img_a_producto;
									$nombre_producto = $resulReport->nombre_producto;
									$fecha_compra = $resulReport->fecha_compra_carrito;
									$status_carrito = $resulReport->status_carrito;
									$costo_envio_carrito = $resulReport->costo_envio_carrito;
									$cantidad_producto_carrito = $resulReport->cantidad_producto_carrito;
									$fecha_compra_carrito = date_create($resulReport->fecha_compra_carrito);
									$fecha = date_format($fecha_compra_carrito, 'Y-m-d');
									$precio_producto = $resulReport->precioart_carrito;
									$precio_producto= $precio_producto* $cantidad_producto_carrito;
									//GET PERIODO CARRITO
									$SQLPercentReport="SELECT s.id_tienda_suscripcion, s.tipo_suscripcion, s.porcentaje_suscripcion_tiendas, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, t.id_tipo_tienda, t.nombre_tipo_tienda FROM suscripcion_tiendas s, tipos_tienda t WHERE s.id_tienda_suscripcion = $id_tienda AND (s.inicio_suscripcion <= '$fecha_compra' AND s.fin_suscripcion >= '$fecha_compra') AND t.id_tipo_tienda  = s.tipo_suscripcion";
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
									if($costo_envio_carrito=="" OR $costo_envio_carrito==NULL OR $costo_envio_carrito == null){
										$costo_envio_carrito =0;
									};
									
									//SUB TOTAL CON IVA
									$subtotal = ($cantidad_producto_carrito * $precio_producto);		
									//TOTAL CON IVA
									$total = $subtotal+$costo_envio_carrito;	
									$producto_menos_iva= number_format($precio_producto/1.16, 2, '.', ',');
									$producto_precio_vendedor = $producto_menos_iva / (1+($porcentaje/100));
									$envio_menos_iva = number_format($costo_envio_carrito /1.16, 2, '.', ',');
									$comision_sin_iva = number_format($producto_menos_iva - $producto_precio_vendedor, 2, '.', ',');;
									$iva_Total = number_format($total - ($producto_menos_iva+$envio_menos_iva), 2, '.', ',');
									$total_recepcion= number_format($producto_precio_vendedor+$envio_menos_iva, 2, '.', ',');
									
									$totalcomision= $totalcomision + $comision_sin_iva;
									$totalmes = $totalmes + $total_recepcion;	
									$totaliva = $totaliva + $iva_Total;	
									if($status_carrito==3){
										$txtStatus="Cancelado";
									}else{
										$txtStatus="-";
									}
								?>
								<tr>
									<td style="vertical-align: middle"><a href="<?php echo SITE.'admin/escaparates/detalle-de-venta?id='.$id_carrito.'&v='.$clave_carrito ?>"><?php echo $id_carrito.'-'.$clave_carrito?></a></td>
									<td style="vertical-align: middle"><img src="<?php echo SITE.'img/tiendas/'.$escaparate.'/'.$img_a_producto?>" class="img-fluid" width="100px" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';"></td>
									<td style="vertical-align: middle"><?php echo $nombre_producto?></td>
									<td style="vertical-align: middle; text-align: center"><?php echo $fecha?></td>
									<td style="vertical-align: middle; text-align: center">$<?php echo $precio_producto?> <small>mxn.</small></td>
									<td style="vertical-align: middle; text-align: center"><?php echo $cantidad_producto_carrito?><small>u.</small></td>
									<td style="vertical-align: middle; text-align: center"><?php echo $txtStatus?></td>
									<td style="vertical-align: middle; text-align: center">$<?php echo $costo_envio_carrito?></td>
									<td style="vertical-align: middle" align="right"><?php echo $porcentaje?>% <span style="display: block; text-align: right">$<?php echo $comision_sin_iva?> <small>mxn.</small><br><?php echo $nombre_tipo?></span></td>
									<td style="vertical-align: middle; text-align: center">- $<?php echo $iva_Total?> <small>mxn.</small></td>
									<td style="vertical-align: middle" align="left">$<?php echo $total_recepcion?> <small>mxn.</small></td>
								</tr>
								<?php
								}
								?>
							</tbody>
								<tfoot>
									<tr class="table-danger"><td colspan="10" align="right" class="font-weight-bold">Comisión total del periodo:</td><td align="left">- $<?php echo $totalcomision?></td></tr>
									<tr class="table-warning"><td colspan="10" align="right" class="font-weight-bold">IVA total del periodo:</td><td align="left">- $<?php echo $totaliva?></td></tr>
									<tr class="table-active"><td colspan="10" align="right" class="font-weight-bold">Total del perido:</td><td align="left">- $<?php echo $totalmes?></td></tr>
								</tfoot>
							</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
	$("#productslist").tableExport({			
		formats: ["xlsx","csv","txt"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
		position: 'top',  // Posicion que se muestran los botones puedes ser: (top, bottom)
		bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
		fileName: "Reporte escaparate <?php echo NICKTIENDA.' de '.$in .' al '. $out?>",    //Nombre del archivo 
	});
	</script>
</body>
</html>
	