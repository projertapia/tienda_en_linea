<?php
//1. Import the PayPal SDK client
namespace Sample;

require __DIR__ . '/vendor/autoload.php';
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

require 'paypal-client.php';

$orderID = $_GET['orderID'];
if(!isset($_GET['orderID'])){
	header("Location:../");
};
class GetOrder
{

  // 2. Set up your server to receive a call from the client
  public static function getOrder($orderId)
  {
	$Carrito = $_GET['idcarrito'];
	$userID = $_GET['iduser'];
	$idDir = $_GET['dir'];
    // 3. Call PayPal to get the transaction details
    $client = PayPalClient::client();
    $response = $client->execute(new OrdersGetRequest($orderId));
	
	// 4. Specify which information you want from the transaction details. For example:
	$orderID = $response->result->id;
	$email = $response->result->payer->email_address;
	$name = $response->result->purchase_units[0]->shipping->name->full_name;
	$status = $response->result->status;
	$transaccionID = $response->result->purchase_units[0]->payments->captures[0]->id;
	$cantidadPago = $response->result->purchase_units[0]->payments->captures[0]->amount->value;
	$fechaPago = $response->result->purchase_units[0]->payments->captures[0]->create_time;
	$fechaPag = date('Y-m-d H:i:s', strtotime($fechaPago));
	  /*purchase_units__payments__captures__create_time*/
	$dir1 = $response->result->purchase_units[0]->shipping->address->address_line_1." ";
	$dir1.= $response->result->purchase_units[0]->shipping->address->address_line_2." ";
	$dir1.= $response->result->purchase_units[0]->shipping->address->admin_area_1." ";
	$dir1.= $response->result->purchase_units[0]->shipping->address->postal_code." ";
	$dir1.= $response->result->purchase_units[0]->shipping->address->country_code;
	
	//$data=json_encode($response->result, JSON_PRETTY_PRINT);
	//header("Location:../success");
	  session_start();
	  require('../connect/conect_usrer.php');
	  include('mailventa-tienda.php');
	  include('mailcompra-cliente.php');
	//SAVE DATA SQL:
	$save_pay="INSERT INTO pagos_tienda
	(iduser_pagos_tienda, clave_pedido_pago_tienda, fecha_pago_tienda, orderID_paypal, email_paypal, name_paypal, status_paypal, transaccionID_paypal, cantidadPago_paypal, fechaPago_paypal, direccion_paypal)
	VALUES
	('$userID','$Carrito', '$fechaPag','$orderID','$email','$name','$status','$transaccionID', '$cantidadPago', '$fechaPag', '$dir1')";
	if ($conex->query($save_pay) === TRUE) {
		echo $conex->error;
		$aviso="1";
		$updatecarrito="UPDATE carrito SET status_carrito = 1, paypal_name= '$name', paypal_orderID = '$orderID', fecha_compra_carrito = '$fechaPag', id_direccion = '$idDir' WHERE clave_carrito  = $Carrito AND id_user_carrito = $userID";
		$conex->query($updatecarrito);
		echo $conex->error;
		//ADD 1 COMPRA
		$updateCompra="UPDATE clientes SET compras_cliente = compras_cliente+ 1 WHERE id_cliente = $userID";
		$conex->query($updateCompra);
		echo $conex->error;
		//REST 1 COMPRA
		$selectprod="SELECT clave_carrito, id_producto_carrito,cantidad_producto_carrito,id_vendedor_carrito FROM carrito WHERE clave_carrito = $Carrito";
		$reqprod=mysqli_query($conex, $selectprod);
		while($Rprod = mysqli_fetch_object($reqprod)){
			$id_producto_carrito = $Rprod->id_producto_carrito;
			$cantidad_producto_carrito = $Rprod->cantidad_producto_carrito;
			$Tienda = $Rprod->id_vendedor_carrito;
			$updateCompra="UPDATE productos SET stock_producto = stock_producto- $cantidad_producto_carrito WHERE id_producto = $id_producto_carrito";
			$conex->query($updateCompra);
			echo $conex->error;
		}
		//SEND CLIENTE
		sendMailCliente($userID,$Carrito,$Tienda);
		$senderMail="SELECT DISTINCT clave_carrito, id_user_carrito, id_vendedor_carrito FROM carrito WHERE clave_carrito = $Carrito AND id_user_carrito = $userID AND status_carrito = 1";
		$reqMail=mysqli_query($conex, $senderMail);
		while($RMail = mysqli_fetch_object($reqMail)){
			$idTienda = $RMail->id_vendedor_carrito;
			sendMailTienda($userID,$Carrito,$idTienda);
		}
	} else {
		$aviso="2";
	}
	  header("Location:../confirmacion-pago?idorder=$Carrito&action=$aviso");
  }
}

if (!count(debug_backtrace()))
{
  GetOrder::getOrder($orderID, true);
}
?>