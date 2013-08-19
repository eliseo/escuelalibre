$(document).ready(function(){
	
	if($("#selectRoom").length > 0){
		getRooms("#selectRoom");
	}
	
	
});


function getRooms(selectNode){	
	$.getJSON("datastores/admindata.php?q=getRooms",function(data){
		if($.isArray(data)){
				selectNode= $(selectNode).empty();
				$(selectNode).append($("<option></option>").attr("value","").text("Selecciona"));
				$.each(data, function(key, value){
					$(selectNode).append($("<option></option>").attr("value",value.id_room).text(value.desc_room));
	 			});
				$(selectNode).append($("<option></option>").attr("value",0).text("todos"));
		}
	});
	$(selectNode).change(function(){ 
		
		showCalendarRoom($(this).val()); 
		
		});
}


function showCalendarRoom(id_room){
				$("#calendar").empty();

				$('#calendar').fullCalendar({
					header: {
									left: 'prev,next today',
									center: 'title',
									right: 'month,agendaWeek,agendaDay'
								},

					editable: false,

					events: "datastores/admindata.php?q=roomsAvailab&id_room="+id_room,

					eventDrop: function(event, delta) {
						alert(event.title + ' fue movido ' + delta + ' dias\n' +
							'(es necesario actualizar los datos)');
					},

					loading: function(bool) {
						if (bool) $('#loading').show();
						else $('#loading').hide();
					}

				});

}


