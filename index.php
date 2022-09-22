<?php

	session_start();
	require('connect/conect_usrer.php');
	include('functions/promociones.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
	$subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));
	if (!empty($subdomain) AND $subdomain!="www") {
		$tienda = $subdomain;
		$site=$urlserver;
		$sqlStore="SELECT id_tienda, nick_tienda, activa_tienda, categoria_tienda, nivel_de_tienda FROM tiendas WHERE nick_tienda = '$tienda' AND activa_tienda = 1";
		$reqStore=mysqli_query($conex, $sqlStore);
		$row_cnt = $reqStore->num_rows;
		if($row_cnt==1){
			while($resultStore = mysqli_fetch_object($reqStore)){
				$section = $resultStore->categoria_tienda;
			}
			header("location:".$site.$section.'/'.$tienda);
		}else{
			header("location:".$site);	
		}
	} else {
	//header("location:".$site);
	}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="home">
		<div class="container" id="home-banner-ads">
			<a href="<?php echo $url_hb?>" title="" target="<?php echo $target_hb?>" id="banner-home" style="background-image: url('<?php echo SITEUSER.'img/'.$img_hb?>')">
			</a>
		</div>
	</section>
	<section id="home-influencers">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-12">
					<h2 class="title-section">Influencers</h2>
					<?php
					$limitnum = 6;
			   	//FUNCTION ESCAPARATES
			   	function escaparates($cantidad,$categoria,$pos){
					$connectescaparates = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
					if($pos=='principales'){
						$post = "!=0";
						$order= 'post_home_tienda ASC';
					}else{
						$post = "=0";
						$order= 'RAND(id_tienda)';
					}
					$sqlesc ="SELECT id_tienda, nombre_tienda, nick_tienda, categoria_tienda, color_tienda, logo_tienda, cover_tienda FROM tiendas WHERE categoria_tienda = '$categoria' AND activa_tienda = 1 AND post_home_tienda $post ORDER BY $order LIMIT $cantidad";
					$reqesc=mysqli_query($connectescaparates, $sqlesc);
					$row_escp = $reqesc->num_rows;
					$return='';
					while($result = mysqli_fetch_object($reqesc)){
						$id_tienda = $result->id_tienda;
						$nombre_tienda = $result->nombre_tienda;
						$nick_tienda = strtolower($result->nick_tienda);
						$logo_tienda = $result->logo_tienda;
						$cover_tienda = $result->cover_tienda;
						$categoria_tienda =$result->categoria_tienda;
						if (strpos($nombre_tienda, " ")){
							$nombreshow = explode(" ", $nombre_tienda);
							$name = $nombreshow[0].'<span>'.$nombreshow[1].'</span>';
						}else{
							$name = $nombre_tienda;
						}					
					
					$return .='<div class="grid">';
					$return .='<div class="box-cover-shop" style="background-image: url('.SITEUSER.'img/tiendas/'.$nick_tienda.'/'.$logo_tienda.')">';
					$return .='<figcaption>';
					$return .='<h2>'.$name.'</h2>';
					$return .='<a href="'.SITEUSER.$categoria_tienda.'/'.$nick_tienda.'" title="'.$nombre_tienda.'"class="btn-comprar-ahora" >VISÍTANOS</a>';
					$return .='</figcaption>';
					$return .='</div>';
					$return .='</div>';
					
					
				}
					mysqli_close($connectescaparates);
					//echo $return;
					$faltantes = $cantidad-$row_escp;
					return array($return, $faltantes);
				}
			   list($escaparatesinfluencers,$numfaltantes)=escaparates("$limitnum","influencers","principales");
			   echo($escaparatesinfluencers);
			   
			   list($escaparatesinfluencers,$numfaltantes)=escaparates("$numfaltantes","influencers","secundarios");
			   echo($escaparatesinfluencers);
			   
			   if($numfaltantes == $limitnum){				
					echo'<a href="'.$urlserver.'mi-escaparate" title="Crear mi escaparate"> <img src="img/espacio_disponible.jpg" alt="Espacio disponible" class="img-fluid"></a>';
				}?>
				</div>
				<div class="col-md-4 col-sm-12 col-12">
					<h2 class="title-section">Empresas</h2>
					<?php
						list($escaparatesempresas,$numfaltantes)=escaparates("$limitnum","empresas","principales");
						echo($escaparatesempresas);

						list($escaparatesempresas,$numfaltantes)=escaparates("$numfaltantes","empresas","secundarios");
						echo($escaparatesempresas);

						if($numfaltantes == $limitnum){				
							echo'<a href="'.$urlserver.'mi-escaparate" title="Crear mi escaparate"> <img src="img/espacio_disponible.jpg" alt="Espacio disponible" class="img-fluid"></a>';
						}
					?>
				</div>
				<div class="col-md-4 col-sm-12 col-12">
					<h2 class="title-section">Profesionales</h2>
					<?php
					list($escaparatesprofesionales,$numfaltantes)=escaparates("$limitnum","profesionales","principales");
					echo($escaparatesprofesionales);

					list($escaparatesprofesionales,$numfaltantes)=escaparates("$numfaltantes","profesionales","secundarios");
					echo($escaparatesprofesionales);

					if($numfaltantes == $limitnum){				
						echo'<a href="'.$urlserver.'mi-escaparate" title="Crear mi escaparate"> <img src="img/espacio_disponible.jpg" alt="Espacio disponible" class="img-fluid"></a>';
					}
					?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>
	<section id="promos-box">
		<div class="container">
			<h2 class="title-section">Promociones</h2>			
			<div id="top-promo">
				<div class="row">
					<?php echo promos('rq',1,'1');?>
					<?php echo promos('rq',1,'2');?>
					<?php echo promos('sq',1,'3');?>
					<?php echo promos('sq',1,'4');?>
					<?php echo promos('sq',1,'5');?>
					<?php echo promos('sq',1,'6');?>
					<?php echo promos('sq',1,'7');?>
					<?php echo promos('sq',1,'8');?>
					<?php echo promos('sq',1,'9');?>
					<?php echo promos('sq',1,'10');?>
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
	<script>
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
		function mail(post){
			event.preventDefault();
			window.open("mailto:contacto@ecommerce.com?subject=Deseo%20mostrar%20mi%20promoci%C3%B3n%20en%20el%20espacio%20"+post+"&body=Hola%20deseo%20mostrar%20mi%20promoci%C3%B3n%20en%20el%20espacio%20numero%20"+post, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=300,width=800,height=600");
			
			
		}
	</script>
</body>
</html>
