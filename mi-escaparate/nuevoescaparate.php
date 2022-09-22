<?php
	session_start();
	require('connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.SITE.'entrar');
	}
	include('functions/mailconfirm.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{$http="http://";};
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
	$edadminima = date('Y-m-d', strtotime('-15 years'));
	$last = explode("/", $server, 5);
	$urlparts = $http.$last[2].'/'.$last[3].'/';
	$aviso="";
	if(isset($_POST['escaparate']) AND $_POST['escaparate'] != ""){
		$escaparate = $_POST['escaparate'];
		$nombre = $_POST['nombre'];
		if(!isset($_POST['apellidos']) AND empty($_POST['apellidos'])){
			$apellidos="";
		}else{
			$apellidos = $_POST['apellidos'];
		}
		$emailnew = $_POST['emailnew'];
		$passwordnew = md5($_POST['passwordnew']);
		$confirmapasswordnew = md5($_POST['confirmapasswordnew']);
		$terminos = $_POST['terminos'];
		$nombre_tienda = $nombre.' '.$apellidos;
		//rectificamos el nombre de la tienda
		$sql ="SELECT nick_tienda FROM tiendas WHERE UPPER(nick_tienda) = UPPER('$escaparate')";
		$req=mysqli_query($conex, $sql);
		$okTienda = $req->num_rows;
		//rectificamos el correo
		$sqlNMA ="SELECT email_tienda FROM tiendas WHERE email_tienda = '$emailnew'";
		$reqNMA=mysqli_query($conex, $sqlNMA);
		$okMail = $req->num_rows;
		if($okTienda!=1 AND $okMail != 1 AND $passwordnew == $confirmapasswordnew){
			$newuser="INSERT INTO tiendas
		(nombre_tienda, nick_tienda, email_tienda, email_contacto_tienda,pass_tienda,activa_tienda) VALUES ('$nombre_tienda','$escaparate', '$emailnew', '$emailnew','$passwordnew','2')";
			if ($conex->query($newuser) === TRUE) {
				$idNewTienda=$conex->insert_id;
				//CREAR FOLDER
				if (!file_exists("../img/tiendas/$escaparate")) {
					mkdir("../img/tiendas/$escaparate", 0755, true);
				}
				//CREAR FOLDER
				//NEWESCAPARATE
				$new="primermail";
				sendMailCliente($idNewTienda,$escaparate,$emailnew, $new);
				//NEWESCAPARATE
			} else {
				$idNewTienda="0";
				$aviso="Lo sentimos no es posible crear tu cuenta.";
			}
		}
	}
	if((isset($_GET['escaparate']) AND $_GET['escaparate']!= '')){
		$escaparate = $_GET['escaparate'];
		$sqlreturn ="SELECT id_tienda, nick_tienda, email_tienda, logo_tienda, activa_tienda, cover_tienda FROM tiendas WHERE UPPER(nick_tienda) = UPPER('$escaparate')";
		$reqreturn=mysqli_query($conex, $sqlreturn);
		while($resulreturn = mysqli_fetch_object($reqreturn)){
			$idNewTienda = $resulreturn->id_tienda;
			$emailnew = $resulreturn->email_tienda;
			$cover_tienda = $resulreturn->cover_tienda;
			$logo_tienda = $resulreturn->logo_tienda;
		}
		}else{
			if(($_SESSION["tiendauser"]!="" AND isset($_SESSION["tiendauser"]))){
				$mailescaparate=$_SESSION["tiendauser"];
				$sqlreturn ="SELECT id_tienda, nick_tienda, email_tienda, activa_tienda, logo_tienda, cover_tienda FROM tiendas WHERE UPPER(email_tienda) = UPPER('$mailescaparate')";
				$reqreturn=mysqli_query($conex, $sqlreturn);
				while($resulreturn = mysqli_fetch_object($reqreturn)){
					$idNewTienda = $resulreturn->id_tienda;
					$emailnew = $resulreturn->email_tienda;
					$escaparate = $resulreturn->nick_tienda;
					$cover_tienda = $resulreturn->cover_tienda;
					$logo_tienda = $resulreturn->logo_tienda;
				}
			}
	}
	

$_SESSION["idtienda"]=$idNewTienda;
$_SESSION["tiendauser"]=$emailnew;
//$idNewTienda = 5;
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Configura tu cuenta | Ecommerce</title>
<?php include("parts/header.php");?>
<link rel="stylesheet" href="<?php echo $server?>css/escaparatecss.css">
<script src="<?php echo $server?>js/ckeditor/ckeditor.js"></script>
<script src="<?php echo SITE?>js/cropper.js"></script>
<link rel="stylesheet" href="<?php echo SITE?>css/cropper.css">
<style>
	.label{cursor: pointer;}
	.progress{display: none;margin-bottom: 1rem;}
	.alert{display: none;}
	.img-container img {max-width: 100%;}
</style>
</head>
<body>
	<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
		<div class="container">
			<div class="navbar-collapse justify-content-between align-items-center w-100">
				<a href="<?php echo SITE?>mi-escaparate" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce.svg" alt="Ecommerce" width="82px"></a> 
			</div>
		</div>
	</nav>
	<section id="login-box">
		<div class="container">
			<div class="row">
				<?php if($idNewTienda!=0){?>
				<h1 class="title-section">Configura tu escaparate</h1>
				<br>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 offset-lg-3">
					<form accept-charset="UTF-8" enctype="multipart/form-data" action="nuevo/paso2" id="completar-escaparate" method="post" onsubmit="return checkcat()" class="box-white">
						<input type="hidden" name="escaparate" value="<?php echo $escaparate?>">
						<input type="hidden" name="idtienda" value="<?php echo $idNewTienda?>">
						<input type="hidden" name="email_tienda" value="<?php echo $emailnew?>">
						<div class="row">
							<div class="form-group col-sm-4">
								<label for="cumple">Fecha de Cumpleaños</label>
								<input name="cumple" type="date" required max="<?php echo $edadminima?>">
							</div>
							<div class="form-group col-sm-4">
								<label for="tipodeescaparate">Tipo de escaparate</label>
								<select name="tipodeescaparate" class="form-control" id="tipodeescaparate" required>
									<option value="">Seleciona un tipo de escaparate</option>
									<option value="influencers">Influencer</option>
									<option value="empresas">Empresa</option>
									<option value="profesionales">Profesionales</option>
								</select>
							</div>
							<div class="form-group col-sm-4" id="box-color">
								<label for="color">Color de tienda</label>
								<input type="color" name="color" minlength="6" maxlength="6" required>
							</div>
						</div>
						<div class="form-group">
							<label for="desctienda">Descripción de tienda</label>
							<textarea class="form-control" id="desctienda" name="desctienda" rows="3" required></textarea>
						</div>
						<div class="form-group">
							<h6>Logo de escaparate:</h6>
							<label class="label" data-toggle="tooltip" title="Logo de escaparate:">
								<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$logo_tienda?>" alt="Imagen" id="img-logo_tienda" onerror="this.src='<?php echo SITE.'img/prev_logo.jpg'?>';">
								<input type="file" class="sr-only inputimg" name="logo_tienda" id="logo_tienda" accept="image/x-png,image/jpeg" data-imgid="logo_tienda">
							</label>
							<span>*Imagen requerida</span>
							<input type="hidden" name="txt-logo_tienda" id="txt-logo_tienda" value="<?php echo SITE.'img/tiendas'.NICKTIENDA.'/demo.jpg'?>" required title="Por favor agrega tu logo.">
							<input type="hidden" name="old-logo_tienda" id="old-logo_tienda" value="<?php echo SITE.'img/tiendas'.NICKTIENDA.'/'.$logo_tienda?>">
						</div>
						<hr>
						<div class="form-group">
							<h6>Portada de escaparate:</h6>
							<label class="label" data-toggle="tooltip" title="Portada de escaparate:">
								<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$cover_tienda?>" alt="Imagen" id="img-cover_tienda" onerror="this.src='<?php echo SITE.'img/prev_portada.jpg'?>';">
								<input type="file" class="sr-only inputimg" name="cover_tienda" id="cover_tienda" accept="image/x-png,image/jpeg" data-imgid="cover_tienda">
							</label>
							<span>*Imagen requerida</span>
							<input type="hidden" name="txt-cover_tienda" id="txt-cover_tienda" value="<?php echo SITE.'img/tiendas'.NICKTIENDA.'/demo.jpg'?>" required title="Por favor agrega tu portada.">
							<input type="hidden" name="old-cover_tienda" id="old-cover_tienda" value="<?php echo SITE.'img/tiendas'.NICKTIENDA.'/'.$cover_tienda?>">				
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
						</div>
						<div class="alert" role="alert"></div>
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
						<div class="form-group">
							<div class="row">
								<div class="col-sm-8">
									<label for="video_tienda">ID de video de YouTube</label>
									<input type="text" name="video_tienda" class="form-control" onchange="videoloader(this.value)">
								</div>
								<div class="col-sm-4">
									<iframe id="ytplayer" type="text/html" width="266" height="150" src="https://www.youtube.com/embed/"  frameborder="0"/></iframe>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="fb_tienda"><i class="fab fa-facebook"></i> Url Facebook</label>
							<input type="url" name="fb_tienda" class="form-control" placeholder="https://www.facebook.com/">
						</div>
						<div class="form-group">
							<label for="insta_tienda"><i class="fab fa-instagram"></i> Url Instagram</label>
							<input type="url" name="insta_tienda" class="form-control" placeholder="https://www.instagram.com/">
						</div>
						<div class="form-group">
							<label for="tw_tienda"><i class="fab fa-twitter"></i> Url Twitter</label>
							<input type="url" name="tw_tienda" class="form-control" placeholder="https://twitter.com/">
						</div>
						<div class="form-group">
							<label for="yt_tienda"><i class="fab fa-youtube"></i> Url YouTube</label>
							<input type="url" name="yt_tienda" class="form-control" placeholder="https://www.youtube.com/">
						</div>
						<div class="form-group">
							<label for="tik_tienda"><i class="fab fa-tiktok"></i> Url TikTok</label>
							<input type="url" name="tik_tienda" class="form-control" placeholder="https://www.tiktok.com/">
						</div>
						<div class="form-group">
							<label for="twitch_tienda"><i class="fab fa-twitch"></i> Url Twitch</label>
							<input type="url" name="twitch_tienda" class="form-control" placeholder="https://www.twitch.tv/">
						</div>
						<div class="form-group">
							<label for="in_tienda"><i class="fab fa-linkedin"></i> Url LinkedIn</label>
							<input type="url" name="in_tienda" class="form-control" placeholder="https://www.linkedin.com/">
						</div>
						<div class="form-group">
							<label for="web_tienda"><i class="fas fa-link"></i> Url Web</label>
							<input type="url" name="web_tienda" class="form-control" placeholder="https://sitioweb.com">
						</div>
						<div class="form-group">
							<label for="wapp_tienda"><i class="fab fa-whatsapp"></i> Whatsapp</label>
							<input type="tel" name="wapp_tienda" class="form-control" pattern="[0-9]{12}" title="Por favor ingresa el código de país + tu número" placeholder="521234567890">
						</div>
						<div class="form-group">
							<label for="maps_tienda"><i class="fas fa-map-marked-alt"></i> Link Google Maps</label>
							<input type="url" name="maps_tienda" class="form-control" placeholder="https://goo.gl/maps/">
						</div>
						<hr>
						<div class="form-group">
							<h5>Selecciona las categorías que deseas vender.</h5>
						<?php
							$GetCategorias="SELECT id_categoria, nombre_categoria, activo_categoria FROM categorias WHERE activo_categoria = 1";
							$reqCategorias=mysqli_query($conex, $GetCategorias);
							while($resulCategorias = mysqli_fetch_object($reqCategorias)){
								$id_categoria = $resulCategorias->id_categoria;
								$nombre_categoria = $resulCategorias->nombre_categoria;
							?>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="checkbox" id="cat<?php echo $id_categoria?>" name="categorias[]" value="<?php echo $id_categoria?>">
							  <label class="form-check-label" for="cat<?php echo $id_categoria?>"><?php echo $nombre_categoria?></label>
							</div>
							<?php
							}
						?>
						</div>
						<hr>
						<input type="hidden" name="paso" value="3">
						<button type="submit" class="btn btn-success">Continuar <i class="fas fa-chevron-right"></i></button>
					</form>
				</div>
				<?php }else{ ?>
				<h1 class="text-danger"><?php echo $aviso?></h1>
				<?php } ?>
			</div>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
		
		function videoloader(idYT){		
			var SRC = "https://www.youtube.com/embed/"+idYT;
			
			$('#ytplayer').prop('src', SRC)
		}
		
		CKEDITOR.replace( 'desctienda',{
			language: 'es-mx',
			uiColor: '#d1d1e0',
			height: 200
		});
		function checkcat(){
			checked = $("input[type=checkbox]:checked").length;

			if(!checked) {
			alert("Por favor, seleccione al menos 1 categoría de la lista.");
			return false;
			//event.preventDefault();	
			}
		}
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

		$('[data-toggle="tooltip"]').tooltip();
		//Evocamos funcion Start
		//input.addEventListener('change', function (e) {
		$( ".inputimg" ).change(function(e) {
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
			switch(dataimg){
				case 'logo_tienda':
					var aspc = 1280/749;
					break;
				case 'cover_tienda':
					var aspc = 24/11;
					break;
				default:
					var aspc = 'NaN';
					break;
			}
		  
			cropper = new Cropper(image, {
				aspectRatio: aspc,
				viewMode: 2,
			});
		}).on('hidden.bs.modal', function () {
			cropper.destroy();
			cropper = null;
      	});

		document.getElementById('crop').addEventListener('click', function () {
        	var initialAvatarURL;
        	var canvas;
        	$modal.modal('hide');
			if (cropper) {
				switch (dataimg){
					case 'logo_tienda':
						var width= 1280;
						var height= 749;
						break;
					case 'cover_tienda':
						var width= 1200;
						var height= 800;
						break;
					default:
						var width= 648;
						var height= 861;
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
					formData.append('oldimg', oldimg);
					//console.log(formData);
					$.ajax('functions/uploader-img-escaparate.php', {
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
							$("#old-"+dataimg).val(info);
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
