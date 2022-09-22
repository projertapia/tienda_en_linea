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
		if(isset($_GET["action"]) AND $_GET["action"] == "1"){
			if(isset($_POST["nombre"]) AND $_POST["nombre"] != ""){
				$idadmin = $_POST["idadmin"];
				$nombre = $_POST["nombre"];
				$email = $_POST["email"];
				$deldefault="UPDATE admin SET nombre_admin = '$nombre', email_admin = '$email' WHERE id_admin  = $idadmin";
				if ($conex->query($deldefault) === TRUE) {
					$affected= $conex->affected_rows;	//echo "ok-pass";
					if($affected==0){
						echo '3';
					}else{
						echo'ok';
					}
				}else{
					echo "1";
				};
			};			
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "2"){
			if(isset($_POST["oldpassword"]) AND $_POST["oldpassword"] != ""){
				$idadmin = $_POST["idadmin"];
				$oldpassword = md5($_POST["oldpassword"]);
				$nuevapassword = md5($_POST["nuevapassword"]);
				$confpassword = md5($_POST["confpassword"]);
				if($nuevapassword == $confpassword){
					$deldefault="UPDATE admin SET pass_admin = '$nuevapassword' WHERE id_admin  = $idadmin AND pass_admin = '$oldpassword'";
					if ($conex->query($deldefault) === TRUE) {
							$affected= $conex->affected_rows;	//echo "ok-pass";
							if($affected==0){
								echo '0';
							}else{
								echo'ok';
							}
					}else{
						echo '0';
					};
				}
			};
		};
	}
$conex->close();
?>