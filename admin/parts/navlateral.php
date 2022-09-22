<nav class="collapse" id="lateralpanel">
	<div class="scroller">
		<ul id="menubar">
			<li><a href="<?php echo SITE ?>admin" id="home"><i class="fas fa-home"></i> Inicio</a></li>
			<li><a href="<?php echo SITE ?>admin/publicidad"><i class="fas fa-ad"></i> Publicidad</a></li>
			<li><a href="<?php echo SITE ?>admin/nueva/publicidad"><i class="fas fa-ad"></i> Nueva Publicidad</a></li>
			<li><a href="<?php echo SITE ?>admin/clientes-publicidad"><i class="fas fa-ad"></i> Clientes Publicidad</a></li>
			<li><a href="<?php echo SITE ?>admin/escaparates"><i class="fas fa-store-alt"></i> Escaparates</a></li>
			<li><a href="<?php echo SITE ?>admin/escaparates-principales"><i class="fas fa-store"></i> Escaparates Principales</a></li>
			<li><a href="<?php echo SITE ?>admin/paquetes"><i class="fas fa-box-open"></i> Paquetes</a></li>
			<li><a href="<?php echo SITE ?>admin/clientes"><i class="fas fa-file-invoice-dollar"></i> Clientes</a></li>
			<li><a href="<?php echo SITE ?>admin/promociones"><i class="fas fa-percentage"></i> Promociones</a></li>
			<li><a href="<?php echo SITE ?>admin/mis-datos"><i class="far fa-file-alt"></i> Mis Datos</a></li>
			<li><a href="<?php echo SITE ?>admin/administradores"><i class="fas fa-users"></i> Admins</a></li>
			<li><a href="<?php echo SITE ?>admin/banners"><i class="fas fa-images"></i> Banners</a></li>
			<li><a href="<?php echo SITE ?>admin/contenido"><i class="fas fa-images"></i> Contenido</a></li>
			<li><a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
		</ul>
	</div>
</nav>
<script>
	$(function() {
		var url = location.pathname.split("/")[2];
		
		if(url){
	  		$('#menubar li a[href="<?php echo SITE ?>admin/' + url + '"]').addClass('active');			
		}else{
			$('#home').addClass('active');
		}
	});
	$('.navbar-toggler').click(function(){
		console.log("hola");
	});
	$('.navbar-toggler').on('shown.bs.collapse', function () {
	   $('#content-info').addClass( "highlight" );
		console.log("hola");
	});
	

	$('.navbar-toggler').on('hidden.bs.collapse', function () {
	   $('#content-info').removeClass( "highlight" );
	});
	
</script>