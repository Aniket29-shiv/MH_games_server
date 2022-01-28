<?php 

	include('lock.php'); 
	include('config.php');
	include('include/couponlist.php');


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
				<div class="row">
					<div class="col-xs-12">
					    <div class="box-header with-border">
								<h3 class="box-title">Coupon List</h3><a href="addcoupon.php" class="btn btn-primary" style="margin-left:10px;">Add Coupon</a>
							</div>
							
						<div class="box point-lobby-wrapper">
					
							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table  class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>SR.NO</th>
											<th>TITLE</th>
											<th>Coupon</th>
											<th>Valid From</th>
											<th>Valid TO</th>
											<th>Bonus TYPE</th>
											<th>Bonus Value</th>
											<th>Max Price</th>
											<th>Reusable</th>
										
											<th>Edit</th>
											<th>Delete</th>
										
										</tr>
									</thead>
									<tbody>
									<?php listpromotions($conn,$start,10);?>
									</tbody>
								</table>
								<nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-end">
                   
                    <?php echo paginate($reload, $pagenum, $tpages); ?>
                   
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
		  // alert(changenoid+'=='+number);
		
          var dataString ='updatepromotionstatus='+proid;
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
		
		
			$(".statuss").click(function(){
	     	var proid = $(this).attr('data-id');
	     
	     $('#live'+proid).show();
	     $('#stop'+proid).hide();
		  // alert(changenoid+'=='+number);
		
          var dataString ='updatepromotionstatus='+proid;
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