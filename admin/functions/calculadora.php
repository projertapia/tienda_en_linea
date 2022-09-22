<?php
class calorescalculadora{
    public $subtotal;
    public $total;
	public $producto_menos_iva;
	public $envio_menos_iva;
	public $producto_precio_vendedor;
	public $comision_sin_iva;
	public $iva_Total;
	public $total_recepcion;
	public $prod_fact;
}
function calculadora($precio_producto,$cantidad_producto_carrito,$costo_envio_carrito,$porcentaje){
	$calc = new calorescalculadora();
	//SUB TOTAL CON IVA
	$calc->subtotal = $subtotal=($cantidad_producto_carrito * $precio_producto);		
	//TOTAL CON IVA
	$calc->total = $total=$subtotal+$costo_envio_carrito;		
	//PRODUCTO MENOS IVA
	$calc->producto_menos_iva = $producto_menos_iva=$subtotal/1.16;		
	//ENVIO - IVA
	$calc->envio_menos_iva = $envio_menos_iva=$costo_envio_carrito /1.16;
	//PRODUCTO SIN COMISION
	$calc->producto_precio_vendedor = $producto_precio_vendedor=$producto_menos_iva / (1+($porcentaje/100));		
	//COMISION
	$calc->comision_sin_iva = $comision_sin_iva=number_format(($producto_menos_iva - $producto_precio_vendedor), 2, '.', ',');			
	//IVA TOTAL
	$calc->iva_Total = $iva_Total=$total - ($producto_menos_iva+$envio_menos_iva);
	//TOTAL RECEPCIÓN VENDEDOR
	$calc->total_recepcion= $total_recepcion=$producto_precio_vendedor+$envio_menos_iva;	

	$calc->prod_fact = $prod_fact=$total_recepcion - $envio_menos_iva;
	return $calc;
}
?>