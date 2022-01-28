<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include('lock.php');
	include("config.php");
	include('include/login_social.php');

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rummy Store Admin Panel</title>
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
						<h3 class="box-title">Social Login Configuration</h3>
					</div>
					<div class="col-md-6  col-xs-12">
						<div class="box">
							<div class="box-header text-center with-border">
					      	<h3 class="box-title">Facbook Configuration</h3>
				         	</div>
							<div class="box-body">
							<form method="post">
								<div style="padding:20px 5%">
								    
								<label style="width:40%;" >Social Login ID :</label>
								<input type="text" style="width:56%;" name="pgname" value="<?php echo $pgname;?>">  
                                
                                <label style="width:40%">Version :</label>
                                <input type="text" style="width:56%" name="pgid" required value="<?php echo $pgid;?>">
                                
                               
                                <label style="width:40%">Status :</label>
                                 <select required  style="width:56%" name="pgstatus">
                                     <option value="">Select Status</option>
                                     <option value="active" <?php if($pgstatus == 'active'){ echo 'selected="selected"';} ?> >Active</option>
                                     <option value="inactive" <?php if($pgstatus == 'inactive'){ echo 'selected="selected"';} ?>>Inactive</option>
                                </select>
								</div>
							
								<div style="padding:20px 5%;margin:0px 15px" class="text-right">
									<input type="submit" name="facebook"  class="btn btn-info" value="Submit">
								</div>
								
                                <?php if($message != ''){?>
                                <p class="errormsg"><span style="background: red; color: white; padding: 2px;font-family: monospace; font-size: 14px;"><?php echo $message;?></span></p>
                                <?php }?>
                                 <?php if($message1 != ''){?>
                                <p class="errormsg"><span style="background: green; color: white; padding: 2px;font-family: monospace; font-size: 14px;"><?php echo $message1;?></span></p>
                                <?php }?>
								
								</div>
							</from>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-6  col-xs-12">
						<div class="box">
							<div class="box-header text-center with-border">
					      	<h3 class="box-title">Google Configuration</h3>
				         	</div>
							<div class="box-body">
								
							<form method="post">
								<div style="padding:20px 5%">
								 <label style="width:40%;">Social Login ID :</label>
                                <input type="text" style="width: 100%;margin-bottom: 10px;" name="pgname1" value="<?php echo $pgname1;?>">  
                                
                               
                             
                                
                                <label style="width:40%">Status :</label>
                                 <select style="width:56%" name="pgstatus1">
                                     <option value="">Select Status</option>
                                     <option value="active" <?php if($pgstatus1 == 'active'){ echo 'selected="selected"';} ?>>Active</option>
                                     <option value="inactive" <?php if($pgstatus1 == 'inactive'){ echo 'selected="selected"';} ?>>Inactive</option>
                                </select>
								</div>
							
								<div style="padding:20px 5%;margin:0px 15px" class="text-right">
									<input type="submit" name="google"  class="btn btn-info" value="Submit">
								</div>
								 <?php if($message2 != ''){?>
                                <p class="errormsg"><span style="background: red; color: white; padding: 2px;font-family: monospace; font-size: 14px;"><?php echo $message2;?></span></p>
                                <?php }?>
                                 <?php if($message3 != ''){?>
                                <p class="errormsg"><span style="background: green; color: white; padding: 2px;font-family: monospace; font-size: 14px;"><?php echo $message3;?></span></p>
                                <?php }?>
							</div>
							</from>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
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
</body>

</html>