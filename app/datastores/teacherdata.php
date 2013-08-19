<?php
include("../includes/teacher-functions.php");
$q=$_GET['q'];

// just for test code
//$_COOKIE['HID'] = 'eccbc87e4b5ce2fe28308fd9f2a7baf3';
//

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