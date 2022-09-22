<?php
session_start();
	require('../connect/conect_usrer.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_POST['id']) AND $_POST['id'] != ""){
		$id=$_POST['id'];
		$oldfile=$_POST['oldfile'];
		$title=$_POST['nombre_contenido'];
		$contenido=$_FILES['file_contenido'];
		$post_file_temp=$_FILES['file_contenido']['tmp_name'];
		if($id==1){
			$dir="../../mi-escaparate/pdf/";
			$post_file="pdf-".$_FILES['file_contenido']['name'];
		}
		if($id==2){
			$dir="../../img/";
			$post_file="bienvenida_escaparates-".$_FILES['file_contenido']['name'];
		}
		if($id==3){
			$dir="../../img/";
			$post_file="bienvenida_admin-".$_FILES['file_contenido']['name'];
		}
		if (file_exists($dir.$post_file)){
			unlink($dir.$post_file);
		}else{
			unlink($dir.$oldfile);
		}
		
			if (move_uploaded_file($post_file_temp,$dir.$post_file)){			
				$safeData = "UPDATE contenido_editable SET nombre_contenido = '$title', file_contenido = '$post_file' WHERE id_contenido  = $id";
				if ($conex->query($safeData) === TRUE) {
					echo 1;
				}else{
					echo 2;
				}
			}else{
				echo 2;
			};
		
	}else{
		echo 0;
	}	
?>