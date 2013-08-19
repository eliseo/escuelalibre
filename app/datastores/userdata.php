
<?php
include("../includes/admin-functions.php");
$q=$_GET['q'];

switch($q){
	case "userdata":
		$hid = $_COOKIE['HID'];
		getUserData($hid);
	break;
	default:
	break;
}
?>