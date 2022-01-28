<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include 'database.php';
/*

- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.

*/


//define('PAYTM_ENVIRONMENT', 'PROD'); // PROD
//define('PAYTM_MERCHANT_KEY', 'oZveSbX0KE&y@IpV'); //Change this constant's value with Merchant key downloaded from portal
//define('PAYTM_MERCHANT_MID', 'rummyc63042182356226'); //Change this constant's value with MID (Merchant ID) received from Paytm
//define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm

     //  $makequery = "SELECT * FROM `payment_gateway`  where id = 2";
	// $query = mysqli_query($sql,$makequery);
   // $listdata=mysqli_fetch_object($query);
	 
	 $makequery = "SELECT * FROM `payment_gateway`  where id = 2";
     $result = $conn->query($makequery);
     $row = $result->fetch_assoc();
     
     $mode = $row['gateway_type'];
     $key = $row['gateway_key'];
     $cid = $row['gateway_id'];
     
	 // $mode=$listdata->gateway_type;
	// $key=$listdata->gateway_key;
   // $cid=$listdata->gateway_id;
	 
	 //echo  $mode.'==='.$key.'===='.$cid;
	

define('PAYTM_ENVIRONMENT', $mode); // PROD/TEST
define('PAYTM_MERCHANT_KEY', $key); //Change this constant's value with Merchant key downloaded from portal
define('PAYTM_MERCHANT_MID', $cid); //Change this constant's value with MID (Merchant ID) received from Paytm
define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm WEBSTAGING/WEBPROD
//define('PAYTM_ENVIRONMENT', 'TEST'); // PROD/TEST
//define('PAYTM_MERCHANT_KEY', 'QXB7!DNXmmaGqXF#'); //Change this constant's value with Merchant key downloaded from portal
//define('PAYTM_MERCHANT_MID', 'XYSgIO85997661938432');
$PAYTM_DOMAIN = "pguat.paytm.com";

 if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_DOMAIN = 'secure.paytm.in';
} 

/*define('PAYTM_REFUND_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/REFUND');
define('PAYTM_STATUS_QUERY_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/TXNSTATUS');
define('PAYTM_TXN_URL', 'https://'.$PAYTM_DOMAIN.'/oltp-web/processTransaction');*/

define('PAYTM_REFUND_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/REFUND');
define('PAYTM_STATUS_QUERY_URL', 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus');
define('PAYTM_TXN_URL', 'https://securegw-stage.paytm.in/theia/processTransaction');


?>
