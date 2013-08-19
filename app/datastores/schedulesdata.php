<?php
include("../includes/schedule-functions.php");
$q=$_GET['q'];

switch($q){
	case "horarios" :
		$id_course = @$_GET['id_course'];
		getSchedule($_COOKIE['HID'], $id_course);
	break;
	default:
		echo "DataStore not exists";
}

?>