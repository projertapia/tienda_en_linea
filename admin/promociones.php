<?php
	session_start();
	require('connect/conect_usrer.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['s']) AND !empty($_GET['s'])){
		$s = $_GET['s'];
	}else{
		$s="";
	}
	$hoypromo = date("Y-m-d H:i:s");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Promociones | Ecommerce</title>
<?php include("parts/header.php");?>
<style>
	.blacksc{z-index: 3; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.50); display: none; opacity: 0; position: absolute; top:0; left: 0}
	.blacksc.show{display: block; opacity: 1}
	.img-btn{}
	.img-btn img{ cursor: pointer}
	ul {
  list-style-type: none;
}

li {
  display: inline-block;
	max-width: 200px;
}

input[type="radio"][id^="promo-"] {
  display: none;
}

label {
  border: 1px solid #fff;
  padding: 10px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

label::before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: auto;
  width: 200px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked+label {
  border-color: #ddd;
}

:checked+label::before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}

:checked+label img {
  transform: scale(0.9);
  box-shadow: 0 0 5px #333;
  z-index: -1;
}
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
					<div class="col-12 col-sm-5 col-md-9 p-2">
						<h1 id="titlesection">Promociones</h1>
					</div>
					
					<hr>
					<div class="col-12">
						<div class="card-header lista-prodcutos table-responsive">
							<div class="row">
								<?php
									function promos($tipo, $cantidad, $lugar){
										$hoypromo = date("Y-m-d H:i:s");
										$promoconect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
										$sqlpromosq ="SELECT p.id_promocion, p.tienda_rel_promocion, p.nombre_promocion, p.fecha_inicio_promocion, p.fecha_fin_promocion, p.img_promocion, p.url_promocion, p.tipo_promocion, p.activo_promocion, t.id_tienda, t.nick_tienda, p.lugar_promocion FROM promociones p, tiendas t WHERE p.activo_promocion = 1 AND ((p.fecha_inicio_promocion <= '$hoypromo') AND (p.fecha_fin_promocion >= '$hoypromo')) AND t.id_tienda = p.tienda_rel_promocion AND p.tipo_promocion = '$tipo' AND p.lugar_promocion = $lugar ORDER BY p.lugar_promocion ASC LIMIT $cantidad";
										$reqpromosq=mysqli_query($promoconect, $sqlpromosq);
										$countpromo = $reqpromosq->num_rows;
										if($countpromo!=0){
											while($resultpromosq = mysqli_fetch_object($reqpromosq)){
												$img_promocion = $resultpromosq->img_promocion;							
												$nick_tienda= $resultpromosq->nick_tienda;							
												$nombre_promocion = $resultpromosq->nombre_promocion;	
												return array(SITE.'img/tiendas/'.$nick_tienda.'/'.$img_promocion, $nick_tienda, $nombre_promocion);
											}
										}else{
											return array(SITE.'img/tiendas/imagen.jpg', 'promoción.', 'Sin asignación');
										}
										//echo SITE.'img/tiendas/'.$nick_tienda.'/'.$img_promocion;
										
										
									}
						   			
								?>
								<div class="col-6 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('rq', '1', '1'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promos" onClick="postnumber(1,'rq')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-6  my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('rq', '1', '2'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promos" onClick="postnumber(2,'rq')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-3  my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '3'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(3,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>									
								</div>
								<div class="col-3 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '4'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(4,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-3 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '5'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(5,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-3 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '6'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(6,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-3 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '7'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(7,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-3 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '8'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(8,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-3 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '9'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(9,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
								<div class="col-3 my-3 img-btn">
									<?php list($img,$nick,$promo) = promos('sq', '1', '10'); ?>
									<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#promossq" onClick="postnumber(10,'sq')" onerror="this.src = '<?php echo SITE.'img/img_rq.png'?>';">
									<small><?php echo $promo.' de '.$nick?></small>
								</div>
							</div>
						</div>	
					</div>
					<div class="clearfix"></div>
				</div>
			</section>
		</div>
		<div class="modal fade bd-example-modal-lg" tabindex="-1" id="promos" role="dialog" aria-labelledby="promos" aria-hidden="true" data-backdrop="static">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Promociones principales</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<form accept-charset="UTF-8" id="form-rq" method="get">
						<ul>
					<?php
						$tipo = "rq";
						$sqlpromosq ="SELECT p.id_promocion, p.tienda_rel_promocion, p.nombre_promocion, p.fecha_inicio_promocion, p.fecha_fin_promocion, p.img_promocion, p.url_promocion, p.tipo_promocion, p.activo_promocion, t.id_tienda, t.nick_tienda, p.lugar_promocion FROM promociones p, tiendas t WHERE p.activo_promocion = 1 AND ((p.fecha_inicio_promocion <= '$hoypromo') AND (p.fecha_fin_promocion >= '$hoypromo')) AND t.id_tienda = p.tienda_rel_promocion AND p.tipo_promocion = '$tipo' ORDER BY p.lugar_promocion ASC"; //
						$reqpromosq=mysqli_query($conex, $sqlpromosq);
						$Mispromosq = $reqpromosq->num_rows;
						if($Mispromosq != 0){
							?>
							<input type="hidden" id="post-rq" value="" name="post-rq">
							<li>
								<input type="radio" id="promo-0" / name="promo-principal" value="-">
								<label for="promo-0">
									<img src="<?php echo SITE.'img/prev_promocion_rq.jpg'?>" alt="" class="img-fluid">
									<small>Sin asignación</small>
								</label>
							</li>
							<?php
							while($resultpromosq = mysqli_fetch_object($reqpromosq)){
							$id_promocion = $resultpromosq->id_promocion;
							$tienda_rel_promocion = $resultpromosq->tienda_rel_promocion;
							$img_promocion = $resultpromosq->img_promocion;
							$url_promocion = $resultpromosq->url_promocion;
							$nick_tienda= $resultpromosq->nick_tienda;
							$tipo_promocion = $resultpromosq->tipo_promocion;
							$nombre_promocion = $resultpromosq->nombre_promocion;
							$lugar_promocion = $resultpromosq->lugar_promocion;
							?>
							
							<li>
								<input type="radio" id="promo-<?php echo $id_promocion?>" / name="promo-principal" value="<?php echo $id_promocion?>" data-post="<?php echo $lugar_promocion?>" class="promo">
								<label for="promo-<?php echo $id_promocion?>">
									<img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$img_promocion?>" alt="" class="img-fluid">
									<small><?php echo $nombre_promocion.' de '.$nick_tienda?></small>
								</label>
							</li>
							
							<?php
							}
							?>
						</ul>
						<?php
						}else{
							?>
							<h3>Los escaparates no cuentan con promociones activas.</h3>
							<?php
						}
					?>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onClick="updatepromo('rq')" id="send-principal">Cambiar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		  </div>
		</div>
		<div class="modal fade bd-example-modal-lg" tabindex="-1" id="promossq" role="dialog" aria-labelledby="promos" aria-hidden="true" data-backdrop="static">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Promociones secundarias</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form accept-charset="UTF-8" id="form-sq" method="get">
						<ul>
					<?php
						$tipo = "sq";
						$sqlpromosq ="SELECT p.id_promocion, p.tienda_rel_promocion, p.nombre_promocion, p.fecha_inicio_promocion, p.fecha_fin_promocion, p.img_promocion, p.url_promocion, p.tipo_promocion, p.activo_promocion, t.id_tienda, t.nick_tienda, p.lugar_promocion FROM promociones p, tiendas t WHERE p.activo_promocion = 1 AND ((p.fecha_inicio_promocion <= '$hoypromo') AND (p.fecha_fin_promocion >= '$hoypromo')) AND t.id_tienda = p.tienda_rel_promocion AND p.tipo_promocion = '$tipo' ORDER BY p.lugar_promocion ASC"; //
						$reqpromosq=mysqli_query($conex, $sqlpromosq);
						$Mispromosq = $reqpromosq->num_rows;
						if($Mispromosq != 0){
							?>
							<input type="hidden" id="post-sq" value="" name="post-sq">
							<li>
								<input type="radio" id="promo-0" / name="promo-secundaria" value="-">
								<label for="promo-0">
									<img src="<?php echo SITE.'img/img_rq.png'?>" alt="" class="img-fluid">
									<small>Sin asignación</small>
								</label>
							</li>
							<?php
							while($resultpromosq = mysqli_fetch_object($reqpromosq)){
							$id_promocion = $resultpromosq->id_promocion;
							$tienda_rel_promocion = $resultpromosq->tienda_rel_promocion;
							$img_promocion = $resultpromosq->img_promocion;
							$url_promocion = $resultpromosq->url_promocion;
							$nick_tienda= $resultpromosq->nick_tienda;
							$tipo_promocion = $resultpromosq->tipo_promocion;
							$nombre_promocion = $resultpromosq->nombre_promocion;
							$lugar_promocion = $resultpromosq->lugar_promocion;
							?>
							
							<li>
								<input type="radio" id="promo-<?php echo $id_promocion?>" / name="promo-secundaria" value="<?php echo $id_promocion?>" data-post="<?php echo $lugar_promocion?>" class="promo">
								<label for="promo-<?php echo $id_promocion?>">
									<img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$img_promocion?>" alt="" class="img-fluid">
									<small><?php echo $nombre_promocion.' de '.$nick_tienda?></small>
								</label>
							</li>
							
							<?php
							}
							?>
						</ul>
						<?php
						}else{
							?>
							<h3>Los escaparates no cuentan con promociones activas.</h3>
							<?php
						}
					?>
						</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onClick="updatepromo('sq')" id="send-secundaria">Cambiar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		  </div>
		</div>
	</section>
	<div class="blacksc"></div>
	<script>
		function postnumber(numberpost,typepost){
			if(typepost=='rq'){
				document.getElementById("post-rq").value = numberpost;
			}else{
				document.getElementById("post-sq").value = numberpost;
			}
			const el = document.querySelector("[data-post='"+numberpost+"']");
			$(el).prop('checked', true);			
		}
		function updatepromo(type){
			
			if(type=='rq'){
				document.getElementById("send-principal").disabled = true;
				var formData = $('#form-rq').serializeArray();
			}else{
				document.getElementById("send-secundaria").disabled = true;
				var formData = $('#form-sq').serializeArray();
			}
			$.ajax({
				data: formData,
				type: "POST",
				url: "<?php echo SITE.'admin/functions/promociones-update.php'?>",
				success: function(info) {
					console.log(info);
					location.reload();
				},
				error: function() {
					alert("Error al actualizar.");
					location.reload();
				}
			});
		}
	</script>
</body>
</html>