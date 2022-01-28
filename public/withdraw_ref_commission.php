<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$message="";
 
 
 if(!isset($_SESSION['logged_user'])){ 
     
     header("Location:sign-in.php");
}else{
    $loggeduser =  $_SESSION['logged_user'];
    $user_id='';
     include 'database.php';
     include 'referral_commission_functions.php';
   

?>
</DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
<!--	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
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
								<h3 class="color-white text-center mt20"><b>My Commission Withdrawals</b></h3>
								 <div class="col-md-4 col-sm-12">
								       <div class="col-md-12" style="background: black; color: white;padding: 6px;text-align: center;">Total Commission</div>
								      <div class="col-md-12" style="background: #c4d8e8; padding: 10px; text-align: center;font-size: 19px;">Rs.<span><?php echo totalrefcommission($conn);?></span>/-</div>
								       </div>
								       <div class="col-md-4 col-sm-12">
								             <div class="col-md-12" style="background: black; color: white;padding: 6px;text-align: center;">Total Withdraw</div>
								      <div class="col-md-12" style="background: #c4d8e8; padding: 10px; text-align: center;font-size: 19px;">Rs.<span><?php echo totalrefwithdrawal($conn);?></span>/-</div>
								       </div>
								       <div class="col-md-4 col-sm-12">
								            <div class="col-md-12" style="background: black; color: white;padding: 6px;text-align: center;">Total Balance</div>
								      <div class="col-md-12" style="background: #c4d8e8; padding: 10px; text-align: center;font-size: 19px;">Rs.<span id="balamount"><?php echo balancerefcommission($conn);?></span>/-</div>
								       </div>
								<div>
								  <div class="col-md-12 col-sm-12" style="background: white;margin: 14px;padding: 2px;">
								      	<p style="margin-left:15px;display:inline-block;color:red;width:100%">* Minimum Withdraw Amount Limit Is Rs.100/-</p>
									
								      <div class="col-md-4 col-sm-12">
								          <lable>Enter amount</lable><br />
								          <input type="number" style="width:100%" min="100" id="amount" value="" placeholder="0.0" required step="0.01" />
								          </div>
								     
								      <div class="col-md-4 col-sm-12">
								          <lable>Select Type</lable><br />
								          <select class="form-control" id="ttype">
								              <option value="">Select Transaction Type</option>
								              <option value="1">Bank Transfer</option>
								              <option value="2">Account Transfer</option>
								              </select>
								          </div>
								           <div class="col-md-4 col-sm-12">
								              <button class="btn btn-default" name="btnSubmit" id="withdraw" style="margin-top:21px;color:white;">Submit</button>
								          </div>
								          <p style="margin-left:15px;display:inline-block;color:red;width:100%;text-align:center;" id="emsg"></p>
									        <p style="margin-left:15px;display:inline-block;color:green;width:100%;text-align:center;" id="smsg"></p>
									
								      </div>
								
									</div>
									<div class="col-md-12" style="background:white;height:500px;overflow:auto; margin-left: 14px;">
									<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
										<thead>
											<tr style='background-color: wheat;'>
												<th style="width:1%;text-align:center;font-size: 12px;">Sr.No</th>
												<th style="width:10%;text-align:center;font-size: 12px;">Amount</th>
												<th style="width:20%;text-align:center;font-size: 12px;">Request Date</th>
												<th style="width:20%;text-align:center;font-size: 12px;">Updation Date</th>
												<th style="width:16%;text-align:center;font-size: 12px;">Type</th>
												<th style="width:30%;text-align:center;font-size: 12px;">Status</th>
											</tr>
										</thead>
									
										<tbody>
										<?php		
										$refid =  $_SESSION['user_id'];
											$sql1="select * from withdraw_refcommission_request where user_id='".$refid."'";
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
													<td><?php echo $row1['requested_amount'];?></td>
													<td><?php echo $row1['created_on'];?></td>													
													<td><?php echo $row1['updated_on'];?></td>
													<?php if($row1['type'] == 1) {?>
													  <td>Bank Transfer</td>
												     <?php } else {?>
													    <td>Account Transfer</td>
													<?php } ?>
												<td><?php echo $row1['status'];?></td>
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
                     var amount=$('#amount').val();
                     var ttype=$('#ttype').val();
                      var balamount=parseInt($('#balamount').text());
                     //alert(amount+'===='+ttype+'===='+balamount);
                      var ch=0;
                     if(amount == '' || amount < 0){ ch=1; $('#emsg').text('Enter Valid Amount'); setTimeout(function(){ $('#emsg').text(''); }, 3000);}
                     if(ttype != 2){
                     if(amount < 100){ ch=1; $('#emsg').text('Please enter Minimum Rs.100'); setTimeout(function(){ $('#emsg').text(''); }, 3000);}
                     }
                      if(ttype == ''){ ch=1;  $('#emsg').text('PLease select Transaction Type'); setTimeout(function(){ $('#emsg').text(''); }, 3000);}
                       if(amount > balamount){ ch=1;    $('#emsg').text('Unsufficiant Fund for Withdrawal'); setTimeout(function(){ $('#emsg').text(''); }, 3000);}
                       if(ch == 0){
                			if(confirm('are you sure you want withdraw Rs.'+amount+'?')){
                			  
                                    var dataString ='withdrawrequestrefcommission='+amount+'&ttype='+ttype;
                                   // alert(dataString);
                                    $.ajax({
                                    type: "POST",
                                    url:"ajax_function.php",
                                    data: dataString,
                                    cache: false,
                                    success: function(data){
                                       // alert(data);
                                        if(data == 1){
                                         $('#smsg').text('Transaction successfull.'); 
                                         setTimeout(function(){ window.location.href=""; }, 2000);
                                        }else{
                                          $('#emsg').text(data); setTimeout(function(){ $('#emsg').text(''); }, 3000); 
                                        }
                                     
                                    
                                    }
                                    });
        
                			}else{
                			    return false;
                			}
                       }

        		});
		});
	</script>
	  
</html>
<?php 

} 
?>