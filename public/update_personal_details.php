<?php
/* $servername = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "rummystore";
$conn = new mysqli($servername, $user, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 */
 include 'database.php';
 //print_r($_POST);
 $dob=null;
/*  if($_POST['fname'] !='First Name')
{ $fname = $_POST['fname'];}
 if($_POST['mname'] !='Middle Name')
{ $mname = $_POST['mname'];}
 if($_POST['lname'] !='Last Name')
{ $lname = $_POST['lname'];} */
$usernm = $_POST['usernm'];
$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$usernm."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
		{
			$first_name = $row['first_name'];
			$middle_name = $row['middle_name'];
			$last_name = $row['last_name'];
			$gender_db = $row['gender'];
			$date_of_birth = $row['date_of_birth'];
			$pan_card_no_db = $row['pan_card_no'];
		}
	}
	if($first_name =='')
	{ $fname = $_POST['fname']; }
		else { $fname = $first_name; }
	if($middle_name =='')
	{ $mname = $_POST['mname']; }
		else { $mname = $middle_name; }
	if($last_name =='')
	{ $lname = $_POST['lname']; }
		else { $lname = $last_name; }
		
	if($gender_db =='')
	{ $gender = $_POST['gender']; }
		else { $gender = $gender_db; }
	
	if($pan_card_no_db =='')
	{ 
		if($_POST['pan_no'] !='Pan Card No')
		{ $pan_no = $_POST['pan_no'];} 
	}
	else { $pan_no = $pan_card_no_db; }
	
	if($date_of_birth =='')
	{
		$dob_day = $_POST['dob_day'];
		$dob_month = $_POST['dob_month'];
		$dob_year = $_POST['dob_year'];
		
		if($dob_day!='' && $dob_month!='' && $dob_year!='')
		{$dob =$dob_year.'-'.$dob_month.'-'.$dob_day; }
		else {$dob =''; }
		
		
	}
	else 
	{
		 $dob = $date_of_birth;
		/* if((strlen($date_of_birth)) >0)
		{
		 $dob_db = explode('-',$date_of_birth);
		}
		$dob_day = $dob_db[0];
		$dob_month =$dob_db[1];
		$dob_year = $dob_db[2];
		if($dob_day!='' && $dob_month!='' && $dob_year!='')
		{$dob =$dob_year.'-'.$dob_month.'-'.$dob_day; }
		else {$dob =''; } */
	}
	//echo $date_of_birth.'----------'.$dob;
		
$user_email = $_POST['user_email'];
$user_mobile = $_POST['user_mobile'];

          


$updated_date = date('Y/m/d h:m:s');

$sql = "update users set first_name= '".$fname."',middle_name= '".$mname."',last_name= '".$lname."',email= '".$user_email."',gender= '".$gender."',mobile_no= '".$user_mobile."',pan_card_no= '".$pan_no."',`date_of_birth`= '".$dob."',`updated_date` = '".$updated_date."' where username = '".$usernm."'";
//echo $sql;
//echo 1;
$result = $conn->query($sql);

if ($result === true) {
if(mysqli_affected_rows($conn) > 0)
	{echo 1;}
	else {echo 3;}
	if($pan_no !='')
	{
		$sql1 = "SELECT * from user_kyc_details where username = '".$usernm."'";
		$result1 = $conn->query($sql1);
		if ($result1->num_rows > 0) {
			while($row1 = $result1->fetch_assoc())
				{
					$db_pan_no = $row1['pan_no'];
				}
				if($db_pan_no ==''){
				$sql_update = "update user_kyc_details set pan_no= '".$pan_no."',`updated_date` = '".$updated_date."' where username = '".$usernm."'";
				$conn->query($sql_update);}
			}
			
	}
	
}
else {
echo 2;
} 
$conn->close();

?>