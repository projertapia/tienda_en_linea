<?php
	session_start();
	require('../connect/conect_usrer.php');
	include('safeimg.php');
	require('../../functions/resize-class.php');
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
			$logo_tienda = $_FILES["logo_tienda"]["name"];
			$cover_tienda = $_FILES["cover_tienda"]["name"];
			$allowed_file_types = array('.jpeg','.jpg','.png');	
			$aviso="";
			//FILE PROFILE
			$filename = $_FILES["logo_tienda"]["name"];
			$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
			$file_ext = substr($filename, strripos($filename, '.')); // get file name
			$filesize = $_FILES["logo_tienda"]["size"];
			if (in_array($file_ext,$allowed_file_types) && ($filesize < 20097152)){
				// Rename file
				$newprofileimg ="logo_tienda".md5(date("dmYHis")). $file_ext;
				if (file_exists("../img/tiendas/$nick_tienda/$newprofileimg"))
				{
					// file already exists error
					$aviso = "Ya has subido este archivo.";
					$oklogo=2;
				}
				else
				{		
					move_uploaded_file($_FILES["logo_tienda"]["tmp_name"], "../../img/tiendas/$nick_tienda/$newprofileimg");
					// *** 1) Initialise / load image
					$resizeObj = new resize("../../img/tiendas/$nick_tienda/$newprofileimg");
					 // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
					$resizeObj -> resizeImage(1280, 749, 'crop');
					if($file_ext=='.png'){
						$resizeObj -> saveImage("../../img/tiendas/$nick_tienda/$newprofileimg",null, 1000);
					}else{
					$resizeObj -> saveImage("../../img/tiendas/$nick_tienda/$newprofileimg", 1000);
					}
					$aviso ."- Logotipo cargado con éxito.";
					$oklogo=1;
				}
			}elseif (empty($file_basename)){	
				// file selection error
				$aviso = "Seleccione un archivo para cargar.";
				$oklogo=2;
			}elseif ($filesize > 20097152){	
				// file size error
				$aviso = "El archivo que está intentando cargar es demasiado grande. intenta con un archivo de 1 mb";
				$oklogo=2;
			}else{
				// file type error
				$aviso = "Solo se permite la carga de estos tipos de archivos: " . implode(', ',$allowed_file_types);
				unlink($_FILES["logo_tienda"]["tmp_name"]);
				$oklogo=2;
			}
			if ($filesize!=0){
				$profileQuery=", logo_tienda ='$newprofileimg'";
			}else{$profileQuery="";}
			//FILE PROFILE
			//FILE PORTADA
			$portadaname = $_FILES["cover_tienda"]["name"];
			$portada_basename = substr($portadaname, 0, strripos($portadaname, '.')); // get file extention
			$portada_ext = substr($portadaname, strripos($portadaname, '.')); // get file name
			$portada_size = $_FILES["cover_tienda"]["size"];
			if (in_array($portada_ext,$allowed_file_types) && ($portada_size < 20097152)){	
				// Rename file
				$newportadaimg ="cover_tienda".md5(date("dmYHis")). $portada_ext;
				if (file_exists("../../img/tiendas/$nick_tienda/$newportadaimg"))
				{
					// file already exists error
					$aviso = "Ya has subido este archivo.";
					$okportada=2;
				}
				else
				{		
					move_uploaded_file($_FILES["cover_tienda"]["tmp_name"], "../../img/tiendas/$nick_tienda/$newportadaimg");
					// *** 1) Initialise / load image
					$resizeportada = new resize("../../img/tiendas/$nick_tienda/$newportadaimg");
					 // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
					$resizeportada -> resizeImage(1920, 880, 'crop');
					if($portada_ext=='.png'){
						$resizeportada -> saveImage("../../img/tiendas/$nick_tienda/$newportadaimg",null, 1000);
					}else{
					$resizeportada -> saveImage("../../img/tiendas/$nick_tienda/$newportadaimg", 1000);
					}
					$aviso .="- Portada cargada con éxito.";
					$okportada=1;
				}
			}elseif (empty($portada_basename)){	
				// file selection error
				$aviso = "Seleccione un archivo para cargar.";
				$okportada=2;
			}elseif ($portada_size > 20097152){	
				// file size error
				$aviso = "El archivo que está intentando cargar es demasiado grande. intenta con un archivo de 2 mb";
				$okportada=2;
			}else{
				// file type error
				$aviso = "Solo se permite la carga de estos tipos de archivos: " . implode(', ',$allowed_file_types);
				unlink($_FILES["cover_tienda"]["tmp_name"]);
				$okportada=2;
			}
		//FILE PORTADA
		
		if ($portada_size!=0){
				$coverQuery=", cover_tienda ='$newportadaimg'";
			}else{$coverQuery="";}
			
		//guardar DATOS
			$deldefault="UPDATE tiendas SET video_tienda = '$video_tienda', color_tienda = '$color_tienda' $profileQuery $coverQuery WHERE id_tienda = $idtienda";
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