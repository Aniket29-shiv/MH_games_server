<?php
 
/**
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
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
?>