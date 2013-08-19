<?php

include("ez_sql_mysql.php");

function getMessages($hid = false, $from, $type){
	global $ndb;
	
	if(!$hid) return false;
		
	global $ndb;
	$messages = array();
	
	if($type == 1){
		$query = "	SELECT m.*, (select concat(name,' ',f_lastname) from users u where u.hid = m.hid_sender) as sender, '' as recipient
					FROM messages m 
					WHERE hid_recipient = '$hid' ".($from != false ? " AND id > $from " : '' ).
					"ORDER BY id ASC"; 
	}else if($type == 2){
		$query = "	SELECT m.*, (select concat(name,' ',f_lastname) from users u where u.hid = m.hid_recipient) as sender, '' as recipient
					FROM messages m 
					WHERE hid_sender = '$hid' AND draft = 0 ".($from != false ? " AND id > $from " : '' ).
					"ORDER BY id ASC"; 
	}else if($type == 3){
		$query = "	SELECT m.*, (select concat(name,' ',f_lastname,' ', s_lastname) from users u where u.hid = m.hid_recipient) as sender, '' as recipient
					FROM messages m 
					WHERE hid_sender = '$hid' ".($from != false ? " AND id > $from " : '' ).
					"AND draft = 1
					ORDER BY id ASC"; 
	}else if($type == 4){
		$query = "	SELECT 
						m.*,
						(SELECT CONCAT(NAME,' ',f_lastname) FROM users us WHERE us.hid = m.hid_sender ) AS sender,
						(SELECT CONCAT(NAME,' ',f_lastname) FROM users us WHERE us.hid = m.hid_recipient ) AS recipient
					FROM users u
					JOIN messages m ON u.hid = m.hid_sender
					JOIN classmates cm ON cm.id_student = u.id
					WHERE id_course IN (
						SELECT o.id_course
						FROM users u
						JOIN observer o ON u.id = o.id_user
						WHERE u.hid = '$hid'
						)
					AND hidden = 0 AND draft = 0
					ORDER BY m.id";
	}
	
	$rs = $ndb->get_results($query);
	
	if(count($rs)<=0) return false;
	
	foreach($rs as $m){
		$messages[] = array(	
							"idmsg" => $m->id,
							"ticket" => $m->ticket,
							"sender" => $m->sender, 		/* o recipient en caso de type = 2 */
							"recipient" => $m->recipient,
							"hid_sender" => $m->hid_sender,
							"hid_recipient" => $m->hid_recipient,
							"subject" => $m->subject,
							"message" => stripslashes($m->message),
							"send_date" => $m->send_date,
							"read_date" => $m->read_date,
							"hidden" => $m->hidden
						 );
	}
	
	echo json_encode($messages);
}

function newMsgExists($hid){
	global $ndb;
	$query = "SELECT count(*) as numMsg
				FROM messages m 
				WHERE hid_recipient = '$hid' 
				AND read_date IS NULL";
				
	$res = $ndb->get_row($query);
	
	echo $res->numMsg;
}

function getSenders($hid=false){
	global $ndb;
	$info = array();

	/* Verificar tipo de usuario */
	$query = "select up.* from users u join users_priv up where u.hid = '$hid' and up.id_user = u.id ";
	$r = $ndb->get_row($query);
	
	// Si es estudiante obtiene a su profesor 
	if($r->func_1 == 1){
		$query = "	SELECT stu.hid, stu.name, stu.f_lastname, stu.s_lastname 
					FROM users u 
					JOIN classmates cm ON u.id = cm.id_student
					JOIN users stu ON cm.id_student = stu.id 
					WHERE u.hid != '$hid' 
					UNION
					SELECT tea.hid, tea.name, tea.f_lastname,tea.s_lastname
					FROM users u 
					JOIN classmates cm ON u.id = cm.id_student
					JOIN courses c ON cm.id_course = c.id
					JOIN users tea ON c.id_professor = tea.id
					WHERE u.hid = '$hid' ";
	// Si es profesor obtiene a sus estudiantes 
	}elseif($r->func_2 == 1){
		$query = "	SELECT info.* FROM (
					SELECT stu.hid, stu.name, stu.f_lastname, stu.s_lastname
					FROM users s
					JOIN courses c ON c.id_professor = s.id
					JOIN classmates cm ON cm.id_course = c.id
					JOIN users stu ON cm.id_student = stu.id
					WHERE s.hid = '$hid'
						UNION
					SELECT stu.hid, stu.name, stu.f_lastname, stu.s_lastname
					FROM users s
					JOIN classmates cm ON cm.id_student = s.id
					JOIN courses c ON c.id = cm.id_course
					JOIN classmates cm2 ON c.id = cm2.id_course
					JOIN users stu ON cm.id_student = stu.id
					WHERE s.hid = '$hid' AND cm2.id_student != s.id
						UNION
					SELECT teach.hid, teach.name, teach.f_lastname, teach.s_lastname
					FROM users s
					JOIN classmates cm ON cm.id_student = s.id
					JOIN courses c ON c.id = cm.id_course
					JOIN users teach ON c.id_professor = teach.id
					WHERE s.hid = '$hid' 
				) AS info";
	}else{
		$query = "	SELECT u.hid, u.name, u.f_lastname, u.s_lastname 
					FROM users u WHERE u.hid != '$hid' ";
	}

	//echo $query;
	$res = $ndb->get_results($query);
	
	foreach($res as $senders){
		$info[] = array(	
							"hid" => $senders->hid,
							"sender" => ($senders->name." ".$senders->f_lastname." ".$senders->s_lastname)
						);
	}	
	echo json_encode($info);
}

function getRelatedMessages($ticket, $idmsg){

	global $ndb;
	$info = array();
	$query = "select 	m.* ,
						(select concat(u.name) from users u where u.hid = m.hid_sender) as sender,
						(select concat(u.name) from users u where u.hid = m.hid_recipient) as recipient
	from messages m where ticket = '$ticket' and id < $idmsg and draft = 0 and hidden = 0 order by id asc";
	//echo $query; return;
	$rs = $ndb->get_results($query);
	foreach($rs as $msg){
		$info[] = array(
						"id" => $msg->id,
						"sender" => $msg->sender,
						"recipient" => $msg->recipient,
						"hid_sender" => $msg->hid_sender,
						"hid_recipient" => $msg->hid_recipient,
						"subject" => $msg->subject,
						"message" => $msg->message, 
						"send_date" => $msg->send_date
		);
	}
	echo json_encode($info);
}

?>