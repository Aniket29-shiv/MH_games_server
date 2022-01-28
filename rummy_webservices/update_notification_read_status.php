<?php
error_reporting(0);
include 'config.php';
error_reporting(E_ALL);

    $notificationId = $_GET['notificationId'];
    $current_date = date('Y/m/d H:i:s');
    
    
    $notificationcountsql = "SELECT `read_count` FROM `notifications` WHERE `id` = '".$notificationId."'";
		$countresult = $connect->query($notificationcountsql);	  
		$notcount_row = mysqli_fetch_array($countresult);
		$prev_count = $notcount_row['read_count'];
		$curr_count = $prev_count + 1;

	$updatesql = "UPDATE `notifications` SET `is_read`= '1', `read_count`= '".$curr_count."', `updated_date` = '".$current_date."' WHERE `id` = '".$notificationId."'";
	
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