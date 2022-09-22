<?php
	session_start();
	require('../connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (!$conex) {
		die('No pudo conectarse: ');
	}else{
		date_default_timezone_set('America/Mexico_City');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		setlocale(LC_TIME, 'spanish');
	
		if((isset($_GET['idCarrito']) AND $_GET['idCarrito'] != "") AND (isset($_GET['clavecarrito']) AND $_GET['clavecarrito'] != "") ){
			$idCarrito = $_GET["idCarrito"];
			$clavecarrito = $_GET["clavecarrito"];
			$queryupdate= "DELETE FROM carrito WHERE id_carrito = $idCarrito AND clave_carrito = $clavecarrito";
			if ($conex->query($queryupdate) === TRUE) {
				echo 1;
			}else{
				echo 2;
				//echo $conex -> error;
			}		
		}else{
			echo 3;
		}
	}
?>