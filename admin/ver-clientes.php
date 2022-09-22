<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['mod']) AND $_GET['mod'] != ""){
		$actionStatus="Cliente actualizado";
	}else{
		$actionStatus="";
	}
	if(isset($_GET['id']) AND $_GET['id'] != ""){
		$id_cliente=$_GET['id'];
		$sqlEditor="SELECT id_cliente, nombre_cliente, apellidos_cliente, genero_cliente, numero_cliente, email_cliente, registro_cliente, cumple_cliente, activo_cliente
		FROM clientes
		WHERE id_cliente= $id_cliente";
		$reqEditor=mysqli_query($conex, $sqlEditor);
		while($resulEditor = mysqli_fetch_object($reqEditor)){
			$nombre_cliente = $resulEditor->nombre_cliente;
			$apellidos_cliente = $resulEditor->apellidos_cliente;
			$nombre_completo= $nombre_cliente.' '.$apellidos_cliente;
			$genero_cliente = $resulEditor->genero_cliente;
			$numero_cliente = $resulEditor->numero_cliente;
			$email_cliente = $resulEditor->email_cliente;
			$registro_cliente = $resulEditor->registro_cliente;
			$cumple_cliente = $resulEditor->cumple_cliente;
			$activo_cliente = $resulEditor->activo_cliente;
			$cumple=date_create($cumple_cliente);
			$cumple = date_format($cumple, 'd-m-Y');
		}
		if($activo_cliente==1){
			$txtActiva="Activo";
		}else{
			$txtActiva="Desactivado";
		}
		if($genero_cliente=='h'){
			$genero="Hombre";
		}else if($genero_cliente=='m'){
			$genero="Mujer";
		}else{
			$genero="No definido";
		}
	}else{header('location:'.SITE.'admin/clientes');}
	
	$TitleModal="Confirmación de acción";
	if($activo_cliente=="1"){
		$status="Activo";
		$TxtModal="Desactivar el cliente: $nombre_completo";
	}else{
		$status="Desactivado";
		$TxtModal="Activar el cliente: $nombre_completo";
	}
	//GET Pedidos
	$txtplan;
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cliente: <?php echo $nombre_completo?> | Ecommerce</title>
<?php include("parts/header.php");?>
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
					<div class="col-12">
						<h1 id="titlesection">Datos de <?php echo $nombre_completo?></h1>
					</div>
					<hr>
					<div class="col-12 col-lg-9">
						<div class="card-header lista-prodcutos box-status">
							<div class="row">
								<div class="col-12 col-md-6">
									<h6>Nombre Completo:</h6>
									<p><strong><?php echo $nombre_completo?></strong></p>
									<hr>
									<h6>Genero:</h6>
									<p><strong><?php echo $genero?></strong></p>
									<hr>
									<h6>Cumpleaños</h6>
									<p><strong><?php echo $cumple?></strong></p>
								</div>
								<div class="col-12 col-md-6">
									<h6>Correo Eléctronico de contacto:</h6>
									<p><strong><?php echo $email_cliente?></strong></p>
									<hr>
									<h6>Número de contacto:</h6>
									<p><strong><?php echo $numero_cliente?></strong></p>
								</div>
							</div>
						</div>
						<div class="card-header lista-prodcutos box-status">
							<?php
						$sqlPedidos="SELECT c.clave_carrito, c.id_user_carrito, c.status_carrito, c.fecha_compra_carrito, c.paypal_orderID, c.id_direccion, p.clave_pedido_pago_tienda, p.cantidadPago_paypal FROM carrito c, pagos_tienda p WHERE c.id_user_carrito = $id_cliente AND c.status_carrito IS NOT NULL AND c.clave_carrito = p.clave_pedido_pago_tienda GROUP BY c.clave_carrito ORDER BY c.fecha_compra_carrito DESC";
						$reqPedidos=mysqli_query($conex, $sqlPedidos);
						$cntPedidos = $reqPedidos->num_rows;
						if($cntPedidos !=0){
					?>
					<div class="table-responsive">
					<table class="table table-striped">
					  <thead class="thead-dark">
						<tr>
						  <th scope="col" colspan="2">Información del pedido</th>
						  <th scope="col">Numero de pedido</th>
						  <th scope="col">Escaparate</th>
						  <th scope="col" colspan="2">Estado</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							while($resultPedidos = mysqli_fetch_object($reqPedidos)){
								
								$clave_carrito = $resultPedidos->clave_carrito;
								$fecha_compra_carrito = date_create($resultPedidos->fecha_compra_carrito);
								$cantidadPago_paypal = $resultPedidos->cantidadPago_paypal;
								$paypal_orderID= $resultPedidos->paypal_orderID;
								$fechaPag = date_format($fecha_compra_carrito, 'd/m/Y H:i');
								$sqlArticulos="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.notas_carrito, c.fecha_compra_carrito,  c.status_carrito, c.cancelacion_carrito, c.precioart_carrito, c.paypal_orderID, c.id_direccion, c.costo_envio_carrito,
								p.id_producto, p.nombre_producto, p.url_producto, p.id_tienda_producto, p.img_a_producto,
								t.id_tienda,  t.nombre_tienda, t.nick_tienda, t.categoria_tienda
								FROM carrito c, productos p, tiendas t WHERE id_user_carrito = $id_cliente AND status_carrito IS NOT NULL AND clave_carrito = $clave_carrito AND p.id_producto = c.id_producto_carrito AND c.id_vendedor_carrito = t.id_tienda";
								$reqArticulos=mysqli_query($conex, $sqlArticulos);
								$RealTotal=0;
								$RealPedidos=0;
								?>
						  		<tr class="table-info" style="color: #737373; font-size: 12px">
									<td colspan="1" align="left">N.º pedido:<br><span style="color: #000"><?php echo $clave_carrito?></span></td>
									<td colspan="1" align="left">Número de orden Paypal: <br><a href="#" style="font-weight: bold" data-toggle="modal" data-target="#infopaypal-<?php echo $clave_carrito?>"><?php echo $paypal_orderID?></a></td>
									<td colspan="2">Fecha y hora de pedido:<br><span style="color: #000"><?php echo $fechaPag?></span></td>
									<td colspan="2">Importe total:<br><span style="color: red">$<?php echo $cantidadPago_paypal?></span></td>
						  		</tr>
								<?php
								while($resultArticulos = mysqli_fetch_object($reqArticulos)){
									$id_carritoA = $resultArticulos->id_carrito;
									$id_producto_carrito = $resultArticulos->id_producto_carrito;
									$vendedor_carrito = $resultArticulos->id_vendedor_carrito;
									$notas_carrito = $resultArticulos->notas_carrito;									
									$status_carrito = $resultArticulos->status_carrito;
									$cancelacion_carrito = $resultArticulos->cancelacion_carrito;
									$precioart_carrito = $resultArticulos->precioart_carrito;
									$id_direccion = $resultArticulos->id_direccion;
									//PRODUCTO
									$cantidad_producto_carrito = $resultArticulos->cantidad_producto_carrito;
									$talla_producto_carrito = $resultArticulos->talla_producto_carrito;
									$color_producto_carrito = $resultArticulos->color_producto_carrito;
									$nombre_producto = $resultArticulos->nombre_producto;
									$img_a_producto = $resultArticulos->img_a_producto;
									$costo_envio_carrito = $resultArticulos->costo_envio_carrito;
									//TIENDA
									$nombre_tienda = $resultArticulos->nombre_tienda;
									$nick_tienda = $resultArticulos->nick_tienda;
									$categoria_tienda = $resultArticulos->categoria_tienda;
									switch ($status_carrito){
										case 1:
											$statusTXT = "Pagado";
											$cssColor="yellow";
											break;
										case 2:
											$statusTXT = "Enviado";
											$cssColor="green";
											break;
										case 3:
											$statusTXT = "Cancelado";
											$cssColor="red";
											break;
										default:
											$statusTXT = "Pendiente";
											$cssColor="white";
									}
						?>
						<tr>
						  <th scope="row" width="100px"><img src="<?php echo $urlserver.'img/tiendas/'.$nick_tienda.'/'.$img_a_producto?>" alt="<?php echo $nombre_producto?>" class="img-fluid"></th>
						  <td class="align-middle"><?php echo $nombre_producto?><br><span style="font-size: 11px"><?php echo '$'.$precioart_carrito.' X '.$cantidad_producto_carrito?></span><br><span style="font-size: 11px;">Costo de envío: <?php echo $costo_envio_carrito?></span></td>
						  <td class="align-middle"><?php echo $clave_carrito?></td>
						  <td class="align-middle"><?php echo $nombre_tienda?></td>
						  <td class="align-middle"><span class="statuspk <?php echo $cssColor?>" id="txt-<?php echo $id_carritoA?>"><?php echo $statusTXT?></span></td>
						  <td class="align-middle" width="130px">
							  <button class="btn btn-info actioninfo" style="font-size: 12px" onClick="enviarcorreo('<?php echo $clave_carrito?>','<?php echo $id_producto_carrito?>', '<?php echo $id_cliente?>')">Contactar al vendedor.</button>
							  <?php if($status_carrito==1){?>
							  	<button class="btn btn-outline-danger actioninfo" style="font-size: 12px" onClick="cancelarpedido('<?php echo $clave_carrito?>','<?php echo $id_carritoA?>', '<?php echo $id_cliente?>')" id="btncancel-<?php echo $id_producto_carrito?>">Cancelar Pedido.</button>
							  <?php }?>
							</td>
						 <?php if($status_carrito ==3){
							$RealTotal = $RealTotal;
							$RealPedidos = $RealPedidos;
							}else{
							$RealPedidos = $RealPedidos + $costo_envio_carrito;
							$RealTotal = $RealTotal + ($precioart_carrito * $cantidad_producto_carrito);
							}
							?>
						</tr>
						<?php }
							$sqlDirecciones="SELECT * FROM direcciones WHERE id_cliente_direccion = $id_cliente AND id_direccion =$id_direccion";
							$reqDirecciones=mysqli_query($conex, $sqlDirecciones);
							$row_cnt = $reqDirecciones->num_rows;
							if($row_cnt !=0){
							while($resultDirecciones = mysqli_fetch_object($reqDirecciones)){
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
							}
							}
						?>
					  	<tr>
						 	<td class="align-middle"><span style="font-size: 12px">Dirección de entrega</span></td>
							<td colspan="3" class="align-middle" style="font-size: 12px"><strong>Entregar a:</strong> <?php echo $nombre_direccion ?><br>
								<strong>Número de contacto:</strong> <?php echo $num_cont_direccion?><br>
								<strong>Dirección de entrega:</strong> <?php echo $calle_direccion.' '.$numero_direccion.' '.$colonia_direccion.' '.$municipio_direccion.' '.$estado_direccion.' '.$cp_direccion?><br>
								<strong>Referencia:</trong> <?php echo $ref_direccion?>
							</td>
							<td colspan="2">
								<table class="table table-striped">
									<tr>
										<td class="align-middle" align="right"><strong style="font-size: 12px">Total de pedio:</strong></td>
										<td class="align-middle">$<?php  if($RealTotal<=0){ $RealTotal=0;} echo $RealTotal?></td>
									</tr>
									<tr>
										<td class="align-middle" align="right"><strong style="font-size: 12px">Total de Envios:</strong></td>
										<td class="align-middle">$<?php echo $RealPedidos?></td>
									</tr>
									<tr>
										<td class="align-middle" align="right"><strong style="font-size: 12px">Total:</strong></td>
										<td class="align-middle">$<?php echo $RealTotal + $RealPedidos?></td>
									</tr>
								</table>
							</td>
							
							
						 </tr>
						  <tr><td colspan="6" height="5px" bgcolor="#3e6d38" style="padding: 0"></td></tr>
							<div class="modal fade" tabindex="-1" role="dialog" id="infopaypal-<?php echo $clave_carrito?>">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title">Información PayPal <i class="fab fa-paypal"></i></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									  <?php 
										$sqlPayPal="SELECT * FROM pagos_tienda WHERE clave_pedido_pago_tienda = $clave_carrito";
										$reqPayPal=mysqli_query($conex, $sqlPayPal);
										$row_cnt = $reqPayPal->num_rows;
										if($row_cnt !=0){
											while($resultPayPal = mysqli_fetch_object($reqPayPal)){
												$clave_pedido_pago_tienda = $resultPayPal->clave_pedido_pago_tienda;
												$fecha_pago_tienda = $resultPayPal->fecha_pago_tienda;
												$orderID_paypal = $resultPayPal->orderID_paypal;
												$email_paypal = $resultPayPal->email_paypal;
												$status_paypal = $resultPayPal->status_paypal;
												$transaccionID_paypal = $resultPayPal->transaccionID_paypal;
												$cantidadPago_paypal = $resultPayPal->cantidadPago_paypal;
												$fechaPago_paypal = $resultPayPal->fechaPago_paypal;
												$direccion_paypal = $resultPayPal->direccion_paypal;
											}
										}
									  ?>
									<p>Clave de pedido: <?php echo $clave_pedido_pago_tienda?></p>
									  <p>Id Orden Paypal: <?php echo $orderID_paypal?></p>
									  <p>Id de trasacción: <?php echo $transaccionID_paypal?></p>
									  <p>Recibido: $<?php echo number_format($cantidadPago_paypal, 2, '.', ',');?></p>
									  <p>Pago recibido: <?php echo $fechaPago_paypal?></p>
									  <p>Dirección de PayPal: <?php echo $direccion_paypal?></p>
								  </div>
								</div>
							  </div>
							</div>
						<?php }?>
					</tbody>
					</table>
					</div>
					<?php } ?>
					<!--PREGUNTAR ALGO-->
					<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="sendMailLabel" aria-hidden="true" id="sendmail">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="sendMailLabel">Contactar al Vendedor</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form accept-charset="UTF-8" id="mailcontact" method="post">
										<input type="hidden" id="iduser" name="iduser" value="">
										<input type="hidden" id="idproduct" name="idproduct" value="">
										<input type="hidden" id="idcarrito" name="idcarrito" value="">
										<div class="form-group">
										<select name="razon" id="razon" required class="form-control">
											<option value="">Seleccione una opción</option>
											<option value="duda">Duda</option>
											<option value="facturacion">Facturación</option>
											<option value="cancelacion">Cancelar pedido</option>
										</select>
										</div>
										<div class="form-group">
										<textarea name="info" class="form-control" id="info" required></textarea>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-primary" onClick="enviar()" id="enviarDudas">Enviar</button>
								</div>
							</div>
						</div>
					</div>
					<!--CANCELAR PEDIDO-->
					<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="cancelLabel" aria-hidden="true" id="cancelmail">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="cancelLabel">Cancelar pedido</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form accept-charset="UTF-8" id="cancelpedido" method="post">
										<input type="hidden" id="iduser-can" name="iduser-can" value="">
										<input type="hidden" id="idproduct-can" name="idproduct-can" value="">
										<input type="hidden" id="idcarrito-can" name="idcarrito-can" value="">
										<div class="form-group">
										<select name="razon-can" id="razon-can" required class="form-control">
											<option>Seleccione una opción</option>
											<option value="Talla o producto equivocado">Talla o producto equivocado</option>
											<option value="Sin Stock">Sin Stock</option>
											<option value="Cancelación del cliente">Cancelación del cliente</option>
											<option value="Cancelación del vendedor">Cancelación del vendedor</option>
										</select>
										</div>
										<div class="form-group">
											<label for="info">Detalla por que quieres cancelar el pedido</label>
										<textarea name="info-can" class="form-control" id="info-can" required></textarea>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-primary" onClick="enviarcancel()" id="enivarcancelbtn">Enviar</button>
								</div>
							</div>
						</div>
					</div>
					<!--AVISOS-->
					<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="avisosLabel" aria-hidden="true" id="avisos">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="avisosLabel"></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p id="txtaviso"></p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
								</div>
							</div>
						</div>
					</div>
					<!--Cancelar-->
						</div>
					</div>
					<div class="col-12 col-lg-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Status</h5>
							</div>
							<div class="card-body">
								<p><?php echo $actionStatus?></p>
								<p><strong><?php echo $status?></strong></p>
								<?php if($activo_cliente=="1"){ ?>
								<button type="button" name="guardar" id="guardar" data-toggle="modal" data-target="#confirmar" class="btn btn-danger">Desactivar</button>
								<?php }else{ ?>
								<button type="button" name="ocultar" id="ocultar" data-toggle="modal" data-target="#confirmar" class="btn btn-success">Activar</button>
								<?php }?>
							</div>
						</div>
					</div>
					<!--MODAL UPDATE-->
					<div class="modal" tabindex="-1" role="dialog" id="confirmar">
					  <div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title"><?php echo $TitleModal?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
							<form id="action" method="post">
								<input type="hidden" name="idadmin" value="<?php echo $id_admin?>">
								<input type="hidden" name="idcliente" value="<?php echo $id_cliente?>">
								<input type="hidden" name="action" value="<?php echo $activo_cliente?>">
							</form>
						  <div class="modal-body">
							<p><?php echo $TxtModal?></p>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-primary" onClick="statuscliente()" id="statuscliente">Aceptar</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						  </div>
						</div>
					  </div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script>
		function statuscliente(){
			$( "#statuscliente" ).prop( "disabled", true );
			var formData = $('#action').serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo SITE.'admin/functions/showcliente.php'?>",
				data : formData,
				success: function(info) {
					console.log(info);
					if(info == 1){
						location.reload();
					}else{
						alert("Error al actualizar el cliente.");
					}
				},
				error: function() {
					alert("Error al actualizar el cliente.");
					location.reload();
				}
			});
		}
		
		function cancelarpedido(carrito,producto,user){
			document.getElementById("iduser-can").value = user;
			document.getElementById("idproduct-can").value = producto;
			document.getElementById("idcarrito-can").value = carrito;
			$('#cancelmail').modal('toggle');
		};
		function enviarcorreo(carrito,producto,user){
			document.getElementById("iduser").value = user;
			document.getElementById("idproduct").value = producto;
			document.getElementById("idcarrito").value = carrito;
			$('#sendmail').modal('toggle');
		};
		/*ENVIAR DUDAS*/
		function enviar(){
			event.preventDefault();
			$( "#enviarDudas" ).prop( "disabled", true );
			var formData = $('#mailcontact').serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo SITE.'admin/functions/enivardudas.php'?>",
				data : formData,
				success: function(info) {
					console.log(info);
					if(info==1){
						$('#sendmail').modal('toggle');
						document.getElementById("avisosLabel").innerHTML = 'Envío exitoso';
						document.getElementById("txtaviso").innerHTML = 'Su mensaje se envío con éxito';
						document.getElementById("info").value = "";
						$('#avisos').modal('toggle');
					}else{
						$('#sendmail').modal('toggle');
						
						document.getElementById("avisosLabel").innerHTML = 'Error al enviar';
						document.getElementById("txtaviso").innerHTML = 'No se logro enviar su mensaje, intente nuevamente.';
						$('#avisos').modal('toggle');
					}
					
				},
				error: function(info) {
					console.log(info);
					$('#sendmail').modal('toggle');
					$('#avisos').modal('toggle');
						document.getElementById("avisosLabel").innerHTML = 'Error al enviar';
						document.getElementById("txtaviso").innerHTML = 'No se logro enviar su mensaje, intente nuevamente.';
				}
			});
			$( "#enviarDudas" ).prop( "disabled", false );
		}
		/*ENVIAR CANCELACION*/
		
		function confir(){
			var mensaje;
			var opcion = confirm("¿Realmente desea cancelar el pedido?");
			if (opcion == true) {
				var confirmacion =1;
				$( "#enivarcancelbtn" ).prop( "disabled", true );
			} else {
				var confirmacion =2;
			}
			return confirmacion
		}
		
		function enviarcancel(){
			var x;
			event.preventDefault();
			var idprodcut = document.getElementById("idproduct-can").value;
			var razon = document.getElementById("razon-can").value;
			var info = document.getElementById("info-can").value;
			if((razon !== null && info !== null) && (razon !== '' && info !== '')){
			var formData = $('#cancelpedido').serializeArray();
			x = confir(x);
			if(x==1){
				$( "#enivarcancelbtn" ).prop( "disabled", true );
				$.ajax({
					type: "POST",
					url: "<?php echo SITE.'admin/functions/cancelpedido.php'?>",
					data : formData,
					success: function(info) {
						console.log(info+" - "+idprodcut);
						if(info==123){
							$("#txt-"+idprodcut).addClass("red");
							$("#txt-"+idprodcut).removeClass("yellow");
							$("#txt-"+idprodcut).text("Cancelado");
							$("#btncancel-"+idprodcut).remove();
							$('#cancelmail').modal('toggle');
							document.getElementById("avisosLabel").innerHTML = 'Su solicitud fue enviada.';
							document.getElementById("txtaviso").innerHTML = 'Lamentamos la situación, informamos al vendedor y al cliente del proceso de cancelación vía correo electrónico.';
							document.getElementById("info").value = "";
							$('#avisos').modal('toggle');
						}else{
							$('#cancelmail').modal('toggle');

							document.getElementById("avisosLabel").innerHTML = 'Error al enviar';
							document.getElementById("txtaviso").innerHTML = 'No se logro enviar su mensaje, intente nuevamente.';
							$('#avisos').modal('toggle');
						}
						
					},
					error: function(info) {
						console.log(info);
						$('#cancelmail').modal('toggle');
						$('#avisos').modal('toggle');
							document.getElementById("avisosLabel").innerHTML = 'Error al enviar';
							document.getElementById("txtaviso").innerHTML = 'No se logro enviar su mensaje, intente nuevamente.';
					}
				});
			}
			}else{
				alert("Seleciona una opción y detalla la razón de la cancelación.");
			}
			$( "#enivarcancelbtn" ).prop( "disabled", false );
		}
		
		
		
	</script>
</body>
</html>