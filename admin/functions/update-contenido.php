<?php
session_start();
	require('../connect/conect_usrer.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_POST['idpage']) AND $_POST['idpage'] != ""){
		$idpage=$_POST['idpage'];
		$title=$_POST['title'];
		$contenido=$_POST['contenido'];
	
		$safeData = "UPDATE contenido_page SET titulo_page = '$title', contenido_page = '$contenido' WHERE id_page = $idpage";
		if ($conex->query($safeData) === TRUE) {
			header('location:'.SITE.'admin/contenido/editar?id='.$idpage.'&title='.$title.'&mod=true');
		}else{
			header('location:'.SITE.'admin/contenido/editar?id='.$idpage.'&title='.$title.'&mod=false');
		}
	}else{
		header('location:'.SITE.'admin/contenido');
	}
?>