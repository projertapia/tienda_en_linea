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
		if(isset($_POST['iddir']) AND $_POST['iddir'] != ""){
			$iddir = $_POST['iddir'];
			$iduser = $_POST['iduser'];
			$delDir ="DELETE FROM direcciones WHERE id_direccion = $iddir AND id_cliente_direccion = $iduser";
			
			if ($conex->query($delDir) === TRUE) {
				echo "Borramos tu dirección éxitosamente.";
			} else {
				echo "Lo sentimos no es posible borrar tu dirección ahora.";
			}
		}
	}
$conex->close();
?>