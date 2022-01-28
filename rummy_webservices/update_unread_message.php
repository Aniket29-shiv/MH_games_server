<?php
error_reporting(0);
include 'config.php';
error_reporting(E_ALL);

    $ticketId = $_GET['ticketId'];

	$updatesql = "UPDATE `user_help_reply` SET `read_status`= '1' WHERE `ticketid` = '".$ticketId."' AND msgby = '1'";
	
	if($connect->query($updatesql))
	{
        $myObj->response = "true";
        $myObj->message = "Updated successfully";  
	}
	else
	{
        $myObj->response = "false";
        $myObj->message = "Error in insert details";
	}
    
    echo json_encode($myObj);
    
    $connect->close();
?>