<?php
session_start();
include 'database.php';

$username = $_POST['usernm'];
$subject = $_POST['subject'];
$message = $_POST['msg'];
$created_date = date('Y/m/d h:m:s');
$status = 'pending';

$sql = "insert into user_help_support ( `name`, `subject`, `message`, `status`, `created_date`,`user_id`)values ( '".$username."','".$subject."','".$message."','".$status."','".$created_date."','".$_SESSION['user_id']."')";

$result = $conn->query($sql);

if ($result === true) {
	echo true;
	}
	else {
	echo false;
	}
	
	$conn->close();
//header("Location:account-contact-us.php?user_message=true");

?>