<?php
	include 'lock.php';
include "database.php";



if(isset($_GET['mobile']))
  {
      
      $mobile_no =$_GET['mobile'];
    $user =$_GET['user'];
	$OTP=rand(100000,999999);
	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?country=91&sender=RSTORE&route=4&mobiles=".$mobile_no."&authkey=244710AnsQdHELOEK5bd2e037&message=Your Otp For Mobile Number Verification is:".$OTP."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);


curl_close($curl);



if ($response) {


 $sql13 = "insert into sms_otp ( `user_id`,`mobile_no`, `otp`)values ( '".$user."','".$mobile_no."','".$OTP."')";

		$conn->query($sql13); 
		echo '1';
	



} else {
 // 
   echo "cURL Error #:" . $err;
 	
// echo '0';

 
}
      
      
  }
else if($_GET['otp_val']!="" )
  {
     $otp= $_GET['otp_val'];
  
	   $user =$_GET['user'];
	     
 
  $SEL="UPDATE sms_otp set otp='0' where `user_id`=$user"." and `otp`=".$otp ;

	   if(  $updat1 = $conn->query($SEL))
{	     
    $SEL_up="UPDATE user_kyc_details set `mobile_status`='Verified' where `userid`=$user";
 	        $updat2 = $conn->query($SEL_up);
	     
     echo '1';
	     
}else{
    
    echo '0';
}


	 

  }else{
        $userid =$_GET['user'];
          $email =$_GET['email'];
      				
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
										
								$sel="select user_id from t_activation where user_id='".$userid."'";
									$sel_res=$conn->query($sel);
									if($sel_res->num_rows > 0)
										{		
										    	   $query="UPDATE `t_activation` SET `activation_key`= '".$activattion_id."' WHERE user_id = '".$userid."'";
												$result = $conn->query($query);
										    
										}else{
										    $sql13 = "insert into t_activation ( `user_id`, `activation_key`)values ( '".$userid."','".$activattion_id."')";
										   
												$conn->query($sql13); 
										    
										}
					 				    
	$actual_link = "http://rummysahara.com/public/"."email-verify.php?verify_code=".''.$activattion_id.'';
	$toEmail = $email;
	$subject = "User  Email Verification";
	$content = "Click this link to Verify your Email.". $actual_link . "\n
	Your Activation code is.'$activattion_id'.
	";
	$mailHeaders = "From: noreply@rummysahara.com\r\n";
	if(mail($toEmail, $subject, $content, $mailHeaders)) {
	    
	   echo '1';
	  	
	//	$message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";	
	}else{
	   echo '2';
	    
	}
			}										
													



?>