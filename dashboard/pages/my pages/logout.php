<?php

	/*
	*    LOGOUT USER AND DESTROY SESSION
	*/ 
		session_start();
		unset ($_SESSION["user_id"]);
		header("Location:../../index.php");
		/* if(session_destroy())
		{
			header("Location:../../index.php");
		}  */
?>