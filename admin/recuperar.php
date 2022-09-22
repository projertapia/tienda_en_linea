<?php
	session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
	require('connect/conect_usrer.php');
	include('functions/sendmailpass.php');
	include('functions/sendconfmailpass.php');
	$conex->query("SET lc_time_names = 'es_ES';");
		if (isset($_SERVER['HTTPS'])) {
			$http="https://";}else{
			$http="http://";
		}
		$_SERVER['HTTP_HOST'];
		dirname($_SERVER['PHP_SELF']);
		$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";

	if (!$conex) {
		die('No pudo conectarse: ');
	}else{
		date_default_timezone_set('America/Mexico_City');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		setlocale(LC_TIME, 'spanish');
		if (isset($_SESSION['emailuser']) OR $_SESSION['emailuser']!="") {
			 header('Location:'.SITE.'admin');
		}
	}
	$aviso="";
	function rand_char($length) {
	  $random = '';
	  for ($i = 0; $i < $length; $i++) {
		$random .= chr(mt_rand(33, 126));
		$random = md5($random);
	  }
	  return $random;
	}
	//CLAVE
	if(isset($_GET['clave']) AND isset($_GET['clave'])){
		$clave = $_GET['clave'];
		$sqlMail="SELECT clave_temporal, email_admin FROM admin WHERE clave_temporal = '$clave' AND activa_admin = 1 LIMIT 1";
		$reqMail=mysqli_query($conex, $sqlMail);
		$row_cnt = $reqMail->num_rows;
		if($row_cnt ==1){
			while($resultmail = mysqli_fetch_object($reqMail)){
				$email_admin= $resultmail->email_admin;
			}
		$showpass=TRUE;	
		
		}else{
			$showpass=false;	
			$aviso="Lo sentimos el link ya no es valido.";
		}
	}else{
		$showpass=FALSE;	
	}
	//MAIL
	if(isset($_POST['email']) AND $_POST['email'] !=""){
		$mail=$_POST['email'];
		$sqlMail="SELECT email_admin, activa_admin,clave_temporal,id_admin FROM admin WHERE email_admin = '$mail' AND activa_admin = 1 LIMIT 1";
		$reqMail=mysqli_query($conex, $sqlMail);
		$row_cnt = $reqMail->num_rows;
		if($row_cnt ==1){
			$clave = rand_char(10);
			$sqlClaveSave = "UPDATE admin SET clave_temporal='$clave' WHERE email_admin='$mail'";
			if ($conex->query($sqlClaveSave) === TRUE) {
			  sendmailpass($mail,$clave);
				$aviso="Por favor, verifica tu bandeja de entrada o spam.";
			} else {
			  
			}
		}else{
			$aviso="Verifica el correo.";
		}
	}
	//SAVE PASS
	if(isset($_POST['clave']) AND $_POST['clave'] !="" AND isset($_POST['passwordnew']) AND $_POST['passwordnew']!="" ){
		$myclave = $_POST['clave'];
		$pass=$_POST['passwordnew'];
		$newpass=md5($_POST['passwordnew']);
		$repass=md5($_POST['confirmapasswordnew']);
		if($newpass == $repass){
			$sqlClaveSave = "UPDATE admin SET pass_admin='$newpass', clave_temporal = NULL WHERE clave_temporal='$myclave'";
			if ($conex->query($sqlClaveSave) === TRUE) {
				sendmailcf($email_admin,$pass);
			 header('Location:'.SITE.'admin/entrar');
			} else {
			  
			}
		}else{
			$aviso="Por favor verifica tu contraseña";
		}
	}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Recuperar Contraseña | Ecommerce</title>
<?php include("parts/header.php");?>
</head>

<body>
	<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
		<div class="container">
			<div class="navbar-collapse justify-content-between align-items-center w-100" id="collapsingNavbar2">
				<a href="<?php echo SITE.'admin'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
			</div>
		</div>
	</nav>
	<section id="login-box">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-4 offset-lg-4 offset-md-2">
					<?php if($showpass == false){?>
					<div class="bg-white rounded-top tab-head">
					  <ul class="nav nav-tabs" id="registro-login" role="tablist">
						<li class="nav-item" style="width: 100%">
						  <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="form-registro" aria-selected="false">Recuperar contraseña</a>
						</li>
					  </ul>
					</div>
					<div class="bg-white p-3">   
					  <div class="tab-content mt-4" id="form-registro">
						<div class="tab-pane fade show active" id="recuperar" role="tabpanel" aria-labelledby="profile-tab">
						  	<form method="post" action="<?php echo SITE?>admin/recuperar?recuperar=mail">
								<div class="form-group">
									<label for="mail">Ingresa el correo de tu cuenta</label>
									<input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
								</div>
								<div class="form-check">
									<button type="submit" class="btn btn-primary col-12">Recuperar</button>
								</div>
							</form>
						</div>
					  </div>
					</div>
					<?php }else{ ?>
						<div class="bg-white rounded-top tab-head">
							<div class="bg-white p-3">
								<form method="post" action="<?php echo SITE?>admin/recuperar/<?php echo $clave?>">
								<input type="hidden" value="<?php echo $clave?>" name="clave">
								<div class="form-group">
									<input type="password" name="passwordnew" class="form-control" placeholder="Contraseña" required>
								</div>
								<div class="form-group">
									<input type="password" name="confirmapasswordnew" class="form-control" placeholder="Confirma tu contraseña" required>
								</div>
								<div class="form-check">
									<button type="submit" class="btn btn-primary col-12">Cambiar contraseña</button>
								</div>
							</form>
							</div>
						</div>
					<?php }?>
					<div class="row" style="margin-top: 15px;">
						<div class="col-12"><p class="text-center" style="background-color:#fff; border-radius: 5px"><?php echo $aviso?></p></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
		
	</script>
</body>
</html>