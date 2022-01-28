<?php

include("config.php");
session_start(); 

if(isset($_POST['btnSubmit'])){ 
	$pageData = $_POST;  
	 
	$username = $pageData['username'];
	$password = md5($pageData['password']);
	
	$query = "select * from administrator WHERE username='{$username}' AND password='{$password}'"; 
	
	$result = $conn->query($query); 
	
	if ($result->num_rows > 0) { 
		while($row = $result->fetch_assoc()) {
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['username'] = $row['username']; 
			header('location:pages/my pages/dashboard.php');
		}
	} else {
			
			header("location:index.php?status=F");
	}
$conn->close();
}


?>