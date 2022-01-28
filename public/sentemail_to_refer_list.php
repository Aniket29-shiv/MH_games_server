<?php
session_start();
 if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
{
$loggeduser =  $_SESSION['logged_user'];

$losscommi=0;
$wincommi=0;
include 'database.php';

    $from1='';
    $from='';
    $to='';
    $to1='';
    $email='';
   
    
    if(isset($_GET['email'])){ $email=$_GET['email'];}
    
    if(isset($_GET['from'])){
        
        $from1=$_GET['from'];
        if($from1 != ''){ $from=date('Y-m-d',strtotime($from1));}
        
    }
     if(isset($_GET['to'])){ 
         
         $to1=$_GET['to'];
         if($to1 != ''){ $to=date('Y-m-d',strtotime($to1));}
         
     }
   

function listpromotions($conn,$from,$to,$email) {
    
    $refid =  $_SESSION['user_id'];
    $makequery="SELECT * FROM `referral_send` WHERE referral_id ='$refid' ";
    
    if($email != ''){ $makequery .=" and `receiver`='$email'"; }
    if($from != ''){ $makequery .=" and  `date` >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and  `date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY `date`  DESC";
 
 	$query=mysqli_query ($conn,$makequery);
 	
    if(mysqli_num_rows(	$query) > 0){   
        
        	while($listdata=mysqli_fetch_object($query)){
    	    
                 
                    echo '<tr>
                   <td>'.$listdata->date.'</td>
                    <td>'.$listdata->receiver.'</td> 
                    <td>'.$listdata->subject.'</td>
                    <td>'.$listdata->content.'</td> 
                  </tr>  ';
                   
    	    
    	}
    }
	
}


?>
</DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">

	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">	
		<link rel="stylesheet" href="../css/jquery-ui.css">
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
	<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
					<div class="row user-name pb20">
					<div class="col-md-12">
						
						
					</div>
				</div>
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
					    
						
						    		
						<div class="row">
						    	<h3 class="text-center"><b>Sent Mail List</b></h3>
						    
                                	<form method="get">
                                <div class="col-md-2 col-xs-12">
                                             <input type="text" class="form-control datepicker" autocomplete="off" name="from" value="<?php echo $from1;?>" placeholder="From Date" style="margin-bottom: 10px;width: 100%;">
                                           </div>
                                             <div class="col-md-2 col-xs-12">
                                                <input type="text" class="form-control datepicker" autocomplete="off"  name="to" value="<?php echo $to1;?>" placeholder="TO date" style="margin-bottom: 10px;width: 100%;">
                                           </div>
                                  <div class="col-md-4 col-xs-12">
                                             <input type="text" class="form-control" autocomplete="off" name="email" value="" placeholder="Search By Email" style="margin-bottom: 10px;width: 100%;">
                                           </div>
                                            
							<div class="col-md-1 col-xs-12">
						        <input type="submit" style="width: 144%;" class="btn btn-primary" name="search" value="Search">
						   </div>
							<div class="col-md-2 col-xs-12">
						      <a href="sentemail_to_refer_list.php"   class="btn btn-danger">Cancel</a> 
							
							</div>
							</form>
							<div class="col-md-12 tournaments-wrapper" style="overflow: auto;">								    
									<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
										<thead>
											<tr style='background-color: wheat;'>
                                              
                                                <th style="width:10%;text-align:center;font-size: 15px;">Date</th>
                                                
                                                <th style="width:10%;text-align:center;font-size: 15px;">Email</th>
                                                <th style="width:10%;text-align:center;font-size: 15px;">Subject</th>
                                               
                                                <th style="width:10%;text-align:center;font-size: 15px;">Content</th>
                                                
                                                   
											</tr>
										</thead>
										<tbody>
										<?php	
										listpromotions($conn,$from,$to,$email);
                                     	?>
										</tbody>
									</table>
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
		<script src="../../js/jquery-ui.js"></script>  

	<script>
		$(function(){
		    $(".datepicker").datepicker({
					dateFormat:'dd-mm-yy'
				});
			
			});
	</script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		});
	</script>
</html>
<?php } ?>