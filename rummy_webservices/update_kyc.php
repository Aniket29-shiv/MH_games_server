<?php
error_reporting(0);
include 'config.php'; 
$uploaddir = '../uploads/';

	$id_proof = $_GET['id_proof'];
	$pan_no = $_GET['pan_no'];
	$mobile = $_GET['mobile'];
	$id_proof_url = $uploaddir .$_GET['id_proof_url'];
	$pan_url = $uploaddir .$_GET['pan_url'];
	$username = $_GET['username'];
	$updated_date = date('Y/m/d h:m:s');

	$sql = "update user_kyc_details set id_proof= '".$id_proof."',pan_no= '".$pan_no."',`updated_date` = '".$updated_date."',`mobile_no` = '".$mobile."' where username = '".$username."'";
	$result = $connect->query($sql);

	if ($result === true) {
		if(mysqli_affected_rows($connect) > 0)
		{
			$sql_update = "update users set pan_card_no= '".$pan_no."',`updated_date` = '".$updated_date."' where username = '".$username."'";
			$connect->query($sql_update);
		}
		$myObj->status = "KYC Documents Updated Successfully.";
	}
	else {
	 $myObj->status = "KYC Document Update Failed.";
	}
	
	echo json_encode($myObj);

$connect->close();
?>