<?php
session_start();
$message="";
 
 
 if(!isset($_SESSION['logged_user'])){ 
     
     header("Location:sign-in.php");
}else{
    $loggeduser =  $_SESSION['logged_user'];
    $user_id='';
     include 'database.php';
    $getuser = $conn->query("SELECT * FROM users WHERE username = '".$loggeduser."'");
    
    if ($getuser->num_rows > 0) { 
    
    $listuser = $getuser->fetch_assoc();
    $user_id=$listuser['user_id'];			
    }
            
   
    
    
    
    
     function witdrawableamount($conn){
         
            $loggeduser =  $_SESSION['logged_user'];
            $user_id='';
            $todate = date('Y-m-d H:i:s');
            $withdrawableDiffAmount = 0;
            
            //=====User ID Get From Username
            $getuser = $conn->query("SELECT * FROM users WHERE username = '".$loggeduser."'");
            
            if ($getuser->num_rows > 0) { 
            
               $listuser = $getuser->fetch_assoc();
               $user_id=$listuser['user_id'];			
            }
            
            //=====Check AMount Of Withdraw
            if($user_id != ''){
                
                	$paymenthistorysql = $conn->query("SELECT * FROM fund_added_to_player WHERE user_id = '".$user_id."' and  chip_type = 'real'  and  status = 'success' and payment_mode != 'Redeem'  ORDER BY id DESC LIMIT 3");
                
                    
                    if($paymenthistorysql->num_rows > 0 ){	
                        
		                while($row = $paymenthistorysql->fetch_assoc()){
		                     
                                $amount = $row['amount'];
                                $fromDate = $row['created_date'];
                                
                                $lostamountsql = $conn->query("SELECT SUM(amount) AS lostAmount FROM game_transactions WHERE user_id = '".$user_id."' AND status = 'Lost' AND chip_type = 'real' AND (transaction_date BETWEEN '".$fromDate ."' AND '".$todate."')");
                               
                                if($lostamountsql->num_rows > 0 ){
                                    
                                    $lostAmountRow = $lostamountsql->fetch_assoc();
                                    $lostAmount = $lostAmountRow['lostAmount'];
                                }else{
                                    $lostAmount=0;
                                }
                                
                                if ($lostAmount == NULL || $lostAmount == ''){
                                    
                                    $lostAmount = 0;
                                    
                                }
                                
                                
                                if ($lostAmount < $amount){
                                    
                                        $amountDiff = $amount - $lostAmount;
                                        $withdrawableDiffAmount = $withdrawableDiffAmount + $amountDiff;
                                        
                                }
                                
                                $todate = $fromDate;
                            
                            
                            

		                }
		                
		                
		                
                    }else{
                        return 0;
                    }
                    
                    
                    //================Final amount check
                    
                    $totalamount = 0;
                    $sql1 = "SELECT real_chips FROM accounts where userid = '".$user_id."'";
                    
                    $result1 = $conn->query($sql1);
                    
                    if ($result1->num_rows > 0) {
                        
                        $userrow = $result1->fetch_assoc();
                        $totalamount = $userrow['real_chips'];
                        
                    }
                    
                    if ($totalamount >= $withdrawableDiffAmount){
                      $withdrawalAmount = $totalamount - $withdrawableDiffAmount;
                    }else {
                       $withdrawalAmount = 0;
                    }
                    
                    return $withdrawalAmount;
               
            }else{
              return 0;
            }
     
     }   
    
    $sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
    $result = $conn->query($sql);
    
    
        if ($result->num_rows > 0) {
            
            	while($row = $result->fetch_assoc()){
            	    
            		$play_chips = $row['play_chips'];
            		$real_chips = $row['real_chips'];
            		
            	}
            	
        	
            	if(isset($_POST['btnSubmit'])){
            	    
                    		$created_date = date("Y-m-d H:i:s");
                    	    $withdrawable=witdrawableamount($conn);
                    	    $reqamount=$_POST['amount'];
                    	
                    	   if($reqamount <= $withdrawable){
                    	       
                    	           	$sql1="select * from accounts where userid='".$_SESSION['user_id']."'";
                    	        	$result1 = $conn->query($sql1);
                    		
                            		if ($result1->num_rows > 0) { 
                            		    
                            			while($row1 = $result1->fetch_assoc()){	$amt=$row1['real_chips'];	}			
                            	    }
                            		
                            		if($_POST['amount']>=100 and $_POST['amount']<=$amt){
                            		    
                            			$sql="insert into withdraw_request(user_id,requested_amount,created_on,updated_on,status)values('".$_SESSION['user_id']."','".$_POST['amount']."','".$created_date."','".$created_date."','Pending')";
                            			$conn->query($sql);
                            			$upAmount=$amt-$_POST['amount'];
                            			$sql_upAmount = "UPDATE accounts SET real_chips = $upAmount  where userid='".$_SESSION['user_id']."'";
                            			$conn->query($sql_upAmount);
                            			
                            		}else if($_POST['amount']<100){
                            		    
                            			$message="You can withdraw minimum 100Rs. ...!";
                            			
                            	    }else if($_POST['amount']>$amt){
                            		    
                            			$message='You have not enough balance ...!';
                            	
                            		}else{
                            			$message='Enter valid amount';
                            		}
                    	   }else{
                    	       
                    	       $message='You have not enough balance ...!';
                    	       
                    	   }
            	}
    	
    	
    	
    	
        }else {
                echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
                header("Location:index.php");
        }
        
       function  balanceamount($conn){
            
                $loggeduser =  $_SESSION['logged_user'];
                $sql = "SELECT real_chips FROM  accounts where username = '".$loggeduser."'";
                $result = $conn->query($sql);
    
    
                         if ($result->num_rows > 0) {
                            	$row = $result->fetch_assoc();
                            	$real_chips = $row['real_chips'];
                         }else{
                             $real_chips =0;
                         }
                         return $real_chips;
        }
    

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
								<h3 class="color-white text-center mt20"><b>My Withdrawals</b></h3>
								
								<div>
								    <?php 
									//	require 'database.php';
										//$sql1="select * from accounts where userid='".$_SESSION['user_id']."'";
										//$result1 = $conn->query($sql1);
										//if ($result1->num_rows > 0) { 
									?>
									<div class="bg-grey table-responsive mt10">
									<p style="margin-left:15px;display:inline-block;color:red">* Minimum Withdraw Amount Limit Is Rs.100/-</p>
										<p style="margin-left:15px;	color:green">* Your Total Balance is <span style="font-weight:600;">Rs.<?php  echo balanceamount($conn);?><span></p>
									<p style="margin-left:15px;	color:green">* You Can Withdraw Upto <span style="font-weight:600;">Rs. <?php  $finalwithdrawable=witdrawableamount($conn); //while($row1 = $result1->fetch_assoc())
											echo $finalwithdrawable;	//{ echo $row1['real_chips']. " ";}} ?></span> From Your Account</p>	
									<form id="form_personal_details" method="post" action="">
										<label style="color:#333;">Enter Amount :</label>
										<input type="text" name="amount" required /><br/><span id="mobilemsg" style="color: red;margin-left: 14px;"><?php echo $message;?></span>
										<div class="text-center"><button class="btn btn-default" name="btnSubmit" id="withdraw" style="margin:25px;color:white;">Submit</button></div>
									</form>
									</div>
									</div>
									<div style="background:white;height:500px;overflow:auto;">
									<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
										<thead>
											<tr style='background-color: wheat;'>
												<th style="width:1%;text-align:center;font-size: 12px;">Sr.No</th>
												<th style="width:28%;text-align:center;font-size: 12px;">Transaction Id</th>
												<th style="width:10%;text-align:center;font-size: 12px;">Amount</th>
												<th style="width:20%;text-align:center;font-size: 12px;">Request Date</th>
												<th style="width:6%;text-align:center;font-size: 12px;">Updation Date</th>
												<th style="width:16%;text-align:center;font-size: 12px;">Status</th>
												<th style="width:30%;text-align:center;font-size: 12px;">Action</th>
											</tr>
										</thead>
									
										<tbody>
										<?php											
											$sql1="select * from withdraw_request where user_id='".$user_id."' order by transaction_id";
											//echo $sql1;
											$result1 = $conn->query($sql1);
											if ($result1->num_rows > 0) { 
												 $i = 1;
												while($row1 = $result1->fetch_assoc())
												{
													?>
													<form action="update_flowback_record.php" method="post" id="flowback">
													<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $tid=$row1['transaction_id'];?><input type="hidden" name="tid" value ="<?php echo $tid; ?>" /></td>
													<td><?php echo $row1['requested_amount'];?></td>
													<td><?php echo $row1['created_on'];?></td>													
													<td><?php echo $row1['updated_on'];?></td>
													<?php if($row1['status'] == 'Pending') {?>
													<td><?php echo $row1['status'];?></td>
													<td><button class="btn btn-primary btn-xs" name="flowback" >Flowback</button></td>													
													<?php } else {?>
													<td><?php echo $row1['status'];?></td>
													<td><?php echo $row1['status'];?></td>
													<?php } ?>
												
													</tr>
													</form>
													<?php 
												 $i++;			
												}
											}
										?>
										</tbody>
										
									</table>
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
		  
		  
		      
        		 $("#withdraw").click(function() {

        			if(confirm('are you sure?')){
        			    return true;

        			}else{
        			    return false;
        			}

        		});
		});
	</script>
	  
</html>
<?php 

$conn->close();

} 
?>