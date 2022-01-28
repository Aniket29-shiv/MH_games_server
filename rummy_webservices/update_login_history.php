<?php
error_reporting(0);
include 'config.php';

	$userId = $_GET['user_id'];
	$platform = $_GET['platform'];
	$updated_date = date('Y/m/d h:m:s');

	$sql = "update login_history set status = 'logout',logouttime= '".$updated_date."' where userid = '".$userId."' AND platform = '".$platform."' ORDER BY id DESC LIMIT 1";
	$result = $connect->query($sql);

	if ($result === true) {
	 $myObj->status = "True";
	}
	else {
	 $myObj->status = "False";
	}
	
	echo json_encode($myObj);

$connect->close();
?>