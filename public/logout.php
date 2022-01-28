<?php
session_start();
include 'database.php';
$_SESSION["email"]=" ";
$cdate=date('Y-m-d H:i:s');
$loginid=$_SESSION["loginid"];

	$Update_sql=mysqli_query($conn,"UPDATE `login_history` SET `status`='logout',`logouttime`='$cdate'  where id={$_SESSION['loginid']}");
//$_SESSION['logged_user']= " ";
unset($_SESSION["logged_user"]);
session_unset();

session_destroy(); 
//header("Location:index.php");




header("Location:../index.php");


?>