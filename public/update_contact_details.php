<?php
/* $servername = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "rummystore";
$conn = new mysqli($servername, $user, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 */
 include 'database.php';
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$addr = "";
if($address2!='')
{ $addr = $address1.','.$address2;}
else { $addr = $address1;}

$state = $_POST['state'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$usernm = $_POST['usernm'];
$updated_date = date('Y/m/d h:m:s');

$sql = "update users set address= '".$addr."',state= '".$state."',city= '".$city."',pincode= '".$pincode."',`updated_date` = '".$updated_date."' where username = '".$usernm."'";
$result = $conn->query($sql);

if ($result === true) {
//echo '<script type="text/javascript">alert("Information updated...!");</script>';
//header("Location:my-profile.php?profile_updated=true");
echo true;
}
else {
echo false;

/* echo "<script>";
echo "alert('Information not updated,Please,try again...!');";
echo "</script>";
header("Location:my-profile.php"); */
}
$conn->close();

?>