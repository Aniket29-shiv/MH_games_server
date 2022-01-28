<?php

include 'config.php';

	$results = array();

    $userId = $_GET['userId'];
    $todate = date('Y-m-d H:i:s');
    
    $withdrawableDiffAmount = 0;

	//$paymenthistorysql = $conn->query("SELECT * FROM ( SELECT * FROM payment_history WHERE player_id = '".$userId."' ORDER BY id DESC LIMIT 3 ) sub ORDER BY id DESC"); 
	$paymenthistorysql = $connect->query("SELECT * FROM fund_added_to_player WHERE user_id = '".$userId."' AND payment_mode != 'Redeem' AND status = 'success' ORDER BY id DESC LIMIT 3");
	if($paymenthistorysql->num_rows > 0 )
	{							
		while($row = $paymenthistorysql->fetch_assoc())
    	{
    	    $amount = $row['amount'];
    	    $fromDate = $row['created_date'];
			
			$lostamountsql = $connect->query("SELECT SUM(amount) AS lostAmount FROM game_transactions WHERE user_id = '".$userId."' AND status = 'Lost' AND chip_type = 'real' AND (transaction_date BETWEEN '".$fromDate ."' AND '".$todate."')");
			
			//echo "SELECT SUM(points) AS lostAmount FROM game_transactions WHERE player_id = '".$userId."' AND status = 'Lost' AND game_type = 'money' AND (date_time BETWEEN '".$fromDate ."' AND '".$todate."')";
			
			$lostAmountRow = $lostamountsql->fetch_assoc();
			$lostAmount = $lostAmountRow['lostAmount'];
			
			if ($lostAmount == NULL || $lostAmount == '') 
			{
			    $lostAmount = 0;
			}
			
			if ($lostAmount < $amount)
			{
			    $amountDiff = $amount - $lostAmount;
			    $withdrawableDiffAmount = $withdrawableDiffAmount + $amountDiff;
			}
			
			$todate = $fromDate;
    	}
	}
	
	$realpoints = 0;
	$sql1 = "SELECT * FROM accounts where userid = '".$userId."'";
    $result1 = $connect->query($sql1);
    if ($result1->num_rows > 0) 
    {
        $userrow = $result1->fetch_assoc();
		$realpoints = $userrow['real_chips'];
    }
    
    if ($realpoints >= $withdrawableDiffAmount)
    {
        $withdrawalAmount = $realpoints - $withdrawableDiffAmount;
    }
    else
    {
        $withdrawalAmount = 0;
    }
	
	echo json_encode(array('response' => 'true','withdrawal_amount' => $withdrawalAmount));
    
	$connect->close();
?>