<?php
session_start();
 if(isset($_SESSION['logged_user'])) 
{$loggeduser =  $_SESSION['logged_user'];}
else {$loggeduser = 'Guest';}

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<title>Rummy Online | Play Indian Rummy Games at rummysahara.com </title>
<meta name="description" content="Play rummy online at rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS"/>
<meta name="keywords" content="Rummy, Indian Rummy, rummy online, classic rummy, 13 Cards Rummy, Rummy Games, Rummy Free, Play Rummy, Rummy 24x7, Card Games, Rummy Online" />
<meta name="robots" content="follow, index" />
<meta name="news_keywords" content="Rummy, Indian Rummy, 13 Cards Rummy, Rummy Games, Rummy Free, Play Rummy, Rummy online game, Card Games, Rummy Online" />
<meta property='og:title' content='Rummy Online | Play Indian Rummy Games at rummysahara.com'/>
<meta property='og:description' content='Play rummy online at rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS - Click to PLAY NOW!' />
<meta property='og:url' content='http://www.rummysahara.com'/>
<meta property='og:site_name' content='rummysahara'/>
<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@rummysahara' />
<meta name='twitter:creator' content='@rummysahara' />
<meta name='twitter:title' content='Rummy Online | Play Indian Rummy Games at rummysahara.com' />
<meta name='twitter:description' content='Play rummy online at rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS - Click to PLAY NOW!' />
<meta name='twitter:domain' content='http://www.rummysahara.com/' />
</head>
<body>
	<header>
		<div class="container-fluid">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-6 mt10">
						<a href="#."><img src="../images/logo.png" alt="rummysahara.com" title="logo" class="img-responsive"></a>
					</div>
					<?php if(!isset($_SESSION['logged_user'])) { ?>
					<form id="form_login" action="login.php" method="post">
						<div class="col-md-6 col-md-offset-3 col-sm-6 mt20 log-in">
							<div class="row">
								<div class="col-md-4 col-sm-4 pa0 col-xs-6 mt5">
									<input class="width94p" name="username" id="username" type="text" placeholder="User Id" autocomplete="off" required/>
								</div>
								<div class="col-md-4 col-sm-4 pa0 col-xs-6 mt5 mb5">
									<input class="width94p" name="user_password" id="user_password" type="password" placeholder="Password" autocomplete="off" required/>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12 pa0">
									<button class="btn btn-warning" type="Submit">LOGIN</button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 pa0">
									<a href="forgot-password.php" class="color-white">Forgot password ?</a>
								</div>
							</div>
						</div>
					</form>
					<?php } else { 
					header("Location:point-lobby-rummy.php");
					}  ?>
				</div>
			</div>
		</div>
	</header>
	<main>
		<div class="container-fluid pa0 mt20 index-cara-wrapper">
			<div class="container">
				<div class="row pos-rel">
					<div class="col-md-12">
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel"  data-interval="2000">
						  <!-- Indicators -->
							<ol class="carousel-indicators">
								<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
								<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							</ol>
							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox">
								<div class="item active">
									<img src="../images/carousel.png" alt="play rummy games">
								</div>
								<div class="item">
									<img src="../images/carousel.png" alt="rummy games">
								</div>
							</div>
						</div>
					</div>
					<div class="play-now hidden-xs hidden-sm"><button class="btn btn-warning">PLAY NOW</button></div>
					<?php if(!isset($_SESSION['logged_user'])) { ?>
					<div class="col-md-4 col-sm-4 mt20 sign-up">
						<h3 class="text-center mt0 pt20">Play Rummy Now!</h3>
						<h4 class="text-center mt0">Get Sign Up 1000*</h4>
						<hr class="hidden-sm">
						<form id="form_register" action="register.php" method="post">
							<label>User Name</label>:
							<input  style="width:66%;" type="text" placeholder="User Name" name="user_name" id="user_name" autocomplete="off" required><br>
							<label>E-mail</label>:
							<input  style="width:66%;" type="email" name="email" id="email" placeholder="E-mail Address" autocomplete="off" required><br>
							<label>Mobile No</label>:
							<input  style="width:66%;" type="tel" name="user_mobile" id="user_mobile" placeholder="9998887776" autocomplete="off" maxlength="10" minlength="10" required >
							<span id="mobilemsg" style="color: red;"></span>
							<br><!--onblur="validateMobile(this.value)" -->
							<label>Password</label>:
							<input  style="width:66%;" type="password" name="user_pwd" id="user_pwd" placeholder="Password" autocomplete="off" minlength="6" required><br>
							<label>State</label>:
								<select class="form-control" name="state" id="state">
									<option value="">Select State</option>
									<option value="1">Andaman and Nicobar Islands</option>
									<option value="2">Andhra Pradesh</option>
									<option value="3">Arunachal Pradesh</option>
									<option value="4">Assam</option>
									<option value="5">Bihar</option>
									<option value="6">Chandigarh</option>
									<option value="7">Chhattisgarh</option>
									<option value="8">Dadra and Nagar Haveli</option>
									<option value="9">Daman and Diu</option>
									<option value="10">Delhi</option>
									<option value="11">Goa</option>
									<option value="12">Gujarat</option>
									<option value="13">Haryana</option>
									<option value="14">Himachal Pradesh</option>
									<option value="15">Jammu and Kashmir</option>
									<option value="16">Jharkhand</option>
									<option value="17">Karnataka</option>
									<option value="18">Kerala</option>
									<option value="19">Lakshadweep</option>
									<option value="20">Madhya Pradesh</option>
									<option value="21">Maharashtra</option>
									<option value="22">Manipur</option>
									<option value="23">Meghalaya</option>
									<option value="24">Mizoram</option>
									<option value="25">Nagaland</option>
									<option value="26">Odisha</option>
									<option value="27">Pondicherry</option>
									<option value="28">Punjab</option>
									<option value="29">Rajasthan</option>
									<option value="30">Sikkim</option>
									<option value="31">Tamil Nadu</option>
									<option value="32">Telangana</option>
									<option value="33">Tripura</option>
									<option value="34">Uttar Pradesh</option>
									<option value="35">Uttarakhand</option>
									<option value="36">West Bengal</option>
									<button class="btn btn-danger">SUBMIT</button>
									<p class="text-center">By signing up you accept you are 18+ and agree to our <a href="#.">T & C</a></p> 
								</select>
								<p class="text-center"><input type="checkbox" autocomplete="off" style="-webkit-appearance:checkbox"/>
								By signing up you accept you are 18+ and agree to our <a href="terms-and-conditions.php">T & C</a></p><br>
								<button class="btn btn-danger" id="btn_sumbit">SUBMIT</button>
						</form>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="container-fluid pa0">
			<div class="container fav-online-rummy mt20">
				<div class="row">
					<marquee>Attention TELANGANA USERS: All users residing or logging in from the State of Telangana will not have access to our real money games. <a href="#.">Know more</a></marquee>
					<h2 class="text-uppercase text-center color-white">india's favourite online rummy site - play indian rummy game online</h2>
					<h4 class="text-center color-white"><i>Awesome Online Rummy Game Experience! Step Inside to Enjoy Amazing Online Rummy Games with World Class Gaming Services from rummysahara.com</i></h4>
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="../images/bonus.png" class="img-responsive" alt="mobile rummy experience"></div>
							<h3>Biggest Welcome Bonus</h3>
							<p class="pb20">Get 200% Bonus up to Rs.1000. Register now and get welcome bonus</p>
						</div>
					</div> 
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="../images/security.png" class="img-responsive" alt="real cash rummy game"></div>
							<h3>100% Legal & Secure</h3>
							<p class="pb20">Complete Security & RNG Certified, Anti-Fraud system & payment security</p>
						</div>
					</div> 
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="../images/payment.png" class="img-responsive" alt="indian rummy online"></div>
							<h3>Multiple Payment Options</h3>
							<p class="pb20">All major credit/debit cards accepted, Net banking from 50+ banks & wallets</p>
						</div>
					</div> 
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="../images/winbig.png" class="img-responsive" alt="play rummy"></div>
							<h3>Think Big ! Win Big !</h3>
							<p class="pb20">Play and win big cash prices and lots other gifts on rummysahara.com</p>
						</div>
					</div> 
				</div>
				<hr>
			</div>
		</div>
		<div class="container-fluid pa0 mb30">
			<div class="container index-content-wrapper">
				<div class="row">
					<div class="col-md-12 mb10">
						<div class="col-md-12 bg-grey br10">
							<h4 class="pt20">Legality of Playing Rummy</h4><hr>
							<p>"Rummy has been declared by the courts of law to be a game of skill or mere skill. Games of skill or mere skill are excluded from the applicability of laws prohibiting betting and gambling ('Betting and Gambling' being a state subject under the Constitution of India) in all states to the exception of a few. However, the states of Assam and Orissa have not provided clear rulings on this matter and are thus ambiguous territories. Playing rummy online is also legal in India"</p>
							<p>In 1957 the Supreme Court stated that prize competitions which involve substantial skill are business activities that are protected under Article 19(1)(g) of the Constitution of India.</p>
							<p>The Supreme Court of India in the year 1968 has ruled that rummy is a game of skills. This judgement has been relied and followed in many subsequent judgements. In 1996, the Supreme Court of India had also stated that
								(i) competition where chances of success depends on significant degree of skill is not considered as ‘gambling’ and
								(ii) despite the fact that there is an element of chance, rummy is preponderantly a game of skills and, thus, may be considered as a game of ‘mere skill’.
							</p>
							<p class="pb20">"Rummy, on the other hand, requires certain amount of skill because the fall of
								the cards has to be memorised and the building up of Rummy requires considerable
								skill in holding and discarding cards. We cannot, therefore, say that the game of
								Rummy is a game of entire chance. It is mainly and preponderantly a game of skill.
								The chance in Rummy is of the same character as the chance in a deal at a game of
								bridge."
							</p>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-2 mt10 col-sm-3">
						<div class="col-md-12 bg-grey pb30">
							<h4 class="pt20">Why Join Us</h4><hr>
							<span class="glyphicon glyphicon-menu-right"></span><a href="#">Welcome <span class="fs14">Bonus</span></a><br>
							<span class="glyphicon glyphicon-menu-right mt15"></span><a href="#">Secure <span class="fs14">Transactions</span></a><br>
							<span class="glyphicon glyphicon-menu-right mt15"></span><a href="#">Easy <span class="fs14">Payouts</span></a><br>
							<span class="glyphicon glyphicon-menu-right mt15"></span><a href="#">Referal <span class="fs14">Bonus</span></a><br>
							<span class="glyphicon glyphicon-menu-right mt15"></span><a href="#">Tournaments</a><br>
							<span class="glyphicon glyphicon-menu-right mt15"></span><a href="#">Rewards</a><br>
							<span class="glyphicon glyphicon-menu-right mt15"></span><a href="#">Coupan <span class="fs14">Codes</span></a><br>
						</div>
					</div>
					<div class="col-md-8 mt10 col-sm-6">
						<div class="col-md-12 bg-grey">
							<h4 class="pt20">Play Rummy Online</h4><hr>
							<p>According to supreme court ruling, now rummy is fully legal in India. So continue Playing Indian Rummy Game, Play more, and Earn more. Sharpen your Skills by Playing Rummy Online.</p>
							<p>The primary purpose of rummysahara is to provide wholesome entertainment to individuals, their family, friends and colleagues. rummysahara is meant for time pass and provides you the ability to earn money - a completely different approach to most free card game sites.</p>
							<p class="pb20">Play Indian rummy online with real players in the most enhanced multiplayer rummy environment. Enjoy a endless 24x7 rummy experience replete with wonderful features in the comfort of your home.<br>
								It is Legal to Play Rummy.<br>
								100% Welcome Bonus up to Rs.2000<br>
								Enhanced Gaming Experience.<br>
								Sharpen your Skills. <br>
							</p>
						</div> 
					</div>
					<div class="col-md-2 mt10 col-sm-3">
						<div class="col-md-12 bg-grey">
							<h4 class="pt20">Download for Mobile</h4><hr class="mb30">
							<a href="#." class="text-center"><img src="../images/android-app.png" class="img-responsive" alt="rummy on mobile"></a>
							<p class="text-center mt30 pb30">Play Rummy online on your mobile phones with friends and take joy of entertainment</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid black-bg testimonials pa0">
			<div class="container mt20 mb30">
				<div class="row">
					<div class="col-md-4 col-xs-2 col-sm-4 mt20 pr0"><hr></div>
					<div class="col-md-4 col-xs-8 col-sm-4">
						<h2 class="text-center color-white">Testimonials</h2>
					</div>
					<div class="col-md-4 col-xs-2 col-sm-4 mt20 pl0"><hr></div>
				</div>
				<div class="row mt20">
					<div class="col-md-8 col-md-offset-2">
						<div class="row">
							<div class="col-md-12 col-xs-9 col-sm-6">
								<!-- Tab panes -->
								<div>
									<!-- Tab panes -->
									<div class="tab-content mb30">
										<div role="tabpanel" class="tab-pane active" id="home">
											<p><i>"Awesome, never thought I could win Monthly Million Tournament. It's like a dream come true. I congratulate and thank rummysahara that they provide every detail on their screen so nobody misses it. Website works good. Thank you!"</i></p>
											<h5><i>Mr. Bharat Aghav</i></h5>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="profile">
											<p><i>"Awesome, never thought I could win Monthly Million Tournament. It's like a dream come true. I congratulate and thank rummysahara that they provide every detail on their screen so nobody misses it. Website works good. Thank you!"</i></p>
											<h5><i>Mr. Atul Daware</i></h5>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="messages">
											<p><i>"Awesome, never thought I could win Monthly Million Tournament. It's like a dream come true. I congratulate and thank rummysahara that they provide every detail on their screen so nobody misses it. Website works good. Thank you!"</i></p>
											<h5><i>Mr. Bharat Aghav</i></h5>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="settings">
											<p><i>"Awesome, never thought I could win Monthly Million Tournament. It's like a dream come true. I congratulate and thank rummysahara that they provide every detail on their screen so nobody misses it. Website works good. Thank you!"</i></p>
											<h5><i>Mr. Atul Daware</i></h5>
										</div>
									</div>
									<!-- Nav tabs -->
									<ul class="nav nav-tabs pull-right" role="tablist">
										<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"></a></li>
										<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"></a></li>
										<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"></a></li>
										<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<footer>
		<div id="footer" class="mt20 mb20"></div>
	</footer>
</body>
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		  
		   /* var macAddress = "";
			var ipAddress = "";
			var computerName = "";
			var wmi = GetObject("winmgmts:{impersonationLevel=impersonate}");
			e = new Enumerator(wmi.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration WHERE IPEnabled = True"));
			for(; !e.atEnd(); e.moveNext()) {
				var s = e.item();
				macAddress = s.MACAddress;
				ipAddress = s.IPAddress(0);
				computerName = s.DNSHostName;
			}  */
	
		$("#user_mobile").keypress(function(e)
		{
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			//alert("Enter Digits Only...!");
			$("#mobilemsg").text("Enter Digits Only...!");
			}
			else  $("#mobilemsg").text("");
		});
		
		});
	</script>
</html>