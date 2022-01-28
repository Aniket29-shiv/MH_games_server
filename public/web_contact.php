<?php
include 'database.php';

$username = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['user_mobile'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$created_date = date('Y/m/d h:m:s');

$sql = "insert into web_contact_us ( `name`, `email`, `mobile_no`, `subject`, `message`, `created_date`)values ( '".$username."','".$email."','".$mobile."','".$subject."','".$message."','".$created_date."')";
$result = $conn->query($sql);

if ($result === true) {
	echo true;
	}
	else {
	echo false;
	}
	
	$conn->close();
//header("Location:contact-us.php?message=true");

?>