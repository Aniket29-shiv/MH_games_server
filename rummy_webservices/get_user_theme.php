<?php
error_reporting(0);
include 'config.php';
    

$userId = $_GET['user_id'];

$selectedTheme = -1;
$userAvatar = "";

$selusertheme = "SELECT * FROM user_theme where `user_id` = '$userId'";
$themeresult = $connect->query($selusertheme);
if($themeresult->num_rows > 0)
{
    $userthemedata = $themeresult->fetch_assoc();
    $selectedTheme = $userthemedata['theme_id'];
}

$seluseravatar = "SELECT * FROM user_avatar where `user_id` = '$userId'";
$avatarresult = $connect->query($seluseravatar);
if($avatarresult->num_rows > 0)
{
    $useravatardata = $avatarresult->fetch_assoc();
    $userAvatar = $useravatardata['image'];
}

echo json_encode(array('status' => "success",'selected_theme'=>$selectedTheme,'user_avatar'=>$userAvatar,'message'=>"No record found"));

?>
