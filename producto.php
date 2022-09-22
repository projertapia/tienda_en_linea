<?php
	session_start();
	require('connect/conect_usrer.php');
	if (isset($_SERVER['HTTPS'])) {
		$http="https://";}else{
		$http="http://";
	}
	$str = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {
		  $_SESSION['page'] =$http.$str;
	}
	$datetime_now=date('Y-m-d G:i:s');
	$date_now=date('Y-m-d');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
	if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {}else{
		$user_id = $_SESSION["iduser"];
	}
	$tienda=$_GET['tienda'];
	$producto=$_GET['producto'];
	
	$back= SITEUSER;
	$sql ="SELECT id_tienda, nombre_tienda, email_contacto_tienda, nick_tienda, desc_tienda, video_tienda, fb_tienda, insta_tienda, tw_tienda, yt_tienda, tik_tienda, twitch_tienda, in_tienda, web_tienda, categoria_tienda, color_tienda, logo_tienda, cover_tienda FROM tiendas WHERE nick_tienda = '$tienda' AND activa_tienda = 1";
		$req=mysqli_query($conex, $sql);
		$row_cnt = $req->num_rows;
	if($row_cnt!=1){
		header("location:$back");
	}
		while($result = mysqli_fetch_object($req)){
			$id_tienda = $result->id_tienda;
			$email_contacto_tienda= $result->email_contacto_tienda;
			$nombre_tienda = $result->nombre_tienda;
			$nick_tienda = strtolower($result->nick_tienda);
			$desc_tienda = $result->desc_tienda;
			$video_tienda = $result->video_tienda;
			$fb_tienda = $result->fb_tienda;
			$insta_tienda = $result->insta_tienda;
			$tw_tienda = $result->tw_tienda;
			$yt_tienda = $result->yt_tienda;
			$tik_tienda = $result->tik_tienda;
			$twitch_tienda = $result->twitch_tienda;
			$in_tienda = $result->in_tienda;
			$web_tienda = $result->web_tienda;
			$categoria_tienda = $result->categoria_tienda;
			$color_tienda = $result->color_tienda;
			$logo_tienda = $result->logo_tienda;
			$cover_tienda = $result->cover_tienda;
			$nick_limpio = strtr($nick_tienda, "-", " ");
		}
		$titletienda=ucwords($nick_limpio);

	//get plan
	$SQLPlan="SELECT t.id_tienda, t.nivel_de_tienda, s.id_suscripcion, s.id_tienda_suscripcion, s.tipo_suscripcion, s.porcentaje_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, z.id_tipo_tienda FROM tiendas t, suscripcion_tiendas s, tipos_tienda z WHERE t.nivel_de_tienda = s.id_suscripcion AND z.id_tipo_tienda = s.tipo_suscripcion AND t.id_tienda = $id_tienda AND s.id_tienda_suscripcion = $id_tienda";
	$reqPlan=mysqli_query($conex, $SQLPlan);
	$myplan_rows = mysqli_num_rows($reqPlan); 
	while($resulPlan = mysqli_fetch_object($reqPlan)){		
		$checkinicio = $resulPlan->inicio_suscripcion;
		$checkfin = $resulPlan->fin_suscripcion;
		$porcentaje_suscripcion_tiendas =$resulPlan->porcentaje_suscripcion_tiendas;
	}
	$fecha_hoy=date('Y-m-d G:i:s');
	if($myplan_rows!=0){
		if(($checkinicio <= $fecha_hoy AND $checkfin >= $fecha_hoy) OR $myplan_rows != 0){	

		}else{
			$SQLPercent="SELECT id_tipo_tienda, porcentaje_tienda FROM tipos_tienda WHERE id_tipo_tienda = 1";
			$reqPercent=mysqli_query($conex, $SQLPercent);
			while($resulPercent = mysqli_fetch_object($reqPercent)){			
				$porcentaje_suscripcion_tiendas = $resulPercent->porcentaje_tienda;
			}
			$checkinicio="-";
			$checkfin ="-";
		}
	}else{
		$SQLPercent="SELECT id_tipo_tienda, porcentaje_tienda FROM tipos_tienda WHERE id_tipo_tienda = 1";
			$reqPercent=mysqli_query($conex, $SQLPercent);
			while($resulPercent = mysqli_fetch_object($reqPercent)){			
				$porcentaje_suscripcion_tiendas = $resulPercent->porcentaje_tienda;
			}
			$checkinicio="-";
			$checkfin ="-";
	}

	///PRODUCTO
	$sqlProd ="SELECT id_producto, nombre_producto, codigo_producto, id_tienda_producto, url_producto, stock_producto, precio_producto, titulo_desc_producto, txt_desc_producto,img_tallas_producto, precio_promo_producto, costo_envio_productos, img_a_producto, img_b_producto, img_c_producto, img_d_producto, img_e_producto, talla_producto, color_tallas, activo_producto, fecha_producto, tags_producto FROM productos WHERE id_tienda_producto = '$id_tienda' AND activo_producto = 1 AND url_producto = '$producto' AND stock_producto >=1 LIMIT 1";
	$reqProd=mysqli_query($conex, $sqlProd);
	$productExist = $reqProd->num_rows;
	if($productExist==0){
		header("location:$back");
	}
	while($resultProd = mysqli_fetch_object($reqProd)){
		$id_productoProd = $resultProd->id_producto;
		$nombre_productoProd = $resultProd->nombre_producto;
		$url_productoProd = $resultProd->url_producto;
		$id_tienda_productoProd = $resultProd->id_tienda_producto;
		$codigo_productoProd = $resultProd->codigo_producto;
		$stock_productoProd = $resultProd->stock_producto;
		$precio_productoProd = $resultProd->precio_producto;
		$costo_envioProd = $resultProd->costo_envio_productos;
		$titulo_desc_productoProd = $resultProd->titulo_desc_producto;
		$txt_desc_productoProd = $resultProd->txt_desc_producto;
		$precio_promo_productoProd = $resultProd->precio_promo_producto;
		$tags_producto= $resultProd->tags_producto;
		$img_a_productoProd = $resultProd->img_a_producto;
		$img_b_productoProd = $resultProd->img_b_producto;
		$img_c_productoProd = $resultProd->img_c_producto;
		$img_d_productoProd = $resultProd->img_d_producto;
		$img_e_productoProd = $resultProd->img_e_producto;
		$talla_productoProd = $resultProd->talla_producto;
		$img_tallas_productoProd = $resultProd->img_tallas_producto;
		$color_tallasProd = $resultProd->color_tallas;
		$fecha_productoProd = $resultProd->fecha_producto;
		//PRECIO PROMO FINAL
		$comision= $precio_promo_productoProd * ($porcentaje_suscripcion_tiendas/100);
		$precio_promo_productoProd_Comision = $precio_promo_productoProd + $comision;		
		$precioProd =$precio_promo_productoProd_Comision*1.16;
		
		$precioNormalProd="";
		//PRECIO NORMAL FINAL
		if($precio_promo_productoProd==""){
			$comision= $precio_productoProd * ($porcentaje_suscripcion_tiendas/100);
			$precioProd = ($comision+$precio_productoProd)*1.16;
		}else{
			$comisionNormal = $precio_productoProd * ($porcentaje_suscripcion_tiendas/100);
			$precioNormalProd= number_format(($comisionNormal+$precio_productoProd)*1.16, 2, '.', ',');
		}
		//COSTO DE ENVIO CON IVA
		if($costo_envioProd!=0 OR $costo_envioProd !="" OR $costo_envioProd!=NULL){
			$costo_envioProd= number_format($costo_envioProd*1.16, 2, '.', ',');
		}
		
		
		$formComision=$comision;
		$fechaLimite = date("Y-m-d",strtotime($date_now."- 1 week"));
		$formPrecio = number_format($precioProd, 2, '.', ',');	
		$precioProd = number_format($precioProd, 2, '.', ',');	
		$nuevo=false;
		$datetime1 = new DateTime($fecha_productoProd);
		$datetime2 = new DateTime($fechaLimite);
		$interval = $datetime1->diff($datetime2);
		$dif = $interval->format('%R%a');
		if($dif<=0){
			$nuevo=true;
		}
		if($stock_productoProd >= 1){
			$enStock ="En Stock";
		}else{
			$enStock ="Sin Stock";
		}
		$talllasarray = explode(",", $talla_productoProd);
		$colorarray = explode(",", $color_tallasProd);
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
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title><?php echo $nombre_productoProd?> - <?php echo $nombre_tienda?> | Ecommerce</title>
<?php include("parts/head.php"); ?>
<meta name="description" content="<?php echo $titulo_desc_productoProd?>">
<meta name="keywords" content="<?php echo $nombre_tienda.', '.$titletienda.','.$categoria_tienda.','.$nombre_productoProd.','. $tags_producto.','.$nombre_tienda?>">
<meta name="author" content="<?php echo $nick_tienda?>">

<meta property="og:title" content="<?php echo $nombre_productoProd.' de '.$nombre_tienda?> | Ecommerce" />
<meta property="og:description" content="<?php echo $titulo_desc_productoProd?>"/>
<meta name="article:author" content="<?php echo $nombre_tienda?> Ecommerce"/>
<meta property="og:type" content="product" />
<meta property="og:url" content="<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$producto ?>" />
<meta property="og:image" content="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda."/".$img_a_productoProd?>" />
<meta property="og:site_name" content="Ecommerce"/>
<!--TWITTER-->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" contnet="<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$producto ?>">
<meta name="twitter:title" content="<?php echo $nombre_productoProd.' de '.$nombre_tienda?> | Ecommerce">
<meta name="twitter:description" content="<?php echo $titulo_desc_productoProd?>">
<meta name="twitter:image" content="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda."/".$img_a_productoProd?>">
	

<link href="<?php echo SITEUSER?>css/jquery.fancybox.min.css" rel="stylesheet" type="text/css">
<style>
	#product-indicators li.active{border-color: #<?php echo $color_tienda?>}
	#precio-producto,.btn-desc.active,.btn-desc:hover{color: #<?php echo $color_tienda?>}
	.btn-carrito{background-color:#<?php echo $color_tienda?>}
</style>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="home-producto" style="background-image: linear-gradient(rgba(255, 255, 255, 0.0) 50%, rgba(255, 255, 255, 1) 100%), url(<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$cover_tienda?>)">
		<div class="container">
			<a href="<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda?>"><div id="logo-img-escaparate" style="background-image:url(<?php echo SITEUSER.'img/tiendas/'.$nick_tienda."/".$logo_tienda?>)"></div></a>
			<h2 id="title-escaparate">Escaparate de <a style="color:#<?php echo $color_tienda?>" href="<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda?>"><?php echo $nombre_tienda?></a></h2>
		</div>
	</section>
	<section id="articulos-escaparate">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-2" id="col-l-ads">
					<div id="pcads">
						<div class="row" id="adssq">
							<?php list($id_a,$img_sq_a,$link_sq_a,$tipopubli,$host_server,$id_b,$img_sq_b,$link_sq_b,$id_c,$img_sq_c,$link_sq_c,$id_d,$img_sq_d,$link_sq_d) = ads("sq","$tiendaads","$tipopubli",$id);?>
		<a href="<?php echo $link_sq_a?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_a,$host_server)?>" onclick="adsclick(<?php echo $id_a?>','sq1')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_a?>" class="img-fluid" alt=""></a>
		
		<a href="<?php echo $link_sq_b?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_b,$host_server)?>" onclick="adsclick(<?php echo $id_b?>','sq2')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_b?>" class="img-fluid" alt=""></a>
		
		<a href="<?php echo $link_sq_c?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_c,$host_server)?>" onclick="adsclick(<?php echo $id_c?>','sq3')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_c?>" class="img-fluid" alt=""></a>
		
		<a href="<?php echo $link_sq_d?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_d,$host_server)?>" onclick="adsclick(<?php echo $id_d?>','sq4')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_d?>" class="img-fluid" alt=""></a>
						</div>
					</div>				
				</div>
				<div class="col-md-12 col-lg-8">
					<article>
						<div class="row">
							<div class="col-sm-12 col-md-4">
								<ul class="row" id="product-indicators">
									<li data-target="#carouselProduct" class="col-md-12 col-3 active">
										<img src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_a_productoProd?>" class="img-fluid" alt="<?php echo $nombre_productoProd?>">
									</li>
									<?php if($img_b_productoProd !=""){?>
									<li data-target="#carouselProduct" class="col-md-12 col-3">
										<img src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_b_productoProd?>" class="img-fluid" alt="<?php echo $nombre_productoProd?>">
									</li>
									<?php }?>
									<?php if($img_c_productoProd !=""){?>
									<li data-target="#carouselProduct" class="col-md-12 col-3">
										<img src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_c_productoProd?>" class="img-fluid" alt="<?php echo $nombre_productoProd?>">
									</li>
									<?php }?>
									<?php if($img_d_productoProd !=""){?>
									<li data-target="#carouselProduct" class="col-md-12 col-3">
										<img src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_d_productoProd?>" class="img-fluid" alt="<?php echo $nombre_productoProd?>">
									</li>
									<?php }?>
								</ul>
							</div>
							<div id="carouselProduct" class="carousel slide col-sm-12 col-md-8" data-ride="carousel" data-interval="false">
							<?php if($nuevo == true){?>
								<div class="nuevo-producto-tag">NUEVO</div>
							<?php } ?>
							  <div class="carousel-inner">
								<div class="carousel-item active">
									<a class="galeria" data-fancybox="<?php echo $nombre_productoProd?>" href="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_a_productoProd?>">
								  <img class="d-block w-100" src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_a_productoProd?>" alt="<?php echo $nombre_productoProd?>">
									</a>
								</div>
								<?php if($img_b_productoProd !=""){?>
								<div class="carousel-item">
								<a class="galeria" data-fancybox="<?php echo $nombre_productoProd?>" href="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_b_productoProd?>">
								  <img class="d-block w-100" src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_b_productoProd?>" alt="<?php echo $nombre_productoProd?>">
									</a>
								</div>
								 <?php }?>
								  <?php if($img_c_productoProd !=""){?>
								<div class="carousel-item">
								<a class="galeria" data-fancybox="<?php echo $nombre_productoProd?>" href="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_c_productoProd?>">
								  <img class="d-block w-100" src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_c_productoProd?>" alt="<?php echo $nombre_productoProd?>">
									</a>
								</div>
								  <?php }?>
								  <?php if($img_d_productoProd !=""){?>
								<div class="carousel-item">
								<a class="galeria" data-fancybox="<?php echo $nombre_productoProd?>" href="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_d_productoProd?>">
								  <img class="d-block w-100" src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_d_productoProd?>" alt="<?php echo $nombre_productoProd?>">
									</a>
								</div>
								   <?php }?>
							  </div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-lg-6 col-md-12">
								<h1 id="nombre-producto"><?php echo $nombre_productoProd?></h1>
								<p id="codigo-producto">Código de producto: <span><?php echo $codigo_productoProd?></span></p>
								<p id="disponible-producto">Disponibilidad: <span><?php echo $enStock?></span></p>
								<h3 id="precio-producto">$<?php echo $precioProd?> <span><?php echo $precioNormalProd?></span> <small style="font-size: 11px">*IVA incluido</small></h3>
							</div>
							<div class="col-lg-6 col-md-12">
								<form method="get" id="addcarrito" action="<?php echo SITEUSER?>carrito">
									<div class="row">
									<div class="col-sm-6 col-md-4 col-lg-6 col-xl-5">
										<input type="hidden" name="addprodcut" value="<?php echo $id_productoProd?>" id="idproducto">
										<input type="hidden" name="addenvio" value="<?php echo $costo_envioProd?>" id="addenvio">
										<input type="hidden" name="addvendor" value="<?php echo $id_tienda_productoProd?>" id="addvendor">
										<input type="hidden" name="addprecio" value="<?php echo str_replace (',', '',$formPrecio);?>" id="addprecio">
										<input type="hidden" name="addcomision" value="<?php echo $formComision?>" id="addcomision">
										<input type="number" value="1" min="1" max="10" step="1" name="cantidadproducto" id="cantidadproducto"/>
										<select name="addcolor" class="form-control" id="addcolor">
											<?php 
												foreach ($colorarray as &$Cvalor) {
													?>
												<option value="<?php echo $Cvalor?>"><?php echo $Cvalor?></option>
											<?php 
												}
											?>
										</select>										
									</div>
									<div class="col-sm-6 col-md-8 col-lg-6 col-xl-7">
										<select name="addtalla" class="form-control" id="addtalla">
											<?php 
												foreach ($talllasarray as &$valor) {
													?>
												<option value="<?php echo $valor?>"><?php echo $valor?></option>
											<?php 
												}
											?>
										</select>
										<input type="hidden" name="key" value="<?php echo rand_char(16)?>">
										<button type="submit" class="btn btn-carrito">Añadir al carrito</button>
									</div>
									</div>
								</form>
								<hr>
								<ul id="list-actions-product">
									<?php if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {}else{
									$SQLFav="SELECT id_producto_favorito, id_cliente_favorito FROM favoritos WHERE id_producto_favorito = $id_productoProd AND id_cliente_favorito = $user_id";
									$reqFav=mysqli_query($conex, $SQLFav);
									$cntFav = $reqFav->num_rows;
									if($cntFav==0){	
									?>									
									<li><a href="#" target="_blank" class="likes" onClick="addfav(<?php echo $id_productoProd?>,1)"><i class="fas fa-heart"></i> <span>Añadir a lista de deseos</span></a></li>
									<?php }else{
									?>
									<li><a href="#" target="_blank" class="likes" onClick="addfav(<?php echo $id_productoProd?>,0)" id="likes"><i class="fas fa-heart"></i> <span>Quitar de la lista de deseos</span></a></li>
									<?php
									} };
									if($img_e_productoProd!=""){
									?>
									<li><a href="#" target="" class="actions-link-desc"><i class="fas fa-tshirt"></i> Tallas / Variantes</a></li>
									<?php }?>
									<li><a href="mailto:<?php echo $email_contacto_tienda?>?subject=Hola%2C%20tengo%20una%20duda%20sobre%20tu%20producto%20<?php echo $nombre_productoProd?>&body=Hola%20<?php echo $tienda?>%2C%20tengo%20una%20duda%20relacionada%20a%20tu%20producto%20<?php echo $nombre_productoProd?>%20publicado%20en%20El%20Pa%C3%ADs%20de%20las%20Compras." target="_blank"><i class="fas fa-envelope"></i> Preguntar por este producto</a></li>
								</ul>
								<ul id="list-share">
									<span>Compartir en:</span>
									<li><a href="#" target="_blank" title="Facebook" onclick="shareFB('<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$url_productoProd?>')"><i class="fab fa-facebook-f"></i></a></li>
									<li><a href="#" target="_blank" title="Twitter" onclick="shareTW('<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$url_productoProd?>')"><i class="fab fa-twitter"></i></a></li>
									<li><a href="#" arget="_blank" title="WP" onclick="shareWA('<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$url_productoProd?>')"><i class="fab fa-whatsapp"></i></a></li>
									<li><a href="mailto:?subject=Mira%20este%20producto%20de%20El%20Pa%C3%ADs%20de%20las%20Compras&body=<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$url_productoProd?>" target="_blank" title="Email"><i class="fas fa-envelope"></i></a></li>
								</ul>
							</div>
						</div>
					</article>
				</div>
				<div class="col-md-12 col-lg-2" id="col-r-ads">
					<div id="mobileads">
					</div>
					<div class="row">
						<?php list($id_rq_a,$img_rq_a,$link_rq_a,$tipopubli_rq,$host_server,$id_rq_b,$img_rq_b,$link_rq_b) = ads("rq","$tiendaads","$tipopubli",$id);?>
		<a href="<?php echo $link_rq_a?>" class="box-promo-shop col-lg-12 col-md-6 col-sm-6 col-12" target="<?php echo checklinkads($link_rq_a,$host_server)?>" onclick="adsclick(<?php echo $id_rq_a?>','rq1')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_rq_a?>" class="img-fluid" alt=""></a>
		<?php ads("rq","$tiendaads","$tipopubli",$id);?>
		<a href="<?php echo $link_rq_b?>" class="box-promo-shop col-lg-12 col-md-6 col-sm-6 col-12" target="<?php echo checklinkads($link_rq_b,$host_server)?>" onclick="adsclick(<?php echo $id_rq_b?>','rq1')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_rq_b?>" class="img-fluid" alt=""></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="alert alert-secondary alert-dismissible fade" role="alert">
		<strong id="titlealert"></strong> <span id="txtalert"></span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<section>
		<div id="nav-desc">
			<a href="#" class="btn-desc btn-link-desc active">Descripción</a>
			<?php if($img_e_productoProd != ""){?>
			<a href="" class="btn-desc btn-link-desc" id="carta">Tallas / Variantes</a>
			<?php } ?>
		</div>
		<div id="graybox">
			<div class="container">
				<div id="slider-desc" class="carousel slide" data-ride="carousel"  data-interval="false">
				  <div class="carousel-inner">
					<div class="carousel-item active">
						<div class="row">
							<div class="col-md-5 col-sm-12 offset-md-1 offset-sm-0">
								<img class="d-block w-100 my-3" src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_e_productoProd?>" alt="">
							</div>
							<div class="col-md-5 col-sm-12">
								<div class="d-flex h-100 my-3">
									<div class="justify-content-center align-self-center">
										<h3 class="title-desc"><?php echo $titulo_desc_productoProd?></h3>
										<p class="text-desc"><?php echo $txt_desc_productoProd?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					 <?php if($talla_productoProd != ""){?>
					<div class="carousel-item">
					  <img class="d-block w-100" src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda.'/'.$img_tallas_productoProd?>" alt="Guia de tallas">
					</div>
					 <?php }?>
				  </div>
				</div>
			</div>
		</div>
	</section>
	<section id="mobi-ads" class="container" style="margin-top: 15px;">
		<div id="sq"></div>
		<div id="rq"></div>
	</section>
	<section id="productos-relacionados">
		<div class="container">
			<h5 id="title-productos-relacionados">MÁS PRODUCTOS DE <?php echo strtoupper($nombre_tienda)?></h5>
			<div id="carouselRelacioandos" class="carousel slide" data-ride="carousel" data-interval="false">
				<div class="carousel-inner">
					<?php
					$countSlides =0;
					$countProducts=0;
					$activeclass ="";
					$countershowproducts=0;
					$sqlRel ="SELECT id_producto, nombre_producto, url_producto, stock_producto, precio_producto, precio_promo_producto, img_a_producto, activo_producto, fecha_producto, costo_envio_productos FROM productos WHERE id_tienda_producto = '$id_tienda' AND activo_producto = 1 AND stock_producto >= 1 ORDER BY fecha_producto DESC";
					$reqRel=mysqli_query($conex, $sqlRel);
					$totalcount = $reqRel->num_rows;
					
					while($resultRel = mysqli_fetch_object($reqRel)){
						$id_productoRel = $resultRel->id_producto;
						$nombre_productoRel = $resultRel->nombre_producto;
						$url_productoRel = $resultRel->url_producto;
						$stock_productoRel = $resultRel->stock_producto;
						$precio_productoRel = $resultRel->precio_producto;
						$precio_promo_productoRel = $resultRel->precio_promo_producto;
						$img_a_productoRel = $resultRel->img_a_producto;
						$precioRel =$precio_promo_productoRel;
						$costo_envioRel = $resultRel->costo_envio_productos;
						
						if($precio_promo_productoRel==""){
							$precioRel = $precio_productoRel;
						}
						$precioRel = $precioRel;
						//PRECIO PROMO FINAL
						$comisionRel= $precioRel * ($porcentaje_suscripcion_tiendas/100);
						$precio_promo_productoRel_Comision = $precio_promo_productoRel + $comision;		
						$precioRel =$precio_promo_productoRel_Comision*1.16;

						$precioNormalRel="";
						//PRECIO NORMAL FINAL
						if($precio_promo_productoRel==""){
							$comision= $precio_productoRel * ($porcentaje_suscripcion_tiendas/100);
							$precioRel = ($comision+$precio_productoRel)*1.16;
						}else{
							$comisionNormal = $precio_productoRel * ($porcentaje_suscripcion_tiendas/100);
						}
						//COSTO DE ENVIO CON IVA
						if($costo_envioRel!=0 OR $costo_envioRel !="" OR $costo_envioRel!=NULL){
							$costo_envioRel= number_format($costo_envioRel*1.16, 2, '.', ',');
						}
						if($countSlides==0 AND $countProducts==0){
							$activeclass="active";
							?>
							<div class="carousel-item <?php echo $activeclass?>">
							<div class="row">
						<?php
						}else if($countProducts==0){
							echo '<div class="carousel-item"><div class="row">';
						}
						$activeclass="";
						$precioRel =number_format( $precioRel, 2, '.', ',');
						if($countProducts<4){
						?>
							<div class="col-sm-6 col-md-6 col-lg-3">
								<a href="<?php echo SITEUSER.$categoria_tienda.'/'.$tienda.'/'.$url_productoRel?>" class="link-product">
								<img src="<?php echo SITEUSER?>img/tiendas/<?php echo $tienda?>/<?php echo $img_a_productoRel?>" class="img-fluid d-block w-100" alt="<?php echo $nombre_productoRel?>">
								<h6 class="title-product-relacionados"><?php echo $nombre_productoRel?></h6>
								<p class="price-product-relacionados">$<?php echo number_format($precioRel, 2, '.', ',');?><small> .mxn</small></p>
								</a>
							</div>	
						<?php
							$countProducts++;
							$countershowproducts++;
						}
						if($countProducts==4){
							echo "</div></div>";
							$countSlides++;
							$countProducts=0;
							//echo "hola ==4";
						}
						?>
						<?php
						if($countershowproducts == $totalcount AND $countProducts!=4 AND $countProducts!=0){
							echo "</div></div>";
							//echo "hola !=4";
						}
						
					}
					?>
								
				
				<?php if($totalcount >=4){?>
				<?php }?>
			</div>
				<a class="carousel-control-prev" href="#carouselRelacioandos" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Anterior</span>
				</a>
				<a class="carousel-control-next" href="#carouselRelacioandos" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Siguiente</span>
				</a>
			</div>
		</div>
	</section>
	<?php include("parts/boletin.php");?>
	<?php include("parts/footer.php"); ?>
	<script src="<?php echo SITEUSER?>js/bootstrap-input-spinner.js"></script>
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
	<script src="<?php echo SITEUSER?>js/jquery.fancybox.min.js"></script>
	<script>
		$('.galeria').fancybox({
			// Options will go here
		});
		/*NAV BAR FOTOS*/
		$('#product-indicators').on('click', 'li', function(event) {
			event.preventDefault();
			$('#product-indicators li').removeClass("active");
			$(this).addClass("active");
			// `this` is the clicked <a> tag
			// `$.index()` returns the position of `this` relative to its sibling elements
			var target = $(this).index();
			$('#carouselProduct').carousel(target);
		});
		$('.btn-link-desc').on('click', function(event) {
			event.preventDefault();
			$('.btn-link-desc').removeClass("active");
			$(this).addClass("active");
			var target = $(this).index();
			$('#slider-desc').carousel(target);
		});		
		$('.actions-link-desc').on('click', function(event) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: $("#nav-desc").offset().top
			}, 800);
			$('.btn-link-desc').removeClass("active");
			$('#carta').addClass("active");
			$('#slider-desc').carousel(1);
		});	
		
		$("input[type='number']").inputSpinner()
		
		function addfav(idprod,act){
			event.preventDefault();
			console.log(idprod);
			$.ajax({
				url: "<?php echo $urlserver.'functions/masfav.php?idproducto='?>"+idprod+'&act='+act,
				success: function(info) {
					if(info == 1){
						$( ".likes span" ).html( "Quitar de la lista de deseos" );
						$(".likes").attr("onclick", "addfav("+idprod+",0)");
						$( "#titlealert" ).html( "Éxito" );
						$( "#txtalert" ).html( "El producto ha sido agregado a favoritos" );
						$('.alert').alert();
						setTimeout(function(){
							$('.alert').alert('likes');
						}, 3000);
						$('.likes').attr('id', 'likes');
					}
					if(info == 2){
						$( "#titlealert" ).html( "Error" );
						$( "#txtalert" ).html( "El producto no a sido agregado a favoritos" );
						$('.alert').alert();
						setTimeout(function(){
							$('.alert').alert('close');
						}, 5000);
					}
					if(info == 4){
						$( ".likes span" ).html( "Añadir a lista de deseos" );
						$(".likes").attr("onclick","addfav("+idprod+",1)");
						$( "#titlealert" ).html( "Éxito" );
						$( "#txtalert" ).html( "Se ha eliminado de tus favoritos" );
						$('.alert').alert();
						setTimeout(function(){
							$('.alert').alert('close');
						}, 5000);
						$('.likes').removeAttr('id');
					}
					if(info == 5){
						$( "#titlealert" ).html( "Error" );
						$( "#txtalert" ).html( "No se ha eliminado de tus favoritos" );
						$('.alert').alert();
						setTimeout(function(){
							$().alert('close');
						}, 5000);
					}
					if(info == 3 || info == 6){
						$( "#titlealert" ).html( "Error" );
						$( "#txtalert" ).html( "La acción no fue realizado" );
						$('.alert').alert();
						setTimeout(function(){
							$().alert('close');
						}, 5000);
					}
					
				},
				error: function() {
					$( "#titlealert" ).html( "Error" );
					$( "#txtalert" ).html( "La acción no fue realizado" );
					$('.alert').alert();
					setTimeout(function(){
						$().alert('close');
					}, 5000);
				}
			});
		}
	//SHARE FB
	function shareFB(url){
		event.preventDefault();
	 window.open(
      'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url), 
      'facebook-share-dialog', 
      'width=626,height=436'); 
	}
	//SHARE tw
	function shareTW(url){
		event.preventDefault();
	 window.open(
      'https://twitter.com/intent/tweet?text=Este producto me encanta. '+url+'&url'+url+'&via=ecommerce&in-reply-to=1283957255533203457',
      'twitter-share-dialog', 
      'width=626,height=436'); 
	}
	//SHARE WA
	function shareWA(url){
		event.preventDefault();
		window.open(
		'https://wa.me/?text=Este producto de Ecommerce me encanta. '+encodeURIComponent(url)
		);
	}
	//SHARE WA
	$( document ).ready(function() {
		var w = $(window).width();
		if(w<=991){
			//console.log(w);
			if($("#pcads").children().length !=0){
				elementos = $("#adssq");
				elementos.appendTo('#mobi-ads #sq');				
			}
			if($("#col-r-ads .row").children().length !=0){
				elementos = $("#col-r-ads .row");
				elementos.appendTo('#mobi-ads #rq');				
			}
		}
	});
	$(window).resize(function() {
		  var w = $(window).width();
			if(w<=991){
				//console.log(w);
				if($("#pcads").children().length !=0){
					elementos = $("#adssq");
					elementos.appendTo('#mobi-ads #sq');					
				}
				if($("#col-r-ads .row").children().length !=0){
					elementos = $("#col-r-ads .row");
					elementos.appendTo('#mobi-ads #rq');				
				}
			}else{
				if($("#mobi-ads #sq").children().length !=0){
					elementos = $("#adssq");
					elementos.appendTo('#pcads');
				}
				if($("#mobi-ads #rq").children().length !=0){
					elementos = $("#mobi-ads #rq .row");
					elementos.appendTo('#col-r-ads');				
				}
				
			}
			
		});
	</script>
</body>
</html>