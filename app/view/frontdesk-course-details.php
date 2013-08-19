<!--  breadcrumbs [begin] -->
<div class="breadcrumb">
		<ul>
			<li><a href="#">Panel</a></li>
			<li><a href="cursos">Cursos</a></li>
			<li>Curso #<?php echo $_GET['id_course']; ?></li>
		</ul>
</div>
<!--  breadcrumbs [end] -->
<!-- .begin areatabs -->
<div class="areatabs">
	<ul class="tabs">
		<li class="current"><a href="#">Detalles</a></li>
		<li><a href="#">Evaluaciones</a></li>
		<li><a href="#">Observadores</a></li>
	</ul>
	<div class="panes">
		<div class="pane visible">
			<h3 class="line marginTop-10">Detalles de Curso</h3>

	<!-- .begin full container-->
			<div class="span-full container_12">
				<div class="span-5 alpha">
					<div class="block collapsible marginTop-0">
						<h3><span>Detalles de Curso</span></h3>
						<div class="bcontent">
							<div id="infoCourse"></div>
						</div>
					</div>
				</div>
		
				<div class="span-7 omega">
					<div class="block collapsible marginTop-0">
						<h3><span>Estudiantes</span></h3>
						<div class="bcontent">
							<div id="studentsCourse"></div>
						</div>
					</div>
				</div>
	
				<div class="clearfix"></div>
	
				<div class="span-5 alpha">
					<div class="block collapsible marginTop-0">
						<h3><span>Horario</span></h3>
						<div class="bcontent">
							<div id="dailySchedule"></div>
						</div>
					</div>
				</div>
		
				<div class="span-7 omega">
					<div class="block collapsible marginTop-0">
						<h3><span>Añadir Estudiantes</span></h3>
						<div class="bcontent">
							<div id="studentToCourse"></div>
						</div>
					</div>
				</div>
			</div>
		<!-- full container end. -->
		</div><!-- .end first pane-->	

		<div class="pane">
			<h3 class="line marginTop-10">Evaluaciones</h3>
			<div id="messageClient_2"></div>
			<!-- .begin full container -->
			<div class="span-full container_12">
				<div class="span-7 alpha">
						<div class="bcontent">
							<!-- .begin form newEval -->
							<div class="areatabs">
								<ul class="tabs">
									<li class="current"><a href="#">Sem 01</a></li>
									<li><a href="#">Sem 02</a></li>
									<li><a href="#">Sem 03</a></li>
									<li><a href="#">Sem 04</a></li>
								</ul>
								<div class="panes">
									<div class="pane visible">
											<h3 class="line marginTop-10">Evaluaciones sem 01</h3>
											<div id="evalsS1"></div>
									</div>
									<div class="pane">
											<h3 class="line marginTop-10">Evaluaciones sem 02</h3>
											<div id="evalsS2"></div>
									</div>
									<div class="pane">
											<h3 class="line marginTop-10">Evaluaciones sem 03</h3>
											<div id="evalsS3"></div>
									</div>
									<div class="pane">
											<h3 class="line marginTop-10">Evaluaciones sem 04</h3>
											<div id="evalsS4"></div>
									</div>
								</div>
							</div>
							<!-- .end form new Eval -->
					</div>
				</div>
			</div>
			<!-- .end full container -->
		</div>

	<!-- .begin third pane-->
		<div class="pane">
			<h3 class="line marginTop-10">Observadores</h3>
			<div id="messageClient_3"></div>
			<div class="span-full container_12">
				
				<div class="span-7 alpha">
					<div class="block collapsible marginTop-0">
						<h3><span>Observadores del Curso</span></h3>
						<div class="bcontent">
							<div id="observersCourse"></div>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="span-7 alpha">
					<div class="block collapsible marginTop-0">
						<h3><span>Añadir Observadores</span></h3>
						<div class="bcontent">
							<div id="observersToCourse"></div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div><!-- third pane end. -->	
</div>
<!-- .end areatabs -->