<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
$hoy=date_create($datetime_now);
$fechahoy = date_format($hoy, 'Y-m-d\TH:i');
if(isset($_GET['tipo']) AND !empty($_GET['tipo'])){
	$tipo = $_GET['tipo'];
}else{
	$tipo="";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Nueva publicidad | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>js/cropper.js"></script>
<link rel="stylesheet" href="<?php echo SITE?>css/cropper.css">
<style>
    .label{cursor: pointer;}
    .progress{display: none;margin-bottom: 1rem;}
    .alert{display: none;}
	.img-container img {max-width: 100%;}
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
			<section id="edit-product">
				<h1 id="titlesection">Nueva publicidad</h1>
				<?php if(!isset($_GET['tipo']) AND empty($_GET['tipo'])){?>
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Selecione el tipo de publicidad que sea cargar.</h5>
						</div>
						<div class="card-body">
							<form method="get" accept-charset="UTF-8" action="<?php echo SITE.'admin/nueva/publicidad'?>">
								<div class="form-group">
									<select name="tipo" id="tipo_publi_form" class="form-control">
										<option value="">Selecionar</option>
										<option value="campaña">Campaña</option>
										<option value="individual">Individual</option>
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-success">Aceptar</button>
								</div>
							</form>
						</div>
					</div>
				<?php }else{
					if($tipo=='campaña'){
						$requerido= 'required';
						$tipo_publicidad="campaña";
					}else{
						$requerido= '';
						$tipo_publicidad="individual";
					}
				?>					
				<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="../functions/guardar-publi.php" id="nueva-publicidad">
					<input type="hidden" name="tipo_publicidad" value="<?php echo $tipo_publicidad?>">
					<div class="col-md-12 col-lg-9">
						<div class="row card-header lista-prodcutos">	
							<div class="col-md-12">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 1 / Top Banner</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 1">
										<img class="card-img-top" src="<?php echo SITE.'img/img_top_hb.jpg'?>" onerror="this.src='<?php echo SITE.'img/img_top_hb.jpg'?>';" alt="Imagen" id="img-img_top_publicidad">
										<input type="file" class="sr-only inputimg" name="img_top_publicidad" id="img_top_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_top_publicidad" >
									</label>
									<small>*Imagen requerida (Tamaño recomenado 1920 x 250)</small>
									<input type="hidden" name="txt-img_top_publicidad" id="txt-img_top_publicidad">
									
									<hr>
									<div class="form-group">
										<label for="link_hb_producto">URL de publicidad 1</label>
										<input type="url" name="link_hb_producto" class="form-control form-control-sm" id="link_hb_producto" <?php echo $requerido?>>
									</div>
								</div>
								</div>
							</div>
							<hr>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imágen 2 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 2">
										<img class="card-img-top" src="<?php echo SITE.'img/img_rq.png'?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_a_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_a_publicidad" id="img_sq_a_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_a_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_a_publicidad" id="txt-img_sq_a_publicidad">
									<hr>
									<div class="form-group">
										<label for="link_sqa_producto">URL de publicidad 2</label>
										<input type="url" name="link_sqa_producto" class="form-control form-control-sm" id="link_sqb_producto" <?php echo $requerido?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 3 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 3">
										<img class="card-img-top" src="<?php echo SITE.'img/img_rq.png'?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_b_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_b_publicidad" id="img_sq_b_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_b_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_b_publicidad" id="txt-img_sq_b_publicidad">
									<hr>
									<div class="form-group">
										<label for="link_sqb_producto">URL de publicidad 3</label>
										<input type="url" name="link_sqb_producto" class="form-control form-control-sm" id="link_sqb_producto" <?php echo $requerido?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 4 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 4">
										<img class="card-img-top" src="<?php echo SITE.'img/img_rq.png'?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_c_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_c_publicidad" id="img_sq_c_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_c_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_c_publicidad" id="txt-img_sq_c_publicidad">
									<hr>
									<div class="form-group">
										<label for="link_sqc_producto">URL de publicidad 4</label>
										<input type="url" name="link_sqc_producto" class="form-control form-control-sm" id="link_sqc_producto" <?php echo $requerido?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 5 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 5">
										<img class="card-img-top" src="<?php echo SITE.'img/img_rq.png'?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_d_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_d_publicidad" id="img_sq_d_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_d_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_d_publicidad" id="txt-img_sq_d_publicidad">
									<hr>
									<div class="form-group">
										<label for="link_sqd_producto">URL de publicidad 5</label>
										<input type="url" name="link_sqd_producto" class="form-control form-control-sm" id="link_sqd_producto" <?php echo $requerido?>>
									</div>
								</div>
								</div>
							</div>
							<hr>
							<div class="col-md-6 col-lg-4">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 6 Rectangular</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 6">
										<img class="card-img-top" src="<?php echo SITE.'img/img_rq_publicidad.jpg'?>" onerror="this.src='<?php echo SITE.'img/img_rq_publicidad.jpg'?>';" alt="Imagen" id="img-img_rq_a_publicidad">
										<input type="file" class="sr-only inputimg" name="img_rq_a_publicidad" id="img_rq_a_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_rq_a_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 361 x 738)</small>
									<input type="hidden" name="txt-img_rq_a_publicidad" id="txt-img_rq_a_publicidad">
									<hr>
									<div class="form-group">
										<label for="link_rqa_producto">URL de publicidad 6</label>
										<input type="url" name="link_rqa_producto" class="form-control form-control-sm" id="link_rqa_producto" <?php echo $requerido?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-4">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 7 / Rectangular</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 7">
										<img class="card-img-top" src="<?php echo SITE.'img/img_rq_publicidad.jpg'?>" onerror="this.src='<?php echo SITE.'img/img_rq_publicidad.jpg'?>';" alt="Imagen" id="img-img_rq_b_publicidad">
										<input type="file" class="sr-only inputimg" name="img_rq_b_publicidad" id="img_rq_b_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_rq_b_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 361 x 738)</small>
									<input type="hidden" name="txt-img_rq_b_publicidad" id="txt-img_rq_b_publicidad">
									
									<hr>
									<div class="form-group">
										<label for="link_rqb_producto">URL de publicidad 7</label>
										<input type="url" name="link_rqb_producto" class="form-control form-control-sm" id="link_rqb_producto" <?php echo $requerido?>>
									</div>
								</div>
								</div>
							</div>
							<hr>
							<div class="progress">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
							</div>
							<div class="alert" role="alert"></div>
							<hr>
							<div class="col-12">
								<div class="card">
									<div class="card-header ">
										 <h5 class="card-title">Mostrar solo en:</h5>
									</div>
									<div class="card-body">
										<div class="form-group">
											<label for="show_tienda_publicidad">Escaparates:</label>
											<select name="show_tienda_publicidad" class="form-control" id="show_tienda_publicidad">
												<option value="Aleatorio" selected>Aleatorio</option>

												<?php
													$sqlPromos="SELECT id_tienda, nombre_tienda, nick_tienda FROM tiendas WHERE activa_tienda = 1 ORDER BY nombre_tienda";
													$reqPromos=mysqli_query($conex, $sqlPromos);
													while($resulPromos = mysqli_fetch_object($reqPromos)){
														$id_tienda  = $resulPromos->id_tienda;
														$nombre_tienda  = $resulPromos->nombre_tienda;
														$nick_tienda  = $resulPromos->nick_tienda;
												?>
												<option value="<?php echo $nick_tienda?>"><?php echo $nombre_tienda.' - '.$nick_tienda?></option>
												<?php }?>
											</select>
										</div>
									</div>
								
							
								<hr>
							
								
									<div class="card-header">
										<h5 class="card-title">Mostrar solo en categorías:</h5>
									</div>
									<div class="card-body">
											<?php
											$sqlCats="SELECT id_categoria, nombre_categoria FROM categorias WHERE activo_categoria = 1 ORDER BY nombre_categoria";
											$reqCats=mysqli_query($conex, $sqlCats);
											while($resulCats = mysqli_fetch_object($reqCats)){
											$id_categoria   = $resulCats->id_categoria ;
											$nombre_categoria  = $resulCats->nombre_categoria;
											?>
											<div class="form-check form-check-inline">
											<input class="form-check-input categorias_check" type="checkbox" id="cat<?php echo $id_categoria?>" name="categorias[]" value="<?php echo $id_categoria?>">
											<label class="form-check-label" for="cat<?php echo $id_categoria?>"><?php echo $nombre_categoria?></label>
											</div>
											<?php }?>										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Tipo de publicación: </h5>
							</div>
							<div class="card-body">
								<h3><?php echo ucfirst ($tipo)?></h3>
									<div class="form-group">
										<select name="tipo" id="tipo_publi_form" class="form-control" onChange="tipopubli(this.value)">
											
											<option value="campaña" id="opcampaña">Campaña</option>
											<option value="individual" id="opindividual">Individual</option>
										</select>
									</div>
								<script>
									document.getElementById("op<?php echo $tipo?>").selected = "true";
									function tipopubli(variable){
										window.location.replace("<?php echo SITE.'admin/nueva/publicidad?tipo='?>"+variable);
									}
								</script>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Publicar</h5>
							</div>
							<div class="card-body">
								<button type="submit" name="guardar" id="guardar" class="btn btn-success">Guardar</button>
								<button type="submit" name="ocultar" id="ocultar" class="btn btn-dark">Borrador</button>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Cliente</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="nombre_publicidad">Seleccione un cliente</label>
									<select name="cliente_publicidad" class="form-control" id="cliente_publicidad">
										<option value="">Selecciona un cliente</option>
										<option value="nuevo">Nuevo Cliente</option>
										<?php
											$sqlPromos="SELECT id_cliente_publi, nombre_cliente_publi, activo_cliente_publi FROM clientes_publi WHERE activo_cliente_publi = 1 ORDER BY nombre_cliente_publi";
											$reqPromos=mysqli_query($conex, $sqlPromos);
											while($resulPromos = mysqli_fetch_object($reqPromos)){
												$id_cliente_publi  = $resulPromos->id_cliente_publi;
												$nombre_cliente_publi  = $resulPromos->nombre_cliente_publi;
										?>
										<option value="<?php echo $id_cliente_publi?>"><?php echo $nombre_cliente_publi?></option>
										<?php }?>
									</select>
								</div>
								<div class="form-group hidden" id="nuevo-cliente">
									<label for="nuevo_cliente">Nuevo Cliente</label>
									<input type="text" name="nombre_cliente_publi" class="form-control">
								</div>
							</div>
						</div>
						
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Precio:</h5>
							</div>
							<div class="card-body">
								<div class="form-group" id="tipo_precio_publicidad_box">
									<label for="tipo_precio_publicidad">Tipo de Publicidad:</label>
									<select name="tipo_precio_publicidad" id="tipo_precio_publicidad" class="form-control" required>
										<option value="">Seleccionar</option>
										<option value="intercambio">Intercambio</option>
										<option value="cortesia">Cortesía</option>
										<option value="normal">Normal</option>
										<option value="descuento">Descuento</option>
									</select>
								</div>
								<div class="form-group" id="precio_publicidad_box">
									<label for="precio_publicidad">Precio de Publicidad:</label>
									<input type="number" name="precio_publicidad" id="precio_publicidad" class="form-control" min="0" value="0">
								</div>
								<div class="form-group" id="descuento_precio_publicidad_box">
									<label for="descuento_precio_publicidad">% de descuento :</label>
									<input type="number" name="descuento_precio_publicidad" id="descuento_precio_publicidad" class="form-control" min="0" value="0">
								</div>
								<div class="form-group">
									<label for="iva_precio_publicidad">IVA:</label>
									<input type="number" name="iva_precio_publicidad" id="iva_precio_publicidad" class="form-control" readonly value="0">
								</div>
								<div class="form-group">
									<label for="total_precio_publicidad">Precio Final:</label>
									<input type="number" name="total_precio_publicidad" id="total_precio_publicidad" class="form-control" readonly value="0">
								</div>
							</div>
						</div>
						
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Periodo</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="fecha_inicio_publicidad">Fecha de inicio</label>
									<input type="datetime-local" name="fecha_inicio_publicidad" id="fecha_inicio_publicidad" min="<?php echo $fechahoy?>" onchange="passfecha()" class="form-control" value="<?php echo $fechahoy?>" required>
								</div>
							<hr>
								<div class="form-group">
									<label for="fecha_fin_publicidad">Fecha de final</label>
									<input type="datetime-local" name="fecha_fin_publicidad" id="fecha_fin_publicidad" class="form-control" min="<?php echo $fechahoy?>" required>
								</div>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Nombre de Publicidad</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="nombre_publicidad">Nombre de Publicidad</label>
									<input type="text" name="nombre_publicidad" class="form-control form-control-lg" id="nombre_publicidad" required>
								</div>
							</div>
						</div>
					</div>
				</form>
				<?php } ?>
				<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalLabel">Cortar imagen</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="img-container">
								<img id="image" src="<?php echo SITE?>img/default-image-product.jpg">
							</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-primary" id="crop">Cortar</button>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script>
	
	//UPLOADERFILES
		window.addEventListener('DOMContentLoaded', function () {
		//Variables especificas
		var avatar;
		var image = document.getElementById('image');
		var input;
		var $progress = $('.progress');
		var $progressBar = $('.progress-bar');
		var $alert = $('.alert');
		var $modal = $('#modal');
		//Variables generales
		var cropper;
		var filename;
		var dataimg;
		var aspc;

		$('[data-toggle="tooltip"]').tooltip();
		//Evocamos funcion Start
		//input.addEventListener('change', function (e) {
		$( ".inputimg" ).change(function(e) {
			var element = $(this),
    		imgid = element.data("imgid");
			avatar = document.getElementById('img-'+imgid);
			input = element;
			dataimg = imgid;
		
			var files = e.target.files;
			var done = function (url) {
				input.value = '';
				image.src = url;
				$alert.hide();
				$modal.modal({backdrop: 'static', keyboard: false},'show');
			};
			var reader;
			var file;
			var url;
			if (files && files.length > 0) {
				file = files[0];
				if (URL) {
					done(URL.createObjectURL(file));
				} else if (FileReader) {
					reader = new FileReader();
						reader.onload = function (e) {
						done(reader.result);
					};
					reader.readAsDataURL(file);
				}
				filename = file.name;
			}
		 });
		//Evocamos funcion End
		$modal.on('shown.bs.modal', function () {
			switch(dataimg){
				case 'img_top_publicidad':
					var aspc = 192/25;
					break;
				case 'img_rq_a_publicidad':
					var aspc = 359/735;
					break;
				case 'img_rq_b_publicidad':
					var aspc = 359/735;
					break;
				default:
					var aspc = 1/1;
					break;
			}
		  
			cropper = new Cropper(image, {
				aspectRatio: aspc,
				viewMode: 2,
				autoCropArea: 1,
			});
		}).on('hidden.bs.modal', function () {
			cropper.destroy();
			cropper = null;
			document.getElementById(dataimg).value = '';
      	});

		document.getElementById('crop').addEventListener('click', function () {
        	var initialAvatarURL;
        	var canvas;
        	$modal.modal('hide');
			if (cropper) {
				switch (dataimg){
					case 'img_top_publicidad':
						var width= 1920;
						var height= 250;
						break;
					case 'img_rq_a_publicidad':
						var width= 359;
						var height= 735;
						break;
					case 'img_rq_b_publicidad':
						var width= 359;
						var height= 735;
						break;
					default:
						var width= 425;
						var height= 425;
						break;
				}
				canvas = cropper.getCroppedCanvas({
					width: width,
					height: height,
				});
          		initialAvatarURL = avatar.src;
				avatar.src = canvas.toDataURL();
				$progress.show();
				$alert.removeClass('alert-success alert-warning');
				canvas.toBlob(function (blob) {
					var formData = new FormData();
					//console.log(filename+dataimg);
					formData.append('avatar', blob, filename);
					formData.append('part', dataimg);
					formData.append('folder', "publicidad");
					//console.log(formData);
					$.ajax('../functions/uploader-img-admin.php', {
						method: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						xhr: function () {
							var xhr = new XMLHttpRequest();
						xhr.upload.onprogress = function (e) {
							var percent = '0';
							var percentage = '0%';
							if (e.lengthComputable) {
								percent = Math.round((e.loaded / e.total) * 100);
								percentage = percent + '%';
								$progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
							}
						};
						return xhr;
						},
						success: function (info) {
							$alert.show().addClass('alert-success').text('Subida exitosa');
							$("#txt-"+dataimg).val(info);
						},
						error: function (info) {
							avatar.src = initialAvatarURL;
							$alert.show().addClass('alert-warning').text('Error al subir');
							$("#txt-"+dataimg).val(info);
						},
						complete: function () {
							$progress.hide();
						},
					});
				});
			}
		});
	});
		
	$("#form-new-prod").submit(function(event){
		var imgprin=$("#txt-img_a_producto").val();
		var imgdesc=$("#txt-img_e_producto").val();
		var imgtalll=$("#txt-img_tallas_producto").val();
		console.log(imgprin+imgdesc);
		if(imgprin=="" || imgdesc=="" || imgtalll==""){
			alert("Por favor comprueba que todas la imagenes esten cargadas.");
			event.preventDefault();
		}else{
			
		}
	});
		
	function passfecha(){
		var date=$("#fecha_inicio_publicidad").val()
		$('#fecha_fin_publicidad').attr('min', date);
	}
	$("#cliente_publicidad").change(function() {
		var nuevo=$("#cliente_publicidad").val();
		if(nuevo=="nuevo"){
			$("#nuevo-cliente").removeClass("hidden");
		}else{
			$("#nuevo-cliente").addClass("hidden");
		}
	});
		
	$("#tipo_precio_publicidad").change(function() {
		var tipo_precio=$("#tipo_precio_publicidad").val();

		switch (tipo_precio){
			case 'normal':
				$("#descuento_precio_publicidad_box").addClass("hidden");
				$("#precio_publicidad_box").removeClass("hidden");
				$("#descuento_precio_publicidad").val('0');
			break;
			case 'cortesia':
				$("#descuento_precio_publicidad_box").addClass("hidden");
				$("#precio_publicidad_box").addClass("hidden");
				$("#descuento_precio_publicidad").val('0');
				$("#precio_publicidad").val('0');
				$("#total_precio_publicidad").val('0');
			break;
			case 'intercambio':
				$("#descuento_precio_publicidad_box").removeClass("hidden");
				$("#precio_publicidad_box").removeClass("hidden");
			break;
			case 'descuento':
				$("#descuento_precio_publicidad_box").removeClass("hidden");
				$("#precio_publicidad_box").removeClass("hidden");
			break;
		}
	});
		
	$("#precio_publicidad").change(function() {
		calcularTotal();
	});
	$("#descuento_precio_publicidad").change(function() {
		calcularTotal();
	});
	function calcularTotal(){
		var precio=$("#precio_publicidad").val();
		var descuento=$("#descuento_precio_publicidad").val();
		var descuentonum = precio * (descuento /100);
		var subtotal = precio - descuentonum;
		var iva = subtotal*0.16;
		var total = subtotal + iva;
		$("#iva_precio_publicidad").val(iva);
		$("#total_precio_publicidad").val(total);
	}
	$("#show_tienda_publicidad").change(function() {
		var showonly = $("#show_tienda_publicidad").val();
		if(showonly =="Aleatorio"){
			$('.categorias_check').prop("disabled", false);
		}else{
			$('.categorias_check').prop("disabled", true);
			$('.categorias_check').prop('checked', false); 
		}
	});
		<?php if($tipo == 'paquete'){?>
			$("#nueva-publicidad").submit(function(event){
				var imgtop=$("#txt-img_top_publicidad").val();
				var sqa=$("#txt-img_sq_a_publicidad").val();
				var sqb=$("#txt-img_sq_b_publicidad").val();
				var sqc=$("#txt-img_sq_c_publicidad").val();
				var sqd=$("#txt-img_sq_d_publicidad").val();
				var rqa=$("#txt-img_rq_a_publicidad").val();
				var rqb=$("#txt-img_rq_b_publicidad").val();

				if(imgtop=="" || sqa=="" || sqb=="" || sqc=="" || sqd=="" || rqa=="" || rqb==""){
					alert("Comprueba que todas las imagenes esten cargadas.");
					event.preventDefault();
				}else{

				}
			});
		<?php }?>
	</script>
</body>
</html>
