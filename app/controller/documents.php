<?php
require_once("includes/ez_sql_mysql.php");

class Document{

	public function addDocument($desc, $filename, $filecontent, $filetype, $id_course){
		global $ndb;
		
		$query = "INSERT INTO course_documents(`desc`,`id_course`, `name`, document, mimetype, creation_date, modif_date) VALUES('$desc',$id_course,'$filename','$filecontent', '$filetype', now(), now())";
		
		$res = ($ndb->query($query)) ? true : false;
		
		return $res;
	}
	
	public function deleteDocument($id){
		global $ndb;
		$query = "DELETE FROM course_documents WHERE id = $id";
		$res = ($ndb->query($query)) ? true : false;
		return $res;
	}
	
	public function getDocument($id){
		global $ndb;
		$query = "SELECT * FROM course_documents WHERE id = $id";
		$res = $ndb->get_row($query);
		return $res;
	}
}
?>