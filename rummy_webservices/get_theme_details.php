<?php
error_reporting(0);
include 'config.php';
    

$userId = $_GET['user_id'];

$selectedTheme = -1;

$selusertheme = "SELECT * FROM user_theme where `user_id` = '$userId'";
$themeresult = $connect->query($selusertheme);
if($themeresult->num_rows > 0)
{
    $userthemedata = $themeresult->fetch_assoc();
    $selectedTheme = $userthemedata['theme_id'];
}


$seluser = "SELECT * FROM themes";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
    	$json_user[] = array('id' => $userdata['id'],'theme_name' => $userdata['theme_name'],'theme_image' => $userdata['theme_image']);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'theme_details'=>$json_user,'selected_theme'=>$selectedTheme,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
    echo json_encode(array('status' => "false",'selected_theme'=>$selectedTheme,'message'=>"No record found"));
}


		
?>
