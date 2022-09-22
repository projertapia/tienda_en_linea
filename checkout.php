<?php
	session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');
if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
}
$_SERVER['HTTP_HOST'];
dirname($_SERVER['PHP_SELF']);
$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";

if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {
		header('location:'.$server.'entrar');
}
$user_id = $_SESSION["iduser"];
$clave_carrito = $_SESSION["clave_carrito"]
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Confirmar Pago | Ecommerce</title>
<?php include("parts/head.php"); ?>
</head>

<body>	
	<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
		<div class="container">
			<a href="/" class="navbar-brand mr-0"><img src="img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
		</div>
	</nav>
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		 <li class="breadcrumb-item"><a href="<?php echo $urlserver?>"> Inicio</a></li>
		  <li class="breadcrumb-item"><a href="<?php echo $urlserver.'carrito'?>">Carrito</a></li>
		  <li class="breadcrumb-item active" aria-current="page">Envio</li>
		 <li class="breadcrumb-item">Confirmación</li>
	  </ol>
	</nav>
	<section id="carrito">
		<form method="post" accept-charset="UTF-8">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-12" id="direcciones">
						<div class="d-flex h-100">
							<div class="justify-content-center align-self-center" >
								<h3>Dirección de entrega</h3>
								<table class="table">
									<tbody>
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
										?>
										<tr>
											<td>
											<div class="direccionEntrega">
												<h4><?php echo $calle_direccion.' '.$numero_direccion?></h4>
												<p><?php echo $calle_direccion?></p>
												<p><?php echo $ref_direccion ?></p>
												<p><?php echo $estado_direccion?> (<?php echo $cp_direccion ?>), <?php echo $municipio_direccion?>, <?php echo $colonia_direccion?></p>
												<p><?php echo $nombre_direccion?> - <?php echo $num_cont_direccion?></p>
											</div>
											</td>
											<td valign="middle">
												<div class="form-group">
													<?php if($default_direccion==1){?>
													<input type="radio" class="form-check" name="direccion" value="<?php echo $id_direccion?>" checked>
													<?php }else{?>
													<input type="radio" class="form-check" name="direccion" value="<?php echo $id_direccion?>">
													<?php }?>
												</div>
											</td>
										</tr>
										<?php }}?>
									</tbody>
								</table>
								<hr>
								<div id="adddireccion">
									<a data-toggle="modal" data-target="#nuevadireccion" style="cursor: pointer" class="my-2">Agregar dirección</a>
									<hidden>|</hidden>
									<a href="<?php echo $urlserver.'mis-direcciones'?>" id="btn-a-direct" class="my-2">Mis direcciones</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12" id="carrito-list">
						<?php
									$subtotal=0;
									$totalenvios = 0;
									//POR CATEGORIA
									$sqlTienda = "SELECT c.clave_carrito, c.id_vendedor_carrito, c.status_carrito,
									t.id_tienda, t.nombre_tienda
									FROM carrito c, tiendas t WHERE c.clave_carrito = $clave_carrito AND c.id_vendedor_carrito=t.id_tienda AND c.id_user_carrito = $user_id AND c.status_carrito IS NULL GROUP BY c.id_vendedor_carrito";
									$reqTienda=mysqli_query($conex, $sqlTienda);
									while($resultTienda = mysqli_fetch_object($reqTienda)){
										$id_vendedor_carrito = $resultTienda->id_vendedor_carrito;
										$nombre_tienda = $resultTienda->nombre_tienda;
									?>
									<table id="vendedor-<?php echo $id_vendedor_carrito?>" class="box-carrito-producto" class="table">
										<tbody id="box-list-items">
										<tr><th colspan="4" align="left"><h6>Tienda: <?php echo $nombre_tienda?></h6></th></tr>
									<?php
									//OBTENGO LOS PRODUCTOS DE ESA CATEGORÍA
									$sqlcarrito ="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.status_carrito, c.id_producto_carrito, c.id_vendedor_carrito, c.precioart_carrito, c.cantidad_producto_carrito, c.color_producto_carrito, c.talla_producto_carrito, c.notas_carrito, c.costo_envio_carrito,
									p.id_producto, p.nombre_producto, p.img_a_producto, p.id_tienda_producto, p.precio_producto, p.precio_promo_producto, p.talla_producto, p.color_tallas, p.activo_producto, p.tarifa_envio_producto,
									t.categoria_tienda, t.id_tienda, t.nick_tienda
									FROM carrito c, productos p, tiendas t
									WHERE c.id_user_carrito = $user_id AND c.clave_carrito = $clave_carrito AND c.id_producto_carrito = p.id_producto AND t.id_tienda = p.id_tienda_producto AND c.id_vendedor_carrito = $id_vendedor_carrito AND c.status_carrito IS NULL";
									$req=mysqli_query($conex, $sqlcarrito);
									$row_cnt = $req->num_rows;
									if($row_cnt == 0){
									$showclass = "hidden";
									$txtcarrito ="Su carrito está vacio.";
								?>
									<div id="aviso-carrito" class="show">
										<h3>Su carrito está vacio.</h3>
										<button class="btn btn-shopnow">Volver a la tienda.</button>
									</div>
								<?php
									}else{
										$showclass="show";
										$txtcarrito ="Total del carrito";
								?>
								<?php
									while($result = mysqli_fetch_object($req)){
										$id_producto = $result->id_producto;
										$id_carrito = $result->id_carrito;
										$clave_carrito = $result->clave_carrito;
										$nombre_producto = $result->nombre_producto;
										$categoria_tienda = $result->categoria_tienda;
										$nick_tienda = $result->nick_tienda;
										$img_a_producto = $result->img_a_producto;
										$precioart_carrito = $result->precioart_carrito;
										$talla_producto = $result->talla_producto_carrito;
										$color_tallas = $result->color_producto_carrito;
										$cantidad_producto_carrito = $result->cantidad_producto_carrito;
										$totalporproducto = $precioart_carrito * $cantidad_producto_carrito;
										$tarifa_envio_producto = $result->tarifa_envio_producto;
										$costo_envio_productos = $result->costo_envio_carrito;
										$notas_carrito = $result->notas_carrito;	
										$subtotal = $subtotal+$totalporproducto;
								?>
								<tr class="lista-producto" id="item-<?php echo $id_producto?>">
									<td width="90px"><img src="<?php echo $urlserver."img/tiendas/".$nick_tienda.'/'.$img_a_producto?>" alt="" width="80px"></td>
									<td>
										<a href="<?php $urlserver.$categoria_tienda.'/'.$nick_tienda?>" class="title-product-link"><?php echo $nombre_producto?></a>
										<p style="font-size: 13px; line-height: 10px; margin-bottom: 5px">Talla: <?php echo $talla_producto?></p>
										<p style="font-size: 13px; line-height: 10px; margin-bottom: 5px">Color: <?php echo $color_tallas?></p>
										<input type="number" value="<?php echo $cantidad_producto_carrito?>" min="1" max="10" step="1" name="cantidadprod[]" id="idproductshop-<?php echo $id_producto?>" style="background-color: #fff;border: none;" disabled/>
										<input type="hidden" value="<?php echo $id_carrito?>" name="idproducto[]">
									</td>
									<td width="90px" align="right"><p class="precio-producto-lista">$<?php echo $totalporproducto?></p></td>
								</tr>
								<?php
									if($tarifa_envio_producto !=NULL){
										$sqlenvios ="SELECT * FROM costoenvios WHERE tarifa_activa_envios = 1 LIMIT 1";
										$reqenvios=mysqli_query($conex, $sqlenvios);
										while($resultenvios = mysqli_fetch_object($reqenvios)){
											$tipodeenvio_envios = $resultenvios->tipodeenvio_envios;
											$costo_envios = $resultenvios->costo_envios;
											$precio_envio_por_producto = $costo_envios;
										}
									}else{
										$tipodeenvio_envios = $costo_envio_productos;
										$costo_envios = $costo_envio_productos;
										$precio_envio_por_producto = $costo_envio_productos;
									}
									$totalenvios = $totalenvios + $costo_envios;
									if($costo_envios =="0"){
										$precio_envio_por_producto ="Gratis";
									}else{
										$precio_envio_por_producto= $costo_envios;
									}
									?>
									<tr><td width="30px"></td><td colspan="2" height="15px" align="right"><span style="font-size: 12px; color: #3e6d38">Envío: $<?php echo $precio_envio_por_producto?></span></td></tr>
									<tr><td colspan="3"></td></tr>	
									<?php
									}	
									}									
								?>
							</tbody>
						</table>
						<?php 
							}
						?>
						<div id="aviso-carrito" class="hidden">
							<h3>Su carrito está vacio.</h3>
							<button class="btn btn-shopnow">Volver a la tienda.</button>
						</div>
						<div id="box-btn-notas" class="<?php echo $showclass?>">
							<label for="notapedido">Nota de su pedido:</label>
							<textarea class="form-control" name="notapedido" id="notapedido" disabled style="background-color: #fff; border:none"><?php echo $notas_carrito?></textarea>
						</div>
					</div>
					<div class="col-lg-4 col-md-12" id="ticket-carrito">
						<div class="d-flex h-100">
								<div class="justify-content-center align-self-center" id="div-center-ticket">
									<h3 id="title-ticket">Total del carrito</h3>
									<?php if($row_cnt != 0){?>
									<table class="table">
										<tbody id="list-ticket">
											<tr>
												<td>Sub Total:</td>
												<td align="right">$<?php echo $subtotal?></td>
											</tr>
											<tr>
												<td>Envio:</td>
												<?php
													
												?>
												<td align="right">$<?php echo $totalenvios?></td>
											</tr>
											<!--<tr id="descuento">
												<td>Descuento:</td>
												<td align="right">-$20</td>
											</tr>-->
											<tr id="total-box-carrito">
												<td valign="middle" id="totalbox">Total: </td>
												<td  valign="middle" align="right" id="totalnum">$<?php echo $total = $totalenvios+$subtotal?></td>
											</tr>
											<tr>
												<td colspan="2">
													<div id="paypal-button-container"></div>
													<script src="https://www.paypal.com/sdk/js?client-id=AWsFu2W8kq66tY8rMYDlJKvLtVu-F9B0u-Y66j8DrMqlSOcN4T02_ZGNjriKLhu83vRagCBMV1nGR5CB&currency=MXN&locale=es_MX" data-sdk-integration-source="button-factory" data-page-type="checkout" data-order-id="<?php echo $clave_carrito?>" ></script>
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
																		  value: '<?php echo $total?>'
																	  }
																  }]
															  });
														  },
														  onApprove: function(data, actions) {
															  return actions.order.capture().then(function(details) {
																 // alert(details.payer.name.given_name);
																 // alert(data.orderID);
																  var radioValue = $("input[name='direccion']:checked").val();
																   window.location = "<?php echo $urlserver?>functions/autorizacion.php?&orderID="+data.orderID+"&idcarrito=<?php echo $clave_carrito."&iduser=".$user_id.'&dir='?>"+radioValue;
															  });
															  
														  }
													  }).render('#paypal-button-container');
													</script>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
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
		if ($(window).width() < 480) {
			docu = $(document).height();
			$(window).scroll(function(){ 
				var navY = $("nav").height();
				var tikerY = $("#carrito-list").height();
				var direccionesY = $("#direcciones").height();
				var size = docu - tikerY - direccionesY - navY;
				console.log(size+"-"+$(window).scrollTop())
				if ($(window).scrollTop() >= size){ 
					$("#ticket-carrito").addClass("normal");
				//lastAddedLiveFunc(); 
				}else{
					$("#ticket-carrito").removeClass("normal");
				} 
			}); 
		}
	</script>
</body>
</html>
