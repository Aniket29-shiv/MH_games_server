<?php
error_reporting(0);
include 'config.php';
    

$seluser = "SELECT * FROM payment_gateway";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('id' => $userdata['id'],'pgname' => $userdata['pgname'],'gateway_id' => $userdata['gateway_id'],'gateway_key' => $userdata['gateway_key'],'gateway_type' => $userdata['gateway_type'],'status' => $userdata['status'],'deleted' => $userdata['deleted']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'payment_gateway_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
