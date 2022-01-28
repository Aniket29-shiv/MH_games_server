<?php
include 'config.php';

$user_id = $_GET['user_id'];

$seluser = "SELECT * FROM player_table";
$runuser = mysqli_query($connect,$seluser) or die(mysqli_error($connect));
$getuser = mysqli_num_rows($runuser);

if($getuser>=1)
{
	
	while($userdata = mysqli_fetch_array($runuser))
	{
	    
	    $table_id = $userdata['table_id'];
    	$checkplayer = "SELECT * FROM user_tabel_join WHERE joined_table = '$table_id'";
        $checkplayersql = mysqli_query($connect,$checkplayer) or die(mysqli_error($connect));
        $playercount = mysqli_num_rows($checkplayersql);
        $userId = -1;
        if ($playercount > 0)
        {
            while($tabledata = mysqli_fetch_array($checkplayersql))
            {
                $userid = $tabledata['user_id'];
                if ($userid == $user_id)
                {
                    $userId = $userid;
                }
            }
        }
	    
		$json_user[] = array('table_id' => $userdata['table_id'],'table_name' => $userdata['table_name'],'game_type' => $userdata['game_type'],'point_value' => $userdata['point_value'],'min_entry' => $userdata['min_entry'],'status' => $userdata['status'],'player_capacity' => $userdata['player_capacity'],'game' => $userdata['game'],'table_type' => $userdata['table_type'],'pool' => $userdata['pool'],'table_no' => $userdata['table_no'],'creared_on' => $userdata['creared_on'],'joker_type' => $userdata['joker_type'],'table_status' => $userdata['table_status'],'updated_on' => $userdata['updated_on'],'join_player_count' => $playercount,'user_id' => $userId);
	}
	
	
	
	
	
}
else
{
	echo  "Invalid User";
}
header('Content-type: application/json');
echo json_encode(array('table_details'=>$json_user));
		
?>
