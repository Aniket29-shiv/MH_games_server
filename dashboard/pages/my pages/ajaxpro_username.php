<?php

include("config.php");

	$sql = "SELECT username FROM users 
			WHERE username LIKE '%".$_GET['query']."%'
			LIMIT 10"; 


	$result = $conn->query($sql);


	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['username'];
	}


	echo json_encode($json);
?>