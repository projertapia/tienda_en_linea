<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
	if(isset($_GET['id']) AND $_GET['id']!=""){
	$idPubli= $_GET['id'];
		$sqlPubli="SELECT p.id_publicidad, p.nombre_publicidad, p.fecha_inicio_publicidad, p.fecha_fin_publicidad, p.cliente_publicidad, p.tipo_publicidad, p.activo_publicidad, p.img_sq_a_publicidad, p.img_sq_b_publicidad, p.img_sq_c_publicidad, p.img_sq_d_publicidad, p.img_rq_a_publicidad, p.img_rq_b_publicidad, p.img_top_publicidad, p.show_tienda_publicidad, p.link_sqa_producto, p.link_sqb_producto, p.link_sqc_producto, p.link_sqd_producto, p.link_rqa_producto, p.link_rqb_producto,  p.link_hb_producto, p.click_sqa_producto, p.click_sqb_producto, p.click_sqc_producto, p.click_sqd_producto, p.click_rqa_producto, p.click_rqb_producto, p.click_hb_producto,
		t.id_cliente_publi, t.nombre_cliente_publi, t.activo_cliente_publi
		FROM publicidad p, clientes_publi t WHERE p.id_publicidad = $idPubli AND t.id_cliente_publi = p.cliente_publicidad";
		$reqPubli=mysqli_query($conex, $sqlPubli);
		while($resulPubli = mysqli_fetch_object($reqPubli)){
			$id_publicidad  = $resulPubli->id_publicidad;
			$nombre_publicidad  = $resulPubli->nombre_publicidad;
			$fecha_inicio_check = $resulPubli->fecha_inicio_publicidad;
			$fecha_inicio_publicidad  = date_create($fecha_inicio_check);
			$fecha_fin_check = $resulPubli->fecha_fin_publicidad;
			$fecha_fin_publicidad  = date_create($fecha_fin_check);
			$cliente_publicidad  = $resulPubli->cliente_publicidad;
			$tipo_publicidad  = $resulPubli->tipo_publicidad;
			$activo_publicidad  = $resulPubli->activo_publicidad;
			$show_tienda_publicidad = $resulPubli->show_tienda_publicidad;
			$nombre_cliente_publi = $resulPubli->nombre_cliente_publi;
			
			$img_sq_a_publicidad  = $resulPubli->img_sq_a_publicidad;
			$link_sqa_producto  = $resulPubli->link_sqa_producto;			
			$click_sqa_producto = $resulPubli->click_sqa_producto;
			
			$img_sq_b_publicidad  = $resulPubli->img_sq_b_publicidad;
			$link_sqb_producto  = $resulPubli->link_sqb_producto;
			$click_sqb_producto = $resulPubli->click_sqb_producto;
			
			$img_sq_c_publicidad  = $resulPubli->img_sq_c_publicidad;
			$link_sqc_producto  = $resulPubli->link_sqc_producto;
			$click_sqc_producto = $resulPubli->click_sqc_producto;
			
			$img_sq_d_publicidad  = $resulPubli->img_sq_d_publicidad;
			$link_sqd_producto  = $resulPubli->link_sqd_producto;
			$click_sqd_producto = $resulPubli->click_sqd_producto;
			
			$img_rq_a_publicidad  = $resulPubli->img_rq_a_publicidad;
			$link_rqa_producto  = $resulPubli->link_rqa_producto;
			$click_rqa_producto = $resulPubli->click_rqa_producto;
			
			$img_rq_b_publicidad  = $resulPubli->img_rq_b_publicidad;
			$link_rqb_producto  = $resulPubli->link_rqb_producto;
			$click_rqb_producto = $resulPubli->click_rqb_producto;
			
			$img_top_publicidad  = $resulPubli->img_top_publicidad;
			$link_hb_producto  = $resulPubli->link_hb_producto;
			$click_hb_producto = $resulPubli->click_hb_producto;
			
		}
		$totalclics = $click_sqa_producto+$click_sqb_producto+$click_sqc_producto+$click_sqd_producto+$click_rqa_producto+$click_rqb_producto+$click_hb_producto;
			
		$fecha_inicio = date_format($fecha_inicio_publicidad, 'd-m-Y H:i');
		$fecha_fin = date_format($fecha_fin_publicidad, 'd-m-Y H:i');
		
		if($fecha_inicio_check<=$datetime_now AND $fecha_fin_check>=$datetime_now){
			$visible = "Activo";
			$classPEr="bg-success text-white";
		}else{
			$visible = "Vencido";
			$classPEr="bg-danger text-white";
		}
		
		if($activo_publicidad==1){
			$Status ="Activo";
		}else{
			$Status ="Desactivado";
		}
	}else{
		header('location:'.SITE.'admin/publicidad');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte de Publicidad <?php echo $nombre_publicidad. ' de '.$nombre_cliente_publi?> | Ecommerce</title>
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
			<section id="edit-product">
				<div class="card">
					<div class="row card-header lista-prodcutos">	
						<div class="p-3 mb-2 col-md-8 col-lg-10">
							<h1 id="titlesection">Reporte de Publicidad "<?php echo $nombre_publicidad. '" del cliente '.$nombre_cliente_publi;?></h1>
						</div>
						<div class="p-3 mb-2 col-md-4 col-lg-2">
							<a href="<?php echo SITE.'admin/publicidad/editar?id='.$id_publicidad?>" class="btn btn-primary btn-block">Editar</a>
						</div>
						<hr>
						<div class="p-3 mb-2 col-sm-6 col-md-3 bg-info text-white">Desde el: <?php echo $fecha_inicio;?></div>
						<div class="p-3 mb-2 col-sm-6 col-md-3 bg-info text-white">Hasta el: <?php echo $fecha_fin;?></div>
						<div class="p-3 mb-2 col-sm-6 col-md-3 <?php echo $classPEr?>">Periodo: <strong><?php echo $visible;?></strong></div>
						<div class="p-3 mb-2 col-sm-6 col-md-3 bg-primary text-white">Total de clics: <strong><?php echo $totalclics;?></strong></div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
						<table class="table table-striped" id="reporte">
							<thead class="thead-dark">
								<tr>
									<th scope="col">Imagen</th>
									<th scope="col">Posición</th>
									<th scope="col">Link</th>
									<th scope="col">Clics</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row"><img src="<?php echo SITE.'img/publicidad/'.$img_sq_a_publicidad?>" width="100px"></th>
									<td>Lateral Izquierdo 1</td>
									<td><?php echo $link_sqa_producto?></td>
									<td align="center"><?php echo $click_sqa_producto?></td>
								</tr>
								<tr>
									<th scope="row"><img src="<?php echo SITE.'img/publicidad/'.$img_sq_b_publicidad?>" width="100px"></th>
									<td>Lateral Izquierdo 2</td>
									<td><?php echo $link_sqb_producto?></td>
									<td align="center"><?php echo $click_sqb_producto?></td>
								</tr>
								<tr>
									<th scope="row"><img src="<?php echo SITE.'img/publicidad/'.$img_sq_c_publicidad?>" width="100px"></th>
									<td>Lateral Izquierdo 3</td>
									<td><?php echo $link_sqc_producto?></td>
									<td align="center"><?php echo $click_sqc_producto?></td>
								</tr>
								<tr>
									<th scope="row"><img src="<?php echo SITE.'img/publicidad/'.$img_sq_d_publicidad?>" width="100px"></th>
									<td>Lateral Izquierdo 4</td>
									<td><?php echo $link_sqd_producto?></td>
									<td align="center"><?php echo $click_sqd_producto?></td>
								</tr>
								<tr>
									<th scope="row"><img src="<?php echo SITE.'img/publicidad/'.$img_rq_a_publicidad?>" width="100px"></th>
									<td>Lateral Derecho 1</td>
									<td><?php echo $link_rqa_producto?></td>
									<td align="center"><?php echo $click_rqa_producto?></td>
								</tr>
								<tr>
									<th scope="row"><img src="<?php echo SITE.'img/publicidad/'.$img_rq_b_publicidad?>" width="100px"></th>
									<td>Lateral Derecho 1</td>
									<td><?php echo $link_rqb_producto?></td>
									<td align="center"><?php echo $click_rqb_producto?></td>
								</tr>
								<tr>
									<th scope="row"><img src="<?php echo SITE.'img/publicidad/'.$img_top_publicidad?>" width="100px"></th>
									<td>Top Banner</td>
									<td><?php echo $link_hb_producto?></td>
									<td align="center"><?php echo $click_hb_producto?></td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</body>
</html>