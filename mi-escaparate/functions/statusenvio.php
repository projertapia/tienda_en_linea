<?php
	session_start();
	require('../connect/conect_usrer.php');
	include('mail-cancelacion.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	date_default_timezone_set('America/Mexico_City');
	// Unix
	setlocale(LC_TIME, 'es_ES.UTF-8');
	// En windows
	setlocale(LC_TIME, 'spanish');
	setlocale(LC_MONETARY, 'es_MX');
	if(isset($_POST['idCarrito']) AND $_POST['idCarrito']!=""){
		$idCarrito=$_POST['idCarrito'];
		$clavecarrito=$_POST['clavecarrito'];
		$mail = $_POST['mail'];
		$nombrecliente = $_POST['nombrecliente'];
		$status=$_POST['status'];
		if($status ==3){
			$razon =$_POST['razon'];
		}else{
			$razon="-";
		}
		$empresa=$_POST['empresa'];
		$rastreo=$_POST['rastreo'];
		$masterkey= $idCarrito.'-'.$clavecarrito;
		if($status ==2){
			$sqlUpdatePredido = "UPDATE carrito SET status_carrito='$status', empresa_envio_carrito = '$empresa', guia_envio_carrito= '$rastreo'  WHERE id_carrito ='$idCarrito'";
		}else{
			$sqlUpdatePredido = "UPDATE carrito SET status_carrito='$status', razoncancelado_carrito = '$razon' WHERE id_carrito ='$idCarrito'";
		}
		if ($conex->query($sqlUpdatePredido) === TRUE) {
			echo 1;
			sendMailStatus($nombrecliente,$mail,$masterkey,$razon,$empresa,$rastreo,$status);
		}else{
			echo 2;
		};		
		
	}else{
		echo 2;
	}
?>