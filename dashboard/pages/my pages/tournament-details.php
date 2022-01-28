<?php 
	include ('lock.php');
	include ('config.php');
	include ('include/detail-tournament.php');
	
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
			    <div class="box-header with-border">
								<h3 class="box-title">Add New Tournament</h3><a href="tournament.php" class="btn btn-primary" style="margin-left:10px;">New Tournament</a>
							</div>
				<div class="row">
				    	<?php  if($status==1){ ?>
						
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> Tournament Status Changed .....!
							</div>  
							
						<?php } if($status==2) { ?>
						
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured...!
							</div>   
						<?php }?>
							<?php  if($status==3){ ?>
						
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> Tournament Deleteed  Successfully.....!
							</div>  
							
						<?php } if($status==4) { ?>
						
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured On Tournament Delete...!
							</div>   
						<?php }
							if($status==5){ ?>
						
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> Record Updated.....!
							</div>  
							
						<?php }?>
			
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
                                                <input type="text" class="form-control" autocomplete="off" name="searchval" value="<?php echo $searchval;?>" placeholder="Search Title">
                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="tournament-details.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">Member Withdraw Details ( Total Records : <?php echo  numberofdata($conn,$searchval,$from,$to);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-tournament-Details.php">
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
												<th>Tournament ID</th>
												<th>Title</th>
												<th>Price</th>
												<th>Start Date</th>
												<th>Start Time</th>
												<th>Date</th>
												<th>Winners</th>
												<th>Joined</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										    <?php listpromotions($conn,$start,10,$searchval,$from,$to);?>
											<?php //$i=1; if($result->num_rows > 0){ 
												//while($row=$result->fetch_assoc()){ ?>
                                                    <!--<tr>
                                                    <td><?php //echo $i; ?></td> 
                                                    <td><?php //echo $row['tournament_id']; ?></td> 
                                                    <td><?php //echo $row['title']; ?></td> 
                                                    <td><?php //echo $row['price']; ?></td>
                                                    <td><?php //echo $row['start_date']; ?></td>
                                                    <td><?php //echo $row['start_time']; ?></td>
                                                    <td><?php //echo $row['created_date']; ?></td>
                                                    <td>
                                                    <a href="tournament-view.php?id=<?php //echo $row['tournament_id'] ?>"><i class="glyphicon glyphicon-list-alt" title="view" aria-hidden="true"></i></a>&nbsp;
                                                    <a href="#" onclick=" theFunction(<?php //echo $row['tournament_id'] ;?>);"><i class="glyphicon glyphicon-trash" title="Delete" aria-hidden="true"></i></a>
                                                    </td>	
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