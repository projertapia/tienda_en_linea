<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['id']) AND $_GET['id']!=""){
		if(isset($_GET['mod'])){
			$status="Actualizado con éxito";
		}else{
			$status="";
		}
		$idPubli= $_GET['id'];
		$sqlPubli="SELECT p.id_publicidad, p.nombre_publicidad, p.fecha_inicio_publicidad, p.fecha_fin_publicidad, p.cliente_publicidad, p.tipo_publicidad, p.activo_publicidad, p.img_sq_a_publicidad, p.img_sq_b_publicidad, p.img_sq_c_publicidad, p.img_sq_d_publicidad, p.img_rq_a_publicidad, p.img_rq_b_publicidad, p.img_top_publicidad, p.show_tienda_publicidad, p.link_sqa_producto, p.link_sqb_producto, p.link_sqc_producto, p.link_sqd_producto, p.link_rqa_producto, p.link_rqb_producto,  p.link_hb_producto, p.tipo_precio_publicidad, p.precio_publicidad, p.descuento_precio_publicidad, p.total_precio_publicidad, p.show_categorias_publicidad, p.iva_publicidad,
		t.id_cliente_publi, t.nombre_cliente_publi, t.activo_cliente_publi
		FROM publicidad p, clientes_publi t WHERE p.id_publicidad = $idPubli AND t.id_cliente_publi = p.cliente_publicidad";
		$reqPubli=mysqli_query($conex, $sqlPubli);
		$TotalPubli = mysqli_num_rows($reqPubli);
		if($TotalPubli==0){
			header('location:'.SITE.'admin/publicidad');
		}
		while($resulPubli = mysqli_fetch_object($reqPubli)){
			$id_publicidad  = $resulPubli->id_publicidad;
			$nombre_publicidad  = $resulPubli->nombre_publicidad;
			$fecha_inicio_publicidad  = date_create($resulPubli->fecha_inicio_publicidad);
			$fecha_fin_publicidad  = date_create($resulPubli->fecha_fin_publicidad);
			$cliente_publicidad  = $resulPubli->cliente_publicidad;
			$tipo_publicidad  = $resulPubli->tipo_publicidad;
			$activo_publicidad  = $resulPubli->activo_publicidad;
			$show_tienda_publicidad = $resulPubli->show_tienda_publicidad;
			$img_sq_a_publicidad  = $resulPubli->img_sq_a_publicidad;
			$link_sqa_producto  = $resulPubli->link_sqa_producto;
			$nombre_cliente_publi = $resulPubli->nombre_cliente_publi;
			
			$img_sq_b_publicidad  = $resulPubli->img_sq_b_publicidad;
			$link_sqb_producto  = $resulPubli->link_sqb_producto;
			
			$img_sq_c_publicidad  = $resulPubli->img_sq_c_publicidad;
			$link_sqc_producto  = $resulPubli->link_sqc_producto;
			
			$img_sq_d_publicidad  = $resulPubli->img_sq_d_publicidad;
			$link_sqd_producto  = $resulPubli->link_sqd_producto;
			
			$img_rq_a_publicidad  = $resulPubli->img_rq_a_publicidad;
			$link_rqa_producto  = $resulPubli->link_rqa_producto;
			
			$img_rq_b_publicidad  = $resulPubli->img_rq_b_publicidad;
			$link_rqb_producto  = $resulPubli->link_rqb_producto;
			
			$img_top_publicidad  = $resulPubli->img_top_publicidad;
			$link_hb_producto  = $resulPubli->link_hb_producto;
			
			$tipo_precio_publicidad  = $resulPubli->tipo_precio_publicidad;
			$precio_publicidad  = $resulPubli->precio_publicidad;
			$descuento_precio_publicidad  = $resulPubli->descuento_precio_publicidad;
			$total_precio_publicidad  = $resulPubli->total_precio_publicidad;
			$iva_publicidad = $resulPubli->iva_publicidad;
			$show_categorias_publicidad = $resulPubli->show_categorias_publicidad;
			
		}
		$show_categorias_publicidad = trim($show_categorias_publicidad, ',');
		$fecha_inicio = date_format($fecha_inicio_publicidad, 'Y-m-d\TH:i');
		$fecha_fin = date_format($fecha_fin_publicidad, 'Y-m-d\TH:i');
		
		if($activo_publicidad==1){
			$visible ="Visible";
		}else{
			$visible ="Oculto";
		}
	}else{
		header('location:'.SITE.'admin/publicidad');
	}
	if($tipo_publicidad=='campaña'){
		$requerido= 'required';
		$tipo_publicidad="campaña";
	}else{
		$requerido= '';
		$tipo_publicidad="individual";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Editar Publicidad <?php echo $nombre_publicidad.' - '.$id_publicidad .' - '. $nombre_cliente_publi?>  | Ecommerce</title>
<?php include("parts/header.php");?>
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
						<a href="<?php echo SITE.'admin'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lateralpanel" aria-controls="lateralpanel" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
				</div>
			</nav>
			<section id="edit-product">
				<h1 id="titlesection">Editar Publicidad - <?php echo $nombre_publicidad .' - '.$nombre_cliente_publi?></h1>
				<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" class="row" action="../functions/guardar-edicion-publi.php" id="form-edit-prod">
					<input type="hidden" value="<?php echo $id_publicidad?>" name="id_publicidad" required>
					<div class="col-12 col-lg-9">
						<div class="row card-header lista-prodcutos">	
							<div class="col-md-12">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 1 / Top Banner</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 1 / Top Banner">
										<img class="card-img-top" src="<?php echo SITE.'img/publicidad/'.$img_top_publicidad?>" onerror="this.src='<?php echo SITE.'img/img_top_hb.jpg'?>';" alt="Imagen" id="img-img_top_publicidad">
										<input type="file" class="sr-only inputimg" name="img_top_publicidad" id="img_top_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_top_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 1920 x 250)</small>
									<input type="hidden" name="txt-img_top_publicidad" id="txt-img_top_publicidad" value="<?php echo $img_top_publicidad?>">
									<input type="hidden" name="old-img_top_publicidad" id="old-img_top_publicidad" value="<?php echo $img_top_publicidad?>">
									<hr>
									<div class="form-group">
										<label for="link_hb_producto">URL de publicidad 1 / Top Banner</label>
										<input type="url" name="link_hb_producto" class="form-control form-control-sm" value="<?php echo $link_hb_producto?>" id="link_hb_producto" <?php echo $requerido ?> >
									</div>
								</div>
								</div>
							</div>
							<hr>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header">
									 <h5 class="card-title">Imagen 2 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 2 / Cuadrada">
										<img class="card-img-top" src="<?php echo SITE.'img/publicidad/'.$img_sq_a_publicidad?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_a_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_a_publicidad" id="img_sq_a_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_a_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_a_publicidad" id="txt-img_sq_a_publicidad" value="<?php echo $img_sq_a_publicidad?>">
									<input type="hidden" name="old-img_sq_a_publicidad" id="old-img_sq_a_publicidad" value="<?php echo $img_sq_a_publicidad?>">
									<hr>
									<div class="form-group">
										<label for="link_sqa_producto">URL de publicidad 2</label>
										<input type="url" name="link_sqa_producto" class="form-control form-control-sm" value="<?php echo $link_sqa_producto?>" id="link_sqa_producto"  <?php echo $requerido ?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header">
									 <h5 class="card-title">Imagen 3 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 3 / Cuadrada">
										<img class="card-img-top" src="<?php echo SITE.'img/publicidad/'.$img_sq_b_publicidad?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_b_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_b_publicidad" id="img_sq_b_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_b_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_b_publicidad" id="txt-img_sq_b_publicidad" value="<?php echo $img_sq_b_publicidad?>">
									<input type="hidden" name="old-img_sq_b_publicidad" id="old-img_sq_b_publicidad" value="<?php echo $img_sq_b_publicidad?>">
									<hr>
									<div class="form-group">
										<label for="link_sqa_producto">URL de publicidad 3</label>
										<input type="url" name="link_sqb_producto" class="form-control form-control-sm" value="<?php echo $link_sqb_producto?>" id="link_sqb_producto"  <?php echo $requerido ?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 4 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 4 / Cuadrada">
										<img class="card-img-top" src="<?php echo SITE.'img/publicidad/'.$img_sq_c_publicidad?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_c_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_c_publicidad" id="img_sq_c_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_c_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_c_publicidad" id="txt-img_sq_c_publicidad" value="<?php echo $img_sq_c_publicidad?>">
									<input type="hidden" name="old-img_sq_c_publicidad" id="old-img_sq_c_publicidad" value="<?php echo $img_sq_c_publicidad?>">
									<hr>
									<div class="form-group">
										<label for="link_sqa_producto">URL de publicidad 4</label>
										<input type="url" name="link_sqc_producto" class="form-control form-control-sm" value="<?php echo $link_sqc_producto?>" id="link_sqc_producto"  <?php echo $requerido ?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-xl-3">
								<div class="card">
								<div class="card-header">
									 <h5 class="card-title">Imagen 5 / Cuadrada</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 5 / Cuadrada">
										<img class="card-img-top" src="<?php echo SITE.'img/publicidad/'.$img_sq_d_publicidad?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_sq_d_publicidad">
										<input type="file" class="sr-only inputimg" name="img_sq_d_publicidad" id="img_sq_d_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_sq_d_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 500 x 500)</small>
									<input type="hidden" name="txt-img_sq_d_publicidad" id="txt-img_sq_d_publicidad" value="<?php echo $img_sq_d_publicidad?>">
									<input type="hidden" name="old-img_sq_d_publicidad" id="old-img_sq_d_publicidad" value="<?php echo $img_sq_d_publicidad?>">
									<hr>
									<div class="form-group">
										<label for="link_sqa_producto">URL de publicidad 5</label>
										<input type="url" name="link_sqd_producto" class="form-control form-control-sm" value="<?php echo $link_sqd_producto?>" id="link_sqd_producto"  <?php echo $requerido ?>>
									</div>
								</div>
								</div>
							</div>
							<hr>
							<div class="col-md-6 col-lg-4">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 6 / Rectangular</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 6 / Rectangular">
										<img class="card-img-top" src="<?php echo SITE.'img/publicidad/'.$img_rq_a_publicidad?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_rq_a_publicidad">
										<input type="file" class="sr-only inputimg" name="img_rq_a_publicidad" id="img_rq_a_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_rq_a_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 361 x 738)</small>
									<input type="hidden" name="txt-img_rq_a_publicidad" id="txt-img_rq_a_publicidad" value="<?php echo $img_rq_a_publicidad?>">
									<input type="hidden" name="old-img_rq_a_publicidad" id="old-img_rq_a_publicidad" value="<?php echo $img_rq_a_publicidad?>">
									<hr>
									<div class="form-group">
										<label for="link_rqa_producto">URL de publicidad 6</label>
										<input type="url" name="link_rqa_producto" class="form-control form-control-sm" value="<?php echo $link_rqa_producto?>" id="link_rqa_producto"  <?php echo $requerido ?>>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-4">
								<div class="card">
								<div class="card-header ">
									 <h5 class="card-title">Imagen 7 / Rectangular</h5>
								</div>
								<div class="card-body">
									<label class="label" data-toggle="tooltip" title="Imagen 7 / Rectangular">
										<img class="card-img-top" src="<?php echo SITE.'img/publicidad/'.$img_rq_b_publicidad?>" onerror="this.src='<?php echo SITE.'img/img_rq.png'?>';" alt="Imagen" id="img-img_rq_b_publicidad">
										<input type="file" class="sr-only inputimg" name="img_rq_b_publicidad" id="img_rq_b_publicidad" accept="image/x-png,image/jpeg" data-imgid="img_rq_b_publicidad">
									</label>
									<small>*Imagen requerida (Tamaño recomenado 361 x 738)</small>
									<input type="hidden" name="txt-img_rq_b_publicidad" id="txt-img_rq_b_publicidad" value="<?php echo $img_rq_b_publicidad?>">
									<input type="hidden" name="old-img_rq_b_publicidad" id="old-img_rq_b_publicidad" value="<?php echo $img_rq_b_publicidad?>">
									<hr>
									<div class="form-group">
										<label for="link_rqb_producto">URL de publicidad 7</label>
										<input type="url" name="link_rqb_producto" class="form-control form-control-sm" value="<?php echo $link_rqb_producto?>" id="link_rqb_producto"  <?php echo $requerido ?>>
									</div>
								</div>
								</div>
							</div>
							<hr>
							<div class="progress">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
							</div>
							<div class="alert" role="alert"></div>
							<hr>
							<div class="col-12">
								<div class="card ">
									<div class="card-header ">
										 <h5 class="card-title">Mostrar solo en:</h5>
									</div>
									<div class="card-body">
										<div class="form-group">
											<label for="show_tienda_publicidad">Escaparates:</label>
											<select name="show_tienda_publicidad" class="form-control" id="show_tienda_publicidad">

												<?php
													if($show_tienda_publicidad=="" OR $show_tienda_publicidad=="NULL" OR $show_tienda_publicidad==NULL){
												?>
													<option value="Aleatorio" selected>Aleatorio</option>
												<?php
													}else{
												?>
													<option value="Aleatorio">Aleatorio</option>
												<?php
													}
													$sqlPromos="SELECT id_tienda, nombre_tienda, nick_tienda FROM tiendas WHERE activa_tienda = 1 ORDER BY nombre_tienda";
													$reqPromos=mysqli_query($conex, $sqlPromos);
													while($resulPromos = mysqli_fetch_object($reqPromos)){
														$id_tienda  = $resulPromos->id_tienda;
														$nombre_tienda  = $resulPromos->nombre_tienda;
														$nick_tienda  = $resulPromos->nick_tienda;
														if($show_tienda_publicidad == $nick_tienda AND $show_tienda_publicidad!=""){
												?>
												<option value="<?php echo $nick_tienda?>" selected><?php echo $nombre_tienda.' - '.$nick_tienda?></option>
												<?php }else{?>
												<option value="<?php echo $nick_tienda?>"><?php echo $nombre_tienda.' - '.$nick_tienda?></option>
												<?php }}?>
											</select>
										</div>
									</div>
									<hr>					
									<div class="card-header">
										<h5 class="card-title">Mostrar solo en categorías:</h5>
									</div>
									<div class="card-body">
										<?php											
											if($show_tienda_publicidad=="" OR $show_tienda_publicidad=="NULL" OR $show_tienda_publicidad==NULL){$check='';}else{$check="disabled";};		
											$GetCategorias="SELECT id_categoria, nombre_categoria, activo_categoria FROM categorias WHERE activo_categoria = 1";
											$reqCategorias=mysqli_query($conex, $GetCategorias);
											while($resulCategorias = mysqli_fetch_object($reqCategorias)){
											$id_categoria = $resulCategorias->id_categoria;
											$nombre_categoria = $resulCategorias->nombre_categoria;
											?>
											<div class="form-check form-check-inline">											
												<input class="form-check-input categorias_check" type="checkbox" id="cat<?php echo $id_categoria?>" name="categorias[]" value="<?php echo $id_categoria?>" <?php echo $check?>>
												<label class="form-check-label" for="cat<?php echo $id_categoria?>"><?php echo $nombre_categoria?></label>
											</div>
											<?php
											}
										?>
										<script>
											var miArray = [<?php echo $show_categorias_publicidad?>];
											miArray.forEach( function(valor, indice, array) {
												//console.log("En el índice " + indice + " hay este valor: " + valor);
												$("#cat"+valor).prop('checked', true);
											});
										</script>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Tipo de publicación: </h5>
							</div>
							<div class="card-body">
								<h3 id="tipo_publi_header"><?php echo ucfirst ($tipo_publicidad)?></h3>
								<hr>
								<div class="form-group">
									<select name="tipo_publicidad" class="form-control" id="tipo_publicidad" onChange="tipopubli()">
										<option value="individual" id="opindividual">Individual</option>
										<option value="campaña" id="opcampaña">Campaña</option>
									</select>
									<script>
										
										document.getElementById("op<?php echo $tipo_publicidad?>").selected = "true";
										function tipopubli(){
											var x = document.getElementById("tipo_publicidad").value;
											document.getElementById("tipo_publi_header").innerHTML = x;
											if(x=='individual'){
												$('form input[type="url"]').prop("required", false);
											}else{
												$('form input[type="url"]').prop("required", true);
											}
										}
									</script>
								</div>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Publicar</h5>
							</div>
							<div class="card-body">
								<div style="width: 100%">
									<span><?php echo $status?></span>
									<p>Visibilidad: <?php echo $visible?></p>									
								</div>
								
								<button type="submit" name="guardar" id="guardar" class="btn btn-success">Guardar</button>
								<button type="submit" name="ocultar" id="ocultar" class="btn btn-dark">Ocultar</button>
							</div>
						</div>
						
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Precio:</h5>
							</div>
							<div class="card-body">
								<div class="form-group" id="tipo_precio_publicidad_box">
									<label for="tipo_precio_publicidad">Tipo de Publicidad:</label>
									<select name="tipo_precio_publicidad" id="tipo_precio_publicidad" class="form-control" required>
										<?php
										$tip_intercambio=""; $tip_cortesia=""; $tip_normal=""; $tip_descuento=""; 
										switch($tipo_precio_publicidad){
											case 'intercambio':
												$tip_intercambio="selected";
												$class_form_prec = "";
												$class_form_desc = "";
											break;
											case 'cortesia':
												$tip_cortesia="selected";
												$class_form_prec = "hidden";
												$class_form_desc = "hidden";
											break;
											case 'normal':
												$tip_normal="selected";
												$class_form_prec = "";
												$class_form_desc = "hidden";
											break;
											case 'descuento':
												$tip_descuento="selected";
												$class_form_prec = "";
												$class_form_desc = "";
											break;
										}?>
										
										<option value="intercambio" <?php echo $tip_intercambio?>>Intercambio</option>
										<option value="cortesia" <?php echo $tip_cortesia?>>Cortesía</option>
										<option value="normal" <?php echo $tip_normal?>>Normal</option>
										<option value="descuento" <?php echo $tip_descuento?>>Descuento</option>
									</select>
								</div>
								<div class="form-group <?php echo $class_form_prec?>" id="precio_publicidad_box">
									<label for="precio_publicidad">Precio de Publicidad:</label>
									<input type="number" name="precio_publicidad" id="precio_publicidad" class="form-control" min="0" value="<?php echo $precio_publicidad?>">
								</div>
								<div class="form-group <?php echo $class_form_desc?>" id="descuento_precio_publicidad_box">
									<label for="descuento_precio_publicidad">% de descuento :</label>
									<input type="number" name="descuento_precio_publicidad" id="descuento_precio_publicidad" class="form-control" min="0" value="<?php echo $descuento_precio_publicidad?>">
								</div>
								<div class="form-group">
									<label for="iva_precio_publicidad">IVA:</label>
									<input type="number" name="iva_precio_publicidad" id="iva_precio_publicidad" class="form-control" readonly value="<?php echo $iva_publicidad?>">
								</div>
								<div class="form-group">
									<label for="total_precio_publicidad">Precio Final:</label>
									<input type="number" name="total_precio_publicidad" id="total_precio_publicidad" class="form-control" readonly value="<?php echo $total_precio_publicidad?>">
								</div>
							</div>
						</div>
						
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Periodo</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="fecha_inicio_publicidad">Fecha de inicio</label>
									<input type="datetime-local" name="fecha_inicio_publicidad" id="fecha_inicio_publicidad" min="2020-01-01T0:00:00" onchange="passfecha()" class="form-control" value="<?php echo $fecha_inicio?>" required>
								</div>
							<hr>
								<div class="form-group">
									<label for="fecha_fin_publicidad">Fecha de final</label>
									<input type="datetime-local" name="fecha_fin_publicidad" id="fecha_fin_publicidad" class="form-control" min="<?php echo $fecha_inicio?>" value="<?php echo $fecha_fin?>" required>
								</div>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Nombre de Publicidad</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="nombre_publicidad">Nombre de Publicidad</label>
									<input type="text" name="nombre_publicidad" class="form-control form-control-lg" id="nombre_publicidad" value="<?php echo $nombre_publicidad?>" required>
								</div>
							</div>
						</div>
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Eliminar Publicidad</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<button type="submit" name="borrar" value="borrar" class="btn btn-danger btn-sm btn-block">Borrar</button>
								</div>
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
		</div>
	</section>
	<script>
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
		var dataimg,oldimg;
		var aspc;

		$('[data-toggle="tooltip"]').tooltip();
		//Evocamos funcion Start
		//input.addEventListener('change', function (e) {
		$( ".inputimg" ).change(function(e) {
			var element = $(this),
    		imgid = element.data("imgid");
			avatar = document.getElementById('img-'+imgid);
			input = element;
			dataimg = imgid;
			oldimg = document.getElementById("old-"+imgid).value;
		
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
				case 'img_top_publicidad':
					var aspc = 192/25;
					break;
				case 'img_rq_a_publicidad':
					var aspc = 359/735;
					break;
				case 'img_rq_b_publicidad':
					var aspc = 359/735;
					break;
				default:
					var aspc = 1/1;
					break;
			}
		  
			cropper = new Cropper(image, {
				aspectRatio: aspc,
				viewMode: 2,
				autoCropArea: 1,
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
					case 'img_top_publicidad':
						var width= 1920;
						var height= 250;
						break;
					case 'img_rq_a_publicidad':
						var width= 359;
						var height= 735;
						break;
					case 'img_rq_b_publicidad':
						var width= 359;
						var height= 735;
						break;
					default:
						var width= 425;
						var height= 425;
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
					formData.append('folder', "publicidad");
					formData.append('oldimg', oldimg);
					formData.append('id_tienda', <?php echo $id_publicidad?>);
					//console.log(formData);
					$.ajax('../functions/uploader-img-admin.php', {
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
							$("#old-"+dataimg).val(info);
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
		
		function passfecha(){
			var date=$("#fecha_inicio_publicidad").val()
			$('#fecha_fin_publicidad').attr('min', date);
		}
		$("#tipo_precio_publicidad").change(function() {
			var tipo_precio=$("#tipo_precio_publicidad").val();
			
			switch (tipo_precio){
				case 'normal':
					$("#descuento_precio_publicidad_box").addClass("hidden");
					$("#precio_publicidad_box").removeClass("hidden");
					$("#descuento_precio_publicidad").val('0');
				break;
				case 'cortesia':
					$("#descuento_precio_publicidad_box").addClass("hidden");
					$("#precio_publicidad_box").addClass("hidden");
					$("#descuento_precio_publicidad").val('0');
					$("#precio_publicidad").val('0');
					$("#total_precio_publicidad").val('0');
				break;
				case 'intercambio':
					$("#descuento_precio_publicidad_box").removeClass("hidden");
					$("#precio_publicidad_box").removeClass("hidden");
				break;
				case 'descuento':
					$("#descuento_precio_publicidad_box").removeClass("hidden");
					$("#precio_publicidad_box").removeClass("hidden");
				break;
			}
		});
		
		$("#precio_publicidad").change(function() {
			calcularTotal();
		});
		$("#descuento_precio_publicidad").change(function() {
			calcularTotal();
		});
		function calcularTotal(){
			var precio=$("#precio_publicidad").val();
			var descuento=$("#descuento_precio_publicidad").val();
			var descuentonum = precio * (descuento /100);
			var subtotal = precio - descuentonum;
			var iva = subtotal*0.16;
			var total = subtotal + iva;
			$("#iva_precio_publicidad").val(iva);
			$("#total_precio_publicidad").val(total);
		}
		$("#show_tienda_publicidad").change(function() {
			var showonly = $("#show_tienda_publicidad").val();
			if(showonly =="Aleatorio"){
				$('.categorias_check').prop("disabled", false);
			}else{
				$('.categorias_check').prop("disabled", true);
				$('.categorias_check').prop('checked', false); 
			}
		});
	</script>
</body>
</html>
