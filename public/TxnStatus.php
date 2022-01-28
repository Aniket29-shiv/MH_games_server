<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$ORDER_ID = "";
$requestParamList = array();
$responseParamList = array();

$requestParamList = array("MID" => 'Mbhite85373473272753' , "ORDERID" => "ORDS30362687");  

$checkSum = getChecksumFromArray($requestParamList,'oZveSbX0KE&y@IpV');
$requestParamList['CHECKSUMHASH'] = urlencode($checkSum);

$data_string = "JsonData=".json_encode($requestParamList);
echo $data_string;


$ch = curl_init();                    // initiate curl
$url = "https://securegw-stage.paytm.in/merchant-status/getTxnStatus?"; // where you want to post data  pg+ testing
//$url = "https://pguat.paytm.com/oltp/HANDLER_INTERNAL/getTxnStatus";

//$url = "https://secure.paytm.in/oltp/HANDLER_INTERNAL/getTxnStatus?"; // where you want to post data PG live
//$url = "https://securegw.paytm.in/merchant-status/getTxnStatus";      //   pg+ live
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec($ch); // execute
$info = curl_getinfo($ch);

echo "kkk".$output;
$data = json_decode($output, true);
echo "<pre>";
print_r($data);
echo "</pre>";

?>