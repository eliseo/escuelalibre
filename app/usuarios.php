<?php
require_once("includes/admin-functions.php");

	$hid = $_COOKIE['HID'];
	$ut = new userType($hid);
	
	if(!($ut->isAdmin())){
			if(!($ut->isFrontDesk())){
				header("Location: login"); 
			}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Panel :: Escuela Libre</title>
	
	<script type="text/javascript" src="js/modernizr-1.6.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="js/jquery.tools.overlay.min.js"></script> 
	<script type="text/javascript" src="js/jquery-ui-1.8.7.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.flot.min.js"></script>
	<script type="text/javascript" src="js/jquery.visualize.js"></script>
	<script type="text/javascript" src="js/jquery.rloader-1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.pack.js"></script>
	<script type="text/javascript" src="js/jquery.md5.js"></script>	
	<script type="text/javascript" src="js/yaadmin.js"></script>
	<script type="text/javascript" src="js/custom.js"></script> 
	<script type="text/javascript" src="js/jquery.form.js"></script>
	

	<script type="text/javascript" src="js/user.js"></script>
<!--
	<script type="text/javascript" src="js/toolbar.js"></script> 
-->
	
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

	<link rel="stylesheet" type="text/css" href="css/overlay.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/custom.css" media="screen" />
	
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
						<?php include("view/top-nav.php"); ?>
					</div>
				</nav>
				<!-- horizontal multilevel menu [end] -->
				
				<!-- horizontal main tabs menu [begin] -->
				<?php include("view/menutop.php"); ?>
				<!-- horizontal main tabs menu [end] -->
				
			</header>
			<div id="container">
				 <!-- main header [begin] -->
                      <header> Usuarios
                        <!-- search [begin] -->
                          <form method="get" action="" id="search">
                            <input type="text" class="text" size="30" name="q" placeholder="Search" />
                          </form>
                        <!-- search [end] -->
                      </header>
			  <div class="colmask rightmenu">
                <div class="colleft">
                  <div class="col1wrap">
                    <div id="page" class="col1">
                      <!-- CONTENT [begin] -->
                  
					<?php 
						if($ut->isAdmin()){	
							if(@$_GET['ac']=="edit" && $_GET['id_user'] != ""){ 
								include("view/admin-update-users.php");
							}else{
								include("view/admin-users.php");
							}
						}elseif($ut->isFrontDesk()){
								include("view/frontdesk-users.php");
						}
					  ?>
                      <!-- CONTENT [end] -->
                    </div>
                  </div>
                  <div class="col2">
                    <!-- SIDEBAR [begin] -->
                    <!-- right menu [begin] -->
                    <nav class="left">
                      <ul>
                        <li class="current"><a href="index.html">Usuarios</a></li>
                      </ul>
                    </nav>
                    <!-- right menu [end] -->
                    <!-- block with header [begin] -->
                    <?php
						if($ut->isAdmin()){
							include("view/admin-last-users.php");
						}elseif($ut->isTeacher()){
							include("view/twitter.php");
						}elseif($ut->isStudent()){
							include("view/twitter.php");
						}
					?>
                    <!-- block with header [end] -->
                    <!-- SIDEBAR [end] -->
                  </div>
                </div>
		      </div>
			  <div class="clearfix"></div>
		  </div>
		</div>
		<!-- footer [begin] -->
		<footer>&copy; Copyright 2010 by <a href="#">Your Company</a></footer>
		<!-- footer [end] -->
	</div>
</div>

								
</body>
</html>