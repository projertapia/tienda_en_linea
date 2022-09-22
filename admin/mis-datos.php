<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
//GET DATA
	$sql ="SELECT id_admin, nombre_admin, email_admin, activa_admin FROM admin WHERE id_admin = '$id_admin'  AND activa_admin = 1";
		$req=mysqli_query($conex, $sql);
		$row_cnt = $req->num_rows;
		while($result = mysqli_fetch_object($req)){
		$id_admin  = $result->id_admin;
		$nombre_admin = $result->nombre_admin;
		$email_admin = $result->email_admin;
		}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mis datos | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>mi-escaparate/js/bootstrap-show-password.js"></script>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light right-content">
				<div class="container">
					<div class="nav justify-content-end w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'admin'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lateralpanel" aria-controls="lateralpanel" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
				</div>
			</nav>
			<section id="info-content">
				<div class="row">
					<div class="col-md-6 offset-md-3 col-sm-12 offset-sm-0">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Mis datos</h5>
							</div>
							<div class="card-body">
								<h4>Nombre:</h4>
								<p><?php echo $nombre_admin ?></p>
								<h3>Correo Electrónico:</h3>
								<p><?php echo $email_admin ?></p>
								<div id="nombrebox" class="collapse" aria-labelledby="user">
								  <div class="card card-body">
									<form accept-charset="UTF-8" method="post" id="datosgenerales">
										<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
										<div class="form-group">
											<label for="nombre">Nombre (s):</label>
											<input type="text" name="nombre" class="form-control" value="<?php echo $nombre_admin?>" required>
										</div>
										<div class="form-group">
											<label for="email">E-mail</label>
											<input type="email" name="email" class="form-control" id="email_admin" value="<?php echo $email_admin ?>" required onfocusout="checkmail()">
											<small id="avisonew"></small>
										</div>
										<button type="button" class="btn btn-primary btn-block" onClick="actualizardatos('1')" id="actualizar">Actualizar</button>
									 </form>
									</div>
								</div>
							</div>
							<div class="card-footer text-muted">
								<a href="#" data-toggle="collapse" data-target="#nombrebox" aria-expanded="true" aria-controls="user" class="btn btn-info btn-block btn-sm">Editar </a>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Mi contraseña</h5>
							</div>
							<div class="card-body">
								<h4>Contraseña:</h4>
								<p>*****</p>
								<div id="passbox" class="collapse" aria-labelledby="user">
								  <div class="card card-body">
									<form accept-charset="UTF-8" method="post" id="datospass">
										<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
										<div class="form-group">
											<label for="oldpassword">Contraseña anterior</label>
											<input type="password" name="oldpassword" class="form-control" placeholder="***" required  data-toggle="password">
										</div>
										<div class="form-group">
											<label for="nuevapassword">Nueva contraseña</label>
											<input type="password" name="nuevapassword" class="form-control" id="nuevapassword" required  data-toggle="password">
										</div>
										<div class="form-group">
											<label for="confpassword">Confirma contraseña</label>
											<input type="password" name="confpassword" class="form-control" id="confpassword" required  data-toggle="password">
										</div>
										<button type="button" class="btn btn-primary btn-block" onClick="actualizardatos('2')" id="actualizar">Cambiar contraseña</button>
									 </form>
									</div>
								</div>
							</div>
							<div class="card-footer text-muted">
								<a href="#" data-toggle="collapse" data-target="#passbox" aria-expanded="true" aria-controls="user" class="btn btn-info btn-block btn-sm">Editar </a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script>
		function actualizardatos(act){
			switch (act) {
				case '1':
				var formData = $('#datosgenerales').serializeArray();
				break;
				case '2':
				var formData = $('#datospass').serializeArray();
				var newpass=document.getElementById("nuevapassword").value; 
				var confpassword=document.getElementById("confpassword").value; 
				if(newpass != confpassword){
					event.preventDefault();
					newpass.value = "";
					confpassword.value = "";
					alert("La contraseña no coincide.");	
					
				}else{
					if(newpass=="" || confpassword=="") {
						event.preventDefault();
						alert("Rellene todos los campos.");	
					}
				}
				break;
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITE.'admin/functions/actualizardatos.php?action='?>"+act,
				data : formData,
				success: function(info) {
					console.log(info);
					if(info==0){
						alert('Por favor verifica tu contraseña anterior.');
					}
					if(info ==1){
						alert('No es posible guardar los cambios en este momento.');
					}
					if(info ==3){
						alert('No es posible guardar los cambios en este momento.');
					}
					if(info =='ok'){
						window.location.replace("<?php echo SITE.'admin/salir'?>");
					}
					//location.reload();
				},
				error: function(info) {
					alert(info);
					//location.reload();
				}
			});
		}
		
		//CHANGE MAIL
		function checkmail(){
			var newadmin = document.getElementById("email_admin").value;

			if(newadmin.length>3){
				var url = '<?php echo $urlserver.'admin/functions/checkmail.php?nma='?>'+newadmin;
				$.ajax({                    
					  url: url,
					  success: function(data){
						  if(data >0){
							  document.getElementById("avisonew").innerHTML = "Correo ya registrado.";
							  //document.getElementById("escaparate").focus();
							  $( "#email_admin").removeClass( "border border-success" );
							  $( "#email_admin").addClass( "border border-danger" );
							  document.getElementById("actualizar").disabled = true;
							  $( "#avisonew").removeClass( "text-success" );
							  $( "#avisonew").addClass( "text-danger" );
						  }else{
							   document.getElementById("avisonew-").innerHTML = "Correo disponible.";
							  $( "#email_admin").removeClass( "border border-danger" );
							  $( "#email_admin").addClass( "border border-success" );
							  $( "#email_admin").removeClass( "text-danger" );
							  $( "#email_admin").addClass( "text-success" );
							  document.getElementById("actualizar").disabled = false;
						  }
					  },
						error: function(data){

						}
				});
			}else{
				document.getElementById("avisonew").innerHTML = "Correo no válido.";
				document.getElementById("actualizar").disabled = true;
			}
		}
	</script>
</body>
</html>