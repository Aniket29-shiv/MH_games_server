<?php
include 'database.php';

if(isset($_POST['amount']))
{$amount = $_POST['amount'];}

if(isset($_POST['table_id']))
{$table_id = $_POST['table_id'];}


$sql = "SELECT * FROM `player_table`  where `table_id` = "+table_id;
$sql = "SELECT * FROM `accounts` where `username`='"+uname+"'"
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo 1;
}
else {
	echo 0;
}
?>