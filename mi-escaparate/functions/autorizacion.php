<?php
//1. Import the PayPal SDK client
namespace Sample;

require __DIR__ . '/vendor/autoload.php';
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

require 'paypal-client.php';

$orderID = $_GET['orderID'];
if(!isset($_GET['orderID'])){
	header("Location:../mi-escaparate");
};
class GetOrder
{

  // 2. Set up your server to receive a call from the client
  public static function getOrder($orderId)
  {
	$Carrito = $_GET['idcarrito'];
	$plan = $_GET['plan'];
	$id_tienda_suscripcion = $_GET['id_tienda_suscripcion'];
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
	  //GETPLAN
	  $sqlPlanes="SELECT * FROM tipos_tienda WHERE activo_tipo_tienda = 1 AND id_tipo_tienda = $plan";
		$reqPlanes=mysqli_query($conexlite, $sqlPlanes);
		while($resulPlanes = mysqli_fetch_object($reqPlanes)){
			$id_tipo_tienda = $resulPlanes->id_tipo_tienda;
			$nombre_tipo_tienda = $resulPlanes->nombre_tipo_tienda;
			$cantidad_suscripcion_tiendas = $resulPlanes->cantidad_tipo_tienda;
			$cantidad_promos_tiendas = $resulPlanes->cantidad_promos_tipo_tienda;
			$porcentaje_tienda = $resulPlanes->porcentaje_tienda;
			$costo_tienda = ($resulPlanes->costo_tienda)*1.16;
			$duracion_tipo_tienda = "+ ".$resulPlanes->duracion_tipo_tienda." month";
		}
	  $inicio_suscripcion=$datetime_now;
	  
				
	  $fin_suscripcion= date("Y-m-d G:i:s",strtotime($datetime_now.$duracion_tipo_tienda));
	  //$fin_suscripcion= date("Y-m-d G:i:s",strtotime($datetime_now."+ 1 year"));
	  //GETPLAN
	  //SAVE DATA SQL:
	  $save_pay="INSERT INTO suscripcion_tiendas
	  (id_tienda_suscripcion, tipo_suscripcion, porcentaje_suscripcion_tiendas, cantidad_suscripcion_tiendas, cantidad_promos_tiendas, inicio_suscripcion, fin_suscripcion, orderID_paypal, name_paypal, status_paypal, transaccionID_paypal, cantidadPago_paypal, fechaPago_paypal,email_paypal)
	  VALUES
	  ('$id_tienda_suscripcion','$plan', '$porcentaje_tienda','$cantidad_suscripcion_tiendas','$cantidad_promos_tiendas','$inicio_suscripcion','$fin_suscripcion','$orderID','$name','$status','$transaccionID','$cantidadPago','$fechaPag','$email')";
	  if ($conexlite->query($save_pay) === TRUE) {
		echo $conexlite->error;
		$aviso="1";
		$lastID=$conexlite->insert_id;
		$safeData = "UPDATE tiendas SET nivel_de_tienda = $lastID WHERE id_tienda  = $id_tienda_suscripcion";
		 $conexlite->query($safeData);
		//SEND CLIENTE
		//sendMailCliente($id_tienda_suscripcion,$plan,$inicio_suscripcion);		
		//sendMailTienda($id_tienda_suscripcion,$plan,$inicio_suscripcion);
		
	  } else {
		$aviso="2";
	  }
	  header("Location:../mi-plan/confirmacion-pago?idorder=$orderID&action=$aviso");
  }
}

if (!count(debug_backtrace()))
{
  GetOrder::getOrder($orderID, true);
}
?>