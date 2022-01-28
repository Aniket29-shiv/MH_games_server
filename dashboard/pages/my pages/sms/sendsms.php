<?php


$getsmsdetail=mysqli_query($conn,"SELECT * FROM `sms_conf` WHERE id=1");
$listsmsdetail=mysqli_fetch_object($getsmsdetail);

$senderid=$listsmsdetail->senderid;
$userkey= $listsmsdetail->userkey;


define('SENDERID',$senderid);
define('SMSKEY',$userkey);
define('ROUTE','4');

function sendSms($mobile,$message) {

            $postData = array(
            'authkey' => SMSKEY,
            'mobiles' => $mobile,
            'message' => $message,
            'sender' => SENDERID,
            'route' => ROUTE
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
            
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $output = curl_exec($ch);
            
            return $output;

            curl_close($ch);
            
           
	
}




?>