<?php 
	include('lock.php');
	include('config.php');  
	$status = ''; 
	date_default_timezone_set('Asia/Calcutta');
	if($_GET){ 
	  $user_id   = $_GET['user_id']; 
	  $user_name = $_GET['user_name']; 
	  $query  	 = "select * from bank_details where user_id=$user_id";
	  $result 	 = $conn->query($query);
	  $result    = $result->fetch_assoc();
	}  

	if(isset($_POST['btnSubmit'])){ 
		$pageData = $_POST;  
	 	$updated_on = date("Y-m-d H:i:s");
		$query_update = "update bank_details set bank_name='{$pageData['bank_name']}',account_no='{$pageData['account_no']}',ifsc_code='{$pageData['ifsc_code']}',updated_on='{$updated_on}' where user_id={$pageData['user_id']} ";  

		$update_result = $conn->query($query_update);
		 
		if($update_result){
			header("Location:bank-details.php?status=1");
		}else{
			header("Location:bank-details.php?status=2");
		} 
	} 
	$conn->close();
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
				<!-- Content Header (Page header) -->
				<section class="content">
					<div class="row">  
						<div class="col-md-7 col-md-offset-3 col-xs-12">
							<div class="box-header text-center with-border">
								<h3 class="box-title">Bank Details</h3>
							</div>
							<div class="box"> 
								<!-- /.box-header -->
								<div class="box-body">
									<form role="form" action="" method="post" name="bank_details" id="bank_details" enctype="multipart/formdata"> 
										<div class="box-body">  
											<div class="form-group">
												<label style="width:30%">User Full Name</label>:
												<input type="text" name=""  id="" style="padding:5px 0px; width:67%" value="<?php echo $user_name; ?>" readonly >
											</div> 
											<div class="form-group">
												<label style="width:30%">Bank Name</label>:
												<input type="text" name="bank_name" id="bank_name" style="padding:5px 0px; width:67%" value="<?php echo $result['bank_name']; ?>">
											</div>
											<div class="form-group">
												<label style="width:30%">Account No</label>:
												<input type="text" name="account_no" id="account_no" style="padding:5px 0px; width:67%" value="<?php echo $result['account_no']; ?>">
											</div>
											<div class="form-group">
												<label style="width:30%">IFSC Code</label>:
												<input type="text" name="ifsc_code" id="ifsc_code" style="padding:5px 0px; width:67%" value="<?php echo $result['ifsc_code']; ?>">
											</div> 
										</div>
										<!-- /.box-body -->
										<div class="box-footer text-center">
											<input type="hidden" name="user_id" id="user_id" style="padding:5px 0px; width:67%" value="<?php echo $result['user_id']; ?>">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>
									</form>
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
	 
		<!-- FastClick -->
		<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="../../dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="../../dist/js/demo.js"></script> 

		<script src="../../js/jquery.validate.min.js"></script> 
		<script> 
			$("#bank_details").validate({
				rules: { 
					bank_name:"required",
					account_no:"required",
					ifsc_code :"required",
				 
					}, 
		}); 


			$('#pool_game').hide();
			$(function(){
					$("#sidebar-menu").load("sidebar-menu.html"); 
					$("#header").load("header.html"); 
					$("#footer").load("footer.html");
					$("#dashboard-settings").load("dashboard-settings.html"); 				
				});
			function get_game_type(game_type){
			
				if(game_type=="Pool Rummy"){
					$('#pool_game').show();
				}else{
					$('#pool_game').hide();
				}
			}
		</script>
	</body> 
</html>