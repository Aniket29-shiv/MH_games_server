<?php
include 'database.php';
	//include('Classes/class.phpmailer.php');
	include 'php/Mail.php';
include 'php/Mail/mime.php' ;
include('email/sendEmail.php');
$uploaddir = '../uploads/';
//print_r($_POST);
$username = $_POST['usernm'];
$userid=$_POST['userid'];

$email=$_POST['user_email']	;

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
					 				    
					 				    				

	  $subject="Email Verification From  RummySahara. ";
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
            
            <p>   Click this link to Verify your Email.</p>
            <p style="text-align: center; margin-top: 38px;">
            <span style=" background: #a50b0b;padding: 12px;">
            <a href="http://rummysahara.com/public/email-verify.php?verify_code='.$activattion_id.'&id='.$userid.'" target="_blank" rel="noreferrer" style="color: white;">Click Here</a>
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
                echo 3; 
                
            }else{ 
                echo "2"; 
            }

//header("Location:update-kyc.php");



 


$conn->close();


?>