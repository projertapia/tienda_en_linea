<?php
class comisiones{
    public $porc_com;
    public $nombre_com;
}
function comision($id_tienda,$fecha){
	$comi_conex = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
	$SQLPercentReport="SELECT s.id_tienda_suscripcion, s.tipo_suscripcion, s.porcentaje_suscripcion_tiendas, s.cantidad_suscripcion_tiendas, s.inicio_suscripcion, s.fin_suscripcion, t.id_tipo_tienda, t.nombre_tipo_tienda FROM suscripcion_tiendas s, tipos_tienda t WHERE s.id_tienda_suscripcion = $id_tienda AND (s.inicio_suscripcion <= '$fecha' AND s.fin_suscripcion >= '$fecha') AND t.id_tipo_tienda  = s.tipo_suscripcion";
	$reqPercentReport=mysqli_query($comi_conex, $SQLPercentReport);
	if($reqPercentReport->num_rows !=0){
		while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
			$porcentaje = $resulPercentReport->porcentaje_suscripcion_tiendas;
			$nombre_tipo = $resulPercentReport->nombre_tipo_tienda;
		}
	}else{
		$SQLPercentReport="SELECT * FROM tipos_tienda WHERE id_tipo_tienda = 1";
		$reqPercentReport=mysqli_query($comi_conex, $SQLPercentReport);
		while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
			$porcentaje = $resulPercentReport->porcentaje_tienda;
			$nombre_tipo = $resulPercentReport->nombre_tipo_tienda;
		}
	}
	$out = new comisiones();
	$out->porc_com = $porcentaje;
	$out->nombre_com = $nombre_tipo;
	return $out;
}
?>