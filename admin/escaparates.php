<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['s']) AND $_GET['s']!=""){
		$s=$_GET['s'];
		
		$queryWhere="WHERE LOWER(t.nick_tienda) LIKE LOWER('%$s%') OR LOWER(t.nombre_tienda) LIKE LOWER('%$s%')";
		$txtTitle="Busqueda de: ".$s;
	}else{
		$s="";
		$queryWhere="";
		$txtTitle="Escaparates";
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
					<div class="col-12 col-sm-5 col-md-6 p-2">
						<h1 id="titlesection"><?php echo $txtTitle?></h1>
					</div>
					<div class="col-12 col-sm-7 col-md-6 p-2">
						<form method="get" accept-charset="UTF-8" action="<?php echo SITE.'admin/escaparates'?>">
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
										<th scope="col" align="center">№<br>Escaparate</th>
										<th scope="col" align="center"><i class="fas fa-image"></i></th>
										<th scope="col" align="center">Nombre Escaparate</th>										
										<th scope="col" align="center">Miembro desde</th>
										<th scope="col" align="center">№ Productos</th>
										<th scope="col" align="center">Total de Ventas</th>
										<th scope="col" align="center">Plan contratado</th>
										<th scope="col" align="center">Status</th>
										<th scope="col" align="center">Ver Reporte</th>
										<th scope="col" align="center">Visitar Escaparate</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$SQLreport="SELECT t.id_tienda, t.nombre_tienda, t.nick_tienda, t.categoria_tienda, t.logo_tienda, t.fecha_crea_tienda, t.nivel_de_tienda, t.activa_tienda FROM tiendas t $queryWhere";
										$totalmes=0;
										$totalcomision=0;
										$reqReport=mysqli_query($conex, $SQLreport);
										while($resulReport = mysqli_fetch_object($reqReport)){
											$id_tienda = $resulReport->id_tienda;
											$nombre_tienda = $resulReport->nombre_tienda;
											$nick_tienda = $resulReport->nick_tienda;
											$categoria_tienda = $resulReport->categoria_tienda;
											$logo_tienda = $resulReport->logo_tienda;
											$fecha_tienda = $resulReport->fecha_crea_tienda;
											$nivel_de_tienda = $resulReport->nivel_de_tienda;
											$fecha_crea_tienda = date_create($fecha_tienda);
											$fecha_inicio = date_format($fecha_crea_tienda, 'Y-m-d');
											$hora_inicio = date_format($fecha_crea_tienda, ' H:i:s');
											$activa_tienda = $resulReport->activa_tienda;
											if($activa_tienda=="1"){
												$status="Activo";
											}else{
												$status="Desactivado";
											}
											//PRODUCTS
											$SQLproducts="SELECT p.id_producto, p.nombre_producto FROM productos p WHERE id_tienda_producto=$id_tienda";
											$reqproducts=mysqli_query($conex, $SQLproducts);
											$total_products=$reqproducts->num_rows;
											//SALES
											$SQLventas="SELECT c.id_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.status_carrito FROM carrito c WHERE c.id_vendedor_carrito=$id_tienda AND (c.status_carrito = 1 OR c.status_carrito=2)";
											$reqventas=mysqli_query($conex, $SQLventas);
											$total_ventas=0;
											while($resulventas = mysqli_fetch_object($reqventas)){
												$cantidad_producto_carrito = $resulventas->cantidad_producto_carrito;
												$total_ventas = $total_ventas + $cantidad_producto_carrito;
											}
											//PLAN CONTRATADO
											if($nivel_de_tienda != 1 AND $nivel_de_tienda != "" AND $nivel_de_tienda != NULL){
												$sqlLimit="SELECT s.id_suscripcion, s.id_tienda_suscripcion, s.tipo_suscripcion, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, t.id_tipo_tienda, t.nombre_tipo_tienda
												FROM suscripcion_tiendas s, tipos_tienda t WHERE s.id_tienda_suscripcion = $id_tienda AND s.id_suscripcion = $nivel_de_tienda AND t.id_tipo_tienda = s.tipo_suscripcion";
												echo "<br>";
												$reqLimit=mysqli_query($conex, $sqlLimit);
												$LimitPlan_rows = mysqli_num_rows($reqLimit);
												if($LimitPlan_rows !=0){
													while($resultLimit = mysqli_fetch_object($reqLimit)){
														$cantidad_show = $resultLimit->cantidad_suscripcion_tiendas;
														$checkinicio = $resultLimit->inicio_suscripcion;
														$checkfin = $resultLimit->fin_suscripcion;
														$nombre_tipo_tienda = $resultLimit->nombre_tipo_tienda;
													}
												}else{
													$checkinicio='0000-00-00 00:00:00';
													$checkfin='0000-00-00 00:00:00';
												}
												$fecha_hoy=date('Y-m-d G:i:s');
												if(($checkinicio <= $fecha_hoy AND $checkfin >= $fecha_hoy) OR $LimitPlan_rows != 0){
													$txtFin="Vence el: ".$checkfin;
												}else{
													$nombre_tipo_tienda="Gratuito";
													$txtFin="";
												}
											}else{
												$nombre_tipo_tienda="Gratuito";
												$txtFin="";
											}
									?>
									<tr>
										<td height="80px" style="vertical-align:middle;" align="center"><?php echo $id_tienda?></td>
										<td><img src="<?php echo SITE?>img/tiendas/<?php echo $nick_tienda.'/'.$logo_tienda?>" width="90px" class="img-fluid" onerror="this.src='<?php echo SITE.'img/prev_logo.jpg'?>';"></td>
										<td align="left" style="max-width:400px; vertical-align:middle;"><a href="escaparates/ver?id=<?php echo $id_tienda.'&e='.$nick_tienda.'&cat='.$categoria_tienda?>"><?php echo $nombre_tienda.' - '.$nick_tienda?></a></td>
										<td style="vertical-align:middle;" align="center"><?php HaceCuanto::imprimirTiempo($fecha_inicio,$hora_inicio)?><small class="time"><?php echo $fecha_inicio.' - '.$hora_inicio?></small></td>
										<td style="vertical-align:middle;" align="center"><?php echo $total_products?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $total_ventas?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $nombre_tipo_tienda?><small class="time"><?php echo $txtFin?></small></td>
										<td style="vertical-align:middle;" align="center">
											<?php echo $status?>
											<?php if($total_products==0 AND $total_ventas==0){?>
											<button type="button" class="btn btn-danger btn-sm" onClick="borrarEscaparate(<?php echo $id_tienda.",'".$nick_tienda?>')">Borrar</button>
											<?php }?>
											
										</td>
										<td align="center" style="vertical-align:middle;"><a href="<?php echo SITE?>admin/escaparates/reportes?id=<?php echo $id_tienda.'&escaparate='.$nick_tienda.'&cat='.$categoria_tienda?>" class="btn btn-success btn-sm">Ver Reporte</a></td>
										<td align="center" style="vertical-align:middle;"><a href="<?php echo SITE.$categoria_tienda.'/'.$nick_tienda?>" target="_blank" class="btn btn-secondary btn-sm">Visitar</a></td>
									</tr>
									<?php }?>
								</tbody>
								<tfoot>
									<tr><td colspan="10"><small>*Solo los escaparates sin productos y sin ventas se pueden eliminar. <strong>Esta operación no se puede deshacer.</strong></small></td></tr>
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
		function borrarEscaparate(id,name){
			$( ".blacksc" ).addClass( "show" );
			var respuesta = confirm("Confirme si desea eliminar el escaparate '"+name+"'");
			if(respuesta){			
				$.ajax({
					type: "GET",
					url: "<?php echo SITE.'admin/functions/borrar_escaparate.php?id='?>"+id+"&nick="+name,
					success: function(info) {
						if(info == 1 ){
							//console.log(info);
							$( ".blacksc" ).removeClass( "show" );
							location.reload();
						}else if(info == 2){
							alert("Error borrar el escaparate.");
							$( ".blacksc" ).removeClass( "show" );
						}else{
							console.log(info);
							$( ".blacksc" ).removeClass( "show" );
						}
					},
					error: function() {
						alert("Error borrar el escaparate.");
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