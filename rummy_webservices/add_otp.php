<?php

error_reporting(0);
include 'config.php';

$otp = $_GET['otp'];
$userid = $_GET['user_id'];
$mobileNo = $_GET['mobile_no'];
    									
    	$seluser1 = "SELECT * FROM sms_otp  WHERE user_id = '$userid'";
        $result1 = $connect->query($seluser1);
        if($result1->num_rows > 0)
        {
            $sql_update = "update sms_otp set otp= '".$otp."', mobile_no = '".$mobileNo."' where user_id = '".$userid."'";
    		//$connect->query($sql_update);
    		
    		if ($connect->query($sql_update)) 
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
            $sql13 = "insert into sms_otp ( `user_id`, `otp`, `mobile_no`)values ( '".$userid."','".$otp."','".$mobileNo."')";
            //$connect->query($sql13); 
            
            if ($connect->query($sql13)) 
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