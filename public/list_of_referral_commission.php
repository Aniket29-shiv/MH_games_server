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
include 'include/transaction_referral.php';
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
						    	<h3 class="text-center"><b>Referral Commission</b></h3>
						    	 <h5 class="color-white" style="background-color:white;"><span style="margin:20px;">Commission On Lost : Rs. <?php
                                echo losscomm($conn,$game,$from,$to,$status,$refid,$losscommi); ?>/-</span>
                               <span style="margin-right:80px;"> Commission On Won : Rs. <?php
                                echo wincomm($conn,$game,$from,$to,$status,$refid,$wincommi);
                                ?>/-</span>
                                
                                <span> Commission Total : Rs. <?php
                                $wintotal=wincomm($conn,$game,$from,$to,$status,$refid,$wincommi);
                                $losstotal=losscomm($conn,$game,$from,$to,$status,$refid,$losscommi);
                                echo $wintotal+ $losstotal;
                                ?>/-</span>
                                </h5>
                                	<form method="get">
                                <div class="col-md-2 col-xs-12">
                                             <input type="text" class="form-control datepicker" autocomplete="off" name="from" value="<?php echo $from1;?>" placeholder="From Date" style="margin-bottom: 10px;width: 100%;">
                                           </div>
                                             <div class="col-md-2 col-xs-12">
                                                <input type="text" class="form-control datepicker" autocomplete="off"  name="to" value="<?php echo $to1;?>" placeholder="TO date" style="margin-bottom: 10px;width: 100%;">
                                           </div>
                                           
                                           <div class="col-md-2 col-xs-12">
						         <select class="btn btn-primary" name="game">
						   	        <option value="">Game Type</option>
						   	        <option value="Point Rummy">Point Rummy</option>
						   	         <option value="Deal Rummy">Deal Rummy</option>
						   	        <option value="Pool Rummy">Pool Rummy</option>
						   	       
						   	        
						   	    </select>
							</div>
							
							<div class="col-md-2 col-xs-12">
						        
						   	    <select class="btn btn-primary" name="status">
						   	        <option value="">Status Type</option>
						   	        <option value="Won">Won</option>
						   	         <option value="Lost">Lost</option>
						   	      
						   	        
						   	    </select>
							
							</div>
							<div class="col-md-1 col-xs-12">
						        <input type="submit" style="width: 144%;" class="btn btn-primary" name="search" value="Search">
						   </div>
							<div class="col-md-1 col-xs-12">
						      <a href="list_of_referral_commission.php"   class="btn btn-danger">Cancel</a> 
							
							</div>
							</form>
							<div class="col-md-12 tournaments-wrapper" style="overflow: auto;">								    
									<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
										<thead>
											<tr style='background-color: wheat;'>
                                              
                                                <th style="width:10%;text-align:center;font-size: 15px;">Date</th>
                                                
                                                <th style="width:10%;text-align:center;font-size: 15px;">Round</th>
                                                <th style="width:10%;text-align:center;font-size: 15px;">Table</th>
                                               
                                                <th style="width:10%;text-align:center;font-size: 15px;">Player</th>
                                                <th style="width:20%;text-align:center;font-size: 15px;">Game</th>
                                                <th style="width:20%;text-align:center;font-size: 15px;">Status</th>
                                                 <th style="width:20%;text-align:center;font-size: 15px;">Amount</th>
                                                  <th style="width:20%;text-align:center;font-size: 15px;">Commission</th>
                                                   
											</tr>
										</thead>
										<tbody>
										<?php	
										listpromotions($conn,$game,$from,$to,$status,$refid,$losscommi,$wincommi);
/*$makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g left join users as u on u.user_id=g.user_id where  `chip_type`='real' 
  and u.referral_code='$user_id' ORDER BY g.`transaction_date`  DESC";
   
											$result1 = $conn->query($makequery);
											if ($result1->num_rows > 0) { 
												 $i = 1;
												while($row1 = $result1->fetch_assoc())
												{
												*/	?>
													<!--<form action="update_flowback_record.php" method="post" id="flowback">
													<tr>
												
													<td><?php //echo $row1['transaction_date'];?></td>
												
													<td><?php //echo $row1['round_no'];?></td>													
													<td><?php //echo $row1['table_name'];?></td>
													<td><?php //echo $row1['player_name'];?></td>
                                                    <td><?php //echo $row1['game_type'];?></td>
                                                    <td><?php //echo $row1['status'];?></td>
                                                    <td><?php //echo $row1['amount'];?></td>
                                                    <?php 
                                                           
                                                                
                                                                // if($row1['status'] == 'Lost'){
                                                                //   echo  ' <td>'.number_format(($row1['amount']*($losscommi/100)),2).'</td> ';
                                                                // }
                                                                
                                                                // if($row1['status'] == 'Won'){
                                                                //   echo  ' <td>'.number_format(($row1['amount']*($wincommi/100)),2).'</td> ';
                                                                // }
                                                            
                                                           
                                                    ?>
                                                    <td><?php //echo $row1['chip_type'];?></td>
                                                   
													</tr>
													</form>-->
													<?php 
											/*	 $i++;			
												}
											}*/
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