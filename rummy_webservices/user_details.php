<?php
error_reporting(0);
include 'config.php';

$username = strtolower($_GET['username']);
$password = $_GET['password'];
$os = $_GET['os'];
$ip = $_GET['ip'];
$city = $_GET['city'];
$region = $_GET['region'];
$country = $_GET['country'];
$platform = $_GET['platform'];
$insertLogin = $_GET['insertLogin'];
$current_date = date('Y-m-d H:i:s');


$password1 = md5($password);
$seluser = "SELECT * FROM users u ,accounts a WHERE u.username='$username' and u.password ='$password1' and u.user_id=a.userid";
$runuser = mysqli_query($connect,$seluser) or die(mysqli_error($connect));
$getuser = mysqli_num_rows($runuser);
$userdata = mysqli_fetch_array($runuser);
if($getuser==1)
{
	$user = "valid";
	$check_user = array('user' => $user);
	
	$userId = $userdata['user_id'];
	$rewardPoint = 0;
	
	$rewardsql = "SELECT * FROM reward_total_point WHERE user_id ='$userId'";
	$result_reward = $connect->query($rewardsql);
	if($result_reward->num_rows > 0 )
	{
	    $rewardrow = $result_reward->fetch_assoc();
        
        $rewardPoint = $rewardrow['reward_points'];
	}
	
	$userid = $userdata['user_id'];
	$email = $userdata['email'];
	$username = $userdata['username'];
	
	$json_user = array('user_id' => $userdata['user_id'],'username' => $userdata['username'],'first_name' => $userdata['first_name'],'middle_name' => $userdata['middle_name'],'last_name' => $userdata['last_name'],'date_of_birth' => $userdata['date_of_birth'],'mobile_no' => $userdata['mobile_no'],'email' => $userdata['email'],'state' => $userdata['state'],'gender' => $userdata['gender'],'pan_card_no' => $userdata['pan_card_no'],'address' => $userdata['address'],'city' => $userdata['city'],'pincode' => $userdata['pincode'],'mac_address' => $userdata['mac_address'],'ip_address' => $userdata['ip_address'],'created_date' => $userdata['created_date'],'updated_date' => $userdata['updated_date']);
	
	$json_account = array('account_id' => $userdata['account_id'],'userid' => $userdata['userid'],'username' => $userdata['username'],'play_chips' => $userdata['play_chips'],'real_chips' => $userdata['real_chips'],'redeemable_balance' => $userdata['redeemable_balance'],'bonus' => $userdata['bonus'],'player_club' => $userdata['player_club'],'player_status' => $userdata['player_status'],'created_date' => $userdata['created_date'],'updated_date' => $userdata['updated_date'],'rewardPoints' => $rewardPoint);
	
	if ($insertLogin == "yes") 
	{
	    $sql13 = "insert into login_history ( `userid`, `email`, `username`, `os`, `ip`, `city`, `region`, `country`, `platform`, `status`, `logindate`)values ( '".$userid."','".$email."','".$username."','".$os."','".$ip."','".$city."','".$region."','".$country."','".$platform."','login','".$current_date."')";
        $connect->query($sql13);
	}
	
	header('Content-type: application/json');
echo json_encode(array('status'=>$check_user,'user_details'=>$json_user,'accounts_details'=>$json_account));
}
else
{
    $user = "Invalid";
	$check_user = array('user' => $user);
	header('Content-type: application/json');
echo json_encode(array('status'=>$check_user));
}


		
?>
