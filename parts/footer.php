<footer>
		<div class="container">
			<div class="row">
				<div class="d-none d-xl-block col-lg-2"></div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-2"><img src="<?php echo $urlserver?>img/ecommerce.svg" alt="Ecommerce" class="img-fluid" id="logo-footer">
					<address>
						<strong>Ecommerce</strong><br>
						<abbr title="Phone"><i class="fab fa-whatsapp"></i>: <a href="https://api.whatsapp.com/send?phone=5212221134143&text=Hola" target="_blank">222-113-4143</a></abbr>
					</address>
					<address>
						<a href="mailto:contacto@ecommerce.com" target="_blank" style="font-size: 12px">contacto@ecommerce.com</a>
					</address>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-8">
					<div class="row" id="links-footer">
						<div class="col-md-4 col-6">
							<h5>INFORMACIÓN</h5>
							<a href="<?php echo $urlserver?>contactanos" title="Contáctanos">Contáctanos</a>
							<a href="<?php echo $urlserver?>mapa-de-sitio" title="Mapa del sitio">Mapa del sitio</a>
							<a href="<?php echo $urlserver?>historias" title="Historias">Historias</a>
							<a href="<?php echo $urlserver?>mi-escaparate" title="Mi escaparate">Mi escaparate</a>
						</div>
						<div class="col-md-4 col-6">
							<h5>NUESTRA COMPAÑÍA</h5>
							<a href="<?php echo $urlserver?>entrega" title="Entrega">Entrega</a>
							<a href="<?php echo $urlserver?>aviso-legal" title="Aviso Legal">Aviso Legal</a>
							<a href="<?php echo $urlserver?>terminos-y-condiciones" title="Terminos y Condiciones">Términos y Condiciones</a>
							<a href="<?php echo $urlserver?>sobre-nosotros" title="Sobre Nosotros">Sobre nosotros</a>
							<a href="<?php echo $urlserver?>preguntas-frecuentes" title="Preguntas Frecuentes">Preguntas Frecuentes</a>
						</div>
						<div class="col-md-4 col-12">
							<h5>MI CUENTA</h5>
							<?php if (!isset($_SESSION['emailuser']) OR $_SESSION['emailuser']=="") {?>
							<a href="<?php echo $urlserver?>entrar" title="">Iniciar sesión</a>
							<?php }else{ ?>
							<a href="<?php echo $urlserver?>mi-cuenta" title="">Mi Cuenta</a>							
							<a href="<?php echo $urlserver?>mis-compras" title="Pedidos">Pedidos</a>
							<a href="<?php echo $urlserver?>mis-direcciones" title="Direcciones">Direcciones</a>
							<a href="<?php echo $urlserver?>salir" title="Salir">Salir</a>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div id="derechos-reservados">
					© 2020 ecommerce.com Todos los derechos reservados.
				</div>
			</div>
		</div>
	</footer>
<script src="<?php echo SITEUSER?>js/bootstrap.min.js"></script>
<script src="<?php echo SITEUSER?>js/popper.min.js"></script>
<script src="<?php echo SITEUSER?>js/all.min.js"></script>
<script src="<?php echo $urlserver?>js/myjs.js"></script>