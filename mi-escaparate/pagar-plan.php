<?php
	session_start();
	require('connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
		header('location:'.SITE.'entrar');
	}
	if(isset($_POST['plan']) AND $_POST['plan']!="" AND isset($_POST['idtienda']) AND $_POST['idtienda']!=""){
		$planid = $_POST['plan'];
		//GET VALUES
		$sqlPlanes="SELECT * FROM tipos_tienda WHERE activo_tipo_tienda = 1 AND id_tipo_tienda = $planid";
		$reqPlanes=mysqli_query($conex, $sqlPlanes);
		while($resulPlanes = mysqli_fetch_object($reqPlanes)){
			$id_tipo_tienda = $resulPlanes->id_tipo_tienda;
			$nombre_tipo_tienda = $resulPlanes->nombre_tipo_tienda;
			$cantidad_tipo_tienda = $resulPlanes->cantidad_tipo_tienda;
			$cantidad_promos_tipo_tienda = $resulPlanes->cantidad_promos_tipo_tienda;
			$porcentaje_tienda = $resulPlanes->porcentaje_tienda;
			$costo_tienda = ($resulPlanes->costo_tienda)*1.16;
			$duracion_tipo_tienda = $resulPlanes->duracion_tipo_tienda;
			if($duracion_tipo_tienda==1){
				$meses="mes.";
			}else{
				$meses="meses.";
			}
		}
		$mesessuma = "+ ".$duracion_tipo_tienda." month";
		$fin_suscripcion= date("Y-m-d G:i:s",strtotime($datetime_now.$mesessuma));
		
	}else{
		header('location:'.SITE.'mi-plan');
	}
	$key = time();
	$key .= IDTIENDA.$id_tipo_tienda;
	$clave_carrito="$key";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Compara un Plan - <?php echo NICKTIENDA?> | Ecommerce</title>
<?php include("parts/header.php");?>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light right-content">
				<div class="container">
					<div class="nav justify-content-end w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'mi-escaparate'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce.svg" alt="Ecommerce" width="82px"></a> 
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lateralpanel" aria-controls="lateralpanel" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
				</div>
			</nav>
			<section id="info-content">
				<div class="row">
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 ">
						<h1 id="titlesection">Comprar plan <?php echo $nombre_tipo_tienda?></h1>
					</div>
					<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-0 card-header lista-prodcutos">
						<div class="box-status">
							<table class="table table-striped">
								<thead>
									<tr>
										<th scope="col">Plan</th>
										<th scope="col">Productos publicados</th>
										<th scope="col">Promociones publicadas</th>
										<th scope="col">Comisión</th>
										<th scope="col">Vencimiento</th>
										<th scope="col">Costo</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $nombre_tipo_tienda?></td>
										<td><?php echo $cantidad_tipo_tienda?></td>
										<td><?php echo $cantidad_promos_tipo_tienda?></td>
										<td><?php echo $porcentaje_tienda?>%</td>
										<td><?php echo $fin_suscripcion?></td>
										<td>$<?php echo $costo_tienda?>*<small>mxn.</small></td>
									</tr>
								</tbody>
							</table>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 offset-xl-4 offset-lg-4 offset-md-4 offset-sm-0">
								<div id="paypal-button-container"></div>
							</div>
													<script src="https://www.paypal.com/sdk/js?client-id={client-id}&currency=MXN&locale=es_MX" data-sdk-integration-source="button-factory" data-page-type="checkout" data-order-id="<?php echo $clave_compra?>" ></script>
													
													<?php 
													//ID LINK &merchant-id={merchant-id}
													?>
													<script>
													  paypal.Buttons({
														  style: {
															  shape: 'rect',
															  color: 'gold',
															  layout: 'horizontal',
															  label: 'paypal',

														  },
														  createOrder: function(data, actions) {
															  return actions.order.create({
																  purchase_units: [{
																	  amount: {
																		  value: '<?php echo $costo_tienda?>'
																	  }
																  }]
															  });
														  },
														  onApprove: function(data, actions) {
															  return actions.order.capture().then(function(details) {
																   window.location = "<?php echo SITE?>mi-escaparate/functions/autorizacion.php?&orderID="+data.orderID+"&idcarrito=<?php echo $clave_carrito."&id_tienda_suscripcion=".$id_tienda.'&plan='.$id_tipo_tienda?>";
															  });
															  
														  }
													  }).render('#paypal-button-container');
													</script>
										
									
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</body>
</html>