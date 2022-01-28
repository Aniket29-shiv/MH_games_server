<?php
   	session_start();
   	include 'database.php';
   	
    $_SESSION["id"] = $_POST["id"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    $email=$_SESSION["email"] ;
    //echo '<script>alert('.$email.');</script>';
    $ipadd=$_SERVER['REMOTE_ADDR'];
    $fnm=explode(" ",$_SESSION["name"]);
    $lnamee=$fnm[1];
    $myStr= $fnm[0];  
    $resultnm = substr($myStr, 0, 3);
    $three=rand(15,999);
    $mstr=strtolower($myStr);
    $usernm=  $mstr.$three;	
	$_SESSION['logged_user']=$usernm;
		
    
	//======password generater=============================
    function generateRandomString($length = 10) {
        
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
                
                for ($i = 0; $i < $length; $i++) {
                    
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                    
                }
            
             return $randomString;
    }
    
    $newpass=generateRandomString();
        

       

    
	$sql = "SELECT * FROM users WHERE email='".$_SESSION["email"]."'";
	$result = $conn->query($sql);
    $row=$result->fetch_assoc();
    $dbbemail=$row['email'];
    
    
	if($dbbemail == $_SESSION["email"]){
	     $userid = $row['user_id'];
        $user_name = $row['username'];
	$_SESSION['logged_user']=$user_name;   
	$_SESSION['user_id']=$userid;
	      //header("Location:point-lobby-rummy.php");
	   echo '<script type="text/javascript">window.location.href="Location:point-lobby-rummy.php";</script>';
	    //	echo "Email already exists";
	}else{
	    
        $sql2 = "INSERT INTO users (username,first_name,last_name, mobile_no,email,password,gender,state,referral_code,mac_address,ip_address,created_date,updated_date) VALUES ('".$usernm."','".$myStr."','".$lnamee."', ' ','".$_SESSION["email"]."','".$newpass." ',' ', ' ', '0','00000','".$ipadd."','".date('Y-m-d h:i:s')."','".date('Y-m-d h:i:s')."')";
        
        $conn->query($sql2);
    
        // header("Location:update_Profile.php");
   
   
        $sql1 = "SELECT * FROM users where username = '".$usernm."'";
        $result1 =$conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        
        $userid = $row1['user_id'];
        $user_name = $row1['username'];
        
        $user_full_name=$last_name = $row1['last_name']." ".$first_name = $row1['first_name'];
        $referral_code = $row1['referral_code'];
        	$_SESSION['user_id']=$userid;
        $_SESSION['logged_user']=$user_name;
         $email=$row1['email'];
        $mob=$row1['mobile_no'];
        
        //insert into t_activation table
        
        $activattion_id=0;	    
									// 	$encrypted=encryptIt( $activattion_id );
											
        $sql13 = "insert into t_activation ( `user_id`, `activation_key`)values ( '".$userid."','".$activattion_id."')";
        
        $conn->query($sql13);	
        
        $query_bonus_entry = "select * from bonus_entry order by  created_on  desc limit 1";
        $bonus_result_raw = $conn->query($query_bonus_entry);
        
                        	 
                if($bonus_result_raw->num_rows > 0  ){
                    
                        $bonus_result = $bonus_result_raw->fetch_assoc(); 
                        $reg_bonus= $bonus_result['reg_bonus'];
                        $ref_bonus=$bonus_result['ref_bonus'];
                        
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
        $play_chips = 15000;
        $sql2 = "insert into accounts (`userid`, `username`, `play_chips`, `real_chips`, `redeemable_balance`, `bonus`, `player_club`, `player_status`, `created_date`, `updated_date`)values ( '".$userid."','".$user_name."','".$play_chips."','0','0','".$reg_bonus."','Silver','Regular','".date('Y-m-d h:i:s')."','".date('Y-m-d h:i:s')."')";
        $conn->query($sql2);
        
        //insert data to user_kyc_details 
        $email_status = 'Not Verified';
        $mobile_status = 'Not Verified';
        $sql3 = "insert into user_kyc_details ( `userid`, `username`, `email`,mobile_no,`created_date`, `updated_date`,`email_status`,`mobile_status`)values ( '".$userid."','".$user_name."','".$email."','".$mob."','".date('Y-m-d h:i:s')."','".date('Y-m-d h:i:s')."','".$email_status."','".$mobile_status."')";
        
        $conn->query($sql3);
	}




	//echo "Updated Successful";
?>