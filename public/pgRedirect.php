<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires:0");
//following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
//include 'database.php';
$checkSum = "";
$paramList = array();

$ORDER_ID = $_POST["ORDER_ID"];
$CUST_ID = $_POST["CUST_ID"];
$INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
$CHANNEL_ID = $_POST["CHANNEL_ID"];
$TXN_AMOUNT = $_POST["TXN_AMOUNT"];
$Mobile_No = $_POST["Mobile_No"];
$EMAIL = $_POST["EMAIL"];
$couponcode = $_POST["couponcode"];
$loginuser = $_POST["loginuser"];


$reg=0;
$maxprice ='';
$discount_type = '';
$discount_val = '';
$maxprice = '';
$reusable = '';

if($couponcode != ''){
    
        $todaydate=date('Y-m-d');
        $sql = "SELECT *  FROM `coupons`  where `coupon` = '".$couponcode."' and deleted != 1 and `valid_from` <='".$todaydate."' and `valid_to` >='".$todaydate."'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            
           
            $row = $result->fetch_assoc();
            $reusable = $row['reusable'];
            $maxprice = $row['maxprice'];
            $discount_type = $row['discount_type'];
            $discount_val = $row['discount_val'];
            $maxprice = $row['maxprice'];
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







// var_dump($_POST);
// Create an array having all required parameters for creating checksum.
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;

$paramListCHK["MID"] = PAYTM_MERCHANT_MID;
$paramListCHK["ORDER_ID"] = $ORDER_ID;

$paramList["CUST_ID"] =$CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = $CHANNEL_ID;
$paramList["TXN_AMOUNT"] =$TXN_AMOUNT;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
$paramList["CALLBACK_URL"] = $mainurl."public/pgResponse.php";

$paramList["MSISDN"] =$Mobile_No; //Mobile number of customer
$paramList["EMAIL"] =$EMAIL; //Email ID of customer
$paramList["VERIFIED_BY"] = "EMAIL"; //
$paramList["IS_USER_VERIFIED"] = "YES"; //
/*echo '<script>alert("'.PAYTM_MERCHANT_MID.'==='.PAYTM_MERCHANT_KEY.'=='.PAYTM_ENVIRONMENT.'")</script>';*/

//$paramList["MSISDN"] = '8087734443'; //Mobile number of customer
//$paramList["EMAIL"] = 'mahadev@mbhitech.com'; //Email ID of customer
//$paramList["VERIFIED_BY"] = "EMAIL"; //
//$paramList["IS_USER_VERIFIED"] = "YES"; //



// var_dump($paramList);
/*
$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
$paramList["EMAIL"] = $EMAIL; //Email ID of customer
$paramList["VERIFIED_BY"] = "EMAIL"; //
$paramList["IS_USER_VERIFIED"] = "YES"; //


https://pguat.paytm.com/oltp/HANDLER_INTERNAL/getTxnStatus?JsonData=%7b%22MID%22:%22klbGlV59135347348753%22,%22ORDERID%22:%22ORDER488868099111%22,%22CHECKSUMHASH%22:%22wctrePBbNfJkGyNXRg8sHBTJZWGJEFMBuUtO3qoFkL2ox8HIe9YSzTU%2FpswpDbtAhS%2bkWiHgr5nmu9z9cn8rbzGsV0qy8D16c2negimoD%2Fs%3D%22%7d
*/

// die;
//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

if($reg == 0){
    
      if($couponcode != ''){  
       
         if($discount_type == 'percent'){
             $bonus=$TXN_AMOUNT*($discount_val/100);
         }else{
            $bonus=$discount_val;
         }
          if($bonus >= $maxprice){$finalbonus=$maxprice;}else{$finalbonus=$bonus;}
        $cdate=date('Y-m-d H:i:s');
       
        $sqlcoupon= "INSERT INTO `coupon_used_by_player`(`user_id`, `amount`, `created_date`, `chip_type`, `order_id`, `status`, `couponcode`, `discount_type`, `discount_val`, `maxprice`, `bonus`, `reusable`, `addfrom`)VALUES ('".$loginuser."','".$TXN_AMOUNT."','".$cdate."','Real','".$ORDER_ID."','Pending','".$couponcode."','".$discount_type."','".$discount_val."','".$maxprice."','".$finalbonus."','".$reusable."',1)";
      // echo $sqlcoupon;
        $conn->query($sqlcoupon);
     }
    
}
?>
<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
	<?php
	
	  if($reg == 0){
	    
	?>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			    
			<?php
			
		    	foreach($paramList as $name => $value) {
		    	    
			    	echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
				
		    	}
			?>
			
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
	<?php } ?>
</body>
</html>