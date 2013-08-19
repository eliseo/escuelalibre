/*
Implemntación de código usando APPI google maps, implementación realizada por ehecatl software services.
http://www.ehecatl.com.mx/
contacto@ehecatl.com.mx  
*/
document.onLoad= init();
	function init(){  
				checkStatusP(); 
			}
			

	function checkStatusP(){
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
					initGoogleMaps(latitud,longitud,zoom);
				});
				
				 }else{ 
					
					latitud=19.166573;
					longitud=-96.128998;
					zoom=12;
					var forma = "updateuserdataG";
					initGoogleMaps(latitud,longitud,zoom);
					
					}
		});
	}
	
	
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
	}
	
	function getXMLData(xmlSource,callback){
			/*
				var ajaxObject = false;
				if (window.XMLHttpRequest){   ajaxObject = new XMLHttpRequest();
					}else if (window.ActiveXObject){ ajaxObject = new ActiveXObject("Microsoft.XMLHTTP"); }
		   */
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
	}
	
	
	function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

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
	
	
	
	
	/*  ============= google maps functions =============  */
	var latitud;
	var longitud;
	var accuracy;
	var zoom;
	
	function initGoogleMaps(latitud,longitud,zoom,update){
		
				var myLatlng = new google.maps.LatLng(latitud, longitud);
				var myOptions = {zoom: zoom,center: myLatlng,mapTypeId: google.maps.MapTypeId.ROADMAP}
				var map = new google.maps.Map(document.getElementById("edit_map_2"), myOptions);	
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
						//infowindow = new google.maps.InfoWindow({content:'Longitud'+longitud+'zoom:'+zoom,position: myLatlng});infowindow.open(map,marker);
						createInputHidden(latitud,longitud,zoom,update);
				     
				  });
		}


function createInputHidden(latitud,longitud,zoom,update){
	var forma = "updateuserdataG";
	var id_user = getParameterByName("id_user");
	var f1=document.getElementById("l01");
	var f2=document.getElementById("l02");
	var f3=document.getElementById("l03");
	var f4=document.getElementById("l04");
		
	if(!f1){
	var a = document.createElement("input");
		a.setAttribute("name","latitud");
		a.setAttribute("type","hidden");
		a.setAttribute("id","l01");
		a.setAttribute("value",latitud);
		document.getElementById(forma).appendChild(a);
	}else{ f1.setAttribute("value",latitud); }
	
	if(!f2){
	var b = document.createElement("input");
		b.setAttribute("name","longitud");
		b.setAttribute("type","hidden");
		b.setAttribute("id","l02");
		b.setAttribute("value",longitud);
		document.getElementById(forma).appendChild(b);
	}else{ f2.setAttribute("value",longitud); }
	
	if(!f3){
	var c = document.createElement("input");
		c.setAttribute("name","zoom");
		c.setAttribute("type","hidden");
		c.setAttribute("id","l03");
		c.setAttribute("value",zoom);
		document.getElementById(forma).appendChild(c);
	}else{ f3.setAttribute("value",zoom); }

	if(!f4){
	var d = document.createElement("input");
		d.setAttribute("name","id_user");
		d.setAttribute("type","hidden");
		d.setAttribute("id","l04");
		d.setAttribute("value",id_user);
		document.getElementById(forma).appendChild(d);
	}else{ f4.setAttribute("value",id_user); }
	
}