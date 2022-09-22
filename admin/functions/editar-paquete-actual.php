<?php
	session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_POST['idsup']) AND $_POST['idsup']!="" AND isset($_POST['productos']) AND $_POST['productos']!="" AND isset($_POST['fechafin']) AND $_POST['fechafin']!=""){
		$formadmin=$_POST['id_admin'];
		if($id_admin==$formadmin){
			$e=$_POST['e'];
			$cat=$_POST['cat'];
			$idesc = $_POST['idesc'];
			$idsup = $_POST['idsup'];
			$productos= $_POST['productos'];
			$promociones= $_POST['promociones'];
			$porcentaje= $_POST['porcentaje'];
			$fechafin= $_POST['fechafin'];
			$fechafin = str_replace("T", " ", $fechafin).":00";
			//safedate
			$safeData = "UPDATE suscripcion_tiendas SET porcentaje_suscripcion_tiendas = '$porcentaje', cantidad_suscripcion_tiendas = '$productos', cantidad_promos_tiendas = '$promociones', fin_suscripcion = '$fechafin' WHERE id_suscripcion = $idsup";
			if ($conex->query($safeData) === TRUE) {
				header('location:'.SITE.'admin/escaparates/ver?id='.$idesc.'&e='.$e.'&cat='.$cat.'&mod=true');
			}else{
				header('location:'.SITE.'admin/escaparates/ver?id='.$idesc.'&e='.$e.'&cat='.$cat.'&mod=false');
			}
		}else{
			header('location:'.SITE.'admin/escaparates');
		}
	}else{
		header('location:'.SITE.'admin/escaparates');
	}
?>