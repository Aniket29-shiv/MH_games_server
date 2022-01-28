<?php

include 'lock.php'; 
include 'config.php';
	include('include/withdraw-request-commission.php');
error_reporting(0);
date_default_timezone_set('Asia/Calcutta'); 
//converts dmy format date to ymd format 
	function date_ymd($dmy_date){
	    $explode_date = explode('-', $dmy_date);
	    $ymd_date = "";
	    $ymd_date = $explode_date[2] . "-" . $explode_date[1] . "-" . $explode_date[0];
	    return $ymd_date;
	}

/*
*	CHANGE STATUS OF TRANSACTION
*/
	if($_GET){
		$updated_on =  date('Y-m-d H:i:s'); 
		$id = $_GET['transaction_id'];
		$status = $_GET['status'];  
		$query = "update withdraw_request set status='{$status}',updated_on='{$updated_on}' where transaction_id=$id"; 
		$result_status = $conn->query($query);  
	}
	
/**	
 * SEARCH ON DATE
*/	 

	if($_POST){
		$start_date = date_ymd($_POST['start_date']);
		$end_date   = date_ymd($_POST['end_date']);
	 	$query  = "select wr.*,us.username,us.first_name from withdraw_request wr LEFT JOIN users us ON wr.user_id=us.user_id where wr.created_on BETWEEN '{$start_date}%' AND '{$end_date}%' ";  
	 	$result = $conn->query($query); 
	}else{
		$query  = "select wr.*,us.username,us.first_name from withdraw_request wr LEFT JOIN users us ON wr.user_id=us.user_id";
		$result = $conn->query($query);
	}  	



?>

<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
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
                                        
                                            <div class="col-md-3 col-xs-12">
                                                
                                                <lable>Search</lable>
                                                <input type="text" class="form-control" autocomplete="off" name="searchval" value="<?php echo $searchval;?>" placeholder="Search Player By Username, Mobile And Email">
                                            
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-3 col-xs-12">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="commission_withdraw_request.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">Member Withdraw Details ( Total Records : <?php echo numberofdata($conn,$searchval,$from,$to,$affiliate);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-withdraw-comm-Details.php">
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
                            
                                <?php  echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to,$affiliate); ?>
                            
                            </ul>
                        </nav>
                        
									<table class="table table-bordered table-hover">
										<thead>
										   	<tr>
												<th style="text-align:center">Sr No</th>
											    <th style="text-align:center">Name</th>
												<th style="text-align:center">Mobile No</th>
												<th style="text-align:center">Email</th>
												<th style="text-align:center">User Name</th>
												<th style="text-align:center">Request Amount</th> 
												<th style="text-align:center">Request Date</th>
												<th style="text-align:center">Status</th>
												<th style="text-align:center">Change Status</th>
												
											</tr>
											
										</thead>
										<tbody style="text-align:center">
										    <?php listpromotions($conn,$start,10,$searchval,$from,$to,$affiliate);?>
										
											 
										</tbody>
									</table>
									
                            <nav aria-label="Page navigation example" style="text-align: right;">
                                <ul class="pagination justify-content-end">
                                
                                    <?php  echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to,$affiliate); ?>
                                
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
            
            var dataString ='updatewithdrawstatuscommission='+status+'&trid='+trid;
            
             //alert(dataString);
                $.ajax({
                
                    type: "GET",
                    url:"ajax_function.php",
                    data: dataString,
                    cache: false,
                    success: function(data){
                    
                   alert('Status Changed Successfully');
                }
            });
            
            
        
        });
		
	  });
	</script>
</body>

</html>
<?php 	$conn->close();?>