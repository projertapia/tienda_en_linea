<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['mod']) AND $_GET['mod'] != ""){
		$actionStatus="Plan actualizado";
	}else{
		$actionStatus="";
	}
	if(isset($_GET['id']) AND $_GET['id'] != ""){
		$id_escaparate=$_GET['id'];
		$escaparate=$_GET['e'];
		$categoria=$_GET['cat'];
		$sqlEditor="SELECT t.id_tienda, t.nombre_tienda, t.nick_tienda, t.email_tienda, t.desc_tienda, t.video_tienda, t.fb_tienda, t.insta_tienda, t.tw_tienda, t.yt_tienda, t.tik_tienda, t.twitch_tienda, t.in_tienda, t.web_tienda, t.color_tienda, t.logo_tienda, t.categoria_tienda, t.cover_tienda, t.cumple_tienda, t.cuenta_verif_tienda, t.df_nombre, t.df_tipo, t.df_rfc, t.df_domicilio, t.df_estado, t.nivel_de_tienda, t. df_cp, t. df_numero, t. df_facturacion, t.activa_tienda
		FROM tiendas t
		WHERE t.id_tienda= $id_escaparate";
		$reqEditor=mysqli_query($conex, $sqlEditor);
		while($resulEditor = mysqli_fetch_object($reqEditor)){
			$email_tienda = $resulEditor->email_tienda;
			$categoria_tienda = $resulEditor->categoria_tienda;
			$logo_tienda = $resulEditor->logo_tienda;
			$activa_tienda = $resulEditor->activa_tienda;
			$df_nombre = $resulEditor->df_nombre;
			$df_tipo = $resulEditor->df_tipo;
			$df_rfc = $resulEditor->df_rfc;
			$df_domicilio = $resulEditor->df_domicilio;
			$df_estado = $resulEditor->df_estado;
			$df_cp = $resulEditor->df_cp;
			$df_numero = $resulEditor->df_numero;
			$df_facturacion = $resulEditor->df_facturacion;
			$nivel_de_tienda = $resulEditor->nivel_de_tienda;
		}
	}else{header('location:'.SITE.'admin/escaparates');}
	
	$TitleModal="Confirmación de acción";
	if($activa_tienda=="1"){
		$status="Activa";
		$TxtModal="Desactivar el escaparate: $escaparate";
	}else{
		$status="Desactivada";
		$TxtModal="Activar el escaparate: $escaparate";
	}
	//GET PLAN
	$txtplan;
	//PLAN CONTRATADO
	$sqlLimit="SELECT s.id_suscripcion, s.id_tienda_suscripcion, s.tipo_suscripcion, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, t.id_tipo_tienda, t.nombre_tipo_tienda
	FROM suscripcion_tiendas s, tipos_tienda t WHERE s.id_tienda_suscripcion = $id_escaparate AND s.id_suscripcion = $nivel_de_tienda AND t.id_tipo_tienda = s.tipo_suscripcion";
	$reqLimit=mysqli_query($conex, $sqlLimit);
	$LimitPlan_rows = mysqli_num_rows($reqLimit);	
	while($resultLimit = mysqli_fetch_object($reqLimit)){
		$id_suscripcion = $resultLimit->id_suscripcion;
		$cantidad_show = $resultLimit->cantidad_suscripcion_tiendas;
		$checkinicio = $resultLimit->inicio_suscripcion;
		$checkfin = $resultLimit->fin_suscripcion;
		$nombre_tipo_tienda = $resultLimit->nombre_tipo_tienda;
	}
	if(($checkinicio <= $datetime_now AND $checkfin >= $datetime_now) OR $LimitPlan_rows != 0){
		$txtFin="Vence el: ".$checkfin;
		$changeplan=false;
	}else{
		$SQLPercentReport="SELECT * FROM tipos_tienda WHERE id_tipo_tienda = 1";
		$reqPercentReport=mysqli_query($conex, $SQLPercentReport);
		while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
			$nombre_tipo_tienda = $resulPercentReport->nombre_tipo_tienda;
			$txtFin="";
		}
		$changeplan=true;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Datos <?php echo $escaparate?> | Ecommerce</title>
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
						<h1 id="titlesection">Datos de <?php echo $escaparate?></h1>
					</div>
					<hr>
					<div class="col-12 col-lg-9">
						<div class="card-header lista-prodcutos box-status">
							<h3>Datos Fiscales:</h3>
							<hr>
							<h6>Tipo de contribuyente</h6>
							<p><strong><?php echo $df_tipo?></strong></p>
							<hr>
							<h6>Razón social</h6>
							<p><strong><?php echo $df_nombre?></strong></p>
							<hr>
							<h6>RFC</h6>
							<p><strong><?php echo $df_rfc?></strong></p>
							<hr>
							<h6>Dirección fiscal</h6>
							<p><strong><?php echo $df_domicilio.' '.$df_cp.' '.$df_estado?></strong></p>
							<hr>
							<h6>Teléfono de contribuyente</h6>
							<p><strong><a href="tel:<?php echo $df_numero?>" target="_blank"><?php echo $df_numero?></a></strong></p>
							<hr>
							<h6>Correo eléctronico fiscal</h6>
							<p><strong><a href="mailto:mailto:<?php echo $df_facturacion?>?subject=<?php echo $df_nombre?>" target="_blank"><?php echo $df_facturacion?></a></strong></p>
							<hr>
						</div>
					</div>
					<div class="col-12 col-lg-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Status</h5>
							</div>
							<div class="card-body">
								<p><?php echo $actionStatus?></p>
								<p><strong><?php echo $status?></strong></p>
								<?php if($activa_tienda=="1"){ ?>
								<button type="button" name="guardar" id="guardar" data-toggle="modal" data-target="#confirmar" class="btn btn-danger">Desactivar</button>
								<?php }else{ ?>
								<button type="button" name="ocultar" id="ocultar" data-toggle="modal" data-target="#confirmar" class="btn btn-success">Activar</button>
								<?php }?>
								<hr>
								<h6>Link escaparate:</h6>
								<p><?php echo SITE.$categoria_tienda.'/'.$escaparate?></p>
								<a href="<?php echo SITE.$categoria_tienda.'/'.$escaparate?>" target="_blank" class="btn btn-secondary btn-sm">Visitar</a>
								
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Plan Contratado:</h5>
							</div>
							<div class="card-body">
								<p><?php echo $nombre_tipo_tienda?></p>
								<p><strong><?php echo $txtFin?></strong></p>
								<hr>
								<?php if($changeplan==true){?>
								<form method="post" id="plan-tienda" action="<?php echo SITE?>admin/functions/update-plan-escaparate.php" accept-charset="UTF-8">
									<input type="hidden" name="idescaparate" value="<?php echo $id_escaparate?>">
									<input type="hidden" name="id_admin" value="<?php echo $id_admin?>">
									<input type="hidden" name="e" value="<?php echo $escaparate?>">
									<input type="hidden" name="cat" value="<?php echo $categoria?>">
									<div class="form-group">
										<label for="plan">Cambiar de Plan</label>
										<select name="plan" class="form-control" required>
											<option value="">Seleccione un plan</option>
								<?php
									$SQLPercentReport="SELECT * FROM tipos_tienda WHERE id_tipo_tienda != 1";
									$reqPercentReport=mysqli_query($conex, $SQLPercentReport);
									while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
										$id_tipo_tienda  = $resulPercentReport->id_tipo_tienda;
										$nombre_tipo_tienda = $resulPercentReport->nombre_tipo_tienda;
										$cantidad_tipo_tienda = $resulPercentReport->cantidad_tipo_tienda;
										$cantidad_promos_tipo_tienda = $resulPercentReport->cantidad_promos_tipo_tienda;
										$porcentaje_tienda = $resulPercentReport->porcentaje_tienda;
										$costo_tienda = $resulPercentReport->costo_tienda;
								?>
											<option value="<?php echo $id_tipo_tienda?>"><?php echo $nombre_tipo_tienda .' - Productos:'.$cantidad_tipo_tienda.' - $'.$costo_tienda?></option>
								<?php }?>
										</select>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success">Actualizar Plan</button>
										</div>
								</form>
								<?php }?>
							</div>
						</div>
						<?php if($changeplan==false){
							$SQLeditorPlan="SELECT * FROM suscripcion_tiendas WHERE id_suscripcion = $id_suscripcion";
							$reqeditorPlan=mysqli_query($conex, $SQLeditorPlan);
							while($resuleditorPlan = mysqli_fetch_object($reqeditorPlan)){
								$id_suscripcion = $resuleditorPlan->id_suscripcion;
								$id_tienda_suscripcion = $resuleditorPlan->id_tienda_suscripcion;
								$porcentaje_suscripcion_tiendas = $resuleditorPlan->porcentaje_suscripcion_tiendas;
								$cantidad_suscripcion_tiendas = $resuleditorPlan->cantidad_suscripcion_tiendas;
								$cantidad_promos_tiendas = $resuleditorPlan->cantidad_promos_tiendas;
								
								$inicio_suscripcion = date_create($resuleditorPlan->inicio_suscripcion);
								$inicio_suscripcion = date_format($inicio_suscripcion, 'Y-m-d\TH:i');
								
								$fin_suscripcion = date_create($resuleditorPlan->fin_suscripcion);
								$fin_suscripcion = date_format($fin_suscripcion, 'Y-m-d\TH:i');
							}
							
						?>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Editar Plan Contratado:</h5>
							</div>
							<div class="card-body">
								 <div id="accordion">
								  <div class="card">
									<div class="card-header" id="headingOne">
									  <h5 class="mb-0">
										<button class="btn btn-info btn-sm" data-toggle="collapse" data-target="#editor-plan" aria-expanded="true" aria-controls="collapseOne">
										  Editar Plan
										</button>
									  </h5>
									</div>
									<div id="editor-plan" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
									  <div class="card-body">
										<form method="post" accept-charset="UTF-8" action="<?php echo SITE?>admin/functions/editar-paquete-actual.php">
											<input type="hidden" value="<?php echo $id_suscripcion?>" name="idsup">
											<input type="hidden" value="<?php echo $id_escaparate?>" name="idesc">
											<input type="hidden" name="id_admin" value="<?php echo $id_admin?>">
											<input type="hidden" name="e" value="<?php echo $escaparate?>">
											<input type="hidden" name="cat" value="<?php echo $categoria?>">
											<div class="form-group">
												<label for="productos">Cantidad de productos</label>
												<input name="productos" type="number" required="required" class="form-control" value="<?php echo $cantidad_suscripcion_tiendas?>">
											</div>
											<div class="form-group">
												<label for="promociones">Cantidad de promociones</label>
												<input name="promociones" type="number" required="required" class="form-control" value="<?php echo $cantidad_promos_tiendas?>">
											</div>
											<div class="form-group">
												<label for="porcentaje">Porcentaje de comisión</label>
												<input name="porcentaje" type="number" required="required" class="form-control form-control-sm" value="<?php echo $porcentaje_suscripcion_tiendas?>">
											</div>
											<div class="form-group">
												<label for="fechafin">Fecha finalización de plan</label>
												<input name="fechafin" type="datetime-local" required="required" class="form-control" max="<?php echo $fin_suscripcion?>" min="<?php echo $inicio_suscripcion?>" value="<?php echo $fin_suscripcion?>">
											</div>
											<div class="form-group">
												<button type="submit" class="btn btn-success">Modificar</button>
											</div>
										</form>
									  </div>
									</div>
								  </div>
								  </div>
							</div>
						</div>
						<?php } ?>
					</div>
					<!--MODAL UPDATE-->
					<div class="modal" tabindex="-1" role="dialog" id="confirmar">
					  <div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title"><?php echo $TitleModal?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
							<form id="action" method="post">
								<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
								<input type="hidden" name="idescaparate" value="<?php echo $id_escaparate?>">
								<input type="hidden" name="action" value="<?php echo $activa_tienda?>">
							</form>
						  <div class="modal-body">
							<p><?php echo $TxtModal?></p>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-primary" onClick="statustienda()">Aceptar</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						  </div>
						</div>
					  </div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script>
		function statustienda(){
			var formData = $('#action').serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo SITE.'admin/functions/showescaparate.php'?>",
				data : formData,
				success: function(info) {
					console.log(info);
					if(info == 1){
						location.reload();
					}else{
						alert("Error al actualizar el escaparate.");
					}
				},
				error: function() {
					alert("Error al actualizar el escaparate.");
					location.reload();
				}
			});
		}
	</script>
</body>
</html>