<?php
session_start();
	require('../connect/conect_usrer.php');
	require('../../functions/resize-class.php');
	//include('safeimg.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
			header('location:'.SITE.'/admin/entrar');
	}
	$aviso="";
	//SAFE DATA
	if(isset($_POST['nombre_publicidad']) AND $_POST['nombre_publicidad'] != ""){
		//$img_top_publicidad=$_POST['img_top_publicidad'];
		$nombre_publicidad =$_POST['nombre_publicidad'];
		$cliente_publicidad= $_POST['cliente_publicidad'];
		$link_hb_producto=$_POST['link_hb_producto'];
		$tipo_publicidad=$_POST['tipo_publicidad'];
		$img_top_publicidad=$_POST["txt-img_top_publicidad"];
		
		$img_sq_a_publicidad=$_POST["txt-img_sq_a_publicidad"];
		$link_sqa_producto=$_POST['link_sqa_producto'];
		$img_sq_b_publicidad=$_POST["txt-img_sq_b_publicidad"];
		$link_sqb_producto=$_POST['link_sqb_producto'];
		$img_sq_c_publicidad=$_POST["txt-img_sq_c_publicidad"];
		$link_sqc_producto=$_POST['link_sqc_producto'];
		$img_sq_d_publicidad=$_POST["txt-img_sq_d_publicidad"];
		$link_sqd_producto=$_POST['link_sqd_producto'];
		$img_rq_a_publicidad=$_POST["txt-img_rq_a_publicidad"];
		$link_rqa_producto=$_POST['link_rqa_producto'];
		$img_rq_b_publicidad=$_POST["txt-img_rq_b_publicidad"];
		$link_rqb_producto=$_POST['link_rqb_producto'];
		
		$fecha_inicio_publicidad=$_POST['fecha_inicio_publicidad'];
		$fecha_inicio_publicidad = str_replace("T", " ", $fecha_inicio_publicidad).":00";
		$fecha_fin_publicidad=$_POST['fecha_fin_publicidad'];
		$fecha_fin_publicidad = str_replace("T", " ", $fecha_fin_publicidad).":00";
		
		$show_tienda_publicidad=$_POST['show_tienda_publicidad'];
		
		$tipo_precio_publicidad=$_POST['tipo_precio_publicidad'];
		$precio_publicidad=$_POST['precio_publicidad'];
		$descuento_precio_publicidad=$_POST['descuento_precio_publicidad'];
		$iva_precio_publicidad=$_POST['iva_precio_publicidad'];
		$total_precio_publicidad=$_POST['total_precio_publicidad'];
		
		if($show_tienda_publicidad=="Aleatorio"){
			$show_tienda_publicidad=NULL;
			$rowshow_tienda="";
			$rowcat="";
			if(!empty($_POST['categorias']) AND isset($_POST['categorias'])){
				foreach($_POST['categorias'] as $categorias){
					$rowcat.=$categorias.",";
				}
			}else{
				$rowcat=NULL;
			}
		}else{
			$rowshow_tienda="show_tienda_publicidad,";
			$show_tienda_publicidad="'$show_tienda_publicidad',";
		}
		if (isset($_POST["ocultar"])){
			$activo_publicidad = 2;
		}else{
			$activo_publicidad = 1;
		}
		if($cliente_publicidad=="nuevo"){
			$nombre_cliente_publi = $_POST['nombre_cliente_publi'];
			$NuevoClient = "INSERT INTO clientes_publi (nombre_cliente_publi) VALUES ('$nombre_cliente_publi')";
			if ($conex->query($NuevoClient) === TRUE) {	
				$id_cliente=$conex->insert_id;
			}else{
				$id_cliente=0;
			}
		}else{
			$id_cliente=$cliente_publicidad;
		}
		//SAFE DATA
		$NuevaPubli = "INSERT INTO publicidad (cliente_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, nombre_publicidad,activo_publicidad,$rowshow_tienda link_sqa_producto,link_sqb_producto,link_sqc_producto, link_sqd_producto,link_rqa_producto, link_rqb_producto, link_hb_producto, tipo_precio_publicidad, precio_publicidad, descuento_precio_publicidad, iva_publicidad, total_precio_publicidad, show_categorias_publicidad,img_sq_a_publicidad,img_sq_b_publicidad,img_sq_c_publicidad,img_sq_d_publicidad,img_rq_a_publicidad,img_rq_b_publicidad,img_top_publicidad, tipo_publicidad) VALUES
		('$id_cliente','$fecha_inicio_publicidad', '$fecha_fin_publicidad', '$nombre_publicidad', '$activo_publicidad', $show_tienda_publicidad '$link_sqa_producto', '$link_sqb_producto', '$link_sqc_producto', '$link_sqd_producto', '$link_rqa_producto', '$link_rqb_producto', '$link_hb_producto', '$tipo_precio_publicidad', '$precio_publicidad', '$descuento_precio_publicidad', '$iva_precio_publicidad', '$total_precio_publicidad','$rowcat','$img_sq_a_publicidad','$img_sq_b_publicidad','$img_sq_c_publicidad','$img_sq_d_publicidad','$img_rq_a_publicidad','$img_rq_b_publicidad','$img_top_publicidad','$tipo_publicidad')";
		if ($conex->query($NuevaPubli) === TRUE) {				
			$id_publicidad=$conex->insert_id;
			//SAVER IMG
				$aviso.="Publicidad guardada con éxito";
		  		//header('location:'.SITE.'admin/publicidad/editar?id='.$id_publicidad.'&mod=true');
				header( "Refresh:2; url=".SITE."admin/publicidad/editar?id=".$id_publicidad."&mod=true", true, 303);
			}else {
				$aviso.="Error 13. La Publicidad no se ha guardado.";
				//header('location:'.SITE.'admin/nueva/publicidad');
				header( "Refresh:3; url=".SITE."admin/nueva/publicidad", true, 303);
			}
	}else{
		$aviso.="Error 11. Sin datos.";
		//header('location:'.SITE.'admin/nueva/publicidad');
		header( "Refresh:3; url=".SITE."admin/nueva/publicidad", true, 303);
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Guardar Nueva Publicidad | Ecommerce</title>
<?php include("../parts/header.php");?>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("../parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
				<div class="container">
					<div class="navbar-collapse justify-content-between align-items-center w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'admin'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
					</div>
				</div>
			</nav>
			<section id="edit-product">
				<h1><?php echo $aviso?></h1>
			</section>
		</div>
	</section>
</body>
</html>