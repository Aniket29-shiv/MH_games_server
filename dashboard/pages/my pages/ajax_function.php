<?php 
session_start();

include("config.php");
//include('Classes/class.phpmailer.php');
include 'php/Mail.php';
include 'php/Mail/mime.php' ;
include('email/sendEmail.php');
include('sms/sendsms.php');
	
//===================login company address=================	

if(isset($_POST['addserialnumber'])){
 
	 $id = $_POST['addserialnumber'];
	  $number = $_POST['number'];
	
	 $makequery = "SELECT * FROM `webslider`  where rank = '$number' and deleted != 1";
	 $query = mysqli_query($conn,$makequery);
	 if(mysqli_num_rows($query) > 0){
	     echo 0;
	 }else{
	       mysqli_query($conn,"update `webslider` set `rank`='$number' where id='$id'");
	echo 1;
	 }
	
		
	
	 

}



//===================login company address=================	
if(isset($_POST['addserialnumbermobile'])){
 
	 $id = $_POST['addserialnumbermobile'];
	  $number = $_POST['number'];
	
	 $makequery = "SELECT * FROM `mobileslider`  where rank = '$number' and deleted != 1";
	 $query = mysqli_query($conn,$makequery);
	 if(mysqli_num_rows($query) > 0){
	     echo 0;
	 }else{
	       mysqli_query($conn,"update `mobileslider` set `rank`='$number' where id='$id'");
	echo 1;
	 }
	
		
	
	 

}


//===================Promotionstatus=================	
if(isset($_POST['updatepromotionstatus'])){
 
	 $id = $_POST['updatepromotionstatus'];
	 
	
	 $makequery = "SELECT * FROM `promotions`  where id = '$id'";
	 $query = mysqli_query($conn,$makequery);
	 if(mysqli_num_rows($query) > 0){
	     
	     $listdata=mysqli_fetch_object($query);
	     $status=$listdata->status;
	     
	     if($status == 'S'){
	         mysqli_query($conn,"update `promotions` set status='L' where id='$id'");
	    
	     }
	     
	     if($status == 'L'){
	         mysqli_query($conn,"update `promotions` set status='S' where id='$id'");
	     
	     }
	    
	 }
	  echo 1;
}


//===================UPdate  Player Table=================	
if(isset($_POST['updaterummystatus'])){
 
	 $id = $_POST['updaterummystatus'];
	 
	
	 $makequery = "SELECT * FROM `player_table`  where table_id = '$id'";
	 $query = mysqli_query($conn,$makequery);
	 if(mysqli_num_rows($query) > 0){
	     
	     $listdata=mysqli_fetch_object($query);
	     $status=$listdata->table_status;
	     
	     if($status == 'S'){
	         mysqli_query($conn,"update `player_table` set table_status='L' where table_id='$id'");
	    
	     }
	     
	     if($status == 'L'){
	         mysqli_query($conn,"update `player_table` set table_status='S' where table_id='$id'");
	     
	     }
	    
	 }
	  echo 1;
}



//===================UPdate  Player Table=================	
if(isset($_GET['updatewithdrawstatus'])){
 
	 $status = $_GET['updatewithdrawstatus'];
	 $trid = $_GET['trid'];
	 $makequery="update `withdraw_request` set status='$status' where `transaction_id`='$trid'";
	
   mysqli_query($conn,$makequery);
	  
	   
}


//===================UPdate  withdrawal commission=================	
if(isset($_GET['updatewithdrawstatuscommission'])){
 
	 $status = $_GET['updatewithdrawstatuscommission'];
	 $trid = $_GET['trid'];
	 $cdate=date('Y-m-d H:i:s');
	 $makequery="update `withdraw_refcommission_request` set status='$status',updated_on='$cdate' where `transaction_id`='$trid'";
	
   mysqli_query($conn,$makequery);
	  echo 1;
	   
}


//===================update banners=================	
if(isset($_POST['updatebannerstatus'])){
 
	 $id = $_POST['updatebannerstatus'];
	 
	
	 $makequery = "SELECT * FROM `banners`  where id = '$id'";
	 $query = mysqli_query($conn,$makequery);
	 if(mysqli_num_rows($query) > 0){
	     
	     $listdata=mysqli_fetch_object($query);
	     $status=$listdata->status;
	     
	     if($status == 0){
	         mysqli_query($conn,"update `banners` set status=1 where id='$id'");
	    
	     }
	     
	     if($status == 1){
	         mysqli_query($conn,"update `banners` set status=0 where id='$id'");
	     
	     }
	    
	 }
	  echo 1;
}

//===================ID PRoof Verification=================	
if(isset($_POST['idproofverification'])){
 
	 $kycid = $_POST['idproofverification'];
	 
	 $makequery="update `user_kyc_details` set id_proof_status='Verified' where `id`='$kycid'";
	
   mysqli_query($conn,$makequery);
	  
	   
}


//===================ID PRoof Verification=================	
if(isset($_POST['panverification'])){
 
	 $kycid = $_POST['panverification'];
	 
	 $makequery="update `user_kyc_details` set pan_status='Verified' where `id`='$kycid'";
	
   mysqli_query($conn,$makequery);
	  
	   
}

//===================ID PRoof Verification=================	
if(isset($_POST['updatemessagestatus'])){
 
	 $msgid = $_POST['updatemessagestatus'];
	 $status = $_POST['statusmasg'];
	 
	 $makequery="update `user_help_support` set status='$status' where `id`='$msgid'";
	
   mysqli_query($conn,$makequery);
	  
	   
}




//===================ID PRoof Verification=================	
if(isset($_POST['replymessage'])){
 
        $msg = $_POST['replymessage'];
        $ticketid = $_POST['ticketid'];
        $cdate=date('Y-m-d H:i:s');
	 if($msg != ''){
	     $updateequery="UPDATE `user_help_support` SET `lastreply`='ADMIN' WHERE id='$ticketid'";
	     mysqli_query($conn,$updateequery);
	    $makequery="INSERT INTO `user_help_reply`(`ticketid`, `msg`,  `created_date`,`msgby`) VALUES ('$ticketid','$msg','$cdate',1)";
	    mysqli_query($conn,$makequery);
	 }

      $get="select * from `user_help_reply` where `ticketid`='$ticketid' order by id asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      
        	  	  if($listdata->msgby == 0){
        	      $tikid=$listdata->ticketid;
        	  	      $getuser=mysqli_query($conn,"select name from `user_help_support` where `id`='$tikid' ");;
        	  	      $listuser=mysqli_fetch_object($getuser);
                echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                
                <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> '.$listuser->name.'</span>
                <br />'.$listdata->msg. '
                </p></div>';
                
        	  }
    	  
    	   if($listdata->msgby == 1){
    	      
              echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
                                    <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
                                    <br />'.$listdata->msg. '
                                    </p></div>';
            
    	  }
	  }
	   
}

//=========ticket data
if(isset($_POST['ticketdata'])){
 
        $ticketid = $_POST['ticketdata'];
       
      $get="select * from `user_help_reply` where `ticketid`='$ticketid'  order by id asc";
	  $query=mysqli_query($conn,$get);     
	  
	   $getticket="select * from `user_help_support` where `id`='$ticketid'";
                                $queryticket=mysqli_query($conn,$getticket);   
                                $listticket=mysqli_fetch_object($queryticket);
                                if($listticket->ticketby == 0){$textby='You';}else{$textby='Support Department';}
                                echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                                
                                <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listticket->created_date)).'</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> You</span>
                                <br />'.$listticket->message. '
                                </p></div>';
                            
                                while($listdata=mysqli_fetch_object($query)){
                                    
                                    if($listdata->msgby == 0){
                                        $tikid=$listdata->ticketid;
                                        $getuser=mysqli_query($conn,"select name from `user_help_support` where `id`='$tikid' ");;
                                        $listuser=mysqli_fetch_object($getuser);
                                        
                                        if($listdata->type == 0){
                                        
                                        echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                                        
                                        <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> '.$listuser->name.'</span>
                                        <br />'.$listdata->msg. '
                                        </p></div>';
                                        }else{
                                	          $reid=$listdata->id;
                                	          
                                	          $getimg="select * from `user_help_reply_document` where `user_help_reply_id`='$reid'";
                                        	  $queryimg=mysqli_query($conn,$getimg);   
                                        	  $listimg=mysqli_fetch_object($queryimg);
                                        	  if($listimg->image_path != ''){
                                	           echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                                         <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> '.$listuser->name.'</span>
                                        <br />';
                                                    if($listimg->file_type == 'img'){
                                                      echo '<img src="../../../'.$listimg->image_path.'"  style="width: 50%;">';
                                                    }
                                                     if($listimg->file_type == 'doc'){
                                                      echo '<a class="btn btn-primary" href="../../../'.$listimg->image_path.'" download>Download Attachment</a>';
                                                    }
                                                echo '</p></div>';
                                        	  }
                                	      
                                	     }
                                    
                                    }
                                    
                                    if($listdata->msgby == 1){
                                         if($listdata->type == 0){
                                    
                                            echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
                                            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
                                            <br />'.$listdata->msg. '
                                            </p></div>';
                                         }else{
                                	          $reid=$listdata->id;
                                	          
                                	          $getimg="select * from `user_help_reply_document` where `user_help_reply_id`='$reid'";
                                        	  $queryimg=mysqli_query($conn,$getimg);   
                                        	  $listimg=mysqli_fetch_object($queryimg);
                                        	  if($listimg->image_path != ''){
                                	           echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
                                            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
                                            <br />';
                                                    if($listimg->file_type == 'img'){
                                                      echo '<img src="../../../'.$listimg->image_path.'"  style="width: 50%;">';
                                                    }
                                                     if($listimg->file_type == 'doc'){
                                                      echo '<a class="btn btn-primary" href="../../../'.$listimg->image_path.'" download>Download Attachment</a>';
                                                    }
                                                echo '</p></div>';
                                        	  }
                                	      
                                	     }
                                    
                                    
                                    }
                                }
	   
}


//===Test <MAuil

if(isset($_POST['Testmailsend'])){
    
            $to=$_POST['Testmailsend'];
            
    $subject="Testing Mail from Admin";
            
            $sendmessage='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
            <div style="background:#ffffff;padding:20px">
            <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
            <div style=" text-align:center;">
             </div>
            </div>			  
            <div>
            <p style="margin:0px 0px 10px 0px">
            <p>Dear Admin,</p>
            <p>Hi, This is testing mail</p>
             <p>Your Mail Configuration setting is correct.</p>
            <p>Thank you,</p>
            </div>
            <div>
            </div>
            </div>
            </div>';

   if(bulkMail($to,$subject,$sendmessage)) {
       echo 1;
   }else{
       echo 0;
   }
    
}


//===Template Use

if(isset($_POST['template'])){
    
        $template=$_POST['template'];
        $getemp = mysqli_query($conn, "select subject,emessage from `email-template` where id='$template'");
        
        $listdata=mysqli_fetch_object($getemp);
        $temp[] = $listdata;
        echo json_encode($temp);

}



//===SMS Template Use

if(isset($_POST['smstemplate'])){
    
        $template=$_POST['smstemplate'];
        $getemp = mysqli_query($conn, "select message from `sms-template` where id='$template'");
        
        $listdata=mysqli_fetch_object($getemp);
        $temp[] = $listdata;
        echo json_encode($temp);

}


//===Test SMS Send

if(isset($_POST['Testsmssend'])){
    
        $mobile=$_POST['Testsmssend'];
        $message='Hi, This is testing sms from admin';
            if(sendSms($mobile,$message)) {
            echo 1;
            }else{
            echo 0;
            }

}

//===============revert points of joined table
if(isset($_POST['revertpointsofjoinedtable'])){
    
        $cdate=date('Y-m-d H:i:s');
        $id=$_POST['revertpointsofjoinedtable'];
        
        $getemp = mysqli_query($conn, "select * from `user_tabel_join` where id='$id'");
        
        if(mysqli_num_rows($getemp) > 0){
            
                $listdata=mysqli_fetch_object($getemp);
                $chip_type=$listdata->chip_type;
                $username=$listdata->username;
                $user_id=$listdata->user_id;
                $amount_to_revert=$listdata->amount_to_revert;
                 
                $newchips=0;
                $getacc = mysqli_query($conn, "select account_id,play_chips,real_chips from `accounts` where userid='$user_id' and username='$username'");
                $listacc=mysqli_fetch_object($getacc);
                $account_id=$listacc->account_id;
                   
                if( $chip_type=='free'){
                    
                    $play_chips=$listacc->play_chips;
                    $newchips=$play_chips+ $amount_to_revert;
                    $query=mysqli_query($conn, "UPDATE `accounts` SET `play_chips`='$newchips',`updated_date`='$cdate' WHERE account_id='$account_id' and username='$username'");
                    
                }
                
                if( $chip_type=='real'){
                    
                    $real_chips=$listacc->real_chips;
                    $newchips=$real_chips + $amount_to_revert;
                    $query=mysqli_query($conn, "UPDATE `accounts` SET `real_chips`='$newchips',`updated_date`='$cdate' WHERE account_id='$account_id' and username='$username'");
                    
                }
                
                
                if($query){
                    mysqli_query($conn, "DELETE FROM `user_tabel_join` WHERE id='$id'");
                    echo 1;
                }else{
                   echo 0;
                
                }
            
        }

}

//===========delete deleteenquiry message
if(isset($_POST['deleteenquiry'])) {

	$sid = $_POST['deleteenquiry'];
   if($sid != ''){
	 mysqli_query($conn, "DELETE FROM `web_contact_us` WHERE id='$sid'");
		
		 echo 1;
   }else{
   echo 0;
   } 
   
     
}

//===========delete deletefreezed message
if(isset($_POST['deletefreezed'])) {

	$sid = $_POST['deletefreezed'];
   if($sid != ''){
	  mysqli_query($conn, "DELETE FROM `user_tabel_join` WHERE id='$sid'");
		
		 echo 1;
   }else{
   echo 0;
   } 
   
     
}

//===========updateaffiliatecommission
if(isset($_POST['addreffrealcommission'])) {

	$affiliateid = $_POST['addreffrealcommission'];
	$commission = $_POST['commission'];
	$wincommission = $_POST['wincommission'];
    $getquery="SELECT id FROM `referal_commission` where userid='$affiliateid'";
    $get=mysqli_query($conn,$getquery); 
    if(mysqli_num_rows($get) > 0){
        $getquery1="update `referal_commission` set commission='$commission',wincommission='$wincommission'  where userid='$affiliateid'"; 
        $result=mysqli_query($conn,$getquery1); 
    }else{
        $getquery1="insert into `referal_commission`(`userid`,`commission`,wincommission) VALUES ('$affiliateid','$commission','$wincommission')"; 
        $result=mysqli_query($conn,$getquery1); 
    }
    if($result){ echo 1;}else{ echo 0;}
               
}

//===========getreffralcommission
if(isset($_POST['getreffrealcommission'])) {

	$userid = $_POST['getreffrealcommission'];
    if($userid != ''){
        $getquery="SELECT * FROM `referal_commission` where userid='$userid'";
       // echo  $getquery;
        $get=mysqli_query($conn,$getquery); 
        if(mysqli_num_rows($get) > 0){
            $listdata=mysqli_fetch_object($get);
            $arr = array();
            $arr['comm'] = $listdata->commission;
            $arr['wincomm'] = $listdata->wincommission;
            echo json_encode($arr);;
        }else{
            echo 0;
        }
	}else{
	    echo 0;
	}
               
}

//===================Deactivate player=================	
if(isset($_POST['updateuserloginstatus'])){
 
	 $id = $_POST['updateuserloginstatus'];
	 
	
	 $makequery = "SELECT * FROM `users`  where user_id = '$id'";
	 $query = mysqli_query($conn,$makequery);
	 if(mysqli_num_rows($query) > 0){
	     
	     $listdata=mysqli_fetch_object($query);
	     $status=$listdata->login_status;
	     
	     if($status == 0){
	         mysqli_query($conn,"update `users` set login_status=1 where user_id='$id'");
	    
	     }
	     
	     if($status == 1){
	         mysqli_query($conn,"update `users` set login_status=0 where user_id='$id'");
	     
	     }
	    
	 }
	  echo 1;
}


?>
