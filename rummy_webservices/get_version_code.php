<?php
error_reporting(0);
include 'config.php';

$sql = "SELECT * FROM app_version";
$result = $connect->query($sql);
if($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
	    $json_user[] = array('id' => $row['id'],'version_code' => $row['version_code'],'version_name' => $row['version_name']);
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'version_code_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
