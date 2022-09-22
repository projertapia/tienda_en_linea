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
				$iduser = $_POST["iduser"];
				$nombre = $_POST["nombre"];
				$apellidos = $_POST["apellidos"];
				$tel = $_POST["tel"];
				$fechaUser = $_POST["fechaUser"];
				$sex = $_POST["sex"];
				$deldefault="UPDATE clientes SET nombre_cliente = '$nombre', apellidos_cliente = '$apellidos', numero_cliente = '$tel', cumple_cliente = '$fechaUser', genero_cliente = '$sex' WHERE id_cliente = $iduser";
				if ($conex->query($deldefault) === TRUE) {
					$affected= $conex->affected_rows;	//echo "ok-pass";
					if($affected==0){
						echo '0';
					}
				}else{
					echo "1";
				};
			};			
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "2"){
			if(isset($_POST["email"]) AND $_POST["email"] != ""){
				$iduser = $_POST["iduser"];
				$email = $_POST["email"];
				$deldefault="UPDATE clientes SET email_cliente = '$email' WHERE id_cliente = $iduser";
				if ($conex->query($deldefault) === TRUE) {
					//echo "ok-correo";
					$affected= $conex->affected_rows;	//echo "ok-pass";
					if($affected==0){
						echo '0';
					}else{
						$_SESSION["emailuser"]=$email;
					}
				}else{
					echo "1";
				};
			};
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "3"){
			if(isset($_POST["oldpassword"]) AND $_POST["oldpassword"] != ""){
				$iduser = $_POST["iduser"];
				$oldpassword = md5($_POST["oldpassword"]);
				$nuevapassword = md5($_POST["nuevapassword"]);
				$confpassword = md5($_POST["confpassword"]);
				if($nuevapassword == $confpassword){
					$deldefault="UPDATE clientes SET pass_cliente = '$nuevapassword' WHERE id_cliente = $iduser AND pass_cliente = '$oldpassword'";
					
					if ($conex->query($deldefault) === TRUE) {
							$affected= $conex->affected_rows;	//echo "ok-pass";
							if($affected==0){
								echo '0';
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