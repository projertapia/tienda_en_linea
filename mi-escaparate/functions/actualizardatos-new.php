<?php
	session_start();
	require('../connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if (!$conex) {
		die('No pudo conectarse: ');
	}else{
		date_default_timezone_set('America/Mexico_City');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		setlocale(LC_TIME, 'spanish');
		if(isset($_GET["action"]) AND $_GET["action"] == "1"){
			$idtienda=$_POST['idtienda'];
			$nombre_tienda=$_POST['nombre_tienda'];
			$email_tienda=$_POST['email_tienda'];
			$cumple_tienda=$_POST['cumple_tienda'];
			$desc_tienda=$_POST['desc_tienda'];
			$deldefault="UPDATE tiendas SET nombre_tienda = '$nombre_tienda', email_tienda = '$email_tienda', cumple_tienda = '$cumple_tienda', desc_tienda = '$desc_tienda' WHERE id_tienda = $idtienda";
			if ($conex->query($deldefault) === TRUE) {
				$affected= $conex->affected_rows;	//echo "ok-pass";
				if($affected==0){
					echo 'mailpass';
				}else{
					echo '1';
				}
				
			}else{
				echo "1";
			};
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "2"){
			$idtienda=$_POST['idtienda'];
			$video_tienda=$_POST['video_tienda'];
			$color=$_POST['color_tienda'];
			$color_tienda = str_replace ( "#", '', $color);			
			$aviso="";
		//guardar DATOS
			$deldefault="UPDATE tiendas SET video_tienda = '$video_tienda', color_tienda = '$color_tienda' WHERE id_tienda = $idtienda";
			if ($conex->query($deldefault) === TRUE) {
				echo 0;
			}else{
				echo 1;
			}
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "3"){
			$idtienda=$_POST['idtienda'];
			$fb_tienda=$_POST['fbtienda'];
			$insta_tienda=$_POST['instatienda'];
			$tw_tienda=$_POST['twtienda'];
			$yt_tienda=$_POST['yttienda'];
			$tik_tienda=$_POST['tiktienda'];
			$twitch_tienda=$_POST['twitchtienda'];
			$in_tienda=$_POST['intienda'];
			$web_tienda=$_POST['webtienda'];
			$wapp_tienda=$_POST['wapp_tienda'];
			$maps_tienda=$_POST['maps_tienda'];
			$deldefault="UPDATE tiendas SET fb_tienda = '$fb_tienda', insta_tienda = '$insta_tienda', tw_tienda = '$tw_tienda', yt_tienda = '$yt_tienda', tik_tienda = '$tik_tienda' , twitch_tienda = '$twitch_tienda', in_tienda = '$in_tienda', web_tienda = '$web_tienda', wapp_tienda = '$wapp_tienda', maps_tienda = '$maps_tienda' WHERE id_tienda = $idtienda";
			if ($conex->query($deldefault) === TRUE) {
				$affected= $conex->affected_rows;	//echo "ok-pass";
				if($affected==0){
					echo '0';
				}else{
					echo '1';
				}
				
			}else{
				echo "1";
			};
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "4"){
			$idtienda=$_POST['idtienda'];
			$df_nombre=$_POST['rsocial'];
			$df_tipo=$_POST['tipo'];
			$df_rfc=$_POST['rfc'];
			$df_domicilio=$_POST['df_domicilio'];
			$df_estado=$_POST['df_estado'];
			$df_cp=$_POST['df_cp'];
			$df_numero=$_POST['df_numero'];
			$df_facturacion=$_POST['df_facturacion'];
			$deldefault="UPDATE tiendas SET df_nombre = '$df_nombre', df_tipo = '$df_tipo', df_rfc = '$df_rfc', df_domicilio = '$df_domicilio', df_estado = '$df_estado' , df_cp = '$df_cp', df_numero = '$df_numero', df_facturacion = '$df_facturacion' WHERE id_tienda = $idtienda";
			if ($conex->query($deldefault) === TRUE) {
				$affected= $conex->affected_rows;	//echo "ok-pass";
				if($affected==0){
					echo '0';
				}else{
					echo '1';
				}
				
			}else{
				echo "1";
			};
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "5"){
			$idtienda=$_POST['idtienda'];
			$oldpassword=md5($_POST['oldpassword']);
			$nuevapassword=md5($_POST['nuevapassword']);
			$confpassword=md5($_POST['confpassword']);
			if($nuevapassword==$confpassword){
				$deldefault="UPDATE tiendas SET pass_tienda = '$nuevapassword' WHERE id_tienda = $idtienda AND pass_tienda = '$oldpassword'";
				if ($conex->query($deldefault) === TRUE) {
					$affected= $conex->affected_rows;	//echo "ok-pass";
					if($affected==0){
						echo 'passok';
					}
				}else{
					echo "3";
				};
			}else{
				echo "2";
			}
		};
		if(isset($_GET["action"]) AND $_GET["action"] == "6"){
			$idtienda=$_POST['idtienda'];
			$rowcat="";
			foreach($_POST['categorias'] as $categorias){
				$rowcat.=$categorias.",";
			}
			$deldefault="UPDATE tiendas SET categorias_tienda = '$rowcat' WHERE id_tienda = $idtienda";
			if ($conex->query($deldefault) === TRUE) {
				$affected= $conex->affected_rows;	//echo "ok-pass";
				if($affected==0){
					echo '0';
				}
			}else{
				echo "1";
			};
			
		};
	}
?>