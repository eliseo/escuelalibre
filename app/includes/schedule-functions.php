<?php
include("ez_sql_mysql.php");

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
							MAX(domingo) AS domingo,
							b.vigente
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
							CONCAT(start_time, ' - ', end_time) AS horario,
							CASE WHEN CURDATE() BETWEEN c.start_date AND c.end_date THEN 1 ELSE 0 END AS vigente
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
						MAX(domingo) AS domingo,
						b.vigente
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
						CONCAT(start_time, ' - ', end_time) AS horario,
						CASE WHEN CURDATE() BETWEEN c.start_date AND c.end_date THEN 1 ELSE 0 END AS vigente
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
						MAX(domingo) AS domingo,
						b.vigente
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
						CONCAT(start_time, ' - ', end_time) AS horario,
						CASE WHEN CURDATE() BETWEEN c.start_date AND c.end_date THEN 1 ELSE 0 END AS vigente
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
						"domingo"=>utf8_encode($col->domingo),
						"vigente" => $col->vigente
						); 
	}
	echo json_encode($info);
}
?>