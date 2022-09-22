<?php
session_start();
	require('../connect/conect_usrer.php');
	require('../../functions/resize-class.php');
	include('safeimg.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
			header('location:'.SITE.'/admin/entrar');
	}
//SAFE DATA
	if(isset($_POST['nombre_cliente_publi']) AND $_POST['nombre_cliente_publi'] != ""){
		$nombre_cliente_publi = $_POST['nombre_cliente_publi'];
		$NuevoClient = "INSERT INTO clientes_publi (nombre_cliente_publi) VALUES ('$nombre_cliente_publi')";
		if ($conex->query($NuevoClient) === TRUE) {	
			$id_cliente=$conex->insert_id;
			header('location:'.SITE.'admin/clientes-publicidad');
		}else{
			$id_cliente=0;
			header('location:'.SITE.'admin/clientes-publicidad');
		}
	}else{
		header('location:'.SITE.'admin/clientes-publicidad');
	}
?>