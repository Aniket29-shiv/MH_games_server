<?php
include 'database.php';
$uploaddir = '../uploads/';
//print_r($_POST);
$username = $_POST['usernm'];
$userid=$_SESSION['user_id'];
   $sql1 = "SELECT * from user_kyc_details where username = '".$username."'";
 

$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
	while($row = $result1->fetch_assoc())
		{
		    $userid = $row['userid'];
		    $email = $row['email'];
			$db_id_proof = $row['id_proof'];
			$db_pan_no = $row['pan_no'];
			$db_id_proof_url = $row['id_proof_url'];
			$db_pan_card_url = $row['pan_card_url'];
		}
	}
	if($db_id_proof =='')
	{$kyc_id_proof = $_POST['id_proof']; }
		else { $kyc_id_proof = $db_id_proof; }
	if($db_pan_no =='')
	{ $kyc_pan = $_POST['kyc_pan'];}
		else { $kyc_pan = $db_pan_no; }
	if($db_id_proof_url =='' && $_POST['id_proof_file'] != '' )
	{ $id_proof_url = $uploaddir .$_POST['id_proof_file'];  }
		else { $id_proof_url = $db_id_proof_url; }
	if($db_pan_card_url =='' && $_POST['pan_file'] != '')
	{ $pan_url = $uploaddir .$_POST['pan_file']; }
		else { $pan_url = $db_pan_card_url; }
	


    
    
				    

    $kyc_id_proof = $_POST['id_proof'];
     $kyc_pan = $_POST['kyc_pan'];


$updated_date = date('Y/m/d h:m:s');

 $sql = "update user_kyc_details set `id_proof`= '".$kyc_id_proof."',`pan_no`= '".$kyc_pan."',`id_proof_url`= '".$id_proof_url."',`pan_card_url`= '".$pan_url."',`updated_date` = '".$updated_date."' where username = '".$username."'";



    $result = $conn->query($sql);
	$sql_update = "update users set pan_card_no= '".$kyc_pan."',`updated_date` = '".$updated_date."' where username = '".$username."'";
$result1=	$conn->query($sql_update);

if ($result) 
{
 echo "1";
 
}else{
     echo "2";
}
    

 


$conn->close();


?>