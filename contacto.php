<?php
	session_start();
	require('connect/conect_usrer.php');
	$SQLPage="SELECT id_page, titulo_page, contenido_page FROM contenido_page WHERE id_page=6";
	$reqPage=mysqli_query($conex, $SQLPage);
	while($resulPage = mysqli_fetch_object($reqPage)){
		$titulo_page = $resulPage->titulo_page;
		$contenido_page = $resulPage->contenido_page;
	}
	function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	$keymail=generateRandomString(10);
	$_SESSION["keymail"]=$keymail;	
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
				<div class="col-md-6 col-sm-12 card-container">
					<?php echo $contenido_page?>
				</div>
				<div class="col-md-6 col-sm-12 card-container">
					<h3>¿Tienes dudas o comentarios?</h3>
					<p><strong>Escríbenos</strong></p>
					<form method="post" action="contactanos/gracias" accept-charset="UTF-8">
						<input type="hidden" name="key" value="<?php echo $keymail?>">
						<div class="form-group">
							<label for="nombre">Nombre:</label>
							<input type="text" class="form-control" name="nombre" required placeholder="Nombre completo">
						</div>
						<div class="form-group">
							<label for="asunto">Asunto:</label>
							<input type="text" class="form-control" name="asunto" required placeholder="Asunto">
						</div>
						<div class="form-group">
							<label for="email">Correo Electrónico:</label>
							<input type="email" class="form-control" name="email" required placeholder="correo@electronico.com">
						</div>
						<div class="form-group">
							<label for="mensaje">Mensaje:</label>
							<textarea class="form-control" name="mensaje" rows="6" required></textarea>
						</div>
						<hr>
						<button type="submit" class="btn btn-success btn-sm btn-block">Enviar</button>
					</form>
				</div>
			</div>
		</div>
	</section>
	<?php include("parts/boletin.php");?>
	<?php include("parts/footer.php"); ?>
	<script>
		
	</script>
</body>
</html>
