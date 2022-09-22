<?php
	session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
		header('location:'.SITE.'/mi-escaparate/entrar');
	}
	$aviso="";
	if((isset($_POST['id']) AND $_POST['id'] != "") AND (isset($_POST['key']) AND $_POST['key'] == $_SESSION["key"])){
		$id_promo=$_POST['id'];
		$img=$_POST['img'];
		$dir="../../img/tiendas/".NICKTIENDA."/";
		if (file_exists($dir.$img)) {
			unlink($dir.$img);
		}else{
			//echo $oldimg;
		}
		
		$safeData = "DELETE FROM promociones WHERE id_promocion = $id_promo";
		if ($conex->query($safeData) === TRUE) {			
			echo 1;
		} else {
			echo 2;
		}
	}else{
		echo 3;
	}
	$_SESSION["key"]="";
	unset($_SESSION["key"]);
?>