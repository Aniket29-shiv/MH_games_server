<?php

include 'config.php';

global $connect,$myObj;
	$userId = $_GET['user_id'];

	$sql1 = "SELECT * FROM accounts where userid = '".$userId."'";
    $result1 = $connect->query($sql1);
    if ($result1->num_rows > 0) 
    {
    	while($row = $result1->fetch_assoc())
    	{
    		$points = $row['real_chips'];
    	}
		
		$myObj->success = "1";
       	$myObj->message = "Success";
       	$myObj->points = $points;
    }
	else
	{
		$myObj->success = "0";
       	$myObj->message = "Error getting play chips";
       	$myObj->points = "0";
	}
    
   echo json_encode($myObj);
	
$conn->close();
?>