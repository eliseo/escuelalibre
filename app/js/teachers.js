$(document).ready(function(){

	/// Se cargan los cursos relacionados con el profesor
	cargarClases();
	cargarHorarioGeneral();
	// Configuración para envio de archivos
	var options = {
		success: response
	};
	
	$('#fileupload').submit(function(){
									 
		// first we have to validate the form before send it to php...
		if(!$('#fileupload').validate().form()){
			return false;
		}
		
		$(this).ajaxSubmit(options);
		return false;
	});
});

function response(responseText, statusText, xhr, $form){
	alert(responseText);
	if(responseText != 'false'){
		cargarListaDocumentos(responseText);
		$('#fileupload')[0].reset();
	}else
		alert('fail');
}

function getDocument(id_doc){
	window.open('fileService?id_doc='+id_doc+'&action=get', 'getDocument', '');
}

function eliminarDocumento( id_doc, id_course ){
	$.post('fileService', {deleteId: id_doc}, function(response){
		//alert(response);
		cargarListaDocumentos(id_course);
	});
}

function cargarListaDocumentos(id_course){
	$('#id_course', '#fileupload').attr('value', id_course);
	$.post('datastores/teacherdata.php?q=listamateriales&id_course='+id_course, function(response){
																						 
		if(response == null)
			return;
			
		var documentslistbody = '';
		
		$.each(response, function(i,item){

			documentslistbody += '<tr id="'+item.id+'">';
			documentslistbody += '<td class="small"><input type="checkbox"/></td>';
			documentslistbody += '<td>' + item.name + '</td>';
			documentslistbody += '<td>' + item.desc + '</td>';
			documentslistbody += '<td>' + item.modif_date + '</td>';
			documentslistbody += '<td><a href="#" onclick="getDocument('+item.id+');return false;">Descargar</a></td>';
			documentslistbody += '<td><a href="#" onclick="eliminarDocumento('+item.id+','+id_course+'); return false;">Eliminar</a></td>';
			documentslistbody += '</tr>';
		});

		$(documentslistbody).appendTo($('#documentlist').empty());
		
	}, 'json');
	
}

function verDetalle(ref){
	
	// Se limpian los campos 
	clearObserverPanel();
		
	// Se cancela el comportamiento predeterminado del hipervínculo
		// Se obtiene el id de la clase 
		var id_course = $(ref).attr('rel');
		
		// ---------- Obtiene los horarios
		$.post('datastores/teacherdata.php?q=horarios&id_course=' + id_course, function(response){
			//alert(response);
			var schedulecoursetable = $('#schedulecoursetable').empty();
			var schedulecoursetablecontent = '';
			
			$.each(response, function(i, item){
				schedulecoursetablecontent += '<tr>';
				schedulecoursetablecontent += '<td>' + item.horario + '</td>';
				schedulecoursetablecontent += '<td>' + (item.lunes != 0 ? '<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
				schedulecoursetablecontent += '<td>' + (item.martes != 0 ? '<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
				schedulecoursetablecontent += '<td>' + (item.miercoles != 0 ? '<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
				schedulecoursetablecontent += '<td>' + (item.jueves != 0 ? '<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
				schedulecoursetablecontent += '<td>' + (item.viernes != 0 ? '<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
				schedulecoursetablecontent += '<td>' + (item.sabado != 0 ? '<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
				schedulecoursetablecontent += '<td>' + (item.domingo != 0 ? '<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
				schedulecoursetablecontent += '</tr>';
			});

			$(schedulecoursetablecontent).appendTo(schedulecoursetable);
			
		}, 'json');
		
		/// --------- Obtiene los alumnos
		$.post('datastores/teacherdata.php?q=alumnos&id_course=' + id_course , function(response){

			if(response == null || response.students == null || response.evals == null ){
				desplegar(false);
				return ;
			}
			
			students = response.students;
			evaluations = response.evals;
			
			var classmatestable = $('#classmatestable').empty();
			var classmatestablecontent = '';
			
			//making header
			var classmatestableheader = '<tr><th class="small"><input type="checkbox" class="checkall" /></th>';
			classmatestableheader += '<th class="small"><a class="action" href="#"></a></th>';
			classmatestableheader += '<th>Apellido</th>';
			classmatestableheader += '<th>Nombre</th>';
			classmatestableheader += '<th>E-mail</th>';
			classmatestableheader += '</tr>';

			for(var std = 0 ; std < students.length; std++ ){
				// making content
				
				classmatestablecontent += '<tr>';
				classmatestablecontent += '<input type="hidden" name="id_course" value="'+ id_course +'" />';
				classmatestablecontent += '<td class="small"><input type="checkbox" /></td>';
				classmatestablecontent += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a href="#">Calificaci&oacute;n</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>';
				classmatestablecontent += '<td>' + students[std].f_lastname + ' ' + students[std].s_lastname + '</td>';
				classmatestablecontent += '<td>' + students[std].name + '</td>';
				classmatestablecontent += '<td><a href="mailto:'+students[std].email+'">'+students[std].email+'</a></td>';
				classmatestablecontent += '</tr>';
			}
			
			// add header
			header = $('#classmatestableheader').empty();
			$(classmatestableheader).appendTo(header);
			// add content
			$(classmatestablecontent).appendTo(classmatestable);
			// Visualiza tabla de calificaciones [start]
			cargarCalificaciones(id_course, 1);
			// Visualiza tabla de calificaciones [end] 
			
		}, 'json');
		
		/// --------- Obtiene las asistencias
		var assistancetablecontent = '';
		$.post('datastores/teacherdata.php?q=asistencia&id_course=' + id_course , function(ds){
																						   
			if(ds == null || ds.fechas == null || ds.alumnos == null || ds.asistencias == null || ds.resumen_asistencias == null){
				desplegar(false);
				return;
			}
			
			assistance_dates =  ds.fechas;
			assistance_students = ds.alumnos;
			assistance_assis = ds.asistencias;
			assistance_resum = ds.resumen_asistencias;
			
			cargarAsistencias(id_course,1);

		}, 'json');
		
		cargarListaDocumentos(id_course);
	
		desplegar(true);
}

function desplegar( action ){
	if(action){
	// Desplegar las tablas con los datos
		$('.collapsible').removeClass('closed');
		$('.collapsible').removeClass('collapsible');
	}else{
		$('.collapsible').addClass('closed');
		$('.collapsible').addClass('collapsible');
	}
}

/* GLOBLAR VARS */
var assistance_dates;
var assistance_students;
var assistance_assis;
var assistance_resum;

var students;
var evaluations;

var MAX_ITEM_SHOW = 5;
var first = true;
/* GLOBLAR VARS[END] */

function updateEvaluations(ref){
	var cajita = $(ref);
	var value = cajita.val();
	var tmp = cajita.attr('id')
	var hid = tmp.substr(0, tmp.indexOf('-'));
	var id_eval_t = tmp.substr(tmp.indexOf('-') + 1);
	for( var idx in evaluations[hid] ){
		if(id_eval_t == evaluations[hid][idx].id_eval_type ){
			evaluations[hid][idx].rating = value;
			break;
		}
	}
}

function cargarCalificaciones(id_course, nav){
	//// codigo para visualizar panel de edicion de calificaciones [Inicia]
//	alert(evaluations[students[0].hid].length);return;
	// indices 	
	init = nav * MAX_ITEM_SHOW - MAX_ITEM_SHOW;
	end = init + MAX_ITEM_SHOW ;
			
	/*Estableciendo el curso */
	
	$('#id_course', '#updatefinalrating').attr('value', id_course);
	
	// header
	var ratingstableheader = $('#ratingstableheader').empty();
	var ratingstableheadercontent = '<tr><th>Estudiante</th>';

	for(var eidx = init ; eidx < end && eidx < evaluations[students[0].hid].length ; eidx++ ){
		ratingstableheadercontent += '<th>' + evaluations[students[0].hid][eidx].evaldesc + '</th>';
	}

	ratingstableheadercontent += '</tr>';
	$(ratingstableheadercontent).appendTo(ratingstableheader);
			
	// body
	var ratingtablebody = $('#ratingstablecontent').empty();
	var ratingtablebodycontent = '';
	//for(var sidx in students){
	for(var sidx = 0; sidx < students.length; sidx++){
		// Agrega el nombre del estudiante
		ratingtablebodycontent += '<tr>';
		ratingtablebodycontent += '<td>';
		ratingtablebodycontent += students[sidx].f_lastname + ' ' + students[sidx].s_lastname + ' ' + students[sidx].name;
		ratingtablebodycontent += '</td>';				
		// Agrega las calificaciones del estudiante
		
		var curhid = students[sidx].hid;
		var cureval = evaluations[curhid];	

		for(var eidx = init ; eidx < end && eidx < cureval.length ; eidx++ ){
				ratingtablebodycontent += '<td>';
				ratingtablebodycontent += '<input type="text" size="2" id="'+cureval[eidx].hid + '-' + cureval[eidx].id_eval_type +'" name="calif['+cureval[eidx].hid + '-' + cureval[eidx].id_eval_type +']" value="' + ( cureval[eidx].rating == null ? '' : cureval[eidx].rating ) + '" onkeyup="updateEvaluations(this);" />';
				// lanzador de comments
				var hidtmp =  cureval[eidx].hid;
				var id_classmatetmp = cureval[eidx].id_classmate;
				var id_eval_typetmp = cureval[eidx].id_eval_type;
				ratingtablebodycontent += '<a href="#" onclick="mostrarComentario(\'' + hidtmp + '\',' + id_classmatetmp + ',' + id_eval_typetmp + '); return false;"><img src="images/comment.png" /></a>';
				ratingtablebodycontent += '</td>';
		}
		ratingtablebodycontent += '</tr>';
	}
			
	$(ratingtablebodycontent).appendTo(ratingtablebody);
	
	//// codigo para visualizar panel de edicion de calificaciones [Termina]
	
	/* ajustando el nav */
	if(evaluations[students[0].hid].length > MAX_ITEM_SHOW){
			
		navegador = $('#ratingspag').empty();	
		navmaker = '';
		nav_items = Math.ceil(evaluations[students[0].hid].length / MAX_ITEM_SHOW);

		for(var w = 0 ; w < nav_items ; w++ ){
			navmaker += '<a href="#" '+ (nav == (w+1) ? 'disabled ' : '') +' onclick="cargarCalificaciones(' + id_course + ', '+ (w+1) +'); return false;">'+(w+1)+'</a>';
		}

		$(navmaker).appendTo(navegador);
	}	
}

function mostrarComentario(hid, id_classmate, id_eval_type){
	// Despliega un overlay para mostrar y editar comentarios sobre calificación
	$('#commentform')[0].reset();
	
	var cureval = evaluations[hid];
	var comment = "";
		
	for(var eidx = init ; eidx < end && eidx < cureval.length ; eidx++ ){
		if( cureval[eidx].hid == hid &&  cureval[eidx].id_classmate == id_classmate && cureval[eidx].id_eval_type == id_eval_type) {
			comment = cureval[eidx].comment;
			break;
		}
	}
	
	$('#hid', '#commentpanel').attr('value', hid);
	$('#id_classmate', '#commentpanel').attr('value', id_classmate);
	$('#id_eval_type', '#commentpanel').attr('value', id_eval_type);
	$('#comment', '#commentpanel').val(comment);
	
	var cp = $("#commentpanel").overlay({
		mask: '000',
		effect: 'default',
		load: true, 
		close: '#closecomment'
	});
	
	
	if(cp != null || cp.isOpened()){
		cp.load();
	}
}

function addComment(){

	var hid = $('#hid', '#commentpanel').attr('value');
	var id_classmate = $('#id_classmate', '#commentpanel').attr('value');
	var id_eval_type = $('#id_eval_type', '#commentpanel').attr('value');
	var comment = $('#comment', '#commentpanel').val();

	var cureval = evaluations[hid];
		
	for(var eidx = init ; eidx < end && eidx < cureval.length ; eidx++ ){
		if( cureval[eidx].hid == hid &&  cureval[eidx].id_classmate == id_classmate && cureval[eidx].id_eval_type == id_eval_type) {
			//alert(comment);
			cureval[eidx].comment = comment;
			break;
		}
	}
	
	//Cerramos el overlay
	$('#closecomment').click();
}

function cargarAsistencias(id_course, nav){
			// extrayendo fechas intermedias del periodo [start]
			var fs = assistance_dates;
			
			var interdays = new Array();
			for(var f = 0; f < fs.length; f++){
				interdays[f] = new Date(fs[f].substring(0,4), fs[f].substring(5,7) - 1, fs[f].substring(8,10));
			}

			/* Acomodando encabezados de la tabla */
			var assistancetablehead = $('#assistancetablehead').empty();
			var assistancetableheadcontent = '<tr><th style="width: 150px">Estudiante</th><th style="width: 30px">A</th><th style="width: 30px">F</th>';
			
			/**/
			//alert(interdays.length);
			if(interdays.length > MAX_ITEM_SHOW){
				start = (MAX_ITEM_SHOW * nav) - MAX_ITEM_SHOW;
				end = (start + MAX_ITEM_SHOW );
			}else{
				start = 0;
				end = interdays.length;
			}
			/**/
			
			for(var idx = start; idx < end && idx <interdays.length ; idx++ ){
				var dia = interdays[idx].getDate();
				var mes = interdays[idx].getMonth()+1;
				var anio = interdays[idx].getYear();

				assistancetableheadcontent += '<th style="width: 30px">';
				assistancetableheadcontent += (dia<10? '0' + dia : dia) + '/' + (mes < 10 ? '0' + mes: mes);
				assistancetableheadcontent += '</th>';
			}
			$(assistancetableheadcontent).appendTo(assistancetablehead);
			// extrayendo fechas intermedias del periodo [end]
			
			// recuperando el listado de alumnos
			//alumnos = ds.alumnos;
			//asistencias = ds.asistencias;
			
			var assistancetablecontent = '';
			var assistancetable = $('#assistancetable').empty();
			var today = new Date();
			var todaystr = today.getFullYear() + '-' + (today.getMonth()<10?'0'+today.getMonth():today.getMonth()) + '-' + (today.getDate()<10?'0'+today.getDate():today.getDate());

//			for(var i in assistance_students){
			for(var i = 0; i < assistance_students.length; i++){
				/*se obtienen las asistencias del alumno*/
				var asis = 0;
				for(var x in assistance_resum){
					if(assistance_resum[x].hid == assistance_students[i].hid){
						asis = assistance_resum[x].assistances;
						break;
					}
				}
				/*se obtienen las asistencias del alumno[end]*/
				
				/*	Calcular las faltas			*/
				var dias_pasados = 0;
				//for(var j in interdays){
				for(var j = 0 ; j < interdays.length; j++){
					if( interdays[j].getTime() <= today.getTime() ){
						dias_pasados++;
					}
				}
				
				faltas = dias_pasados - asis;
				/*	Calcular las faltas[end] 	*/
				assistancetablecontent += '<tr>';
				assistancetablecontent += '<td style="width: 150px">' + assistance_students[i].f_lastname + ' ' + assistance_students[i].s_lastname + ' ' + assistance_students[i].name + '</td>';
				assistancetablecontent += '<td>' + asis + '</td>';
				assistancetablecontent += '<td>' + faltas + '</td>';
					// Fechas detectadas
				for(var idx = start; idx < end && idx < interdays.length ; idx++ ){
					dia = interdays[idx].getDate();
					mes = interdays[idx].getMonth();
					anio = interdays[idx].getFullYear();
					str_d = anio + '-' + (mes<10?'0'+mes:mes) + '-' + (dia<10?'0'+dia:dia);
					// buscando asistencias 
					var checked = '';
					var faltas = 0;		// se cuentan las faltas
					first = true;

					// Busca la fecha actual a evaluar
					for(var as = 0 ; as < assistance_assis.length; as++){
						
						if(assistance_students[i].hid == assistance_assis[as].hid && assistance_assis[as].fecha == str_d){
							
							checked = ' checked ';
							
							if(assistance_assis[as].now != 0)
								first = false;
							break;
						}
					}
					
					tmp_fecha = anio+'-'+(mes<10?'0'+mes:mes)+'-'+(dia<10?'0'+dia: dia);
					assistancetablecontent += '<td><input class="checkdate" type="checkbox" onclick="registerDate(this);" ';
					assistancetablecontent += 'id="'+ assistance_students[i].hid + '-' + tmp_fecha +'" ';
					assistancetablecontent += 'name="fechachk['+ assistance_students[i].hid + '-' + id_course +'][' + tmp_fecha + ']" ';
					assistancetablecontent += ( ( today.getTime() > interdays[idx].getTime() ) ? ' ' : ' disabled ' );
					assistancetablecontent += (first && checked != '') ? ' disabled ' : ' ';
					assistancetablecontent += checked;
					assistancetablecontent += ' />';
					assistancetablecontent += '</td>';
				}
				assistancetablecontent += '</tr>';
			}
			$(assistancetablecontent).appendTo(assistancetable);
			
			/* ajustando el nav */
			if(assistance_dates.length > MAX_ITEM_SHOW){
				
				navegador = $('#assistancepag').empty();	
				navmaker = '';
	
				nav_items = Math.ceil(assistance_dates.length / MAX_ITEM_SHOW);
				
				for(var w = 0 ; w < nav_items ; w++ ){
					navmaker += '<a href="#" '+ (nav == (w+1) ? 'disabled ' : '') +' onclick="cargarAsistencias(' + id_course + ', '+ (w+1) +'); return false;">'+(w+1)+'</a>';
				}
				$(navmaker).appendTo(navegador);
			}
}

function registerDate(ref){
		checkbox = $(ref);
		
		str = checkbox.attr('id');
		
		h = str.substr(0, str.indexOf('-'));
		
		d = str.substr(str.indexOf('-')+1);
		
		if(ref.checked){
			var top = assistance_assis.length;
			assistance_assis[top]= { hid: h, fecha: d , now: 1 };
		}else{
			//for( var i in assistance_assis ){
			for(var i = 0; i < assistance_assis.length; i++ ){
				if(assistance_assis[i].hid == h && assistance_assis[i].fecha == d){
					assistance_assis[i].hid = '';
					assistance_assis[i].fecha = '';
					break;
				}
			}
		}
}

//// Carga los cursos segun el profesor 
function cargarClases(){
	$.post('datastores/teacherdata.php?q=cursos', function(response){

		var tbody = $('#coursestable').empty();
		
		var tbodycontent = "";
	
		$.each(response, function(i, item){
			tbodycontent += '<tr>';
			tbodycontent += '<td class="small"><input type="checkbox" /></td>';
			tbodycontent += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a onclick="return false;" href="#">Detalle</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>';
			tbodycontent += '<td><a id="scheduledetail" onclick="verDetalle(this); return false;" href="#" rel="'+item.id_course+'" >'+item.name_course+'</a></td>';
			tbodycontent += '<td>'+item.desc_course+'</td>';
			tbodycontent += '<td>'+item.start_date+'</td>';
			tbodycontent += '<td>'+item.end_date+'</td>';
			tbodycontent += '<td>'+item.room+'</td>';
			tbodycontent += '</tr>';
		});
		
		$(tbodycontent).appendTo(tbody);
		
		
		/* se renderiza la tabla con id=courselist
		if($("#courselist").length > 0) $.rloader([
        	{ type: 'css', src: 'modules/datatables/css/demo_table_jui.css' },
         	{ type: 'js', src: 'modules/datatables/js/jquery.dataTables.js', callback: function(){
            	$('#courselist').dataTable({
                		"bJQueryUI": true,
                		"sPaginationType": "full_numbers"
	             });
         	} }
     	]);*/

		$.rloader([
			{ type: 'css', src: 'modules/datatables/css/demo_table_jui.css' },
			{ type: 'js', src: 'modules/datatables/js/jquery.dataTables.js', callback: function(){
				$('#courselist').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} }
		]);
		
	}, 'json');
}

///// Actualiza la lista de asistencia
function updateAssistance(){
	
	var rconfirm = confirm('Estas seguro de que los datos son correctos? Los datos deben ser correctos ya que no podrás modificarlos posteriormente');
	if(!rconfirm){ return ; }
	
	var action = $('#assistanceupdate').attr('action');
	var datos = $('#assistanceupdate').serialize();
	
	$.post('updateAssistanceService', datos, function(response){
		//alert(response);
		// Se obtienen la referencias a los checkbox
		checks = $('.checkdate');
		$.each(checks, function(i, item){
			if(checks[i].checked == true){
				// Si el checkbox fue marcado se desactiva para evitar ediciones
				checks[i].disabled = true;
				
				// borrar propiedad 
				atr = $(checks[i]).attr('id');

				h = atr.substr(0, atr.indexOf('-'));
				d = atr.substr(atr.indexOf('-')+1);

				//for(var j in assistance_assis){
				for(var j = 0; j < assistance_assis.length; j++){
					if(assistance_assis[j].hid == h && assistance_assis[j].fecha == d){
						assistance_assis[j].now = 0;
						break;
					}
				}
			}
		});
	});
}

///// Actualiza la lista de asistencia
function updateFinalRating(){
	
	var action = $('#updatefinalrating').attr('action');
//	var datos = $('#updatefinalrating').serialize();
	
	/* datos */
		
	datos = 'id_course=' + $('#id_course', '#updatefinalrating').attr('value') + '&';
	
	for(var sidx in students){
		var evals = evaluations[students[sidx].hid]
		for( var eidx in evals ){
			if(evals[eidx].rating != null){
				datos += 'calif%5B' + evals[eidx].hid + '-' + evals[eidx].id_eval_type + '%5D' + '=' + evals[eidx].rating + '-' + evals[eidx].comment + '&';
			}
		}
	}

	$.post('finalRatingService', datos, function(response){
	//	alert(response);
		if(response == "true")
			alert('Calificaciones dadas de alta correctamente');
	});
}

function cargarHorarioGeneral(){
	$.post('datastores/teacherdata.php?q=horarios', function(response){
		//alert(response);
		var horariosgeneraltable = $('#horariosgeneraltable').empty();
		var horariosgeneraltablecontent = '';
		$.each(response, function(i, item){
			horariosgeneraltablecontent += '<tr>';
			horariosgeneraltablecontent += '<td>' + item.horario + '</td>';
			horariosgeneraltablecontent += '<td>' + (item.lunes != 0 ? item.lunes+'<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
			horariosgeneraltablecontent += '<td>' + (item.martes != 0 ? item.martes+'<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
			horariosgeneraltablecontent += '<td>' + (item.miercoles != 0 ? item.miercoles+'<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
			horariosgeneraltablecontent += '<td>' + (item.jueves != 0 ? item.jueves+'<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
			horariosgeneraltablecontent += '<td>' + (item.viernes != 0 ? item.viernes+'<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
			horariosgeneraltablecontent += '<td>' + (item.sabado != 0 ? item.sabado+'<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
			horariosgeneraltablecontent += '<td>' + (item.domingo != 0 ? item.domingo+'<center><img src="images/list_icons/tick_16.png" /></center>' : '&nbsp;') + '</td>';
			horariosgeneraltablecontent += '</tr>';
		});
		
		$(horariosgeneraltablecontent).appendTo(horariosgeneraltable);
		
	}, 'json');
}

function clearObserverPanel(){
	$('#schedulecoursetable').empty();
	$('#classmatestable').empty();
	$('#ratingstablecontent').empty();
	$('#assistancetable').empty();
	$('#documentlist').empty();
}