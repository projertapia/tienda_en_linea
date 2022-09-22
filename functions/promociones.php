<?php
//session_start();
	
	function promos($tipo, $cantidad, $lugar){
		$promoconect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
		$hoypromo = date("Y-m-d H:i:s");
		$lugar_sql = "p.lugar_promocion = $lugar";
		
		$showpromoscounter="";
		$sqlpromosq ="SELECT p.id_promocion, p.tienda_rel_promocion, p.fecha_inicio_promocion, p.fecha_fin_promocion, p.img_promocion, p.url_promocion, p.tipo_promocion, p.activo_promocion, t.id_tienda, t.nick_tienda, p.lugar_promocion FROM promociones p, tiendas t WHERE p.activo_promocion = 1 AND ((p.fecha_inicio_promocion <= '$hoypromo') AND (p.fecha_fin_promocion >= '$hoypromo')) AND t.id_tienda = p.tienda_rel_promocion AND p.tipo_promocion = '$tipo' AND $lugar_sql ORDER BY p.lugar_promocion ASC LIMIT $cantidad"; //
		$reqpromosq=mysqli_query($promoconect, $sqlpromosq);
		$Mispromosq = $reqpromosq->num_rows;
		$add_counter = 0;
		if($Mispromosq!=0){
			while($resultpromosq = mysqli_fetch_object($reqpromosq)){
			$id_promocion = $resultpromosq->id_promocion;
			$tienda_rel_promocion = $resultpromosq->tienda_rel_promocion;
			$img_promocion = $resultpromosq->img_promocion;
			$url_promocion = $resultpromosq->url_promocion;
			$nick_tienda= $resultpromosq->nick_tienda;
			$tipo_promocion = $resultpromosq->tipo_promocion;
			$showpromoscounter=$showpromoscounter.$id_promocion.',';
			$lugar_promocion = $resultpromosq-> lugar_promocion;
			if($tipo_promocion=="rq"){
				$class="col-md-6 col-sm-12 my-2";
				$add_counter = $add_counter+2;

			}else{
				$class="col-md-3 col-sm-6 col-12 my-2";
				$add_counter = $add_counter+1;
			}

			?>

			<a href="<?php echo $url_promocion?>" title="" class="<?php echo $class?>" target="_blank" onClick="promo(<?php echo $id_promocion?>)" data-post="<?php echo $lugar_promocion;?>"><img src="<?php echo SITEUSER.'img/tiendas/'.$nick_tienda.'/'.$img_promocion?>" alt="" class="img-fluid promos"></a>
			<?php
			}
		}else{
			if($tipo=='rq'){
				$class="col-md-6 col-sm-12 my-2";
				$img_show = "espacio-disponible_rectangular.jpg";
			}else{
				$class="col-md-3 col-sm-6 col-12 my-2";
				$img_show = "espacio-disponible_cuadrado.jpg";
			}
			?>
			<a href="#" onClick="mail(<?php echo $lugar?>)" title="Muestra tu promoción aquí." class="<?php echo $class?>" data-post="<?php echo $lugar?>" rel="noopener noreferrer"><img src="<?php echo SITEUSER.'img/'.$img_show?>" alt="" class="img-fluid promos"></a>
			<?php
		}
		
	}
?>