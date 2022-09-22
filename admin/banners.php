<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Editar imagenes de sitio | Ecommerce</title>
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
				<h1 id="titlesection">Imagenes de sitio</h1>
				<div class="row">
					<div class="col-lg-9 col-md-12">
							<div class="card lista-prodcutos">
								<div class="card-header ">
									 <h5 class="card-title">Home Banner</h5>
								</div>
								<div class="card-body">
									<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="functions/guardar-banner.php?id=1">
									<?php
										$sqlBanner="SELECT id_banner, img_banner, url_banner, activo_banner, target_banner FROM site_banner WHERE id_banner = 1";
						   				$reqBanner=mysqli_query($conex, $sqlBanner);
						   				while($resulBanner = mysqli_fetch_object($reqBanner)){
											$img_banner = $resulBanner->img_banner;
											$url_banner = $resulBanner->url_banner;
											$target_banner = $resulBanner->target_banner;
										}
									?>
									<label class="label" data-toggle="tooltip" title="Home Banner">
										<img class="card-img-top" src="<?php echo SITE.'img/'.$img_banner?>" onerror="this.src='<?php echo SITE.'img/Home_Banner1763x720.jpg'?>';" alt="Imagen" id="img-img_homebanner">
										<input type="file" class="sr-only inputimg" name="img_homebanner" id="img_homebanner" accept="image/x-png,image/jpeg" data-imgid="img_homebanner" data-tipo="banners" data-idbanner="1">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 1763 x 720)</small>
									<input type="hidden" name="txt-img_homebanner" id="txt-img_homebanner" value="<?php echo $img_banner?>">
									<input type="hidden" name="old-img_homebanner" id="old-img_homebanner" value="<?php echo $img_banner?>">
									<hr>
									<div class="form-group">
										<label for="link_img_homebanner">URL de Home Banner</label>
										<input type="url" name="link_img_homebanner" class="form-control form-control-sm" id="link_img_homebanner" required value="<?php echo $url_banner?>">
									</div>
									<div class="form-group">
										<label for="target_img_homebanner">Abrir en:</label>
										<select name="target_img_homebanner" class="form-control form-control-sm" required>
											<?php if($target_banner==1){?>
											<option value="1" selected>Misma Ventana</option>
											<option value="2">Ventana Nueva</option>
											<?php }else{?>
											<option value="1">Misma Ventana</option>
											<option value="2" selected>Ventana Nueva</option>
											<?php }?>
										</select>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-success btn-block">Cambiar Home Banner</button>
									</div>
									</form>
								</div>
							</div>
							<hr>
							<div class="card lista-prodcutos">
								<div class="card-header ">
									 <h5 class="card-title">Footer Banner</h5>
								</div>
								<div class="card-body">
									<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="functions/guardar-banner.php?id=2">
									<?php
										$sqlBanner="SELECT id_banner, img_banner, url_banner, activo_banner, target_banner FROM site_banner WHERE id_banner = 2";
						   				$reqBanner=mysqli_query($conex, $sqlBanner);
						   				while($resulBanner = mysqli_fetch_object($reqBanner)){
											$img_banner = $resulBanner->img_banner;
											$url_banner = $resulBanner->url_banner;
											$target_banner = $resulBanner->target_banner;
										}
									?>
									<label class="label" data-toggle="tooltip" title="Footer Banner">
										<img class="card-img-top" src="<?php echo SITE.'img/'.$img_banner?>" onerror="this.src='<?php echo SITE.'img/Footer_Banner1820x190.jpg'?>';" alt="Imagen" id="img-img_footerbanner">
										<input type="file" class="sr-only inputimg" name="img_footerbanner" id="img_footerbanner" accept="image/x-png,image/jpeg" data-imgid="img_footerbanner" data-tipo="banners" data-idbanner="2">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 1820 x 190)</small>
									<input type="hidden" name="txt-img_footerbanner" id="txt-img_footerbanner" value="<?php echo $img_banner?>">
									<input type="hidden" name="old-img_footerbanner" id="old-img_footerbanner" value="<?php echo $img_banner?>">
									
									<hr>
									<div class="form-group">
										<label for="link_img_footerbanner">URL de Footer Banner</label>
										<input type="url" name="link_img_footerbanner" class="form-control form-control-sm" id="link_img_footerbanner" value="<?php echo $url_banner?>" required>
									</div>
									<div class="form-group">
										<label for="target_img_footerbanner">Abrir en:</label>
										<select name="target_img_footerbanner" class="form-control form-control-sm" required>
											<?php if($target_banner==1){?>
											<option value="1" selected>Misma Ventana</option>
											<option value="2">Ventana Nueva</option>
											<?php }else{?>
											<option value="1">Misma Ventana</option>
											<option value="2" selected>Ventana Nueva</option>
											<?php }?>
										</select>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-success btn-block">Cambiar Footer Banner</button>
									</div>
									</form>
								</div>
							</div>
							<hr>
							<div class="card lista-prodcutos">
								<div class="card-header ">
									 <h5 class="card-title">Banner Páginas internas</h5>
								</div>
								<div class="card-body">
									<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="functions/guardar-banner.php?id=3">
									<?php
										$sqlBanner="SELECT id_banner, img_banner, url_banner, activo_banner, target_banner FROM site_banner WHERE id_banner = 3";
						   				$reqBanner=mysqli_query($conex, $sqlBanner);
						   				while($resulBanner = mysqli_fetch_object($reqBanner)){
											$img_banner = $resulBanner->img_banner;
											$url_banner = $resulBanner->url_banner;
											$target_banner = $resulBanner->target_banner;
										}
									?>
									<label class="label" data-toggle="tooltip" title="Home Banner Páginas internas">
										<img class="card-img-top" src="<?php echo SITE.'img/'.$img_banner?>" onerror="this.src='<?php echo SITE.'img/Home_Banner1763x720.jpg'?>';" alt="Imagen" id="img-img_intbanner">
										<input type="file" class="sr-only inputimg" name="img_intbanner" id="img_intbanner" accept="image/x-png,image/jpeg" data-imgid="img_intbanner" data-tipo="banners" data-idbanner="3">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 1763 x 720)</small>
									<input type="hidden" name="txt-img_intbanner" id="txt-img_intbanner" value="<?php echo $img_banner?>">
									<input type="hidden" name="old-img_intbanner" id="old-img_intbanner" value="<?php echo $img_banner?>">
									<hr>
									<div class="form-group">
										<label for="link_img_intbanner">URL de Home Banner</label>
										<input type="url" name="link_img_intbanner" class="form-control form-control-sm" id="link_img_intbanner" required value="<?php echo $url_banner?>">
									</div>
									<div class="form-group">
										<label for="target_img_intbanner">Abrir en:</label>
										<select name="target_img_intbanner" class="form-control form-control-sm" required>
											<?php if($target_banner==1){?>
											<option value="1" selected>Misma Ventana</option>
											<option value="2">Ventana Nueva</option>
											<?php }else{?>
											<option value="1">Misma Ventana</option>
											<option value="2" selected>Ventana Nueva</option>
											<?php }?>
										</select>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-success btn-block">Cambiar Banner Páginas Internas</button>
									</div>
									</form>
								</div>
							</div>
					</div>
					<div class="col-3">
						<?php if(isset($_GET['mod'])){?>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Status</h5>
							</div>
							<div class="card-body">
							<p>	<?php if($_GET['mod']=="true"){ echo "Actualizado";}; if($_GET['mod']=="false" ){ echo "Error al actualizar.";};?></p>
							</div>
						</div>
						<?php }?>
					</div>
					</div>
				<hr>
				<h1 id="titlesection">Imagenes de bienvenida</h1>
				<div class="row">
					<div class="col-lg-9 col-md-12">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Fondo de bienvenida escaparates</h5>
							</div>
							<div class="card-body">
								<?php
								function getdata($id){
									$comi_conex = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
									$sqlContenido="SELECT file_contenido FROM contenido_editable WHERE id_contenido = $id";
									$reqContenido=mysqli_query($comi_conex, $sqlContenido);	
									while($resulContenido = mysqli_fetch_object($reqContenido)){		
										return $file_contenido = $resulContenido->file_contenido;
									}
								};
								?>
								<div class="row">
								<div class="col-12">
									<label class="label" data-toggle="tooltip" title="Fondo de bienvenida escaparates">
										<img class="card-img-top" src="<?php echo SITE.'img/'.getdata(2);?>" onerror="this.src='<?php echo SITE.'img/prev_desc.jpg'?>';" alt="Imagen" id="img-img_esc_bienv">
										<input type="file" class="sr-only inputimg" name="img_esc_bienv" id="img_esc_bienv" accept="image/x-png,image/jpeg" data-imgid="img_esc_bienv" data-tipo="bienvenida" data-idbanner="2">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 1920 x 1112)</small>
									<input type="hidden" name="txt-img_esc_bienv" id="txt-img_esc_bienv" value="<?php echo getdata(2);?>">
									<input type="hidden" name="old-img_esc_bienv" id="old-img_esc_bienv" value="<?php echo getdata(2);?>">									
								</div>
							</div>
							</div>
						</div>

						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Fondo de bienvenida administradores</h5>
							</div>
							<div class="card-body">
								<div class="row">
								<div class="col-12">
									<label class="label" data-toggle="tooltip" title="Fondo de bienvenida escaparates">
										<img class="card-img-top" src="<?php echo SITE.'img/'.getdata(3);?>" onerror="this.src='<?php echo SITE.'img/prev_desc.jpg'?>';" alt="Imagen" id="img-img_admin_bienv">
										<input type="file" class="sr-only inputimg" name="img_admin_bienv" id="img_admin_bienv" accept="image/x-png,image/jpeg" data-imgid="img_admin_bienv" data-tipo="bienvenida" data-idbanner="3">
									</label>
								</div>
									<small>*Imagen requerida (Tamaño recomenado 1920 x 1112)</small>
									<input type="hidden" name="txt-img_admin_bienv" id="txt-img_admin_bienv" value="<?php echo getdata(3);?>">
									<input type="hidden" name="old-img_admin_bienv" id="old-img_admin_bienv" value="<?php echo getdata(3);?>">									
									<input type="hidden" id="3" name="id" value="3">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-9 col-md-12">
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
						</div>
						<div class="alert" role="alert"></div>
					</div>
				</div>
			</section>
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
		var dataimg,oldimg;
		var aspc;
		var datatipo,dataid;
		

		$('[data-toggle="tooltip"]').tooltip();
		//Evocamos funcion Start
		//input.addEventListener('change', function (e) {
		$( ".inputimg" ).change(function(e) {
			var element = $(this),
    		imgid = element.data("imgid");
			datatipo = element.data("tipo");
			dataid = element.data("idbanner");
			avatar = document.getElementById('img-'+imgid);
			input = element;
			dataimg = imgid;
			oldimg = document.getElementById("old-"+imgid).value;
		
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
				case 'img_homebanner':
					var aspc = 1736/720;
					break;
				case 'img_footerbanner':
					var aspc = 182/19;
					break;
				case 'img_intbanner':
					var aspc = 1736/720
					break;
				case 'img_esc_bienv':
					var aspc = 1920/1112;
					break;
				case 'img_admin_bienv':
					var aspc = 1920/1112;
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
					case 'img_homebanner':
						var width= 1763;
						var height= 720;
						break;
					case 'img_footerbanner':
						var width= 1820;
						var height= 190;
						break;
					case 'img_intbanner':
						var width= 1763;
						var height= 720;
						break;
					case 'img_admin_bienv':
						var width= 1920;
						var height= 1112;
						break;
					case 'img_esc_bienv':
						var width= 1920;
						var height= 1112;
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
					formData.append('tipo', datatipo);
					formData.append('oldimg', oldimg);
					formData.append('id_post', dataid);
					//console.log(formData);
					$.ajax('functions/uploader-img-admin-banners.php', {
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
							$("#old-"+dataimg).val(info);
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
	</script>
</body>
</html>