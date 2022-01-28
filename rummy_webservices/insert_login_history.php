<?php

error_reporting(0);
include 'config.php';

$userid = $_GET['user_id'];
$email = $_GET['email'];
$username = $_GET['username'];
$os = $_GET['os'];
$ip = $_GET['ip'];
$city = $_GET['city'];
$region = $_GET['region'];
$country = $_GET['country'];
$platform = $_GET['platform'];
$current_date = date('Y-m-d H:i:s');
    									
	$sql13 = "insert into login_history ( `userid`, `email`, `username`, `os`, `ip`, `city`, `region`, `country`, `platform`, `status`, `logindate`)values ( '".$userid."','".$email."','".$username."','".$os."','".$ip."','".$city."','".$region."','".$country."','".$platform."','login','".$current_date."')";
            //$connect->query($sql13); 
            
    if ($connect->query($sql13)) 
	{
	    $myObj->status = "True";
	}
	else
	{
	    $myObj->status = "False";
	}
	
	
echo json_encode($myObj);

$connect->close();
?>