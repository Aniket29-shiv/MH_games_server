<?php 
	include('lock.php');
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
						
						<div class="col-md-7 col-md-offset-3 col-xs-12">
							<div class="box-header text-center with-border">
								<h3 class="box-title">Table Details</h3>
							</div>
							<div class="box"> 
								<!-- /.box-header -->
								<div class="box-body">
									<form role="form" action="table-entry_db.php" method="post" name="table_details" id="table_details" enctype="multipart/formdata"> 
										<div class="box-body">
											<div class="form-group">
												<label style="width:30%">Game</label>:
												<div style="display:inline-block; width:67%">
													<select class="form-control required" name="game" id="game" >
														<option value="">--- Select ---</option>
														<option>Cash Game</option>
														<option>Free Game</option>
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label style="width:30%">Game type</label>:
												<div style="display:inline-block; width:67%">
													<select class="form-control required" id="game_type" name="game_type" onchange="get_game_type(this.value)">
														<option value="">--- Select ---</option>
														<option>Point Rummy</option>
														<option>Pool Rummy</option>
														<option>Deal Rummy</option>
														<option>Papplu Rummy</option>
													</select>
												</div>
											</div>
											
											<div class="form-group" id="pool_game">
												<label style="width:30%">Pools</label>:
												<div style="display:inline-block; width:67%">
													<select class="form-control" name="pool" id="pool">
														<option value="0" >--- Select ---</option>
														<option>101 Pools</option>
														<option>201 Pools</option>
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label style="width:30%">Table Name</label>:
												<input type="text" name="table_name"  id="table_name" style="padding:5px 0px; width:67%">
											</div>
											
											<div class="form-group">
												<label style="width:30%">Table No</label>:
												<input type="text" name="table_no" id="table_no" style="padding:5px 0px; width:67%">
											</div>
											
											<div class="form-group" style="display:none;">
												<label style="width:30%">Joker Type</label>:
												<div style="display:inline-block; width:67%">
													<select class="form-control" name="joker_type" id="joker_type">
														<option>--- Select ---</option>
														<option>Joker</option>
														<option>No Joker</option>
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label style="width:30%">Bet / Entry</label>:
												<input type="text" style="padding:5px 0px; width:67%" name="min_entry" id="min_entry">
											</div>
											
											<div class="form-group" id="pvalue" style="diplay:none;">
												<label style="width:30%">Value Points (Rs)</label>:
												<input type="text" style="padding:5px 0px; width:67%" name="point_value" id="point_value" >
											</div>
											
											<div class="form-group">
												<label style="width:30%">Sitting Capacity</label>:
												<div style="display:inline-block; width:67%">
													<select class="form-control" name="player_capacity" id="player_capacity">
														<option>--- Select ---</option>
														<option value="2">2 Seats</option>
														<option value="6">6 Seats</option>
													</select>
												</div>
											</div> 
											<div class="form-group">
												<label style="width:30%">Table Status</label>:
												<div style="display:inline-block; width:67%">
													<select class="form-control" name="table_status" id="table_status">
														<option>--- Select ---</option>
														<option value="S">Stop</option>
														<option value="L">Live</option>
													</select>
												</div>
											</div> 
											
										</div>
										<!-- /.box-body -->
										<div class="box-footer text-center">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>
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
	 
		<!-- FastClick -->
		<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="../../dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="../../dist/js/demo.js"></script> 

		<script src="../../js/jquery.validate.min.js"></script> 
		<script> 
			$("#table_details").validate({
				rules: { 
					game:"required",
					game_type:"required" 
					},
				messages: {
					 game:'Please select Game',
					 game_type:'Please select Game Type' 
				}
		}); 


			$('#pool_game').hide();
			$(function(){
					$("#sidebar-menu").load("sidebar-menu.html"); 
					$("#header").load("header.html"); 
					$("#footer").load("footer.html");
					$("#dashboard-settings").load("dashboard-settings.html"); 				
				});
			function get_game_type(game_type){
			//alert(game_type);
				if(game_type=="Pool Rummy"){
					$('#pool_game').show();
				}else{
					$('#pool_game').hide();
				}
				
				if(game_type=="Point Rummy"){
					$('#pvalue').show();
				}else{
					$('#pvalue').hide();
				}
			}
		</script>
	</body> 
</html>
