<?php 
date_default_timezone_set('Asia/Kolkata');
$servername = "localhost";
$user = "rummysah_db";
$dbpassword = "Admin@123";
$dbname = "rummysah_db";
$conn = new mysqli($servername, $user, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata');


$geturl="select baseurl from `base_url`  WHERE id=1";
$seturl=mysqli_query ($conn,$geturl);
$listurl=mysqli_fetch_object($seturl);

$mainurl= $listurl->baseurl;
$logo=$mainurl.'images/logo.png';
$mainurl2=$mainurl.'public/';
define('MAINLINK', $mainurl);
define('LOGO',$logo);
define('MAINLINK2',$mainurl2);

 
?>