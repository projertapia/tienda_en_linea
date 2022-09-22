<?php
session_start();
require('../connect/conect_usrer.php');
if(isset($_POST['part']) AND $_POST['part']!=""){
	$part = $_POST['part'];
	$type = $_POST['tipo'];
	$contenido=$_FILES['avatar'];
	$post_file_temp=$_FILES['avatar']['tmp_name'];
	$dir="../../img/";
	$name_file = str_replace(' ', '_', $_FILES['avatar']['name']);
	$post_file=$part.'-'.md5(date("dmYHis")).'-'.$name_file;
	if(isset($_POST['id_post']) AND !empty($_POST['id_post'])){
		$id_post = $_POST['id_post'];
	}
	if(isset($_POST['oldimg']) AND !empty($_POST['oldimg'])){
		$oldimg = $_POST['oldimg'];
		if (file_exists($dir.$oldimg)) {
			unlink($dir.$oldimg);
		}else{
			//echo $oldimg;
		}
	}
	if (move_uploaded_file($post_file_temp,$dir.$post_file)){
			if($type == "banners"){
				$safeData = "UPDATE site_banner SET img_banner = '$post_file' WHERE id_banner = $id_post";
				if ($conex->query($safeData) === TRUE) {
				}else{
					$post_file="";
				}
			}
			if($type == "bienvenida"){
				$safeData = "UPDATE contenido_editable SET file_contenido = '$post_file' WHERE id_contenido  = $id_post";
				if ($conex->query($safeData) === TRUE) {
				}else{
					$post_file="";
				}
			}
		}
		echo $post_file;
}else{
	echo "-";
}
?>