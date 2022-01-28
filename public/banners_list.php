<?php
session_start();
$message="";
if(!isset($_SESSION['logged_user'])){ 
     header("Location:sign-in.php");
}else{
    include 'database.php';
    $loggeduser =  $_SESSION['logged_user'];
   $sql1 = "SELECT * FROM users  where username = '".$loggeduser."'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
$userid=$row1['user_id']; 
    
    function getimages($conn,$userid,$mainurl){
        
        $query="select * from `banners` where status=1";
        $getimg=mysqli_query($conn,$query);
        if(mysqli_num_rows($getimg) > 0){
            
            while($listdata=mysqli_fetch_object($getimg)){
                
            echo '<div class="gallery">
            <a target="_blank" href="'.$mainurl.'public/registration.php?referral_id='.$userid.'">
            <img src="'.$listdata->bimage.'" alt="Cinque Terre" width="600" height="400">
            </a>
            <div class="desc" style="background: #d2c1c1;color: #0c0c0c;">'.strtoupper($listdata->title).'</div>
                <textarea id = "textdownload'.$listdata->id.'" style="display:none;">
                 <style>
                div.gallery {
                margin: 5px;
                border: 1px solid #ccc;
                float: left;
                
                }
                
                div.gallery:hover {
                border: 1px solid #777;
                }
                
                div.gallery img {
                width: 100%;
                height: 50%;
                }
                
                div.desc {
                padding: 15px;
                text-align: center;
                }
                
                </style>
                <div class="gallery">
                <a target="_blank" href="'.$mainurl.'public/registration.php?referral_id='.$userid.'">
                <img src="'.$listdata->bimage.'" alt="Cinque Terre" width="600" height="400">
                </a>
                <div class="desc" style="background: #d2c1c1;color: #0c0c0c;">'.strtoupper($listdata->title).'</div>
                </div>
                </textarea>
            <!-- <div style="text-align: center;background: #948c8c;padding: 5px;"><a class="btn btn-primary donloadfile" onclick="myfunction('.$listdata->id.')" data-id="'.$listdata->id.'" style="margin-right:2px;">Download</a><a class="copy_text btn btn-primary" href="'.$listdata->bimage.'" >Copy Link</a></div>-->
              <div style="text-align: center;background: #948c8c;padding: 5px;"><a class="btn btn-primary donloadfile" onclick="myfunction('.$listdata->id.')" data-id="'.$listdata->id.'" style="margin-right:2px;">Download Banner</a><a class="copy_text btn btn-primary" href="'.$mainurl.'public/registration.php?referral_id='.$userid.'" >Copy Ref Link</a></div>
            
            </div>';
           
                
            }
            
        }
    }
?>
</DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">	

</head>
<body>
  <style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
 
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: 50%;
}

div.desc {
  padding: 15px;
  text-align: center;
}

</style>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
								<h3 class="color-white text-center mt20"><b>Banners</b></h3>
							
									<div class="col-md-12" style="background:white;height:500px;overflow:auto; margin-left: 14px;">
 <?php getimages($conn,$userid,$mainurl);?>

									</div>
								
								
								
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
		function myfunction(id) {
   var dataid=$(this).attr('data-id');
  // alert(id);
    var text = document.getElementById("textdownload"+id).value;
    var filename = "banner.txt";
    
    download(filename, text);
}




 
 
 function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}

 
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		  
		  
		      
        		$('.copy_text').click(function (e) {
   e.preventDefault();
   var copyText = $(this).attr('href');

   document.addEventListener('copy', function(e) {
      e.clipboardData.setData('text/plain', copyText);
      e.preventDefault();
   }, true);

   document.execCommand('copy');  
   console.log('copied text : ', copyText);
   alert('Text Copied Successfully'); 
 });
 
 
// Start file download.
//$(".donloadfile").addEventListener("click", function(){
    
 
 
 
		});
	</script>
	  
</html>
<?php 

} 
?>