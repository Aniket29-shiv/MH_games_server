<?php
session_start();
 
 if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
{
$loggeduser =  $_SESSION['logged_user'];

include 'database.php';


$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
	}	
}
else {
echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
header("Location:index.php");
}
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
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
	<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
			<!--		<div class="row user-name pb20">
					<div class="col-md-12">
						<div class="col-md-6 col-sm-5 black-bg">
							<h5 class="color-white">Welcome</h5>
							<h4><b><?php echo $loggeduser; ?></b></h4>
						</div>
						<div class="col-md-6 col-sm-7 black-bg">
							<h5 class="color-white">Play Chips :</h5>
							<h4><b><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?></b></h4>
							<h5 class="color-white"> Money :</h5>
							<h4><b><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
								<h3 class="text-center mt20"><b>Login History</b></h3>
								<div class="tournaments-wrapper" style="overflow: auto;">								    
									<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
										<thead>
											<tr style='background-color: wheat;'>
                                                <th style="width:1%;text-align:center;font-size: 12px;">Sr.No</th>
                                                <th style="width:10%;text-align:center;font-size: 10px;">OS</th>
                                                <th style="width:10%;text-align:center;font-size: 10px;">IP</th>
                                                <th style="width:10%;text-align:center;font-size: 10px;">city</th>
                                                <th style="width:10%;text-align:center;font-size: 10px;">Region</th>
                                                <th style="width:10%;text-align:center;font-size: 10px;">Country</th>
                                                <th style="width:10%;text-align:center;font-size: 10px;">Status</th>
                                                <th style="width:20%;text-align:center;font-size: 15px;">Login date</th>
                                                <th style="width:20%;text-align:center;font-size: 15px;">Logout Date</th>
											</tr>
										</thead>
										<tbody>
										<?php											
											require 'database.php';
											$sql1="select * from login_history where username='".$loggeduser."' order by id desc";
											//echo $sql1;
											$result1 = $conn->query($sql1);
											if ($result1->num_rows > 0) { 
												 $i = 1;
												while($row1 = $result1->fetch_assoc())
												{
													?>
													<form action="update_flowback_record.php" method="post" id="flowback">
													<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $row1['os'];?></td>
													<td><?php echo $row1['ip'];?></td>
													<td><?php echo $row1['city'];?></td>													
													<td><?php echo $row1['region'];?></td>
													<td><?php echo $row1['country'];?></td>	
													<td><?php echo $row1['status'];?></td>
                                                    <td><?php echo $row1['logindate'];?></td>
                                                    <td><?php echo $row1['logouttime'];?></td>
													</tr>
													</form>
													<?php 
												 $i++;			
												}
											}
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
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		});
	</script>
</html>
<?php } ?>