<?php
error_reporting(0);
include 'config.php';
    
    $tournamentId = $_GET['tournament_id'];
    
    $json_user = array();
    $playePositionArray = array();

$seluser = "SELECT * FROM price_distribution where `tournament_id` = '$tournamentId' ORDER BY price_id DESC";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('price_id' => $userdata['price_id'],'tournament_id' => $userdata['tournament_id'],'position' => $userdata['position'],'price' => $userdata['price'],'no_players' => $userdata['no_players']);
    	
	}
	
// 	header('Content-type: application/json');
//     echo json_encode(array('status'=>"success",'price_destribution_details'=>$json_user,'message'=>"Record found"));
}

$playerpositionsql = "SELECT * FROM tournament_transaction where `tournament_id` = '$tournamentId' ORDER BY position ASC";
$playerpositionresult = $connect->query($playerpositionsql);
if($playerpositionresult->num_rows > 0)
{
	while($playerpositiondata = $playerpositionresult->fetch_assoc())
	{
	    $playerId =  $playerpositiondata['player_id'];
	    
	    $playernamesql = "SELECT username FROM users where `user_id` = '$playerId'";
	    $playernameresult = $connect->query($playernamesql);
	    $playernamedata = $playernameresult->fetch_assoc();
	    $playername = $playernamedata['username'];
	    
    	$playePositionArray[] = array(
    	    'player_id' => $playerpositiondata['player_id'],
    	    'position' => $playerpositiondata['position'],
    	    'score' => $playerpositiondata['score'],
    	    'taken_date' => $playerpositiondata['taken_date'],
    	    'entry_date' => $playerpositiondata['entry_date'],
    	    'playername' => $playername
    	    );
    	
	}
	
// 	header('Content-type: application/json');
//     echo json_encode(array('status'=>"success",'price_destribution_details'=>$json_user,'message'=>"Record found"));
}

// else
// {
// 	header('Content-type: application/json');
// echo json_encode(array('status' => "false",'message'=>"No record found"));
// }

echo json_encode(array('status'=>"success",'price_destribution_details'=>$json_user,'player_position'=>$playePositionArray,'message'=>"Record found"));
		
?>
