<?php

include 'dbconfig.php';

	$results = array();

    $username = $_GET['username'];
    $userId = $_GET['userId'];
    
    $total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM notifications where username = '".$username."' AND is_read = '0'"));
    
    $totalUnreadMessage = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `support` as s LEFT JOIN user_help_reply as r ON r.ticketid = s.support_id WHERE s.player_id = '".$username."' AND r.read_status = '0' AND r.msgby = '1'"));
	
	echo json_encode(array('response' => 'true','total_record'=>$total,'total_unread_message'=>$totalUnreadMessage));
    
	$conn->close();
?>