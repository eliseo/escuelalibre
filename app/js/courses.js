$(document).ready(function(){
	
	if($("#selectProfesor").length > 0){ 
		selectProfesor();
	}
	
	if($(".datepicker").length > 0){
		$( ".datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd',
			yearRange: '2010:2020'
		});
	}
	
	if($("#selectPeriod").length > 0){ 
		selectPeriod();
		}
	
	if($("#otherPeriod").length > 0){
		otherPeriod();
	}
	
	if($("#cnP").length > 0){
		createPeriod();
	}
	
	if($(".timepicker").length > 0){ 
		$('.timepicker').timepicker({});
	}
	
	if($("#newCourse").length > 0){
		validateForm("#newCourse");
	}
	
	if($("#coursesList").length > 0){
		getCoursesList();
	}
	
	/*functions for course details*/
	var id_course = getParameterByName("id_course");
	if($("#infoCourse").length > 0){
		infoCourse(id_course,"#infoCourse","#dailySchedule");
	}
	
	if($("#studentsCourse").length > 0){
		getStudentsCourse("#studentsCourse",id_course);
	}
	
	if($("#studentToCourse").length > 0){
		getStudentsList("#studentToCourse",id_course);
	}
	
	if($("#newEval").length > 0){
		validateForm_2("#newEval");
	}
	
	if($("#evalsS1").length > 0){
		getEvaluations("#evalsS1",id_course);
	}
	
	if($("#observersToCourse").length > 0){
		getObserversList("#observersToCourse",id_course);
	}
	
	if($("#observersCourse").length > 0){
		getObserversCourse("#observersCourse",id_course)
	}
	/**/
});

/* .begin functions for create clases */

function showSelectProfesor(data){
	if($.isArray(data)){
		selectNode= $("#selectProfesor").empty();
		var optionP="";
		var selectP="<select name='profId' class='select'>";
		$.each(data, function(i, item){
			optionP =optionP+"<option value='"+item.id_profesor+"'>"+item.name_profesor+","+item.f_lastname+"</option>";
		});
		selectP=selectP+optionP+"</select>";
		$(selectP).appendTo("#selectProfesor");
		
	}else{ $(".error", selectNode).css("lineHeight", selectNode.height()+'px'); }
}

function selectProfesor(){
	$.post("datastores/admindata.php?q=profesores", showSelectProfesor, 'json');
}

function showAvailableRoom(selectNode,numDay,timeStart,timeEnd){	
	$.getJSON("datastores/admindata.php?q=rooms_availab&nd="+numDay+"&ts="+timeStart+"&te="+timeEnd,function(data){
		selectNode= $(selectNode).empty();
		$.each(data, function(key, value){
	
			$(selectNode).append($("<option></option>").attr("value",value.id_room).text(value.name_room));
	 	});
	});
}

function showScheduleForm(data){
	if($.isArray(data)){
		scheduleForm= $("#schedulePeriod").empty();
		var form="<table>";
		$.each(data, function(i, item){
			if(item.lun==1){
				form=form+"<tr><td>Lun:</td><td><input type='text' id='d1t1' name='time1[]' class=' text timepicker required'/></td><td><input type='text' id='d1t2' name='time1[]' class='text timepicker required' onChange='showAvailableRoom(\"#rd1\",1,$(\"#d1t1\").val(),$(\"#d1t2\").val())'/></td><td><select name='rd1' id='rd1'></select></td></tr>"; }
			if(item.mar==1){
					form=form+"<tr><td>Mar:</td><td><input type='text' id='d2t1' name='time2[]'class='text timepicker required'/></td><td><input type='text' id='d2t2' name='time2[]'class='text timepicker required' onChange='showAvailableRoom(\"#rd2\",2,$(\"#d2t1\").val(),$(\"#d2t2\").val())'/></td><td><select name='rd2' id='rd2'/></select></td></tr>";
				}
				 if(item.mier==1){
					form=form+"<tr><td>Mier:</td><td><input type='text' id='d3t1' name='time3[]'class='text timepicker required'/></td><td><input type='text' id='d3t2' name='time3[]'class='text timepicker required' onChange='showAvailableRoom(\"#rd3\",3,$(\"#d3t1\").val(),$(\"#d3t2\").val())'/></td><td><select name='rd3' id='rd3'/></select></td></tr>";
				}

				if(item.juev==1){
					form=form+"<tr><td>Juev:</td><td><input type='text' id='d4t1' name='time4[]'class='text timepicker required'/></td><td><input type='text' id='d4t2' name='time4[]' class='text timepicker required' onChange='showAvailableRoom(\"#rd4\",4,$(\"#d4t1\").val(),$(\"#d4t2\").val())'/></td><td><select name='rd4' id='rd4'/></select></td></tr>";
				}

				if(item.vier==1){
					form=form+"<tr><td>Vier:</td><td><input type='text' id='d5t1' name='time5[]' class='text timepicker required'/></td><td><input type='text' id='d5t2' name='time5[]'class='text timepicker required' onChange='showAvailableRoom(\"#rd5\",5,$(\"#d5t1\").val(),$(\"#d5t2\").val())'/></td><td><select name='rd5' id='rd5'/></select></td></tr>";
				}
				
				if(item.sab==1){
					form=form+"<tr><td>Sab:</td><td><input type='text' id='d5t1' name='time6[]'class='text timepicker required'/></td><td><input type='text' id='d5t2' name='time6[]'class='text timepicker required' onChange='showAvailableRoom(\"#rd6\",6,$(\"#d6t1\").val(),$(\"#d6t2\").val())'/></td><td><select name='rd6' id='rd6'/></select></td></tr>";
				}

				if(item.dom==1){
					form=form+"<tr><td>Dom:</td><td><input type='text' id='d6t1' name='time7[]'class='text timepicker required'/></td><td><input type='text' id='d6t2' name='time7[]' class='text timepicker required' onChange='showAvailableRoom(\"#rd6\",7,$(\"#d6t1\").val(),$(\"#d6t2\").val())'/></td><td><select name='rd7' id='rd7'/></select></td></tr>";
				}
			});
		form=form+"</table>";
		$(form).appendTo("#schedulePeriod");
		$('.timepicker').timepicker({});
	}else{ $(".error", scheduleForm).css("lineHeight", scheduleForm.height()+'px'); }
}

function showSchedulePeriod(idPeriod){
	$.get("datastores/admindata.php?q=periods&id="+idPeriod, showScheduleForm,'json');
}

function showSelectPeriod(data){
	if($.isArray(data)){
		selectNode= $("#selectPeriod").empty();
		var optionP="";
		
		var selectP="<select name='periodId' id='periodId' class='select'>";
		$.each(data, function(i, item){
			optionP =optionP+"<option value='"+item.id_period+"'>"+item.name_period+"</option>";
		});
		selectP=selectP+optionP+"</select>";
		
		$(selectP).appendTo("#selectPeriod");
		$("#periodId").change( function(){ showSchedulePeriod($(this).val()); });
		
	}else{ $(".error", selectNode).css("lineHeight", selectNode.height()+'px'); }
}

function selectPeriod(){
	$.post("datastores/admindata.php?q=periods", showSelectPeriod, 'json');
}

function otherPeriod(){
	$("#otherPeriod").change(function(){
		var checked = $(this).attr('checked');
		if(checked){
			$("#nPf").show();
		}else{
			$("#nPf").hide();
		}
	});
}

function createPeriod(){
	$("#cnP").click(function(){
				
				var nPeriod = $("#nPeriod").val();
				var dayP= $('input[name="dayP[]"]').serialize();
				
				var string="nPeriod='"+nPeriod+"'&dayP='"+dayP+"'";
						$.post("controller/admin-events.php?a=newPeriod",$("#nPf *").serialize(),function(data){
							if(data=="success"){
								selectPeriod();
								$("#nPf").hide();
								$("#otherPeriod").attr('checked',false);
							}else{ alert(data); }
						});
		return false;
	});
}


function validateForm(idForm){
	var validator = $(idForm).validate({
		rules: {
			name_course: "required",
			desc_course: "required",
			proIf: "required",
		},
		messages: {
			name_course: "Ingresa nombre de la curso",
			desc_course: "Ingresa una descripción",
			start_date: "Ingresa Fecha válida",
			end_date: "Ingresa Fecha válida",
		},

		errorPlacement: function(error, element) {
			note = element.next("span.note");
			if(note.length > 0) note.addClass("error").text(error.text());
			else element.after('<span class="note error">'+error.text()+'</span>');
			if($.trim(error.text()).length == 0) element.parent().find("span.note").remove();
		},
		
		submitHandler: function() {
			$.post("controller/admin-events.php?a=newCourse",$("#newCourse").serialize(),function(data){
				if(data=="success"){
					$('#newCourse')[0].reset();
					$("#messageClient").empty();
					$("<div><p>La clase ha sido creada correctamente.</p></div>").addClass("message closeable tip").appendTo("#messageClient");
				}else{ alert(data+"asd"); }
			});
		},

		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("ok");
		}
	});
	
}

/* functions for create clases end.*/

//------------------------------------------//

/* .begin functions for view,edit, classes */
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


function infoCourse(id_course,nodeG,nodeDs){
	$.getJSON("datastores/admindata.php?q=coursedata&id_course="+id_course,function(data){
		
		var t=$("<table></table>").addClass("table"); 
		var t1=$("<table></table>").addClass("table");	
		
		var info ='';
		var info1 ='';	
									
		$.each(data, function(i, item){
				
				
				info += '<tr>';
				info +='<th>Curso:</th>';
				info +='<td>'+item.name_course+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Descripción:</th>';
				info +='<td>'+item.desc_course+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Profesor:</th>';
				info +='<td>'+item.name_professor+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Periodo:</th>';
				info +='<td>'+item.name_period+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Fecha Inicial:</th>';
				info +='<td>'+item.start_date+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Fecha Final:</th>';
				info +='<td>'+item.end_date+'</td>';
				info += '</tr>';
				
				t.append(info);
				
				info1 += '<tr>';
				info1 += '<th>Id Salón</th><th>Num Dia</th><th>Hora Inicia</th><th>Hora Termina</th>';
				info1 += '<tr>';
				$.each(item.daily_schedule, function(i, ds){
					info1 += '<tr>';
					info1 +='<td>'+ds.id_room+'</td>';
					info1 +='<td>'+ds.name_day+'</td>';
					info1 +='<td>'+ds.start_time+'</td>';
					info1 +='<td>'+ds.end_time+'</td>';
					info1 += '</tr>';
				});
				t1.append(info1);
		});
		$(nodeG).append(t);
		$(nodeDs).append(t1);
	});
}

function eliminar(id_course){
	
	if(!confirm('Esta seguro que desea eliminar este curso?')){
		return false;
	}
	
	$.get("controller/admin-events.php?a=delCourse&id_course="+id_course,function(data){
		if(data == "success"){
			getCoursesList();
		}else{
			alert(data);
		}
	});
};


function showCourseList(data){
	if($.isArray(data)){
		tableNode = $("#coursesList").empty();
		var info='';

		$.each(data, function(i, item){
			
			var info = '<tr class="gradeA odd">';
				info += '<td>' + item.id_course + '</td>';
				info += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a id="course_'+ item.id_course +'" href="cursos?id_course='+item.id_course +'">Ver</a></li><li><a id="deleteuser" href="#'+ item.id_course +'" onclick="eliminar('+ item.id_course +'); return false;">Eliminar</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>';
				info += '<td>' + item.name_course + '</td>';
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
	$.getJSON("datastores/admindata.php?q=courseslist", showCourseList);
}


function delStudFromCourse(id_student,id_course){
	$.get("controller/admin-events.php?a=delStudentFromCourse&id_student="+id_student+"&id_course="+id_course,function(data){
		if(data=="success"){
			getStudentsCourse("#studentsCourse",id_course);
		}else{
			alert(data);
		}
	});
}


function getStudentsCourse(nodeS,id_course){
	
	$.getJSON("datastores/admindata.php?q=studentslist&id_course="+id_course, function(data){
		tableNode = $(nodeS).empty();
		if($.isArray(data)){
			var t = $("<table></table>").addClass("table");
			var info='';
			$.each(data, function(i, item){
				var info = '<tr>';
					info += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a onclick="delStudFromCourse('+item.id_user+','+id_course+'); return false;" href="#">Delete</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>';
					info += '<td><a id="user_'+item.id_user+'" href="#">' + item.id_user + '</a></td>';
					info += '<td>' + item.name_user + '</td>';
					info += '<td>' + item.f_lastname + '</td>';
					info += '<td>' + item.s_lastname + '</td>';
					info += '</tr>';

				t.append(info);
			});
		tableNode.append(t);
		}
	});
}


function addToCourse(id_student,id_course){
	$.get("controller/admin-events.php?a=studentToCourse&id_student="+id_student+"&id_course="+id_course,function(data){
		if(data == "success"){
			getStudentsCourse("#studentsCourse",id_course);
		}else{
			alert(data);
		}
	});
}



function getStudentsList(nodeS,id_course){
	$.getJSON("datastores/admindata.php?q=studentslist&left=1&id_course="+id_course, function(data){
		if($.isArray(data)){
			tableNode = $("#studentToCourse").empty();
			var t = $("<table></table>").addClass("table");
			var info='';

			$.each(data, function(i, item){
				var info = '<tr>';
					info += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a onclick="addToCourse('+item.id_user+','+id_course+'); return false;" href="#">Add</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>';
					info += '<td><a id="user_'+item.id_user+'" href="#">' + item.id_user + '</a></td>';
					info += '<td>' + item.name_user + '</td>';
					info += '<td>' + item.f_lastname + '</td>';
					info += '<td>' + item.s_lastname + '</td>';
					info += '</tr>';

				t.append(info);
			});
		tableNode.append(t);
		}
	});
}


function getObserversCourse(nodeId,id_course){
	
	$.getJSON("datastores/admindata.php?q=observerslist&id_course="+id_course, function(data){
		tableNode = $(nodeId).empty();
		if($.isArray(data)){
			var t = $("<table></table>").addClass("table");
			var info='';

			$.each(data, function(i, item){
				var info = '<tr>';
					info += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a onclick="delObservFromCourse('+item.id_user+','+id_course+'); return false;" href="#">Delete</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>';
					info += '<td><a id="user_'+item.id_user+'" href="#">' + item.id_user + '</a></td>';
					info += '<td>' + item.name_user + '</td>';
					info += '<td>' + item.f_lastname + '</td>';
					info += '<td>' + item.s_lastname + '</td>';
					info += '</tr>';

				t.append(info);
			});
		tableNode.append(t);
		}
	});
}


function addObserverToCourse(id_observer,id_course){
	$.get("controller/admin-events.php?a=observerToCourse&id_observer="+id_observer+"&id_course="+id_course,function(data){
		if(data == "success"){
			getObserversCourse("#observersCourse",id_course);
		}else{
			alert(data);
		}
	});
}

function delObservFromCourse(id_observer,id_course){
	$.get("controller/admin-events.php?a=delObservFromCourse&id_observer="+id_observer+"&id_course="+id_course,function(data){
		if(data=="success"){
			getObserversCourse("#observersCourse",id_course);
		}else{
			alert(data);
		}
	});
}

function getObserversList(nodeId,id_course){
	$.getJSON("datastores/admindata.php?q=observerslist", function(data){
		
		if($.isArray(data)){
			
			tableNode = $(nodeId).empty();
			var t = $("<table></table>").addClass("table");
			var info='';

			$.each(data, function(i, item){
				var info = '<tr>';
					info += '<td class="small"><a class="action" href="#"></a><div class="opmenu"><ul><li><a onclick="addObserverToCourse('+item.id_user+','+id_course+'); return false;" href="#">Add</a></li></ul><div class="clear"></div><div class="foot"></div></div></td>';
					info += '<td><a id="user_'+item.id_user+'" href="#">' + item.id_user + '</a></td>';
					info += '<td>' + item.name_user + '</td>';
					info += '<td>' + item.f_lastname + '</td>';
					info += '<td>' + item.s_lastname + '</td>';
					info += '</tr>';

				t.append(info);
			});
		tableNode.append(t);
		}
		
	});
};


function getEvaluations(nodeId,id_course){

	$.getJSON("datastores/admindata.php?q=evaluationslist&id_course="+id_course, function(data){
			
		if($.isArray(data)){
			
			tableNode1 = $("#evalsS1").empty();
			var t1 = $("<table></table>").addClass("table");
			var info1 = '';
			
			tableNode2 = $("#evalsS2").empty();
			var t2 = $("<table></table>").addClass("table");
			var info2 = '';
			
			tableNode3 = $("#evalsS3").empty();
			var t3 = $("<table></table>").addClass("table");
			var info3 = '';
			
			tableNode4 = $("#evalsS4").empty();
			var t4 = $("<table></table>").addClass("table");
			var info4 = '';

			$.each(data, function(i, item){
				
					$.each(item.sem01, function(i, s01){
						 info1 += '<tr>';
						 info1 += '<td>' + s01.name_eval + '</td>';
						 info1 += '<td>' + s01.description_eval + '</td>';
						 if(s01.available == 1){ checked = "checked"; value = 1; }else{ checked = ""; value=0; } 
						 info1 += '<td><input type="checkbox" name="'+ s01.id_eval+'"'+checked+' value="'+value+'"></input></td>';
						 info1 += '</tr>';
					});
					
					$.each(item.sem02, function(i, s02){
						 info2 += '<tr>';
						 info2 += '<td>' + s02.name_eval + '</td>';
						 info2 += '<td>' + s02.description_eval + '</td>';
						if(s02.available == 1){ checked = "checked"; value = 1; }else{ checked = ""; value=0; } 
						 info2 += '<td><input type="checkbox" name="'+ s02.id_eval+'"'+checked+' value="'+value+'"></input></td>';
						 info2 += '</tr>';
					});
					
					$.each(item.sem03, function(i, s03){
						 info3 += '<tr>';
						 info3 += '<td>' + s03.name_eval + '</td>';
						 info3 += '<td>' + s03.description_eval + '</td>';
						 if(s03.available == 1){ checked = "checked"; value = 1; }else{ checked = ""; value=0; } 
						 info3 += '<td><input type="checkbox" name="'+ s03.id_eval+'"'+checked+' value="'+value+'"></input></td>';
						 info3 += '</tr>';
					});
					
					$.each(item.sem04, function(i, s04){
						 info4 += '<tr>';
						 info4 += '<td>' + s04.name_eval + '</td>';
						 info4 += '<td>' + s04.description_eval + '</td>';
						 if(s04.available == 1){ checked = "checked"; value = 1; }else{ checked = ""; value=0; } 
						 info4 += '<td><input type="checkbox" name="'+ s04.id_eval+'"'+checked+' value="'+value+'"></input></td>';
						 info4 += '</tr>';
					});
					
				t1.append(info1);
				t2.append(info2);
				t3.append(info3);
				t4.append(info4);
			});
			
		tableNode1.append(t1);
		tableNode2.append(t2);
		tableNode3.append(t3);
		tableNode4.append(t4);
		
		$("input:checkbox").change(function(){ 
			var id_eval = $(this).attr("name");
			var value = $(this).attr("value");
			changeStatusEval(id_eval, value);
			});
		}
		
	});
};

function changeStatusEval(id_eval,value){
	
	if(value == 1){
		var nVal = "0";
		$.post("controller/admin-events.php?a=chStatEval",{ "id_eval" : id_eval, "available": nVal},function(data){
			if(data == "success"){
				alert("cambio realizado!");
				$(this).attr("value",nVal);
			}else{ 
					alert(data);
				 }
		});
		
	}else{
		var nVal = "1";
		$.post("controller/admin-events.php?a=chStatEval",{ "id_eval" : id_eval, "available": nVal},function(data){
			if(data == "success"){
				alert("cambio realizado!");
				$(this).attr("value",nVal);
			}else{ 
					alert(data);
				 }
		});
	}
};


function validateForm_2(idForm){
	var validator = $(idForm).validate({
		rules: {
			name_eval: "required",
			desc_eval: "required",
		},
		messages: {
			name_eval: "Ingresa nombre de la evaluación",
			desc_eval: "Ingresa una descripción",
		},

		errorPlacement: function(error, element) {
			note = element.next("span.note");
			if(note.length > 0) note.addClass("error").text(error.text());
			else element.after('<span class="note error">'+error.text()+'</span>');
			if($.trim(error.text()).length == 0) element.parent().find("span.note").remove();
		},
		
		submitHandler: function() {
			$.post("controller/admin-events.php?a=newEval",$("#newEval").serialize(),function(data){
				if(data=="success"){
					$('#newEval')[0].reset();
					$("#messageClient_2").empty();
					$("<div><p>La Evaluación ha sido creada correctamente.</p></div>").addClass("message closeable tip").appendTo("#messageClient_2");
				}else{ 
						$("#messageClient_2").empty();
						$("<div><p>"+data+"</p></div>").addClass("message closeable tip").appendTo("#messageClient_2");
					 }
			});
		},

		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("ok");
		}
	});
	
}
