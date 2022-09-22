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
		$search='WHERE activo_cliente_publi=0';
		$txtSearch="Ocultos";
	}else{
		$search="WHERE activo_cliente_publi=1";
		$txtSearch="Visibles";
	}
}else{
	$search="WHERE activo_cliente_publi=1";
	$txtSearch="Visibles";
}
$hoy=date_create($datetime_now);
$fechahoy = date_format($hoy, 'Y-m-d\TH:i');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Clientes Publicidad | Ecommerce</title>
<?php include("parts/header.php");?>
<style>
	.blacksc{z-index: 3; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.50); display: none; opacity: 0; position: absolute; top:0; left: 0}
	.blacksc.show{display: block; opacity: 1}
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
			<section id="edit-product">
				<div class="row">
					<div class="col-12 col-sm-5 col-md-6 col-lg-9 p-2">
						<h1 id="titlesection">Clientes Publicidad</h1>
					</div>
					<div class="col-12 col-sm-7 col-md-6 col-lg-3 p-2">
						<form method="get" accept-charset="UTF-8" action="<?php echo SITE.'admin/clientes-publicidad'?>">
							<div class="form-row align-items-center">
								 <div class="col-auto m-2">
									<select name="v" class="form-control">
										<?php if($v=='Ocultos'){?>
										<option value="Ocultos" selected>Desactivados</option>
										<option value="Visibles">Activos</option>
										<?php }else{ ?>
										<option value="Ocultos">Desactivados</option>
										<option value="Visibles" selected>Activos</option>
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
							<form method="post" accept-charset="UTF-8" action="functions/nuevoclienteads.php">
								<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
								<div class="form-group">
									<label for="nombre">Nombre Cliente</label>
									<input type="text" name="nombre_cliente_publi" class="form-control" required>
								</div>								
								<div class="form-group">
									<button type="submit" class="btn btn-success">Guardar</button>
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
										<th scope="col" class="hidden-row">#ID</th>
										<th scope="col">Cliente</th>										
										<th scope="col">N° de publicidad</th>
										<th scope="col">Editar</th>
										<th scope="col">Borrar</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sqlPaq="SELECT * FROM clientes_publi $search ORDER BY id_cliente_publi  DESC";
										$reqPaq=mysqli_query($conex, $sqlPaq);
										while($resulPaq = mysqli_fetch_object($reqPaq)){
											$id_cliente_publi  = $resulPaq->id_cliente_publi  ;
											$nombre_cliente_publi = $resulPaq->nombre_cliente_publi;
											$activo_cliente_publi = $resulPaq->activo_cliente_publi;											
											if($id_cliente_publi ==$idedit){
												$addClass=$classTable;
											}else{
												$addClass="";
											}
											$sql_publicidad="SELECT id_publicidad,cliente_publicidad FROM publicidad WHERE cliente_publicidad = $id_cliente_publi ";
											$result_publicidad = mysqli_query($conex,$sql_publicidad);
											$cantidad_publi = mysqli_num_rows($result_publicidad); 
									?>
									<tr class="<?php echo $addClass?>">
										<td style="vertical-align:middle;" class="hidden-row" align="center"><?php echo $id_cliente_publi ?></td>
										<td style="vertical-align:middle;" align="center"><a href="<?php echo SITE ?>admin/publicidad?s=<?php echo $nombre_cliente_publi?>"><?php echo $nombre_cliente_publi?></a></td>
										<td style="vertical-align:middle;" align="center"><?php echo $cantidad_publi?></td>
										<td><button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#edit-<?php echo $id_cliente_publi ?>">Editar</button></td>										
										<td><button type="button" class="btn btn-danger btn-block" onClick="borrarCliente(<?php echo $id_cliente_publi.",'".$nombre_cliente_publi."'"?>)">Borrar</button></td>
										
									</tr>
									<div class="modal" tabindex="-1" role="dialog" id="edit-<?php echo $id_cliente_publi ?>" data-backdrop="static">
									  <div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title">Editar el cliente: <?php echo $nombre_cliente_publi?></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										  </div>
										  <div class="modal-body">
											<form accept-charset="UTF-8" action="functions/editar-cliente-publi.php" method="post">
												<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
												<input type="hidden" name="idclientepubli" value="<?php echo $id_cliente_publi ?>">
												<div class="form-group">
													<label for="nombre">Nombre cliente</label>
													<input type="text" name="nombre_cliente_publi" class="form-control" required="" value="<?php echo $nombre_cliente_publi?>">
												</div>
												<div class="form-group">
													<label for="activo">Activar</label>
													<select name="activo" class="form-control" required>
														<?php if($activo_cliente_publi==1){
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
												<div class="form-group">
													<button type="submit" class="btn btn-success btn-lg btn-block">Editar cliente publicidad</button>
												</div>
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
								<tfoot>
									<tr><td colspan="5"><small>*Al borrar un cliente borrara toda su publicidad vinculada. <strong>Esta acción no se puede deshacer.</strong></small></td></tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<div class="blacksc"></div>
	<script>
		function borrarCliente(idClient,nameClient){
			$( ".blacksc" ).addClass( "show" );
			var respuesta = confirm("Confirme si desea eliminar el cliente '"+nameClient+"'");
			if(respuesta){			
				$.ajax({
					type: "GET",
					url: "<?php echo SITE.'admin/functions/borrar-cliente.php?id='?>"+idClient,
					success: function(info) {
						if(info == 11 || info == 1 ){
							//console.log(info);
							$( ".blacksc" ).removeClass( "show" );
							location.reload();
						}else if(info == 22){
							alert("Error borrar el cliente.");
							$( ".blacksc" ).removeClass( "show" );
						}else{
							console.log(info);
							$( ".blacksc" ).removeClass( "show" );
						}
					},
					error: function() {
						alert("Error borrar el cliente.");
						location.reload();
					}
				});
			}else{
				$( ".blacksc" ).removeClass( "show" );
			}
		}
	</script>
</body>
</html>