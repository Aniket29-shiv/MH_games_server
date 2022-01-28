<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");


//=================template EMAIL======================================

if(isset($_GET['template'])){
    
	$sql = "SELECT title FROM `email-template` 
			WHERE title LIKE '%".$_GET['template']."%'
			 and deleted != 1 LIMIT 10"; 


	$result = $conn->query($sql);


	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['title'];
	}


	echo json_encode($json);
}

//=================Template SMS======================================

if(isset($_GET['smstemplate'])){
    
	$sql = "SELECT title FROM `sms-template` WHERE title LIKE '%".$_GET['smstemplate']."%' and deleted != 1 	LIMIT 10"; 


	$result = $conn->query($sql);


	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['title'];
	}


	echo json_encode($json);
}

//=================Username==========================================
if(isset($_GET['query'])){
	$sql = "SELECT username FROM users 
			WHERE username LIKE '%".$_GET['query']."%'
			LIMIT 10"; 


	$result = $conn->query($sql);


	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['username'];
	}


	echo json_encode($json);
}
?>