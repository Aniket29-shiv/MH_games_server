<?php
session_start();
 
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
		$user_id = $row['user_id'];
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
		$first_name = $row['first_name'];
		$middle_name = $row['middle_name'];
		$last_name = $row['last_name'];
		$email = $row['email'];
		 //$disabled_email = $email!='' ? "disabled='disabled'" : "";
		$mobile_no = $row['mobile_no'];
	$pan_card_no = $row['pan_card_no'];
	}
}
else {
echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
header("Location:index.php");
}


$sql1 = "SELECT * FROM `user_kyc_details`  where username = '".$loggeduser."'";

$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
	while($row1 = $result1->fetch_assoc())
	{
		$email_id = $row1['email'];
		$mail_status = $row1['email_status'];
		
		$mob = $row1['mobile_no'];
		$mob_status = $row1['mobile_status'];
		
	$id_proof = $row1['id_proof'];
		$id_proof_status = $row1['id_proof_status'];
		
	$kyc_pan = $row1['pan_no'];
 	$pan_status = $row1['pan_status'];
		
	$kyc_pan_url = $row1['pan_card_url'];
	$kyc_idproof_url = $row1['id_proof_url'];
		
	
	} 
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
							<h5 class="color-white">Free Money :</h5>
							<h4><b><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?></b></h4>
							<h5 class="color-white">Real Money :</h5>
							<h4><b><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></</b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
				<hr>
				<div class="row kyc-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-8">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<h3 class="color-white text-center mt20"><b>Know Your Customer</b></h3>
								<div class="bg-grey mt30">
									<h5 class="text-center mb0"><b>Your KYC Status</b></h5>
								<span id="update_success" style="display: none;margin-left: 1%; color: green;text-align:center">Your KYC documents has been updated successfully.</span>
									<span id="otp_success" style="display: none;margin-left: 1%; color: green;text-align:center">OTP sent successfully to Your Mobile Number.</span>
										<span id="mobile_success" style="display: none;margin-left: 1%; color: green;text-align:center">Your successfully Verified.</span>
									<span id="email_sent" style="display: none;margin-left: 1%; color: green;text-align:center"> Email with  Activation link Sent to Your Registerd Email successfully.</span>
								<span id="update_failure" style="display: none;margin-left: 1%; color: red;text-align:center">Something went wrong,kyc update failed.</span>
				
									<hr class="mt0">
									<div class="table-responsive">
								
										<table class="table table-bordered">
											<thead>
												<tr class="bg-info" align="center">
													<th>Information</th>
													<th>Details</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
														<tr>
														    	<input type="hidden" autocomplete="off" value="<?php echo $userid;?>"name="user" id="user">
														<input type="hidden" name="hidden_email" id="hidden_email" value="<?php if($email_id !=''){  echo $email_id; }?>">
															<td>Email ID</td>
															<td>
															<?php if($email_id==''){?>
																<input type="text" autocomplete="off" value=""name="user_email" required>
															<?php }else {?>
															<input type="text"  name="user_email" value="<?php echo $email_id;?>" disabled>
															<?php }?>
															</td>
															<td><label>
															<?php 
															echo $mail_status;?></label></td>
															<td>
															<?php if($mail_status== 'Verified'){ ?>
																<button class="btn btn-default" name="email_verify" type="submit"disabled>Verify</button>
																<?php } else{ ?>
																<input type="hidden" autocomplete="off" value="email_verify"name="email_verify" >
																<button class="btn btn-default" name="email_verify" value="email_verify" id="email_verify" onclick="email_verify();" >Verify</button>
																<?php }?>
															</td>
														
														</tr>
														
															<tr>
														<input type="hidden" name="hidden_mobile" id="hidden_mobile" value="<?php if($mob !=''){  echo $mob; }?>">
															<td>Mobile Number</td>
															<td>
															<?php if($mob ==''){?>
																<input type="text" name="mobile_no" id="mobile_no" value="" maxlength="10"required>
															<?php }else{?>
															<input type="text"  maxlength="10" name="mobile_no" id="mobile_no" value="<?php echo $mob;?>" disabled>
															<?php }?>
															</td>
															<td><label><?php echo $mob_status; ?></label></td>
															<td>
															<?php if($mob_status== 'Verified'){ ?>
																<button class="btn btn-default"name="mob_verify" type="submit"disabled>Verify</button>
															<?php }else {?>
															    <button class="btn btn-default"  id="otp_bt"onclick="mob(this);">Get Otp</button>
															    <label id="otpmsg" style="color:Green;"></label>
															
															 <label id="otpapend"></label>
															<?php }?>
															</td>
														</tr>
													
													
														<form action="upload.php" method="post" enctype="multipart/form-data">
															<tr>
													<td>ID Proof</td>
													<td>
														<select id="kyc_id_proof" name="kyc_id_proof"  required
													<?php if(($result1->num_rows > 0) && $id_proof!='' ) {?> disabled <?php } ?>
														>
													
															<option value="None">Please select an option</option>
															<option <?php if($id_proof=='Aadhaar Card'){?> selected = "true" <?php } ?> value="Aadhaar Card">Aadhaar Card</option>
															<option <?php if( $id_proof=='Ration Card'){?> selected = "true" <?php } ?> value="Ration Card">Ration Card</option>
															<option <?php if( $id_proof=='Voter ID'){?> selected = "true" <?php } ?> value="Voter ID">Voter ID</option>
															<option <?php if($id_proof=='Passport'){?> selected = "true" <?php } ?> value="Passport">Passport</option>
															<option <?php if( $id_proof=='Driving Licence'){?> selected = "true" <?php } ?> value="Driving Licence">Driving License</option>
														</select>
														<span id="id_proof_alert_msg" style="color: red;margin-left: 10px;"></span>
													</td>
													<td><label><?php if(($result1->num_rows > 0) &&$id_proof_status!='') {echo $id_proof_status;} ?></label></td> 
													<td>
														<div class="fileUpload">
														    
														      <?php if($kyc_idproof_url!='') { ?>
														      <img src="<?php echo $kyc_idproof_url;?>" style="width:100px;height:100px">
														      <?php   }else{?>
															<span>Upload</span>
															<form id="fileinfo" enctype="multipart/form-data" method="post" name="fileinfo">
															<input id="upload_id_proof" type="file" name="file"  class="upload" <?php if(($result1->num_rows > 0) && $kyc_idproof_url!='') { ?> disabled <?php } ?>  required />
																<?php	}?>
															</form>
															<img id="giphy" src='images/WaitCover.gif' width="50px" height="50px" alt='loading' />
															<h5 id="file_msg" style="color: red;margin-left: 10px;"></h5>
															<!--<input id="uploadBTN" type="button" value="Stash the file!"></input>-->
															<div id="output"></div>
														</div>
													</td>
												</tr>
														
														<tr>
													<td>PAN</td>
													<td>
													<input name="kyc_pan" id="kyc_pan" value="<?php if(($result1->num_rows > 0) && $kyc_pan!='') {echo $kyc_pan;} else if($pan_card_no!='') { echo $pan_card_no;}?>"  <?php if(($result1->num_rows > 0) &&  $kyc_pan!='' || $pan_card_no!='') { ?> disabled <?php } ?> type="text"pattern=".{10,10}" required title="10 Alphanumeric characters with 5 character 4  digit 1 character"   placeholder="PAN No" required >
													<span id="pan_alert_msg" style="color: red;margin-left: 10px;"></span>
													</td>
													<td><label><?php if(($result1->num_rows > 0) &&$pan_status!='') {echo $pan_status;} ?></label></td>
													<td>
														<div class="fileUpload">
														
															<form id="fileinfo1" enctype="multipart/form-data" method="post" name="fileinfo1">
														        <?php if($kyc_pan_url!='') { ?>
															    <img src="<?php echo $kyc_pan_url;?>" style="width:100px;height:100px">
															 <?php   }else{?>
															    	<span>Upload</span>
															<input id="upload_pan" type="file" name="upload_pan"  class="upload" <?php if(($result1->num_rows > 0) && $kyc_pan_url!='') { ?> disabled <?php } ?>required />
															
														<?php	}?>
															</form>
																<img id="giphy1" src='images/WaitCover.gif' width="50px" height="50px" alt='loading' />
																<h5 id="upload_pan_msg" style="color: red;margin-left: 10px;"></h5>
															<div id="output1"></div>
														</div>
													</td>
												</tr>
														
													</tbody>
										</table>
									
										<input type="hidden"  name="pan_file" id="pan_file" >
										<input type="hidden"  name="id_proof_file" id="id_proof_file" >
										<input type="hidden"  name="kyc_pan" id="kyc_pan" value="<?php echo $kyc_pan; ?>">
										<input type="hidden"  name="usernm" id="usernm" value="<?php echo $loggeduser; ?>">
										<input type="hidden"  name="userid" id="userid" value="<?php if($user_id!='') echo $user_id; ?>">
										<input type="hidden" name="user_email" id="user_email" value="<?php if($email!='') echo $email; ?>">
										<input type="hidden"  name="user_mobile" id="user_mobile" value="<?php if($mobile_no!='') echo $mobile_no; ?>">
										<!--<input type="hidden"  name="email_status" id="email_status" value="<?php if(($result1->num_rows > 0) && $email_status!='') {echo $email_status;}?>">
										<input type="hidden"  name="mobile_status" id="mobile_status" value="<?php if(($result1->num_rows > 0) && $mobile_status  !='') {echo $mobile_status  ;}?>">
										<input type="hidden"  name="id_proof_status" id="id_proof_status" value="<?php if(($result1->num_rows > 0) && $id_proof_status !='') {echo $id_proof_status ;}?>">
										<input type="hidden"  name="pan_status" id="pan_status" value="<?php if(($result1->num_rows > 0) && $pan_status!='') {echo $pan_status;}?>">-->
										
										<div class="pull-right">
										    
										
										     
									 <button class="btn" name="save" value="save" onclick="save_data()" style="margin: 0px 26px 26px 0px;">Save</button> 
										
											
										</div>
								
									</div>
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
	  $("#giphy").hide(); 
		    
		  $("#giphy1").hide(); 	    
		});
		function email_verify() {
		 // alert();
		  	var usernm = $("#usernm").val();
	    	var user_email = $("#user_email").val();
	    		var userid = $("#userid").val();
			$.post("save_user_email.php",
			{
				usernm:usernm,
				user_email:user_email,
				userid:userid,
			},
			function(data, status){
				{ 
				    if(data == 3){
					$('#email_sent').fadeIn().delay(45000).fadeOut();
						var count = 10;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('update-kyc.php');							}
							}, 1000);
					}
					else if(data == 2)
					{
						$('#update_failure').fadeIn().delay(25000).fadeOut();
					}
			}
		  
		});
		    
		}
		
		
		function save_data() {
		 // alert();
		  	var usernm = $("#usernm").val();
	    	var user_email = $("#user_email").val();
	    		var kyc_pan = $("#kyc_pan").val();
	    	var pan_file = $("#pan_file").val();
	    		var upload_id_proof = $("#upload_id_proof").val();
	    		var upload_pan = $("#upload_pan").val();	
	    		var output1 = $("#output1").html();
	    		var output = $("#output").html();
			//	alert(upload_pan+""+output);
			
					var id_proof_file = $("#id_proof_file").val();
	    			var  id_proof = $("#kyc_id_proof").val();
	    			//alert(id_proof);
			if(id_proof == 'None' || id_proof == '')
			{
				 $("#id_proof_alert_msg").text('Please Select anyone ID Proof.');
				
			}else if(output == '' && upload_id_proof == '')
				{
					 $("#file_msg").text('Please Select upload PAN ID Proof.');
				
				}
			else if(kyc_pan == 'None' || kyc_pan == '')
				{
					 $("#pan_alert_msg").text('Please Enter Valid PAN no first.');
					
				}
					else if(output1 == '' && upload_pan == '')
				{
					 $("#upload_pan_msg").text('Please Select upload PAN File.');
				
				}
			else
			{
				$("#id_proof_alert_msg").text('');
				$("#pan_alert_msg").text('');
			
				
				
				prepare_save();
			}
	    				
	    }
	    
	    
	    function mob()
{
    
  var mobile= $('#mobile_no').val();
    var user= $('#userid').val();
      $.post("send-otp.php?mobile="+mobile+"&user="+user, function( data ) 
			  {
				
					if(data == 1)
				{
				   // alert(data);
				    
				    $('#otp_bt').css("display", "none");
					$('#otpmsg').append("Opt Sent On Mobile Number.");
				
						
					setTimeout(function(){
					    
					    
					    $('#otpmsg').empty("");
					    
					    
					}
					, 3000);
					var a="";
					
					$('#otpapend').append('<input type="number" name="otp" id="otp_val" value=""> <button class="btn" name="save" onclick="verify_otp();">Verify</button>');
		
				}
				 else 
				{
		//	$('#otp_bt').css("display", "Block");
					$('#otpmsg').append("Error !!!!.");
				
						
					setTimeout(function(){
					    
					    
					    $('#otpmsg').empty("");
					    
					    
					}
					, 3000);
				
				} 
			   });
    
	
    
}

function verify_otp(){
    // alert();
  var otp_val=$('#otp_val').val();
  	 var user= $('#userid').val();
  	 
  	
  	  $.post("send-otp.php?otp_val="+otp_val+"&user="+user, function( data ) 
			  {
				
					if(data == 1)
				{
				   // alert(data);
				    
				    $('#otp_bt').css("display", "none");
					$('#otpmsg').append(" Mobile Number Verified.");
				
						
					setTimeout(function(){
					    
					    
					    $('#otpmsg').empty("");
					  	 $('#otpapend').css("display", "none");  
					    window.location=('update-kyc.php'); 
					}
					, 4000);
				
	
		 
		 
				}
				 else 
				{
			$('#otp_bt').css("color", "red");
					$('#otpmsg').append("Error !!!!.");
				
						
					setTimeout(function(){
					    
					    
					    $('#otpmsg').empty("");
					    
					    
					}
					, 3000);
				
				} 
			   });
    
  	
}
	    function prepare_save()
			{
					var output1 = $("#output1").html();
				 	var usernm = $("#usernm").val();
	    	var user_email = $("#user_email").val();
	    		var kyc_pan = $("#kyc_pan").val();
	    	var pan_file = $("#pan_file").val();
	    				var  id_proof = $("#kyc_id_proof").val();
				//alert(pan_no);
	    			var id_proof_file = $("#id_proof_file").val();
	    			//	alert(id_proof_file);
	    			
			$.post("save_user_kyc.php",
			{
				usernm:usernm,
				user_email:user_email,
				kyc_pan:kyc_pan,
				id_proof_file:id_proof_file,
				pan_file:pan_file,
				id_proof:id_proof
				
			},
			function(data, status){
				{ 
				    if(data == 1){
					$('#update_success').fadeIn().delay(45000).fadeOut();
						var count = 10;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('update-kyc.php');							}
							}, 1000);
					}
					else if(data == 2)
					{
						$('#update_failure').fadeIn().delay(25000).fadeOut();
					}
			}
		  
		});
	    		}  
	
		$(function(){
		      
		
		    
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		  var files,files1;
		
		 $("#kyc_id_proof").change(function(e)
		{
		    	var  id_proof = $("#kyc_id_proof").val();
			//alert(id_proof);
			if(id_proof == 'None' || id_proof == '')
			{
				 $("#id_proof_alert_msg").text('Please Select anyone ID Proof.');
			
			}
			else
			{   	$("#file_msg").text('');
				$("#id_proof_alert_msg").text('');
			//	prepareUpload(e);
			}
		    
		});
		 //$("#upload_id_proof").on('change', prepareUpload);
		
		 $("#upload_id_proof").change(function(e)
		{
		
			var  id_proof = $("#kyc_id_proof").val();
			//alert(id_proof);
			if(id_proof == 'None' || id_proof == '')
			{
				 $("#id_proof_alert_msg").text('Please Select anyone ID Proof.');
				 e.preventDefault();
			}
			else
			{   	$("#file_msg").text('');
				$("#id_proof_alert_msg").text('');
				prepareUpload(e);
			}
		}); 
			function prepareUpload(event)
			{
			   $("#giphy").show(); 
     
			  files = event.target.files;
			  var data = new FormData();
				$.each(files, function(key, value)
				{
					data.append(key, value);
				})
				var fd = new FormData($("#fileinfo")[0]);
				$.ajax({
					url: 'upload.php?files',  
					type: 'POST',
					data: data,
					success:function(data){
					     $("#giphy").hide(); 
						$('#output').html(data);
						$('#id_proof_file').val(data);
					},
					cache: false,
					contentType: false,
					processData: false
				});
			}

			//$("#upload_pan").on('change', prepareUploadPAN);
			 $("#upload_pan").change(function(e)
			{
			 	var  pan_no = $("#kyc_pan").val();
				//alert(pan_no);
				if(pan_no == 'None' || pan_no == '')
				{
					 $("#pan_alert_msg").text('Please Enter Valid PAN no first.');
					 e.preventDefault();
				}
				else
				{
				    	$("#upload_pan_msg").text('');
					$("#pan_alert_msg").text('');
					prepareUploadPAN(e);
				}
			}); 
		
			function prepareUploadPAN(event)
			{
			    
			      $("#giphy1").show(); 
			  files = event.target.files;
			  var data = new FormData();
				$.each(files, function(key, value)
				{
					data.append(key, value);
				})
				var fd = new FormData($("#fileinfo1")[0]);
				$.ajax({
					url: 'upload.php?files',  
					type: 'POST',
					data: data,
					success:function(data){
					      $("#giphy1").hide(); 
						$('#output1').html(data);
						$('#pan_file').val(data);						  
					},
					cache: false,
					contentType: false,
					processData: false
				});
			}
			
			 $("#kyc_pan").blur(function()
			
			{
			    
			    	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
				 var txtpan = $("#kyc_pan").val(); 
		
			   
			
				 
				 
				 if (txtpan.length != 10||txtpan.length >= 10) { 
				  if(!txtpan.match(regExp) )
				  { 
				      	 
				   $("#pan_alert_msg").text('Enter Valid PAN Number.');
				  }
				  else if(txtpan.length != 10){
				      	  
				     
				        $("#pan_alert_msg").text('Enter Valid PAN Number.');
				      
				  }else{
				       $("#pan_alert_msg").text('');
				  }
				 } else{
				     
				      $("#pan_alert_msg").text('');
				 }
				     
			
				 
			});
			
		

		  /* $('#uploadBTN').on('click', function(){ 
		  
		}); */

	
	
		var frm1 = $('#form_user_kyc');
		frm1.submit(function (e) {
			e.preventDefault();
			$.ajax({
				type: frm1.attr('method'),
				url: frm1.attr('action'),
				data: frm1.serialize(),
				success: function (data) {
				if(data == 1)
					{ 
					$('#update_success').fadeIn().delay(45000).fadeOut();
						var count = 10;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('update-kyc.php');							}
							}, 1000);
					}
					else if(data == 2)
					{
						$('#update_failure').fadeIn().delay(25000).fadeOut();
					}
					else  if(data == 3)
					{
						$('#email_sent').fadeIn().delay(45000).fadeOut();
						var count = 10;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('update-kyc.php');							}
							}, 1000);
					}
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		});
		
			
	</script>
</html>
<?php } ?>