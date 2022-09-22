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
	
		if(isset($_GET['idpromo']) AND $_GET['idpromo'] != ""){
			$idpromo = $_GET["idpromo"];
			$queryupdate= "UPDATE promociones SET clicks_promocion = clicks_promocion + 1 WHERE id_promocion = $idpromo";
			if ($conex->query($queryupdate) === TRUE) {
				
			}		
		}
	}
?>