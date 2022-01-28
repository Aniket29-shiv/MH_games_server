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


//"SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";

/*$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
		$first_name = $row['first_name'];
	}
}
$sql1 = "SELECT * FROM `game_transactions`  where player_name = '".$loggeduser."' ORDER BY id DESC";
$result1 = $conn->query($sql1);
$conn->close();*/

$sql = "select u.user_id,u.username,t.title,t.entry_fee,tt.tournament_id,tt.position,tt.score,tt.entry_date from users as u 
left join `tournament_transaction` as tt on tt.player_id=u.user_id
left join `tournament` as t on t.tournament_id=tt.tournament_id
where u.username='$loggeduser' order by t.tournament_id desc";
//echo $sql;
$result1 = $conn->query($sql);

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/bootstrap.css" rel="stylesheet">
<!--	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
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
				</div>-->
				
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-8">
						<div class="row">
							<div class="col-md-12">
								<h3 class="color-white text-center mt20"><b>My Transactions</b></h3>
								<div class="table-responsive " style="height: 400px;overflow-y: scroll;background: white;">
									<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
										<thead>
											<tr style='background-color: wheat;'>
												<th style="width:1%;text-align:center;font-size: 12px;">Sr.No</th>
												<th style="width:10%;text-align:center;font-size: 12px;">Tournament ID</th>
												<th style="width:28%;text-align:center;font-size: 12px;">Title</th>
												<th style="width:20%;text-align:center;font-size: 12px;">Entry fee</th>
												<th style="width:6%;text-align:center;font-size: 12px;">Position</th>
												<th style="width:16%;text-align:center;font-size: 12px;">Score</th>
												<th style="width:30%;text-align:center;font-size: 12px;">Date</th>
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
													<td><?php echo $row1['tournament_id'];?></td>
													<td><?php echo $row1['title'];?></td>
													<td><?php echo $row1['entry_fee'];?></td>
													<td><?php echo $row1['position'];?></td>
													<td><?php echo $row1['score'];?></td>
													<td><?php echo $row1['entry_date'];?></td>
													</tr>
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