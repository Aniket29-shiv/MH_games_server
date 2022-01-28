<?php

	include 'lock.php';
	include 'config.php';  	
	
      $ticketid=$_GET['mid'];
	  $get="select * from `user_help_reply` where `ticketid`='$ticketid'  order by id asc";
	  $query=mysqli_query($conn,$get);     
	  
	  

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
			<!-- Main content -->
			<section class="content">
			<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Reply</h3><a href="help_support.php" class="btn btn-primary" style="margin-left:10px;">Back</a>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							
                                    
                                        
							</div>
								</div>
									</div>
							
					<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper  showmsg" style="background: white;width: 100%;height: 412px;overflow: auto;|">
						   
                            <?php
                            
                                $getticket="select * from `user_help_support` where `id`='$ticketid'";
                                $queryticket=mysqli_query($conn,$getticket);   
                                $listticket=mysqli_fetch_object($queryticket);
                                if($listticket->ticketby == 0){$textby='You';}else{$textby='Support Department';}
                                echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                                
                                <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listticket->created_date)).'</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> You</span>
                                <br />'.$listticket->message. '
                                </p></div>';
                            
                                while($listdata=mysqli_fetch_object($query)){
                                    
                                    if($listdata->msgby == 0){
                                        $tikid=$listdata->ticketid;
                                        $getuser=mysqli_query($conn,"select name from `user_help_support` where `id`='$tikid' ");;
                                        $listuser=mysqli_fetch_object($getuser);
                                        
                                        if($listdata->type == 0){
                                        
                                        echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                                        
                                        <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> '.$listuser->name.'</span>
                                        <br />'.$listdata->msg. '
                                        </p></div>';
                                        }else{
                                	          $reid=$listdata->id;
                                	          
                                	          $getimg="select * from `user_help_reply_document` where `user_help_reply_id`='$reid'";
                                        	  $queryimg=mysqli_query($conn,$getimg);   
                                        	  $listimg=mysqli_fetch_object($queryimg);
                                        	  if($listimg->image_path != ''){
                                	           echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                                         <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> '.$listuser->name.'</span>
                                        <br />';
                                                    if($listimg->file_type == 'img'){
                                                      echo '<img src="../../../'.$listimg->image_path.'"  style="width: 50%;">';
                                                    }
                                                     if($listimg->file_type == 'doc'){
                                                      echo '<a class="btn btn-primary" href="../../../'.$listimg->image_path.'" download>Download Attachment</a>';
                                                    }
                                                echo '</p></div>';
                                        	  }
                                	      
                                	     }
                                    
                                    }
                                    
                                    if($listdata->msgby == 1){
                                         if($listdata->type == 0){
                                    
                                            echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
                                            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
                                            <br />'.$listdata->msg. '
                                            </p></div>';
                                         }else{
                                	          $reid=$listdata->id;
                                	          
                                	          $getimg="select * from `user_help_reply_document` where `user_help_reply_id`='$reid'";
                                        	  $queryimg=mysqli_query($conn,$getimg);   
                                        	  $listimg=mysqli_fetch_object($queryimg);
                                        	  if($listimg->image_path != ''){
                                	           echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
                                            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
                                            <br />';
                                                    if($listimg->file_type == 'img'){
                                                      echo '<img src="../../../'.$listimg->image_path.'"  style="width: 50%;">';
                                                    }
                                                     if($listimg->file_type == 'doc'){
                                                      echo '<a class="btn btn-primary" href="../../../'.$listimg->image_path.'" download>Download Attachment</a>';
                                                    }
                                                echo '</p></div>';
                                        	  }
                                	      
                                	     }
                                    
                                    
                                    }
                                }
                            
                            ?>
							
                                        
							</div>
								</div>
									</div>	
									<div class="row">
									    <form id="uploadForm" action="replayimage.php" method="post" enctype="multipart/form-data">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						   
                                        <input type="hidden" value="<?php echo $_GET['mid'];?>" id="ticketid">
                                            <div class="col-md-7">
                                                 <lable>Reply</lable>
                                                <textarea class="form-control msgtxt"  name="replymsg" style  placeholder="Type Message"></textarea>
                                            </div>
                                            <div class="col-md-3" id="selectdiv">
								        <input type="file" name="images[]" id="imgs" multiple style="width: 100%;font-size: 12px;margin-top: 29px;color: black;" >
								   </div> 
                                            <div class="col-md-2" id="replybtn">
                                            
                                               
                                               <!-- <a href="#" class="btn btn-primary reply"  data-id="<?php echo $_GET['mid'];?>" style="margin-top: 29px;">Reply</a>-->
                                                <input  type="hidden" value="<?php echo $_GET['mid'];?>" name="selectedticket" id="selectedticket">
								     <!--<a class="btn btn-primary reply" style="margin-top: 28px;">Reply</a>-->
								      <input class="btn btn-primary reply" type="submit" name="replybyuser" value="Reply" style="margin-top: 28px;width: 100%;"/>
								      
                                            
                                            </div>
                                            
                                              <div class="col-md-2" id="loaderdiv"  style="display:none;">
								       <img src="loader.gif" style="margin-top: 24px; width: 50%;">
								   </div>
                                            
                                            <div class="box-footer with-border" style="text-align:right;">
                                            
                                            </div>
                                            
                                        
							</div>
								</div>
								</form>
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
	<!-- page script -->
	<script>
		$(function(){
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
	
		<script>
$(function(){
		
     	$(".msgstatus").click(function(){
	     	var msgid = $(this).attr('data-id');
	     		var status = $(this).attr('data-status');
	     
	     
		 
         var dataString ='updatemessagestatus='+msgid+'&statusmasg='+status;
                //alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                window.location.href="";
                
                }
                });

		
		
		});
		
	
		
	  });
	</script>
	
	<script>
	
               /* $(function(){
            		
            		
            			$(".reply").click(function() {
            		     
                			var msg=$('.msgtxt').val();
                			var ticketid=$(this).attr('data-id');
                	       	//alert(ticketid+"=="+msg);
                			
                			var dataString ='replymessage='+msg+'&ticketid='+ticketid;
                           // alert(dataString);
                            
                            
                               $.ajax({
                                
                                type: "POST",
                                url:"ajax_function.php",
                                data: dataString,
                                cache: false,
                                success: function(data){
                                //alert(data);
                                 
                                   $('.showmsg').html('');
                                    $('.showmsg').html(data);
                                $('.msgtxt').val('');
                                
                                }
                                });
                                
            	
            			
            		});
            		
                });*/
                
   </script>
   <script>
   	$(document).ready(function() { /// Wait till page is loaded
setInterval(timingLoad, 5000);

  function timingLoad() {
    
            var ticketid = $("#ticketid").val();
            var dataString ='ticketdata='+ticketid;
           // alert(dataString);
            $.ajax({
            
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                	
                 $('.showmsg').html('');
                   $('.showmsg').html(data);
                
                }
            });


       }
       
       
       
        $("#uploadForm").on('submit',(function(e){
            $('#selectdiv').hide('');
            $('#replybtn').hide('');
            $('#loaderdiv').show('');
            e.preventDefault();
            $.ajax({
            url: "replayimage.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                //alert(data);
                $('.showmsg').html('');
                $('.showmsg').html(data);
                $('#replymsg').val('');
                $('#imgs').val('');
                $('#selectdiv').show('');
                $('#replybtn').show('');
                $('#loaderdiv').hide('');
                alert('Replay Send Successfully');

            },
            error: function(){} 	        
            });
        }));
});

	</script>


</body>

</html>