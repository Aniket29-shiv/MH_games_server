<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include('lock.php');
	include("config.php");
	
	$message='';
	$message1='';
	if(isset($_POST['submit'])){
	   $commission=$_POST['commission'];
	   if($commission != ''){
	    $makequery="UPDATE `commission` SET `commission`='$commission' WHERE id=1";
        mysqli_query ($conn,$makequery);
        $message1="Updated Successfully"; 
	   }else{
	   $message='Commission Amount Required';
	   }
	}
	
    	$getquery="select * from `commission`  WHERE id=1";
        $get=mysqli_query ($conn,$getquery);
        $listdata=mysqli_fetch_object($get);
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
						<h3 class="box-title">Commission</h3>
					</div>
					<div class="col-md-6 col-md-offset-3 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<div class="box-body commission-wrapper">
								Note :<h5 class="text-center" style="color:blue">*Commission in % will be deducted from players winning amount from every game.</h5>
                                <form method="post">
                                    <div style="padding:0px 15% 5%">
                                        <label> Commission</label>:
                                        <input type="text" name="commission" value="<?php echo $listdata->commission;?>" placeholder="15">%
                                    
                                    </div>
                                    <div style="padding:0px 15% 5%; text-align:right;">
                                        <input type="submit" class="btn btn-primary" name="submit" value="Update">
                                        
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
</body>

</html>