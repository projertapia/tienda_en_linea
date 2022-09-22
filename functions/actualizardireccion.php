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
		
		
		if(isset($_POST["idcliente"]) AND $_POST["idcliente"] != ""){
			$idcliente = $_POST["idcliente"];
			$iddir = $_POST["iddir"];
			$deldefault="UPDATE direcciones SET default_direccion = 0 WHERE id_cliente_direccion = $idcliente";
			if ($conex->query($deldefault) === TRUE) {
				//echo "ok-default";
			};
			
			$nombre = $_POST["nombre"];
			$tel = $_POST["tel"];
			$calle = $_POST["calle"];
			$numero = $_POST["numero"];
			$estado = $_POST["estado"];
			$municipio = $_POST["municipio"];
			$colonia = $_POST["colonia"];
			$cp = $_POST["cp"];
			$referencia = $_POST["referencia"];
			$default = $_POST['default'];
			echo $queryupdate= "UPDATE direcciones SET nombre_direccion = '$nombre', num_cont_direccion = '$tel', 
			ref_direccion = '$referencia', calle_direccion = '$calle', 
			numero_direccion = '$numero', estado_direccion = '$estado', 
			municipio_direccion = '$municipio', colonia_direccion = '$colonia', 
			cp_direccion = '$cp', default_direccion = '$default'			
			WHERE id_direccion = $iddir AND id_cliente_direccion = $idcliente";
			if ($conex->query($queryupdate) === TRUE) {
				//echo "ok update";
			};
				
			
		}
	}
$conex->close();
?>