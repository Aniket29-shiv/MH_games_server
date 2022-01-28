<?php

$message='';
$eid='';
$title='';
$description='';
$simage='';
 $shortdescription='';
$path = "../../../uploads/promotions/";
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG");

if(isset($_GET['did'])){
    $did=$_GET['did'];
    mysqli_query ($conn,"update `promotions` set deleted=1 where id='$did'");
    echo '<script>alert("Deleted Successfully")</script>';
    echo '<script>window.location.href="addpromotion.php"</script>';
}


if(isset($_GET['eid'])){
    
    $eid=$_GET['eid'];
    $makequery="select * from `promotions` where id = '$eid'";
	$query=mysqli_query ($conn,$makequery);
    $listdata=mysqli_fetch_object($query);
    $title=$listdata->title;
    $description=$listdata->description;
    $shortdescription=$listdata->shortdescription;
    $simage=$listdata->simage;

}

function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}


if(isset($_POST['btnSubmit'])){
     $eid=$_POST['eid'];
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $tslug=seoUrl($title);
    $description=$_POST['description'];
    $shortdescription=$_POST['shortdescription'];
    $pimage = $_FILES['pimage']['name'];
    $cdate=date('Y-m-d H:i:s');
       
        
    if($pimage != '') {
        list($txt, $ext) = explode(".", $pimage);
        if(in_array($ext,$valid_formats)){
            global $upload_image;
    		$upload_image = time()."_".$txt.".".$ext;
    		$tmp = $_FILES['pimage']['tmp_name'];	
    		move_uploaded_file($tmp, $path.$upload_image);
        }
       $theimage = $upload_image;			
    } else {
         $theimage = $_POST['uimage'];
    }
    
 
   
    
    $reg=0;
     if($title == ''){$reg=1;$message="Title Required";}
      if($theimage == ''){$reg=1; $message="Image Required";}
       if($description == ''){$reg=1; $message="Descrition Required";}
        $makequery="select * from `promotions` where `slug`='$tslug' and deleted != 1 and id != '$eid'";
        $query=mysqli_query ($conn,$makequery);
        
        if(mysqli_num_rows($query) > 0){
            $reg=1; $message="Title Alredy Exists";
        }
       
       
          if($reg == 0){
          
             if($eid == ''){
                $makequery="INSERT INTO `promotions`(`title`, `slug`, `simage`,`description`,`shortdescription`, `created_date`,`status`) VALUES ('$title','$tslug', '$theimage', '$description', '$shortdescription', '$cdate','S')";
                	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="addpromotion.php?status=1"</script>';
             }else{
                 $makequery="UPDATE `promotions` SET `title`='$title',`slug`='$tslug', `simage`='$theimage',`description`='$description',`shortdescription`= '$shortdescription', `updated_date`= '$cdate' where id='$eid'";
                	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="addpromotion.php?status=2"</script>';
             
             }
          }else{
               
               return false;
          }
      
							
}




/*function listslider($sql){
    
    $makequery="select * from `promotions` where deleted != 1";
	$query=mysqli_query ($sql,$makequery);
	$x=1;
	while($listdata=mysqli_fetch_object($query)){
            
            echo '<tr>
            <td>'.$x.'</td>
            <td>'.$listdata->title.'</td>
            <td><img src="../../../uploads/mslider/'.$listdata->simage.'"  style="width: 100px;" ></td>
            <td><input type="number" class="serialno" data-id="'.$listdata->id.'" value="'.$listdata->rank.'"></td>';
            echo '<td><a onclick="return confirm(';
            echo "'Are you sure you want to delete'";
            echo ')" href="?did='.$listdata->id.'"><i class="fa fa-times"></i></a></td>';    
            echo '</tr> ';
	    
	    
	}
	
}*/

?>
