<?php
require_once("includes/ez_sql_mysql.php");

class Message{

	public function send($idmsg, $hid_sender, $hid_recipient, $asunto, $mensaje, $ticket, $save, $hidden = false){
		global $ndb;		
		if($idmsg == ''){
			$query = 	"INSERT INTO messages(hid_sender, hid_recipient, subject, message, ticket, send_date".($hidden?',hidden':'').($save?',draft':'').")";
			$query .= 	"VALUES(";
			$query .= 	"'".$hid_sender."',";
			$query .= 	"'".$hid_recipient."',";
			$query .= 	"'".$asunto."',";
			$query .= 	"'".$mensaje."',";
			$query .= 	"'".$ticket."',";
			$query .= 	"now()";
			if($hidden)
				$query .= ", 1";
			if($save)
				$query .= ", 1";
			$query .= 	")";
		}else{
			return $this->update($idmsg, $hid_sender, $hid_recipient, $asunto, $mensaje, $save, $hidden);
		}
		$res = ($ndb->query($query)) ? true : false;
		return $res;
	}
	
	public function update($idmsg, $hid_sender, $hid_recipient, $asunto, $mensaje, $save, $hidden = false){
		global $ndb;
		
		$query = 	"UPDATE messages SET 
							hid_sender = '".$hid_sender."', 
							hid_recipient = '".$hid_recipient."', 
							subject = '".$asunto."', 
							message = '".$mensaje."', 
							draft = ".($save ? 1 : 0 ).",".
							" send_date = now()";
		$query .=	", hidden = ".($hidden ? 1 : 0);
		$query .=	" WHERE id = $idmsg";
		
		echo $query;

		$res = ($ndb->query($query)) ? true : false;
		return $res;
	}
	
	public function markRead($idmsg){
		global $ndb;
		$query="UPDATE messages SET read_date = now() WHERE id = $idmsg";
		$res = ($ndb->query($query)) ? true : false;
		return $res;
	}
}
?>