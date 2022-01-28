<?php
session_start();

if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
{
    
  //  echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
$loggeduser =  $_SESSION['logged_user'];

include 'database.php';

$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
		$first_name = $row['first_name'];
	}
}
else {
echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
header("Location:index.php");
}

$sql1 = "SELECT * FROM `user_help_support`  where name = '".$loggeduser."'";
$result1 = $conn->query($sql1);
$conn->close();
?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<style>
button.accordion {
    color: #444;
    cursor: pointer;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
	background-color: crimson;
}

button.accordion.active, button.accordion:hover {
    background-color: #ccc; 
}

div.panel {
    padding: 0 18px;
    display: none;
    background-color: white;
}
</style>
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
			<!--	<div class="row user-name pb20">
					<div class="col-md-12">
						<div class="col-md-6 col-sm-5 black-bg">
							<h5 class="color-white">Welcome</h5>
							<h4><b><?php echo $loggeduser; ?></b></h4>
						</div>
						<div class="col-md-6 col-sm-7 black-bg">
							<h5 class="color-white">Free Money :</h5>
							<h4><b><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?></b></h4>
							<h5 class="color-white">Real Money :</h5>
							<h4><b><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></</b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>		-->		
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-8">
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<h3 class="color-white text-center mt20"><b>Help & Support</b></h3>
								<div class="table-responsive ">
									<table class="table table-bordered"  style='background-color: white;'>
										<thead>
											<tr style='background-color: wheat;'>
												<th style="width:2%;text-align:center">Sr.No</th>
												<th style="width:33%;text-align:center">Subject</th>
												<th style="width:47%;text-align:center">Message</th>
												<th style="width:47%;text-align:center">Last Reply</th>
												<th style="width:18%;text-align:center">Status</th>
													<th style="width:18%;text-align:center">Detail</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if ($result1->num_rows > 0) {
											$i=1;
												while($row1 = $result1->fetch_assoc())
												{
												
													?>
													<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $row1['subject'];?></td>
													<td><?php echo $row1['message'];?></td>
														<td><?php echo $row1['lastreply'];?></td>
													<?php if($row1['status'] == 'open') {?>
													<td style="color:green"><?php echo $row1['status'];?></td>
														<td style="color:red"><a class="btn btn-primary msgdetail" data-id="<?php echo $row1['id'];?>">Detail</a></td>
													<?php } else if($row1['status'] == 'Close') {?>
													<td style="color:red"><?php echo $row1['status'];?></td>
													<td style="color:red"><a class="btn btn-primary msgdetail" data-id="<?php echo $row1['id'];?>">Detail</a></td>
													<input type="hidden" id="statusval<?php echo $row1['id'];?>" value="<?php echo $row1['status'];?>">
													<?php } else {?>
													<td><?php echo $row1['status'];?></td>
													<td style="color:red"><a class="btn btn-primary msgdetail" data-id="<?php echo $row1['id'];?>">Detail</a></td>
													</tr>
													<?php }
												 $i++;			
												}
											}
										?>
										</tbody>
									</table>
								</div>
							
								<button class="accordion pull-right mb30" id="div_msg" style="background: -webkit-linear-gradient(#ffa31a, #cc7a00);color:white;padding:5px 10px">New Message</button>
								<div class="black-bg panel" style="clear:both" id="div_sub_msg">
								<h4 class="color-white">Please fill the form below and we will get in touch with you shortly</h4>
									<form id="form_user_contact" action="user_contact.php" method="post">
										<label>Subject :-</label>
										<select id="subject" name="subject" style="width: 40%;" required>
											<option value="" selected="">Select Subject</option>
											<option value="Payment">Payment</option>
											<option value="Technical Support">Technical Support</option>
											<option value="Suggest">Suggest</option>
											<option value="Other">Other</option>
										</select>
										<br>
										<label>Message :-</label>
										<textarea id="msg" name="msg" placeholder="Enter Your Message here" autocomplete="off" style="height:15%" required></textarea><br>
										<input type="hidden" autocomplete="off" name="usernm" id="usernm" value="<?php echo $loggeduser; ?>">
										<button class="btn btn-default mt20 color-white" style="margin:5% 31%">Send</button>
										<span id="update_success" style="display: none;margin-left: 7%; color: white;text-align:center">Your Request has been submitted successfully,we will get back to you shortly.</span>
										<span id="update_failure" style="display: none;margin-left: 9%; color: red;text-align:center">Something went wrong,please try again.</span>
										<!--<span id="success_msg" style="display: none;margin-left: 80px; color: yellow;">Your Message has been sent successfully..!</span>-->
									</form>
								</div>
								
									<div class="col-md-10 msgpage" id="showmsg" style="background: white;width: 100%;height: 412px;overflow: auto;display:none;">
									 
									    
									</div>
									<div class="col-md-10 msgpage" style="width: 100%; margin-bottom: 19px;display:none;">
								 
							<form id="uploadForm" action="replayimage.php" method="post" enctype="multipart/form-data">
								   <div class="col-md-6" id="replybox">
								     <lable style="color:white;">Reply</lable><br />
								     <textarea class="form-control" name="replymsg" id="replymsg" style="width:100%;"></textarea>
								   </div>  
								   <div class="col-md-4" id="selectdiv">
								        <input type="file" name="images[]" id="imgs" multiple style="width: 100%;font-size: 12px;margin-top: 29px;color: white;" >
								   </div> 
								    <div class="col-md-2" id="replybtn">
								        <input  type="hidden" value="" name="selectedticket" id="selectedticket">
								     <!--<a class="btn btn-primary reply" style="margin-top: 28px;">Reply</a>-->
								      <input class="btn btn-primary reply" type="submit" name="replybyuser" value="Reply" style="margin-top: 28px;width: 100%;"/>
								      
								   </div> 
								   
								    <div class="col-md-2" id="loaderdiv"  style="display:none;">
								       <img src="images/loader.gif" style="margin-top: 24px; width: 100%;">
								   </div> 
								   </form>
								   <div class="col-md-12" id="closemsg" style="display:none;">
								       <p><span style="color:white;">Your ticket closed by admin. if yoou want to ask any question  so please generate new ticket.</span></p>
								   </div>
								    
								    
								</div>
							</div>
						</div>
						
						
			     	</div>	    
					</div>
				</div>
				<hr>
			</div>
		</div>
	</main>
	<footer>
		<div id="footer"></div>
	</footer>
</body>
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		  
		  <?php  
		 $message = isset($_GET['user_message']) ? $_GET['user_message'] : '';
		 if($message == true)
		 {
		 ?>
				$('#success_msg').fadeIn().delay(15000).fadeOut();
		<?php } ?>
		
		var frm1 = $('#form_user_contact');
		frm1.submit(function (e) {
			e.preventDefault();
			$.ajax({
				type: frm1.attr('method'),
				url: frm1.attr('action'),
				data: frm1.serialize(),
				success: function (data) {
				   
				    alert('Query submited Successfully.');
				    window.location=('account-contact-us.php');
                                    			/*	if(data == true)
                                    					{ 
                                    					 $('#form_user_contact').trigger("reset");
                                    					  $('#update_success').fadeIn().delay(45000).fadeOut();
                                    						var count = 10;
                                    						var countdown1 = setInterval(function(){
                                    						count--;
                                        						 if (count == 0)
                                        							{
                                        								window.location=('account-contact-us.php');
                                        							}
                                    							}, 1000);
                                    					}
                                    					else 
                                    					{
                                    						$('#form_user_contact').trigger("reset");
                                    						$('#update_failure').fadeIn().delay(15000).fadeOut();
                                    						window.location=('account-contact-us.php');
                                    					}*/
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		
		 $("#div_msg").click(function()
		 {
			//$("#div_sub_msg").show();
			//$("#div_sub_msg").css('display','block');
			var div_css = $("#div_sub_msg").css('display');
			if(div_css == 'none')
			{
				$("#div_sub_msg").show();
					$(".msgpage").hide();
				
			}
			else 
			{
				$("#div_sub_msg").hide();
				$(".msgpage").hide();
			}
		});
		
		
		
		
		$(".msgdetail").click(function(){
		    
		    	$("#div_sub_msg").hide();
			var ticketid=$(this).attr('data-id');
			var status=$('#statusval'+ticketid).val();
	
                if(status == 'Close'){
                   
                       	$('#replybox').hide();
                       	$('#replybtn').hide();
                       	$('#closemsg').show();
                       	$('#selectdiv').hide('');
                   	
                }else{
                    	$('#replybox').show();
                    	$('#replybtn').show();
                   	    $('#closemsg').hide();
                   	    $('#selectdiv').show('');
                }
                
    			$('.msgpage').show();
    				$('#selectedticket').val(ticketid);
    				
    				 var dataString ='ticketdata='+ticketid;
                      //alert(dataString);
                    $.ajax({
                    
                    type: "POST",
                    url:"ajax_function.php",
                    data: dataString,
                    cache: false,
                    success: function(data){
                    //alert(data);
                     
                       $('#showmsg').html('');
                        $('#showmsg').html(data);
                    
                    
                    }
                    });
    				
    				
    			
    });
		
		
		
    /*$('#submitreplay').ajaxForm({
    
        success:function(){
        $('#imgs').val('');
        $('#status').html('');
        },
    
    });*/
		
		/*	$(".reply").click(function() {
		     
			var msg=$('#replymsg').val();
			var files=$('#file').val();
			var ticketid=$('#selectedticket').val();
			
	       	alert(files+"=="+msg);
			
			
			  var dataString ='submitedmessage='+msg+'&ticketid='+ticketid;
                 // alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
               // alert(data);
                 
                   $('#showmsg').html('');
                    $('#showmsg').html(data);
                $('#replymsg').val('');
                
                }
                });
                
	       	//	$('.msgpage').show();
			//	$('#selectedticket').val(ticketid);
			
		});*/
		
		
		
		
		
});
</script>

 <script>
   	$(document).ready(function() { /// Wait till page is loaded
        setInterval(timingLoad, 5000);

          function timingLoad() {
            
                    var ticketid = $("#selectedticket").val();
                    var dataString ='ticketdata='+ticketid;
                  //  alert(dataString);
                    $.ajax({
                    
                        type: "POST",
                        url:"ajax_function.php",
                        data: dataString,
                        cache: false,
                        success: function(data){
                        //alert(data);	
                         $('#showmsg').html('');
                           $('#showmsg').html(data);
                        
                        }
                    });
        
        
               }
               
               
        $("#uploadForm").on('submit',(function(e){
            $('#selectdiv').hide();
            $('#replybtn').hide();
            $('#loaderdiv').show();
            e.preventDefault();
            $.ajax({
            url: "replayimage.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
             $('#showmsg').html('');
                    $('#showmsg').html(data);
                $('#replymsg').val('');
                 $('#imgs').val('');
                $('#selectdiv').show();
            $('#replybtn').show();
            $('#loaderdiv').hide();
                alert('Replay Send Successfully');
                
            },
            error: function(){} 	        
            });
        }));
              
         

    });

	</script>

</html>
<?php } ?>