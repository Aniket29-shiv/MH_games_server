<?php

    $searchval='';
    $from1='';
    $from='';
    $to='';
    $to1='';
    
    
    if(isset($_GET['searchval'])){ $searchval=$_GET['searchval'];}
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


    function totalpages($limit,$sql,$searchval,$from,$to) {
    	
    	
        $makequery="select fund_added_to_player.*,accounts.play_chips,accounts.username as fullname,accounts.real_chips,users.username,users.first_name,users.last_name,users.mobile_no,users.email
        from fund_added_to_player
        LEFT JOIN accounts ON accounts.userid=fund_added_to_player.user_id 
        LEFT JOIN users ON users.user_id=fund_added_to_player.user_id where 1=1 ";
        
        if($searchval != ''){ $makequery .=" and  (users.`first_name` like '$searchval%' or users.`last_name` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%' or users.`username` like '$searchval%')"; }
        if($from != ''){ $makequery .=" and  fund_added_to_player.created_date >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  fund_added_to_player.created_date <= '$to 23:59:59'"; }
        $makequery .=" ORDER BY `fund_added_to_player`.`created_date` DESC";
        $query1=mysqli_query($sql,$makequery);
    	
    	$listdata = mysqli_num_rows($query1);
    	
    	$total_pages = ceil($listdata / $limit);
    	
    	return $total_pages;
    	
    	
    }



$tpages = totalpages(10,$conn,$searchval,$from,$to);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages,$searchval,$from,$to) {
    
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
   if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "&amp;searchval=" . $searchval . "&amp;from=" . $from . "&amp;to=" . $to . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$start,$limit,$searchval,$from,$to){
    
        
     $makequery="select fund_added_to_player.*,accounts.play_chips,accounts.username as fullname,accounts.real_chips,users.username,users.first_name,users.last_name,users.mobile_no,users.email
        from fund_added_to_player
        LEFT JOIN accounts ON accounts.userid=fund_added_to_player.user_id 
        LEFT JOIN users ON users.user_id=fund_added_to_player.user_id   where 1=1 ";
        
        if($searchval != ''){ $makequery .=" and  (users.`first_name` like '$searchval%' or users.`last_name` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%' or users.`username` like '$searchval%')"; }
        if($from != ''){ $makequery .=" and  fund_added_to_player.created_date >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  fund_added_to_player.created_date <= '$to 23:59:59'"; }
        $makequery .=" ORDER BY `fund_added_to_player`.`created_date` DESC LIMIT $start,$limit";
    //$makequery .= " ORDER BY us.user_id asc LIMIT $start,$limit";
    
    
  //echo $makequery;
    
	$query=mysqli_query ($sql,$makequery);
	
        if($start == 0){
          $x=1;
        }else{
          $x=$start+1;
        }
    if(mysqli_num_rows(	$query) > 0){     
            
    	while($listdata=mysqli_fetch_object($query)){
                
                    echo '	<tr>
                    <td>'.$x.'</td> 
                     <td>'.$listdata->first_name.' '.$listdata->last_name.'</td> 
                     <td>'.$listdata->username.'</td> 
                     <td>'.$listdata->amount.'</td> 
                    <td>'.$listdata->payment_mode.'</td> 
                    <td>'.$listdata->order_id.'</td> 
                    <td>'.$listdata->real_chips.'</td> 
                    <td>'.$listdata->created_date.'</td> 
                     </tr> ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval,$from,$to){
    
        $makequery="select fund_added_to_player.*,accounts.play_chips,accounts.username as fullname,accounts.real_chips,users.username,users.first_name,users.last_name,users.mobile_no,users.email
        from fund_added_to_player
        LEFT JOIN accounts ON accounts.userid=fund_added_to_player.user_id 
        LEFT JOIN users ON users.user_id=fund_added_to_player.user_id   where 1=1 ";
        
        if($searchval != ''){ $makequery .=" and  (users.`first_name` like '$searchval%' or users.`last_name` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%' or users.`username` like '$searchval%')"; }
        if($from != ''){ $makequery .=" and  fund_added_to_player.created_date >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  fund_added_to_player.created_date <= '$to 23:59:59'"; }
        $makequery .=" ORDER BY `fund_added_to_player`.`created_date` DESC";
        
        $query=mysqli_query ($sql,$makequery);
        $num=mysqli_num_rows($query);
        
        return $num;

}

?>
