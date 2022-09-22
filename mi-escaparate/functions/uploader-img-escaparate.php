<?php
session_start();
require('../connect/conect_usrer.php');
if(isset($_POST['part']) AND $_POST['part']!=""){
	$part = $_POST['part'];
	$contenido=$_FILES['avatar'];
	$post_file_temp=$_FILES['avatar']['tmp_name'];
	$dir="../../img/tiendas/".NICKTIENDA."/";
	$name_file = str_replace(' ', '_', $_FILES['avatar']['name']);
	$post_file=$part.'-'.md5(date("dmYHis")).'-'.$name_file;
	if(isset($_POST['oldimg']) AND !empty($_POST['oldimg'])){
		$oldimg = $_POST['oldimg'];
		if (file_exists($dir.$oldimg)) {
			unlink($dir.$oldimg);
		}else{
			//echo $oldimg;
		}
	}
	if (move_uploaded_file($post_file_temp,$dir.$post_file)){
		if($part=="cover_tienda" OR $part=="logo_tienda"){
			$safeData = "UPDATE tiendas SET $part = '$post_file' WHERE id_tienda = $id_tienda";
			if ($conex->query($safeData) === TRUE) {
			}else{
				$post_file="";
			}
		}
		echo $post_file;
	}else{
		echo "-";
	}
}else{
	echo "-";
}
?>