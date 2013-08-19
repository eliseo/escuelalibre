	<!--<div class="simple_overlay" id="mies1"> -->
		<script type="text/javascript">
		function getParameterByName( name )
		{
		  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		  var regexS = "[\\?&]"+name+"=([^&#]*)";
		  var regex = new RegExp( regexS );
		  var results = regex.exec( window.location.href );
		  if( results == null )
		    return "";
		  else
		    return decodeURIComponent(results[1].replace(/\+/g, " "));
		}
		
		var id_user = getParameterByName("id_user");
		editar(id_user);
		</script>
		                 <!--  breadcrumbs [begin] -->
	                      <div class="breadcrumb">
	                        <ul>
	                          <li><a href="#">Main</a></li>
	                          <li><a href="usuarios"> Usuarios</a></li>
							  <li> Usuario # <?php echo $_GET['id_user']; ?></li>
	                        </ul>
	                      </div>
	                      <!-- CONTENT [begin] -->
									<!--  .BEGIN image profile -->
									<div class="block uiPicEdit">
										<h3><span>Imagen del Perfil</span></h3>
										<table width="100%">
											<tr>
												<td>
													<div class="profile-picture">
														<img id="profile_user_pic" src="">
													</div>
												</td>
												<td>
													<div class="profile_pic_new">
														<div class="profile_pic_upload">
															<div id="profile_pic_form">
																Selecciona una imagen de tu computadora (10MB max)
																<form id="form_upload_profile_pic" enctype="multipart/form-data" method="post" action="controller/pic_upload.php">
																	<input type="hidden" id="hid" name="hid" value=""/>
																	<div class="pfileselector">
																		<input id="profile_picture_post_file" type="file" name="pic"  class="required"/>
																	</div>
																		<a href="#" id="submitnewpicprofile" class="button" onClick="$('#form_upload_profile_pic').submit(); return false;">
																		<span><span>Actualizar</span></span>
																		</a>
																</form>
															</div>
														</div>
													</div>
											
												</td>
											</tr>
										</table>
									</div>
									<!-- image profile END. -->
									
									
									<div  id="updatepersonalmsg" class="message hidden">
										<p>text</p>
									</div>
									
									<div class="block">
										<h3><span>Datos personales</span></h3>
										<div class="bcontent">
											<form id="updatepersonaldata" name="updatepersonaldata" class="form" method="post" action="ServiceUpdateUser">
												<input type="hidden" name="hid" id="hid" value="c9f0f895fb98ab9159f51fd0297e236d" />
												<table width="100%">
													<tr>
														<td>
															<div class="line">
																<label>Apellido Paterno:</label>
																<input type="text" class="text" size="25" value="" name="f_lastname" id="f_lastname" />
															</div>
														</td>
														<td>
															<div class="line">
																<label>Apellido Paterno:</label>
																<input type="text" class="text" size="25" value="" name="s_lastname" id="s_lastname"/>
															</div>
														</td>
														<td>
															<div class="line">
																<label>Nombre:</label>
																<input type="text" class="text" size="25" value="" name="name" id="name"/>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<div class="line">
																<label>Fecha de Nacimiento:</label>
																<input type="text" class="text datepicker" size="25" value="" name="bday" id="bday" />
															</div>
														</td>
														<td>
															<div class="line">
																<label>Estado Civil :</label>
																<select class="select" name="civil_status" id="civil_status">
																	<option value="1">Soltero</option>
																	<option value="2">Casado</option>
																	<option value="3">Divorciado</option>
																	<option value="4">No Especificado</option>
																</select>

															</div>
														</td>
														<td>
															<div class="line">
																<label>Calle:</label>
																<input type="text" class="text" size="25" value="" name="street" id="street"/>
															</div>
														</td>
														</tr><tr>
														<td>
															<div class="line">
																<label>Numero exterior:</label>
																<input type="text" class="text" size="25" value="" name="no_ext" id="no_ext"/>
															</div>
														</td>
														
														<td>
															<div class="line">
																<label>Numero interior:</label>
																<input type="text" class="text" size="25" value="" name="no_int" id="no_int"/>
															</div>
														</td>
														
														<td>
															<div class="line">
																<label>Colonia:</label>
																<input type="text" class="text" size="25" value="" name="colonia" id="colonia"/>
															</div>
														</td>
														</tr><tr>
														<td>
															<div class="line">
																<label>C&oacute;digo postal :</label>
																<input type="text" class="text" size="25" value="" name="postalcode" id="postalcode"/>
															</div>
														</td>
														
														<td>
															<div class="line">
																<label>Municipio:</label>
																<input type="text" class="text" size="25" value="" name="municipio" id="municipio"/>
															</div>
														</td>
														
														<td>
															<div class="line">
																<label>Referencias :</label>
																<input type="text" class="text" size="25" value="" name="referencias" id="referencias"/>
															</div>
														</td>
														</tr><tr>
													
														<td>
															<div class="line">
																  <label>Telmex:</label>
																  <input type="text" class="text" size="25" value="" name="telmex" id="telmex"/>
															</div>
														</td>
														
														<td>
															<div class="line">
																  <label>Telcel:</label>
																  <input type="text" class="text" size="25" value="" name="telcel" id="telcel"/>
															</div>
														</td>
														
														<td>
															<div class="line">
																  <label>Iusacell:</label>
																  <input type="text" class="text" size="25" value="" name="iusacell" id="iusacell"/>
															</div>
														</td>
														</tr><tr>
														<td>
															<div class="line">
																  <label>Movistar:</label>
																  <input type="text" class="text" size="25" value="" name="movistar" id="movistar"/>
															</div>
														</td>
														
														<td>
															<div class="line">
																  <label>Nextel:</label>
																  <input type="text" class="text" size="25" value="" name="nextel" id="nextel"/>
															</div>
														</td>

														<td>
															<br />
															<div class="line"> 
																<a href="#" id="submitnewuser" class="button" onClick="$('#updatepersonaldata').submit();return false;">
																<span><span>Actualizar</span></span>
																</a>
															</div>
														</td>
													</tr>
												</table>
											</form>
											<br />
										</div>
									</div>
									
									<div  id="updateusermsg" class="message hidden">
										<p>text</p>
									</div>
											
									<div class="block">
										<h3><span>Datos de usuario</span></h3>
										<div class="bcontent">
											<form id="updateuserdata" name="updateuserdata" action="ServiceUpdateUser" method="post" >
												<input type="hidden" id="hid" name="hid" value="c9f0f895fb98ab9159f51fd0297e236d" />
												<table width="100%">
													<tr>
														<td>
															<div class="line">
																  <label>Username:</label>
																  <input type="text" class="text" size="25" value="" name="user" id="user" readonly="readonly" />
															</div>
														</td>
														<td>
															<div class="line">
																  <label>Email:</label>
																  <input type="text" class="text" size="25" value="" name="email" id="email"/>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<div class="line">
																  <label>Password:</label>
																  <input type="text" class="text" size="25" value="" name="pass" id="pass" />
															</div>
														</td>
														<td>
															<div class="line">
																  <label>Again:</label>
																  <input type="text" class="text" size="25" value="" name="pass2" id="pass2"/>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															<div class="line">
																<label>Tipo de Usuario:</label>
																	<div id="usertype2"></div> 
															</div>
														</td>
														<td>
															<br />
															<div class="line">
																<a href="#" id="submitnewuser" class="button" onClick="$('#updateuserdata').submit();return false;"><span><span>Actualizar</span></span>
																</a>
															</div>
														</td>
													</tr>
												</table>
											</form>
											
										</div>	 
									</div>
									<div class="block">
										<h3><span>Datos de Geoposicionamiento</span></h3>
										<div class="bcontent">
											<form id="updateuserdataG" name="updateuserdata" action="ServiceUpdateUser" method="post" >
												<table width="100%">
													<!-- .BEGIN code for geodata -->
													<?php
														global $ndb;
														$id_user = $_GET['id_user'];
														$query="SELECT * FROM geodata WHERE id_user='$id_user'";
														if(!($ndb->query($query))){
															 $message = "No hay datos de georeferencia para este usuario"; 
													?>
													<tr><td colspan="2" style="text-align:center;"><?php echo $message; ?><br/>
														Desea Habilitar? <input type='checkbox' name='usemap' value='1'></td></tr>
													<?php } ?>
													<tr>
														<td><div id="edit_map_2" style="width: 448px; height: 350px; margin:0px auto;"></div></td>
														<td>
															<a href="#" id="submitnewuser" class="button" onClick="$('#updateuserdataG').submit();return false;"><span><span>Actualizar</span></span>
																</a>
														</td>
													</tr>
													<script src='http://maps.google.com/maps/api/js?sensor=false' type='text/javascript'></script>
													<script type='text/javascript' src='gm2.js'></script>
													
													<!-- code for geodata END.-->
												</table>
											</form>
										</div>
									</div>
									
	
	<!-- </div> -->			  
	
	<!-- Overlay [end] -->