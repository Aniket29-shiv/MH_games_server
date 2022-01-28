<?php


// ini_set('display_startup_errors',1);
// ini_set('display_errors',1);
// error_reporting(-1);

error_reporting(0);
include 'config.php';
include "../public/database.php";
// include('../public/Classes/class.phpmailer.php');
include ('php/Mail.php');
include ('php/Mail/mime.php');
include('../public/email/sendEmail.php');

$email = $_GET['email'];


    $seluser2 = "SELECT * FROM users  WHERE email = '$email'";
    $result2 = $connect->query($seluser2);
    if($result2->num_rows > 0)
    {
        $row = $result2->fetch_assoc();
        $userid = $row['user_id'];
        
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
    									
    	$seluser1 = "SELECT * FROM reset_code  WHERE user_id = '$userid'";
        $result1 = $connect->query($seluser1);
        if($result1->num_rows > 0)
        {
            $sql_update = "update reset_code set reset_code= '".$activattion_id."' where user_id = '".$userid."'";
    		$connect->query($sql_update);
        }
        else
        {
            $sql13 = "insert into reset_code ( `user_id`, `reset_code`)values ( '".$userid."','".$activattion_id."')";
            $connect->query($sql13);   
        }
        
    	$actual_link = "http://rummysahara.com/"."reset-code.php?reset_code=".''.$activattion_id.'';
    	$toEmail = $email;
    	$subject = "Forget Password Link From  RummySahara. ";
    	$content = "Click this link to Reset your account Password.:" . $actual_link . "
    	Your Reset code is.'$activattion_id'.";
    	$mailHeaders = "From: noreply@rummysahara.com\r\n";
    // 	if(mail($toEmail, $subject, $content, $mailHeaders)) 
    // 	{
    // 	    $myObj->status = "True";
    // 	}
    // 	else
    // 	{
    // 	    $myObj->status = "False";
    // 	}
    
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
                        
                        <p>  Click on following link to Change your account Password.</p>
                        <p style="text-align: center; margin-top: 38px;">
                        <span style=" background: #a50b0b;padding: 12px;">
                        <a href="http://rummysahara.com/public/reset-code.php?reset-code='.$activattion_id.'" target="_blank" rel="noreferrer" style="color: white;">Click Here</a>
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
    
        if(bulkMail($toEmail,$subject,$message))
        {
            $myObj->status = "True";
        }
        else
        {
            $myObj->status = "False";
        }
    }
    else
    {
        $myObj->status = "Email Not Exist";
    }
	
	
echo json_encode($myObj);

$connect->close();
?>