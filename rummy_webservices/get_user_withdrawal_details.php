<?php
error_reporting(0);
include 'config.php';

// $seluser = "select fund_added_to_player.*,accounts.play_chips,accounts.username,accounts.real_chips from fund_added_to_player LEFT JOIN accounts ON fund_added_to_player.user_id=accounts.userid";

// $page = $_GET['page'];
// $operaterId = $_GET['operater_id'];
// $limit = 50;

//Counting the total item available in the database 
// $total = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM offline_withdraw w ,offline_users u WHERE w.user_id=u.user_id AND w.operator_id = $operaterId"));

//We can go atmost to page number total/limit
// $page_limit = $total/$limit; 

    //Calculating start for every given page number 
    // $start = ($page - 1) * $limit; 
    
    $userId = $_GET['user_id'];

$seluser = "SELECT * FROM withdraw_request WHERE user_id= '$userId' ORDER BY transaction_id DESC";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('transaction_id' => $userdata['transaction_id'],'requested_amount' => $userdata['requested_amount'],'created_on' => $userdata['created_on'],'updated_on' => $userdata['updated_on'],'status' => $userdata['status']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'withdrawal_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
