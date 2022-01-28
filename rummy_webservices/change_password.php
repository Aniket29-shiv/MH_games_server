<?php
error_reporting(0);
include 'config.php';

$username = $_GET['username'];
$old_pwd = $_GET['old_pwd'];
$new_pwd = $_GET['new_pwd'];
$updated_date = date('Y/m/d h:m:s');

if($old_pwd!=$new_pwd)
{
    
    $sql1 = "SELECT * FROM `users` where username='".$username."' AND password='".md5($old_pwd)."'";
    $result1 = $connect->query($sql1);	
	if($result1->num_rows == 0)
	{ 
    	$myObj->status = "false";
    	$myObj->message = "Current password is invalid.";
	}
	else
	{
	    $sql = "update users set password= '".md5($new_pwd)."',`updated_date` = '".$updated_date."' where username = '".$username."'";
    	$result = $connect->query($sql);
    
    	if ($result === true) {
    	   $myObj->status = "true";
    	   $myObj->message = "Password Updated Successfully.";
    	}
    	else {
    	   $myObj->status = "false";
    	    $myObj->message = "Password Updation Failed.";
    	}
	}
}

echo json_encode($myObj);

$connect->close();
?>