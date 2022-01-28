<?php
error_reporting(0);
include 'config.php';
$myObj = new \stdClass();
$final_array = []; 

		$username = $_GET['username'];

		$sql = "SELECT * FROM user_help_support where name = '".$username."' ORDER BY id DESC";
		$result = $connect->query($sql);
		
		if ($result->num_rows > 0) 
		{
			 while($row = $result->fetch_assoc())
			{
			    $ticketId = $row['id'];
			    $totalCount = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM user_help_reply where ticketid = '".$ticketId."' AND read_status = '0' AND msgby = '1'"));
			    
				 $final_array []= [
									"subject" => $row['subject'],
									"message" => $row['message'],
									"msg_status" => $row['status'],
									"id" => $row['id'],
									"name" => $row['name'],
									"created_date" => $row['created_date'],
									"user_id" => $row['user_id'],
									"lastreply" => $row['lastreply'],
									"status" =>"",
									"unreadMessageCount" =>$totalCount
								  ];
			}//while
			$j = json_encode($final_array, JSON_HEX_QUOT);
			echo json_encode(array('status'=>"success",'help_support_details'=>$final_array,'message'=>"Record found"));
		
		}
		else
		{
			 $final_array []= ["record_status" => "No Records Found."];
			//echo json_encode($final_array);
			echo json_encode(array('status' => "false",'message'=>"No record found"));
		}
//echo json_encode($myObj);

$connect->close();
?>