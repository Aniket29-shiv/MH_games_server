<?php

	/*
	*    LOGOUT USER AND DESTROY SESSION
	*/

		session_start();
		if(session_destroy())
		{
			header("Location:index.php");
		} 
?>