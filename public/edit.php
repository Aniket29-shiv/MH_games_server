<?php
session_start();
$message='';
$ipadd=$_SERVER['REMOTE_ADDR'];
 include 'database.php';

    
    $sql = "SELECT * FROM users WHERE username='".$_POST["username"]."'"; 
    $result = $conn->query($sql);
    	
    //	$row=$result->fetch_assoc();
    //	$usrname=$row[''];


	if(($result->fetch_assoc())){
	    
       $sql2 = "update users set first_name='".$_POST['FirstName']."',last_name='".$_POST['LastName']."',username='".$_POST['username']."', mobile_no='".$_POST['mobile']."',state='".$_POST['state']."',gender='".$_POST['gender']."',referral_code='".$_POST['referral']."',ip_address='". $ipadd."',created_date='".date('Y-m-d h:i:s')."',updated_date='".date('Y-m-d h:i:s')."' where email='".$_POST['email']."'";
		
	}else{
	    // echo "Username already exists Give another username";
	} 

   	$conn->query($sql2);

    
   $message='Profile Updated Successfully';
	
    $sql1 = "SELECT * FROM users where username = '".$_POST['username']."'";
    $result =$conn->query($sql1);
    $row = $result->fetch_assoc();

    $userid = $row['user_id'];
    $user_name = $row['username'];
		
    $user_full_name=$last_name = $row['last_name']." ".$first_name = $row['first_name'];
    $referral_code = $row['referral_code'];
    
    $_SESSION['logged_user']=$user_name;
    
    
    $email=$row['email'];
    $mob=$row['mobile_no'];
 echo "<script>window.location.href = 'social-profile.php?u=1';</script>";
	//	header("Location:social-profile.php?u=1");
		
     //	header("Location:point-lobby-rummy.php");
	
	//
	
			
														    
	
?>