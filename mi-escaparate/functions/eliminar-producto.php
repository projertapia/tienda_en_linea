<?php
	session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
		header('location:'.SITE.'/mi-escaparate/entrar');
	}
	$aviso="";
	if((isset($_POST['id']) AND $_POST['id'] != "") AND (isset($_POST['key']) AND $_POST['key'] == $_SESSION["key"])){
		$id_producto=$_POST['id'];
		$safeData = "UPDATE productos SET activo_producto = 4 WHERE id_producto = $id_producto";
		if ($conex->query($safeData) === TRUE) {
			echo 1;
		} else {
			echo 2;
		}
	}else{
		echo 3;
	}
	$_SESSION["key"]=""
?>