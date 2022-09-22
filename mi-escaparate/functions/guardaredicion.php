<?php
	session_start();
	require('../connect/conect_usrer.php');
	require('../../functions/resize-class.php');
	include('safeimg.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.SITE.'/mi-escaparate/entrar');
	}

	
	//SAFE DATA
	if(isset($_POST['id_producto']) AND $_POST['id_producto'] != ""){
		$id_producto=$_POST['id_producto'];
		$nombre_producto=$_POST['nombre_producto'];
		$url_producto=$_POST['url_producto'];
		$titulo_desc_producto=$_POST['titulo_desc_producto'];
		$txt_desc_producto=$_POST['txt_desc_producto'];
		$precio_producto=$_POST['precio_producto'];
		$precio_promo_producto=$_POST['precio_promo_producto'];
		$costo_envio_productos=$_POST['costo_envio_productos'];
		$comision_producto=$_POST['comision'];
		$codigo_producto=$_POST['codigo_producto'];
		$stock_producto=$_POST['stock_producto'];
		$talla_producto=$_POST['talla_producto'];
		$tags_producto=$_POST['tags_producto'];
		$color_tallas=$_POST['color_tallas'];
		$guardar=$_POST['guardar'];
		$borrador=$_POST['borrador'];
		$categoria_producto=$_POST['categoria_producto'];
		
		//DELETE IMGS
		function borrarfoto($foto,$idp){
			return $SqlIMG="UPDATE productos SET $foto = NULL WHERE id_producto = $idp";			
		}
		
		if(isset($_POST['fotob']) AND $_POST['fotob']!=""){
			$namefotob=$_POST['namefotob'];
			$bfotob=borrarfoto('img_b_producto',$id_producto);
			$conex->query($bfotob);
			unlink("../../img/tiendas/".NICKTIENDA."/$namefotob");
			
		}
		if(isset($_POST['fotoc']) AND $_POST['fotoc']!=""){
			$namefotoc=$_POST['namefotoc'];
			$bfotoc=borrarfoto('img_c_producto',$id_producto);
			$conex->query($bfotoc);
			unlink("../../img/tiendas/".NICKTIENDA."/$namefotoc");
		}
		if(isset($_POST['fotod']) AND $_POST['fotod']!=""){
			$namefotod=$_POST['namefotod'];
			$bfotod=borrarfoto('img_d_producto',$id_producto);
			$conex->query($bfotod);
			unlink("../../img/tiendas/".NICKTIENDA."/$namefotod");
		}
		if(isset($_POST['img_tallas']) AND $_POST['img_tallas']!=""){
			$namefotot=$_POST['namefotot'];
			$bfotot=borrarfoto('img_tallas_producto',$id_producto);
			$conex->query($bfotot);
			unlink("../../img/tiendas/".NICKTIENDA."/$namefotot");
		}
		//DELETE IMGS
		
		//DATAIMG
		$img_a_producto = $_FILES["img_a_producto"]["name"];
		if($img_a_producto !=""){
			$safeAimage=saveImage($img_a_producto,'img_a_producto',$id_producto,648,861);
			$conex->query($safeAimage);
		}else{
			//echo "a";
		}
		$img_b_producto = $_FILES["img_b_producto"]["name"];
		if($img_b_producto !=""){
			$safeBimage=saveImage($img_b_producto,'img_b_producto',$id_producto,648,861);
			$conex->query($safeBimage);
		}else{
			//echo "b";
		}
		$img_c_producto = $_FILES["img_c_producto"]["name"];
		if($img_c_producto !=""){
			$safeCimage=saveImage($img_c_producto,'img_c_producto',$id_producto,648,861);
			$conex->query($safeCimage);
		}else{
			//echo "c";
		}
		$img_d_producto = $_FILES["img_d_producto"]["name"];
		if($img_d_producto !=""){
			$safeDimage=saveImage($img_d_producto,'img_d_producto',$id_producto,648,861);
			$conex->query($safeDimage);
		}else{
			//echo "d";
		}
		$img_e_producto = $_FILES["img_e_producto"]["name"];
		if($img_e_producto !=""){
			$safeEimage=saveImage($img_e_producto,'img_e_producto',$id_producto,770,526);
			$conex->query($safeEimage);
		}else{
			//echo "e";
		}
		$img_tallas_producto = $_FILES["img_tallas_producto"]["name"];
		if($img_tallas_producto !=""){
			$safeTimage=saveImage($img_tallas_producto,'img_tallas_producto',$id_producto,800,400);
			$conex->query($safeTimage);
		}else{
			//echo "t";
		}
		if (isset($_POST["ocultar"])){
			$activo_producto = 2;
		}else{
			$activo_producto = 1;
		}
		if($precio_promo_producto!=""){
		$precioPromo = "precio_promo_producto='$precio_promo_producto',";
		}else{
			$precioPromo;
		}
		//SAFE DATA
		$safeData = "UPDATE productos SET nombre_producto = '$nombre_producto', url_producto ='$url_producto', codigo_producto = '$codigo_producto', stock_producto = '$stock_producto', precio_producto='$precio_producto', $precioPromo costo_envio_productos = '$costo_envio_productos',  comision_producto = '$comision_producto', titulo_desc_producto='$titulo_desc_producto', txt_desc_producto='$txt_desc_producto', talla_producto='$talla_producto', color_tallas='$color_tallas', categoria_producto ='$categoria_producto', activo_producto ='$activo_producto', tags_producto = '$tags_producto' WHERE id_producto = $id_producto";
		if ($conex->query($safeData) === TRUE) {
			header('location:'.SITE.'mi-escaparate/mis-productos/editar?id='.$id_producto.'&mod=true');
		} else {
			header('location:'.SITE.'mi-escaparate/mis-productos/editar?id='.$id_producto.'&mod=false');
		}
		
	}else{
		$aviso.="Sín datos";
		//header('location:'.SITE.'mi-escaparate/mis-productos');
	}
	//SAFE DATA	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mi escaparate | Ecommerce</title>
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
			</section>
		</div>
	</section>
	<?php include('../parts/footer.php');?>
</body>
</html>