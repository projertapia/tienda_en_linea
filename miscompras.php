<?php
session_start();
if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {
	header("location:$server./entrar");
}
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
	$user_id = $_SESSION["iduser"];
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Mis compras | Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>
	<?php include("parts/header.php"); ?>	
	<section id="mis-datos"  class="avatar">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-2 col-sm-3" id="left-tab">
					<?php include("parts/leftbar.php");?>
				</div>
				<div class="col-xl-9 col-lg-10 col-sm-9" id="box-info-cuenta" style="background-color: #fff">
					<h1>Mis Compras</h1>
					<?php
						$sqlPedidos="SELECT c.clave_carrito, c.id_user_carrito, c.status_carrito, c.fecha_compra_carrito, p.clave_pedido_pago_tienda, p.cantidadPago_paypal FROM carrito c,  pagos_tienda p WHERE c.id_user_carrito = $user_id AND c.status_carrito IS NOT NULL AND c.clave_carrito = p.clave_pedido_pago_tienda GROUP BY c.clave_carrito ORDER BY c.fecha_compra_carrito DESC";
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
								$fechaPag = date_format($fecha_compra_carrito, 'd/m/Y H:i');
								$sqlArticulos="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.id_producto_carrito, c.talla_producto_carrito, c.color_producto_carrito, c.cantidad_producto_carrito, c.id_vendedor_carrito, c.notas_carrito, c.fecha_compra_carrito,  c.status_carrito, c.cancelacion_carrito, c.precioart_carrito, c.paypal_orderID, c.id_direccion,
								p.id_producto, p.nombre_producto, p.url_producto, p.id_tienda_producto, p.img_a_producto,
								t.id_tienda,  t.nombre_tienda, t.nick_tienda, t.categoria_tienda
								FROM carrito c, productos p, tiendas t WHERE id_user_carrito = $user_id AND status_carrito IS NOT NULL AND clave_carrito = $clave_carrito AND p.id_producto = c.id_producto_carrito AND c.id_vendedor_carrito = t.id_tienda";
								$reqArticulos=mysqli_query($conex, $sqlArticulos);
								?>
						  		<tr class="table-info" style="color: #737373; font-size: 12px">
									<td colspan="3" align="left">N.º pedido:<br><span style="color: #000"><?php echo $clave_carrito?></span></td>
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
						  <td class="align-middle"><?php echo $nombre_producto?><br><span style="font-size: 11px"><?php echo '$'.$precioart_carrito.'X'.$cantidad_producto_carrito?></span></td>
						  <td class="align-middle"><?php echo $clave_carrito?></td>
						  <td class="align-middle"><?php echo $nombre_tienda?></td>
						  <td class="align-middle"><span class="statuspk <?php echo $cssColor?>" id="txt-<?php echo $id_carritoA?>"><?php echo $statusTXT?></span></td>
						  <td class="align-middle" width="130px">
							  <button class="btn btn-info actioninfo" style="font-size: 12px" onClick="enviarcorreo('<?php echo $clave_carrito?>','<?php echo $id_producto_carrito?>', '<?php echo $user_id?>')">Contactar al vendedor.</button>
							  <?php if($status_carrito==1){?>
							  	<button class="btn btn-outline-danger actioninfo" style="font-size: 12px" onClick="cancelarpedido('<?php echo $clave_carrito?>','<?php echo $id_carritoA?>', '<?php echo $user_id?>')" id="btncancel-<?php echo $id_producto_carrito?>">Cancelar Pedido.</button>
							  <?php }?>
							</td>
						</tr>
						<?php } ?>
					  
						<?php } ?>
					</tbody>
					</table>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
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
					<button type="button" class="btn btn-primary" onClick="enviar()">Enviar</button>
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
							<option value="Me equivoque en la talla">Me equivoque en la talla</option>
							<option value="Lo encontre más barato">Lo encontre más barato</option>
							<option value="Ya no quiero el producto">Ya no quiero el producto</option>
						</select>
						</div>
						<div class="form-group">
							<label for="info">Detalla por que quieres cancelar tu pedido</label>
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
	<?php include("parts/footer.php"); ?>
	<script>
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
			var formData = $('#mailcontact').serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo $urlserver.'functions/enivarcorreo.php'?>",
				data : formData,
				success: function(info) {
					console.log(info);
					if(info==11){
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
		}
		/*ENVIAR CANCELACION*/
		
		function confir(){
			var mensaje;
			var opcion = confirm("¿Realmente desea cancelar el pedido?");
			if (opcion == true) {
				var confirmacion =1;
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
					url: "<?php echo $urlserver.'functions/cancelpedido.php'?>",
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
							document.getElementById("txtaviso").innerHTML = 'Lamentamos la situación, te informaremos del proceso de cancelación vía correo electrónico.';
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
