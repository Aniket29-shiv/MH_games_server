
<?php

$message='';
$path = "../../../images/logo.png";
$valid_formats = array("png");


if(isset($_POST['btnSubmit'])){
    
   
    $pimage = $_FILES['pimage']['name'];
   
       
        
    if($pimage != '') {
        
        list($txt, $ext) = explode(".", $pimage);
        
        
            if(in_array($ext,$valid_formats)){
                
                global $upload_image;
                
                $tmp = $_FILES['pimage']['tmp_name'];	
                move_uploaded_file($tmp, $path);
                 echo '<script>window.location.href="addlogo.php?status=1"</script>';
            }else{
                
               echo '<script>window.location.href="addlogo.php?status=2"</script>';
            }
     		
    } else{
          echo '<script>window.location.href="addlogo.php?status=2"</script>';
    }
      
							
}




?>
