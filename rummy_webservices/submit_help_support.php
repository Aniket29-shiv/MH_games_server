<?php
error_reporting(0);
include 'config.php';

$username = $_GET['username'];
$subject = $_GET['subject'];
$message = $_GET['msg'];
$created_date = date('Y/m/d H:m:s');
$user_id = $_GET ['user_id'];
$status = 'pending';

		$sql = "insert into user_help_support ( `name`, `subject`, `message`, `status`, `created_date`,user_id)values ( '".$username."','".$subject."','".$message."','".$status."','".$created_date."','".$user_id."')";
		$result = $connect->query($sql);
			if($result)
			{
				$myObj->status = "Your Request has been submitted successfully , we will get back to you shortly.";
			}
			else
			{
				$myObj->status = "Something went wrong,please try again.";
			}
			
echo json_encode($myObj);

$connect->close();
?>