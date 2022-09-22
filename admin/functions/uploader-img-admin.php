<?php
session_start();
require('../connect/conect_usrer.php');
if(isset($_POST['part']) AND $_POST['part']!=""){
	$part = $_POST['part'];
	$folder = $_POST['folder'];
	$contenido=$_FILES['avatar'];
	$post_file_temp=$_FILES['avatar']['tmp_name'];
	$dir="../../img/$folder/";
	$name_file = str_replace(' ', '_', $_FILES['avatar']['name']);
	$post_file=$part.'-'.md5(date("dmYHis")).'-'.$name_file;
	if(isset($_POST['id_tienda']) AND !empty($_POST['id_tienda'])){
		$id_tienda = $_POST['id_tienda'];
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
		if($folder=="publicidad" AND isset($_POST['id_tienda']) AND !empty($_POST['id_tienda'])){
			$safeData = "UPDATE publicidad SET $part = '$post_file' WHERE id_publicidad = $id_tienda";
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