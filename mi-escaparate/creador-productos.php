<?php
	session_start();
	require('connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.$server.'entrar');
	}
	$sqlContenido="SELECT * FROM contenido_editable
	WHERE id_contenido = 1 AND activo_contenido = 1";
	$reqContenido=mysqli_query($conexlite, $sqlContenido);	
	while($resulContenido = mysqli_fetch_object($reqContenido)){		
		$nombre_contenido = $resulContenido->nombre_contenido;
		$file_contenido = $resulContenido->file_contenido;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Creador de Productos</title>
<?php include("parts/header.php");?>
	<style>
		#pdf-show{width: 100%; height: 100vh; height: calc(100vh - 140px)}
	</style>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light right-content">
				<div class="container">
					<div class="nav justify-content-end w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'mi-escaparate'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lateralpanel" aria-controls="lateralpanel" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
				</div>
			</nav>
			<section id="info-content">
				<div class="row">
					<div class="card" style="width: 100%">
  						<div class="card-body row">
							<embed src="<?php echo SITE.'mi-escaparate/pdf/'.$file_contenido?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="600px" id="pdf-show" />
							<a href="<?php echo SITE.'mi-escaparate/pdf/'.$file_contenido?>" class="btn btn-sm btn-success my-3" download="<?php echo $nombre_contenido?>" title="<?php echo $nombre_contenido?>.pdf">Descargar</a>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</body>
</html>