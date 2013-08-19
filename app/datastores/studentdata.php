<?php
include("../includes/student-functions.php");

$hid = $_COOKIE['HID'];
$ut = new userType($hid);
$id_user = $ut->id_user;

$q = $_GET['q'];

switch($q){
	case "courseslist":
		getCoursesUser($id_user);
	break;
	case "horarios":
	$id_course = $_GET['id_course'];
	getSchedule($id_user, $id_course);
	break;
	case "asistencia":
		$id_course = $_GET['id_course'];
		getAssistance($id_user, $id_course);
	break;
	case "ratings":
		$id_course = $_GET['id_course'];
		getRatingsStudent($id_user,$id_course);
	break;
	case "listamateriales":
		if(isset($_GET['id_course'])){
			getMaterialsList($_GET['id_course'],$id_user);
		}else{ echo "error"; }
	break;
	default:
	break;
}



?>