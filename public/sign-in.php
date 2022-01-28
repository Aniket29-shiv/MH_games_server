<?php
session_start();
 if(isset($_SESSION['logged_user'])) 
{$loggeduser =  $_SESSION['logged_user'];}
else {$loggeduser = 'Guest';}

?>
</DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<title>Rummy Online | Play Indian Rummy Games at Rummysahara.com </title>
<meta name="description" content="Play rummy online at Rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS"/>
<meta name="keywords" content="Rummy, Indian Rummy, rummy online, classic rummy, 13 Cards Rummy, Rummy Games, Rummy Free, Play Rummy, Rummy 24x7, Card Games, Rummy Online" />
<meta name="robots" content="follow, index" />
<meta name="news_keywords" content="Rummy, Indian Rummy, 13 Cards Rummy, Rummy Games, Rummy Free, Play Rummy, Rummy online game, Card Games, Rummy Online" />
<meta property='og:title' content='Rummy Online | Play Indian Rummy Games at Rummysahara.com'/>
<meta property='og:description' content='Play rummy online at Rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS - Click to PLAY NOW!' />
<meta property='og:url' content='http://www.Rummysahara.com'/>
<meta property='og:site_name' content='Rummysahara'/>
<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@Rummysahara' />
<meta name='twitter:creator' content='@Rummysahara' />
<meta name='twitter:title' content='Rummy Online | Play Indian Rummy Games at Rummysahara.com' />
<meta name='twitter:description' content='Play rummy online at Rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS - Click to PLAY NOW!' />
<meta name='twitter:domain' content='http://www.Rummysahara.com/' />
</head>
<body>
<header>
	<div id="header"></div>
</header>
<main>
	<div class="container-fluid pa0 mt20">
		<?php if(!isset($_SESSION['logged_user'])) { ?>
		<div class="container sign-in-wrapper">
			<div class="row">
				<h3 class="color-white text-center">Login Now to Start Playing Rummy Online.</h3>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
						<div class="black-bg mt30">
							<h4 class="color-white text-center">Login to <span style="color:#ffff1a">Rummysahara</span></h4>
						</div>
						<form id="form_sign_in" action="login.php" method="post">
						
						<div class="bg-grey ">
						<span id="login_failure_msg" style="display: none; text-align: center;
						color: red;">Either Username or password is incorrect,please try again.</span>
						<span id="login_block_msg" style="display: none; text-align: center;
						color: red;">your account is disabled please contact us.</span>
							<input type="text" name="username" id="username"  placeholder="User ID" autocomplete="off" required/>
							<input type="password" name="user_password" id="user_password" placeholder="Password" autocomplete="off" required/>
							<button class="btn btn-default color-white mt20" type="Submit">Login</button><br>
							<a href="forgot-password.php">Forgot password ?</a>
							<a href="registration.php" class="pull-right">Sign Up</a>
						</div>
						</form>
					</div>
				</div>
			</div>
			<hr class="mt35">
		</div>
		<?php } else { ?>
		<div class="container sign-in-wrapper">
			<div class="row">
				<h3 class="color-white text-center">You have already logged as : <b style="color:yellow"><?php echo $loggeduser; ?></b></h3>
			</div>
		</div>
		<?php }  ?>
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
		  
		  var frm1 = $('#form_sign_in');
			frm1.submit(function (e) {

			e.preventDefault();
			$.ajax({
				type: frm1.attr('method'),
				url: frm1.attr('action'),
				data: frm1.serialize(),
				success: function (data) {
					if(data == true)
					{ window.location=('point-lobby-rummy.php');}
					else 
					{
					    
					    if(data == 2){
					         $('#form_login').trigger("reset");
						$('#login_block_msg').fadeIn().delay(25000).fadeOut();
					      
					    }else{
						$('#form_sign_in').trigger("reset");
						$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
					    }
					}
					
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		});
	</script>
</html>