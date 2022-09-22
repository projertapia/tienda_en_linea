<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
	$tienda = $_GET['cat'];
	$datetime_now=date('Y-m-d G:i:s');
	$date_now=date('Y-m-d');
	//GET MAX
	$sqlStore="SELECT id_tienda, nick_tienda, activa_tienda, categoria_tienda, nivel_de_tienda, categorias_tienda FROM tiendas WHERE nick_tienda = '$tienda' AND activa_tienda = 1";
	$reqStore=mysqli_query($conex, $sqlStore);
	while($resultStore = mysqli_fetch_object($reqStore)){
		$id_tienda = $resultStore->id_tienda;
		$nivel_de_tienda = $resultStore->nivel_de_tienda;
		$section = $resultStore->categoria_tienda;
		$categorias_tienda = $resultStore->categorias_tienda;
	}
	$categorias_tienda = trim($categorias_tienda, ',');
	$sqlLimit="SELECT s.id_suscripcion, s.id_tienda_suscripcion, s.tipo_suscripcion, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion
	FROM suscripcion_tiendas s WHERE s.id_tienda_suscripcion = $id_tienda AND s.id_suscripcion = $nivel_de_tienda";
	$reqLimit=mysqli_query($conex, $sqlLimit);
	$LimitPlan_rows = mysqli_num_rows($reqLimit);	
	if($LimitPlan_rows==0){
		$checkinicio="0000 00 00 00:00:00";
		$checkfin="0000 00 00 00:00:00";
	}else{
		while($resultLimit = mysqli_fetch_object($reqLimit)){
			$cantidad_show = $resultLimit->cantidad_suscripcion_tiendas;
			$checkinicio = $resultLimit->inicio_suscripcion;
			$checkfin = $resultLimit->fin_suscripcion;
		}
	}
	$fecha_hoy=date('Y-m-d G:i:s');
	if(($checkinicio <= $fecha_hoy AND $checkfin >= $fecha_hoy) AND $LimitPlan_rows != 0){	
	}else{
		$SQLPercent="SELECT id_tipo_tienda, cantidad_tipo_tienda FROM tipos_tienda WHERE id_tipo_tienda = 1";
		$reqPercent=mysqli_query($conex, $SQLPercent);
		while($resulPercent = mysqli_fetch_object($reqPercent)){			
			$cantidad_show = $resulPercent->cantidad_tipo_tienda;
		}		
	}
	
	//GET DATA
	$sql ="SELECT id_tienda, nombre_tienda, nick_tienda, desc_tienda, video_tienda, fb_tienda, insta_tienda, tw_tienda, yt_tienda, tik_tienda, twitch_tienda, in_tienda, web_tienda, wapp_tienda, maps_tienda, categoria_tienda, color_tienda, logo_tienda, cover_tienda FROM tiendas WHERE nick_tienda = '$tienda' AND activa_tienda = 1";
		$req=mysqli_query($conex, $sql);
		$row_cnt = $req->num_rows;
	if($row_cnt!=1){
		//header("location:$back");
	}
		while($result = mysqli_fetch_object($req)){
			$id_tienda = $result->id_tienda;
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
			$wapp_tienda = $result->wapp_tienda;
			$maps_tienda = $result->maps_tienda;
			$nick_limpio = strtr($nick_tienda, "-", " ");
			$nick_limpio = strtr($nick_limpio, ".", " ");
			$nick_limpio = strtr($nick_limpio, "_", " ");
		}
		$titletienda=ucwords($nick_limpio);

$sqlList ="SELECT id_producto, nombre_producto, url_producto, stock_producto, precio_producto, precio_promo_producto, costo_envio_productos, img_a_producto, activo_producto, fecha_producto FROM productos WHERE id_tienda_producto = '$id_tienda' AND activo_producto = 1 AND stock_producto >= 1 ORDER BY fecha_producto DESC LIMIT $cantidad_show";
$reqList=mysqli_query($conex, $sqlList);
$List_cnt = $reqList->num_rows;

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


?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Escaparate de <?php echo $nombre_tienda ?> | Ecommerce</title>
<?php include("parts/head.php"); ?>
<meta name="description" content="<?php echo $desc_tienda?>">
<meta name="keywords" content="<?php echo $nombre_tienda.', '.$nick_limpio.','.$categoria_tienda ?>">
<meta name="author" content="<?php echo $nick_tienda?>">

<meta property="og:title" content="Escaparate <?php echo $nombre_tienda?> | Ecommerce" />
<meta property="og:description" content="<?php echo $desc_tienda?>"/>
<meta name="article:author" content="Ecommerce"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda ?>" />
<meta property="og:image" content="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda."/".$logo_tienda?>" />
<meta property="og:site_name" content="Ecommerce"/>
<!--TWITTER-->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" contnet="<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda ?>">
<meta name="twitter:title" content="Escaparate <?php echo $nombre_tienda?> | Ecommerce">
<meta name="twitter:description" content="<?php echo $desc_tienda?>">
<meta name="twitter:image" content="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda."/".$logo_tienda?>">
<link href="<?php echo SITEUSER?>css/jquery.fancybox.min.css" rel="stylesheet" type="text/css">
	<style>
		#pop-home-escaparate{position: absolute; width: 100%; height: auto;top: 0; z-index: 0}
		#pop-home-escaparate img{position: relative}
	</style>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="home-escaparate" style="background-image: linear-gradient(rgba(255, 255, 255, 0.0) 75%, rgba(255, 255, 255, 1) 100%), url(<?php echo $urlserver?>img/tiendas/<?php echo $nick_tienda."/".$cover_tienda?>)">
		<a href="<?php echo $urlserver?>img/tiendas/<?php echo $nick_tienda."/".$cover_tienda?>" id="pop-home-escaparate" data-fancybox="<?php echo $nick_tienda?>" title="Ver Portada de <?php echo $nick_tienda?>">
			
		</a>
		<div class="container">
			<div class="row">
				<div class="col-10 col-sm-8 col-md-7 col-lg-6 col-xl-5" id="info-escaparate">
					<?php if($video_tienda ==""){
					?>
					<img src="<?php echo $urlserver?>img/tiendas/<?php echo $nick_tienda."/".$logo_tienda?>" alt="<?php echo $nick_tienda?>" class="img-fluid">
					<?php
					}else{ ?>
					<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_tienda?>?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<?php }?>
					<div id="text-escaparate" style="background-color: #<?php echo $color_tienda ?>">
						<h1><?php echo ucwords($nombre_tienda)?></h1>
						<small id="small-title"><?php echo ucwords($nick_limpio);?></small>
						<?php echo $desc_tienda?>
					</div>
					<div id="socialmedia-escaparate">
						<?php if($fb_tienda!=""){?>
						<a href="<?php echo $fb_tienda?>" class="facebook" target="_blank" title="<?php echo $fb_tienda?>"><i class="fab fa-facebook-f"></i></a>
						<?php } ?>
						<?php if($insta_tienda!=""){?>
						<a href="<?php echo $insta_tienda?>" class="instagram" target="_blank" title="<?php echo $insta_tienda?>"><i class="fab fa-instagram"></i></a>
						<?php } ?>
						<?php if($tw_tienda!=""){?>
						<a href="<?php echo $tw_tienda?>" class="twitter" target="_blank" title="<?php echo $tw_tienda?>"><i class="fab fa-twitter"></i></a>
						<?php } ?>
						<?php if($yt_tienda!=""){?>
						<a href="<?php echo $yt_tienda?>" class="youtube" target="_blank" title="<?php echo $yt_tienda?>"><i class="fab fa-youtube"></i></a>
						<?php } ?>
						<?php if($tik_tienda!=""){?>
						<a href="<?php echo $tik_tienda?>" class="tiktok" target="_blank" title="<?php echo $tik_tienda?>"><i class="fab fa-tiktok" ></i></a>
						<?php } ?>
						<?php if($twitch_tienda!=""){?>
						<a href="<?php echo $twitch_tienda?>" class="twitch" target="_blank" title="<?php echo $twitch_tienda?>"><i class="fab fa-twitch"></i></a>
						<?php } ?>
						<?php if($in_tienda!=""){?>
						<a href="<?php echo $in_tienda?>" class="linkedin" target="_blank" title="<?php echo $in_tienda?>"><i class="fab fa-linkedin"></i></a>
						<?php } ?>
						<?php if($web_tienda!=""){?>
						<a href="<?php echo $web_tienda?>" class="link" target="_blank" title="<?php echo $web_tienda?>"><i class="fas fa-link"></i></a>
						<?php } ?>
						<?php if($wapp_tienda!=""){?>
						<a href="https://api.whatsapp.com/send?phone=<?php echo $wapp_tienda?>&text=Hola" class="wapp" target="_blank" title="<?php echo $wapp_tienda?>"><i class="fab fa-whatsapp"></i></a>
						<?php } ?>
						<?php if($maps_tienda!=""){?>
						<a href="<?php echo $maps_tienda?>" class="maps" target="_blank" title="<?php echo $maps_tienda?>"><i class="fas fa-map-marked-alt"></i></a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="articulos-escaparate">
		<div class="container">
			<?php if($List_cnt>0){?>
			<h2 id="title-escaparate">PRODUCTOS DE <span style="color: #<?php echo $color_tienda?>"><?php echo $nombre_tienda?></span></h2>
			<?php }else{ ?>
			<!--<h4 id="title-escaparate">Lo sentimos <?php //echo $nombre_tienda?> no tiene productos disponibles.</h4>-->
			<?php } ?>
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
					<!--RECIENTES-->
					<?php
						$sqlRel ="SELECT id_producto, nombre_producto, url_producto, stock_producto, precio_producto, precio_promo_producto, img_a_producto, activo_producto, fecha_producto, costo_envio_productos FROM productos WHERE id_tienda_producto = '$id_tienda' AND activo_producto = 1 AND stock_producto >= 1 ORDER BY fecha_producto DESC LIMIT 3";
						$reqRel=mysqli_query($conex, $sqlRel);
						$Rel_cnt = $reqRel->num_rows;
					if($Rel_cnt !=0){
					?>
					
					<div id="productos-recientes-box">
						<h4 class="title-recientes">Productos recientes</h4>
						<div class="rel-prod-list">
						<?php
							
							while($resultRel = mysqli_fetch_object($reqRel)){
								$id_productoRel = $resultRel->id_producto;
								$nombre_productoRel = $resultRel->nombre_producto;
								$url_productoRel = $resultRel->url_producto;
								$stock_productoRel = $resultRel->stock_producto;
								$precio_productoRel = $resultRel->precio_producto;
								$precio_promo_productoRel = $resultRel->precio_promo_producto;
								$costo_envio_productosRel = $resultRel->costo_envio_productos;
								$img_a_productoRel = $resultRel->img_a_producto;
								$precioRel =$precio_promo_productoRel;
								if($precio_promo_productoRel==""){
									$precioRel = $precio_productoRel;
								}
								if($costo_envio_productosRel=="" OR $costo_envio_productosRel== NULL){
									$costo_envio_productosRel = 0;
								}
								$comisionRel = $precioRel * ($porcentaje_suscripcion_tiendas / 100);
								$precioRel = number_format(($precioRel+$comisionRel)*1.16, 2, '.', ',');
								
						?>
						<a class="list-producto-reciente" href="<?php echo $urlserver.$section.'/'.$tienda.'/'.$url_productoRel?>">
							<img src="<?php echo $urlserver?>img/tiendas/<?php  echo $tienda.'/'.$img_a_productoRel ?>" class="img-fluid img-reciente" alt="">
							<h5 class="title-reciente-articulo"><?php echo $nombre_productoRel?></h5>
							<p class="price-reciente-articulo">$<?php echo $precioRel?></p>
							<div class="clearfix"></div>
						</a>
						<?php }
						?>
						</div>
					</div>
				<?php } ?>
				</div>
				<div class="col-md-12 col-lg-8">
					<article>
						<div class="row">
							<div id="promos-user" style="width: 100%">
								<?php
									$hoypromo = date("Y-m-d H:i:s"); 
									$sqlpromosq ="SELECT p.id_promocion, p.tienda_rel_promocion, p.fecha_inicio_promocion, p.fecha_fin_promocion, p.img_promocion, p.url_promocion, p.tipo_promocion, p.activo_promocion FROM promociones p WHERE p.activo_promocion = 1 AND ((p.fecha_inicio_promocion <= '$hoypromo') AND (p.fecha_fin_promocion >= '$hoypromo')) AND p.tienda_rel_promocion = $id_tienda ORDER BY p.tipo_promocion, p.id_promocion DESC";
									$reqpromosq=mysqli_query($conex, $sqlpromosq);
									$Mispromosq = $reqpromosq->num_rows;
									if($Mispromosq!=0){ ?>
									<section id="promos-box">
										<div class="container">
											<h2 class="title-section">Promociones</h2>			
											<div class="row" id="top-promo">
												<?php
													while($resultpromosq = mysqli_fetch_object($reqpromosq)){
														$id_promocion = $resultpromosq->id_promocion;
														$tienda_rel_promocion = $resultpromosq->tienda_rel_promocion;
														$img_promocion = $resultpromosq->img_promocion;
														$url_promocion = $resultpromosq->url_promocion;
														$tipo_promocion = $resultpromosq->tipo_promocion;
														if($tipo_promocion=="rq"){
															$class="col-6 my-2";

														}else{
															$class="col-4 my-2";
														}
												?>
												<a href="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda.'/'.$img_promocion?>" title="" class="<?php echo $class?> promo-link" data-fancybox="promocion-<?php echo $id_promocion?>" title-id="promocion-<?php echo $id_promocion?>" data-caption="<a href='<?php echo $url_promocion?>' target='_blank' onClick='promo(<?php echo $id_promocion?>)'>Ver más</a>">
													<img src="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda.'/'.$img_promocion?>" alt="" class="img-fluid promos">
												</a>
												<?php } ?>
											</div>
										</div>
									</section>
									<?php
									}
									if($List_cnt==0 AND $Mispromosq==0){
									?>
									<h4 id="title-escaparate">Lo sentimos <?php echo $nombre_tienda?> no tiene productos disponibles.</h4>
									<?php
									}
									?>
							</div>
							<?php
							while($resultList = mysqli_fetch_object($reqList)){
								$id_productoList = $resultList->id_producto;
								$nombre_productoList = $resultList->nombre_producto;
								$url_productoList = $resultList->url_producto;
								$stock_productoList = $resultList->stock_producto;
								$precio_productoList = $resultList->precio_producto;
								$precio_promo_productoList = $resultList->precio_promo_producto;
								$costo_envio_productosList = $resultList->costo_envio_productos;
								$img_a_productoList = $resultList->img_a_producto;
								$fecha_productoList = $resultList->fecha_producto;
								$precioList =$precio_promo_productoList;
								if($precio_promo_productoList==""){
									$precioList = $precio_productoList;
								}
								if($costo_envio_productosList=="" OR $costo_envio_productosList== NULL){$costo_envio_productosList = 0;}
								$comisionList = $precioList * ($porcentaje_suscripcion_tiendas / 100);
								$precioList = number_format(($precioList+$comisionList)*1.16, 2, '.', ',');
								
								$fechaLimite = date("Y-m-d",strtotime($date_now."- 1 week"));
								$nuevo=false;
								$datetime1 = new DateTime($fecha_productoList);
								$datetime2 = new DateTime($fechaLimite);
								$interval = $datetime1->diff($datetime2);
								$dif = $interval->format('%R%a');
								if($dif<=0){
									$nuevo=true;
								}
								
								
								
							?>
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 articulo-box">
								<a href="<?php echo $urlserver.$section.'/'.$tienda.'/'.$url_productoList?>" title="<?php echo $nombre_productoList?>">
									<?php if($precio_promo_productoList!="" AND $nuevo == false){?>
									<p class="text-rebaja-grill">Rebaja</p>
									<?php } ?>
									<?php if($nuevo == true){?>
									<p class="text-nuevo-grill">Nuevo</p>
									<?php } ?>
									<img src="<?php echo $urlserver?>img/tiendas/<?php echo $tienda .'/'. $img_a_productoList?>" class="img-fluid img-articulo-grill" alt="">
									<div class="box-text-articulo">
										<h3 class="title-articulo-grill"><?php echo $nombre_productoList?></h3>
										<p class="price-grill">$<?php echo $precioList?></p>
									</div>
								</a>
							</div>
							<?php } ?>
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
	<section id="ads-footer">
		<div class="container">
			<a href="<?php echo $url_ft?>" title="" target="<?php echo $target_ft?>" id="footer_ads"><img src="<?php echo SITEUSER.'img/'.$img_ft?>" alt="" class="img-fluid"></a>
		</div>
	</section>
	<?php include("parts/boletin.php");?>
	<?php include("parts/footer.php"); ?>
	<script src="<?php echo SITEUSER?>js/jquery.fancybox.min.js"></script>
	<script>
		/*$('#home-escaparate').click(function() {
			$("#pop-home-escaparate").fancybox().trigger('click');
		});*/
		$(document).ready(function(){
			var homebanner = document.getElementById('home-escaparate').clientHeight;
			document.getElementById("pop-home-escaparate").style.height = homebanner+"px";
		});
		$('#pop-home-escaparate').fancybox({
			// Options will go here
		});
		
		//$(".promo-link").attr('rel', 'gallery').fancybox({
		$('.promo-link').fancybox({
		/*	 beforeLoad: function() {
            var el, id = $(this.element).data('title-id');

            if (id) {
                el = $('#' + id);
            
                if (el.length) {
                    this.title = el.html();
                }
            }
			 }*/
		});
		function promo(idpromo){
			//event.preventDefault()
			$.ajax({
				url: "<?php echo $urlserver?>/functions/clicks.php?idpromo="+idpromo,
				success: function(click) {
					var link = $("#promosq"+idpromo).attr("href");
					//console.log(link);
					//window.location.href = link;
				},
				error: function(click) {
					console.log(click);
				}
			});
		}
		
		$( document ).ready(function() {
			var w = $(window).width();
			if(w<=991){
				//console.log(w);
				if($("#pcads").children().length !=0){
					elementos = $("#adssq");
					elementos.appendTo('#mobileads');
				}
			}else{
				if($("#mobileads").children().length !=0){
					elementos = $("#adssq");
					elementos.appendTo('#pcads');
				}
			}
		});
		
		$(window).resize(function() {
			var homebanner = document.getElementById('home-escaparate').clientHeight;
			document.getElementById("pop-home-escaparate").style.height = homebanner+"px";
			var w = $(window).width();
			if(w<=991){
			//console.log(w);
				if($("#pcads").children().length !=0){
					elementos = $("#adssq");
					elementos.appendTo('#mobileads');
				}
			}else{
				if($("#mobileads").children().length !=0){
					elementos = $("#adssq");
					elementos.appendTo('#pcads');
				}
			}

		});
	</script>
</body>
</html>
