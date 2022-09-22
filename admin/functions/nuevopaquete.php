<?php
session_start();
	require('../connect/conect_usrer.php');
	require('../../functions/resize-class.php');
	include('safeimg.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
			header('location:'.SITE.'/admin/entrar');
	}
	if(isset($_POST['idadmin']) AND $_POST['idadmin'] != ""){
		$formadmin=$_POST['idadmin'];
		if($id_admin==$formadmin){	
			$nombre_tipo_tienda=$_POST['nombre_tipo_tienda'];
			$cantidad_prod=$_POST['cantidad_prod'];
			$cantidad_prom=$_POST['cantidad_prom'];
			$porcentaje=$_POST['porcentaje'];
			$costo=$_POST['costo'];
			$duracion=$_POST['duracion'];
			$AddPlan = "INSERT INTO tipos_tienda (nombre_tipo_tienda,cantidad_tipo_tienda,cantidad_promos_tipo_tienda,porcentaje_tienda,costo_tienda,duracion_tipo_tienda) VALUES ('$nombre_tipo_tienda','$cantidad_prod','$cantidad_prom','$porcentaje','$costo','$duracion')";
			if ($conex->query($AddPlan) === TRUE) {	
				$lastID=$conex->insert_id;
				header('location:'.SITE.'/admin/paquetes?mod=true&id='.$lastID.'');
			}else{
				header('location:'.SITE.'/admin/paquetes?mod=false');
			}
		}else{
			header('location:'.SITE.'/admin/paquetes');
		}
	}else{
		header('location:'.SITE.'/admin/paquetes');
	}
?>