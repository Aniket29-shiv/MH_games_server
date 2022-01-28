<?php
session_start();
$loggeduser =  $_SESSION['logged_user'];
include 'database.php';

$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$user_id = $row['user_id'];
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
		$first_name = $row['first_name'];
		$middle_name = $row['middle_name'];
		$last_name = $row['last_name'];
		$email = $row['email'];
		 //$disabled_email = $email!='' ? "disabled='disabled'" : "";
		$mobile_no = $row['mobile_no'];
	$pan_card_no = $row['pan_card_no'];
	}
}

	$sql = "SELECT * FROM reward_total_point where user_id = '".$user_id."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc())
		{
			$db_reward_points = $row['reward_points'];
		
		}
	    
	    
	}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico"/>
</head>
<body>
<header>
	<nav class="navbar navbar-default">
		<div class="container-fluid pa0 header-wrapper">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo MAINLINK2;?>point-lobby-rummy.php"><img src="../images/logo.png" class="img-responsive"></a>
			</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse mt25" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo MAINLINK2;?>point-fun-games.php">home<span class="sr-only">(current)</span></a></li>
						<li><a href="<?php echo MAINLINK2;?>promotions.php" class="active">promotions</a></li>
						<li><a href="<?php echo MAINLINK2;?>how-to-play.php">how to play</a></li>
						<li><a href="<?php echo MAINLINK2;?>mobile-rummy.php">mobile rummy</a></li>
						<li><a href="<?php echo MAINLINK2;?>contact-us.php">contact</a></li>
						<li><a href="<?php echo MAINLINK2;?>my-account.php">My Account</a></li>
						<!-- <li><a href="#">Log Out</a></li> -->
						<?php if(isset($_SESSION['logged_user'])) { ?>
						<li><a href="<?php echo MAINLINK2;?>logout.php" id="logout">Log Out</a></li>
						<?php } else { ?>
						<li class="dropdown">
							<a href="#" class="<?php echo MAINLINK2;?>dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Log In<span class="caret ml15"></span></a>
							<ul class="dropdown-menu">
								<form id="form_login_popup" action="login.php" method="post">
									<li><input type="text" name="username" id="username" placeholder="User Id" autocomlete="off" required></li>
									<li><input type="password" name="user_password" id="user_password"  placeholder="Password" class="mt10" autocomlete="off" required></li>
									<li><button class="btn btn-default mt10" type="Submit">LOGIN</button></li>
									<span id="login_failure_msg" style="display: none;color: yellow;  text-align: center;">Either Username or password is incorrect,please try again.</span>
									<a href="<?php echo MAINLINK2;?>forgot-password.php" class="mt15">Forgot Password ?</a><br>
									<a href="<?php echo MAINLINK2;?>registration.php">Sign Up</a>
								</form>
							</ul>
						</li>
						<?php } ?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div>
	</nav>
</header>
	<!--<div class="container-fluid mt35 pa0">
		<div class="container header">
			<div class="row black-bg mlr0">
				<div class="col-md-2 col-sm-3 col-xs-12">
					<a href="<?php echo MAINLINK2;?>point-lobby-rummy.php" class="text-uppercase mt10">play <span>now !</span></a>
				</div>
				<div class="col-md-8 col-sm-7 col-xs-12">
					<p class="color-white">Claim Rs <span>1500 + 200*</span> of FREE game play on your first purchase. To start playing on Rummysahara.com</p>
				</div>
				<?php if(!isset($_SESSION['logged_user'])) { ?>
				<div class="col-md-2 col-sm-2 col-xs-6 pull-right">
					<span class="hidden-sm"><i class="fa fa-hand-o-right" aria-hidden="true"></i></span>
					<a href="<?php echo MAINLINK2;?>registration.php"><button class="btn btn-default text-uppercase">sign up</button></a>
				</div>
				<?php } ?>
			</div>
		</div>	
	</div>-->
				<?php if(isset($_SESSION['logged_user'])) { ?>	<div class="container-fluid pa0">
			<div class="container account-cont-wrapper">
				<div class="row user-name mlr0 black-ft" style="margin-top: 15px;">
					<div class="col-md-12">
						<div class="col-md-6 col-sm-7">
							<h5 class="color-white">Welcome</h5>
							<h4><b><?php echo $loggeduser; ?></b></h4>
								<h5 class="color-white">Online Players :</h5>
							<h4><b><?PHP
									$file = "users.ini";
									$ip = $_SERVER['REMOTE_ADDR'];
									$time = time();
									$content = @file_get_contents($file);
									$new_content = $ip." = ".$time;
									$content .= $new_content."\r\n";
									@file_put_contents($file,$content);

									$users = @parse_ini_file($file);
									$count = 0;
									foreach($users as $ip=>$time){
										if($time >= time() - 300){ // past 3 minutes
											$count++;
										}
									}
									echo $count;
									?></b></h4>
								
							<h5 class="color-white" style="margin-left: 10px;">Rewards :</h5> 
							<?php
							if($db_reward_points==""){
							    $db_reward_points="00";
							    
							}
							
							?>
								<h4><?php echo $db_reward_points;?></h4>
						
							<a href="<?php echo MAINLINK2;?>redeem-chips.php">	<i  class="glyphicon glyphicon-plus" title="Redeem Your Rewards Points" style="color:white;"></i></a>
						</div>
						<div class="col-md-6 col-sm-5">
							<h5 class="color-white">Free Money :</h5>
							<h4><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?></h4>
							<h5 class="color-white">Real Money :</h5>
							<h4><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></h4>
							<a href="<?php echo MAINLINK2;?>buy-chips.php"><img src="<?php echo MAINLINK2;?>images/buynow.gif" style="height: 36px;"></a>
						</div>
					</div>
				</div>
			</div>		
	</div><?php } ?>
</body>
</html>
	<script>
		$(function() {
			$('#nav li a').click(function() {
				$('#nav li').removeClass();
			$($(this).attr('href')).addClass('active');
			});
			
			$("#logout").click(function()
			{
				<?php //session_destroy();?>
				window.location = 'logout.php';
			});
		
		var frm1 = $('#form_login_popup');
			frm1.submit(function (e) {

			e.preventDefault();
			$.ajax({
				type: frm1.attr('method'),
				url: frm1.attr('action'),
				data: frm1.serialize(),
				success: function (data) {
					if(data == true)
					{ window.location=('point-fun-games.php');}
					else 
					{
						$('#form_login_popup').trigger("reset");
						$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
					}
					
				},
				error: function (data) {
					$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		
		//alert(window.location.href);
		
		});
	</script>
        <script>
            $(function(){
                    
                  
                     var url=window.location.href;
                    // alert(url);
                      var dataString ='browseentry='+url;
                       
                        $.ajax({
                        
                        type: "POST",
                        url:"ajax_function.php",
                        data: dataString,
                        cache: false,
                        success: function(data){
                        }
                       
                        });
                    
                    
                   
                    
            });
        </script>
