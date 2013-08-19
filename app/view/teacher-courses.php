	<!-- CONTENT [begin] -->
                  
                      <!--  breadcrumbs [begin] -->
                      <div class="breadcrumb">
                        <ul>
                          <li><a href="index.html">Main</a></li>
                          <li> Usuarios</li>
                        </ul>
                      </div>
                      <!-- CONTENT [end] -->

					<!-- AREA DE TABS -->					  
					<div class="areatabs">
						<ul class="tabs">
							<li class="current"><a id="clasesviewtab" href="#">Clases</a></li>
							<li><a id="scheduletab" href="#">Horarios</a></li>
						</ul>
						<div class="panes">
							<div class="pane visible">
									
								  	<table id="courselist" class="table">
											<thead>
												<tr>
													<th class="small"><input type="checkbox" class="checkall" /></th>
													<th class="small"><a class="action" href="#"></a></th>
													<th>Nombre</th>
													<th>Descripci&oacute;n</th>
													<th>Fecha Inicio</th>
													<th>Fecha Fin</th>
													<th>Sal&oacute;n</th>
												</tr>
											</thead>
											<tbody id="coursestable">
												
											</tbody>
										</table>
										
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
											<h3><span>Alumnos</span></h3>
											<div class="bcontent">
												<table class="table">
													<thead id="classmatestableheader">
														<tr>
															<th class="small"><input type="checkbox" class="checkall" /></th>
															<th class="small"><a class="action" href="#"></a></th>
															<th>Apellido</th>
															<th>Nombre</th>
															<th>E-mail</th>
														</tr>
													</thead>
													<tbody id="classmatestable">
														<tr>
															<td class="small"><input type="checkbox" /></td>
															<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a href="#">Edit</a></li><li><a href="#">Remove</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										
										<div class="block collapsible closed">
											<h3><span>Calificaciones</span></h3>
											<div class="bcontent">
												<form name="updatefinalrating" id="updatefinalrating" action="finalRatingService" method="post">
												<input type="hidden" name="id_course" id="id_course" value="" />
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
															<td><input type="input" name="" size="1" value="" /></td>
														</tr>
													</tbody>
												</table>
												<div id="ratingspag" class="pagination float-right">
														<a href="#">&lt;</a>
														<a class="active" href="#">1</a>
														<a href="#">&gt;</a>
													</div>

												<a class="button default" href="#" onClick="updateFinalRating();return false;"><span><span>Actualizar Calificaci&oacute;n</span></span></a>
												</form>
											</div>
										</div>
										
										<div class="block collapsible closed">
											<h3><span>Asistencia</span></h3>
											<div class="bcontent">
												<form name="assistanceupdate" id="assistanceupdate" action="updateAssistanceService" method="post" > 
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
															<!-- 
															<tr>
																<td>Student</td>
																<td>&nbsp;</td>
																<td>&nbsp;</td>
																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>
															-->
														</tbody>
													</table>
													<div id="assistancepag" class="pagination float-right">
														<a href="#">&lt;</a>
														<a class="active" href="#">1</a>
														<a href="#">&gt;</a>
													</div>
													<a class="button default" href="#" onClick="updateAssistance();return false;"><span><span>Actualizar Asistencia</span></span></a>
												</form>
											</div>
										</div>
										
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
															<th>Eliminar</th>
														</tr>
													</thead>
													<tbody id="documentlist">
														
													</tbody>
												</table>
												
												<div class="clear"></div>
												
												<form name="fileupload" id="fileupload" method="post" action="fileService">
													<input type="hidden" id="id_course" name="id_course" value=""/>
													
													<table width="100%">
														<tr>
															<td> Descripci&oacute;n:
																<input type="text" class="text half required" name="desc" />
 															</td>

															<td><span>Buscar: </span>
																<input type="file" class="required" name="archivo" />
															</td>
														</tr>
													</table>
												</form>
												<a class="button default" href="#" onClick="$('#fileupload').submit(); return false;"><span><span>A&ntilde;adir Archivo</span></span></a>
											</div>
										</div>
							</div>
							<div class="pane">
										<div class="block">
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
													<tbody id="horariosgeneraltable">
														<tr>
															<td><span>09:00 - 10:00</span></td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
	
														<tr>
															<td><span>10:00 - 11:00</span></td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
														<tr>
															<td><span>11:00 - 12:00</span></td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
														<tr>
															<td><span>12:00 - 13:00</span></td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										
							</div>
							
						</div>
					</div>
					  
                      <!-- CONTENT [end] -->
					  
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
						<textarea id="comment" name="com" class="textarea"/></textarea>
					</td>
				</tr>
			</table>
			<a class="button default" href="#" onClick="addComment(); return false;"><span><span>A&ntilde;adir Comentario</span></span></a>
			<a id="closecomment" class="button default" href="#" onClick="return false;"><span><span>Cancelar</span></span></a>
			</form>
		</div>
	</div>
	<!-- Comment on Rating [end] -->