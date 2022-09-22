<?php
	session_start();
	require('connect/conect_usrer.php');
	require('../functions/resize-class.php');
	include('functions/mailconfirm.php');
	if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{$http="http://";};
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
	$aviso;
	$last = explode("/", $server, 5);
	$urlparts = $http.$last[2].'/'.$last[3].'/';
	if(isset($_POST['idtienda']) AND $_POST['idtienda'] != ""){
		$escaparate = $_POST['escaparate'];
		$email_tienda = $_POST['email_tienda'];
		$idtienda = $_POST['idtienda'];
		$rsocial = $_POST['rsocial'];
		$df_tipo = $_POST['tipo'];
		$df_domicilio = $_POST['df_domicilio'];
		$df_estado = $_POST['df_estado'];
		$df_cp = $_POST['df_cp'];
		$df_rfc = $_POST['rfc'];
		$df_numero = $_POST['df_numero'];
		$df_facturacion = $_POST['df_facturacion'];
		
		
		$paso3 = "UPDATE tiendas SET df_nombre='$rsocial', df_tipo='$df_tipo', df_rfc='$df_rfc', df_numero='$df_numero', df_facturacion = '$df_facturacion', df_domicilio ='$df_domicilio', df_estado = '$df_estado', df_cp='$df_cp', activa_tienda =1 WHERE id_tienda ='$idtienda'";
			if ($conex->query($paso3) === TRUE) {
				$infook=true;
				$new="segundomail";
				sendMailCliente($idtienda,$escaparate,$email_tienda,$new);
			} else {
				$infook=false;
				$aviso="Lo sentimos no es posible guardar los datos de tienda.";
			}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Configura tu cuenta| Ecommerce</title>
<?php include("parts/header.php");?>
<link rel="stylesheet" href="<?php echo $server?>css/escaparatecss.css">
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
					<h1 class="text-success" style="display: block; width: 100%">Felicidades tu escaparate <strong><?php echo $escaparate?></strong> esta listo para comenzar a vender.</h1>
					<div class="clearfix"></div>
					<a href="<?php echo SITE.'mi-escaparate/entrar'?>" title="Entrar" class="btn btn-success my-3">Iniciar sesión</a>
				<?php }else{?>
				<h1 class="text-danger"><?php echo $aviso?></h1>
				<a href="../nuevo/paso2?escaparate=<?php echo $escaparate.'&id='.$idtienda?>">Regresar</a>
				<?php }?>
			</div>
		</div>
	</section>
	<?php include('parts/footer.php');?>
</body>
</html>