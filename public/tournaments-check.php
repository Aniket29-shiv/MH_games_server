<?php

session_start();
if( !isset( $_SESSION["logged_user"] ) ) {
  header("Location: sign-in.php");
  die();
}

$loggeduser =  $_SESSION['logged_user'];
include 'database.php';

$sqluser="SELECT user_id FROM users WHERE username='".$loggeduser."'"; 
$resultusr=$conn->query($sqluser);
$rowusr=$resultusr->fetch_assoc();
$userid=$rowusr['user_id'];

if($_POST['action'] == "list") {

	$query="SELECT * FROM tournament ORDER BY tournament_id DESC";
	
	$result = $conn->query($query);

	$i = 0;
	if($result->num_rows > 0) { 

		while( $row = $result->fetch_assoc() ) { 
			$ret[$i]["id"]				 = $row['tournament_id'];
			$ret[$i]["price"]			 = $row['price'];
			$ret[$i]["title"]			 = $row['title'];
			$ret[$i]["start_date"]		 = $row['start_date'];
			$ret[$i]["start_time"]		 = $row['start_time'];
			$ret[$i]["entry_fee"]		 = $row['entry_fee'];
			$ret[$i]["all_players"]		 = $row['no_of_player'];

			$ret[$i]["ended"]		 	= $row['status'] == "end" ? true : false;

			$sqchkusr = "SELECT count(*) as 'total' FROM join_tournaments WHERE player_id='".$userid."' AND tournament_id=".$ret[$i]["id"]; 
			$result11 = $conn->query($sqchkusr);
            $rowusrr  = $result11->fetch_assoc();

            $ret[$i]["joined"] = $rowusrr['total'] > 0 ? true : false;

            $sqlallprice = "SELECT count(*) as 'total' FROM join_tournaments WHERE tournament_id='".$row['tournament_id']."'";
            $result1 = $conn->query($sqlallprice);
            $row1 = $result1->fetch_assoc();

			$ret[$i]["players"] = $row1['total'];

			$ret[$i]["regtime"] = false;

			$regstart 	= strtotime ($row['reg_start_date'] . " " . $row['reg_start_time']);
			$regend 	= strtotime ($row['reg_end_date'] . " " . $row['reg_end_time']);
			$startTime	= strtotime ($row['start_date'] . " " . $row['start_time']);
			$timeNow	= time();

			if( $timeNow >= $regstart && $timeNow <= $regend ) {
				$ret[$i]["regtime"] = true;
			}

			$ret[$i]["started"] = false;
			if( $timeNow >= $startTime ) {
				$ret[$i]["started"] = true;
			}
			$i++;
        }

		echo json_encode($ret);
    }
} elseif($_POST['action'] == "join") {
    $cquery="SELECT id FROM join_tournaments WHERE tournament_id='".$_POST['tour_id']."' and player_id='".$userid."'";
    $cresult=mysqli_query($conn,$cquery);
    if(mysqli_num_rows($cresult) > 0){
        echo "success";
    }else{
            $sqltoal 	= "SELECT id  FROM join_tournaments WHERE tournament_id='".$_POST['tour_id']."'"; 
            $totalresult=mysqli_query($conn,$sqltoal);
            $totalpl=mysqli_num_rows($totalresult);
    
            $querycapacity=mysqli_query($conn,"SELECT * FROM tournament WHERE tournament_id='".$_POST['tour_id']."'");
            $listcapacity=mysqli_fetch_object($querycapacity);
            $no_of_player=$listcapacity->no_of_player;
            
        if($totalpl < $no_of_player){ 	
                
        	$sqlp 	= "SELECT reg_start_date, reg_start_time,reg_end_date, reg_end_time, entry_fee FROM tournament WHERE tournament_id='".$_POST['tour_id']."'"; 
            
            $res 	= $conn->query($sqlp);
        	$rowres	=$res->fetch_assoc();
        	if( !$rowres ) {
        		echo "failed";
        		$conn->close(); 
                exit; 
        	}
        
        	$regtime = false;
        	$regstart 	= strtotime ($rowres['reg_start_date'] . " " . $rowres['reg_start_time']);
        	$regend 	= strtotime ($rowres['reg_end_date'] . " " . $rowres['reg_end_time']);
        	$timeNow	= time();
        
        	if( $timeNow >= $regstart && $timeNow <= $regend ) {
        		$regtime = true;
        	}
        
        	if( $regtime == false ) {
        		echo "timeout";
        		$conn->close(); 
                exit; 
        	}
        
            $tid 	= $_POST['tour_id'];
            $fee 	= (float)$rowres['entry_fee'];
            $created_time = date('Y-m-d H:i:s');
                   
                         
            if($fee=='Free'){                                        
        		$query="INSERT INTO `join_tournaments`(`player_id`, `tournament_id`, `fees`, `created_time`) VALUES ('$userid','$tid','$fee','$created_time')";
            } else {
            	$sqlpaychip="SELECT real_chips FROM accounts WHERE userid='".$userid."'"; 
                            
            	$resultchip = $conn->query($sqlpaychip);
            	$rowchip 	= $resultchip->fetch_assoc();
            	$realchipval= $rowchip['real_chips'];
        	
        		if($realchipval < $fee){ 
        			echo "money";
        			$conn->close(); 
                    exit;            
        		}
        		else{
        			$queryup="UPDATE accounts SET real_chips= real_chips - ".$fee." WHERE userid='".$userid."'" ;  
        			$resultrel = $conn->query($queryup);
        			$query="INSERT INTO `join_tournaments`(`player_id`, `tournament_id`, `fees`, `created_time`) VALUES ('$userid','$tid','$fee','$created_time')"; 
                }
            }
        
                $result = $conn->query($query);
            	$tournament_id = $conn->insert_id;
            	if($result){
            		echo "success";
            	}else{
            		echo "failed";
            	}
        }else{
    		echo "failed";
    	}
  }
} elseif($_POST['action'] == "withdraw") {
	$sqlp 	= "SELECT reg_start_date, reg_start_time,reg_end_date, reg_end_time FROM tournament WHERE tournament_id='".$_POST['tour_id']."'"; 
    
    $res 	= $conn->query($sqlp);
	$rowres	=$res->fetch_assoc();
	if( !$rowres ) {
		echo "failed";
		$conn->close(); 
        exit; 
	}

	$regtime = false;
	$regstart 	= strtotime ($rowres['reg_start_date'] . " " . $rowres['reg_start_time']);
	$regend 	= strtotime ($rowres['reg_end_date'] . " " . $rowres['reg_end_time']);
	$timeNow	= time();

	if( $timeNow >= $regstart && $timeNow <= $regend ) {
		$regtime = true;
	}

	if( $regtime == false ) {
		echo "timeout";
		$conn->close(); 
        exit; 
	}

	$sqljoinid="SELECT id, fees FROM join_tournaments WHERE player_id ='".$userid."' AND tournament_id = ".$_POST['tour_id']  ; 

	$resultid=$conn->query($sqljoinid);

	$row=$resultid->fetch_assoc();
	if( $row ) {
		$joinid = $row['id'];
		$feee 	= $row['fees'];

		$sqlup = "UPDATE accounts SET real_chips = real_chips + ".$feee." WHERE userid='".$userid."'" ;	   
		$conn->query($sqlup);

		$sqldeljoin = "DELETE FROM join_tournaments where id='".$joinid."'";
		$conn->query($sqldeljoin);

		echo "success";
	} else {
		echo "failed";
	}	    
}

$conn->close();

?>