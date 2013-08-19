<?php
require_once("includes/admin-functions.php");

$hid = $_COOKIE['HID'];
$ut = new userType($hid);

if($ut->isUser()){
	if(!($ut->isAdmin()))
	header("Location: login.php");
}else{	header("Location: login.php"); }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Panel :: Escuela Libre</title>
	
	<script type="text/javascript" src="js/modernizr-1.6.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.7.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.flot.min.js"></script>
	<script type="text/javascript" src="js/jquery.ga.js"></script>
	<script type="text/javascript" src="js/jquery.visualize.js"></script>
	<script type="text/javascript" src="js/jquery.rloader-1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.pack.js"></script>
	<script type="text/javascript" src="js/yaadmin.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
	<!-- JS Compressor
	<script type="text/javascript" src="js/js.php?js,modernizr-1.6.min,jquery-1.4.4.min,jquery-ui-1.8.7.custom.min,jquery.flot.min,jquery.ga,jquery.visualize,jquery.rloader-1.1.min,jquery.validate.pack,yaadmin,custom,toolbar"></script>
	-->
	
	<!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
	
	<link rel="stylesheet" type="text/css" href="css/reset.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/fluidgrid/fluidgrid.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/fluidgrid/fluidgrid-12.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/general.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/buttons.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/forms.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/tables.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/visualize.css" media="screen"/>

	
	<!-- CSS Compressor
	<link rel="stylesheet" type="text/css" href="css/css.php?css,reset,fluidgrid/fluidgrid,fluidgrid/fluidgrid-12,general,styles,menu,buttons,forms,tables,visualize,prettyPhoto" media="screen"/>
	-->
	
	<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.7.custom.css" media="screen"/>
	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" />
	<![endif]-->
</head>
<body>
<div id="page-body">
	<div id="wrapperbg">
		<div id="wrapper">
			<header>
				<!-- horizontal multilevel menu [begin] -->
				<nav id="menu">
					<ul class="menu">
						<?php include("view/menu.php"); ?>
					</ul>
					<div id="topnav">
						<?php include("view/top-nav.php");?>
					</div>
				</nav>
				<!-- horizontal multilevel menu [end] -->
				
				<!-- horizontal main tabs menu [begin] -->
				<?php include("view/menutop.php"); ?>
				<!-- horizontal main tabs menu [end] -->
				
			</header>
			<div id="container">
				<!-- main header [begin] -->
				<header>
					Dashboard
					<!-- search [begin] -->
					<form method="get" action="" id="search">
						<input type="text" class="text" size="30" name="q" placeholder="Search" />
					</form>
					<!-- search [end] -->
				</header>
				<!-- main header [end] -->
				
				<div class="colmask rightmenu">
					<div class="colleft">
						<div class="col1wrap">
							<div id="page" class="col1">
								<!-- CONTENT [begin] -->
								<!--  breadcrumbs [begin] -->
								<div class="breadcrumb">
									<ul>
										<li><a href="index.html">Panel</a></li>
										<li>Main</li>
									</ul>
								</div>
								<!--  breadcrumbs [end] -->
								<div id="visualize"></div>
								<div class="areatabs marginBottom-0">
									<ul class="tabs">
										<li class="current"><a href="#">Características</a></li>
										<li><a href="#">Acerca De</a></li>
										<li><a href="#">Últimas Actualizaciones</a></li>
									</ul>
									<div class="panes">
										<div class="pane visible">
											<!-- features [begin] -->
											<ul class="list list0">
												<li>Administración de Usuarios</li>
												<li>Administración de cursos</li>
												<li>Gestión de documentación para cursos</li>
												<li>Administración de calificaciones y asistencias</li>
											</ul>
											<!-- features [end] -->
										</div>
										<div class="pane">
											<p>Ehecatl Software Services, empresa enfocada al desarrollo de software como servicio, desarrollo de portales empresariales y gestión de proyectos de TI.</p>
										</div>
										<div class="pane">
											<p><a href="http://www.twitter.com/ehecatlmexico">Proyecto Escuela Libre en Twitter</a></p>
										</div>
									</div>
								</div>
								<!-- CONTENT [end] -->
							</div>
						</div>
						<div class="col2">
							<!-- SIDEBAR [begin] -->
							
							<!-- right menu [begin] -->
							<nav class="left">
								<ul>
									<li class="current"><a href="index.html">Dashboard</a></li>
								</ul>
							</nav>
							<!-- right menu [end] -->
							
							<?php include("view/admin-last-users.php"); ?>
							
							<!-- SIDEBAR [end] -->
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<!-- footer [begin] -->
		<footer>&copy; Copyright 2010 by <a href="http://www.ehecatl.com.mx/">Ehecatl Software Services</a></footer>
		<!-- footer [end] -->
	</div>
</div>
</body>
</html>