<?php
session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
			header('location:'.SITE.'/admin/entrar');
	}
	$aviso="";
	//SAFE DATA
	if(isset($_POST['id_publicidad']) AND $_POST['id_publicidad'] != ""){
		
		$id_publicidad=$_POST['id_publicidad'];
		if(isset($_POST['borrar']) AND $_POST['borrar']=="borrar"){
			$sqlDeleteFiles="SELECT img_sq_a_publicidad,img_sq_b_publicidad,img_sq_c_publicidad,img_sq_d_publicidad,img_rq_a_publicidad,img_rq_b_publicidad,img_top_publicidad FROM publicidad WHERE id_publicidad = $id_publicidad";
			$reqDeleteFiles=mysqli_query($conex, $sqlDeleteFiles);
			while($resulreqDeleteFiles = mysqli_fetch_object($reqDeleteFiles)){
				$img_sq_a_publicidad = $resulreqDeleteFiles->img_sq_a_publicidad;
				unlink('../../img/publicidad/'.$img_sq_a_publicidad);
				$img_sq_b_publicidad = $resulreqDeleteFiles->img_sq_b_publicidad;
				unlink('../../img/publicidad/'.$img_sq_b_publicidad);
				$img_sq_c_publicidad = $resulreqDeleteFiles->img_sq_c_publicidad;
				unlink('../../img/publicidad/'.$img_sq_c_publicidad);
				$img_sq_d_publicidad = $resulreqDeleteFiles->img_sq_d_publicidad;
				unlink('../../img/publicidad/'.$img_sq_d_publicidad);
				$img_rq_a_publicidad = $resulreqDeleteFiles->img_rq_a_publicidad;
				unlink('../../img/publicidad/'.$img_rq_a_publicidad);
				$img_rq_b_publicidad = $resulreqDeleteFiles->img_rq_b_publicidad;
				unlink('../../img/publicidad/'.$img_rq_b_publicidad);
				$img_top_publicidad = $resulreqDeleteFiles->img_top_publicidad;
				unlink('../../img/publicidad/'.$img_top_publicidad);
				
			}
			$sqlborrar="DELETE FROM publicidad WHERE id_publicidad = $id_publicidad";
			if ($conex->query($sqlborrar) === TRUE) {
		  		header('location:'.SITE.'admin/publicidad?mod=true');
			} else {
				$aviso.="Error 13. La Publicidad no se ha borrado.";
				header('location:'.SITE.'admin/publicidad/editar?id='.$id_publicidad.'&mod=false');
			}
		};
		$img_top_publicidad=$_POST['txt-img_top_publicidad'];
		$nombre_publicidad =$_POST['nombre_publicidad'];
		$img_top_publicidad=$_POST["txt-img_top_publicidad"];
		$link_hb_producto=$_POST['link_hb_producto'];
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
		
		$tipo_publicidad=$_POST['tipo_publicidad'];
		
		if($show_tienda_publicidad=="Aleatorio"){
			$show_tienda_publicidad='NULL';
			$rowshow_tienda="";
			$rowcat="";
			if($_POST['categorias']!=""){
				foreach($_POST['categorias'] as $categorias){
					$rowcat.=$categorias.",";
				}
				$rowcat = trim($rowcat, ',');
			}else{
				$rowcat=NULL;
			}
		}
		if (isset($_POST["ocultar"])){
			$activo_publicidad = 2;
		}else{
			$activo_publicidad = 1;
		}
		
		
		//SAFE DATA
		$safeData = "UPDATE publicidad SET fecha_inicio_publicidad = '$fecha_inicio_publicidad', fecha_fin_publicidad ='$fecha_fin_publicidad', nombre_publicidad = '$nombre_publicidad', activo_publicidad = '$activo_publicidad', show_tienda_publicidad='$show_tienda_publicidad', link_sqa_producto = '$link_sqa_producto', link_sqb_producto='$link_sqb_producto', link_sqc_producto='$link_sqc_producto', link_sqd_producto='$link_sqd_producto', link_rqa_producto='$link_rqa_producto', link_rqb_producto ='$link_rqb_producto', link_hb_producto ='$link_hb_producto', tipo_precio_publicidad='$tipo_precio_publicidad', precio_publicidad='$precio_publicidad', descuento_precio_publicidad='$descuento_precio_publicidad', total_precio_publicidad='$total_precio_publicidad', show_categorias_publicidad='$rowcat', tipo_publicidad = '$tipo_publicidad', iva_publicidad='$iva_precio_publicidad' WHERE id_publicidad  = $id_publicidad ";
		if ($conex->query($safeData) === TRUE) {
		  	header('location:'.SITE.'admin/publicidad/editar?id='.$id_publicidad.'&mod=true');
		} else {
			$aviso.="Error 13. La Publicidad no se ha guardado.";
			header('location:'.SITE.'admin/publicidad/editar?id='.$id_publicidad.'&mod=false');
		}
		
	}else{
		$aviso.="Sin Datos";
		header('location:'.SITE.'admin/publicidad');
	}
echo $aviso;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Guardar edición de publicidad | Ecommerce</title>
<?php include("../parts/header.php");?>
</head>

<body>
	<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
		<div class="container">
			<div class="navbar-collapse justify-content-between align-items-center w-100" id="collapsingNavbar2">
				<a href="<?php echo SITE.'admin'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
			</div>
		</div>
	</nav>
</body>
</html>