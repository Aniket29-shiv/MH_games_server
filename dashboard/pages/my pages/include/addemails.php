<?php

$message='';
$message1='';
$sender='';
$sendfrom='';
$host='';
$security='';
$port='';
$authentication='';
$username='';
$password='';



//if(isset($_GET['eid'])){
    
   
    $makequery="select * from `email_conf` where id = 1";
	$query=mysqli_query ($conn,$makequery);
    $listdata=mysqli_fetch_object($query);
   //SELECT `id`, `sender`, `sendfrom`, `host`, `security`, `port`, `authentication`, `username`, `password`, `updated_date` FROM `email_conf` WHERE 1
    $sender=$listdata->sender;
    $sendfrom=$listdata->sendfrom;
    $host=$listdata->host;
    $security=$listdata->security;
    $port=$listdata->port;
    $authentication=$listdata->authentication;
    $username=$listdata->username;
    $password=$listdata->password;

//}




if(isset($_POST['submit'])){
     
    $sender=$_POST['sender'];
    $sendfrom=$_POST['sendfrom'];
    $host=$_POST['host'];
    $security=$_POST['security'];
    $port=$_POST['port'];
    $authentication=$_POST['authentication'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $cdate=date('Y-m-d H:i:s');
       

   
    
    $reg=0;
    
    if($sender == ''){    $reg=1; $message="Sender Required"; return false; exit();}
    if($sendfrom == ''){  $reg=1; $message="Send From Name Required"; return false; exit();}
    if($host == ''){      $reg=1; $message="Host Required"; return false; exit();} 
    if($security == ''){  $reg=1; $message="Security Type Required"; return false; exit();}
    if($port == ''){      $reg=1; $message="Port Required"; return false; exit();}
    if($username == ''){  $reg=1; $message="Username Required"; return false; exit();}
    if($password == ''){  $reg=1; $message="Password Required"; return false; exit();}
    if($authentication == ''){ $reg=1; $message="Authentication Required"; return false; exit();}
            
       
    if($reg == 0){
    
    
        $makequery="UPDATE `email_conf` SET `sender`='$sender',`sendfrom`='$sendfrom',`host`='$host',`security`='$security',`port`='$port',`authentication`='$authentication',`username`='$username',`password`='$password',`updated_date`='$cdate' WHERE id=1";
        mysqli_query ($conn,$makequery);
        $message1="Updated Successfully"; return false; exit();
    
    
    }
							
}

if(isset($_POST['send'])){
    
            $to=$_POST['to'];
            $subject=$_POST['subject'];
            $emailmessage=$_POST['message'];
    
            
            $sendmessage='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
            <div style="background:#ffffff;padding:20px">
            <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
            <div style=" text-align:center;">
             </div>
            </div>			  
            <div>
            <p style="margin:0px 0px 10px 0px">
            <p>Dear Admin,</p>
            <p>'.$emailmessage.'</p>
            <p>Thank you,</p>
            </div>
            <div>
            </div>
            </div>
            </div>';

    sendmail($to,$subject,$sendmessage);
    
}

?>
