<?php
error_reporting(0);
include 'config.php';

$usernm = $_GET['username'];
$fname = $_GET['fname'];
$mname = $_GET['mname']; 
$lname = $_GET['lname'];
$mobile = $_GET['mobile'];
$gender = $_GET['gender'];
$pan_no = $_GET['pan_no'];
$dob_day = $_GET['dob_day'];
$dob_month = $_GET['dob_month'];
$dob_year = $_GET['dob_year'];
$updated_date = date('Y/m/d h:m:s');
		
if($dob_day!='' && $dob_month!='' && $dob_year!='')
	{
	    $dob_month = $dob_month + 1;
	    $dob =$dob_year.'-'.$dob_month.'-'.$dob_day; 
	}
	else {$dob =''; }
	
	//$sql = "update users set first_name= '".$fname."',middle_name= '".$mname."',last_name= '".$lname."',email= '".$user_email."',gender= '".$gender."',mobile_no= '".$user_mobile."',pan_card_no= '".$pan_no."',`date_of_birth`= '".$dob."',`updated_date` = '".$updated_date."' where username = '".$usernm."'";
	
	$sql = "update users set first_name= '".$fname."',middle_name= '".$mname."',last_name= '".$lname."',gender= '".$gender."',pan_card_no= '".$pan_no."',`date_of_birth`= '".$dob."',`updated_date` = '".$updated_date."',`mobile_no` = '".$mobile."' where username = '".$usernm."'";
	
	$result = $connect->query($sql);
	if ($result === true) {
	if(mysqli_affected_rows($connect) > 0)
		{
			if($pan_no !='')
			{
				$sql1 = "SELECT * from user_kyc_details where username = '".$usernm."'";
				$result1 = $connect->query($sql1);
				if ($result1->num_rows > 0) {
					while($row1 = $result1->fetch_assoc())
						{
							$db_pan_no = $row1['pan_no'];
						}
						if($db_pan_no ==''){
						$sql_update = "update user_kyc_details set pan_no= '".$pan_no."',`updated_date` = '".$updated_date."' where username = '".$usernm."'";
						$connect->query($sql_update);}
					}
					
			}
		}
		$myObj->status = "Profile Updated Successfully.";
	}
	else {
	   $myObj->status = "Profile Updation Failed.";
	}

echo json_encode($myObj);

$connect->close();
?>