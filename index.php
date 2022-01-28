<?php
session_start();
 $fbkey='';
 $fbversion='';
 $googlekey='';
 $fbstatus='';
 $gstatus='';
if(isset($_SESSION['logged_user'])) 
{
header("Location:public/point-fun-games.php");
}else{

      include 'public/database.php';
      
      
        function webslider($conn){
            
            $makequery = "SELECT * FROM `webslider`  where deleted != 1 order by rank asc";
    	    $query = mysqli_query($conn,$makequery);
    	 
            	   if($listdata=mysqli_num_rows($query) > 0){
            	       
                	     $x=1;
                	     //echo 'hi';
                    	 while($listdata=mysqli_fetch_object($query)){
                    	     
                    	    
                            if($x == 1){
                               echo '<div class="item active"><img src="uploads/slider/'.$listdata->simage.'" alt="play rummy games" style="width:1200px;">	</div>';
                            }else{
                                echo '<div class="item"><img src="uploads/slider/'.$listdata->simage.'" alt="play rummy games" style="width:1200px;">	</div>';
                            }
                            $x++;
                        }
                        
                    }else{
                        echo '<div class="item active"><img src="uploads/slider/dummy.png" alt="play rummy games" style="width:1200px;">	</div>';
                    }
    	 }
    	 
    	 //====Scoial Login
    	 
    	 
    	  $getfbdata = mysqli_query($conn,"SELECT * FROM `social_login`  where id=1");
    	  $listfbdata=mysqli_fetch_object($getfbdata);
    	   $fbkey=$listfbdata->social_id;
           $fbversion=$listfbdata->version;
           $fbstatus=$listfbdata->status;
 
    	  $getgdata = mysqli_query($conn,"SELECT * FROM `social_login`  where id=2");
    	  $listgdata=mysqli_fetch_object($getgdata);
          $googlekey=$listgdata->social_id;
          $gstatus=$listgdata->status;
}
	if($_GET){ 
	  @$status = $_GET['status']; 
	} 
?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<title>Rummy Online | Play Indian Rummy Games at rummysahara.com </title>
<meta name="description" content="Play rummy online at rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS"/>
<meta name="keywords" content="Rummy, Indian Rummy, rummy online, classic rummy, 13 Cards Rummy, Rummy Games, Rummy Free, Play Rummy, Rummy 24x7, Card Games, Rummy Online" />
<meta name="robots" content="follow, index" />
<meta name="news_keywords" content="Rummy, Indian Rummy, 13 Cards Rummy, Rummy Games, Rummy Free, Play Rummy, Rummy online game, Card Games, Rummy Online" />
<meta property='og:title' content='Rummy Online | Play Indian Rummy Games at rummysahara.com'/>
<meta property='og:description' content='Play rummy online at rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS - Click to PLAY NOW!' />
<meta property='og:url' content='https://www.rummysahara.com'/>
<meta property='og:site_name' content='rummysahara'/>
<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@rummysahara' />
<meta name='twitter:creator' content='@rummysahara' />
<meta name='twitter:title' content='Rummy Online | Play Indian Rummy Games at rummysahara.com' />
<meta name='twitter:description' content='Play rummy online at rummysahara.com for premium and free rummy games. Play online rummy card games free and win real cash prizes. Play Classic Indian Rummy Online & GET FREE Rs.1000 WELCOME BONUS - Click to PLAY NOW!' />
<meta name='twitter:domain' content='https://www.rummysahara.com/' />
	<script>
        var fbkey='<?php echo $fbkey;?>';
        var fbversion='<?php echo $fbversion;?>';
	</script>
	
	
	<style>

.glow {
  font-size: 15px;
  color: #fff;
  text-align: center;
  -webkit-animation: glow 200ms ease-in-out infinite alternate;
  -moz-animation: glow 200ms ease-in-out infinite alternate;
  animation: glow 200ms ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 20px #fff, 0 0 20px #fff, 0 0 20px gold, 0 0 20px gold, 0 0 20px gold, 0 0 12px gold, 0 0 15px gold;
  }
  
  to {
    text-shadow: 0 0 20px #fff, 0 0 12px #ff4da6, 0 0 10px #ff4da6, 0 0 10px #ff4da6, 0 0 12px #ff4da6, 0 0 15px #ff4da6, 0 0 20px #ff4da6;
  }
}
</style>
	
	<style>
.btn {
  background-color: #f50505;
  border: none;
  color: white;
  padding: 6px 20px;
  cursor: pointer;
  font-size: 15px;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
</style>
	
	
	<style type="text/css">
.mobileShow {
  display: none;
}

/* full width of parent */
.mobileShow img{
    width: 100%;
}

/* Smartphone Portrait and Landscape */
@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
  .mobileShow {
    display: block;
    width: 40%;
    position: fixed;
    bottom: 0;
    left: 50%;
    margin: 0 0 0 -20%;
  }
}
</style>
	
	
	
</head>
<body>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<!--376276911976-ai0n310h1be2mb4bhhii6ht32hnekt2i.apps.googleusercontent.com-->
<meta name="google-signin-client_id" content="<?php echo  $googlekey;?>" >
	<header>
		<div class="container-fluid mtback">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-6 mt10">
						<a href="index.php"><img src="images/logo.png" alt="RummySahara.com" title="logo" class="img-responsive"></a>
					</div>
					<?php //if(!isset($_SESSION['logged_user'])) { ?>
					
					<form id="form_login" action="public/login.php" method="post">
						<div class="col-md-6 col-md-offset-3 col-sm-6 log-in">
							<div class="row">
								<div class="col-md-4 col-sm-4 pa0 col-xs-6 mt5">
									<input class="width94p" name="username" id="username" type="text" placeholder="User Id" autocomplete="off" required/>
								</div>
								<div class="col-md-4 col-sm-4 pa0 col-xs-6 mt5 mb5">
									<input class="width94p" name="user_password" id="user_password" type="password" placeholder="Password" autocomplete="off" required/>
								</div>
								<!--<div class="col-md-2 col-sm-2 col-xs-12 pa0">
									<button class="btn btn-warning" type="Submit">LOGIN</button>
								</div>-->
									<div class="col-md-4 col-sm-4 col-xs-6">
									<button class="btn btn-warning" type="Submit">LOGIN</button> 
										<!--<a href="public/fbconfig.php" class="fa fa-facebook"></a>-->
										<?php if($fbstatus == 'active'){?>
										<a href="javascript:void(0);" onclick="fbLogin()" id="fbLink"><img src="images/facebook.jpg" style="width:28px; margin-left: 5px;"></a>
									<?php }?>		<!--	<a href="javascript:void(0);" onclick="fbLogin()" id="fbLink" class="fa fa-facebook"></a>-->
							<!--	<a href="public/fbconfig.php" class="fa fa-facebook"></a>-->
				<!--	<a href="" class="fa fa-google " data-onsuccess="onSignIn" title="Login with Gmail "></a>-->
								</div>
									<?php if($gstatus == 'active'){?>
							 <div class="g-signin2" data-onsuccess="onSignIn"style="height: 25px; width: 25px;float: left; margin-left: -50px; margin-top: 4px;"></div>
							 	<?php }?>

							</div>
							<span id="login_failure_msg" style="display: none;margin-left: 0px; color: yellow;">Login Failed,please try again.</span>
							
							<div class="row">
								<div class="col-md-12 pa0">
									<a href="public/forgot-password.php" class="color-white">Forgot password ?</a>&nbsp;&nbsp;
									<a href="apk/rummysahara.apk" class="glow" style="font-size:15px; background:black; padding:2px;">Download Android</a>
						
								</div>
							</div>
						</div>
					</form>
					<?php //} ?>
				</div>
			</div>
		</div>
	</header>
	
	<main>

		<div class="container-fluid pa0 mt20 index-cara-wrapper">
			<div class="container">

				<div class="row pos-rel">
					<div class="col-md-9">
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel"  data-interval="2000">
						    
						  <!-- Indicators -->
							<ol class="carousel-indicators">
								<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
								<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							</ol>
							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox">
							     <?php webslider($conn);?>
								<!--<div class="item active">
									<img src="images/play-rummy-game.png" alt="play rummy games">
								</div>
								<div class="item">
									<img src="images/play-rummy.png" alt="rummy games">
								</div>-->
							</div>
						</div>
					</div>
					<div class="play-now hidden-xs hidden-sm">
					<a href="public/point-lobby-rummy.php"><button class="btn btn-warning">PLAY NOW</button></a></div>
					<?php //if(!isset($_SESSION['logged_user'])) { ?>
					<div class="col-md-3 col-sm-3 sign-up">
						<h3 class="text-center mt0 pt20">Play Rummy Now!</h3>
						<!--<hr class="hidden-sm">-->
						<?php if($status=='1'){ ?>
								 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<center>Your account Activated successfully Done..Login here</center>
							  </div>
							<?php }?>
						<span id="success_msg" style="display: none;margin-left: 0px; color: white;">Your account has been created successfully and Activation Link sent To Your Email ID</span>
						<span id="failure_msg" style="display: none;margin-left: 0px; color: white;">Your registration was not done,please try again.</span>
						<form id="form_register" action="public/register.php" method="post">
							<label>User Name</label>:
							<input  style="width:66%;" type="text" placeholder="User Name" name="user_name" pattern=".{5,15}" required title="5 to 15 characters" id="user_name" autocomplete="off" required>
							<span id="user_name_msg" style="color: red;"></span>
							<br>
							<label>E-mail</label>:
							<input  style="width:66%;" type="email" name="email" id="email" placeholder="E-mail Address" autocomplete="off" required>
							<span id="user_email_msg" style="color: red;"></span>
							<br>
							<label>Mobile No</label>:
							<input  style="width:66%;" type="tel" name="user_mobile" id="user_mobile" placeholder="9998887776" autocomplete="off" maxlength="10" minlength="10" required >
							<span id="user_mobile_msg" style="color: red;"></span>
							<span id="mobilemsg" style="color: red;"></span>
							<br><!--onblur="validateMobile(this.value)" -->
							<label>Gender</label>:
							<select name="gender" id="gender" class="form-control" required>
								<option value="">Select</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select><br>
							<label>Password</label>:
							<input  style="width:66%;" type="password" name="user_pwd" id="user_pwd" placeholder="Password" autocomplete="off" pattern=".{5,15}" required title="5 to 15 characters" required><br>
							<label>State</label>:
								<select class="form-control" name="state" id="state" required>
									<option value="">Select State</option>
									<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
									<option value="Andhra Pradesh">Andhra Pradesh</option>
									<option value="Arunachal Pradesh">Arunachal Pradesh</option>
									<option value="Assam">Assam</option>
									<option value="Bihar">Bihar</option>
									<option value="Chandigarh">Chandigarh</option>
									<option value="Chhattisgarh">Chhattisgarh</option>
									<option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
									<option value="Daman and Diu">Daman and Diu</option>
									<option value="Delhi">Delhi</option>
									<option value="Goa">Goa</option>
									<option value="Gujarat">Gujarat</option>
									<option value="Haryana">Haryana</option>
									<option value="Himachal Pradesh">Himachal Pradesh</option>
									<option value="Jammu and Kashmir">Jammu and Kashmir</option>
									<option value="Jharkhand">Jharkhand</option>
									<option value="Karnataka">Karnataka</option>
									<option value="Kerala">Kerala</option>
									<option value="Lakshadweep">Lakshadweep</option>
									<option value="Madhya Pradesh">Madhya Pradesh</option>
									<option value="Maharashtra">Maharashtra</option>
									<option value="Manipur">Manipur</option>
									<option value="Meghalaya">Meghalaya</option>
									<option value="Mizoram">Mizoram</option>
									<option value="Nagaland">Nagaland</option>
									<option value="Odisha">Odisha</option>
									<option value="Pondicherry">Pondicherry</option>
									<option value="Punjab">Punjab</option>
									<option value="Rajasthan">Rajasthan</option>
									<option value="Sikkim">Sikkim</option>
									<option value="Tamil Nadu">Tamil Nadu</option>
									<option value="Telangana">Telangana</option>
									<option value="Tripura">Tripura</option>
									<option value="Uttar Pradesh">Uttar Pradesh</option>
									<option value="Uttarakhand">Uttarakhand</option>
									<option value="West Bengal">West Bengal</option>
									<button class="btn btn-danger">SUBMIT</button>
									<p class="text-center">By signing up you accept you are 18+ and agree to our <a href="#.">T & C</a></p> 
								</select>
								
									<label>Referral Code</label>:
								<input type="number" style="color:black;width:66%;" id="user_ref" name="user_ref"  value="<?php if(isset($_GET["referal_code"])){ echo $_GET['referal_code'];}?>" maxlength="10" placeholder="Referral Code" autocomplete="off" />
								<p class="text-center"><input type="checkbox" autocomplete="off" style="-webkit-appearance:checkbox" required/>
								By signing up you accept you are 18+ and agree to our <a href="/public/terms-and-conditions.php">T & C</a></p><br>
								<button class="btn btn-danger" id="btn_sumbit">SUBMIT</button>
						</form>
					</div>
					<?php //} ?>
				</div>
			</div>
		</div>
		<div class="container-fluid pa0">
			<div class="container fav-online-rummy mt20 welcome-bonus">
				<div class="row">
					<marquee>Attention TELANGANA USERS: All users residing or logging in from the State of Telangana will not have access to our real money games. <a href="#.">Know more</a></marquee>
					<h2 class="text-uppercase text-center color-white">india's favourite online rummy site - play indian rummy game online</h2>
					<h4 class="text-center color-white"><i>Awesome Online Rummy Game Experience! Step Inside to Enjoy Amazing Online Rummy Games with World Class Gaming Services from rummysahara.com</i></h4>
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="images/bonus.png" class="img-responsive" alt="mobile rummy experience"></div>
							<h3>Biggest Welcome Bonus</h3>
							<p class="pb20">Get 200% Bonus up to Rs.1000. Register now and get welcome bonus</p>
						</div>
					</div> 
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="images/security.png" class="img-responsive" alt="real cash rummy game"></div>
							<h3>100% Legal & Secure</h3>
							<p class="pb20">Complete Security & RNG Certified, Anti-Fraud system & payment security</p>
						</div>
					</div> 
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="images/payment.png" class="img-responsive" alt="indian rummy online"></div>
							<h3>Multiple Payment Options</h3>
							<p class="pb20">All major credit/debit cards accepted, Net banking from 50+ banks & wallets</p>
						</div>
					</div> 
					<div class="col-md-3 col-sm-6 text-center mt20">
						<div class="col-md-12  welcome-bonus">
							<div><img src="images/winbig.png" class="img-responsive" alt="play rummy"></div>
							<h3>Think Big ! Win Big !</h3>
							<p class="pb20">Play and win big cash prices and lots other gifts on rummysahara.com</p>
						</div>
					</div> 
				</div>
				<hr>
			</div>
		</div></br>
		<div class="container-fluid pa0 mb30">
			<div class="container index-content-wrapper welcome-bonus">
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
					<div class="col-md-3 mt10 col-sm-3">
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
					<div class="col-md-6 mt10 col-sm-6">
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
					<div class="col-md-3 mt10 col-sm-3">
						<div class="col-md-12 bg-grey">
							<h4 class="pt20">Download for Mobile</h4><hr class="mb30">
							<a href="https://rummysahara.com/apk/rummysahara.apk" class="text-center"><img src="../images/android-app.png" class="img-responsive" alt="rummy on mobile"></a>
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
											<h5><i>Mr. Sanjay desai</i></h5>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="profile">
											<p><i>"Awesome, never thought I could win Monthly Million Tournament. It's like a dream come true. I congratulate and thank rummysahara that they provide every detail on their screen so nobody misses it. Website works good. Thank you!"</i></p>
											<h5><i>Mr. Tushar kataria</i></h5>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="messages">
											<p><i>"Awesome, never thought I could win Monthly Million Tournament. It's like a dream come true. I congratulate and thank rummysahara that they provide every detail on their screen so nobody misses it. Website works good. Thank you!"</i></p>
											<h5><i>Mr. pravin gupta</i></h5>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="settings">
											<p><i>"Awesome, never thought I could win Monthly Million Tournament. It's like a dream come true. I congratulate and thank rummysahara that they provide every detail on their screen so nobody misses it. Website works good. Thank you!"</i></p>
											<h5><i>Mr. avinash solanki</i></h5>
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
	<div class="container-fluid pa0 black-ft">
		<div class="container">
			<div class="row color-white">
			<hr>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<h4>Secure Gaming</h4>
					<div class="row">
						<div class="col-md-4 col-xs-4 pr0">
							<img src="images/eighteen-plus.png" class="img-responsive" alt="play cash rummy">
						</div>
						<div class="col-md-8 col-xs-8 pl0">
							<p class="fs13">Only players above 18 years in age are permitted to play our games.</p>
						</div>
					</div>
				</div>
				
				<div class="col-md-9 col-sm-6 col-sm-pull-3 col-md-pull-0 col-xs-12">
					<h4>Payment Options</h4>
					<img src="images/our-payment-partner.png" class="img-responsive mt15" alt="payment partners">
				</div>
			</div>
			<hr>
		</div>
	</div>
	<div class="container-fluid black-bg pa0">
		<div class="container footer-wrapper">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<ul>
						<li><a href="public/about-us.php">About us &nbsp |</a></li>
						<li><a href="public/legality.php">Legality &nbsp |</a></li>
						<li><a href="public/contact-us.php">Contact Us &nbsp |</a></li>
						<li><a href="public/blog.php">Blog</a></li>
					</ul>
				</div>
				<div class="col-md-5 col-sm-6 col-xs-12 col-md-offset-3">
					<ul>
						<li><a href="public/disclaimer.php">Disclaimer &nbsp |</a></li>
						<li><a href="public/privacy-policy.php">Privacy Policy &nbsp |</a></li>
						<li><a href="public/terms-and-conditions.php">Terms and Conditions &nbsp </a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<div class="mobileShow">
<!--<a href="https://rummysahara.com/apk/rummysahara.apk"><img src="../images/android-app.png" class="img-responsive" alt="download mobile app"></a>-->
<a href="apk/rummysahara.apk"><button class="btn"><i class="fa fa-download"></i> Download App</button></a>
</div>
	
	
	
	<div class="container-fluid pa0 black-ft">
		<div class="container footer">
			<div class="row mb10">
				<hr>
				<div class="col-md-7 col-sm-9 mt10">
					<!--<span class="color-white">Copyright <b>Pixaview Solutions Pvt Ltd 2017</b> - All rights reserved.</span>-->
				</div>
				<div class="col-md-3 col-sm-3 col-md-offset-2 mt10">
					<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid pa0 black-bg mt20">
		<div class="container">
			<div class="row">
				<div class="text-center color-white" style="padding:10px 0px">All Rights Reserved  &nbsp; <a href="https://rummysahara.com" target="_blank" class="color-white"><b>Rummysahara.com</b></a> Developed & Powered By &nbsp; <a href="https://mbhitech.com" target="_blank" class="color-white"><b>mbhitech.com</b></a></div>
			</div>
		</div>
	</div>
		<!--<div id="footer" class="mt20 mb20"></div>-->
	</footer>
</body>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	<script src="public/facebook-login.js"></script>

	<script>
		$(function(){
		  $("#header").load("public/header.php"); 
		 /* $("#footer").load("public/footer.php"); */
		  
		  $("#user_name").blur(function(){
		var username = $("#user_name").val();
		
			$.post("public/check_user_name.php",
			{
				user_name:username
			},
			function(data, status){
				if(data == 1)
				{
					$('#user_name_msg').text("Username already exist.");
					$("#user_name").val('');
				}
				 else 
				{
					$('#user_name_msg').text("");
				} 
			});
		});
		    	  $("#user_name").keyup(function()
			{
				this.value = this.value.toLowerCase();
			});
		$("#email").blur(function(){
		var email = $("#email").val();
		
			$.post("public/check_user_email.php",
			{
				user_email:email
			},
			function(data, status){
				if(data == 1)
				{
					$('#user_email_msg').text("Email ID already exist.");
					$("#email").val('');
				}
				 else 
				{
					$('#user_email_msg').text("");
				} 
			});
		});
		
		$("#user_mobile").blur(function(){
		var usermobile = $("#user_mobile").val();
		
			$.post("public/check_user_mobile.php",
			{
				user_mobile:usermobile
			},
			function(data, status){
				if(data == 1)
				{
					$('#user_mobile_msg').text("Mobile no already taken.");
					$("#user_mobile").val('');
				}
				 else 
				{
					$('#user_mobile_msg').text("");
				} 
			});
		});
	
		$("#user_mobile").keypress(function(e)
		{
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			$("#mobilemsg").text("Enter Digits Only...!");
			}
			else  $("#mobilemsg").text("");
		});
		
		var frm = $('#form_register');
		frm.submit(function (e) {
             var username=$('#user_name').val();
             
             var reg=0;
               if( /[^a-zA-Z0-9]/.test( username ) ) {
                   //alert('In Username only Letter and number allowed');
                    $('#failure_msg').html('<p>In Username only Letter and number allowed</p>');
                   $('#failure_msg').fadeIn().delay(25000).fadeOut();
                   $('#user_name').val('');
                   reg=1;
                   return false;
                }
           if(reg == 0){
        			e.preventDefault();
        
        			$.ajax({
        				type: frm.attr('method'),
        				url: frm.attr('action'),
        				data: frm.serialize(),
        				success: function (data) {
        					//alert('Submission was successful.');
        				//	alert(data);
        					if(data == true)
        					{
        						$('#form_register').trigger("reset");
        						$('#success_msg').fadeIn().delay(25000).fadeOut();
        					}
        					else 
        					{
        						$('#form_register').trigger("reset");
        					
        						$('#failure_msg').fadeIn().delay(25000).fadeOut();
        					}
        				},
        				error: function (data) {
        					$('#failure_msg').fadeIn().delay(25000).fadeOut();
        					//alert('An error occurred.');
        					//alert(data);
        				},
        			});
			
			
           }
		});
		
		var frm1 = $('#form_login');
		frm1.submit(function (e) {
		    

			e.preventDefault();
			$.ajax({
				type: frm1.attr('method'),
				url: frm1.attr('action'),
				data: frm1.serialize(),
				success: function (data) {
				//alert('Submission was successful.');
					//alert(data);
					if(data == true){
					    $('#form_login').trigger("reset");
					  window.location=('public/point-fun-games.php');
					    
					}
					else 
					{
						$('#form_login').trigger("reset");
						$('#login_failure_msg').fadeIn().delay(25000).fadeOut();
					}
					
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
			
			
			
		});
		
		<?php  
		 $message = isset($_GET['user_registered']) ? $_GET['user_registered'] : '';
		 if($message == true)
		 {
		 ?>
				$('#success_msg').fadeIn().delay(15000).fadeOut();
		<?php } ?>
		
		});
	</script>
        <script type="text/javascript">
        
        function onSignIn(googleUser) {
            
            var profile = googleUser.getBasicProfile();
            
            
            if(profile){
                $.ajax({
                    type: 'POST',
                    url: 'public/login_profile.php',
                    data: {id:profile.getId(), name:profile.getName(), email:profile.getEmail()}
                    }).done(function(data){
                    console.log(data);
                    window.location.href = 'public/social-profile.php';
                    }).fail(function() { 
                    
                    //   alert( "Posting failed." );
                });
            }
        
        
        }
        </script>
</html>