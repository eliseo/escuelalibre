<?php
include("../includes/observer-functions.php");
$q=$_GET['q'];

switch($q){
	case "cursos":
		getClases($_COOKIE['HID']);
	break;
	case "alumnos":
		$id_course = $_GET['id_course'];
		getStudientsByCourse($_COOKIE['HID'], $id_course);
	break;
	case "horarios" :
		$id_course = @$_GET['id_course'];
		getSchedule($_COOKIE['HID'], $id_course);
	break;
	case "asistencia" :
		$id_course = $_GET['id_course'];
		getAssistance($_COOKIE['HID'], $id_course);
	break;
	case "listamateriales" :
		$id_course = $_GET['id_course'];
		getMaterialsList($id_course);
	break;
	default:
		echo "DataStore not exists";
}
?>