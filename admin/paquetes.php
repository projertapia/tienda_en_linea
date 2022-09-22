<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	$idedit="";
	if(isset($_GET['mod']) AND isset($_GET['id']) AND $_GET['mod']!="" AND $_GET['id']!=""){
		$idedit=$_GET['id'];
		if($_GET['mod'] == 'true'){			
			$classTable="table-success";
		}else{			
			$classTable="table-danger";
		}
	}
if(isset($_GET['v']) AND isset($_GET['v'])){
	$v=$_GET['v'];
	if($v=="Ocultos"){
		$search='WHERE activo_tipo_tienda=0';
		$txtSearch="Ocultos";
	}else{
		$search="WHERE activo_tipo_tienda=1";
		$txtSearch="Visibles";
	}
}else{
	$search="WHERE activo_tipo_tienda=1";
	$txtSearch="Visibles";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Paquetes | Ecommerce</title>
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
					<div class="col-12 col-sm-5 col-md-6 col-lg-9 p-2">
						<h1 id="titlesection">Paquetes</h1>
					</div>
					<div class="col-12 col-sm-7 col-md-6 col-lg-3 p-2">
						<form method="get" accept-charset="UTF-8" action="<?php echo SITE.'admin/paquetes'?>">
							<div class="form-row align-items-center">
								 <div class="col-auto m-2">
									<select name="v" class="form-control">
										<?php if($v=='Ocultos'){?>
										<option value="Ocultos" selected>Ocultos</option>
										<option value="Visibles">Visibles</option>
										<?php }else{ ?>
										<option value="Ocultos">Ocultos</option>
										<option value="Visibles" selected>Visibles</option>
										<?php }?>
									</select>
								</div>
								 <div class="col-auto m-2">
								  <button type="submit" class="btn btn-primary">Buscar</button>
								</div>
							</div>
						</form>
					</div>
					<hr>
					<div class="col-md-4">
						<div class="card-header lista-prodcutos table-responsive">
							<form method="post" accept-charset="UTF-8" action="functions/nuevopaquete.php">
								<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
								<div class="form-group">
									<label for="nombre">Nombre Paquete</label>
									<input type="text" name="nombre_tipo_tienda" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="cantidad_prod">Cantidad de Productos</label>
									<input name="cantidad_prod" type="number" required class="form-control" min="0" step="1">
								</div>
								<div class="form-group">
									<label for="cantidad_prom">Cantidad de promociones</label>
									<input name="cantidad_prom" type="number" required class="form-control" min="0" step="1">
								</div>
								<div class="form-group">
									<label for="porcentaje">Porcentaje de comisión</label>
									<input name="porcentaje" type="number" required class="form-control" min="0" step="1">
								</div>
								<div class="form-group">
									<label for="costo">Costo del paquete</label>
									<input name="costo" type="number" required class="form-control" min="0" step="1">
								</div>
								<div class="form-group">
									<label for="duracion">Duración de paquete</label>
									<select name="duracion" class="form-control" required>
										<option value="1">1 mes</option>
										<option value="2">2 meses</option>
										<option value="3">3 meses</option>
										<option value="4">4 meses</option>
										<option value="5">5 meses</option>
										<option value="6">6 meses</option>
										<option value="7">7 meses</option>
										<option value="8">8 meses</option>
										<option value="9">9 meses</option>
										<option value="10">10 meses</option>
										<option value="11">11 meses</option>
										<option value="12">12 meses</option>
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-success">Crear Nuevo Paquete</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-8">
						<div class="card-header lista-prodcutos table-responsive">
							<strong><?php echo $txtSearch?></strong>
							<table class="table table-striped" id="productslist">
								<thead>
									<tr align="center">
										<th scope="col" class="hidden-row">#</th>
										<th scope="col">Paquete</th>										
										<th scope="col">Max. Productos</th>
										<th scope="col">Max. Promos</th>
										<th scope="col">Comisión</th>
										<th scope="col">Costo</th>
										<th scope="col">Duración</th>
										<th scope="col">Mes + IVA</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sqlPaq="SELECT * FROM tipos_tienda $search ORDER BY id_tipo_tienda DESC";
										$reqPaq=mysqli_query($conex, $sqlPaq);
										while($resulPaq = mysqli_fetch_object($reqPaq)){
											$id_tipo_tienda = $resulPaq->id_tipo_tienda ;
											$nombre_tipo_tienda = $resulPaq->nombre_tipo_tienda;
											$cantidad_tipo_tienda = $resulPaq->cantidad_tipo_tienda;
											$cantidad_promos_tipo_tienda = $resulPaq->cantidad_promos_tipo_tienda;
											$porcentaje_tienda = $resulPaq->porcentaje_tienda;
											$costo_tienda = $resulPaq->costo_tienda;
											$activo_tipo = $resulPaq->activo_tipo_tienda;
											$duracion_tipo_tienda = $resulPaq->duracion_tipo_tienda;
											if($id_tipo_tienda==$idedit){
												$addClass=$classTable;
											}else{
												$addClass="";
											}
											$costo_tienda_iva = $costo_tienda*1.16;
											if($duracion_tipo_tienda==1){
												$meses= "mes.";
											}else{
												$meses= "meses.";
											}
									?>
									<tr data-toggle="modal" data-target="#edit-<?php echo $id_tipo_tienda?>" class="clic <?php echo $addClass?>">
										<td style="vertical-align:middle;" class="hidden-row" align="center"><?php echo $id_tipo_tienda?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $nombre_tipo_tienda?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $cantidad_tipo_tienda?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $cantidad_promos_tipo_tienda?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $porcentaje_tienda?>%</td>
										<td style="vertical-align:middle;" align="center">$<?php echo $costo_tienda?></td>
										<td style="vertical-align: middle" align="center">
											<?php if($id_tipo_tienda==1){ echo "No aplica"; }else{ echo $duracion_tipo_tienda." ".$meses;};?>
										</td>
										<td style="vertical-align:middle;" align="center">$<?php echo $costo_tienda_iva?></td>
									</tr>
									<div class="modal" tabindex="-1" role="dialog" id="edit-<?php echo $id_tipo_tienda?>" data-backdrop="static">
									  <div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title">Editar el paquete: <?php echo $nombre_tipo_tienda?></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										  </div>
										  <div class="modal-body">
											<form accept-charset="UTF-8" action="functions/editar-paquete.php" method="post">
												<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
												<input type="hidden" name="idpaquete" value="<?php echo $id_tipo_tienda?>">
												<div class="form-group">
													<label for="nombre">Nombre Paquete</label>
													<input type="text" name="nombre_tipo_tienda" class="form-control" required="" value="<?php echo $nombre_tipo_tienda?>">
												</div>
												<div class="form-group">
													<label for="cantidad_prod">Cantidad de Productos</label>
													<input name="cantidad_prod" type="number" required="" class="form-control" min="1" step="1" value="<?php echo $cantidad_tipo_tienda?>">
												</div>
												<div class="form-group">
													<label for="cantidad_prom">Cantidad de promociones</label>
													<input name="cantidad_prom" type="number" required="" class="form-control" min="1" step="1" value="<?php echo $cantidad_promos_tipo_tienda?>">
												</div>
												<div class="form-group">
													<label for="porcentaje">Porcentaje de comisión</label>
													<input name="porcentaje" type="number" required="" class="form-control" min="1" step="1" value="<?php echo $porcentaje_tienda?>">
												</div>
												<div class="form-group">
													<label for="nombre">Costo del paquete</label>
													<input name="costo" type="number" required="" class="form-control" min="0" step="1" value="<?php echo $costo_tienda?>">
												</div>
												<?php if($id_tipo_tienda!=1){?>
												<div class="form-group">
													<label for="duracion">Duración de paquete</label>
													<select name="duracion" class="form-control" required id="duracion-<?php echo $id_tipo_tienda?>">
														<option value="1">1 mes</option>
														<option value="2">2 meses</option>
														<option value="3">3 meses</option>
														<option value="4">4 meses</option>
														<option value="5">5 meses</option>
														<option value="6">6 meses</option>
														<option value="7">7 meses</option>
														<option value="8">8 meses</option>
														<option value="9">9 meses</option>
														<option value="10">10 meses</option>
														<option value="11">11 meses</option>
														<option value="12">12 meses</option>
													</select>
												</div>
												<script>
													var options = document.getElementById("duracion-<?php echo $id_tipo_tienda?>").options;
													for (var i = 0; i < options.length; i++) {
													  if (options[i].value == <?php echo $duracion_tipo_tienda?>) {
														options[i].selected = true;
														break;
													  }
													}
												</script>
												<?php } ?>
												<div class="form-group">
													<label for="activo">Activar</label>
													<select name="activo" class="form-control" required>
														<?php if($activo_tipo==1){
														?>
														<option value="0">Desactivado</option>
														<option value="1" selected>Activo</option>
														<?php
														}else{?>
														<option value="0" selected>Desactivado</option>
														<option value="1">Activo</option>
														<?php }?>
													</select>
												</div>
												<div class="form-group">
													<button type="submit" class="btn btn-success btn-lg btn-block">Editar Paquete</button>
												</div>
											</form>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-secondary btn-sm btn-block" data-dismiss="modal">Cerrar</button>
										  </div>
										</div>
									  </div>
									</div>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>					
</body>
</html>