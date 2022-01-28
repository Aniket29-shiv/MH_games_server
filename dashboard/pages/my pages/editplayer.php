<?php
	include('lock.php');
	include("config.php");
	include('include/playeredit.php');
		$status = '';
		$status1 = '';
	if($_GET){
	  $status = $_GET['status'];
	  $status1 = $_GET['status1'];
	}
		


?>

<!DOCTYPE html>
<html>
	 <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rummysahara Admin Panel</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link href="../../css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    
</head>

	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				<div id="header"></div>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<section class="sidebar">
					<div class="sidebar-menu" data-widget="tree" id="sidebar-menu"></div>
				</section>
			</aside>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content">
					<div class="row">
					

						<div class="col-md-12  col-xs-12">
							<div class="box-header with-border">
								<h3 class="box-title">Update Player</h3><a href="player-details.php" class="btn btn-primary" style="margin-left:10px;">Player List</a>
							</div>
							<div class="box">
								<!-- /.box-header -->
									<div class="box-header">
									    <h4>Player Profile</h4><hr style="border:0.5px solid;">
									    </div>
								<div class="box-body">
									<form role="form"  method="post" enctype="multipart/form-data">
										<div class="box-body">
										<div class="col-md-12 col-xs-12">	
                                      	<div class="form-group">
												<label style="width:49%">First Name</label> 	<label style="width:49%">Middal Name</label><br />
												<input type="text" name="first_name" value="<?php echo $first_name;?>" Placeholder="First name" required  id="table_name" style="padding:5px 0px; width:49%">
												<input type="text" name="middle_name" value="<?php echo $middle_name;?>" Placeholder="Middal name" required  id="table_name" style="padding:5px 0px; width:49%">
												
											</div>
											</div>
											
											
											
											<div class="col-md-12 col-xs-12">	
                                      	<div class="form-group">
												 <label style="width:49%">Last Name</label> <label style="width:49%">Mobile Number</label> 	<br />
												 <input type="text" name="last_name" value="<?php echo $last_name;?>" Placeholder="Last name"  required  id="table_name" style="padding:5px 0px; width:49%">
                                                <input type="text" name="mobile_no" value="<?php echo $mobile_no;?>" Placeholder="Mobile Number" required  id="table_name" style="padding:5px 0px; width:49%">
											</div>
											</div>
										
											<div class="col-md-12 col-xs-12">	
                                      	<div class="form-group">
												<label style="width:49%">Email ID</label> <label style="width:49%">Username</label><br />
											
												<input type="text" name="email" value="<?php echo $email;?>" Placeholder="Email ID" required  id="table_name" style="padding:5px 0px; width:49%">
												<input type="text" name="username" value="<?php echo $username;?>" Placeholder="User Name"  required  id="table_name" style="padding:5px 0px; width:49%">
											</div>
											</div>
											<div class="col-md-12 col-xs-12">	
                                      	<div class="form-group">
												<label style="width:30%">Address</label><br />
											<textarea class="form-control"  required name="address" style="width:98%"><?php echo $address;?></textarea>
											</div>
											</div>
											
                                                    <div class="col-md-12 col-xs-12">	
                                                    <div class="form-group">
                                                    <label style="width:49%">State</label><label style="width:49%">City</label> <br />
                                                    <select name="state" required=""  style="padding:7px; width:49%">
                                                    <option value="">Please select State</option>
                                                    <option value="Andaman and Nicobar Islands"  <?php if($state == 'Andaman and Nicobar Islands'){ echo 'selected="selected"';}?>>Andaman and Nicobar Islands</option>
                                                    <option value="Andhra Pradesh" <?php if($state == 'Andhra Pradesh'){ echo 'selected="selected"';}?>>Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh" <?php if($state == 'Arunachal Pradesh'){ echo 'selected="selected"';}?>>Arunachal Pradesh</option>
                                                    <option value="Assam" <?php if($state == 'Assam'){ echo 'selected="selected"';}?>>Assam</option>
                                                    <option value="Bihar" <?php if($state == 'Bihar'){ echo 'selected="selected"';}?>>Bihar</option>
                                                    <option value="Chandigarh" <?php if($state == 'Chandigarh'){ echo 'selected="selected"';}?>>Chandigarh</option>
                                                    <option value="Chhattisgarh" <?php if($state == 'Chhattisgarh'){ echo 'selected="selected"';}?>>Chhattisgarh</option>
                                                    <option value="Dadra and Nagar Haveli" <?php if($state == 'Dadra and Nagar Haveli'){ echo 'selected="selected"';}?>>Dadra and Nagar Haveli</option>
                                                    <option value="Daman and Diu" <?php if($state == 'Daman and Diu'){ echo 'selected="selected"';}?>>Daman and Diu</option>
                                                    <option value="Delhi" <?php if($state == 'Delhi'){ echo 'selected="selected"';}?>>Delhi</option>
                                                    <option value="Goa" <?php if($state == 'Goa'){ echo 'selected="selected"';}?>>Goa</option>
                                                    <option value="Gujarat" <?php if($state == 'Gujarat'){ echo 'selected="selected"';}?>>Gujarat</option>
                                                    <option value="Haryana" <?php if($state == 'Haryana'){ echo 'selected="selected"';}?>>Haryana</option>
                                                    <option value="Himachal Pradesh" <?php if($state == 'Himachal Pradesh'){ echo 'selected="selected"';}?>>Himachal Pradesh</option>
                                                    <option value="Jammu and Kashmir" <?php if($state == 'Jammu and Kashmir'){ echo 'selected="selected"';}?>>Jammu and Kashmir</option>
                                                    <option value="Jharkhand" <?php if($state == 'Jharkhand'){ echo 'selected="selected"';}?>>Jharkhand</option>
                                                    <option value="Karnataka" <?php if($state == 'Karnataka'){ echo 'selected="selected"';}?>>Karnataka</option>
                                                    <option value="Kerala" <?php if($state == 'Kerala'){ echo 'selected="selected"';}?>>Kerala</option>
                                                    <option value="Lakshadweep" <?php if($state == 'Lakshadweep'){ echo 'selected="selected"';}?>>Lakshadweep</option>
                                                    <option value="Madhya Pradesh" <?php if($state == 'Madhya Pradesh'){ echo 'selected="selected"';}?>>Madhya Pradesh</option>
                                                    <option value="Maharashtra" <?php if($state == 'Maharashtra'){ echo 'selected="selected"';}?>>Maharashtra</option>
                                                    <option value="Manipur" <?php if($state == 'Manipur'){ echo 'selected="selected"';}?>>Manipur</option>
                                                    <option value="Meghalaya" <?php if($state == 'Meghalaya'){ echo 'selected="selected"';}?>>Meghalaya</option>
                                                    <option value="Mizoram" <?php if($state == 'Mizoram'){ echo 'selected="selected"';}?>>Mizoram</option>
                                                    <option value="Nagaland" <?php if($state == 'Nagaland'){ echo 'selected="selected"';}?>>Nagaland</option>
                                                    <option value="Orissa" <?php if($state == 'Orissa'){ echo 'selected="selected"';}?>>Orissa</option>
                                                    <option value="Puducherry" <?php if($state == 'Puducherry'){ echo 'selected="selected"';}?>>Puducherry</option>
                                                    <option value="Punjab" <?php if($state == 'Punjab'){ echo 'selected="selected"';}?>>Punjab</option>
                                                    <option value="Rajasthan" <?php if($state == 'Rajasthan'){ echo 'selected="selected"';}?>>Rajasthan</option>
                                                    <option value="Sikkim" <?php if($state == 'Sikkim'){ echo 'selected="selected"';}?>>Sikkim</option>
                                                    <option value="Tamil Nadu"  <?php if($state == 'Tamil Nadu'){ echo 'selected="selected"';}?>>Tamil Nadu</option>
                                                    <option value="Telangana" <?php if($state == 'Telangana'){ echo 'selected="selected"';}?>>Telangana</option>
                                                    <option value="Tripura" <?php if($state == 'Tripura'){ echo 'selected="selected"';}?>>Tripura</option>
                                                    <option value="Uttarakhand" <?php if($state == 'Uttarakhand'){ echo 'selected="selected"';}?>>Uttarakhand</option>
                                                    <option value="Uttar Pradesh" <?php if($state == 'Uttar Pradesh'){ echo 'selected="selected"';}?>>Uttar Pradesh</option>
                                                    <option value="West Bengal" <?php if($state == 'West Bengal'){ echo 'selected="selected"';}?>>West Bengal</option>
                                                    </select>
                                                    <input type="text" name="city" value="<?php echo $city;?>" Placeholder="City" required  id="table_name" style="padding:5px 0px; width:49%">
                                                   
                                                    </div>
                                                    </div>
                                                    
                                                    
                                                     <div class="col-md-12 col-xs-12">	
                                                    <div class="form-group">
                                                    <label style="width:49%">Pincode</label><label style="width:49%">Gender</label><br />
                                                   
                                                    
                                                    <input type="text" name="pincode" value="<?php echo $pincode;?>" Placeholder="Pincode"  required  id="table_name" style="padding:5px 0px; width:49%">
                                                    <select name="gender" required=""  style="padding:7px; width:49%">
                                                        <option value="">Select Gender</option>
                                                        <option Value="Male" <?php if($gender == 'Male'){ echo 'selected="selected"';}?>>Male</option>
                                                         <option Value="Female" <?php if($gender == 'Female'){ echo 'selected="selected"';}?>>Female</option>
                                                        </select>
                                                    </div>
                                                    </div>
											
												 
										</div>
									

								

									 <div class="box-footer" style="text-align: right;">
									     <input type="hidden" name="eid" value="<?php echo $eid;?>">
									   
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>			
									
										
										<!-- <div class="box-footer text-center">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>/.box-body -->
										
										
										
                                        <?php  if($status==1){ ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> Record Saved.....!
                                        </div>
                                         <?php } if($status == 2) { ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> Record Updated.....!
                                        </div>
                                        
                                       
                                        
                                        <?php } if($message != '') { ?>
                                        
                                        <div class="alert alert-danger alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
                                        </div>
                                        <?php } ?>
									</form>
								</div>
								<div class="box-header">
									   <hr style="border:0.5px solid;"> <h4>Player KYC Update</h4><hr style="border:0.5px solid;">
									    </div>
								<div class="box-body">
									<form role="form"  method="post" enctype="multipart/form-data">
										<div class="box-body">
										    
                                    <div class="col-md-12 col-xs-12">	
                                        <div class="form-group">
                                            <label style="width:49%">Email ID</label> 	<label style="width:49%">Email Status</label><br />
                                            <input type="text" name="email" value="<?php echo $email;?>" Placeholder="Email ID" required  id="table_name" style="padding:5px 0px; width:49%">
                                            <select  name="estatus"  style="padding:5px 0px; width:49%">
                                            
                                            <option value="None">Please Select Status</option>
                                            <option value="Not Verified"  <?php if($estatus == 'Not Verified'){ echo 'selected="selected"';}?>>Not Verified</option>
                                            <option value="Verified"  <?php if($estatus == 'Verified'){ echo 'selected="selected"';}?>>Verified</option>
                                            
                                            </select>
                                        </div>
                                    </div>
											
                                     
                                        <div class="col-md-12 col-xs-12">	
                                        <div class="form-group">
                                        <label style="width:49%">Mobile Number</label> 	<label style="width:49%">Mobile Status</label><br />
                                        <input type="text" name="mobile" value="<?php echo $mobile_no;?>" Placeholder="Mobile Number" required  id="table_name" style="padding:5px 0px; width:49%">
                                        <select  name="mstatus"  style="padding:5px 0px; width:49%">
                                        
                                        <option value="None">Please Select Status</option>
                                        <option value="Not Verified"  <?php if($mstatus == 'Not Verified'){ echo 'selected="selected"';}?>>Not Verified</option>
                                        <option value="Verified"  <?php if($mstatus == 'Verified'){ echo 'selected="selected"';}?>>Verified</option>
                                        
                                        </select>
                                        </div>
                                        </div>
											
										<div class="col-md-12 col-xs-12">	
                                      	<div class="form-group">
												<label style="width:49%">ID Proof</label> 	<label style="width:49%">ID Proof Status</label><br />
											<select  name="idproof" style="padding:5px 0px; width:49%">
													
															<option value="None">Please select an option</option>
															<option value="Aadhaar Card" <?php if($idproof == 'Aadhaar Card'){ echo 'selected="selected"';}?>>Aadhaar Card</option>
															<option value="Ration Card" <?php if($idproof == 'Ration Card'){ echo 'selected="selected"';}?>>Ration Card</option>
															<option  value="Voter ID" <?php if($idproof == 'Voter ID'){ echo 'selected="selected"';}?>>Voter ID</option>
															<option value="Passport" <?php if($idproof == 'Passport'){ echo 'selected="selected"';}?>>Passport</option>
															<option value="Driving Licence" <?php if($idproof == 'Driving Licence'){ echo 'selected="selected"';}?>>Driving License</option>
														</select>
													<select  name="idstatus"  style="padding:5px 0px; width:49%">
													
															<option value="None">Please Select Status</option>
															<option value="Not Verified"  <?php if($idstatus == 'Not Verified'){ echo 'selected="selected"';}?>>Not Verified</option>
															<option value="Verified"  <?php if($idstatus == 'Verified'){ echo 'selected="selected"';}?>>Verified</option>
															
														</select>
												
											</div>
											</div>
											
                                            <div class="col-md-12 col-xs-12">	
                                            <div class="form-group">
                                            <label style="width:49%">Select Image</label><br />
                                            <input type="file" 	 tabindex="20" style="width: 15%;float: left;" name="iimage" />
                                            <?php if($idimage != ''){?>
                                               <img src="../../<?php echo $idimage;?>" style="width: 21%;">
                                            <?php }?>
                                            </div>
                                            </div>
											
											
                                            <div class="col-md-12 col-xs-12">	
                                            <div class="form-group">
                                            <label style="width:49%">PAN Card Number</label> 	<label style="width:49%">PAN Status</label><br />
                                              <input type="text" name="pan" value="<?php echo $pan;?>" Placeholder="PAN Card Number" required  id="table_name" style="padding:5px 0px; width:49%">
                                            <select id="kyc_id_proof" name="pstatus"  style="padding:5px 0px; width:49%">
                                            
                                            <option value="None">Please Select Status</option>
                                            <option value="Not Verified"  <?php if($pstatus == 'Not Verified'){ echo 'selected="selected"';}?>>Not Verified</option>
                                            <option value="Verified"  <?php if($pstatus == 'Verified'){ echo 'selected="selected"';}?>>Verified</option>
                                            
                                            </select>
                                            
                                            </div>
                                            </div>
                                            
                                            <div class="col-md-12 col-xs-12">	
                                            <div class="form-group">
                                            <label style="width:49%">Select Image</label><br />
                                            <input type="file" 	 tabindex="20" style="width: 15%;float: left;" name="pimage" />
                                            
                                            <?php if($panimage != ''){?>
                                               <img src="../../<?php echo $panimage;?>" style="width: 21%;">
                                            <?php }?>
                                            </div>
                                            </div>
										
												 
										</div>
									

								

									 <div class="box-footer" style="text-align: right;">
									     <input type="hidden" name="eid" value="<?php echo $eid;?>">
									      <input type="hidden" name="pancardimage" value="<?php echo $panimage;?>">
									       <input type="hidden" name="idproofimage" value="<?php echo $idimage;?>">
									   
											<button  name="kycSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>			
									
                                        <?php  if($status1==1){ ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> Record Saved.....!
                                        </div>
                                         <?php } if($status1 == 2) { ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> Record Updated.....!
                                        </div>
                                        
                                       
                                        
                                        <?php } if($message1 != '') { ?>
                                        
                                        <div class="alert alert-danger alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message1;?>
                                        </div>
                                        <?php } ?>
									</form>
								</div>
								<!-- /.box-body -->
							</div>
							
							<!-- /.box -->
						</div>
						
						</div>
						
				
				</section>
				<!-- /.content -->
			</div>
			<footer class="main-footer">
				<div id="footer"></div>
			</footer>
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark" id="dashboard-settings"></aside>
			<div class="control-sidebar-bg"></div>
		</div>
		<!-- ./wrapper -->
		<!-- jQuery 3 -->
		<script src="../../bower_components/jquery/dist/jquery.min.js"></script>

		<!-- Bootstrap 3.3.7 -->
		<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

		<!-- FastClick -->
		<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="../../dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="../../dist/js/demo.js"></script>

		<script src="../../js/jquery.validate.min.js"></script>
		<script src="../../js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <script>
	$(function () {	$(".textarea").wysihtml5();	});
   </script>
		<script>
		

			$('#pool_game').hide();
			$(function(){
					$("#sidebar-menu").load("sidebar-menu.html");
					$("#header").load("header.html");
					$("#footer").load("footer.html");
					$("#dashboard-settings").load("dashboard-settings.html");
				});
			
		</script>
		
		
		
	<script>
$(function(){
		
     	$(".serialno").change(function(){
	     	var changenoid = $(this).attr('data-id');
	     	var number = $(this).val();
	     
		  // alert(changenoid+'=='+number);
		
          var dataString ='addserialnumber='+changenoid+'&number='+number;
              //  alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                
                if(data == 1){
                    alert("Added sccessfully");
                }else{
                     alert("Number Alredy Use");
                }
                		
                 
                
                }
                });

		
		
		});
		
	

		
		
	
});
	</script>
	</body>
</html>
