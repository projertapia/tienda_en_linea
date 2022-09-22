<?php
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
require('connect/conect_usrer.php');
$conex->query("SET lc_time_names = 'es_ES';");
	if (isset($_SERVER['HTTPS'])) {
		$http="https://";}else{
		$http="http://";
	}
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";

	if(isset($_SESSION['page']) AND $_SESSION['page']!="") {		
		$return = $_SESSION['page'];
	}else{
		$return=SITEUSER;
	}
if (!$conex) {
    die('No pudo conectarse: ');
}else{
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_TIME, 'es_MX.UTF-8');
	setlocale(LC_TIME, 'spanish');
	if(isset($_SESSION['emailuser']) AND $_SESSION['emailuser']!="") {
		header("location:".SITEUSER);
	}
}

//LOGIN_USER
$aviso="";
	if(isset($_POST['email']) AND isset($_POST['password'])){
		$email_login = $_POST['email'];
		$pass_login = md5($_POST['password']);
		$sql ="SELECT id_cliente, email_cliente, pass_cliente, activo_cliente FROM clientes WHERE email_cliente = '$email_login' AND pass_cliente = '$pass_login' AND activo_cliente = 1";
		$req=mysqli_query($conex, $sql);
		$row_cnt = $req->num_rows;
		while($result = mysqli_fetch_object($req)){
		$id_cliente = $result->id_cliente;
		$email_cliente = $result->email_cliente;
		}
		if($row_cnt == 1){
			header("location:$return");
			$_SESSION["iduser"]=$id_cliente;
			$_SESSION["emailuser"]=$email_cliente;
		}else{
			$aviso="No es posible iniciar sesión, por favor verifica tu usuario o contraseña.";
		}
	}
//NEW_USER

if(isset($_POST['nombre']) AND isset($_POST['apellidos']) AND isset($_POST['emailnew']) AND isset($_POST['emailnew']) AND ($_POST['passwordnew'] == $_POST['confirmapasswordnew'])){
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$emailnew = $_POST['emailnew'];
	$passwordnew = md5($_POST['passwordnew']);	
	//COMPRUEBL EL USUARIO
	$sql ="SELECT email_cliente FROM clientes WHERE email_cliente = '$emailnew'";
	$req=mysqli_query($conex, $sql);
	$row_cnt = $req->num_rows;
	if($row_cnt==0){
		$newuser="INSERT INTO clientes (nombre_cliente, apellidos_cliente, pass_cliente, email_cliente) VALUES ('$nombre','$apellidos','$passwordnew','$emailnew')";
		if ($conex->query($newuser) === TRUE) {
			header("location:$return");
		} else {
			$aviso="Lo sentimos no es posible crear tu cuenta en este momento.";
		}
	}
}

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Bienvenido | Ecommerce</title>
<?php include("parts/head.php"); ?>
<script src="<?php echo SITEUSER?>js/bootstrap-show-password.js"></script>
</head>

<body>
	<?php include("parts/header.php"); ?>	
	<section id="login-box">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-4">
					<div class="bg-white rounded-top tab-head">
					  <ul class="nav nav-tabs" id="registro-login" role="tablist">
						<li class="nav-item">
						  <a class="nav-link" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="form-registro" aria-selected="true">Regístrate</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="form-registro" aria-selected="false">Identifícate</a>
						</li>
					  </ul>
					</div>
					<div class="bg-white p-3">   
					  <div class="tab-content mt-4" id="form-registro">
						<div class="tab-pane" id="registro" role="tabpanel" aria-labelledby="home-tab">
							<form method="post" action="<?php echo $urlserver?>entrar">
								<div class="form-group">
									<input type="text" name="nombre" class="form-control" placeholder="Nombre(s)" required>
								</div>
								<div class="form-group">
									<input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
								</div>
								<div class="form-group">
									<input type="email" name="emailnew" id="emailnew" class="form-control" placeholder="Correo electrónico" onfocusout="checkmail()" required autocomplete="off">
									<span id="avisomail" class="text-danger"></span>
								</div>
								<div class="form-group">
									<input type="password" name="passwordnew" id="passwordnew" class="form-control" placeholder="Contraseña" required minlength="6" data-toggle="password">
								</div>
								<div class="form-group">
									<input type="password" name="confirmapasswordnew" id="confirmapasswordnew" class="form-control" placeholder="Confirma tu contraseña" required minlength="6" onkeyup="passwordcheck()" data-toggle="password">
									<span id="avisopass"></span>
								</div>
								<div class="form-check">
									<button type="submit" class="btn btn-primary col-12" id="crearcuenta" disabled>Crea tu cuenta en Ecommerce</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="profile-tab">
						  	<form method="post" action="<?php echo $urlserver?>entrar">
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Contraseña" required data-toggle="password">
								</div>
								<!--<div class="form-check">
									<input type="checkbox" class="form-check-input" id="recordarme">
									<label class="form-check-label" for="recordarme">Recordarme</label>
								</div>-->
								<div class="form-check">
									<button type="submit" class="btn btn-primary col-12">Bienvenid@</button>
								</div>
							</form>
							<a href="<?php echo $urlserver?>recuperar" style="text-align: center; display: block; margin: 15px auto">Recuperar contraseña</a>
						</div>
					  </div>
						<p class="text-center"><?php echo $aviso?></p>
					</div>
					<div class="row">
						
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include("parts/footer.php"); ?>
	<script>
		//VERIFICAMOS EL CORREO
		function checkmail(){
			var emailnew = document.getElementById("emailnew").value
			 var urlmail = '<?php echo $urlserver.'functions/checkmail.php?nus='?>'+emailnew;
			$.ajax({                    
				  url: urlmail,
				  success: function(mail){
					  console.log(mail);
					  if(mail >0){
						  
						  document.getElementById("avisomail").innerHTML = "Este correo electrónico ya esta ligado a un usuario.";
						 // document.getElementById("emailnew").focus();
						  $( "#emailnew" ).removeClass( "border border-success" );
						  $( "#emailnew" ).addClass( "border border-danger" );
						  document.getElementById("crearcuenta").disabled = true;
						  $( "#avisomail" ).removeClass( "text-success" );
						  $( "#avisomail" ).addClass( "text-danger" );
					  }else{
						  document.getElementById("avisomail").innerHTML = "Correo electrónico es valido.";
						  $( "#emailnew" ).removeClass( "border border-danger" );
						  $( "#emailnew" ).addClass( "border border-success" );
						  $( "#avisomail" ).removeClass( "text-danger" );
						  $( "#avisomail" ).addClass( "text-success" );
						  document.getElementById("crearcuenta").disabled = false;
					  }
				  },
					error: function(data){
						
					}
				
			});
		}
		//VERIFICAMOS LA CONTRASEÑA
		function passwordcheck(){
			var passwordnew = document.getElementById("passwordnew").value;
			var confirmapasswordnew = document.getElementById("confirmapasswordnew").value;
			if(passwordnew.length>=6){
			if(passwordnew != confirmapasswordnew){
				document.getElementById("avisopass").innerHTML = "Las contraseñas no coinciden.";
				$( "#confirmapasswordnew" ).addClass( "border border-danger" );
				$( "#confirmapasswordnew" ).removeClass( "border border-success" );
				$( "#avisopass" ).addClass( "text-danger" );
				$( "#avisopass" ).removeClass( "text-success" );
				 document.getElementById("crearcuenta").disabled = true;
			}else{
				document.getElementById("avisopass").innerHTML ="";
				$( "#confirmapasswordnew" ).removeClass( "border border-danger" );
				$( "#confirmapasswordnew" ).addClass( "border border-success" );
				document.getElementById("crearcuenta").disabled = false;
			}
			}else{
				document.getElementById("avisopass").innerHTML ="Ingresa al menos 6 caracteres.";
				document.getElementById("crearcuenta").disabled = true;
			}
		}
	</script>
</body>
</html>
