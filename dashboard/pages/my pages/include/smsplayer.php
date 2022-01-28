<?php

$message='';
$messages='';
$count=0;



if(isset($_POST['submit'])){
    
            $utype=$_POST['utype'];
            $msg=$_POST['message'];
            set_time_limit(0);
            
            if($utype ==''){$message="Please Select User"; return false; exit();}
            if($msg ==''){$message="message is required"; return false; exit();}
            
            
            $cdate=date('Y-m-d H:i:s');
            
            
            if(isset($_POST['savetemp'])){
                 $temptitle=$_POST['ttitle'];
                 if( $temptitle == ''){$message="Template Title Is Required"; return false; exit();}
                  $get=mysqli_query ($conn,"SELECT * FROM `sms-template` where title='$temptitle'");
                  if(mysqli_num_rows($get) > 0){
                     mysqli_query ($conn,"UPDATE `sms-template` SET `title`='$temptitle',`message`='$msg' where title='$temptitle'"); 
                     $messages="Template Updated Successfully"; 
                  }else{
                     mysqli_query ($conn,"INSERT INTO `sms-template`( `title`,  `message`) VALUES ('$temptitle','$msg')");
                     $messages="Template Inserted Successfully"; 
                  }
             }
            
            
             if($utype == 'indivisual'){
                 
                $username=$_POST['hidden-username'];
                $arr_username = explode (",", $username);  
                        
                foreach ($arr_username as $value){
                
                 
                 
                            $makequery="SELECT *  FROM  `users`   where username='$value'";
                           
                            $query=mysqli_query ($conn,$makequery);
                            
                                
                                
                            if(mysqli_num_rows($query) > 0){
                                
                                    $listdata=mysqli_fetch_object($query);
                                    
                                    $user_id=$listdata->user_id;
                                    $mobile_no=$listdata->mobile_no;
                                    $username1=$listdata->username;
                                     $msg= str_replace("{username}","$username1",$msg1);
                                    $fullname=$listdata->first_name.' '.$listdata->last_name;
                                    $msg= str_replace("{fullname}"," $fullname",$msg);
                                
                                    mysqli_query ($conn,"INSERT INTO `sms-to-players`( `mtype`, `userid`, `username`, `mobileno`,  `message`, `send_date`)VALUES('$utype','$user_id','$username1','$mobile_no','$msg','$cdate')");
                                    
                                    $insertid=mysqli_insert_id($conn);
                                    $response=sendSms($mobile_no,$msg) ;
                                    
                                    mysqli_query($conn,"UPDATE `sms-to-players` SET `response`='$response'  where id='$insertid'");
                                    
                                    $count++;
                            }
                            
                 } 
                                    
            }
            
            if($utype == 'active'){
                
                    if($_POST['to'] != ''){  $to=date('Y-m-d H:i:s',strtotime($_POST['to']));}else{ $to='';}
                   if($_POST['from'] != ''){ $from=date('Y-m-d H:i:s',strtotime($_POST['from']));}else{$from='';}
                   
                  
                 
                        $makequery="SELECT h.userid,u.`username` ,u.`mobile_no`,u.`user_id`,u.`first_name`,u.`last_name`
                        FROM `login_history` as h 
                        left join `users` as u on u.user_id=h.userid  where 1=1 ";
                        if($to != ''){  $makequery .=" and h.logindate <= '$to 23:59:59'";}
                          if($from != ''){  $makequery .=" and h.logindate >= '$from 23:59:59'";}
                        $makequery .=" group by h.userid";
                     
                        $query=mysqli_query ($conn,$makequery);
                    
                    while($listdata=mysqli_fetch_object($query)){
                        
                        $user_id=$listdata->user_id;
                        $mobile_no='8830314601';//$listdata->mobile_no;
                        $username=$listdata->username;
                         $msg= str_replace("{username}","$username",$msg1);
                                  $fullname=$listdata->first_name.' '.$listdata->last_name;
                                $msg= str_replace("{fullname}"," $fullname",$msg);
                        
                        mysqli_query ($conn,"INSERT INTO `sms-to-players`( `mtype`, `userid`, `username`, `mobileno`,  `message`, `send_date`)VALUES('$utype','$user_id','$username','$mobile_no','$msg','$cdate')");
                      
                        $insertid=mysqli_insert_id($conn);
                        $response=sendSms($mobile_no,$msg) ;
                        
                        mysqli_query($conn,"UPDATE `sms-to-players` SET `response`='$response'  where id='$insertid'");
                       
                          $count++;
                       
                    }
                            
            }
            
            
            if($utype == 'verified'){
                
                
                                $makequery="SELECT h.userid,u.`username` ,u.`user_id`,u.mobile_no ,u.`first_name`,u.`last_name`
                                FROM `user_kyc_details` as h 
                                left join `users` as u on u.user_id=h.userid where h.mobile_status='Verified'";
                                
                                $query=mysqli_query ($conn,$makequery);
                                
                                while($listdata=mysqli_fetch_object($query)){
                                        
                                        $user_id=$listdata->user_id;
                                        $mobile_no='8830314601';//$listdata->mobile_no;
                                        $username=$listdata->username;
                                         $msg= str_replace("{username}","$username",$msg1);
                                  $fullname=$listdata->first_name.' '.$listdata->last_name;
                                $msg= str_replace("{fullname}"," $fullname",$msg);
                                        mysqli_query ($conn,"INSERT INTO `sms-to-players`( `mtype`, `userid`, `username`, `mobileno`,  `message`, `send_date`)VALUES('$utype','$user_id','$username','$mobile_no','$msg','$cdate')");
                                            $insertid=mysqli_insert_id($conn);
                                            $response=sendSms($mobile_no,$msg) ;
                                            
                                            mysqli_query($conn,"UPDATE `sms-to-players` SET `response`='$response'  where id='$insertid'");
                                           
                                            $count++;
                                           
                                }
                
            }
            
            if($utype == 'alluser'){
                
                                $makequery="SELECT * FROM `users`";
                                
                                $query=mysqli_query ($conn,$makequery);
                                
                                while($listdata=mysqli_fetch_object($query)){
                                
                                            $user_id=$listdata->user_id;
                                            $mobile_no='8830314601';//$listdata->mobile_no;
                                            $username=$listdata->username;
                                             $msg= str_replace("{username}","$username",$msg1);
                                  $fullname=$listdata->first_name.' '.$listdata->last_name;
                                $msg= str_replace("{fullname}"," $fullname",$msg);
                                            mysqli_query ($conn,"INSERT INTO `sms-to-players`( `mtype`, `userid`, `username`, `mobileno`,  `message`, `send_date`)VALUES('$utype','$user_id','$username','$mobile_no','$msg','$cdate')");
                                                $insertid=mysqli_insert_id($conn);
                                                $response=sendSms($mobile_no,$msg) ;
                                                
                                                mysqli_query($conn,"UPDATE `sms-to-players` SET `response`='$response'  where id='$insertid'");
                                               
                                                $count++;
                                              
                           
                                }
            }
            
            
          
            
            

    
    
}





    function smstemplate($sql){
        
        $makequery="select * from `sms-template`  where `deleted`!=1";
        
        $query=mysqli_query ($sql,$makequery);
        
       while($listdata=mysqli_fetch_object($query)){
           echo '<option value="'.$listdata->id.'">'.$listdata->title.'</option>';
       }
    
    }

?>
