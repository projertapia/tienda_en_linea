<?php
session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
if(isset($_POST['idadmin']) AND $_POST['idadmin']!="" AND isset($_POST['idclientepubli']) AND $_POST['idclientepubli']!="" AND isset($_POST['nombre_cliente_publi']) AND $_POST['nombre_cliente_publi']!=""){
		$formadmin=$_POST['idadmin'];
		if($id_admin==$formadmin){
			$idclientepubli=$_POST['idclientepubli'];
			$nombre_cliente_publi=$_POST['nombre_cliente_publi'];
			$activo = $_POST['activo'];
			
			$safeData = "UPDATE clientes_publi SET nombre_cliente_publi = '$nombre_cliente_publi', activo_cliente_publi = '$activo' WHERE id_cliente_publi  = $idclientepubli";
			if ($conex->query($safeData) === TRUE) {
				header('location:'.SITE.'admin/clientes-publicidad?mod=true&e='.$e.'&id='.$idclientepubli);
			}else{
				header('location:'.SITE.'admin/clientes-publicidad?mod=false&e='.$e.'&id='.$idclientepubli);
			}
		}else{
			header('location:'.SITE.'admin/clientes-publicidad');
		}
}else{
	header('location:'.SITE.'admin/clientes-publicidad');
}
?>