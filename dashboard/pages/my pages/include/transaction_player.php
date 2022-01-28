<?php

    $game='';
    $players='';
   $from1='';
    $from='';
    $to='';
    $to1='';
    $chiptype='';
    $status='';
    
    
    if(isset($_GET['game'])){ $game=$_GET['game'];}
    if(isset($_GET['chiptype'])){ $chiptype=$_GET['chiptype'];}
    if(isset($_GET['status'])){ $status=$_GET['status'];}
    if(isset($_GET['players'])){ $players=$_GET['players'];}
   
    
   
    if(isset($_GET['from'])){
        
        $from1=$_GET['from'];
        if($from1 != ''){ $from=date('Y-m-d',strtotime($from1));}
        
    }
     if(isset($_GET['to'])){ 
         
         $to1=$_GET['to'];
         if($to1 != ''){ $to=date('Y-m-d',strtotime($to1));}
         
     }


    $start = 0;
    $pagenum = 1;
  
if(isset($_GET['page'])) {
	$start =($_GET['page'] - 1) * 25;
	$pagenum = $_GET['page'];
} 


function totalpages($limit,$sql,$game,$players,$from,$to,$chiptype,$status) {
	
	
    $makequery="SELECT g.id FROM `game_transactions` as g left join users as u on u.user_id=g.user_id where 1=1 ";
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($chiptype != ''){ $makequery .=" and g.`chip_type`='$chiptype'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
   if($players != ''){ $makequery .=" and (g.`player_name` like '%$players%' or u.`email` like '%$players%' or u.`mobile_no` like '%$players%' )"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date` DESC";
    
    
    $query1=mysqli_query($sql,$makequery);
    
	
	$listdata = mysqli_num_rows($query1);
	
	$total_pages = ceil($listdata / $limit);
	
	return $total_pages;
	
	
}



$tpages = totalpages(25,$conn,$game,$players,$from,$to,$chiptype,$status);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages,$game,$players,$from,$to,$chiptype,$status) {
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
   if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;game=" . $game . "&amp;players=" . $players . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;chiptype=" . $chiptype . "&amp;status=" . $status . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "&amp;game=" . $game . "&amp;players=" . $players . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;chiptype=" . $chiptype . "&amp;status=" . $status . "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;game=" . $game . "&amp;players=" . $players . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;chiptype=" . $chiptype . "&amp;status=" . $status . "&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;game=" . $game . "&amp;players=" . $players . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;chiptype=" . $chiptype . "&amp;status=" . $status . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "&amp;game=" . $game . "&amp;players=" . $players . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;chiptype=" . $chiptype . "&amp;status=" . $status . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "&amp;game=" . $game . "&amp;players=" . $players . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;chiptype=" . $chiptype . "&amp;status=" . $status . "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "&amp;game=" . $game . "&amp;players=" . $players . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;chiptype=" . $chiptype . "&amp;status=" . $status . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$start,$limit,$game,$players,$from,$to,$chiptype,$status){
    
   $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g left join users as u on u.user_id=g.user_id where 1=1 ";
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($chiptype != ''){ $makequery .=" and g.`chip_type`='$chiptype'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
    if($players != ''){ $makequery .=" and (g.`player_name` like '%$players%' or u.`email` like '%$players%' or u.`mobile_no` like '%$players%' )"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC LIMIT $start,$limit";
   
    
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
                    <td>'.$listdata->transaction_date.'</td>
                    <td>'.$listdata->table_id.'</td> 
                    <td>'.$listdata->round_no.'</td> 
                    <td>'.$listdata->table_name.'</td>
                     <td>'.$listdata->first_name.' '.$listdata->last_name.'</td> 
                    <td>'.$listdata->player_name.'</td> 
                    <td>'.$listdata->game_type.'</td> 
                    <td>'.$listdata->status.'</td> 
                    <td>'.number_format($listdata->amount,2).'</td> 
                    <td>'.$listdata->chip_type.'</td> 
                    
                    </tr>  ';
                    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$game,$players,$from,$to,$chiptype,$status){
    
    $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g left join users as u on u.user_id=g.user_id where 1=1 ";
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($chiptype != ''){ $makequery .=" and g.`chip_type`='$chiptype'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
   if($players != ''){ $makequery .=" and (g.`player_name` like '%$players%' or u.`email` like '%$players%' or u.`mobile_no` like '%$players%' )"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC";
        
        $query=mysqli_query ($sql,$makequery);
        
        $num=mysqli_num_rows($query);
        
        return $num;
	
}

function totalwin($sql,$game,$players,$from,$to,$chiptype,$status){
    
       $makequery="SELECT sum(g.amount) as total FROM `game_transactions` as g left join users as u on u.user_id=g.user_id where g.`status`='Won'";
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($chiptype != ''){ $makequery .=" and g.`chip_type`='$chiptype'"; }
   
    if($players != ''){ $makequery .=" and (g.`player_name` like '%$players%' or u.`email` like '%$players%' or u.`mobile_no` like '%$players%' )"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC";
        
        $query=mysqli_query ($sql,$makequery);
        
       $listdata=mysqli_fetch_object($query);
        
        return $listdata->total;
	
}
function totallost($sql,$game,$players,$from,$to,$chiptype,$status){
    
     
       $makequery="SELECT sum(g.amount) as total FROM `game_transactions` as g left join users as u on u.user_id=g.user_id where g.`status`='Lost'";
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($chiptype != ''){ $makequery .=" and g.`chip_type`='$chiptype'"; }
   
   if($players != ''){ $makequery .=" and (g.`player_name` like '%$players%' or u.`email` like '%$players%' or u.`mobile_no` like '%$players%' )"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC";
        
        $query=mysqli_query ($sql,$makequery);
        
       $listdata=mysqli_fetch_object($query);
        
        return $listdata->total;
	
}


?>
