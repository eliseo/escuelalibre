<?php
include_once("general-functions.php");

function getCoursesUser($id_student){
	global $ndb;
	$info_users=array();
	$query = "SELECT id_course FROM classmates WHERE id_student=$id_student ORDER BY id DESC";
	$data = $ndb->get_results($query);
	
	foreach($data as $col){
		
		$query2 = "SELECT * FROM courses WHERE id=$col->id_course";
		$data2 = $ndb->get_row($query2);
		
		
		$info_users[] = array("id_course" => $col->id_course , "name_course" => $data2->name_course, "desc_courses" => $data2->desc_course, "id_professor" => $data2->id_professor, "id_period" => $data2->id_period, "start_date" => $data2->start_date, "end_date" => $data2->end_date);
		
	}
	echo json_encode($info_users);
}

function getSchedule($id_user, $id_course = false ){
	global $ndb;
	$info=array();
	$query = "SELECT  a.horario, 
	     MAX(lunes) AS lunes, 
	     MAX(martes) AS martes, 
	     MAX(miercoles) AS miercoles, 
	     MAX(jueves) AS jueves, 
	     MAX(viernes) AS viernes, 
	     MAX(sabado) AS sabado, 
	     MAX(domingo) AS domingo 
	    FROM (
	    SELECT  
	     MAX(ds.id_course) AS id_course,
	     CONCAT(start_time, ' - ', end_time) AS horario
	    FROM courses c 
	    JOIN classmates cm ON c.id = cm.id_course
	    JOIN users_priv priv ON cm.id_student = priv.id_user AND priv.func_1 = 1 
	    JOIN daily_schedule ds ON c.id = ds.id_course 
	    WHERE  cm.id_student = $id_user
	     AND ds.id_course = $id_course
	    GROUP BY CONCAT(start_time, ' - ', end_time)
	    ) a, 
	    (
	    SELECT 
	     MAX(ds.id_course) AS id_course,
	     CASE WHEN ds.num_day = 1 THEN r.desc ELSE 0 END AS lunes,
	     CASE WHEN ds.num_day = 2 THEN r.desc ELSE 0 END AS martes,
	     CASE WHEN ds.num_day = 3 THEN r.desc ELSE 0 END AS miercoles,
	     CASE WHEN ds.num_day = 4 THEN r.desc ELSE 0 END AS jueves,
	     CASE WHEN ds.num_day = 5 THEN r.desc ELSE 0 END AS viernes,
	     CASE WHEN ds.num_day = 6 THEN r.desc ELSE 0 END AS sabado,
	     CASE WHEN ds.num_day = 7 THEN r.desc ELSE 0 END AS domingo, 
	     CONCAT(start_time, ' - ', end_time) AS horario
	    FROM courses c 
	    JOIN classmates cm ON c.id = cm.id_course
	    JOIN users_priv priv ON cm.id_student = priv.id_user AND priv.func_1 = 1 
	    JOIN daily_schedule ds ON c.id = ds.id_course 
	    JOIN rooms_availab ra ON c.id = ds.id_course
	    JOIN rooms r ON ra.id_room = r.id_room
	    WHERE  cm.id_student = $id_user
	     AND ds.id_course = $id_course
	    GROUP BY ds.num_day , CONCAT(start_time, ' - ', end_time) 
	    ) b
	    WHERE a.id_course = b.id_course AND b.horario = a.horario
	    GROUP BY a.horario";
	$data=$ndb->get_results($query);

	// Si no hay resultados devuelve falso
	if(!$data) return false;
	
	// Se recorre el arreglo de datos para cargarlos en formato json
	foreach($data as $col){
		$info[]=array(	"horario"=>utf8_encode($col->horario),
						"lunes"=>utf8_encode($col->lunes),
						"martes"=>utf8_encode($col->martes),
						"miercoles"=>utf8_encode($col->miercoles),
						"jueves"=>utf8_encode($col->jueves),
						"viernes"=>utf8_encode($col->viernes),
						"sabado"=>utf8_encode($col->sabado),
						"domingo"=>utf8_encode($col->domingo)
						); 
	}
	echo json_encode($info);
}

function getAssistance($id_user, $id_course=false){
	global $ndb;
	$info=array();
	$query = "SELECT DISTINCT
					p.lun, 
					p.mar, 
					p.mier, 
					p.juev, 
					p.vier, 
					p.sab,
					p.dom,
					c.start_date,
					c.end_date
				FROM courses c
				JOIN period p ON c.id_period = p.id_period
				JOIN classmates cm ON c.id = cm.id_course
				WHERE cm.id_course=$id_course AND cm.id_student=$id_user";
	$data=$ndb->get_results($query);
	foreach($data as $col){
		$info[]=array(	1=>$col->lun,
						2=>$col->mar,
						3=>$col->mier,
						4=>$col->juev,
						5=>$col->vier,
						6=>$col->sab,
						7=>$col->dom,
					); 
	}

	$data=$ndb->get_row($query);
	
	/*
		Calculando dias intermedios para el periodo
	*/
	
	$start_date = $data->start_date;
	$end_date = $data->end_date;
	$fechas = array();
	
	//2011-02-02
	$init = mktime(0,0,0,(int)substr($start_date,5,2), (int)substr($start_date, 8,2), (int)substr($start_date,0,4));
	$end = mktime(0,0,0,(int)substr($end_date, 5,2), (int)substr($end_date,8,2), (int)substr($end_date,0,4));
	
	while($init <= $end){
		$day = date('N', $init);
		if($info[0][$day]==1){$fechas[] = date('Y-m-d', $init);}
		$init = $init + 24 * 60 * 60 ;
	}
	
	//Agregar información de fechas al array info
	$info['fechas'] = $fechas;
	
	
	/// Consultar la lista de alumnos para este curso
	$query = "	SELECT 	u.hid, u.f_lastname, u.s_lastname, u.name
				FROM users u
				JOIN classmates c ON u.id = c.id_student
				WHERE c.id_course = $id_course AND c.id_student=$id_user ORDER BY u.f_lastname, u.s_lastname, u.name";
	
	$alumnos=$ndb->get_results($query);
	$alu = array();
	if(count($alumnos)>0){
		foreach($alumnos as $a){
			$alu[] = array(	'hid'=>$a->hid, 
							'f_lastname'=>$a->f_lastname,
							's_lastname'=>$a->s_lastname,
							'name'=>$a->name
							);
		}
	}
	
	$info['alumnos'] = $alu;
	
	/// Consultar las assistencias ya confirmadas en la base de datos
	$query = "	SELECT 	u.hid, a.date as fecha
				FROM users u
				JOIN classmates c ON u.id = c.id_student
				JOIN assistance a ON u.hid = a.hid_student
				WHERE c.id_course = $id_course AND a.assistance = 1";
	
	$asistencias=$ndb->get_results($query);
	$asis = array();
	
	if(count($asistencias)>0){
		foreach($asistencias as $asistencia){
			$asis[] = array('hid'=>$asistencia->hid, 'fecha'=>$asistencia->fecha, 'now'=>0 );
		}
	}
	$info['asistencias'] = $asis;
	
	/// Consultar la estadistica de inasistencias
	
	$query = "	SELECT 	u.hid,
					COUNT(a.assistance) AS assistances
				FROM users u
				JOIN classmates c ON u.id = c.id_student
				LEFT JOIN assistance a ON u.hid = a.hid_student
				WHERE c.id_course = $id_course AND a.assistance = 1
				GROUP BY u.hid";
	$resumen_asis = $ndb->get_results($query);
	$tmp_asis = array();
	if(count($resumen_asis)>0){
		foreach($resumen_asis as $v){
			$tmp_asis[] = array(
							"hid"=>$v->hid,
							"assistances"=>$v->assistances
						);
		}
	}
	
	$info["resumen_asistencias"] = $tmp_asis;
	
	echo json_encode($info);
}

function getMaterialsList($id_course, $id_user){
	global $ndb;

	$query = "SELECT cd.id, cd.name, cd.desc,cd.creation_date,cd.modif_date
				FROM course_documents cd
				JOIN classmates c ON cd.id_course = c.id_course
				WHERE cd.id_course = $id_course AND c.id_student=$id_user";
				
	if(!($ndb->query($query))) exit(0);
	
	$rs = $ndb->get_results($query);
	$info = array();
	foreach($rs as $material){
		$info[] = array(	"id"=>$material->id, 
							"name"=>$material->name,
							"desc"=>$material->desc,
							"creation_date"=>($material->creation_date == null ? 'SF' : $material->creation_date),
							"modif_date"=>($material->modif_date == null ? 'SF' : $material->modif_date)
					);
	}
	
	echo json_encode($info);
}

function getRatingsStudent($id_student,$id_course){
	global $ndb;
	$info = array();
	$query = "	SELECT 
				stu.hid,
				stu.f_lastname, 
				stu.s_lastname,
				stu.name,
				stu.email
				FROM courses c 
				JOIN classmates cm ON c.id = cm.id_course
				JOIN users stu ON cm.id_student = stu.id 
				WHERE stu.id = '$id_student' AND c.id = $id_course 
				ORDER BY f_lastname, s_lastname";
				

	$data=$ndb->get_results($query);
	// Si no hay resultados devuelve falso
	if(!$data) return false;
	
	// Se recorre el arreglo de datos para cargarlos en formato json
	$students = array();
	foreach($data as $col){
		$students[]=array(	"hid"=>$col->hid,
						"f_lastname"=>$col->f_lastname,
						"s_lastname"=>$col->s_lastname,
						"name"=>$col->name,
						"email"=>$col->email
						); 
	}
	
	$info['students'] = $students;
	
	// Obtiene las calificaciones asociadas a ese alumno
	$query = "	SELECT u.hid, 
				cm.id AS id_classmate, 
				et.id AS id_evaluation_type,
				et.name AS evalname,
				et.description as evaldesc,
				r.rating,
				r.comment
			FROM classmates cm
			JOIN users u ON u.id = cm.id_student 
			JOIN evaluation_type et ON et.id_course = cm.id_course
			LEFT JOIN ratings r ON cm.id = r.id_classmate AND r.id_evaluation_type = et.id
			WHERE cm.id_course = $id_course AND cm.id_student=$id_student
			ORDER BY hid, et.id";

	$data = $ndb->get_results($query);
	$ratings = array();
	$a = array();
	foreach($data as $col){
		$hid = $col->hid;
		$ratings[$hid][] = array(
							"hid" => $hid, 
							"id_classmate" => $col->id_classmate,
							"id_eval_type" => $col->id_evaluation_type,
							"evalname" => $col->evalname,
							"evaldesc" => $col->evaldesc,
							"rating" => $col->rating,
							"comment" => $col->comment
						);
	}
	
	$info['evals'] = $ratings;
	echo json_encode($info);
}


?>