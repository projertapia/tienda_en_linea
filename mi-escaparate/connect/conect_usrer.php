<?php
if(!isset($_SESSION)){ 
	session_start();
}
 // datos para la conexion a mysql
define('DB_SERVER','localhost');
define('DB_NAME','db_name');
define('DB_USER','db_user');
define('DB_PASS','*PASS*');
$conexlite = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
$conex = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
//define('CONEX',$conex);
mysqli_set_charset($conex,"utf8");
$conex -> set_charset("utf8");
$conex->query("SET lc_time_names = 'es_ES'");
global $conex;
//URL
if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
}
$_SERVER['HTTP_HOST'];
dirname($_SERVER['PHP_SELF']);
#$urlserver=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
#$last = explode("/", $urlserver, 5);
#$urlserver = $http.$last[2].'/'.$last[3].'/';
	$sqlSite="SELECT * FROM options_site";
	$reqSite=mysqli_query($conexlite, $sqlSite);
	while($resulSite = mysqli_fetch_object($reqSite)){
		$http_site = $resulSite->http_site;
		$url_site = $resulSite->url_site;
	}
$urlserver = $http_site.$url_site.'/';
define('SITE',$urlserver);
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_MX.UTF-8');
setlocale(LC_TIME, 'spanish');


if(isset($_SESSION['tiendauser']) AND $_SESSION['tiendauser'] !=""){
	$checkinicio="";
	$checkfin="";
	$datetime_now=date('Y-m-d G:i:s');
	$mailsession = $_SESSION['tiendauser'];
	$sqlmail="SELECT t.id_tienda, t.nick_tienda, t.email_tienda, t.email_contacto_tienda, t.categoria_tienda, t.activa_tienda, t.nivel_de_tienda
	FROM tiendas t
	WHERE t.email_tienda ='$mailsession' AND t.activa_tienda != 0";
	$reqmail=mysqli_query($conexlite, $sqlmail);
	$mymail_rows = mysqli_num_rows($reqmail); 
	
	while($resulmail = mysqli_fetch_object($reqmail)){		
		$id_tienda = $resulmail->id_tienda;
		$nick_tienda = $resulmail->nick_tienda;
		$categoria_tienda = $resulmail->categoria_tienda;
		$email_contacto_tienda = $resulmail->email_contacto_tienda;
		$nivel_de_tienda = $resulmail->nivel_de_tienda;
		define('NICKTIENDA',$nick_tienda);
		define('CATTIENDA',$categoria_tienda);
		define('IDTIENDA',$id_tienda);
		define('MAILCONTACTTIENDA',$email_contacto_tienda);
	};
	//get plan
	$SQLPlan="SELECT t.id_tienda, t.nivel_de_tienda, s.id_suscripcion, s.id_tienda_suscripcion, s.tipo_suscripcion, s.porcentaje_suscripcion_tiendas, s.cantidad_suscripcion_tiendas, s.cantidad_promos_tiendas, s.inicio_suscripcion, s.fin_suscripcion, z.id_tipo_tienda, z.nombre_tipo_tienda, z.cantidad_promos_tipo_tienda FROM tiendas t, suscripcion_tiendas s, tipos_tienda z WHERE t.nivel_de_tienda = s.id_suscripcion AND z.id_tipo_tienda = s.tipo_suscripcion AND t.id_tienda = $id_tienda AND s.id_tienda_suscripcion = $id_tienda";
	$reqPlan=mysqli_query($conexlite, $SQLPlan);
	$myplan_rows = mysqli_num_rows($reqPlan); 
	while($resulPlan = mysqli_fetch_object($reqPlan)){
		$id_tipo_tienda = $resulPlan->id_tipo_tienda;
		$cantidad_suscripcion_tiendas = $resulPlan->cantidad_suscripcion_tiendas;
		$checkinicio = $resulPlan->inicio_suscripcion;
		$checkfin = $resulPlan->fin_suscripcion;
		$nombre_tipo_tienda=$resulPlan->nombre_tipo_tienda;
		$cantidad_promos_tiendas=$resulPlan->cantidad_promos_tiendas;
		$porcentaje_suscripcion_tiendas =$resulPlan->porcentaje_suscripcion_tiendas;
	}
	$fecha_hoy=date('Y-m-d G:i:s');
	if($myplan_rows != 0 OR ($checkinicio <= $fecha_hoy AND $checkfin >= $fecha_hoy)){	
		
	}else{
		$SQLPercent="SELECT * FROM tipos_tienda WHERE id_tipo_tienda = 1";
		$reqPercent=mysqli_query($conexlite, $SQLPercent);
		while($resulPercent = mysqli_fetch_object($reqPercent)){
			$id_tipo_tienda = $resulPercent->id_tipo_tienda;
			$cantidad_suscripcion_tiendas = $resulPercent->cantidad_tipo_tienda;
			$nombre_tipo_tienda= $resulPercent->nombre_tipo_tienda;
			$porcentaje_suscripcion_tiendas = $resulPercent->porcentaje_tienda;
			$cantidad_promos_tiendas = $resulPercent->cantidad_promos_tipo_tienda;
		}
		$checkinicio="-";
		$checkfin ="-";
	}
		//TOTAL PRODUCTOS
		$SQLTotal="SELECT id_producto, activo_producto FROM productos WHERE id_tienda_producto = $id_tienda AND activo_producto = 1";
		$reqTotal=mysqli_query($conexlite, $SQLTotal);
		$TotalProd_rows = mysqli_num_rows($reqTotal);
		$prod_rows_sum = $TotalProd_rows;
		//TOTALPROMOS
		$SQLPromos="SELECT id_promocion, activo_promocion FROM promociones WHERE tienda_rel_promocion = $id_tienda AND activo_promocion = 1";
		$reqPromos=mysqli_query($conexlite, $SQLPromos);
		$TotalPromos_rows = mysqli_num_rows($reqPromos);
		$prom_rows_sum = $TotalPromos_rows;
	if($id_tipo_tienda==1){
		$TotalProd_rows=$prod_rows_sum+$prom_rows_sum;
		$TotalPromos_rows=$prod_rows_sum+$prom_rows_sum;
	}
	
};
?>