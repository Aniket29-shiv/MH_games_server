<?php
error_reporting(0);
include 'config.php';
    
    $page = $_GET['page'];
    $userId = $_GET['user_id'];
    
    $limit = 50;
		
		//Counting the total item available in the database 
$total = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM notification_details where `user_id` = '".$userId."'"));

//We can go atmost to page number total/limit
$page_limit = $total/$limit; 

    //Calculating start for every given page number 
    $start = ($page - 1) * $limit;

$seluser = "SELECT * FROM notification_details where `user_id` = '".$userId."' ORDER BY `id` DESC limit $start, $limit";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
        $json_user[] = array('id' => $userdata['id'],'title' => $userdata['title'],'description' => $userdata['description'],'image' => $userdata['image'],'read_status' => $userdata['read_status'],'created_date' => $userdata['created_date']);
    	
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
