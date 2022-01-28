<?php
session_start();

 if(!isset($_SESSION['logged_user'])) 
{
//header("Location:sign-in.php");
 echo '<script type="text/javascript">window.location.href="sign-in.php";</script>';
}
else
{
$loggeduser =  $_SESSION['logged_user'];

include 'database.php';

$sql = "SELECT u.username, u.`mobile_no`, u.`email`, DATE_FORMAT(u.created_date,'%d/%m/%Y') as profile_created_date,acct.`play_chips`, acct.`real_chips`, acct.`redeemable_balance`, acct.`bonus`, acct.`player_club`, acct.`player_status` FROM users u left join accounts acct on u.user_id = acct.userid where acct.username = '".$loggeduser."'";
$result = $conn->query($sql);
//print_r($result); die();
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
		$redem_bal = $row['redeemable_balance'];
		$bonus = $row['bonus'];
		$ace_level = $row['player_club'];
		$created_date = $row['profile_created_date'];
		$email = $row['email']; 
		$mobile = $row['mobile_no'];
		$player_status = $row['player_status'];
	}

}
else {
echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
//header("Location:index.php");
//header("Location:sign-in.php");
 echo '<script type="text/javascript">window.location.href="sign-in.php";</script>';
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
							<h4><b><?php if($play_chips!='') echo $play_chips; else echo 0; ?></b></h4>
							<h5 class="color-white">Real Money :</h5>
							<h4><b><?php if($real_chips!='') echo $real_chips; else echo 0; ?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
				<hr>
				<div class="row account-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
							<h3 class="color-white text-center mt20"><b>My Account</b></h3>
							<div class="col-md-6">
								<div class="bg-grey">
									<h5 class="text-center mb0"><b>Account Overview </b></h5>
									<hr class="mt0">
									<div>
										<span>User Name</span>
											<label><?php echo $loggeduser; ?></label>
										<span>Play Chips</span>
										<h6><?php if($play_chips!='') echo $play_chips; else echo 0; ?></h6>
										<span>Real Chips</span>
										<h6><?php if($real_chips!='') echo $real_chips; else echo 0; ?> &nbsp <a href="buy-chips.php" class="pa0">Buy Now</a></h6>
										<span>Redeemable Bal</span>
										<h6>INR <?php if($redem_bal!='') echo $redem_bal; else echo 0; ?></h6>
										<span>Bonus</span>
										<h6><?php if($bonus!='') echo $bonus; else echo 0; ?></h6>
										<span>Club Level</span>
										<h6 class="mb30"><?php if($ace_level!='') echo $ace_level; else echo 'Silver'; ?></h6>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="bg-grey">
									<h5 class="text-center mb0"><b>Profile Overview</b></h5>
									<hr class="mt0">
									<div>   
										<span>Created on</span>
										<h6><?php if($created_date!='') echo $created_date; else echo ''; ?></h6>
										<span>Email ID</span>
										<h6><?php if($email!='') echo $email; else echo ''; ?></h6>
										<span>Mobile No</span>
										<h6><?php if($mobile!='') echo $mobile; else echo ''; ?></h6>
										<span>Player Status</span>
										<h6><?php if($player_status!='') echo $player_status; else echo 'Regular'; ?></h6><br>
										<a href="change-password.php">Change Password</a>
										<a href="my-profile.php" class="pull-right">Edit Profile</a>
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
		});
	</script>
</html>
<?php } ?>