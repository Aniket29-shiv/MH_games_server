<?php
    include "database.php";
   	//include('Classes/class.phpmailer.php');
	include 'php/Mail.php';
    include 'php/Mail/mime.php' ;
    include('email/sendEmail.php');
   // print_r($_POST); //die();
    $username = strtolower($_POST['user_name']);
    $email = $_POST['email'];
    $mobile = $_POST['user_mobile'];
    $gender = $_POST['gender'];
    $pass = $_POST['user_pwd'];
    $state = $_POST['state'];
    $user_ref = $_POST["user_ref"];
    $created_date = date('Y/m/d h:m:s');
     $cdate = date('Y-m-d h:i:s');//date('Y/m/d');
    $ipaddress = get_client_ip(); 
    //$user_ref = $_POST["user_ref"];
 
     /*if(empty($user_ref)){
         
        if(isset($_POST["refid"])){
            $user_ref=$_POST["refid"];
        }else{
           $user_ref ='0'; 
        }
        
     }*/
     if($user_ref){
         
         $user_ref=$user_ref;
     }
     else{
           $user_ref ='0'; 
        }
    ob_start();
    system('ipconfig /all');
    $mycom=ob_get_contents();
    ob_clean();
    $findme = "Physical";
    $pmac = strpos($mycom, $findme);
    $mac=substr($mycom,($pmac+36),17);
     $checkusername = "SELECT * FROM users where username = '".$username."'";
     $checkresult = $conn->query($checkusername);
  $reg=0;  
if (!ctype_alnum($username)) {  $reg=1; }
if ($checkresult->num_rows > 0) { $reg=1;}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {$reg=1;}
 if(!preg_match('/^\d{10}$/',$mobile)){$reg=1;}
    
if ($reg == 0) {
    ///insert data to users after register 
    $sql = "insert into users (`username`, `mobile_no`, `email`, password,`state`,`mac_address`, `ip_address`,`referral_code`, `created_date`, `updated_date`,gender)values ( '".$username."','".$mobile."','".$email."','".md5($pass)."','".$state."','".$mac."','".$ipaddress."','".$user_ref."','".$created_date."','".$created_date."','".$gender."')";
    $conn->query($sql);
    
    ///get username and userid of registered user 
    $sql1 = "SELECT * FROM users where username = '".$username."'";
    $result = $conn->query($sql1);
    if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
            	$userid = $row['user_id'];
            	$user_name = $row['username'];
            		$user_full_name=$last_name = $row['last_name']." ".$first_name = $row['first_name'];
            		$referral_code = $row['referral_code'];
            }
            $query_bonus_entry = "select * from bonus_entry order by  created_on  desc limit 1";
            $bonus_result_raw = $conn->query($query_bonus_entry);
            if($bonus_result_raw->num_rows > 0  ){
                $bonus_result = $bonus_result_raw->fetch_assoc();
                $reg_bonus= $bonus_result['reg_bonus'];
                $ref_bonus=$bonus_result['ref_bonus'];
                  $real_chips=$bonus_result['real_chips'];
            }
            if($referral_code!='0'){
                    $sql_ref_check = "SELECT * FROM users where user_id = '".$referral_code."'";
                    $result_ref = $conn->query($sql_ref_check);
                    if ($result_ref->num_rows > 0){
                            $row_ref = $result_ref->fetch_assoc();
                            $ref_userid = $row_ref['user_id'];
                            $ref_username = $row_ref['username'];
                            $ref_userfull_name=$first_name = $row_ref['first_name']." ".$last_name = $row_ref['last_name'];
                            $sql_ref_bonus = "insert into referral_bonus (`referral_id`,`ref_username`,`refrral_name`,`user_id`,`username`,`user_full_name`,`ref_bonus`,`date`)values ( '".$ref_userid."','".$ref_username."','".$ref_userfull_name."','".$userid."','".$user_name."','".$user_full_name."','".$ref_bonus."','".$created_date."')";
                            $conn->query($sql_ref_bonus);
                    }	
            }
	
            //insert data to accounts 
            $play_chips = 10000;
            $sql2 = "insert into accounts (`userid`, `username`, `play_chips`, `real_chips`, `redeemable_balance`, `bonus`, `player_club`, `player_status`, `created_date`, `updated_date`)values ( '".$userid."','".$user_name."','".$play_chips."','".$real_chips."','0','0','Silver','Regular','".$created_date."','".$created_date."')";
            $conn->query($sql2);
            
            //===fund added to player entry
            $addfund = "INSERT INTO `fund_added_to_player`(`user_id`, `amount`, `created_date`, `chip_type`, `transaction_id`, `payment_mode`, `order_id`, `status`) VALUES ('".$userid."','".$real_chips."','".$cdate."','Real','0','signup','0','success')";
            $conn->query($addfund);
                        
            //insert data to user_kyc_details 
            $email_status = 'Not Verified';
            $mobile_status = 'Not Verified';
            $sql3 = "insert into user_kyc_details ( `userid`, `username`, `email`,mobile_no,`created_date`, `updated_date`,`email_status`,`mobile_status`)values ( '".$userid."','".$user_name."','".$email."','".$mobile."','".$created_date."','".$created_date."','".$email_status."','".$mobile_status."')";
            $conn->query($sql3);
    
	
	        if(!empty($userid)) {
													    
    												
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
                    $sql13 = "insert into t_activation ( `user_id`,`activation_key`)values ( '".$userid."','".$activattion_id."')";
                    $conn->query($sql13);
    												
												
	
	
                    
                    $subject="User Registration Activation Email From  RummySahara. ";
                    $to=$email;
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
                    
                    <p>  Click this link to activate your account.</p>
                    <p style="text-align: center; margin-top: 38px;">
                    <span style=" background: #a50b0b;padding: 12px;">
                    <a href="'.$mainurl.'public/activate.php?activattion_id='.$activattion_id.'" target="_blank" rel="noreferrer" style="color: white;">Click Here</a>
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
                    if(bulkMail($to,$subject,$message)) {
                   
                    }
													
													
			}

    	   echo true;
	   
    }else{
        
    	echo false;
    }
}
$conn->close();
/* echo '<script>';
echo 'alert("Successfully Registered ,You can Login now..! ")';		
echo '</script>'; */
//header("Location:../index.php?user_registered=true");

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>