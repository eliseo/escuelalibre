// JavaScript Document
$(document).ready(function(){
	
	if($("#studentslistbody").length > 0){
		getStudentsList();
	}
	
	var id_student = getParameterByName("id_student");
	if($("#infoStudent").length > 0){

		getStudentInfo(id_student,"#infoStudent","#studentCourses");
	}
});

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



function showStudentsList(data){
	if($.isArray(data)){
		tableNode = $("#studentslistbody").empty();
		var info='';

		$.each(data, function(i, item){
			
			var info = '<tr>';
				info += '<td>'+ item.id_user+'</td>';
				info += '<td class="odd gradeA"><a href="estudiantes?id_student='+item.id_user +'">' + item.user + '</a></td>';
				info += '<td class="odd gradeA">' + item.name_user + '</td>';
				info += '<td class="odd gradeA">' + item.f_lastname + ' ' + item.s_lastname + '</td>';
				info += '<td class="odd gradeA">' + item.email + '</td>';
				info += '</tr>';
					
			$("#studentslistbody").append(info);
		});
		
			$.rloader([
				{ type: 'css', src: 'modules/datatables/css/demo_table_jui.css' },
				{ type: 'js', src: 'modules/datatables/js/jquery.dataTables.js', callback: function(){
				$('#studentslist').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
				} }
			]);
	}
}

function getStudentsList(){
	$.getJSON("datastores/admindata.php?q=studentslist", showStudentsList);
}


function getStudentInfo(id_student,nodeI,nodeC){
	$.getJSON("datastores/admindata.php?q=studentdata&id_student="+id_student,function(data){
		
		var t = $("<table></table>").addClass("table"); 
		var t1 = $("<table></table>").addClass("table"); 
		var info = '';	
		var info1 = '';
									
		$.each(data, function(i, item){
			   	info += '<tr>';
				info +='<th>Id:</th>';
				info +='<td>'+item.id_student+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Usuario:</th>';
				info +='<td>'+item.user+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Nombre:</th>';
				info +='<td>'+item.name_student+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Apellido Paterno:</th>';
				info +='<td>'+item.f_lastname+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Apellido Materno:</th>';
				info +='<td>'+item.s_lastname+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>E-Mail:</th>';
				info +='<td>'+item.email+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Dirección:</th>';
				info +='<td>'+item.address+'</td>';
				info += '</tr>';
				
				info += '<tr>';
				info +='<th>Teléfono:</th>';
				info +='<td>'+item.tel+'</td>';
				info += '</tr>';

				info += '<tr>';
				info +='<th>Estado Civil:</th>';
				info +='<td>'+item.civil_status+'</td>';
				info += '</tr>';
				
				t.append(info);
				
				
				info1 += '<tr>';
				info1 += '<th>Id Curso</th><th>Nombre Curso</th><th>Id Profesor</th><th>ID Periodo</th><th>Fecha Inicia</th><th>Fecha Termina</th>';
				info1 += '</tr>';
				$.each(item.courses, function(i, c){
						info1 += '<tr>';
						info1 +='<td>' + c.id_course + '</td>';
						info1 +='<td>' + c.name_course + '</td>';
						info1 +='<td>' + c.id_professor + '</td>';
						info1 +='<td>' + c.id_period + '</td>';
						info1 +='<td>' + c.start_date + '</td>';
						info1 +='<td>' + c.end_date + '</td>';
						info1 += '</tr>';
					});
					t1.append(info1);
		});
		$(nodeI).append(t);
		$(nodeC).append(t1);

	});
};