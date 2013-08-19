<?php



class Auth{
	
	
	public function userValid($user){
		global $ndb;	
		$query="SELECT user FROM users WHERE user='$user'";
		$return_val = ($ndb->query($query)) ? true : false;
		return $return_val;
	}
	
	public function checkAuth($user,$pass){
		global $ndb;
		$md5_pass=md5($pass);
		$query="SELECT user,pass FROM users WHERE user='$user' AND pass='$md5_pass'";
		$return_val = ($ndb->query($query)) ? true : false;
		return $return_val;
	}
	
	public function setUserCookie($user){
		//making a hash named hid from password
		global $ndb;
		$query="SELECT hid FROM users WHERE user='$user'";
		$data = $ndb->get_results($query);
		foreach($data as $col){ $hid=$col->hid;}
		$return_val = setcookie("HID",$hid,0,'/') ? true : false;//this cookie ends when browser is closed
		return $return_val;
	}
	
	public function logoutUser(){
		$return_val = setcookie("HID",null,time()-21600,"/","",1) ? true : false;
		return $return_val;
	}
	
}
?>