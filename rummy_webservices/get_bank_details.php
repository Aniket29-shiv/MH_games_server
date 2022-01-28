<?php
error_reporting(0);
include 'config.php';

		$user_id = $_GET['user_id'];

		$sql = "SELECT * FROM bank_details where user_id = '".$user_id."'";
		$result = $connect->query($sql);
		
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc())
			{
				$myObj->bank_name = $row['bank_name'];
				$myObj->account_no = $row['account_no'];
				$myObj->ifsc_code = $row['ifsc_code'];
				$myObj->status = "";
			}
		}
		else
		{
			$myObj->status = "No Records Found.";
		}
echo json_encode($myObj);

$connect->close();
?>