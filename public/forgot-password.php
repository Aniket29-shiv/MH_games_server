<?php 
ob_start();
include "database.php";
	//include('Classes/class.phpmailer.php');
	include 'php/Mail.php';
include 'php/Mail/mime.php' ;
include('email/sendEmail.php');
?></DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt20">
			<div class="container forgot-wrapper">
				<div class="row">
					<h3 class="text-center color-white pt20">Please enter your email address Registered.</h3>
						<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
							<div class="black-bg mt30" style="background: black">
								<h4 class="color-white text-center">Forgot Password</h4>
							</div>
							<div class="bg-grey" style="background: black">
									<form action="" method="post">
								<?php
								if(isset($_POST["forgot"]))
									{
										$email = $_POST["email"];
										
										
										if(empty($email))
											{
												header("Location:forgot-password.php?Error=Email address is required.");
												exit();
											}
											elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
											{
												header("Location:forgot-password.php?Error=Invalid email and password.");
											}
											else
											{
								$query = "SELECT * FROM `users` where `email`='".$email."'";
										
									
											$result =$conn->query($query);
										
										
									
									

										if ($result->num_rows > 0) {					$row = $result->fetch_assoc();			    
												
								$three=rand(100,999);
											$four=rand(1000,9999);
											$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
											$charactersLength = strlen($characters);
											$randomString = '';
											$length=3;
											for ($i = 0; $i < $length; $i++) {
												$randomString .= $characters[rand(0, $charactersLength - 1)];
											}
											$activattion_id=$three.$randomString.$four;					    
									// 	$encrypted=encryptIt( $activattion_id );
											
				 $sql13 = "insert into reset_code ( `user_id`, `reset_code`)values ( '".$row['user_id']."','".$activattion_id."')";
										     
										
												$conn->query($sql13);				    

	
	   $subject="Forget Password Link From  RummySahara. ";
                        $to=$email;
                         $message='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
                        <div style="background:#ffffff;padding:20px">
                        <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
                        <div style=" text-align:center;">
                        <a href="'.MAINLINK.'">
                        <img src="'.LOGO.'" style="width:150px;" />
                        </a>
                        </div>
                        </div>			  
                        <div>
                        <p style="margin:0px 0px 10px 0px">
                        <p>Dear User,</p><br />
                        
                        <p>  Click on following link to Change your account Password.</p>
                        <p style="text-align: center; margin-top: 38px;">
                        <span style=" background: #a50b0b;padding: 12px;">
                        <a href="'.$mainurl.'public/reset-code.php?reset-code='.$activattion_id.'" target="_blank" rel="noreferrer" style="color: white;">Click Here</a>
                        </span>
                        </p>
                        <p>Thank you,</p>
                        <a href="'.MAINLINK.'">
                        <p>Team RummySahara</p>
                        </a>
                        </div>
                        <div>
                        </div>
                        </div>
                        </div>';
                        ;
		if(bulkMail($to,$subject,$message)) {
                        
                        header("Location:forgot-password.php?success=1");
                        //	$message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";	
                        }
		
												
											
											}
											else
											{
											header("Location:forgot-password.php?Error=0");
											}
										}
									}
								?>
									<?php if(@$_GET['success']=='1'){ ?>
										 <div class="alert alert-success alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<center>Your password reset link send to your e-mail address.</center>
									  </div>
									<?php }?>
									<?php if(@$_GET['Error']=='0'){ ?>
										 <div class="alert alert-danger alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<center>Account not found please signup now!!</center>
									  </div>
									<?php }?>
									<label>Email Address :</label>
									<input type="email" name="email" style="color:black" placeholder="Email Address" autocomplete="off"/>
									<div class="text-right"><button class="btn btn-default" name="forgot" value="Recover">Recover</button></div>
									<a href="sign-in.php">Log In</a>
									<a href="registration.php" class="pull-right">Sign Up</a>
								</form>
							</div>
						</div>
					
				</div>
				<hr class="mt35">
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