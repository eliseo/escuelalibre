// JavaScript Document
$(document).ready(function(){
	cargarHorarioGeneral();	
	$("#printSchedule").click(function(){ 
		printDivContent("scheduleTeacher");
		});			  
});

function cargarHorarioGeneral(){
	$.getJSON('datastores/teacherdata.php?q=horarios', function(response){
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
		
	});
};


function printDivContent(nodeId){
	var prtContent = document.getElementById(nodeId);
	var WinPrint = window.open('','losgirosticket','left=0,top=0,width=600,height=500,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	prtContent.innerHTML=strOldOne;
};
