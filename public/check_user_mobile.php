<?php
include 'database.php';

if(isset($_POST['user_mobile']))
{$user_mobile_no = $_POST['user_mobile'];}

$sql = "SELECT * from users where mobile_no = '".$user_mobile_no."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo 1;
}
else {
	echo 0;
}
?>