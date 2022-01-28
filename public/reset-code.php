<?php

ob_start();
include "database.php";

	$status = '';
				$check_active=$_REQUEST['reset-code'];
					
								
				

?>
	
		<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
	
		<div class="container-fluid mt25">
		<?php if(!isset($_SESSION['logged_user'])) { ?>
			<div class="container forgot-wrapper">
				<div class="row">
					<h3 class="text-center color-white pt20">Please enter your email address Registered.</h3>
						<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
							<div class="black-bg mt30">
								<h4 class="color-white text-center">Forgot Password</h4>
							</div>
							<div class="bg-grey" style="background: black">
								<form action="" method="post">
								<?php
								if(isset($_POST["Submit"]))
									{
										$password = $_POST["password"];
										$con_password = $_POST["con_password"];
										if(empty($password))
											{
												header("Location:reset-code.php?Error=Password is required.");
												exit();
											}
											elseif(empty($con_password))
											{
												header("Location:reset-code.php?Error=Confirm password is required.");
											}
											else
											{
												
												$check_active=$_REQUEST['reset-code'];
					
								
						$sql = "SELECT user_id,reset_code FROM reset_code where reset_code='".$check_active."'  ";
									
										$result = $conn->query($sql);
								
										if($result->num_rows > 0)
										{
										$row=$result->fetch_assoc();
									$user_id=$row['user_id'];
										$new_pass=md5($password);
						 	$query_update = "update  users set `password` ='$new_pass' where `user_id`=	$user_id";
									$update_result = $conn->query($query_update);
										
									if($update_result){	
											    $query="Delete from reset_code WHERE reset_code = '".$check_active."'";
											   
											  
												$result = $conn->query($query);
								
						
									header("Location:sign-in.php?status=1");
		
												
											
											}
											else
											{
											header("Location:reset-code.php?Error=0");
											}
										}
									}
									
									}
								?>
									<?php if($_GET['success']=='1'){ ?>
										 <div class="alert alert-success alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<center>Your password reset Successfully.</center>
									  </div>
									<?php }?>
									<?php if($_GET['Error']=='0'){ ?>
										 <div class="alert alert-danger alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<center>Your password is not reset </center>
									  </div>
									<?php }?>
									
									<div class="form-group">
									<label>New Password :</label>
									<input type="password" name="password"  style="color:black" id="password-1"  placeholder="Enter New Password" autocomplete="off"/>	</div>
								<div class="form-group">	<label>Confirm Password :</label>
									<input type="password" name="con_password" onchange="check_pass(this.value);" id="password-2"style="color:black"placeholder="Email Address" autocomplete="off"/>
									<center><label style="color:red;"for="con_err" id="con_err"></label></center>
									</div>
									<div class="text-center"><button class="btn btn-default" name="Submit" value="Recover">Submit</button></div>
								
								</form>
							</div>
						</div>
				</div>
			</div>
			<?php } else { ?>
		<div class="forgot-wrapper">
				<div class="row">
				<h3 class="text-center">You have already logged as : <b style="color:red"><?php echo $_SESSION['logged_user']; ?></b>    &nbsp; Go to <a href="my-account/" style="    margin: 8% 1%;
    font-size: 22px;" >My Account </a></h3>
			</div>
		</div>
		<?php }  ?>
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


<script src="js/hideShowPassword.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script> 
   <script>if(Modernizr.input.placeholder)document.getElementsByTagName('html')[0].className+=' inputplaceholder';</script>
	<script>
	$('#password-1').hidePassword(true);
		$('#password-2').hidePassword(true);
		
		
			    function check_pass(val)
		  {
			  
			  
			var pass=$('#password-1').val();
					//alert(val+"=="+pass);
					if(pass!=val)
					{
						$( "#con_err" ).append("Confirm Password  Not Match");
						setTimeout(function(){
							$( "#con_err" ).empty( );
							$("#con_password").val("");
							$("#con_password").focus();
						}, 2000);
					}
			   
			
		  }	
</script>


