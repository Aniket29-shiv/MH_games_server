<?php
//Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
//define('PAYTM_MERCHANT_KEY', 'QXB7!DNXmmaGqXF#'); 


//include '../../database.php';

$makequery = "SELECT * FROM `payment_gateway`  where id = 2";
$result = $conn->query($makequery);
$row = $result->fetch_assoc();
     
$mode = $row['gateway_type'];
$key = $row['gateway_key'];
$cid = $row['gateway_id'];

define('PAYTM_MERCHANT_KEY', $key); 
?>
