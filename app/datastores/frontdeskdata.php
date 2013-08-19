<?php
include("../includes/frontdesk-functions.php");
$q=$_GET['q'];

switch($q){
	case "profesores":
		showInfoProfesores();
	break;
	case "periods":
		if(isset($_GET['id'])){ $id=$_GET['id']; }else{ $id=0; }
		showInfoPeriod($id);
	break;
	case "usertypes":
		getUserTypes();
	break;
	case "userlist":
		getUserList();
	break;
	case "userdata":
		$hid = $_POST['hid'];
		getUserData($hid);
	break;
	case "rooms_availab":
		if(isset($_GET['nd']) && isset($_GET['ts']) && isset($_GET['te'])){
			getRoomsAvailab($_GET['nd'],$_GET['ts'],$_GET['te']);
		}
		break;
	case "courseslist":
		getCoursesList();
	break;
	case "coursedata":
		$id_course=$_GET['id_course'];
		$fc = new fCourse;
		$fc->getCourseInfo($id_course);
	break;
	case "studentslist":
		if(isset($_GET['id_course'])){ $id_course = $_GET['id_course']; }else{ $id_course = 0;}
		if(isset($_GET["left"])){ $left = 1; }else{ $left = 0; }
		getUsersList("student",$id_course,$left);
	break;
	case "getRooms":
		getRooms();
	break;
	case "roomsAvailab":
		$start= $_GET['start'];
		$end = $_GET['end'];
		$id_room = $_GET['id_room'];
		roomsAvailab($id_room,$start, $end);
	break;
	case "studentdata":
		if(isset($_GET['id_student'])){
			$id_student = $_GET['id_student'];
			getStudentData($id_student);
		}
		break;
	case "observerslist":
		if(isset($_GET['id_course'])){ $id_course = $_GET['id_course']; }else{ $id_course = 0;}
		getUsersLIst("observer",$id_course);
		break;
	case "evaluationslist":
			if(isset($_GET['id_course'])){
				$id_course = $_GET['id_course'];
				getEvaluationsList($id_course);
			}
		break;
	default:
	break;
}

?>