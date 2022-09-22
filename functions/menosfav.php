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
		if((isset($_GET['idproducto']) AND $_GET['idproducto'] != "")){
			$idproducto = $_GET["idproducto"];
			$user_id = $_SESSION["iduser"];
			$queryupdate= "DELETE FROM favoritos WHERE id_producto_favorito = $idproducto AND id_cliente_favorito = $user_id";
			if ($conex->query($queryupdate) === TRUE) {
				echo 1;
			}else{
				echo 2;
			}		
		}else{
			echo 3;
		}
	}
?>