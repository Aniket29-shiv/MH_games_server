<?php
error_reporting(0);
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
include 'config.php';

$userId = $_GET['user_id'];
$amount = $_GET['amount'];
$transactionDate = $_GET['transactionDate'];
$transactionId = $_GET['transactionId'];
$paymentMode = $_GET['paymentMode'];
$orderId = $_GET['orderId'];
$couponCode = $_GET['couponCode'];
$couponAmount = $_GET['couponAmount'];
$current_date = date('Y-m-d H:i:s');
$order_id = mt_rand(100000, 999999);

   $insertsql = "INSERT INTO fund_added_to_player(user_id, amount, created_date, chip_type, transaction_id, payment_mode, order_id, status) 
									   VALUES('{$userId}','{$amount}','{$transactionDate}','Real','{$transactionId}','{$paymentMode}','{$orderId}','success')";
	   
    if($connect->query($insertsql))
    {
        $playerpointsql = "SELECT `real_chips`, `bonus` FROM `accounts` WHERE `userid` = '".$userId."'";
		$playerpointresult = $connect->query($playerpointsql);	  
		$playerpoint_row = mysqli_fetch_array($playerpointresult);
		$player_prev_points = $playerpoint_row['real_chips'];
		$player_prev_bonus = $playerpoint_row['bonus'];
		$player_curr_points = $player_prev_points + $amount;
		$player_curr_bonus = $player_prev_bonus + $couponAmount;
		
		$updatesql = "UPDATE `accounts` SET `real_chips`= '".$player_curr_points."', `bonus`= '".$player_curr_bonus."', `updated_date`= '".$current_date."' WHERE `userid` = '".$userId."'";
		
		if($connect->query($updatesql))
		{
		    
            if ($couponCode != "")
            {
		        
                $select_coupon = "select * from coupons where coupon = '$couponCode'";
                $result_coupon = $connect->query($select_coupon);
                $rowcoupon = $result_coupon->fetch_assoc();
                
                $reusable = $rowcoupon['reusable'];
                $maxprice = $rowcoupon['maxprice'];
                $discount_type = $rowcoupon['discount_type'];
                $discount_val = $rowcoupon['discount_val'];
                
                $addFrom = 0;
                
                if ($paymentMode == "Paytm")
                {
                    $addFrom = 1;
                }
		        
               $sqlcoupon= "INSERT INTO `coupon_used_by_player`(`user_id`, `amount`, `created_date`, `chip_type`, `order_id`, `status`, `couponcode`, `discount_type`, `discount_val`, `maxprice`, `bonus`, `reusable`, `addfrom`)VALUES ('".$userId."','".$amount."','".$current_date."','Real','".$orderId."','SUCCESS','".$couponCode."','".$discount_type."','".$discount_val."','".$maxprice."','".$couponAmount."','".$reusable."','".$addFrom."')";
       
                $connect->query($sqlcoupon);
		    }
		    
		    
		    
		    $select_reset='select * from reward_point_set where id=1';
            $result_set = $connect->query($select_reset);
            $rowset = $result_set->fetch_assoc();
            $rewardpointoncash=0;
            if($amount>='1' && $amount <='500'){  $rewardpointoncash=$rowset['col_0_500']; }
            if($amount>='501' && $amount <='1000'){  $rewardpointoncash=$rowset['col_501_1000']; }
            if($amount>='1001' && $amount<='5000') {  $rewardpointoncash=$rowset['col_1001_5000']; }
            if($amount>='5001' && $amount<='10000') {  $rewardpointoncash=$rowset['col_5001_10000']; }
            if($amount>='10001' ){  $rewardpointoncash=$rowset['col_10000_up']; }
            
            if($rewardpointoncash > 0)
            {
                      
                $select_re='select reward_points from reward_total_point where user_id="'.$userId.'"';
                $result_se = $connect->query($select_re);
                
                if ($result_se->num_rows > 0) 
                {
                        $row = $result_se->fetch_assoc();
                        $points=$row['reward_points'];
                        $new_points= $points+$rewardpointoncash;
                        
                        $Update_sql=mysqli_query($connect,"update reward_total_point set reward_points='$new_points' where user_id='$userId'");
                        
                        $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                        VALUES('$userId','$rewardpointoncash','$amount','$paymentMode','$current_date')";
                        $result_re_tran= mysqli_query($connect,$insert_sql_reward_tran);
                
                } else {
               
                        $insert_sql_reward="INSERT INTO reward_total_point(user_id,reward_points)
                        VALUES('$userId','$rewardpointoncash')";
                        
                        $result_re= mysqli_query($connect,$insert_sql_reward);
                        
                        $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                        VALUES('$userId','$rewardpointoncash','$amount','$paymentMode','$current_date')";
                        
                        $result_re_tran= mysqli_query($connect,$insert_sql_reward_tran);
                }
            }
		    
		    echo json_encode(array('status'=>"success",'message'=>"Fund added successfully"));    
		}
		else
		{
		    echo json_encode(array('status'=>"false",'message'=>"Error in update"));
		}
        
    }
    else
    {
        echo json_encode(array('status'=>"false",'message'=>"Record not added"));
    }
		
?>