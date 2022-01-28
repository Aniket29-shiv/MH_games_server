<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include('lock.php');
	include("config.php");
	
	include('Classes/class.phpmailer.php');
	include('email/sendEmail.php');
	include('include/addemails.php');
	$status = '';
	
	if($_GET){
	    
	   $status = $_GET['status'];
	  
	}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rummy Admin Panel</title>
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
					<div class="box-header text-center with-border">
						<h3 class="box-title">Email Configuration</h3>
					</div>
					<div class="col-md-8 col-md-offset-2 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<div class="box-body">
								<div class="email-config">
									<form  method="post" >
										<!--<label>Email Sender :</label>
                                        <select>
                                        <option>-- Select --</option>
                                        <option>Default</option>
                                        <option>Sendgrid</option>
                                        <option>Pepipost</option>
                                        </select>-->
										<label>Sender Email :</label>
										<input type="text" name="sender"  value="<?php echo $sender;?>" required placeholder="johnDoe1234@gmail.com" style="width:58%">
										<label>From Name :</label>
										<input type="text" name="sendfrom"  value="<?php echo $sendfrom;?>" required placeholder="John Doe" style="width:58%">
										<label>SMTP Host :</label>
										<input type="text" name="host"  value="<?php echo $host;?>" required style="width:58%">
										<label>Type of Encryption / Security :</label>
										<input type="radio" name="security" <?php if($security == 'SSL'){ echo 'checked="checked"';}?> value="SSL">SSL
										<input type="radio" name="security" <?php if($security == 'TLS'){ echo 'checked="checked"';}?> value="TLS">TLS
										<input type="radio" name="security" <?php if($security == 'None'){ echo 'checked="checked"';}?> value="None">None
										<br />
										<label>SMTP Port :</label>
										<input type="text" name="port"  value="<?php echo $port;?>" required style="width:58%">
										<label>SMTP Authentication :</label>
										<input type="radio" name="authentication"  <?php if($authentication == 'false'){ echo 'checked="checked"';}?> value="false">No
										<input type="radio" name="authentication" <?php if($authentication == 'true'){ echo 'checked="checked"';}?>  value="true">Yes
										<br>
										<label>SMTP Username :</label>
										<input type="text" name="username"  value="<?php echo $username;?>" required style="width:58%">
										<label>SMTP Password :</label>
										<input type="password" name="password"  value="<?php echo $password;?>" required style="width:58%">
										<div class="text-right" style="margin:20px 5px 0px">
											<input type="submit" name="submit" style="padding: 6px;" Value="update" class="btn btn-primary" >
                                            <a class="btn btn-primary" id="sendmail" style="padding: 6px;">Send Mail</a>
                                            <a class="btn btn-danger" style="display:none;padding: 6px;" id="cancelmail" >Cancel Mail</a>
										</div>
										<?php if($message != ''){?>
										<p style="background: red; width: 50%;text-align: center;color: white;" class="errormsg"><? echo $message;?></p>
										<?php
									    	}  
										if($message1 != ''){
										?>
										<p style="background: blue; width: 50%;text-align: center;color: white;" class="errormsg"><? echo $message1;?></p>
										<?php } ?>
									</form>
								</div>
								<div class="email-config" id="maildiv" style="display:none">
								
										<label style="width:25%">To :</label><br />
										<input type="email" style="width: 100%;padding: 8px;" required id="to" placeholder="Type your Email here...">
										
										<div class="text-right" style="margin:20px 12px 0px">
										<a class="btn btn-primary" style="padding: 6px;" id="sendfinalmail" >Send</a>
										
										</div>
								<p class="errormsg" id="mailmsg"></p>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				<!---	<div class="col-md-6 col-md-offset-3 col-xs-12" >
						<div class="box">
							
							<div class="box-body">
								<div class="box-header text-center with-border">
									<h3 class="box-title">Test Sending Email</h3>
								</div>
								<div class="email-config">
								
										<label style="width:25%">Message :</label><br />
										<textarea style="margin-top:20px;width:70%;height:120px" required id="message" placeholder="Type your message here..."></textarea>
										<div class="text-right" style="margin:20px 12px 0px">
										<a class="btn btn-danger" style="padding: 6px;" id="sendfinalmail" >Send</a>
										</div>
								
								</div>
							</div>
							
						</div>
						
					</div>-->
				
				</div>
				
			</section>
		
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
	<!-- SlimScroll -->
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
	<script>
		$(function(){
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
			});
	</script>

	<script>
		 $(document).ready(function() { /// Wait till page is loaded
            setInterval(timingLoad, 5000);
           function timingLoad() { $('.errormsg').html(''); }

      });
	</script>
		<script>
                $(function(){
                	
                        $("#sendmail").click(function(){
                        
                               
                                $('#sendmail').hide();
                                $('#cancelmail').show();
                                $('#maildiv').show();
                        
                        });
                        
                        $("#cancelmail").click(function(){
                        
                               
                                $('#sendmail').show();
                                $('#cancelmail').hide();
                                $('#maildiv').hide();
                        
                        });
                        
                        
                        $("#sendfinalmail").click(function(){
                        
                                        $to=$('#to').val();
                                        var dataString ='Testmailsend='+$to;
                                       /// alert(dataString);
                                        $.ajax({
                                        
                                        type: "POST",
                                        url:"ajax_function.php",
                                        data: dataString,
                                        cache: false,
                                        success: function(data){
                                        if(data == 1){
                                            
                                           $('#mailmsg').html('<span style="background: blue; width: 50%;text-align: center;color: white;padding: 6px;" class="">Mail Send Successfully</span>');
                                        $('#to').val('');
                                            
                                        }else{
                                            
                                         $('#mailmsg').html('<span style="background: red; width: 50%;text-align: center;color: white;padding: 6px;" class="">Sorry ! Error Occured PLease Try Again</span>');
                                         
                                        }
                                        
                                        }
                                        });
                        
                        });
                        
                        
                 });
	</script>
</body>

</html>
