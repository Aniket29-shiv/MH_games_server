<?php 
 
 //importing dbDetails file 
error_reporting(E_ALL);
include 'config.php';

    $userId = $_REQUEST['userId'];
    $username = $_REQUEST['username'];
    $ImageData = $_REQUEST['base64'];
    $fileName = $_REQUEST['file_name'];
    $current_date = date('Y-m-d H:i:s');
	
    
    $file_path = "../uploads/user_avatar/";
    $timestamp = date("Y_m_d_H_i_s");
    $pic = "../uploads/user_avatar/" . $timestamp . $fileName;
  
    $file_path = $file_path .$timestamp . $fileName;
    
    if (file_put_contents($file_path,base64_decode($ImageData)))
    {
        
        $result_user_check = $connect->query("SELECT * FROM `user_avatar` where user_id = '".$userId."'");    
    	if($result_user_check->num_rows > 0 )
    	{ 
            $updatesql = "update user_avatar set image= '".$pic."' where user_id = '".$userId."'";
            
            $result = $connect->query($updatesql);
            if ($result === true) 
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
            $insertsql = "insert into user_avatar (`user_id`, `username`, `image`)values ( '".$userId."','".$username."','".$pic."')";
            if($connect->query($insertsql))
            {
                $myObj->status = "Success";
            }
            else
            {
                $myObj->status = "False";
            }
        }
    }
    else
    {
        $myObj->status = "False";
    }
    
    echo json_encode($myObj);
    
    $connect->close();
 
?>