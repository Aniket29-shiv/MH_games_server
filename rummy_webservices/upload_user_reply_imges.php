<?php 
 
 //importing dbDetails file 
error_reporting(E_ALL);
include 'config.php';

    $supportId = $_REQUEST['supportId'];
    $ImageData = $_REQUEST['base64'];
    $fileName = $_REQUEST['file_name'];
    $message = $_REQUEST['message'];
    $current_date = date('Y-m-d H:i:s');
	
    
    $file_path = "../uploads/user_reply/";
    $timestamp = date("Y_m_d_H_i_s");
    $pic = "../uploads/user_reply/" . $timestamp . $fileName;
  
    $file_path = $file_path .$timestamp . $fileName;
    
    if (file_put_contents($file_path,base64_decode($ImageData)))
    {
        
        $insertmessagesql = "insert into user_help_reply ( `ticketid`, `msg`, `msgby`, `created_date`, `type`)values ( '".$supportId."','".$message."','0','".$current_date."','1')";
            
        if ($connect->query($insertmessagesql)) 
    	{
    	    $last_id = $connect->insert_id;
    	    
            $insertimagesql = "insert into user_help_reply_document ( `user_help_reply_id`, `image_path`, `file_type`)values ( '".$last_id."','".$pic."','img')";
    	    
            if ($connect->query($insertimagesql)) 
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
    }
    else
    {
        $myObj->status = "False";
    }
    
    echo json_encode($myObj);
    
    $connect->close();
 
?>