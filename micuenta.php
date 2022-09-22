<?php
	session_start();
	if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {
		header("location:$server./entrar");
	}
	require('connect/conect_usrer.php');
	$email_login=$_SESSION["emailuser"];
//GET DATA
	$sql ="SELECT id_cliente, email_cliente, nombre_cliente, apellidos_cliente, genero_cliente, numero_cliente, cumple_cliente, activo_cliente FROM clientes WHERE email_cliente = '$email_login'  AND activo_cliente = 1";
		$req=mysqli_query($conex, $sql);
		$row_cnt = $req->num_rows;
		while($result = mysqli_fetch_object($req)){
		$id_cliente = $result->id_cliente;
		$email_cliente = $result->email_cliente;
		$nombre_cliente = $result->nombre_cliente;
		$apellidos_cliente = $result->apellidos_cliente;
		$numero_cliente = $result->numero_cliente;
		$cumple_cliente = $result->cumple_cliente;
		$genero_cliente = $result->genero_cliente;
		}
		$h="";
		$m="";
		$o="";
		switch($genero_cliente){
			case "h":
					$h="checked";
				break;
			case "m":
					$m="checked";
				break;
			case "o":
					$o="checked";
				break;
		};
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Mi Cuenta | Ecommerce</title>
<?php include("parts/head.php"); ?>
<script src="<?php echo SITEUSER?>js/bootstrap-show-password.js"></script>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="mis-datos" class="avatar">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-2 col-sm-4" id="left-tab">
					<?php include("parts/leftbar.php");?>
				</div>
				<div class="col-xl-9 col-lg-10 col-sm-8" id="box-info-cuenta">
					<h1>Mi Cuenta</h1>
					<div class="box-direccion-comprador">
						<h4>Nombre:</h4>
						<p><?php echo $nombre_cliente." ".$apellidos_cliente?></p>
						<h3>Teléfono:</h3>
						<p><?php echo $numero_cliente ?></p>
						<div class="editar-direccion">
							<a href="#" data-toggle="collapse" data-target="#nombrebox" aria-expanded="true" aria-controls="user">Editar </a>		
						</div>
						<div id="nombrebox" class="collapse" aria-labelledby="user">
						  <div class="card-body">
							<form accept-charset="UTF-8" method="post" id="datosgenerales">
								<input type="hidden" name="iduser" value="<?php echo $id_cliente?>">
								<div class="form-group">
									<label for="nombre">Nombre (s):</label>
									<input type="text" name="nombre" class="form-control" value="<?php echo $nombre_cliente?>" required>
								</div>
								<div class="form-group">
									<label for="apellidos">Apellidos</label>
									<input type="text" name="apellidos" class="form-control" value="<?php echo $apellidos_cliente?>" required>
								</div>
								<div class="form-group">
									<label for="tel">Teléfono de contacto:</label>
									<input type="tel" name="tel" class="form-control" value="<?php echo $numero_cliente ?>" required>
								</div>
								<div class="form-group">
									<label for="fechaUser">Fecha de nacimiento:</label>
    								<input class="form-control" type="date" value="<?php echo $cumple_cliente ?>" name="fechaUser">
								</div>
								<div class="form-group">
									<label for="sex">Genero</label>
    								<input type="radio" name="sex" id="sex-m" value="m" <?php echo $m?> >
									<label for="sex-m">Mujer</label>
									<input type="radio" name="sex" id="sex-h" value="h" <?php echo $h?> >
									<label for="sex-m">Hombre</label>
									<input type="radio" name="sex" id="sex-o" value="o" <?php echo $o?> >
									<label for="sex-o">Otro</label>
								</div>
								<button type="button" class="btn btn-primary" id="updateNombre" onClick="actualizardatos('1')">Actualizar</button>
							</form>
							 
						  </div>
						</div>						
					</div>
					<div class="box-direccion-comprador">
						<h4>E-mail:</h4>
						<p><?php echo $email_cliente ?></p>
						<div class="editar-direccion">
							<a href="#" data-toggle="collapse" data-target="#emailbox" aria-expanded="true" aria-controls="user">Editar </a>								
						</div>
						<div id="emailbox" class="collapse" aria-labelledby="user">
						  <div class="card-body">
							<form accept-charset="UTF-8" method="post" id="datoemail">
								<div class="form-group">
									<input type="hidden" name="iduser" value="<?php echo $id_cliente?>">
									<label for="email">E-mail</label>
									<input type="email" name="email" class="form-control" value="<?php echo $email_cliente ?>" required>
								</div>
							<button type="button" class="btn btn-primary" id="updateEmail" onClick="actualizardatos('2')">Actualizar</button>
							</form>							 
						  </div>
						</div>	
					</div>
					<div class="box-direccion-comprador">
						<h4>Contraseña:</h4>
						<p>*****</p>
						<div class="editar-direccion">
							<a href="#" data-toggle="collapse" data-target="#passlbox" aria-expanded="true" aria-controls="user">Editar </a>								
						</div>
						<div id="passlbox" class="collapse" aria-labelledby="user">
						  <div class="card-body">
							<form accept-charset="UTF-8" method="post" id="datopass">
								<input type="hidden" name="iduser" value="<?php echo $id_cliente?>">
								<div class="form-group">
									<label for="oldpassword">Contraseña anterior</label>
									<input type="password" name="oldpassword" class="form-control" placeholder="Ingresa tu contraseña anterior" required data-toggle="password">
								</div>
								<div class="form-group">
									<label for="nuevapassword">Nueva contraseña</label>
									<input type="password" name="nuevapassword" class="form-control" id="nuevapassword" placeholder="Nueva contraseña" required data-toggle="password">
								</div>
								<div class="form-group">
									<label for="confpassword">Confirma contraseña</label>
									<input type="password" name="confpassword" class="form-control" id="confpassword" placeholder="Repite tu nueva contraseña" required data-toggle="password">
								</div>
								<button type="button" class="btn btn-primary" id="updatePass" onClick="actualizardatos('3')">Actualizar</button>
							</form>							 
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
	<?php include("parts/footer.php"); ?>
	<script>
		function actualizardatos(act){
			
			switch (act) {
  				case '1':
					var formData = $('#datosgenerales').serializeArray();
					break;
				case '2':
					var formData = $('#datoemail').serializeArray();
					break;
				case '3':
					var formData = $('#datopass').serializeArray();
					var newpass=document.getElementById("nuevapassword").value; 
					var confpassword=document.getElementById("confpassword").value; 
					if(newpass != confpassword){
						newpass.value = "";
						confpassword.value = "";
						alert("La contraseña no coincide.");	
						return true;
					}
					break;
			};
			
			$.ajax({
				type: "POST",
				url: "<?php echo $urlserver.'functions/actualizardatos.php?action='?>"+act,
				data : formData,
				success: function(info) {
					console.log(info);
					if(info==0){
						alert('Por favor verifica tu contraseña anterior.');
					}
					if(info ==1){
						alert('No es posible guardar los cambios en este momento.');
					}
					//location.reload();
				},
				error: function(info) {
					alert(info);
					//location.reload();
				}
			});
		}
	</script>
</body>
</html>
