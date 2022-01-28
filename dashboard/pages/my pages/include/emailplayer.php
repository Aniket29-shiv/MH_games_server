<?php

$message='';
$messages='';
$count=0;

if(isset($_POST['submit'])){
    
            $utype=$_POST['utype'];
            $subject=$_POST['subject'];
            $msg1=$_POST['message'];
            $cdate=date('Y-m-d H:i:s');
            
            set_time_limit(0);
            if($utype ==''){$message="Please Select User"; return false; exit();}
            if($subject ==''){$message="Subject is required"; return false; exit();}
            if($msg1 ==''){$message="message is required"; return false; exit();}
            
             if(isset($_POST['savetemp'])){
                 $temptitle=$_POST['ttitle'];
                 if( $temptitle == ''){$message="Template Title Is Required"; return false; exit();}
                  $get=mysqli_query ($conn,"SELECT * FROM `email-template` where title='$temptitle'");
                  if(mysqli_num_rows($get) > 0){
                     mysqli_query ($conn,"UPDATE `email-template` SET `subject`='$subject',`emessage`='$msg' where title='$temptitle'"); 
                     $messages="Template Updated Successfully"; 
                  }else{
                     mysqli_query ($conn,"INSERT INTO `email-template`( `title`, `subject`, `emessage`, `created_date`) VALUES ('$temptitle','$subject','$msg','$cdate')");
                     $messages="Template Inserted Successfully"; 
                  }
             }
            
           
            
            //================================================Indivisual===============================================================
             if($utype == 'indivisual'){
                 
                $username=$_POST['hidden-username'];
                $arr_username = explode (",", $username);  
                        
                foreach ($arr_username as $value){
                
                 
                 
                                $makequery="SELECT *  FROM  `users`   where username='$value'";
                               
                                $query=mysqli_query ($conn,$makequery);
                            if(mysqli_num_rows($query) > 0){
                                
                                $listdata=mysqli_fetch_object($query);
                                
                                $user_id=$listdata->user_id;
                                 
                                $email=$listdata->email;
                                $username1=$listdata->username;
                                $msg= str_replace("{username}","$username1",$msg1);
                                $fullname=$listdata->first_name.' '.$listdata->last_name;
                                $msg= str_replace("{fullname}"," $fullname",$msg);
                                
                                mysqli_query ($conn,"INSERT INTO `email-to-players`( `mtype`, `userid`, `username`, `email`, `subject`, `message`, `send_date`)VALUES('$utype','$user_id','$username1','$email','$subject','$msg','$cdate')");
                                
                                //======mail
                                $sendmessage='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
                                <div style="background:#ffffff;padding:20px">
                                <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
                                <div style=" text-align:center;">
                                <a href="'.MAINLINK.'">
                                <img src="'.LOGO.'" style="width:150px;" />
                                </a>
                                </div>
                                </div>			  
                                <div>'.$msg.' </div>
                                <div>
                                </div>
                                </div>
                                </div>';
                                
                                
                                bulkMail($email,$subject,$sendmessage);
                                $count++;
                            }
                            
                 } 
                                    
            }
            
             //================================================Active USer===============================================================
            if($utype == 'active'){
                
                    $to=date('Y-m-d H:i:s',strtotime($_POST['to']));
                    $from=date('Y-m-d H:i:s',strtotime($_POST['from']));
                    //SELECT userid FROM `login_history` group by userid
                 
                        $makequery="SELECT h.userid,u.`username` ,u.`email`,u.`user_id`,u.`first_name`,u.`last_name`
                        FROM `login_history` as h 
                        left join `users` as u on u.user_id=h.userid  where 1=1";
                        if($to != ''){  $makequery .=" and h.logindate <= '$to 23:59:59'";}
                          if($from != ''){  $makequery .=" and h.logindate >= '$from 23:59:59'";}
                        $makequery .=" group by h.userid";
                      // echo $makequery;
                        $query=mysqli_query ($conn,$makequery);
                    
                    while($listdata=mysqli_fetch_object($query)){
                        
                        $user_id=$listdata->user_id;
                        $email=$listdata->email;
                        $username=$listdata->username;
                          $msg= str_replace("{username}","$username1",$msg1);
                           $fullname=$listdata->first_name.' '.$listdata->last_name;
                                $msg= str_replace("{fullname}"," $fullname",$msg);
                        mysqli_query ($conn,"INSERT INTO `email-to-players`( `mtype`, `userid`, `username`, `email`, `subject`, `message`, `send_date`)VALUES('$utype','$user_id','$username','$email','$subject','$msg','$cdate')");
                        
                        //======mail
                        $sendmessage='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
                        <div style="background:#ffffff;padding:20px">
                        <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
                        <div style=" text-align:center;">
                        <a href="'.MAINLINK.'">
                        <img src="'.LOGO.'" style="width:150px;" />
                        </a>
                        </div>
                        </div>			  
                        <div>'.$msg.' </div>
                        <div>
                        </div>
                        </div>
                        </div>';
                        
                        
                        bulkMail($email,$subject,$sendmessage);
                        $count++;
                    }
                            
            }
            
              //================================================Verified USer===============================================================
            if($utype == 'verified'){
                
                
                                $makequery="SELECT h.userid,h.email,u.`username` ,u.`user_id`,u.`first_name`,u.`last_name`
                                FROM `user_kyc_details` as h 
                                left join `users` as u on u.user_id=h.userid where h.email_status='Verified'";
                                
                                $query=mysqli_query ($conn,$makequery);
                                
                                while($listdata=mysqli_fetch_object($query)){
                                
                                $user_id=$listdata->user_id;
                                $email=$listdata->email;
                                $username=$listdata->username;
                                  $msg= str_replace("{username}","$username1",$msg1);
                                   $fullname=$listdata->first_name.' '.$listdata->last_name;
                                $msg= str_replace("{fullname}"," $fullname",$msg);
                                mysqli_query ($conn,"INSERT INTO `email-to-players`( `mtype`, `userid`, `username`, `email`, `subject`, `message`, `send_date`)VALUES('$utype','$user_id','$username','$email','$subject','$msg','$cdate')");
                                
                                //======mail
                                $sendmessage='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
                                <div style="background:#ffffff;padding:20px">
                                <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
                                <div style=" text-align:center;">
                                <a href="'.MAINLINK.'">
                                <img src="'.LOGO.'" style="width:150px;" />
                                </a>
                                </div>
                                </div>			  
                                <div>'.$msg.' </div>
                                <div>
                                </div>
                                </div>
                                </div>';
                                
                                
                                bulkMail($email,$subject,$sendmessage);
                                $count++;
                                }
                
            }
            
            
              //================================================All USer===============================================================
            if($utype == 'alluser'){
                  $to=date('Y-m-d H:i:s',strtotime($_POST['to']));
                    $from=date('Y-m-d H:i:s',strtotime($_POST['from']));
                                $makequery="SELECT * FROM `users` where 1=1";
                                if($to != ''){  $makequery .=" and created_date <= '$to 23:59:59'";}
                          if($from != ''){  $makequery .=" and created_date >= '$from 23:59:59'";}
                     
                               
                                $query=mysqli_query ($conn,$makequery);
                                
                                while($listdata=mysqli_fetch_object($query)){
                                
                                $user_id=$listdata->user_id;
                                $email=$listdata->email;
                                $username=$listdata->username;
                                 $msg= str_replace("{username}","$username1",$msg1);
                                  $fullname=$listdata->first_name.' '.$listdata->last_name;
                                $msg= str_replace("{fullname}"," $fullname",$msg);
                                mysqli_query ($conn,"INSERT INTO `email-to-players`( `mtype`, `userid`, `username`, `email`, `subject`, `message`, `send_date`)VALUES('$utype','$user_id','$username','$email','$subject','$msg','$cdate')");
                                
                                //======mail
                                $sendmessage='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
                                <div style="background:#ffffff;padding:20px">
                                <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
                                <div style=" text-align:center;">
                                <a href="'.MAINLINK.'">
                                <img src="'.LOGO.'" style="width:150px;" />
                                </a>
                                </div>
                                </div>			  
                                <div>'.$msg.' </div>
                                <div>
                                </div>
                                </div>
                                </div>';
                                
                                
                                bulkMail($email,$subject,$sendmessage);
                                $count++;
                               //echo '<script>alert('.$count.');</script>';
                               //echo "<script>$('#cnout').val('.$count.');</script>";
                                }
            }
            
            
             
            
            
            

    
    
}





    function emailtemplate($sql){
        
        $makequery="select * from `email-template`  where `deleted`!=1";
        
        $query=mysqli_query ($sql,$makequery);
        
       while($listdata=mysqli_fetch_object($query)){
           echo '<option value="'.$listdata->id.'">'.$listdata->title.'</option>';
       }
    
    }

?>
