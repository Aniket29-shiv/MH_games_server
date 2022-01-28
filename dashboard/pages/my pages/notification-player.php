<?php
    include('lock.php');
    include("config.php");
    require_once __DIR__ . '/firebase/firebase.php';
    require_once __DIR__ . '/firebase/push.php';
    
   
    include("include/firebas-notification.php");

?>

<!DOCTYPE html>
<html>
	 <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rummy Admin Panel</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link href="../../css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    
</head>

	<body class="hold-transition skin-blue sidebar-mini">
	    
<style>
.tm-tag .tm-tag-remove {
    color: #ffff;
    font-weight: bold;
    margin-left: 4px;
    opacity: 2.2;
}
.tm-tag.tm-tag-info {
    color: #f4f4f7;
    background-color: #1c3077;
    border-color: #070ae6;
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
								<div class="box-header with-border">
								<h3 class="box-title">Notification Details</h3><a href="notification-list.php" class="btn btn-primary" style="margin-left:10px;">View List</a>
							</div>
							</div>
							<div class="box">
							    <h3 class="box-title" style="text-align:center;">Send Notifications</h3>
								<!-- /.box-header -->
								<div class="box-body">
									<form role="form"  method="post">
									    
										
									<div class="box-body">
										    
										<div class="col-md-12 col-xs-12">	
                                      	    <div class="form-group">
												<label style="width:30%">Player Type</label><br />
                                                    <select name="ptype" required class="form-control" id="ptype" style="padding:5px 0px; width:100%">
                                                         <option value="">Select Type</option>
                                                        <option value="Indivisual">Indivisual</option>
                                                        <option value="All Player">All Player</option>
                                                        <option value="fail">Fail</option>
                                                    </select>
											</div>
										</div>
										
										<div class="col-md-12 col-xs-12" id="regid" style="display:none">	
                                         	<div class="form-group">
												<label >Player UserName</label><br />
												<input type="text" multiple="true" name="fireregid"  class="typeahead tm-input form-control tm-input-info" placeholder="Search Username" style="padding:5px 0px; width:100%">
											</div>
										</div>
										
										<div class="col-md-12 col-xs-12" id="titlediv" >	
                                         	<div class="form-group">
												<label >Title</label><br />
												<input type="text"  autocomplete="off" name="title" value=""  style="padding:5px 0px; width:100%">
											</div>
										</div>
    									<div class="col-md-12 col-xs-12" id="msgdiv">	
                                          	<div class="form-group">
    											<label style="width:30%">Message</label><br />
    											<textarea  id="msg" class="form-control"   name="message"></textarea>
    										</div>
    								    </div>
                                   
									
                                        <div class="box-footer" style="text-align: right;">
                                           <input type="submit" name="send_notif" value="Send" class="btn btn-primary">
                                        </div>			
									<?php if($count > 0){?>
									<p style="text-align:center;"></p><span style="background: green; padding: 7px; color: white;float-left">Total <?php echo $count;?> Notification send</span></p>
									<?php }?>
										<?php if($countf > 0){?>
									<p style="text-align:center;margin-top:17px;"></p><span style="background: red; padding: 7px; color: white;margin-left: 10px;">Total <?php echo $countf;?> Notification Fail</span></p>
									<?php }?>
									
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
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
		<script src="../../js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
		
		 <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="typeahead.js"></script>
 
    <script>
	$(function () {	$(".textarea").wysihtml5();	});
   </script>
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
		
     	$("#ptype").change(function(){
	    
            	var ptype=$('#ptype').val();
            	
                if(ptype == 'All Player'){ 
                    
                $('#regid').hide();	
                 $('#titlediv').show();	
                  $('#msgdiv').show();	
                
                }
                
                if(ptype == 'Indivisual'){ 
                $('#regid').show();	
                  $('#titlediv').show();	
                  $('#msgdiv').show();
                
                }
                
                if(ptype == 'fail'){ 
                $('#regid').hide();	
                  $('#titlediv').hide();	
                  $('#msgdiv').hide();
                
                }

            	
            		
		});
	

		
		
	
});
	</script>
	<script>
    /*$(document).ready(function () {
    
        $('#txtCountry').typeahead({
            source: function (query, result) {

                $.ajax({
                    url: "server.php",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
						  // alert(item);
							return item;
                        }));
                    }
                });
            }
        });
    });*/
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var tagApi = $(".tm-input").tagsManager();


    jQuery(".typeahead").typeahead({
      name: 'fireregid',
      displayKey: 'name',
      source: function (query, process) {
        return $.get('server.php', { query: query }, function (data) {
          data = $.parseJSON(data);
          return process(data);
        });
      },
      afterSelect :function (item){
        tagApi.tagsManager("pushTag", item);
      }
    });
  });
</script>
	</body>
</html>
