<?php
error_reporting(0);
include 'config.php';
    
    $user_id = $_GET['user_id'];

$seluser = "SELECT * FROM tournament as t LEFT JOIN tournament_transaction as tt ON tt.tournament_id = t.tournament_id WHERE tt.player_id = '$user_id' ORDER BY t.start_date DESC";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
	    $tournament_id = $userdata['tournament_id'];
    	$checkplayer = "SELECT * FROM join_tournaments WHERE tournament_id = '$tournament_id'";
        $checkplayersql = mysqli_query($connect,$checkplayer) or die(mysqli_error($connect));
        $playercount = mysqli_num_rows($checkplayersql);
	    
    	$json_user[] = array('tournament_id' => $userdata['tournament_id'],'price' => $userdata['price'],'title' => $userdata['title'],'start_date' => $userdata['start_date'],'start_time' => $userdata['start_time'],'reg_start_date' => $userdata['reg_start_date'],'reg_start_time' => $userdata['reg_start_time'],'reg_end_date' => $userdata['reg_end_date'],'reg_end_time' => $userdata['reg_end_time'],'entry_fee' => $userdata['entry_fee'],'no_of_player' => $userdata['no_of_player'],'description' => $userdata['description'],'file' => $userdata['file'],'created_date' => $userdata['created_date'],'updated_date' => $userdata['updated_date'],'status' => $userdata['status'],'position' => $userdata['position'],'score' => $userdata['score'],'player_count' => $playercount);
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'tournament_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
