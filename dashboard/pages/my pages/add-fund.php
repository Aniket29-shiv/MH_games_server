<?php

	include('lock.php');
	include('config.php');
 $play_chips 	= $_REQUEST['play_chips'];
	$user_id 	= $_REQUEST['user_id'];
 $real_chips 	= $_REQUEST['real_chips'];
	$current_date		= date('Y-m-d H:i:s');
	
	$fetch_query = "select play_chips,real_chips from accounts where userid =$user_id";
				$account_data = $conn->query($fetch_query);
				$account_data = $account_data->fetch_assoc(); 
				 
				$play_chips_new = $play_chips+ $account_data['play_chips'];				
		    	$real_chips_new = $real_chips+  $account_data['real_chips']; 
	

			if($play_chips!=0 && $real_chips!=0)
			{
				
				if($play_chips!=0)
				{
						$sql2 	= "INSERT INTO fund_added_to_player(user_id, amount, created_date, chip_type,transaction_id,payment_mode,order_id,status) 
									   VALUES('{$user_id}','$play_chips','{$current_date}','Free',0,'Admin',0,'success')";
					
					$result2		= $conn->query($sql2);
				
					
					$query3 		= "update accounts set play_chips={$play_chips_new},updated_date ='{$current_date}'  where  userid= $user_id"; 
					
					$result5 	= $conn->query($query3);
					
				}
				if($real_chips!=0)
				{ 
						
						
                                $sql3 	= "INSERT INTO fund_added_to_player(user_id, amount, created_date, chip_type,transaction_id,payment_mode,order_id,status) 
                                VALUES('{$user_id}','$real_chips','{$current_date}','Real',0,'Admin',0,'success')";
                                
                                $result3		= $conn->query($sql3);
                                
                                
                                $query12 		= "update accounts set real_chips={$real_chips_new},updated_date ='{$current_date}'  where  userid= $user_id"; 
                                
                                $result12 	= $conn->query($query12);
                                //Insert record into fund_added_to_player table end
                    
                                $paymentMode="Admin";
                                $orderAmount=$real_chips;
                                $updated_date		= date('Y-m-d H:i:s');
                                
                                $select_reset='select * from reward_point_set where id=1';
                                
                                $result_set = $conn->query($select_reset);
                                $rowset = $result_set->fetch_assoc();
                                
                                $rewardpointoncash=0;
                                
                                if($real_chips>='1' && $real_chips <'500'){  $rewardpointoncash=$rowset['col_0_500']; }
                                if($real_chips>='501' && $real_chips <'1000'){  $rewardpointoncash=$rowset['col_501_1000']; }
                                if($real_chips>='1001' && $real_chips<'5000') {  $rewardpointoncash=$rowset['col_1001_5000']; }
                                if($real_chips>='5001' && $real_chips<'10000') {  $rewardpointoncash=$rowset['col_5001_10000']; }
                                if($real_chips>='10001' ){  $rewardpointoncash=$rowset['col_10000_up']; }
                                
                                
                                if($rewardpointoncash > 0){	
                                    
                                    
                                            
                                            $select_re='select reward_points from reward_total_point where user_id="'.$user_id.'"';
                                            $result_se = $conn->query($select_re);
                                            
                                            if ($result_se->num_rows > 0){
                                                
                                                    
                                                    $row = $result_se->fetch_assoc();
                                                    $points=$row['reward_points'];
                                                    $new_points= $points+$rewardpointoncash;
                                                    
                                                    //	die("update reward_total_point set reward_points='$new_points' where user_id={$_SESSION['user_id']}");
                                                    $Update_sql=mysqli_query($conn,"update reward_total_point set reward_points='$new_points' where user_id='$user_id'");
                                                    
                                                    $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                    VALUES('$user_id','$rewardpointoncash','$real_chips','$paymentMode','$updated_date')";
                                                    
                                                    $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                                            
                                            }else{
                                                
                                                   
                                                    $insert_sql_reward="INSERT INTO reward_total_point(user_id,reward_points)
                                                    VALUES('$user_id','$rewardpointoncash')";
                                                    
                                                    
                                                    $result_re= mysqli_query($conn,$insert_sql_reward);
                                                    
                                                    $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                    VALUES('$user_id','$rewardpointoncash','$real_chips','$paymentMode','$updated_date')";
                                                    
                                                    $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                                                    
                                            }
                                    
                                    
                                    
                                }
										    
						
						
                    //end here
                    
                    	if(($result3)&&($result12)){
							echo "1";
						}else{ 
								echo "2";
						}
					
					//header("Location:add-fund-account.php?status=5");
				}					

			}else if($play_chips!=0)
				{
				    
				    
						$sql2 	= "INSERT INTO fund_added_to_player(user_id, amount, created_date, chip_type,transaction_id,payment_mode,order_id,status) 
									   VALUES('{$user_id}','$play_chips','{$current_date}','Free',0,'Admin',0,'success')";
					
					$result2		= $conn->query($sql2);
				
					
					$query3 		= "update accounts set play_chips={$play_chips_new},updated_date ='{$current_date}'  where  userid= $user_id"; 
					
					$result5 	= $conn->query($query3);
					
                    	if(($result2)&&($result5)){
							echo "1";
						}else{ 
								echo "2";
						}
					
				}else if($real_chips!=0)
				{ 
						
						
						$sql3 	= "INSERT INTO fund_added_to_player(user_id, amount, created_date, chip_type,transaction_id,payment_mode,order_id,status) 
									   VALUES('{$user_id}','$real_chips','{$current_date}','real',0,'Admin',0,'success')";
					
					$result3		= $conn->query($sql3);
				
					
					$query12 		= "update accounts set real_chips={$real_chips_new},updated_date ='{$current_date}'  where  userid= $user_id"; 
					
					$result12 	= $conn->query($query12);
						//Insert record into fund_added_to_player table end
                    
                    	$paymentMode="Admin";
					         $orderAmount=$real_chips;
				        	$updated_date		= date('Y-m-d H:i:s');
						    
																  	 $select_reset='select * from reward_point_set where id=1';
                               
                                $result_set = $conn->query($select_reset);
                                $rowset = $result_set->fetch_assoc();
                              
                                $rewardpointoncash=0;
                                
                                 if($real_chips>='1' && $real_chips <'500'){  $rewardpointoncash=$rowset['col_0_500']; }
                                if($real_chips>='501' && $real_chips <'1000'){  $rewardpointoncash=$rowset['col_501_1000']; }
                                if($real_chips>='1001' && $real_chips<'5000') {  $rewardpointoncash=$rowset['col_1001_5000']; }
                                if($real_chips>='5001' && $real_chips<'10000') {  $rewardpointoncash=$rowset['col_5001_10000']; }
                                if($real_chips>='10001' ){  $rewardpointoncash=$rowset['col_10000_up']; }
                                
                                
                                
                                if($rewardpointoncash > 0){	
                                    
                                    
                                            
                                            $select_re='select reward_points from reward_total_point where user_id="'.$user_id.'"';
                                            $result_se = $conn->query($select_re);
                                            
                                            if ($result_se->num_rows > 0){
                                                
                                                    
                                                    $row = $result_se->fetch_assoc();
                                                    $points=$row['reward_points'];
                                                    $new_points= $points+$rewardpointoncash;
                                                    
                                                    //	die("update reward_total_point set reward_points='$new_points' where user_id={$_SESSION['user_id']}");
                                                    $Update_sql=mysqli_query($conn,"update reward_total_point set reward_points='$new_points' where user_id='$user_id'");
                                                    
                                                    $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                    VALUES('$user_id','$rewardpointoncash','$real_chips','$paymentMode','$updated_date')";
                                                   // echo $insert_sql_reward_tran;
                                                    //exit();
                                                    $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                                            
                                            }else{
                                                
                                                   
                                                    $insert_sql_reward="INSERT INTO reward_total_point(user_id,reward_points)
                                                    VALUES('$user_id','$rewardpointoncash')";
                                                    
                                                    
                                                    $result_re= mysqli_query($conn,$insert_sql_reward);
                                                    
                                                    $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                    VALUES('$user_id','$rewardpointoncash','$real_chips','$paymentMode','$updated_date')";
                                                    
                                                    $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                                                    
                                            }
                                    
                                    
                                    
                                }
						
						
                    //end here
                    
                    	if(($result3)&&($result12)){
                    	  
							echo "1";
						}else{ 
						    
						      
								echo "2";
						}
					
					//header("Location:add-fund-account.php?status=5");
				}

			
	
?>