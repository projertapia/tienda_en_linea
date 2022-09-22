<?php
	session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_POST['influencers-principal']) AND !empty($_POST['influencers-principal']) AND isset($_POST['post-influencers']) AND !empty($_POST['post-influencers'])){
		$id = $_POST['influencers-principal'];		
		$pos = $_POST['post-influencers'];
		$categoria = $_POST['influencers-categoria'];
		$sqlClaveSave = "UPDATE tiendas SET post_home_tienda=0 WHERE post_home_tienda='$pos' AND categoria_tienda = '$categoria'";
		$conex->query($sqlClaveSave);
		/*UPDATE POST*/
		if($id!='-'){
			$sqlClaveSave = "UPDATE tiendas SET post_home_tienda=$pos WHERE id_tienda=$id";
			if ($conex->query($sqlClaveSave) === TRUE) {
				echo "1";
			}else{
				echo "0";
			}
		}else{
			echo "1";
		}
	}
	
	if(isset($_POST['profesionales-principal']) AND !empty($_POST['profesionales-principal']) AND isset($_POST['post-profesionales']) AND !empty($_POST['post-profesionales'])){
		$id = $_POST['profesionales-principal'];		
		$pos = $_POST['post-profesionales'];
		$categoria = $_POST['profesionales-categoria'];
		$sqlClaveSave = "UPDATE tiendas SET post_home_tienda=0 WHERE post_home_tienda='$pos' AND categoria_tienda = '$categoria'";
		$conex->query($sqlClaveSave);
		/*UPDATE POST*/
		if($id!='-'){
			$sqlClaveSave = "UPDATE tiendas SET post_home_tienda=$pos WHERE id_tienda=$id";
			if ($conex->query($sqlClaveSave) === TRUE) {
				echo "1";
			}else{
				echo "0";
			}
		}else{
			echo "1";
		}
	}

	if(isset($_POST['empresas-principal']) AND !empty($_POST['empresas-principal']) AND isset($_POST['post-empresas']) AND !empty($_POST['post-empresas'])){
		$id = $_POST['empresas-principal'];		
		$pos = $_POST['post-empresas'];
		$categoria = $_POST['empresas-categoria'];
		$sqlClaveSave = "UPDATE tiendas SET post_home_tienda=0 WHERE post_home_tienda='$pos' AND categoria_tienda = '$categoria'";
		$conex->query($sqlClaveSave);
		/*UPDATE POST*/
		if($id!='-'){
			$sqlClaveSave = "UPDATE tiendas SET post_home_tienda=$pos WHERE id_tienda=$id";
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