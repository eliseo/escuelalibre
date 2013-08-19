<?php
require_once("includes/ez_sql_mysql.php");

class Assistance{

	public function existsAssistance($date, $id_course, $hid){
		global $ndb;
		$query = "SELECT 1 FROM assistance WHERE date='$date' AND hid_student='$hid' AND id_course=$id_course ";
		$result = ($ndb->get_results($query)) ? true : false;
		return $result;
		
	}
		
	public function setAssistance($date, $id_course, $hid){
		global $ndb;
		
		if($this->existsAssistance($date, $id_course, $hid)){
			// Si la asistencia esta dada de alta solo se actualiza
			$query = "UPDATE assistance SET assistance=1 WHERE id_course = $id_course AND hid_student = '$hid' AND date='$date'";
		}else{
			// Si la asistencia NO existe se procede a insertarla
			$query = "INSERT INTO assistance(id_course, hid_student, date, assistance) VALUES($id_course, '$hid', '$date', 1)";
		}
		//echo $query."-\n";
		$result = ($ndb->get_results($query)) ? true : false;
		
		return $result;
	}
	
	public function clearAssistance($id_course, $hid){
		global $ndb;
		// Poner todas las asistancias existentes en cero :p
		$query = "UPDATE assistance SET assistance=0 WHERE id_course = $id_course AND hid_student = '$hid'";
		$ndb->query($query);
	}
}
?>