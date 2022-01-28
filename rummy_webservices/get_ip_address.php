<?php
error_reporting(0);
include 'config.php';
    

$seluser = "SELECT * FROM ip_conf";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
    while($userdata = $result->fetch_assoc())
    {
        $json_user[] = array('id' => $userdata['id'],'ip' => $userdata['ip'],'port' => $userdata['port'],'mlink' => $userdata['mlink'],'tip' => $userdata['tip'],'tport' => $userdata['tport'],'tlink' => $userdata['tlink']);
    }
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'ip_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
    echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
