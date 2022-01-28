<?php

$message='';
$eid='';
$username='';
$first_name="";
$middle_name="";
$last_name="";
$mobile_no="";
$email="";
$state="";
$gender="";
$address="";
$city="";
$pincode="";

//===KYC veriable
$estatus='';
$mstatus='';
$idstatus='';
$idproof='';
$pan='';
$pstatus='';
$panimage='';
$idimage='';

if(isset($_GET['eid'])){
    
    $eid=$_GET['eid'];
    
    //======Profile Data
    $makequery="select  `username`, `first_name`, `middle_name`, `last_name`,`mobile_no`, `email`,  `state`, `gender`, `address`, `city`, `pincode` from `users` where user_id = '$eid'";
	$query=mysqli_query ($conn,$makequery);
    $listdata=mysqli_fetch_object($query);
   
    $username=$listdata->username;
    $first_name=$listdata->first_name;
    $middle_name=$listdata->middle_name;
    $last_name=$listdata->last_name;
    $mobile_no=$listdata->mobile_no;
    $email=$listdata->email;
    $state=$listdata->state;
    $gender=$listdata->gender;
    $address=$listdata->address;
    $city=$listdata->city;
    $pincode=$listdata->pincode;
    
    //===KYC Data=====================
   
    $makequery1="select  `email`, `email_status`, `mobile_no`, `mobile_status`, `id_proof`, `id_proof_status`, `pan_no`, `pan_status`, `id_proof_url`, `pan_card_url` from `user_kyc_details` where userid = '$eid'";
	$query1=mysqli_query ($conn,$makequery1);
    $listdata1=mysqli_fetch_object($query1);
   
    
    $estatus=$listdata1->email_status;
    $mstatus=$listdata1->mobile_status;
    $idstatus=$listdata1->id_proof_status;
    $idproof=$listdata1->id_proof;
    $pan=$listdata1->pan_no;
    $pstatus=$listdata1->pan_status;
    $panimage=$listdata1->pan_card_url;
    $idimage=$listdata1->id_proof_url;
}




if(isset($_POST['btnSubmit'])){
    
    $eid=$_POST['eid'];
 
    $username=$_POST['username'];
    $first_name=$_POST['first_name'];
    $middle_name=$_POST['middle_name'];
    $last_name=$_POST['last_name'];
    $mobile_no=$_POST['mobile_no'];
    $email=$_POST['email'];
    $state=$_POST['state'];
    $gender=$_POST['gender'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $pincode=$_POST['pincode'];
    
    $cdate=date('Y-m-d H:i:s');
       
        
   
       //username validation
        $reg=0;
    
        $makequery="select * from `users` where `username`='$username' and user_id != '$eid'";
        $query=mysqli_query ($conn,$makequery);
        
        if(mysqli_num_rows($query) > 0){
            $reg=1; $message="Username Alredy Exists";
            return false; exit();
        }
       
       
          if($reg == 0){
          
             if($eid != ''){
              
                 $makequery="UPDATE `users` SET `username`='$username',`first_name`='$first_name', `middle_name`='$middle_name',`last_name`='$last_name',`mobile_no`= '$mobile_no' ,`email`= '$email',`state`= '$state',`gender`= '$gender',`address`= '$address',`city`= '$city',`pincode`= '$pincode', `updated_date`= '$cdate', `update_by`= 1 where user_id='$eid'";
                mysqli_query ($conn,$makequery);
                
                 $makequery1="UPDATE `user_kyc_details` SET  `email`='$email',  `mobile_no`='$mobile_no' where userid='$eid'";
                	mysqli_query ($conn,$makequery1);
            	echo '<script>window.location.href="editplayer.php?eid='.$eid.'&status=2"</script>';
             
             }else{
                    $reg=1; $message="Error Occured.....! Try Again.";
                    return false; exit();
               }
          }
      
							
}



//=======================================Kyc SUbmit
$path = "../../../uploads/";
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG");

if(isset($_POST['kycSubmit'])){
    
    $eid=$_POST['eid'];
 
    $email=$_POST['email'];
    $estatus=$_POST['estatus'];
    $mobile=$_POST['mobile'];
    $mstatus=$_POST['mstatus'];
    $idproof=$_POST['idproof'];
    $idstatus=$_POST['idstatus'];
    $pan=$_POST['pan'];
    $pstatus=$_POST['pstatus'];
    $pimage = $_FILES['pimage']['name'];
    $iimage = $_FILES['iimage']['name'];
    
     if($pimage != '') {
        list($txt, $ext) = explode(".", $pimage);
        if(in_array($ext,$valid_formats)){
            global $upload_image;
    		$upload_image = time()."_".$txt.".".$ext;
    		$tmp = $_FILES['pimage']['tmp_name'];	
    		move_uploaded_file($tmp, $path.$upload_image);
        }
       $theimage = '../uploads/'.$upload_image;			
    } else {
         $theimage = $_POST['pancardimage'];
    }
    
    
     if($iimage != '') {
        list($txt1, $ext1) = explode(".", $iimage);
        if(in_array($ext1,$valid_formats)){
            global $upload_image1;
    		$upload_image1 = time()."_".$txt1.".".$ext1;
    		$tmp1 = $_FILES['iimage']['tmp_name'];	
    		move_uploaded_file($tmp1, $path.$upload_image1);
        }
       $theimage1 = '../uploads/'.$upload_image1;			
    } else {
         $theimage1 = $_POST['idproofimage'];
    }
    
    $cdate=date('Y-m-d H:i:s');
       
        
   
       
         
          
             if($eid != ''){
              
                 $makequery="UPDATE `user_kyc_details` SET  `email`='$email', `email_status`='$estatus', `mobile_no`='$mobile', `mobile_status`='$mstatus', `id_proof`='$idproof', `id_proof_status`='$idstatus', `pan_no`='$pan', `pan_status`='$pstatus', `id_proof_url`='$theimage1', `pan_card_url`='$theimage' where userid='$eid'";
                	mysqli_query ($conn,$makequery);
                	$makequery1="UPDATE `users` SET `mobile_no`= '$mobile' ,`email`= '$email' where user_id='$eid'";
                	mysqli_query ($conn,$makequery1);
                	
            	echo '<script>window.location.href="editplayer.php?eid='.$eid.'&status1=2"</script>';
             
             }else{
                   $message1="Error Occured.....! Try Again.";
                    return false; exit();
               }
          
      
							
}


?>
