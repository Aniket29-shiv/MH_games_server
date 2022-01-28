<?php

include 'config.php';

	$results = array();

    $username = $_GET['username'];
    $userId = $_GET['userId'];
    
    $totalUnreadNotification = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `notification_details` WHERE user_id = '".$userId."' AND read_status = '0'"));
    
    $totalUnreadMessage = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `user_help_support` as s LEFT JOIN user_help_reply as r ON r.ticketid = s.id WHERE s.name = '".$username."' AND r.read_status = '0' AND r.msgby = '1'"));
	
	echo json_encode(array('response' => 'true','total_unread_message'=>$totalUnreadMessage,'total_unread_notification'=>$totalUnreadNotification));
    
	$connect->close();
?>