<?php
include 'database.php';

if(isset($_POST['user_name']))
{$username = $_POST['user_name'];}

$sql = "SELECT * from users where username = '".$username."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo 1;
}
else {
	echo 0;
}
?>
