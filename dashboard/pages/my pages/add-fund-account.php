<?php
include 'lock.php';
include 'config.php'; 
include('include/addfundtoplayer.php');
	$query = "select accounts.*,users.* from accounts  LEFT JOIN users ON accounts.userid=users.user_id order by users.user_id desc "; 
	$result = $conn->query($query);   
	$status = '';
	if($_GET){ 
	  $status = $_GET['status']; 
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
						<span id="success" style="display: none;"><div   class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Successfully!</strong>  fund Added to player account.....!
							</div></span>
							   
								
					<span id="fail" style="display: none;">
						
							 <div id="fail" class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail!</strong>  Error Occured...!
							</div>   </span>
							
					<span id="play" style="display: none;">
						
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Successfully!</strong> added play chips amount.....!
							</div>  
							</span>
							
					
						<span id="real" style="display: none;">
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Successfully!</strong> added real chips amount.....!
							</div>  
							
				</span>
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
                                        
                                            <div class="col-md-3">
                                                
                                                <lable>Search</lable>
                                                <input type="text" class="form-control" name="searchval" value="" placeholder="Search Player By Username, Mobile And Email">
                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="add-fund-account.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
                                            </div>
                                            
                                            <div class="box-footer with-border" style="text-align:right;">
                                            
                                            </div>
                                            
                                        </form>
							</div>
								</div>
									</div>
				<div class="row">
				
				
					<div class="col-xs-12">
						<div class="box">
							<div class="box-body">
							    <div class="box-header with-border">
							         <div class="col-md-8">
								        <h3 class="box-title">Add Fund ( Total Records : <?php echo numberofdata($conn,$searchval,$from,$to);?>)</h3>
								    </div>
								   <!-- <div class="col-md-4" style="text-align: right; margin-top: -9px;">
								        <form method="get" action="excel-Player-Details.php">
								             <input type="hidden" name="searchtxt" value="<?php echo $searchval;?>">
								            
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>-->
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval,$from,$to); ?>
                        
                        </ul>
                        </nav>
								
									<table  style="text-align:center" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th style="text-align:center">Sr No</th>
												<th style="text-align:center">Date</th>
												<th style="text-align:center">User Id</th>
												<th style="text-align:center">User Name</th>
												<th style="text-align:center">First Name</th>
												<th style="text-align:center">Email</th>
												<th style="text-align:center">Mob No</th>
												<th style="text-align:center">Play Chips</th>
												<th style="text-align:center">Real Chips</th>
												<th style="text-align:center">Action</th>
											</tr>
										</thead>
										<tbody>
										    
										     <?php listpromotions($conn,$start,25,$searchval,$from,$to);?>
											 <?php
											 	//if($result->num_rows > 0){
											 	//	$i = 1;
											 	//	while($row = $result->fetch_assoc()){
											 ?>
											 
										<!--	<tr>
												<td><?php //echo $i; ?></td> 
												<td><?php //echo $row['user_id']?></td> 
												<td><?php //echo $row['username']?></td> 
												<td><?php //echo $row['first_name']?></td> 
												<td><?php //echo $row['email']?></td> 
												<td><?php //echo $row['mobile_no']?></td> 
													<td>
													<input type="text" id="play_chips_<?php //echo $row['user_id']; ?>"name="play_chips_<?php //echo $row['user_id']; ?>" style="width:85%" autocomplete="off">
												<span id="fre_<?php //echo $row['user_id'];?>" style="display: none;margin-left: 1%; color: red;text-align:center">Please entered Free Chips!.</span>
												</td>
												<td>
													<input type="text" name="real_chips_<?php //echo $row['user_id']; ?>" id="real_chips_<?php //echo $row['user_id']; ?>"style="width:85%" autocomplete="off">
												<span id="rel_<?php // echo $row['user_id'];?>" style="display: none;margin-left: 1%; color: red;text-align:center">Please entered Real Chips!.</span>
												</td> 
												<td>
													<input type="hidden" name="acc_no[]"  value="<?php //echo $row['user_id']; ?>"> 
													<button name="submit" class="btn btn-primary btn-xs" onclick="add(<?php //echo $row['user_id']; ?>);">Add</button> 
												</td>
											</tr> -->
											<?php //$i++; } } ?>
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
		<script src="../../js/jquery-ui.js"></script>  
	<!-- page script -->
	<script>
	
	        function add(id){
                        var user_id=id;
            var play_chips = $('#play_chips_'+id+'').val();
	    
	    	var real_chips = $('#real_chips_'+id+'').val();
	         real_chips= Number(real_chips);
	    	 play_chips= Number(play_chips);
	    //	alert(user_id+"=="+play_chips+"=="+real_chips);
	      if(play_chips=== 0 && real_chips===0 ||play_chips== null && real_chips==null ){
	    	    
	    	     $('#rel_'+id+'').fadeIn().delay(5000).fadeOut();
	    	       $('#fre_'+id+'').fadeIn().delay(5000).fadeOut();
	    	}else{
	    	
			$.post("add-fund.php",
			{
				play_chips:play_chips,
	
				real_chips:real_chips,
				user_id:user_id,
			},
			function(data, status){
				{ 
				    if(data == 1){
					$('#success').fadeIn().delay(5000).fadeOut();
						var count = 6;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('add-fund-account.php');						}
							}, 1000);
					
					}
					else if(data == 3)
					{
						$('#real').fadeIn().delay(5000).fadeOut();
							var count = 6;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('add-fund-account.php');						}
							}, 1000);
					}else if(data == 4)
					{
						$('#play').fadeIn().delay(5000).fadeOut();
							var count = 6;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('add-fund-account.php');						}
							}, 1000);
					}else{
					    	$('#fail').fadeIn().delay(5000).fadeOut();
							var count = 6;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								window.location=('add-fund-account.php');						}
							}, 1000);
					    
					}
			}
		  
		});  
          }          }
	
	
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
</body>

</html>