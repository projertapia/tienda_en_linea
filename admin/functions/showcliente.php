<?php
session_start();
	require('../connect/conect_usrer.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
			header('location:'.SITE.'/admin/entrar');
	}
	if(isset($_POST['idadmin']) AND $_POST['idadmin'] != ""){
		$formadmin=$_POST['idadmin'];
		if($id_admin==$formadmin){			
			$idcliente=$_POST['idcliente'];
			$action=$_POST['action'];
			if($action==1){
				$activa=0;
			}else{
				$activa=1;
			}
			$safeData = "UPDATE clientes SET activo_cliente = $activa WHERE id_cliente = $idcliente";
			if ($conex->query($safeData) === TRUE) {
				echo 1;
			}else{
				echo 2;
			}
		}
	}else{
		echo 3;
	}
?>