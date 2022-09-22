<?php
 session_start();
	require('../connect/conect_usrer.php');
 	include('mailventa-tienda.php');
	include('mailcompra-cliente.php');
	$userID=2;
	$Carrito = 20200902006;
	$idTienda = 2;
	sendMailCliente($userID,$Carrito,$idTienda);
	sendMailTienda($userID,$Carrito,$idTienda);
?>