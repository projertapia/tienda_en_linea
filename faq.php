<?php
	session_start();
	require('connect/conect_usrer.php');
	$SQLPage="SELECT id_page, titulo_page, contenido_page FROM contenido_page WHERE id_page=2";
	$reqPage=mysqli_query($conex, $SQLPage);
	while($resulPage = mysqli_fetch_object($reqPage)){
		$titulo_page = $resulPage->titulo_page;
		$contenido_page = $resulPage->contenido_page;
	}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title><?php echo $titulo_page?> | Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="home-producto" style="background-image: linear-gradient(rgba(255, 255, 255, 0.0) 50%, rgba(255, 255, 255, 1) 100%), url(img/cover_busqueda.png)">
		<div class="container">
			<h2 id="title-escaparate"><?php echo $titulo_page?></h2>
		</div>
	</section>
	<section id="faq">
		<div class="container">
			<div class="row">
				<div class="col-12 card-container">
					<?php echo $contenido_page?>
				</div>
			</div>
		</div>
	</section>
	<?php include("parts/footer.php"); ?>
	<script>
		
	</script>
</body>
</html>
