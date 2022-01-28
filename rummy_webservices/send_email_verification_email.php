<?php

error_reporting(0);
include 'config.php';
include "../public/database.php";
// include('../public/Classes/class.phpmailer.php');
include ('php/Mail.php');
include ('php/Mail/mime.php');
include('../public/email/sendEmail.php');

$email = $_GET['email'];
$userid = $_GET['user_id'];


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
									
	$seluser1 = "SELECT * FROM t_activation  WHERE user_id = '$userid'";
    $result1 = $connect->query($seluser1);
    if($result1->num_rows > 0)
    {
        $sql_update = "update t_activation set activation_key= '".$activattion_id."' where user_id = '".$userid."'";
		$connect->query($sql_update);
    }
    else
    {
        $sql13 = "insert into t_activation ( `user_id`, `activation_key`)values ( '".$userid."','".$activattion_id."')";
        $connect->query($sql13);   
    }
    
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
	
// 	if(mail($toEmail, $subject, $content, $mailHeaders)) 
    if(bulkMail($toEmail,$subject,$message))
	{
	    $myObj->status = "True";
	}
	else
	{
	    $myObj->status = "False";
	}

	
	
echo json_encode($myObj);

$connect->close();
?>