<?php

include("config.php");
include("lock.php");
date_default_timezone_set('Asia/Calcutta'); 



	if(isset($_REQUEST['id'])){ 
	    $tournament_id=$_REQUEST['id'];
	    
	$insert="INSERT INTO tournament_del
        SELECT * FROM tournament
        WHERE  tournament_id = '".$tournament_id."' ";
      
    $result_ins = $conn->query($insert);
    
    $insert1="INSERT INTO price_distribution_del
        SELECT * FROM price_distribution
        WHERE  tournament_id = '".$tournament_id."' ";
    $result_ins1 = $conn->query($insert1);
		if($result_ins && $result_ins1)
		{
		    			
              $sql = "DELETE FROM `tournament`  where tournament_id = '".$tournament_id."'";
	             
        	$result = $conn->query($sql);

	 $sql1 = "DELETE FROM `price_distribution`  where tournament_id = '".$tournament_id."'";
	
        	$result1 = $conn->query($sql1);
				
		if($result && $result1){
				 header("Location:tournament-details.php?status=1");  
			}else{
				 header("Location:tournament-details.php?status=2");  
			}		
		}else{
		    
		     header("Location:tournament-details.php?status=2"); 
		}	
	}

$conn->close();

?>