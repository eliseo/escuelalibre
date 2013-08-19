<?php
require_once("includes/admin-functions.php");

	$hid = $_COOKIE['HID'];
	$ut = new userType($hid);
	if(!($ut->isUser())){
		header("Location: login.php"); 
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Panel :: Escuela Libre</title>
	
	<script type="text/javascript" src="js/modernizr-1.6.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.7.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.tools.overlay.min.js"></script> 
	<script type="text/javascript" src="js/jquery.flot.min.js"></script>
	<script type="text/javascript" src="js/jquery.visualize.js"></script>
	<script type="text/javascript" src="js/jquery.rloader-1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.pack.js"></script>
	<script type="text/javascript" src="js/jquery.autocomplete.js" /></script>
	<script type='text/javascript' src='js/lib/jquery.bgiframe.min.js'></script> 
	<script type='text/javascript' src='js/lib/jquery.ajaxQueue.js'></script> 
	<script type='text/javascript' src='js/lib/thickbox-compressed.js'></script> 
	<script type="text/javascript" src="js/jquery.md5.js"></script>	
	<script type="text/javascript" src="js/yaadmin.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<script type="text/javascript" src="js/messages.js"></script>
	<script>
		/* Sirve para notificar nuevos mensajes en el view/top-nav.php */
		var my;
		var view = 1;  /* 1: entrantes, 2: salientes, 3: draft */
		
		$(document).ready(function(){
			var ol;
			my = new MsgManager(readCookie('HID')); 
			my.loadMySenders();
			setInterval('selectView(view); my.newMsgExists(); my.repaint()', 4000);
			setTimeout('setAutoComplete()', 5000);
		});
		
		function selectView(type){
			$('#msgtodiv').addClass('hidden');
			switch(type){
				case 1 :
					my.getMessages();
					break;
				case 2 :
					my.getSent();
					break;
				case 3 :
					my.getDraft();
					break;
				case 4 :
					$('#msgtodiv').removeClass('hidden');
					my.getObservables();
			}
		}
		
		function setAutoComplete(){
			//alert(my.getMySenders());
			$('#toresp').autocomplete(my.getMySenders(),{
				autoFill: true,
				mustMatch: true
			}).result(function(event,data, formatted){
				$('#hidresp','#messagesendform').attr('value', my.getSenderHID(formatted));
			});
		}
	</script>
	
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
	<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" /> 
	<link rel="stylesheet" type="text/css" href="js/lib/thickbox.css" /> 
	
	<link rel="stylesheet" type="text/css" href="css/overlay.css" media="screen"/>
<!-- 	<link rel="stylesheet" type="text/css" href="modules/datatables/css/styles.css" media="screen"/> -->
	
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
                      <header> Mensajes
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
                
						<div class="block">
							<h3><span></span></h3>
							<div class="bcontent">
								<!-- Nuevo mensaje [begins] -->
								<div class="line">
								<a class="button white" href="#" onClick="cleanData();my.clearTable();view=1;selectView(view); return false;"><span><span>Bandeja de entrada</span></span></a>
								<a class="button white" href="#" onClick="showSendForm(); return false;"><span><span>Redactar</span></span></a>
								<a class="button white" href="#" onClick="cleanData();my.clearTable();view=2;selectView(view); return false;"><span><span>Enviados</span></span></a>
								<a class="button white" href="#" onClick="cleanData();my.clearTable();view=3;selectView(view); return false;"><span><span>Borrador</span></span></a>
								<?php if(($ut->isObserver())){ ?>
								<a class="button white" href="#" onClick="cleanData();my.clearTable();view=4;selectView(view); return false;"><span><span>Observer</span></span></a>
								<?php } ?>
								
								<br />
								<br />
								</div>
								<!-- Nuevo mensaje [ends]   -->
							 	<table id="messagelist" class="table">
									<thead>
										<tr>
											<th class="small"><input type="checkbox" class="checkall" /></th>
											<th class="small"><a class="action" href="#"></a></th>
											<th>De: </th>
											<th>Asunto</th>
											<th>Fecha</th>
										</tr>
									</thead>
									<tbody id="messagelistbody">
									</tbody>
								</table>
							</div>
						</div>

						<a id="detalle"></a>
						<div class="block">
							<h3><span>Detalle del mensaje</span></h3>
							<div class="bcontent">
								<h4 class="left"><a href="#responder" onClick="showResponder();">Responder</a></h4>
								<br />
								<div id="msgdetail">
									<table width="100%">
										<tr>
											<td>
											<div style="float:left"> 
											<strong>De: </strong><span id="msgfrom"></span>
											</div>
											</td>
											<?php if($ut->isObserver()){ ?>
											<td>
												<div id="msgtodiv" style="float:left;" class="hidden"> 
												<strong>Para: </strong><span id="msgto"></span>
												</div>
											</td>
											<?php }?>
											<td>
												<div style="float:left"> 
												<strong>Asunto:</strong> <span id="msgsubject"></span>
												</div>
											</td>
											<td>
												<div style="float:left"> 
												<strong>Fecha:</strong> <span id="msgsenddate"></span>
												</div>
											</td>
										</tr>
									</table>
										<div style="width:100%; height: 150px; border: 1px solid #ddd;">
										<span id="msgmessage">
											<div>
												<span class="hidden"></span>
											</div>
										</span>
										</div>
								</div>
								
								<div id="msgdetaillist">
								</div>
								<a id="responder"></a>
								<br>
								<br>
								<!-- RESPONDER [begins] -->
								<div id="responderForm" class="hidden">
									<div id="messageformnotif" class="message hidden">
										<p>Notificaciones</p>
									</div>
									<form name="messagerespform" id="messagerespform" method="post" action="messageService">
										<input type="hidden" name="hid" id="hidresp" class="required" value="" />
										<input type="hidden" name="ticket" id="ticketresp" class="required" value="" />
										<div class="line">
											<label>Asunto: </label>
											<input type="text" class="text half required" name="subject" id="subjectresp"/>
										</div>
										<div class="line">
											<label>Mensaje: </label>
											<textarea class="textarea required" name="message" id="messageresp"></textarea>
										</div>
									</form>
									<a class="button green" href="#" onClick="send(1); return false;"><span><span>Enviar Mensaje</span></span></a>
									<a class="button red" href="#" onClick="hide(1); return false;"><span><span>Cancelar</span></span></a>
								</div>
								<!-- RESPONDER [ends] -->
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
                        <li class="current"><a href="index.html">Mensajes</a></li>
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
						}elseif($ut->isObserver()){
							include("view/twitter.php");
						}elseif($ut->isFrontDesk()){
							include("view/twitter.php");
						}
					?>
                    <!-- block without header [end] -->
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

<!-- Overlay [begin] -->
	<div class="block simple_overlay" id="mies1">
		<h3><span>Nuevo Mensaje</span></h3>
		<div id="sendmessageformnotif" class="message hidden">
			<p>Notificaciones</p>
		</div>
		
		<style>
			table.table tr td{
				vertical-align:top;
			}
			
		</style>		
		<form name="messagesendform" id="messagesendform" method="post" action="messageService">
			<input type="hidden" name="idmsg" id="idmsg" value="" />
			<input type="hidden" name="ticketresp" id="ticketresp" value="" />
			<input type="hidden" name="hidresp" id="hidresp" value="" />
			<table width="100%" class="table">
			<tr><td>
			<div class="line">
				<label>Para: </label>
			</div>
			</td><td>
				<input type="text" class="text half required" name="toresp" id="toresp"/>
			</td></tr>
			<tr><td>
			<div class="line">
				<label>Asunto: </label>
			</div>
			</td><td>
				<input type="text" class="text half required" name="subjectresp" id="subjectresp"/>
			</td></tr>
			<tr><td>
			<div class="line">
				<label>Oculto: </label>
			</div>
			</td><td>
				<input type="checkbox" class="checkbox" name="hiddenresp" id="hiddenresp"/> (Este mensaje solo ser&aacute; le&iacute;do por su destinatario)
			</td></tr>
			<tr><td>
			<div class="line">
				<label>Mensaje: </label>
			</div>
			</td><td>
				<textarea class="textarea required" name="messageresp" id="messageresp"></textarea>
			</td></tr>
			</table>
		</form>
		<div class="line">
		<a class="button blue" href="#" onClick="send(2); return false;"><span><span>Enviar</span></span></a>
		<a class="button blue" href="#" onClick="save(2); return false;"><span><span>Guardar</span></span></a>
		<a class="button red" href="#" onClick="hide(2); return false;" id="closeol"><span><span>Cancelar</span></span></a>
		</div>
	</div>			  			
<!-- Overlay [end] -->
<!-- trigger[begins] -->
<a class="trigger" href="#"></a>
<!-- trigger[ends] -->
</body>
</html>