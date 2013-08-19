$(document).ready(function(){
	if($("#coursesList").length > 0){
		getCoursesList();
	}
	
});

function showCourseList(data){
	if($.isArray(data)){
		tableNode = $("#coursesList").empty();
		var info='';

		$.each(data, function(i, item){
			
			var info = '<tr class="gradeA odd">';
				info += '<td>' + item.id_course + '</td>';
				info += '<td><a onClick="courseDetails(' + item.id_course + '); return false;" href="#">' + item.name_course + '</a></td>';
				info += '<td>' + item.id_professor + '</td>';
				info += '<td>' + item.id_period + '</td>';
				info += '<td>' + item.start_date + '</td>';
				info += '<td>' + item.end_date + '</td>';
				info += '</tr>';
					
			$("#coursesList").append(info);
		});
		
		/*data table*/
		$.rloader([
			{ type: 'css', src: 'modules/datatables/css/demo_table_jui.css' },
			{ type: 'js', src: 'modules/datatables/js/jquery.dataTables.js', callback: function(){
				$('#coursesListTable').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} }
		]);
		/**/
	}
}


function getCoursesList(){
	$.getJSON("datastores/studentdata.php?q=courseslist", showCourseList);
}


function courseDetails(id_course){
	
	clearObserverPanel();
	
	//getting horarios
	// ---------- Obtiene los horarios
	$.getJSON('datastores/studentdata.php?q=horarios&id_course=' + id_course, function(response){
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
		
	});
	
	// getRatings
	$.getJSON('datastores/studentdata.php?q=ratings&id_course=' + id_course, function(response){
		students = response.students;
		evaluations = response.evals;
		
		cargarCalificaciones(id_course, 1);
	});
	
	//getting assistance
	/// --------- Obtiene las asistencias
	var assistancetablecontent = '';
	$.getJSON('datastores/studentdata.php?q=asistencia&id_course=' + id_course , function(ds){
		
		assistance_dates =  ds.fechas;
		assistance_students = ds.alumnos;
		assistance_assis = ds.asistencias;
		assistance_resum = ds.resumen_asistencias;
		
		loadAsistances(id_course,1);

	});
	
	loadDocumentList(id_course);
	
	//open collapsible
	$('.collapsible').removeClass('closed');
}

/* GLOBLAR VARS */
var assistance_dates;
var assistance_students;
var assistance_assis;
var assistance_resum;
var MAX_ITEM_SHOW = 5;
var first = true;

var students;
var evaluations;
/* GLOBLAR VARS[END] */


function loadAsistances(id_course, nav){
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
				//end = (start + MAX_ITEM_SHOW ) < interdays.length ? (start + MAX_ITEM_SHOW ) : (start + (interdays.length - MAX_ITEM_SHOW));
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

			//for(var i in assistance_students){
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
					for( var as in assistance_assis ){
						if(assistance_students[i].hid == assistance_assis[as].hid && assistance_assis[as].fecha == str_d){
							checked = 'checked';

							if(assistance_assis[as].now != 0)
								first = false;
							break;
						}
					}
					
					tmp_fecha = anio+'-'+(mes<10?'0'+mes:mes)+'-'+(dia<10?'0'+dia: dia);
					assistancetablecontent += '<td><input class="checkdate" type="checkbox"';
					assistancetablecontent += 'id="'+ assistance_students[i].hid + '-' + tmp_fecha +'" ';
					assistancetablecontent += 'name="fechachk['+ assistance_students[i].hid + '-' + id_course +'][' + tmp_fecha + ']" ';
					assistancetablecontent += ( ( today.getTime() <= interdays[idx].getTime() ) ? ' ' : ' disabled ' );
					//assistancetablecontent += (first && checked != '') ? ' disabled ' : ' ';
					assistancetablecontent += ' disabled ';
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
					navmaker += '<a href="#" '+ (nav == (w+1) ? 'disabled ' : '') +' onclick="loadAsistances(' + id_course + ', '+ (w+1) +'); return false;">'+(w+1)+'</a>';
				}

				$(navmaker).appendTo(navegador);
			}			
			
}

function cargarCalificaciones(id_course, nav){
	//// codigo para visualizar panel de edicion de calificaciones [Inicia]
	//// indices 	
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
				
				// lanzador de comments
				
				var hidtmp =  cureval[eidx].hid;
				var id_classmatetmp = cureval[eidx].id_classmate;
				var id_eval_typetmp = cureval[eidx].id_eval_type;
				
				ratingtablebodycontent += ( cureval[eidx].rating == null ? 'SA' : cureval[eidx].rating );
				if(cureval[eidx].comment != null && cureval[eidx].comment != ""){
					ratingtablebodycontent += '<a href="#" onclick="mostrarComentario(\'' + hidtmp + '\',' + id_classmatetmp + ',' + id_eval_typetmp + '); return false;"><img src="images/comment.png" /></a>';
				}
				
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
	$('#comment', '#commentpanel').html(comment);
	
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


function loadDocumentList(id_course){
	$.getJSON('datastores/studentdata.php?q=listamateriales&id_course='+id_course, function(response){
		
		var documentslistbody = '';
		
		$.each(response, function(i,item){
			documentslistbody += '<tr id="'+item.id+'">';
			documentslistbody += '<td class="small"><input type="checkbox"/></td>';
			documentslistbody += '<td>' + item.name + '</td>';
			documentslistbody += '<td>' + item.desc + '</td>';
			documentslistbody += '<td>' + item.modif_date + '</td>';
			documentslistbody += '<td><a href="#" onclick="getDocument('+item.id+');return false;">Descargar</a></td>';
			documentslistbody += '</tr>';
		});

		$(documentslistbody).appendTo($('#documentlist').empty());
	});
	
}

function getDocument(id_doc){
	window.open('fileService?id_doc='+id_doc+'&action=get', 'getDocument', '');
}

function clearObserverPanel(){
	$('#schedulecoursetable').empty();
	$('#classmatestable').empty();
	$('#ratingstablecontent').empty();
	$('#assistancetable').empty();
	$('#documentlist').empty();
}