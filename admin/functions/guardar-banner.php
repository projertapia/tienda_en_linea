<?php
session_start();
	require('../connect/conect_usrer.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
			header('location:'.SITE.'/admin/entrar');
	}
	//SAFE DATA
	if(isset($_GET['id']) AND $_GET['id'] == "1"){
		$id_banner=$_GET['id'];		
		$target=$_POST['target_img_homebanner'];		
		$link=$_POST['link_img_homebanner'];
		$img = $_POST['txt-img_homebanner'];
	}
	if(isset($_GET['id']) AND $_GET['id'] == "2"){
		$id_banner=$_GET['id'];		
		$target=$_POST['target_img_footerbanner'];
		$link=$_POST['link_img_footerbanner'];
		$img = $_POST['txt-img_footerbanner'];
	}

	if(isset($_GET['id']) AND $_GET['id'] == "3"){
		$id_banner=$_GET['id'];		
		$target=$_POST['target_img_intbanner'];
		$link=$_POST['link_img_intbanner'];
		$img = $_POST['txt-img_intbanner'];
	}
	if(isset($_GET['id']) AND $_GET['id']!=""){
		$idbanner=$_GET['id'];
		$safeData = "UPDATE site_banner SET url_banner = '$link', target_banner ='$target', img_banner= '$img' WHERE id_banner = $idbanner ";
		if ($conex->query($safeData) === TRUE) {
		  header('location:'.SITE.'/admin/banners?mod=true');
		} else {
			$aviso="Error 14. La imagen no se ha guardado.";
		  header('location:'.SITE.'/admin/banners?mod=false');
		}
	}else{
		echo 'notimg';
	}
	header('location:'.SITE.'/admin/banners');
?>