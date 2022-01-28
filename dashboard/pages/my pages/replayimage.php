<?php

session_start();
ini_set('max_execution_time', '0');
include("config.php");

        $msg = $_POST['replymsg'];
        $ticketid = $_POST['selectedticket'];
        $cdate=date('Y-m-d H:i:s');
      
         $target_dir = "../../../uploads/user_reply/";
         $allow_types = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG","tif","tiff","jif","jfif","jp2","jpx","j2k","j2c","fpx","pcd");
         $allow_types2 = array("doc", "docx", "odt", "pdf","rtf", "tex", "txt", "wpd", "wks", "wps");
         
     
            
    $images_arr = array();
    foreach($_FILES['images']['name'] as $key=>$val){
            $image_name = $_FILES['images']['name'][$key];
            $tmp_name   = $_FILES['images']['tmp_name'][$key];
            $size       = $_FILES['images']['size'][$key];
            $type       = $_FILES['images']['type'][$key];
            $error      = $_FILES['images']['error'][$key];
            
            
            
            $file_name = basename($_FILES['images']['name'][$key]);
            $targetFilePath = $target_dir . $file_name;
            
            
            $file_type = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                if(in_array($file_type, $allow_types)){    
                
                    if(move_uploaded_file($_FILES['images']['tmp_name'][$key],$targetFilePath)){
                        
                        
	     
            	     $updateequery="UPDATE `user_help_support` SET `lastreply`='ADMIN' WHERE id='$ticketid'";
            	     mysqli_query($conn,$updateequery);
            	     $makequery="INSERT INTO `user_help_reply`(`ticketid`, `msg`,`type`,  `created_date`,`msgby`,`reply_by`) VALUES ('$ticketid','',1,'$cdate',1,'ADMIN')";
            	     $result=mysqli_query($conn,$makequery);
            	     $lastinsertid=mysqli_insert_id($conn);
            	     $imagefile='../uploads/user_reply/'.$file_name;
            	     $makequery="INSERT INTO `user_help_reply_document`( `user_help_reply_id`, `image_path`,`file_type`) VALUES ('$lastinsertid','$imagefile','img')";
            	     $result=mysqli_query($conn,$makequery);
	 
                    
                    }
                }
                
                 if(in_array($file_type, $allow_types2)){    
                
                    if(move_uploaded_file($_FILES['images']['tmp_name'][$key],$targetFilePath)){
                        
                        
	     
            	     $updateequery="UPDATE `user_help_support` SET `lastreply`='ADMIN' WHERE id='$ticketid'";
            	     mysqli_query($conn,$updateequery);
            	     $makequery="INSERT INTO `user_help_reply`(`ticketid`, `msg`,`type`,  `created_date`,`msgby`,`reply_by`) VALUES ('$ticketid','',1,'$cdate',1,'ADMIN')";
            	     $result=mysqli_query($conn,$makequery);
            	     $lastinsertid=mysqli_insert_id($conn);
            	     $imagefile='../uploads/user_reply/'.$file_name;
            	     $makequery="INSERT INTO `user_help_reply_document`( `user_help_reply_id`, `image_path`,`file_type`) VALUES ('$lastinsertid','$imagefile','doc')";
            	     $result=mysqli_query($conn,$makequery);
	 
                    
                    }
                }
                
                
                
        }
            
            
            
    
                    if($msg != ''){
                    
                        $updateequery="UPDATE `user_help_support` SET `lastreply`='User' WHERE id='$ticketid'";
                        mysqli_query($conn,$updateequery);
                        $makequery="INSERT INTO `user_help_reply`(`ticketid`, `msg`,  `created_date`,`msgby`,`reply_by`) VALUES ('$ticketid','$msg','$cdate',1,'ADMIN')";
                        mysqli_query($conn,$makequery);
                    }
                    
                    $get="select * from `user_help_reply` where `ticketid`='$ticketid' order by id asc";
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
                                                    echo '<img src="../../'.$listimg->image_path.'"  style="width: 50%;">';
                                                    }
                                                    if($listimg->file_type == 'doc'){
                                                    echo '<a class="btn btn-primary" href="../../'.$listimg->image_path.'" download>Download Attachment</a>';
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
                                                            echo '<img src="../../'.$listimg->image_path.'"  style="width: 50%;">';
                                                            }
                                                            if($listimg->file_type == 'doc'){
                                                            echo '<a class="btn btn-primary" href="../../'.$listimg->image_path.'" download>Download Attachment</a>';
                                                            }
                                                    echo '</p></div>';
                                                }
                                            
                                            }
                                    
                                    
                                    }
                                    
                                    
                                    if($listdata->msgby == 2){
                                        
                                            if($listdata->type == 0){
                                            
                                            echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
                                            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> '.$listdata->reply_by.'</span>
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
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b>  '.$listdata->reply_by.'</span>
                                                    <br />';
                                                            if($listimg->file_type == 'img'){
                                                            echo '<img src="../../'.$listimg->image_path.'"  style="width: 50%;">';
                                                            }
                                                            if($listimg->file_type == 'doc'){
                                                            echo '<a class="btn btn-primary" href="../../'.$listimg->image_path.'" download>Download Attachment</a>';
                                                            }
                                                    echo '</p></div>';
                                                }
                                            
                                            }
                                    
                                    
                                    }
                    }

	   
         
?>      
         
         
         