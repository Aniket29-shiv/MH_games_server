<?php

	include 'lock.php';
	include 'config.php'; 
	include('include/fundtransfer.php');
/*	$query 	= "SELECT 
						u.user_id, 
						u.username, 
						concat(ifnull(u.first_name,''),' ',ifnull(u.middle_name,''),' ',ifnull(u.last_name,'')) AS player_name, 
						ifnull(u.mobile_no,'') AS mobile_no, 
						ifnull(u.email,'') AS email,
						kd.amount,
						kd.transaction_id,
						kd.order_id,
						kd.payment_mode,
						kd.status
				from 
						users as u
						INNER JOIN fund_added_to_player AS kd ON (kd.user_id = u.user_id)
				where 
						kd.chip_type='Real'";
	$result 	= $conn->query($query);    */


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
	<!-- DataTables -->
	<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../css/jquery-ui.css">
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
			<!-- Main content -->
			<section class="content">
					<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Search </h3>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                                        <form method="get">
                                        <div class="col-md-3 col-xs-12">
                                                
                                                <lable>From Date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off" name="from" value="<?php echo $from1;?>" placeholder="From Date">
                                            
                                            </div>
                                             <div class="col-md-3 col-xs-12">
                                                
                                                <lable>To date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off"  name="to" value="<?php echo $to1;?>" placeholder="TO date">
                                            
                                            </div>
                                            <div class="col-md-3">
                                                
                                                <lable>Search</lable>
                                                <input type="text" class="form-control" name="searchval" value="" placeholder="Search Player By Username, Mobile, Email ">
                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="fund_transfer_to_player.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
                                            </div>
                                            
                                            <div class="box-footer with-border" style="text-align:right;">
                                            
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
								        <h3 class="box-title">Fund Transfer Details ( Total Records : <?php echo numberofdata($conn,$searchval,$from,$to);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-fundtransfer.php">
								             <input type="hidden" name="searchtxt" value="<?php echo $searchval;?>">
								             <input type="hidden" name="fdate" value="<?php echo $from;?>">
								             <input type="hidden" name="tdate" value="<?php echo $to;?>">
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to); ?>
                        
                        </ul>
                        </nav>
							
									<table  class="table table-bordered table-hover">
										<thead>
											<tr>
												<th style="text-align:center">Sr No.</th>
													<th style="text-align:center">Date</th>
												<th style="text-align:center">User Id</th>
												<th style="text-align:center">Full Name</th>
												<th style="text-align:center">User Name</th>
												<th style="text-align:center">Email</th>
												<th style="text-align:center">Mobile No</th>
												<th style="text-align:center">Amount</th>
												<th style="text-align:center">Transaction Id</th>
												<th style="text-align:center">Order Id</th>
												<th style="text-align:center">Payment Mode</th>
												<th style="text-align:center">Status</th>
											</tr>
										</thead>
										<tbody style="text-align:center">
										     <?php listpromotions($conn,$start,10,$searchval,$from,$to);?>
											 <?php 
											//	if($result->num_rows > 0){
												//	$i = 1;
												//	while($row = $result->fetch_assoc()){ 
											 ?>
											<!--<tr>
												<td><?php //echo $i; ?></td> 
												<td><?php //echo $row['user_id']?></td> 
												<td><?php //echo $row['player_name']?></td> 
												<td><?php //echo $row['username']?></td> 
												<td><?php //echo $row['email']?></td> 
												<td><?php //echo $row['mobile_no']?></td> 
												<td><?php //echo $row['amount']?></td> 	
												<td><?php //echo $row['transaction_id']?></td> 													
												<td><?php //echo $row['order_id']?></td> 	
												<td><?php //echo $row['payment_mode']?></td> 	
												<td><?php// echo $row['status']?></td> 	
											</tr> -->
											<?php //$i++; } } ?>
										</tbody>
									</table>
									 <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to); ?>
                        
                        </ul>
                        </nav>
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
	<!-- Bootstrap 3.3.7 -->
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- DataTables -->
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- SlimScroll -->
	
	<!-- FastClick -->
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
	<script src="../../js/jquery-ui.js"></script>  
	<!-- page script -->
	<script>
		$(function(){
		     $(".datepicker").datepicker({
					dateFormat:'dd-mm-yy'
				});
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
			});
			
			  $(function () {
				$('#example1').DataTable()
				$('#example2').DataTable({
				  'paging'      : true,
				  'lengthChange': false,
				  'searching'   : false,
				  'ordering'    : true,
				  'info'        : true,
				  'autoWidth'   : false
				});
			  });
	</script>
</body>

</html>