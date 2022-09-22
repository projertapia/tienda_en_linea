<?php
	session_start();
	if (isset($_SERVER['HTTPS'])) {
		$http="https://";}else{
		$http="http://";
	}
	$_SERVER['HTTP_HOST'];
	dirname($_SERVER['PHP_SELF']);
	$server=$http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
	session_destroy();
	header("location:".$server);
?>