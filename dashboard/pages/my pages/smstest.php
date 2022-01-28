<?php

//Your authentication key
$authKey = "244710AnsQdHELOEK5bd2e037";

//Multiple mobiles numbers separated by comma
$mobileNumber = "8830314601";

//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "MBRUMY";

//Your message to send, Add URL encoding here.
$message = urlencode("HI How Are You Madam");

//Define route
$route = "4";
//Prepare you post parameters
$postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);

//API URL
$url="http://api.msg91.com/api/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));


//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

  echo $output;


curl_close($ch);


?>
