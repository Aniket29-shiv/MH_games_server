<?php
include 'database.php';

$old_pwd = $_POST['old_pwd'];
$new_pwd = $_POST['new_pwd'];
$usernm = $_POST['usernm'];
$updated_date = date('Y/m/d h:m:s');

if($old_pwd!=$new_pwd)
{
	$sql = "update users set password= '".md5($new_pwd)."',`updated_date` = '".$updated_date."' where username = '".$usernm."'";
	$result = $conn->query($sql);

	if ($result === true) {
	echo true;
	/* echo '<script type="text/javascript">alert("Password changed Successfully...!");</script>';
	header("Location:my-profile.php"); */
	}
	else {
	echo false;
	/* echo "<script>";
	echo "alert('Password updation failed,Please,try again...!');";
	echo "</script>";
	header("Location:my-profile.php?password_updated=true"); */
	}
}
else
{
	/* echo "<script>";
	echo "alert('Please, Check new and old password should not be same...!');";
	echo "</script>";
	header("Location:my-profile.php"); */
}
$conn->close();

?>