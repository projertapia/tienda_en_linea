<?php
  session_start();
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_MX';");
	setlocale(LC_MONETARY, 'es_MX');

	if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {
		header('location:'.SITEUSER.'entrar');
	}
	//GENERATE KEY CARRITO
	$user_id = $_SESSION["iduser"];
	$sql ="SELECT id_carrito, clave_carrito, id_user_carrito, status_carrito FROM carrito WHERE id_user_carrito = $user_id AND status_carrito IS NULL LIMIT 1";
	$req=mysqli_query($conex, $sql);
	$clave_cnt = $req->num_rows;
	if($clave_cnt==0){
		unset($_SESSION['clave_carrito']);
		$fecha_clave = date("Ymd"); 
		$sqlNclave ="SELECT clave_carrito FROM carrito ORDER BY clave_carrito DESC LIMIT 1";
		$reqNclave=mysqli_query($conex, $sqlNclave);
		while($resultNclave = mysqli_fetch_object($reqNclave)){
			$saveoldcarrito = $resultNclave->clave_carrito;
		}
		$clave = substr($saveoldcarrito, 8);
		++$clave;
		$clave = str_pad($clave, 3, "0", STR_PAD_LEFT);
		$clavefinal = $fecha_clave.$clave;
		$_SESSION["clave_carrito"]=$clavefinal;
	}else{
		while($result = mysqli_fetch_object($req)){
			unset($_SESSION['clave_carrito']);
			$clave_carrito = $result->clave_carrito;
			$_SESSION["clave_carrito"]=$clave_carrito;
		}
	}
	$clave_carrito = $_SESSION["clave_carrito"];
	if(isset($_GET['key']) AND $_GET['key']!=""){
		$key=$_GET['key'];
	}

	if((isset($_SESSION['keys']) AND $_SESSION['keys']!="") AND (isset($_GET['key']) AND $_GET['key']!="")){
		for($i=0;$i<count($_SESSION['keys']);$i++){
			if($key!= $_SESSION['keys'][$i]){
				$pass=true;
			}else{$pass=false;}
		};
	}else{
		$pass=true;
	}

	//CATCH CARRITO
	if((isset($_GET['addprodcut']) AND $_GET['addprodcut'] != "") AND (isset($_GET['cantidadproducto']) AND $_GET['cantidadproducto'] != "") AND $pass==true){
		$addprodcut = $_GET['addprodcut'];
		$cantidadproducto = $_GET['cantidadproducto'];
		$addvendor = $_GET['addvendor'];
		$id_vendedor_carrito = $_GET['addvendor'];
		$addprecio = $_GET['addprecio'];
		$addprecioEnvio = $_GET['addenvio'];
		$addcolor = $_GET['addcolor'];
		$addtalla = $_GET['addtalla'];
		//CHECK
		$checkExist="SELECT id_carrito, clave_carrito, id_user_carrito,id_producto_carrito, talla_producto_carrito, color_producto_carrito, cantidad_producto_carrito, id_vendedor_carrito FROM carrito WHERE clave_carrito=$clave_carrito AND id_user_carrito = $user_id AND id_producto_carrito = $addprodcut AND talla_producto_carrito = '$addtalla' AND color_producto_carrito='$addcolor' AND id_vendedor_carrito = $id_vendedor_carrito";
		$reqExist=mysqli_query($conex, $checkExist);
		$ProdCheck = $reqExist->num_rows;
		if($ProdCheck==0){
			$AddProduct="INSERT INTO carrito
			(clave_carrito, id_user_carrito, id_producto_carrito, talla_producto_carrito,color_producto_carrito,cantidad_producto_carrito,id_vendedor_carrito,precioart_carrito,costo_envio_carrito) VALUES ('$clave_carrito','$user_id', '$addprodcut', '$addtalla','$addcolor','$cantidadproducto','$id_vendedor_carrito','$addprecio', '$addprecioEnvio')";
		}else{
			while($resultExist = mysqli_fetch_object($reqExist)){
				$cantidad_producto_carrito = $resultExist->cantidad_producto_carrito;
				$id_carrito= $resultExist->id_carrito;
			}
			$updatecantidad=$cantidad_producto_carrito+$cantidadproducto;
			$AddProduct="UPDATE carrito SET cantidad_producto_carrito = $updatecantidad WHERE id_carrito  = $id_carrito";
		}
		if ($conex->query($AddProduct) === TRUE) {
			$_SESSION['keys'][] = $key;
		} else {
			$aviso="Lo sentimos no es posible guardar tu producto.";
		}
	}


?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Mi carrito | Ecommerce</title>
<?php include("parts/head.php"); ?>
<script src="<?php echo $urlserver?>js/bootstrap-input-spinner.js"></script>
</head>

<body>
	<?php include("parts/header.php"); ?>
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		 <li class="breadcrumb-item"><a href="<?php echo $urlserver?>"> Inicio</a></li>
		  <li class="breadcrumb-item active" aria-current="page">Carrito</li>
		  <li class="breadcrumb-item">Envio</li>
		 <li class="breadcrumb-item">Confirmación</li>
	  </ol>
	</nav>
	<section id="carrito">
		<form method="post" accept-charset="UTF-8" action="<?php echo $urlserver.'checkout'?>" id="micarrito">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-2 d-none d-sm-none d-md-none d-lg-block">
						<div class="d-flex h-100">
						<a href="" class="justify-content-center align-self-center" id="goback-carrito" onClick="goBack()"><i class="fas fa-reply"></i> Seguir comprando</a>
						</div>
					</div>
					<div class="col-lg-5 col-md-12" id="box-products-list">
						<?php
									$subtotal=0;
									$totalenvios = 0;
									//POR CATEGORIA
									$sqlTienda = "SELECT c.clave_carrito, c.id_vendedor_carrito, c.status_carrito,
									t.id_tienda, t.nombre_tienda
									FROM carrito c, tiendas t WHERE c.clave_carrito = $clave_carrito AND c.id_vendedor_carrito=t.id_tienda AND c.id_user_carrito = $user_id AND c.status_carrito IS NULL GROUP BY c.id_vendedor_carrito";
									$reqTienda=mysqli_query($conex, $sqlTienda);
									$carritoVacio = $reqTienda->num_rows;
									$txtcarrito ="Su carrito está vacio.";
									if($carritoVacio!=0){
									while($resultTienda = mysqli_fetch_object($reqTienda)){
										$id_vendedor_carrito = $resultTienda->id_vendedor_carrito;
										$nombre_tienda = $resultTienda->nombre_tienda;
									?>
									<table id="vendedor-<?php echo $id_vendedor_carrito?>" class="box-carrito-producto" class="table">
										<tbody id="box-list-items">
										<tr><th colspan="4" align="left">Tienda: <?php echo $nombre_tienda?></th></tr>
									<?php
									//OBTENGO LOS PRODUCTOS DE ESA CATEGORÍA
									$sqlcarrito ="SELECT c.id_carrito, c.clave_carrito, c.id_user_carrito, c.status_carrito, c.id_producto_carrito, c.id_vendedor_carrito, c.precioart_carrito, c.cantidad_producto_carrito, c.color_producto_carrito, c.talla_producto_carrito, c.notas_carrito, c.costo_envio_carrito,
									p.id_producto, p.nombre_producto, p.img_a_producto, p.id_tienda_producto, p.precio_producto, p.precio_promo_producto, p.talla_producto, p.color_tallas, p.activo_producto, p.url_producto, p.tarifa_envio_producto, p.costo_envio_productos,
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
										<button class="btn btn-shopnow" onclick="goBack()">Volver a la tienda.</button>
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
										$url_producto = $result->url_producto;
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
								<tr class="lista-producto" id="item-<?php echo $id_carrito?>">
									<td width="30px"><a href="#" onClick="eliminarItem('<?php echo $id_carrito?>','<?php echo $clave_carrito?>')" class="eliminarItem"><i class="far fa-times-circle"></i></a></td>
									<td width="90px" class="tdimg"><img src="<?php echo SITEUSER."img/tiendas/".$nick_tienda.'/'.$img_a_producto?>" alt="" width="80px"></td>
									<td>
										<a href="<?php echo SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$url_producto?>" class="title-product-link"><?php echo $nombre_producto?></a>
										<p style="font-size: 13px; line-height: 10px; margin-bottom: 5px">Variante: <?php echo $talla_producto?></p>
										<p style="font-size: 13px; line-height: 10px; margin-bottom: 5px">Color: <?php echo $color_tallas?></p>
										<input type="number" value="<?php echo $cantidad_producto_carrito?>" min="1" max="10" step="1" name="cantidadprod[]" id="idproductshop-<?php echo $id_carrito?>"/>
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
									<tr><td width="30px"></td><td colspan="3" height="15px" align="right"><span style="font-size: 12px; color: #3e6d38">Envío: $<?php echo $precio_envio_por_producto?></span></td></tr>
									<tr><td colspan="4"></td></tr>	
									<?php
									}	
									}									
								?>
							</tbody>
						</table>
						<?php 
							}
							}else{
							unset($_SESSION['clave_carrito']);
						?>
						<div id="aviso-carrito" class="show">
							<h3>Su carrito está vacio.</h3>
							<button class="btn btn-shopnow" onclick="goBack()">Volver a la tienda.</button>
						</div>
						<?php }?>
						<div id="aviso-carrito" class="hidden">
							<h3>Su carrito está vacio.</h3>
							<button class="btn btn-shopnow" onclick="goBack()">Volver a la tienda.</button>
						</div>
						<?php if($carritoVacio != 0){?>
						<div id="box-btn-notas" class="<?php echo $showclass?>">
							<div class="clearfix"></div>
							<label for="notapedido">Agregue una nota a su pedido:</label>
							<textarea class="form-control" name="notapedido" id="notapedido"><?php echo $notas_carrito?></textarea>
							<div class="clearfix"></div>
							<button class="btn btn-update-carrito my-3" onClick="actualizarcarrito()">Actualizar Carrito</button>
							<div class="clearfix"></div>

						</div>
						<?php }?>
					</div>
					<div class="col-lg-4 col-md-12" id="ticket-carrito">
						<div class="d-flex h-100">
								<div class="justify-content-center align-self-center" id="div-center-ticket">
									<h3 id="title-ticket"><?php echo $txtcarrito?></h3>
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
												<td align="right">$<?php echo $totalenvios?>
												</td>
											</tr>
											<!--<tr id="descuento">
												<td>Descuento:</td>
												<td align="right">-$20</td>
											</tr>-->
											<tr id="total-box-carrito">
												<td valign="middle" id="totalbox">Total: </td>
												<td  valign="middle" align="right" id="totalnum">$<?php echo $total = $totalenvios+$subtotal?>*<br><p style="font-size: 11px; margin: 5px 0; padding: 0">*IVA incluido</p></td>
											</tr>
											<tr>
												<td colspan="2">
													<button class="btn btn-comprar" type="submit">Comprar</button>
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
			<input type="hidden" value="<?php echo $clave_carrito?>" name="clavecarrito">
		</form>
	</section>
	<?php include("parts/footer.php"); ?>
	<script>
		$("input[type='number']").inputSpinner();
		function eliminarItem(id,clave){
			event.preventDefault();
			var myobj = document.getElementById("item-"+id);
  			console.log(myobj);
			/*AJAX*/
			$.ajax({
				url: "<?php echo $urlserver.'functions/menoscarrito.php?idCarrito='?>"+id+"&clavecarrito="+clave,
				success: function(info) {
					if(info == 1){
						console.log(info);
						myobj.remove();
						window.location.replace('<?php echo SITEUSER.'carrito'?>');
					}else if(info == 2){
						alert("Error al borrar el producto de tu carrito.");
					}else{
						console.log(info);
					}
				},
				error: function() {
					window.location.replace('<?php echo SITEUSER.'carrito'?>');
				}
			});
			var c = document.getElementById("box-list-items").childElementCount;
  			if(c==0){
				//$("#aviso-carrito").removeClass("hidden");
				//$("#aviso-carrito").addClass("show");
				//$("#box-btn-notas").addClass("hidden");
				//document.getElementById("list-ticket").innerHTML = "Su carrito está vacío.";
			}
		}
		function actualizarcarrito(){
			console.log("Actualizar Carrito");
			event.preventDefault();
			var formData = $('#micarrito').serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo $urlserver.'functions/actualziarcarrito.php'?>",
				data : formData,
				success: function(info) {
					console.log(info);
					window.location.replace('<?php echo $urlserver.'carrito'?>');
				},
				error: function(info) {
					console.log(info);
					window.location.replace('<?php echo $urlserver.'carrito'?>');
				}
			});
		}
		function goBack() {
		  event.preventDefault();
		  window.history.back();
		}
		if ($(window).width() < 480) {
			$(window).scroll(function(){ 
				var footerY = $("footer").height();
				var tikerY = $("#carrito").height();
				if ($(window).scrollTop() >= ($(document).height() - tikerY - footerY)){ 
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
