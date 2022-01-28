<?php 
	include ('lock.php');
	include ('config.php');
	include('include/detailoffund.php');
	$query = "select fund_added_to_player.*,accounts.play_chips,accounts.username as fullname,accounts.real_chips,users.username from fund_added_to_player
	LEFT JOIN accounts ON accounts.userid=fund_added_to_player.user_id 
	LEFT JOIN users ON users.user_id=fund_added_to_player.user_id 
	ORDER BY `fund_added_to_player`.`created_date` DESC ";
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
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	
		<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="../../css/jquery-ui.css">
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
                                            
                                             <div class="col-md-3">
                                                
                                                <lable>From Date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off" name="from" value="<?php echo $from1;?>" placeholder="From Date">
                                            
                                            </div>
                                            
                                             <div class="col-md-3">
                                                
                                                <lable>To date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off"  name="to" value="<?php echo $to1;?>" placeholder="TO date">
                                            
                                            </div>
                                        
                                            <div class="col-md-3">
                                                
                                                <lable>Search</lable>
                                                <input type="text" class="form-control" autocomplete="off" name="searchval" value="<?php echo $searchval;?>" placeholder="Search  By Username">
                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="add-fund-details.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">Member Fund Details ( Total Records : <?php echo numberofdata($conn,$searchval,$from,$to);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-fund-Details.php">
								             <input type="hidden" name="searchtxt" value="<?php echo $searchval;?>">
								             <input type="hidden" name="fromdate" value="<?php echo $from;?>">
								             <input type="hidden" name="todate" value="<?php echo $to;?>">
								            
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                        <nav aria-label="Page navigation example" style="text-align: right;">
                            <ul class="pagination justify-content-end">
                            
                                <?php  echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to); ?>
                            
                            </ul>
                        </nav>
									<table  style="text-align:center" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>Sr No.</th>
												
												<th>Name </th>
												<th>Username</th>
												<th>Amount</th>
												<th>Payment Mode</th>
												<th>Order ID</th>
												<th>Real Chips</th>
											<th>Date & Time</th>
											</tr>
										</thead>
											<tbody>
											    <?php  listpromotions($conn,$start,10,$searchval,$from,$to);?>
											<?php //$i=1; if($result->num_rows > 0){ 
											//	while($row=$result->fetch_assoc()){ ?>
											<!--	<tr>
												<td><?php echo $i; ?></td> 
											
												<td><?php echo $row['fullname']; ?></td> 		<td><?php echo $row['username']; ?></td> 
									
												<td><?php echo $row['amount']; ?></td> 
												<td><?php echo $row['payment_mode']; ?></td> 
												<td><?php echo $row['order_id']; ?></td> 
										<td><?php echo $row['real_chips']; ?></td> 
													<td><?php echo $row['created_date']; ?></td> 
											
											</tr> -->
											<?php //$i++; } }  ?>
										</tbody>
                                        </table>
                                          <nav aria-label="Page navigation example" style="text-align: right;">
                            <ul class="pagination justify-content-end">
                            
                                <?php  echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to); ?>
                            
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
	<!-- SlimScroll -->
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	
		<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
<script src="../../js/jquery-ui.js"></script>  
	<script>
		$(function(){
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
					$('#user_details').DataTable()
			});
	</script>
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
  
				//Date range picker
				$('#reservation').daterangepicker()
				//Date range picker with time picker
				$('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
				//Date range as a button
				$('#daterange-btn').daterangepicker(
				  {
					ranges   : {
					  'Today'       : [moment(), moment()],
					  'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					  'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
					  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					  'This Month'  : [moment().startOf('month'), moment().endOf('month')],
					  'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					},
					startDate: moment().subtract(29, 'days'),
					endDate  : moment()
				  },
				  function (start, end) {
					$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
				  }
				)

				//Date picker
				$('#datepicker').datepicker({
				  autoclose: true
				});
				
				 $('#datepicker1').datepicker({
				  autoclose: true
				});
			  });
	</script>
	
</body> 
</html>