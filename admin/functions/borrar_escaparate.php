<?php
session_start();
require('../connect/conect_usrer.php');
if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
	header('location:'.SITE.'/admin/entrar');
}
if(isset($_GET['id']) AND $_GET['id'] != ""){
	$id=$_GET['id'];
	$nick="../../img/tiendas/".$_GET['nick'];
	function deleteDirectory($dir) {
		if(!$dh = @opendir($dir)) return;
		while (false !== ($current = readdir($dh))) {
			if($current != '.' && $current != '..') {
				//echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
				if (!@unlink($dir.'/'.$current)) 
					deleteDirectory($dir.'/'.$current);
			}       
		}
		closedir($dh);
		//echo 'Se ha borrado el directorio '.$dir.'<br/>';
		@rmdir($dir);
	}
	
	$update_cliente="DELETE FROM tiendas WHERE id_tienda  = $id";
	if ($conex->query($update_cliente) === TRUE) {
		deleteDirectory($nick);
		echo 1;
	} else {
		$aviso.="Error 13. No se ha borrado el escaparate.";
		echo 2;
	}
}else{
	echo 2;
}
?>