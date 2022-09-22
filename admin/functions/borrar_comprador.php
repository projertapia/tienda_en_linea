<?php
session_start();
require('../connect/conect_usrer.php');
if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
	header('location:'.SITE.'/admin/entrar');
}
if(isset($_GET['id']) AND $_GET['id'] != ""){
	$id=$_GET['id'];
	$update_cliente="UPDATE clientes SET activo_cliente = 2 WHERE id_cliente  = $id";
	if ($conex->query($update_cliente) === TRUE) {
		echo 1;
	} else {
		$aviso.="Error 13. No se ha borrado el cliente.";
		echo 2;
	}
}else{
	echo 2;
}
?>