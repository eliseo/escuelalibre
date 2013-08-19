/*
Implemntación de código usando APPI google maps, implementación realizada por ehecatl software services.
http://www.ehecatl.com.mx/
contacto@ehecatl.com.mx  

*/
	
document.onLoad= init();

var idForma = "newuserform";


function init(){
		var latitud = 19.166573;
		var longitud = -96.128998;
		initGoogleMaps(latitud,longitud);
};
	

	

	
	function initGoogleMaps(latitud,longitud){
		
				var myLatlng = new google.maps.LatLng(latitud,longitud);
				var myOptions = {zoom: 12,center: myLatlng,mapTypeId: google.maps.MapTypeId.ROADMAP};
				var map = new google.maps.Map(document.getElementById("edit_map"), myOptions);	
				var marker = new google.maps.Marker({position: myLatlng,draggable:true});
				var infowindow;
				marker.setMap(map);  

				google.maps.event.addListener(marker, 'dragstart', function(){
					//infowindow.close(map,marker);
				  });
				
				google.maps.event.addListener(marker, 'dragend', function(){
						latitud=marker.position.lat();
						longitud=marker.position.lng();
						zoom=map.getZoom();
						//infowindow = new google.maps.InfoWindow({ content: 'Longitud'+longitud+'latitud:'+latitud,position: myLatlng});
						createInputHidden(latitud,longitud,zoom);
				     //infowindow.open(map,marker);
				  });
		};
		
function createInputHidden(latitud,longitud,zoom){
	var f1 = document.getElementById("l01");
	var f2 = document.getElementById("l02");
	var f3 = document.getElementById("l03");
	if(!f1){
	var a = document.createElement("input");
		a.setAttribute("name","latitud");
		a.setAttribute("type","hidden");
		a.setAttribute("id","l01");
		a.setAttribute("value",latitud);
		document.getElementById(idForma).appendChild(a);
	}else{ f1.setAttribute("value",latitud); }
	
	if(!f2){
	var b = document.createElement("input");
		b.setAttribute("name","longitud");
		b.setAttribute("type","hidden");
		b.setAttribute("id","l02");
		b.setAttribute("value",longitud);
		document.getElementById(idForma).appendChild(b);
	}else{ f2.setAttribute("value",longitud); }
	
	if(!f3){
	var c = document.createElement("input");
		c.setAttribute("name","zoom");
		c.setAttribute("type","hidden");
		c.setAttribute("id","l03");
		c.setAttribute("value",zoom);
		document.getElementById(idForma).appendChild(c);
	}else{ f3.setAttribute("value",zoom); }
	
};