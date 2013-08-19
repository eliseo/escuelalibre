

<?php if(isset($_GET['id_student'])){?>
		<div class="panes">
			<div class="pane visible">
				<h3 class="line marginTop-10">Detalles del Estudiante</h3>
	
				<div class="span-full container_12">
					<div class="span-5 alpha">
						<div class="block collapsible marginTop-0">
							<h3><span>Información General</span></h3>
							<div class="bcontent">
								<div id="infoStudent"> </div>
							</div>
						</div>
					</div>
					<div class="span-7 beta">
						<div class="block collapsible marginTop-0">
							<h3><span>Geoposicionamiento</span></h3>
							<div class="bcontent">
								<!-- .BEGIN code for geodata -->
								<?php
									global $ndb;
									$id_user = $_GET['id_student'];
									$query="SELECT * FROM geodata WHERE id_user='$id_user'";
									if(!($ndb->query($query))){
										 $message = "No hay datos de georeferencia para este usuario"; 
								?>
								<h3><?php echo $message; ?></h3>
								<?php } ?>
								<div id="info_map" style="width: 350px; height: 250px; margin:0px auto;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="span-full container_12">
					<div class="span-9 alpha">
						<div class="block collapsible marginTop-0">
							<h3><span>Cursos</span></h3>
							<div class="bcontent">
								<div id="studentCourses"> </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php }else{ ?>
		<!-- .begin AREA DE TABS -->					  
			<div class="areatabs">
					<ul class="tabs">
						<li><a href="#">Ver Estudiantes</a></li>
						<li class="current"><a href="#">Ver Mapa</a></li>
					</ul>
					<div class="panes">
						<div class="pane">
							<div id="userlistmsg" class="message hidden">
								<p>text</p>
							</div>
							<!-- table [end] -->
							<table id="studentslist" class="table">
					    		<thead>
					        		<tr>
					            		<th>ID</th>
					            		<th>Login</th>
					            		<th>Nombre</th>
					            		<th>Apellido</th>
					            		<th>E-mail</th>
					        		</tr>
					    		</thead>
					    		<tbody id="studentslistbody">
								</tbody>
							</table>
							<!-- table [end] -->
							<div class="clearfix"></div>
							<!-- table, pagination [end] -->
						</div>
						<div class="pane visible">
							<h3 class="line marginTop-10">Mapa General de Estudiantes</h3>
							<div style="margin:30px 70px auto;">
								<a href="#" id="printMap" class="button gray" onclick="printDivContent('info_map_students');"><span><span>Imprimir</span></span></a>
								<div id="info_map_students" style="width: 550px; height: 350px;"></div>
							</div>
						</div>
					</div>
				</div>
			<!-- AREA DE TABS [end.]-->
<?php }?>
			<script src='http://maps.google.com/maps/api/js?sensor=false' type='text/javascript'></script>
			<script type='text/javascript' src='gm3.js'></script>
			<script type="text/javascript">
			function printDivContent(nodeId){
				var prtContent = document.getElementById(nodeId);
				var WinPrint = window.open('','mapa-estudiantes','left=0,top=0,width=550,height=350,toolbar=0,scrollbars=0,status=0');
				WinPrint.document.write(prtContent.innerHTML);
				WinPrint.document.close();
				WinPrint.focus();
				WinPrint.print();
				prtContent.innerHTML=strOldOne;
			};
			</script>