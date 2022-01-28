<?php
	include 'config.php';
	date_default_timezone_set('Asia/Calcutta'); 
	$updated_on =  date('Y-m-d H:i:s');  
	$url = $_GET['page'];
	if($_GET['stop']){
		$id = $_GET['stop'];
		$status = "S";
	}
	if($_GET['live']){ 
		$id = $_GET['live'];
		$status = "L";
	}

	$query = "update player_table set table_status='{$status}',updated_on='{$updated_on}' where table_id=$id"; 
	$result = $conn->query($query); 

	$conn->close();
	header("Location:$url");

?>