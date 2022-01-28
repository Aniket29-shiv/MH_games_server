<?php
error_reporting(0);
include 'config.php';
    

$seluser = "SELECT * FROM sms_conf";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('id' => $userdata['id'],'senderid' => $userdata['senderid'],'userkey' => $userdata['userkey']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'sms_gateway_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
