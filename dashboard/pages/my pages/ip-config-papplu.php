<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	include('lock.php');
	include("config.php");
	
	$message='';
	$message1='';
	$status='';
	
	if(isset($_POST['submit'])){
	   $ip=$_POST['ip'];
	   $port=$_POST['port'];
	    $mlink=$_POST['mlink'];
	     $tip=$_POST['tip'];
	      $tport=$_POST['tport'];
	       $tlink=$_POST['tlink'];
	       $reg=0;
       if (!filter_var($ip, FILTER_VALIDATE_IP)) { $reg=1;}
        if (!filter_var($tip, FILTER_VALIDATE_IP)) { $reg=1;}
          if ($reg == 0) {
             $makequery="UPDATE `ip_conf_papplu` SET `ip`='$ip',`port`='$port',`mlink`='$mlink',`tip`='$tip',`tport`='$tport',`tlink`='$tlink' WHERE id=1";
             mysqli_query ($conn,$makequery);
        
               echo '<script>window.location.href="ip-conf.php?status=1"</script>';
        }else{
            echo '<script>window.location.href="ip-conf.php?status=2"</script>';
        }

	}
	
    	$getquery="select * from `ip_conf_papplu`  WHERE id=1";
        $get=mysqli_query ($conn,$getquery);
        $listdata=mysqli_fetch_object($get);
        
        if(isset($_GET['status'])) {
          $status= $_GET['status'];
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
					<div class="box-header text-center with-border">
						<h3 class="box-title">IP Configuration</h3>
					</div>
					<div class="col-md-6 col-md-offset-3 col-xs-12">
						<div class="box">
							<!-- /.box-header -->
							<div class="box-body">

                                <form method="post">
                                    <div  class="col-md-12">
                                      <label> Game IP Address</label>
                                      <input type="text" name="ip" class="form-control" value="<?php echo $listdata->ip;?>"  placeholder="xx.xx.xx.xx">
                                      <p style="color:blue;">Ex.127.0.0.2</p>
                                     </div>
                                    <div  class="col-md-12">
                                        <label>Game Port Number</label>
                                        <input type="number" name="port" class="form-control" value="<?php echo $listdata->port;?>"  placeholder="1111">
                                     </div>
                                  <div  class="col-md-12">
                                        <label> Game Domain Name</label>
                                        <input type="text" name="mlink" class="form-control" value="<?php echo $listdata->mlink;?>"  placeholder="1111">

                                    <p style="color:blue;">Ex.http://domainname.com:3030</p>
                                     </div>
                                 <div  class="col-md-12">
                                        <label>Tournament IP Address</label>
                                        <input type="text" name="tip" class="form-control" value="<?php echo $listdata->tip;?>"  placeholder="xx.xx.xx.xx">
                                          <p style="color:blue;">Ex.127.0.0.2</p>
                                     </div>
                                   <div  class="col-md-12">
                                        <label>Tournament Port Number</label>
                                        <input type="number" name="tport" class="form-control" value="<?php echo $listdata->tport;?>"  placeholder="1111">
                                    </div>
                                  <div  class="col-md-12">
                                        <label>Tournament Domain Name</label>
                                        <input type="text" name="tlink" class="form-control" value="<?php echo $listdata->tlink;?>"  placeholder="1111">

                                  <p style="color:blue;">Ex.http://domainname.com:3030</p>
                                     </div>
                                    <div style="padding:0px 15% 5%; text-align:right;">
                                        <input type="submit" class="btn btn-primary" name="submit" value="Update">

                                    </div>
                                    	<?php if($status == 2){?>
										<p style="background: red; width: 50%;text-align: center;color: white;" class="errormsg">Invalid Data</p>
										<?php
									    	}  
										if($status == 1){
										?>
										<p style="background: blue; width: 50%;text-align: center;color: white;" class="errormsg">Updated Successfully</p>
										<?php } ?>
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
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
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
			});
	</script>
</body>

</html>