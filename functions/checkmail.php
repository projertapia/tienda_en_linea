<?php
session_start();
require('../connect/conect_usrer.php');
$conex->query("SET lc_time_names = 'es_ES';");
if(isset($_GET['nus']) AND $_GET['nus']!=""){
	$nus =$_GET['nus'];
	$sql ="SELECT email_cliente FROM clientes WHERE UPPER(email_cliente) = UPPER('$nus')";
	$req=mysqli_query($conex, $sql);
	echo $req->num_rows;
};
?>