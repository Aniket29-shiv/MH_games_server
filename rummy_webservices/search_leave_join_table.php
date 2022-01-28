<?php
// error_reporting(0);
// include 'config.php';

// $noOfPlayer = $_GET['no_of_player'];
// $point = $_GET['point'];
// $game = $_GET['game'];
// $gameType = $_GET['game_type'];

// $seluser = "SELECT * FROM player_table WHERE game_type = '$gameType' AND min_entry = '$point' AND player_capacity = '$noOfPlayer' AND game = '$game' AND table_status = 'L'";
// $runuser = mysqli_query($connect,$seluser) or die(mysqli_error($connect));
// $getuser = mysqli_num_rows($runuser);

// if($getuser==1)
// {
// 	$userdata = mysqli_fetch_array($runuser);
	
// 	$table_id = $userdata['table_id'];
// 	$checkplayer = "SELECT * FROM user_tabel_join WHERE joined_table = '$table_id'";
//     $checkplayersql = mysqli_query($connect,$checkplayer) or die(mysqli_error($connect));
//     $playercount = mysqli_num_rows($checkplayersql);
    
//     if($noOfPlayer==2)
//     {
//         if($playercount>=2)
//         {
//             echo json_encode(array('status' => "false",'message'=>"Table Not Found"));
//         }
//         else
//         {
//             $json_user[] = array('table_id' => $userdata['table_id'],'table_name' => $userdata['table_name'],'game_type' => $userdata['game_type'],'point_value' => $userdata['point_value'],'min_entry' => $userdata['min_entry'],'status' => $userdata['status'],'player_capacity' => $userdata['player_capacity'],'game' => $userdata['game'],'table_type' => $userdata['table_type'],'pool' => $userdata['pool'],'table_no' => $userdata['table_no'],'creared_on' => $userdata['creared_on'],'joker_type' => $userdata['joker_type'],'table_status' => $userdata['table_status'],'updated_on' => $userdata['updated_on']);
    	
//     	    echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found"));    
//         }    
//     }
//     else if($noOfPlayer==6)
//     {
//         if($playercount>=6)
//         {
//             echo json_encode(array('status' => "false",'message'=>"Table Not Found"));
//         }
//         else
//         {
//             $json_user[] = array('table_id' => $userdata['table_id'],'table_name' => $userdata['table_name'],'game_type' => $userdata['game_type'],'point_value' => $userdata['point_value'],'min_entry' => $userdata['min_entry'],'status' => $userdata['status'],'player_capacity' => $userdata['player_capacity'],'game' => $userdata['game'],'table_type' => $userdata['table_type'],'pool' => $userdata['pool'],'table_no' => $userdata['table_no'],'creared_on' => $userdata['creared_on'],'joker_type' => $userdata['joker_type'],'table_status' => $userdata['table_status'],'updated_on' => $userdata['updated_on']);
    	
//     	    echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found"));    
//         }    
//     }
// }
// else
// {
// 	echo json_encode(array('status' => "false",'message'=>"No record found"));
// }

error_reporting(0);
include 'config.php';

$noOfPlayer = $_GET['no_of_player'];
$point = $_GET['point'];
$game = $_GET['game'];
$gameType = $_GET['game_type'];
$tableid = $_GET['tableid'];

$seluser = "SELECT * FROM player_table WHERE game_type = '$gameType' AND point_value = '$point' AND player_capacity = '$noOfPlayer' AND game = '$game' AND table_status = 'L' AND `table_id` != '$tableid'";
$runuser = mysqli_query($connect,$seluser) or die(mysqli_error($connect));
$getuser = mysqli_num_rows($runuser);

$zero_table_id = "";
$fill_table_id = "";

if($getuser>0)
{
// 	$userdata = mysqli_fetch_array($runuser);
	while($userdata = mysqli_fetch_array($runuser))
	{
	    $table_id = $userdata['table_id'];
    	$checkplayer = "SELECT * FROM user_tabel_join WHERE joined_table = '$table_id'";
        $checkplayersql = mysqli_query($connect,$checkplayer) or die(mysqli_error($connect));
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
        $gettable = mysqli_query($connect,$gettablesql) or die(mysqli_error($connect));
        $tabledate = mysqli_fetch_array($gettable);
        
        $json_user[] = array('table_id' => $tabledate['table_id'],'table_name' => $tabledate['table_name'],'game_type' => $tabledate['game_type'],'point_value' => $tabledate['point_value'],'min_entry' => $tabledate['min_entry'],'status' => $tabledate['status'],'player_capacity' => $tabledate['player_capacity'],'game' => $tabledate['game'],'table_type' => $tabledate['table_type'],'pool' => $tabledate['pool'],'table_no' => $tabledate['table_no'],'creared_on' => $tabledate['creared_on'],'joker_type' => $tabledate['joker_type'],'table_status' => $tabledate['table_status'],'updated_on' => $tabledate['updated_on']);
    	
    	    echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found",'table_status'=>"Join")); 
	}
	else if ($zero_table_id != "") 
	{
	    $gettablesql = "SELECT * FROM player_table WHERE table_id = '$zero_table_id'";
        $gettable = mysqli_query($connect,$gettablesql) or die(mysqli_error($connect));
        $tabledate = mysqli_fetch_array($gettable);
        
        $json_user[] = array('table_id' => $tabledate['table_id'],'table_name' => $tabledate['table_name'],'game_type' => $tabledate['game_type'],'point_value' => $tabledate['point_value'],'min_entry' => $tabledate['min_entry'],'status' => $tabledate['status'],'player_capacity' => $tabledate['player_capacity'],'game' => $tabledate['game'],'table_type' => $tabledate['table_type'],'pool' => $tabledate['pool'],'table_no' => $tabledate['table_no'],'creared_on' => $tabledate['creared_on'],'joker_type' => $tabledate['joker_type'],'table_status' => $tabledate['table_status'],'updated_on' => $tabledate['updated_on']);
    	
    	    echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found",'table_status'=>"Not Join"));
	}
	else
	{
	    echo json_encode(array('status' => "false",'message'=>"Table Not Found"));
	}
}
else
{
	echo json_encode(array('status' => "false",'message'=>"No record found"));
}
		
?>
