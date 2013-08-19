// JavaScript Document
/* Clase manejadora de mensajes */
function MsgManager(hid){

	// private properties
	this.hid = hid;
	var newMsg = '';
	var messages = new Array(); 			// Guarda todos los mensajes
	var sent = new Array();
	var draft = new Array();
	var observers = new Array();
	var senders = new Array();				// Guarda todos los posibles destinatarios
	var top = 0;
	var topsent = 0;
	var topdraft = 0;
	var topobserver = 0;
	var myTable;
	var sendersLoaded = false;
	var relatedMessages;
	
	$.rloader([
			{ type: 'css', src: 'modules/datatables/css/demo_table_jui.css' },
			{ type: 'js', src: 'modules/datatables/js/jquery.dataTables.js', callback: function(){
			myTable = $('#messagelist').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"iDisplayLength" : 5
			});
		} }
	]);
	
	// public elements
	return {
		/* obtiene el hid del destinatario */
		getSenderHID: function(name){
			for(var i in senders){
				if(senders[i].sender == name){
					return senders[i].hid;
				}
			}
			return null;
		},
		
		/* obtiene todos los posibles destinatarios */
		getMySenders: function(){
			var data = new Array();

			for(var i in senders){
				data[i] = senders[i].sender;
			}
			return data;
		},
		
		/* Devuelve un array de objetos (hid, sendername) para destinatarios */
		loadMySenders: function(){
			$.get('datastores/messageservice.php?q=senders', function(response){
				$.each(response, function(i, item){
					senders.push(item);
				});
				sendersLoaded = true;
			}, 'json');
		},
		
		/* Devuelve un objeto con toda la información del mensaje */
		getMsg: function(idmsg){
			var msgs = new Array();
			for(var i = messages.length -1 ; i >= 0; i-- ){
				if(idmsg == messages[i].idmsg){
					return messages[i];
				}
			}
			return false;
		},
		
		/* Devuelve un objeto con toda la información del mensaje enviado */
		getObserverMsg: function(idmsg){
			for(var i = observers.length -1 ; i >= 0; i-- ){
				if(idmsg == observers[i].idmsg){
					return observers[i];
				}
			}
			return false;
		},
		
		/* Devuelve un objeto con toda la información del mensaje enviado */
		getSentMsg: function(idmsg){
			for(var i = sent.length -1 ; i >= 0; i-- ){
				if(idmsg == sent[i].idmsg){
					return sent[i];
				}
			}
			return false;
		},
		
		/* Devuelve un objeto con toda la información del mensaje guardado */
		getDraftMsg: function(idmsg){
			for(var i = draft.length -1 ; i >= 0; i-- ){
				if(idmsg == draft[i].idmsg){
					return draft[i];
				}
			}
			return false;
		},
		
		/* funcion para obtener los mensajes guardados */
		getObservables: function(){
			
			/* Calculando desde que punto se van a actualizar los mensajes */
			if(observers.length > 0){
				from = '&update=' + observers[topobserver].idmsg;
			}else{
				from = '';
			}
			$.get('datastores/messageservice.php?type=4&q=get'+from, function(response){
				if(response==null) return;
				nuevos= false;
				$.each(response, function(i, item){
					if( topobserver == 0 || item.idmsg > observers[topobserver].idmsg ){
						observers.push(item);
						nuevos = true;
					}
				});
				
				/* rellenar la tabla de mensajes solo 1 vez */
				if(observers.length > 0 && nuevos){
					var messagelistbody = $('#messagelistbody');
					messagelistbodycontent = '';

					for(var i = 0 ; i < observers.length  ; i++ ){

						if(observers.length > 0 && parseInt(observers[i].idmsg) < parseInt(observers[topobserver].idmsg) ) continue;

						// Se agrega el nuevo valor a la tabla 
						idx = myTable.fnAddData([
							'<input type="checkbox" />',
							'<a class="action" href="#"></a><div class="opmenu"><ul><li><a href="#">Leer</a></li><li><a href="#">Eliminar</a></li></ul><div class="clear"></div><div class="foot"></div></div>',
							observers[i].sender,
							'<a href="#detalle" onclick="readObserverMsg(' + observers[i].idmsg + ');">' + observers[i].subject + '</a>',
							observers[i].send_date
						]);
					}

					// Los nuevos valores se ordenan por fecha-hora
					myTable.fnSort([[4,'desc']]);					
				}
				
				topobserver = observers.length-1;
				
			}, 'json');
			
		},
		
		/* funcion para obtener los mensajes guardados */
		getDraft: function(){
			
			/* Calculando desde que punto se van a actualizar los mensajes */
			if(draft.length > 0){
				from = '&update=' + draft[topdraft].idmsg;
			}else{
				from = '';
			}
			$.get('datastores/messageservice.php?type=3&q=get'+from, function(response){
				if(response==null) return;
				nuevos= false;
				$.each(response, function(i, item){
					if( topdraft == 0 || item.idmsg > draft[topdraft].idmsg ){
						draft.push(item);
						nuevos = true;
					}
				});
				
				/* rellenar la tabla de mensajes solo 1 vez */
				if(draft.length > 0 && nuevos){
					var messagelistbody = $('#messagelistbody');
					messagelistbodycontent = '';

					for(var i = 0 ; i < draft.length  ; i++ ){

						if(draft.length > 0 && parseInt(draft[i].idmsg) < parseInt(draft[topdraft].idmsg) ) continue;

						// Se agrega el nuevo valor a la tabla 
						idx = myTable.fnAddData([
							'<input type="checkbox" />',
							'<a class="action" href="#"></a><div class="opmenu"><ul><li><a href="#">Leer</a></li><li><a href="#">Eliminar</a></li></ul><div class="clear"></div><div class="foot"></div></div>',
							draft[i].sender,
							'<a href="#" onclick="editDraft(' + draft[i].idmsg + '); return false;">' + draft[i].subject + '</a>',
							draft[i].send_date
						]);
					}

					// Los nuevos valores se ordenan por fecha-hora
					myTable.fnSort([[4,'desc']]);					
				}
				
				topdraft = draft.length-1;
				
			}, 'json');
			
		},
		/* funcion para obtener los mensajes enviados */
		getSent: function(){
			
			/* Calculando desde que punto se van a actualizar los mensajes */
			if(sent.length > 0){
				from = '&update=' + sent[topsent].idmsg;
			}else{
				from = '';
			}
			$.get('datastores/messageservice.php?type=2&q=get' + from, function(response){
				if(response==null) return;
				nuevos= false;
				$.each(response, function(i, item){
					if( topsent == 0 || item.idmsg > sent[topsent].idmsg ){
						sent.push(item);
						nuevos = true;
					}
				});
				
				/* rellenar la tabla de mensajes solo 1 vez */
				if(sent.length > 0 && nuevos){
					var messagelistbody = $('#messagelistbody');
					messagelistbodycontent = '';
					
					for(var i = 0 ; i < sent.length  ; i++ ){

						if(sent.length > 0 && parseInt(sent[i].idmsg) < parseInt(sent[topsent].idmsg) ) continue;

						// Se agrega el nuevo valor a la tabla 
						idx = myTable.fnAddData([
							'<input type="checkbox" />',
							'<a class="action" href="#"></a><div class="opmenu"><ul><li><a href="#">Leer</a></li><li><a href="#">Eliminar</a></li></ul><div class="clear"></div><div class="foot"></div></div>',
							sent[i].sender,
							'<a href="#detalle" onclick="readSentMsg(' + sent[i].idmsg + ', ' + i + ');">' + sent[i].subject + '</a>',
							sent[i].send_date
						]);
					}

					// Los nuevos valores se ordenan por fecha-hora
					myTable.fnSort([[4,'desc']]);					
				}

				topsent = sent.length-1;

			}, 'json');
			
		},
		
		/* Funcion para obtener todos los mensajes iniciales */
		getMessages: function(){
			
			/* Calculando desde que punto se van a actualizar los mensajes */
			if(messages.length > 0){
				from = '&update=' + messages[top].idmsg;
			}else{
				from = '';
			}
			
			$.get('datastores/messageservice.php?type=1&q=get'+from, function(response){
				if(response==null) return;
				
				nuevos= false;
				$.each(response, function(i, item){
					if( top == 0 || item.idmsg > messages[top].idmsg ){
						messages[i] = item;
						nuevos = true;
					}
				});
				
				/* rellenar la tabla de mensajes solo 1 vez */
				if(messages.length > 0 && nuevos){
					var messagelistbody = $('#messagelistbody');
					messagelistbodycontent = '';
					//for(var i = messages.length - 1 ; i >= 0 ; i-- ){
					for(var i = 0 ; i < messages.length  ; i++ ){
//						alert(messages[i].idmsg + ' - ' + messages[top].idmsg );
						if(messages.length > 0 && parseInt(messages[i].idmsg) < parseInt(messages[top].idmsg) ) continue;

						// Se agrega el nuevo valor a la tabla 
						idx = myTable.fnAddData([
							'<input type="checkbox" />',
							'<a class="action" href="#"></a><div class="opmenu"><ul><li><a href="#">Leer</a></li><li><a href="#">Eliminar</a></li></ul><div class="clear"></div><div class="foot"></div></div>',
							messages[i].sender,
							'<a href="#detalle" onclick="readMsg(' + messages[i].idmsg + ', ' + i + ');">' + messages[i].subject + '</a>',
							messages[i].send_date
						]);

						// pintando el color de la fila
						curtr = myTable.fnGetNodes(idx);
						
						// aplica css a la fila
						$(curtr).addClass('even');
						if(messages[i].read_date == null){
							$(curtr).addClass('gradeA');
						}
						//myTable.fnDraw();
					}

					// Los nuevos valores se ordenan por fecha-hora
					myTable.fnSort([[4,'desc']]);					
				}
				
				top = messages.length-1;
				
			}, 'json');
			
		},
		
		newMsgExists: function(){
			$.get('datastores/messageservice.php?q=nuevos', function(response){
				if(!isNaN(response))
					newMsg = response;
				else 
					newMsg = 0;
			});
		},
		
		/* Pinta elementos en la interfaz */
		repaint: function(){
			/*Cantidad de mensajes nuevos en los elementos de top-nav.php */
			$('#numMsgCount').html(newMsg);
		},
		
		setRowClass: function(numrow, cclass, oper){
			curtr = myTable.fnGetNodes(numrow-1);
			// aplica css a la fila
			if(oper)
				$(curtr).addClass(cclass);
			else
				$(curtr).removeClass(cclass);
				
			$(curtr).addClass('even');
		},
		
		clearTable: function(){
			myTable.fnClearTable();
			top = 0;
			messages = new Array();
			topsent = 0;
			sent = new Array();
			topdraft = 0;
			draft = new Array();
			topobserver = 0;
			observers = new Array();
		}
	};
}

function getMessages(){
	$.get('datastores/messageservice.php?q=get', function(response){});
}

/* funcion para leer el valor de la cookie especificada */
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function editDraft(idmsg){
	msg = my.getDraftMsg(idmsg);
	
	//alert(msg.idmsg);
	if(msg==false) return;
	
	/* Llenar los campos */
	$('#idmsg','#messagesendform').attr('value', msg.idmsg);
	$('#toresp','#messagesendform').attr('value', msg.sender);
	$('#subjectresp','#messagesendform').attr('value', msg.subject);
	$('#messageresp','#messagesendform').val(msg.message);
	$('#hidresp','#messagesendform').attr('value', msg.hid_recipient);
	$('#ticketresp','#messagesendform').attr('value', msg.ticket);
	$('#hiddenresp','#messagesendform').attr('checked', msg.hidden == 1 ? true : false );
	
	/* Despliega overlay de formulario de envío */
	ol = $('.trigger').overlay({
			mask: '000',
			effect: 'default',
			target: '#mies1',
			load: true,
			close: '#closeol'
	});	
	if(!ol.isOpened())
		ol.load();
}

function readObserverMsg(idmsg){
	/* Ocultamos Responder si es que ha sido desplegado */
	hide(1);
	/* Obtener los datos */
	msg = my.getObserverMsg(idmsg);
	
	if(msg==false) return;
	
	$('#msgfrom').html('<em class="line">' + msg.sender + '</em>');
	$('#msgto').html('<em class="line">' + msg.recipient + '</em>');
	$('#msgsubject').html('<em class="line"> ' + msg.subject + '</em>');
	$('#msgsenddate').html('<em class="line"> ' + msg.send_date + '</em>');
	$('#msgmessage').html('<div">' + msg.message + '</div>');
	
	
	/* Rellenar campos para responder */
	$('#idmsg').attr('value', '');
	$('#hidresp').attr('value', msg.hid_sender);
	$('#ticketresp').attr('value', msg.ticket);
	$('#subjectresp').attr('value', 'RE: ' + msg.subject);
}

function readSentMsg(idmsg){
	/* Ocultamos Responder si es que ha sido desplegado */
	hide(1); hide(2);
	/* Obtener los datos */
	msg = my.getSentMsg(idmsg);
	
	if(msg==false) return;
	
	$('#msgfrom').html('<em class="line">' + msg.sender + '</em>');
	$('#msgsubject').html('<em class="line"> ' + msg.subject + '</em>');
	$('#msgsenddate').html('<em class="line"> ' + msg.send_date + '</em>');
	$('#msgmessage').html('<div">' + msg.message + '</div>');	
}

function readMsg(idmsg, reftr){
	/* Ocultamos Responder si es que ha sido desplegado */
	hide(1); hide(2);
	/* Obtener los datos */
	msg = my.getMsg(idmsg);
	
	if(msg==false) return;
	
	$('#msgfrom').html('<em class="line">' + msg.sender + '</em>');
	$('#msgsubject').html('<em class="line"> ' + msg.subject + '</em>');
	$('#msgsenddate').html('<em class="line"> ' + msg.send_date + '</em>');
	$('#msgmessage').html('<div">' + msg.message + '</div>');
	
	$.get('datastores/messageservice.php?q=related&ticket='+msg.ticket+'&idmsg='+msg.idmsg, function(response){

		relatedMessages = new Array();

		$.each(response, function(i, item){
			relatedMessages[i] = item;
		});

		/* Pintar la secuencia de mensajes relacionados */
		msgdetail = $('#msgdetaillist').empty();
		
		tabla = $('<table width="700px"></table>');

		for(var i = relatedMessages.length -1 ; i >= 0 ; i-- ){

			if(relatedMessages[i].id == msg.idmsg) continue; 
			
			if(i%2==0)
				cclass = "#eee";
			else
				cclass = '';
				
			tr = $('<tr style="background-color: '+cclass+'"></tr>');
			
			td1 = $('<td></td>');

			msgdetailfrom = $('<div>'+relatedMessages[i].sender+'<span> dice: </span></div>');
			
			td1.append(msgdetailfrom);

			msgdetailsenddate= $('<div></div>');
			msgdetailsenddate.append(relatedMessages[i].send_date);
			
			td2 = $('<td></td>');
			td2.append(msgdetailsenddate);

			msgdetailmessage = $('<div></div>');
			msgdetailmessage.append(relatedMessages[i].message);
			
			td3 = $('<td></td>');
			td3.append(msgdetailmessage);
			
			tr.append(td1);
			tr.append(td2);
			tr.append(td3);
			
			tabla.append(tr);
		}
		
		msgdetail.append(tabla);

	}, 'json');
	
	/* Rellenar campos para responder */
	$('#idmsg').attr('value', '');
	$('#hidresp').attr('value', msg.hid_sender);
	$('#ticketresp').attr('value', msg.ticket);
	$('#subjectresp').attr('value', 'RE: ' + msg.subject);
	
	
	/* Marcar email como leido en la base de datos*/
	$.get('messageService.php?idmsgread='+idmsg, function(response){ return ; });
	/* Pintar la fila como leida */
	my.setRowClass(reftr, 'gradeA', false);
			
}
		
function showResponder(){
	$('#responderForm').removeClass('hidden');
}

function hide(envio){
	cleanData();
	if(envio==1)
		$('#responderForm').addClass('hidden');
	if(envio==2){
		$('#sendForm').addClass('hidden');
	}
}

function showSendForm(){
	/* Despliega overlay de formulario de envío */
	var ol = $('.trigger').overlay({
			mask: '000',
			effect: 'default',
			target: '#mies1',
			load: true,
			close: '#closeol'
	});	
	if(!ol.isOpened())
		ol.load();
}

function save(envio){
	send(envio, true);
}
		
function send(envio, save){
	/* Envía un nuevo mensaje en respuesta a uno previo */
	ticketresp = '';
	var myRespForm;
	if(envio == 1){
		myRespForm = '#messagerespform';
		ticketresp = $('#ticketresp').attr('value');
	}else if(envio == 2){
		myRespForm = '#messagesendform';
	}

	if(!$(myRespForm).validate().form()){
		alert('Rellene TODOS los campos del formulario de respuesta correctamente');
		return false;
	}
	/* si va para draft */
	if(save)
		s = 1;
	else
		s = 0;
	/* es oculto */
	if($('#hiddenresp', myRespForm).attr('checked')){
		h = 1;	
	}else
		h = 0;
	
	var url = $(myRespForm).attr('action');
	var datos = {
					idmsg: $('#idmsg').attr('value'),
					hid_recipient: $('#hidresp', myRespForm).attr('value'),
					subject: $('#subjectresp', myRespForm).attr('value'),
					message: $('#messageresp', myRespForm).val(),
					ticket: ticketresp,
					save: s,
					hidden: h
				}
	
	$.post(url, datos, function(res){
		showMessageTags('messageformnotif','success', '<p>Mensaje enviado</p>');
		showMessageTags('sendmessageformnotif','success', '<p>Mensaje enviado</p>');
		cleanData();
		setTimeout('hide(1);hide(2);', 1000); // ocultar respuesta
		setTimeout('$(\'#closeol\').click()',1000);
		my.clearTable();
	});
}

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

function cleanData(){
	$('#msgdetaillist').empty();
	$('#messagesendform')[0].reset();
	$('#messagerespform')[0].reset();
	
	$('#msgfrom').html('');
	$('#msgsubject').html('');
	$('#msgsenddate').html('');
	$('#msgmessage').html('');
}