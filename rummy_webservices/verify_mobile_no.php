<?php

error_reporting(0);
include 'config.php';

$otp = $_GET['otp'];
$mobileNo = $_GET['mobile_no'];
    									
    	$seluser1 = "SELECT * FROM sms_otp  WHERE mobile_no = '$mobileNo' AND otp = $otp";
        $result1 = $connect->query($seluser1);
        if($result1->num_rows > 0)
        {
            $sql_update = "update sms_otp set otp= '0' where mobile_no = '$mobileNo'";
    		$connect->query($sql_update);
    		
    		if ($connect) 
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