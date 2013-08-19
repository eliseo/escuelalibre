
		<div class="panes">
			<!-- .begin first pabe -->
			<div class="pane visible">
				<h3 class="line marginTop-10">Ver Curso</h3>
				<!-- table [begin] -->
				<table id="coursesListTable" class="table">
				    <thead>
				        <tr>
				            <th>ID</th>
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
							<th>Curso</th> 
							<th>ID Profesor </th> 
							<th>ID Periodo </th>
							<th>Fecha Inicial </th> 
							<th>Fecha Final </th> 
						</tr> 
					</tfoot>
				</table>

				<!-- table, pagination [end] -->
				<!-- .begin box horario -->
				<div class="block collapsible closed">
					<h3><span>Horario</span></h3>
					<div class="bcontent">
						<table class="table" width="100%" border="1">
							<thead>
								<tr>
									<th><span>Horario</span></th>
									<th><span>Lunes</span></th>
									<th><span>Martes</span></th>
									<th><span>Mi&eacute;rcoles</span></th>
									<th><span>Jueves</span></th>
									<th><span>Viernes</span></th>
									<th><span>S&aacute;bado</span></th>
									<th><span>Domingo</span></th>
								</tr>
							</thead>
							<tbody id="schedulecoursetable">
								
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="block collapsible closed">
					<h3><span>Calificaciones</span></h3>
					<div class="bcontent">
						<table class="table">
							<thead id="ratingstableheader">
								<tr>
									<th>Apellido</th>
									<th>Nombre</th>
									<th>Calificación</th>
								</tr>
							</thead>
							<tbody id="ratingstablecontent">
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						<div id="ratingspag" class="pagination float-right">
							<a href="#">&lt;</a>
							<a class="active" href="#">1</a>
							<a href="#">&gt;</a>
						</div>
					<!-- 
						<a class="button default" href="#" onClick="updateFinalRating();return false;"><span><span>Actualizar Calificaci&oacute;n</span></span></a>
					-->
						</form>
					</div>
				</div>
				<!-- -box horario end. -->
				<!-- .begin box asistencia -->
				<div class="block collapsible closed">
					<h3><span>Asistencia</span></h3>
					<div class="bcontent">
							<table class="table">
								<thead id="assistancetablehead">
									<tr>
										<th>Estudiante</th>
										<th>dia 1</th>
										<th>dia 2</th>
										<th>dia 3</th>
										<th>dia 4</th>
									</tr>
								</thead>
								<tbody id="assistancetable">
								</tbody>
							</table>
							<div id="assistancepag" class="pagination float-right">
								<a href="#">&lt;</a>
								<a class="active" href="#">1</a>
								<a href="#">&gt;</a>
							</div>
					</div>
				</div>
				<!-- box asistencia end. -->
				<!-- .begin box material  -->
				<div class="block collapsible closed">
					<h3><span>Materiales</span></h3>
					<div class="bcontent">
						<table class="table">
							<thead>
								<tr>
									<th class="small"><input type="checkbox" class="checkall" /></th>
									<th>Nombre</th>
									<th>Descripci&oacute;n</th>
									<th>Fecha</th>
									<th>Descargar</th>
								</tr>
							</thead>
							<tbody id="documentlist">
								
							</tbody>
						</table>					
					</div>
				</div>
				<!--  box material end. -->
			</div>
			<!-- first pane end. -->
		</div>
		
	<!-- Comment on Rating -->
	<div id="commentpanel" class="block hidden">
		<h3><span>Comentario</span></h3>
		<div class="bcontent">
			<form id="commentform" action="#" method="post" >
			
			<input type="hidden" id="hid" name="hid" value="" />
			<input type="hidden" id="id_classmate" name="id_classmate" value="" />
			<input type="hidden" id="id_eval_type" name="id_eval_type" value="" />
			
			<table>
				<tr>
					<td>
						<label id="comment" name="com" class="textarea"/></label>
					</td>
				</tr>
			</table>
			<a id="closecomment" class="button default" href="#" onClick="return false;"><span><span>Cerrar</span></span></a>
			</form>
		</div>
	</div>
	<!-- Comment on Rating [end] -->