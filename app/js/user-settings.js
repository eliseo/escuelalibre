$(document).ready(function(){

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
	
	getUserData();
	
	//Update personal Data
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
				 // getUserList();
			}else
				showMessageTags('updatepersonalmsg', 'error', '<p>Error: No se pudo actualizar los datos personales del usuario</p>');
		});
	});
	
	
	// Update User Data
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
		
});


function showImageProfile(){
	var hid_user = readCookie("HID");
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

function createCookie(name, value, days) {
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                var expires = "; expires=" + date.toGMTString();
            }
            else var expires = "";

            var fixedName = '<%= Request["formName"] %>';
            name = fixedName + name;

            document.cookie = name + "=" + value + expires + "; path=/";
        };

function readCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
};

function eraseCookie(name) {
            createCookie(name, "", -1);
};


function getUserData(){
		$.getJSON("datastores/userdata.php?q=userdata",function(datos){
			
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

					// Coloca los datos en el form para datos personales
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
					$('#user','#updateuserdata').attr('value', user);
					$('#email','#updateuserdata').attr('value', email);
					$('#usertype',"#updateuserdata").attr('value',usertype);			
		});
};


function updateCivilStatus(cs){
	$('#civil_status option[value='+cs+']', '#updatepersonaldata').attr('selected', 'selected');
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
};



