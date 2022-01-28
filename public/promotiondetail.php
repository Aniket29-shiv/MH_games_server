<?php 

include 'database.php';

$slug='';
if(isset($_GET['slug'])){
    $slug=$_GET['slug'];
    
    
}

$makequery = "SELECT * FROM `promotions`  where deleted != 1 and slug='$slug'";
$query = mysqli_query($conn,$makequery);
$listdata=mysqli_fetch_object($query);
    function promotions($conn){
        
        $makequery = "SELECT * FROM `promotions`  where deleted != 1 and status='L' order by id asc";
	 $query = mysqli_query($conn,$makequery);
	   if($listdata=mysqli_num_rows($query) > 0){
	     $x=1;
	     //echo 'hi';
        	 while($listdata=mysqli_fetch_object($query)){
        	     
        	     
        	     if($listdata->simage != ''){
        	     
        	       echo '<div class="col-md-4 col-sm-4 mt15">
        	       
						<div class="col-md-12 over-hid bg-grey pa0 text-center pb20">
							<img src="../uploads/promotions/'.$listdata->simage.'" class="img-responsive">
							<h3 class="mt15 text-uppercase">'.substr($listdata->title, 0,20).'</h3>
							<p style="font-size: 17px; font-style: italic;"><i>'.strtolower(substr($listdata->shortdescription, 0,100)).'...</i></p>
							<a href="'.MAINLINK.'/public/promotiondetail.php?slug='.$listdata->slug.'" class="pull-right"><i>Read More ></i></a>
						</div>
						
					</div>';
        	     }
                $x++;
            }
        }else{
            echo '<div class="item active"><img src="uploads/slider/dummy.png" alt="play rummy games" style="width:1200px;">	</div>';
        }
	 }
	 

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo MAINLINK;?>/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo MAINLINK;?>/css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<title>Play Online Rummy Promotions Online Rummy Bonus & Offers</title>
<meta name="description" content="Endless rummy bonuses; daily, weekly &amp; monthly. Special rummy offers &amp; promotions to help you win big. Redeem special bonus to earn extra bucks in your account." />
<meta name="abstract" content="Endless rummy bonuses; daily, weekly &amp; monthly. Special rummy offers &amp; promotions to help you win big. Redeem special bonus to earn extra bucks in your account." />
<meta name="keywords" content="Rummy Promotions, Rummy Bonus, Rummy Offers, play rummy online, rummy, rummy games, rummy cash" />
<meta name="robots" content="follow, index" />

</head>
<body>
	<header>
		<div id="header"><?php include('header.php');?></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt20" style="background-color: white;">
			<div class="container promo-cont-wrapper">
			    
				<div class="row">
					
					<div class="col-md-12 col-xs-12 col-sm-4" style="text-align:center;">
						<h2 class="text-center">Latest Promotions >> <?php echo ucfirst(strtolower($listdata->title));?></h2>
					</div>
					
				
				</div>
				
				<div class="row mt10">
				    <?php //promotions($sql);?>
				    <hr style="border: 1px solid;">
				    <div class="col-md-12" style="margin-top: 35px;text-align:center">
				        <img src="<?php echo MAINLINK;?>uploads/promotions/<?php echo $listdata->simage;?>" width="100%">
				     </div>
				      <div class="col-md-12" style="">
				          <p> <?php echo $listdata->description;?></p>
				     </div>
			
			
			</div>
		</div>
	</main>
	<footer>
		<div id="footer"><?php include('footer.php');?></div>
	</footer>
</body>
	<script src="<?php echo MAINLINK;?>/js/jquery.js"></script>
	<script src="<?php echo MAINLINK;?>/js/bootstrap.min.js"></script>
	<script>
		$(function(){
		 // $("#header").load("https://eliterummy.com/public/header.php"); 
		 // $("#footer").load("https://eliterummy.com/public/footer.php"); 
		});
	</script>
</html>