<?php
error_reporting(0);
include 'config.php';
    
    $page = $_GET['page'];
    $user_id = $_GET['user_id'];
    $limit = 50;
		
		//Counting the total item available in the database 
$total = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM login_history where `userid` = '".$user_id."'"));

$page_limit = $total/$limit; 

//Calculating start for every given page number 
$start = ($page - 1) * $limit;

$seluser = "SELECT * FROM login_history where `userid` = '".$user_id."' ORDER BY logindate DESC limit $start, $limit";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('id' => $userdata['id'],'os' => $userdata['os'],'ip' => $userdata['ip'],'city' => $userdata['city'],'region' => $userdata['region'],'country' => $userdata['country'],'platform' => $userdata['platform'],'status' => $userdata['status'],'logindate' => $userdata['logindate'],'logouttime' => $userdata['logouttime']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'login_history_details'=>$json_user,'message'=>"Record found",'total_record'=>$total));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found",'total_record'=>$total));
}


		
?>
