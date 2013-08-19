$(document).ready(function(){

	// Validacion de formulario  de envio de datos
	var isValid = $('#newuserform').validate({
		rules:{
			pass2:{
				equalTo:"#pass"
			}
		}
	});

	// Activacion de datepicker para campo de fecha de nacimiento
	if($(".datepicker").length > 0){
		$( ".datepicker" ).datepicker({ 
			   	dateFormat: 'yy-mm-dd',
				yearRange: '1960:2005',
				changeMonth: true,
				 changeYear: true
		});
	}
	
	// Generacion de lista de tipos de usuario 
	if($("#usertype").length > 0){ 
		selectUserType(1);
	}
	if($("#usertype2").length > 0){ 
		selectUserType(2);
	}
	
	generateUsername();
	
	// Actualizar datos personales de usuario	
	
	showImageProfile();
	
	$('#form_upload_profile_pic').submit(function(){								 
		// first we have to validate the form before send it to php...
		if(!$('#form_upload_profile_pic').validate().form()){
			return false;
		}
		
		$(this).ajaxSubmit({
			success: response
		});
		return false;
	});
	
	function response(responseText, statusText, xhr, $form){
		if(responseText == 'success'){
			//changing the image
			showImageProfile();
			/**/
			$('#form_upload_profile_pic')[0].reset();
		}else
			alert(responseText);
	};
	
	
	$('#updatepersonaldata').submit(function(evento){
		evento.preventDefault();
		// Validar el formulario

		if(!$('#updatepersonaldata').validate().form()){
			showMessageTags('updatepersonalmsg', 'error', '<p>Error: Por favor llene los campos correctamente</p>');
			return false;
		}
		
		var url = $(this).attr('action');
		var datos = $(this).serialize();
	
		
		$.post(url, datos, function(response){
			//alert(response);
			if(response == 'true'){
				showMessageTags('updatepersonalmsg', 'success', '<p>Sus datos personales fueron actualizados correctamente</p>');
				getUserList();
			}else
				showMessageTags('updatepersonalmsg', 'error', '<p>Error: No se pudo actualizar los datos personales del usuario</p>');
		});
	});
	
	// Actualizar datos de usuario	
	$('#updateuserdata').submit(function(evento){
		evento.preventDefault();
		if(!$('#updateuserdata').validate().form()){
			showMessageTags('updateusermsg', 'error', '<p>Error: Por favor llene los campos correctamente</p>');
			return false;
		}
		
		var url = $(this).attr('action');
		var datos = $(this).serialize();
		
		$.post(url, datos, function(response){
			if(response == 'true'){
				showMessageTags('updateusermsg', 'success', '<p>Sus datos de usuario fueron actualizados correctamente</p>');
				//getUserList();
			}else
				showMessageTags('updateusermsg', 'error', '<p>Error: No se pudo actualizar los datos de usuario</p>');
		});
	});
	
	$('#updateuserdataG').submit(function(evento){
		evento.preventDefault();
		
		var url = $(this).attr('action');
		var datos = $(this).serialize();
		
		$.post(url, datos, function(response){
			if(response == 'true'){
				showMessageTags('updateusermsg', 'success', '<p>Sus datos de usuario fueron actualizados correctamente</p>');
			}else
				showMessageTags('updateusermsg', 'error', '<p>Error: No se pudo actualizar los datos de usuario</p>');
		});
	});

	// Establecer comportamiento de llamada en segundo plano para insertar nuevo usuario
	$("#newuserform").submit(function(evento){
		//Se previene comportamiento default
		evento.preventDefault();
		
		var res = ''; 
		
		if(!isValid.form()){
			showMessageTags('notifmsg', 'error', '<p>Por favor llene correctamente los campos en el formulario</p>');
			return false;
		}
		//Enviar datos y recuperar en segundo plano
		var url = $(this).attr('action');
		var datos = $(this).serialize();
		$.post(url, datos, function(respuesta){	
									alert(respuesta);
			if(respuesta == "true"){ 
				msg = '<p>Usuario fue dado de alta Satisfactoriamente</p>';
				res = 'success';
				// Si el usuario fue insertado se limpian los campos
				$('#newuserform')[0].reset();
				generateUsername();
			}else{
				msg = '<p>No se pudo registrar nuevo usuario, intente nuevamente o contacte al administrador</p>';
				res = 'error';
			}
			showMessageTags('notifmsg', res, msg);
		});
		return false;
	});

	$('#listausertab').click(function(){
		
		getUserList();
	});

});

function generateUsername(){
	/* se rellena el nombre de usuario  */
	var d = new Date();
	var h = d.getHours() < 10 ? ('0' + d.getHours()) : d.getHours();
	var m = d.getMinutes() < 10 ? ('0' + d.getMinutes()) : d.getMinutes();
	$('#user', '#newuserform').attr('value', 'w'+ d.getFullYear() + (d.getMonth() + 1) + d.getDate() + h + m );
}

function showImageProfile(){
	var hid_user = $('#hid', "#form_upload_profile_pic").attr('value');

	$.get("pic-profile.php?hid_user="+hid_user+"&have=0",function(data){
			var url_pic;
			var now = new Date();
			var time = now.getTime();
		
			if(data != "no-pic"){
				url_pic = "pic-profile.php?hid_user="+hid_user+"&have=1&time="+time;
				$(".profile-picture").empty();
				$(document.createElement("img"))
				    .attr({ src: url_pic, title: 'profile_picture',id:'profile_user_pic' })
					.load(function(){
						$(".profile-picture").append( $(this) );
					});
			}else{
				url_pic ="images/noimage.jpg";
				$("#profile_user_pic").attr("src",url_pic);
			}
		});
	
};


function showMessageTags(id, type, mensaje){
	
	$('#'+id).html(mensaje);
	$('#'+id).addClass(type);
	$("#"+id).removeClass('hidden');
	
	// Añade timeout para ocultar
	setTimeout(function(){
					$("#"+id).addClass('hidden');		// Se oculta el mensaje
					$("#"+id).removeClass(type);		// Se quita el tipo de mensaje
					$("#"+id).html('');					// Se limpia el contenido
				}, 3000);
}

/* Editar usuario */

function editar(r){
	//$('#updatepersonaldata"').f_lastname = "algo"; return;
	// Obtiene datos de usuario

	var hash = $.md5(r);
	$.post("datastores/admindata.php?q=userdata", { hid: hash } ,function(datos){
															
		var cad = "";
		
		$.each(datos, function(i , item){
			// personal data
			hid = item.hid;
			name = item.name;
			f_lastname = item.f_lastname;
			s_lastname = item.s_lastname;
			bday = item.bday;
			civil_status = item.civil_status;
			street = item.street;
			no_ext = item.no_ext;
			no_int = item.no_int;
			colonia = item.colonia;
			postalcode = item.postalcode;
			municipio = item.municipio;
			referencias = item.referencias;
			
			telmex = item.telmex;
			telcel = item.telcel;
			iusacell = item.iusacell;
			movistar = item.movistar;
			nextel = item.nextel;

			// userdata
			user = item.user;
			email = item.email;
			usertype = item.usertype;
		});
		
		// Coloca los datos en el form para pic profile
		$('#hid', "#form_upload_profile_pic").attr('value', hid);
		
		// Coloca los datos en el form para datos personales
		$('#hid', '#updatepersonaldata').attr('value', hid);
		$('#name', '#updatepersonaldata').attr('value', name);
		$('#f_lastname', '#updatepersonaldata').attr('value', f_lastname);
		$('#s_lastname', '#updatepersonaldata').attr('value', s_lastname);
		$('#bday', '#updatepersonaldata').attr('value', bday);		
		$('#street', '#updatepersonaldata').attr('value', street);
		$('#no_ext', '#updatepersonaldata').attr('value', no_ext);
		$('#no_int', '#updatepersonaldata').attr('value', no_int);
		$('#colonia', '#updatepersonaldata').attr('value', colonia);
		$('#postalcode', '#updatepersonaldata').attr('value', postalcode);
		$('#municipio', '#updatepersonaldata').attr('value', municipio);
		$('#referencias', '#updatepersonaldata').attr('value', referencias);
		
		$('#telmex', '#updatepersonaldata').attr('value', telmex);
		$('#telcel', '#updatepersonaldata').attr('value', telcel);
		$('#iusacell', '#updatepersonaldata').attr('value', iusacell);
		$('#movistar', '#updatepersonaldata').attr('value', movistar);
		$('#nextel', '#updatepersonaldata').attr('value', nextel);
		
		setTimeout('updateCivilStatus(civil_status)', 500);
		
		// Coloca los datos en el form para datos de usuario
		$('#hid','#updateuserdata').attr('value', hid);
		$('#user','#updateuserdata').attr('value', user);
		$('#email','#updateuserdata').attr('value', email);
		setTimeout('updateUsertypeSelect(usertype)', 500);
		
		/* Se da de alta todos los disparadors overlay
		$(".edituser_"+r).overlay({
			mask: '000',
			effect: 'default',
			target: '#mies1',
			load: true
		});*/
	}, 'json');
}

function updateUsertypeSelect(ut){
	$('#usertype option[value='+ut+']','#updateuserdata').attr('selected', 'selected');
}

function updateCivilStatus(cs){
	$('#civil_status option[value='+cs+']', '#updatepersonaldata').attr('selected', 'selected');
}

/* Elimina un usuario del sistema */ 
function eliminar(r){
	
	if(!confirm('Esta seguro que desea eliminar a este usuario?')){
		return false;
	}
	
	var username = $('#user_'+r);

	$.post("ServiceDelUser", { id: r , user: username.html() }, function(data){
		if(data == "true"){
			// Datos eliminados correctante
			showMessageTags('userlistmsg', 'success', '<p>Usuario eliminado correctamente</p>');
		}else{
			// No se pudo elminar usuario
			showMessageTags('userlistmsg', 'error', '<p>Error: No se pudo eliminar al usuario</p>');
		}
		// Refrescar lista de usuarios
		getUserList();
	});
}

/******** [ select  usertype BEGIN ] **********/
function showSelect(data){
	if($.isArray(data)){
		selectNode= $("#usertype").empty();
		var optionP="";
		var selectP="<select id='selusertype' name='usertype' class='select'>";
		$.each(data, function(i, item){
			optionP = optionP+"<option value='"+item.id+"'>"+item.description.toUpperCase()+"</option>";
		});
		selectP=selectP+optionP+"</select>";
		$(selectP).appendTo("#usertype");
		
		$("#selusertype").change(function(e){
			// Si la opcion es PROSPECTO hay que ocultar los campos de username y password
			if($('option:selected', this).attr('value') == 6){
				//$('#divuser').addClass('hidden');
				//$('#divpass').addClass('hidden');
				//$('#divpass2').addClass('hidden');
				// rellenamos el valor con el password por default
				$('#pass', '#newuserform').attr('value', 'default');
				$('#pass2', '#newuserform').attr('value', 'default');
			}else{
				//$('#divuser').removeClass('hidden');
				//$('#divpass').removeClass('hidden');
				//$('#divpass2').removeClass('hidden');
				// Limpiamos el valor del campo (por si fue seleccionado tipo de usuario PROSPECTO por eerror yposteriormente se volvio a cambiar el valor de este select
				$('#pass', '#newuserform').attr('value', '');
				$('#pass2', '#newuserform').attr('value', '');
			}
				
		});
		
	}else{ $(".error", selectNode).css("lineHeight", selectNode.height()+'px'); }
}

function showSelect2(data){
	//alert(data);
	if($.isArray(data)){
		selectNode= $("#usertype2").empty();
		var optionP="";
		var selectP="<select name='usertype' class='select' id='usertype' >";
		$.each(data, function(i, item){
			optionP = optionP+"<option value='"+item.id+"'>"+item.description.toUpperCase()+"</option>";
		});
		selectP=selectP+optionP+"</select>";
		$(selectP).appendTo("#usertype2");
		
	}else{ $(".error", selectNode).css("lineHeight", selectNode.height()+'px'); }
}

function selectUserType(box){
	switch(box){
		case 1 : 
		$.post("datastores/admindata.php?q=usertypes", showSelect, 'json');
		break;
		case 2 :
		$.post("datastores/admindata.php?q=usertypes", showSelect2, 'json');
		break;
	}
}
/******** [ select usertype END ] ************/

/******** [ select userlist BEGIN ] **********/
function showUserList(data){
	if($.isArray(data)){
		tableNode = $("#userlistbody").empty();
		var info='';

		$.each(data, function(i, item){
			//optionP = optionP+"<option value='"+item.id+"'>"+item.description.toUpperCase()+"</option>";
			
			var info = '<tr>';
				info += '<td class="small"><input type="checkbox" /></td>';
				info += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a class="edituser_'+item.id+'"  href="usuarios?ac=edit&id_user='+item.id+'">Editar</a></li><li><a id="deleteuser" href="#'+item.id+'" onclick="eliminar('+item.id+'); return false;">Eliminar</a></li>' + (item.nameTypeUser == 'prospecto' ? '<li><a id="signup" href="#'+item.id+'" onclick="inscribir('+item.id+'); return false;">Inscribir</a></li>' : '' ) + '</ul><div class="clear"></div><div class="foot"></div></div></td>';
				info += '<td class="odd gradeA">' + item.nameTypeUser + '</td>';
				info += '<td class="odd gradeA">' + item.name + '</td>';
				info += '<td class="odd gradeA">' + item.lastname + '</td>';
				info += '<td class="odd gradeA"><a href="mailto:' + item.email + '">' + item.email + '</a></td>';
				info += '</tr>';
					
			$("#userlistbody").append(info);
		});
		
		if($("#userlist").length > 0){
			$.rloader([
				{ type: 'css', src: 'modules/datatables/css/demo_table_jui.css' },
				{ type: 'js', src: 'modules/datatables/js/jquery.dataTables.js', callback: function(){
				$('#userlist').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
				} }
			]);
							
			/* === Tables javascripts [begin] === */
			/* optional menu in the table to each row */
			$("table td a.action").live("click", function(){
				var pos = $(this).position();
				$(this).addClass("active").next().css({top: pos.top + 24, left: pos.left}).show().find("li:last a").css("border-bottom", 0);
				return false;
			});
						
			$("table th a.action").live("click", function(){return false;});
											
			/* when you click to close the active optional menu and select box */
			$("body").click(function(event){
				$.each($("a.action.active"), function(){
					$(this).removeClass("active").next().hide();
				});
			});
											
			/* the effect of zebra */
			$("table.table tbody tr:odd").css({backgroundColor: "#fbfbfb"});
										
			/* Check all */
			$('input:checkbox.checkall').click(function() {
				$(this).parents('.table').find('input:checkbox').attr('checked', $(this).is(':checked')).parents("tr").each(function(){
					if($(this).find('input:checkbox').is(':checked')) $(this).addClass("selected");
					else $(this).removeClass("selected");
				});  
			});
												
			/* selection row with the active checkbox */
			$("table.table input:checkbox").change(function(){
				if($(this).is(':checked')) $(this).parents("tr").addClass("selected");
				else $(this).parents("tr").removeClass("selected");
			});
											
			/* === Tables javascripts [end] === */
		}
	
	}
}

function inscribir(id_user){
	/* Es necesario cambiar el estado del usuario de prospecto a estudiante */
	/* La contraseña utilizada en todos los casos es default */
	
	$.get('ServiceUpdateUser.php?action=inscribir&id=' + id_user, function(data){
		alert(data);
		getUserList();
	});
	
}

function getUserList(){
	$.post("datastores/admindata.php?q=userlist", showUserList, 'json');
}

/******** [ select userlist END ] **********/
