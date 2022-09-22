<?php
session_start();
	require('../connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (!$conex) {
		die('No pudo conectarse: ');
	}else{
		if((isset($_GET['idproducto']) AND $_GET['idproducto'] != "" AND isset($_GET['act']) AND $_GET['act']!="")){
			$idproducto = $_GET["idproducto"];
			$user_id = $_SESSION["iduser"];
			$act = $_GET["act"];
			if($act==1){
			$queryupdate= "INSERT INTO favoritos (id_producto_favorito, id_cliente_favorito) VALUES ($idproducto,$user_id)";
			}
			if($act==0){
			$queryupdate= "DELETE FROM favoritos WHERE id_producto_favorito = $idproducto AND id_cliente_favorito = $user_id";
			}
		if ($conex->query($queryupdate) === TRUE) {
			if($act==1){
				echo 1;
			}else{
				echo 4;
			}
			}else{
				if($act==1){
					echo 2;
				}else{
					echo 5;
				}
			}		
		}else{
			if($act==1){
				echo 3;
			}else{
				echo 6;
			}
		}
	}
?>