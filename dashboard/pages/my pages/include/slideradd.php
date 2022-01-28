<?php


$path = "../../../uploads/slider/";
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG");

if(isset($_GET['did'])){
    $did=$_GET['did'];
    mysqli_query ($conn,"update `webslider` set deleted=1 where id='$did'");
    echo '<script>alert("Deleted Successfully")</script>';
    echo '<script>window.location.href="addslider.php"</script>';
}

if(isset($_POST['btnSubmit'])){
    
    $title=mysqli_real_escape_string($conn,$_POST['title']);
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
         $theimage = '';//$_POST['profileimage'];
    }
     $makequery="select * from `webslider` where deleted != 1 order by rank desc limit 1";
	$query=mysqli_query ($conn,$makequery);
    if(mysqli_num_rows($query) > 0){
    	$listdata=mysqli_fetch_object($query);
	    $rank=$listdata->rank+1;
	}else{
	  $rank=1;  
	
	}
    
    $reg=0;
     if($title == ''){$reg=1;$message="Title Required";}
      if($pimage == ''){$reg=1; $message="Image Required";}
       $makequery="INSERT INTO `webslider`(`title`, `simage`,`rank`, `created_date`) VALUES ('$title', '$theimage','$rank', '$cdate')";
       
          if($reg == 0){
             
            	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="addslider.php?status=1"</script>';
          }else{
              echo '<script>window.location.href="addslider.php?status=1"</script>';
          }
      
							
}




function listslider($sql){
    
    $makequery="select * from `webslider` where deleted != 1";
	$query=mysqli_query ($sql,$makequery);
	$x=1;
	while($listdata=mysqli_fetch_object($query)){
            
            echo '<tr>
            <td>'.$x.'</td>
            <td>'.$listdata->title.'</td>
            <td><img src="../../../uploads/slider/'.$listdata->simage.'"  style="width: 100px;" ></td>
            <td><input type="number" class="serialno" data-id="'.$listdata->id.'" value="'.$listdata->rank.'"></td>';
            echo '<td><a onclick="return confirm(';
            echo "'Are you sure you want to delete'";
            echo ')" href="?did='.$listdata->id.'"><i class="fa fa-times"></i></a></td>';    
            echo '</tr> ';
	    
	    
	}
	
}

?>
