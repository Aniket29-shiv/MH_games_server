<?php 
	include ('lock.php');
	include ('config.php');
	include('include/listnotificationtoplayer.php');
  //$query = "select users.*,accounts.play_chips,accounts.real_chips from users LEFT JOIN accounts ON users.user_id=accounts.userid";
  //$result = $conn->query($query);  
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
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
								<h3 class="box-title">Send Notification</h3><a href="notification-player.php" class="btn btn-primary" style="margin-left:10px;">Create New</a>
							</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Search </h3>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                                        <form method="get">
                                        
                                            <div class="col-md-6">
                                                
                                                <lable>User Type</lable>
                                                <select name="searchval" required class="form-control" id="searchval" style="padding:5px 0px; width:100%">
                                                    <option value="">Select User</option>
                                                      <option value="Indivisual">Indivisual</option>
                                                        <option value="All Player">All Player</option>
                                                    </select>
                                            
                                            </div>
                                            
                                            <div class="col-md-6">
                                            
                                                <input type="submit" class="btn btn-primary" name="search" value="Search" style="margin-top: 19px;">
                                                <a href="notification-list.php" class="btn btn-danger"  style="margin-top: 19px;">Cancel</a>
                                            
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
								        <h3 class="box-title">Players Notifications List ( Total Records : <?php echo numberofdata($conn,$searchval);?>)</h3>
								    </div>
								     <!--<div class="col-md-4" style="text-align: right; margin-top: -9px;">
								         <form method="get" action="excel-player-notifications.php">
								             <input type="hidden" name="searchtxt" value="<?php echo $searchval;?>">
								            
								        <input type="submit" class="btn btn-primary excelbtn" name="excel" Value="Excel">
								        </form>
								    </div>-->
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                        <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval); ?>
                        
                        </ul>
                        </nav>
								
									<table  style="text-align:left" class="table table-bordered">
										<thead>
											<tr>
											    
												<th>Sr No.</th>
												<th>Send Type</th>
												<th>Send Date</th>
												<th>Name</th>
												<th>Username</th>
												<th>Title</th>
												<th>Message</th>
												<th>Send Status</th>
												<th>Read Status</th>
												<th>Read count</th>
												
											</tr>
										</thead>
										<tbody>
										    
                                            <?php listpromotions($conn,$start,25,$searchval);?>
                                            
                                            <?php 
                                            
                                            //$i=1; if($result->num_rows > 0){ 
                                            //while($row=$result->fetch_assoc()){ ?>
                                            <!--	<tr>
                                            <td><?php //echo $i; ?></td> 
                                            <td><?php //echo $row['first_name']; ?></td> 
                                            <td><?php //echo $row['mobile_no']; ?></td> 
                                            <td><?php //echo $row['email']; ?></td> 
                                            <td><?php //echo $row['username']; ?></td> 
                                            <td><?php //echo $row['play_chips']; ?></td> 
                                            <td><?php //echo $row['real_chips']; ?></td> 
                                            <td>
                                            <a href="edit_user.php?id=<?php //echo $row['user_id'] ?>" id="edit_row_<?php //echo $row['user_id']; ?>"><i class="glyphicon glyphicon-edit" title="Edit"  aria-hidden="true"></i></a>&nbsp 
                                            <a href="#" id="save_row_<?php //echo $row['user_id']; ?>" style="display:none"><i class="glyphicon glyphicon-save" title="Save"  aria-hidden="true"></i></a>&nbsp 
                                            <a href="#"><i class="glyphicon glyphicon-trash" title="Delete" aria-hidden="true"></i></a>
                                            </td>
                                            </tr> 
                                            -->
                                            <?php //$i++; } }  ?>
										</tbody>
									</table>
							  <nav aria-label="Page navigation example" style="text-align: right;">
                        <ul class="pagination justify-content-end">
                        
                        <?php echo paginate($reload, $pagenum, $tpages,$searchval); ?>
                        
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

	<script>
		$(function(){
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
					$('#user_details').DataTable()
			});
	</script>
	
</body> 
</html>