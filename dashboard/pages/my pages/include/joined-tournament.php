
<?php

    $tid='';
    $title='';
    $price='';
    $entry_fee='';
    $players='';
    $start_date='';
    $reg_start_date='';
    $reg_end_date='';

  
    
    
    if(isset($_GET['tid'])){ 
        
        
        $tid=$_GET['tid'];
        
         $makequery="SELECT * FROM `tournament`  where tournament_id='$tid'";

	        $query=mysqli_query ($conn,$makequery);
	        $listdata=mysqli_fetch_object($query);
	        $title=$listdata->title;
	        $price=$listdata->price;
	        $entry_fee=$listdata->entry_fee;
	        $players=$listdata->no_of_player;
	        $start_date=$listdata->start_date;
	        $reg_start_date=$listdata->reg_start_date;
	        $reg_end_date=$listdata->reg_end_date;
        
    }

//SELECT `tournament_id`, `price`, `title`, `start_date`, `start_time`, `reg_start_date`, `reg_start_time`, `reg_end_date`, `reg_end_time`,
//`entry_fee`, `no_of_player`, `description`, `file`, `created_date`, `updated_date`, `status` FROM `tournament` WHERE 1
//SELECT `id`, `player_id`, `tournament_id`, `fees`, `created_time` FROM `join_tournaments` WHERE 1
function listpromotions($sql,$tid){
    
        
      $makequery="SELECT ts.*,u.first_name,u.last_name,u.username FROM `join_tournaments` as ts 
        left join `tournament` as t on t.tournament_id=ts.tournament_id
        left join `users` as u on u.user_id=ts.player_id
        where ts.tournament_id='$tid' ORDER BY ts.`id` desc";

    
 // echo $makequery;
    
	$query=mysqli_query ($sql,$makequery);
	
        if($start == 0){
          $x=1;
        }else{
          $x=$start+1;
        }
    if(mysqli_num_rows(	$query) > 0){     
            
    	while($listdata=mysqli_fetch_object($query)){
                
                    echo '<tr>
                    <td>'.$x.'</td> 
                     <td>'.$listdata->username.'</td>
                     <td>'.$listdata->first_name.' '.$listdata->last_name.'</td>
                    <td>'.$listdata->fees.'</td>
                    <td>'.$listdata->created_time.'</td>
                     
                   </tr> ';
                    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$tid){
    
    $makequery="SELECT ts.*,u.first_name,u.last_name,u.username FROM `join_tournaments` as ts 
        left join `tournament` as t on t.tournament_id=ts.tournament_id
        left join `users` as u on u.user_id=ts.player_id
        where ts.tournament_id='$tid' ORDER BY ts.`id` desc";

	$query=mysqli_query ($sql,$makequery);
     $num=mysqli_num_rows($query);
     
     return $num;
	
}

?>
