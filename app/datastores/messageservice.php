<?php
include("../includes/messages-functions.php");
$q=$_GET['q'];

switch($q){
	case "get":
		$type = $_GET['type'];
		$from = isset($_GET['update']) ? $_GET['update'] : false ;
		getMessages($_COOKIE['HID'], $from, $type);
	break;
	case "nuevos":
		newMsgExists($_COOKIE['HID']);
	break;
	case "senders":
		getSenders($_COOKIE['HID']);
	break;
	case "related":
		$ticket = $_GET['ticket'];
		$idmsg = $_GET['idmsg'];
		getRelatedMessages($ticket, $idmsg);
	break;
	default:
}

?>