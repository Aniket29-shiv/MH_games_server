<?php
error_reporting(0);
include 'config.php';

$sql = "SELECT * FROM base_url";
$result = $connect->query($sql);
if($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
	    $json_user[] = array('id' => $row['id'],'baseurl' => $row['baseurl']);
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'base_url_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
