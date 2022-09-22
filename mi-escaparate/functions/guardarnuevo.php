<?php
	session_start();
	require('../connect/conect_usrer.php');
	require('../../functions/resize-class.php');
	include('safeimg.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.SITE.'/mi-escaparate/entrar');
	}
	$id_tienda_producto=IDTIENDA;
	$aviso;
	//SAFE DATA
	if(isset($_POST['nombre_producto']) AND $_POST['nombre_producto'] != ""){
		$nombre_producto=$_POST['nombre_producto'];
		$url_producto=$_POST['url_producto'];
		$titulo_desc_producto=$_POST['titulo_desc_producto'];
		$txt_desc_producto=$_POST['txt_desc_producto'];
		$precio_producto=$_POST['precio_producto'];
		$precio_promo_producto=$_POST['precio_promo_producto'];
		$costo_envio_productos=$_POST['costo_envio_productos'];
		$codigo_producto=$_POST['codigo_producto'];
		$stock_producto=$_POST['stock_producto'];
		$talla_producto=$_POST['talla_producto'];
		$tags_producto=$_POST['tags_producto'];
		$color_tallas=$_POST['color_tallas'];
		$guardar=$_POST['guardar'];
		$borrador=$_POST['borrador'];
		$categoria_producto=$_POST['categoria_producto'];
		if (isset($_POST["ocultar"])){
			$activo_producto = 2;
		}else{
			$activo_producto = 1;
		}
		
		if($precio_promo_producto!=""){
			$comision = $precio_promo_producto * ($porcentaje_suscripcion_tiendas/100);
			$precioPromo = $precio_promo_producto.',';
			$rowPrecioPromo="precio_promo_producto,";
		}else{
			$precioPromo;
			$rowPrecioPromo;
			$comision=$precio_producto * ($porcentaje_suscripcion_tiendas/100);
		}
		
		
		$NuevoProducto="INSERT INTO productos
		(nombre_producto, url_producto, id_tienda_producto, codigo_producto, stock_producto, precio_producto, $rowPrecioPromo costo_envio_productos, comision_producto, titulo_desc_producto, txt_desc_producto,talla_producto,color_tallas,tags_producto,categoria_producto,activo_producto)
		VALUES
		('$nombre_producto','$url_producto', '$id_tienda_producto', '$codigo_producto','$stock_producto','$precio_producto', $precioPromo '$costo_envio_productos', '$comision', '$titulo_desc_producto', '$txt_desc_producto', '$talla_producto', '$color_tallas','$tags_producto', '$categoria_producto', '$activo_producto')";
		if ($conex->query($NuevoProducto) === TRUE) {				
			$lastID=$conex->insert_id;
			//DATAIMG
			$img_a_producto = $_FILES["img_a_producto"]["name"];
			if($img_a_producto !=""){
				$safeAimage=saveImage($img_a_producto,'img_a_producto',$lastID,648,861);
				$conex->query($safeAimage);
			}else{
				//echo "a";
			}
			$img_b_producto = $_FILES["img_b_producto"]["name"];
			if($img_b_producto !=""){
				$safeBimage=saveImage($img_b_producto,'img_b_producto',$lastID,648,861);
				$conex->query($safeBimage);
			}else{
				//echo "b";
			}
			$img_c_producto = $_FILES["img_c_producto"]["name"];
			if($img_c_producto !=""){
				$safeCimage=saveImage($img_c_producto,'img_c_producto',$lastID,648,861);
				$conex->query($safeCimage);
			}else{
				//echo "c";
			}
			$img_d_producto = $_FILES["img_d_producto"]["name"];
			if($img_d_producto !=""){
				$safeDimage=saveImage($img_d_producto,'img_d_producto',$lastID,648,861);
				$conex->query($safeDimage);
			}else{
				//echo "d";
			}
			$img_e_producto = $_FILES["img_e_producto"]["name"];
			if($img_e_producto !=""){
				$safeEimage=saveImage($img_e_producto,'img_e_producto',$lastID,770,526);
				$conex->query($safeEimage);
			}else{
				//echo "e";
			}
			$img_tallas_producto = $_FILES["img_tallas_producto"]["name"];
			if($img_tallas_producto !=""){
				$safeTimage=saveImage($img_tallas_producto,'img_tallas_producto',$lastID,800,400);
				$conex->query($safeTimage);
			}else{
				//echo "t";
			}
			//DATAIMG
			$aviso.="Producto guardado con éxito";
			
			$linkgo=SITE.CATTIENDA.'/'.NICKTIENDA.'/'.$url_producto;
			$txtlinkgo="Ver el producto";
			$target="_blank";
		}else{
			$linkgo="javascript:history.back()";
			$txtlinkgo="Intentarlo nuevamente.";
			$target="_self";
		}
	}else{
		$aviso.="Sín datos";
		header('location:'.SITE.'mi-escaparate/mis-productos');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo NICKTIENDA?> | Ecommerce</title>
<?php include("../parts/header.php");?>
<script src="<?php echo SITE?>mi-escaparate/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo SITE?>mi-escaparate/js/tags.js"></script>
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
	<script>
		setTimeout(function(){
			window.location = "<?php echo SITE.'mi-escaparate/mis-productos'?>";
		}, 2000);
	</script>
	<?php include('../parts/footer.php');?>
</body>
</html>