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
if(isset($_GET['v']) AND $_GET['v']!=""){
	$v=$_GET['v'];
	if($v=="Ocultos"){
		$search='WHERE activo_cliente=0';
		$txtSearch="Desactivados";
	}else{
		$search="WHERE activo_cliente=1";
		$txtSearch="Activos";
	}
}else{
	$search="WHERE activo_cliente=1";
	$txtSearch="Activos";
}
if(isset($_GET['s']) AND $_GET['s']!=""){
	$s=$_GET['s'];
	$search.=" AND LOWER(nombre_cliente) LIKE LOWER('%$s%') OR LOWER(apellidos_cliente) LIKE LOWER('%$s%') OR LOWER(email_cliente) LIKE LOWER('%$s%')";
	$txtSearch .=', con la busqueda: '.$s;
}else{
	$s="";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Clientes | Ecommerce</title>
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
					<div class="col-12 col-sm-6 col-md-5 col-xl-6 p-2">
						<h1 id="titlesection">Clientes</h1>
					</div>
					<div class="col-12 col-sm-6 col-md-7 col-xl-6 p-2">
						<form method="get" accept-charset="UTF-8" action="<?php echo SITE.'admin/clientes'?>">
							<div class="form-row align-items-center">
								<div class="col-auto my-1">
									<input type="text" name="s" class="form-control" placeholder="Buscar:" value="<?php echo $s?>">
								</div>
								 <div class="col-auto my-1">
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
								 <div class="col-auto my-1">
								  <button type="submit" class="btn btn-primary">Buscar</button>
								</div>
							</div>
						</form>
					</div>
					<hr>
					<div class="col-md-12">
						<div class="card-header lista-prodcutos table-responsive">
							<strong><?php echo $txtSearch?></strong>
							<table class="table table-striped" id="productslist">
								<thead>
									<tr align="center">
										<th scope="col">№ Cliente</th>
										<th scope="col">Nombre</th>
										<th scope="col">Genero</th>
										<th scope="col">Correo electrónico</th>
										<th scope="col">Número telefónico</th>
										<th  scope="col">Pedidos</th>
										<th  scope="col">Miembro desde</th>
										<th  scope="col">Cumpleaños</th>
										<th scope="col">Status</th>
										<th scope="col">Borrar</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sqlPaq="SELECT id_cliente, nombre_cliente, apellidos_cliente, genero_cliente, numero_cliente, email_cliente, activo_cliente, cumple_cliente, registro_cliente FROM clientes $search ORDER BY nombre_cliente ASC";
										$reqPaq=mysqli_query($conex, $sqlPaq);
										while($resulPaq = mysqli_fetch_object($reqPaq)){
											$idcliente  = $resulPaq->id_cliente ;
											$nombre_cliente = $resulPaq->nombre_cliente;
											$apellidos_cliente = $resulPaq->apellidos_cliente;
											$genero_cliente = $resulPaq->genero_cliente;
											$email_cliente = $resulPaq->email_cliente;
											$activo_cliente = $resulPaq->activo_cliente;
											$registro_cliente = $resulPaq->registro_cliente;
											$cumple_cliente = $resulPaq->cumple_cliente;
											$numero_cliente = $resulPaq->numero_cliente;
											$cumple=date_create($cumple_cliente);
											$cumple = date_format($cumple, 'd-m-Y');
											$fecha_crea_tienda = date_create($registro_cliente);
											$fecha_reg = date_format($fecha_crea_tienda, 'Y-m-d');
											$hora_reg = date_format($fecha_crea_tienda, ' H:i:s');
											
											if($activo_cliente==1){
												$txtActiva="Activo";
											}else{
												$txtActiva="Desactivado";
											}
											if($idcliente==$idedit){
												$addClass=$classTable;
											}else{
												$addClass="";
											}
											if($genero_cliente=='h'){
												$genero="Hombre";
											}else if($genero_cliente=='m'){
												$genero="Mujer";
											}else{
												$genero="No definido";
											}
											//SEARCH PEDIDOS
											$sqlPed="SELECT id_carrito, id_user_carrito, status_carrito, clave_carrito FROM carrito WHERE id_user_carrito = $idcliente AND status_carrito = 1 OR status_carrito = 2 GROUP BY clave_carrito";
											$reqPed=mysqli_query($conex, $sqlPed);
											$TotalPedidos = mysqli_num_rows($reqPed);
									?>
									<trclass="clic <?php echo $addClass?>">
										<td style="vertical-align:middle;" align="center"><?php echo $idcliente?></td>
										<td style="vertical-align:middle;" align="center"><strong><a href="<?php echo SITE.'admin/clientes/ver?id='.$idcliente ?>"><?php echo $nombre_cliente.' '.$apellidos_cliente?></a></strong></td>
										<td style="vertical-align:middle;" align="center"><?php echo $genero?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $email_cliente?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $numero_cliente?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $TotalPedidos?></td>
										<td style="vertical-align:middle;" align="center"><?php HaceCuanto::imprimirTiempo($fecha_reg,$hora_reg)?><br><small><?php echo $fecha_reg?></small></td>
										<td style="vertical-align:middle;" align="center"><?php echo $cumple?></td>
										<td style="vertical-align:middle;" align="center"><?php echo $txtActiva?></td>
										<td style="vertical-align:middle;" align="center"><button type="button" class="btn btn-danger" onClick="eliminarCliente(<?php echo $idcliente.",'".$nombre_cliente?>')">Eliminar</button></td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<div class="blacksc"></div>
	<script>
		$("#productslist").tableExport({
			formats: ["xlsx","txt"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
			position: 'top',  // Posicion que se muestran los botones puedes ser: (top, bottom)
			bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
			fileName: "Todos los clientes",    //Nombre del archivo
		});
		function eliminarCliente(idCliente,nombreCliente){
			$( ".blacksc" ).addClass( "show" );
			var respuesta = confirm("Confirme si desea eliminar el cliente '"+nombreCliente+"'");
			if(respuesta){			
				$.ajax({
					type: "GET",
					url: "<?php echo SITE.'admin/functions/borrar_comprador.php?id='?>"+idCliente,
					success: function(info) {
						if(info == 1 ){
							//console.log(info);
							$( ".blacksc" ).removeClass( "show" );
							location.reload();
						}else if(info == 2){
							alert("Error borrar al cliente.");
							$( ".blacksc" ).removeClass( "show" );
						}else{
							console.log(info);
							$( ".blacksc" ).removeClass( "show" );
						}
					},
					error: function() {
						alert("Error borrar al cliente.");
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