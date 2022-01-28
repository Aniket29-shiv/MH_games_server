<?php
error_reporting(0);
include 'config.php';

		$user_id = $_GET['user_id'];

	//	$sql = "SELECT * FROM user_tabel_join where user_id = '108'";
		$sql = "SELECT * FROM user_tabel_join where user_id = '".$user_id."'";
		//echo $sql;
		$result = $connect->query($sql);
		
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc())
			{
				/*$myObj->id = $row['id'];
				$myObj->user_id = $row['user_id'];
				$myObj->username = $row['username'];
				$myObj->player_capacity = $row['player_capacity'];
				$myObj->joined_table = $row['joined_table'];
				$myObj->round_id = $row['round_id'];
				$myObj->amount_to_revert = $row['amount_to_revert'];
				echo json_encode($myObj);*/
				// $json_user[] = array('id' => $row['id'],'username' => $row['username'],'player_capacity' => $row['player_capacity'],'joined_table' => $row['joined_table'],'round_id' => $row['round_id'],'amount_to_revert' => $row['amount_to_revert'],'chip_type' => $row['chip_type'],'game_type' => $row['game_type']);
				
				$tableId = $row['joined_table'];
				
				$gettablesql = "SELECT * FROM player_table WHERE table_id = '$tableId'";
        $gettable = mysqli_query($connect,$gettablesql) or die(mysqli_error($connect));
        $tabledate = mysqli_fetch_array($gettable);
        
        $json_user[] = array('table_id' => $tabledate['table_id'],'table_name' => $tabledate['table_name'],'game_type' => $tabledate['game_type'],'point_value' => $tabledate['point_value'],'min_entry' => $tabledate['min_entry'],'status' => $tabledate['status'],'player_capacity' => $tabledate['player_capacity'],'game' => $tabledate['game'],'table_type' => $tabledate['table_type'],'pool' => $tabledate['pool'],'table_no' => $tabledate['table_no'],'creared_on' => $tabledate['creared_on'],'joker_type' => $tabledate['joker_type'],'table_status' => $tabledate['table_status'],'updated_on' => $tabledate['updated_on'],'round_id' => $row['round_id']);
				
			}
		}
		else
		{
			$myObj->status = "No Records Found.";
		}
echo json_encode(array('table_details'=>$json_user));

$connect->close();
?>