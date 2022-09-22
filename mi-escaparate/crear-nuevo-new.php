<?php
	session_start();
	require('connect/conect_usrer.php');
	if (!isset($_SESSION['tiendauser']) OR $_SESSION['tiendauser']=="") {
			header('location:'.SITE.'entrar');
	}

$idtienda = $_SESSION["idtienda"];
 
if($TotalProd_rows < $cantidad_suscripcion_tiendas){
	$pass=true;
}else{
	$pass=false;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Nuevo producto - <?php echo NICKTIENDA?> | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>mi-escaparate/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo SITE?>mi-escaparate/js/tags.js"></script>
<script src="<?php echo SITE?>js/cropper.js"></script>
<link rel="stylesheet" href="<?php echo SITE?>css/cropper.css">
<style>
    .label{cursor: pointer;}
    .progress{display: none;margin-bottom: 1rem;}
    .alert{display: none;}
	.img-container img {max-width: 100%;}
  </style>
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
			<?php if($pass == true){?>
			<section id="edit-product">
				<h1 id="titlesection">Nuevo producto</h1>
				<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="functions/guardarnuevo-new.php" id="form-new-prod">
					<input type="hidden" name="id_producto" required>
					<div class="col-md-12 col-lg-8 col-xl-9">
					<div class="row card-header lista-prodcutos">
						<div class="form-group">
							<label for="nombre_producto">Nombre del producto</label>
							<input type="text" name="nombre_producto" id="nombre_producto" class="form-control form-control-lg" onkeyup="urlAmigable()" required>
						</div>
						<div class="form-group">
							<label for="url_producto">URL del producto</label>
							<input type="text" name="url_producto" id="url_producto" class="form-control form-control-sm" required pattern="[a-z0-9-]{3,50}" onKeyUp="valideurlamigable()" title="Ingresa solo el nombre corto o identificador de tu producto. No uses links (urls) de sitios webs guiones bajos, diagonales, acentos, caracteres  especiales.">
							<p id="urlamigable"><strong>Previo de link de producto: </strong><?php echo SITE.$categoria_tienda.'/'.$nick_tienda.'/'?><span id="productlink"></span></p>
						</div>
						<hr>
						<div class="form-group">
							<label for="titulo_desc_producto">Titulo descripción</label>
							<input type="text" name="titulo_desc_producto" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="txt_desc_producto">Descripción</label>
							<textarea id="descinfo" name="txt_desc_producto"></textarea>
						</div>
						<hr>
						<div class="card" style="width: 100%" id="atributos-box">
  							<div class="card-body row">
								<div class="col-6">
									<div class="form-group">
										<label for="codigo_producto">Código de Producto</label>
										<input type="text" name="codigo_producto" class="form-control" required>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="stock_producto">Cantidad de inventario</label>
										<input type="number" name="stock_producto" class="form-control" required min="0">
									</div>
								</div>
								<div class="clearfix"></div>
								<hr>
								<div class="col-lg-12 col-xl-4 rounded" id="box-talla">
									<div class="form-group">
										<label for="talla_producto">Tallas / Tamaño / Estilo</label>
										<input type="text" name="talla_producto" class="form-control" id="talla_producto" data-role="tagsinput">
										<p><small>Separados por comas.</small></p>
									</div>
								</div>
								<div class="col-lg-12 col-xl-4 rounded" id="box-atributo">
									<div class="form-group">
										<label for="color_tallas">Color / Atributos</label>
										<input type="text" name="color_tallas" class="form-control" id="color_tallas" data-role="tagsinput">
										<p><small>Separados por comas.</small></p>
									</div>
								</div>
								<div class="col-lg-12 col-xl-4 rounded" id="box-tag">
									<div class="form-group">
										<label for="color_tallas">Etiquetas</label>
										<input type="text" name="tags_producto" class="form-control" id="tags_producto" data-role="tagsinput">
										<p><small>Separados por comas.</small></p>
									</div>
								</div>
								<div class="clearfix"></div>
								<hr>
								
								<h5 class="card-title">Imágenes</h5>
								<div class="row">
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<label class="label" data-toggle="tooltip" title="Imagen 1">
										<img class="card-img-top" src="<?php echo SITE.'img/default-image-product.jpg'?>" alt="Imagen" id="img-img_a_producto">
										<input type="file" class="sr-only inputimg" name="img_a_producto" id="img_a_producto" accept="image/x-png,image/jpeg" data-imgid="img_a_producto">
										</label>
										<span>*Imagen requerida</span>
										<input type="hidden" name="txt-img_a_producto" id="txt-img_a_producto" required title="Por favor suba la imagen principal.">
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<label class="label" data-toggle="tooltip" title="Imagen 2">
										<img class="card-img-top" src="<?php echo SITE.'img/default-image-product.jpg'?>" alt="Imagen" id="img-img_b_producto">
										<input type="file" class="sr-only inputimg" name="img_b_producto" id="img_b_producto" accept="image/x-png,image/jpeg" data-imgid="img_b_producto">
										</label>
										<input type="hidden" name="txt-img_b_producto" id="txt-img_b_producto">
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<label class="label" data-toggle="tooltip" title="Imagen 3">
										<img class="card-img-top" src="<?php echo SITE.'img/default-image-product.jpg'?>" alt="Imagen" id="img-img_c_producto">
										<input type="file" class="sr-only inputimg" name="img_c_producto" id="img_c_producto" accept="image/x-png,image/jpeg" data-imgid="img_c_producto">
										</label>
										<input type="hidden" name="txt-img_c_producto" id="txt-img_c_producto">
									</div>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-3">
									<div class="card-body">
										<label class="label" data-toggle="tooltip" title="Imagen 4">
										<img class="card-img-top" src="<?php echo SITE.'img/default-image-product.jpg'?>" alt="Imagen" id="img-img_d_producto">
										<input type="file" class="sr-only inputimg" name="img_d_producto" id="img_d_producto" accept="image/x-png,image/jpeg" data-imgid="img_d_producto">
										</label>
										<input type="hidden" name="txt-img_d_producto" id="txt-img_d_producto">
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="progress">
		 					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
						</div>
						<div class="alert" role="alert"></div>
					</div>
					</div>
					<div class="col-md-12 col-lg-4 col-xl-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Publicar</h5>
							</div>
							<div class="card-body">
								<button type="submit" name="guardar" id="guardar" class="btn btn-success my-2">Guardar</button>							
								<button type="submit" name="ocultar" id="ocultar" class="btn btn-dark my-2">Guardar como borrador</button>
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
										?>
										<option value="<?php echo $tag_categoria?>"><?php echo $nombre_categoria?></option>
										<?php }?>
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
									<input type="number" name="precio_producto" id="precio_producto" class="form-control" onchange="calc()"  onkeyup="calc()" required step="any">
									<small>Ingresa el precio con IVA</small>
								</div>
								<div class="form-group">
									<label for="precio_promo_producto">Precio en promoción</label>
									<input type="number" name="precio_promo_producto" id="precio_promo_producto" onchange="calc()" onkeyup="calc()" class="form-control" step="any">
									<small>Ingresa el precio con IVA</small>
								</div>
								<div class="form-group">
									<label for="costo_envio_productos">Costo de envío</label>
									<input name="costo_envio_productos" type="number" id="costo_envio_productos" onchange="calc()" onkeyup="calc()" required class="form-control" min="0" step="any">
								</div>
							</div>
							<div class="card-footer" id="box-precio-prev">
								<p>Precio: <span id="precio"></span></p>
								<p>Comisión <?php echo $porcentaje_suscripcion_tiendas?>%: <span id="comision"></span></p>
								<p>Envío: <span id="envio"></span></p>
								<p>SubTotal: <span id="subtotal"></span></p>
								<p>I.V.A.: <span id="iva"></span></p>
								<h4>Precio al público: <span id="total"></span></h4>
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
										console.log(precio_comision_envio);
										
										var iva= precio_comision_envio * 0.16;
										
										var total = precio_comision_envio+iva;
										document.getElementById('subtotal').innerText = "$"+ redondearDecimales(precio_comision_envio,2);
										document.getElementById('precio').innerText = "$"+ redondearDecimales(cuenta,2);
										document.getElementById('iva').innerText = "$"+ redondearDecimales(iva,2);
										document.getElementById('total').innerText = "$"+ redondearDecimales(total,2);
										document.getElementById('comision').innerText = "$"+ redondearDecimales(comision,2);
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
								<label class="label" data-toggle="tooltip" title="Imagen para descripción">
									<img class="card-img-top" src="<?php echo SITE.'img/prev_desc.jpg'?>" alt="Imagen" id="img-img_e_producto">
									<input type="file" class="sr-only inputimg" name="img_e_producto" id="img_e_producto" accept="image/x-png,image/jpeg" data-imgid="img_e_producto">
								</label>
								<span>*Imagen requerida</span>
								<input type="hidden" name="txt-img_e_producto" id="txt-img_e_producto" required title="Por favor suba la imagen de descripción.">
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Imagen para tallas/variantes</h5>
							</div>
							<div class="card-body">
								<label class="label" data-toggle="tooltip" title="Imagen referente tallas / variantes">
									<img class="card-img-top" src="<?php echo SITE.'img/prevtallas.jpg'?>" alt="Imagen" id="img-img_tallas_producto">
									<input type="file" class="sr-only inputimg" name="img_tallas_producto" id="img_tallas_producto" accept="image/x-png,image/jpeg" data-imgid="img_tallas_producto">
								</label>
								<span>*Imagen requerida</span>
								<input type="hidden" name="txt-img_tallas_producto" id="txt-img_tallas_producto">
							</div>
						</div>
					</div>
				</form>
				<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalLabel">Cortar imagen</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="img-container">
								<img id="image" src="<?php echo SITE?>img/default-image-product.jpg">
							</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-primary" id="crop">Cortar</button>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php }else{ ?>
			<section id="edit-product">
				<div class="row">
					<div class="col-12">
						<h2>Lo sentimos no pudedes crear más productos.</h2><h3> Te recomendamos aumentar tu plan.</h3>
						<a href="<?php echo SITE.'mi-escaparate/mi-plan'?>" class="btn btn-success">Aumentar mi plan</a>
					</div>
				</div>
			</section>
			<?php } ?>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<?php if($pass == true){?>
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
		//UPLOADERFILES
		window.addEventListener('DOMContentLoaded', function () {
		//Variables especificas
		var avatar;
		var image = document.getElementById('image');
		var input;
		var $progress = $('.progress');
		var $progressBar = $('.progress-bar');
		var $alert = $('.alert');
		var $modal = $('#modal');
		//Variables generales
		var cropper;
		var filename;
		var dataimg;
		var aspc;
		var imgid;

		$('[data-toggle="tooltip"]').tooltip();
		//Evocamos funcion Start
		//input.addEventListener('change', function (e) {
			var element;
		$( ".inputimg" ).change(function(e) {
			var element = $(this),
    		imgid = element.data("imgid");
			avatar = document.getElementById('img-'+imgid);
			input = element;
			dataimg = imgid;
		
			var files = e.target.files;
			var done = function (url) {
				input.value = '';
				image.src = url;
				$alert.hide();
				$modal.modal({backdrop: 'static', keyboard: false},'show');
			};
			var reader;
			var file;
			var url;
			if (files && files.length > 0) {
				file = files[0];
				if (URL) {
					done(URL.createObjectURL(file));
				} else if (FileReader) {
					reader = new FileReader();
						reader.onload = function (e) {
						done(reader.result);
					};
					reader.readAsDataURL(file);
				}
				filename = file.name;
			}
		 });
		//Evocamos funcion End
		$modal.on('shown.bs.modal', function () {
			switch(dataimg){
				case 'img_a_producto':
					var aspc = 216/287;
					break;
				case 'img_b_producto':
					var aspc = 216/287;
					break;
				case 'img_c_producto':
					var aspc = 216/287;
					break;
				case 'img_d_producto':
					var aspc = 216/287;
					break;
				case 'img_e_producto':
					var aspc = 385/263;
					break;
				case 'img_tallas_producto':
					var aspc = 2/1;
					break;
				default:
					var aspc = 'NaN';
					break;
			}
		  
			cropper = new Cropper(image, {
				aspectRatio: aspc,
				viewMode: 2,
			});
		}).on('hidden.bs.modal', function () {
			cropper.destroy();
			cropper = null;
			document.getElementById(dataimg).value = '';
      	});

		document.getElementById('crop').addEventListener('click', function () {
        	var initialAvatarURL;
        	var canvas;
        	$modal.modal('hide');
			if (cropper) {
				switch (dataimg){
					case 'img_e_producto':
						var width= 770;
						var height= 526;
						break;
					case 'img_tallas_producto':
						var width= 800;
						var height= 400;
						break;
					default:
						var width= 648;
						var height= 861;
						break;
				}
				canvas = cropper.getCroppedCanvas({
					width: width,
					height: height,
				});
          		initialAvatarURL = avatar.src;
				avatar.src = canvas.toDataURL();
				$progress.show();
				$alert.removeClass('alert-success alert-warning');
				canvas.toBlob(function (blob) {
					var formData = new FormData();
					//console.log(filename+dataimg);
					formData.append('avatar', blob, filename);
					formData.append('part', dataimg);
					//console.log(formData);
					$.ajax('functions/uploader-img-escaparate.php', {
						method: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						xhr: function () {
							var xhr = new XMLHttpRequest();
						xhr.upload.onprogress = function (e) {
							var percent = '0';
							var percentage = '0%';
							if (e.lengthComputable) {
								percent = Math.round((e.loaded / e.total) * 100);
								percentage = percent + '%';
								$progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
							}
						};
						return xhr;
						},
						success: function (info) {
							$alert.show().addClass('alert-success').text('Subida exitosa');
							$("#txt-"+dataimg).val(info);
						},
						error: function (info) {
							avatar.src = initialAvatarURL;
							$alert.show().addClass('alert-warning').text('Error al subir');
							$("#txt-"+dataimg).val(info);
						},
						complete: function () {
							$progress.hide();
						},
					});
				});
			}
		});
	});
		
	$("#form-new-prod").submit(function(event){
		var tallas=$("#talla_producto").val();
		var color=$("#color_tallas").val();
		var tags=$("#tags_producto").val();
		var elmnt = document.getElementById("atributos-box");
		var faltantesT="";
		var faltantesC="";
		var faltantesE="";
		if(tallas==""){
			var faltantesT=("'Tallas / Tamaño / Estilo '");
			elmnt.scrollIntoView();
			$('#box-talla').addClass('border border-danger');
		}else{
			$('#box-talla').removeClass('border border-danger');
		}
		if(color==""){
			var faltantesC=("'Color / Atributos' ");
			elmnt.scrollIntoView();
			$('#box-atributo').addClass('border border-danger');
		}else{
			$('#box-atributo').removeClass('border border-danger');
		}
		if(tags==""){
			var faltantesE=("'Etiquetas' ");
			elmnt.scrollIntoView();
			$('#box-tag').addClass('border border-danger');
		}else{
			$('#box-tag').removeClass('border border-danger');
		}
		if(tags=="" || color=="" || tags==""){
			event.preventDefault();
			alert("Por favor ingresa: "+ faltantesT+faltantesC+faltantesE);
		}
		var imgprin=$("#txt-img_a_producto").val();
		var imgdesc=$("#txt-img_e_producto").val();
		var imgtalll=$("#txt-img_tallas_producto").val();
		console.log(imgprin+imgdesc);
		if(imgprin=="" || imgdesc=="" || imgtalll==""){
			alert("Por favor sube la imagen principal, la imagen de descripción y la imagen de tallas o variantes.");
			event.preventDefault();
		}else{
			
		}
	});
</script>
	<?php } ?>
	<style>
		/*input:invalid{
			border:2px solid #e63425; 
		}*/
		/*input:valid{
			border:2px solid #3e6d38; 
		}*/
	</style>
</body>
</html>