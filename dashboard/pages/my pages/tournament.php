<script type="text/javascript">
function CheckFee(val){
 var element=document.getElementById('otherpaid');
 if(val=='Paid')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script> 

<?php 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	include('lock.php');
	include ('config.php');
	$status = '';
	if($_GET){ 
	  $status = $_GET['status']; 
	} 


    if(isset($_POST['btnSubmit'])){
      
        $created_on = date('Y-m-d H:i:s');   
        $update_on =  date('Y-m-d H:i:s');   
       
        $title=$_POST['title'];
        $tour_price=$_POST['tour_price'];
        $start_date=$_POST['start_date'];
        //$description=$_POST['description'];
        $description_new= mysqli_real_escape_string($conn,$_POST['description']);
   
        $start_date_new= explode('-',$start_date);
        $start_date=$start_date_new[2]."-".$start_date_new[0]."-".$start_date_new[1];
       
        $start_time=$_POST['start_time'];
        $reg_start_date=$_POST['reg_start_date'];
        
        $reg_start_date_new= explode('-',$reg_start_date);
        $reg_start_date=$reg_start_date_new[2]."-".$reg_start_date_new[0]."-".$reg_start_date_new[1];
           
        $reg_start_time=$_POST['reg_start_time'];
        $reg_end_time=$_POST['reg_end_time'];
        $reg_end_date=$_POST['reg_end_date'];
        $reg_end_date_new= explode('-',$reg_end_date);
        $reg_end_date=$reg_end_date_new[2]."-".$reg_end_date_new[0]."-".$reg_end_date_new[1];
       
        
        $no_player=$_POST['player'];
        $position=$_POST['position'];
        $price=$_POST['price'];
        $players=$_POST['players'];
        $price=$_POST['price'];

        if($_POST['status']=='Free'){
             $status=$_POST['status'];
        } else{
            $status=$_POST['otherpaid'];
        }
       /* $ufile=$_FILES["fileToUpload"]["name"];
        if($ufile != ''){
        $temp = explode(".",$ufile );
        $extension = end($temp);
        
        $imageName = time()."_"."tour".".".$extension;
        $unlink=$imageName;
        $path ="tournament_uploads/".$imageName;
        $dir='tournament_uploads';	
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path);
          $uploadFilename= "tournament_uploads/".$imageName;
        }else{
        $uploadFilename='';
        }*/
        
        
	    //if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path)){
				  
              
                $query="INSERT INTO `tournament`(`price`, `title`, `start_date`, `start_time`, `reg_start_date`, `reg_start_time`, `reg_end_date`,`reg_end_time`, `entry_fee`, `no_of_player`,`description`, `created_date`, `updated_date`, `status`) VALUES ('$tour_price','$title','$start_date','$start_time','$reg_start_date','$reg_start_time','$reg_end_date','$reg_end_time','$status','$no_player','$description_new','$created_on','$update_on', 'create')";
               
                $result = $conn->query($query);
                $tournament_id = $conn->insert_id;
                
                if($result){
                    
                            $len= count($position);
                            
                            for($i=0;$i<=$len;$i++){   
                                
                                $query_price= "INSERT INTO `price_distribution`(`tournament_id`, `position`, `price`,no_players) VALUES ('$tournament_id','$position[$i]','$price[$i]','$players[$i]')";
                                $result_price = $conn->query($query_price);
                            
                            }
                            
                            
                          //  if($result_price){
                            
                                    //echo '<script language="javascript">alert("Successfully Inserted")</script>';
                                    echo '<script language="javascript">window.location.href="tournament.php?status=1"</script>';
                                    //header("Location:tournament.php?&status=1"); 
                            
                           // }else{
                             //echo '<script language="javascript">window.location.href="tournament.php?status=2"</script>';
                                    //header("Location:tournament.php?&status=2");
                            
                           // }
    
                }else{
                echo '<script language="javascript">window.location.href="tournament.php?status=3"</script>';
                    //header("Location:tournament.php?&status=2"); 
                
                }
                
       // }else{
            
           // unlink($dir.'/'.$unlink);
            //  echo '<script language="javascript">window.location.href="tournament.php?status=4"</script>';
           // header("Location:tournament.php?&status=2"); 
            
       // }
                
    }

if(isset($_POST['btnSubmit_edit'])){
      $id=$_GET['id'];
        $update_on =  date('Y-m-d H:i:s');   
       $title=$_POST['title'];
       $description=$_POST['description'];
    
     $query = "UPDATE `promotion` SET `title`='$title',`description`='$description',`updated_date`='$update_on'  WHERE id=$id";  
			
			  $result = $conn->query($query);
			  
		
			 
			if($result){
				 header("Location:promotions-details.php?status=5");  
			}else{
				 header("Location:promotions-details.php?status=2");  
			}
}

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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
	<link rel="stylesheet" type="text/css" media="screen"
     href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
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
				    <div class="box-header with-border">
								<h3 class="box-title">tournament-details.php</h3><a href="tournament-details.php" class="btn btn-primary" style="margin-left:10px;">Tournament List</a>
							</div>
					<div class="row">
						<?php  if($status==1){ ?>
						
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> Record Saved.....!
							</div>  
							
						<?php } if($status==2) { ?>
						
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured...!
							</div>   
						<?php }if($status==3) { ?>
						
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured ...!
							</div>   
						<?php } if($status==4) { ?>
						
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured Invalid file ...!
							</div>   
						<?php }
			
						?>
						
						<div class="col-md-8 col-md-offset-3 col-xs-12">
							<div class="box-header text-center with-border">
							<?php if($_GET['task']=='edit'){?>	<h3 class="box-title">Edit Tournament</h3><?php  }else {?>
							<h3 class="box-title">Add Tournament</h3
							<?php }?>
							</div>
							<div class="box"> 
								<!-- /.box-header -->
								<div class="box-body">
                                    <?php   
                                           if($_GET['task']=='edit'){
                                               
                                                    $id=$_GET['id'];
                                                    $query = "select * from promotion  where id='$id'";
                                                    
                                                    $result = $conn->query($query);
                                                    
                                                    while($row = $result->fetch_assoc())
                                                    {
                                                        $title=  $row['title']; 
                                                        $description= $row['description'];
                                                    
                                                    }
                                    ?>	
								    
								    <form role="form" action="" method="post" name="table_details" id="table_details" enctype="multipart/form-data"> 
									
										<div class="form-group">
												<label style="width:30%">Title   :</label>
												<input type="text" name="title" autocomplete="off"  id="title" value="<?php echo $title;?>" style="padding:5px 0px; width:67%"required >
											</div>
										<div class="form-group">
												<label style="width:30%;float: left;">Description :</label>
												<textarea type="textarea"  autocomplete="off" name="description" id="description" value=""style="padding:5px 0px; width:67%"rows="10" cols="80" required><?php echo $description; ?></textarea>
											</div>
								        <div class="box-footer text-center">
											<button  name="btnSubmit_edit" type="submit" class="btn btn-primary">Submit</button>
											</div>
								
									</form>
								    
								 <?php   }else{ ?>
								 
						        	<form role="form" action="" method="post" name="table_details" id="table_details" enctype="multipart/form-data"> 
									
											<div class="form-group">
												<label style="width:30%">Title   :</label>
												<input type="text" name="title"  autocomplete="off"  id="title" value="" style="padding:5px 0px; width:67%"required >
											</div>
											
											<div class="form-group">
												<label style="width:30%;float: left;">Price :</label>
												<input type="number" name="tour_price"  autocomplete="off"  id="tour_price" value="" style="padding:5px 0px; width:67%"required >
											</div>
											
												
												
											<div class="form-group">
												<label style="width:30%;float: left;">Start Date :</label>
									             <input type="text" name="start_date"  autocomplete="off"  id="start_date" value="" style="padding:5px 0px; width:67%" required >
											</div>
											
											<div class="form-group">
												<label style="width:30%;float: left;">Start Time :</label>
												<input type="text" name="start_time"   autocomplete="off" id="start_time" value="" style="padding:5px 0px; width:67%" required >
											</div>
											
											<div class="form-group">
												<label style="width:30%;float: left;">Registration Start Date :</label>
												<input type="text" name="reg_start_date"  autocomplete="off"  id="reg_start_date" value="" style="padding:5px 0px; width:67%" required >
											</div>
											
											<div class="form-group">
												<label style="width:30%;float: left;">Registration Start Time :</label>
												<input type="text" name="reg_start_time"  id="reg_start_time" value="" style="padding:5px 0px; width:67%" required >
											</div>
											
											<div class="form-group">
												<label style="width:30%;float: left;">Registration End Date :</label>
												<input type="text" name="reg_end_date"  autocomplete="off"  id="reg_end_date" value="" style="padding:5px 0px; width:67%" required >
											</div>
											
											<div class="form-group">
												<label style="width:30%;float: left;">Registration End Time :</label>
												<input type="text" name="reg_end_time"  autocomplete="off"  id="reg_end_time" value="" style="padding:5px 0px; width:67%" required >
											</div>
											
							       	<div class="form-group">
							       	    <label style="width:30%;float: left;">Entry Fee :</label>
										<select required name="status" style="width:65%;margin-left:-12px;" onchange='CheckFee(this.value);'>
										    
                                            <option value="1">Please select an option</option>
                                            <option value="Free">Free</option>
                                            <option value="Paid">Paid</option>
                                            
										</select>
										
										<br>
										<input type="number" name="otherpaid" id="otherpaid" style='display:none;margin-top:8px;margin-left:259px;'/>
										<span id="err_domain" style="display: none; color: red;text-align:center">Please Select option.</span>	
										</div>
										
										
                                            <div class="form-group">
                                                <label style="width:30%;float: left;">No Of Players :</label>
                                                <input type="number" name="player"   autocomplete="off" id="player" value="" style="padding:5px 0px; width:67%"required >
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                 <label style="width:100%;    margin-left: -496px;">Description :</label>
                                            </div>
                                             
                                            <div class="form-group">
                                                
                                               <textarea type="textarea" name="description" id="" n value=""style="padding:5px 0px; width:90%"rows="10" cols="90" required></textarea>
                                            
                                            </div>

                                          <!--  <div class="form-group">
                                                
                                                <label style="width:30%;float: left;">Attachment :</label>
                                                <input type="file" name="fileToUpload"   ="required" />
                                                
                                            </div>-->	
											
											<div class="form-group">
										    <label style="margin-left: -66%;">Price Distributions </label></div>
										
									    	<div class="form-group">
                                                <table  class="table table-hover small-text" id="tb" style="padding: 4px;">
                                                    <tr class="tr-header">
                                                        
                                                        <th style=" text-align: -webkit-center;">Position</th>
                                                        <th style=" text-align: -webkit-center;">Price</th>
                                                        <th style=" text-align: -webkit-center;">No. Of Players</th>
                                                        <th style="text-align: -webkit-center;"><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Position"><span class="glyphicon glyphicon-plus"></span></a></th>
                                                       
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td><input type="number"  autocomplete="off" name="position[]"  id="position" value="" style="padding:5px 0px;"required ></td>
                                                        <td><input type="number"  autocomplete="off" name="price[]"  id="price" value="" style="padding:5px 0px;"required ></td>
                                                        <td><input type="number"  autocomplete="off" name="players[]"  id="players" value="" style="padding:5px 0px;"required ></td>
                                                        <td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a> </td> 
                                                    </tr>
                                                
                                                </table>
											</div>
											
									
										<!-- /.box-body -->
										<div class="box-footer text-center">
											<button  name="btnSubmit" type="submit" class="btn btn-primary">Submit</button>
										</div>
									</form>
									
									<?php }?>
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
	<!-- ./wrapper -->
	<!-- jQuery 3 -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
		 <script type="text/javascript"
     src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>
     <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

	<script>
		$(function () {
				// Replace the <textarea id="editor1"> with a CKEditor
				// instance, using default configuration.
				CKEDITOR.replace('editor1')
				//bootstrap WYSIHTML5 - text editor
				$('.textarea').wysihtml5()
			  });
		$(function () {
			  $('#addMore').on('click', function() {
			      
			  //    alert();
              var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
             //   alert(data);
              data.find("input").val('');
     });
     $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
      });
			  });
		    	  
			$(function(){
				$(".createPromo").click(function(){
					$(".promo-temp").slideToggle(700);
				});
			});
			$(function(){
			    
			    $.fn.datepicker.defaults.format = "mm-dd-yyyy";
			    	  $('#start_date').datepicker({});
			    	  $('#reg_start_date').datepicker({});
			    	   $('#reg_end_date').datepicker({});
			    	  
	
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
			});
			
			$('#start_time').timepicker({
               showMeridian:false,
                showSeconds: true
			    
			    });
						$('#reg_start_time').timepicker({
                showMeridian:false,
                showSeconds: true
			    
			    });
							$('#reg_end_time').timepicker({
                showMeridian:false,
                showSeconds: true
			    
			    });
			
				function getval(sel)
{
    
    if(sel.value!=1){
    var domain=sel.value;
   // alert(domain);
    }else{
       // alert(sel.value);
        	 $('#email_1').val('');
        	 	$('#err_domain').fadeIn().delay(5000).fadeOut();
    }
}

	</script>
	
		
</body>

</html>