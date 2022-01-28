<?php

    $searchval='';
    $from1='';
    $from='';
    $to='';
    $to1='';
    $ttitle='';
    $type='';
    if(isset($_GET['type'])){ $type=$_GET['type'];}
    if(isset($_GET['searchval'])){ $searchval=$_GET['searchval'];}
    if(isset($_GET['ttitle'])){ $ttitle=$_GET['ttitle'];}
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
    	$start =($_GET['page'] - 1) * 10;
    	$pagenum = $_GET['page'];
    } 


    function totalpages($limit,$sql,$searchval,$from,$to,$ttitle,$type) {
    
    	
        $makequery="select t.*,u.first_name,u.last_name,ts.title,ts.entry_fee from `tournament_transaction` as t 
        left join `tournament` as ts on ts.tournament_id=t.tournament_id
        left join `users` as u on u.user_id=t.player_id where 1=1";
        if($searchval != ''){ $makequery .=" and  (u.`username` like '$searchval%' or u.`email` like '$searchval%' or u.`mobile_no` like '$searchval%')"; }
        if($ttitle != ''){ $makequery .=" and  ( ts.`tournament_id` = '$ttitle')"; }
        if($type == 'free'){ $makequery .=" and   ts.`entry_fee` = 0"; }
        if($type == 'cash'){ $makequery .=" and   ts.`entry_fee` != 0"; }
        if($from != ''){ $makequery .=" and  t.entry_date >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and t.entry_date <= '$to 23:59:59'"; }
        $makequery .= " ORDER BY ts.tournament_id desc";
        
        $query1=mysqli_query($sql,$makequery);
    	
    	$listdata = mysqli_num_rows($query1);
    	
    	$total_pages = ceil($listdata / $limit);
    	
    	return $total_pages;
    	
    	
    }



$tpages = totalpages(10,$conn,$searchval,$from,$to,$ttitle,$type);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages,$searchval,$from,$to,$ttitle,$type) {
    
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
   if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;ttitle=" . $ttitle . "&amp;type=" . $type . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;ttitle=" . $ttitle . "&amp;type=" . $type . "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;ttitle=" . $ttitle . "&amp;type=" . $type . "&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;ttitle=" . $ttitle . "&amp;type=" . $type . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;ttitle=" . $ttitle . "&amp;type=" . $type . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;ttitle=" . $ttitle . "&amp;type=" . $type . "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;ttitle=" . $ttitle . "&amp;type=" . $type . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$start,$limit,$searchval,$from,$to,$ttitle,$type){
    
   
    	
         $makequery="select t.*,u.first_name,u.last_name,u.username,ts.title,ts.entry_fee from `tournament_transaction` as t 
        left join `tournament` as ts on ts.tournament_id=t.tournament_id
         left join `users` as u on u.user_id=t.player_id where 1=1";
    if($searchval != ''){ $makequery .=" and  (u.`username` like '$searchval%' or u.`email` like '$searchval%' or u.`mobile_no` like '$searchval%')"; }
     if($ttitle != ''){ $makequery .=" and  ( ts.`tournament_id` = '$ttitle')"; }
      if($type == 'free'){ $makequery .=" and   ts.`entry_fee` = 0"; }
        if($type == 'cash'){ $makequery .=" and   ts.`entry_fee` != 0"; }
    if($from != ''){ $makequery .=" and  t.entry_date >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and t.entry_date <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY ts.tournament_id desc Limit $start,$limit";

    
  //echo $makequery;
    
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
                    <td>'.$listdata->entry_date.'</td>
                    <td>'.$listdata->tournament_id.'</td> 
                    <td>'.$listdata->title.'</td> 
                    <td>'.$listdata->username.'</td>
                    <td>'.$listdata->first_name.' '.$listdata->last_name.'</td>
                    <td>'.$listdata->entry_fee.'</td>
                    <td>'.$listdata->position.'</td>
                    <td>'.$listdata->score.'</td>
                     </tr> ';
                    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval,$from,$to,$ttitle,$type){
    
  $makequery="select t.*,u.first_name,u.last_name,ts.title,ts.entry_fee from `tournament_transaction` as t 
        left join `tournament` as ts on ts.tournament_id=t.tournament_id
         left join `users` as u on u.user_id=t.player_id where 1=1";
    if($searchval != ''){ $makequery .=" and  (u.`username` like '$searchval%' or u.`email` like '$searchval%' or u.`mobile_no` like '$searchval%')"; }
     if($ttitle != ''){ $makequery .=" and  (ts.`tournament_id` = '$ttitle' )"; }
      if($type == 'free'){ $makequery .=" and   ts.`entry_fee` = 0"; }
        if($type == 'cash'){ $makequery .=" and   ts.`entry_fee` != 0"; }
    if($from != ''){ $makequery .=" and  t.entry_date >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and t.entry_date <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY ts.tournament_id desc";

	$query=mysqli_query ($sql,$makequery);
     $num=mysqli_num_rows($query);
     
     return $num;
	
}

function numberentryfee($sql,$searchval,$from,$to,$ttitle,$type){
    
  $makequery="select sum(ts.entry_fee) as total from `tournament_transaction` as t 
        left join `tournament` as ts on ts.tournament_id=t.tournament_id
         left join `users` as u on u.user_id=t.player_id where 1=1";
    if($searchval != ''){ $makequery .=" and  (u.`username` like '$searchval%' or u.`email` like '$searchval%' or u.`mobile_no` like '$searchval%')"; }
     if($ttitle != ''){ $makequery .=" and  ( ts.`tournament_id` = '$ttitle')"; }
      if($type == 'free'){ $makequery .=" and   ts.`entry_fee` = 0"; }
        if($type == 'cash'){ $makequery .=" and   ts.`entry_fee` != 0"; }
    if($from != ''){ $makequery .=" and  t.entry_date >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and t.entry_date <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY ts.tournament_id desc";

	$query=mysqli_query ($sql,$makequery);
     $listdata=mysqli_fetch_object($query);
     
     return  $listdata->total;
	
}

function numberscore($sql,$searchval,$from,$to,$ttitle,$type){
    
    $makequery="select sum(t.score)  as total from `tournament_transaction` as t 
    left join `tournament` as ts on ts.tournament_id=t.tournament_id
    left join `users` as u on u.user_id=t.player_id where 1=1";
    if($searchval != ''){ $makequery .=" and  (u.`username` like '$searchval%' or u.`email` like '$searchval%' or u.`mobile_no` like '$searchval%')"; }
    if($ttitle != ''){ $makequery .=" and  (ts.`tournament_id` = '$ttitle')"; }
     if($type == 'free'){ $makequery .=" and   ts.`entry_fee` = 0"; }
        if($type == 'cash'){ $makequery .=" and   ts.`entry_fee` != 0"; }
    if($from != ''){ $makequery .=" and  t.entry_date >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and t.entry_date <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY ts.tournament_id desc";

	$query=mysqli_query ($sql,$makequery);
    $listdata=mysqli_fetch_object($query);
     return  $listdata->total;
	
}

?>
