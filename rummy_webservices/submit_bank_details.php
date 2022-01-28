<?php
error_reporting(0);
include 'config.php';

$user_id = $_GET['user_id'];
$bank_name = $_GET['bank_name'];
$account_no = $_GET['account_no'];
$ifsc_code = $_GET['ifsc_code']; 
$created_date = date('Y/m/d h:m:s');

		$query = "insert into bank_details(`user_id`, `bank_name`, `account_no`, `ifsc_code`, `ctearted_on`, `updated_on`) values ( '".$user_id."','".$bank_name."','".$account_no."','".$ifsc_code."','".$created_date."','".$created_date."')"; 
			$result =  $connect->query($query);
					 
			if($result)
			{
				    $myObj->status = "Bank Details Submited Successfully.";
			}
			else
			{
				$myObj->status = "Error While bank details submit";
			}
			
echo json_encode($myObj);

 $connect->close();
?>