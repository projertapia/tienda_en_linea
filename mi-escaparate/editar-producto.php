<?php
	session_start();
	require('connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.SITE.'entrar');
	}
	if(isset($_GET['mod'])){
		$status="Actualizado con éxito";
	}else{
		$status="";
	}
	if(isset($_GET['id']) AND $_GET['id']!=""){
		$id_product = $_GET['id'];
		$sqlProd="SELECT * FROM productos WHERE id_producto = $id_product";
		$reqProd=mysqli_query($conex, $sqlProd);
		while($resulProd = mysqli_fetch_object($reqProd)){
			$id_producto  = $resulProd->id_producto;
			$nombre_producto = $resulProd->nombre_producto;
			$url_producto = $resulProd->url_producto;
			$codigo_producto = $resulProd->codigo_producto;
			$stock_producto = $resulProd->stock_producto;
			$precio_producto = $resulProd->precio_producto;
			$comision_producto = $resulProd->comision_producto;
			$precio_promo_producto = $resulProd->precio_promo_producto;
			$costo_envio_productos = $resulProd->costo_envio_productos;
			$titulo_desc_producto = $resulProd->titulo_desc_producto;
			$txt_desc_producto = $resulProd->txt_desc_producto;
			$img_tallas_producto = $resulProd->img_tallas_producto;
			$img_a_producto = $resulProd->img_a_producto;
			$img_b_producto = $resulProd->img_b_producto;
			$img_c_producto = $resulProd->img_c_producto;
			$img_d_producto = $resulProd->img_d_producto;
			$img_e_producto = $resulProd->img_e_producto;
			$talla_producto = $resulProd->talla_producto;
			$color_tallas = $resulProd->color_tallas;
			$tags_producto = $resulProd->tags_producto;
			$categoria_producto = $resulProd->categoria_producto;
			$activo_producto = $resulProd->activo_producto;
		}
		if($precio_promo_producto == 0 OR $precio_promo_producto== NULL){
			$precio = $precio_producto;
		}else{
			$precio = $precio_promo_producto;
		}
		
		if($comision_producto==NULL OR $comision_producto==""){
			$comision_producto= $precio * ($porcentaje_suscripcion_tiendas/100);
		}
	}else{
		header('location:'.SITE.'mis-productos');
	}
	if($activo_producto==1){
		$visible ="Visible";
	}else{
		$visible ="Oculto";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mi escaparate en | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>mi-escaparate/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo SITE?>mi-escaparate/js/tags.js"></script>
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
			<section id="edit-product">
				<h1 id="titlesection">Editar producto</h1>
				<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="../functions/guardaredicion.php">
					<input type="hidden" value="<?php echo $id_producto?>" name="id_producto" required>
					<div class="col-md-12 col-lg-8 col-xl-9">
					<div class="row card-header lista-prodcutos">
						<div class="form-group">
							<label for="nombre_producto">Nombre del producto</label>
							<input type="text" name="nombre_producto" class="form-control form-control-lg" id="nombre_producto" onkeyup="urlAmigable()" value="<?php echo $nombre_producto?>" required>
						</div>
						<div class="form-group">
							<label for="url_producto">URL del producto</label>
							<input type="text" name="url_producto" class="form-control form-control-sm" value="<?php echo $url_producto?>" id="url_producto" required pattern="[a-z0-9-]{3,50}" onKeyUp="valideurlamigable()" title="Ingresa solo el nombre corto o identificador de tu producto. No uses links (urls) de sitios webs guiones bajos, diagonales, acentos, caracteres  especiales.">
							<p id="urlamigable"><strong>Previo de link de producto: </strong><?php echo SITE.$categoria_tienda.'/'.$nick_tienda.'/'?><span id="productlink"><?php echo $url_producto?></span></p>
						</div>
						<hr>
						<div class="form-group">
							<label for="titulo_desc_producto">Titulo descripción</label>
							<input type="text" name="titulo_desc_producto" class="form-control" value="<?php echo $titulo_desc_producto?>" required>
						</div>
						<div class="form-group">
							<label for="txt_desc_producto">Descripción</label>
							<textarea id="descinfo" name="txt_desc_producto">
								<?php echo $txt_desc_producto?>
							</textarea>
						</div>
						<hr>
						<div class="card" style="width: 100%">
  							<div class="card-body row">
								<div class="col-6">
									<div class="form-group">
										<label for="codigo_producto">Código de Producto</label>
										<input type="text" name="codigo_producto" class="form-control" value="<?php echo $codigo_producto?>" required>
									</div>
								</div>
								<div class="col-6">									
									<div class="form-group">
										<label for="stock_producto">Cantidad de inventario</label>
										<input type="number" name="stock_producto" class="form-control" value="<?php echo $stock_producto?>" required>
									</div>
								</div>
								<div class="clearfix"></div>
								<hr>
								<div class="col-lg-12 col-xl-4">
									<div class="form-group">
										<label for="talla_producto">Tallas / Tamaño / Estilo</label>
										<input type="text" name="talla_producto" class="form-control" id="talla_producto" value="<?php echo $talla_producto?>" data-role="tagsinput" required>
										<p><small>Separados por comas.</small></p>
									</div>
								</div>
								<div class="col-lg-12 col-xl-4">
									<div class="form-group">
										<label for="color_tallas">Color / Atributos</label>
										<input type="text" name="color_tallas" class="form-control" id="color_tallas" value="<?php echo $color_tallas?>" data-role="tagsinput" required>
										<p><small>Separados por comas.</small></p>
									</div>
								</div>
								<div class="col-lg-12 col-xl-4">
									<div class="form-group">
										<label for="color_tallas">Etiquetas</label>
										<input type="text" name="tags_producto" class="form-control" id="tags_producto" value="<?php echo $tags_producto?>" data-role="tagsinput" required>
										<p><small>Separados por comas.</small></p>
									</div>
								</div>
								<div class="clearfix"></div>
								<hr>
								
								<h5 class="card-title">Imágenes</h5>
								<div class="row">
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_a_producto?>" alt="Imagen" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';" id="img-img_a_producto">
										<div class="form-group">
											<label for="img_a_producto">Imagen 1</label>
											<div class="input-group mb-3">
											  <div class="custom-file">
												<input type="file" class="custom-file-input" name="img_a_producto" accept="image/jpeg">
												<label class="custom-file-label" for="img_a_producto">Subir Archivo nuevo</label>
											  </div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_b_producto?>" alt="Imagen" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';" id="img-img_b_producto">
										<div class="form-group">
											<label for="img_b_producto">Imagen 2</label>
											<div class="input-group mb-3">
											  <div class="custom-file">
												<input type="file" class="custom-file-input" name="img_b_producto" accept="image/jpeg">
												<label class="custom-file-label" for="img_b_producto">Subir Archivo nuevo</label>
											  </div>
											</div>
										</div>
										<div class="form-check">
										  <input type="hidden" name="namefotob" value="<?php echo $img_b_producto?>">
										  <input class="form-check-input" type="checkbox" name="fotob" value="borrarb" id="fotob">
										  <label class="form-check-label" for="fotob">
											Eliminar imagen
										  </label>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_c_producto?>" alt="Imagen" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';" id="img-img_c_producto">
										<div class="form-group">
											<label for="img_c_producto">Imagen 3</label>
											<div class="input-group mb-3">
											  <div class="custom-file">
												<input type="file" class="custom-file-input" name="img_c_producto" accept="image/jpeg">
												<label class="custom-file-label" for="img_c_producto">Subir Archivo nuevo</label>
											  </div>
											</div>
										</div>
										<div class="form-check">
										  <input type="hidden" name="namefotoc" value="<?php echo $img_c_producto?>">
										  <input class="form-check-input" type="checkbox" name="fotoc" value="borrarc" id="fotoc">
										  <label class="form-check-label" for="fotoc">
											Eliminar imagen
										  </label>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_d_producto?>" alt="Imagen" onerror="this.src='<?php echo SITE.'img/default-image-product.jpg'?>';" id="img-img_d_producto">
										<div class="form-group">
											<label for="img_d_producto">Imagen 4</label>
											<div class="input-group mb-3">
											  <div class="custom-file">
												<input type="file" class="custom-file-input" name="img_d_producto" accept="image/jpeg">
												<label class="custom-file-label" for="img_d_producto">Subir Archivo nuevo</label>
											  </div>
											</div>
										</div>
										<div class="form-check">
										  <input type="hidden" name="namefotod" value="<?php echo $img_d_producto?>">
										  <input class="form-check-input" type="checkbox" name="fotod" value="borrard" id="fotod">
										  <label class="form-check-label" for="fotod">
											Eliminar imagen
										  </label>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					</div>
					<div class="col-md-12 col-lg-4 col-xl-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Publicar</h5>
							</div>
							<div class="card-body">
								<div style="width: 100%">
									<span><?php echo $status?></span>
									<p>Visibilidad: <?php echo $visible?></p>									
								</div>
								<?php if($TotalProd_rows <= $cantidad_suscripcion_tiendas){ ?>
								<button type="submit" name="guardar" id="guardar" class="btn btn-success  my-2">Guardar</button>
								<?php }else{ ?>
								<h6>Haz alacanzado el limite de tus productos publicados.</h6>
								<?php } ?>
								<button type="submit" name="ocultar" id="ocultar" class="btn btn-dark my-2">Ocultar</button>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Categoría</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="categoria_producto">Categoría de producto</label>
									<select name="categoria_producto" class="form-control">
										<?php
											$sqlCat="SELECT nombre_categoria, tag_categoria, activo_categoria FROM categorias WHERE activo_categoria =1";
											$reqCat=mysqli_query($conex, $sqlCat);
											while($resulCat = mysqli_fetch_object($reqCat)){
												$nombre_categoria  = $resulCat->nombre_categoria;
												$tag_categoria  = $resulCat->tag_categoria;
												if($categoria_producto==$tag_categoria){
										?>
										<option value="<?php echo $tag_categoria?>" selected><?php echo $nombre_categoria?></option>
										<?php }else{
										?>
										<option value="<?php echo $tag_categoria?>"><?php echo $nombre_categoria?></option>
										<?php }}?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="card lista-prodcutos">
							<div class="card-header">
								<h5 class="card-title">Precio</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="precio_producto">Precio</label>
									<input type="number" name="precio_producto" id="precio_producto" class="form-control" onchange="calc()"  onkeyup="calc()" required step="any" value="<?php echo $precio_producto?>">
									<small>Ingresa el precio con IVA</small>
								</div>
								<div class="form-group">
									<label for="precio_promo_producto">Precio en promoción</label>
									<input type="number" name="precio_promo_producto" id="precio_promo_producto" onchange="calc()" onkeyup="calc()" class="form-control" step="any" value="<?php echo $precio_promo_producto?>">
									<small>Ingresa el precio con IVA</small>
								</div>
								<div class="form-group">
									<label for="costo_envio_productos">Costo de envío</label>
									<input name="costo_envio_productos" type="number" id="costo_envio_productos" onchange="calc()" onkeyup="calc()" required class="form-control" min="0" step="any" value="<?php echo $costo_envio_productos?>">
									<input type="hidden" name="comision" id="comisionform" value="<?php echo $comision_producto?>">
								</div>
							</div>
							<div class="card-footer" id="box-precio-prev">
								<p>Precio: <span id="precio"><?php echo "$".$precio?></span></p>
								<p>Comisión <?php echo $porcentaje_suscripcion_tiendas?>%: <span id="comision"><?php echo "$".$comision_producto?></span></p>
								<p>Envío: <span id="envio"><?php echo "$".$costo_envio_productos?></span></p>
								<?php
									if($comision_producto==0 OR $comision_producto==NULL){
										$subtotal=  $precio+$comision_producto+$costo_envio_productos;
									}else{
										$subtotal=  $precio+$comision_producto;
									}
									$subtotal=  round($subtotal,2, PHP_ROUND_HALF_UP);
									$iva= round($subtotal*0.16,2, PHP_ROUND_HALF_UP);
									$total= round($subtotal+$iva,2, PHP_ROUND_HALF_UP);
								?>
								<p>SubTotal: <span id="subtotal"><?php echo "$".$subtotal?></span></p>
								<p>I.V.A.: <span id="iva"><?php echo "$".$iva?></span></p>
								<h4>Precio al público: <span id="total"><?php echo "$".$total?></span></h4>
								<script>
									function redondearDecimales(numero, decimales) {
										numeroRegexp = new RegExp('\\d\\.(\\d){' + decimales + ',}'); // Expresion regular para numeros con un cierto numero de decimales o mas
										if (numeroRegexp.test(numero)) { // Ya que el numero tiene el numero de decimales requeridos o mas, se realiza el redondeo
											return Number(numero.toFixed(decimales));
										} else {
											return Number(numero.toFixed(decimales)) === 0 ? 0 : numero; // En valores muy bajos, se comprueba si el numero es 0 (con el redondeo deseado), si no lo es se devuelve el numero otra vez.
										}
									}
									function calc() {
										var porcentajecomision= Number(<?php echo $porcentaje_suscripcion_tiendas/100?>);
										var precio_producto= $("#precio_producto").val();
										var costo_envio_productos= Number($("#costo_envio_productos").val());
										var precio_promo_producto= $("#precio_promo_producto").val();										
										if(costo_envio_productos==""){
											costo_envio_productos= Number(0);
										};
										if(precio_promo_producto!= "" || precio_promo_producto!=0){
											var cuenta = Number(precio_promo_producto);
										}else{
											var cuenta = Number(precio_producto);
										}										
										var comision = cuenta*porcentajecomision;
										var precio_comision_envio = Number(cuenta) + Number(comision) + Number(costo_envio_productos);
										
										
										var iva=precio_comision_envio * 0.16;
										
										var total = precio_comision_envio+iva;
										document.getElementById('subtotal').innerText = "$"+ redondearDecimales(precio_comision_envio,2);
										document.getElementById('precio').innerText = "$"+ redondearDecimales(cuenta,2);
										document.getElementById('iva').innerText = "$"+ redondearDecimales(iva,2);
										document.getElementById('total').innerText = "$"+ redondearDecimales(total,2);
										document.getElementById('comision').innerText = "$"+ redondearDecimales(comision,2);
										document.getElementById('comisionform').value = redondearDecimales(comision,2);
										document.getElementById('envio').innerText = "$"+ redondearDecimales(costo_envio_productos,2);
									};
								</script>
							</div>
						</div>
						
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Imágen para descripción</h5>
							</div>
							<div class="card-body">
								<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_e_producto?>" alt="Imagen" onerror="this.src='<?php echo SITE.'img/prevtallas.jpg'?>';" id="img-img_e_producto">
								<div class="form-group">
									<label for="img_e_producto">Imagen para descripción</label>
									<div class="input-group mb-3">
									  <div class="custom-file">
										<input type="file" class="custom-file-input" name="img_e_producto" accept="image/jpeg">
										<label class="custom-file-label" for="img_e_producto">Subir Archivo nuevo</label>
									  </div>
									</div>
								</div>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Imagen para tallas/variantes</h5>
							</div>
							<div class="card-body">
								<img class="card-img-top" src="<?php echo SITE.'img/tiendas/'.NICKTIENDA.'/'.$img_tallas_producto?>" alt="Imagen" onerror="this.src='<?php echo SITE.'img/prev_desc.jpg'?>';" id="img-img_tallas_producto">
								<div class="form-group">
									<label for="img_tallas_producto">Imágen referente tallas / variantes </label>
									<div class="input-group mb-3">
									  <div class="custom-file">
										<input type="file" class="custom-file-input" name="img_tallas_producto" accept="image/jpeg">
										<label class="custom-file-label" for="img_tallas_producto">Subir Archivo nuevo</label>
									  </div>
									</div>
								</div>
								<div class="form-check">
								  <input type="hidden" name="namefotot" value="<?php echo $img_tallas_producto?>">
								  <input class="form-check-input" type="checkbox" name="img_tallas" value="borrart" id="img_tallas">
								  <label class="form-check-label" for="img_tallas">
									Eliminar imagen
								  </label>
								</div>
							</div>
						</div>
					</div>
				</form>
			</section>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
		$('#tags_producto').tagsinput({
		  tagClass: 'label label-primary',
			trimValue: true,
			allowDuplicates: true
		}); 
		$('#color_tallas').tagsinput({
		  tagClass: 'label label-primary',
			trimValue: true,
			allowDuplicates: true
		}); 
		$('#talla_producto').tagsinput({
		  tagClass: 'label label-primary',
			trimValue: true,
			allowDuplicates: true
		}); 
		CKEDITOR.replace( 'descinfo',{
			language: 'es-mx',
			uiColor: '#d1d1e0',
			height: 200
		});
		
		//IMG CHANGE
		function readURL(input,Apreload) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
				$('#img-'+Apreload).attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$(".custom-file-input").change(function() {
			var preload=($(this).attr('name'));
			readURL(this,preload);
		});
		//URLAMIGABLE
		function urlAmigable(){
			var key=$("#nombre_producto").val();
			key=key.replace("https://","");
			key=key.replace("http://","");
			key=key.replace("www.","");
			key=key.replace(".com","");
			key=key.replace(".com.mx","");
			key=key.replace("/","-");
			var chars={
			"á":"a", "é":"e", "í":"i", "ó":"o", "ú":"u",
			"à":"a", "è":"e", "ì":"i", "ò":"o", "ù":"u", "ñ":"n",
			"Á":"A", "É":"E", "Í":"I", "Ó":"O", "Ú":"U",
			"À":"A", "È":"E", "Ì":"I", "Ò":"O", "Ù":"U", "Ñ":"N"}
			var expr=/[áàéèíìóòúùñ]/ig;
			key=key.replace(expr,function(e){return chars[e]});
			key = key.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
			//key=key.replace(/[^0-9a-zA-Z_\s]/g, "");
			//key=key.replace(" ","-");
			key=key.toLowerCase()
			$("#url_producto").val(key);
			$("#productlink").html(key);
		}
		function valideurlamigable(){			
			var key=$("#url_producto").val();
			key=key.replace("https://","");
			key=key.replace("http://","");
			key=key.replace("www.","");
			key=key.replace(".com","");
			key=key.replace(".com.mx","");
			key=key.replace("/","-");
			var chars={
			"á":"a", "é":"e", "í":"i", "ó":"o", "ú":"u",
			"à":"a", "è":"e", "ì":"i", "ò":"o", "ù":"u", "ñ":"n",
			"Á":"A", "É":"E", "Í":"I", "Ó":"O", "Ú":"U",
			"À":"A", "È":"E", "Ì":"I", "Ò":"O", "Ù":"U", "Ñ":"N"}
			var expr=/[áàéèíìóòúùñ]/ig;
			key=key.replace(expr,function(e){return chars[e]});
			key = key.replace(/[^a-z0-9-\s]/gi, '').replace(/[_\s]/g, '-');
			//key=key.replace(/[^0-9a-zA-Z_\s]/g, "");
			//key=key.replace(" ","-");
			key=key.toLowerCase();
			$("#productlink").html(key);
		}
		$("#url_producto").focusout(function() {
			var key=$("#url_producto").val();
			key=key.replace("https://","");
			key=key.replace("http://","");
			key=key.replace("www.","");
			key=key.replace(".com","");
			key=key.replace(".com.mx","");
			key=key.replace("/","-");
			var chars={
			"á":"a", "é":"e", "í":"i", "ó":"o", "ú":"u",
			"à":"a", "è":"e", "ì":"i", "ò":"o", "ù":"u", "ñ":"n",
			"Á":"A", "É":"E", "Í":"I", "Ó":"O", "Ú":"U",
			"À":"A", "È":"E", "Ì":"I", "Ò":"O", "Ù":"U", "Ñ":"N"}
			var expr=/[áàéèíìóòúùñ]/ig;
			key=key.replace(expr,function(e){return chars[e]});
			key = key.replace(/[^a-z0-9-\s]/gi, '').replace(/[_\s]/g, '-');
			//key=key.replace(/[^0-9a-zA-Z_\s]/g, "");
			//key=key.replace(" ","-");
			key=key.toLowerCase();
			$("#url_producto").val(key);
			valideurlamigable();
		});
	</script>
</body>
</html>