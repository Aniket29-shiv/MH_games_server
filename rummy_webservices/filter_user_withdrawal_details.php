<?php
error_reporting(0);
include 'config.php';
    
    $userId = $_GET['user_id'];
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

$seluser = "SELECT * FROM withdraw_request WHERE user_id= '$userId' AND created_on >= '$fromDate' AND created_on <= '$toDate' ORDER BY transaction_id DESC";
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
