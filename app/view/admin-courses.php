<!--  breadcrumbs [begin] -->
<div class="breadcrumb">
	<ul>
		<li><a href="#">Panel</a></li>
		<li><a href="cursos">Cursos</a></li>
	</ul>
</div>
<!--  breadcrumbs [end] -->
<div class="areatabs">
	<ul class="tabs">
		<li class="current"><a href="#">Ver Cursos</a></li>
		<li><a href="#">Crear Curso</a></li>
	</ul>
	<div class="panes">
		<div class="pane visible">
			<h3 class="line marginTop-10">Ver Curso</h3>
			<!-- table [end] -->
			<table id="coursesListTable" class="table">
			    <thead>
			        <tr>
			            <th>ID</th>
						<th class="small"><a class="action" href="#"></a></th>
			            <th>Curso</th>
			            <th>ID Profesor </th>
			            <th>ID Periodo </th>
						<th>Fecha Inicial </th>
						<th>Fecha Final </th>
			        </tr>
			    </thead>
			    <tbody id="coursesList">
			    </tbody>
				<tfoot> 
					<tr> 
						<th>ID</th> 
						<th class="small"><a class="action" href="#"></a></th>
						<th>Curso</th> 
						<th>ID Profesor </th> 
						<th>ID Periodo </th>
						<th>Fecha Inicial </th> 
						<th>Fecha Final </th> 
					</tr> 
				</tfoot>
			</table>
			<div class="clearfix"></div>
			<!-- table, pagination [end] -->
			
		</div>
		<div class="pane">
			<h3 class="line marginTop-10">Crear Curso</h3>
			<div id="messageClient">
				<div class="message closeable tip">
			       <p>Usted esta a punto de crear una clase.</p>
			   </div>	
			</div>
			<!-- .begin form class -->
			<form id="newCourse" method="POST" class="form">
				<fieldset>
					<table class="simple">
						<tbody>
							<tr>
								<td>
									<div class="line">
										<label>Código:</label>
										<input type="text" name="name_course" class="text" value="" />
									</div>
								</td>
								<td>
									<div class="line">
									<label>Descripción:</label>
									<input type="text" name="desc_course" class="text full" value="" />
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="line">
										<label>Maestro: </label>
										<div id="selectProfesor"></div>
									</div>
								</td>
								<td>
									<table>
										<tbody>
											<tr>
												<td>	
													<div class="line">
													<label>Fecha Inicio:</label> <input type="text" name="start_date" class="datepicker text required" />
														</div>
												</td>
												<td>
													<div class="line">
														<label>Fecha Terminación:</label> <input type="text" name="end_date" class="datepicker text required"> 
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<div class="line">
										<label>Selecciona Periodo:</label>
										<div id="selectPeriod"></div>
										<input type="checkbox" id="otherPeriod" name="otherPeriod" value="1" />
										<label  for="otherPeriod">Otro</label>
									</div>
								</td>
								<td>
									<div id="nPf" style="display:none">
										<div class="line">
											<label>Nombre periodo:</label>
											<input type="text" name="nPeriod" id="nPeriod" class="text"/>
										</div>
										<div class="line">
											<table class="table">
												<tbody>
													<th colspan="4">Días periodo:</th>
													<tr>
														<td>
															L:<input type="checkbox" name="dayP[]" value="lun">
														</td>
														<td>
															Ma:<input type="checkbox" name="dayP[]" value="mar">
														</td>
														<td>
															Mi:<input type="checkbox" name="dayP[]" value="mier">
														</td>
														<td>
															J:<input type="checkbox" name="dayP[]" value="juev">
														</td>
														<td>
															V:<input type="checkbox" name="dayP[]" value="vier">
														</td>
														<td>
															S:<input type="checkbox" name="dayP[]" value="sab">
														</td>
														<td>
															D:<input type="checkbox" name="dayP[]" value="dom">
														</td>
													</tr>
												</tbody>
											</table>
											<a id="cnP" href="#" class="button blue"><span><span>Nuevo Periodo</span></span></a>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan='2'>
								<div id="schedulePeriod"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="line">
										<a href="#" class="button blue" onclick="$('#newCourse').submit();return false;"><span><span>Crear</span></span></a>
										<a href="#" class="button white" onclick="$('#newCourse')[0].reset();return false;"><span><span>Restablecer</span></span></a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
			</form>
			<!--  form class end. -->
		</div>
	</div>
</div>