<?PHP
class Firebase {
 
    // sending push message to single user by firebase reg id
    public function send($to, $message) {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
 
    // Sending message to a topic by topic name
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
 
    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
        );
 
        return $this->sendPushNotification($fields);
    }
 
    // function makes curl request to firebase servers
    private function sendPushNotification($fields) {
         
        require_once __DIR__ . '/config.php';
        
        $firebaseServerKey = "AAAAxU1z3PY:APA91bFptcvzpUlwvYyFYXSsPSSNe8m4f3TupGfZinZi6ZRUuaHqK4QM_YjzKHvnfVsPKkz6kgyPLC6m46IsPSfzCvgNFCzxIuiatNlA3teFx9T0jz47ecJLYOfb0mj4NJh-HR7s6nbM";
        
        // $sql1 = "SELECT * FROM firebase_server_key";
        // $result1 = $conn->query($sql1);
        //  if ($result1->num_rows > 0) 
        // {
        // 	$row = $result1->fetch_assoc();
        // 	$firebaseServerKey = $row['server_key'];
        // }
 
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
        
 
        $headers = array(
            'Authorization: key=' . $firebaseServerKey,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }
}



  $firebase = new Firebase();
        $push = new Push();
/*

function push_notification_android($device_id,$message){

    //API URL of FCM
    $url = 'https://fcm.googleapis.com/fcm/send';

    //api_key available in:
    //Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key  
    $api_key = 'AAAAxU1z3PY:APA91bFptcvzpUlwvYyFYXSsPSSNe8m4f3TupGfZinZi6ZRUuaHqK4QM_YjzKHvnfVsPKkz6kgyPLC6m46IsPSfzCvgNFCzxIuiatNlA3teFx9T0jz47ecJLYOfb0mj4NJh-HR7s6nbM';
                
    $fields = array (
        'registration_ids' => array (
                $device_id
        ),
        'data' => array (
                "message" => $message
        )
    );

    //header includes Content type and api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$api_key
    );
                
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

$device_id1="eLzB6M_ccZI:APA91bFJH-MOBrX-vEwTc6TJceOdpSaSVnGpYqXFK3hWgYMUjyXG_GqoCda5SHgSeBJTrnpCc-lun6RJ2UfaMLHxSX-TA0aAF5KcoP1QfHj7Nz3BHA0_mnIoYO8hix4cdmGL_44S63Ac";
$device_id2='f9YpIk1sq2M:APA91bGNqdgLDJ5MNFO9XpdSNkCQetyIRZbenJu7TyS9__LMW-DvwFe5TFIBN099YIgrU4Ng7t5t90pMvNlxLt2-TaAK6_4ARF8ktYGEKmJAWdXDNVdeM7_pe9C_jqY3i5Qb0ZKebTWu';
$device_id3='cHVv1UByhZg:APA91bEOOWClYeiFSI5MW4CButO_dtf5r452ajBOrSJRK9h9iBkmQuuRjPp8SFCUC9SBcwS7W51YiivZOZhwKzPmG5Qa4xjvaTM6ayjCCYdfwnrx2GuV0Xa1tqMuZKvi3FFR7oez9aTr';
$message="HI this is testing Message";


echo push_notification_android($device_id1,$message);
echo push_notification_android($device_id2,$message);
echo push_notification_android($device_id3,$message);

*/





?>