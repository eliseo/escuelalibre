<?php
include("includes/general-functions.php");

if(isset($_GET['hid_user']) && isset($_GET['have'])){
	
	$hid = $_GET['hid_user'];
	if($_GET['have'] == 1){
		showImage($hid);
	}else{
		
		$image = new imageProfile($hid);
		if($image->haveImage()){
			echo "1";
		}else{  echo "no-pic"; };
	}
		
}else{
	echo "no-pic";
}


function showImage($hid){
	global $ndb;
	$query = "SELECT * FROM image_profile WHERE id_user = (SELECT id FROM users WHERE hid='$hid')";
	
	$data = $ndb->get_row($query);
	$filetype = $data->mimetype;
	$image = $data->image;
	
	$header_string = 'Content-Type: '.$filetype;
	header($header_string);
	print $image;
	
}


?>