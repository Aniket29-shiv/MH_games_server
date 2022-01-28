<?php
include '../../lock.php';
include("config.php");
	$status = '';
	if(isset($_GET['status'])){ 
	  $status = $_GET['status']; 	  
	}	
	if(isset($_GET["id"]))
	{
		$user_id = $_GET["id"];
			
					  $fetch_query = "DELETE FROM `users` WHERE  user_id=$user_id";
			
				$result = $conn->query($fetch_query);
				 $fetch_query1 = "DELETE FROM `user_kyc_details` WHERE  user_id=$userid";
			
				$result1 = $conn->query($fetch_query1);
				 $fetch_query2 = "DELETE FROM `accounts` WHERE  userid=$user_id";
			
				$result2 = $conn->query($fetch_query2);
						
					if(($result&&$result2&&$result1)){
							header("Location:player-details.php?status=2");
						}else{ 
							header("Location:player-details.php?status=3");
						}
			
		}
	
?>