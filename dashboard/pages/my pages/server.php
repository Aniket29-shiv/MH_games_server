<?php
//echo $_GET['query'];
include('config.php');
	$sql = "SELECT u.username FROM user_firebase_reg_id as f left join users  as u on u.user_id=f.user_id
			WHERE u.username LIKE '%".$_GET['query']."%'
			LIMIT 20"; 
			
	$result = $conn->query($sql);
	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['username'];
	}
	echo json_encode($json);
	$conn->close();
?>
