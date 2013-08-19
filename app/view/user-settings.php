	<!--  .BEGIN image profile -->
	<div class="block collapsible closed">
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
									<input type="hidden" id="hid" name="hid" value="<?php echo $_COOKIE['HID']; ?>"/>
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
	
	<!-- .BEGIN personal data -->
	<div class="block collapsible open">
			<h3><span>Datos Personales</span></h3>
				<div class="bcontent">
					<form id="updatepersonaldata" name="updatepersonaldata" action="ServiceUpdateUser" method="post" >
							<div  id="updatepersonalmsg" class="message hidden">
								<p>text</p>
							</div>
					<input type="hidden" name="hid" value="<?php echo $_COOKIE['HID']; ?>" />
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
								</tr>
								<tr>
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
								</tr>
								<tr>
									<td>
									<div class="line">
										<a href="#" id="updatepersonaldata" class="button" onClick="$('#updatepersonaldata').submit();return false;"><span><span>Actualizar Datos Personales</span></span>
										</a>
									</div>
								</td>
							</tr>
						</table>
					</form>
			</div>
	</div>
	<!-- password profile END. -->
	<!--  .BEGIN user data -->
	<div  id="updateusermsg" class="message hidden">
		<p>text</p>
	</div>
	<div class="block">
		<h3><span>Datos de usuario</span></h3>
		<div class="bcontent">
			<form id="updateuserdata" name="updateuserdata" action="ServiceUpdateUser" method="post" >
				<input type="hidden" id="hid" name="hid" value="<?php echo $_COOKIE['HID']; ?>" />
				<input type="hidden" id="usertype" name="usertype" value="" />
				<table width="100%">
					<tr>
						<td>
							<div class="line">
								  <label>Username:</label>
								  <input type="text" class="text" size="25" value="" name="user" id="user" disabled="disabled" />
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
						<td>
							<br />
							<div class="line">
								<a href="#" id="submitnewuser" class="button" onClick="$('#updateuserdata').submit();return false;"><span><span>Actualizar Datos Usuario</span></span>
								</a>
							</div>
						</td>
					</tr>
				</table>
			</form>
			
		</div>	 
	</div>
	<!-- user data END. -->
	
	