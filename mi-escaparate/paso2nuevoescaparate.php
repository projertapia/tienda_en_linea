<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/resize-class.php');
	$aviso="";
	if(isset($_POST['idtienda']) AND $_POST['idtienda'] != ""){
		$idtienda = $_POST['idtienda'];
		$email_tienda = $_POST['email_tienda'];
		$cumple = $_POST['cumple'];
		$tipodeescaparate = $_POST['tipodeescaparate'];
		$color = $_POST['color'];
		$color = str_replace ( "#", '', $color);
		//$logo = $_POST['logo'];
		//$portada = $_POST['portada'];
		$video_tienda = $_POST['video_tienda'];
		$fb_tienda = $_POST['fb_tienda'];
		$insta_tienda = $_POST['insta_tienda'];
		$yt_tienda = $_POST['yt_tienda'];
		$tik_tienda = $_POST['tik_tienda'];
		$twitch_tienda = $_POST['twitch_tienda'];
		$tw_tienda = $_POST['tw_tienda'];
		$in_tienda = $_POST['in_tienda'];
		$web_tienda = $_POST['web_tienda'];
		$wapp_tienda = $_POST['wapp_tienda'];
		$maps_tienda = $_POST['maps_tienda'];
		$escaparate = $_POST['escaparate'];
		$desc_tienda = $_POST['desctienda'];
		$paso = $_POST['paso'];
		
		$rowcat="";
		foreach($_POST['categorias'] as $categorias){
			$rowcat.=$categorias.",";
		}
		
		if(empty($video_tienda)){
			$video_tienda =NULL;
		}
		if(empty($fb_tienda)){
			$fb_tienda =NULL;
		}
		if(empty($insta_tienda)){
			$insta_tienda =NULL;			
		}
		if(empty($tw_tienda)){
			$tw_tienda =NULL;
		}
		if(empty($yt_tienda)){
			$yt_tienda =NULL;
		}
		if(empty($tik_tiend)){
			$tik_tienda =NULL;
		}
		if(empty($twitch_tienda)){
			$twitch_tienda =NULL;
		}
		if(empty($in_tienda)){
			$in_tienda =NULL;
		}
		if(empty($web_tienda)){
			$web_tienda =NULL;
		}
		if(empty($wapp_tienda)){
			$wapp_tienda =NULL;
		}
		if(empty($maps_tienda)){
			$maps_tienda =NULL;
		}
		
			$paso2 = "UPDATE tiendas SET cumple_tienda='$cumple', categoria_tienda='$tipodeescaparate', color_tienda='$color', fb_tienda='$fb_tienda', insta_tienda = '$insta_tienda', yt_tienda ='$yt_tienda', tik_tienda = '$tik_tienda', twitch_tienda='$twitch_tienda', in_tienda ='$in_tienda', web_tienda ='$web_tienda',wapp_tienda ='$wapp_tienda', maps_tienda ='$maps_tienda', video_tienda = '$video_tienda', desc_tienda = '$desc_tienda', categorias_tienda = '$rowcat', activa_tienda = '$paso'  WHERE id_tienda ='$idtienda'";
			if ($conex->query($paso2) === TRUE) {
				$infook=true;
			} else {
				$infook=false;
				$aviso="Lo sentimos no es posible guardar los datos de tienda.";
			}
		
	}else{
		if((!isset($_GET['id']) AND $_GET['id'] == "")){
			header('location:'.SITE.'mi-escaparate/entrar');
		}
	}
	if((isset($_GET['id']) AND $_GET['id'] != "") OR (isset($_POST['idtienda']) AND $_POST['idtienda'] != "")){
		$infook=true;
		if((isset($_GET['id']) AND $_GET['id'] != "")){
			$idtienda = $_GET['id'];
		}else{
			$idtienda = $_POST['idtienda'];
		}
		$sqlreturn="SELECT id_tienda, nick_tienda, email_tienda FROM tiendas WHERE id_tienda = $idtienda";
		$req= mysqli_query($conex, $sqlreturn);
		while($resultReturn= mysqli_fetch_object($req)){
			$escaparate= $resultReturn->nick_tienda;
			$email_tienda= $resultReturn->email_tienda;
		}
	}else{
		$infook=false;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Configura tu cuenta| Ecommerce</title>
<?php include("parts/header.php");?>
<link rel="stylesheet" href="<?php echo SITE?>css/escaparatecss.css">
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
				<?php if($infook==true){?>
				<h1 class="title-section">Configura tu escaparate <span style="font-size: 16px; display: block">Datos fiscales</span></h1>
				<br>
				<div class="col-md-6 offset-md-3">
					<form accept-charset="UTF-8" enctype="multipart/form-data" action="paso3" id="completar-escaparate" method="post" class="box-white">
						<input type="hidden" name="escaparate" value="<?php echo $escaparate?>">
						<input type="hidden" name="idtienda" value="<?php echo $idtienda?>">
						<input type="hidden" name="email_tienda" value="<?php echo $email_tienda?>">
						<div class="form-group">
							<label for="rsocial">¿Cuál es tu razón social?</label>
							<input name="rsocial" type="text" required class="form-control" pattern="{2,254}">
						</div>
						<div class="form-group">
							<label for="tipo">¿Qué tipo de contribuyente eres?</label>
							<select name="tipo" class="form-control" required>
								<option value="Persona Física">Persona Física</option>
								<option value="Persona Moral">Persona Moral</option>
							</select>
						</div>
						<div class="form-group">
							<label for="rfc">¿Cuál es tu RFC?</label>
							<input name="rfc" type="text" required class="form-control" maxlength="13" minlength="12" pattern="{15-16}" onkeyup="javascript:this.value=this.value.toUpperCase();" title="Por favor ingresa un RFC válido.">
						</div>
						<div class="form-group">
							<label for="df_domicilio">Domicilio Fiscal</label>
							<input name="df_domicilio" type="text" required class="form-control">
						</div>
						<div class="form-group">
							<label for="df_estado">Estado del domicilio Fiscal</label>
							<select name="df_estado" class="form-control" required="">
								<option value="Aguascalientes">Aguascalientes</option>
								<option value="Baja California">Baja California</option>
								<option value="Baja California Sur">Baja California Sur</option>
								<option value="Campeche">Campeche</option>
								<option value="CDMX">CDMX</option>
								<option value="Chiapas">Chiapas</option>
								<option value="Chihuahua">Chihuahua</option>
								<option value="Coahuila">Coahuila</option>
								<option value="Colima">Colima</option>
								<option value="Durango">Durango</option>
								<option value="Edo. De México">Edo. De México</option>
								<option value="Guanajuato">Guanajuato</option>
								<option value="Guerrero">Guerrero</option>
								<option value="Hidalgo">Hidalgo</option>
								<option value="Jalisco">Jalisco</option>
								<option value="Michoacán">Michoacán</option>
								<option value="Morelos">Morelos</option>
								<option value="Nayarit">Nayarit</option>
								<option value="Nuevo León">Nuevo León</option>
								<option value="Oaxaca">Oaxaca</option>
								<option value="Puebla">Puebla</option>
								<option value="Querétaro">Querétaro</option>
								<option value="Quintana Roo">Quintana Roo</option>
								<option value="San Luis Potosí">San Luis Potosí</option>
								<option value="Sinaloa">Sinaloa</option>
								<option value="Sonora">Sonora</option>
								<option value="Tabasco">Tabasco</option>
								<option value="Tamaulipas">Tamaulipas</option>
								<option value="Tlaxcala">Tlaxcala</option>
								<option value="Veracruz">Veracruz</option>
								<option value="Yucatán">Yucatán</option>
								<option value="Zacatecas">Zacatecas</option>
							</select>
						</div>
						<div class="form-group">
							<label for="df_cp">Códigó Postal Fiscal</label>
							<input name="df_cp" type="number" required class="form-control" maxlength="5" minlength="5">
						</div>
						<div class="form-group">
							<label for="df_numero">Número de contacto Fiscal</label>
							<input name="df_numero" type="tel" required class="form-control" >
						</div>
						<div class="form-group">
							<label for="df_facturacion">Correo electrónico para facturación</label>
							<input name="df_facturacion" type="email" required class="form-control">
						</div>
						<button type="submit" class="btn btn-success">Continuar <i class="fas fa-chevron-right"></i></button>
					</form>
				</div>				
				<?php }else{ ?>
				<h1 class="text-danger"><?php echo $aviso?></h1>
				<a href="../nuevo?escaparate=<?php echo $escaparate?>">Regresar</a>
				<?php } ?>
			</div>
		</div>
	</section>
	<?php include('parts/footer.php');?>
	
</body>
</html>