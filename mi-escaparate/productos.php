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
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_TIME, 'es_MX.UTF-8');
	setlocale(LC_TIME, 'spanish');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.$server.'entrar');
	}
	$idtienda = $_SESSION["idtienda"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mis productos - <?php echo NICKTIENDA?> | Ecommerce</title>
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
					<div class="col-10">
						<h1 id="titlesection">Mis productos <small style="font-size: 50%">(Activos: <?php echo $TotalProd_rows?> de <?php echo $cantidad_suscripcion_tiendas?> disponibles) - Plan <?php echo ($nombre_tipo_tienda)?></small></h1>
					</div>
					<div class="col-2">
						<a href="<?php echo SITE.'mi-escaparate/crear-nuevo'?>" class="btn btn-primary my-2">Crear nuevo</a>
					</div>
					<div class="clearfix"></div>
					<div class="col-12">
						<div class="card-header lista-prodcutos table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre</th>
										<th scope="col">SKU</th>
										<th scope="col">Inventario</th>
										<th scope="col">Precio</th>
										<th scope="col">Categorías</th>
										<th scope="col">Etiquetas</th>
										<th scope="col">Fecha</th>
										<th scope="col">Status</th>
									</tr>
								</thead>
							<tbody>
								<?php
									$sql="SELECT id_producto, nombre_producto, url_producto, id_tienda_producto, codigo_producto, stock_producto, precio_producto, precio_promo_producto, img_a_producto, tags_producto, categoria_producto, activo_producto, fecha_producto FROM productos WHERE id_tienda_producto = $idtienda AND activo_producto != 4";
									$req=mysqli_query($conex, $sql);
									while($resul = mysqli_fetch_object($req)){
										$id_producto = $resul->id_producto;
										$nombre_producto = $resul->nombre_producto;
										$url_producto = $resul->url_producto;
										$codigo_producto = $resul->codigo_producto;
										$stock_producto = $resul->stock_producto;
										$precio_producto = $resul->precio_producto;
										$precio_promo_producto = $resul->precio_promo_producto;
										$img_a_producto = $resul->img_a_producto;
										$tags_producto = $resul->tags_producto;
										$categoria_producto = $resul->categoria_producto;
										$activo_producto = $resul->activo_producto;
										$fecha_producto = date_create($resul->fecha_producto);
										$fecha = date_format($fecha_producto, 'Y-m-d');
										$hora = date_format($fecha_producto, ' H:i:s');
										if($stock_producto==0){
											$stock_producto="Agotado";
										}
										$classline="";
										if($precio_promo_producto!=""){
											$classline="text-decoration: line-through";
										}else{
											$classline="";
										}
										switch ($activo_producto){
											case 4:
											$statusProd="Eliminado";
											case 2:
											$statusProd="Oculto";
											break;
											case 1:
											$statusProd="Visible";
											break;
											case NULL:
											$statusProd="Oculto";
											break;	
										}
								?>
								<tr>
									<th scope="row"><?php echo $id_producto?></th>
									<td class="img-table"><img src="../img/tiendas/<?php echo $nick_tienda.'/'.$img_a_producto?>" alt="" class="img-fluid" width="80px"></td>
									<td class="title-table"><a href="mis-productos/editar?id=<?php echo $id_producto?>"><?php echo $nombre_producto?></a></td>
									<td><?php echo $codigo_producto?></td>
									<td><?php echo $stock_producto?></td>
									<td><span style="<?php echo $classline?>"><?php echo $precio_producto?></span><span><?php echo $precio_promo_producto?></span></td>
									<td><?php echo $categoria_producto?></td>
									<td class="tag-table"><?php echo $tags_producto?></td>
									<td class="date-table"><?php HaceCuanto::imprimirTiempo($fecha,$hora)?><span><?php echo $fecha?></span></td>
									<td><?php echo $statusProd?></td>
								</tr>
								<?php
									}
								?>
							</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<?php include('parts/footer.php');?>
</body>
</html>