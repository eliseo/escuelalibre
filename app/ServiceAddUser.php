<?php
require_once("controller/user.php");

if(
	isset($_POST['user']) && 
	isset($_POST['pass']) && 
	isset($_POST['name']) 
){
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$usertype = $_POST['usertype'];
	$name = $_POST['name'];
	$f_lastname = $_POST['f_lastname'];
	$s_lastname = $_POST['s_lastname'];
	$bday = $_POST['bday'];
	$email = $_POST['email'];
	
	$street = $_POST['street'];
	$no_ext = $_POST['no_ext'];
	$no_int = $_POST['no_int'];
	$colonia = $_POST['colonia'];
	$postalcode = $_POST['postalcode'];
	$municipio = $_POST['municipio'];
	$referencias = $_POST['referencias'];
	
	$telmex = $_POST['telmex'];
	$telcel = $_POST['telcel'];
	$iusacell = $_POST['iusacell'];
	$movistar = $_POST['movistar'];
	$nextel = $_POST['nextel'];
	
	$civil_status = $_POST['civil_status'];
	
	/* .begin code for maps */
	$usemap = @$_REQUEST['usemap'];
	$lat = 0;
	$lng = 0;
	$zoom = 0;
	if($usemap == 1){
		
			$lat = @$_REQUEST['latitud'];
			$lng = @$_REQUEST['longitud'];
			$zoom = @$_REQUEST['zoom'];
	}
	/* code for maps end. */

	$U = new User();
	if($U->addUser($user, $pass, $usertype, $name, $f_lastname, $s_lastname, $bday, $email, $street, $no_ext, $no_int, $colonia, $postalcode, $municipio, $referencias, $telmex, $telcel, $iusacell, $movistar, $nextel, $civil_status,$usemap,$lat,$lng,$zoom)){
		echo "true";
	}else
		echo "false";
}

?>