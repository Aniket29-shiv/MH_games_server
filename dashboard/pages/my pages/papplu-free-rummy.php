<?php
	include('lock.php');
	include('config.php');
	include('include/free-papplu-rummy.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rummy Sahara Admin Panel</title>
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
<style>
.table>thead:first-child>tr:first-child>th {
     border-top: 1px solid #0a0909;
}
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #0a0909;
}
</style>
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
			    <div class="box-header with-border">
								<h3 class="box-title">Add New Table</h3><a href="table-entry.php" class="btn btn-primary" style="margin-left:10px;">Table Entry</a>
							</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Search </h3>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							<form method="get">

						    <div class="col-xs-3" style="display:none;">
						   	<div class="dropdown">
						   	    <select class="btn btn-primary" name="joker">
						   	        <option value="">Joker Type</option>
						   	        <option value="Joker">Joker</option>
						   	        <option value="No Joker">No Joker</option>
						   	    </select>

							</div>
							</div>

                        <div class="col-xs-3">
                        <div class="dropdown">
                        <select class="btn btn-primary" name="players">
                        <option value="">Players</option>
                        <option value="2">2 Players</option>
                        <option value="6">6 Players</option>
                        </select>
                        </div>
                        </div>


                        <div class="col-xs-3">
                        <div class="dropdown">
                        <select class="btn btn-primary" name="bet">
                        <option value="">Bet Value</option>
                        <option value="low">Low (1-100)</option>
                        <option value="medium">Medium (101-1000)</option>
                        <option value="high">High (1001 and more)</option>
                        </select>
                        </div>
                        </div>

						 <div class="col-xs-3">
                        <div class="dropdown">
                        <select class="btn btn-primary" name="status">
                        <option value="">Action</option>
                        <option value="S">Stop</option>
                        <option value="L">Live</option>
                       </select>
                        </div>
                        </div>

						<div class="box-footer with-border" style="text-align:right;">
							<input type="submit" class="btn btn-primary" name="search" value="Search">
						    <a href="papplu-free-rummy.php" class="btn btn-danger">Cancel</a>
						</div>

						</form>
							</div>
								</div>
									</div>

							<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
							<div class="box-body table-responsive">
							     <div class="box-header with-border">
							         <div class="col-md-8">
								        <h3 class="box-title">Free Papplu Rummy List ( Total Records : <?php echo numberofdata($conn,$joker,$players,$bet,$status);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-dash-deal-lobby-rummy.php">
								             <input type="hidden" name="joke" value="<?php echo $joker;?>">
								             <input type="hidden" name="play" value="<?php echo $players;?>">
								             <input type="hidden" name="bets" value="<?php echo $bet;?>">
								             <input type="hidden" name="action" value="<?php echo $status;?>">
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">

                        <?php echo paginate($reload, $pagenum, $tpages,$joker,$players,$bet,$status); ?>

                        </ul>
                        </nav>
								<table id="example2" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Table Name</th>
                                         	<th>Min Entry</th>
											<th>Status</th>
											<th>Players</th>
											<th>Action</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
									      <?php listpromotions($conn,$start,10,$joker,$players,$bet,$status);?>

									</tbody>
								</table>
								 <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">

                        <?php echo paginate($reload, $pagenum, $tpages,$joker,$players,$bet,$status); ?>

                        </ul>
                        </nav>
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
			<script>
$(function(){

     	$(".statusl").click(function(){
	     	var proid = $(this).attr('data-id');

	     $('#live'+proid).hide();
	     $('#stop'+proid).show();
		   //alert(changenoid+'=='+number);

          var dataString ='updaterummystatus='+proid;
                //alert(dataString);
                $.ajax({

                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){


                }
                });



		});

		$(".statuss").click(function(){

                var proid = $(this).attr('data-id');

                $('#live'+proid).show();
                $('#stop'+proid).hide();
               //  alert(changenoid+'=='+number);

                var dataString ='updaterummystatus='+proid;
                //  alert(dataString);
                $.ajax({

                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){


                }
                });



                });

	  });
	</script>
</body>

</html>
