

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
								<div id="infoStudent"> </div>
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
						<li class="current"><a href="#">Ver Estudiantes</a></li>
					</ul>
					<div class="panes">
						<div class="pane visible">
							<div id="userlistmsg" class="message hidden">
								<p>text</p>
							</div>
							<!-- table [end] -->
							<table id="studentslist" class="table">
					    		<thead>
					        		<tr>
					            		<th>ID</th>
					            		<th>Usuario</th>
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
					</div>
				</div>
			<!-- AREA DE TABS [end.]-->
<?php }?>