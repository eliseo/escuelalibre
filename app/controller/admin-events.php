<?php
include("../includes/admin-functions.php");

$action=$_GET['a'];

switch($action){
	case "newPeriod":
		if($_POST['dayP'] != "" && $_POST['nPeriod'] !=""){
			$dayP=$_POST['dayP'];
			$nPeriod=$_POST['nPeriod'];
			if(createPeriod($dayP,$nPeriod)){ 
				echo "success"; 
			}else{ echo "Error al crear periodo, intente nuevamente"; }
		}else{ echo "Ingresa Campos Obligatorio"; }
	break;
	case "newCourse":
	if($_POST['name_course'] !="" && $_POST['desc_course'] !="" && $_POST['profId'] !="" && $_POST['start_date'] != "" && $_POST['end_date'] != "" && $_POST['periodId'] != ""){

	$rd=array();
	$td=array();
	$name_course=$_POST['name_course'];
	$desc_course=$_POST['desc_course'];
	$profId=$_POST['profId'];
	$start_date=$_POST['start_date'];
	$end_date=$_POST['end_date'];
	$periodId=$_POST['periodId'];
	
	for($i=1;$i<8;$i++){
		$param="rd".$i;
		if(isset($_POST[$param])){ $rd[$i]= $_POST[$param]; }
	}
	
	for($i=1;$i<8;$i++){
		$param="time".$i;
		if(isset($_POST[$param])){ $td[$i]= $_POST[$param]; }
	}
	
	$fcourse = new fCourse;
	if($fcourse->createCourse($name_course,$desc_course,$profId,$periodId,$start_date,$end_date,$rd,$td)){
		echo "success";
	}else{	echo $fcourse->last_error;	}
	

	}else{ echo "error"; }
	break;
	case "studentToCourse":
		$id_student=$_GET['id_student'];
		$id_course=$_GET['id_course'];
		if(studentToCourse($id_student,$id_course)){
			echo "success";
		}else{ echo "error, please try again"; }
	break;
	case "delStudentFromCourse":
		if(isset($_GET['id_student']) && isset($_GET['id_course'])){
			if(delStudentFromCourse($_GET['id_student'],$_GET['id_course'])){
				echo "success";
			}else{	echo "error deleting user, try again";	}
		}
	break;
	case "newEval":
	
		if(isset($_POST['name_eval']) && isset($_POST['desc_eval']) && isset($_POST['id_course'])){
			$name_eval = $_POST['name_eval']."_".$_POST['id_course'];
			if(createEval($_POST['id_course'], $name_eval, $_POST['desc_eval'])){
				echo "success";
			}else{ echo "error, name in use!"; }
		}else{ echo "error, values missing, try again!"; }
		
	break;
	case "observerToCourse":
	
			$id_observer = $_GET['id_observer'];
			$id_course = $_GET['id_course'];
			if(observerToCourse($id_observer,$id_course)){
				echo "success";
			}else{ echo "error, please try again"; }
	
	break;
	case "delObservFromCourse":
	
			if(isset($_GET['id_observer']) && isset($_GET['id_course'])){
				if(delObserverFromCourse($_GET['id_observer'],$_GET['id_course'])){
					echo "success";
				}else{	echo "error deleting user, try again";	}
			}
	break;
	case "chStatEval":
			$id_eval = $_POST['id_eval'];
			$available = $_POST['available'];
			if(changeStatEval($id_eval,$available)){ echo "success"; }else{ echo "error, intente nuevamente!"; } 
	break;
	case "delCourse":
		if(isset($_REQUEST['id_course'])){
			$id_course = $_REQUEST['id_course'];
			$fcourse = new fCourse;	
			if($fcourse->deleteCourse($id_course)){ echo "success"; }else{ echo "error deleting, sorry!"; }
			}else{ echo "error, values missing try again!";   }
	break;
	default:
	break;
}
?>