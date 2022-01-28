<?php
session_start();
include('database.php');
 if(isset($_SESSION['logged_user'])) 
{$loggeduser =  $_SESSION['logged_user'];}
else {$loggeduser = 'Guest';}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 
				
						$check_active=$_REQUEST['activattion_id'];
					
								
									$sql = "SELECT activation_key FROM t_activation where activation_key='".$check_active."'  ";
									
										$result = $conn->query($sql);
									
										if($result->num_rows > 0)
										{
										
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

		<div class="container sign-in-wrapper">
			<div class="row">
				<h3 class="color-white text-center">Login Now to Start Playing Rummy Online.</h3>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
							<?php	if($status=='1'){ ?>
								 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<center>Your Activation successfully Done</center>
							  </div>
							<?php }?>
									<?php if($status=='0'){ ?>
										 <div class="alert alert-danger alert-dismissable fade in">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<center>Invalid Activation Link.</center>
									  </div>
									<?php } ?>
					
					</div>
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
						$('#form_sign_in').trigger("reset");
						$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
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