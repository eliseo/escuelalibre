<?php
include_once("general-functions.php");

function showInfoProfesores(){
	global $ndb;
	$info_profesores=array();
	$query="SELECT id_user FROM users_priv WHERE func_2=1";
	$data=$ndb->get_results($query);
		foreach($data as $col){
			$id_user=$col->id_user;
			$query="SELECT id,name,f_lastname FROM users WHERE id=$id_user";
			$data=$ndb->get_results($query);
			foreach($data as $col){
				$id=$col->id; $name=$col->name; $f_lastname=$col->f_lastname;
				$info_profesores[]=array("id_profesor"=>$id,"name_profesor"=>$name,"f_lastname"=>$f_lastname);
			}
		}	
		echo json_encode($info_profesores);
}

function showInfoPeriod($id){
	global $ndb;
	$info = array();
	if($id != 0){
		$query="SELECT * FROM period WHERE id_period='$id'";
	}else{
		$query="SELECT * FROM period";
	}
	$data=$ndb->get_results($query);
		foreach($data as $col){
			$id_period=$col->id_period; $name_period=$col->name_period;
			$info[]=array("id_period"=>$id_period,"name_period"=>$name_period,"lun"=>$col->lun,"mar"=>$col->mar,"mier"=>$col->mier,"juev"=>$col->juev,"vier"=>$col->vier,"sab"=>$col->sab,"dom"=>$col->dom); 
		}
	echo json_encode($info);
}

function getUserTypes(){
	global $ndb;
	$info_usertypes=array();
	$query="SELECT id, description FROM priv_desc";
	$data=$ndb->get_results($query);
	foreach($data as $col){
		$info_usertypes[] = array("id" => $col->id , "description" => $col->description);
	}
	echo json_encode($info_usertypes);
}

function getNameTypeUser($id_user){
	global $ndb;
	$query = "SELECT func_1,func_2,func_3,func_4,func_5 FROM users_priv WHERE id_user=$id_user";
	$data  = $ndb->get_results($query);
	$i = 1;
	foreach($data as $func){
		foreach($func as $func_num){
			if($func_num == 1){
				$name_func = "func_".$i;
				$query2 = "SELECT description FROM priv_desc WHERE name='$name_func'";
				$data2 = $ndb->get_row($query2);
				return $data2->description;
			}
			$i++;
		}
	}
}

function getUserList(){
	global $ndb;
	$info_users=array();
	$query = "SELECT id, `user`, `name`,  CONCAT(f_lastname ,' ', s_lastname) AS lastname, email FROM users ORDER BY `name`";
	$data = $ndb->get_results($query);
	foreach($data as $col){

		$name_type_user = getNameTypeUser($col->id);
		$info_users[] = array("id" => $col->id , "user" => $col->user, "name" => $col->name, "lastname" => htmlentities(utf8_decode($col->lastname)), "email" => $col->email,"nameTypeUser" =>$name_type_user );
	}
	echo json_encode($info_users);
}

//new function for retrieve all kind of users (students, teachers, admins, ops...)
function getUsersList($type,$id_course=0,$left=0){
	global $ndb;
	$info_users = array();
	$query = "SELECT * FROM users u, users_priv up WHERE up.func_1 = 1 AND u.id = up.id_user ORDER BY name ASC";		

	$data = $ndb->get_results($query);
	//echo $query;
	foreach($data as $col){
		$info_users[] = array("id_user" => $col->id, "user" => $col->user, "name_user" => $col->name, "f_lastname" => $col->f_lastname, "s_lastname" => utf8_encode($col->s_lastname), "email" => $col->email );
	}
	echo json_encode($info_users);
}


function getEvaluationsList($id_course){
	global $ndb;
	$info_users = array();
	$sem01 = array(); $sem02 = array(); $sem03 = array(); $sem04 = array();
	
	$query1 = "SELECT * FROM evaluation_type WHERE id_course=$id_course AND name LIKE '%sem01%'";
	$data1 = $ndb->get_results($query1);
	foreach($data1 as $col1){
		$sem01[] = array("id" => $col1->id,"name_eval" => $col1->name, "description_eval" => $col1->description, "available" => $col1->available);
	}
	
	$query2 = "SELECT * FROM evaluation_type WHERE id_course=$id_course AND name LIKE '%sem02%'";
	$data2 = $ndb->get_results($query2);
	foreach($data2 as $col2){
		$sem02[] = array("id_eval" => $col2->id, "name_eval" => $col2->name, "description_eval" => $col2->description, "available" => $col2->available);
	}
	
	$query3 = "SELECT * FROM evaluation_type WHERE id_course=$id_course AND name LIKE '%sem03%'";
	$data3 = $ndb->get_results($query3);
	foreach($data3 as $col3){
		$sem03[] = array("id_eval" => $col3->id, "name_eval" => $col3->name, "description_eval" => $col3->description, "available" => $col3->available);
	}
	
	$query4 = "SELECT * FROM evaluation_type WHERE id_course=$id_course AND name LIKE '%sem04%'";
	$data4 = $ndb->get_results($query4);
	foreach($data4 as $col4){
		$sem04[] = array("id_eval" => $col4->id, "name_eval" => $col4->name, "description_eval" => $col4->description, "available" => $col4->available);
	}
	
	$info_users[] = array("sem01" => $sem01, "sem02" => $sem02, "sem03" => $sem03, "sem04" => $sem04 );
	
	echo json_encode($info_users);
}

function changeStatEval($id_eval,$available){
	global $ndb;
	$query = "UPDATE evaluation_type SET available=$available WHERE id=$id_eval";
	$return_val = ($ndb->query($query)) ? true : false;
	return $return_val;
}


function getUserData($hid){
	global $ndb;
	$info_user=array();
	$query = "SELECT * FROM users WHERE hid='$hid'";
	$data = $ndb->get_results($query);
	foreach($data as $col){
		$info_user[] = array(	"id" => $col->id , 
								"hid" => $col->hid , 
								"user" => $col->user, 
								"name" => $col->name, 
								"f_lastname" => $col->f_lastname, 
								"s_lastname" => $col->s_lastname, 
								"email" => $col->email, 
								"bday" => $col->bday, 
								"address" => $col->address,
								"civil_status" => $col->civil_status,
								"tel" => $col->tel
							);
	}
	echo json_encode($info_user);
}

function createPeriod($dayP,$nPeriod){
		global $ndb;
		$query="SELECT * FROM period WHERE name_period='$nPeriod'";
		if($ndb->get_results($query)){ return false; }
		$days=array();
		$string_val="";
		$nameDays=array(1=>"lun",2=>"mar",3=>"mier",4=>"juev",5=>"vier",6=>"sab",7=>"dom");
		foreach($dayP as $key2=>$value2){
			for($i=1;$i<8;$i++){
				if($value2==$nameDays[$i]){
					$days[$i]=1;
				}
			}
		}
		
		for($i=1;$i<8;$i++){
			if($days[$i]==1){ $val=1; }else{ $val=0; }
			$string_val.= $val.",";
			if($i==7){
				$string_val = substr($string_val, 0, -1);
			}
		}
		$query="INSERT INTO period(name_period,lun,mar,mier,juev,vier,sab,dom) VALUES('$nPeriod',$string_val)";
		if($ndb->query($query)){ return true; }else{ return false;}
}


function getRoomsAvailab($nd,$ts,$te){
	global $ndb;
	$query="SELECT * FROM rooms WHERE id_room NOT IN (SELECT id_room FROM rooms_availab WHERE time_start >= '$ts' AND time_end <= '$te' AND num_day =$nd)";
	$data=$ndb->get_results($query);
	foreach($data as $col){
		$info_user[] = array("id_room"=>$col->id_room,
							  "name_room"=>$col->name);
	}
	echo json_encode($info_user);
}

function getRooms(){
	global $ndb;
	$query="SELECT * FROM rooms";
	$data=$ndb->get_results($query);
	foreach($data as $col){
		$info_user[] = array("id_room"=>$col->id_room, "name_room"=>$col->name, "desc_room" => utf8_encode($col->desc));
	}
	echo json_encode($info_user);
}

/// function getCoursesList was moved to general-functions.php///
function getCoursesList(){
	global $ndb;
	$info_users=array();
	$query = "SELECT * FROM courses ORDER BY id DESC";
	$data = $ndb->get_results($query);

	foreach($data as $col){
		$info_users[] = array("id_course" => $col->id , "name_course" => $col->name_course, "desc_courses" => $col->desc_course, "id_professor" => $col->id_professor, "id_period" => $col->id_period, "start_date" => $col->start_date, "end_date" => $col->end_date);
	}
	echo json_encode($info_users);
}


class fCourse{
	
	function createCourse($name_course,$desc_course,$profId,$periodId,$start_date,$end_date,$rd,$td){
		global $ndb;
		$e=0;
		//we init this process with the clases table
		$query="INSERT INTO courses(name_course,desc_course,id_professor,id_period,start_date,end_date) VALUES('$name_course','$desc_course',$profId,$periodId,'$start_date','$end_date')";
		
		if($ndb->query($query)){
			$id_course=$ndb->insert_id;
		}else{
			$e=1;
			$this->register_error("Problem inserting data to users table");
		}
		
		//inserting evaluation_type default "final"
		//and inserting the other evaluations:
		//c001_sem01_comunicacion, c001_sem01_interaccion, c001_sem01_precision, c001_sem01_fluidez, c001_sem01_pronunciacion
		$type_courses = array(
							1 => "comunicacion",
							2 => "interaccion",
							3 => "precision",
							4 => "fluidez",
							5 => "pronunciacion"
						);

		for($i=1;$i<5;$i++){
			$d=1;
			foreach($type_courses as $tc){
				$name = "sem0".$i."_".$tc."<br/>";
				$query="INSERT INTO evaluation_type(id_course,name,description) VALUES($id_course,'$name','$description')";
				$ndb->query($query);
			}
		}
		
		
		//then we insert info into daily schedule and rooms available
		$query = "SELECT * FROM period WHERE id_period=$periodId";
		
		$data = $ndb->get_row($query);
		$daysA=array(
						1=>$data->lun,
						2=>$data->mar,
						3=>$data->mier,
						4=>$data->juev,
						5=>$data->vier,
						6=>$data->sab,
						7=>$data->dom,
				);

		$query="";
		$i=1;
		foreach($daysA as $value){
			if($value == 1){
				$start_time = $td[$i][0];
				$end_time = $td[$i][1];
				$id_room = $rd[$i][0];
				$query = "INSERT INTO daily_schedule(id_course,num_day,id_period,start_time,end_time) VALUES($id_course,$i,$periodId,'$start_time','$end_time')";
				
				if(!($ndb->query($query))){
					$e=1;
					$this->register_error("Problem inserting data to daily_schedule table");
				} 
				
				$query = "INSERT INTO rooms_availab(id_room,id_course,num_day,time_start,time_end) VALUES($id_room,$id_course,$i,'$start_time','$end_time')";
				if(!($ndb->query($query))){
					$e=1;
					$this->register_error("Problem inserting data to rooms_availab table");
				}
			}
			$i++;
		}
		if($e==0){ return $id_course; }else{ return false;}
		
	}
	
		function updateCourse(){
			global $ndb;
		}
	
		function deleteCourse(){
			global $ndb;
		}
	
		function getCourseInfo($id_course){
			global $ndb;
			$info_users = array();
			$ds = array();
			$query=	"SELECT 
					c.id AS id,
					c.name_course AS name_course,
					c.desc_course AS desc_course,
					u.id AS id_professor,
					c.id_period AS id_period,
					c.start_date AS start_date,
					c.end_date AS end_date,
					CONCAT(u.f_lastname,',', u.name)  AS  name_professor
					FROM courses c 
					JOIN users u ON c.id_professor=u.id WHERE c.id=$id_course";	
					
			$data = $ndb->get_row($query);
		
			$query2="SELECT * FROM daily_schedule WHERE id_course=$id_course";
			$data2=$ndb->get_results($query2);
		
			foreach($data2 as $col){
				$query3="SELECT id_room FROM rooms_availab WHERE id_course=$id_course AND num_day=$col->num_day";
				$data3 = $ndb->get_row($query3);
				$name_day = "";
				switch($col->num_day){
					
					case "1": $name_day = "Lunes"; break;
					case "2": $name_day = "Martes"; break;	
					case "3": $name_day = "Miércoles"; break;
					case "4": $name_day = "Jueves"; break;
					case "5": $name_day = "Viernes"; break;
					case "6": $name_day = "Sábado"; break;
					case "7": $name_day = "Domingo"; break;
					default: break;
				}
				
				$ds[]=array("name_day" => $name_day,"start_time" => $col->start_time, "end_time" => $col->end_time,"id_room" => $data3->id_room);
			}
		
			$info_users[] = array("id_course" => $data->id , "name_course" => $data->name_course, "desc_course" => $data->desc_course, "name_professor" => $data->name_professor, "id_period" => $data->id_period, "start_date" => $data->start_date, "end_date" => $data->end_date,"daily_schedule" => $ds);
		
			echo json_encode($info_users);
		}
	
	
		function register_error($err_str){
			$this->last_error = $err_str;
			$this->captured_errors[] = array('error_str' => $err_str);
		}
}

function studentToCourse($id_student,$id_course){
	global $ndb;
	$query="SELECT * FROM classmates WHERE id_student=$id_student AND id_course=$id_course";
	if(!($ndb->query($query))){
		$query="INSERT INTO classmates(id_student,id_course) VALUES($id_student,$id_course)";
		$return_val = ($ndb->query($query)) ? true : false;
	}else{
		$return_val=false;
	}
	return $return_val;
}

function delStudentFromCourse($id_student,$id_course){
	global $ndb;
	$query="DELETE FROM classmates wHERE id_student=$id_student AND id_course=$id_course";
	
	$return_val = ($ndb->query($query)) ? true : false;
	return $return_val;
}

function observerToCourse($id_observer,$id_course){
	global $ndb;
	$query = "SELECT * FROM observer WHERE id_user=$id_observer AND id_course=$id_course";
	if(!($ndb->query($query))){
		$query="INSERT INTO observer(id_user,id_course) VALUES($id_observer,$id_course)";
		$return_val = ($ndb->query($query)) ? true : false;
	}else{
		$return_val=false;
	}
	return $return_val;
}

function delObserverFromCourse($id_observer,$id_course){
	global $ndb;
	$query="DELETE FROM observer wHERE id_user=$id_observer AND id_course=$id_course";
	
	$return_val = ($ndb->query($query)) ? true : false;
	return $return_val;
}


/*lines added*/

function roomsAvailab($id_room,$start_date,$end_date){
	global $ndb;
	if($id_room != 0){
		$query="SELECT * FROM rooms_availab WHERE id_room=$id_room";
	}else{
		$query="SELECT * FROM rooms_availab";
	}
	if($ndb->query($query)){
		$data = $ndb->get_results($query);
		$info_user = array();
	}else{
		echo "información no disponible";
		exit();
	}
	
	foreach($data as $col){
		$id = $col->id;
		$id_course = $col->id_course;
		$time_start = $col->time_start;
		$time_end = $col->time_end;

		$query2 = "SELECT * FROM rooms WHERE id_room=$col->id_room";
		$data2 = $ndb->get_row($query2);
		$name_room = $data2->name;
	
		
		$query3 = "SELECT start_date, end_date, id_period, name_course FROM courses WHERE id=$id_course AND end_date < $end_date";
		$data3 = $ndb->get_row($query3);
		$start_date_room = $data3->start_date;
		$end_date_room = $data3->end_date;
		$name_course = $data3->name_course;
		
		$id_period = $data3->id_period;
		$query4="SELECT * FROM period WHERE id_period=$id_period";
		$data4 = $ndb->get_row($query4);
		$days_a = array(
						1=>$data4->lun,
						2=>$data4->mar,
						3=>$data4->mier,
						4=>$data4->juev,
						5=>$data4->vier,
						6=>$data4->sab,
						7=>$data4->dom,
				);
		
		//analyze each day from start_date from end_date
		//$start_date and $end_date are timestamps
		$init = $start_date;
		$end = $end_date;

		while($init <= $end){
			$day = date('N', $init);
			if($days_a[$day]==1){
				
				//$start = date('Y-m-d', $init);
				$start_t = mktime((int)substr($time_start,0,2),(int)substr($time_start,3,2),(int)substr($time_start,6,2), date("m",$init), date("d",$init), date("Y",$init)); 
				
				$start_t = date('Y-m-d H:i:s', $start_t);
				
				$end_t = mktime((int)substr($time_end,0,2),(int)substr($time_end,3,2),(int)substr($time_end,6,2), date("m",$init), date("d",$init), date("Y",$init));
				
				$end_t = date('Y-m-d H:i:s', $end_t);
				
				$info_user[] = array(
										"id" =>	$id,
										"title" => $name_room."C:".$name_course,
										"start" => $start_t,
										 "end"	=> $end_t,
										"allDay" => false 
									);
			}
			
			$init = $init + 24 * 60 * 60 ;
		}
		
	}
	
	echo json_encode($info_user);
}





function createEval($id_course,$name_eval,$desc_eval){
	global $ndb;
	//check if this name eval exist
	$query = "SELECT * FROM evaluation_type WHERE name='$name_eval'";
	if(!($ndb->query($query))){
		$query = "INSERT INTO evaluation_type(id_course,name,description) VALUES($id_course,'$name_eval','$desc_eval')";
		$return_val = ($ndb->query($query)) ? true : false;
		return $return_val;
	}else{
		return false;
	}
}

function getStudentData($id_student){
	global $ndb;
	$info_user = array();
	$courses = array();
	
	$query="SELECT * FROM courses WHERE id IN(SELECT id_course FROM classmates WHERE id_student=$id_student) ORDER BY id DESC";
	if($ndb->query($query)){
		$data = $ndb->get_results($query);
		foreach($data as $col){
			$courses[] = array("id_course" => $col->id , 
								"name_course" => $col->name_course, 
								"desc_course" => $col->desc_course, 
								"id_professor" => $col->id_professor, 
								"id_period" => $col->id_period, 
								"start_date" => $col->start_date, 
								"end_date" => $col->end_date			
							);
		}
	}	
	
	$query = "SELECT * FROM users WHERE id=$id_student";
	$data = $ndb->get_results($query);
	foreach($data as $col){
	
		$cs = '';
		switch($col->civil_status){
			case 1 :
				$cs = 'Soltero';
				break;
			case 2 :
				$cs = 'Casado';
				break;
			case 3 :
				$cs = 'Divorciado';
		}
		
		$info_user[] = array(	"id_student" => $col->id , 
								"user" => $col->user, 
								"name_student" => $col->name, 
								"f_lastname" => $col->f_lastname, 
								"s_lastname" => $col->s_lastname, 
								"email" => $col->email, 
								"bday" => $col->bday, 
								"address" => $col->address,
								"civil_status" => $cs,
								"tel" => $col->tel,
								"courses" => $courses,
							);
	}
	echo json_encode($info_user);
}

?>