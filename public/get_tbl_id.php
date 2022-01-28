<?php


error_reporting(0);
include 'database.php';

$noOfPlayer = $_REQUEST['no_of_player'];
$point = $_REQUEST['points'];
$game = $_REQUEST['game'];
$gameType = $_REQUEST['game_type'];

$seluser = "SELECT * FROM player_table WHERE game_type = '$gameType' AND point_value = '$point' AND player_capacity = '$noOfPlayer' AND game = '$game' AND table_status = 'L'";
 $runuser = mysqli_query($conn,$seluser) or die(mysqli_error($conn));
 $getuser = mysqli_num_rows($runuser);

$zero_table_id = "";
$fill_table_id = "";
$json_user=array();
if($getuser>0)
{
// 	$userdata = mysqli_fetch_array($runuser);
	while($userdata = mysqli_fetch_array($runuser))
	{
	    $table_id = $userdata['table_id'];
    	$checkplayer = "SELECT * FROM user_tabel_join WHERE joined_table = '$table_id'";
        $checkplayersql = mysqli_query($conn,$checkplayer) or die(mysqli_error($conn));
        $playercount = mysqli_num_rows($checkplayersql);
        if($noOfPlayer==2)
        {
            if($playercount==0)
            {
                if ($zero_table_id == "") 
                {
                    $zero_table_id = $table_id;
                }
            }
            else if ($playercount==1)
            {
                if ($fill_table_id == "") 
                {
                    $fill_table_id = $table_id;
                    break;
                }
            }
        }
        else if($noOfPlayer==6)
        {
            if($playercount==0)
            {
                if ($zero_table_id == "") 
                {
                    $zero_table_id = $table_id;
                }
            }
            else if ($playercount<6)
            {
                if ($fill_table_id == "") 
                {
                    $fill_table_id = $table_id;
                    break;
                }
            }
        }
	}
	
	if ($fill_table_id != "")
	{
	    $gettablesql = "SELECT * FROM player_table WHERE table_id = '$fill_table_id'";
        $gettable = mysqli_query($conn,$gettablesql) or die(mysqli_error($conn));
        $tabledate = mysqli_fetch_array($gettable);
        
        $json_user[] = array('table_id' => $tabledate['table_id'],'table_name' => $tabledate['table_name'],'game_type' => $tabledate['game_type'],'point_value' => $tabledate['point_value'],'min_entry' => $tabledate['min_entry'],'status' => $tabledate['status'],'player_capacity' => $tabledate['player_capacity'],'game' => $tabledate['game'],'table_type' => $tabledate['table_type'],'pool' => $tabledate['pool'],'table_no' => $tabledate['table_no'],'creared_on' => $tabledate['creared_on'],'joker_type' => $tabledate['joker_type'],'table_status' => $tabledate['table_status'],'updated_on' => $tabledate['updated_on']);
    	
    	    echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found",'joined'=>"join")); 
	}
	else if ($zero_table_id != "") 
	{
	    $gettablesql = "SELECT * FROM player_table WHERE table_id = '$zero_table_id'";
        $gettable = mysqli_query($conn,$gettablesql) or die(mysqli_error($conn));
        $tabledate = mysqli_fetch_array($gettable);
        
        $json_user[] = array('table_id' => $tabledate['table_id'],'table_name' => $tabledate['table_name'],'game_type' => $tabledate['game_type'],'point_value' => $tabledate['point_value'],'min_entry' => $tabledate['min_entry'],'status' => $tabledate['status'],'player_capacity' => $tabledate['player_capacity'],'game' => $tabledate['game'],'table_type' => $tabledate['table_type'],'pool' => $tabledate['pool'],'table_no' => $tabledate['table_no'],'creared_on' => $tabledate['creared_on'],'joker_type' => $tabledate['joker_type'],'table_status' => $tabledate['table_status'],'updated_on' => $tabledate['updated_on']);
    	
    	    echo json_encode(array('msg'=>"success",'table_details'=>$json_user,'message'=>"Record found",'joined'=>"notjoin"));
	}
	else
	{
	    echo json_encode(array('msg' => "false",'table_details'=>$json_user,'message'=>"Table Not Found"));
	}
}
else
{
	echo json_encode(array('msg' => "false",'table_details'=>$json_user,'message'=>"No record found"));
}
		
?>
