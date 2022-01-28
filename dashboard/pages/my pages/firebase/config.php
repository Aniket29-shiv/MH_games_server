<?php

// define('FIREBASE_API_KEY', 'AAAAA1GLonA:APA91bEjeh-TZzVQRjd-h9HEbO0kgCCOrEkVHNJDqkfXS0iT7jUjw9N9sGRzFblZZu8qcJ0byPSOUJK35Ply1_UNb-jV3aazdCB-EG6VXd4XVRoLK32L-_prYsSfNzHhTM8Bl-liTLKl');

$servername = "localhost";
$user_name = "rummysah_sahara";
$password = "Admin@123";
$dbname = "rummysah_sahara";
$myObj = new \stdClass();

define('FIREBASE_API_KEY', 'AAAAxU1z3PY:APA91bFptcvzpUlwvYyFYXSsPSSNe8m4f3TupGfZinZi6ZRUuaHqK4QM_YjzKHvnfVsPKkz6kgyPLC6m46IsPSfzCvgNFCzxIuiatNlA3teFx9T0jz47ecJLYOfb0mj4NJh-HR7s6nbM');


$conn = new mysqli($servername, $user_name, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>