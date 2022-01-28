<?php
error_reporting(0);
include 'config.php';
    

$seluser = "SELECT * FROM mobileslider where `deleted` = '0' ORDER BY rank ASC";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('id' => $userdata['id'],'title' => $userdata['title'],'simage' => $userdata['simage'],'rank' => $userdata['rank']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'slider_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
