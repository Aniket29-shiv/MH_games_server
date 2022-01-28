<?php 
	include ('lock.php');
	include ('config.php');
		$status = '';
	if($_GET){ 
	  $id = $_GET['id']; 
	}  
 	$query = "select * from tournament where tournament_id=$id ";
	$result = $conn->query($query);  
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
		<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
			<!-- Main content -->
			<section class="content">
				<div class="row">
				 <!-- 	 <button type="button" onclick="window.location.href='tournament-details.php'"class="btn btn-primary">Back</button>--->
					<div class="box-header text-center with-border">
						<h3 class="box-title">Tournament Price Details</h3>
					</div>
					
					<div class="col-md-7 col-md-offset-3 col-xs-12">
						<div class="box">			
							<div class="box-body">
									<div style=" margin-left: 10%;">
												<?php $i=1; if($result->num_rows > 0){ 
												while($row=$result->fetch_assoc()){ ?>	
											
											<div class="form-group">
												<label style="width:30%">Title   :</label>
											<?php echo $row['title']; ?>
											</div>
											
											<div class="form-group">
												<label style="width:30%;float: left;">Price :</label>
											<?php echo $row['price']; ?>
											</div>
												<div class="form-group">
												<label style="width:30%;float: left;">Start Date :</label>
								<?php echo $row['start_date']; ?>
											</div>
												<div class="form-group">
												<label style="width:30%;float: left;">Start Time :</label>
											<?php echo $row['start_time']; ?>
											</div>
												<div class="form-group">
												<label style="width:30%;float: left;">Registration Start Date :</label>
											<?php echo $row['reg_start_date']; ?>
											</div>	<div class="form-group">
												<label style="width:30%;float: left;">Registration Start Time :</label>
											<?php echo $row['reg_start_time']; ?>
											</div>
											<div class="form-group">
												<label style="width:30%;float: left;">Registration End Date :</label>
											<?php echo $row['reg_end_date']; ?>
											</div>
												<div class="form-group">
												<label style="width:30%;float: left;">Registration End Time :</label>
											<?php echo $row['reg_end_time']; ?>
											</div>
								<div class="form-group">	
								<label style="width:30%;float: left;">Entry Fee :</label>
									<?php echo $row['entry_fee']; ?>
										
										</div>
							<div class="form-group">
												<label style="width:30%;float: left;">No Of Players :</label>
												<?php echo $row['no_of_player']; ?>
											</div>
											<div class="form-group">
									    <label style="width:30%;float: left;">Description :</label>
							<p><?php echo $row['description']; ?></p>
								</div>		
								<div class="form-group">
									    <label style="width:30%;float: left;">Date :</label>
								<?php echo $row['created_date']; ?>	
								</div>	
											<?php  } }  ?>
								<div class="form-group">
												<label style="width:30%">Price Distributions   :</label>
											</div>
									<?php
									$query = "select * from price_distribution  where tournament_id=$id ";
	$result1 = $conn->query($query);  		
									?><div class="table-responsive">
								
									<table id="user_details" style="text-align:center" class="table table-bordered table-hover">
									    	<thead>
											<tr>
											<th>Postion </th>
											<th>Price </th>
											<th>No.Of Playes</th>
											</tr></thead>
										<tbody><?php
									$i=1; if($result1->num_rows > 0){ 
												while($row1=$result1->fetch_assoc()){ ?>
										<tr>
												<td>
											<?php echo $row1['position']; ?>
											</td>
											<td><?php echo $row1['price']; ?>	    </td>
											<td><?php echo $row1['no_players']; ?>	    </td>
											<tr>
											
							<?php $i++; } }  ?>
							</tbody>
							</table>
							</div>
							</div>
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
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
		<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
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
				
					$('#user_details').DataTable(
					    
					    {

} 
					    )
			});
			
	</script>
	
</body> 
</html>