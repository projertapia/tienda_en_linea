<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['s']) AND $_GET['s'] !=""){
		$s=$_GET['s'];
		$queryWhere="AND (LOWER(p.nombre_publicidad) LIKE LOWER('%$s%') OR LOWER(t.nombre_cliente_publi) LIKE LOWER('%$s%'))";
		$txtTitle="Buscar publicidad: ".$s;
	}else{
		$s="";
		$queryWhere="";
		$txtTitle="Publicidad";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $txtTitle?> | Ecommerce</title>
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
			<section id="info-content">
				<div class="row">
					<div class="col-12 col-sm-5 col-md-9 p-2">
						<h1 id="titlesection"><?php echo $txtTitle?></h1>
					</div>
					<div class="col-12 col-sm-7 col-md-3 p-2">
						<form method="get" accept-charset="UTF-8" action="<?php echo SITE.'admin/publicidad'?>">
							<div class="form-row align-items-center">
								 <div class="col-auto m-2">
									<input type="text" name="s" value="<?php echo $s?>" placeholder="Buscar" class="form-control form-control-sm">
								</div>
								 <div class="col-auto m-2">
								  <button type="submit" class="btn btn-primary">Buscar</button>
								</div>
							</div>
						</form>
					</div>
					<hr>
					<div class="col-12">
						<div class="card-header lista-prodcutos table-responsive">
							<table class="table table-striped" id="productslist">
								<thead>
									<tr>
										<th scope="col">ID</th>
										<th scope="col"><i class="fas fa-image"></i></th>
										<th scope="col">Nombre campaña</th>
										<th scope="col">Cliente</th>
										<th scope="col">Fecha de inicio</th>
										<th scope="col">Fecha de finalizacion</th>
										<th scope="col">Mostrado en</th>
										<th scope="col">Status</th>
										<th scope="col">Precio</th>
										<th scope="col">Ver Reporte</th>
										<th scope="col">Borrar</th>
									</tr>
								</thead>
							<tbody>
						<?php 
							$sqlPubli="SELECT p.id_publicidad, p.nombre_publicidad, p.fecha_inicio_publicidad, p.fecha_fin_publicidad, p.img_sq_a_publicidad, p.cliente_publicidad, p.activo_publicidad, p.show_tienda_publicidad, p.total_precio_publicidad, p.tipo_precio_publicidad, t.id_cliente_publi, t.nombre_cliente_publi, t.activo_cliente_publi FROM publicidad p, clientes_publi t WHERE t.id_cliente_publi = p.cliente_publicidad $queryWhere ORDER BY p.id_publicidad DESC";
							$reqPubli=mysqli_query($conex, $sqlPubli);
							while($resulPubli = mysqli_fetch_object($reqPubli)){
								$id_publicidad  = $resulPubli->id_publicidad;
								$nombre_publicidad  = $resulPubli->nombre_publicidad;
								$fecha_inicio_check  = $resulPubli->fecha_inicio_publicidad;
								$fecha_inicio_publicidad  = date_create($resulPubli->fecha_inicio_publicidad);
								$fecha_fin_publicidad  = date_create($resulPubli->fecha_fin_publicidad);
								$fecha_fin_check  = $resulPubli->fecha_fin_publicidad;
								$img_sq_a_publicidad  = $resulPubli->img_sq_a_publicidad;
								$cliente_publicidad  = $resulPubli->cliente_publicidad;
								$activo_publicidad  = $resulPubli->activo_publicidad;
								$show_tienda_publicidad  = $resulPubli->show_tienda_publicidad;
								$nombre_cliente_publi = $resulPubli->nombre_cliente_publi;
								$fecha_inicio = date_format($fecha_inicio_publicidad, 'Y-m-d');
								$hora_inicio = date_format($fecha_inicio_publicidad, ' H:i:s');
								$fecha_fin = date_format($fecha_fin_publicidad, 'Y-m-d');
								$hora_fin = date_format($fecha_fin_publicidad, ' H:i:s');
								$total_precio_publicidad = $resulPubli->total_precio_publicidad;
								$tipo_precio_publicidad = $resulPubli->tipo_precio_publicidad;
								
								if($show_tienda_publicidad=="" OR $show_tienda_publicidad==NULL OR $show_tienda_publicidad=='NULL'){
									$show_tienda_publicidad="General";
								}
								switch ($activo_publicidad){
									case 1:
										$statuspubli="Activo";
									break;
									case 0:
										$statuspubli="Desactivado";
									break;
								}
								if($fecha_inicio_check<=$datetime_now AND $fecha_fin_check>=$datetime_now){
									$showtime="Plazo activo";
								}else{
									$showtime="Plazo vencido";
								}									
						?>
							<tr>
								<th scope="row" align="center" valign="middle"><?php echo $id_publicidad?></th>
								<th scope="row" align="center" valign="middle"><a href="publicidad/editar?id=<?php echo $id_publicidad?>" title="<?php echo $nombre_publicidad?>"><img src="<?php echo SITE.'img/publicidad/'.$img_sq_a_publicidad?>" width="100px"></a></th>
								<th scope="row" align="center" valign="middle"><a href="publicidad/editar?id=<?php echo $id_publicidad?>" title="<?php echo $nombre_publicidad?>"><?php echo $nombre_publicidad?></a></th>
								<th scope="row" align="center" valign="middle"><?php echo $nombre_cliente_publi?></th>
								<th scope="row" align="center" valign="middle"><?php echo $fecha_inicio?><small class="time"><?php echo $hora_inicio ?></small></th>
								<th scope="row" align="center" valign="middle"><?php echo $fecha_fin?><small class="time"><?php echo $hora_fin ?></small></th>
								<th scope="row" align="center" valign="middle"><?php echo $show_tienda_publicidad?></th>
								<th scope="row" align="center" valign="middle"><?php echo $statuspubli?> <small class="showtime"><?php echo $showtime?></small></th>
								<td scope="row" align="center" valign="middle"><?php echo ucfirst($tipo_precio_publicidad)?><br>$<?php echo $total_precio_publicidad?><small>mxn.</small></td>
								<th scope="row" align="center" valign="middle"><a href="<?php echo SITE.'admin/publicidad/reporte?id='.$id_publicidad?>" class="btn btn-success">Ver Reporte</a></th>
								<th><button type="button" class="btn btn-danger btn-block" onClick="borrarCliente(<?php echo $id_publicidad.",'".$nombre_publicidad." de ".$nombre_cliente_publi."'"?>)">Borrar</button></th>
							</tr>
						<?php }?>								
							</tbody>
						</table>
					</div>	
					</div>
					<div class="clearfix"></div>
				</div>
			</section>
		</div>
	</section>
	<div class="blacksc"></div>
	<script>
		function borrarCliente(idClient,nameClient){
			$( ".blacksc" ).addClass( "show" );
			var respuesta = confirm("Confirme si desea eliminar la publicidad '"+nameClient+"'");
			if(respuesta){			
				$.ajax({
					type: "GET",
					url: "<?php echo SITE.'admin/functions/borrar-publi.php?id='?>"+idClient,
					success: function(info) {
						if(info == 1 ){
							//console.log(info);
							$( ".blacksc" ).removeClass( "show" );
							location.reload();
						}else if(info == 2){
							alert("Error borrar la publicidad.");
							$( ".blacksc" ).removeClass( "show" );
						}else{
							console.log(info);
							$( ".blacksc" ).removeClass( "show" );
						}
					},
					error: function() {
						alert("Error borrar la publicidad.");
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