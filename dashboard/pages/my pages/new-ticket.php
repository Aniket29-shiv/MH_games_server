<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	include('lock.php');
	include("config.php");
	
	include('include/ticketnew.php');
	

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
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link href="../../css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    
</head>

	<body class="hold-transition skin-blue sidebar-mini">
	    
<style>
.overlay {
    position: fixed;
    z-index: 999;
    height: 100%;
    width: 100%;
    top: 297px;
  
    /* left: 200px; */
    background-color: white;
    filter: alpha(opacity=60);
    opacity: 0.6;
    -moz-opacity: 0.8;
}
</style>
	    
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
							<div class="box-header with-border">
								<h3 class="box-title"> Ticket Details</h3><a href="help_support.php" class="btn btn-primary" style="margin-left:10px;">Tickets List</a>
							</div>
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body">
									<form role="form"  method="post" enctype="multipart/form-data">
										<div class="box-body">
									
											
											
											
											
											<div class="col-md-12 col-xs-12">	
                                         	<div class="form-group">
												<label >Search User</label><br />
												<input type="text"   name="username" id="uname" value="" class="typeahead tm-input form-control tm-input-info"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											
										
										
										
											
											<div class="col-md-12 col-xs-12">	
                                      	    <div class="form-group">
												<label style="width:30%">Subject</label><br />
                                                    <select  name="subject" style="width: 100%;padding: 10px;" required="">
                                                    <option value="" selected="">Select Subject</option>
                                                    <option value="Payment">Payment</option>
                                                    <option value="Technical Support">Technical Support</option>
                                                    <option value="Suggest">Suggest</option>
                                                    <option value="Other">Other</option>
                                                    </select>
											</div>
											</div>
											<div class="col-md-12 col-xs-12">	
                                        	<div class="form-group">
											<label style="width:30%">Message</label><br />
											<textarea required  class="form-control textarea"   name="message"><?php //echo $description;?></textarea>
											</div>
											</div>
                                         
											
										

												 
										</div>
									

								

                                        <div class="box-footer" style="text-align: right;">
                                           <input type="submit" name="submit" value="Send" class="btn btn-primary">
                                        </div>			
									
										
									
										
									
                        
                                        
                                        <?php  if($messagee != '') { ?>
                                        
                                        <div class="alert alert-danger alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $messagee;?>
                                        </div>
                                        <?php } ?>
                                         <?php  if($messages != '') { ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $messages;?>
                                        </div>
                                        <?php } ?>
									</form>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						</div>
					
				
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
		
        <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../bower_components/fastclick/lib/fastclick.js"></script>
        <script src="../../dist/js/adminlte.min.js"></script>
        <script src="../../dist/js/demo.js"></script>
        <script src="../../js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        
    
		<script>
		

			$('#pool_game').hide();
			$(function(){
					$("#sidebar-menu").load("sidebar-menu.html");
					$("#header").load("header.html");
					$("#footer").load("footer.html");
					$("#dashboard-settings").load("dashboard-settings.html");
				});
			
		</script>
		<script type="text/javascript">
              $(document).ready(function() {
                var tagApi = $(".tm-input").tagsManager();
            
            
                jQuery(".typeahead").typeahead({
                  name: 'username',
                  displayKey: 'name',
                  source: function (query, process) {
                    return $.get('ajaxpro.php', { query: query }, function (data) {
                      data = $.parseJSON(data);
                      return process(data);
                    });
                  },
                  afterSelect :function (item){
                    //tagApi.tagsManager("username", item);
                    $('#uname').val(item);
                  }
                });
              });
</script>
	
		
	
	</body>
</html>
