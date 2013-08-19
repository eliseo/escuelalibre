<?php
include_once("ez_sql_mysql.php");

class userType{
	
	function userType($hid){
		$this->hid = $hid;
		$this->id_user = $this->idUser();
	}	

	function idUser(){
		global $ndb;
		$query = "SELECT id FROM users WHERE hid='$this->hid'";
		$data = $ndb->get_row($query);
		return $data->id;
	}

	function isUser(){
		global $ndb;
		$hid = $this->hid;
		$query = "SELECT hid FROM users WHERE hid='$hid'";
		$return_val = ($ndb->query($query)) ? true : false;
		return $return_val;
	}

	function isAdmin(){
		global $ndb;
		$id_user = $this->id_user;
		$query = "SELECT  * FROM users_priv WHERE id_user=$id_user";
		$data = $ndb->get_row($query);
		$func_5 = $data->func_5;
		$return_val = ($func_5 == 1) ? true : false;
		return $return_val;
	}

	function isTeacher(){
		global $ndb;
		$id_user = $this->id_user;
		$query = "SELECT  * FROM users_priv WHERE id_user=$id_user";
		$data = $ndb->get_row($query);
		$func_2 = $data->func_2;
		$return_val = ($func_2 == 1) ? true : false;
		return $return_val;
	}
	
	function isStudent(){
		global $ndb;
		$id_user = $this->id_user;
		$query = "SELECT  * FROM users_priv WHERE id_user=$id_user";
		$data = $ndb->get_row($query);
		$func_1 = $data->func_1;
		$return_val = ($func_1 == 1) ? true : false;
		return $return_val;
	}

	function isObserver(){
		global $ndb;
		$id_user = $this->id_user;
		$query = "SELECT * FROM users_priv WHERE id_user=$id_user";
		$data = $ndb->get_row($query);
		$func_1 = $data->func_3;
		$return_val = ($func_1 == 1) ? true : false;
		return $return_val;
	}
	
	function isDirector(){ //the same funcion than above
			global $ndb;
			$id_user = $this->id_user;
			$query = "SELECT * FROM users_priv WHERE id_user=$id_user";
			$data = $ndb->get_row($query);
			$func_1 = $data->func_3;
			$return_val = ($func_1 == 1) ? true : false;
			return $return_val;
	}
	
	function isFrontDesk(){
		global $ndb;
		$id_user = $this->id_user;
		$query = "SELECT * FROM users_priv WHERE id_user=$id_user";
		$data = $ndb->get_row($query);
		$func_4 = $data->func_4;
		$return_val = ($func_4 == 1) ? true : false;
		return $return_val;
	}
	
	function isProspecto(){
		global $ndb;
		$id_user = $this->id_user;
		$query = "SELECT * FROM users_priv WHERE id_user=$id_user";
		$data = $ndb->get_row($query);
		$func_6 = $data->func_6;
		$return_val = ($func_6 == 1) ? true : false;
		return $return_val;
	}
	
}

?>