 <?php

include '../../lock.php';
include("config.php");
$sql = "select count(user_id) AS total_user from users";			
	$result 	= $conn->query($sql);
	if($result->num_rows > 0)
	{		
		while($row = $result->fetch_assoc())
		{			
			$total_user = $row['total_user'];
		}
	}
	
	
	//============Total Collected Payment =================================================================
	
        function playersbalance($conn){
            
             $sql = "select sum(real_chips) AS total_amount from accounts";			
             $result = $conn->query($sql);
             $row = $result->fetch_row();
             $totalamount = round($row[0],2);	
              echo $totalamount;
        }
        
        
        function totalpaymentcollected($conn){
            
                $sql = "select sum(amount) AS total_amount from fund_added_to_player where status='success' and chip_type='Real'";			
                $result = $conn->query($sql);
                $row = $result->fetch_row();
                $totalamount = round($row[0],2);
                echo $totalamount;
        }
        
     //============Total bonus===============================================================================   
        function totalBonus($conn){
            
             $sql = "select sum(bonus) AS total_amount from accounts";			
             $result = $conn->query($sql);
             $row = $result->fetch_row();
             $totalamount = round($row[0],2);	
              echo $totalamount;
        }
        
      //============Total WIthdrawal===============================================================================   
        function withdraw_request($conn){
            
             $sql = "select sum(requested_amount) AS totalamount  from withdraw_request where status='Paid'";			
             $result = $conn->query($sql);
             $row = $result->fetch_row();
             $totalamount = $row[0];
             if($totalamount > 0){
             echo $totalamount;
             }else{
                  $totalamount =0;
                  echo $totalamount;
             }
        }   
        
        
 ?> 
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EliteRummy Admin Panel</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
	
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
	<link type="text/css" rel="stylesheet" href="../../css/bar-chart.css" />
	
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
			<section class="content-header">
				<h1>Payment Details</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a>
					</li>
					<li class="active">Payment Details</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
							<div class="info-box-content"> <span>Total Collected Paymment</span>
								<span class="info-box-number">₹ <?php totalpaymentcollected($conn);?><small></small></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-inr" aria-hidden="true"></i></span>
							<div class="info-box-content"> <span>All Bonuses</span>
								<span class="info-box-number">₹ <?php totalBonus($conn);?></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<!-- fix for small devices only -->
					<div class="clearfix visible-sm-block"></div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
							<div class="info-box-content"> <span>Total withdrawal Payment</span>
								<span class="info-box-number">₹ <?php withdraw_request($conn);?></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
							<div class="info-box-content"> <span>Players Balance</span>
								<span class="info-box-number"><?php playersbalance($conn);?></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
				</div>
			
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
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
	<!-- SlimScroll -->
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- ChartJS -->
	<script src="../../bower_components/Chart.js/Chart.js"></script>
	
	<script src="../../dist/js/demo.js"></script>
	<script src="../../js/bar.js"></script>
	<script src="../../js/jquery.rotapie.js"></script>
	<script>
		$(function(){
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
			});
			
		$(function(){
				$('#pie').rotapie({
					slices: [
						{ color: '#dd4b39 ', percentage: 23 }, // If color not set, slice will be transparant.
						{ color: '#00a65a ', percentage: 18 }, // Font color to render percentage defaults to 'color' but can be overriden by setting 'fontColor'.
						{ color: '#f39c12 ', percentage: 16 },
						{ color: '#00c0ef ', percentage: 20 },
						{ color: '#3c8dbc ', percentage: 14 },
						{ color: '#d2d6de ', percentage: 9 },
					],
					sliceIndex: 0, // Start index selected slice.
					deltaAngle: 0.2, // The rotation angle in radians between frames, smaller number equals slower animation.
					minRadius: 100, // Radius of unselected slices, can be set to percentage of container width i.e. '50%'
					maxRadius: 110, // Radius of selected slice, can be set to percentage of container width i.e. '45%'
					minInnerRadius: 30, // Smallest radius inner circle when animated, set to 0 to disable inner circle, can be set to percentage of container width i.e. '35%'
					maxInnerRadius: 45, // Normal radius inner circle, set to 0 to disable inner circle, can be set to percentage of container width i.e. '30%'
					innerColor: '#fff', // Background color inner circle. 
					minFontSize: 20, // Smallest fontsize percentage when animated, set to 0 to disable percentage display, can be set to percentage of container width i.e. '20%'
					maxFontSize: 30, // Normal fontsize percentage, set to 0 to disable percentage display, can be set to percentage of container width i.e. '10%'
					fontYOffset: 0, // Vertically offset the percentage display with this value, can be set to percentage of container width i.e. '-10%'
					fontFamily: 'Times New Roman', // FontFamily percentage display.
					fontWeight: 'bold', // FontWeight percentage display.
					decimalPoint: '.', // Can be set to comma or other symbol.
					clickable: true // If set to true a user can select a different slice by clicking on it. 
					/*
					beforeAnimate: function (nextIndex, settings) {
						var canvas = this;
						return false; // Cancel rotation
					},
					afterAnimate: function(settings){
						var canvas = this;
						var index = settings.sliceIndex; // Retrieve current index.
					}
					*/
				});
			});
	</script>
</body>

</html>