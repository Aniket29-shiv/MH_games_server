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
    
   
    $getcf="select * from `social_login` where id = 1";
	$querycf=mysqli_query ($conn,$getcf);
    $listcf=mysqli_fetch_object($querycf);
    
    $pgname=$listcf->social_id;
    $pgid=$listcf->version;
     $pgstatus=$listcf->status;
    

   $getpm="select * from `social_login` where id = 2";
	$querypm=mysqli_query ($conn,$getpm);
    $listpm=mysqli_fetch_object($querypm);
   
    $pgname1=$listpm->social_id;
 
    $pgstatus1=$listpm->status;
//}



//==========================Cash Free  Gate Way
if(isset($_POST['facebook'])){
    
    $pgname=trim($_POST['pgname']); 
    $pgid=trim($_POST['pgid']);
    $pgstatus=$_POST['pgstatus'];
   
  

   
    
    $reg=0;
   
    //echo $makequery;
    if($pgname == ''){    $reg=1; $message="Social ID  Required"; return false; exit();}
    if($pgid == ''){  $reg=1; $message="Version Required"; return false; exit();}
 
    if($pgstatus == ''){      $reg=1; $message="Social Status Required"; return false; exit();}
    
            
       
    if($reg == 0){
    
    
         $makequery="UPDATE `social_login` SET `social_id`='$pgname',`version`='$pgid',`status`='$pgstatus' WHERE id=1";
        
        mysqli_query ($conn,$makequery);
        $message1="Updated Successfully"; return false; exit();
    
    
    }
							
}

//==========================Paytm Gate Way
if(isset($_POST['google'])){
     $pgname1=trim($_POST['pgname1']); 
  
    $pgstatus1=$_POST['pgstatus1'];
   
  

   
    
    $reg=0;
    
    if($pgname1 == ''){    $reg=1; $message2="Social ID Required"; return false; exit();}
   
    if($pgstatus1 == ''){      $reg=1; $message2="Social Status Required"; return false; exit();}
    
         
      
       
    if($reg == 0){
    
    
         $makequery="UPDATE `social_login` SET `social_id`='$pgname1',`status`='$pgstatus1' WHERE id=2";
        // echo  $makequery;
        mysqli_query ($conn,$makequery);
        $message3="Updated Successfully"; return false; exit();
    
    
    }
							
}



?>
