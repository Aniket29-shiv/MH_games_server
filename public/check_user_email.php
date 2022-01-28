<?php
include 'database.php';

if(isset($_POST['user_email']))
{$useremail = $_POST['user_email'];}

$sql = "SELECT * from users where email = '".$useremail."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo 1;
}
else {
	echo 0;
}
?>