<?php
include("globals.php");
require_once("controller/auth.php");
require_once("includes/ez_sql_mysql.php");

$messageLogin = "Ingrese sus Credenciales";

$auth = new Auth();
if(isset($_GET['logout']) && isset($_COOKIE['HID'])){
	$messageLogin = ($auth->logoutUser()) ? "Sesión Cerrada" : "Problema al cerrar sesión";
}elseif(isset($_COOKIE['HID'])){
	header("Location: courses.php");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">

<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Escuela Libre :: Ingreso</title>
	
	<script type="text/javascript" src="js/modernizr-1.6.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.rloader-1.1.min.js"></script>
	<script type="text/javascript" src="js/yaadmin.js"></script>
	<script type="text/javascript" src="js/custom-auth.js"></script>
<!--	<script type="text/javascript" src="js/toolbar-auth.js"></script> -->
	
	<!-- JS Compressor
	<script type="text/javascript" src="js/js.php?js,modernizr-1.6.min,jquery-1.4.4.min,jquery.rloader-1.1.min,yaadmin,custom-auth,toolbar-auth"></script>
	-->
	
	<link rel="stylesheet" type="text/css" href="css/reset.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/general.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/buttons.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/forms.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/prettyPhoto.css" media="screen"/>
	
	<!-- CSS Compressor
	<link rel="stylesheet" type="text/css" href="css/css.php?css,reset,general,styles,buttons,forms,prettyPhoto" media="screen"/>
	-->
	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" />
	<![endif]-->
	<style>
		body#auth-page { background: transparent url('images/bg/bg-dark.jpg') 0 0 repeat; }
	     #container-auth header { background-color: #00557a; }
	   #wrapperbg-auth { background-color: rgba(255, 255, 255, 0.3); }
	</style>
</head>
<body id="auth-page">
<div id="page-body-auth">
	<div id="wrapperbg-auth">
		<div id="container-auth">
			<header>Ingresa</header>
			<div class="content">
				<div class="message information closeable">
					<p><?php
						if(isset($_GET['nE'])){
							$noErr=$_GET['nE'];
						  	$messageLogin=$errorMessage[$noErr]; 
						}
						 echo $messageLogin;
						?>
					</p>
				</div>
				<!--  Login form [begin] -->
				<form class="form" id="loginform" method="post" action="ServiceLogin.php">
					<div class="line">
						<label>Usuario:</label>
						<input type="text" name="user" class="text full96" value="" />
					</div>
					<div class="line">
						<label>Contraseña: <a href="#" class="small bold float-right">Haz olvidado tu contraseña?</a></label>
						<input type="password" name="password" class="text full96" value="" />
					</div>
					<div class="line">
						<input type="checkbox" id="remember" class="" value="1" name="remember"/>
						<label class="choice" for="remember">Recuérdame</label>
						<a href="#" class="button green float-right" onclick="$('#loginform').submit();return false;"><span><span>Acceder</span></span></a>
						<div class="clearfix"></div>
					</div>
				</form>
				<!--  Login form [end] -->
			</div>
		</div>
	</div>
</div>
</body>
</html>