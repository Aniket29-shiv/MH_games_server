<?php

$messages='';
$messagee='';


if(isset($_POST['submit'])){
    
            $username=$_POST['username'];
            $subject=$_POST['subject'];
            $msg=$_POST['message'];
            
            if($username ==''){$messagee="Please Select User"; return false; exit();}
            if($subject ==''){$messagee="Subject is required"; return false; exit();}
            if($msg ==''){$messagee="message is required"; return false; exit();}
            
            $cdate=date('Y-m-d H:i:s');
            
            if($username != ''){
                
                $getuserid=mysqli_query ($conn,"SELECT user_id FROM `users` where username='$username'");
                
                    if(mysqli_num_rows($getuserid) > 0){
                        $listuser=mysqli_fetch_object($getuserid);
                        $user_id=$listuser->user_id;
                          mysqli_query ($conn,"INSERT INTO `user_help_support`(`name`, `subject`, `message`, `status`, `created_date`, `user_id`, `lastreply`, `ticketby`) VALUES ('$username','$subject','$msg','Open','$cdate','$user_id','ADMIN',1)");
                          $lastinsertid=mysqli_insert_id($conn);
                          mysqli_query ($conn,"INSERT INTO `user_help_reply`(`ticketid`, `msg`, `msgby`, `created_date`) VALUES ('$lastinsertid','$msg',1,'$cdate')");
                          $messages='Ticket Generated Successfully';
                    }else{
                        $messagee="Username Not Found"; return false; exit();
                    }
             }
            
    
           
          
            
            

    
    
}





?>
