<!--  breadcrumbs [begin] -->
  <div class="breadcrumb">
         <ul>
               <li><a href="#">Main</a></li>
                <li> Usuarios</li>
           </ul>
   </div>
 <!-- CONTENT [begin] -->
<!-- .begin AREA DE TABS -->					  
<div class="areatabs">
	<ul class="tabs">
		<li class="current"><a id="addusertab" href="#">Añadir Usuario</a></li>
		<li><a id="listausertab" href="#">Usuarios registrados</a></li>
	</ul>
	<div class="panes">
		<div class="pane visible">
			
				<!-- NOTIFICACION -->
			  
			  <!--  Form examples [begin] -->
			   <form id="newuserform" name="newuserform" class="form" method="post" action="ServiceAddUser">
			  <table style="width: 100%;">
				<tr>
					<td>
						<div class="line">
						<label>Apellido Paterno:</label>
						<input type="text" class="text" size="25" value="" name="f_lastname" />
						</div>
					</td>
				  <td>
					<div class="line">
						<label>Apellido Materno:</label>
						<input type="text" class="text" size="25" value="" name="s_lastname" />
					</div>
				</td>
				</tr>
				<tr>
				  <td>
					<div class="line">
						<label>Nombre(s):</label>
						<input type="text" class="text required" size="25" value="" name="name" />
					</div>
				  </td>
				  <td>
					<div class="line">
						<label>Fecha de Nacimiento:</label>
						<input type="text" class="text datepicker" size="25" value="" name="bday" />
					</div>
				</td>
				  <td>
				  <div class="line">
				  <label>Estado Civil :</label>
				  <select class="select" name="civil_status">
					<option value="1">Soltero</option>
					<option value="2">Casado</option>
					<option value="3">Divorciado</option>
					<option value="4">No Especificado</option>
				  </select>
				</div>
				  </td>
				</tr> 
				<tr>
				  <td> <div class="line">
				  <label>Calle:</label>
				  <input type="text" class="text" size="25" value="" name="street" />
				</div></td>
				
				<td> <div class="line">
				<label>Numero exterior:</label>
				<input type="text" class="text" size="25" value="" name="no_ext" />
				</div></td>
			</tr><tr>
				<td> <div class="line">
				<label>Numero interior:</label>
				<input type="text" class="text" size="25" value="" name="no_int" />
				</div></td>
				
				<td> <div class="line">
				  <label>Colonia:</label>
				  <input type="text" class="text" size="25" value="" name="colonia" />
				</div></td>
			</tr><tr>
				<td> <div class="line">
				  <label>Código Postal:</label>
				  <input type="text" class="text" size="25" value="" name="postalcode" />
				</div></td>
				
				<td> <div class="line">
				  <label>Municipio:</label>
				  <input type="text" class="text" size="25" value="" name="municipio" />
				</div></td>
			</tr><tr>
				<td> <div class="line">
				  <label>Referencias:</label>
				  <input type="text" class="text" size="25" value="" name="referencias" />
				</div></td>
				
				  <td>
				   <div class="line">
				  <label>Telmex:</label>
				  <input type="text" class="text" size="25" value="" name="telmex" />
				</div>
				  </td>
			 </tr><tr>
				  <td>
				   <div class="line">
				  <label>Telcel:</label>
				  <input type="text" class="text" size="25" value="" name="telcel" />
				</div>
				  </td>
				  
				  <td>
				   <div class="line">
				  <label>Iusacell:</label>
				  <input type="text" class="text" size="25" value="" name="iusacell" />
				</div>
				  </td>
			</tr><tr>	  
				  <td>
				   <div class="line">
				  <label>Movistar:</label>
				  <input type="text" class="text" size="25" value="" name="movistar" />
				</div>
				  </td>
				  
				  <td>
				   <div class="line">
				  <label>Nextel:</label>
				  <input type="text" class="text" size="25" value="" name="nextel" />
				</div>
				  </td>
				</tr>
				<tr>
				  <td> 
				  <div class="line">
				  <label>Email:</label>
				  <input type="text" class="text required" size="25" value="" name="email" />
				</div>
				</td>
				  <td>
				  <div id="divuser" class="line">
				  <label>Usuario:</label>
				  <input type="text" class="text required" size="25" value="" name="user" id="user" readonly="readonly" />
				</div>
				  </td>
				</tr>
				<tr>
				  <td>
				  <div id="divpass" class="line">
				  <label>Contraseña:</label>
				  <input type="password" class="text required" size="25" value="" name="pass" id="pass" />
				</div>
				  </td>
				  <td>
				  <div id="divpass2" class="line">
				  <label>Confirma Contraseña:</label>
				  <input type="password" class="text required" size="25" value="" name="pass2" id="pass2" />
				</div>
				  </td>
				  <td>
				  <div class="line">
				  <label>Tipo de Usuario:</label>
					  <div id="usertype"></div>
				</div></td>
				  <td></td>
				</tr>
				<tr>
					<td colspan="3">
					<!-- .begin code for maps -->
						<input type="checkbox" name="usemap" value="1"/>
						<label for="usemap">Desea Añadir Datos de Geoposición? </label> 
						<div id="edit_map" style="width: 520px; height: 350px;">Añadir Mapa</div>
						<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false" ></script>
						<script type="text/javascript" src="gm1.js"></script>
						
					<!-- cod for maps end. -->
					</td>
				</tr>
				
			  </table>
			<br />
			
			<div  id="notifmsg" class="message hidden">
					<p>text</p>
			</div>
			
		  <div class="line"> <a href="#" id="submitnewuser" class="button" onClick="$('#newuserform').submit();return false;"><span><span>Agregar Usuario</span></span></a> <a href="#" class="button white" onClick="$('#newuserform')[0].reset();return false;"><span><span>Limpiar Formulario</span></span></a> </div>
			  </form>


		</div>
		<div class="pane">
					<div id="userlistmsg" class="message hidden">
						<p>text</p>
					</div>
					<!-- table [end] -->
					<table id="userlist" class="table">
					    <thead>
					        <tr>
					            <th class="small"><input type="checkbox" class="checkall" /></th>
					            <th class="small"><a class="action" href="#"></a></th>
					            <th>Tipo</th>
					            <th>Nombre</th>
					            <th>Apellidos</th>
					            <th>E-mail</th>
					        </tr>
					    </thead>
					    <tbody id="userlistbody">
						</tbody>
					</table>
					<!-- table [end] -->
					<div class="clearfix"></div>
					<!-- table, pagination [end] -->
		</div>
	</div>
</div>
<!-- AREA DE TABS [end.]-->