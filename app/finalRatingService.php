<?php
require_once("controller/ratings.php");

//print_r($_REQUEST);


if(isset($_POST['id_course']) && isset($_POST['calif'])){

	$id_course = $_POST['id_course'];
	$calif = $_POST['calif'];
	$ratings = new Ratings();
	
	if(count($calif) > 0){
		foreach($calif as $c=>$v ){
			if($v != ''){
				$hid = substr($c,0,strpos($c,'-'));
				$id_eval_t = substr($c,strpos($c,'-')+1,strlen($c));
				$rat = substr($v,0,strpos($v,'-'));
				$com = substr($v,strpos($v,'-')+1,strlen($v));
				$ratings->setRating( $hid , $id_course, $id_eval_t, $rat, $com);
			}
		}
	}

echo "true";
}
?>