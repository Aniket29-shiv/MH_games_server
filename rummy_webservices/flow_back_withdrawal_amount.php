<?php
error_reporting(0);
include 'config.php';

$transactionId = $_GET['transactionId'];
$userId = $_GET['user_id'];
$amount = $_GET['amount'];
$current_date = date('Y-m-d H:i:s');
$order_id = mt_rand(100000, 999999);

    $updatestatus = "UPDATE withdraw_request SET status = 'Reversed', updated_on = '".$current_date."' WHERE transaction_id = '$transactionId'";
	   
    if($connect->query($updatestatus))
    {
        $playerpointsql = "SELECT `real_chips` FROM `accounts` WHERE `userid` = '".$userId."'";
		$playerpointresult = $connect->query($playerpointsql);	  
		$playerpoint_row = mysqli_fetch_array($playerpointresult);
		$player_prev_points = $playerpoint_row['real_chips'];
		$player_curr_points = $player_prev_points + $amount;
		
		$updatesql = "UPDATE `accounts` SET `real_chips`= '".$player_curr_points."', `updated_date`= '".$current_date."' WHERE `userid` = '".$userId."'";
		
		if($connect->query($updatesql))
		{
		    echo json_encode(array('status'=>"success",'message'=>"Fund added successfully"));    
		}
		else
		{
		    echo json_encode(array('status'=>"false",'message'=>"Error in update"));
		}
        
    }
    else
    {
        echo json_encode(array('status'=>"false",'message'=>"Error in update status"));
    }
		
?>