<?php

// include 'config.php';

// 	$results = array();

//     $username = $_GET['username'];
//     $userId = $_GET['userId'];
//     $page = $_GET['page'];
//     $limit = 50;
    
//     $total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM notifications where username = '".$username."'"));
//     echo "SELECT * FROM notifications where username = '".$username."'";

//     // //We can go atmost to page number total/limit
//     $page_limit = $total/$limit; 

//     // //Calculating start for every given page number 
//     $start = ($page - 1) * $limit;
    
//     // echo "SELECT * FROM `notifications` where username = '".$username."' ORDER BY `id` DESC limit $start, $limit";
    
//     $banksql = $conn->query("SELECT * FROM `notifications` where username = '".$username."' ORDER BY `id` DESC limit $start, $limit");    

// 	if($banksql->num_rows > 0 )
// 	{							
// 		while($row = $banksql->fetch_assoc())
//     	{
// 			$results[] = array(
// 			'id' => $row['id'],
// 			'username' => $row['username'],
// 			'title' => $row['title'],
// 			'description' => $row['description'],
// 			'image' => $row['image'],
// 			'is_read' => $row['is_read'],
// 			'read_count' => $row['read_count'],
// 			'created_date' => $row['created_date']
// 			);
//     	}
		
// 		echo json_encode(array('response' => 'true','notification_details' => $results,'total_record'=>$total));
// 	}
// 	else
// 	{
// 		echo json_encode(array('response' => 'false','notification_details' => $results,'total_record'=>$total));
// 	}
    
// 	$conn->close();

error_reporting(0);
include 'config.php';
    
    $page = $_GET['page'];
    $userId = $_GET['user_id'];
    $username = $_GET['username'];
    
    $limit = 50;
		
		//Counting the total item available in the database 
$total = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM notifications where `username` = '".$username."'"));

//We can go atmost to page number total/limit
$page_limit = $total/$limit; 

    //Calculating start for every given page number 
    $start = ($page - 1) * $limit;

$seluser = "SELECT * FROM notifications where `username` = '".$username."' ORDER BY `id` DESC limit $start, $limit";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
        $json_user[] = array('id' => $userdata['id'],
        'title' => $userdata['title'],
        'description' => $userdata['description'],
        'image' => $userdata['image'],
        'read_status' => $userdata['is_read'],
        'created_date' => $userdata['created_date']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'notification_details'=>$json_user,'message'=>"Record found",'total_record'=>$total));
}
else
{
	header('Content-type: application/json');
    echo json_encode(array('status' => "false",'message'=>"No record found",'total_record'=>$total));
}


?>