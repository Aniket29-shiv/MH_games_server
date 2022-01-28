<?php 
	include ('lock.php');
	include ('config.php');
	include ('include/transaction-all-tournament.php');
	
		$status = '';
	if($_GET){ 
	  $status = $_GET['status']; 
	}  
	$query = "select * from tournament ";
	$result = $conn->query($query);  
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
		<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
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
                                            
                                             <div class="col-md-2">
                                                
                                                <lable>From Date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off" name="from" value="<?php echo $from1;?>" placeholder="From Date">
                                            
                                            </div>
                                            
                                             <div class="col-md-2">
                                                
                                                <lable>To date</lable>
                                                <input type="text" class="form-control datepicker" autocomplete="off"  name="to" value="<?php echo $to1;?>" placeholder="TO date">
                                            
                                            </div>
                                            <div class="col-md-2">
                                                
                                                <lable>Type</lable>
                                              <select class="form-control" name="type">
                                                  <option value="">Type</option>
                                                  <option value="free">Free</option>
                                                  <option value="cash">Cash</option>
                                                  </select>
                                            
                                            </div>
                                              <div class="col-md-2">
                                                
                                                <lable>Tournament ID</lable>
                                                <input type="text" class="form-control" autocomplete="off" name="ttitle" value="<?php echo  $ttitle;?>" placeholder="Search Tournament By ID">
                                            
                                            </div>
                                        
                                            <div class="col-md-2">
                                                
                                                <lable>Search</lable>
                                                <input type="text" class="form-control" autocomplete="off" name="searchval" value="<?php echo  $searchval;?>" placeholder="Search Username,Email And Mobile number">
                                            
                                            </div>
                                            
                                            <div class="col-md-2">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="tournament-all-transaction.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title" style="width:100%">Tournament  Transactions ( Total Records : <?php echo  numberofdata($conn,$searchval,$from,$to,$ttitle,$type);?>)</h3>
								        <h3 class="box-title" style="background: #2ab75c;padding: 5px;color: white;">Total Entre Fee : Rs. <?php echo  number_format(numberentryfee($conn,$searchval,$from,$to,$ttitle,$type),2);?> /-</h3>
								        <h3 class="box-title"  style="background: #b7a62a;padding: 5px;color: white;">Total score : Rs. <?php echo   number_format(numberscore($conn,$searchval,$from,$to,$ttitle,$type),2);?> /-</h3>
								        
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-all-tournament-tra.php">
								             <input type="hidden" name="searchtxt" value="<?php echo $searchval;?>">
								             <input type="hidden" name="fromdate" value="<?php echo $from;?>">
								             <input type="hidden" name="todate" value="<?php echo $to;?>">
								             <input type="hidden" name="tid" value="<?php echo $ttitle;?>">
								             <input type="hidden" name="ttype" value="<?php echo $type;?>">
								            
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                                    <nav aria-label="Page navigation example" style="text-align: right;">
                                       <ul class="pagination justify-content-end">
                                    
                                        <?php  echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to,$ttitle,$type); ?>
                                    
                                      </ul>
                                    </nav>
								
									<table  style="text-align:center" class="table table-bordered table-hover">
										<thead>
											<tr>
											  
                                            <th>Sr No.</th>
                                            <th>Entry Date</th>
                                            <th>Tournament  ID</th>
                                            <th>Title</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Entry Fee</th>
                                            <th>Position</th>
                                            <th>Score</th>
											
											</tr>
										</thead>
										<tbody>
										    <?php listpromotions($conn,$start,10,$searchval,$from,$to,$ttitle,$type);?>
											
										</tbody>
									</table>
                                    <nav aria-label="Page navigation example" style="text-align: right;">
                                    <ul class="pagination justify-content-end">
                                    
                                    <?php  echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to,$ttitle,$type); ?>
                                    
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
		<script src="../../js/jquery-ui.js"></script>  


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
				      function theFunction (id) {
							          
     var answer = confirm('Are you sure you want to delete this?');
if (answer)
{
    alert('yes'+id);
  console.log('yes');
  window.location = "tournament-del.php?id="+id;
}
else
{
    alert('No'+id);
  console.log('cancel');
}
    }
			
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