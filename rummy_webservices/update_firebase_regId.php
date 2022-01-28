<?php
error_reporting(0);
include 'config.php';

$userId = $_GET['userId'];
$regId = $_GET['regId'];
	
	$result_user_check = $connect->query("SELECT * FROM `user_firebase_reg_id` where user_id = '".$userId."'");    
	if($result_user_check->num_rows > 0 )
	{ 
	    
	    $updatesql = "update user_firebase_reg_id set firebase_reg_id= '".$regId."' where user_id = '".$userId."'";
	
    	$result = $connect->query($updatesql);
    	if ($result === true) 
    	{
    	    $myObj->status = "True";
    	}
    	else
		{
		     $myObj->status = "False";
		}
	}
	else
	{
	    $insertsql = "insert into user_firebase_reg_id (`user_id`, `firebase_reg_id`)values ( '".$userId."','".$regId."')";
		if($connect->query($insertsql))
		{
		    $myObj->status = "True";
		}
		else
		{
		     $myObj->status = "False";
		}
	}

echo json_encode($myObj);

$connect->close();
?>