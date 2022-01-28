<?php 
	/*
	*   CHECK USER IS LOGGED IN
	*/
	session_start(); 
	$user_check = $_SESSION['user_id'];  
	if(!$user_check){ 
		header("Location: index.php");
		
	}


?>