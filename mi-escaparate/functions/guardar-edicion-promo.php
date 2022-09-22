<?php
	session_start();
	require('../connect/conect_usrer.php');
	require('../../functions/resize-class.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
		header('location:'.SITE.'/mi-escaparate/entrar');
	}
$aviso="";
	if(isset($_POST['id_promocion']) AND $_POST['id_promocion'] != ""){
		$id_promocion=$_POST['id_promocion'];
		$nombre_promocion=$_POST['nombre_promocion'];
		$url_promocion=$_POST['url_promocion'];
		$fecha_inicio_promocion=$_POST['fecha_inicio_promocion'];
		$fecha_fin_promocion=$_POST['fecha_fin_promocion'];
		$tipo_promocion=$_POST['tipo_promocion'];
		$txt_img_promocion =  $_POST['txt-img_promocion'];
		if(isset($_POST['ocultar'])){
			$activo=0;
		}else{
			$activo=1;
		};
		$safeData = "UPDATE promociones SET nombre_promocion = '$nombre_promocion', fecha_inicio_promocion ='$fecha_inicio_promocion', fecha_fin_promocion = '$fecha_fin_promocion', img_promocion = '$txt_img_promocion', url_promocion='$url_promocion', tipo_promocion = '$tipo_promocion', activo_promocion = $activo WHERE id_promocion = $id_promocion";
		if ($conex->query($safeData) === TRUE) {
			header('location:'.SITE.'mi-escaparate/mis-promociones/editar?id='.$id_promocion.'&mod=true');
		} else {
			header('location:'.SITE.'mi-escaparate/mis-promociones/editar?id='.$id_promocion.'&mod=false');
		}
				
			
		
	}else{
		$linkgo="javascript:history.back()";
		$txtlinkgo="Error interno 12. No se recibieron los datos.";
		$target="_self";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo NICKTIENDA?> | Ecommerce</title>
<?php include("../parts/header.php");?>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("../parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
				<div class="container">
					<div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'mi-escaparate'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce.svg" alt="Ecommerce" width="82px"></a> 
					</div>
				</div>
			</nav>
			<section id="edit-product">
				<h1 style="margin: 15px auto; display: block; text-align: center;"><?php echo $aviso?></h1>
				<a href="<?php echo $linkgo?>" target="<?php echo $target?>" style="margin: 0 auto; padding: 0; display: block; width: 250px; text-align: center"><?php echo $txtlinkgo?></a>
			</section>
		</div>
	</section>
	<?php include('../parts/footer.php');?>
</body>
</html>