<?php
	session_start();
	require('connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.SITE.'entrar');
	}
	if($checkfin != "-"){
		$finplan = date('d-m-Y', strtotime($checkfin));
	}else{
		$finplan="-";
	};
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mi Plan - <?php echo NICKTIENDA?> | Ecommerce</title>
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
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 ">
						<h1 id="titlesection">Mi Plan</h1>
					</div>
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<strong>Descripción de Plan</strong>
							<?php if($id_tipo_tienda==1){?>
								<div class="editar-direccion">
									<a href="#" data-toggle="collapse" data-target="#editarplan" aria-expanded="false" aria-controls="user" class="collapsed"><i class="fas fa-edit"></i> Editar</a>								
								</div>
							<?php }?>
							<hr>
							<div class="row">
								<div class="col-sm-6">
								<h6>Tipo de cuenta:</h6>
								<p><strong><?php echo ($nombre_tipo_tienda)?></strong></p>
								</div>
								<div class="col-sm-6">
									<p style="font-size: 12px; margin: 2px 0">Fecha de vencimiento del plan: <strong><?php echo $finplan?></strong></p>
									<?php if($id_tipo_tienda==1){?>
									<p style="font-size: 12px; margin: 2px 0">Limite de productos y promociones publicadas: <strong><?php echo $cantidad_suscripcion_tiendas?></strong></p>
									<?php }else{ ?>
									<p style="font-size: 12px; margin: 2px 0">Limite de productos publicados: <strong><?php echo $cantidad_suscripcion_tiendas?></strong></p>
									<p style="font-size: 12px; margin: 2px 0">Limite de promociones publicadas: <strong><?php echo $cantidad_promos_tiendas?></strong></p>
									<?php }?>
									<p style="font-size: 12px; margin: 2px 0">Comisión del: <strong><?php echo $porcentaje_suscripcion_tiendas?>%</strong></p>
								</div>
								<hr>
								<div class="collapse col-12" id="editarplan">
								  <div class="card card-body">
									<div class="table-responsive">
									<form method="post" accept-charset="UTF-8" id="cuenta" action="mi-plan/pagar">
										<input type="hidden" value="<?php echo IDTIENDA?>" name="idtienda">
										<input type="hidden" value="updateplan" name="tipo_udpate">
										<div class="form-group">
											<table class="table table-striped">
												<thead>
													<tr>
														<th scope="col">Selecionar</th>
														<th scope="col">Plan</th>
														<th scope="col">Productos publicados</th>
														<th scope="col">Promociones publicadas</th>
														<th scope="col">Comisión</th>
														<th scope="col">Costo</th>
														<th scope="col">Duración</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$sqlPlanes="SELECT * FROM tipos_tienda WHERE activo_tipo_tienda =1 AND id_tipo_tienda != 1";
													$reqPlanes=mysqli_query($conex, $sqlPlanes);
													while($resulPlanes = mysqli_fetch_object($reqPlanes)){
														$id_tipo_tienda = $resulPlanes->id_tipo_tienda;
														$nombre_tipo_tienda = $resulPlanes->nombre_tipo_tienda;
														$cantidad_tipo_tienda = $resulPlanes->cantidad_tipo_tienda;
														$cantidad_promos_tipo_tienda = $resulPlanes->cantidad_promos_tipo_tienda;
														$porcentaje_tienda = $resulPlanes->porcentaje_tienda;
														$costo_tienda = ($resulPlanes->costo_tienda)*1.16;
														$duracion_tipo_tienda = $resulPlanes->duracion_tipo_tienda;
														if($duracion_tipo_tienda==1){
															$meses="mes.";
														}else{
															$meses="meses.";
														}
													?>
													<tr>
														<th scope="row" align="center"><input type="radio" name="plan" id="plan-<?php echo $id_tipo_tienda?>" value="<?php echo $id_tipo_tienda?>" required></th>
														<td><?php echo $nombre_tipo_tienda?></td>
														<td><?php echo $cantidad_tipo_tienda?></td>
														<td><?php echo $cantidad_promos_tipo_tienda?></td>
														<td><?php echo $porcentaje_tienda?>%</td>
														<td>$<?php echo $costo_tienda?>*<small>mxn.</small></td>
														<td><?php echo $duracion_tipo_tienda.' '.$meses?></td>
													</tr>
													<?php
													}
												?>
												</tbody>
											</table>										
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block btn-sm" id="updateDatos" >Comprar Plan</button>
										</div>
									</form>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>	
</body>
</html>