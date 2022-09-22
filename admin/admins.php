<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	$idedit="";
	if(isset($_GET['mod']) AND isset($_GET['id']) AND $_GET['mod']!="" AND $_GET['id']!=""){
		$idedit=$_GET['id'];
		if($_GET['mod'] == 'true'){			
			$classTable="table-success";
		}else{			
			$classTable="table-danger";
		}
	}
if(isset($_GET['v']) AND isset($_GET['v'])){
	$v=$_GET['v'];
	if($v=="Ocultos"){
		$search='AND activa_admin=0';
		$txtSearch="Ocultos";
	}else{
		$search="AND activa_admin=1";
		$txtSearch="Visibles";
	}
}else{
	$search="AND activa_admin=1";
	$txtSearch="Visibles";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administradores | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>js/bootstrap-show-password.min.js"></script>
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
					<div class="col-md-12 col-lg-8 p-2">
						<h1 id="titlesection">Administradores</h1>
					</div>
					<div class="col-md-12 col-lg-4 p-2">
						<form method="get" accept-charset="UTF-8" action="<?php echo SITE.'admin/administradores'?>">
							<div class="form-row align-items-center">
								 <div class="col-auto m-2">
									<select name="v" class="form-control">
										<?php if($v=='Ocultos'){?>
										<option value="Ocultos" selected>Ocultos</option>
										<option value="Visibles">Visibles</option>
										<?php }else{ ?>
										<option value="Ocultos">Ocultos</option>
										<option value="Visibles" selected>Visibles</option>
										<?php }?>
									</select>
								</div>
								 <div class="col-auto m-2">
								  <button type="submit" class="btn btn-primary">Buscar</button>
								</div>
							</div>
						</form>
					</div>
					<hr>
					<div class="col-md-4">
						<div class="card-header lista-prodcutos table-responsive">
							<form method="post" accept-charset="UTF-8" action="functions/nuevoadmin.php">
								<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
								<div class="form-group">
									<label for="nombre_admin">Nombre Administardor</label>
									<input type="text" name="nombre_admin" class="form-control" required autocomplete="off">
								</div>
								<div class="form-group">
									<label for="email_admin">Correo electrónico</label>
									<input name="email_admin" id="email_admin" type="email" required class="form-control" onfocusout="checkmail()" placeholder="Correo electrónico" autocomplete="off">
									<hr>
									<small id="avisonew"></small>
								</div>
								<div class="form-group">
									<label for="pass_admin">Contraseña</label>
									<input name="pass_admin" id="pass_admin" data-toggle="password" type="password" required class="form-control" autocomplete="off">
								</div>
								<div class="form-group mb-2">
									<button type="button" class="btn btn-info btn-sm" onclick="resPass()">Generar Contraseña</button>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-success" id="crearcuenta" disabled>Crear Nuevo Administrador</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-8">
						<div class="card-header lista-prodcutos table-responsive">
							<strong><?php echo $txtSearch?></strong>
							<table class="table table-striped" id="productslist">
								<thead>
									<tr align="center">
										<th scope="col">№ Admin</th>
										<th scope="col">Nombre</th>										
										<th scope="col">Correo electrónico</th>
										<th scope="col">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sqlPaq="SELECT id_admin, nombre_admin, email_admin, activa_admin FROM admin WHERE id_admin != $id_admin $search ORDER BY nombre_admin ASC";
										$reqPaq=mysqli_query($conex, $sqlPaq);
										while($resulPaq = mysqli_fetch_object($reqPaq)){
											$idadmin  = $resulPaq->id_admin;
											$nombre_admin = $resulPaq->nombre_admin;
											$email_admin = $resulPaq->email_admin;
											$activa_admin = $resulPaq->activa_admin;
											if($activa_admin==1){
												$txtActiva="Activo";
											}else{
												$txtActiva="Desactivado";
											}
											if($idadmin==$idedit){
												$addClass=$classTable;
											}else{
												$addClass="";
											}
									?>
									<tr data-toggle="modal" data-target="#edit-<?php echo $idadmin?>" class="clic <?php echo $addClass?>">
										<td style="vertical-align:middle;" align="center"><?php echo $idadmin?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $nombre_admin?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $email_admin?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $txtActiva?></td>
									</tr>
									<div class="modal fade" tabindex="-1" role="dialog" id="edit-<?php echo $idadmin?>" data-backdrop="static">
									  <div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title">Editar administrador: <?php echo $nombre_admin?></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										  </div>
										  <div class="modal-body">
											<form accept-charset="UTF-8" action="functions/editar-admin.php" method="post">
												<input type="hidden" name="idadmin" value="<?php echo $idadmin?>">
												<input type="hidden" name="idactual" value="<?php echo $id_admin?>">
												<div class="form-group">
													<label for="nombre_admin">Nombre Administrador</label>
													<input type="text" name="nombre_admin" class="form-control" required="" value="<?php echo $nombre_admin?>">
												</div>
												<div class="form-group">
													<label for="email_admin">Correo Electrónico</label>
													<input name="email_admin" type="email" required="" class="form-control" id="email_admin-<?php echo $idadmin?>" value="<?php echo $email_admin?>" onfocusout="recheckmail(<?php echo $idadmin?>)">
													<hr>
													<small id="avisonew-<?php echo $idadmin?>"></small>
												</div>
												<div class="form-group">
													<label for="activa_admin">Activar</label>
													<select name="activa_admin" class="form-control" required>
														<?php if($activa_admin==1){
														?>
														<option value="0">Desactivado</option>
														<option value="1" selected>Activo</option>
														<?php
														}else{?>
														<option value="0" selected>Desactivado</option>
														<option value="1">Activo</option>
														<?php }?>
													</select>
												</div>
												<hr>
												<div class="form-group">
													<label for="pass_admin">Cambiar contraseña</label>
													<input name="pass_admin" id="resetpass-<?php echo $idadmin?>" type="text" class="form-control">
												</div>
												<div class="form-group mb-2">
													<button type="button" class="btn btn-info btn-sm btn-block" onclick="newpass(<?php echo $idadmin?>)">Generar Contraseña</button>
												</div>
												<hr>
												<div class="form-group">
													<button type="submit" class="btn btn-success btn-lg btn-block" id="editar-<?php echo $idadmin?>">Editar Administrador</button>
												</div>
												<?php if($activa_admin==0){
												?>
												<div class="form-group">
													<button type="submit" class="btn btn-danger btn-lg btn-block" value="borrar" name="action">Borrar</button>
												</div>
												<?php } ?>
											</form>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-secondary btn-sm btn-block" data-dismiss="modal">Cerrar</button>
										  </div>
										</div>
									  </div>
									</div>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script>
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
							  $( "#email_admin" ).removeClass( "border border-success" );
							  $( "#email_admin" ).addClass( "border border-danger" );
							  document.getElementById("crearcuenta").disabled = true;
							  $( "#avisonew" ).removeClass( "text-success" );
							  $( "#avisonew" ).addClass( "text-danger" );
						  }else{
							   document.getElementById("avisonew").innerHTML = "Correo disponible.";
							  $( "#email_admin" ).removeClass( "border border-danger" );
							  $( "#email_admin" ).addClass( "border border-success" );
							  $( "#email_admin" ).removeClass( "text-danger" );
							  $( "#email_admin" ).addClass( "text-success" );
							  document.getElementById("crearcuenta").disabled = false;
						  }
					  },
						error: function(data){

						}
				});
			}else{
				document.getElementById("avisonew").innerHTML = "Correo no válido.";
				document.getElementById("crearcuenta").disabled = true;
			}
		}
		//EDITOR
		function recheckmail(idUser){
			var newadmin = document.getElementById("email_admin-"+idUser).value;

			if(newadmin.length>3){
				var url = '<?php echo $urlserver.'admin/functions/checkmail.php?nma='?>'+newadmin;
				$.ajax({                    
					  url: url,
					  success: function(data){
						  if(data >0){
							  document.getElementById("avisonew-"+idUser).innerHTML = "Correo ya registrado.";
							  //document.getElementById("escaparate").focus();
							  $( "#email_admin-"+idUser ).removeClass( "border border-success" );
							  $( "#email_admin-"+idUser ).addClass( "border border-danger" );
							  document.getElementById("crearcuenta").disabled = true;
							  $( "#avisonew-"+idUser ).removeClass( "text-success" );
							  $( "#avisonew-"+idUser ).addClass( "text-danger" );
						  }else{
							   document.getElementById("avisonew-"+idUser).innerHTML = "Correo disponible.";
							  $( "#email_admin-"+idUser ).removeClass( "border border-danger" );
							  $( "#email_admin-"+idUser ).addClass( "border border-success" );
							  $( "#email_admin-"+idUser ).removeClass( "text-danger" );
							  $( "#email_admin-"+idUser ).addClass( "text-success" );
							  document.getElementById("editar-"+idUser).disabled = false;
						  }
					  },
						error: function(data){

						}
				});
			}else{
				document.getElementById("avisonew-"+idUser ).innerHTML = "Correo no válido.";
				document.getElementById("editar-"+idUser ).disabled = true;
			}
		}
		//EDITOR
		function resPass(){
			var length = 8,
			charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
			retVal = "";
			for (var i = 0, n = charset.length; i < length; ++i) {
				retVal += charset.charAt(Math.floor(Math.random() * n));
			}
			document.getElementById("pass_admin").value = retVal;
			document.getElementById("showpass").value = retVal;
		}
		function newpass(idusr){
			var length = 8,
			charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
			retVal = "";
			for (var i = 0, n = charset.length; i < length; ++i) {
				retVal += charset.charAt(Math.floor(Math.random() * n));
			}
			document.getElementById("resetpass-"+idusr).value = retVal;
		}
	</script>
</body>
</html>