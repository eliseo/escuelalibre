<?php

require_once("controller/user.php");

if(
	isset($_POST['hid']) &&
	(isset($_POST['name']) || isset($_POST['f_lastname']) || isset($_POST['s_lastname']) ||	isset($_POST['bday']) || isset($_POST['civil_status']) ||	isset($_POST['address']) || isset($_POST['tel']))){
	/// Recupera datos personales 
	$hid = $_POST['hid'];
	if(isset($_POST['name'])) $name = $_POST['name'];
	if(isset($_POST['f_lastname'])) $f_lastname = $_POST['f_lastname'];
	if(isset($_POST['s_lastname'])) $s_lastname = $_POST['s_lastname'];
	if(isset($_POST['bday'])) $bday = $_POST['bday'];
	if(isset($_POST['civil_status'])) $civil_status = $_POST['civil_status'];
	
	if(isset($_POST['street'])) $street = $_POST['street'];
	if(isset($_POST['no_ext'])) $no_ext = $_POST['no_ext'];
	if(isset($_POST['no_int'])) $no_int = $_POST['no_int'];
	if(isset($_POST['colonia'])) $colonia = $_POST['colonia'];
	if(isset($_POST['postalcode'])) $postalcode = $_POST['postalcode'];
	if(isset($_POST['municipio'])) $municipio = $_POST['municipio'];
	if(isset($_POST['referencias'])) $referencias = $_POST['referencias'];


	if(isset($_POST['telmex'])) $telmex = $_POST['telmex'];
	if(isset($_POST['telcel'])) $telcel = $_POST['telcel'];
	if(isset($_POST['iusacell'])) $iusacell = $_POST['iusacell'];
	if(isset($_POST['movistar'])) $movistar = $_POST['movistar'];
	if(isset($_POST['nextel'])) $nextel = $_POST['nextel'];
	
	//print_r($_POST); die();
	
	$user = new User();
	if($user->updatePersonalData($hid, $name, $f_lastname, $s_lastname, $bday, $civil_status, $street, $no_ext, $no_int, $colonia, $postalcode, $municipio, $referencias, $telmex, $telcel, $iusacell, $movistar, $nextel )){
		echo "true";
	}else
		echo "false";
	
}elseif(
	isset($_POST['hid']) && ( isset($_POST['pass']) || isset($_POST['email']) || isset($_POST['usertype']) )
){
	/// Recupera datos de usuario
	//print_r($_REQUEST);
	$hid = $_POST['hid'];
	if(isset($_POST['pass'])) $pass = $_POST['pass'];
	if(isset($_POST['email'])) $email = $_POST['email'];
	if(isset($_POST['usertype'])) $usertype = $_POST['usertype'];
	
	$user = new User();
	if($user->updateUserData($hid, $pass, $email, $usertype)){
		echo "true";
	}else
		echo "false";
		
}elseif(isset($_REQUEST['latitud']) && isset($_REQUEST['longitud']) && isset($_REQUEST['zoom'])){
	//.BEGIN code for Geodata update
	global $ndb;
	$usemap = $_REQUEST['usemap'];
	if($usemap == 1){
			$id_user = $_REQUEST['id_user'];
			$lat = $_REQUEST['latitud'];
			$lng = $_REQUEST['longitud'];
			$zoom = $_REQUEST['zoom'];
			
			$query="INSERT INTO geodata(id_user,lat,lng,zoom) VALUES($id_user,$lat,$lng,$zoom)";
			$return_data = ($ndb->query($query)) ? "true" : "false";

	}else{
			$id_user = $_REQUEST['id_user'];
			$lat = $_REQUEST['latitud'];
			$lng = $_REQUEST['longitud'];
			$zoom = $_REQUEST['zoom'];

			$query="UPDATE geodata SET id_user=$id_user, lat=$lat, lng=$lng, zoom=$zoom WHERE id_user=$id_user";
			$return_data = ($ndb->query($query)) ? "true" : "false";
	}
	echo $return_data;
	//code for Geodata update END.
}

if(isset($_REQUEST['action'])){

	$id = $_REQUEST['id'];
	$user = new User();
	$r = $user->becomeStudent($id);
	if($r)
		echo "true";
	else
		echo "false";
}

?>