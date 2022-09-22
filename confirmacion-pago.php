<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
	if(isset($_GET['idorder']) AND $_GET['idorder'] != ""){
		$idorder=$_GET['idorder'];
		$action=$_GET['action'];
		unset($_SESSION['clave_carrito']);
		if($action==1){
			$txtTitle= "Pago Confirmado";
			$txt="ha sido pagado y ha sido confirmado.";			
		}else{
			$txtTitle= "Pago en confirmación";
			$txt="ha realizado, pero esta por confirmar.";
		}
	}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Confirmación de Pago | Ecommerce</title>
<?php include("parts/head.php"); ?>
<script>
	window.history.forward();
</script>
</head>

<body>	
	<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
		<div class="container">
			<a href="/" class="navbar-brand mr-0"><img src="img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
		</div>
	</nav>
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		 <li class="breadcrumb-item"><a href="<?php echo $urlserver?>"> Inicio</a></li>
		  <li class="breadcrumb-item">Carrito</a></li>
		  <li class="breadcrumb-item">Envio</li>
		 <li class="breadcrumb-item active" aria-current="page">Confirmación</li>
	  </ol>
	</nav>
	<section id="confirmado-pago">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
					<h1 class="text-center"><?php echo $txtTitle?></h1>
					<p class="text-center">Su pedido con número: <span class="green"><?php echo $idorder?></span>, <?php echo $txt?></p>
					<a href="<?php echo $urlserver?>" class="btn btn-seguir-comprando">Seguir comprando</a>
				</div>
			</div>
		</div>
	</section>
	<?php include("parts/footer.php"); ?>
	<script>
		function goBack() {
		  event.preventDefault();
		  window.history.back();
		}
	</script>
</body>
</html>
