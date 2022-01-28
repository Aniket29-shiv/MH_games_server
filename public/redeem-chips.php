<?php
session_start();
 $message="";
 if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
{
$loggeduser =  $_SESSION['logged_user'];
include 'database.php';

$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
	}
	if(isset($_POST['btnSubmit']))
	{
		$created_date = date("Y-m-d H:i:s");
		$sql1="select * from accounts where userid='".$_SESSION['user_id']."'";
		$result1 = $conn->query($sql1);
		if ($result1->num_rows > 0) { 
			while($row1 = $result1->fetch_assoc())
			{
				$amt=$row1['real_chips'];
			}			
		}
		if($_POST['amount']>=100 and $_POST['amount']<=$amt)
		{
			$sql="insert into withdraw_request(user_id,requested_amount,created_on,updated_on,status)values('".$_SESSION['user_id']."','".$_POST['amount']."','".$created_date."','".$created_date."','Pending')";
			$conn->query($sql);
			$upAmount=$amt-$_POST['amount'];
			$sql_upAmount = "UPDATE accounts SET real_chips = $upAmount  where userid='".$_SESSION['user_id']."'";
			$conn->query($sql_upAmount);
		}
		else if($_POST['amount']<100)
			$message="You can withdraw minimum 100Rs. ...!";
		//echo '<script type="text/javascript">$("#amtmsg").text("You can withdraw minimum 100Rs. ...!");</script>';
		else if($_POST['amount']>$amt)
			$message='You have not enough balance ...!';
		//echo '<script type="text/javascript">$("#amtmsg").text("You have not enough balance ...!");</script>';
		else
			$message='Enter valid amount';
	}
}
else {
echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
header("Location:index.php");
}






$conn->close();

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">	
	<style>
	    
	    td{
	            text-align: initial;
	    }
	    th {

    font-size: 15px;
} 
	</style>
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
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
								<h3 class="text-center mt20" style="padding: 1%;"><b></b> Redeem chips</b></h3>
									
								<div>
								    <?php 
										require 'database.php';
										$sql1="SELECT * FROM reward_total_point where user_id='".$_SESSION['user_id']."'";
										$result1 = $conn->query($sql1);
										if ($result1->num_rows > 0) { 
									?>
									<div class="bg-grey table-responsive mt10" style="color:black;padding: 3%;">
									<p style="margin-left:315px;display:inline-block;color:black">* Minimum Redeem Chips Limit Is 100/-</p>								    
									<p style="margin-left:315px;	color:black"> * You Can Redeem chips Upto
									<?php
									
									           while($row1 = $result1->fetch_assoc()){
            						               
            									    echo $db_reward_points = $row1['reward_points'].'<input type="hidden" id="balance" value="'.$row1['reward_points'].'">';
            									    
            									}
            							} 
            						?>
            						From Your Account</p>	
											
										<div style=" display: inline-flex; width: 100%;color:black"">
											 	<!--<table class="table table-bordered table-hover" style="width:47%;color:black;border:1px solid;">
											   <tr> <th style="font-size: 15px;;">Redeem chips</th> <th>Rs</th></tr> 
											<tr><td style="padding: 0;text-align: initial;"> 100</td> <td> Rs.3</td>   </tr> 
											<tr><td style="padding: 0;text-align: initial;"> 300</td> <td>  Rs.10</td>  </tr>
											<tr><td style="padding: 0;text-align: initial;"> 600</td> <td> Rs.20</td>  </tr> 
											<tr><td style="padding: 0;text-align: initial;"> 1500</td><td> Rs.50</td>  </tr>
											<tr><td style="padding: 0;text-align: initial;"> 2000</td><td> Rs.100</td>  </tr>
											<tr><td style="padding: 0;text-align: initial;"> 4000</td><td> Rs.200</td> </tr>
											<tr><td style="padding: 0;text-align: initial;"> 8000</td><td> Rs.500</td> </tr>
												</table>-->
												<div style="width:80%">
							
										<label style="color:black;">Enter Chips :</label>
										
										<input type="number" id="amount"name="amount" min="100"  required />
											<center><span id="err_msg"  style=" color: black;margin-left: 14px;"></span></center>
									
										<div class="text-center"><button class="btn btn-default" name="btnSubmit"  onclick="submit();"style="margin:25px;color:white;">Submit</button></div>
		
									</div><div>
									</div>
									</div>
									
								<!--	<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
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
											$sql1="select * from withdraw_request where user_id='".$_SESSION['user_id']."' order by transaction_id";
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
													<td><?php echo $row1['updated_on'];?></td><?php if($row1['status'] == 'Pending') {?>
													<td><button class="btn btn-primary btn-xs" name="flowback" >Flowback</button></td>													
													<?php } else {?>
													<td><?php echo $row1['status'];?></td>
													<td><button class="btn btn-primary btn-xs" style="display:none;">Flowback</button></td>
													<?php } ?>
													<td></td>	
													</tr>
													</form>
													<?php 
												 $i++;			
												}
											}
										?>
										</tbody>
									</table>-->
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
	

      
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		});
 
             	
		/*onchange="amount_check(this.value);"function amount_check(a){
		    var amount=a;
		    var balance=$('#balance').val(); 
		  
		    
		    
		    if((amount < '100') || ( amount > balance )){
		    
		      alert(amount+'=='+balance);
                    $('#err_msg').append("Enter valid amount !!!!.");
                    setTimeout(function(){ $('#err_msg').empty("");	}	, 3000); 
		   
		    }else{
		        
		    }
		    
		}*/
			function submit(){
		 var amount=parseInt($('#amount').val()); 
		  var balance=parseInt($('#balance').val()); 
		  
		  
		  
	
		  /* if((amount !='100') && ( amount !=300 )&&(amount !=600) && (amount !=1500) && (amount !=2000 ) && (amount !=4000) && (amount !=8000) && (amount !="") ){
		      	$('#err_msg').append("Enter valid amount !!!!.");
				
						
					setTimeout(function(){
					    
					    
					    $('#err_msg').empty("");
					    
					    
					}
					, 3000);  
		 
		    }else*/
		    
		     if((amount < 100) || ( amount > balance ) || (!Number.isInteger(amount))){
		    
		     // alert(amount+'=='+balance);
                    $('#err_msg').append("Enter valid amount !!!!.");
                    setTimeout(function(){ $('#err_msg').empty("");	}	, 3000); 
                    $('#amount').val('');
		   
		    }else{
		    
		        if(amount!=""){
		           
                var answer = confirm('Are you sure you want to Redeed  Chips?');
                if (answer)
                {
                  $.post("redeem_db.php",
                			{
                				amount:amount
                			},
                			function(data, status){
                				if(data == 1)
                				{
                				$('#err_msg').append("Your Redeem chips successfully !!!.");
                				
						
            					setTimeout(function(){
            					    
            					    
            					    $('#err_msg').empty("");
            					   window.location=('redeem-chips.php');  
            					    
            					}
            					, 3000);
            				}
            				 else if(data == 2)
            				{
            					$('#err_msg').append("Enter valid amount !!!!.");
            				
            						
            					setTimeout(function(){
            					    
            					    
            					    $('#err_msg').empty("");
            					    
            					    window.location=('redeem-chips.php');    
            					}
            					, 3000);
            				} else 
            				{
            					$('#err_msg').append(" Error !!!!.");
            				
            						
            					setTimeout(function(){
            					    
            					    
            					    $('#err_msg').empty("");
            					     window.location=('redeem-chips.php');   
            					    
            					}
            					, 3000);
            				} 
            			});
}
else
{
  //console.log('cancel');
    window.location=('redeem-chips.php');  
}
		    }else{
		            	$('#err_msg').append("Enter valid amount !!!!.");
				
						
					setTimeout(function(){
					    
					    
					    $('#err_msg').empty("");
					    
					    
					}
					, 3000); 
		    }
		        
		    }
		 
		}
	</script>
</html>
<?php } ?>