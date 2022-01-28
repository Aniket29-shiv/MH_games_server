<?php

$message='';

$eid='';

$title='';
$coupon='';
$from='';
$to='';
$distype='';
$disval=0;
$mprice=0;
$reusable='';

if(isset($_GET['eid'])){
     
    $eid=$_GET['eid'];
    //echo "select * from  `coupons` where `id`= '$eid' and deleted != 1";
    
    $query= mysqli_query ($conn,"select * from  `coupons` where `id`= '$eid' and deleted != 1");
    
    $listdata=mysqli_fetch_object($query);
   
    $title= $listdata->title;
    $coupon=$listdata->coupon;
    $from=date('m/d/Y',strtotime($listdata->valid_from));
    $to=date('m/d/Y',strtotime($listdata->valid_to));
    $distype=$listdata->discount_type;
    $disval=$listdata->discount_val;
    $mprice=$listdata->maxprice;
    $reusable=$listdata->reusable;
}

if(isset($_POST['btnSubmit'])){
    
    $eid=$_POST['eid'];
    $title=$_POST['title'];
    $coupon=$_POST['coupon'];
    $from=$_POST['from']; //str_replace('/', '-', $_POST['from']);
    $to= $_POST['to'];   // str_replace('/', '-', $_POST['to']);
    $distype=$_POST['distype'];
    $disval=$_POST['disval'];
    $mprice=$_POST['mprice'];
    
    if(isset($_POST['reusable'])) {$reusable=1;}else{ $reusable=0;}
    
    $cdate=date('Y-m-d H:i:s');
   
 
        //Validations All
        
        $reg=0;
        
        $checkcoupon= mysqli_query ($conn,"select id from  `coupons` where `coupon`='$coupon'" and `id`!= '$eid');
        
        if(mysqli_num_rows($checkcoupon) > 0){$reg=1;$message="Coupon Code ALerady Exists"; return false; exit();}
        
        if($title == ''){$reg=1;$message="Coupon Title Required"; return false; exit();}
        if($coupon == ''){$reg=1;$message="Coupon Required"; return false; exit();}
        if(strlen($coupon) != 8){ $reg=1;$message="* character required in Coupon Code"; return false; exit(); }
        if($from == ''){$reg=1; $message="From Date Required"; return false; exit();}else{ $from1=date('Y-m-d',strtotime($from)); }
        if($to == ''){$reg=1; $message="To Date Required"; return false; exit();}else{ $to1=date('Y-m-d',strtotime($to));}
        if($disval == ''){$reg=1; $message="discount Value  Required"; return false; exit();}
        
        if($distype == 'percent'){
            
            if($disval > 100){
               $reg=1; $message="Discount Value IS Max 100% Allowed"; return false; exit(); 
            }
            
        }else{
       
            if($disval >= $mprice){ $reg=1; $message="Max Price is Required Greter Than Discount Val"; return false; exit(); }
        }
       
        if($reg == 0){
          
             if($eid == ''){
            
                $makequery="INSERT INTO `coupons`(`title`, `coupon`, `valid_from`, `valid_to`, `discount_type`, `discount_val`, `maxprice`, `reusable`,`created_date`) VALUES ('$title','$coupon','$from1','$to1','$distype','$disval','$mprice','$reusable','$cdate')";
                //echo $makequery;
                mysqli_query ($conn,$makequery);
                
            	echo '<script>window.location.href="addcoupon.php?status=1"</script>';
             }else{
                 
                $makequery="UPDATE `coupons` SET `title`='$title',`coupon`='$coupon', `valid_from`='$from1', `valid_to`='$to1', `discount_type`= '$distype', `discount_type`= '$distype', `discount_val`= '$disval', `maxprice`= '$mprice', `reusable`= '$reusable', `updated_date`= '$cdate' where id='$eid'";
               	//echo $makequery;
               	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="addcoupon.php?status=2"</script>';
             
             }
        }
      
							
}






?>
