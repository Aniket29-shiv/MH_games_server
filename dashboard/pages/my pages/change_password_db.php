<?php
	include("config.php");
	include("lock.php");
	date_default_timezone_set('Asia/Calcutta');
	if(isset($_POST['btnSubmit']))
	{   
		$pageData = $_POST;
		$old_password = md5($pageData['old_password']);
		$new_password = md5($pageData['new_password']);
		$updated_on =  date('Y-m-d H:i:s');	
 
		$check_password="select password from administrator where id='".$pageData['id']."'";
		$result_password = $conn->query($check_password);
		while($row = $result_password->fetch_assoc())
		{
			$password=$row["password"];
		}
		
		if($password==$old_password)
		{
			$update = "update administrator set password='".$new_password."'";
			$update_status=$conn->query($update);
			if($update_status)
			{
				header("Location:change_password.php?status=1");
			}else{
				header("Location:change_password.php?status=2");
			}
		}else{
			header("Location:change_password.php?status=3");
		}
	/*$query = "insert into table_affiliate(full_name,mobile,email,user_name,password,creared_on,status,address)values('{$pageData['full_name']}','{$pageData['mobile']}','{$pageData['email']}','{$pageData['user_name']}','{$password}','{$creared_on}','inactive','{$pageData['address']}')";
		 
		 $result = $conn->query($query);
		 if($result)
		 {		 
			 header("Location:table-affiliate.php?status=1");		 
		 }
		 else
		 {
			 header("Location:table-affiliate.php?status=2");  
		 }*/
		 

	}
	
$conn->close();
	 
?>