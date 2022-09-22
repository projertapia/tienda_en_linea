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
		
		
		if(isset($_POST["clavecarrito"]) AND $_POST["clavecarrito"] != ""){
			$clavecarrito = $_POST["clavecarrito"];
			//$prodcuto = array("idprodcuto"=>$_POST["idproducto"]);
			//$Cantidadprodcuto = array("cantidadprodcuto"=>$_POST["cantidadprod"]);
			
			$prodcuto = $_POST['idproducto'];
			$Cantidadprodcuto = $_POST['cantidadprod'];
			$notapedido = $_POST['notapedido'];
			foreach( $prodcuto as $key => $n ) {
			  	//print "ID PRODUCTO ".$n." CANTIDAD DE PRODUCTO".$Cantidadprodcuto[$key].",<BR>";
				echo $queryupdate= "UPDATE carrito SET cantidad_producto_carrito = $Cantidadprodcuto[$key], notas_carrito = '$notapedido' WHERE id_carrito = $n AND clave_carrito = $clavecarrito";
				if ($conex->query($queryupdate) === TRUE) {
					echo "ok-".$n;
				};
				
			}
		}
	}
$conex->close();
?>