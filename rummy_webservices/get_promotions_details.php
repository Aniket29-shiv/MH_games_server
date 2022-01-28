<?php
error_reporting(0);
include 'config.php';
    

$seluser = "SELECT * FROM promotions where `status` = 'L' AND `deleted` = '0' ORDER BY id DESC";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('id' => $userdata['id'],'title' => $userdata['title'],'slug' => $userdata['slug'],'simage' => $userdata['simage'],'description' => $userdata['description'],'shortdescription' => $userdata['shortdescription'],'created_date' => $userdata['created_date'],'updated_date' => $userdata['updated_date']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'pramotions_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
