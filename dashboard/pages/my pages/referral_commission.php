<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	include('lock.php');
	include("config.php");
	
	$message='';
	$message1='';

        
        function affiliatelist($conn){
            $getquery="SELECT `user_id`, `username` FROM `users`  order by username asc";
            //echo $getquery;
              $get=mysqli_query($conn,$getquery);
               while($listdata=mysqli_fetch_object($get)){
               echo '<option value="'.$listdata->user_id.'">'.$listdata->username.'</option>';
               }
            
        
        }
        
        $getcommquery="SELECT * FROM `referal_commission` where userid='0'";
          $getcommi=mysqli_query($conn,$getcommquery);
          $listcommidata=mysqli_fetch_object($getcommi);
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
					<div class="box-header text-center with-border">
						<h3 class="box-title">Commission</h3>
					</div>
					<div class="col-md-6 col-md-offset-3 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<div class="box-body commission-wrapper">
								Note :<h5 class="text-center" style="color:blue">*Refferal Commission in % will be given on player's winning and lost amount from every cash game.</h5>
                               
                                    <div class="col-md-6 col-md-offset-3 col-xs-12">
                                        <label> Select User</label>
                                        <select class="form-control" name="affiliate" id="affiliate">
                                            <option value="0">Select User</option>
                                            <?php affiliatelist($conn);?>
                                            </select>
                                    
                                    </div>
                                    <div class="col-md-6 col-md-offset-3 col-xs-12">
                                        <label style="width:100%">On Lost amount Commission(in %)</label>
                                        <input type="text" class="form-control" name="commission" id="commission" required style="width:100%" value="<?php echo $listcommidata->commission;?>">
                                    
                                    </div>
                                     <div class="col-md-6 col-md-offset-3 col-xs-12">
                                        <label style="width:100%">On Won amount Commission(in %)</label>
                                        <input type="text" class="form-control" name="commission" id="wincommission" required style="width:100%" value="<?php echo $listcommidata->wincommission;?>">
                                    
                                    </div>
                                    <div style="padding:0px 15% 5%; text-align:center;">
                                       
                                        <a class="btn btn-primary" id="addcommission" style="margin: 21px;">Submit</a>
                                    </div>
                                    	<p  class="smsg" style="text-align: center;"></p>
										
										
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
	<!-- SlimScroll -->
	
	<!-- FastClick -->
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
				
				
			$("#affiliate").change(function(){
	     	    var affiliateid = $('#affiliate').val();
	            var dataString ='getreffrealcommission='+affiliateid;
               // alert(dataString);
                $.ajax({
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                    if(data == 0){
                         $('#commission').val('0'); 
                          $('#wincommission').val('0'); 
                    }else{
                     var obj = JSON.parse(data);
                       //alert(obj.comm);
                         $('#commission').val(obj.comm); 
                          $('#wincommission').val(obj.wincomm); 
                    }
                    }
                });

		
		
		 });
		 
		 
		 $("#addcommission").click(function(){
	     	    var affiliateid = $('#affiliate').val();
	     	    var commission = $('#commission').val();
	     	    var wincommission=$('#wincommission').val(); 
	            var dataString ='addreffrealcommission='+affiliateid+'&commission='+commission+'&wincommission='+wincommission;
                //alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                    //alert(data);
                        if(data == 1){
                        $('.smsg').html('<span style="background: green; width: 50%;text-align: center;color: white;padding:10px;">Commission updated successfully</span>');
                        setTimeout(function() { $('.smsg').html('');}, 2000);
                        }else{
                           $('.smsg').html('<span style="background: red; width: 50%;text-align: center;color: white;padding:10px;">Somthing is wrong</span>'); 
                            setTimeout(function() {  $('.smsg').html('');}, 2000);
                        }
                    }
                });

		
		
		 });
		
			});
	</script>
		
		
</body>

</html>