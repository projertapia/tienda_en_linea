<?php
if(!isset($_SESSION)){ 
	session_start();
}
//header("Access-Control-Allow-Origin: *");
 // datos para la conexion a mysql
define('DB_SERVER','localhost');
define('DB_NAME','db_name');
define('DB_USER','db_user');
define('DB_PASS','*PASS*');

$conex = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
//define('CONEX',$conex);
mysqli_set_charset($conex,"utf8");
$conex->query("SET lc_time_names = 'es_ES'");
global $conex;
//URL
if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
}
$_SERVER['HTTP_HOST'];
dirname($_SERVER['PHP_SELF']);
$urlserver=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
$last = explode("/", $urlserver, 5);
//$urlserver = $http.$last[2].'/'.$last[3].'/';
//$urlserver= $http.$_SERVER["HTTP_HOST"].'/';
$sqlSite="SELECT *	FROM options_site";
	$reqSite=mysqli_query($conex, $sqlSite);
	while($resulSite = mysqli_fetch_object($reqSite)){
		$http_site = $resulSite->http_site;
		$url_site = $resulSite->url_site;
	}
$urlserver = $http_site.$url_site.'/';
define('SITE',$urlserver);

date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_MX.UTF-8');
setlocale(LC_TIME, 'spanish');

if(isset($_SESSION['adminuser']) AND $_SESSION['adminuser'] !=""){
	
	$datetime_now=date('Y-m-d G:i:s');
	$mailsession = $_SESSION['adminuser'];
	$sqlmail="SELECT id_admin, nombre_admin, email_admin, activa_admin, fecha_admin	FROM admin
	WHERE email_admin ='$mailsession' AND activa_admin = 1";
	$reqmail=mysqli_query($conex, $sqlmail);
	while($resulmail = mysqli_fetch_object($reqmail)){		
		$id_admin = $resulmail->id_admin;
		$nombre_admin = $resulmail->nombre_admin;
		$email_admin=$resulmail->email_admin;
		$fecha_admin = $resulmail->fecha_admin;
		define('USERADMIN',$nombre_admin);
		define('MAILADMIN',$mailsession);
	};	
};
?>