<?php
session_start();
require('../connect/conect_usrer.php');
include("sendmailnewadmin.php");
if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
	header('location:'.SITE.'admin/entrar');
}
if(isset($_POST['nombre_admin']) AND $_POST['nombre_admin'] != "" AND isset($_POST['email_admin']) AND $_POST['email_admin'] != "" AND isset($_POST['pass_admin']) AND $_POST['pass_admin'] != ""){
	$nombre_admin = $_POST['nombre_admin'];
	$email_admin = $_POST['email_admin'];
	$pass_admin = $_POST['pass_admin'];
	$pass =md5($pass_admin);
	$NuevoAdmin="INSERT INTO admin (nombre_admin, email_admin, pass_admin) VALUES ('$nombre_admin','$email_admin', '$pass')";
	if ($conex->query($NuevoAdmin) === TRUE) {
		$newid=$mysqli->insert_id;
		if($newid!="" AND $newid != false){
			sendmailna($email_admin,$pass);
			header('location:'.SITE.'admin/administradores?mod=true&id='.$newid.'');
		}else{
			header('location:'.SITE.'admin/administradores?mod=false');
		}
	}else{
		header('location:'.SITE.'admin/administradores?mod=false');
	}
}else{
	header('location:'.SITE.'admin/administradores');
}
?>