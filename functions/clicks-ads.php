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
	
		if(isset($_GET['idpublicidad']) AND $_GET['idpublicidad'] != ""){
			$idpublicidad = $_GET["idpublicidad"];
			$tipopublicidad = $_GET["tipopublicidad"];
			switch ($tipopublicidad){
				case 'hb':
					$clickimage = 'click_hb_producto';
				break;
				case 'sq1':
					$clickimage = 'click_sqa_producto';
				break;
				case 'sq2':
					$clickimage = 'click_sqb_producto';
				break;
				case 'sq3':
					$clickimage = 'click_sqc_producto';
				break;
				case 'sq4':
					$clickimage = 'click_sqd_producto';
				break;
				case 'rq1':
					$clickimage = 'click_rqa_producto';
				break;
				case 'rq2':
					$clickimage = 'click_rqb_producto';
				break;
				default:
					die();
			}
			$queryupdate= "UPDATE publicidad SET $clickimage = $clickimage + 1 WHERE id_publicidad = $idpublicidad";
			if ($conex->query($queryupdate) === TRUE) {
				echo "OK";
			}else{
				echo "no";
			}
		}
	}
?>