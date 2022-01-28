<?php
error_reporting(0);
include 'config.php';

$userId = $_GET['user_id'];
$tournamentId = $_GET['tournamentId'];
$current_date = date('Y-m-d H:i:s');

    $tournamentpointsql = "SELECT `fees` FROM `join_tournaments` WHERE `player_id` = '$userId' AND `tournament_id` = '$tournamentId'";
    		$tournamentpointresult = $connect->query($tournamentpointsql);	  
    		$tournamentpoint_row = mysqli_fetch_array($tournamentpointresult);
    		$amount = $tournamentpoint_row['fees'];

    $insertsql = "DELETE FROM `join_tournaments` WHERE `player_id` = '$userId' AND `tournament_id` = '$tournamentId'";
	   
    if($connect->query($insertsql))
    {
        if ($amount == 0)
        {
            echo json_encode(array('status'=>"success",'message'=>"Player withdraw successfully"));
        }
        else
        {
            $playerpointsql = "SELECT `real_chips` FROM `accounts` WHERE `userid` = '".$userId."'";
    		$playerpointresult = $connect->query($playerpointsql);	  
    		$playerpoint_row = mysqli_fetch_array($playerpointresult);
    		$player_prev_points = $playerpoint_row['real_chips'];
    		$player_curr_points = $player_prev_points + $amount;
    		
    		$updatesql = "UPDATE `accounts` SET `real_chips`= '".$player_curr_points."', `updated_date`= '".$current_date."' WHERE `userid` = '".$userId."'";
    		
    		if($connect->query($updatesql))
    		{
    		    echo json_encode(array('status'=>"success",'message'=>"Player withdraw successfully"));
    		}
    		else
    		{
    		    echo json_encode(array('status'=>"false",'message'=>"Error in update"));
    		}   
        }
    }
    else
    {
        echo json_encode(array('status'=>"false",'message'=>"Record not added"));
    }
		
?>