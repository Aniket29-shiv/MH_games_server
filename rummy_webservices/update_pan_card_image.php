<?php 
 
 //importing dbDetails file 
error_reporting(E_ALL);
include 'config.php';

    $username = $_REQUEST['username'];
    $ImageData = $_REQUEST['base64'];
    $fileName = $_REQUEST['file_name'];
	
    
    $file_path = "../uploads/";
    $timestamp = date("Y_m_d_H_i_s");
    $pic = "../uploads/" . $timestamp . $fileName;
  
    $file_path = $file_path .$timestamp . $fileName;
    
    if (file_put_contents($file_path,base64_decode($ImageData)))
    {
         $updatesql = "update user_kyc_details set pan_card_url= '".$pic."' where username = '".$username."'";
	    $updateresult = $connect->query($updatesql);
	    
	    if ($updateresult === true)
	    {
	        $myObj->status = "Success";
	    }
	    else
	    {
	        $myObj->status = "False";
	    }
    }
    else
    {
        $myObj->status = "False";
    }
    
    echo json_encode($myObj);
    
    $connect->close();
 
?>