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
		if(isset($_POST['idcliente']) AND $_POST['idcliente'] != ""){
			$idcliente = $_POST['idcliente'];
			$nombre = $_POST['nombre'];
			$tel = $_POST['tel'];
			$calle = $_POST['calle'];
			$numero = $_POST['numero'];
			$referencia = $_POST['referencia'];
			$estado = $_POST['estado'];
			$municipio = $_POST['municipio'];
			$colonia = $_POST['colonia'];
			$CP = $_POST['cp'];
			
			echo $nuevadir="INSERT INTO direcciones (id_cliente_direccion, nombre_direccion, num_cont_direccion, ref_direccion, calle_direccion, numero_direccion, estado_direccion, municipio_direccion, colonia_direccion, cp_direccion) VALUES
			('$idcliente','$nombre','$tel','$referencia','$calle','$numero','$estado','$municipio','$colonia','$CP')";
			if ($conex->query($nuevadir) === TRUE) {
				
			} else {
				echo "Lo sentimos no es posible guardar tu dirección ahora.";
			}
		}
	}
$conex->close();
?>