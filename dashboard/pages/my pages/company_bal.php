<?php 
	include ('lock.php');
	include ('config.php');
		include('include/bal_company.php');
	
//	$query = "SELECT * FROM `company_balance` ORDER BY `company_balance`.`date` DESC";
//	$result = $conn->query($query);  
?>

<!DOCTYPE html>
<html>
 <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rummy Admin Panel</title>
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
							    <div class="col-md-2 col-xs-12">
                                                
                                                <lable>From Date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off" name="from" value="<?php echo $from1;?>" placeholder="From Date">
                                            
                                            </div>
                                             <div class="col-md-2 col-xs-12">
                                                
                                                <lable>To date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off"  name="to" value="<?php echo $to1;?>" placeholder="TO date">
                                            
                                            </div>
                                        
                                            
						    <div class="col-md-2 col-xs-12">
						         <lable>Game Type</lable><br />
						   	<div class="dropdown">
						   	   
						   	    <select class="btn btn-primary" name="game">
						   	        <option value="">Game Type</option>
						   	        <option value="Point Rummy">Point Rummy</option>
						   	         <option value="Deal Rummy">Deal Rummy</option>
						   	        <option value="Pool Rummy">Pool Rummy</option>
						   	       
						   	    </select>
							
							</div>
							</div>
							
							 <div class="col-md-2 col-xs-12" style="display:none;">
						         <lable>Chip Type</lable><br />
						   	<div class="dropdown">
						   	   
						   	    <select class="btn btn-primary" name="chiptype">
						   	        <option value="">Chip Type</option>
						   	        <option value="free">Free</option>
						   	         <option value="real">Real</option>
						   	      
						   	        
						   	    </select>
							
							</div>
							</div>
							 <div class="col-md-2 col-xs-12">
						         <lable>Player Capacity</lable><br />
						   	<div class="dropdown">
						   	   
						   	    <select class="btn btn-primary" name="status">
						   	        <option value="">Player Capacity</option>
						   	        <option value="6">Six</option>
						   	         <option value="2">Two</option>
						   	      
						   	        
						   	    </select>
							
							</div>
							</div>
							
                        <div class="col-md-2 col-xs-12" style="display:none;">
                         <lable>Player</lable>
                             <input type="text" class="form-control" autocomplete="off"  name="players" value="" placeholder="Search By Player Username">
                        </div>
                        
                         <div class="col-xs-1">
                        
                       
						  
                        </div>
                         <div class="col-xs-1">
                       
						    
                       
                        </div>
                        
                        	<div class="box-footer with-border" style="text-align:right;"><input type="submit" style="margin-top:16px;" class="btn btn-primary" name="search" value="Search">
                        	<a href="company_bal.php" style="margin-top:16px;"   class="btn btn-danger">Cancel</a></div>
							
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
								        <h3 class="box-title">Player Transactions Detail ( Total Records : <?php echo numberofdata($conn,$game,$players,$from,$to,$chiptype,$status);?>)
								        </h3>
								        <div class="row">
								        <div class="col-md-6" style="background: #d8d3af; padding: 5px;width: 49%;font-size: 18px;margin: 1px;">
								        <span style="color:green;">Total Commission Amount : </span><span>Rs. <?php echo number_format(totalwin($conn,$game,$players,$from,$to,$chiptype,$status),2);?>/-</span>
								        </div>
								         
								         </div>
								        
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-company_bal.php">
								             <input type="hidden" name="games" value="<?php echo $game;?>">
								            <input type="hidden" name="fdate" value="<?php echo $from;?>">
								             <input type="hidden" name="tdate" value="<?php echo $to;?>">
								             <input type="hidden" name="gstatus" value="<?php echo $status;?>">
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$game,$players,$from,$to,$chiptype,$status); ?>
                        
                        </ul>
                        </nav>
                        
                  
									<table  style="text-align:center" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>Sr No.</th>
												<th>Date</th>
												<th>Table Id</th>
												<th>Round Id</th>
												<th>Players Capacity</th>
												<th>Player Name</th>
												
												<th>Game Type</th>
												<th>Commission</th>
												<th>Total Amount</th>
												<th>Amount</th>
												
											</tr>
										</thead>
										<tbody>
										    <?php listpromotions($conn,$start,25,$game,$players,$from,$to,$chiptype,$status);?>
											</tbody>
									</table>
                                    <nav aria-label="Page navigation example" style="text-align: right;">
                                    <ul class="pagination justify-content-end">
                                    
                                    <?php echo paginate($reload, $pagenum, $tpages,$game,$players,$from,$to,$chiptype,$status); ?>
                                    
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
		    $(".datepicker").datepicker({
					dateFormat:'dd-mm-yy'
				});
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
					$('#user_details').DataTable()
			});
	</script>
	
</body> 
</html>