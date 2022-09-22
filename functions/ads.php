<?php
	function checklinkads($linkads,$host_server){
		if (strpos($linkads, $host_server) !== false) {
			return '_self';
		}else{
			return '_blank';
		}
	}
	function ads($tipo, $tienda){
		if (isset($_SERVER['HTTPS'])) {
		$httpads="https://";}else{
		$httpads="http://";
		}
		$_SERVER['HTTP_HOST'];
		$host_server=$_SERVER['HTTP_HOST'];
		dirname($_SERVER['PHP_SELF']);
		$urlserverads=$httpads.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
		
		$adsconect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
		$hoy = date("Y-m-d H:i:s"); 
		$sql="";
		if($tipo!="" AND $tienda !=""){
			switch ($tipo){
				case 'sq':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_a_publicidad,img_sq_b_publicidad,img_sq_c_publicidad,img_sq_d_publicidad, show_tienda_publicidad, link_sqa_producto, link_sqb_producto, link_sqc_producto, link_sqd_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) AND show_tienda_publicidad = '$tienda'LIMIT 1";
				break;
				case 'rq':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_rq_a_publicidad, img_rq_b_publicidad, show_tienda_publicidad, link_rqa_producto, link_rqb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND show_tienda_publicidad = '$tienda' LIMIT 1";
				break;
				case 'hb':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_top_publicidad, show_tienda_publicidad, link_hb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND show_tienda_publicidad = '$tienda' LIMIT 1";
				break;
			}
		}elseif($tipo!="" AND $tienda ==""){
			switch ($tipo){
				case 'sq':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_a_publicidad,img_sq_b_publicidad,img_sq_c_publicidad,img_sq_d_publicidad, show_tienda_publicidad, link_sqa_producto, link_sqb_producto, link_sqc_producto, link_sqd_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL' ) order by RAND() LIMIT 1";
				break;
				case 'rq':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_rq_a_publicidad, img_rq_b_publicidad, show_tienda_publicidad, link_rqa_producto, link_rqb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL' ) order by RAND() LIMIT 1";
				break;
				case 'hb':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_top_publicidad, show_tienda_publicidad, link_hb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL') order by RAND() LIMIT 1";
				break;
			}
		}
		$req=mysqli_query($adsconect, $sql);
		$row_cnt = $req->num_rows;
		if($row_cnt==0){
			$req="";
			$getcatstore="SELECT categorias_tienda FROM tiendas WHERE nick_tienda = '$tienda'";
			$reqcatstore=mysqli_query($adsconect, $getcatstore);
			$catsnum = $reqcatstore->num_rows;
			while($resultcatstore = mysqli_fetch_object($reqcatstore)){
				$categorias_tienda = $resultcatstore->categorias_tienda;
				$categorias_tienda = trim($categorias_tienda, ',');
			}			
			switch ($tipo){
				case 'sq':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_a_publicidad,img_sq_b_publicidad,img_sq_c_publicidad,img_sq_d_publicidad, show_tienda_publicidad, link_sqa_producto, link_sqb_producto, link_sqc_producto, link_sqd_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) AND show_categorias_publicidad IN ('$categorias_tienda') ORDER BY RAND() LIMIT 1";
				break;
				case 'rq':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_rq_a_publicidad, img_rq_b_publicidad, show_tienda_publicidad, link_rqa_producto, link_rqb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND show_categorias_publicidad IN ('$categorias_tienda') ORDER BY RAND() LIMIT 1";
				break;
				case 'hb':
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_top_publicidad, show_tienda_publicidad, link_hb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) AND show_categorias_publicidad IN ('$categorias_tienda') order by RAND() LIMIT 1";
				break;
			}
			$req=mysqli_query($adsconect, $sql);
			$row_cnt = $req->num_rows;
			if($row_cnt==0){
				$req="";
				switch ($tipo){
					case 'sq':
						$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_a_publicidad,img_sq_b_publicidad,img_sq_c_publicidad,img_sq_d_publicidad, show_tienda_publicidad, link_sqa_producto, link_sqb_producto, link_sqc_producto, link_sqd_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL' OR show_tienda_publicidad = '') ORDER BY RAND() LIMIT 1";
					break;
					case 'rq':
						$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_rq_a_publicidad, img_rq_b_publicidad, show_tienda_publicidad, link_rqa_producto, link_rqb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL' OR show_tienda_publicidad = '') AND (show_categorias_publicidad= 'NULL' OR show_categorias_publicidad IS NULL OR show_categorias_publicidad = '') ORDER BY RAND() LIMIT 1";
					break;
					case 'hb':
						$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_top_publicidad, show_tienda_publicidad, link_hb_producto FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' ))  AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL' OR show_tienda_publicidad = '') order by RAND() LIMIT 1";
					break;
				}
				$req=mysqli_query($adsconect, $sql);
				$row_cnt = $req->num_rows;
			}
		}else{
			
		}
		
		if($row_cnt!=0){
			switch ($tipo){
					case 'sq':
						while($result = mysqli_fetch_object($req)){
							$id_publicidad = $result->id_publicidad;
							$img_sq_a_publicidad = $result->img_sq_a_publicidad;
							$img_sq_b_publicidad = $result->img_sq_b_publicidad;
							$img_sq_c_publicidad = $result->img_sq_c_publicidad;
							$img_sq_d_publicidad = $result->img_sq_d_publicidad;
							$link_sqa_producto = $result->link_sqa_producto;
							$link_sqb_producto = $result->link_sqb_producto;
							$link_sqc_producto = $result->link_sqc_producto;
							$link_sqd_producto = $result->link_sqd_producto;
						}
							
							echo '<a href="'.$link_sqa_producto.'" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="'. checklinkads($link_sqa_producto,$host_server).'" onclick="adsclick('.$id_publicidad.',\'sq1\')"><img src="'.$urlserverads.'img/publicidad/'.$img_sq_a_publicidad.'" class="img-fluid" alt=""></a>';
							echo '<a href="'.$link_sqb_producto.'" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="'. checklinkads($link_sqb_producto,$host_server).'" onclick="adsclick('.$id_publicidad.',\'sq2\')"><img src="'.$urlserverads.'img/publicidad/'.$img_sq_b_publicidad.'" class="img-fluid" alt=""></a>';
							echo '<a href="'.$link_sqc_producto.'" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="'. checklinkads($link_sqc_producto,$host_server).'" onclick="adsclick('.$id_publicidad.',\'sq3\')"><img src="'.$urlserverads.'img/publicidad/'.$img_sq_c_publicidad.'" class="img-fluid" alt=""></a>';
							echo '<a href="'.$link_sqd_producto.'" class="box-promo-shop col-lg-12 col-md-3 col-sm-3 col-6" target="'. checklinkads($link_sqd_producto,$host_server).'" onclick="adsclick('.$id_publicidad.',\'sq4\')"><img src="'.$urlserverads.'img/publicidad/'.$img_sq_d_publicidad.'" class="img-fluid" alt=""></a>';
						
					break;
					case 'rq':
						while($result = mysqli_fetch_object($req)){
							$id_publicidad = $result->id_publicidad;
							$img_rq_a_publicidad = $result->img_rq_a_publicidad;
							$img_rq_b_publicidad = $result->img_rq_b_publicidad;
							$link_rqa_producto = $result->link_rqa_producto;
							$link_rqb_producto = $result->link_rqb_producto;
						}
							echo'<a href="'.$link_rqa_producto.'" class="box-promo-shop col-lg-12 col-md-6 col-sm-6 col-12" target="'. checklinkads($link_rqa_producto,$host_server).'" onclick="adsclick('.$id_publicidad.',\'rq1\')"><img src="'.$urlserverads.'img/publicidad/'.$img_rq_a_publicidad.'" class="img-fluid" alt=""></a>';
							echo'<a href="'.$link_rqb_producto.'" class="box-promo-shop col-lg-12 col-md-6 col-sm-6 col-12" target="'. checklinkads($link_rqb_producto,$host_server).'" onclick="adsclick('.$id_publicidad.',\'rq2\')"><img src="'.$urlserverads.'img/publicidad/'.$img_rq_b_publicidad.'" class="img-fluid" alt=""></a>';
						
					break;
					case 'hb':
						while($result = mysqli_fetch_object($req)){
							$id_publicidad = $result->id_publicidad;
							$img_top_publicidad = $result->img_top_publicidad;
							$link_hb_producto = $result->link_hb_producto;
						}
							echo'<a href="'.$link_hb_producto.'" target="'. checklinkads($link_hb_producto,$host_server).'" onclick="adsclick('.$id_publicidad.',\'hb\')"><img src="'.$urlserverads.'img/publicidad/'.$img_top_publicidad.'" alt="" class="img-fluid img-ads"></a>';
						
					break;
			}
		}
		
	}

?>

