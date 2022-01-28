<?php
error_reporting(0);
include 'config.php';

$userId = $_GET['user_id'];

$seluser = "SELECT * FROM users WHERE `user_id` = '$userId'";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$rewardPoint = 0;
    	
    	$rewardsql = "SELECT * FROM reward_total_point WHERE user_id ='$userId'";
    	$result_reward = $connect->query($rewardsql);
    	if($result_reward->num_rows > 0 )
    	{
    	    $rewardrow = $result_reward->fetch_assoc();
            
            $rewardPoint = $rewardrow['reward_points'];
    	}
	    
    	$json_user[] = array('user_id' => $userdata['user_id'],'username' => $userdata['username'],'first_name' => $userdata['first_name'],'middle_name' => $userdata['middle_name'],'last_name' => $userdata['last_name'],'date_of_birth' => $userdata['date_of_birth'],'mobile_no' => $userdata['mobile_no'],'email' => $userdata['email'],'state' => $userdata['state'],'gender' => $userdata['gender'],'pan_card_no' => $userdata['pan_card_no'],'address' => $userdata['address'],'city' => $userdata['city'],'pincode' => $userdata['pincode'],'rewardPoints' => $rewardPoint);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'user_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
