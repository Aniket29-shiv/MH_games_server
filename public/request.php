<!DOCTYPE html>
<html>
<head>
  <title>Cashfree - Signature Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body onload="document.frm1.submit()">


<?php 

/*
 PROD key!!
 $secretKey = "934d6feec2c78ed40c4dc0e050cc0b69b762b1da";
 $appId= '504298071550650236db92512405';
 
 TEST key!!
 $secretKey = "e4139ec6e2e5fcfe071c61576e4b2c70cc311354";
 $appId= '229067560cd00fdcb4fb24bb0922';
 */
 
include 'database.php';




$config = "SELECT * FROM `payment_gateway`  where id = 1";
$resultget = $conn->query($config);
$rowget = $resultget->fetch_assoc();
$mode = $rowget['gateway_type'];
///$secretKey = "c32f7335bb4cda705bff338892a514aeb19154ee";
// $appId= '11862c4d0f172db7bbac0258926811';
$secretKey = $rowget['gateway_key'];
$appId = $rowget['gateway_id'];//"PROD"; //<------------ Change to TEST for test server, PROD for production

//echo '<script>alert("'.$mode.'==='.$keypg.'=='.$march_id.'")</script>';

extract($_POST);
$reg=0;
$maxprice ='';
$discount_type = '';
$discount_val = '';
$maxprice = '';
$reusable = '';
 
 
    if($couponcode != ''){
    
                  //echo '<script>alert("'.$loginuser.'");</script>'; 
                  $todaydate=date('Y-m-d');
                $sql = "SELECT *  FROM `coupons`  where `coupon` = '".$couponcode."' and deleted != 1 and `valid_from` <='".$todaydate."' and `valid_to` >='".$todaydate."' ";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    
                   
                        $row = $result->fetch_assoc();
                        $reusable = $row['reusable'];
                        $maxprice = $row['maxprice'];
                        $discount_type = $row['discount_type'];
                        $discount_val = $row['discount_val'];
                        $reusable = $row['reusable'];
                       
                       
                        
                           if($reusable != 1){
                            
                                 $sql1 = "SELECT id FROM `coupon_used_by_player` WHERE  `couponcode` = '".$couponcode."' and `user_id`='".$loginuser."' and `status` ='SUCCESS'";
                                 $result1 = $conn->query($sql1);
                        
                                if ($result1->num_rows > 0) {
                                     
                                     $reg=1;
                                     echo '<script>window.location.href="buy-chips.php?e=2"</script>'; 
                                     
                                }
                        
                          }
                    	
                  
                }else{
                    $reg=1;
                    echo '<script>window.location.href="buy-chips.php?e=1"</script>';
                }
    }
    


if($reg == 0){
    
     if($couponcode != ''){  
       
         if($discount_type == 'percent'){
             $bonus=$orderAmount*($discount_val/100);
         }else{
            $bonus=$discount_val;
         }
         
         if($bonus >= $maxprice){$finalbonus=$maxprice;}else{$finalbonus=$bonus;}
         
        $cdate=date('Y-m-d H:i:s');
       
        $sqlcoupon= "INSERT INTO `coupon_used_by_player`(`user_id`, `amount`, `created_date`, `chip_type`, `order_id`, `status`, `couponcode`, `discount_type`, `discount_val`, `maxprice`, `bonus`, `reusable`)VALUES ('".$loginuser."','".$orderAmount."','".$cdate."','Real','".$orderId."','Pending','".$couponcode."','".$discount_type."','".$discount_val."','".$maxprice."','".$finalbonus."','".$reusable."')";
       
        $conn->query($sqlcoupon);
     }

         //$secretKey = "c32f7335bb4cda705bff338892a514aeb19154ee";
         //$appId= '11862c4d0f172db7bbac0258926811';
          $postData = array( 
          "appId" => $appId, 
          "orderId" => $orderId, 
          "orderAmount" => $orderAmount, 
          "orderCurrency" => $orderCurrency, 
          "orderNote" => $orderNote, 
          "customerName" => $customerName, 
          "customerPhone" => $customerPhone, 
          "customerEmail" => $customerEmail,
          "returnUrl" => $returnUrl, 
          "notifyUrl" => $notifyUrl,
        );
        
        ksort($postData);
        $signatureData = "";
        foreach ($postData as $key => $value){
            $signatureData .= $key.$value;
        }
        $signature = hash_hmac('sha256', $signatureData, $secretKey,true);
        $signature = base64_encode($signature);
        
        if ($mode == "PROD") {
          $url = "https://www.cashfree.com/checkout/post/submit";
        } else {
          $url = "https://test.cashfree.com/billpay/checkout/post/submit";
        }
}

?>
  <form action="<?php echo $url; ?>" name="frm1" method="post">
      <p>Please wait.......</p>
      <input type="hidden" name="signature" value='<?php echo $signature; ?>'/>
      <input type="hidden" name="orderNote" value='<?php echo $orderNote; ?>'/>
      <input type="hidden" name="orderCurrency" value='<?php echo $orderCurrency; ?>'/>
      <input type="hidden" name="customerName" value='<?php echo $customerName; ?>'/>
      <input type="hidden" name="customerEmail" value='<?php echo $customerEmail; ?>'/>
      <input type="hidden" name="customerPhone" value='<?php echo $customerPhone; ?>'/>
      <input type="hidden" name="orderAmount" value='<?php echo $orderAmount; ?>'/>
      <input type ="hidden" name="notifyUrl" value='<?php echo $notifyUrl; ?>'/>
      <input type ="hidden" name="returnUrl" value='<?php echo $returnUrl; ?>'/>
      <input type="hidden" name="appId" value='<?php echo $appId; ?>'/>
      <input type="hidden" name="orderId" value='<?php echo $orderId; ?>'/>
     
  </form>
</body>
</html>
