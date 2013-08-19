<?php

require_once("includes/ez_sql_mysql.php");

class ratings{

	public function setRating($hid, $id_course, $id_eval_t, $rating, $comment){
		global $ndb;
		
		$id_classmate = $this->getIDClassmates($hid, $id_course);
		
		$query = "";
		if($this->ratingExists($hid, $id_course, $id_eval_t)){
			// aquí tendriamos que añadir el id_evaluation_type
			$query=" UPDATE ratings SET rating = $rating, comment= '$comment' WHERE id_classmate = $id_classmate AND id_evaluation_type = $id_eval_t";
		}else{
			$query="INSERT INTO ratings(id_classmate, rating, id_evaluation_type, comment) VALUES($id_classmate, $rating, $id_eval_t, '$comment')";
		}

		$res = ($ndb->query($query)) ? true :  false;

		return $res;
	}
	
	public function ratingExists($hid, $id_course, $id_eval_t){
		global $ndb;
		$query = "	SELECT 1
					FROM ratings r
					JOIN classmates c ON r.id_classmate = c.id
					JOIN users u ON u.id = c.id_student
					WHERE c.id_course = $id_course AND u.hid = '$hid' AND id_evaluation_type = $id_eval_t";
		
		$res = $ndb->get_results($query);
		if($res==false) return false;
		return true;
	}
	
	private function getIDClassmates($hid, $id_course){
		global $ndb;
		$query = "	SELECT c.id
					FROM users u
					JOIN classmates c  ON c.id_student = u.id
					WHERE c.id_course = $id_course AND u.hid = '$hid'";
		$data = $ndb->get_row($query);
		
		return $data->id;
	}
	
	private function getIdEvaluationType($id_course){
		global $ndb;
		$query = "SELECT et.id FROM evaluation_type et WHERE id_course = $id_course";
		$data = $ndb->get_row($query);
		return $data->id;
	}

}
?>