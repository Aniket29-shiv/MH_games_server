<?php

$message='';
$message1='';
$message2='';
$message3='';
$pgname=''; 
$pgid=''; 
$pgkey=''; 
$pgtype=''; 
$pgstatus=''; 
$pgname1=''; 
$pgid1=''; 
$pgkey1=''; 
$pgtype1=''; 
$pgstatus1=''; 



//if(isset($_GET['eid'])){
    
   
    $getcf="select * from `payment_gateway` where id = 1";
	$querycf=mysqli_query ($conn,$getcf);
    $listcf=mysqli_fetch_object($querycf);
    
    $pgname=$listcf->pgname;
    $pgid=$listcf->gateway_id;
    $pgkey=$listcf->gateway_key;
    $pgtype=$listcf->gateway_type; 
    $pgstatus=$listcf->status;
    

   $getpm="select * from `payment_gateway` where id = 2";
	$querypm=mysqli_query ($conn,$getpm);
    $listpm=mysqli_fetch_object($querypm);
   
    $pgname1=$listpm->pgname;
    $pgid1=$listpm->gateway_id;
    $pgkey1=$listpm->gateway_key;
    $pgtype1=$listpm->gateway_type; 
    $pgstatus1=$listpm->status;
//}



//==========================Cash Free  Gate Way
if(isset($_POST['cashfree'])){
    
    $pgname=$_POST['pgname']; 
    $pgid=$_POST['pgid'];
    $pgkey=$_POST['pgkey'];
    $pgtype=$_POST['pgtype'];
    $pgstatus=$_POST['pgstatus'];
   
  

   
    
    $reg=0;
   
    //echo $makequery;
    if($pgname == ''){    $reg=1; $message="Payment Gateway Name Required"; return false; exit();}
    if($pgid == ''){  $reg=1; $message="Payment Gateway ID Required"; return false; exit();}
    if($pgkey == ''){      $reg=1; $message="Payment Gateway Key Required"; return false; exit();} 
    if($pgtype == ''){  $reg=1; $message="Payment Gateway Type Required"; return false; exit();}
    if($pgstatus == ''){      $reg=1; $message="Payment Gateway Status Required"; return false; exit();}
    
            
       
    if($reg == 0){
    
    
         $makequery="UPDATE `payment_gateway` SET `pgname`='$pgname',`gateway_id`='$pgid',`gateway_key`='$pgkey',`gateway_type`='$pgtype',`status`='$pgstatus' WHERE id=1";
         //echo $makequery;
        mysqli_query ($conn,$makequery);
        $message1="Updated Successfully"; return false; exit();
    
    
    }
							
}

//==========================Paytm Gate Way
if(isset($_POST['Paytm'])){
     $pgname1=$_POST['pgname1']; 
    $pgid1=$_POST['pgid1'];
    $pgkey1=$_POST['pgkey1'];
    $pgtype1=$_POST['pgtype1'];
    $pgstatus1=$_POST['pgstatus1'];
   
  

   
    
    $reg=0;
    
    if($pgname1 == ''){    $reg=1; $message2="Payment Gateway Name Required"; return false; exit();}
    if($pgid1 == ''){  $reg=1; $message2="Payment Gateway ID Required"; return false; exit();}
    if($pgkey1 == ''){      $reg=1; $message2="Payment Gateway Key Required"; return false; exit();} 
    if($pgtype1 == ''){  $reg=1; $message2="Payment Gateway Type Required"; return false; exit();}
    if($pgstatus1 == ''){      $reg=1; $message2="Payment Gateway Status Required"; return false; exit();}
    
            
       
    if($reg == 0){
    
    
         $makequery="UPDATE `payment_gateway` SET `pgname`='$pgname1',`gateway_id`='$pgid1',`gateway_key`='$pgkey1',`gateway_type`='$pgtype1',`status`='$pgstatus1' WHERE id=2";
        // echo  $makequery;
        mysqli_query ($conn,$makequery);
        $message3="Updated Successfully"; return false; exit();
    
    
    }
							
}



?>
