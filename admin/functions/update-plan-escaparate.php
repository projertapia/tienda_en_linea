<?php
	session_start();
	require('../connect/conect_usrer.php');
	require('../../functions/resize-class.php');
	include('safeimg.php');
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
			header('location:'.SITE.'/admin/entrar');
	}
	if(isset($_POST['idescaparate']) AND $_POST['idescaparate'] != ""){
		$formadmin=$_POST['id_admin'];
		if($id_admin==$formadmin){		
			$idescaparate=$_POST['idescaparate'];
			$e=$_POST['e'];
			$cat=$_POST['cat'];
			$plan=$_POST['plan'];
			//GET PLAN
			$SQLPercentReport="SELECT * FROM tipos_tienda WHERE id_tipo_tienda = $plan";
			$reqPercentReport=mysqli_query($conex, $SQLPercentReport);
			while($resulPercentReport = mysqli_fetch_object($reqPercentReport)){
				$id_tipo_tienda  = $resulPercentReport->id_tipo_tienda;
				$nombre_tipo_tienda = $resulPercentReport->nombre_tipo_tienda;
				$cantidad_tipo_tienda = $resulPercentReport->cantidad_tipo_tienda;
				$cantidad_promos_tipo_tienda = $resulPercentReport->cantidad_promos_tipo_tienda;
				$porcentaje_tienda = $resulPercentReport->porcentaje_tienda;
				$costo_tienda = $resulPercentReport->costo_tienda;
				$duracion_tipo_tienda = "+ ".$resulPercentReport->duracion_tipo_tienda." month";}
				
				$fin_suscripcion= date("Y-m-d G:i:s",strtotime($datetime_now.$duracion_tipo_tienda));
			//GET PLAN
			$AddPlan = "INSERT INTO suscripcion_tiendas (id_tienda_suscripcion,tipo_suscripcion,porcentaje_suscripcion_tiendas,cantidad_suscripcion_tiendas,cantidad_promos_tiendas,fin_suscripcion) VALUES ('$idescaparate','$plan','$porcentaje_tienda','$cantidad_tipo_tienda','$cantidad_promos_tipo_tienda','$fin_suscripcion')";
			if ($conex->query($AddPlan) === TRUE) {	
				$lastID=$conex->insert_id;
				$safeData = "UPDATE tiendas SET nivel_de_tienda = $lastID WHERE id_tienda  = $idescaparate ";
				if ($conex->query($safeData) === TRUE) {
					header('location:'.SITE.'/admin/escaparates/ver?id='.$idescaparate.'&e='.$e.'&cat='.$cat.'&mod=true');
				}else{
					header('location:'.SITE.'/admin/escaparates/ver?id='.$idescaparate.'&e='.$e.'&cat='.$cat.'');
				}
			}else{
				header('location:'.SITE.'/admin/escaparates/ver?id='.$idescaparate.'&e='.$e.'&cat='.$cat.'');
			}
		}else{
			header('location:'.SITE.'/admin/entrar');
		}
	}else{
		header('location:'.SITE.'/admin/escaparates');
	}
?>