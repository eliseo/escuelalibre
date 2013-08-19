<?php

require_once ("../includes/general-functions.php");

$q=$_GET['q'];
$id_user=$_GET['id_user'];
global $ndb;

switch($q){
	case 'exist':
			$query="SELECT * FROM geodata WHERE id_user='$id_user'";
			$return_val = ($ndb->query($query)) ? 1 : 0;
			echo $return_val;
		break;
	case 'data':
			if($id_user == 0){
				if($_GET['type'] == "students"){
					
					$query = "SELECT g.id_user,g.lat,g.lng,g.zoom FROM geodata g
							  JOIN users u ON u.id = g.id_user
							  JOIN users_priv up ON up.id_user = u.id
							  WHERE up.func_1=1";
				}
			}else{
				
				$query = "SELECT * FROM geodata WHERE id_user=$id_user";
			}
			
			$data = $ndb->get_results($query);
		  	$doc = new DOMDocument('1.0','utf-8');
			
			$items = $doc->createElement('items');
			$items = $doc->appendChild($items);
			
		  foreach($data as $col){
			/*
		    $item = $doc->createElement('item');
			$item = $doc->appendChild($item);
			$id_user = $doc->createElement('id_user');
			$id_user = $item->appendChild($id_user);
			$info_id_user = $doc->createTextNode($col->id_user);
			$info_id_user = $id_user->appendChild($info_id_user);
			$latitud = $doc->createElement('latitud');
			$latitud = $item->appendChild($latitud);
			$info_latitud = $doc->createTextNode($col->lat);
			$info_latitud = $latitud->appendChild($info_latitud);
			$longitud = $doc->createElement('longitud');
			$longitud = $item->appendChild($longitud);
			$info_longitud = $doc->createTextNode($col->lng);
			$info_longitud = $longitud->appendChild($info_longitud);
			$zoom = $doc->createElement('zoom');
			$zoom = $item->appendChild($zoom);
			$info_zoom = $doc->createTextNode($col->zoom);
			$info_zoom = $zoom->appendChild($info_zoom);*/
			
			$item = $doc->createElement('item');
			$item = $items->appendChild($item);
			$id_user = $doc->createElement('id_user');
			$id_user = $item->appendChild($id_user);
			$info_id_user = $doc->createTextNode($col->id_user);
			$info_id_user = $id_user->appendChild($info_id_user);
			$latitud = $doc->createElement('latitud');
			$latitud = $item->appendChild($latitud);
			$info_latitud = $doc->createTextNode($col->lat);
			$info_latitud = $latitud->appendChild($info_latitud);
			$longitud = $doc->createElement('longitud');
			$longitud = $item->appendChild($longitud);
			$info_longitud = $doc->createTextNode($col->lng);
			$info_longitud = $longitud->appendChild($info_longitud);
			$zoom = $doc->createElement('zoom');
			$zoom = $item->appendChild($zoom);
			$info_zoom = $doc->createTextNode($col->zoom);
			$info_zoom = $zoom->appendChild($info_zoom);
			
		  }
		  header("Content-type: text/xml");
		  echo $doc->saveXML();
		break;
	default: break;
}

?>