<?php
/*$servername = "localhost";
$user_name = "root";
$password = "";
$dbname = "rummy_store";
$myObj = new \stdClass();
 
$conn = new mysqli($servername, $user_name, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
*/
error_reporting(0);
include 'config.php';
include "../public/database.php";
// include('../public/Classes/class.phpmailer.php');
	include ('php/Mail.php');
include ('php/Mail/mime.php') ;
include('../public/email/sendEmail.php');

$username = strtolower($_GET['username']);
$email = $_GET['email'];
$mobile = $_GET['mobile'];
$pass = $_GET['pwd']; 
$gender = $_GET['gender'];
$state = $_GET['state'];
$created_date = date('Y-m-d H:i:s');
$ipaddress =$_GET['ip'];
$mac=$_GET['mac'];
$referralCode = $_GET['referral_code'];
if($referralCode == "") {
    $referralCode = 0;
}


	///check unique entry for username ///
	$result_user_check = $connect->query("SELECT * FROM `users` where username='".$username."'");    
	if($result_user_check->num_rows == 1 )
	{ 
		$myObj->status = "User name already exists.";
	}
	else
	{ ///check unique entry for email id ///
	  $result_email_check = $connect->query("SELECT * FROM `users` where email='".$email."'");  if($result_email_check->num_rows == 1 )
		{ 
			$myObj->status = "Email ID already taken.";
		}
		else
		{	///check unique entry for mobile no ///
		  $result_mobile_check = $connect->query("SELECT * FROM `users` where mobile_no ='".$mobile."'"); 
		  if($result_mobile_check->num_rows == 1 )
		  { 
			$myObj->status = "Mobile No already taken.";
		  }
		  else
		  {	
			///insert data to users after register 
		$sql = "insert into users (`username`, `mobile_no`, `email`, password,`state`,`mac_address`, `ip_address`, `created_date`, `updated_date`,`gender`,`referral_code`)values ( '".$username."','".$mobile."','".$email."','".md5($pass)."','".$state."','".$mac."','".$ipaddress."','".$created_date."','".$created_date."','".$gender."','".$referralCode."')";
					if($connect->query($sql))
					{
					///get username and userid of registered user 
					$sql1 = "SELECT * FROM users where username = '".$username."'";
					$result = $connect->query($sql1);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc())
						{
							$userid = $row['user_id'];
							$user_name = $row['username'];
							$user_full_name = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];;
						}
						
						$reg_bonus = 0;
                        $ref_bonus = 0;
					    $refUserName = "";
					    $refName = "";
					    
					    $query_bonus_entry = "select * from bonus_entry order by  created_on  desc limit 1";
                    	$bonus_result = $connect->query($query_bonus_entry);
                    	if ($bonus_result->num_rows > 0) 
                    	{
                    	    $bonus_row = $bonus_result->fetch_assoc();
                    	    $reg_bonus = $bonus_row['reg_bonus'];
                    	    $ref_bonus = $bonus_row['ref_bonus'];
                    	    $real_chips_bonus = $bonus_row['real_chips'];
                    	}
						
						if($referralCode != 0) {
                        	
                        	$query_user_detail = "select * from users WHERE 	user_id = '".$referralCode."'";
                        	$user_result = $connect->query($query_user_detail);
                        	if ($user_result->num_rows > 0) 
                        	{
                        	    $user_row = $user_result->fetch_assoc();
                        	    $refUserName = $user_row['username'];
                        	    $refName = $user_row['first_name'] . " " . $user_row['middle_name'] . " " . $user_row['last_name'];
                        	}
						    
						    $sql5 = "insert into referral_bonus (`referral_id`, `ref_username`, `refrral_name`, `user_id`, `username`, `user_full_name`, `ref_bonus`, `date`)values ( '".$referralCode."','".$refUserName."','".$refName."','".$userid."','".$user_name."','".$user_full_name."','".$ref_bonus."','".$created_date."')";
						    $connect->query($sql5);
						}
						
						//insert data to accounts 
						$play_chips = 10000;
						$sql2 = "insert into accounts (`userid`, `username`, `play_chips`, `real_chips`, `redeemable_balance`, `bonus`, `player_club`, `player_status`, `created_date`, `updated_date`)values ( '".$userid."','".$user_name."','".$play_chips."','".$real_chips_bonus."','0','".$reg_bonus."','Silver','Regular','".$created_date."','".$created_date."')";
						$connect->query($sql2);
						
						//===fund added to player entry
                        $addfund = "INSERT INTO `fund_added_to_player`(`user_id`, `amount`, `created_date`, `chip_type`, `transaction_id`, `payment_mode`, `order_id`, `status`) VALUES ('".$userid."','".$real_chips_bonus."','".$created_date."','Real','0','signup','0','success')";
                        $connect->query($addfund);

						//insert data to user_kyc_details 
						$email_status = 'Not Verified';
						$mobile_status = 'Not Verified';
						$sql3 = "insert into user_kyc_details ( `userid`, `username`, `email`,mobile_no,`created_date`, `updated_date`,`email_status`,`mobile_status`)values ( '".$userid."','".$user_name."','".$email."','".$mobile."','".$created_date."','".$created_date."','".$email_status."','".$mobile_status."')";

						$connect->query($sql3);
						
						$three=rand(100,999);
											$four=rand(1000,9999);
											$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
											$charactersLength = strlen($characters);
											$randomString = '';
											$length=3;
											for ($i = 0; $i < $length; $i++) {
												$randomString .= $characters[rand(0, $charactersLength - 1)];
											}
											$activattion_id=$three.$randomString.$four;					    
									// 	$encrypted=encryptIt( $activattion_id );
											
					  $sql13 = "insert into t_activation ( `user_id`, `activation_key`)values ( '".$userid."','".$activattion_id."')";
										   
												$connect->query($sql13);				    
	$actual_link = "http://rummysahara.com/"."activate.php?activattion_id=".''.$activattion_id.'';
	$toEmail = $email;
	$subject = "User Registration Activation Email";
	$content = "Click this link to activate your account : "  . $actual_link . "\nYour Activation code is ".$activattion_id;
	$mailHeaders = "From: noreply@rummysahara.com\r\n";
	
	$message='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
                        <div style="background:#ffffff;padding:20px">
                        <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
                        <div style=" text-align:center;">
                        <a href="'.MAINLINK.'">
                        <img src="'.LOGO.'" style="width:150px;" />
                        </a>
                        </div>
                        </div>			  
                        <div>
                        <p style="margin:0px 0px 10px 0px">
                        <p>Dear User,</p><br />
                        
                        <p>  Click on following link to activate your account.</p>
                        <p style="text-align: center; margin-top: 38px;">
                        <span style=" background: #a50b0b;padding: 12px;">
                        <a href="http://rummysahara.com/public/activate.php?activattion_id='.$activattion_id.'" target="_blank" rel="noreferrer" style="color: white;">Click Here</a>
                        </span>
                        </p>
                        <p>Thank you,</p>
                        <a href="'.MAINLINK.'">
                        <p>Team RummySahara</p>
                        </a>
                        </div>
                        <div>
                        </div>
                        </div>
                        </div>';
                        ;
	
// 	if(mail($toEmail, $subject, $content, $mailHeaders)) {
    if(bulkMail($toEmail,$subject,$message))
        {
	    
	    
	  	//header("Location:registration.php?success=1");
	//	$message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";	
	}
						
					}
				    $myObj->status = "Registration Done.";
				}
				else
				{
					$myObj->status = "Error While Register";
				}
			}///mobile_else
		}///email_else
	}///user_else

	
	
echo json_encode($myObj);

$connect->close();
?>