
<?php
session_start();
include 'database.php';
if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
	{
	$loggeduser =  $_SESSION['logged_user'];
			$user_id=$_SESSION['user_id'];

	$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc())
		{
			$play_chips = $row['play_chips'];
			$real_chips = $row['real_chips'];
		}
		
	
		
	}
	else {
	echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
	header("Location:index.php");
	}
		$conn->close();
	}
?>

<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
			<!--	<div class="row user-name pb20">
					<div class="col-md-12">
						<div class="col-md-6 col-sm-5 black-bg">
							<h5 class="color-white">Welcome</h5>
							<h4><b><?php echo $loggeduser; ?></b></h4>
						</div>
						<div class="col-md-6 col-sm-7 black-bg">
							<h5 class="color-white">Play Chips :</h5>
							<h4><b><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?></b></h4>
							<h5 class="color-white"> Money :</h5>
							<h4><b><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
			
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
							<div class="col-md-8">
							
								<div class="buy-chips-wrapper">
								
				<div class="box">
					<div class="box-body">

	<?php  
		include 'database.php';
$config = "SELECT * FROM `payment_gateway`  where id = 1";
$resultget = $conn->query($config);
$rowget = $resultget->fetch_assoc();
$secretkey = $rowget['gateway_key'];
		// $secretkey = "c32f7335bb4cda705bff338892a514aeb19154ee";
		 $orderId = $_POST["orderId"];
		 $orderAmount = $_POST["orderAmount"];
		 $referenceId = $_POST["referenceId"];
		 $txStatus = $_POST["txStatus"];
		 $paymentMode = $_POST["paymentMode"];
		 $txMsg = $_POST["txMsg"];
		 $txTime = $_POST["txTime"];
		 $signature = $_POST["signature"];
		 $data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
		 $hash_hmac = hash_hmac('sha256', $data, $secretkey, true) ;
		 $computedSignature = base64_encode($hash_hmac);
		 if ($signature == $computedSignature) {
		     	if ($_POST["txStatus"] == "SUCCESS") 
														{
						
																					
															/*****************************Insert Into Database***************************************/
																// include '../lock.php';
																// include("./config.php"); 
																
														

                                                        	   $query1 = "select bonus from coupon_used_by_player where order_id='".$orderId."' ";
																//echo"---query----".$query."---<br>";
                                                                $listdata = $conn->query($query1);
                                                                   if ($listdata->num_rows > 0) {
                                                                   $list = $listdata->fetch_assoc();
																    $old_bonus=$list['bonus'];
                                                                 }else{
                                                                   $old_bonus=0;
                                                                 }
																// Check connection
																								
														$updated_date		= date('Y-m-d H:i:s');
													        	$query = "select real_chips,bonus from accounts where userid='{$_SESSION['user_id']}' ";
																//echo"---query----".$query."---<br>";
																$result = mysqli_fetch_assoc(mysqli_query($conn,$query)); 
															    $real_chips=$result['real_chips'];
															    $bonus=$result['bonus'];
																// echo"---real_chips----".$real_chips."---<br>";		
																
														
																//echo"---TXNAMOUNT----".$TXNAMOUNT."---<br>";									 
																$new_real_chips=$real_chips+$orderAmount;
																$new_bonus=$bonus+$old_bonus;
																$Real="Real";
																$user_id=$_SESSION['user_id'];
																$select_check='select transaction_id,order_id from fund_added_to_player where transaction_id="'.$referenceId.'" and order_id="'.$orderId.'"';
															   	$result1 = $conn->query($select_check);
											if ($result1->num_rows > 0) { 
															 
									
											    
											}	else 
											
											{
											    	$Update_sql=mysqli_query($conn,"update accounts set real_chips='$new_real_chips',bonus='$new_bonus',updated_date = '$updated_date' where userid={$_SESSION['user_id']}");
																
																//echo"---Update_sql----".$Update_sql."---<br>";
																
																if($Update_sql=='true')
																{
																  
																  
																   //======GEtamount Value
                                                                    $select_reset='select * from reward_point_set where id=1';
                                                                    $result_set = $conn->query($select_reset);
                                                                    $rowset = $result_set->fetch_assoc();
                                                                    $rewardpointoncash=0;
														            if($orderAmount>='1' && $orderAmount <'500'){  $rewardpointoncash=$rowset['col_0_500']; }
                                                                    if($orderAmount>='501' && $orderAmount <'1000'){  $rewardpointoncash=$rowset['col_501_1000']; }
                                                                    if($orderAmount>='1001' && $orderAmount<'5000') {  $rewardpointoncash=$rowset['col_1001_5000']; }
                                                                    if($orderAmount>='5001' && $orderAmount<'10000') {  $rewardpointoncash=$rowset['col_5001_10000']; }
                                                                    if($orderAmount>='10001' ){  $rewardpointoncash=$rowset['col_10000_up']; }
                                                                    
                                                                    
                                                                    if($rewardpointoncash > 0){
                                                                        
                                                                        
                                                                              
                                                                                $select_re='select reward_points from reward_total_point where user_id="'.$user_id.'"';
                                                                                $result_se = $conn->query($select_re);
                                                                                
                                                                                if ($result_se->num_rows > 0) {
                                                                                    
                                                                                       
                                                                                        $row = $result_se->fetch_assoc();
                                                                                        $points=$row['reward_points'];
                                                                                        $new_points= $points+$rewardpointoncash;
                                                                                        
                                                                                        $Update_sql=mysqli_query($conn,"update reward_total_point set reward_points='$new_points' where user_id='$user_id'");
                                                                                        
                                                                                        $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                                                        VALUES('$user_id','$rewardpointoncash','$orderAmount','$paymentMode','$updated_date')";
                                                                                        $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                                                                                
                                                                                } else {
                                                                               
                                                                                        $insert_sql_reward="INSERT INTO reward_total_point(user_id,reward_points)
                                                                                        VALUES('$user_id','$rewardpointoncash')";
                                                                                        
                                                                                        
                                                                                        $result_re= mysqli_query($conn,$insert_sql_reward);
                                                                                        
                                                                                        $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                                                        VALUES('$user_id','$rewardpointoncash','$orderAmount','$paymentMode','$updated_date')";
                                                                                        
                                                                                        $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                                                                                
                                                                                }
                                                                        
                                                                    }
																  
														$insert_sql="INSERT INTO fund_added_to_player(user_id, amount, created_date,chip_type,transaction_id,payment_mode,order_id,status) 
									   VALUES('$user_id','$orderAmount','$updated_date','$Real','$referenceId','$paymentMode','$orderId','$txStatus')";	 
									  
							         $result= mysqli_query($conn,$insert_sql);
							        	$Update_sql=mysqli_query($conn," UPDATE `coupon_used_by_player` SET `transaction_id`='$referenceId',`payment_mode`='$paymentMode',`status`='$txStatus'  where order_id='$orderId'");
									  
									 
																	echo "<span style='color:white;font-size:20px;'><center>Transaction Successfully !!!</center></span>";	
																
																}
																else
																{
																	echo "<span style='color:red;'><center>Transaction UN-Successfully !!!</center></span>";
																	
																}	
											    
											}	
														    
														}						
															/*****************************Insert Into Database***************************************/
													
														else 
														{
															echo "<b style='color:white;' >Transaction status is failure</b>" . "<br/>";								
														}
														if (isset($_POST) && count($_POST)>0 )
														{ 
															?><div class="table-responsive " >
														<label>Order ID </label> <span style="color:white;">=	<?php	echo $orderId;?></span>
												    <br>	<label>Amount </label>	  <span style="color:white;">=   <?php   echo  $orderAmount;?></span>
														  <br> <label>Reference ID </label>  <span style="color:white;">=  <?php  echo  $referenceId;?></span>
														  <br>  <label> Transaction Status </label>   <span style="color:white;">= <?php echo $txStatus;?></span>
														 <br>    <label>Payment Mode </label> <span style="color:white;">=  <?php echo $paymentMode;?></span>
														  <br>   <label>Message </label>   <span style="color:white;">= <?php echo $txMsg;?></span>
														   <br><label>Transaction Time </label>   <span style="color:white;">=  <?php echo  $txTime;?></span>
														        </div>
													<?php	}
													}
													else 
													{
														// echo "<b>Checksum mismatched.</b>";
														?>
															<b>Transaction is failed</b>								
														<?php
													}
												?>
										</div>
				</div>
				<!-- /.box -->
			
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
			</div>
		</div>
	</main>
	
	
	
	
	
	
	<footer>
		<div id="footer"></div>
	</footer>
</body>
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		});
	</script>
</html>
