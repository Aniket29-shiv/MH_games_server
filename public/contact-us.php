</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<title>Contact us - Play Online Rummy get rummy experience with friends</title>
<meta name="description" content="Play rummy games online for free & real cash and win gib prices, we offer rummy game bonuses and real cash to play rummy." />
<meta name="abstract" content="Play rummy games online for free & real cash and win gib prices, we offer rummy game bonuses and real cash to play rummy." />
<meta name="keywords" content="Rummy games, play rummy, Rummy Bonus, Rummy Offers, play rummy online, rummy, rummy games, rummy cash" />
<meta name="robots" content="follow, index" />

</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
	
		<div class="container-fluid pa0 mt20">
			<div class="container contact-cont-wrapper">
				<div class="row">
					<div class="col-md-4 col-xs-2 col-sm-4 mt20 pr0"><hr></div>
					<div class="col-md-4 col-xs-8 col-sm-4">
						<h2 class="text-center color-white">Contact Us</h2>
					</div>
					<div class="col-md-4 col-xs-2 col-sm-4 mt20 pl0"><hr></div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-8 col-sm-offset-2 col-md-offset-3">
						<h3 class="color-white text-center  text-uppercase">For any support and information please contact us</h3>
						<div class="black-bg color-white mt30">
							<h4>Please feel the form below and we will get in touch with you shortly</h4>
							<form id="form_web_contact" action="web_contact.php" method="post">
								<label>Name :-</label>
								<input id="name" name="name" type="text" placeholder="Enter your name" autocomplete="off" required/>
								<label>Email :-</label>
								<input id="email" name="email" type="email" placeholder="Enter your email" autocomplete="off" required/>
								<label>Mobile No</label>
								<input type="tel" name="user_mobile" id="user_mobile" placeholder="Enter your mobile no" autocomplete="off" maxlength="10" minlength="10" required >
								<span id="mobilemsg" style="color: red;margin-left: 21px;"></span>
								<label>Subject :-</label>
								<input id="subject" name="subject" type="text" placeholder="Subject" autocomplete="off" required/>
								<label>Message :-</label>
								<textarea id="message" name="message" placeholder="Your Message" autocomplete="off" class="mt10" required></textarea>
								<button class="btn btn-default mt20 color-white">Send</button>
								<span id="update_success" style="display: none;margin-left:4%; color: white;text-align:center">Your Request has been submitted successfully,we will get back to you shortly.</span>
								<span id="update_failure" style="display: none;margin-left: 7%; color: red;text-align:center">Something went wrong,please try again.</span>
							</form>
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
		  
		  $("#user_mobile").keypress(function(e)
			{
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$("#mobilemsg").text("Enter Digits Only...!");
				}
				else  $("#mobilemsg").text("");
			});
		
		var frm1 = $('#form_web_contact');
		frm1.submit(function (e) {
			e.preventDefault();
			$.ajax({
				type: frm1.attr('method'),
				url: frm1.attr('action'),
				data: frm1.serialize(),
				success: function (data) {
				if(data == true)
					{ 
					  $('#form_web_contact').trigger("reset");
					  $('#update_success').fadeIn().delay(15000).fadeOut();
					 
					 }
					else 
					{
						$('#form_web_contact').trigger("reset");
						$('#update_failure').fadeIn().delay(15000).fadeOut();
					}
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		
		<?php  
		 $message = isset($_GET['message']) ? $_GET['message'] : '';
		 if($message == true)
		 {
		 ?>
				$('#success_msg').fadeIn().delay(15000).fadeOut();
		<?php } ?>

		});
	</script>
</html>