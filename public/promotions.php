<?php 

include 'database.php';

    function promotions($sql){
        
        $makequery = "SELECT * FROM `promotions`  where deleted != 1 and status='L' order by id asc";
	 $query = mysqli_query($sql,$makequery);
	   if($listdata=mysqli_num_rows($query) > 0){
	     $x=1;
	     //echo 'hi';
        	 while($listdata=mysqli_fetch_object($query)){
        	     
        	     
        	     if($listdata->simage != ''){
        	     
        	       echo '<div class="col-md-4 col-sm-4 mt15">
        	       
						<div class="col-md-12 over-hid bg-grey pa0 text-center pb20" style="height: 450px;">
							<img src="../uploads/promotions/'.$listdata->simage.'" class="img-responsive">
							<h3 class="mt15 text-uppercase">'.substr($listdata->title, 0,20).'</h3>
							<p style="font-size: 17px; font-style: italic;"><i>'.strtolower(substr($listdata->shortdescription, 0,100)).'...</i></p>
							<a href="'.MAINLINK.'promotion-detail/'.$listdata->slug.'" class="pull-right"><i>Read More ></i></a>
						</div>
						
					</div>';
        	     }
                $x++;
            }
        }
        
        /*else{
            echo '<div class="item active"><img src="uploads/slider/dummy.png" alt="play rummy games" style="width:1200px;">	</div>';
        }*/
	 }
	 

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
	<title>Play Online Rummy Promotions Online Rummy Bonus & Offers</title>
<meta name="description" content="Endless rummy bonuses; daily, weekly &amp; monthly. Special rummy offers &amp; promotions to help you win big. Redeem special bonus to earn extra bucks in your account." />
<meta name="abstract" content="Endless rummy bonuses; daily, weekly &amp; monthly. Special rummy offers &amp; promotions to help you win big. Redeem special bonus to earn extra bucks in your account." />
<meta name="keywords" content="Rummy Promotions, Rummy Bonus, Rummy Offers, play rummy online, rummy, rummy games, rummy cash" />
<meta name="robots" content="follow, index" />

</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt20">
			<div class="container promo-cont-wrapper">
				<div class="row">
					<div class="col-md-4 col-xs-2 col-sm-4 hidden-xs mt20 pr0"><hr></div>
					<div class="col-md-4 col-xs-12 col-sm-4">
						<h2 class="text-center color-white">Latest Promotions</h2>
					</div>
					<div class="col-md-4 col-xs-2 col-sm-4 hidden-xs mt20 pl0"><hr></div>
				</div>
				<div class="row mt10">
					 <?php promotions($conn);?>
				</div>
			
			
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