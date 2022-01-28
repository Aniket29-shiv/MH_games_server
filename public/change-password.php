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
		$old_password = $row['password'];
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
							if($real_chips!='') echo $play_chips; else echo 0;
							?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
				
				<hr>
				<div class="row password-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
							<div class="col-md-8">
								<h3 class="color-white text-center mt20"><b>Change Password</b></h3>
								<div class="bg-grey mt30">
									<form id="form_change_pwd" action="update_password.php" method="post">
									
										<input id="hidden_old_pwd" type="hidden" value="<?php 
										if($old_password!='') {echo $old_password;} ?>">
										<input type="hidden" autocomplete="off" name="usernm" id="usernm" value="<?php echo $loggeduser; ?>">
										<label>Current Password</label>:
										<input id="old_pwd" name="old_pwd" type="password" placeholder="Current Password" autocomplete="off" required>
										<span id="old_pwd_msg" style="color: red;margin-left: 12px;"></span>
										<label>New Password</label>:
										<input id="new_pwd" name="new_pwd" type="password" placeholder="New Password" autocomplete="off"  minlength="6" required>
										<span id="new_pwd_msg" style="color: red;margin-left: 12px;"></span>
										<label>Confirm New Password</label>:
										<input id="confirm_pwd" type="password" placeholder="Confirm New Password" autocomplete="off"  minlength="6" required>
										<span id="confirm_pwd_msg" style="color: red;margin-left: 12px;"></span>
										<div class="text-center"><button class="btn btn-default" style="margin:25px">Submit</button></div>
										<span id="update_success" style="display: none;color: green;text-align: center;">Your password has been changed successfully.</span>
										<span id="update_failure" style="display: none;color: red;text-align: center;">Something went wrong,password updated failed.</span>
									</form>
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
	<script src="../js/jquery.md5.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		  
		  $("#old_pwd").blur(function(e)
			{
				var old_pwd = $("#hidden_old_pwd").val();
				var old_pwd_entered = $.md5($("#old_pwd").val());
				//alert(""+old_pwd+"--"+old_pwd_entered);
				if (old_pwd_entered != old_pwd) {
				$("#old_pwd_msg").text("Enter Your Old Password!");
				}
				else  $("#old_pwd_msg").text("");
			});
		
			$("#new_pwd").blur(function(e)
			{
				var old_pwd = $("#hidden_old_pwd").val();
				var new_pwd_entered = $("#new_pwd").val();
				if (new_pwd_entered == old_pwd) {
				$("#new_pwd_msg").text("Enter new Password than previous!");
				}
				else  $("#new_pwd_msg").text("");
			});
			
			$("#confirm_pwd").blur(function(e)
			{
				var new_pwd = $("#new_pwd").val();
				var confirm_pwd = $("#confirm_pwd").val();
				if (new_pwd != confirm_pwd) {
				$("#confirm_pwd_msg").text("Please, Check new password and confirm password should be same!");
				}
				else  $("#confirm_pwd_msg").text("");
			});
			
			var frm = $('#form_change_pwd');
			frm.submit(function (e) {
			e.preventDefault();
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function (data) {
				if(data == true)
					{ $('#update_success').fadeIn().delay(15000).fadeOut();}
					else 
					{
						$('#form_change_pwd').trigger("reset");
						$('#update_failure').fadeIn().delay(15000).fadeOut();
					}
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		
			<?php  
		 $message = isset($_GET['password_updated']) ? $_GET['password_updated'] : '';
		 if($message == true)
		 {
		 ?>
				$('#success_msg').fadeIn().delay(15000).fadeOut();
		<?php } ?>
		});
	</script>
</html>
<?php } ?>