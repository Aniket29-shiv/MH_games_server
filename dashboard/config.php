<?php 
 
$servername = "localhost";
$username = "rummysah_db";
$password = "Admin@123";
$mysql_database = "rummysah_db";
$conn = new mysqli($servername, $username, $password,$mysql_database);

 if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}  

?>