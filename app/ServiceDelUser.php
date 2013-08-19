<?php

require_once("controller/user.php");
require_once("controller/auth.php");

if(isset($_POST['id']) && isset($_POST['user'])){

	$id = $_POST['id'];
	$user = $_POST['user'];
	//$auth = new Auth();

	//if($auth->userValid($user)){

		$user = new User();
		if($user->deleteUser($id)){
			echo "true";		// El usuario fue eliminado de la base de datos
		}else{ echo "false"; }	// No se pudo eliminar usuario
	//}else{ echo "false";}		// No es un usuario registrado lo que se intenta borrar
}
?>