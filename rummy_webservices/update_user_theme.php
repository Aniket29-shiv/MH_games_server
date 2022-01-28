<?php
error_reporting(0);
include 'config.php';

$userId = $_GET['userId'];
$themeId = $_GET['themeId'];
	
	$result_user_check = $connect->query("SELECT * FROM `user_theme` where user_id = '".$userId."'");    
	if($result_user_check->num_rows > 0 )
	{ 
	    
	    $updatesql = "update user_theme set theme_id= '".$themeId."' where user_id = '".$userId."'";
	
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
	    $insertsql = "insert into user_theme (`user_id`, `theme_id`)values ( '".$userId."','".$themeId."')";
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