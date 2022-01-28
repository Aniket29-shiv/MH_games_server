<?php
include 'database.php';
$geturl="select baseurl from `base_url`  WHERE id=1";
$seturl=mysqli_query ($conn,$geturl);
$listurl=mysqli_fetch_object($seturl);
$baseurl=$listurl->baseurl;
?>
<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
	<div class="container-fluid pa0 black-ft">
		<div class="container">
		    	<hr>
			<div class="row color-white">
				<div class="col-md-3 col-sm-3 col-xs-6">
					<h4>Secure Gaming</h4>
					<div class="row">
						<div class="col-md-4 col-xs-4 pr0">
							<img src="<?php echo $baseurl;?>public/images/eighteen-plus.png" class="img-responsive" alt="play cash rummy">
						</div>
						<div class="col-md-8 col-xs-8 pl0">
							<p class="fs13">Only players above 18 years in age are permitted to play our games.</p>
						</div>
					</div>
				</div>
				
				<div class="col-md-9 col-sm-6 col-sm-pull-3 col-md-pull-0 col-xs-12">
					<h4>Payment Options</h4>
					<img src="<?php echo $baseurl;?>public/images/our-payment-partner.png" class="img-responsive mt15" alt="payment partners">
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
						<li><a href="<?php echo $baseurl;?>public/about-us.php">About us &nbsp |</a></li>
						<li><a href="<?php echo $baseurl;?>public/legality.php">Legality &nbsp |</a></li>
						<li><a href="<?php echo $baseurl;?>public/contact-us.php">Contact Us &nbsp |</a></li>
						<li><a href="<?php echo $baseurl;?>public/blog.php">Blog</a></li>
					</ul>
				</div>
				<div class="col-md-5 col-sm-6 col-xs-12 col-md-offset-3">
					<ul>
						<li><a href="<?php echo $baseurl;?>public/disclaimer.php">Disclaimer &nbsp |</a></li>
						<li><a href="<?php echo $baseurl;?>public/privacy-policy.php">Privacy Policy &nbsp |</a></li>
						<li><a href="<?php echo $baseurl;?>public/terms-and-conditions.php">Terms and Conditions &nbsp </a></li>
					</ul>
				</div>
			</div>
		</div>
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
				<div class="text-center color-white" style="padding:10px 0px">All Rights Reserved  &nbsp; <a href="http://rummysahara.com" target="_blank" class="color-white"><b>RummySahara</b></a> Developed & Powered By &nbsp; <a href="https://mbhitech.com" target="_blank" class="color-white"><b>mbhitech.com</b></a></div>
			</div>
		</div>
	</div>
</body>
</html>
