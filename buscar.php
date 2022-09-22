<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
	if(isset($_GET['s']) AND $_GET['s'] !=""){
		$busqueda=$_GET['s'];
	}else{
		$busqueda = NULL;
	}
$nick_tienda ="";

if (isset($_GET['pag'])) {
	$pageno = $_GET['pag'];

} else {
	$pageno = 1;
}
//ORDENAR POR
if(isset($_GET['ordenar']) AND $_GET['ordenar']!=""){
	$ordenarpor=$_GET['ordenar'];
	switch ($ordenarpor){
		case 'recientes':
		$OrderBy="ORDER BY p.fecha_producto DESC";
		$ordenar="recientes";
		break;
		case 'preciobajo':
		$OrderBy="ORDER BY p.precio_producto ASC";
		$ordenar="preciobajo";
		break;
		case 'precioalto':
		$OrderBy="ORDER BY p.precio_producto DESC";
		$ordenar="precioalto";
		break;
		default:
		$OrderBy="ORDER BY RAND()";	
		$ordenar="defecto";
	}
}else{
	$OrderBy="ORDER BY RAND()";
	$ordenar="defecto";
}
//CATEGORIA
if(isset($_GET['cat']) AND $_GET['cat']!=""){
	$cat=$_GET['cat'];
	if($cat=='todas'){
		$cat="";
	}else{
	$WhereCat="AND UPPER(p.categoria_producto)=UPPER('$cat')";
	}
}else{
	$WhereCat="";
	$cat="";
}

$no_of_records_per_page = 20;
$offset = ($pageno-1) * $no_of_records_per_page;
$total_pages_sql ="SELECT p.id_producto, p.nombre_producto, p.url_producto, p.stock_producto, p.precio_producto, p.precio_promo_producto, p.precio_promo_producto, p.img_a_producto, p.activo_producto, p.fecha_producto, p.id_tienda_producto, p.tags_producto, p.categoria_producto,
t.id_tienda, t.nick_tienda, t.nombre_tienda, t.categoria_tienda, t.activa_tienda
FROM productos p, tiendas t
WHERE p.activo_producto = 1 AND p.stock_producto >= 1 AND p.id_tienda_producto = t.id_tienda $WhereCat AND (UPPER(p.nombre_producto) LIKE UPPER('%$busqueda%') OR UPPER(t.nick_tienda) LIKE UPPER('%$busqueda%') OR UPPER(t.nombre_tienda) LIKE UPPER('%$busqueda%') OR UPPER(t.nick_tienda) LIKE UPPER('%$busqueda%') OR UPPER(p.categoria_producto) LIKE UPPER('%$busqueda%') OR UPPER(p.tags_producto) LIKE UPPER('%$busqueda%')) 
$OrderBy";
$result = mysqli_query($conex,$total_pages_sql);
$total_rows = mysqli_num_rows($result); 
$total_pages = ceil($total_rows / $no_of_records_per_page);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Resultados de busqueda de <?php echo $busqueda;?> | Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="home-producto" style="background-image: linear-gradient(rgba(255, 255, 255, 0.0) 50%, rgba(255, 255, 255, 1) 100%), url(img/cover_busqueda.png)">
		<div class="container">
			<h2 id="title-escaparate">Resultados de busqueda: <span style="color:#3e6d38"><?php echo $busqueda;?></span>
				<?php if($cat!=""){
				echo 'en la categoría <span style="color:#3e6d38">'.$cat.'</span>';
				}?>
			</h2>
		</div>
	</section>
	<section id="articulos-escaparate">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-2" id="col-l-ads">
					<div class="row" id="adssq">
						<?php list($id_a,$img_sq_a,$link_sq_a,$tipopubli,$host_server,$id_b,$img_sq_b,$link_sq_b,$id_c,$img_sq_c,$link_sq_c,$id_d,$img_sq_d,$link_sq_d) = ads("sq","$tiendaads","$tipopubli",$id);?>
		<a href="<?php echo $link_sq_a?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_a,$host_server)?>" onclick="adsclick(<?php echo $id_a?>','sq1')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_a?>" class="img-fluid" alt=""></a>
		
		<a href="<?php echo $link_sq_b?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_b,$host_server)?>" onclick="adsclick(<?php echo $id_b?>','sq2')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_b?>" class="img-fluid" alt=""></a>
		
		<a href="<?php echo $link_sq_c?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_c,$host_server)?>" onclick="adsclick(<?php echo $id_c?>','sq3')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_c?>" class="img-fluid" alt=""></a>
		
		<a href="<?php echo $link_sq_d?>" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="<?php echo checklinkads($link_sq_d,$host_server)?>" onclick="adsclick(<?php echo $id_d?>','sq4')"><img src="<?php echo SITEUSER.'img/publicidad/'.$img_sq_d?>" class="img-fluid" alt=""></a>
					</div>					
				</div>
				<div class="col-md-12 col-lg-8">
					<article>
						<div class="row">
							<div class="col-12">
								<?php if($busqueda != NULL AND $total_rows != ""){ ?>
								<form action="<?php echo $urlserver.'buscar'?>" accept-charset="UTF-8" method="get">
									<input type="hidden" name="s" value="<?php echo $busqueda?>">
									<div class="row">
									<div class="form-group col-md-4">									
									<select name="ordenar" onchange="this.form.submit()" class="form-control">
										<option value="defecto">Ordenar por:</option>
										<?php if($ordenar == "recientes"){?>
										<option value="recientes" selected>Recientes</option>
										<?php }else{ ?>
										<option value="recientes">Recientes</option>
										<?php } ?>
										<?php if($ordenar == "preciobajo"){?>
										<option value="preciobajo" selected>Precio: del más bajo a más alto</option>
										<?php }else{ ?>
										<option value="preciobajo">Precio: del más bajo a más alto</option>
										<?php } ?>
										<?php if($ordenar == "precioalto"){?>
										<option value="precioalto" selected>Precio: del más alto a más bajo</option>
										<?php }else{ ?>
										<option value="precioalto">Precio: del más alto a más bajo</option>
										<?php } ?>
									</select>
									</div>
									<div class="form-group col-md-4">
										<select name="cat" class="form-control" onchange="this.form.submit()">
											<option value="todas">Filtrar por categoría:</option>
											<?php
												echo $sqlCat="SELECT * FROM categorias WHERE activo_categoria =1 ORDER BY nombre_categoria ASC";
												$reqCat=mysqli_query($conex, $sqlCat);
												while($resultBusqueda = mysqli_fetch_object($reqCat)){
													$nombre_categoria = $resultBusqueda->nombre_categoria;
													$tag_categoria = $resultBusqueda->tag_categoria;
													if($cat==$nombre_categoria){
														echo '<option value="'.$tag_categoria.'" select>'.$nombre_categoria.'</option>';
													}else{
														echo '<option value="'.$tag_categoria.'">'.$nombre_categoria.'</option>';
													}
												}
											?>											
										</select>
									</div>
									</div>
								</form>
								<?php } ?>
							</div>
							<?php
								if($busqueda != NULL AND $total_rows != ""){
								$sqlBusqueda=$total_pages_sql." LIMIT $offset, $no_of_records_per_page";
								$reqBusqueda=mysqli_query($conex, $sqlBusqueda);
								$row_cnt = $reqBusqueda->num_rows;
								if($row_cnt!=0){
								while($resultBusqueda = mysqli_fetch_object($reqBusqueda)){
									$id_tienda = $resultBusqueda->id_tienda;
									$nick_tienda = $resultBusqueda->nick_tienda;
									$nombre_tienda = $resultBusqueda->nombre_tienda;
									$categoria_tienda = $resultBusqueda->categoria_tienda;
									
									$nombre_producto = $resultBusqueda->nombre_producto;
									$url_producto = $resultBusqueda->url_producto;
									$precio_producto = $resultBusqueda->precio_producto;
									$precio_promo_producto = $resultBusqueda->precio_promo_producto;
									$img_a_producto = $resultBusqueda->img_a_producto;
									if($precio_promo_producto == NULL OR $precio_promo_producto ==""){
										$preciofinal = $precio_producto;
									}else{
										$preciofinal = $precio_promo_producto;
									}
									
								
							?>
							
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
								<a href="<?php echo $urlserver.$categoria_tienda.'/'.$nick_tienda.'/'.$url_producto?>" title="<?php echo $nombre_producto?>" class="link-product">
								<img src="img/tiendas/<?php echo $nick_tienda.'/'.$img_a_producto?>" class="img-fluid d-block w-100" alt="<?php echo $nombre_producto?>">
								<h6 class="title-product-relacionados"><?php echo $nombre_producto?></h6>
								<p class="price-product-relacionados">$<?php echo $preciofinal?></p>
								</a>
							</div>
							<?php }} ?>
							<?php }else{ ?>
							<div class="col-12">
							<form method="get" accept-charset="UTF-8" action="<?php echo $urlserver.'buscar'?>">
								<div class="form-group">
									<input type="text" name="s" required value="<?php echo $busqueda?>" class="form-control">
								</div>
								<button type="submit" class="btn btn-primary">Buscar</button>
							</form>
							<blockquote class="blockquote text-center">
								<h4 class="class="mb-0"">¡Lo sentimos!</h4>
								<h6>No se han encontrado productos con tu busqueda.</h6>
								<footer class="blockquote-footer">
									<div class="clearfix"></div>
									<a href="<?php echo $urlserver?>" class="d-inline-block badge badge-dark py-2">Regresar al inicio.</a>
								</footer>
							</blockquote>
							</div>
							<?php }?>
						</div>
						<div class="clearfix"></div>
						<?php
							if(($busqueda != NULL AND $row_cnt!=0) AND ($total_pages!=1)){
							$link =$urlserver.'buscar?s='.$busqueda.'&ordenar='.$ordenar.'&cat='.$cat.'&';
						?>
						<div class="text-xs-center" id="pag-center">
							<nav aria-label="Page navigation example">
							  <ul class="pagination justify-content-center">
								<li class="page-item">
								  <a class="page-link <?php if($pageno == 1){ echo 'disabled'; } ?>" href="<?php echo $link?>pag=1" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
									<span class="sr-only">Previous</span>
								  </a>
								</li>
								 <?php
									for ($i = 1; $i <= $total_pages; $i++) {
										if($i ==$pageno){
											$activeClass="active";
										}else{
											$activeClass="";
										}
								?>	
								  <li class="page-item <?php echo $activeClass?>"><a class="page-link" href="<?php echo $link.'pag='.$i?>"><?php echo $i ?></a></li>
								<?php }
								?>
								<li class="page-item">
								  <a class="page-link <?php if($pageno == $total_pages){ echo 'disabled'; } ?>" href="<?php echo $link.'pag='.$total_pages?>" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
									<span class="sr-only">Next</span>
								  </a>
								</li>
							  </ul>
							</nav>
						</div>
						<?php }?>
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
	<?php include("parts/boletin.php");?>
	<?php include("parts/footer.php"); ?>
	<script>
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
