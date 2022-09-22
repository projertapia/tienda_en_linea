<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
	if(isset($_GET['idorder']) AND $_GET['idorder'] != ""){
		$idorder=$_GET['idorder'];
		$action=$_GET['action'];
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
<title>Confirmación de Pago | ecommerce</title>
<?php include("parts/header.php");?>
<script>
	window.history.forward();
</script>
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
			<section id="confirmado-pago">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
							<h1 class="text-center"><?php echo $txtTitle?></h1>
							<p class="text-center">Su plan ha sido activado clave:: <span class="green"><?php echo $idorder?></span>, <?php echo $txt?></p>
							<a href="<?php echo SITE.'mi-escaparate/mi-plan'?>" class="btn btn-seguir-comprando">Ir a Mi Plan</a>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script>
		function goBack() {
		  event.preventDefault();
		  window.history.back();
		}
	</script>
</body>
</html>
