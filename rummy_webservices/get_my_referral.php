<?php
error_reporting(0);
include 'config.php';

$userId = $_GET['user_id'];

$seluser = "SELECT * FROM referral_bonus  WHERE referral_id = '$userId'";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('ref_username' => $userdata['ref_username'],'refrral_name' => $userdata['refrral_name'],'user_id' => $userdata['user_id'],'username' => $userdata['username'],'user_full_name' => $userdata['user_full_name'],'ref_bonus' => $userdata['ref_bonus'],'date' => $userdata['date']);
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'referral_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
