<?php
error_reporting(0);
include 'config.php';

$username = $_GET['username'];
$userid = $_GET['user_id'];

$seluser = "SELECT * FROM user_kyc_details  WHERE username = '$username'";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
	    $mobileNo = $userdata['mobile_no'];
	    $emailVerify = "Not Verified";
	    $mobileVerify = "Not Verified";
	    $seluser1 = "SELECT * FROM t_activation  WHERE user_id = '$userid'";
        $result1 = $connect->query($seluser1);
        if($result1->num_rows > 0)
        {
            $row = $result1->fetch_assoc();
            $activationCode = $row['activation_key'];
            
            if ($activationCode == 0)
            {
                $emailVerify = "Verified";
            }
        }
        
        $seluser2 = "SELECT * FROM sms_otp  WHERE mobile_no = '$mobileNo'";
        $result2 = $connect->query($seluser2);
        if($result2->num_rows > 0)
        {
            $row1 = $result2->fetch_assoc();
            $otp = $row1['otp'];
            
            if ($otp == 0)
            {
                $mobileVerify = "Verified";
            }
        }
	    
    	$json_user[] = array('email' => $userdata['email'],'mobile_no' => $userdata['mobile_no'],'email_status' => $emailVerify,'mobile_status' => $mobileVerify,'id_proof' => $userdata['id_proof'],'id_proof_status' => $userdata['id_proof_status'],'pan_no' => $userdata['pan_no'],'pan_status' => $userdata['pan_status'],'id_proof_url' => $userdata['id_proof_url'],'pan_card_url' => $userdata['pan_card_url']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'kyc_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
