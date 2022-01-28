<?php 
	/*
	*   CHECK USER IS LOGGED IN
	*/
	session_start(); 
	date_default_timezone_set('Asia/Calcutta'); 
	$user_check = $_SESSION['user_id'];  
	if(!$user_check){ 
		header("Location: ../../index.php");
		
	}


?>