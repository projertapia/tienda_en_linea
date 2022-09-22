<?php
	session_start();
	require('../connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if(isset($_GET['nes']) AND $_GET['nes']!=""){
		$nes =$_GET['nes'];
		$sql ="SELECT nick_tienda FROM tiendas WHERE UPPER(nick_tienda) = UPPER('$nes')";
		$req=mysqli_query($conex, $sql);
		echo $req->num_rows;
	};
	if(isset($_GET['nma']) AND $_GET['nma']!=""){
		$nes =$_GET['nma'];
		$sqlNMA ="SELECT email_tienda FROM tiendas WHERE email_tienda = '$nes'";
		$reqNMA=mysqli_query($conex, $sqlNMA);
		echo $reqNMA->num_rows;
	};
	mysqli_close($conex); 
?>