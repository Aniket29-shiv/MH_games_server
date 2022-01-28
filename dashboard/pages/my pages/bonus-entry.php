<?php
	$status = '';
	 
	if($_GET){ 
	
	  $status = $_GET['status'];  
	}
    
	include("config.php");
	include("lock.php"); 
	
	$query_bonus_entry = "select * from bonus_entry order by  created_on  desc limit 1";
	$bonus_result_raw = $conn->query($query_bonus_entry);
	 
	if($bonus_result_raw->num_rows > 0  ){
		$bonus_result = $bonus_result_raw->fetch_assoc(); 
	}
	
	$query_convert_real = "select * from converting_into order by created_on desc limit 1";
	$convert_result_raw = $conn->query($query_convert_real);
	
	if($convert_result_raw->num_rows > 0){
		$convert_result = $convert_result_raw->fetch_assoc(); 
	}
	
	$query_real_chips = "select * from real_chips order by created_on desc limit 1";
	$real_result_raw = $conn->query($query_real_chips);
	
	if($real_result_raw->num_rows > 0){
		$real_result = $real_result_raw->fetch_assoc();
	}
	 
	 
    
    $query_reward = "select * from reward_point_set";
    $get_reward = $conn->query($query_reward);
    
    if($get_reward->num_rows > 0){
      $reward_result = $get_reward->fetch_assoc();
    }

	
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
				<div class="row bonus-wrapper">
					<?php  if($status==1){ ?>
						
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> Record Saved.....!
							</div>  
							
						<?php } if($status==2) { ?>
						
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured...!
							</div>   
						<?php } ?>
					<div class="box-header text-center with-border">
						<h3 class="box-title">Bonus Entry</h3>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<div class="box-body">
								<form role="form" action="bonus-entry_db.php" method="post" name="bonus_entry_form" id="bonus_entry_form" enctype="multipart/formdata"> 
									<div class="form-group">
										<h5 style="font-size:16px">Total Bonus Entry</h5>
										<br />
										<label style="margin-top:20px">Registration Bonus</label>:
										<input type="number" placeholder="4000" name="reg_bonus" id="reg_bonus" value="<?php echo $bonus_result['reg_bonus']; ?>">
										<label>Reference Bonus</label>:
										<input type="number" placeholder="2000" name="ref_bonus" id="ref_bonus" value="<?php echo $bonus_result['ref_bonus']; ?>">
											<label>Real Chips</label>:
										<input type="number" placeholder="0" name="real_chips" id="real_chips" value="<?php echo $bonus_result['real_chips']; ?>">
										<label>Silver Club Bonus</label>:
										<input type="number" placeholder="1000" name="silver_club" id="silver_club" value="<?php echo $bonus_result['silver_club']; ?>">
										<label>Gold Club Bonus</label>:
										<input type="number" placeholder="1000" name="gold_club" id="gold_club" value="<?php echo $bonus_result['gold_club']; ?>">
										<label>Platinum Club Bonus</label>:
										<input type="number" placeholder="1000" name="platinum_club" id="platinum_club" value="<?php echo $bonus_result['platinum_club']; ?>">
										<div class="box-footer text-right" style="margin-top:20px">
											<button type="submit" name="bonus_entry" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</form>	
								<!-- /.box-body -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<div class="box-body">
							<form role="form" action="bonus-entry_db.php" method="post" name="convert_into_form" id="convert_into_form" enctype="multipart/formdata"> 
								<fieldset>
								<div class="form-group">
									<h5>Converting Into Real Chips</h5>
									<h6>(Players Spending Real Chips)</h6>
									<br>
									<label style="margin-top:20px">Registration Bonus</label>:
									<input type="number" placeholder="500"name="reg_bonus" id="reg_bonus"  value="<?php echo $convert_result['reg_bonus'];   ?>">
									<label>Reference Bonus</label>:
									<input type="number" placeholder="200" name="ref_bonus" id="ref_bonus" value="<?php echo $convert_result['reg_bonus'];    ?>">
									<label>Silver Club Bonus</label>:
									<input type="number" placeholder="100" name="silver_club" id="silver_club" value="<?php echo $convert_result['reg_bonus'];   ?>">
									<label>Gold Club Bonus</label>:
									<input type="number" placeholder="100" name="gold_club" id="gold_club" value="<?php echo  $convert_result['reg_bonus']; ?>">
									<label>Platinum Club Bonus</label>:
									<input type="number" placeholder="100" name="platinum_club" id="platinum_club" value="<?php echo $convert_result['platinum_club'];   ?>">
									<div class="box-footer text-right" style="margin-top:20px">
										<button type="submit" name="convert_into" class="btn btn-primary">Submit</button>
									</div>
								</div>
								</fieldset>
							</form>	
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<form role="form" action="bonus-entry_db.php" method="post" name="real_chips_form" id="real_chips_form" enctype="multipart/formdata"> 
								<div class="box-body">
									<h5>Real chips will get in players account.</h5>
									<label style="margin-top:20px">Registration Bonus</label>:
									<input type="number" placeholder="50" name="reg_bonus" id="reg_bonus" value="<?php echo  $real_result['reg_bonus']; ?>">
									<label>Reference Bonus</label>:
									<input type="numbernumber" placeholder="30" name="ref_bonus" id="ref_bonus" value="<?php echo $real_result['reg_bonus'];  ?>">
									<label>Silver Club Bonus</label>:
									<input type="number" placeholder="20"name="silver_club" id="silver_club" value="<?php echo $real_result['reg_bonus']; ?>">
									<label>Gold Club Bonus</label>:
									<input type="number" placeholder="20" name="gold_club"  id="gold_club" value="<?php echo $real_result['reg_bonus']; ?>">
									<label>Platinum Club Bonus</label>:
									<input type="number" placeholder="20" name="platinum_club" id="platinum_club" value="<?php echo $real_result['platinum_club']; ?>">
									<div class="box-footer text-right" style="margin-top:20px">
										<button type="submit" name="real_chips" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</form>	
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>
					<div class="row bonus-wrapper">
					    	<div class="col-md-4 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<div class="box-body">
								<form role="form" action="bonus-entry_db.php" method="post" name="bonus_entry_form" id="bonus_entry_form" enctype="multipart/formdata"> 
									<div class="form-group">
										<h5 style="font-size:16px">Reward Point On Cash Adding</h5><br>
								            	<label>Rs. 0 - Rs. 500 :</label>
											<input type="number" placeholder="100"  min="0" name="col_0_500"  value="<?php echo $reward_result['col_0_500']; ?>" style="padding:0px 15px">
											<label>Rs. 501 - Rs. 1000 :</label>
											<input type="number" placeholder="100" min="0" name="col_501_1000" value="<?php echo $reward_result['col_501_1000']; ?>" style="padding:0px 15px">
											<label>Rs. 1001 - Rs. 5000 :</label>
											<input type="numbernumber" placeholder="100" min="0" name="col_1001_5000" value="<?php echo $reward_result['col_1001_5000']; ?>" style="padding:0px 15px">
											<label>Rs. 5001 - Rs. 10000 :</label>
											<input type="number" placeholder="100" min="0" name="col_5001_10000" value="<?php echo $reward_result['col_5001_10000']; ?>" style="padding:0px 15px">
												<label>Up To Rs. 10000</label>
											<input type="number" placeholder="100" min="0" name="col_10000_up" value="<?php echo $reward_result['col_10000_up']; ?>" style="padding:0px 15px">
											<hr>
											<h5 style="font-size:16px">Redeem reward point for cash</h5><br>
												<label>Rate of conversion  :</label>
											<input type="number" placeholder="100%" min="0" name="redeem_per" value="<?php echo $reward_result['redeem_per']; ?>" style="padding:0px 15px">
											<br />Note : <span style="color:blue">Rate must be in % for redeem </span>
										
									        <div class="text-right">
												<button type="submit" style="margin-top:20px"  name="reward_set" class="btn btn-primary">Submit</button>
											</div>
									</div>
								</form>	
								<!-- /.box-body -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
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