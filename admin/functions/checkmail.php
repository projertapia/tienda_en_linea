<?php
	session_start();
	require('../connect/conect_usrer.php');
	$conex->query("SET lc_time_names = 'es_ES';");
	if(isset($_GET['nma']) AND $_GET['nma']!=""){
		$nes =$_GET['nma'];
		$sqlNMA ="SELECT email_admin FROM admin WHERE email_admin = '$nes'";
		$reqNMA=mysqli_query($conex, $sqlNMA);
		echo $reqNMA->num_rows;
	};
	mysqli_close($conex); 
?>