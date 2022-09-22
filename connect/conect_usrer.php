<?php //header("Access-Control-Allow-Origin: *");
 // datos para la conexion a mysql
define('DB_SERVER','localhost');
define('DB_NAME','db_name');
define('DB_USER','db_user');
define('DB_PASS','*PASS*');

$conex = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
mysqli_set_charset($conex,"utf8");
$conex->query("SET lc_time_names = 'es_MX'");

//URL
/*
if (isset($_SERVER['HTTPS'])) {
	$http="https://";}else{
	$http="http://";
}
*/
//$_SERVER['HTTP_HOST'];
//dirname($_SERVER['PHP_SELF']);
//$urlserver=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
//$last = explode("/", $urlserver, 5);
//$urlserver = $http.$last[2].'/'.$last[3].'/';
#$last = explode("/", $urlserver, 2);
#$urlserver = $http.$last[1].'/'.$last[2].'/';
#$urlserver= $http.$_SERVER["HTTP_HOST"].'/';
$sqlSite="SELECT *	FROM options_site";
	$reqSite=mysqli_query($conex, $sqlSite);
	while($resulSite = mysqli_fetch_object($reqSite)){
		$http_site = $resulSite->http_site;
		$url_site = $resulSite->url_site;
	}
$urlserver = $http_site.$url_site.'/';
define('SITEUSER',$urlserver);

//BANNERS
$sqlBanner_hb="SELECT id_banner, img_banner, url_banner, target_banner FROM site_banner WHERE id_banner = 1";
$reqBanner_hb=mysqli_query($conex, $sqlBanner_hb);
while($resulBanner_hb = mysqli_fetch_object($reqBanner_hb)){
	$img_hb = $resulBanner_hb->img_banner;
	$url_hb = $resulBanner_hb->url_banner;
	$target_hb = $resulBanner_hb->target_banner;
	if($target_hb==1){
		$target_hb="_self";
	}
	if($target_hb==2){
		$target_hb="_blank";
	}
}
$sqlBanner_ft="SELECT id_banner, img_banner, url_banner, target_banner FROM site_banner WHERE id_banner = 2";
$reqBanner_ft=mysqli_query($conex, $sqlBanner_ft);
while($resulBanner_ft = mysqli_fetch_object($reqBanner_ft)){
	$img_ft = $resulBanner_ft->img_banner;
	$url_ft = $resulBanner_ft->url_banner;
	$target_ft = $resulBanner_ft->target_banner;
	if($target_ft==1){
		$target_ft="_self";
	}
	if($target_ft==2){
		$target_ft="_blank";
	}
}
$sqlBanner_hbint="SELECT id_banner, img_banner, url_banner, target_banner FROM site_banner WHERE id_banner = 3";
$reqBanner_hbint=mysqli_query($conex, $sqlBanner_hbint);
while($resulBanner_hbint = mysqli_fetch_object($reqBanner_hbint)){
	$img_hbint = $resulBanner_hbint->img_banner;
	$url_hbint = $resulBanner_hbint->url_banner;
	$target_hbint = $resulBanner_hbint->target_banner;
	if($target_hbint==1){
		$target_hbint="_self";
	}
	if($target_hbint==2){
		$target_hbint="_blank";
	}
}
?>