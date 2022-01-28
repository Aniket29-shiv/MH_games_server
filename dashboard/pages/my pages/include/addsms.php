<?php

$message='';
$message1='';
$sender='';
$sendkey='';


   //=====Get Sms Data
    $makequery="select * from `sms_conf` where id = 1";
	$query=mysqli_query ($conn,$makequery);
    $listdata=mysqli_fetch_object($query);
 
    $sender=$listdata->senderid;
    $sendkey=$listdata->userkey;




if(isset($_POST['submit'])){
     
    $sender=$_POST['sender'];
    $sendkey=$_POST['sendkey'];
    
  
    $reg=0;
    
    if($sender == ''){    $reg=1; $message="Sender ID Required"; return false; exit();}
    if($sendkey == ''){  $reg=1; $message="Authentication Key Required"; return false; exit();}
  
       
    if($reg == 0){
    
    
        $makequery="UPDATE `sms_conf` SET `senderid`='$sender',`userkey`='$sendkey' WHERE id=1";
        //echo $makequery;
       // exit();
        mysqli_query ($conn,$makequery);
        $message1="Updated Successfully"; return false; exit();
    
    
    }
							
}



?>
