<?php
include_once('controller/messages.php');

//print_r($_REQUEST);

if(
	isset($_POST['message']) && 
	isset($_POST['subject']) &&
	isset($_POST['hid_recipient'])
){
	$mensaje = addslashes($_POST['message']);
	$asunto = addslashes($_POST['subject']);
	$hid_recipient = $_POST['hid_recipient'];
	if(isset($_POST['ticket']) && $_POST['ticket'] != ''){
		$ticket = $_POST['ticket'];
	}else
		$ticket = date('Y').date('m').date('d').date('H').date('i').date('s');
	
	$save = $_POST['save'] == 1 ? true : false ;
	$idmsg = $_POST['idmsg'];
	
	$msg = new Message();
	$hid_sender = $_COOKIE['HID'];
	
	if($msg->send($idmsg, $hid_sender,$hid_recipient, $asunto, $mensaje, $ticket, $save))
		echo "true";
	else
		echo "false";
}

if(isset($_GET['idmsgread'])){

	$idmsg = $_GET['idmsgread'];
	$msg = new Message();
	if($msg->markRead($idmsg)){
		echo "true";
	}else
		echo "false";
	
}
?>