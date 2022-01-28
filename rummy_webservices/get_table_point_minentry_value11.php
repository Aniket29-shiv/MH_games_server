<?php

error_reporting(0);
include 'config.php';

$noOfPlayer = $_GET['no_of_player'];
$game = $_GET['game'];
$gameType = $_GET['game_type'];
$pool = $_GET['pool'];


if ($gameType == "Point Rummy")
{
    $getpointsql = "SELECT DISTINCT(point_value) as value FROM `player_table` WHERE game_type = '$gameType' AND player_capacity = '$noOfPlayer' AND game = '$game' AND table_status = 'L' ORDER BY point_value ASC";
}
else if ($gameType == "Pool Rummy") 
{
    $getpointsql = "SELECT DISTINCT(min_entry) as value FROM `player_table` WHERE game_type = '$gameType' AND player_capacity = '$noOfPlayer' AND game = '$game' AND table_status = 'L' AND pool = '$pool' ORDER BY min_entry ASC";
}
else
{
    $getpointsql = "SELECT DISTINCT(min_entry) as value FROM `player_table` WHERE game_type = '$gameType' AND player_capacity = '$noOfPlayer' AND game = '$game' AND table_status = 'L' ORDER BY min_entry ASC";
}


$result = $connect->query($getpointsql);

if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
	    
    	$json_user[] = array('value' => $userdata['value']);
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'value_array'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}
		
?>
