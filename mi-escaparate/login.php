<?php
	session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
	require('connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
	}
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";

	if (isset($_SESSION['tiendauser'])) {
		if($_SESSION['tiendauser']!=""){
			header('location:'.SITE.'mi-escaparate');
		}
	}
	$last = explode("/", $server, 5);
	$urlparts = $http.$last[2].'/'.$last[3].'/';
	$aviso="";
	//LOGIN_USER
	if(isset($_POST['email']) AND isset($_POST['password'])){
		$email_login = $_POST['email'];
		$pass_login = md5($_POST['password']);
		$sql ="SELECT id_tienda, email_tienda, nick_tienda, pass_tienda, activa_tienda FROM tiendas WHERE email_tienda = '$email_login' AND pass_tienda = '$pass_login' AND activa_tienda != 0";
		$req=mysqli_query($conex, $sql);
		$row_cnt = $req->num_rows;
		while($result = mysqli_fetch_object($req)){
		$id_tienda = $result->id_tienda;
		$email_tienda = $result->email_tienda;
		$activa_tienda = $result->activa_tienda;
		$nick_tienda = $result->nick_tienda;
		}
		if($row_cnt == 1 AND $activa_tienda == 1){
			header("location:".SITE.'mi-escaparate');
			$_SESSION["idtienda"]=$id_tienda;
			$_SESSION["tiendauser"]=$email_tienda;
		}else if($row_cnt == 1 AND $activa_tienda == 2){
			header("location:".SITE."mi-escaparate/nuevo?escaparate=$nick_tienda&id=$id_tienda");
			return;
		}else if($row_cnt == 1 AND $activa_tienda == 3){
			header("location:".SITE."mi-escaparate/nuevo/paso2?id=$id_tienda&escaparate=$nick_tienda");
			return;
		}
		else{
			$aviso="No es posible iniciar sesión, por favor verifica tu usuario o contraseña.";
		}
	}
$sqlContenido="SELECT file_contenido FROM contenido_editable WHERE id_contenido = 2";
$reqContenido=mysqli_query($conex, $sqlContenido);	
while($resulContenido = mysqli_fetch_object($reqContenido)){		
	$file_contenido = $resulContenido->file_contenido;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Bienvenido a tu escaparate | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>mi-escaparate/js/bootstrap-show-password.js"></script>
<style>
	#login-box{background-image:url(<?php echo SITE.'img/'.$file_contenido?>)}
</style>
</head>

<body>
	<nav class="navbar navbar-yellow navbar-expand-md bg-light justify-content-center">
		<div class="container">
			<div class="navbar-collapse justify-content-between align-items-center w-100">
				<a href="<?php echo SITE?>mi-escaparate" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce.svg" alt="Ecommerce" width="82px"></a> 
			</div>
		</div>
	</nav>
	<section id="login-box">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1 class="title-section">Hola, te esperábamos.</h1>
				</div>
				<br>
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-4">
					<div class="bg-white rounded-top tab-head">
					  <ul class="nav nav-tabs" id="registro-login" role="tablist">
						<li class="nav-item">
						  <a class="nav-link" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="form-registro" aria-selected="true">Crea un escaparate</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="form-registro" aria-selected="false">Identifícate</a>
						</li>
					  </ul>
					</div>
					<div class="bg-white p-3">   
					  <div class="tab-content mt-4" id="form-registro">
						<div class="tab-pane" id="registro" role="tabpanel" aria-labelledby="home-tab">
							<form method="post" action="nuevo">
								<div class="form-group">
									<input type="text" name="escaparate" id="escaparate" class="form-control" placeholder="Nombre de tu escaparate*" onfocusout="checkname()" onkeyup="checkchar()" pattern="^[a-zA-Z0-9\.\-]*$" minlength="3" maxlength="20" required autocomplete="off">
									<span id="avisonew" class="text-danger"></span>
									<small>*El nombre de tu escaparate no podrá ser modificado posteriormente.</small>
								</div>
								<div class="form-group">
									<input type="text" name="nombre" class="form-control" placeholder="Nombre(s) / Nombre de tu empresa" required>
								</div>
								<div class="form-group">
									<input type="text" name="apellidos" class="form-control" placeholder="Apellidos*">
									<small>*Opcional</small>
								</div>
								<div class="form-group">
									<input type="email" name="emailnew" id="emailnew" class="form-control" placeholder="Correo electrónico" onfocusout="checkmail()" required autocomplete="off">
									<span id="avisomail" class="text-danger"></span>
								</div>
								<div class="form-group">
									<input type="password" name="passwordnew" id="passwordnew" class="form-control" placeholder="Contraseña" required minlength="6" data-toggle="password">
								</div>
								<div class="form-group">
									<input type="password" name="confirmapasswordnew" id="confirmapasswordnew" class="form-control" placeholder="Confirma tu contraseña" required minlength="6" onkeyup="passwordcheck()" data-toggle="password">
									<span id="avisopass"></span>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="acepto" id="terminos" name="terminos" onChange="checkbox()">
									<label class="form-check-label" for="terminos">
									<a href="#" data-toggle="modal" data-target="#terminosycondiciones">Acepto terminos y condiciones</a>
									</label>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary col-12" id="crearcuenta" disabled>Crea tu escaparate</button>
								</div>
							</form>
							<div class="modal fade bd-example-modal-lg" id="terminosycondiciones" tabindex="-1" role="dialog" aria-labelledby="terminosycondicionesLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="terminosycondicionesLabel">Terminos y condiciones</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
									<div class="modal-body">
										<p><strong>1.Ecommerce</strong> está creado para ayudarte a vender tus productos y servicios por medio de escaparates virtuales dentro de nuestro sitio web, los cuales te servirán como una herramienta de apoyo al realizar tus ventas, ya que el link de tu página te puede servir como tarjeta de presentación digital, también como un aviso clasificado, pues puedes publicar hasta diez anuncios promocionales sin costo, y por si fuera poco, al pagar un anuncio en redes sociales, le agregas tu link y si el cliente le da click, el link lo direccionará a tu escaparate, multiplicando el anuncio pagado  en los diez anuncios que ya tienes publicados con nosotros de manera gratuita. </p>
				<p>De ésta manera tu escaparate se convierte en una gran herramienta, ya sea, que como influencer quieras crear tu propia gama de productos, o bien, si eres una empresa establecida con productos propios, o un profesional ofreciendo sus servicios, Ecommerce te ayudará en la comercialización de los mismos.	</p>
				<hr>
				<p><strong>2.Si eres influencer comisionista:</strong> Ecommerce te pagará el 15% por cada uno de los productos que vendas y te entregará una pieza muestra para realizar la promoción correspondiente al 50% de su precio normal de venta. La manera de cobrar dichas comisiones será a través de factura, bajo el rubro comisiones similares a salarios, con lapso de corte del día primero al último día de cada mes, ingresando su factura del día 1 al 5 del mes inmediato siguiente al corte, misma que será liquidada a más tardar el día 10 de cada mes.</p>
				<hr>
				<p><strong>3.Si eres particular o empresa con productos propios:</strong> Ecommerce te convierte en su proveedor, por lo que deberás facturar y contemplar en el precio publicado de cada producto, los impuestos correspondientes, gastos de envío y comisión por venta la cual deberás especificar al aperturar tu escaparate; ya que Ecommerce funciona como un centro comercial digital, el cual es intermediario entre tu empresa y el comprador final, por lo que Ecommerce facturará al cliente directamente, realizándote el pedido y pagando tu factura (la cual deberás ingresar inmediatamente recibas el pedido) una vez que el cliente tenga el artículo solicitado en sus manos cumpliendo con las características prometidas.</p>
				<hr>
				<p><strong>4.Abrir un escaparate virtual es completamente gratis</strong>, es como si registraras tu perfil comercial o adquirieras un local digital, así que tendrás derecho a colocar hasta diez productos o promociones y publicar tus datos para el cliente te pueda contactar directamente, sin embargo, en todo momento se le informará al cliente que al salir de la plataforma, Ecommerce no se hace responsable de la compra; además de que la tienda no tiene derecho a posición específica en la portada que le corresponda, y por otra parte Ecommerce se reserva el derecho de comercializar los espacios publicitarios existentes dentro de cada perfil comercial.</p>
				<hr>
				<p><strong>5.En Ecommerce existen tres tipos de paquetes</strong>, el primero es el gratuito mencionado en el punto anterior; el segundo es el comercial, el cual te permite publicitar hasta 30 productos y te da el derecho de colocar tu imagen o logotipo dentro de las primeras posiciones en la portada que le corresponda conforme a tus ventas, pero Ecommerce se reserva el derecho de comercializar espacios publicitarios; por último, tenemos el paquete VIP el cual te permite publicitar hasta 50 productos, te da el derecho de colocar tu imagen o logotipo dentro de las primeras posiciones en la portada que le corresponda conforme a tus ventas, y permite colocar tu imagen dentro de los espacios publicitarios de tu perfil de manera exclusiva.</p>
				<hr>
				<p><strong>6.Si eres sólo un cliente</strong> que desea recorrer el sitio web, deberás registrarte en Ecommerce y aceptar que utilicemos tus datos personales como ayuda para conocer tus preferencias, y así mostrarte anuncios de empresas que pueden interesarte, ya sea como clientes, proveedores o simplemente para realizar alianzas estratégicas. Esto no nos da derecho a negociar, entregar y/o vender tu información bajo ninguna circunstancia.</p>
				<p>Sin duda, como ya lo hemos mencionado en tu página puedes colocar lo que desees promocionar, pero debes responsabilizarte de mantenerla con información actualizada y promociones vigentes, pues estás obligado por Profeco a cumplir con todo lo prometido de acuerdo a la Ley Federal del Consumidor.</p>
				<hr>
				<p><strong>7.IMPORTANTE:</strong> Por ningún motivo se permitirá la venta de artículos ilegales o que violen los derechos de terceros. si esto llegara a pasar, la empresa tiene la obligación de dar aviso a las autoridades correspondientes.</p>
				<hr>
				<p><strong>8.Toda la comunidad de Ecommerce se regirá bajo los siguientes principios:</strong></p>
				<p><strong>- Privacidad:</strong> El compromiso será proteger la información y la privacidad de las personas y las empresas participantes, su información será tratada de acuerdo a la Ley Federal de Protección de Datos Personales en Posesión de Particulares.</p>
				<p><strong>Autenticidad:</strong> Nos interesa que cada producto o servicio ofertado aquí sea creado o comercializado de manera clara y auténtica, sin engaño, dolo o mentira en detrimento de los clientes.</p>
				<p><strong>- Honestidad:</strong> Por ningún motivo se le permitirá al proveedor, mentir al consumidor sobre los productos que ofrece en venta (calidad, tiempo de entrega, descuento, promoción, etc.), se debe cumplir lo que se ofrece, de lo contrario será dado de baja, tendrá que devolver el dinero al consumidor y se le cobrara una indemnización por engaño a la plataforma.</p>
				<p><strong>- Imparcialidad:</strong> la empresa tratará a toda su comunidad como su amigo y cliente principal, así se trate del más pequeño comerciante o de una gran trasnacional.</p>
				<p><strong>- Responsabilidad:</strong> disciplina y profesionalismo serán características que representarán a nuestra empresa frente a la sociedad.</p>
				<p><strong>- Dignidad:</strong> Creemos que todas las personas tienen los mismos derechos, por lo que esperamos que respeten la dignidad de los demás y no los acosen ni los degraden. La relación comercial que surja entre nuestros usuarios debe ser clara y transparente.</p>
				<p><strong>- Tolerancia:</strong> sabemos perfectamente que no todos pensamos igual por lo que seremos respetuosos de todas y cada una de las posturas y creencias de nuestra comunidad, pidiendo el mismo respeto hacia nosotros y entre los miembros de la misma.</p>
				<p><strong>- Empatía:</strong> es nuestro compromiso principal ponernos en los zapatos de cada uno de nuestros clientes con el fin de entenderlos y ayudarlos a lograr sus objetivos.</p>
				<hr>
				<p><strong>9.Es importante aclarar</strong> que cualquier situación que no se encuentre contemplada en éstas líneas, y en especial si está relacionada con la venta de los espacios publicitarios, será atendida por el departamento correspondiente o en su defecto directamente por la gerencia de relaciones públicas en el WhatsApp <a href="https://api.whatsapp.com/send?phone=2221134143" target="_blank"><strong>222 113 4143</strong></a>.</p> 
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="profile-tab">
						  	<form method="post" action="<?php echo SITE.'mi-escaparate/entrar'?>">
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Contraseña" required data-toggle="password">
								</div>
								<!--<div class="form-check">
									<input type="checkbox" class="form-check-input" id="recordarme">
									<label class="form-check-label" for="recordarme">Recordarme</label>
								</div>-->
								<div class="form-check">
									<button type="submit" class="btn btn-primary col-12">Bienvenid@</button>
								</div>
							</form>
							<a href="<?php echo SITE.'mi-escaparate/recuperar'?>" style="text-align: center; display: block; margin: 15px auto">Recuperar contraseña</a>
							<div class="row">
								<div style="margin-top: 15px">
									<p class="text-center"><?php echo $aviso?></p>
								</div>
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	<script>
		//ELIMINAMOS Y PONEMOS EN MINUSCULAS
		function checkchar(){
			var escaparate = document.getElementById("escaparate").value;
			escaparate=escaparate.replace(".","-")
			escaparate=escaparate.replace("--","-")
			escaparate = escaparate.replace(/[^a-zA-Z0-9\-]/g, '');
			;
			escaparate = escaparate.toLowerCase()
			document.getElementById("escaparate").value=escaparate;
		}
		//VERFICIAMOS EL ESCAPARATE
		function checkname(){
			var escaparate = document.getElementById("escaparate").value;
			if(escaparate.length>3){
				escaparate = escaparate.replace(/[^a-zA-Z0-9\.\-]/g, '');
				document.getElementById("escaparate").value=escaparate;
				var url = '<?php echo $urlserver.'mi-escaparate/functions/checkname.php?nes='?>'+escaparate;
				$.ajax({                    
					  url: url,
					  success: function(data){
						  if(data >0){
							  document.getElementById("avisonew").innerHTML = "Nombre de escaparate no disponible.";
							  //document.getElementById("escaparate").focus();
							  $( "#escaparate" ).removeClass( "border border-success" );
							  $( "#escaparate" ).addClass( "border border-danger" );
							  document.getElementById("crearcuenta").disabled = true;
							  $( "#avisonew" ).removeClass( "text-success" );
							  $( "#avisonew" ).addClass( "text-danger" );
						  }else{
							   document.getElementById("avisonew").innerHTML = "Nombre de escaparate disponible.";
							  $( "#escaparate" ).removeClass( "border border-danger" );
							  $( "#escaparate" ).addClass( "border border-success" );
							  $( "#avisonew" ).removeClass( "text-danger" );
							  $( "#avisonew" ).addClass( "text-success" );
							  document.getElementById("crearcuenta").disabled = false;
						  }
					  },
						error: function(data){

						}
				});
			}else{
				document.getElementById("avisonew").innerHTML = "Nombre de escaparate no válido.";
				document.getElementById("crearcuenta").disabled = true;
			}
		}
		//VERIFICAMOS EL CORREO
		function checkmail(){
			var emailnew = document.getElementById("emailnew").value
			 var urlmail = '<?php echo $urlserver.'mi-escaparate/functions/checkname.php?nma='?>'+emailnew;
			$.ajax({                    
				  url: urlmail,
				  success: function(mail){
					  console.log(mail);
					  if(mail >0){
						  
						  document.getElementById("avisomail").innerHTML = "Este correo electrónico ya esta ligado a un escaparate.";
						 // document.getElementById("emailnew").focus();
						  $( "#emailnew" ).removeClass( "border border-success" );
						  $( "#emailnew" ).addClass( "border border-danger" );
						  document.getElementById("crearcuenta").disabled = true;
						  $( "#avisomail" ).removeClass( "text-success" );
						  $( "#avisomail" ).addClass( "text-danger" );
					  }else{
						  document.getElementById("avisomail").innerHTML = "Tu correo electrónico es valido.";
						  $( "#emailnew" ).removeClass( "border border-danger" );
						  $( "#emailnew" ).addClass( "border border-success" );
						  $( "#avisomail" ).removeClass( "text-danger" );
						  $( "#avisomail" ).addClass( "text-success" );
					  }
				  },
					error: function(data){
						
					}
				
			});
		}
		//VERIFICAMOS LA CONTRASEÑA
		function passwordcheck(){
			var passwordnew = document.getElementById("passwordnew").value;
			var confirmapasswordnew = document.getElementById("confirmapasswordnew").value;
			if(passwordnew.length>=6){
			if(passwordnew != confirmapasswordnew){
				document.getElementById("avisopass").innerHTML = "Las contraseñas no coinciden.";
				$( "#confirmapasswordnew" ).addClass( "border border-danger" );
				$( "#confirmapasswordnew" ).removeClass( "border border-success" );
				$( "#avisopass" ).addClass( "text-danger" );
				$( "#avisopass" ).removeClass( "text-success" );
				 document.getElementById("crearcuenta").disabled = true;
			}else{
				document.getElementById("avisopass").innerHTML ="";
				$( "#confirmapasswordnew" ).removeClass( "border border-danger" );
				$( "#confirmapasswordnew" ).addClass( "border border-success" );
			}
			}else{
				document.getElementById("avisopass").innerHTML ="Ingresa al menos 6 caracteres.";
				 document.getElementById("crearcuenta").disabled = true;
			}
		}
		function checkbox(){
			if ($('#terminos').prop('checked', true)) {
				 document.getElementById("crearcuenta").disabled = false;
			}else{
				document.getElementById("crearcuenta").disabled = true;
			}
		}
	</script>
</body>
</html>