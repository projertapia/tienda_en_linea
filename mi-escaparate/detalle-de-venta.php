<?php
	session_start();
	require('connect/conect_usrer.php');
	if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
	}
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
	$last = explode("/", $server, 5);
	$urlparts = $http.$last[2].'/'.$last[3].'/';
	$conex->query("SET lc_time_names = 'es_MX';");
	date_default_timezone_set('America/Mexico_City');
	// Unix
	setlocale(LC_TIME, 'es_ES.UTF-8');
	// En windows
	setlocale(LC_TIME, 'spanish');
	setlocale(LC_MONETARY, 'es_MX');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.$server.'entrar');
	}
	if(isset($_GET['id']) AND $_GET['id']!=""){
		$idProdcutoTienda = $_GET['id'];
		$sqlVentas="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.fecha_compra_carrito, c.fecha_entrega_carrito, c.status_carrito, c.cancelacion_carrito, c.precioart_carrito, c.id_direccion, c.notas_carrito, c.paypal_orderID, c.costo_envio_carrito, c.empresa_envio_carrito, c.guia_envio_carrito, c.razoncancelado_carrito,
		p.id_producto, p.nombre_producto, p.img_a_producto,
		z.id_cliente, z.nombre_cliente, z.apellidos_cliente, z.email_cliente,
		d.id_direccion, d.id_cliente_direccion, d.nombre_direccion, d.num_cont_direccion, d.ref_direccion, d.calle_direccion, d.numero_direccion, d.estado_direccion, d.municipio_direccion, d.colonia_direccion, d.cp_direccion
		FROM carrito c, productos p, clientes z, direcciones d
		WHERE c.id_vendedor_carrito = $id_tienda AND c.status_carrito IS NOT NULL AND p.id_producto = c.id_producto_carrito AND z.id_cliente = c.id_user_carrito AND c.id_carrito = $idProdcutoTienda AND d.id_direccion = c.id_direccion AND d.id_cliente_direccion = c.id_user_carrito";
		$reqVentas=mysqli_query($conex, $sqlVentas);
		while($resulVentas = mysqli_fetch_object($reqVentas)){
			$id_carrito = $resulVentas->id_carrito;
			$clave_carrito= $resulVentas->clave_carrito;
			$status_carrito = $resulVentas->status_carrito;
			$talla_producto_carrito = $resulVentas->talla_producto_carrito;
			$color_producto_carrito = $resulVentas->color_producto_carrito;
			$cantidad_producto_carrito = $resulVentas->cantidad_producto_carrito;
			$fecha_compra_carrito = $resulVentas->fecha_compra_carrito;
			$fecha_entrega_carrito = $resulVentas->fecha_entrega_carrito;
			$precio_producto = $resulVentas->precioart_carrito;
			$cancelacion_carrito = $resulVentas->cancelacion_carrito;
			$notas_carrito = $resulVentas->notas_carrito;
			$paypal_orderID = $resulVentas->paypal_orderID;
			$costo_envio_carrito = $resulVentas->costo_envio_carrito;
			$empresa_envio_carrito = $resulVentas->empresa_envio_carrito;
			$guia_envio_carrito = $resulVentas->guia_envio_carrito;
			$razoncancelado_carrito = $resulVentas->razoncancelado_carrito;

			$img_a_producto = $resulVentas->img_a_producto;
			$nombre_cliente = $resulVentas->nombre_cliente;
			$nombre_producto = $resulVentas->nombre_producto;

			$nombre_cliente = $resulVentas->nombre_cliente;
			$apellidos_cliente = $resulVentas->apellidos_cliente;
			$email_cliente = $resulVentas->email_cliente;

			$nombre_cliente=$nombre_cliente.' '.$apellidos_cliente;
			
			//DATOS ENTREGA
			$nombre_direccion = $resulVentas->nombre_direccion;
			$num_cont_direccion = $resulVentas->num_cont_direccion;
			$calle_direccion = $resulVentas->calle_direccion;
			$ref_direccion = $resulVentas->ref_direccion;
			$numero_direccion = $resulVentas->numero_direccion;
			$estado_direccion = $resulVentas->estado_direccion;
			$municipio_direccion = $resulVentas->municipio_direccion;
			$colonia_direccion = $resulVentas->colonia_direccion;
			$cp_direccion = $resulVentas->cp_direccion;
			
		}
		switch ($status_carrito){
			case 1:
				$Status="Pagado";
			break;
			case 2:
				$Status="Enviado";
			break;
			case 3:
				$Status="Cancelado";
			break;
		}
		if($costo_envio_carrito =="" OR $costo_envio_carrito ==NULL){
			$costo_envio_carrito=0;
		}
		//GET PERIODO CARRITO
		$SQLPercentReport="SELECT s.id_tienda_suscripcion, s.tipo_suscripcion, s.porcentaje_suscripcion_tiendas, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, t.id_tipo_tienda, t.nombre_tipo_tienda FROM suscripcion_tiendas s, tipos_tienda t WHERE s.id_tienda_suscripcion = $id_tienda AND (s.inicio_suscripcion <= '$fecha_compra_carrito' AND s.fin_suscripcion >= '$fecha_compra_carrito') AND t.id_tipo_tienda  = s.tipo_suscripcion";
		$reqPercentReport=mysqli_query($conex, $SQLPercentReport);
		if($reqPercentReport->num_rows !=0){
			while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
				$porcentaje = $resulPercentReport->porcentaje_suscripcion_tiendas;
				$nombre_tipo = $resulPercentReport->nombre_tipo_tienda;
			}
		}else{
			$SQLPercentReport="SELECT * FROM tipos_tienda WHERE id_tipo_tienda = 1";
			$reqPercentReport=mysqli_query($conex, $SQLPercentReport);
			while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
				$porcentaje = $resulPercentReport->porcentaje_tienda;
				$nombre_tipo = $resulPercentReport->nombre_tipo_tienda;
			}
		}
		//SUB TOTAL CON IVA
		$subtotal = ($cantidad_producto_carrito * $precio_producto);		
		//TOTAL CON IVA
		$total = $subtotal+$costo_envio_carrito;		
		//PRODUCTO MENOS IVA
		$producto_menos_iva= $subtotal/1.16;
		//ENVIO - IVA
		$envio_menos_iva = $costo_envio_carrito /1.16;
		//PRODUCTO SIN COMISION
		$producto_precio_vendedor = $producto_menos_iva / (1+($porcentaje/100));		
		//COMISION
		$comision_sin_iva = ($producto_menos_iva - $producto_precio_vendedor);
		//IVA TOTAL
		$iva_Total = $total - ($producto_menos_iva+$envio_menos_iva);
		//TOTAL RECEPCIÓN VENDEDOR
		$total_recepcion= ($producto_precio_vendedor+$envio_menos_iva);
		
		$prod_fact = $total_recepcion - $envio_menos_iva;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ver detalla del pedido <?php echo $id_carrito.' - '.$clave_carrito?> | Ecommerce</title>
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
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
				 <li class="breadcrumb-item"><a href="<?php echo SITE?>mi-escaparate/mis-ventas">Ventas</a></li>
				 <li class="breadcrumb-item active" aria-current="page">Detalle de la venta</li>
			  </ol>
			</nav>
			<section id="info-content">
			<div class="row">
			<div class="col-md-12 col-lg-8 col-xl-8">
				<h1 id="titlesection"><?php echo $nombre_producto?></h1>
				<small>Venta #<?php echo $clave_carrito?> | <?php echo strftime("%d de %B de %Y", strtotime($fecha_compra_carrito))?></small>
				<div class="card" style="margin-bottom: 15px">
  					<div class="card-body">
						<h3><?php echo $nombre_cliente?></h3>
						<a class="Vemailc" href="mailto:<?php echo $email_cliente?>?subject=Informaci%C3%B3n%20sobre%20su%20pedido%20%23%20<?php echo $clave_carrito?>%20del%20escaparate%20<?php echo NICKTIENDA?>&body=Hola%20tenemos%20informaci%C3%B3n%20sobre%20tu%20pedido" target="_blank"><?php echo $email_cliente?></a>
					</div>
				</div>
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<strong><?php echo $Status?></strong>
						<?php if($fecha_entrega_carrito!= ""){
						?>
						<span style="display: block"><?php echo strftime("%d de %B de %Y", strtotime($fecha_entrega_carrito))?></span>
						<?php
						}?>
						<hr>
						<table class="table table-striped mysalesprodcut">
							<tbody>
								<tr>
									<th scope="row" class="img"><img src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_a_producto?>" class="img-fluid" alt="<?php echo $nombre_producto?>" width="50px"></th>
									<td class="name" valign="middle" align="left"><?php echo $nombre_producto?></td>
									<td class="precio" valign="middle" align="center">Precio:<br>$<?php echo number_format($producto_precio_vendedor, 2, '.', ',');?></td>
									<td class="cantidad" valign="middle" align="center"><?php echo $cantidad_producto_carrito?>u.</td>
									<td class="variante" valign="middle" align="left"><span>Tamaño / Variante: <strong><?php echo $talla_producto_carrito?></strong></span><span>Color / Atributos: <strong><?php echo $color_producto_carrito?></strong></span>
									</td>
									<td valign="middle" align="center">Envío:<br>$<?php echo $costo_envio_carrito?></td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										<p style="font-size: 12px; font-weight: bold">Datos del envío</p>
										<ul class="list-unstyled">
											<?php if($empresa_envio_carrito !=""){
											?>
											<li><?php echo $empresa_envio_carrito?></li>
											<li><?php echo $guia_envio_carrito?></li>
											<hr>
											<?php } ?>
											<li>Nombre de receptor: <?php echo $nombre_direccion?></li>
											<li>Número de contacto: <?php echo $num_cont_direccion?></li>
											<li>CP <?php echo $cp_direccion?></li>
											<li><?php echo $calle_direccion?> <?php echo $numero_direccion?> <?php echo $colonia_direccion?> - <?php echo $municipio_direccion?> <?php echo $estado_direccion?></li>		
											<li>Referencias: <?php echo $ref_direccion?> </li>
										</ul>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<strong>Notas</strong>
						<hr>
						<p><?php echo $notas_carrito ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-4 col-xl-4">
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<?php if($status_carrito==3){ ?>
						<strong>Pedido Cancelado</strong>
						<?php }else{ ?>
						<strong>Detalle de pago</strong>
						<hr>
						<p>ID PayPal: <?php echo $paypal_orderID ?></p>
						<table class="table">
							<tbody id="list-ticket">
								<tr>
									<td>Producto:</td>
									<td align="right">$<?php echo number_format($producto_precio_vendedor, 2, '.', ',');?></td>
								</tr>
								<tr>
									<td>Envio:</td>
									<td align="right">$<?php echo number_format($envio_menos_iva, 2, '.', ',')?>
									</td>
								</tr>
								<tr id="descuento">
									<td>Comisión <?php echo $porcentaje.'%'?>:</td>
									<td align="right">$<?php echo number_format($comision_sin_iva, 2, '.', ',') ?></td>
								</tr>
								<tr>
									<td><strong>Subtotal:</strong></td>
									<?php $subtotal_sin_iva=$prod_fact+$envio_menos_iva+$comision_sin_iva;?>
									<td align="right">$<?php echo number_format($subtotal_sin_iva, 2, '.', ','); ?></td>
								</tr>
								<tr>
									<td>IVA:</td>
									<td align="right">$<?php echo number_format($iva_Total, 2, '.', ',');?>
									</td>
								</tr>
								<tr id="total-box-carrito">
									<td valign="middle" id="totalbox">Total: </td>
									<td valign="middle" align="right" id="totalnum">$<?php echo number_format($total, 2, '.', ',')?></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
					</div>
				</div>
				<div class="card-header lista-prodcutos table-responsive">
					<div class="box-status">
						<strong>Envío:</strong>
						<hr>
						<form accept-charset="UTF-8" method="post" id="enviosform">
						<input type="hidden" name="idCarrito" value="<?php echo $id_carrito?>">
						<input type="hidden" name="clavecarrito" value="<?php echo $clave_carrito?>">
						<input type="hidden" name="mail" value="<?php echo $email_cliente?>">
						<input type="hidden" name="nombrecliente" value="<?php echo $nombre_cliente?>">
						<?php
							$hiddenclass;
							$razonClass;
							if($status_carrito==1 OR $status_carrito==2){
								$razonClass="hidden";
							}
							if($status_carrito==1){
							$hiddenclass="hidden";
						?>
							<div class="form-group">
								<label for="status">Cambiar status:</label>
								<select name="status" class="form-control" id="SelStatus">
									<option value="" selected>Seleccione un status</option>
									<option value="2">Enviado</option>
									<option value="3">Cancelado</option>
								</select>
							</div>
						<?php
						}
						if($status_carrito==2){
						?>
							<input type="hidden" name="status" id="SelStatus" value="<?php echo $status_carrito?>">
						<?php
						}
						?>
						<?php if($status_carrito==1 OR $status_carrito ==2){?>
						<div class="form-group envios <?php echo $hiddenclass ?>">
							<label for="empresa">Empresa de transporte:</label>
							<input type="text" class="form-control inputempresa" required name="empresa" id="empresa" value="<?php echo $empresa_envio_carrito?>">
						</div>
						<div class="form-group envios <?php echo $hiddenclass ?>">
							<label for="rastreo">Número de rastreo:</label>
							<input type="text" class="form-control inputempresa" required name="rastreo" id="rastreo" value="<?php echo $guia_envio_carrito?>">
						</div>
						<div class="form-group razones <?php echo $razonClass?>">
							<label for="razon">Razón de cancelado</label>
							<textarea class="form-control" id="razoncancel" name="razon" rows="2"></textarea>
						</div>
						<div class="form-check">
							<input type="checkbox" value="si" name="confirmar" class="form-check-input" id="confirmar">
							<label class="form-check-label" for="confirmar">Confirmar acción</label>
						</div>
						<div style="height: 10px; width: 100%; display: block"></div>
						<div class="form-check">
							<button type="button" class="btn btn-primary w-100" onClick="actualizarStatus()">Actualizar</button>
						</div>
						<?php }else{?>
							<h3>Cancelado</h3>
							<p><?php echo $razoncancelado_carrito?></p>
						<?php } ?>
						</form>
					</div>
				</div>
			</div>
			</div>
			</section>
	
	</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
		$('#SelStatus').on('change', function() {
		 var value = this.value;
			if(value ==2){
				$('.envios').removeClass('hidden');
				$(".inputempresa").prop('required',true);
				$(".inputempresa").prop('disabled', false);
				$('.razones').addClass('hidden');
				$("#razoncancel").prop('required',false);
				$("#razoncancel").prop('disabled', true);
			}else if(value==3){
				$('.razones').toggleClass('hidden');
				$("#razoncancel").prop('required',true);
				$("#razoncancel").prop('disabled', false);
				$('.envios').addClass('hidden');
				$(".inputempresa").prop('required',false);
				$(".inputempresa").prop('disabled', true);
			}
		});
		//EDITAR ENVIOS
		function actualizarStatus(){
			event.preventDefault();
			var Cstatus = document.getElementById("SelStatus").value;
			var Cempresa = document.getElementById("empresa").value;
			var Crastre = document.getElementById("rastreo").value;
			var formData = $('#enviosform').serializeArray();
			if(($('#confirmar').prop('checked')  && Cstatus !="")) {
				 if($("#enviosform")[0].checkValidity()) {
					$.ajax({
						type: "POST",
						url: "<?php echo SITE.'mi-escaparate/functions/statusenvio.php'?>",
						data : formData,
						success: function(info) {
							if(info == 1){
								console.log(info);
								location.reload();
							}else if(info == 2){
								alert("Error al actualizar el pedido.");
							}else{
								console.log(info);
							}
						},
						error: function() {
							alert("Error al actualizar el pedido.");
							location.reload();
						}
					});
				}else{
					alert("POR FAVOR: RELLENA TODOS LOS CAMPOS");
				}
			}else{
				alert("POR FAVOR: CONFIRMA LA ACCIÓN");
			}
		}
		//EDITAR ENVIOS
	</script>
</body>
</html>