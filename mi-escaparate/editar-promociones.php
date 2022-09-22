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
			header('location:'.SITE.'mi-escaparate/entrar');
	}
	if(isset($_GET['id']) AND $_GET['id']!=""){
		if(isset($_GET['mod'])){
			$status="Actualizado con éxito";
		}else{
			$status="";
		}
		$id_tienda = IDTIENDA;
		$idpromo= $_GET['id'];
		$sqlPromos="SELECT id_promocion, tienda_rel_promocion, nombre_promocion, fecha_inicio_promocion, fecha_fin_promocion, img_promocion, url_promocion, clicks_promocion, tipo_promocion, activo_promocion FROM promociones WHERE tienda_rel_promocion = $id_tienda AND id_promocion = $idpromo";
		$reqPromos=mysqli_query($conex, $sqlPromos);
		$promoscount = mysqli_num_rows($reqPromos);
		if($promoscount==0){
			header('location:'.SITE.'mi-escaparate/mis-promociones');
		}
		while($resulPromos = mysqli_fetch_object($reqPromos)){
			$id_promocion  = $resulPromos->id_promocion;
			$nombre_promocion  = $resulPromos->nombre_promocion;
			$fecha_inicio_promocion  = date_create($resulPromos->fecha_inicio_promocion);
			$fecha_fin_promocion  = date_create($resulPromos->fecha_fin_promocion);
			$img_promocion  = $resulPromos->img_promocion;
			$url_promocion  = $resulPromos->url_promocion;
			$clicks_promocion  = $resulPromos->clicks_promocion;
			$tipo_promocion  = $resulPromos->tipo_promocion;
			$activo_promocion  = $resulPromos->activo_promocion;
			$fecha_inicio = date_format($fecha_inicio_promocion, 'Y-m-d\TH:i');
			$fecha_fin = date_format($fecha_fin_promocion, 'Y-m-d\TH:i');
			
		}
		if($activo_promocion==1){
			$visible ="Visible";
		}else{
			$visible ="Oculto";
		}
	}else{
		header('location:'.SITE.'mi-escaparate/mis-promociones');
	}
	//RAMDOM KEY
	function rand_char($length) {
	  $random = '';
	$length = $length/2;
	  for ($i = 0; $i < $length; $i++) {
		$random .= chr(mt_rand(65, 90));
		$random .= chr(mt_rand(48, 57));
	  }
	  return $random;
	}
	$_SESSION["key"]=rand_char(16);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mis Promos - <?php echo NICKTIENDA?> | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>js/cropper.js"></script>
<link rel="stylesheet" href="<?php echo SITE?>css/cropper.css">
<style>
	.label{cursor: pointer;}
	.progress{display: none;margin-bottom: 1rem;}
	.alert{display: none;}
	.img-container img {max-width: 100%;}
	#options-box{display: none;}
	#options-box.show{display: block}
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
			<section id="edit-product">
				<h1 id="titlesection">Editar Promoción</h1>
				<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="../functions/guardar-edicion-promo.php" id="form-new-promo">
					<input type="hidden" value="<?php echo $id_promocion?>" name="id_promocion" required>
					<div class="col-md-12 col-lg-8 col-xl-9">
						<div class="row card-header lista-prodcutos">							
							<div class="card" style="width: 100%">
								<div class="card-body row">
									<div class="col-md-12 col-lg-6">
										<div class="card">
											<div class="card-header ">
												 <h5 class="card-title">Imágen de promoción</h5>
											</div>
											<div class="card-body">
												<label class="label" data-toggle="tooltip" title="Imagen para promoción">
												<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_promocion?>" alt="Imagen" id="img-img_promocion" onerror="this.src='<?php echo SITE.'img/prevtallas.jpg'?>';">
												<input type="file" class="sr-only inputimg" name="img_promocion" id="img_promocion" accept="image/x-png,image/jpeg" data-imgid="img_promocion">
												</label>
												<span>*Imagen requerida</span>
												<input type="hidden" name="txt-img_promocion" id="txt-img_promocion" required title="Por favor suba la imagen de promoción." value="<?php echo $img_promocion?>">
												<input type="hidden" name="old-img_promocion" id="old-img_promocion" value="<?php echo $img_promocion?>">
											</div>
										</div>
									</div>
									<div class="col-md-12 col-lg-6">
										<div class="form-group">
											<label for="nombre_promocion">Nombre de promoción</label>
											<input type="text" name="nombre_promocion" class="form-control form-control-lg" id="nombre_promocion" value="<?php echo $nombre_promocion?>" required>
										</div>
										<div class="form-group">
											<label for="url_promocion">URL de promoción</label>
											<input type="url" name="url_promocion" class="form-control form-control-sm" value="<?php echo $url_promocion?>" id="url_promocion" required>
										</div>
										<hr>
										<div class="form-group">
											<label for="fecha_inicio_promocion">Fecha de inicio</label>
											<input type="datetime-local" name="fecha_inicio_promocion" id="fecha_inicio_promocion" min="2020-01-01T0:00:00" onchange="passfecha()" class="form-control" value="<?php echo $fecha_inicio?>" required>
										</div>
										<hr>
										<div class="form-group">
											<label for="fecha_fin_promocion">Fecha de final</label>
											<input type="datetime-local" name="fecha_fin_promocion" id="fecha_fin_promocion" class="form-control" min="<?php echo $fecha_inicio?>" value="<?php echo $fecha_fin?>" required>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="progress">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
							</div>
							<div class="alert" role="alert"></div>
						</div>
					</div>
					<div class="col-md-12 col-lg-4 col-xl-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Publicar</h5>
							</div>
							<div class="card-body">
								<div style="width: 100%">
									<span><?php echo $status?></span>
									<p>Visibilidad: <?php echo $visible?></p>									
								</div>
								<?php if($TotalPromos_rows <= $cantidad_promos_tiendas){ ?>
								<button type="submit" name="guardar" id="guardar" class="btn btn-success my-2">Guardar</button>
								<?php }else{ ?>
								<h6>Haz alacanzado el limite de tus promociones publicadas.</h6>
								<?php } ?>
								<button type="submit" name="ocultar" id="ocultar" class="btn btn-dark my-2">Ocultar</button>
								<button type="button" name="eliminar" id="eliminar" data-toggle="modal" data-target="#eliminar-modal"  class="btn btn-danger my-2">Eliminar</button>
								<div class="clearfix"></div>
								<hr>
								<a href="<?php echo SITE.'mi-escaparate/mis-promociones'?>" class="btn btn-warning my-2">Regresar</a>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Tipo de Promo</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="tipo_promocion">Tamaño de promoción</label>
									<select name="tipo_promocion" class="form-control" id="tipo_promocion">
										<?php if($tipo_promocion == 'sq'){?>
										<option value="sq" selected>Cuadrada</option>
										<option value="rq">Rectangular</option>
										<?php }else{ ?>
										<option value="sq">Cuadrada</option>
										<option value="rq" selected>Rectangular</option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</form>
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
		<div class="modal" tabindex="-1" role="dialog" id="eliminar-modal">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title">Confirmación</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<p>Confirme que desea eliminar la promoción <?php echo $nombre_promocion?></p>
				  <small>*Esta acción no se puede deshacer.</small>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-primary" onClick="eliminar(<?php echo $id_promocion?>)" id="conf-eliminar">Eliminar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			  </div>
			</div>
		  </div>
		</div>
	</section>
	<?php include('parts/footer.php');?>
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
		var aspc,width,height;
		var selecttipopromo,tipopromo;

		$('[data-toggle="tooltip"]').tooltip();
		//Evocamos funcion Start
		//input.addEventListener('change', function (e) {
		$("#tipo_promocion").change(function(){
			var div = document.getElementById('tipo_promocion');
			var tipodiv = div.options[div.selectedIndex].text;
			
			if(tipodiv !='Seleciona una opción'){
				$("#options-box").addClass("show");
				document.getElementById("img_promocion").value = "";
				document.getElementById('img-img_promocion').src = "";
			}else{
				$("#options-box").removeClass("show");
				cropper.destroy();
				cropper = null;
				document.getElementById("img_promocion").value = "";
				document.getElementById('img-img_promocion').src = "";
			}						
		});
									
		$( ".inputimg" ).change(function(e) {
			
			selecttipopromo = document.getElementById('tipo_promocion');
			var tipopromo = selecttipopromo.options[selecttipopromo.selectedIndex].text;
			if(tipopromo=='Cuadrada'){
				aspc = 1/1;
				width= 1280;
				height= 1280;
			}else{
				aspc = 1280/749;
				width= 1280;
				height= 749;
			}
			var element = $(this),
    		imgid = element.data("imgid");
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
			/*switch(dataimg){
				case 'img_promocion':
					var aspc = 1280/749;
					break;
				default:
					var aspc = 'NaN';
					break;
			}*/
		  
			cropper = new Cropper(image, {
				aspectRatio: aspc,
				viewMode: 2,
			});
		}).on('hidden.bs.modal', function () {
			cropper.destroy();
			cropper = null;
			document.getElementById("img_promocion").value = "";
      	});

		document.getElementById('crop').addEventListener('click', function () {
        	var initialAvatarURL;
        	var canvas;
        	$modal.modal('hide');
			if (cropper) {
				/*switch (dataimg){
					case 'img_promocion':
						var width= 1280;
						var height= 749;
						break;
					default:
						var width= 1280;
						var height= 1280;
						break;
				}*/
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
					formData.append('oldimg', oldimg);
					//console.log(formData);
					$.ajax('../functions/uploader-img-escaparate.php', {
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
		$("#form-new-promo").submit(function(event){
			var imgprin=$("#txt-img_promocion").val();
			console.log(imgprin);
			if(imgprin==""){
				alert("Por favor sube una imagen.");
				document.getElementById('img-img_promocion').src = "";
				event.preventDefault();
			}else{

			}
		});
		function passfecha(){
			var date=$("#fecha_inicio_promocion").val()
			$('#fecha_fin_promocion').attr('min', date);
		}
		
		function eliminar(idproduct){
		document.getElementById("conf-eliminar").disabled = true;
		$("#conf-eliminar").html('Cargando...');
		var formDel = new FormData();
		//console.log(filename+dataimg);
		formDel.append('id', idproduct);
		formDel.append('key', '<?php echo $_SESSION["key"]?>');
		formDel.append('img', '<?php echo $img_promocion?>');
		$.ajax('../functions/eliminar-promocion.php', {
			method: 'POST',
			data: formDel,
			processData: false,
			contentType: false,
			success: function (info) {
				console.log(info);
				switch (info){
					case '1':
						window.location.replace("<?php echo SITE?>mi-escaparate/mis-promociones");		
						break;
					case '2':
						alert("No fue posible borrar tu promoción, intentalo más tarde.");
						location.reload();	
					break;
					default:
						alert("No fue posible borrar tu promoción, intentalo más tarde.");
						location.reload();
				}
				
				
			},
			error: function (info) {
				console.log(info);
				alert("No fue posible borrar tu promoción, intentalo más tarde.");
				location.reload();
				
			},
			complete: function () {
				
			},
		});
	}
	</script>
</body>
</html>