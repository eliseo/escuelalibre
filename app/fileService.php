<?php
include('controller/documents.php');

/* Añadir un documento nuevo */
if(isset($_FILES['archivo']) && isset($_POST['desc'])){
	
	
	$max_file_size = 50000000;
	$filename = $_FILES['archivo']['name'];
	$filetype = $_FILES['archivo']['type'];
	$filesize = $_FILES['archivo']['size'];
	$tmp_file = $_FILES['archivo']['tmp_name'];
	
	// validando tipo de archivo
	$allowedExtensions = array("txt", "rtf", "doc", "png", "jpeg", "pdf", "jpg");
	$ext = substr($filename, strrpos($filename, ".")+1);
	if(!in_array($ext, $allowedExtensions)){
		return "false";
	}
	
	if($_FILES["file"]["size"] > $max_file_size){
		echo "no allowed file size";
		$error = 1;
	}
		
	// se obtiene el contenido
	$fp = fopen($tmp_file, "rb");
	$contenido = fread($fp, $filesize);
	$contenido = addslashes($contenido);
	fclose($fp);
	$id_course = $_POST['id_course'];
	$desc = $_POST['desc'];
	
	$doc = new Document();	
	if($doc->addDocument($desc, $filename, $contenido, $filetype, $id_course))
		echo $id_course;
	else
		echo "false";
}

/* Eliminar documento */
if(isset($_POST['deleteId'])){
	$id = $_POST['deleteId'];
	$doc = new Document();
	if($doc->deleteDocument($id))
		echo "true";
	else
		echo "false";
}

if(isset($_GET['action']) && isset($_GET['id_doc'])){
	$id_doc = $_GET['id_doc'];
	$doc = new Document();
	$data = $doc->getDocument($id_doc);
	
	// Enviar documento al navegador
	header('Content-type: '.$data->mimetype);
	header('Content-Disposition: attachment; filename="'.$data->name.'"');
	print($data->document);
}

?>