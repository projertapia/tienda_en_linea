<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Contenido | Ecommerce</title>
<?php include("parts/header.php");?>
<style>
	.form-control-file{overflow: hidden}
</style>
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
					<div class="col-9 p-2">
						<h1 id="titlesection">Contenido</h1>
					</div>
					<div class="col-3 p-2">
						
					</div>
					<hr>
					<div class="col-12">
						<div class="card-header lista-prodcutos table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col" align="center">Página</th>
										<th scope="col" align="center">Contenido</th>
										<th scope="col" align="center">Fecha de modificación</th>										
										<th scope="col" align="center">Editar</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$SQLPage="SELECT id_page, titulo_page, contenido_page, fecha_modificacion_page FROM contenido_page";
										$reqPage=mysqli_query($conex, $SQLPage);
										while($resulPage = mysqli_fetch_object($reqPage)){
											$id_page = $resulPage->id_page;
											$titulo_page = $resulPage->titulo_page;
											$contenido_page = strip_tags($resulPage->contenido_page);
											$fecha_modificacion_page = $resulPage->fecha_modificacion_page;											
											$fecha_page = date_create($fecha_modificacion_page);
											$fecha_inicio = date_format($fecha_page, 'Y-m-d');
											$hora_inicio = date_format($fecha_page, ' H:i:s');
											$contenido = substr($contenido_page, 0, 140).'...'; // devuelve "d"
									?>
									<tr>
										<td><p><?php echo $titulo_page ?></p></td>
										<td align="left" style="vertical-align:middle;"><p><?php echo $contenido?></p></td>
										<td style="vertical-align:middle;" align="center"><?php HaceCuanto::imprimirTiempo($fecha_inicio,$hora_inicio)?><small class="time"><?php echo $fecha_inicio.' - '.$hora_inicio?></small></td>
										<td style="vertical-align:middle;" align="center"><a href="contenido/editar?id=<?php echo $id_page.'&title='.$titulo_page?>" class="btn btn-success btn-sm">Editar</a></td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-9 p-2">
						<h1 id="titlesection">Guía para crear productos</h1>
					</div>
					<div class="col-3 p-2">
						
					</div>
					<hr>
					<div class="col-12">
						<div class="card-header lista-prodcutos table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col" align="center">Nombre</th>
										<th scope="col" align="center">PDF</th>
										<th scope="col" align="center">Fecha de modificación</th>										
										<th scope="col" align="center">Editar</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sqlContenido="SELECT * FROM contenido_editable
										WHERE id_contenido = 1 AND activo_contenido = 1";
										$reqContenido=mysqli_query($conex, $sqlContenido);	
										while($resulContenido = mysqli_fetch_object($reqContenido)){		
											$nombre_contenido = $resulContenido->nombre_contenido;
											$file_contenido = $resulContenido->file_contenido;
											$fecha_edicion_contenido = $resulContenido->fecha_edicion_contenido;
											$ediciondate= date_create($fecha_edicion_contenido);
											$fecha_contenido=date_format($ediciondate, 'Y-m-d');
											$hora_contenido = date_format($ediciondate, ' H:i:s');
										}
									?>
									<tr>
										<td><p><?php echo $nombre_contenido ?></p></td>
										<td><p><?php echo $file_contenido ?></p><a class="btn btn-sm btn-block" data-toggle="modal" data-target="#verpdf">Ver</a></td>
										<td><p><?php echo HaceCuanto::imprimirTiempo($fecha_contenido,$hora_contenido) ?><small class="time"><?php echo $fecha_contenido.' - '.$hora_contenido?></small></p></td>
										<td style="vertical-align:middle;" align="center"><button class="btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#cambiarpdf">Editar</button></td>
									</tr>
								</tbody>
							</table>
							<div class="modal fade" id="cambiarpdf" tabindex="-1" role="dialog" aria-labelledby="cambiarpdfLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="cambiarpdfLabel">Cambiar PDF creador de productos</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form method="post" accept-charset="UTF-8" enctype="multipart/form-data" id="pdf-form">
										<input type="hidden" name="id" value="1">
										<input type="hidden" name="oldfile" value="<?php echo $file_contenido ?>">
										<div class="form-group">
											<label for="nombre_contenido">Nombre:</label>
											<input type="text" name="nombre_contenido" required class="form-control" value="<?php echo $nombre_contenido ?>">
										</div>
										<div class="form-group">
											<label for="file_contenido">PDF:</label>
											<input type="file" name="file_contenido" required class="form-control-file" accept="application/pdf" id="file_contenido">
										</div>
									</form>
									<div style="clear:both">
										<iframe id="viewer" frameborder="0" scrolling="no" width="100%" height="200"></iframe>
									</div>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									<button type="button" class="btn btn-primary" onClick="actualizardatos()">Guardar cambios</button>
								  </div>
								</div>
							  </div>
							</div>
							<div class="modal fade" id="verpdf" tabindex="-1" role="dialog" aria-labelledby="verpdfLabel" aria-hidden="true">
							  <div class="modal-dialog modal-xl" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="verpdfLabel">PDF Publicado:</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body"><div style="clear:both">
										<embed id="viewer" frameborder="0" scrolling="no" width="100%" height="600" src="<?php echo SITE.'mi-escaparate/pdf/'.$file_contenido?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" >
									</div>									  
								  </div>
								 <div class="modal-footer">
									<a href="<?php echo SITE.'mi-escaparate/pdf/'.$file_contenido?>" class="btn btn-sm btn-success my-3" download="<?php echo $nombre_contenido?>" title="<?php echo $nombre_contenido?>.pdf">Descargar</a>
								 </div>
								</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script type="text/javascript">
		$(document).ready(function () {
			var fileTypes = ['pdf'];  //acceptable file types
			$("input:file").change(function (evt) {
				var parentEl = $(this).parent();
				var tgt = evt.target || window.event.srcElement,files = tgt.files;
				if(this.files[0].size > 2097152){
				   alert("El archivo selecionado excele el limite de 7mb, por favor comprime el archivo.");
				   this.value = "";
				};
				// FileReader support
				if (FileReader && files && files.length) {
					var fr = new FileReader();
					var extension = files[0].name.split('.').pop().toLowerCase(); 
					fr.onload = function (e) {
						success = fileTypes.indexOf(extension) > -1;
						if(success)
							//$(parentEl).append('<img src="' + fr.result + '" class="preview"/>');
							 $('#viewer').attr('src',fr.result);
					}
					fr.onloadend = function(e){
						console.debug("Load End");
					}
					fr.readAsDataURL(files[0]);
				}   
			});
		});
		function actualizardatos(){
			var x = document.forms["pdf-form"]["file_contenido"].value;
			if (x == "") {
				alert("Por favor completa todos los campos.");
				return false;
			}else{
				var formData = new FormData(document.getElementById("pdf-form"));
				var typeinput = 'multipart/form-data';
				var pdata=false;
				var ctype=false;
				var url ="<?php echo SITE.'admin/functions/updatefiles-custom.php'?>";
				$.ajax({
					type: "POST",
					url: url,
					data : formData,
					processData: pdata,
					contentType: ctype,
					cache: false,
					success: function(info) {
						console.log(info);
						if(info==0){
							alert("No se tienen datos.");
						}
						if(info ==1){
							//location.reload();
						}
						if(info ==2){
							alert("Error al subir el archivo");
						}
						location.reload();
					},
					error: function(info) {
						alert(info);
						location.reload();
					}
				});
				return false;
			}
		};
	</script>
</body>
</html>