<?php

error_reporting(0);
include 'config.php';

$supportId = $_GET['supportId'];
$message = $_GET['message'];
$current_date = date('Y-m-d H:i:s');
    									
	$sql13 = "insert into user_help_reply ( `ticketid`, `msg`, `msgby`, `created_date`, `reply_by`)values ( '".$supportId."','".$message."','0','".$current_date."', '')";
            //$connect->query($sql13); 
            
    if ($connect->query($sql13)) 
	{
	    
        $sql = "update user_help_support set lastreply = 'User' where id = '".$supportId."'";
        // $result = $connect->query($sql);
        
        if ($connect->query($sql)) 
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
	    $myObj->status = "False";
	}
	
	
echo json_encode($myObj);

$connect->close();
?>