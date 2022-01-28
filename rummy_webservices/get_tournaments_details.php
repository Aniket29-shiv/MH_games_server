<?php
error_reporting(0);
include 'config.php';
    
    $user_id = $_GET['user_id'];
    $tournamentType = $_GET['tournamentType'];

if ($tournamentType == "All")
{
    $seluser = "SELECT * FROM tournament ORDER BY tournament_id DESC";
}
else if ($tournamentType == "Cash") 
{
    $seluser = "SELECT * FROM tournament where `entry_fee` != 'Free' ORDER BY tournament_id DESC";
}
else
{
    $seluser = "SELECT * FROM tournament where `entry_fee` = 'Free' ORDER BY tournament_id DESC";
}

$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
	    $tournament_id = $userdata['tournament_id'];
    	$checkplayer = "SELECT * FROM join_tournaments WHERE tournament_id = '$tournament_id'";
        $checkplayersql = mysqli_query($connect,$checkplayer) or die(mysqli_error($connect));
        $playercount = mysqli_num_rows($checkplayersql);
        $userId = -1;
        if ($playercount > 0)
        {
            while($tabledata = mysqli_fetch_array($checkplayersql))
            {
                $userid = $tabledata['player_id'];
                if ($userid == $user_id)
                {
                    $userId = $userid;
                }
            }
        }
        
        $status = $userdata['status'];
        $transEndDate = "";
        
        if ($status == 'end')
        {
            $tournamenttrans = "SELECT * FROM tournament_transaction where `tournament_id` = '".$tournament_id."' AND `position` = '1'";
            $transresult = $connect->query($tournamenttrans);
            if($transresult->num_rows > 0)
            {
                $transarow = $transresult->fetch_assoc();
                $transEndDate = $transarow['taken_date'];
            }
        }
	    
    	$json_user[] = array('tournament_id' => $userdata['tournament_id'],'price' => $userdata['price'],'title' => $userdata['title'],'start_date' => $userdata['start_date'],'start_time' => $userdata['start_time'],'reg_start_date' => $userdata['reg_start_date'],'reg_start_time' => $userdata['reg_start_time'],'reg_end_date' => $userdata['reg_end_date'],'reg_end_time' => $userdata['reg_end_time'],'entry_fee' => $userdata['entry_fee'],'no_of_player' => $userdata['no_of_player'],'description' => $userdata['description'],'file' => $userdata['file'],'created_date' => $userdata['created_date'],'updated_date' => $userdata['updated_date'],'status' => $userdata['status'],'user_id' => $userId,'player_count' => $playercount,'tournament_end_date' => $transEndDate);
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
