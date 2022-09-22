<?php
  session_start();
require('connect/conect_usrer.php');
if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
}
$_SERVER['HTTP_HOST'];
dirname($_SERVER['PHP_SELF']);
$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
$user_id = $_SESSION["iduser"];
if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {
		header('location:'.$server.'entrar');
}
$SQLFav="SELECT f.id_favorito, f.id_producto_favorito, f.id_cliente_favorito, f.fecha_favorito,
p.id_producto, p.id_tienda_producto,  p.nombre_producto, p.url_producto, p.stock_producto, p.img_a_producto, p.precio_producto, p.precio_promo_producto, p.activo_producto,
t.id_tienda, t.nick_tienda, t.nombre_tienda, t.categoria_tienda
FROM favoritos f, productos p, tiendas t WHERE f.id_cliente_favorito = $user_id AND f.id_producto_favorito = p.id_producto AND p.id_tienda_producto = t.id_tienda";
$reqFav=mysqli_query($conex, $SQLFav);
$cntFav = $reqFav->num_rows;

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Mis favoritos | Ecommerce</title>
<?php include("parts/head.php"); ?>
<style>
	.table td, .table th{vertical-align: middle;}
</style>
</head>

<body>
<?php include("parts/header.php"); ?>
	<section id="mis-datos" class="avatar">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-2 col-sm-3" id="left-tab">
					<?php include("parts/leftbar.php");?>
				</div>
				<div class="col-xl-9 col-lg-10 col-sm-9" id="box-info-cuenta">
					<h1>Mis Favoritos</h1>
					<div class="row">
					<div class="col-12" style="background-color: #fff">
						<?php
							if($cntFav !=0){
						?>
						<div class="table-responsive">
						<table id="box-carrito-producto" class="table">
							<thead>
								<tr>
									<td colspan="2" ></td>
									<td align="left" scope="col">Nombre de producto</td>
									<td scope="col">Precio Unitario</td>
									<td colspan="2" align="left" scope="col">En Stock</td>									
								</tr>
							</thead>
							<tbody id="box-list-items">
								
								<?php while($resultFav = mysqli_fetch_object($reqFav)){
									$id_producto  = $resultFav->id_producto;
									$nombre_producto  = $resultFav->nombre_producto;
									$url_producto  = $resultFav->url_producto;
									$stock_producto  = $resultFav->stock_producto;
									$img_a_producto  = $resultFav->img_a_producto;
									$nick_tienda = $resultFav->nick_tienda;
									$precio_producto = $resultFav->precio_producto;
									$precio_promo_producto = $resultFav->precio_promo_producto;
									$categoria_tienda = $resultFav->categoria_tienda;
									$activo_producto = $resultFav->activo_producto;
									if($precio_promo_producto!= ""){
										$precio=$precio_promo_producto;
									}else{
										$precio=$precio_producto;
									}
									if(($stock_producto!="" AND $stock_producto>0) AND $activo_producto==1){
										$url=SITEUSER.$categoria_tienda.'/'.$nick_tienda.'/'.$url_producto;
										$btnaction="";
										$classActivo="opacity-100";
									}else{
										$url=SITEUSER.$categoria_tienda.'/'.$nick_tienda;
										$classActivo="opacity-50";
										$btnaction='onclick="event.preventDefault()"';
									}
								?>
								<tr class="lista-producto <?php echo $classActivo?>" id="item-<?php echo $id_producto?>">
									<td><a <?php if(($stock_producto!="" AND $stock_producto>0) AND $activo_producto==1){ ?>href="#" onClick="eliminarItem('<?php echo $id_producto?>')" <?php } ?> class="eliminarItem"><i class="far fa-times-circle"></i></a></td>
									<td valign="middle"><img src="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda.'/'.$img_a_producto?>" alt="<?php echo $nombre_producto?>" width="65px">
									</td>
									<td valign="middle" align="left">
										<a href="<?php echo $url?>" <?php echo $btnaction?> class="title-product-link"><?php echo $nombre_producto?></a>
									</td>
									<td valign="middle"><p class="precio-producto-lista">
										<?php if($stock_producto!="" AND $stock_producto>0){?>
										<?php echo '$'.$precio?>
										<?php }else{ echo '-';}?>
									</p></td>
									<td valign="middle">
										<?php if($stock_producto!="" AND $stock_producto>0){?>
										<p class="green">En Stock</p>
										<?php }else{?>
										<p class="red">Sin Stock</p>
										<?php }?>
									</td>
									<td valign="middle">
										<?php if($stock_producto!="" AND $stock_producto>0){?>
										<a href="<?php echo $url?>" class="btn btn-fav-carrito" <?php echo $btnaction ?>>Ver producto</a>
										<?php } ?>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						</div>
						<?php }else{ ?>
						<div id="aviso-carrito">
							<h3>No tienes favoritos.</h3>
							<button class="btn btn-shopnow">Volver al inicio.</button>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>
	<?php include("parts/footer.php"); ?>
	<script>
		function eliminarItem(id){
			event.preventDefault();
			var myobj = document.getElementById("item-"+id);
  			//console.log(myobj);
			/*AJAX*/
			$.ajax({
				url: "<?php echo $urlserver.'functions/menosfav.php?idproducto='?>"+id,
				success: function(info) {
					if(info == 1){
						console.log(info);
						myobj.remove();
						window.location.replace('<?php echo SITEUSER.'favoritos'?>');
					}else if(info == 2){
						alert("Error al borrar el producto de tus favoritos.");
					}else{
						console.log(info);
					}
				},
				error: function() {
					window.location.replace('<?php echo SITEUSER.'favoritos'?>');
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
	</script>
</body>
</html>
