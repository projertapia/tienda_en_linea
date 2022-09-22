<?php
	session_start();
	require('../connect/conect_usrer.php');
	include("sendconfmailpass.php");
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_POST['action']) AND $_POST['action']!=""){
		$formadmin=$_POST['idactual'];
		if($_POST['action']=='borrar' AND $id_admin==$formadmin){
			$idadmin = $_POST['idadmin'];
			$borrar="DELETE FROM admin WHERE id_admin = $idadmin";
			if ($conex->query($borrar) === TRUE) {
				header('location:'.SITE.'admin/administradores');
			}else{
				header('location:'.SITE.'admin/administradores?mod=false');
			}
		}
	}else{
		if(isset($_POST['idadmin']) AND $_POST['idadmin']!="" AND isset($_POST['nombre_admin']) AND $_POST['nombre_admin']!="" AND isset($_POST['email_admin']) AND $_POST['email_admin']!=""){
			$formadmin=$_POST['idactual'];
			if($id_admin==$formadmin){
				$idadmin = $_POST['idadmin'];
				$nombre_admin= $_POST['nombre_admin'];
				$email_admin= $_POST['email_admin'];
				$activa_admin = $_POST['activa_admin'];	
				if(isset($_POST['pass_admin']) AND $_POST['pass_admin']!=""){
					$pass=$_POST['pass_admin'];
					$pass_admin = md5($_POST['pass_admin']);
					$addpass=",pass_admin = '$pass_admin'";
					sendmailcf($email_admin,$pass);
				}else{
					$addpass="";
				}
				//safedate
				$safeData = "UPDATE admin SET nombre_admin = '$nombre_admin', email_admin = '$email_admin', activa_admin = '$activa_admin' $addpass WHERE id_admin  = $idadmin";
				if ($conex->query($safeData) === TRUE) {
					if(isset($_POST['pass_admin']) AND $_POST['pass_admin']!=""){
						sendmailcf($email_admin,$pass);
						header('location:'.SITE.'admin/administradores?mod=true&id='.$idadmin.'');
					}
					header('location:'.SITE.'admin/administradores?mod=true&id='.$idadmin.'');
				}else{
					header('location:'.SITE.'admin/administradores?mod=false');
				}
			}else{
				header('location:'.SITE.'admin/administradores?error=ea1');

			}
		}else{
			header('location:'.SITE.'admin/administradores?error=ea2');
		}
	}
?>