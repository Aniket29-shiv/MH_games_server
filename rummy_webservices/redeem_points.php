<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(0);
include 'config.php';

$userId = $_GET['user_id'];
$real_points = $_GET['amount'];
$current_date = date('Y-m-d H:i:s');

    $amt = 0;

    $sql1="select * from reward_total_point where user_id='".$userId."'";
	
	$result1 = $connect->query($sql1);
	if ($result1->num_rows > 0) 
	{ 
		while($row1 = $result1->fetch_assoc())
		{
		 	$amt=$row1['reward_points'];
		}
	}
	
	if ($amt >= $real_points)
	{
	    //=====Get percent VAlue=======
        $get="select redeem_per from reward_point_set";
        
        $getresult1 = $connect->query($get);
        $setrow1 = $getresult1->fetch_assoc();
        $percentval=$setrow1['redeem_per'];
        
        $amount= $real_points*($percentval/100);
        
        $sql1="select * from accounts where userid='".$userId."'";
                			
    	$result1 = $connect->query($sql1);
    	
    	if ($result1->num_rows > 0) { 
    		while($row1 = $result1->fetch_assoc())
    		{
                $amt_real=$row1['real_chips'];
    		}			
    	}
    	
        $upAmount=$amt_real+$amount;
        $sql_upAmount = "UPDATE accounts SET real_chips = $upAmount  where userid='".$userId."'";
        $result1=	$connect->query($sql_upAmount);
        
        $upAmount_redeem=$amt-$real_points;
        $sql_upAmount = "UPDATE reward_total_point SET reward_points = $upAmount_redeem  where user_id='".$userId."'";
        $result2=$connect->query($sql_upAmount);
        
        if($result1&&$result2)
        {
            $sql2 = "INSERT INTO fund_added_to_player(user_id, amount, created_date, chip_type,transaction_id,payment_mode,order_id,status) 
            VALUES('{$userId}','{$amount}','$current_date','Real',0,'Redeem',0,'success')";
            
            $result3= $connect->query($sql2);
            
            $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date,per_redeem) 
            VALUES('$userId','$real_points','$amount','Redeem','$current_date','$percentval')";	
            
            $result_re_tran= mysqli_query($connect,$insert_sql_reward_tran);
            
            if($result3 && $result_re_tran)
            {
                echo json_encode(array('status'=>"success",'message'=>"Fund added successfully")); 
            }
            else
            {
                echo json_encode(array('status'=>"false",'message'=>"Chips not redeem."));
            }
        }
        else 
        {
            echo json_encode(array('status'=>"false",'message'=>"Chips not redeem."));
        }
	}
	else 
    {
        echo json_encode(array('status'=>"false",'message'=>"You don't have sufficient balance to redeem points"));
    }

?>