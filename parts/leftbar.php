<ul id="links-account">
	<a href="<?php echo SITEUSER?>favoritos" title="Mis favoritos"><li id="list-favoritos">Mis favoritos</li></a>
	<a href="<?php echo SITEUSER?>mis-compras" title="Mis compras"><li id="list-mis-compras">Mis compras</li></a>
	<a href="<?php echo SITEUSER?>mis-direcciones" title="Mis direcciones"><li id="list-mis-direcciones">Mis direcciones</li></a>
	<a href="<?php echo SITEUSER?>mi-cuenta" title="Seguridad"><li id="list-mi-cuenta">Mi Cuenta</li></a>
	<a href="<?php echo SITEUSER?>salir" title="Salir"><li id="list-salir">Salir</li></a>
</ul>
<script>
	$(function() {
		var url = location.pathname.split("/")[2];
		if(url){
	  		$('#list-'+url).addClass('active');	
		}else{
			//$('#home').addClass('active');
		}
	});
</script>