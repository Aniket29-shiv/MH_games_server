<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 if(isset($_SESSION['logged_user'])) 
{$loggeduser =  $_SESSION['logged_user'];}
else {$loggeduser = 'Guest';}
$referral_id ='';
if(isset($_GET['referral_id'])){
if (isset($_COOKIE['referral_id'])) {
    // get data from cookie for local use
    $referral_id = $_COOKIE['referral_id'];
}
else {
    $refcode=$_GET["referral_id"];
    // set cookie, local $uname already set
   $_COOKIE["referral_id"]=$refcode;
    setcookie( 'referral_id', $refcode, time() +2592000, '/', 'rummysahara.com' );
}

$referral_id =$_COOKIE["referral_id"];
}elseif(isset($_COOKIE['referral_id'])){
    $referral_id =$_COOKIE["referral_id"];
}else{
   $referral_id =''; 
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
			<?php if(!isset($_SESSION['logged_user'])) { ?>
			<div class="container register-wrapper">
				<div class="row">
						<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
							<div class="black-bg mt30">
								<h4 class="color-white text-center">Sign Up & Get Rs. 1500 + 200 * FREE</h4>
							</div>
							<div class="bg-grey">
								<form id="form_register2" action="register.php" method="post">
									<h5 class="text-center pt20">All the below fields are mandatory </h5> 
									<span id="success_msg" style="display: none; color: green;    text-align: center;">Your account has been created successfully.</span>
									<span id="failure_msg" style="display: none; color: red;text-align: center;">Your registration was not done,try again.</span>
									<input  style="width:84%;" type="text" placeholder="User Name" name="user_name" id="user_name" pattern=".{5,15}" required title="5 to 15 characters" autocomplete="off" required>
									<span id="user_name_msg" style="color: red;"></span>
									<input  style="width:84%;" type="email" name="email" id="email" placeholder="E-mail Address" autocomplete="off" required>
									<span id="user_email_msg" style="color: red;"></span>
									<input  style="width:84%;" type="tel" name="user_mobile" id="user_mobile" placeholder="Mobile No" autocomplete="off" maxlength="10" minlength="10" required >
									<span id="user_mobile_msg" style="color: red;"></span>
									<span id="mobilemsg" style="color: red;"></span>
									<select class="form-control" name="gender" id="gender" required>
										<option value="">Select Gender</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
									<input  style="width:84%;" pattern=".{5,15}" required title="5 to 15 characters"  type="password" name="user_pwd" id="user_pwd" placeholder="Password" autocomplete="off" minlength="6" required>
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
									</select>
										
								<input type="number" style="color:black;width:84%;" id="user_ref" name="user_ref"  value="<?php echo $referral_id;?>" maxlength="10" placeholder="Referral Code" autocomplete="off" />
									<p><input type="checkbox" autocomplete="off" style=" margin:20px 3px 0px 0px" required/>
									<input type="hidden" name="user_ref" value="<?php echo $referral_id;?>">
										By signing up you accept you are 18+ and agree to our <a href="terms-and-conditions.php" style="margin:0px">T & C</a></p><br>
									<button class="btn btn-default color-white mt20" id="btn_sumbit">Submit</button><br>
									<a href="sign-in.php" class="text-center">I have already an account.</a>
								</form>
							</div>
						</div>
					
				</div>
				<hr class="mt35">
			</div>
			<?php } else { ?>
		<div class="container register-wrapper">
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
		  
		  $("#user_mobile").keypress(function(e)
			{
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$("#mobilemsg").text("Enter Digits Only...!");
				}
				else  $("#mobilemsg").text("");
			});
			
		$("#user_name").blur(function(){
		var username = $("#user_name").val();
		
			$.post("check_user_name.php",
			{
				user_name:username
			},
			function(data, status){
				//alert("Data: " + data + "\nStatus: " + status);
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
		    
		$("#email").blur(function(){
		var email = $("#email").val();
		
			$.post("check_user_email.php",
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
		
			$.post("check_user_mobile.php",
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
		
		
		 $("#form_register2").submit(function(e)
		{
			check_username();
			check_useremail();
			check_usermobile();
			register(e);
		});
		
		function check_username()
		{
		var username = $("#user_name").val();
			$.post("check_user_name.php",
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
		}
		
		function check_useremail()
		{
		var email = $("#email").val();
		
			$.post("check_user_email.php",
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
		}
		
		function check_usermobile()
		{
		var usermobile = $("#user_mobile").val();
		
			$.post("check_user_mobile.php",
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
		}
		 var frm = $('#form_register2');
		function register(e)
		{
		e.preventDefault();
		$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function (data) {
				
				/*	if(data == true)*/
					if(data == 1)
					{
						$('#form_register2').trigger("reset");
						$('#success_msg').fadeIn().delay(25000).fadeOut();
					}
					else 
					{
						$('#form_register2').trigger("reset");
						$('#failure_msg').fadeIn().delay(25000).fadeOut();
					}
				},
				error: function (data) {
					$('#failure_msg').fadeIn().delay(25000).fadeOut();
					
				},
			});
		}
		/* frm.submit(function (e) {

			e.preventDefault();

			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function (data) {
					
					if(data == true)
					{
						$('#form_register2').trigger("reset");
						$('#success_msg').fadeIn().delay(15000).fadeOut();
					}
					else 
					{
						$('#form_register2').trigger("reset");
						$('#failure_msg').fadeIn().delay(15000).fadeOut();
					}
				},
				error: function (data) {
					$('#failure_msg').fadeIn().delay(15000).fadeOut();
					
				},
			});
		}); */
		});
	</script>
</html>