<?php
	session_start();
	if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {
		header("location:$server./entrar");
	}
	require('connect/conect_usrer.php');
	$email_login=$_SESSION["emailuser"];
	$user_id = $_SESSION["iduser"];
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Mis direcciones | Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<section id="mis-datos"  class="avatar">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-2 col-sm-4" id="left-tab">
					<?php include("parts/leftbar.php");?>
				</div>
				<div class="col-xl-9 col-lg-10 col-sm-8" id="box-info-cuenta">
					<h1>Mis Direcciones</h1>
					<div class="row">
						<?php
							$sqlDirecciones="SELECT * FROM direcciones WHERE id_cliente_direccion = $user_id AND activo_direccion=1";
							$reqDirecciones=mysqli_query($conex, $sqlDirecciones);
							$row_cnt = $reqDirecciones->num_rows;
							if($row_cnt !=0){
							while($resultDirecciones = mysqli_fetch_object($reqDirecciones)){
								$id_direccion = $resultDirecciones->id_direccion;
								$nombre_direccion = $resultDirecciones->nombre_direccion;
								$num_cont_direccion = $resultDirecciones->num_cont_direccion;
								$ref_direccion = $resultDirecciones->ref_direccion;
								$calle_direccion = $resultDirecciones->calle_direccion;
								$numero_direccion = $resultDirecciones->numero_direccion;
								$municipio_direccion = $resultDirecciones->municipio_direccion;
								$estado_direccion = $resultDirecciones->estado_direccion;
								$colonia_direccion = $resultDirecciones->colonia_direccion;
								$cp_direccion = $resultDirecciones->cp_direccion;
								$default_direccion = $resultDirecciones->default_direccion;
								$pordefecto="";
								if($default_direccion == 1){
									$pordefecto="| Predeterminada";
								}
						?>
						<div class="col-12 box-direccion-comprador">
							<h4><?php echo $calle_direccion.' '.$numero_direccion?></h4>
							<p><?php echo $calle_direccion?></p>
							<p><?php echo $ref_direccion ?></p>
							<p><?php echo $estado_direccion?> (<?php echo $cp_direccion ?>), <?php echo $municipio_direccion?>, <?php echo $colonia_direccion?></p>
							<p><?php echo $nombre_direccion?> - <?php echo $num_cont_direccion?></p>
							<div class="editar-direccion">
								<a href="#" data-toggle="collapse" data-target="#editarform-<?php echo $id_direccion?>" aria-expanded="true" aria-controls="user">Editar </a>
								|
								<a href="#" onClick="eliminarDir(<?php echo $id_direccion?>)"> Eliminar</a>
								
								<span><?php echo $pordefecto?></span>
							</div>
							<div class="collapse" id="editarform-<?php echo $id_direccion?>">
						  <div class="card card-body">
							<form accept-charset="UTF-8" method="post" class="col-12" id="editar-direccion-<?php echo $id_direccion?>">
									<input type="hidden" name="idcliente" value="<?php echo $user_id?>">
									<input type="hidden" name="iddir" value="<?php echo $id_direccion?>">
									<div class="form-group">
										<label for="nombre">Nombre del receptor:</label>
										<input type="text" name="nombre" class="form-control" placeholder="Nombre de contacto" required value="<?php echo $nombre_direccion?>">
									</div>
									<div class="form-group">
										<label for="nombre">Teléfono de contacto:</label>
										<input type="tel" name="tel" class="form-control" placeholder="Teléfono de contacto" required value="<?php echo $num_cont_direccion?>">
									</div>
									<div class="form-group">
										<label for="nombre">Calle:</label>
										<input type="text" name="calle" class="form-control" placeholder="Calle" required value="<?php echo $calle_direccion?>">
									</div>
									<div class="form-group">
										<label for="nombre">Numero interior, edificio, etc.</label>
										<input type="text" name="numero" class="form-control" placeholder="Numero, interior, edificio, etc." required value="<?php echo $ref_direccion?>">
									</div>
									<div class="form-group">
										<label for="nombre">Estado:</label>
										<select name="estado" class="form-control" required="">
											<option value="<?php echo $estado_direccion?>"><?php echo $estado_direccion?></option>
											<optgroup label="Cambiar de estado">
											<option value="Aguascalientes">Aguascalientes</option>
											<option value="Baja California">Baja California</option>
											<option value="Baja California Sur">Baja California Sur</option>
											<option value="Campeche">Campeche</option>
											<option value="CDMX">CDMX</option>
											<option value="Chiapas">Chiapas</option>
											<option value="Chihuahua">Chihuahua</option>
											<option value="Coahuila">Coahuila</option>
											<option value="Colima">Colima</option>
											<option value="Durango">Durango</option>
											<option value="Edo. De México">Edo. De México</option>
											<option value="Guanajuato">Guanajuato</option>
											<option value="Guerrero">Guerrero</option>
											<option value="Hidalgo">Hidalgo</option>
											<option value="Jalisco">Jalisco</option>
											<option value="Michoacán">Michoacán</option>
											<option value="Morelos">Morelos</option>
											<option value="Nayarit">Nayarit</option>
											<option value="Nuevo León">Nuevo León</option>
											<option value="Oaxaca">Oaxaca</option>
											<option value="Puebla">Puebla</option>
											<option value="Querétaro">Querétaro</option>
											<option value="Quintana Roo">Quintana Roo</option>
											<option value="San Luis Potosí">San Luis Potosí</option>
											<option value="Sinaloa">Sinaloa</option>
											<option value="Sonora">Sonora</option>
											<option value="Tabasco">Tabasco</option>
											<option value="Tamaulipas">Tamaulipas</option>
											<option value="Tlaxcala">Tlaxcala</option>
											<option value="Veracruz">Veracruz</option>
											<option value="Yucatán">Yucatán</option>
											<option value="Zacatecas">Zacatecas</option>
											</optgroup>
										</select>
									</div>
									<div class="form-group">
										<label for="nombre">Municipio:</label>
										<input type="text" name="municipio" class="form-control" placeholder="Municipio" required value="<?php echo $municipio_direccion?>">
									</div>
									<div class="form-group">
										<label for="nombre">Colonia:</label>
										<input type="text" name="colonia" class="form-control" placeholder="Colonia" required value="<?php echo $colonia_direccion?>">
									</div>
									<div class="form-group">
										<label for="nombre">Código Postal:</label>
										<input type="text" name="cp" class="form-control" placeholder="CP" required value="<?php echo $cp_direccion?>">
									</div>
									<div class="form-group">
										<label for="nombre">Referencia del domicilio:</label>
										<input type="text" name="referencia" class="form-control" placeholder="Referencia de domicilio" required value="<?php echo $ref_direccion?>">
									</div>
									<div class="form-check">
										<?php
											if($default_direccion == 1){
												$checked = 'checked';
											}else{
												$checked = '';
											};
										?>
										<input type="checkbox" class="form-check-input" id="default" name="default" value="1" <?php echo $checked?>>
										<label class="form-check-label" for="default">Activar por defecto</label>
									</div>
									<div class="form-group">
										<button type="button" class="btn btn-primary" id="updateDir-<?php echo $id_direccion?>" onClick="updateDir(<?php echo $id_direccion?>)">Actualizar</button>
										<button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#editarform-<?php echo $id_direccion?>">Cancelar</button>
									</div>
							</form>
							</div>
						  </div>
						</div>
						<?php } ?>
								</div>
						<div class="clearfix"></div>
						<a data-toggle="modal" data-target="#nuevadireccion" style="cursor: pointer" id="adddireccion">Agregar dirección</a>
							<?php }else{ ?>
					
					
					<h3>No tienes direcciones.</h3>
					<div class="clearfix"></div>
					<a data-toggle="modal" data-target="#nuevadireccion" style="cursor: pointer" id="adddireccion" >Agregar dirección</a>
					<?php }?>
					</div>
					
				</div>
			</div>
		</div>
		<!--AGREGAR NUEVA DIRECCIÓN-->
		<div class="modal fade" id="nuevadireccion" tabindex="-1" role="dialog" aria-labelledby="nuevadireccionLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="nuevadireccionLabel">Nueva dirección</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form method="post" accept-charset="UTF-8" id="nuevadireccionform">
					<input type="hidden" name="idcliente" value="<?php echo $user_id?>">
					<div class="form-group">
						<input type="text" name="nombre" class="form-control" placeholder="Nombre de contacto" required>
					</div>
					<div class="form-group">
						<input type="tel" name="tel" class="form-control" placeholder="Teléfono de contacto"  required>
					</div>
					<div class="form-group">
						<input type="text" name="calle" class="form-control" placeholder="Calle"  required>
					</div>
					<div class="form-group">
						<input type="text" name="numero" class="form-control" placeholder="Numero, interior, edificio, etc." required>
					</div>
					<div class="form-group">
						<select name="estado" class="form-control" required>
							<option>Estado</option>
							<option value="Aguascalientes">Aguascalientes</option>
							<option value="Baja California">Baja California</option>
							<option value="Baja California Sur">Baja California Sur</option>
							<option value="Campeche">Campeche</option>
							<option value="CDMX">CDMX</option>
							<option value="Chiapas">Chiapas</option>
							<option value="Chihuahua">Chihuahua</option>
							<option value="Coahuila">Coahuila</option>
							<option value="Colima">Colima</option>
							<option value="Durango">Durango</option>
							<option value="Edo. De México">Edo. De México</option>
							<option value="Guanajuato">Guanajuato</option>
							<option value="Guerrero">Guerrero</option>
							<option value="Hidalgo">Hidalgo</option>
							<option value="Jalisco">Jalisco</option>
							<option value="Michoacán">Michoacán</option>
							<option value="Morelos">Morelos</option>
							<option value="Nayarit">Nayarit</option>
							<option value="Nuevo León">Nuevo León</option>
							<option value="Oaxaca">Oaxaca</option>
							<option value="Puebla">Puebla</option>
							<option value="Querétaro">Querétaro</option>
							<option value="Quintana Roo">Quintana Roo</option>
							<option value="San Luis Potosí">San Luis Potosí</option>
							<option value="Sinaloa">Sinaloa</option>
							<option value="Sonora">Sonora</option>
							<option value="Tabasco">Tabasco</option>
							<option value="Tamaulipas">Tamaulipas</option>
							<option value="Tlaxcala">Tlaxcala</option>
							<option value="Veracruz">Veracruz</option>
							<option value="Yucatán">Yucatán</option>
							<option value="Zacatecas">Zacatecas</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="municipio" class="form-control" placeholder="Municipio" required>
					</div>
					<div class="form-group">
						<input type="text" name="colonia" class="form-control" placeholder="Colonia" required>
					</div>
					<div class="form-group">
						<input type="text" name="cp" class="form-control" placeholder="CP" required>
					</div>
					<div class="form-group">
						<input type="text" name="referencia" class="form-control" placeholder="Referencia de domicilio" required>
					</div>
				</form>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" onClick="guardardireccion()">Guardar dirección</button>
			  </div>
			</div>
		  </div>
		</div>
		<!--ELIMINAR DIRECCIÓN-->
		<div class="modal fade" id="deldireccion" tabindex="-1" role="dialog" aria-labelledby="deldireccionLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="deldireccionLabel">¿SEGURO QUE QUIERE ELIMAR ESTA DIRECCIÓN?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="confeliminar">Aceptar</button>
				</div>
				</div>
			</div>
		</div>
	</section>
	<?php include("parts/footer.php"); ?>
	<script>
		function guardardireccion(){
			var formData = $('#nuevadireccionform').serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo $urlserver.'functions/nuevadireccion.php'?>",
				data : formData,
				success: function(info) {
					console.log(info);
					location.reload();
				},
				error: function(info) {
					console.log(info);
					location.reload();
				}
			});
		};
		$('#nuevadireccion').on('hidden.bs.modal', function () {
			document.getElementById("nuevadireccionform").reset();
		});
		function eliminarDir(idDir){
			event.preventDefault();
			$('#confeliminar').attr('onclick','confeliminar('+idDir+')');
			$('#deldireccion').modal('toggle');
		};
		function confeliminar(idDir){
			$.ajax({
				type: "POST",
				data: { iddir: idDir, iduser: <?php echo $user_id?>},
				url: "<?php echo $urlserver.'functions/eliminardireccion.php'?>",
				success: function(info) {
					console.log(info);
					location.reload();
				},
				error: function(info) {
					console.log(info);
					location.reload();
				}
			});
		};
		function updateDir(editdir){
			var formData = $('#editar-direccion-'+editdir).serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo $urlserver.'functions/actualizardireccion.php'?>",
				data : formData,
				success: function(info) {
					console.log(info);
					location.reload();
				},
				error: function(info) {
					console.log(info);
					location.reload();
				}
			});
		}
	</script>
</body>
</html>
