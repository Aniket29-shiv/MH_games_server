<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included

function pkcs5_unpad_e($text) {
	$pad = ord($text{strlen($text) - 1});
	if ($pad > strlen($text))
		return false;
	return substr($text, 0, -1 * $pad);
}
function pkcs5_pad_e($text, $blocksize) {
	$pad = $blocksize - (strlen($text) % $blocksize);
	return $text . str_repeat(chr($pad), $pad);
}
function encrypt_e($input, $ky) {
	$key = $ky;
	$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
	$input = pkcs5_pad_e($input, $size);
	$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
	$iv = "@@@@&&&&####$$$$";
	mcrypt_generic_init($td, $key, $iv);
	$data = mcrypt_generic($td, $input);
	mcrypt_generic_deinit($td);
	mcrypt_module_close($td);
	$data = base64_encode($data);
	return $data;
}
function getChecksumFromArray($arrayList, $key, $sort=1) {
	if ($sort != 0) {
		ksort($arrayList);
	}
	$str = getArray2Str($arrayList);
	$salt = generateSalt_e(4);
	$finalString = $str . "|" . $salt;
	$hash = hash("sha256", $finalString);
	$hashString = $hash . $salt;
	$checksum = encrypt_e($hashString, $key);
	return $checksum;
}
function getArray2Str($arrayList) {
	$paramStr = "";
	$flag = 1;
	foreach ($arrayList as $key => $value) {
		if ($flag) {
			$paramStr .= checkString_e($value);
			$flag = 0;
		} else {
			$paramStr .= "|" . checkString_e($value);
		}
	}
	return $paramStr;
}
//Gaurav check
function generateSalt_e($length) {
	$random = "";
	srand((double) microtime() * 1000000);

	$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
	$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
	$data .= "0FGH45OP89";

	for ($i = 0; $i < $length; $i++) {
		$random .= substr($data, (rand() % (strlen($data))), 1);
	}

	return $random;
}
function checkString_e($value) {
	$myvalue = ltrim($value);
	$myvalue = rtrim($myvalue);
	if ($myvalue == 'null')
		$myvalue = '';
	return $myvalue;
}


//test code

$checkSum = "";

$paramList = array();
$paramList["MID"] = 'Mbhite85373473272753';
$paramList["ORDERID"] = 'ORDS28731163';
//$paramList["ORDERID"] = 'ORDS10062772';

//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList,"4xcYozNexJ@alj9j");
 $check=urlencode($checkSum);  
 $paramList["CHECKSUMHASH"]=$check;
$data_string = json_encode($paramList); 
 
$ch = curl_init();                    // initiate curl
$url = "https://pguat.paytm.com/oltp/HANDLER_INTERNAL/getTxnStatus?JsonData=".$data_string; // where you want to post data

$headers = array('Content-Type:application/json');

$ch = curl_init();  // initiate curl
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec ($ch); // execute
$info = curl_getinfo($ch);
print_r($info)."<br />";






echo $output;
?>
