<?php


error_reporting(0);
include 'config.php';

$noOfPlayer = $_REQUEST['no_of_player'];
$point = $_REQUEST['points'];
$game = $_REQUEST['game'];
$gameType = $_REQUEST['game_type'];
$pool = $_REQUEST['pool'];

 $seluser = "SELECT * FROM player_table WHERE game_type = '$gameType' AND min_entry = '$point' AND player_capacity = '$noOfPlayer' AND game = '$game' AND table_status = 'L' AND 	pool = '$pool'";
 $runuser = mysqli_query($connect,$seluser) or die(mysqli_error($connect));
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
    	
    	    echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found",'joined'=>"join")); 
	}
	else if ($zero_table_id != "") 
	{
	    $gettablesql = "SELECT * FROM player_table WHERE table_id = '$zero_table_id'";
        $gettable = mysqli_query($connect,$gettablesql) or die(mysqli_error($connect));
        $tabledate = mysqli_fetch_array($gettable);
        
        $json_user[] = array('table_id' => $tabledate['table_id'],'table_name' => $tabledate['table_name'],'game_type' => $tabledate['game_type'],'point_value' => $tabledate['point_value'],'min_entry' => $tabledate['min_entry'],'status' => $tabledate['status'],'player_capacity' => $tabledate['player_capacity'],'game' => $tabledate['game'],'table_type' => $tabledate['table_type'],'pool' => $tabledate['pool'],'table_no' => $tabledate['table_no'],'creared_on' => $tabledate['creared_on'],'joker_type' => $tabledate['joker_type'],'table_status' => $tabledate['table_status'],'updated_on' => $tabledate['updated_on']);
    	
    	    echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found",'joined'=>"notjoin"));
	}
	else
	{
	   
	   
	   
	   $table_name='New Pool';
		$status='process';
		$table_type='';
		
		$digits = 5;
		$table_no1= rand(pow(10, $digits-1), pow(10, $digits)-1);
		$table_no=$table_no1;
		
		$joker_type='Joker';
		$table_status='L';
		$today=date('Y-m-d H:i:s');
		
		
		$sqltable = "insert into player_table(table_name,game_type,point_value,min_entry,status,player_capacity,game,table_type,pool,table_no,creared_on,joker_type,table_status) VALUES ('".$table_name."','".$gameType."','0','".$point."','".$status."','".$noOfPlayer."','".$game."','".$table_type."','".$pool."','".$table_no."','".$today."','".$joker_type."','".$table_status."')";
		
		
		$tableresult = mysqli_query($connect,$sqltable) or die(mysqli_error($connect));
		
		
		$last_table_id = mysqli_insert_id($connect);
		
		
		if($last_table_id){
			
			$gettablesql12 = "SELECT * FROM player_table WHERE table_id = '$last_table_id'";
			$gettable12 = mysqli_query($connect,$gettablesql12) or die(mysqli_error($connect));
			$tabledate12 = mysqli_fetch_array($gettable12);
        
			$json_user[] = array('table_id' => $tabledate12['table_id'],'table_name' => $tabledate12['table_name'],'game_type' => $tabledate12['game_type'],'point_value' => $tabledate12['point_value'],'min_entry' => $tabledate12['min_entry'],'status' => $tabledate12['status'],'player_capacity' => $tabledate12['player_capacity'],'game' => $tabledate12['game'],'table_type' => $tabledate12['table_type'],'pool' => $tabledate12['pool'],'table_no' => $tabledate12['table_no'],'creared_on' => $tabledate12['creared_on'],'joker_type' => $tabledate12['joker_type'],'table_status' => $tabledate12['table_status'],'updated_on' => $tabledate12['updated_on']);
    	
			echo json_encode(array('status'=>"success",'table_details'=>$json_user,'message'=>"Record found",'joined'=>"join"));
			
		} else {
			
			  echo json_encode(array('status' => "false",'table_details'=>$json_user,'message'=>"Table Not Found"));
		}
		
	    // echo json_encode(array('status' => "false",'table_details'=>$json_user,'message'=>"Table Not Found"));
	   
	   
	   /* echo json_encode(array('status' => "false",'table_details'=>$json_user,'message'=>"Table Not Found")); */
	}
}
else
{
	echo json_encode(array('status' => "false",'table_details'=>$json_user,'message'=>"No record found"));
}
		
?>
