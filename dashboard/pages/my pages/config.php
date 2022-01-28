<?php 
 date_default_timezone_set('Asia/Kolkata');
$servername = "localhost";
$username = "rummysah_db";
$password = "Admin@123";
$mysql_database = "rummysah_db";
$conn = new mysqli($servername, $username, $password,$mysql_database);

 if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}  

//$sql= mysqli_connect( $servername, $username, $password, $mysql_database);

 
$geturl="select baseurl from `base_url`  WHERE id=1";
$seturl=mysqli_query ($conn,$geturl);
$listurl=mysqli_fetch_object($seturl);

$mainurl= $listurl->baseurl;
$logo=$mainurl.'images/logo.png';

define('MAINLINK',$mainurl);
define('LOGO',$logo);

?>