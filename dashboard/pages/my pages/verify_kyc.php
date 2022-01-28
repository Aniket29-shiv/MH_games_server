<?php

include 'lock.php';
include 'config.php'; 
include('include/kycverify.php');	
		$query 	= "SELECT 
							kd.userid, 
							u.username, 
							concat(ifnull(u.first_name,''),' ',ifnull(u.middle_name,''),' ',ifnull(u.last_name,'')) AS player_name, 
							ifnull(u.mobile_no,'') AS mobile_no, 
							ifnull(u.email,'') AS email,
							ifnull(kd.id_proof,'Not Mentioned') AS id_proof,
							kd.id_proof_url,
							ifnull(kd.pan_no,'Not Mentioned') AS pan_no,
							kd.pan_card_url,
							kd.id_proof_status,
							kd.pan_status
					from 
							users as u
							INNER JOIN user_kyc_details AS kd ON (kd.userid = u.user_id)"; 
					
	$result 	= $conn->query($query);   


	//CHANGE STATUS OF player documents start
	$player_Status = '';
	if($_GET){
		$updated_on 	= date('Y-m-d H:i:s'); 
		$user_id 		= $_GET['userid'];
		$status 		= $_GET['status'];  
		$query2 		= "update user_kyc_details set id_proof_status='{$status}', pan_status='{$status}' where userid=$user_id"; 
		$result_status  = $conn->query($query2); 
		if($result_status)
		{
			$player_Status = 1;
		} else {
			$player_Status = 2;
		}
		$result 			= $conn->query($query);
		
	}
	
	//CHANGE STATUS OF player documents end
?>
<style>
.dot {
  height: 10px;
    width: 10px;
    background-color: #f70909;
  border-radius: 50%;
  display: inline-block;
}

.dot1 {
  height: 10px;
    width: 10px;
    background-color:blue;
  border-radius: 50%;
  display: inline-block;
}
</style>
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
	<!-- Theme style --><link rel="stylesheet" href="../../css/jquery-ui.css">
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
					<?php  //if($player_Status==1){ ?>
						
						<!-- <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong>  Record Updated.....!
							</div>  
							
					<?php //} if($player_Status==2) { ?>
						
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail!</strong>  Error Occured...!
							</div>  --> 
					<?php //} ?>
					<section class="content">

					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Search Documents </h3>
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
                                                <input type="text" class="form-control" name="searchval" value="" placeholder="Search Player By Name, Mobile, Email And Username">
                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="verify_kyc.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">Users Document Verification</h3> ( Total Records : <?php echo numberofdata($conn,$searchval,$from,$to);?>)</h3>
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-kyc.php">
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
												<th style="text-align:center">Full Name</th>
												<th style="text-align:center">User Name</th>
												<th style="text-align:center">Email <br /><p style="font-size: 10px;"><span class="dot"></span> Not Verified , <span class="dot1"></span> Verified</p></th>
												<th style="text-align:center">Mobile No <br /><p style="font-size: 10px;"><span class="dot"></span> Not Verified , <span class="dot1"></span> Verified</p></th>
												<th style="text-align:center">ID Proof File</th>
												<th style="text-align:center">Verification</th>
											
												<th style="text-align:center">Pan Card File </th>
												<th style="text-align:center">Verification</th>
											
											</tr>
										</thead>
										<tbody style="text-align:center">
										    <?php listpromotions($conn,$start,25,$searchval,$from,$to);?>
										
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
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
	<!-- page script -->
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
	</script>
	
		<script>
$(function(){
		
     	$(".idproofverify").click(function(){
	     	var kycid = $(this).attr('data-id');
	     
	     $('#idproof'+kycid).hide();
	      $('#idproofv'+kycid).show();
	     
		   //alert(changenoid+'=='+number);
		
          dataString ='idproofverification='+kycid;
               // alert(dataString);
                
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
               // alert("ID Proof Verified Successfully");
                
                }
                });

		
		
		});
 	
		$(".panproofverify").click(function(){
		    
                var kycid = $(this).attr('data-id');
                
                $('#panproof'+kycid).hide();
	           $('#panproofv'+kycid).show();
                
                var dataString ='panverification='+kycid;
                //  alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                
                
                }
                });
                
                
                
                });
		
	  });
	</script>
</body>

</html>