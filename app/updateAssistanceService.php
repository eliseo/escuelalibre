<?php
require_once("controller/assistance.php");
//print_r($_REQUEST);

$assistance = new Assistance();

foreach($_REQUEST['fechachk'] as $c=>$dates){

	$hid = substr($c, 0, strpos($c,'-'));
	$id_course = substr($c, strpos($c,'-')+1);
	
	foreach($dates as $d=>$v){
		$res = $assistance->setAssistance($d, $id_course, $hid);
	}

}

echo "true";

?>