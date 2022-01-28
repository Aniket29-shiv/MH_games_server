
<?php
session_start();
 
 
if(!isset($_SESSION['logged_user'])){
     
       header("Location:sign-in.php");
       
}else{
        
        $loggeduser =  $_SESSION['logged_user'];
        include 'database.php';
    
        $sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            
        	while($row = $result->fetch_assoc()){
        	    
        		$play_chips = $row['play_chips'];
        		$real_chips = $row['real_chips'];
        	}
        	
        } else {
                echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
                header("Location:index.php");
        }
        
        $conn->close();
    
include 'database.php';
?>


<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

//converts ymd format date to dmy format
/* <link rel="stylesheet" href="../../css/testimonials.css ">
<link rel="stylesheet" href="../../css/jquery-ui.css">
<link rel="stylesheet" href="../../css/bootstrap.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/font-awesome.css">
<script  src="../../js/bootstrap.min.js" ></script>
<script  src="../../js/jquery.js" ></script> */



// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
?>






</DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bootstrap.css" rel="stylesheet">
       	<link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
			
				<hr>
            <div class="row contact-wrapper mt20">
               <?php include 'leftbar.php'; ?>
                 <div class="col-md-9 col-sm-7">
                    <div class="row">
                   	<div class="col-xs-12">
						<div class="box">
							<div class="box-body profile-wrapper">
								<div class="row">
									<div class="col-md-12 col-md-offset-0 mt15 col-sm-8 col-sm-offset-2">
										<div style="border:1px solid #404040;border-radius:8px;color:white;">
											<h3 class="text-center mb0"><b style="color:black;">Transaction Details</b></h3>
											<hr style="border-top:1px solid #ec971f">
				
				<!---====================================Code start Here Php=================================================-->	
				<?php
								
			    	$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
			    	
					if($isValidChecksum == "TRUE"){
					    
								if ($_POST["STATUS"] == "TXN_SUCCESS"){
								    
				?>
                                                    
                                                    <b>Transaction is success</b>
                                                    <div class="table-responsive " >
                                                    <label>Order ID </label> <span style="color:white;">=	<?php	echo $_POST['ORDERID'];?></span>
                                                    <br><label>Transaction ID </label>	  <span style="color:white;">=   <?php   echo  $_POST['TXNID'];;?></span>
                                                    <br><label>Transaction Amount </label>  <span style="color:white;">=  <?php  echo  $_POST['TXNAMOUNT'];;?></span>
                                                    <br><label>Transaction Currency </label>   <span style="color:white;">= <?php echo $_POST['CURRENCY'];;?></span>
                                                    <br><label>Response Status</label> <span style="color:white;">=  <?php echo $_POST['STATUS'];;?></span>
                                                    <br><label>Bank Transaction ID </label>   <span style="color:white;">= <?php echo $_POST['BANKTXNID'];?></span>
                                                    <br><label>Bank Name </label>   <span style="color:white;">=  <?php echo  $_POST['BANKNAME'];?></span>
                                                    
                                                    </div>

								
							<?php 
															
															
                                        /*****************************Insert Into Database***************************************/
                                        // include '../lock.php';
                                        // include("./config.php"); 
									  
										
										$orderId=$_POST["ORDERID"];
										$transactionid=$_POST["TXNID"];
									    $paymentsatus=$_POST["STATUS"];
									    $bonusadded=0;
										$TXNAMOUNT=$_POST['TXNAMOUNT'];		
										
										$query1 = "select bonus from coupon_used_by_player where order_id='".$orderId."' ";
										
                                        $listdata = $conn->query($query1);
                                           if ($listdata->num_rows > 0) {
                                           $list = $listdata->fetch_assoc();
										    $old_bonus=$list['bonus'];
										     $bonusadded=1;
                                         }else{
                                           $old_bonus=0;
                                         }
														
														
														
														
								    	$updated_date = date("Y-m-d H:i:s");
										$query = "select real_chips,bonus from accounts where userid='{$_SESSION['user_id']}' ";
										$result = mysqli_fetch_assoc(mysqli_query($conn,$query)); 
										$real_chips=$result['real_chips'];	
										$bonus=$result['bonus'];
									
										
																								
								    	/*	if (isset($_POST) && count($_POST)>0 ){ 
										    
											foreach($_POST as $paramName => $paramValue) 
											{
												if($paramName=='TXNAMOUNT')
												{
													$TXNAMOUNT=$paramValue;
												}else if($paramName=='ORDER_ID'){
												    
												    $ORDER_ID = $paramValue;
												}
											}
										}*/
																						 
										$new_real_chips=$real_chips+$TXNAMOUNT;	
										$new_bonus=$bonus+$old_bonus;
										$new_real_chips=$real_chips+$TXNAMOUNT;	
										$orderAmount=$TXNAMOUNT;
										$paymentMode="Paytm";
										$referenceId=$ORDER_ID;
										$user_id=$_SESSION['user_id'];
														    
									
										
										$select_check='select transaction_id,user_id from fund_added_to_player where transaction_id="'.$transactionid.'" and user_id="'.$user_id.'"';
									
										$result1 = $conn->query($select_check);
									   	
									   	
										if ($result1->num_rows > 0) { 
										    
										     //echo '<script>alert("hi2")</script>';
										    
										}else{
										    
										  //  echo '<script>alert("hello")</script>';
										    //echo "update accounts set real_chips='$new_real_chips',bonus='$new_bonus',updated_date = '$updated_date' where userid={$_SESSION['user_id']}";
											    $Update_sql=mysqli_query($conn,"update accounts set real_chips='$new_real_chips',bonus='$new_bonus',updated_date = '$updated_date' where userid={$_SESSION['user_id']}");
													
												if($Update_sql=='true'){
																  
																  
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

																          if ($result_se->num_rows > 0){

                                                                                   
                                                                                    $row = $result_se->fetch_assoc();
                                                                                    $points=$row['reward_points'];
                                                                                    $new_points= $points+$rewardpointoncash;

                                                                                    
                                                                                    $Update_sql=mysqli_query($conn,"update reward_total_point set reward_points='$new_points' where user_id='$user_id'");

                                                                                    $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                                                    VALUES('$user_id','$rewardpointoncash','$orderAmount','$paymentMode','$updated_date')";
                                                                                    $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);

                                        								   }else{

                                                                                    
                                                                                    $insert_sql_reward="INSERT INTO reward_total_point(user_id,reward_points)
                                                                                    VALUES('$user_id','$rewardpointoncash')";


                                                                                    $result_re= mysqli_query($conn,$insert_sql_reward);

                                                                                    $insert_sql_reward_tran="INSERT INTO reward_point_trans(user_id,points,amount,payment_mode,date)
                                                                                    VALUES('$user_id','$rewardpointoncash','$orderAmount','$paymentMode','$updated_date')";

                                                                                    $result_re_tran= mysqli_query($conn,$insert_sql_reward_tran);
                                                							}
                                                                
                                                            }
																  
														
														
									
																	
														//=======Insert data in fun add		  
                                                        $insert_sql="INSERT INTO fund_added_to_player(user_id, amount, created_date,chip_type,transaction_id,payment_mode,order_id,status)
                                                        VALUES('$user_id','$orderAmount','$updated_date','Real','$transactionid','$paymentMode','$orderId','SUCCESS')";
                                                        
                                                         //echo $insert_sql;
                                                        
									                    $result= mysqli_query($conn,$insert_sql);
									                    
									                    if($bonusadded == 1){
									                    
									                      	$Update_sql=mysqli_query($conn," UPDATE `coupon_used_by_player` SET `transaction_id`='$transactionid',`payment_mode`='$paymentMode',`status`='SUCCESS'  where order_id='$orderId'");
									                      	//echo " UPDATE `coupon_used_by_player` SET `transaction_id`='$transactionid',`payment_mode`='$paymentMode',`status`='SUCCESS'  where order_id='$orderId'";
									                    }
																	// echo "<span style='color:green;font-size:20px;'><center>Transaction Successfully !!!</center></span>";
																	
								?>
																	<!--	<div class="alert alert-success alert-dismissable fade in">
																			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
																			<strong>Success!</strong> Record Updated.....!
																			<p>Order ID: <?php echo $orderId;?></p>
																		</div>-->
																		
				<?php    }else	{	?>
														<div class="alert alert-danger alert-dismissable fade in">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<strong>Fail....!</strong>  Error Occured...!
														</div>
				<?php	
				    
			            	}  //=======Updtae Condition end		
						    
			    	} //=====Check Sum Condtion End	
				
										    
				}else{
				    
					echo "<b>Transaction status is failure</b>" . "<br/>";	
								
				}
								
											
    								/*
                                        if (isset($_POST) && count($_POST)>0 ){ 
                                        
                                            foreach($_POST as $paramName => $paramValue){
                                            
                                            echo "<br/>" . $paramName . " = " . $paramValue;
                                            
                                            }
                                    */  
                                        
                 }else{
    									
    					echo "<b>Checksum mismatched.</b>";
				?>
														<b>Transaction is failed</b>
															
		    	<?php  }	?>
								
								
								
								
								
								
								
								
								
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
					</div>
				</div>
				<hr>
			</div>
		</div>
	</main>
	<footer>
		<div id="footer">aaaaaaaaaaaaaaaaa</div>
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
<?php } ?>