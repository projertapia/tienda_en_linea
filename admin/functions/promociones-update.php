<?php
	session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_POST['promo-principal']) AND !empty($_POST['promo-principal']) AND isset($_POST['post-rq']) AND !empty($_POST['post-rq'])){
		$id = $_POST['promo-principal'];		
		$pos = $_POST['post-rq'];
		
		$sqlClaveSave = "UPDATE promociones SET lugar_promocion=10 WHERE lugar_promocion='$pos'";
		$conex->query($sqlClaveSave);
		/*UPDATE POST*/
		if($id!='-'){
			$sqlClaveSave = "UPDATE promociones SET lugar_promocion=$pos WHERE id_promocion =$id";
			if ($conex->query($sqlClaveSave) === TRUE) {
				echo "1";
			}else{
				echo "0";
			}
		}else{
			echo "1";
		}
	}
	
	if(isset($_POST['promo-secundaria']) AND !empty($_POST['promo-secundaria']) AND isset($_POST['post-sq']) AND !empty($_POST['post-sq'])){
		$id = $_POST['promo-secundaria'];		
		$pos = $_POST['post-sq'];
		
		$sqlClaveSave = "UPDATE promociones SET lugar_promocion=10 WHERE lugar_promocion='$pos'";
		$conex->query($sqlClaveSave);
		/*UPDATE POST*/
		if($id!='-'){
			$sqlClaveSave = "UPDATE promociones SET lugar_promocion=$pos WHERE id_promocion =$id";
			if ($conex->query($sqlClaveSave) === TRUE) {
				echo "1";
			}else{
				echo "0";
			}
		}else{
			echo "1";
		}
	}
?>