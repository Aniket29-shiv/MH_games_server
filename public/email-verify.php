<?php

ob_start();
include "database.php";

	
						$status = '';
					$check_active=$_REQUEST['verify_code'];
					
								
								$sql = "SELECT 	user_id,activation_key FROM t_activation where activation_key='".$check_active."'  ";
									
										$result = $conn->query($sql);
									
										if($result->num_rows > 0)
										{
										    
										    	$row = $result->fetch_assoc();
										    	$user_id=$row['user_id'];
										   $sql = "update user_kyc_details set email_status ='Verified'  where  userid='".$user_id."'"; 
												$result2 = $conn->query($sql);
										
											   $query="UPDATE `t_activation` SET `activation_key`= '0' WHERE activation_key = '".$check_active."'";
												$result = $conn->query($query);
								// 			header("Location:indexa.php?status=1");
								$status='1';
										}
										else
										{
								// 			header("Location:activate.php?status=0");
									$status='0';
										}

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt20">
			<div class="container forgot-wrapper">
				<div class="row">
					<h3 class="text-center color-white pt20"></h3>
						<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
					
						<?php 	
					
					
						if($status=='1'){ ?>
								 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<center>Your Email successfully Verified</center>
							  </div>
							<?php }?>
									<?php if($status=='0'){ ?>
										 <div class="alert alert-danger alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<center>Invalid  Link.</center>
									  </div>
									<?php }?>
						
						</div>	
				</div>
				<hr class="mt35">
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
		});
	</script>
</html>