<?php
include("../includes/general-functions.php");


if(isset($_FILES['pic']) && isset($_POST['hid'])){
	
	$hid = $_POST['hid'];
	
	$max_file_size = 10000000; //max file size alllowed 30MB
	$filename = $_FILES['pic']['name'];
	$filetype = $_FILES['pic']['type'];
	$filesize = $_FILES['pic']['size'];
	$tmp_file = $_FILES['pic']['tmp_name'];
	
	$error = 0;
	
	// validando tipo de archivo
	$allowedExtensions = array("png", "jpeg", "pdf", "jpg", "JPG");
	$ext = substr($filename, strrpos($filename, ".")+1);
	if(!in_array($ext, $allowedExtensions)){
		echo "no valid file ";
		$error = 1;
	}
	
	if($_FILES["file"]["size"] > $max_file_size){
		echo "no allowed file size";
		$error = 1;
	}
	
	if($error == 1){
		exit(0);
	}
	

	// se obtiene el contenido
	$fp = fopen($tmp_file, "rb");
	$filecontent = fread($fp, $filesize);
	$filecontent = addslashes($filecontent);
	fclose($fp);

	$image = new imageProfile($hid);

	if($image->haveImage()){
		 $id_image = $image->haveImage();
		 if($image->updateImage($id_image, $filecontent, $filetype)){ echo "success"; }else{ echo "error, updating image";   }
	}else{
		if($image->newImage($filecontent, $filetype)){ echo "success"; }else{ echo "error, inserting new image"; }
	}

}

?>