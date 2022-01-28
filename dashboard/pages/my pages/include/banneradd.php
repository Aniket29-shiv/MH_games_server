<?php

$message='';
$eid='';
$title='';
$width='';
$height='';
$simage='';
$path = "../../../uploads/refbanner/";
$geturl="select baseurl from `base_url`  WHERE id=1";
$seturl=mysqli_query ($conn,$geturl);
$listurl=mysqli_fetch_object($seturl);

$mainurl= $listurl->baseurl;
$imgpath = $mainurl."uploads/refbanner/";

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG");

if(isset($_GET['did'])){
    $did=$_GET['did'];
    mysqli_query ($conn,"update `promotions` set deleted=1 where id='$did'");
    echo '<script>alert("Deleted Successfully")</script>';
    echo '<script>window.location.href="addpromotion.php"</script>';
}


if(isset($_GET['eid'])){
    
    $eid=$_GET['eid'];
    $makequery="SELECT `title`, `bimage` FROM `banners`  where id = '$eid'";
	$query=mysqli_query ($conn,$makequery);
    $listdata=mysqli_fetch_object($query);
    $title=$listdata->title;
    //$width=$listdata->iwidth;
    //$height=$listdata->iheight;
    $simage=$listdata->bimage;

}

/*function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}*/


if(isset($_POST['btnSubmit'])){
     $eid=$_POST['eid'];
    $title=mysqli_real_escape_string($conn,$_POST['title']);
   // $width=$_POST['width'];
   // $height=$_POST['height'];
    $pimage = $_FILES['pimage']['name'];
    $cdate=date('Y-m-d H:i:s');
       
        
    if($pimage != '') {
        list($txt, $ext) = explode(".", $pimage);
        if(in_array($ext,$valid_formats)){
            global $upload_image;
    		$upload_image = time()."_BANNER.".$ext;
    		$tmp = $_FILES['pimage']['tmp_name'];	
    		move_uploaded_file($tmp, $path.$upload_image);
        }
       $theimage = $imgpath.''.$upload_image;			
    } else {
         $theimage = $_POST['uimage'];
    }
    
 
   
    
    $reg=0;
     if($title == ''){$reg=1;$message="Title Required";}
      if($theimage == ''){$reg=1; $message="Image Required";}
      // if($width == ''){$reg=1; $message="Width Required";}
      // if($height == ''){$reg=1; $message="Height Required";}
       
          if($reg == 0){
          
             if($eid == ''){
                $makequery="INSERT INTO `banners`(`title`, `bimage`,  `cdate`) VALUES ('$title', '$theimage', '$cdate')";
                	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="addbanner.php?status=1"</script>';
             }else{
                 $makequery="UPDATE `banners` SET `title`='$title', `bimage`='$theimage' where id='$eid'";
                	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="addbanner.php?status=2"</script>';
             
             }
          }else{
               
               return false;
          }
      
							
}



?>
