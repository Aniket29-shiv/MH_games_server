<?php
include 'lock.php';
include 'config.php';
	include('include/detail_bank.php');
	$status = '';
	if($_GET){ 
	  $status = $_GET['status']; 
	}    

	$query  = "select bd.*,us.username,us.first_name,us.middle_name,us.last_name from bank_details bd LEFT JOIN users us ON bd.user_id=us.user_id";

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
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<?php  if($status==1){ ?> 
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> Record Updated.....!
							</div>  
							
						<?php }if($status==2){ ?> 
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured...!
							</div>   
						<?php } ?>
						
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Search </h3>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                                        <form method="get">
                                        
                                            <div class="col-md-6">
                                                
                                                <lable>Search</lable>
                                                <input type="text" class="form-control" name="searchval" value="" placeholder="Search Player By  username">
                                            
                                            </div>
                                            
                                            <div class="col-md-6">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="bank-details.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">Bank Details ( Total Records : <?php echo numberofdata($conn,$searchval);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-bank-Details.php">
								             <input type="hidden" name="searchtxt" value="<?php echo $searchval;?>">
								            
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval); ?>
                        
                        </ul>
                        </nav>
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="text-align:center">Sr No</th>
											<th style="text-align:center">User Name</th>
											<th style="text-align:center">Full Name</th>
											<th style="text-align:center">Bank Name</th>
											<th style="text-align:center">Account No</th>
											<th style="text-align:center">IFSC Code</th>
											<th style="text-align:center">Edit Profile</th>
										</tr>
									</thead>
									<tbody class="text-center">
									    <?php listpromotions($conn,$start,10,$searchval);?>
										<?php
										//$i=1;
										//if($result->num_rows > 0){
										//	while($row = $result->fetch_assoc()){
										?>
										<!--<tr>
											<td><?php //echo $i; ?></td> 
											<td><?php //echo $row['username']; ?></td> 
											<td><?php //echo $full_name = $row['first_name'].' '.$row['middle_name'].' '.$row['last_name']; ?></td>
											<td><?php //echo $row['bank_name']; ?></td> 
											<td><?php //echo $row['account_no']; ?></td> 
											<td><?php //echo $row['ifsc_code']; ?></td> 
											<td>
												<a href="update_bank_details.php?user_id=<?php echo $row['user_id']; ?>&user_name=<?php echo $full_name; ?>"><button class="btn btn-info btn-xs">Edit</button></a>
											</td>
										</tr>-->  
										<?php// $i++ ; } } ?>
									</tbody>
								</table>
								 <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval); ?>
                        
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
	<!-- DataTables -->
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
	<!-- page script -->
	<script>
		$(function(){
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
			});
			
			  $(function (){ 
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