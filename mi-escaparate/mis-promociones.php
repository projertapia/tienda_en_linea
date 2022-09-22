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
<title>Mis Promos - <?php echo NICKTIENDA?> | Ecommerce</title>
<?php include("parts/header.php");?>
<style>
	small.time{display: block; font-size: 11px}
</style>
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
					<div class="col-8">
						<h1 id="titlesection">Mis Promos <small style="font-size: 50%">(Activos:<?php echo $TotalPromos_rows?> de <?php echo $cantidad_promos_tiendas.' Plan: '.$nombre_tipo_tienda?>)</small></h1>
						
					</div>
					<div class="col-4">
						<a href="<?php echo SITE.'mi-escaparate/crear-promo'?>" class="btn btn-small btn-primary"> Nueva promoción</a>
					</div>
					<div class="col-12">
						<div class="card-header lista-prodcutos table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre</th>
										<th scope="col">URL</th>
										<th scope="col">Fecha de inicio</th>
										<th scope="col">Fecha de finalizacion</th>
										<th scope="col">Tipo</th>
										<th scope="col">Clics</th>
										<th scope="col">Status</th>
									</tr>
								</thead>
							<tbody>
						<?php 
							$id_tienda = IDTIENDA;
							$sqlPromos="SELECT id_promocion, tienda_rel_promocion, nombre_promocion, fecha_inicio_promocion, fecha_fin_promocion, img_promocion, url_promocion, clicks_promocion, tipo_promocion, activo_promocion FROM promociones WHERE tienda_rel_promocion = $id_tienda ORDER BY fecha_promocion DESC";
							$reqPromos=mysqli_query($conex, $sqlPromos);
							while($resulPromos = mysqli_fetch_object($reqPromos)){
								$id_promocion  = $resulPromos->id_promocion;
								$nombre_promocion  = $resulPromos->nombre_promocion;
								$fecha_inicio_promocion  = date_create($resulPromos->fecha_inicio_promocion);
								$fecha_fin_promocion  = date_create($resulPromos->fecha_fin_promocion);
								$fin_promocion = $resulPromos->fecha_fin_promocion;
								$img_promocion = $resulPromos->img_promocion;
								$url_promocion = $resulPromos->url_promocion;
								$clicks_promocion = $resulPromos->clicks_promocion;
								$tipo_promocion = $resulPromos->tipo_promocion;
								$activo_promocion = $resulPromos->activo_promocion;
								$fecha_inicio = date_format($fecha_inicio_promocion, 'Y-m-d');
								$hora_inicio = date_format($fecha_inicio_promocion, ' H:i:s');
								$fecha_fin = date_format($fecha_fin_promocion, 'Y-m-d');
								$hora_fin = date_format($fecha_fin_promocion, ' H:i:s');
								if($fin_promocion<$datetime_now){
									$update_promos="UPDATE promociones SET activo_promocion = 0 WHERE id_promocion = $id_promocion";
									$conex->query($update_promos);
									$activo_promocion=0;
								}else{
									
								}
								switch ($tipo_promocion){
									case 'sq':
									$tipopromo="Cuadrado";
									break;
									case 'rq':
									$tipopromo="Rectangular";
									break;
								}
								switch ($activo_promocion){
									case 1:
										$statuspromo="Activo";
									break;
									case 0:
										$statuspromo="Desactivado";
									break;
								}
						?>
							<tr>
								<th scope="row" align="center" valign="middle"><?php echo $id_promocion?></th>
								<th scope="row" align="center" valign="middle"><a href="mis-promociones/editar?id=<?php echo $id_promocion?>" title="<?php echo $nombre_promocion?>"><img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$img_promocion?>" width="100px"></a></th>
								<th scope="row" align="center" valign="middle"><a href="mis-promociones/editar?id=<?php echo $id_promocion?>" title="<?php echo $nombre_promocion?>"><?php echo $nombre_promocion?></a></th>
								<th scope="row" align="center" valign="middle"><a href="<?php echo $url_promocion?>" target="_blank"><?php echo $url_promocion?></a></th>
								<th scope="row" align="center" valign="middle"><?php echo $fecha_inicio?><small class="time"><?php echo $hora_inicio ?></small></th>
								<th scope="row" align="center" valign="middle"><?php echo $fecha_fin?><small class="time"><?php echo $hora_fin ?></small></th>
								<th scope="row" align="center" valign="middle"><?php echo $tipopromo?></th>
								<th scope="row" align="center" valign="middle"><?php echo $clicks_promocion?></th>
								<th scope="row" align="center" valign="middle"><?php echo $statuspromo?></th>
							</tr>
						<?php }?>
								
							</tbody>
						</table>
					</div>	
					</div>
					<div class="clearfix"></div>
				</div>
			</section>
		</div>
	</section>
</body>
</html>