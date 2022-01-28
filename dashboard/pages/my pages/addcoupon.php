<?php
	include('lock.php');
	include("config.php");
	include('include/couponadd.php');
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
	<link href="../../css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    
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
							<div class="box-header with-border">
								<h3 class="box-title">Add Coupon</h3><a href="listcoupon.php" class="btn btn-primary" style="margin-left:10px;">Coupons List</a>
							</div>
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body">
									<form role="form"  method="post" enctype="multipart/form-data">
										<div class="box-body">
										    
										    <div class="col-md-4 col-xs-12">	
                                        	<div class="form-group">
												<label>Coupon Title</label><br />
												<input type="text" name="title" value="<?php echo $title;?>"    id="table_name" style="padding:5px 0px; width:100%">
											</div>
											</div>
									    	<div class="col-md-4 col-xs-12">	
                                        	<div class="form-group">
												<label>Coupon code</label><br />
												<input type="text" name="coupon" value="<?php echo $coupon;?>" maxlength="8" minlengh="8"   id="table_name" style="padding:5px 0px; width:100%">
											</div>
											</div>
											
											<div class="col-md-4 col-xs-12">	
                                         	<div class="form-group">
												<label >Valid From Date </label><br />
												<input type="text" id="from" name="from" value="<?php echo $from;?>" maxlength="100"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											
											<div class="col-md-4 col-xs-12">	
                                         	<div class="form-group">
												<label>Valid To Date </label><br />
												<input type="text" id="to" name="to" value="<?php echo $to;?>" maxlength="100"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											
											<div class="col-md-4 col-xs-12">	
                                         	<div class="form-group">
												<label >Bonus Type</label><br />
												<select   class="from-control" style="padding:6px 0px; width:100%" name="distype">
												    <option value="percent" <?php if($distype == 'percent'){ echo 'selected ="selected"';}?>>Percent</option>
												    <option value="fixed" <?php if($distype == 'fixed'){ echo 'selected ="selected"';}?>>Fixed</option>
												</select>
											</div>
											</div>
										
											<div class="col-md-4 col-xs-12">	
                                         	<div class="form-group">
												<label>Bonus Value</label><br />
												<input type="number" name="disval" value="<?php echo $disval;?>" maxlength="100"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											
											<div class="col-md-4 col-xs-12">	
                                         	<div class="form-group">
												<label>MAX Price</label><br />
												<input type="number" name="mprice" value="<?php echo $mprice;?>" maxlength="100"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											
											
											
											<div class="col-md-4 col-xs-12">	
                                         	<div class="form-group">
												<label style="margin-top: 31px;">Reusable :</label>
												<input type="checkbox" <?php if($reusable == 1){ echo 'checked ="checked"';}?>  style="margin-top: 31px;" name="reusable" value="">
											</div>
											</div>
											
											
											
											
                                        
											</div>
										 <div class="box-footer" style="text-align: right;">
									      <input type="hidden" name="eid" value="<?php echo $eid;?>">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>			
									
										
										<!-- <div class="box-footer text-center">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>/.box-body -->
										
										
										
                                        <?php  if($status==1){ ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> Record Saved.....!
                                        </div>
                                         <?php } if($status == 2) { ?>
                                        
                                        <div class="alert alert-success alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> Record Updated.....!
                                        </div>
                                        
                                       
                                        
                                        <?php } if($message != '') { ?>
                                        
                                        <div class="alert alert-danger alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
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
		<script src="../../js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
		
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
				
		$( function() {
    var dateFormat = "mm-dd-yy",
      from = $( "#from" )
        .datepicker({
         
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
       
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
			
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
