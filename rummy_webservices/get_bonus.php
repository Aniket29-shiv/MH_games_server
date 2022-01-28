<?php
error_reporting(0);
include 'config.php';

		$user_id = $_GET['user_id'];

		$sql = "SELECT * FROM referral_bonus where referral_id = '".$user_id."'";
		$result = $connect->query($sql);
		
		$ref_bonus = 0;
		
		if ($result->num_rows > 0) 
		{
		    $row = $result->fetch_assoc();
		    $ref_bonus = $row['ref_bonus'];
		}
		
		$sql1 = "SELECT * FROM accounts where userid = '".$user_id."'";
		$result1 = $connect->query($sql1);
		
		$reg_bonus = 0;
		
		if ($result1->num_rows > 0) 
		{
		    $row1 = $result1->fetch_assoc();
		    $reg_bonus = $row1['bonus'];
		}
		
		echo json_encode(array('referral_bonus' => $ref_bonus,'registration_bonus'=>$reg_bonus));

$connect->close();
?>