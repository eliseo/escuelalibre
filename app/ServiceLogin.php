<?php
require_once("controller/auth.php");
require_once("includes/ez_sql_mysql.php");


if(isset($_POST['user']) && isset($_POST['password'])){
	$user = $_POST['user'];
	$pass  = $_POST['password'];

	$auth = new Auth();
	if($auth->userValid($user)){
		if($auth->checkAuth($user,$pass)){
			if($auth->setUserCookie($user)){
				header("Location: cursos.php");
			}else{ header("Location: login.php?nE=3");	 }
		}else{ header("Location: login.php?nE=2");	 } //invalid pass
	}else{	header("Location: login.php?nE=2"); }	//invalid user 
}else{
	header("Location: login.php?nE=1");  //required fields
}

?>