<?php 
	include('lock.php'); 
	include('config.php'); 
	  $query = "select * from player_table where game='Cash Game' AND game_type='Deal Rummy' ORDER BY table_id DESC";
	$result_pool = $conn->query($query); 
	 
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
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
							<div class="dropdown">
								<button class="btn btn-primary" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Game Type	<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<li><a href="#" style="color:#000000">Joker</a>
									</li>
									<li><a href="#" style="color:#000000">No Joker</a>
									</li>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-primary" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Players	<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<li><a href="#" style="color:#000000">2 Players</a>
									</li>
									<li><a href="#" style="color:#000000">6 Players</a>
									</li>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-primary" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bet Value	<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<li><a href="#" style="color:#000000">Low</a>
									</li>
									<li><a href="#" style="color:#000000">Medium</a>
									</li>
									<li><a href="#" style="color:#000000">High</a>
									</li>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-primary" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hide	<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" style="margin-left:-30px" aria-labelledby="dLabel">
									<li><a href="#" style="color:#000000">Empty Tables</a>
									</li>
									<li><a href="#" style="color:#000000">Full Tables</a>
									</li>
								</ul>
							</div>
							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="example2" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Table Name</th>
											<th>Joker Type</th>
											<th>Point Value</th>
											<th>Min Entry</th>
											<th>Status</th>
											<th>Players</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; if($result_pool->num_rows > 0){
											while($row = $result_pool->fetch_assoc()){	
											?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['table_name']; ?></td>
											<td><?php echo $row['joker_type']; ?></td>
											<td><?php echo $row['point_value']; ?></td>
											<td><?php echo $row['min_entry']; ?></td>
											<td><?php echo $row['status']; ?></td>
											<td><?php echo $row['player_capacity']; ?></td> 
											<td>
												<a href="stop.php?stop=<?php echo $row['table_id']; ?>">
													<button class="btn btn-primary">Stop</button>
												</a>
												<a href="live.php?live=<?php echo $row['table_id']; ?>">
													<button class="btn btn-primary">Live</button>
												</a>
											</td>
										</tr> 
										<?php $i++; } } $conn->close(); ?>
									</tbody>
								</table>
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