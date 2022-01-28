<?php
        
$json = '';
$response = ''; 
$count=0;
$countf=0;


        
if(isset($_POST['send_notif'])){
    
       $ptype=$_POST['ptype'];
        
        $firebase = new Firebase();
        $push = new Push();
        
        //optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        $push_type = 'individual';
       
       
            if($ptype == 'fail'){
           
                      $query= mysqli_query($conn,"SELECT * FROM `notifications` where status='fail' and regid != ''");
                      
                      
                   
                      while($listdata=mysqli_fetch_object($query)){
                          
                            $regId=$listdata->regid;
                            $notificationid=$listdata->id;
                            $title=$listdata->title;
                            $message=$listdata->description;
                            $push->setTitle($title);
                            $push->setMessage($message);
                            $push->setImage('');
                            $push->setIsBackground(FALSE);
                            $push->setPayload($payload);
                            
                            
                            $json = $push->getPush();
                            $response = $firebase->send($regId, $json);
                            $data = json_decode($response);
                            $success=$data->success;
                            if($success == 1){ 
                                $status='success'; 
                                $count++;
                              mysqli_query($conn," UPDATE `notifications` SET `status`='$status' WHERE id='$notificationid'");
                            }else{
                            $countf++;
                            }
                           
                            //echo 
                          
                      }
           
           
            }else{
           
       
                   $message=$_POST['message'];
                   $title=$_POST['title'];
                   $cdate=date('Y-m-d H:i:s');
                  
                    
            
                   
                   
                   if($ptype == 'All Player'){
                       
                      $query= mysqli_query($conn,"SELECT f.*,u.username FROM `user_firebase_reg_id` as f left join users as u on u.user_id=f.user_id");
                      
                      while($listdata=mysqli_fetch_object($query)){
                          
                            $username=$listdata->username;
                            
                            $regId=$listdata->firebase_reg_id;
                            $push->setTitle($title);
                            $push->setMessage($message);
                            $push->setImage('');
                            $push->setIsBackground(FALSE);
                            $push->setPayload($payload);
                            
                            
                            $json = $push->getPush();
                            $response = $firebase->send($regId, $json);
                            $data = json_decode($response);
                            $success=$data->success;
                            if($success == 1){ $status='success';  $count++;}else{ $status='fail'; $countf++;}
                           
                             mysqli_query($conn,"INSERT INTO `notifications`(`username`, `title`, `description`,  `created_date`, `status`, `regid`,`send_type`) VALUES ('$username','$title','$message','$cdate','$status','$regId','$ptype')");
                            //echo 
                           
                      }
                   
                   }else{
                       
                        $username=$_POST['hidden-fireregid'];
                        $arr_username = explode (",", $username);  
                        
                        foreach ($arr_username as $value){
                            $query= mysqli_query($conn,"SELECT user_id FROM `users` where username='$value' ");
                         
                                if(mysqli_num_rows($query) > 0){
                                
                                        $listuname=mysqli_fetch_object($query);
                                        $userid= $listuname->id;
                                            $query1= mysqli_query($conn,"SELECT * FROM `user_firebase_reg_id` where user_id=user_id");
                                            
                                           if(mysqli_num_rows($query) > 0){  
                                               
                                                    $listdata=mysqli_fetch_object($query1);
                                                    $regId=$listdata->firebase_reg_id;
                                                    
                                                    $push->setTitle($title);
                                                    $push->setMessage($message);
                                                    $push->setImage('');
                                                    $push->setIsBackground(FALSE);
                                                    $push->setPayload($payload);
                                                    
                                                    
                                                    $json = $push->getPush();
                                                    $response = $firebase->send($regId, $json);
                                                    //echo $response;
                                                    $data = json_decode($response);
                                                    $success=$data->success;
                                                    if($success == 1){ $status='success';  $count++;}else{ $status='fail'; $countf++;}
                                                    //echo "INSERT INTO `notifications`(`username`, `title`, `description`,  `created_date`, `status`, `regid`) VALUES ('$username','$title','$message','$cdate','$status','$regId')";
                                                    mysqli_query($conn,"INSERT INTO `notifications`(`username`, `title`, `description`,  `created_date`, `status`, `regid`,`send_type`) VALUES ('$value','$title','$message','$cdate','$status','$regId','$ptype')");
                                          
                                           }
                                           
                                   
                               }
                           
                        }
                        return false;
                        exit();
                       
                   }
                   
                   
        }
        
}
?>
       