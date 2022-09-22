<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
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
	<section id="home-influencers">
		<div class="container" style="min-height:50vh">
			<h3>Error 404</h3>
			<p>Lo sentimos no logramos encontrar la página que buscas.</p>
			<a href="<?php echo SITEUSER?>">Ir a la página principal</a>
		</div>
	</section>
	
	
	<?php include("parts/footer.php"); ?>
	
</body>
</html>
