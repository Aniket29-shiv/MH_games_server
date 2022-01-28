<?php 

	include ('lock.php');
	include ('config.php');
		include('include/transaction_referral.php');
	
//	$query = "SELECT * FROM `company_balance` ORDER BY `company_balance`.`date` DESC";
//	$result = $conn->query($query);  
?>

<!DOCTYPE html>
<html>
 <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
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
	

	<style>
	.typeahead { border: 2px solid #FFF;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 290px;background: rgba(66, 52, 52, 0.5);color: #FFF;}
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;color:#FFF;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.bgcolor {max-width: 550px;min-width: 290px;max-height:340px;background:url("world-contries.jpg") no-repeat center center;padding: 100px 10px 130px;border-radius:4px;text-align:center;margin:10px;}
	.demo-label {font-size:1.5em;color: #686868;font-weight: 500;color:#FFF;}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #1f3f41;
		outline: 0;
	}
	</style>
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
							
							 <!--<div class="col-md-2 col-xs-12">
						         <lable>Chip Type</lable><br />
						   	<div class="dropdown">
						   	   
						   	    <select class="btn btn-primary" name="chiptype">
						   	        <option value="">Chip Type</option>
						   	        <option value="free">Free</option>
						   	         <option value="real">Real</option>
						   	      
						   	        
						   	    </select>
							
							</div>
							</div>-->
							 <div class="col-md-2 col-xs-12">
						         <lable>Status Type</lable><br />
						   	<div class="dropdown">
						   	   
						   	    <select class="btn btn-primary" name="status">
						   	        <option value="">Status Type</option>
						   	        <option value="Won">Won</option>
						   	         <option value="Lost">Lost</option>
						   	      
						   	        
						   	    </select>
							
							</div>
							</div>
							
							<!--<div class="col-md-2 col-xs-12">
						         <lable>User</lable><br />
						   	<div class="dropdown">
						   	   
						   	    <select class="btn btn-primary" name="refid">
						   	        <option value="">select user</option>
						   	       <?php //userlist($conn);?>
						   	        
						   	    </select>
							
							</div>
							</div>-->
							<div class="col-md-2 col-xs-12">
                         <lable>Search Referral user</lable>
                             <input type="text" class="form-control" autocomplete="off" style="width:100%;" id="txtCountry" class="typeahead" name="refid" value="" placeholder="Search By Username name">
                        </div>
                        <div class="col-md-2 col-xs-12">
                         <lable>Player</lable>
                             <input type="text" class="form-control" autocomplete="off"  name="players" value="" placeholder="Search By Player Username">
                        </div>
                        
                         <div class="col-xs-1">
                        
                       
						  
                        </div>
                         <div class="col-xs-1">
                       
						    
                       
                        </div>
                        
                        	<div class="box-footer with-border" style="text-align:right;"><input type="submit" style="margin-top:16px;" class="btn btn-primary" name="search" value="Search">
                        	<a href="referral_transaction.php" style="margin-top:16px;"   class="btn btn-danger">Cancel</a></div>
							
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
								        <h3 class="box-title">Player Transactions Detail ( Total Records : <?php echo numberofdata($conn,$game,$players,$from,$to,$chiptype,$status,$refid);?>)
								        </h3>
								        <?php //if($refid != ''){?>
								        <div class="row">
								        <div class="col-md-4" style="background: #d8d3af; padding: 5px;width: 49%;font-size: 18px;margin: 1px;">
								        <span style="color:green;">Total Won Commission : </span><span>Rs.
								        <?php  
								             $win_comm=number_format(wincomm($conn,$game,$players,$from,$to,$chiptype,$status,$refid),2);
								             echo $win_comm;
								        ?>/-</span>
								        </div>
								         <div class="col-md-4" style="background: #d8c6af; padding: 5px; width: 49%; font-size: 18px;margin: 1px;">
								        <span style="color:red;">Total Lost Commission : </span><span>Rs. 
								        <?php 
								             $loss_commi= number_format(losscomm($conn,$game,$players,$from,$to,$chiptype,$status,$refid),2);
								             echo $loss_commi
								         ?>/-</span>
								         </div>
								         <div class="col-md-4" style="background: #d8c6af; padding: 5px; width: 49%; font-size: 18px;margin: 1px;">
								        <span style="color:red;">Total Commission : </span><span>Rs. <?php echo $win_comm+$loss_commi;?>/-</span>
								         </div>
								         </div>
								         <?php //} ?>
								        
								    </div>
								     <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-referral-commission.php">
								             <input type="hidden" name="games" value="<?php echo $game;?>">
								             <input type="hidden" name="player" value="<?php echo $players;?>">
								              <input type="hidden" name="fdate" value="<?php echo $from;?>">
								             <input type="hidden" name="tdate" value="<?php echo $to;?>">
								             <input type="hidden" name="ctype" value="<?php echo $chiptype;?>">
								             <input type="hidden" name="gstatus" value="<?php echo $status;?>">
								             <input type="hidden" name="losscommi" value="<?php echo $losscommi;?>">
								             <input type="hidden" name="refid" value="<?php echo $refid;?>">
								             <input type="hidden" name="wincommi" value="<?php echo $wincommi;?>">
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$game,$players,$from,$to,$chiptype,$status,$refid); ?>
                        
                        </ul>
                        </nav>
                        
                 
								
									<table  style="text-align:center" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>Sr No.</th>
												<th>Date</th>
												<th>Table Id</th>
												<th>Round Id</th>
												<th>Table Name</th>
												<th>Player Name</th>
													<th>Username</th>
												<th>Game Type</th>
												<th>Status</th>
												<th>Amount</th>
												<?php //if($refid != ''){?>
												<th>Referral Commission</th>
												<th>Referral Name</th>
												<?php //}?>
												<th>Chip Type</th>
												
											</tr>
										</thead>
										<tbody>
										    <?php listpromotions($conn,$start,25,$game,$players,$from,$to,$chiptype,$status,$refid);?>
											</tbody>
									</table>
                                    <nav aria-label="Page navigation example" style="text-align: right;">
                                    <ul class="pagination justify-content-end">
                                    
                                    <?php echo paginate($reload, $pagenum, $tpages,$game,$players,$from,$to,$chiptype,$status,$refid); ?>
                                    
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
	 <script type="text/javascript" src="typeahead.js"></script>
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
	<script>
    $(document).ready(function () {
        $('#txtCountry').typeahead({
            source: function (query, result) {
                //alert(query);
                $.ajax({
                    url: "autocomplete_username.php",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
    });
</script>
</body> 
</html>