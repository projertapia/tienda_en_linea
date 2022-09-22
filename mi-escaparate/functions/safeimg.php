<?php
	session_start();
	function saveImage($filename,$nameinput,$id_producto,$x,$y){	
		$id_producto;
		$allowed_file_types = array('.jpeg','.jpg','.png');
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES[$nameinput]["size"];
		$orgname = strtr($file_basename, " ", "-");
		if (in_array($file_ext,$allowed_file_types) && ($filesize < 20097152)){
			$newprofileimg = $orgname.'-'.md5(date("dmYHis")). $file_ext;
			if (move_uploaded_file($_FILES[$nameinput]["tmp_name"], "../../img/tiendas/".NICKTIENDA."/$newprofileimg")){
				// *** 1) Initialise / load image
				$resizeObj = new resize("../../img/tiendas/".NICKTIENDA."/$newprofileimg");
				 // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$resizeObj -> resizeImage($x,$y, 'crop');
				if($file_ext=='.png'){
					$resizeObj -> saveImage("../../img/tiendas/".NICKTIENDA."/$newprofileimg",null, 1000);
				}else{
					$resizeObj -> saveImage("../../img/tiendas/".NICKTIENDA."/$newprofileimg", 1000);
				}
				return $safeimage = "UPDATE productos SET $nameinput = '$newprofileimg' WHERE id_producto = $id_producto";
				
			}else{
				//echo "no";
			}
			
		}else{
			//echo"El archivo es muy pesado o no es el formato compatible.";
		}
	}
?>