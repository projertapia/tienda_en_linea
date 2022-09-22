<?php
session_start();
require('connect/conect_usrer.php');
if (!empty($_GET['esca'])) {
   $tienda = $_GET['esca'];
   //echo 'Estamos en el subdominio '.$ficha;
	$Onlysite=substr(SITEUSER, strrpos(SITEUSER, '.')+1);
	$site=$http.$Onlysite;
	$sqlStore="SELECT id_tienda, nick_tienda, activa_tienda, categoria_tienda, nivel_de_tienda FROM tiendas WHERE nick_tienda = '$tienda' AND activa_tienda = 1";
	$reqStore=mysqli_query($conex, $sqlStore);
	$row_cnt = $reqStore->num_rows;
	if($row_cnt==1){
		while($resultStore = mysqli_fetch_object($reqStore)){
			$section = $resultStore->categoria_tienda;
		}
		header("location:".$site.$section.'/'.$tienda);
	}else{
		header("location:".$site);	
	}
} else {
	header("location:".$site);
}
?>