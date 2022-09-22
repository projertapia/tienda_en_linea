<?php
	session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (isset($_SESSION['adminuser']) OR !empty ($_SESSION['adminuser'])) {
			header('location:'.SITE.'admin');
		return;
	}
	//LOGIN_USER
$aviso="";
	if(isset($_POST['email']) AND isset($_POST['password'])){
		$email_login = $_POST['email'];
		$pass_login = md5($_POST['password']);
		$sql ="SELECT id_admin, email_admin, pass_admin, activa_admin FROM admin WHERE email_admin = '$email_login' AND pass_admin = '$pass_login' AND activa_admin = 1";
		$req=mysqli_query($conex, $sql);
		$row_cnt = $req->num_rows;
		while($result = mysqli_fetch_object($req)){
		$id_admin = $result->id_admin;
		$email_admin = $result->email_admin;
		}
		if($row_cnt == 1){
			header("location:".SITE."admin");
			//return;
			$_SESSION["idadmin"]=$id_admin;
			$_SESSION["adminuser"]=$email_admin;
			$_SESSION['IsAuthorized']=true;
		}else{
			$aviso="No es posible iniciar sesión, por favor verifica tu usuario o contraseña.";
		}
	}
$sqlContenido="SELECT file_contenido FROM contenido_editable WHERE id_contenido = 3";
$reqContenido=mysqli_query($conex, $sqlContenido);	
while($resulContenido = mysqli_fetch_object($reqContenido)){		
	$file_contenido = $resulContenido->file_contenido;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Bienvenido a Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>mi-escaparate/js/bootstrap-show-password.js"></script>
<style>
	#login-box{background-image:url(<?php echo SITE.'img/'.$file_contenido?>)}
</style>
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
				<div class="col-12">
					<h1 class="title-section">Bienvenido a Ecommerce</h1>
				</div>
				<br>
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-4">
					<div class="bg-white rounded-top tab-head">
						<p class="nav-link active" id="login-tab">Identifícate</a>
					</div>
					<div class="bg-white p-3">   
					  <div class="tab-content mt-4" id="form-registro">
						<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="profile-tab">
						  	<form method="post" action="<?php echo SITE?>admin/entrar?login=false">
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Contraseña" required data-toggle="password">
								</div>
								<div class="form-check">
									<button type="submit" class="btn btn-primary col-12">BIENVENID@</button>
								</div>
							</form>
							<a href="<?php echo SITE?>admin/recuperar" style="text-align: center; display: block; margin: 15px auto">Recuperar contraseña</a>
							<div class="row">
								<div style="margin-top: 15px">
									<p class="text-center"><?php echo $aviso?></p>
								</div>
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
		//VERFICIAMOS EL ESCAPARATE
		function checkname(){
			var escaparte = document.getElementById("escaparate").value;
			if(escaparte.length>3){
				var url = '<?php echo $urlserver.'mi-escaparate/functions/checkname.php?nes='?>'+escaparte;
				$.ajax({                    
					  url: url,
					  success: function(data){
						  if(data >0){
							  document.getElementById("avisonew").innerHTML = "Nombre de escaparate no disponible.";
							  //document.getElementById("escaparate").focus();
							  $( "#escaparate" ).removeClass( "border border-success" );
							  $( "#escaparate" ).addClass( "border border-danger" );
							  document.getElementById("crearcuenta").disabled = true;
							  $( "#avisonew" ).removeClass( "text-success" );
							  $( "#avisonew" ).addClass( "text-danger" );
						  }else{
							   document.getElementById("avisonew").innerHTML = "Nombre de escaparate disponible.";
							  $( "#escaparate" ).removeClass( "border border-danger" );
							  $( "#escaparate" ).addClass( "border border-success" );
							  $( "#avisonew" ).removeClass( "text-danger" );
							  $( "#avisonew" ).addClass( "text-success" );
							  document.getElementById("crearcuenta").disabled = false;
						  }
					  },
						error: function(data){

						}
				});
			}else{
				document.getElementById("avisonew").innerHTML = "Nombre de escaparate no válido.";
				document.getElementById("crearcuenta").disabled = true;
			}
		}
		//VERIFICAMOS EL CORREO
		function checkmail(){
			var emailnew = document.getElementById("emailnew").value
			 var urlmail = '<?php echo $urlserver.'mi-escaparate/functions/checkname.php?nma='?>'+emailnew;
			$.ajax({                    
				  url: urlmail,
				  success: function(mail){
					  console.log(mail);
					  if(mail >0){
						  
						  document.getElementById("avisomail").innerHTML = "Este correo electrónico ya esta ligado a un escaparate.";
						 // document.getElementById("emailnew").focus();
						  $( "#emailnew" ).removeClass( "border border-success" );
						  $( "#emailnew" ).addClass( "border border-danger" );
						  document.getElementById("crearcuenta").disabled = true;
						  $( "#avisomail" ).removeClass( "text-success" );
						  $( "#avisomail" ).addClass( "text-danger" );
					  }else{
						  document.getElementById("avisomail").innerHTML = "Tu correo electrónico es valido.";
						  $( "#emailnew" ).removeClass( "border border-danger" );
						  $( "#emailnew" ).addClass( "border border-success" );
						  $( "#avisomail" ).removeClass( "text-danger" );
						  $( "#avisomail" ).addClass( "text-success" );
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
			}
			}else{
				document.getElementById("avisopass").innerHTML ="Ingresa al menos 6 caracteres.";
				 document.getElementById("crearcuenta").disabled = true;
			}
		}
		function checkbox(){
			if ($('#terminos').prop('checked', true)) {
				 document.getElementById("crearcuenta").disabled = false;
			}else{
				document.getElementById("crearcuenta").disabled = true;
			}
		}
	</script>
</body>
</html>