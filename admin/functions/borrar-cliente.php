<?php
session_start();
require('../connect/conect_usrer.php');
if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
	header('location:'.SITE.'/admin/entrar');
}
if(isset($_GET['id']) AND $_GET['id'] != ""){
	$id=$_GET['id'];
	$sqlDeleteFiles="SELECT img_sq_a_publicidad,img_sq_b_publicidad,img_sq_c_publicidad,img_sq_d_publicidad,img_rq_a_publicidad,img_rq_b_publicidad,img_top_publicidad FROM publicidad WHERE cliente_publicidad = $id";
	$reqDeleteFiles=mysqli_query($conex, $sqlDeleteFiles);
	while($resulreqDeleteFiles = mysqli_fetch_object($reqDeleteFiles)){
		$img_sq_a_publicidad = $resulreqDeleteFiles->img_sq_a_publicidad;
		unlink('../../img/publicidad/'.$img_sq_a_publicidad);
		$img_sq_b_publicidad = $resulreqDeleteFiles->img_sq_b_publicidad;
		unlink('../../img/publicidad/'.$img_sq_b_publicidad);
		$img_sq_c_publicidad = $resulreqDeleteFiles->img_sq_c_publicidad;
		unlink('../../img/publicidad/'.$img_sq_c_publicidad);
		$img_sq_d_publicidad = $resulreqDeleteFiles->img_sq_d_publicidad;
		unlink('../../img/publicidad/'.$img_sq_d_publicidad);
		$img_rq_a_publicidad = $resulreqDeleteFiles->img_rq_a_publicidad;
		unlink('../../img/publicidad/'.$img_rq_a_publicidad);
		$img_rq_b_publicidad = $resulreqDeleteFiles->img_rq_b_publicidad;
		unlink('../../img/publicidad/'.$img_rq_b_publicidad);
		$img_top_publicidad = $resulreqDeleteFiles->img_top_publicidad;
		unlink('../../img/publicidad/'.$img_top_publicidad);
	}
	$sqlborrar="DELETE FROM publicidad WHERE cliente_publicidad = $id";
	if ($conex->query($sqlborrar) === TRUE) {
		echo 1;
	} else {
		$aviso.="Error 13. La Publicidad no se ha borrado.";
		echo 2;
	}
	$sqlborrarCliente="DELETE FROM clientes_publi WHERE id_cliente_publi = $id";
	if ($conex->query($sqlborrarCliente) === TRUE) {
		echo 1;
	} else {
		$aviso.="Error 13. La Publicidad no se ha borrado.";
		echo 2;
	}
}else{
	echo 2;
}
?>