<?php
error_reporting(0);
include 'config.php';
    

$username = $_GET['username'];
$userAvatar = "";

$seluseravatar = "SELECT * FROM user_avatar where `username` = '$username'";
$avatarresult = $connect->query($seluseravatar);
if($avatarresult->num_rows > 0)
{
    $useravatardata = $avatarresult->fetch_assoc();
    $userAvatar = $useravatardata['image'];
}

echo json_encode(array('status' => "success", 'user_avatar'=>$userAvatar,'message'=>"No record found"));

?>
