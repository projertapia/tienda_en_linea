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
<title>Escaparates Principales | Ecommerce</title>
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
						<h1 id="titlesection">Escaparates Principales</h1>
					</div>
					<div class="col-12 col-sm-7 col-md-3 p-2">
						
					</div>
					<hr>
					<div class="col-12">
						<div class="card-header lista-prodcutos table-responsive">
							<div class="row">
								<?php
									function promos($cantidad, $lugar,$categoria){
										$hoypromo = date("Y-m-d H:i:s");
										$promoconect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
										$sqlpromosq ="SELECT id_tienda, nombre_tienda, nick_tienda, logo_tienda FROM tiendas WHERE activa_tienda = 1 AND post_home_tienda = $lugar AND categoria_tienda = '$categoria' ORDER BY post_home_tienda DESC LIMIT $cantidad";
										$reqpromosq=mysqli_query($promoconect, $sqlpromosq);
										$countpromo = $reqpromosq->num_rows;
										if($countpromo!=0){
											while($resultpromosq = mysqli_fetch_object($reqpromosq)){
												$logo_tienda = $resultpromosq->logo_tienda;							
												$nick_tienda= $resultpromosq->nick_tienda;							
												$nombre_tienda = $resultpromosq->nombre_tienda;	
											}
											return array(SITE.'img/tiendas/'.$nick_tienda.'/'.$logo_tienda, $nick_tienda, $nombre_tienda);
										}else{
											return array(SITE.'img/tiendas/imagen.jpg', 'lugar.', 'Sin asignación');
										}
									}
						   			
								?>
								<div class="col-md-4 col-sm-12 col-12">
									<h2 class="title-section">Influencers</h2>
										<div class="grid">
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '1','influencers'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#influencers" onClick="postnumber(1,'influencers')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '2','influencers'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#influencers" onClick="postnumber(2,'influencers')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '3','influencers'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#influencers" onClick="postnumber(3,'influencers')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '4','influencers'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#influencers" onClick="postnumber(4,'influencers')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '5','influencers'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#influencers" onClick="postnumber(5,'influencers')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '6','influencers'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#influencers" onClick="postnumber(6,'influencers')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
										</div>
								</div>
								<div class="col-md-4 col-sm-12 col-12">
									<h2 class="title-section">Empresas</h2>
										<div class="grid">
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '1','empresas'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#empresas" onClick="postnumber(1,'empresas')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '2','empresas'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#empresas" onClick="postnumber(2,'empresas')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '3','empresas'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#empresas" onClick="postnumber(3,'empresas')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '4','empresas'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#empresas" onClick="postnumber(4,'empresas')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '5','empresas'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#empresas" onClick="postnumber(5,'empresas')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '6','empresas'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#empresas" onClick="postnumber(6,'empresas')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
										</div>
								</div>
								<div class="col-md-4 col-sm-12 col-12">
									<h2 class="title-section">PROFESIONALES</h2>
										<div class="grid">
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '1','profesionales'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#profesionales" onClick="postnumber(1,'profesionales')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '2','profesionales'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#profesionales" onClick="postnumber(2,'profesionales')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '3','profesionales'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#profesionales" onClick="postnumber(3,'profesionales')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '4','profesionales'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#profesionales" onClick="postnumber(4,'profesionales')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '5','profesionales'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#profesionales" onClick="postnumber(5,'profesionales')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
											<div class="my-3 img-btn">
												<?php list($img,$nick,$promo) = promos('1', '6','profesionales'); ?>
												<img src="<?php echo $img;?>" class="img-fluid" data-toggle="modal" data-target="#profesionales" onClick="postnumber(6,'profesionales')" onerror="this.src = '<?php echo SITE.'img/prev_promocion_rq.jpg'?>';">
												<small><?php echo $promo.' de '.$nick?></small>
											</div>
										</div>
								</div>
							</div>
						</div>	
					</div>
					<div class="clearfix"></div>
				</div>
			</section>
		</div>
		<div class="modal fade bd-example-modal-lg" tabindex="-1" id="influencers" role="dialog" aria-labelledby="influencers" aria-hidden="true" data-backdrop="static">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Escaparates de Influencers</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<form accept-charset="UTF-8" id="form-influencers" method="get">
						<ul>
					<?php
						$tipo = "influencers";
						$sqlinfluencers ="SELECT id_tienda, nombre_tienda, nick_tienda, logo_tienda, post_home_tienda FROM tiendas WHERE activa_tienda = 1 AND categoria_tienda = '$tipo' ORDER BY post_home_tienda DESC";
						$reqinfluencers=mysqli_query($conex, $sqlinfluencers);
						$Misinfluencers = $reqinfluencers->num_rows;
						if($Misinfluencers != 0){
							?>
							<input type="hidden" id="influencers-categoria" value="influencers" name="post-influencers">
							<input type="hidden" id="post-influencers" value="" name="post-influencers">
							<li>
								<input type="radio" id="influencers-0" / name="influencers-principal" value="-">
								<label for="influencers-0">
									<img src="<?php echo SITE.'img/prev_promocion_rq.jpg'?>" alt="" class="img-fluid">
									<small>Sin asignación</small>
								</label>
							</li>
							<?php
							while($resultinfluencers = mysqli_fetch_object($reqinfluencers)){
							$id_tienda = $resultinfluencers->id_tienda;
							$nombre_tienda = $resultinfluencers->nombre_tienda;
							$logo_tienda = $resultinfluencers->logo_tienda;
							$nick_tienda= $resultinfluencers->nick_tienda;
							$post_home_tienda = $resultinfluencers->post_home_tienda;
							?>
							
							<li>
								<input type="radio" id="influencers-<?php echo $id_tienda?>" / name="influencers-principal" value="<?php echo $id_tienda?>" data-post="<?php echo $post_home_tienda?>" class="promo">
								<label for="influencers-<?php echo $id_tienda?>">
									<img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$logo_tienda?>" alt="" class="img-fluid">
									<small><?php echo $nombre_tienda.' de '.$nick_tienda?></small>
								</label>
							</li>
							
							<?php
							}
							?>
						</ul>
						<?php
						}else{
							?>
							<h3>No se cuentan con escaparates disponibles.</h3>
							<?php
						}
					?>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onClick="updatepromo('influencers')" id="send-influencers">Cambiar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		  </div>
		</div>
		<div class="modal fade bd-example-modal-lg" tabindex="-1" id="empresas" role="dialog" aria-labelledby="promos" aria-hidden="true" data-backdrop="static">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Escaparates de Empresas</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form accept-charset="UTF-8" id="form-empresas" method="get">
						<ul>
					<?php
						$tipo = "empresas";
						$sqlempresas ="SELECT id_tienda, nombre_tienda, nick_tienda, logo_tienda, post_home_tienda FROM tiendas WHERE activa_tienda = 1 AND categoria_tienda = '$tipo' ORDER BY post_home_tienda DESC";
						$reqempresas=mysqli_query($conex, $sqlempresas);
						$Misempresas = $reqempresas->num_rows;
						if($Misempresas != 0){
							?>
							<input type="hidden" id="empresas-categoria" value="empresas" name="empresas-categoria">
							<input type="hidden" id="post-empresas" value="" name="post-empresas">
							<li>
								<input type="radio" id="empresas-0" / name="empresas-principal" value="-">
								<label for="empresas-0">
									<img src="<?php echo SITE.'img/img_rq.png'?>" alt="" class="img-fluid">
									<small>Sin asignación</small>
								</label>
							</li>
							<?php
							while($resultempresas = mysqli_fetch_object($reqempresas)){
							$id_tienda = $resultempresas->id_tienda;
							$nombre_tienda = $resultempresas->nombre_tienda;
							$logo_tienda = $resultempresas->logo_tienda;
							$nick_tienda= $resultempresas->nick_tienda;
							$post_home_tienda = $resultempresas->post_home_tienda;
							?>
							<li>
								<input type="radio" id="empresas-<?php echo $id_tienda?>" / name="empresas-principal" value="<?php echo $id_tienda?>" data-post="<?php echo $post_home_tienda?>" class="promo">
								<label for="empresas-<?php echo $id_tienda?>">
									<img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$logo_tienda?>" alt="" class="img-fluid">
									<small><?php echo $nombre_tienda.' de '.$nick_tienda?></small>
								</label>
							</li>
							<?php
							}
							?>
						</ul>
						<?php
						}else{
							?>
							<h3>No se cuentan con escaparates disponibles.</h3>
							<?php
						}
					?>
						</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onClick="updatepromo('empresas')" id="send-empresas">Cambiar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		  </div>
		</div>
		<div class="modal fade bd-example-modal-lg" tabindex="-1" id="profesionales" role="dialog" aria-labelledby="profesionales" aria-hidden="true" data-backdrop="static">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Escaparates de Profesionales</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form accept-charset="UTF-8" id="form-profesionales" method="get">
						<ul>
					<?php
						$tipo = "profesionales";
						$sqlprofesionales ="SELECT id_tienda, nombre_tienda, nick_tienda, logo_tienda, post_home_tienda FROM tiendas WHERE activa_tienda = 1 AND categoria_tienda = '$tipo' ORDER BY post_home_tienda DESC";
						$reqprofesionales=mysqli_query($conex, $sqlprofesionales);
						$Misprofesionales = $reqprofesionales->num_rows;
						if($Misprofesionales != 0){
							?>
							<input type="hidden" id="profesionales-categoria" value="profesionales" name="profesionales-categoria">
							<input type="hidden" id="post-profesionales" value="" name="post-profesionales">
							<li>
								<input type="radio" id="profesionales-0" / name="profesionales-principal" value="-">
								<label for="profesionales-0">
									<img src="<?php echo SITE.'img/img_rq.png'?>" alt="" class="img-fluid">
									<small>Sin asignación</small>
								</label>
							</li>
							<?php
							while($resultprofesionales = mysqli_fetch_object($reqprofesionales)){
							$id_tienda = $resultprofesionales->id_tienda;
							$nombre_tienda = $resultprofesionales->nombre_tienda;
							$logo_tienda = $resultprofesionales->logo_tienda;
							$nick_tienda= $resultprofesionales->nick_tienda;
							$post_home_tienda = $resultprofesionales->post_home_tienda;
							?>
							<li>
								<input type="radio" id="profesionales-<?php echo $id_tienda?>" / name="profesionales-principal" value="<?php echo $id_tienda?>" data-post="<?php echo $post_home_tienda?>" class="promo">
								<label for="profesionales-<?php echo $id_tienda?>">
									<img src="<?php echo SITE.'img/tiendas/'.$nick_tienda.'/'.$logo_tienda?>" alt="" class="img-fluid">
									<small><?php echo $nombre_tienda.' de '.$nick_tienda?></small>
								</label>
							</li>
							<?php
							}
							?>
						</ul>
						<?php
						}else{
							?>
							<h3>No se cuentan con escaparates disponibles.</h3>
							<?php
						}
					?>
						</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onClick="updatepromo('profesionales')" id="send-profesionales">Cambiar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		  </div>
		</div>
	</section>
	<div class="blacksc"></div>
	<script>
		function postnumber(numberpost,typepost){
			if(typepost=='influencers'){
				document.getElementById("post-influencers").value = numberpost;
			}
			if(typepost=='empresas'){
				document.getElementById("post-empresas").value = numberpost;
			}
			if(typepost=='profesionales'){
				document.getElementById("post-profesionales").value = numberpost;
			}
			const el = document.querySelector("[data-post='"+numberpost+"']");
			$(el).prop('checked', true);			
		}
		function updatepromo(type){
			
			if(type=='influencers'){
				document.getElementById("send-influencers").disabled = true;
				var formData = $('#form-influencers').serializeArray();
			}
			if(type=='empresas'){
				document.getElementById("send-empresas").disabled = true;
				var formData = $('#form-empresas').serializeArray();
			}
			if(type=='profesionales'){
				document.getElementById("send-profesionales").disabled = true;
				var formData = $('#form-profesionales').serializeArray();
			}
			$.ajax({
				data: formData,
				type: "POST",
				url: "<?php echo SITE.'admin/functions/escaparates-principales-update.php'?>",
				success: function(info) {
					console.log(info);
					location.reload();
				},
				error: function() {
					alert("Error al actualizar - Escaparates principales-E13.");
					location.reload();
				}
			});
		}
	</script>
</body>
</html>