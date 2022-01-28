<?php

	include('lock.php');
	include("config.php");
	//include('Classes/class.phpmailer.php');
	include 'php/Mail.php';
include 'php/Mail/mime.php' ;
	include('email/sendEmail.php');
	include('include/emailplayer.php');
	

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
				    <div class="box-header with-border">
								<h3 class="box-title">Sent Email Details</h3><a href="emailtoplayerlist.php" class="btn btn-primary" style="margin-left:10px;">View List</a>
							</div>
					<div class="row">
					

						<div class="col-md-12  col-xs-12">
							<div class="box-header with-border">
								<h3 class="box-title">Email To Players</h3><!--<a href="listpromotion.php" class="btn btn-primary" style="margin-left:10px;">Promotions List</a>-->
							</div>
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body">
									<form role="form"  method="post" enctype="multipart/form-data">
										<div class="box-body">
										<div class="col-md-12 col-xs-12">	
                                      	  <div class="form-group">
												<label style="width:30%">User</label><br />
                                                    <select name="utype" required class="form-control" id="users" style="padding:5px 0px; width:100%">
                                                    <option value="">Select Player</option>
                                                    <option value="indivisual">Indivisual</option>
                                                    <option value="active">Active</option>
                                                    <option value="verified">Verified</option>
                                                    <option value="alluser">All Player</option>
                                                    </select>
											</div>
												<p style="color:blue;display:none;" id="mactive">Note : This Email sending to all Player which are Active between selected dates</p>
											<p style="color:blue;display:none;" id="mverified">Note : This Email sending to all Player  which are  verified kyc document</p>
											<p style="color:blue;display:none;" id="malluser">Note : This Email sending to all Player which are registered in application</p>
											<p style="color:blue;display:none;" id="mind">Note : This Email sending to Selected Username</p>
											</div>
											
											
												<div class="overlay" id="loaddiv" style="display:none;">
											    <img src="../../images/load.gif" style="width:57px;">
											</div>
											<div class="col-md-12 col-xs-12" style="display:none;" id="unamediv">	
                                         	<div class="form-group">
												<label >Search User</label><br />
												<input type="text" autocomplete="off" place holder="Search User By Username"   name="username" id="uname" value="" class="typeahead tm-input form-control tm-input-info"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											<div class="col-md-6 col-xs-12" id="fromdiv" style="display:none;">	
                                         	<div class="form-group">
												<label >Active From Date </label><br />
												<input type="text" id="from" autocomplete="off" name="from" value="<?php //echo $from;?>" maxlength="100"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											
											<div class="col-md-6 col-xs-12" id="todiv" style="display:none">	
                                         	<div class="form-group">
												<label>Active To Date </label><br />
												<input type="text" id="to" autocomplete="off" name="to" value="<?php //echo $to;?>" maxlength="100"   style="padding:5px 0px; width:100%">
											</div>
											</div>
											
											<div class="col-md-12 col-xs-12">	
                                      	  <div class="form-group">
												<label style="width:30%">Use Template</label><br />
                                                    <select  class="form-control usetemp" id="etemp" style="padding:5px 0px; width:100%">
                                                    <option value="">Select Template</option>
                                                   <?php emailtemplate($conn);?>
                                                    </select>
											</div>
											</div>
											
										
											
											<div class="col-md-12 col-xs-12">	
                                      	    <div class="form-group">
												<label style="width:30%">Subject</label><br />
												<input type="text" id="sub" required name="subject" value="<?php //echo $shortdescription;?>" maxlength="100" required  style="padding:5px 0px; width:100%">
											</div>
											</div>
											<div class="col-md-12 col-xs-12">	
                                      	<div class="form-group">
												<label style="width:30%">Message</label><br />
											<textarea required id="msg" class="form-control textarea"   name="message"><?php //echo $description;?></textarea>
											</div>
											<p style="color:blue;">Note : For add Username In Message Add  <span style="color: #d60a67;margin: 11PX;">{username}</span>    and For full name  <span style="color: #d60a67;margin: 11PX;">{fullname}</span> at place of required</p>
											</div>
											
												<div class="col-md-12 col-xs-12">	
                                      	<div class="form-group">
												<label style="width:30%">Save Or Update Template</label><br />
											<p>	<input type="checkbox" style="margin:10px;float:left;" name="savetemp">
											<input type="text" autocomplete="off" placeholder="Serch Or Type new Template name" class="typeahead1 tm-input1 form-control tm-input-info" id="ttitle"  name="ttitle" value=""  style="width: 50%;margin-left: 22px;">
											</p></div>
											
											</div>
                                         
											
										

												 
										</div>
									

								

                                        <div class="box-footer" style="text-align: right;">
                                            <input type="hidden" name="eid" value="<?php echo $eid;?>">
                                            <input type="hidden" name="uimage" value="<?php echo $simage;?>">
                                            <input type="submit" name="submit" value="Send" class="btn btn-primary">
                                        </div>			
									
										
									
										
									
                                      
                            <?php  if($count  != 0) { ?>
                              <p><span style="background: green;padding: 5px;color: white;">Total <?php echo $count;?> Mails Send Successfully</span></p>
                            <?php } ?>
                                        
                                        <?php  if($message != '') { ?>
                                        
                                        <div class="alert alert-danger alert-dismissable fade in" style="padding: 6px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $message;?>
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
		<!-- ./wrapper -->
		<!-- jQuery 3 -->
		<script src="../../bower_components/jquery/dist/jquery.min.js"></script>

		<!-- Bootstrap 3.3.7 -->
		<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">

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
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
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
		
		
		
		$(".usetemp").change(function(){
	     	var tempid = $(this).val();
	     
	    // $('#loaddiv').show();
		   //alert(tempid);
		
          var dataString ='template='+tempid;
              //  alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                      //$('#loaddiv').hide();
                    $.each(JSON.parse(data), function(i, data){
                    
                      $('#sub').val('');
                   $('.wysihtml5-sandbox').contents().find('.wysihtml5-editor').html('');
                    $('#sub').val(data.subject);
                   /// alert(data.emessage);
                  $('.wysihtml5-sandbox').contents().find('.wysihtml5-editor').html(data.emessage);
                   // $('#msg').content(data.emessage);
                     //$('#msg').html(data.emessage);
                    //  $('#msg').val(data.emessage);
                    
                    
                    
                    });
              
                }
                });

		
		
		});
		
		
		
		
		$("#users").change(function(){
	    
            		var utype=$('#users').val();
            	//	alert(utype);
		
                        if(utype == 'active'){
                        
                                $('#fromdiv').show();
                                $('#todiv').show();
                                $('#mactive').show();
                                $('#mverified').hide();
                                $('#malluser').hide();
                                $('#unamediv').hide()
                                $('#mind').hide();
                        
                        } else if(utype == 'verified'){
                                $('#from').val('');
                                $('#to').val('');
                                $('#fromdiv').hide();
                                $('#todiv').hide();
                                $('#mactive').hide();
                                $('#mverified').show();
                                $('#malluser').hide();
                                $('#unamediv').hide();
                                $('#mind').hide();
                        
                        }else if(utype == 'indivisual'){
                                $('#unamediv').show();
                                $('#from').val('');
                                $('#to').val('');
                                $('#fromdiv').hide();
                                $('#todiv').hide();
                                $('#mactive').hide();
                                $('#mverified').hide();
                                $('#malluser').hide();
                                 $('#mind').show();
                                
                        
                        }else if(utype == 'alluser'){
                                $('#from').val('');
                                $('#to').val('');
                                $('#fromdiv').show();
                                $('#todiv').show();
                                $('#mactive').hide();
                                $('#mverified').hide();
                                $('#malluser').show();
                                $('#unamediv').hide();
                                $('#mind').hide();
                        
                        }else{
                                $('#from').val('');
                                $('#to').val('');
                                $('#fromdiv').hide();
                                $('#todiv').hide();
                                $('#mactive').hide();
                                $('#mverified').hide();
                                $('#malluser').hide();
                                $('#unamediv').hide();
                                $('#mind').hide();
                        }
            		
		});
	

		
		
	
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
                    tagApi.tagsManager("pushTag", item);
                  }
                });
              });
</script>

<script type="text/javascript">
              $(document).ready(function() {
                var tagApi1 = $(".tm-input1").tagsManager();
            
            
                jQuery(".typeahead1").typeahead({
                  name: 'ttitle',
                  displayKey: 'name',
                  source: function (query, process) {
                    return $.get('ajaxpro.php', { template: query }, function (data) {
                      data = $.parseJSON(data);
                      return process(data);
                    });
                  },
                  afterSelect :function (item){
                    //tagApi.tagsManager("username", item);
                    $("#ttitle").val(item);
                  }
                });
              });
</script>
	</body>
</html>
