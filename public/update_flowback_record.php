<?php
	$_POST['tid'];
      session_start();  
	update();
		
    function update()
	{ 
	    include 'database.php';
	    $user_id = $_SESSION['user_id'];
		 $sql_reqRec = "SELECT requested_amount FROM withdraw_request where user_id = '".$user_id."' and transaction_id = '$_POST[tid]'";  
          $result_reqRec = $conn->query($sql_reqRec);
		  $row_reqRec = $result_reqRec->fetch_assoc();
		
		  $reqAmount =  $row_reqRec['requested_amount']; 
		
		$sql_act = "SELECT * FROM accounts where userid = '".$user_id."'";  
         $result_act = $conn->query($sql_act);
		 $row_act = $result_act->fetch_assoc();
		   $totalAmount =   $row_act['real_chips'];
		  $upAmount = $reqAmount + $totalAmount;
		  date_default_timezone_set("Asia/Kolkata");

	       $updated_on = date("Y-m-d H:i:s");
	
	$sql_upAmount = "UPDATE accounts SET real_chips = $upAmount  where userid = '".$user_id."'";  
    if($result_upamount = $conn->query($sql_upAmount))
	{
		$sql_upStatus = "UPDATE withdraw_request SET status ='Reversed' , updated_on = '$updated_on' where user_id = '".$user_id."' and transaction_id = '$_POST[tid]'";  
		if($result_upStatus = $conn->query($sql_upStatus))
		{
			header("Location:withdrawals.php");
		}
		 
	}
	else{
		echo 0;
	    }
	}
	?>