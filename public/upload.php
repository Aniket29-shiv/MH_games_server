<?php
$data = array();

if(isset($_GET['files']))
{  
$error = false;
$files = array();

$uploaddir = '../uploads/';
$rand = rand(0000,9999);

//print_r($_FILES);
foreach($_FILES as $file)
{
    if(move_uploaded_file($file['tmp_name'], $uploaddir . $rand .basename($file['name'])))
    {
        $files[] = $uploaddir .$file['name'];
		echo $rand .basename($file['name']); 
    }
    else
    {
        $error = true;
		echo 'file upload error'; 
    }
}
//$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
//$data = $file['name'];
}


//echo json_encode($data);
//echo $data;


?>