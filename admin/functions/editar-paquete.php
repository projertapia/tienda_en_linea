<?php
session_start();
require('../connect/conect_usrer.php');
require('../../functions/resize-class.php');
include('safeimg.php');
if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
	header('location:'.SITE.'/admin/entrar');
}
if((isset($_POST['idadmin']) AND $_POST['idadmin'] != "") AND (isset($_POST['idpaquete']) AND $_POST['idpaquete'] != "")){
	$formadmin=$_POST['idadmin'];
	if($id_admin==$formadmin){
		$idpaquete=$_POST['idpaquete'];
		$nombre_tipo_tienda=$_POST['nombre_tipo_tienda'];
		$cantidad_prod=$_POST['cantidad_prod'];
		$cantidad_prom=$_POST['cantidad_prom'];
		$porcentaje=$_POST['porcentaje'];
		$costo=$_POST['costo'];
		$activo=$_POST['activo'];
		$duracion=$_POST['duracion'];
		$safeData = "UPDATE tipos_tienda SET nombre_tipo_tienda = '$nombre_tipo_tienda', cantidad_tipo_tienda = $cantidad_prod, cantidad_promos_tipo_tienda = $cantidad_prom, porcentaje_tienda = $porcentaje, costo_tienda = $costo, activo_tipo_tienda = $activo, duracion_tipo_tienda = $duracion WHERE id_tipo_tienda = $idpaquete";
		if ($conex->query($safeData) === TRUE) {
			header('location:'.SITE.'/admin/paquetes?mod=true&id='.$idpaquete.'');
		}else{
			header('location:'.SITE.'/admin/paquetes?mod=false&id='.$idpaquete.'');
		}
	}else{
		header('location:'.SITE.'/admin/paquetes');
	}
}else{
	header('location:'.SITE.'/admin/paquetes');
}
?>