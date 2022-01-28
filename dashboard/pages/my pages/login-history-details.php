<?php

include 'lock.php'; 
include 'config.php';
	include('include/history-login-details.php');
error_reporting(0);
date_default_timezone_set('Asia/Calcutta'); 
//converts dmy format date to ymd format 
	function date_ymd($dmy_date){
	    $explode_date = explode('-', $dmy_date);
	    $ymd_date = "";
	    $ymd_date = $explode_date[2] . "-" . $explode_date[1] . "-" . $explode_date[0];
	    return $ymd_date;
	}

    $fname="";
    $lname="";
 $getuser=mysqli_query($conn,"select first_name ,last_name from users where user_id='$searchval'");
 
 if(mysqli_num_rows($getuser) > 0){
 
     $listuser=mysqli_fetch_object( $getuser);
     $fname=$listuser->first_name;
     $lname=$listuser->last_name;
     
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
	<!-- DataTables -->
	<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="../../css/jquery-ui.css">
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
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Search <a href="login-history.php" class="btn btn-primary" style="margin-left:10px;">Back</a> </h3>
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
                                        
                                              <input type="hidden" class="form-control" autocomplete="off"  name="searchval" value="<?php echo $searchval;?>" placeholder="TO date">
                                            
                                            <div class="col-md-3 col-xs-12">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="login-history-details.php?userid=<?php echo $searchval;?>" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">Login History Details Of - <span style="font-weight: 800;color: #0e5aea;"><?php echo strtoupper( $fname.' '.$lname);?></span>( Total Records : <?php echo numberofdata($conn,$searchval,$from,$to);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-login-history-Details.php">
								             <input type="hidden" name="userid" value="<?php echo $searchval;?>">
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
                        
									<table class="table table-bordered table-hover">
										<thead>
										    
										   	<tr>
												<th style="text-align:center">Sr No</th>
												<th style="text-align:center">Username</th>
												<th style="text-align:center">OS</th>
												<th style="text-align:center">IP</th>
												<th style="text-align:center">City</th>
												<th style="text-align:center">Region</th>
												<th style="text-align:center">Country</th>
												<th style="text-align:center">Status</th>
												<th style="text-align:center">Login Date</th>
												<th style="text-align:center">Logout Date</th>
											
												
											</tr>
											
										</thead>
										<tbody style="text-align:center">
										    <?php listpromotions($conn,$start,10,$searchval,$from,$to);?>
											<?php 
												//$i=1;
											//if($result->num_rows > 0){
												//	while($row = $result->fetch_assoc()){
											?>
										<!--	<tr> 
												<td><?php //echo $i; ?></td>
												<td><?php //echo $row['transaction_id']; ?></td>
												<td><?php //echo $row['user_id']; ?></td>
												<td><?php //echo $row['username']; ?></td>
												<td><?php //echo $row['requested_amount']; ?></td>
												<td><?php //echo $row['created_on']; ?></td>
												<td>
													<?php //if($row['status']=="Pending"){ ?>
														<button class="btn btn-default btn-xs">Pending</button>

														<a href="



withdrawal-request.php?transaction_id=<?php //echo $row['transaction_id']; ?>&status=Process"><button class="btn btn-primary btn-xs">Process</button></a>

														<a href="



withdrawal-request.php?transaction_id=<?php //echo $row['transaction_id']; ?>&status=Paid"><button class="btn btn-success btn-xs">Paid</button></a>

													<?php //}elseif($row['status']=='Paid'){ ?>
													<a href="



withdrawal-request.php?transaction_id=<?php //echo $row['transaction_id']; ?>&status=Pending"><button class="btn btn-danger btn-xs">Pending</button></a>
													<a href="



withdrawal-request.php?transaction_id=<?php //echo $row['transaction_id']; ?>&status=Process"><button class="btn btn-primary btn-xs">Process</button></a>
														<button class="btn btn-default btn-xs">Paid</button>

													<?php //}elseif ($row['status']=='Process') {  ?>
													<a href="



withdrawal-request.php?transaction_id=<?php //echo $row['transaction_id']; ?>&status=Pending"><button class="btn btn-danger btn-xs">Pending</button></a>
														<button class="btn btn-default btn-xs">Process</button>
															<a href="



withdrawal-request.php?transaction_id=<?php //echo $row['transaction_id']; ?>&status=Paid"><button class="btn btn-success btn-xs">Paid</button></a>
													<?php //}else{ ?>
														<button class="btn btn-danger btn-xs">Reversed</button>
													<?php //} ?>

													
												
													
												</td>
											</tr>-->
											<?php //$i++; } } ?>
											 
										</tbody>
									</table>
									
                            <nav aria-label="Page navigation example" style="text-align: right;">
                                <ul class="pagination justify-content-end">
                                
                                    <?php  echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to); ?>
                                
                                </ul>
                            </nav>
								</div>
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
	<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap datepicker -->
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	 
	<!-- FastClick -->
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
	<!-- date-range-picker -->
	<script src="../../bower_components/moment/min/moment.min.js"></script>
	<!-- FastClick -->
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
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
$(function(){
		
     
		
        $(".changestatus").change(function(){
        
            var trid = $(this).attr('data-id');
            var status = $(this).val();
            
             $('#statustxt'+trid).text('');
             $('#statustxt'+trid).text(status);
            
            //alert(status+'=='+trid);
            
            var dataString ='updatewithdrawstatus='+status+'&trid='+trid;
            
            //  alert(dataString);
                $.ajax({
                
                    type: "GET",
                    url:"ajax_function.php",
                    data: dataString,
                    cache: false,
                    success: function(data){
                    
               // window.location.href="";
                }
            });
            
            
        
        });
		
	  });
	</script>
</body>

</html>
<?php 	$conn->close();?>