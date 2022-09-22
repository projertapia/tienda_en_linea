<?php
	session_start();
	function saveImage($filename,$nameinput,$id_banner ,$x,$y){	
		$id_banner ;
		$allowed_file_types = array('.jpeg','.jpg','.png');
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES[$nameinput]["size"];
		$orgname = strtr($file_basename, " ", "-");
		if (in_array($file_ext,$allowed_file_types) && ($filesize < 2097152)){
			$newprofileimg = $id_banner.'-'.$orgname.'-'.$nameinput.md5(date("dmYHis")). $file_ext;
			if (move_uploaded_file($_FILES[$nameinput]["tmp_name"], "../../img/$newprofileimg")){
				// *** 1) Initialise / load image
				$resizeObj = new resize("../../img/$newprofileimg");
				 // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$resizeObj -> resizeImage($x,$y, 'crop');
				if($file_ext=='.png'){
					$resizeObj -> saveImage("../../img/$newprofileimg",null, 1000);
				}else{
					$resizeObj -> saveImage("../../img/$newprofileimg", 1000);
				}
				return $safeimage = "UPDATE site_banner SET img_banner = '$newprofileimg' WHERE id_banner  = $id_banner ";
				
			}else{
				//echo "no";
			}
			
		}else{
			//echo"El archivo es muy pesado o no es el formato compatible.";
		}
	}
?>