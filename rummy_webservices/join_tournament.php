<?php
error_reporting(0);
include 'config.php';

$userId = $_GET['user_id'];
$tournamentId = $_GET['tournamentId'];
$amount = $_GET['amount'];
$current_date = date('Y-m-d H:i:s');

    $checkplayer = "SELECT * FROM join_tournaments WHERE tournament_id = '$tournamentId'";
    $checkplayersql = mysqli_query($connect,$checkplayer) or die(mysqli_error($connect));
    $playercount = mysqli_num_rows($checkplayersql);
    
    $getplayercountsql = "SELECT no_of_player FROM tournament WHERE tournament_id = '$tournamentId'";
    $playercountresult = $connect->query($getplayercountsql);
    $playercountrow = mysqli_fetch_array($playercountresult);
    $noofplayer = $playercountrow['no_of_player'];
    
    if ($playercount < $noofplayer)
    {
        $insertsql = "INSERT INTO join_tournaments(player_id, tournament_id, fees, created_time) VALUES('{$userId}','{$tournamentId}','{$amount}','{$current_date}')";
	   
        if($connect->query($insertsql))
        {
            if ($amount == 0)
            {
                echo json_encode(array('status'=>"success",'message'=>"Player Joined successfully"));
            }
            else
            {
                $playerpointsql = "SELECT `real_chips` FROM `accounts` WHERE `userid` = '".$userId."'";
        		$playerpointresult = $connect->query($playerpointsql);	  
        		$playerpoint_row = mysqli_fetch_array($playerpointresult);
        		$player_prev_points = $playerpoint_row['real_chips'];
        		$player_curr_points = $player_prev_points - $amount;
        		
        		$updatesql = "UPDATE `accounts` SET `real_chips`= '".$player_curr_points."', `updated_date`= '".$current_date."' WHERE `userid` = '".$userId."'";
        		
        		if($connect->query($updatesql))
        		{
        		    echo json_encode(array('status'=>"success",'message'=>"Player Joined successfully"));
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
    }
    else
    {
        echo json_encode(array('status'=>"false",'message'=>"This tournament is already full"));
    }
?>