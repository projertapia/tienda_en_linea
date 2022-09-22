<?php
	$bar_mail = $_SESSION['tiendauser'];
	$sqlinfo="SELECT id_tienda, nombre_tienda, categoria_tienda, logo_tienda, cover_tienda, nick_tienda, email_tienda, email_contacto_tienda, activa_tienda FROM tiendas WHERE email_tienda ='$bar_mail' AND activa_tienda = 1";
	$reqinfo=mysqli_query($conex, $sqlinfo);
	while($resulinfo = mysqli_fetch_object($reqinfo)){
		$id_tienda = $resulinfo->id_tienda;
		$nombre_tienda = $resulinfo->nombre_tienda;
		$nick_tienda = $resulinfo->nick_tienda;
		$logo_tienda = $resulinfo->logo_tienda;
		$cover_tienda = $resulinfo->cover_tienda;
		$categoria_tienda = $resulinfo->categoria_tienda;
	}
?>
<nav class="collapse" id="lateralpanel">	
		<div id="logoshow" style="background-image: linear-gradient(to bottom, rgb(253 235 0 / 0%), rgb(253 235 0)),url(<?php echo SITE ?>img/tiendas/<?php echo $nick_tienda.'/'.$cover_tienda?>);">
			<div id="imagecover" style="background-image: url(<?php echo SITE ?>img/tiendas/<?php echo $nick_tienda.'/'.$logo_tienda?>)"></div>
			<h2><a href="<?php echo SITE.CATTIENDA.'/'.$nick_tienda?>" target="_blank"><?php echo substr($nick_tienda,0, 14)?></a></h2>
		</div>
	<div class="scroller">
		<ul id="menubar">
			<li><a href="<?php echo SITE ?>mi-escaparate" id="home"><i class="fas fa-home"></i> Inicio</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/crear-nuevo"><i class="fas fa-tshirt"></i> Nuevo Producto</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/mis-productos"><i class="fas fa-tags"></i> Productos</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/mis-ventas"><i class="fas fa-store-alt"></i> Ventas</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/crear-promo"><i class="fas fa-percentage"></i> Nueva Promo</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/mis-promociones"><i class="fas fa-ad"></i> Promociones</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/mis-datos"><i class="far fa-file-alt"></i> Mis Datos</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/mis-reportes"><i class="fas fa-file-invoice-dollar"></i> Reportes</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/crear-productos"><i class="fas fa-box-open"></i> Crear Productos</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/mi-plan"><i class="fas fa-file-contract"></i> Mi Plan</a></li>
			<li><a href="<?php echo SITE ?>mi-escaparate/salir"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
		</ul>
	</div>
</nav>
<script>
	$(function() {
		var url = location.pathname.split("/")[3];
		
		if(url){
	  		$('#menubar li a[href^="<?php echo SITE ?>mi-escaparate/' + url + '"]').addClass('active');			
		}else{
			$('#home').addClass('active');
		}
	});
</script>