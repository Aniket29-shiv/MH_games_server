<?php 
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require ("database.php");
include 'referral_commission_functions.php';
//$sql= mysqli_connect( "localhost", "eliterum_rummy", "Admin@123", "eliterum_rummy" );

/**************************************************************************Rummy Lobby ***********************************************************************************************/

//===================Rummy Lobby ---->Point Rummy=================	
if(isset($_POST['players'])){
        
        $players = $_POST['players'];
        $min = $_POST['min'];
        $loggeduser=$_POST['logid'];
        $max=$_POST['max'];
        $hide=$_POST['hide'];
        
        $makequery= "SELECT * FROM `player_table` WHERE game = 'Cash Game' and `game_type` = 'Point Rummy' and `table_status` = 'L'";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($min != ''){ 	$makequery .= " and `min_entry` >= '$min'";}
        if($max != ''){ 	$makequery .= " and `min_entry` <= '$max'";}
        
        	$makequery .=" group by min_entry,player_capacity order by min_entry ASC ";
       /* $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
        
        "$makequery: ".$makequery.PHP_EOL.
        "-------------------------".PHP_EOL;
        //Save string to log, use FILE_APPEND to append.
        file_put_contents('log_'.date("j.n.Y").'.log', $log, FILE_APPEND);*/

        $query = mysqli_query($conn,$makequery);
        while($row = mysqli_fetch_object($query)){
            
             $tabl=$row->table_id;
             $player_capacity=$row->player_capacity;
              $min_entry=$row->min_entry; 
              $game_type=$row->game_type;
             $game=$row->game;
             $point_value=$row->point_value;
             $playercapacity=$row->player_capacity;
              
		
			
			$tblcount="select * from user_tabel_join where `game_type` = 'Point Rummy' and player_capacity=".$player_capacity." AND min_entry=".$min_entry." ";
		
			
			
			$result_inn = mysqli_query($conn,$tblcount);						    
			$a= mysqli_num_rows($result_inn);
			
			
			 
                     
             
			
            $reg=0;
            		 if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){
            		 	    if($a == 0)
            		 	    {
            		 	        $reg=1;
            		 	        
            		 	    }
            		 	    
            		 	}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}
            		 		    
            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}}
            		 		
            		 		
            		 		           /*if($reg == 1){ */
		
		                                            echo '<tr>
                                                    <td>'.$row->point_value.' </td>
                                                    <td>'.$row->min_entry.'</td>
                                                    <td>'.$row->player_capacity.'</td>
                                                    <td id="pl_cap">'.$a.'</td>
                                                    <td>';
                                                    
                                                    if( $row->player_capacity == 2 ) {
                                                        
                                                       echo '<a id="two_pl_game" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$point_value.'\',\''.$game_type.'\',\''.$game.'\',\''.$min_entry.'\')" ;return false;"   target="">
                                                       <button  class="btn btn-primary">Join</button></a>';
                                                       
                                                    } else if ( $row->player_capacity == 6){
                                                        
                                                      echo '<a id="six_pl_game" target="" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$point_value.'\',\''.$game_type.'\',\''.$game.'\',\''.$min_entry.'\')" ;return false;">
                                                      <button   class="btn btn-primary">Join</button></a>';
                                                      
                                                    }
                                                    
                                                    echo '</tr>  ';
            		 		           /* }*/ 
	 
        
        }
}

//===================Rummy Lobby ---->Papplu Rummy=================

if(isset($_POST['pappluplayers'])){

        $players = $_POST['pappluplayers'];
        $min = $_POST['min'];
        $loggeduser=$_POST['logid'];
        $max=$_POST['max'];
        $hide=$_POST['hide'];

        $makequery= "SELECT * FROM `player_table` WHERE game = 'Cash Game' and `game_type` = 'papplu Rummy' and `table_status` = 'L'  ";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($min != ''){ 	$makequery .= " and `min_entry` >= '$min'";}
        if($max != ''){ 	$makequery .= " and `min_entry` <= '$max'";}

        $makequery .= " group by min_entry,player_capacity order by min_entry ASC ";

        $query = mysqli_query($conn,$makequery);
        while($row = mysqli_fetch_object($query)){

             $tabl=$row->table_id;
             
             	$playercapacity=$row->player_capacity;
    			$min_entry=$row->min_entry;
    			$game_type=$row->game_type;
    			$game=$row->game;
                $player_capacity=$row->player_capacity;
             
			$tblcount="select * from  user_tabel_join where `game_type` = 'Papplu Rummy' and chip_type='real' and player_capacity=".$player_capacity." AND min_entry=".$min_entry." ";
			$result_inn = mysqli_query($conn,$tblcount);
			$a= mysqli_num_rows($result_inn);
			
			
			
		
			
			
			
            $reg=0;
            		
            	/*	if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}

            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}} */


            		 		         




		                                            echo '<tr>
		                                                <td style="display:none" id="tbl_id">'.$row->table_id.'</td>
		                                                
                                                    <td> '.$row->game_type.'</td>
                                                    
                                                    <td>'.$row->min_entry.'</td>
                                                    <td>'.$row->player_capacity.'</td>
                                                    <td id="pl_cap">'.$a.'</td>
                                                    <td>';
                                                    
                                                    
                                                        
                                                        
                                                       echo '<a id="two_pl_game" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$min_entry.'\',\''.$game_type.'\',\''.$game.'\')"  target="">
                                            <button class="btn btn-primary">Join</button></a>';
                                                      
                                                    
                                                    
                                                    echo ' </td></tr>  ';
            		 		           


        }
}


//===================Free Rummy Lobby ---->Papplu Rummy=================

if(isset($_POST['freepappluplayers'])){
    

        $players = $_POST['freepappluplayers'];
        $min = $_POST['min'];
        $loggeduser=$_POST['logid'];
        $max=$_POST['max'];
        $hide=$_POST['hide'];
        
        
        
        

        $min = $_POST['min'];
        $loggeduser=$_POST['logid'];
        $max=$_POST['max'];
        $hide=$_POST['hide'];

        $makequery= "SELECT * FROM `player_table` WHERE game = 'Free Game' and `game_type` = 'papplu Rummy' and `table_status` = 'L'  ";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($min != ''){ 	$makequery .= " and `min_entry` >= '$min'";}
        if($max != ''){ 	$makequery .= " and `min_entry` <= '$max'";}

        $makequery .= " group by min_entry,player_capacity order by min_entry ASC ";

        $query = mysqli_query($conn,$makequery);
        while($row = mysqli_fetch_object($query)){

             $tabl=$row->table_id;
             
             	$playercapacity=$row->player_capacity;
    			$min_entry=$row->min_entry;
    			$game_type=$row->game_type;
    			$game=$row->game;
                $player_capacity=$row->player_capacity;
             
			$tblcount="select * from  user_tabel_join where `game_type` = 'Papplu Rummy' and chip_type='free' and player_capacity=".$player_capacity." AND min_entry=".$min_entry." ";
			$result_inn = mysqli_query($conn,$tblcount);
			$a= mysqli_num_rows($result_inn);
			
			
			
		
			
			
			
            $reg=0;
            		
            	/*	if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}

            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}} */


            		 		         




		                                            echo '<tr>
		                                                <td style="display:none" id="tbl_id">'.$row->table_id.'</td>
		                                                
                                                    <td> '.$row->game_type.'</td>
                                                    
                                                    <td>'.$row->min_entry.'</td>
                                                    <td>'.$row->player_capacity.'</td>
                                                    <td id="pl_cap">'.$a.'</td>
                                                    <td>';
                                                    
                                                    
                                                        
                                                        
                                                       echo '<a id="two_pl_game" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$min_entry.'\',\''.$game_type.'\',\''.$game.'\')"  target="">
                                            <button class="btn btn-primary">Join</button></a>';
                                                      
                                                    
                                                    
                                                    echo ' </td></tr>  ';
            		 		           


        }

       /*  $makequery= "SELECT * FROM `player_table` WHERE game = 'Free Game' and `game_type` = 'papplu Rummy' and `table_status` = 'L'  ";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($min != ''){ 	$makequery .= " and `min_entry` >= '$min'";}
        if($max != ''){ 	$makequery .= " and `min_entry` <= '$max'";}


        $query = mysqli_query($conn,$makequery);
        while($row = mysqli_fetch_object($query)){

             $tabl=$row->table_id;
			$tblcount="select * from user_tabel_join where joined_table='$tabl' ";
			$result_inn = mysqli_query($conn,$tblcount);
			$a= mysqli_num_rows($result_inn);
			$playercapacity=$row->player_capacity;
            $reg=0;
            		 if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}

            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}}


            		 		           if($reg == 1){




		                                            echo '<tr>
		                                                <td style="display:none" id="tbl_id">'.$row->table_id.'</td>
		                                                <td>'.$row->table_name.'</td>
                                                    <td> '.$row->game_type.'</td>

                                                    <td>'.$row->min_entry.'</td>
                                                    <td>'.$row->status.'</td>
                                                    <td id="pl_cap">'.$a.'/'.$row->player_capacity.'</td>
                                                    <td>';

                                                    if( $row->player_capacity == 2 && $a == 2 ) {


                                                       echo '<a id="two_pl_game" onclick="check('.$row->table_id.',\''.$loggeduser.'\')"  target="">
                                                       <button  disabled class="btn btn-primary">Join</button></a>';

                                                    }else if ( $row->player_capacity == 2){

                                                       echo '<a id="two_pl_game" onclick="check('.$row->table_id.',\''.$loggeduser.'\')" ;return false;"  target="">
                                                      <button   class="btn btn-primary">Join</button></a>';

                                                    }else if ( $row->player_capacity == 6 && $a == 6){

                                                      echo '<a id="six_pl_game" target="" onclick="open_six_player_popup('.$row->table_id.',\''.$loggeduser.'\')">
                                                      <button  disabled class="btn btn-primary">Join</button></a>';

                                                    }else if ( $row->player_capacity == 6){

                                                      echo '<a id="six_pl_game" target="" onclick="open_six_player_popup('.$row->table_id.',\''.$loggeduser.'\')">
                                                      <button   class="btn btn-primary">Join</button></a>';

                                                    }

                                                    echo '</tr>  ';
            		 		           }


        } */
}


//===================GEt Papplu VAlue=================
if(isset($_POST['getpappluvalue'])){

      $playertable = $_POST['getpappluvalue'];

      $pointarry='';
      $get="select DISTINCT(min_entry) from `player_table` where `game`='Cash Game' and `player_capacity`='$playertable' and `table_status`='L' and `game_type`='papplu Rummy' order by min_entry asc";
	  $query=mysqli_query($conn,$get);

	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->min_entry;

           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }

	  }
	   echo $pointarry;
}

//===================GEt papplu VAlue=================
if(isset($_POST['getpappluvaluefree'])){

      $playertable = $_POST['getpappluvaluefree'];

      $pointarry='';
      $get="select DISTINCT(min_entry) from `player_table` where `game`='Free Game' and `player_capacity`='$playertable' and `table_status`='L' and `game_type`='papplu Rummy' order by min_entry asc";
	  $query=mysqli_query($conn,$get);

	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->min_entry;

           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }

	  }
	   echo $pointarry;
}

//===================Rummy Lobby ---->Pool Rummy=================	
if(isset($_POST['poolplayers'])){
        echo 'poolplayers';
        $players = $_POST['poolplayers'];
        $game = $_POST['game'];
        $loggeduser=$_POST['logid'];
        $bet=$_POST['bet'];
        $hide=$_POST['hide'];
        
     
        $makequery= "SELECT * FROM `player_table` WHERE game = 'Cash Game' and `game_type` = 'Pool Rummy' and `table_status` = 'L'  ";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($game != ''){ 	$makequery .= " and `pool` >= '$game'";}
        
        if($bet != ''){ 
          
            if($bet == 'low'){   $makequery .= " and `min_entry` <= 100";}
            if($bet == 'medium'){   $makequery .= " and `min_entry` >= 101 and `min_entry` <= 1000";}
            if($bet == 'high'){   $makequery .= " and `min_entry` >= 1001";}
            
            
        }
        
        
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($game != ''){ 	$makequery .= " and `pool` = '$game'";}
        
        if($bet != ''){ 
          
            if($bet == 'low'){   $makequery .= " and `min_entry` <= 100";}
            if($bet == 'medium'){   $makequery .= " and `min_entry` >= 101 and `min_entry` <= 1000";}
            if($bet == 'high'){   $makequery .= " and `min_entry` >= 1001";}
            
            
        }
        $makequery .=" group by min_entry,player_capacity,pool order by min_entry ASC";
        
     

        $query = mysqli_query($conn,$makequery);
        
        while($row = mysqli_fetch_object($query)){
            
             if($row->pool =='101 Pools'){$pool='101';}else if($row->pool=='201 Pools'){$pool='201';}
             
             
            
                $pool=$row->pool;
            
                $tabl=$row->table_id;
                
                
    			$tblcount="select * from user_tabel_join where joined_table='$tabl' ";
    			$result_inn = mysqli_query($conn,$tblcount);						    
    			$a= mysqli_num_rows($result_inn);
    			
    			$playercapacity=$row->player_capacity;
    			$min_entry=$row->min_entry;
    			$game_type=$row->game_type;
    			$game=$row->game;
    			
    			
    			
               
		
                                            
    			
    			
    			
                $reg=0;
                
            		if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}
            		 		    
            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}}
            		 		
            		 		
            		 		           
		
                                            echo '<tr>										
                                           
                                            <td>'.$row->pool.'</td>
                                            <td>'.$row->min_entry.'</td>
                                            <td>'.$row->player_capacity.'</td>
                                            <td>'.$a.'</td>
                                            <td>';
                                             echo '<a id="two_pl_game" onclick="check_table(\''.$loggeduser.'\',\''.$playercapacity.'\',\''.$game_type.'\',\''.$game.'\',\''.$min_entry.'\',\''.$pool.'\')"  target="">
                                            <button class="btn btn-primary">Join</button></a>';
                                            echo '</td></tr>';
            		 		          
	 
        
        }
}




//===================Rummy Lobby ---->Deal Rummy=================	

if(isset($_POST['dealplayers'])){
        
        $players = $_POST['dealplayers'];
        $min = $_POST['min'];
        $loggeduser=$_POST['logid'];
        $max=$_POST['max'];
        $hide=$_POST['hide'];
        
        $makequery= "SELECT * FROM `player_table` WHERE game = 'Cash Game' and `game_type` = 'Deal Rummy' and `table_status` = 'L'";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($min != ''){ 	$makequery .= " and `min_entry` >= '$min'";}
        if($max != ''){ 	$makequery .= " and `min_entry` <= '$max'";}
        
        $makequery .=" group by min_entry,player_capacity order by min_entry ASC ";
        $query = mysqli_query($conn,$makequery);
        while($row = mysqli_fetch_object($query)){
            
             $tabl=$row->table_id;
             
             $player_capacity=$row->player_capacity;
			 $min_entry=$row->min_entry;
			 
			 $game_type=$row->game_type;
			 $game=$row->game;
			 $point_value=$row->point_value;
										 
			$tblcount="select * from  user_tabel_join where `game_type` = 'Deal Rummy' and chip_type='real' and player_capacity=".$player_capacity." AND min_entry=".$min_entry." ";
			$result_inn = mysqli_query($conn,$tblcount);						    
			$a= mysqli_num_rows($result_inn);
			$playercapacity=$row->player_capacity;
            $reg=0;
            		if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}
            		 		    
            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}}
            		 		
            		 		
            		 		           
            		 		               
            		 		               
            		 		              
		
		                                            echo '<tr>
		                                                <td style="display:none" id="tbl_id">'.$row->table_id.'</td>
		                                                
                                                    <td> '.$row->game_type.'</td>
                                                    
                                                    <td>'.$row->min_entry.'</td>
                                                    <td>'.$row->player_capacity.'</td>
                                                    <td id="pl_cap">'.$a.'</td>
                                                    <td>';
                                                    
                                                    
                                                        
                                                        
                                                       echo '<a id="two_pl_game" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$min_entry.'\',\''.$game_type.'\',\''.$game.'\')"  target="">
                                            <button class="btn btn-primary">Join</button></a>';
                                                      
                                                    
                                                    
                                                    echo ' </td></tr>  ';
            		 		           
	 
        
        }
}



/**************************************************************************Free Rummy Lobby *******************************************************************************/
//===================Free Rummy Lobby ---->Point Rummy=================	
if(isset($_POST['funpointplayers'])){
        
        $players = $_POST['funpointplayers'];
        $min = $_POST['min'];
        $loggeduser=$_POST['logid'];
        $max=$_POST['max'];
        $hide=$_POST['hide'];
        
        $makequery= "SELECT * FROM `player_table` WHERE game = 'Free Game' and `game_type` = 'Point Rummy' and `table_status` = 'L'  ";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($min != ''){ 	$makequery .= " and `min_entry` >= '$min'";}
        if($max != ''){ 	$makequery .= " and `min_entry` <= '$max'";}
         $makequery .=" group by min_entry,player_capacity order by min_entry ASC ";
       

        $query = mysqli_query($conn,$makequery);
        while($row = mysqli_fetch_object($query)){
            
             $tabl=$row->table_id;
             
             	$player_capacity=$row->player_capacity;
             $min_entry=$row->min_entry;
             
             $game_type=$row->game_type;
             $game=$row->game;
             $point_value=$row->point_value;
            
             
             
             
			$tblcount="select * from user_tabel_join where `game_type` = 'Point Rummy' and player_capacity=".$player_capacity." AND min_entry=".$min_entry." ";
			
			$result_inn = mysqli_query($conn,$tblcount);						    
			$a= mysqli_num_rows($result_inn);
			$playercapacity=$row->player_capacity;
            $reg=0;
            		if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}
            		 		    
            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}}
            		 		
            		 		
            		 		           
		
		                                            echo '<tr>
                                                    <td>'.$row->point_value.' </td>
                                                    <td>'.$row->min_entry.'</td>
                                                    <td>'.$row->player_capacity.'</td>
                                                    <td id="pl_cap">'.$a.'</td>
                                                    <td>';
                                                    
                                                   if ( $row->player_capacity == 2){
                                                        
                                                       echo '<a id="two_pl_game" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$point_value.'\',\''.$game_type.'\',\''.$game.'\',\''.$min_entry.'\')" ;return false;"  target="">
                                                      <button   class="btn btn-primary">Join</button></a>';
                                                      
                                                    } else if ( $row->player_capacity == 6){
                                                        
                                                      echo '<a id="six_pl_game" target="" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$point_value.'\',\''.$game_type.'\',\''.$game.'\',\''.$min_entry.'\')" ;return false;">
                                                      <button   class="btn btn-primary">Join</button></a>';
                                                      
                                                    }
                                                    
                                                    echo '</tr>  ';
            		 		           
	 
        
        }
}

//===================Free Rummy Lobby ---->Pool Rummy=================	
if(isset($_POST['funpoolplayers'])){
        
        $players = $_POST['funpoolplayers'];
        $game = $_POST['game'];
        $loggeduser=$_POST['logid'];
        $bet=$_POST['bet'];
        $hide=$_POST['hide'];
        
     
        $makequery= "SELECT * FROM `player_table` WHERE game = 'Free Game' and `game_type` = 'Pool Rummy' and `table_status` = 'L'  ";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($game != ''){ 	$makequery .= " and `pool` >= '$game'";}
        
        if($bet != ''){ 
          
            if($bet == 'low'){   $makequery .= " and `min_entry` <= 100";}
            if($bet == 'medium'){   $makequery .= " and `min_entry` >= 101 and `min_entry` <= 1000";}
            if($bet == 'high'){   $makequery .= " and `min_entry` >= 1001";}
            
            
        }
        $makequery .="group by min_entry,player_capacity,pool order by min_entry ASC";
        
     

        $query = mysqli_query($conn,$makequery);
        
        while($row = mysqli_fetch_object($query)){
            
             if($row->pool =='101 Pools'){$pool='101';}else if($row->pool=='201 Pools'){$pool='201';}
            
                 $tabl=$row->table_id;
                $pool=$row->pool;
                $min_entry=$row->min_entry;
                $game_type=$row->game_type;
                $game=$row->game;
                $player_capacity=$row->player_capacity;
                
    			/* $tblcount="select * from user_tabel_join where joined_table='$tabl' "; */ 
    			
    			$sql1="select * from  user_tabel_join where `game_type` = 'Pool Rummy' and chip_type='free' and player_capacity='".$player_capacity."' AND min_entry='".$min_entry."'  ";
    			
    		
    			
    			$result_inn = mysqli_query($conn,$sql1);						    
    			$a= mysqli_num_rows($result_inn);
    			
    			
    			$playercapacity=$row->player_capacity;
                $reg=0;
                
            		 if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}
            		 		    
            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}}
            		 		
            		 		          
		
                                             echo '<tr>										
                                            
                                            <td>'.$row->pool.'</td>
                                            <td>'.$row->min_entry.'</td>
                                            <td>'.$row->player_capacity.'</td>
                                            <td>'.$a.'</td>
                                            <td>';
                                            if( $row->player_capacity == 2) {
                                                
                                            echo '<a id="six_pl_game" target="" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$game_type.'\',\''.$game.'\',\''.$min_entry.'\',\''.$pool.'\')" ;return false;">
                                                      <button   class="btn btn-primary">Join</button></a>';
                                            
                                            } 
                                            if( $row->player_capacity == 6) {
                                                
                                            echo '<a id="six_pl_game" target="" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$game_type.'\',\''.$game.'\',\''.$min_entry.'\',\''.$pool.'\')" ;return false;">
                                                      <button   class="btn btn-primary">Join</button></a>';
                                            
                                            } 
                                            echo '</td></tr>';
            		 		          
	 
        
        }
}


//===================Free Rummy Lobby ---->Deal Rummy=================	

if(isset($_POST['freedealplayers'])){
        //print_r($_POST);
        $players = $_POST['freedealplayers'];
        $min = $_POST['min'];
        $loggeduser=$_POST['logid'];
        $max=$_POST['max'];
        $hide=$_POST['hide'];
        
        $makequery= "SELECT * FROM `player_table` WHERE game = 'Free Game' and `game_type` = 'Deal Rummy' and `table_status` = 'L'  ";
        if($players != ''){	$makequery .= " and `player_capacity` = '$players'";}
        if($min != ''){ 	$makequery .= " and `min_entry` >= '$min'";}
        if($max != ''){ 	$makequery .= " and `min_entry` <= '$max'";}
        
        $makequery .="group by min_entry,player_capacity order by min_entry ASC";
        //echo $makequery;
        $query = mysqli_query($conn,$makequery);
        while($row = mysqli_fetch_object($query)){
            
             $tabl=$row->table_id;
             
             $player_capacity=$row->player_capacity;
										 $min_entry=$row->min_entry;
										 
										 $game_type=$row->game_type;
										 $game=$row->game;
										 $point_value=$row->point_value;
             
             
             
		$tblcount="select * from  user_tabel_join where `game_type` = 'Deal Rummy' and chip_type='free' and player_capacity=".$player_capacity." AND min_entry=".$min_entry." ";
			$result_inn = mysqli_query($conn,$tblcount);						    
			$a= mysqli_num_rows($result_inn);
			$playercapacity=$row->player_capacity;
            $reg=0;
            		 if($hide == ''){ $reg=1;}
            		 	if($hide == 'empty'){if($a == 0){ $reg=1;}}
            		 		if($hide == 'seating'){
            		 		    $seatnum=1;
            		 		    if($a == 0){ $seatnum=0;}
            		 		    if($a == $row->player_capacity){ $seatnum=0;}
            		 		    if( $seatnum ==1 ){ $reg=1;}
            		 		    
            		 		}
            		 		if($hide == 'full'){if($a == $row->player_capacity){ $reg=1;}}
            		 		
            		 		
            		 		          
            		 		               
            		 		               
            		 		              
		
		                                            echo '<tr>
		                                                <td style="display:none" id="tbl_id">'.$row->table_id.'</td>
		                                                
                                                    <td> '.$row->game_type.'</td>
                                                   
                                                    <td>'.$row->min_entry.'</td>
                                                    <td>'.$row->player_capacity.'</td>
                                                    <td id="pl_cap">'.$a.'</td>
                                                    <td>';
                                                    
                                                    echo '<a id="two_pl_game" onclick="check_table(\''.$loggeduser.'\',\''.$player_capacity.'\',\''.$min_entry.'\',\''.$game_type.'\',\''.$game.'\')"  target="">
                                            <button class="btn btn-primary">Join</button></a>';
                                                    
                                                    echo '</tr>  ';
            		 		          
	 
        
        }
}





//===================submitedmessage=================	
if(isset($_POST['submitedmessage'])){
 
        $msg = $_POST['submitedmessage'];
        $ticketid = $_POST['ticketid'];
        $cdate=date('Y-m-d H:i:s');
	 if($msg != ''){
	     
	     $updateequery="UPDATE `user_help_support` SET `lastreply`='User' WHERE id='$ticketid'";
	     mysqli_query($conn,$updateequery);
	  $makequery="INSERT INTO `user_help_reply`(`ticketid`, `msg`,  `created_date`) VALUES ('$ticketid','$msg','$cdate')";
	 mysqli_query($conn,$makequery);
	 }

      $get="select * from `user_help_reply` where `ticketid`='$ticketid' order by id asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      
        	  	  if($listdata->msgby == 0){
        	      
                echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                
                <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> You</span>
                <br />'.$listdata->msg. '
                </p></div>';
                
        	  }
    	  
    	   if($listdata->msgby == 1){
    	      
            echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
            <br />'.$listdata->msg. '
             </p></div>';
            
    	  }
	  }
	   
}


//===================replybyuser=================	
if(isset($_POST['replybyuser'])){
 
        $msg = $_POST['replymsg'];
        $ticketid = $_POST['selectedticket'];
        $cdate=date('Y-m-d H:i:s');
      
         $target_dir = "uploadimg/";
         $allow_types = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG");
         
         
            $images_arr = array();
            foreach($_FILES['images']['name'] as $key=>$val){
            $image_name = $_FILES['images']['name'][$key];
            $tmp_name   = $_FILES['images']['tmp_name'][$key];
            $size       = $_FILES['images']['size'][$key];
            $type       = $_FILES['images']['type'][$key];
            $error      = $_FILES['images']['error'][$key];
            
            
            $file_name = basename($_FILES['images']['name'][$key]);
            $targetFilePath = $target_dir . $file_name;
            
            
            $file_type = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(in_array($file_type, $allow_types)){    
            
            if(move_uploaded_file($_FILES['images']['tmp_name'][$key],$targetFilePath)){
            $images_arr[] = $targetFilePath;
            }
            }
            }
    
         
         
         
         
         
         
	 if($msg != ''){
	     
	     $updateequery="UPDATE `user_help_support` SET `lastreply`='User' WHERE id='$ticketid'";
	     mysqli_query($conn,$updateequery);
	   $makequery="INSERT INTO `user_help_reply`(`ticketid`, `msg`,  `created_date`) VALUES ('$ticketid','$msg','$cdate')";
	   mysqli_query($conn,$makequery);
	 }

     /* $get="select * from `user_help_reply` where `ticketid`='$ticketid' order by id asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      
        	  	  if($listdata->msgby == 0){
        	      
                echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                
                <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> You</span>
                <br />'.$listdata->msg. '
                </p></div>';
                
        	  }
    	  
    	   if($listdata->msgby == 1){
    	      
            echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
            <br />'.$listdata->msg. '
             </p></div>';
            
    	  }
	  }*/
	   
}

//===================ticketdata=================	
if(isset($_POST['ticketdata'])){
 
        $ticketid = $_POST['ticketdata'];
       
      $get="select * from `user_help_reply` where `ticketid`='$ticketid'  order by id asc";
	  $query=mysqli_query($conn,$get);   
	   $getticket="select * from `user_help_support` where `id`='$ticketid'";
	  $queryticket=mysqli_query($conn,$getticket);   
	  $listticket=mysqli_fetch_object($queryticket);
	  if($listticket->ticketby == 0){$textby='You';}else{$textby='Support Department';}
        echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
        
        <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listticket->created_date)).'</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> You</span>
        <br />'.$listticket->message. '
        </p></div>';
	  
	     while($listdata=mysqli_fetch_object($query)){
	      
        	  	  if($listdata->msgby == 0){
        	  	      
        	  	      
        	      if($listdata->type == 0){
                        echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                        
                        <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> You</span>
                        <br />'.$listdata->msg. '
                        </p></div>';
        	      }else{
        	          $reid=$listdata->id;
        	          
        	          $getimg="select * from `user_help_reply_document` where `user_help_reply_id`='$reid'";
                	  $queryimg=mysqli_query($conn,$getimg);   
                	  $listimg=mysqli_fetch_object($queryimg);
                	  if($listimg->image_path != ''){
        	           echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8ae;WIDTH: 100%;padding: 5px;text-align: left; font-size: 12px; margin-top: 5px;">
                         <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> You</span>
                        <br />';
                        if($listimg->file_type == 'img'){
                        echo '<img src="'.$listimg->image_path.'"  style="width: 50%;">';
                        }
                         if($listimg->file_type == 'doc'){
                        echo '<a class="btn btn-primary" href="'.$listimg->image_path.'" download>Download Attachment</a>';
                        }
                        echo '</p></div>';
                	  }
        	      
        	      }
                
        	  }
    	  
    	   if($listdata->msgby == 1){
    	       
    	        if($listdata->type == 0){
    	      
            echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
            <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
            <br />'.$listdata->msg. '
             </p></div>';
    	        }else{
        	          $reid=$listdata->id;
        	          
        	          $getimg="select * from `user_help_reply_document` where `user_help_reply_id`='$reid'";
                	  $queryimg=mysqli_query($conn,$getimg);   
                	  $listimg=mysqli_fetch_object($queryimg);
                	  if($listimg->image_path != ''){
                        echo '<div class="col-md-12 msgpage" ><p style="BACKGROUND: #aee8e6;WIDTH: 100%;padding: 5px;text-align: right; font-size: 12px; margin-top: 5px;">
                        <span><b>Date : </b>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Message by :</b> Admin</span>
                        <br />';
                        if($listimg->file_type == 'img'){
                        echo '<img src="'.$listimg->image_path.'"  style="width: 50%;">';
                        }
                         if($listimg->file_type == 'doc'){
                        echo '<a class="btn btn-primary" href="'.$listimg->image_path.'" download>Download Attachment</a>';
                        }
                        echo '</p></div>';
                	  }
        	      
        	      }
            
    	  }
	  }
	   
}



//===================browseentry=================	
if(isset($_POST['browseentry'])){
 
    $burl = $_POST['browseentry'];
    $loggeduser =  $_SESSION['logged_user'];
    
    $userip='';
    $usercity='';
    $userregion='';
    $usercountry='';
    
    $devicetype='';
    $ipaddress=$_SERVER['REMOTE_ADDR'];


        if($ipaddress != ''){
        
                $url="http://ipinfo.io/".$ipaddress."/geo";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $curl_scraped_page = curl_exec($ch);
                curl_close($ch);
        
               // echo $curl_scraped_page;
                $resultdata= json_decode($curl_scraped_page, true);
                $userip=$resultdata['ip'];
                $usercity=$resultdata['city'];
                $userregion=$resultdata['region'];
                $usercountry=$resultdata['country'];
        
        
        }
        
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        function getOS() {
        
        global $user_agent;
        
        $os_platform  = "Unknown OS Platform";
        
        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
        
                foreach ($os_array as $regex => $value)
                    if (preg_match($regex, $user_agent))
                        $os_platform = $value;
                
                return $os_platform;
        }
        
        $user_os= getOS();

    if(!$_SESSION['adminlogin']){
    $get="SELECT `user_id`, `username`, `last_name`, `mobile_no`, `email` FROM `users` WHERE username='$loggeduser'";
    $query=mysqli_query($conn,$get);
    $listdata=mysqli_fetch_object($query);

    $user_id=$listdata->user_id;
    $username=$listdata->username;
    $mobile_no=$listdata->mobile_no;
    $email=$listdata->email;
    $cdate=date('Y-m-d H:i:s');

    mysqli_query($conn,"INSERT INTO `browse_history`(`user_id`, `username`, `email`, `mobile`, `browse_url`, `os`, `ip`, `city`, `region`, `country`, `created_date`)
    VALUES ('$user_id','$username','$email','$mobile_no','$burl', '$user_os', '$userip', '$usercity', '$userregion', '$usercountry','$cdate')");
    }
	   
}




//===================GEt POint VAlue=================	
if(isset($_POST['getpointvalue'])){
 
      $playertable = $_POST['getpointvalue'];
      $pointarry='';
      $get="select DISTINCT(point_value) from `player_table` where `game`='Cash Game' and `player_capacity`='$playertable' and `table_status`='L' and `game_type`='Point Rummy' order by point_value asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->point_value;
       
           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }
      
	  }
	   echo $pointarry;
}

//===================GEt pool VAlue=================	
if(isset($_POST['getpoolvalue'])){
 
      $playertable = $_POST['getpoolvalue'];
       $poolvalue = $_POST['poolvalue'].' Pools';
      $pointarry='';
      $get="select DISTINCT(min_entry) from `player_table` where `game`='Cash Game' and `player_capacity`='$playertable'  and `pool`='$poolvalue' and `table_status`='L' and `game_type`='Pool Rummy' order by min_entry asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->min_entry;
       
           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }
      
	  }
	   echo $pointarry;
}


//===================GEt deal VAlue=================	
if(isset($_POST['getdealvalue'])){
 
      $playertable = $_POST['getdealvalue'];
      
      $pointarry='';
      $get="select DISTINCT(min_entry) from `player_table` where `game`='Cash Game' and `player_capacity`='$playertable' and `table_status`='L' and `game_type`='Deal Rummy' order by min_entry asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->min_entry;
       
           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }
      
	  }
	   echo $pointarry;
}

//===================GEt POint VAlue=================	
if(isset($_POST['getpointvaluefree'])){
 
      $playertable = $_POST['getpointvaluefree'];
      $pointarry='';
      $get="select DISTINCT(point_value) from `player_table` where `game`='Free Game' and `player_capacity`='$playertable' and `table_status`='L' and `game_type`='Point Rummy' order by point_value asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->point_value;
       
           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }
      
	  }
	   echo $pointarry;
}
//===================GEt pool VAlue=================	
if(isset($_POST['getpoolvaluefree'])){
 
      $playertable = $_POST['getpoolvaluefree'];
       $poolvalue = $_POST['poolvalue'].' Pools';
      $pointarry='';
      $get="select DISTINCT(min_entry) from `player_table` where `game`='Free Game' and `player_capacity`='$playertable'  and `pool`='$poolvalue' and `table_status`='L' and `game_type`='Pool Rummy' order by min_entry asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->min_entry;
       
           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }
      
	  }
	   echo $pointarry;
}


//===================GEt deal VAlue=================	
if(isset($_POST['getdealvaluefree'])){
 
      $playertable = $_POST['getdealvaluefree'];
      
      $pointarry='';
      $get="select DISTINCT(min_entry) from `player_table` where `game`='Free Game' and `player_capacity`='$playertable' and `table_status`='L' and `game_type`='Deal Rummy' order by min_entry asc";
	  $query=mysqli_query($conn,$get);     
	  
	  while($listdata=mysqli_fetch_object($query)){
	      $point_value = $listdata->min_entry;
       
           if($pointarry == ''){
           $pointarry=$point_value;
           }else{
           $pointarry=$pointarry.','.$point_value;
           }
      
	  }
	   echo $pointarry;
}


//==========================referral withdraw request================================
//var dataString ='withdrawrequestrefcommission='+amount+'&ttype='+ttype;

if(isset($_POST['withdrawrequestrefcommission'])){
 //print_r($_POST);
       $amount = $_POST['withdrawrequestrefcommission'];
       $ttype = $_POST['ttype'];
       $totalcommission= totalrefcommission($conn);
       $totalwithdraw= totalrefwithdrawal($conn);
       $refid =  $_SESSION['user_id'];
       $balamount=$totalcommission-$totalwithdraw-$amount;
       $cdate=date('Y-m-d h:i:s');
       $ch=0;
      
      if($ttype == ''){ $ch=1; return 'PLease select Transaction Type';}
      if($refid == ''){ $ch=1; return 'Somthing Is Wrong';}
      if($amount > $balamount){ $ch=1; return 'Unsufficiant Balance';}
      if($ch == 0){
            if($ttype == 1){
                mysqli_query($conn,"INSERT INTO `withdraw_refcommission_request`( `user_id`, `requested_amount`, `created_on`,`status`, `type`, `total_amount`, `bal_amount`)
                VALUES ('$refid','$amount','$cdate','pending','$ttype','$totalcommission','$balamount')");
                echo 1;
            }else if($ttype == 2){
                
                $loggeduser =  $_SESSION['logged_user'];
                //echo $loggeduser;
                $query=mysqli_query($conn,"SELECT `account_id`, `userid`, `real_chips` FROM `accounts` WHERE userid='$refid'");
                $num=mysqli_num_rows($query);
                if($num > 0){
                    
                    $listamount=mysqli_fetch_object($query);
                    $oldamount=$listamount->real_chips;
                    $account_id=$listamount->account_id;
                    $newamount=$oldamount+$amount;
                    mysqli_query($conn,"UPDATE `accounts` SET `real_chips`='$newamount' WHERE account_id='$account_id' and userid='$refid'");
                    
                    mysqli_query($conn,"INSERT INTO `withdraw_refcommission_request`( `user_id`, `requested_amount`, `created_on`,`status`, `type`, `total_amount`, `bal_amount`)
                    VALUES ('$refid','$amount','$cdate','paid','$ttype','$totalcommission','$balamount')");
                    
                    $insertid=mysqli_insert_id($conn);
                    
                    mysqli_query($conn,"INSERT INTO `fund_added_to_player`(`user_id`, `amount`, `created_date`, `chip_type`, `transaction_id`, `payment_mode`, `order_id`, `status`, `created_by`)
                    VALUES ('$refid','$amount','$cdate','Real','$insertid','commission',0,'success','$loggeduser')");
                   echo 1;
                }
                
               
                
                
            }else{
                return 'Somthing Is Wrong';;
            }
            
            
      }else{
                return 'Somthing Is Wrong';;
            }
     
     
       
       
}



?>
