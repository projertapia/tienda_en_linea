<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (isset($_SERVER['HTTPS'])) {
		$http="https://";}else{
		$http="http://";
	}
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
 	$seccion = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title><?php echo strtoupper($seccion)?> | Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="home">
		<div class="container" id="home-banner-ads">
			<a href="<?php echo $url_hbint?>" title="" target="<?php echo $target_hbint?>" id="banner-home" style="background-image: url('<?php echo SITEUSER.'img/'.$img_hbint?>')">
			</a>
		</div>
	</section>
	<section id="home-influencers">
		<div class="container">
			<h2 class="title-section"><?php echo $seccion?></h2>
			<div class="row">
				<?php
					$sql ="SELECT id_tienda, nombre_tienda, nick_tienda, categoria_tienda, color_tienda, logo_tienda, cover_tienda FROM tiendas WHERE categoria_tienda = '$seccion' AND activa_tienda = 1";
					$req=mysqli_query($conex, $sql);
					$row_cnt = $req->num_rows;
					if($row_cnt !=0){
					while($result = mysqli_fetch_object($req)){
						$id_tienda = $result->id_tienda;
						$nombre_tienda = $result->nombre_tienda;
						$nick_tienda = strtolower($result->nick_tienda);
						$logo_tienda = $result->logo_tienda;
						$cover_tienda = $result->cover_tienda;
						$categoria_tienda =$result->categoria_tienda;
						$nombreshow = explode(" ", $nombre_tienda);
					?>
					<div class="col-md-4 col-sm-12 col-12 grid">
						<div class="box-cover-shop" style="background-image: url(<?php echo $urlserver.'img/tiendas/'.$nick_tienda.'/'.$logo_tienda?>)">
							<figcaption>
								<h2><?php echo $nombreshow[0]?><span><?php echo $nombreshow[1]?></span></h2>
								<a href="<?php echo $urlserver.$seccion.'/'.$nick_tienda?>"><button class="btn-comprar-ahora">VISÍTANOS</button></a>
							</figcaption>
						</div>						
					</div>
					<?php }}else{
						echo'<a href="'.$urlserver.'mi-escaparate" title="Crear mi escaparate"> <img src="img/espacio_disponible.jpg" alt="Espacio disponible" class="img-fluid"></a>';
					} ?>
				</div>
				<div class="clearfix"></div>
			</div>
	</section>
	<section id="ads-footer">
		<div class="container">
			<a href="<?php echo $url_ft?>" title="" target="<?php echo $target_ft?>" id="footer_ads"><img src="<?php echo SITEUSER.'img/'.$img_ft?>" alt="" class="img-fluid"></a>
		</div>
	</section>
	<?php include("parts/boletin.php");?>
	<?php include("parts/footer.php"); ?>
</body>
</html>
