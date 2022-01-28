<?php
include("config.php");
include("lock.php");
date_default_timezone_set('Asia/Calcutta'); 

if(isset($_POST['btnSubmit'])){   
		$pageData = $_POST;
		 
		$creared_on =  date('Y-m-d H:i:s');  
		$gtype=$pageData['game_type'];
		if($gtype == 'Point Rummy'){
		$pointvalue=$pageData['point_value'];
		}else{
		$pointvalue=0;
		}
		$query = "insert into player_table (table_name,game_type,point_value,min_entry,status,player_capacity,game,pool,table_no,creared_on,joker_type,table_status)values('{$pageData['table_name']}','{$pageData['game_type']}','$pointvalue',{$pageData['min_entry']},'process',{$pageData['player_capacity']},'{$pageData['game']}','{$pageData['pool']}',{$pageData['table_no']},'{$creared_on}','Joker','{$pageData['table_status']}')";  
		//exit();
		
		$result = $conn->query($query);
		if($result){
			 header("Location:table-entry.php?status=1");  
		}else{
			 header("Location:table-entry.php?status=2");  
		}
		
}
$conn->close();
?>