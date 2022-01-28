<?php
session_start();
include 'database.php';
if(isset($_POST['amount']))
{
    
    $amount = round($_POST['amount']);}
    $user_id=$_SESSION['user_id'];

    $created_date = date("Y-m-d H:i:s");
    $sql1="select * from reward_total_point where user_id='".$_SESSION['user_id']."'";
			
		$result1 = $conn->query($sql1);
		if ($result1->num_rows > 0) { 
			while($row1 = $result1->fetch_assoc())
			{
			 	$amt=$row1['reward_points'];
			}			
		}
		
		
		//=====Get percent VAlue=======
            $get="select redeem_per from reward_point_set";
            
            $getresult1 = $conn->query($get);
            $setrow1 = $getresult1->fetch_assoc();
            $percentval=$setrow1['redeem_per'];

		
		$reg=0;
        if($_POST['amount'] > $amt){	$reg=1;}
        if($_POST['amount'] < 100){	$reg=1;}
		
	
		if($reg == 0){
		    
            		    $real_points=$_POST['amount'];
            		    $amount= $real_points*($percentval/100);
            			/*if($_POST['amount']==100)
            			$amount=3;
            			else if($_POST['amount']==300)
            			$amount=10;
            			else if($_POST['amount']==600)
            			$amount=20;
            			else if($_POST['amount']==1500)
            			$amount=50;
            			else if($_POST['amount']==2000)
            			$amount=100;
            			else if($_POST['amount']==4000)
            			$amount=200;
            			else if($_POST['amount']==8000)
            			$amount=500;*/
            		
                		$sql1="select * from accounts where userid='".$_SESSION['user_id']."'";
                			
                		$result1 = $conn->query($sql1);
                		
                		if ($result1->num_rows > 0) { 
                			while($row1 = $result1->fetch_assoc())
                			{
                			 	$amt_real=$row1['real_chips'];
                			}			
                		}
                		
                		
                        $upAmount=$amt_real+$amount;
                        $sql_upAmount = "UPDATE accounts SET real_chips = $upAmount  where userid='".$_SESSION['user_id']."'";
                        $result1=	$conn->query($sql_upAmount);
                        
                        $upAmount_redeem=$amt-$real_points;
                        $sql_upAmount = "UPDATE reward_total_point SET reward_points = $upAmount_redeem  where user_id='".$_SESSION['user_id']."'";
                        $result2=$conn->query($sql_upAmount);
                        
                        
        			if($result1&&$result2){
        				
                        $sql2 	= "INSERT INTO fund_added_to_player(user_id, amount, created_date, chip_type,transaction_id,payment_mode,order_id,status) 
                        VALUES('{$user_id}','{$amount}','$created_date','Real',0,'Redeem',0,'success')";
                        
                        $result3= $conn->query($sql2);
                        
                        $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date,per_redeem) 
                        VALUES('$user_id','$real_points','$amount','Redeem','$created_date','$percentval')";	
                        
                        $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                        
                         if($result3 && $result_re_tran){
                             
                              echo "1";
                             
                         }else{
                              echo "0";
                         }
        			}                             									    
		}else{
		    
		    echo "2";
		}
	

?>