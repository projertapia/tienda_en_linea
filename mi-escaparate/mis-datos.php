<?php
	session_start();
	require('connect/conect_usrer.php');
	if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
	}
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
	$last = explode("/", $server, 5);
	$urlparts = $http.$last[2].'/'.$last[3].'/';
	$conex->query("SET lc_time_names = 'es_MX';");
	date_default_timezone_set('America/Mexico_City');
	// Unix
	setlocale(LC_TIME, 'es_ES.UTF-8');
	// En windows
	setlocale(LC_TIME, 'spanish');
	setlocale(LC_MONETARY, 'es_MX');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.$server.'entrar');
	}
	
	$sqlEditor="SELECT t.id_tienda, t.nombre_tienda, t.nick_tienda, t.email_tienda, t.pass_tienda, t.desc_tienda, t.video_tienda, t.fb_tienda, t.insta_tienda, t.tw_tienda, t.yt_tienda, t.tik_tienda, t.twitch_tienda, t.in_tienda, t.web_tienda, t.wapp_tienda, t.maps_tienda, t.color_tienda, t.logo_tienda, t.cover_tienda, t.cumple_tienda, t.cuenta_verif_tienda, t.df_nombre, t.df_tipo, t.df_rfc, t.df_domicilio, t.df_estado, t.df_cp, t.df_numero, t.df_facturacion, t.categorias_tienda
	FROM tiendas t
	WHERE t.id_tienda= $id_tienda AND t.activa_tienda = 1";
	$reqEditor=mysqli_query($conex, $sqlEditor);
	while($resulEditor = mysqli_fetch_object($reqEditor)){
		$nombre_tienda = $resulEditor->nombre_tienda;
		$email_tienda = $resulEditor->email_tienda;
		$pass_tienda = $resulEditor->pass_tienda;
		$desc_tienda = $resulEditor->desc_tienda;
		$video_tienda = $resulEditor->video_tienda;
		$fb_tienda = $resulEditor->fb_tienda;
		$insta_tienda = $resulEditor->insta_tienda;
		$tw_tienda = $resulEditor->tw_tienda;
		$yt_tienda = $resulEditor->yt_tienda;
		$tik_tienda = $resulEditor->tik_tienda;
		$twitch_tienda = $resulEditor->twitch_tienda;
		$in_tienda = $resulEditor->in_tienda;
		$web_tienda = $resulEditor->web_tienda;
		$wapp_tienda = $resulEditor->wapp_tienda;
		$maps_tienda = $resulEditor->maps_tienda;
		$color_tienda = $resulEditor->color_tienda;
		$logo_tienda = $resulEditor->logo_tienda;
		$cover_tienda = $resulEditor->cover_tienda;
		$cumple_tienda = $resulEditor->cumple_tienda;
		$cuenta_verif_tienda = $resulEditor->cuenta_verif_tienda;
		$df_nombre = $resulEditor->df_nombre;
		$df_tipo = $resulEditor->df_tipo;
		$df_rfc = $resulEditor->df_rfc;
		$df_domicilio = $resulEditor->df_domicilio;
		$df_estado = $resulEditor->df_estado;
		$df_cp = $resulEditor->df_cp;
		$df_numero = $resulEditor->df_numero;
		$df_facturacion = $resulEditor->df_facturacion;
		$categorias_tienda = $resulEditor->categorias_tienda;
		
		
	}
	$categorias_tienda = trim($categorias_tienda, ',');
	
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
<title>Mis datos | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>mi-escaparate/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo SITE?>mi-escaparate/js/bootstrap-show-password.js"></script>
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
						<h1 id="titlesection">Mis datos</h1>
					</div>
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<strong>Datos de cuenta</strong>
							<div class="editar-direccion">
								<a href="#" data-toggle="collapse" data-target="#datoscuenta" aria-expanded="false" aria-controls="user" class="collapsed"><i class="fas fa-edit"></i> Editar</a>								
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-6">
								<h6>Tipo de cuenta:</h6>
								<p><strong><?php echo $nombre_tipo_tienda?></strong></p>
								</div>
								<div class="col-sm-6">
									<p style="font-size: 12px; margin: 2px 0">Fecha de vencimiento del plan: <strong><?php echo $finplan?></strong></p>
									<p style="font-size: 12px; margin: 2px 0">Limite de productos publicados: <strong><?php echo $cantidad_suscripcion_tiendas?></strong></p>
									<p style="font-size: 12px; margin: 2px 0">Limite de promociones publicadas: <strong><?php echo $cantidad_promos_tiendas?></strong></p>
									<p style="font-size: 12px; margin: 2px 0">Comisión del: <strong><?php echo $porcentaje_suscripcion_tiendas?>%</strong></p>
								</div>
								<hr>
							</div>
							<h4>Nombre:</h4>
							<p><?php echo $nombre_tienda?></p>
							<hr>
							<h4>E-mail:</h4>
							<p><?php echo $email_tienda?></p>
							<hr>
							<h4>Fecha de cumpleaños:</h4>
							<p><?php echo $cumple_tienda?></p>
							<hr>
							<h5>Descripción de tienda:</h5>
							<span><?php echo $desc_tienda?></span>
						</div>
						<!--EDITOR-->
						<div class="collapse" id="datoscuenta">
						  <div class="card card-body">
							<form method="post" accept-charset="UTF-8" id="cuenta">
								<input type="hidden" value="<?php echo IDTIENDA?>" name="idtienda">
								<input type="hidden" value="datoscuenta" name="tipo_udpate">
								<div class="form-group">
									<label for="nombre_tienda">Nombre:</label>
									<input type="text" class="form-control" name="nombre_tienda" value="<?php echo $nombre_tienda?>">
								</div>
								<div class="form-group">
									<label for="email_tienda">Email:</label>
									<input type="email" class="form-control" name="email_tienda" value="<?php echo $email_tienda?>">
								</div>
								<div class="form-group">
									<label for="cumple_tienda">Fecha de cumpleaños:</label>
									<input type="date" class="form-control" name="cumple_tienda" value="<?php echo $cumple_tienda?>">
								</div>
								<div class="form-group">
									<label for="desc_tienda">Descripción de tienda</label>
									<textarea class="form-control" id="desctienda" name="desc_tienda" rows="3" required><?php echo $desc_tienda?></textarea>
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-primary" id="updateDatos" onclick="actualizardatos('1')">Actualizar</button>
								</div>
							</form>
						  </div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<strong>Personalización de cuenta</strong>
							<div class="editar-direccion">
								<a href="#" data-toggle="collapse" data-target="#personalizacion" aria-expanded="false" aria-controls="user" class="collapsed"><i class="fas fa-edit"></i> Editar</a>								
							</div>
							<hr>
							<div class="row">
								<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
									<h5>ID video:</h5>
									<p><?php echo $video_tienda?></p>
									<iframe width="160" height="150" src="https://www.youtube.com/embed/<?php echo $video_tienda?>" frameborder="0" allow="accelerometer;  encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width: 100%"></iframe>
								</div>
								<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
									<h5>Color:</h5>
									<p><?php echo $color_tienda?></p>
									<span style="width: 100%; height: 80px; display: block; background-color:#<?php echo $color_tienda?>"></span>
								</div>
								<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
									<h5>Logo:</h5>
									<img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$logo_tienda?>" class="img-fluid" onerror="this.src='<?php echo SITE?>img/prevtallas.jpg'">
								</div>
								<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
									<h5>Portada:</h5>
									<img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$cover_tienda?>" class="img-fluid" onerror="this.src='<?php echo SITE?>img/prevtallas.jpg'">
								</div>
							</div>
						</div>
						<!--EDITOR-->
						<div class="collapse" id="personalizacion">
						  <div class="card card-body">
							<form method="post" accept-charset="UTF-8" id="personalizacionform" enctype="multipart/form-data">
								<input type="hidden" value="<?php echo IDTIENDA?>" name="idtienda">
								<input type="hidden" value="personalizacion" name="tipo_udpate">
								<div class="row">
									<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label for="video_tienda">ID video:</label>
											<input type="text" class="form-control" name="video_tienda" value="<?php echo $video_tienda?>" onchange="videoloader(this.value)">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<iframe id="ytplayer" type="text/html" width="266" height="150" src="https://www.youtube.com/embed/<?php echo $video_tienda?>"  frameborder="0"/ style="width: 100%"></iframe>
									</div>
									<div class="col-12" style="height: 15px"></div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="color_tienda">Color:</label>
											<input type="color" class="form-control" name="color_tienda" value="#<?php echo $color_tienda?>">
										</div>
									</div>
									<div class="col-12" style="height: 15px"></div>
									<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label for="logo_tienda">Logo de tienda:</label>
											<input type="file" accept="image/jpeg" name="logo_tienda" id="logo_tienda" required class="form-control-file">
											<br>
											<small id="logoinfo" class="text-muted">*Solo imagenes en formato .jpg o .png con peso menor a 1mb.</small>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$logo_tienda?>" class="img-fluid" id="prevlogo">
									</div>
									<div class="col-12" style="height: 15px"></div>
									<div class="col-md-8 col-sm-12">
										<div class="form-group">
											<label for="cover_tienda">Portada de escaparate:</label>
											<input type="file" accept="image/jpeg" name="cover_tienda" id="cover_tienda" required class="form-control-file">
											<br>
											<small id="logoinfo" class="text-muted">*Solo imagenes en formato .jpg o .png con peso menor a 1mb.</small>
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$cover_tienda?>" class="img-fluid" id="prevcover">
									</div>
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-primary" id="updatePers" onclick="actualizardatos('2')">Actualizar</button>
								</div>
							</form>
						  </div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<strong>Redes Sociales</strong>
							<div class="editar-direccion">
								<a href="#" data-toggle="collapse" data-target="#datosredes" aria-expanded="false" aria-controls="user" class="collapsed"><i class="fas fa-edit"></i> Editar</a>								
							</div>
							<hr>
							<?php if($fb_tienda!=""){?>
							<h6><i class="fab fa-facebook"></i> Url Facebook:</h6>
							<p><?php echo $fb_tienda?></p>
							<hr>
							<?php }
								if($insta_tienda!=""){?>
							<h6><i class="fab fa-instagram"></i> Url Instagram:</h6>
							<p><?php echo $insta_tienda?></p>
							<hr>
							<?php }
								if($tw_tienda!=""){?>
							<h6><i class="fab fa-twitter"></i> Url Twitter:</h6>
							<p><?php echo $tw_tienda?></p>
							<hr>
							<?php }
								if($yt_tienda!=""){?>
							<h6><i class="fab fa-youtube"></i> Url YouTube:</h6>
							<p><?php echo $yt_tienda?></p>
							<hr>
							<?php }
								if($tik_tienda!=""){?>
							<h6><i class="fab fa-tiktok"></i> Url TikTok:</h6>
							<p><?php echo $tik_tienda?></p>
							<hr>
							<?php }
								if($twitch_tienda!=""){?>
							<h6><i class="fab fa-twitch"></i> Url Twitch:</h6>
							<p><?php echo $twitch_tienda?></p>
							<hr>
							<?php }
								if($in_tienda!=""){?>
							<h6><i class="fab fa-linkedin"></i> Url LinkedIn:</h6>
							<p><?php echo $in_tienda?></p>
							<hr>
							<?php }
								if($web_tienda!=""){?>
							<h6><i class="fas fa-link"></i> Url Web:</h6>
							<p><?php echo $web_tienda?></p>
							<?php }?>
							<hr>
							<?php 
								if($wapp_tienda!=""){?>
							<h6><i class="fab fa-whatsapp"></i> WhatsApp:</h6>
							<p>https://api.whatsapp.com/send?phone=<?php echo $wapp_tienda?></p>
							<?php }?>
							<hr>
							<?php
								if($maps_tienda!=""){?>
							<h6><i class="fas fa-map-marked-alt"></i> Google Maps:</h6>
							<p><?php echo $maps_tienda?></p>
							<?php }?>
						</div>
						<!--EDITOR-->
						<div class="collapse" id="datosredes">
						  <div class="card card-body">
							<form method="post" accept-charset="UTF-8" id="redes">
								<input type="hidden" value="<?php echo IDTIENDA?>" name="idtienda">
								<input type="hidden" value="datosredes" name="tipo_udpate">
								<div class="form-group">
									<label for="fb_tienda"><i class="fab fa-facebook"></i> Url Facebook</label>
									<input type="url" name="fbtienda" class="form-control" value="<?php echo $fb_tienda?>">
								</div>
								<div class="form-group">
									<label for="insta_tienda"><i class="fab fa-instagram"></i> Url Instagram</label>
									<input type="url" name="instatienda" class="form-control" value="<?php echo $insta_tienda?>">
								</div>
								<div class="form-group">
									<label for="tw_tienda"><i class="fab fa-twitter"></i> Url Twitter</label>
									<input type="url" name="twtienda" class="form-control" value="<?php echo $tw_tienda?>">
								</div>
								<div class="form-group">
									<label for="yt_tienda"><i class="fab fa-youtube"></i> Url YouTube</label>
									<input type="url" name="yttienda" class="form-control" value="<?php echo $yt_tienda?>">
								</div>
								<div class="form-group">
									<label for="tik_tienda"><i class="fab fa-tiktok"></i> Url TikTok</label>
									<input type="url" name="tiktienda" class="form-control" value="<?php echo $tik_tienda?>">
								</div>
								<div class="form-group">
									<label for="twitch_tienda"><i class="fab fa-twitch"></i> Url Twitch</label>
									<input type="url" name="twitchtienda" class="form-control" value="<?php echo $twitch_tienda?>">
								</div>
								<div class="form-group">
									<label for="in_tienda"><i class="fab fa-linkedin"></i> Url LinkedIn</label>
									<input type="url" name="intienda" class="form-control" value="<?php echo $in_tienda?>">
								</div>
								<div class="form-group">
									<label for="web_tienda"><i class="fas fa-link"></i> Url Web</label>
									<input type="url" name="webtienda" class="form-control" value="<?php echo $web_tienda?>">
								</div>
								<div class="form-group">
									<label for="wapp_tienda"><i class="fab fa-whatsapp"></i> Whatsapp</label>
									<input type="tel" name="wapp_tienda" class="form-control" pattern="[0-9]{12}" title="Por favor ingresa el código de país + tu número" value="<?php echo $wapp_tienda?>">
								</div>
								<div class="form-group">
									<label for="maps_tienda"><i class="fas fa-map-marked-alt"></i> Link Google Maps</label>
									<input type="url" name="maps_tienda" class="form-control" value="<?php echo $maps_tienda?>">
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-primary" id="updateredes" onclick="actualizardatos('3')">Actualizar</button>
								</div>
							</form>
						</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<strong>Categorías de escaparate</strong>
							<div class="editar-direccion">
								<a href="#" data-toggle="collapse" data-target="#catescap" aria-expanded="false" aria-controls="user" class="collapsed"><i class="fas fa-edit"></i> Editar</a>								
							</div>
							<hr>
							<div class="row">
							<?php
								if($categorias_tienda!="" or $categorias_tienda!= NULL or $categorias_tienda != null){
								$GetCurrentCat = "SELECT id_categoria, nombre_categoria, activo_categoria FROM categorias WHERE activo_categoria = 1 AND id_categoria IN ($categorias_tienda)";
								$reqCurrentCat=mysqli_query($conex, $GetCurrentCat);
								while($resulCurrentCat = mysqli_fetch_object($reqCurrentCat)){
								$id_categoria = $resulCurrentCat->id_categoria;
								$nombre_categoria = $resulCurrentCat->nombre_categoria;							
							?>
								<span style="margin: 5px; padding: 5px 10px;  background-color: #fdeb00; border-radius: 4px;"><?php echo $nombre_categoria?></span>
							<?php
								}
							}
							?>
							</div>
						</div>
						<!--EDITOR-->
						<div class="collapse" id="catescap">
						  <div class="card card-body">
							<form method="post" accept-charset="UTF-8" id="categorias">
								<input type="hidden" value="<?php echo IDTIENDA?>" name="idtienda">
								<input type="hidden" value="categorias" name="tipo_udpate">
								<?php
									$GetCategorias="SELECT id_categoria, nombre_categoria, activo_categoria FROM categorias WHERE activo_categoria = 1";
									$reqCategorias=mysqli_query($conex, $GetCategorias);
									while($resulCategorias = mysqli_fetch_object($reqCategorias)){
										$id_categoria = $resulCategorias->id_categoria;
										$nombre_categoria = $resulCategorias->nombre_categoria;
									?>
									<div class="form-check form-check-inline required" >
									
									<?php
										
										if (strpos($categorias_tienda, $id_categoria) !== false) {
										//if (preg_match('/\b'.$id_categoria.'\b/', $categorias_tienda) !== false) {
											//if (preg_match("/$id_categoria\b/", "$categorias_tienda")) {
									?>
									  <input class="form-check-input" type="checkbox" id="cat<?php echo $id_categoria?>" name="categorias[]" value="<?php echo $id_categoria?>" >
									  <label class="form-check-label" for="cat<?php echo $id_categoria?>"><?php echo $nombre_categoria?></label>
									<?php }else{ ?>
										<input class="form-check-input" type="checkbox" id="cat<?php echo $id_categoria?>" name="categorias[]" value="<?php echo $id_categoria?>">
									  	<label class="form-check-label" for="cat<?php echo $id_categoria?>"><?php echo $nombre_categoria?></label>
									<?php }?>
									</div>
									<?php
									}
								?>
								<script>
									var miArray = [<?php echo $categorias_tienda?>];
									miArray.forEach( function(valor, indice, array) {
										//console.log("En el índice " + indice + " hay este valor: " + valor);
										$("#cat"+valor).prop('checked', true);
									});
								</script>
								<div class="form-group">
									<button type="button" class="btn btn-primary" id="updatecategorias" onclick="actualizardatos('6')">Actualizar</button>
								</div>
							</form>
							</div>
						</div>
					</div>
						
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<strong>Datos fiscales</strong>
							<div class="editar-direccion">
								<a href="#" data-toggle="collapse" data-target="#datosfiscales" aria-expanded="false" aria-controls="user" class="collapsed"><i class="fas fa-edit"></i> Editar</a>								
							</div>
							<hr>
							<h6>Tipo de contribuyente</h6>
							<p><?php echo $df_tipo?></p>
							<hr>
							<h6>Razón social</h6>
							<p><?php echo $df_nombre?></p>
							<hr>
							<h6>RFC</h6>
							<p><?php echo $df_rfc?></p>
							<hr>
							<h6>Dirección fiscal</h6>
							<p><?php echo $df_domicilio.' '.$df_cp.' '.$df_estado?></p>
							<hr>
							<h6>Teléfono de contribuyente</h6>
							<p><?php echo $df_numero?></p>
							<hr>
							<h6>Correo eléctronico fiscal</h6>
							<p><?php echo $df_facturacion?></p>
							<hr>
						</div>
						<!--EDITOR-->
						<div class="collapse" id="datosfiscales">
						  <div class="card card-body">
							<form method="post" accept-charset="UTF-8" id="fiscales">
								<input type="hidden" value="<?php echo IDTIENDA?>" name="idtienda">
								<input type="hidden" value="datosfiscales" name="tipo_udpate">
								<div class="form-group">
									<label for="rsocial">Razón social</label>
									<input name="rsocial" type="text" required class="form-control" value="<?php echo $df_nombre?>" minlength="2" maxlength="250">
								</div>
								<div class="form-group">
									<label for="tipo">¿Qué tipo de contribuyente eres?</label>
									<select name="tipo" class="form-control" required>										
										<option value="Persona Física">Persona Física</option>
										<option value="Persona Moral">Persona Moral</option>
									</select>
									<script>
										$("select option[value='<?php echo $df_tipo?>']").attr("selected","selected");
									</script>
								</div>
								<div class="form-group">
									<label for="rfc">¿Cuál es tu RFC?</label>
									<input name="rfc" type="text" required class="form-control" maxlength="13" minlength="12" onkeyup="javascript:this.value=this.value.toUpperCase();" title="Por favor ingresa un RFC válido." value="<?php echo $df_rfc?>">
								</div>
								<div class="form-group">
									<label for="df_domicilio">Domicilio Fiscal</label>
									<input name="df_domicilio" type="text" required class="form-control" value="<?php echo $df_domicilio?>">
								</div>
								<div class="form-group">
									<label for="df_estado">Estado del domicilio Fiscal</label>
									<select name="df_estado" class="form-control" required="" id="df_estado">
										<option value="Aguascalientes">Aguascalientes</option>
										<option value="Baja California">Baja California</option>
										<option value="Baja California Sur">Baja California Sur</option>
										<option value="Campeche">Campeche</option>
										<option value="CDMX">CDMX</option>
										<option value="Chiapas">Chiapas</option>
										<option value="Chihuahua">Chihuahua</option>
										<option value="Coahuila">Coahuila</option>
										<option value="Colima">Colima</option>
										<option value="Durango">Durango</option>
										<option value="Edo. De México">Edo. De México</option>
										<option value="Guanajuato">Guanajuato</option>
										<option value="Guerrero">Guerrero</option>
										<option value="Hidalgo">Hidalgo</option>
										<option value="Jalisco">Jalisco</option>
										<option value="Michoacán">Michoacán</option>
										<option value="Morelos">Morelos</option>
										<option value="Nayarit">Nayarit</option>
										<option value="Nuevo León">Nuevo León</option>
										<option value="Oaxaca">Oaxaca</option>
										<option value="Puebla">Puebla</option>
										<option value="Querétaro">Querétaro</option>
										<option value="Quintana Roo">Quintana Roo</option>
										<option value="San Luis Potosí">San Luis Potosí</option>
										<option value="Sinaloa">Sinaloa</option>
										<option value="Sonora">Sonora</option>
										<option value="Tabasco">Tabasco</option>
										<option value="Tamaulipas">Tamaulipas</option>
										<option value="Tlaxcala">Tlaxcala</option>
										<option value="Veracruz">Veracruz</option>
										<option value="Yucatán">Yucatán</option>
										<option value="Zacatecas">Zacatecas</option>
									</select>
									<script>
										$("select option[value='<?php echo $df_estado?>']").attr("selected","selected");
									</script>
								</div>
								<div class="form-group">
									<label for="df_cp">Códigó Postal Fiscal</label>
									<input name="df_cp" type="number" required class="form-control" maxlength="5" minlength="5" value="<?php echo $df_cp?>">
								</div>
								<div class="form-group">
									<label for="df_numero">Número de contacto Fiscal</label>
									<input name="df_numero" type="tel" required class="form-control" value="<?php echo $df_numero?>">
								</div>
								<div class="form-group">
									<label for="df_facturacion">Correo electrónico para facturación</label>
									<input name="df_facturacion" type="email" required class="form-control" value="<?php echo $df_facturacion?>">
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-primary" id="updatefiscales" onclick="actualizardatos('4')">Actualizar</button>
								</div>
							</form>
						  </div>
						</div>
					</div>
					<!--CONTRASEÑA-->
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<strong>Seguridad</strong>
							<div class="editar-direccion">
								<a href="#" data-toggle="collapse" data-target="#datospassword" aria-expanded="false" aria-controls="user" class="collapsed"><i class="fas fa-edit"></i> Editar</a>								
							</div>
							<hr>
							<h6>Contraseña:</h6>
							<p>******</p>
						</div>
						<!--EDITOR-->
						<div class="collapse" id="datospassword">
						  <div class="card card-body">
							<form method="post" accept-charset="UTF-8" id="password">
								<input type="hidden" value="<?php echo IDTIENDA?>" name="idtienda">
								<input type="hidden" value="datospassword" name="tipo_udpate">
								<div class="form-group">
									<label for="oldpassword">Contraseña anterior</label>
									<input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="Contraseña actual" required autocomplete="off" data-toggle="password">
								</div>
								<div class="form-group">
									<label for="nuevapassword">Nueva contraseña</label>
									<input type="password" name="nuevapassword" id="nuevapassword" class="form-control" required  autocomplete="off" placeholder="Nueva contraseña" data-toggle="password">
								</div>
								<div class="form-group">
									<label for="confpassword">Confirma contraseña</label>
									<input type="password" name="confpassword" id="confpassword" class="form-control" required placeholder="Repite la nueva contraseña" autocomplete="off" data-toggle="password">
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-primary" id="updatepassword" onclick="actualizardatos('5')">Actualizar</button>
								</div>
							  </form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
		function videoloader(idYT){		
			var SRC = "https://www.youtube.com/embed/"+idYT;
			
			$('#ytplayer').prop('src', SRC)
		}
		//prev logo
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
				$('#prevlogo').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$("#logo_tienda").change(function() {
			readURL(this);
		});
		//prev portada
		function readPORTADA(portada) {
			if (portada.files && portada.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
				$('#prevcover').attr('src', e.target.result);
				}

				reader.readAsDataURL(portada.files[0]);
			}
		}

		$("#cover_tienda").change(function() {
			readPORTADA(this);
		});
		CKEDITOR.replace( 'desctienda',{
			language: 'es-mx',
			uiColor: '#d1d1e0',
			height: 200
		});
		//UPDATE DATOS
		function actualizardatos(act){
			
			switch (act) {
  				case '1':
					var desctienda = CKEDITOR.instances['desctienda'].getData();
					var formData = $('#cuenta').serializeArray();
					formData[formData.length] = { name: "desc_tienda", value: desctienda };
					//console.log(formData);
					var typeinput = 'application/x-www-form-urlencoded';
					var pdata=true;
					var ctype= 'application/x-www-form-urlencoded; charset=UTF-8';
					break;
				case '2':
					var formData = new FormData(document.getElementById("personalizacionform"));
					var typeinput = 'multipart/form-data';
					var pdata=false;
					var ctype=false;
					break;
				case '3':
					var formData = $('#redes').serializeArray();
					var typeinput = 'application/x-www-form-urlencoded';
					var pdata=true;
					var ctype= 'application/x-www-form-urlencoded; charset=UTF-8';
					//console.log(formData);
					break;
				case '4':
					var formData = $('#fiscales').serializeArray();
						var typeinput = 'application/x-www-form-urlencoded';
						var pdata=true;
					var ctype= 'application/x-www-form-urlencoded; charset=UTF-8';
					break;
				case '5':
					var typeinput = 'application/x-www-form-urlencoded';
					var pdata=true;
					var ctype= 'application/x-www-form-urlencoded; charset=UTF-8';
					var formData = $('#password').serializeArray();
					var newpass=document.getElementById("nuevapassword").value; 
					var confpassword=document.getElementById("confpassword").value; 
					if(newpass != confpassword){
						newpass.value = "";
						confpassword.value = "";
						alert("La contraseña no coincide.");	
						return true;
					}
					break;
				case '6':
					var checknum = $('div.required :checkbox:checked').length;
					if(checknum==0){
						event.preventDefault;
						
						alert("Por favor, seleccione al menos una categoría.");
						break;
					}else{
						var formData = $('#categorias').serializeArray();
						var typeinput = 'application/x-www-form-urlencoded';
						var pdata=true;
						var ctype= 'application/x-www-form-urlencoded; charset=UTF-8';
					}
					break;
			}
			
			var url ="<?php echo SITE.'mi-escaparate/functions/actualizardatos.php?action='?>"+act;
			for (var value of formData.values()) {
			   //console.log(value); 
			}
			$.ajax({
				type: "POST",
				url: url,
				data : formData,
				//dataType: "html",
				//enctype: typeinput,
				processData: pdata,  // Important!
				contentType: ctype,
				cache: false,
				success: function(info) {
					console.log(info);
					if(info==0){
						//alert(info);
					}
					if(info ==1){
						//alert(info);
					}
					if(info ==2){
						alert("La contraseña anterior no es valida.");
					}
					if(info ==3){
						alert("No se pudo actualizar la contraseña");
					}
					if(info=='passok'){
						alert('Vuelve a intregar a tu cuenta.');
						window.location.href = "<?php echo SITE.'mi-escaparate/salir'?>";
					}
					location.reload();
				},
				error: function(info) {
					alert(info);
					location.reload();
				}
			});
			return false;
		}
		//UPDATE DATOS
	</script>
</body>
</html>
