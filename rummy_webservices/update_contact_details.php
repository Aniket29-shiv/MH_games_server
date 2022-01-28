<?php
error_reporting(0);
include 'config.php';

	$address = $_GET['address'];
	$state = $_GET['state'];
	$city = $_GET['city'];
	$pincode = $_GET['pincode'];
	$usernm = $_GET['username'];
	$updated_date = date('Y/m/d h:m:s');

	$sql = "update users set address= '".$address."',state= '".$state."',city= '".$city."',pincode= '".$pincode."',`updated_date` = '".$updated_date."' where username = '".$usernm."'";
	$result = $connect->query($sql);

	if ($result === true) {
	 $myObj->status = "Profile Updated Successfully.";
	}
	else {
	 $myObj->status = "Profile Updation Failed.";
	}
	
	echo json_encode($myObj);

$connect->close();
?>