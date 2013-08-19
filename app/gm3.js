/*
Implemntación de código usando APPI google maps, implementación realizada por ehecatl software services.
http://www.ehecatl.com.mx/
contacto@ehecatl.com.mx  
*/
document.onLoad= init();
	function init(){  
		if(document.getElementById("info_map")){
			
				var id_user = getParameterByName("id_student");
				checkStatusP(id_user); 
				
		}else if(document.getElementById("info_map_students")){
				latitud = 19.166573;
				longitud = -96.128998;
				zoom = 12;
				initGoogleMaps2(latitud,longitud,zoom,"info_map_students");
		}
	};
			

	function checkStatusP(id_user){
		var url="datastores/geodata.php?q=exist&id_user="+id_user;
		var statprop = getTextData(url, function(data){
			if(data==1){ 
				
				getXMLData("datastores/geodata.php?q=data&id_user="+id_user, function(data){
				
				  var items = data.getElementsByTagName("item");
					for(var i=0; i<items.length;i++){
						var latitud = items[i].getElementsByTagName('latitud')[0].firstChild.nodeValue;
						var longitud = items[i].getElementsByTagName('longitud')[0].firstChild.nodeValue;
						var zoom = items[i].getElementsByTagName('zoom')[0].firstChild.nodeValue;
						zoom=parseInt(zoom);
					}
					initGoogleMaps(latitud,longitud,zoom,"info_map");
				});
				
				 }else{ 
					
					latitud = 19.166573;
					longitud = -96.128998;
					zoom = 12;
					initGoogleMaps(latitud,longitud,zoom,"info_map");
					
					}
		});
	};
	
	
	function getTextData(textSource,callback){
		var ajaxObject = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
		if(ajaxObject){
			ajaxObject.onreadystatechange = function(){	
				if(ajaxObject.readyState == 4 && ajaxObject.status == 200){
					callback(ajaxObject.responseText, ajaxObject.status);
					}
				 };
			 }else{ alert("Navegador no soporta XMLHttpRequest");}
			ajaxObject.open("GET",textSource,true);
			ajaxObject.send(null);
	};
	
	function getXMLData(xmlSource,callback){

			var ajaxObject = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;

			if(ajaxObject){
				ajaxObject.onreadystatechange = function(){	
					if(ajaxObject.readyState == 4 && ajaxObject.status == 200){
						callback(ajaxObject.responseXML, ajaxObject.status);
						}
					 };
				 }else{ alert("Navegador no soporta XMLHttpRequest");}
				ajaxObject.open("GET",xmlSource,true);
				ajaxObject.send(null);
	};
	
	
	function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    };

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
	};
	
	
	
	
	/*  ============= google maps functions =============  */
	var latitud;
	var longitud;
	var accuracy;
	var zoom;
	
	function initGoogleMaps(latitud,longitud,zoom,nodeId){
		
				var myLatlng = new google.maps.LatLng(latitud, longitud);
				var myOptions = {zoom: zoom,center: myLatlng,mapTypeId: google.maps.MapTypeId.ROADMAP}
				var map = new google.maps.Map(document.getElementById(nodeId), myOptions);	
				var marker = new google.maps.Marker({position: myLatlng,draggable:false});
				marker.setMap(map);  
		};
		
	function initGoogleMaps2(latitud,longitud,zoom,nodeId){
				
				var myLatlng = new google.maps.LatLng(latitud, longitud);
				var myOptions = {zoom: zoom,center: myLatlng,mapTypeId: google.maps.MapTypeId.ROADMAP}
				var map = new google.maps.Map(document.getElementById(nodeId), myOptions);
				
				
				
				
				var infowindow = null;
				var infowindow = new google.maps.InfoWindow({content:"loading..."});
				getXMLData("datastores/geodata.php?q=data&id_user=0&type=students", function(data){
					  var items = data.getElementsByTagName("item");

						for(var i=0; i<items.length;i++){
							var latitud = items[i].getElementsByTagName('latitud')[0].firstChild.nodeValue;
							var longitud = items[i].getElementsByTagName('longitud')[0].firstChild.nodeValue;
							var id_user = items[i].getElementsByTagName('id_user')[0].firstChild.nodeValue;
							
							var myLatlng2 = new google.maps.LatLng(latitud, longitud);
							
							var marker = new google.maps.Marker({position: myLatlng2, map: map, clickable:true});
							
							var contentString = '<a href="students?id_student='+id_user+'">Ver Detalles</a><br/>'+
												'<a href="users?ac=edit&id_user='+id_user+'">Editar Estudiante</a><br/>';
							
							
							listenMarker(marker,contentString);
						}
					});
					function listenMarker(marker,contentString){
							google.maps.event.addListener(marker, 'click', function(){
									infowindow.setContent(contentString);
								  	infowindow.open(map,this);
								});
					};	
	};
	

