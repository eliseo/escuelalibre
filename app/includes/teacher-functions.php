<?php
include("ez_sql_mysql.php");

function getClases($hid){
	global $ndb;
	$info=array();
	$query = "SELECT DISTINCT
				c.id, 
				c.name_course, 
				c.desc_course, 
				c.start_date, 
				c.end_date,
				r.desc AS room
			FROM courses c 
			JOIN users pro ON c.id_professor = pro.id 
			JOIN users_priv priv ON pro.id = priv.id_user AND priv.func_2 = 1 
			JOIN rooms_availab ra ON c.id = ra.id_course
			JOIN rooms r ON ra.id_room = r.id_room
			WHERE pro.hid = '$hid'";
	//echo $query;
	$data=$ndb->get_results($query);
	// Si no hay resultados devuelve falso
	if(!$data) return false;
	
	// Se recorre el arreglo de datos para cargarlos en formato json
	foreach($data as $col){
		$info[]=array(	"id_course"=>$col->id,
						"name_course"=>$col->name_course,
						"desc_course"=>$col->desc_course,
						"start_date"=>$col->start_date,
						"end_date"=>$col->end_date,
						"room"=>utf8_encode($col->room)
						); 
	}
	echo json_encode($info);
}

function getStudientsByCourse($hid=false, $id_course=false){
	global $ndb;
	$info=array();
	$query = "	SELECT 
				stu.hid,
				stu.f_lastname, 
				stu.s_lastname,
				stu.name,
				stu.email
				-- r.rating
				FROM courses c 
				JOIN users pro ON c.id_professor = pro.id 
				JOIN users_priv priv ON pro.id = priv.id_user AND priv.func_2 = 1 
				JOIN classmates cm ON c.id = cm.id_course
				JOIN users stu ON cm.id_student = stu.id 
				-- LEFT JOIN ratings r ON r.id_classmate = cm.id
				WHERE pro.hid = '$hid' AND c.id = $id_course 
				ORDER BY f_lastname, s_lastname";
	//echo $query;
	$data=$ndb->get_results($query);
	// Si no hay resultados devuelve falso
	if(!$data) return false;
	
	// Se recorre el arreglo de datos para cargarlos en formato json
	$students = array();
	foreach($data as $col){
		$students[]=array(	
						"hid"=>$col->hid,
						"f_lastname"=>$col->f_lastname,
						"s_lastname"=>$col->s_lastname,
						"name"=>$col->name,
						"email"=>$col->email
						// "rating"=>$col->rating
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
			WHERE cm.id_course = $id_course
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

function getSchedule($hid=false, $id_course = false ){
	global $ndb;
	$info=array();
	
	$query = "select u.hid, up.* from users u, users_priv up where u.id = up.id_user and u.hid = '$hid'";
	$usertype = $ndb->get_row($query);
	
	
	if($usertype->func_1 == 1){
		// Consulta de horarios para estudiantes
		$query = "SELECT 	a.horario, 
							b.name_course,
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
						JOIN users pro ON cm.id_student = pro.id  
						JOIN users_priv priv ON pro.id = priv.id_user AND priv.func_1 = 1 
						JOIN daily_schedule ds ON c.id = ds.id_course 
						WHERE 	pro.hid = '$hid' 
						GROUP BY CONCAT(start_time, ' - ', end_time)
						) a, 
						(
						SELECT 	
							MAX(ds.id_course) AS id_course,
							c.name_course,
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
						JOIN users pro ON cm.id_student = pro.id 
						JOIN users_priv priv ON pro.id = priv.id_user AND priv.func_1 = 1 
						JOIN daily_schedule ds ON c.id = ds.id_course 
						JOIN rooms_availab ra ON c.id = ds.id_course
						JOIN rooms r ON ra.id_room = r.id_room
						WHERE 	pro.hid = '$hid' 
						GROUP BY ds.num_day, CONCAT(start_time, ' - ', end_time), c.name_course
						) b
						WHERE a.id_course = b.id_course AND b.horario = a.horario
						GROUP BY a.horario
						";
	}elseif($usertype->func_2 == 1){
		// Consulta de horarios para profesores
		$query = "SELECT 	a.horario, 
						b.name_course, 
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
					JOIN users pro ON c.id_professor = pro.id 
					JOIN users_priv priv ON pro.id = priv.id_user AND priv.func_2 = 1 
					JOIN daily_schedule ds ON c.id = ds.id_course 
					WHERE 	pro.hid = '$hid' 
						".($id_course ? "AND ds.id_course = $id_course" : ""). 
					" GROUP BY CONCAT(start_time, ' - ', end_time)
					) a, 
					(
					SELECT 	
						MAX(ds.id_course) AS id_course,
						c.name_course,
						CASE WHEN ds.num_day = 1 THEN r.desc ELSE 0 END AS lunes,
						CASE WHEN ds.num_day = 2 THEN r.desc ELSE 0 END AS martes,
						CASE WHEN ds.num_day = 3 THEN r.desc ELSE 0 END AS miercoles,
						CASE WHEN ds.num_day = 4 THEN r.desc ELSE 0 END AS jueves,
						CASE WHEN ds.num_day = 5 THEN r.desc ELSE 0 END AS viernes,
						CASE WHEN ds.num_day = 6 THEN r.desc ELSE 0 END AS sabado,
						CASE WHEN ds.num_day = 7 THEN r.desc ELSE 0 END AS domingo, 
						CONCAT(start_time, ' - ', end_time) AS horario
					FROM courses c 
					JOIN users pro ON c.id_professor = pro.id 
					JOIN users_priv priv ON pro.id = priv.id_user AND priv.func_2 = 1 
					JOIN daily_schedule ds ON c.id = ds.id_course 
					JOIN rooms_availab ra ON c.id = ds.id_course
					JOIN rooms r ON ra.id_room = r.id_room
					WHERE 	pro.hid = '$hid' 
						".($id_course ? "AND ds.id_course = $id_course" : ""). 
					" GROUP BY ds.num_day, CONCAT(start_time, ' - ', end_time), c.name_course
					) b
					WHERE a.id_course = b.id_course AND b.horario = a.horario
					GROUP BY a.horario";

	}elseif($usertype->func_3 == 1 || $usertype->func_5 == 1){
		// query para administrador
		$query = "SELECT 	a.horario, 
						b.name_course, 
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
					JOIN daily_schedule ds ON c.id = ds.id_course
					GROUP BY CONCAT(start_time, ' - ', end_time)
					) a, 
					(
					SELECT 	
						MAX(ds.id_course) AS id_course,
						c.name_course,
						CASE WHEN ds.num_day = 1 THEN r.desc ELSE 0 END AS lunes,
						CASE WHEN ds.num_day = 2 THEN r.desc ELSE 0 END AS martes,
						CASE WHEN ds.num_day = 3 THEN r.desc ELSE 0 END AS miercoles,
						CASE WHEN ds.num_day = 4 THEN r.desc ELSE 0 END AS jueves,
						CASE WHEN ds.num_day = 5 THEN r.desc ELSE 0 END AS viernes,
						CASE WHEN ds.num_day = 6 THEN r.desc ELSE 0 END AS sabado,
						CASE WHEN ds.num_day = 7 THEN r.desc ELSE 0 END AS domingo, 
						CONCAT(start_time, ' - ', end_time) AS horario
					FROM courses c 
					JOIN daily_schedule ds ON c.id = ds.id_course 
					JOIN rooms_availab ra ON c.id = ds.id_course
					JOIN rooms r ON ra.id_room = r.id_room
					GROUP BY ds.num_day, CONCAT(start_time, ' - ', end_time) , c.name_course
					) b
					WHERE a.id_course = b.id_course AND b.horario = a.horario
					GROUP BY a.horario
					";
	}
	$data=$ndb->get_results($query);

	// Si no hay resultados devuelve falso
	if(!$data) return false;
	
	// Se recorre el arreglo de datos para cargarlos en formato json
	foreach($data as $col){
		$info[]=array(	"horario"=>utf8_encode($col->horario),
						"name_course" => utf8_encode($col->name_course),
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

function getAssistance($hid=false, $id_course=false){
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
				JOIN users u ON u.id = c.id_professor
				WHERE u.hid = '$hid' AND c.id = $id_course";
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
				WHERE c.id_course = $id_course ORDER BY u.f_lastname, u.s_lastname, u.name";
	
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
				WHERE c.id_course = 3 AND a.assistance = 1
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

function getMaterialsList($id_course = false){
	global $ndb;
	if(!$id_course) return false;
	$query = "	SELECT *
				FROM course_documents
				WHERE id_course = $id_course";
	$rs = $ndb->get_results($query);
	
	if(count($rs)<=0) return false;
	
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
?>