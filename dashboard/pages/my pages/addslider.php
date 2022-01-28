<?php
	include('lock.php');
	include("config.php");
	include('include/slideradd.php');
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
					

						<div class="col-md-12  col-xs-12">
							<div class="box-header text-center with-border">
								<h3 class="box-title">Add Web Slider</h3>
							</div>
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body">
									<form role="form"  method="post" enctype="multipart/form-data">
										<div class="box-body">
										<div class="col-md-6 col-xs-6">	
                                      	<div class="form-group">
												<label style="width:30%">Title</label><br />
												<input type="text" name="title" required  id="table_name" style="padding:5px 0px; width:100%">
											</div>
											</div>
                                         <div class="col-md-6 col-xs-6">	
											<div class="form-group">
												<label >Image (<span style="color:blue;"> Dimension Must Be 958*460 </span>)</label>
												<input type="file" tabindex="20" name="pimage" />
											</div>
											</div>

												 
										</div>
										
								

									 <div class="box-footer" style="text-align: right;">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>			
									
										
										<!-- <div class="box-footer text-center">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>/.box-body -->
										
										
										
                                        <?php  if($status==1){ ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px; width:26%;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> Record Saved.....!
                                        </div>
                                        
                                        <?php } if($status==2) { ?>
                                        
                                        <div class="alert alert-danger alert-dismissable fade in" style="padding: 6px; width:26%;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Fail....!</strong>  Error Occured...!
                                        </div>
                                        <?php } ?>
									</form>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						</div>
						<div class="row">
						
						
						<div class="col-md-12  col-xs-12">
							<div class="box-header text-center with-border">
								<h3 class="box-title">Slider Details</h3>
							</div>
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body">
									
									<table  class="table table-bordered">
									<thead>
										<tr>
											<th>ID</th>
											<th>Title</th>
												
											<th>Image</th>
											<th>serial Number</th>
											<th>Deleted</th>
										
										</tr>
									</thead>
									<tbody>
										<?php listslider($conn);?>
									</tbody>
								</table>
									
									
									
									
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
		

			$('#pool_game').hide();
			$(function(){
					$("#sidebar-menu").load("sidebar-menu.html");
					$("#header").load("header.html");
					$("#footer").load("footer.html");
					$("#dashboard-settings").load("dashboard-settings.html");
				});
			
		</script>
		
		
		
	<script>
$(function(){
		
     	$(".serialno").change(function(){
	     	var changenoid = $(this).attr('data-id');
	     	var number = $(this).val();
	     
		  // alert(changenoid+'=='+number);
		
          var dataString ='addserialnumber='+changenoid+'&number='+number;
              //  alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                
                if(data == 1){
                    alert("Added sccessfully");
                }else{
                     alert("Number Alredy Use");
                }
                		
                 
                
                }
                });

		
		
		});
		
	

		
		
	
});
	</script>
	</body>
</html>
