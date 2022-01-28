<?php

	include 'lock.php';
	include 'config.php';  	
	include('include/helpsupport.php');
	$query = "select 
						* 
			  from 
					user_help_support as h
					inner join users as u on(h.user_id = u.user_id)"; 
		
	$result = $conn->query($query);   

	$status = '';
	$output = '';
	if($_GET){ 
		$status  = $_GET['status']; 
		$id = $_GET['id']; 
	  
		$update_status = "update user_help_support set status = '$status' where id = '$id'";
		$result1 = $conn->query($update_status); 
		$result = $conn->query($query); 
		if($result1)
		{
			$output = 1;
		} else {
			$output = 0;
		}
		
	}    
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
				<div class="sidebar-menu" data-widget="tree" id="sidebar-menu" ></div>
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
								<h3 class="box-title">Send message <a href="new-ticket.php" class="btn btn-primary" style="margin-left:10px;">Create New Ticket</a></h3>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                                        <form method="get">
                                        
                                            <div class="col-md-6">
                                                
                                                <lable>Search</lable>
                                                <input type="text" class="form-control" name="searchval" value="" placeholder="Search Player By Name, Mobile And Email">
                                            
                                            </div>
                                            <div class="col-md-3">
                                                
                                                <lable>Status</lable>
                                                <select class="form-control" name="statusval" >
                                                    <option value="">Select Status</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="Open">Open</option>
                                                    <option value="Close">Close</option>
                                                    </select>
                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="help_support.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">List  ( Total Records : <?php echo numberofdata($conn,$searchval,$statusval);?>)</h3>
								    </div>
								     
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval,$statusval); ?>
                        
                        </ul>
                        </nav>
										<table  style="text-align:center" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th style="text-align:center">Sr No.</th>
													<th style="text-align:center">User Name</th>
													<th style="text-align:center">Subject</th>
													<th style="text-align:center">Message</th>
													<th style="text-align:center">Status</th>
													<th style="text-align:center">Last Replay</th>
													<th style="text-align:center">Action</th>
													
													<th style="text-align:center">Detail</th>
												</tr>
											</thead>
											<tbody>
												<?php listpromotions($conn,$start,25,$searchval,$statusval);?>
											</tbody>
										</table>
										<nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval,$statusval); ?>
                        
                        </ul>
                        </nav>
									<!-- </form> -->
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
	
		<script>
$(function(){
		
     	$(".msgstatus").click(function(){
	     	var msgid = $(this).attr('data-id');
	     		var status = $(this).attr('data-status');
	     
	     
		 
         var dataString ='updatemessagestatus='+msgid+'&statusmasg='+status;
                //alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                window.location.href="";
                
                }
                });

		
		
		});
		
	
		
	  });
	</script>
</body>

</html>