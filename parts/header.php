<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FNRR9L"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
	include('functions/ads-new.php');
	if(isset($_GET['cat'])){
		$tiendaads = $_GET['cat'];
	}else{
		$tiendaads="";
	}
?>
<div id="header-ads">
	<?php list($id,$imgtop,$linktop,$tipopubli,$host_server) = ads("hb","$tiendaads","principal","0");?>
		<a href="<?php echo $linktop?>" target="<?php echo checklinkads($linktop,$host_server)?>" onclick="adsclick(<?php echo $id?>,'hb')"><img src="<?php echo SITEUSER.'img/publicidad/'.$imgtop?>" alt="" class="img-fluid img-ads"></a>
</div>
	<section id="top-line-links" class="navbar navbar-expand-md justify-content-center">
		<div class="container">
			<div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar1">
				<a href="<?php echo $urlserver?>entrar" title="Visitante" class="mr-0 flex-row" id="visitantes-header">Visitante</a>
				<ul class="navbar-nav mx-auto text-center">
					<li class="nav-item">
					<a class="nav-link" href="https://www.facebook.com/ecommerce/" target="_blank"><i class="fab fa-facebook-f"></i></a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="https://twitter.com/ecommerce" target="_blank"><i class="fab fa-twitter"></i></a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="https://www.instagram.com/ecommerce/" target="_blank"><i class="fab fa-instagram"></i></a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="https://www.youtube.com/channel/UCanuSHXJv6FmulDsRQHI0wA" target="_blank"><i class="fab fa-youtube"></i></a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="https://api.whatsapp.com/send?phone=5212221134143&text=Hola" target="_blank"><i class="fab fa-whatsapp"></i></a>
					</li>
				</ul>
				<div class="nav navbar-nav flex-row justify-content-center flex-nowrap" id="header-cat">
					<form method="get" accept-charset="UTF-8" action="<?php echo $urlserver."buscar"?>" id="buscarform">
						<input type="text" name="s" required class="form-control" id="s" title="Por favor ingresa al menos 3 letras." pattern="[a-z A-Z 0-9]{3,25}">
						<button type="submit" class="btn btn-primary" id="btn-buscar">Buscar</button>
					</form>
				</div>
			</div>
		</div>
	</section>
	<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
		<div class="container">
			<a href="<?php echo $urlserver ?>" class="navbar-brand mr-0"><img src="<?php echo $urlserver?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
			<button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar2">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar2">
				<ul class="navbar-nav mx-auto text-center" id="pages-links">
					<li class="nav-item" id="btn-inicio">
					<a class="nav-link" href="<?php echo $urlserver?>">Inicio <span class="sr-only">Inicio</span></a>
					</li>
					<li class="nav-item" id="btn-influencers">
					<a class="nav-link" href="<?php echo $urlserver."influencers"?>">Influencers<span class="sr-only">Influencers</span></a>
					</li>
					<li class="nav-item" id="btn-empresas">
					<a class="nav-link" href="<?php echo $urlserver."empresas"?>">Empresas<span class="sr-only">Empresas</span></a>
					</li>
					<li class="nav-item" id="btn-profesionales">
					<a class="nav-link" href="<?php echo $urlserver."profesionales"?>">Profesionales <span class="sr-only">Profesionales</span></a>
					</li>
				</ul>
			<ul class="nav navbar-nav flex-row justify-content-center flex-nowrap" id="links-cart">
				<?php if (isset($_SESSION['emailuser']) OR !empty($_SESSION['emailuser'])) {?>
				<li class="nav-item" id="btn-fav"><a class="nav-link" href="<?php echo $urlserver."favoritos"?>" title="Mis favoritos"><i class="fas fa-heart"></i></a> </li>
				<?php }?>
				<li class="nav-item" id="btn-cuenta"><a class="nav-link" href="<?php echo $urlserver."mi-cuenta"?>" title="Mi cuenta"><i class="fas fa-user"></i></a></li>
				<?php if (isset($_SESSION['emailuser']) OR !empty($_SESSION['emailuser'])) {?>
				<li class="nav-item" id="btn-carrito"><a class="nav-link" href="<?php echo $urlserver."carrito"?>" title="Mi carrito"><i class="fas fa-shopping-cart"></i></a></li>
				<?php }?>
			</ul>
			</div>
		</div>
	</nav>