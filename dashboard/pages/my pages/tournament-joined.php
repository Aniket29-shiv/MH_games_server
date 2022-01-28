<?php 
	include ('lock.php');
	include ('config.php');
	include ('include/joined-tournament.php');
	
?>

<!DOCTYPE html>
<html>
 <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MBCHESS Admin Panel</title>
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
								<h3 class="box-title">Tournament Joined Detail </h3><button onclick="goBack()" class="btn btn-primary" style="margin-left:10px;">Go Back</button>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">  

							
                                        <form method="get">
                                              <div class="col-md-4" style="margin-bottom: 15px;text-align: center;  font-size: 18px; font-weight: 800;">
                                                <lable>Title</lable><br />
                                                <input type="text" disabled style="width:100%;background: #a2f1f1;font-size: 15px; text-align: center;padding: 5px;" value="<?php echo $title;?>">
                                              </div>
                                              <div class="col-md-3" style="margin-bottom: 15px; text-align: center;  font-size: 18px; font-weight: 800;">
                                                <lable>Price</lable><br />
                                                <input type="text" style="width:100%;background: #a2f1f1;font-size: 15px;text-align: center;padding: 5px;" disabled value="<?php echo $price;?>">
                                              </div>
                                              <div class="col-md-3" style="margin-bottom: 15px;text-align: center;   font-size: 18px; font-weight: 800;">
                                                <lable>Entry Fee</lable><br />
                                                <input type="text" style="width:100%;background: #a2f1f1;font-size: 15px; text-align: center;padding: 5px;" disabled value="<?php echo $entry_fee;?>">
                                              </div>
                                              <div class="col-md-2" style="margin-bottom: 15px;text-align: center;   font-size: 18px; font-weight: 800;">
                                                <lable>Players</lable><br />
                                                <input type="text" style="width:100%;background: #a2f1f1;font-size: 15px; text-align: center;padding: 5px;" disabled value="<?php echo $players;?>">
                                              </div>
                                              <div class="col-md-4" style="margin-bottom: 15px;text-align: center;   font-size: 18px; font-weight: 800;">
                                                <lable>Start Date</lable><br />
                                                <input type="text" style="width:100%;background: #a2f1f1;font-size: 15px; text-align: center;padding: 5px;" disabled value="<?php echo $start_date;?>">
                                              </div>
                                              <div class="col-md-4" style="margin-bottom: 15px;text-align: center;   font-size: 18px; font-weight: 800;">
                                                <lable>Reg Start Date</lable><br />
                                                <input type="text" style="width:100%;background: #a2f1f1;font-size: 15px; text-align: center;padding: 5px;" disabled value="<?php echo $reg_start_date;?>">
                                              </div>
                                              <div class="col-md-4" style="margin-bottom: 15px;text-align: center;   font-size: 18px; font-weight: 800;">
                                                <lable>Reg End Date</lable><br />
                                                <input type="text" style="width:100%;background: #a2f1f1;font-size: 15px; text-align: center;padding: 5px;" disabled value="<?php echo $reg_end_date;?>">
                                              </div>
                                            
                                           
                                            
                                        </form>
							</div>
								</div>
									</div>
										</section>
									
									<section class="content">
						
				<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
							<div class="box-body table-responsive">
							     <div class="box-header with-border">
							         <div class="col-md-8">
								        <h3 class="box-title">Tournament Joined Details ( Total Records : <?php echo  numberofdata($conn,$tid).' / '.$players;?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-joined-player.php">
								             <input type="hidden" name="searchtxt" value="<?php echo $tid;?>">
								           
								            
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                                   
									<table  style="text-align:center" class="table table-bordered table-hover">
										<thead>
											<tr>
                                            <th>Sr No.</th>
                                            <th>Username</th>
                                            <th>Player Name</th>
                                            
                                            <th>Fees</th>
                                            <th>Joined date</th>
                                            
											</tr>
										</thead>
										<tbody>
										    <?php listpromotions($conn,$tid);?>
										
										</tbody>
									</table>
                                    
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
	<script>
function goBack()
  {
  window.history.back()
  }
</script>
</body> 
</html>