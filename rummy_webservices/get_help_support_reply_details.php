<?php
error_reporting(0);
include 'config.php';
    
    $supportId = $_GET['supportId'];

$seluser = "SELECT * FROM user_help_reply where `ticketid` = '".$supportId."' ORDER BY `id` ASC";
$result = $connect->query($seluser);
if($result->num_rows > 0)
{
	while($userdata = $result->fetch_assoc())
	{
	    
	    $imagePath = "";
	    $fileType = "";
	    $type = $userdata['type'];
	    $id = $userdata['id'];
	    
	    if($type == 1)
	    {
	        $sql = "SELECT * FROM user_help_reply_document where `user_help_reply_id` = '".$id."'";
            $resultsql = $connect->query($sql);
            if($resultsql->num_rows > 0)
            {
                $imagedata = $resultsql->fetch_assoc();
                $imagePath = $imagedata['image_path'];
                $fileType = $imagedata['file_type'];
            }
	    }
	    
    	$json_user[] = array('id' => $userdata['id'],'ticketid' => $userdata['ticketid'],'msg' => $userdata['msg'],'msgby' => $userdata['msgby'],'created_date' => $userdata['created_date'],'type' => $userdata['type'],'imagePath' => $imagePath,'fileType' => $fileType);
    	
	}
	
	header('Content-type: application/json');
    echo json_encode(array('status'=>"success",'help_support_details'=>$json_user,'message'=>"Record found"));
}
else
{
	header('Content-type: application/json');
echo json_encode(array('status' => "false",'message'=>"No record found"));
}


		
?>
