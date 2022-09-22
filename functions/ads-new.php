<?php
	function checklinkads($linkads,$host_server){
		if (strpos($linkads, $host_server) !== false) {
			return '_self';
		}else{
			return '_blank';
		}
	}
	function ads($tipo, $tienda,$tipopubli,$idref){
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
		if($tipo!="" AND $tienda == ""){
			$showtienda ="AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL' )";
		}
		if($tipo!="" AND $tienda !=""){
			$getcatstore="SELECT categorias_tienda FROM tiendas WHERE nick_tienda = '$tienda'";
			$reqcatstore=mysqli_query($adsconect, $getcatstore);
			while($resultcatstore = mysqli_fetch_object($reqcatstore)){
				$categorias_tienda = $resultcatstore->categorias_tienda;
				$categorias_tienda = trim($categorias_tienda, ',');
				$array = explode(",", $categorias_tienda);
				
			}
			//$array = array($categorias_tienda);
			$longitud = count($array);
			$query="";
			for($i=0; $i<$longitud; $i++){
				$query .= 'show_categorias_publicidad LIKE "%'.$array[$i].',%"';
				if($i<($longitud-1)){
					$query .= " OR ";
				}
			}
			
			$query;
			$sql_showtienda ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, tipo_publicidad, show_tienda_publicidad, show_categorias_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) AND (show_tienda_publicidad = '$tienda' OR $query) order by RAND() LIMIT 1";
			$req_showtienda=mysqli_query($adsconect, $sql_showtienda);
			$row_showtienda = $req_showtienda->num_rows;
			if($row_showtienda != 0){
				while($resulshow = mysqli_fetch_object($req_showtienda)){
					$show_tienda_publicidad = $resulshow->show_tienda_publicidad;
					$show_categorias_publicidad = $resulshow->show_categorias_publicidad;
				}
				if(empty($show_tienda_publicidad)){
					$showtienda ="AND ($query OR (show_categorias_publicidad = 'NULL' OR show_categorias_publicidad IS NULL OR show_categorias_publicidad ='')) ";
				}else{
					$showtienda ="AND show_tienda_publicidad = '$tienda'";
				}
			}else{
				$showtienda="AND (show_tienda_publicidad IS NULL OR show_tienda_publicidad = 'NULL' OR show_tienda_publicidad = '') AND (show_categorias_publicidad IS NULL OR show_categorias_publicidad = 'NULL' OR show_categorias_publicidad = '')";				
			}
		}
			switch ($tipo){
				case 'sq':
					if($tipopubli=="campaña"){
						$limitcamp="AND id_publicidad = '$idref'";
					}else{
						$limitcamp = "AND tipo_publicidad != 'campaña'";
					};
					$sqla ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_a_publicidad, link_sqa_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) $showtienda AND (img_sq_a_publicidad <> '' AND img_sq_a_publicidad IS NOT NULL) $limitcamp order by RAND() LIMIT 1";
					$req_sq_a=mysqli_query($adsconect, $sqla);
					$row_sq_a = $req_sq_a->num_rows;
					
					$sqlb ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_b_publicidad, show_tienda_publicidad, link_sqb_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) $showtienda AND (img_sq_b_publicidad <> '' AND img_sq_b_publicidad IS NOT NULL) $limitcamp order by RAND() LIMIT 1";
					$req_sq_b=mysqli_query($adsconect, $sqlb);
					$row_sq_b = $req_sq_b->num_rows;
					
					$sqlc ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_c_publicidad, link_sqc_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) $showtienda AND (img_sq_c_publicidad <> '' AND img_sq_c_publicidad IS NOT NULL) $limitcamp order by RAND() LIMIT 1";
					$req_sq_c=mysqli_query($adsconect, $sqlc);
					$row_sq_c = $req_sq_c->num_rows;
					
					$sqld ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_sq_d_publicidad, show_tienda_publicidad, link_sqd_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) $showtienda AND (img_sq_d_publicidad <> '' AND img_sq_d_publicidad IS NOT NULL) $limitcamp order by RAND() LIMIT 1";
					$req_sq_d=mysqli_query($adsconect, $sqld);
					$row_sq_d = $req_sq_d->num_rows;
					$row_cnt=4;
				break;
				case 'rq':
					if($tipopubli=="campaña"){
						$limitcamp="AND id_publicidad = '$idref'";
					}else{
						$limitcamp = "AND tipo_publicidad != 'campaña'";
					};
					$sqle ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_rq_a_publicidad, link_rqa_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) $showtienda AND (img_rq_a_publicidad <> '' AND img_rq_a_publicidad IS NOT NULL) $limitcamp order by RAND() LIMIT 1";
					$req_rq_a=mysqli_query($adsconect, $sqle);
					$row_rq_a = $req_rq_a->num_rows;
					$sqlf ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_rq_b_publicidad, show_tienda_publicidad, link_rqb_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) $showtienda AND (img_rq_b_publicidad <> '' AND img_rq_b_publicidad IS NOT NULL) $limitcamp order by RAND() LIMIT 1";
					$req_rq_b=mysqli_query($adsconect, $sqlf);
					$row_rq_b = $req_rq_b->num_rows;
					$row_cnt = 2;
				break;
				case 'hb':					
					$sql ="SELECT id_publicidad, fecha_inicio_publicidad, fecha_fin_publicidad, activo_publicidad, img_top_publicidad, show_tienda_publicidad, link_hb_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND ((fecha_inicio_publicidad <= '$hoy') AND (fecha_fin_publicidad >= '$hoy' )) $showtienda AND (img_top_publicidad <> '' AND img_top_publicidad IS NOT NULL) order by RAND() LIMIT 1";
					$req=mysqli_query($adsconect, $sql);
					$row_cnt = $req->num_rows;
				break;
			}
		
		
		if($row_cnt!=0){
			$sqldefault ="SELECT id_publicidad, img_top_publicidad, img_sq_a_publicidad, img_sq_b_publicidad, img_sq_c_publicidad, img_sq_d_publicidad, img_rq_a_publicidad, img_rq_b_publicidad, link_hb_producto, link_sqa_producto, link_sqb_producto, link_sqc_producto, link_sqd_producto, link_rqa_producto, link_rqb_producto, tipo_publicidad FROM publicidad WHERE activo_publicidad = 1 AND id_publicidad = 1";
			$req_default=mysqli_query($adsconect, $sqldefault);
			while($result_default = mysqli_fetch_object($req_default)){
				$id_publicidad_default = $result_default->id_publicidad;
				$tipo_publicidad_default = $result_default->tipo_publicidad;
				
				$img_sq_a_default = $result_default->img_sq_a_publicidad;
				$link_sqa_default = $result_default->link_sqa_producto;
				$img_sq_b_default = $result_default->img_sq_b_publicidad;
				$link_sqb_default = $result_default->link_sqb_producto;
				$img_sq_c_default = $result_default->img_sq_c_publicidad;
				$link_sqc_default = $result_default->link_sqc_producto;
				$img_sq_d_default = $result_default->img_sq_d_publicidad;
				$link_sqd_default = $result_default->link_sqd_producto;
				
				$img_rq_a_default = $result_default->img_rq_a_publicidad;
				$link_rqa_default = $result_default->link_rqa_producto;
				$img_rq_b_default = $result_default->img_rq_b_publicidad;
				$link_rqb_default = $result_default->link_rqb_producto;
				
				$img_top_default = $result_default->img_top_publicidad;
				$link_top_default = $result_default->link_hb_producto;
			}
			switch ($tipo){
					case 'sq':
						while($result_sq_a = mysqli_fetch_object($req_sq_a)){
							$id_publicidad_sq_a = $result_sq_a->id_publicidad;
							$img_sq_a_publicidad = $result_sq_a->img_sq_a_publicidad;
							$link_sqa_producto = $result_sq_a->link_sqa_producto;
							$tipo_publicidad = $result_sq_a->tipo_publicidad;
						}
						if($row_sq_a == 0){
							$id_publicidad_sq_a = $id_publicidad_default;
							$img_sq_a_publicidad = $img_sq_a_default;
							$link_sqa_producto = $link_sqa_default;
							$tipo_publicidad = $tipo_publicidad_default;
						}
						while($result_sq_b = mysqli_fetch_object($req_sq_b)){
							$id_publicidad_sq_b = $result_sq_b->id_publicidad;
							$img_sq_b_publicidad = $result_sq_b->img_sq_b_publicidad;
							$link_sqb_producto = $result_sq_b->link_sqb_producto;
							$tipo_publicidad_sq_b = $result_sq_b->tipo_publicidad;
						}
						while($result_sq_c = mysqli_fetch_object($req_sq_c)){
							$id_publicidad_sq_c = $result_sq_c->id_publicidad;
							$img_sq_c_publicidad = $result_sq_c->img_sq_c_publicidad;
							$link_sqc_producto = $result_sq_c->link_sqc_producto;
							$tipo_publicidad_sq_c = $result_sq_c->tipo_publicidad;
						}
						while($result_sq_d = mysqli_fetch_object($req_sq_d)){
							$id_publicidad_sq_d = $result_sq_d->id_publicidad;
							$img_sq_d_publicidad = $result_sq_d->img_sq_d_publicidad;
							$link_sqd_producto = $result_sq_d->link_sqd_producto;
							$tipo_publicidad_sq_d = $result_sq_d->tipo_publicidad;
						}
						return array($id_publicidad_sq_a, $img_sq_a_publicidad, $link_sqa_producto,$tipo_publicidad,$host_server,$id_publicidad_sq_b, $img_sq_b_publicidad, $link_sqb_producto,$id_publicidad_sq_c, $img_sq_c_publicidad, $link_sqc_producto,$id_publicidad_sq_d, $img_sq_d_publicidad, $link_sqd_producto);
						
					break;
					case 'rq':
						while($result_rq_a = mysqli_fetch_object($req_rq_a)){
							$id_publicidad_rq_a = $result_rq_a->id_publicidad;
							$img_rq_a_publicidad = $result_rq_a->img_rq_a_publicidad;
							$link_rqa_producto = $result_rq_a->link_rqa_producto;
							$tipo_publicidad_rq_a = $result_rq_a->tipo_publicidad;
						}
						while($result_rq_b = mysqli_fetch_object($req_rq_b)){
							$id_publicidad_rq_b = $result_rq_b->id_publicidad;
							$img_rq_b_publicidad = $result_rq_b->img_rq_b_publicidad;
							$link_rqb_producto = $result_rq_b->link_rqb_producto;
							$tipo_publicidad_rq_b = $result_rq_b->tipo_publicidad;
						}
						if($row_rq_a == 0){
							$id_publicidad_rq_a = $id_publicidad_default;
							$img_rq_a_publicidad = $img_rq_a_default;
							$tipo_publicidad_rq_a= $tipo_publicidad_default;
							$link_rqa_producto=$link_rqa_default;
						}
						if($row_rq_b == 0){
							$id_publicidad_rq_b = $id_publicidad_default;
							$img_rq_b_publicidad = $img_rq_b_default;
							$tipo_publicidad_rq_b= $tipo_publicidad_default;
							$link_rqb_producto=$link_rqa_default;
						}
						return array($id_publicidad_rq_a, $img_rq_a_publicidad, $link_rqa_producto,$tipo_publicidad_rq_a,$host_server,$id_publicidad_rq_b, $img_rq_b_publicidad, $link_rqb_producto);
						
					break;
					case 'hb':
						while($result = mysqli_fetch_object($req)){
							$id_publicidad = $result->id_publicidad;
							$img_top_publicidad = $result->img_top_publicidad;
							$link_hb_producto = $result->link_hb_producto;
							$tipo_publicidad = $result->tipo_publicidad;
						}
						return array($id_publicidad, $img_top_publicidad, $link_hb_producto,$tipo_publicidad,$host_server);
					break;
			}
		}
		
	}

?>

