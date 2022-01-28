<?php
include("config.php");
include("lock.php");
date_default_timezone_set('Asia/Calcutta'); 


	/*
	* BONUS ENTRY
	*/
	if(isset($_POST['bonus_entry'])){   
			$pageData = $_POST;
			$creared_on =  date('Y-m-d H:i:s');   
			
			  $query = "insert into bonus_entry (reg_bonus,ref_bonus,real_chips,silver_club,gold_club,platinum_club,created_on)values({$pageData['reg_bonus']},{$pageData['ref_bonus']},{$pageData['real_chips']},{$pageData['silver_club']},{$pageData['gold_club']}, {$pageData['platinum_club']},'{$creared_on}')";  
			
			  $result = $conn->query($query);
			 
			if($result){
				 header("Location:bonus-entry.php?status=1");  
			}else{
				 header("Location:bonus-entry.php?status=2");  
			}
			
	}
	/* 
	* CONVERTING INTO
	*/
	if(isset($_POST['convert_into'])){   
			$pageData = $_POST;
			$creared_on =  date('Y-m-d H:i:s');  
			
			$query = "insert into converting_into (reg_bonus,ref_bonus,silver_club,gold_club,platinum_club,created_on)values({$pageData['reg_bonus']},{$pageData['ref_bonus']},{$pageData['silver_club']},{$pageData['gold_club']}, {$pageData['platinum_club']},'{$creared_on}')";   
			
			$result = $conn->query($query);
			if($result){
				 header("Location:bonus-entry.php?status=1");  
			}else{
				 header("Location:bonus-entry.php?status=2");  
			}
			
	}
	
	/* 
	* REAL CHIPS
	*/
	if(isset($_POST['real_chips'])){   
			$pageData 	= $_POST;
			$creared_on =  date('Y-m-d H:i:s');  
			
			  $query = "insert into real_chips (reg_bonus,ref_bonus,silver_club,gold_club,platinum_club,created_on)values({$pageData['reg_bonus']},{$pageData['ref_bonus']},{$pageData['silver_club']},{$pageData['gold_club']}, {$pageData['platinum_club']},'{$creared_on}')"; 
			 
			$result = $conn->query($query);
			
			if($result){
				 header("Location:bonus-entry.php?status=1");  
			}else{
				 header("Location:bonus-entry.php?status=2");  
			}
			
	}
	
	
		/* 
	* Reward set
	*/
	if(isset($_POST['reward_set'])){   
			$pageData 	= $_POST;
		   if($_POST['col_0_500'] > 0){$col_0_500=$_POST['col_0_500'];}else{$col_0_500=0;}
		   if($_POST['col_501_1000'] > 0){$col_501_1000=$_POST['col_501_1000'];}else{$col_501_1000=0;}
		   if($_POST['col_1001_5000'] > 0){$col_1001_5000=$_POST['col_1001_5000'];}else{$col_1001_5000=0;}
		   if($_POST['col_5001_10000'] > 0){$col_5001_10000=$_POST['col_5001_10000'];}else{$col_5001_10000=0;}
		    if($_POST['col_10000_up'] > 0){$col_10000_up=$_POST['col_10000_up'];}else{$col_10000_up=0;}
		   if($_POST['redeem_per'] > 0){$redeem_per=$_POST['redeem_per'];}else{$redeem_per=0;}
		   
			
			  $query = "update reward_point_set set `col_0_500`='$col_0_500', `col_501_1000`='$col_501_1000', `col_1001_5000`='$col_1001_5000', `col_5001_10000`='$col_5001_10000', `col_10000_up`='$col_10000_up', `redeem_per`='$redeem_per' where id=1";
			  //	$Update_sql=mysqli_query($conn,"update reward_point_set set col_0_500='{$_POST['col_0_500']}',col_0_500='{$_POST['col_0_500']}',col_501_1000='{$_POST['col_501_1000']}',col_1001_5000='{$_POST['col_1001_5000']}',col_5001_10000='{$_POST['col_5001_10000']}',col_10000_up='{$_POST[col_10000_up]}',redeem_per='{$_POST[redeem_per]}' where id=1");
			 
			$result = $conn->query($query);
			
			if($result){
				 header("Location:bonus-entry.php?status=1");  
			}else{
				 header("Location:bonus-entry.php?status=2");  
			}
			
	}
	
	
$conn->close();

?>