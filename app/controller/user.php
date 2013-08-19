<?php
require_once("includes/ez_sql_mysql.php");

class User{
	
	public function addUser($user, $pass, $usertype, $name, $f_lastname, $s_lastname, $bday, $email, $street, $no_ext, $no_int, $colonia, $postalcode, $municipio, $referencias, $telmex, $telcel, $iusacell, $movistar, $nextel, $civil_status,$usemap,$lat,$lng,$zoom){
		global $ndb;	
		// prepare query 
		$query =  "INSERT INTO users(user, pass, name, f_lastname, s_lastname, bday, email, street, no_ext, no_int, colonia, postalcode, municipio, referencias, telmex, telcel, iusacell, movistar, nextel, civil_status) VALUES(";
		$query .= "'".$user."',";
		$query .= "'".md5(trim($pass))."',";
		$query .= "'".$name."',";
		$query .= "'".$f_lastname."',";
		$query .= "'".$s_lastname."',";
		$query .= "'".$bday."',";
		$query .= "'".$email."',";
		
		$query .= "'".$street."',";
		$query .= "'".$no_ext."',";
		$query .= "'".$no_int."',";
		$query .= "'".$colonia."',";
		$query .= "'".$postalcode."',";
		$query .= "'".$municipio."',";
		$query .= "'".$referencias."',";
		
		$query .= "'".$telmex."',";
		$query .= "'".$telcel."',";
		$query .= "'".$iusacell."',";
		$query .= "'".$movistar."',";
		$query .= "'".$nextel."',";
		
		$query .= "'".$civil_status."')";

		$insert_users_result = ($ndb->query($query)) ? true : false;
		if(!$insert_users_result) return $insert_users_result;
		
		/*insertando geodata*/
		if($usemap == 1){
			$id_user = $ndb->insert_id;
			$query = "INSERT INTO geodata(id_user,lat,lng,zoom) VALUES($id_user,$lat,$lng,$zoom)";
			$ndb->query($query);
		}
		/* insertando geodata */
		
		
		$query = "SELECT id FROM users WHERE user='$user' AND pass='".md5($pass)	."' ";
		$dataid = $ndb->get_results($query);
		$id = $dataid[0]->id;

		/// Generar el hid		
		$query = "UPDATE users SET hid=md5(id) WHERE id=$id";
		$ndb->get_results($query);
		
		$campo = 'func_'.$usertype;
		
		$query = "INSERT INTO users_priv(id_user, $campo) VALUES($id, 1)";
		$insert_user_priv_result = ($ndb->query($query)) ? true : false;

		return $insert_user_priv_result;
	}
	
	public function deleteUser($id, $newState = false){
		global $ndb;
		
		$query = "DELETE FROM users WHERE id=$id";
		$result = ($ndb->query($query)) ? true : false;
		if(!$result) return $result;
		
		$query = "DELETE FROM users_priv WHERE id_user=$id";
		$result = ($ndb->query($query)) ? true : false;
		
		
		return $result;
	}
	
	public function updateUserData($hid, $pass=false, $email=false, $usertype=false){ 
		global $ndb;
		// Si no se pasaron parametros se aborta la funcion
		if(!($pass || $email)) return false;
		/*
		$query =  "UPDATE users SET ";
		
		if($pass) $query .= "pass='".md5($pass)."',";
		if($email) $query .= "email='$email',";
		
		$query = substr($query, 0, strlen($query)-1);
		$query .= " WHERE hid='$hid'";
		$result1 = ($ndb->query($query)) ? true : false;
		*/
		
		if($usertype){
			
			$query = "UPDATE users_priv up, users u SET ";
			switch($usertype){
				case 1 :
					$query .= " func_1 = 1, func_2 = 0, func_3 = 0, func_4 = 0, func_5 = 0, func_6 = 0, u.pass='".md5($pass)."', email='$email'";
					break;
				case 2 :
					$query .= " func_1 = 0, func_2 = 1, func_3 = 0, func_4 = 0, func_5 = 0, func_6 = 0, u.pass='".md5($pass)."', u.email='$email' ";
					break;
				case 3 :
					$query .= " func_1 = 0, func_2 = 0, func_3 = 1, func_4 = 0, func_5 = 0, func_6 = 0, u.pass='".md5($pass)."', u.email='$email' ";
					break;
				case 4 :
					$query .= " func_1 = 0, func_2 = 0, func_3 = 0, func_4 = 1, func_5 = 0, func_6 = 0, u.pass='".md5($pass)."', u.email='$email' ";
					break;
				case 5 :
					$query .= " func_1 = 0, func_2 = 0, func_3 = 0, func_4 = 0, func_5 = 1, func_6 = 0, u.pass='".md5($pass)."', u.email='$email' ";
					break;
				case 6:
					$query .= " func_1 = 0, func_2 = 0, func_3 = 0, func_4 = 0, func_5 = 0, func_6 = 1, u.pass='".md5($pass)."', u.email='$email' ";
					break;
			}
			$query .= " WHERE up.id_user = u.id AND u.hid = '$hid'";
			$result2 = ($ndb->query($query)) ? true : false;
			
		}
		
		
		return $result2;
	}
	
	public function updatePersonalData($hid, $name, $f_lastname, $s_lastname, $bday, $civil_status, $street, $no_ext, $no_int, $colonia, $postalcode, $municipio, $referencias, $telmex, $telcel, $iusacell, $movistar, $nextel ){ 
		global $ndb;
		// Si no se pasaron parametros se aborta la funcion
		if(!($name || $f_lastname || $s_lastname )) return false;
		//
		$query =  "UPDATE users SET ";
		
		if($name) $query .= "name='$name',";
		if($f_lastname) $query .= "f_lastname='$f_lastname',";
		if($s_lastname) $query .= "s_lastname='$s_lastname',";
		if($bday) $query .= "bday='$bday',";
		if($civil_status) $query .= "civil_status='$civil_status',";
		
		if($street) $query .= "street='$street',";
		if($no_ext) $query .= "no_ext='$no_ext',";
		if($no_int) $query .= "no_int='$no_int',";
		if($colonia) $query .= "colonia='$colonia',";
		if($postalcode) $query .= "postalcode='$postalcode',";
		if($municipio) $query .= "municipio='$municipio',";
		if($referencias) $query .= "referencias='$referencias',";
		
		if($telmex) $query .= "telmex='$telmex',";
		if($telcel) $query .= "telcel='$telcel',";
		if($iusacell) $query .= "iusacell='$iusacell',";
		if($movistar) $query .= "movistar='$movistar',";
		if($nextel) $query .= "nextel='$nextel',";
		
		$query = substr($query, 0, strlen($query)-1);
		
		$query .= " WHERE hid='$hid'";
		
//		echo $query;
		//echo $query; 
		$result = ($ndb->query($query)) ? true : false;
		return $result;
	}

	public function becomeStudent($id = false){
		global $ndb;
		
		if(!$id) return false;
		
		$query = "UPDATE users_priv SET func_6 = 0 , func_1 = 1 WHERE id_user = $id";
		$result = ($ndb->query($query)) ? true : false;
		
		return $result;
	}
}
?>