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
	
	
    $makequery 	= "SELECT 
    u.user_id, 
    u.username, 
    concat(ifnull(u.first_name,''),' ',ifnull(u.middle_name,''),' ',ifnull(u.last_name,'')) AS player_name, 
    ifnull(u.mobile_no,'') AS mobile_no, 
    ifnull(u.email,'') AS email,
    kd.amount,
    kd.transaction_id,
    kd.order_id,
    kd.payment_mode,
    kd.status,
    kd.created_date as cdate
    from 
    users as u
    INNER JOIN fund_added_to_player AS kd ON (kd.user_id = u.user_id)
    where 
    kd.chip_type='Real'";
    
     if($searchval != ''){ $makequery .=" and  (u.`first_name` like '$searchval%' or u.`last_name` like '$searchval%' or u.`mobile_no` like '$searchval%' or u.`email` like '$searchval%' or u.`username` like '$searchval%')"; }
    if($from != ''){ $makequery .=" and  kd.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`created_date` <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY u.user_id asc";
    
   
    
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
    
        
    $makequery 	= "SELECT 
						u.user_id, 
						u.username, 
						concat(ifnull(u.first_name,''),' ',ifnull(u.middle_name,''),' ',ifnull(u.last_name,'')) AS player_name, 
						ifnull(u.mobile_no,'') AS mobile_no, 
						ifnull(u.email,'') AS email,
						kd.amount,
						kd.transaction_id,
						kd.order_id,
						kd.payment_mode,
						kd.status,
						kd.created_date as cdate
				from 
						users as u
						INNER JOIN fund_added_to_player AS kd ON (kd.user_id = u.user_id)
				where 
						kd.chip_type='Real'";
     if($from != ''){ $makequery .=" and  kd.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`created_date` <= '$to 23:59:59'"; }
     if($searchval != ''){ $makequery .=" and  (u.`first_name` like '$searchval%' or u.`last_name` like '$searchval%' or u.`mobile_no` like '$searchval%' or u.`email` like '$searchval%' or u.`username` like '$searchval%')"; }
    $makequery .= " ORDER BY u.user_id asc LIMIT $start,$limit";
    
       
        
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
                    <td>'.$listdata->cdate.'</td> 
                    <td>'.$listdata->user_id.'</td> 
                    <td>'.$listdata->player_name.'</td> 
                    <td>'.$listdata->username.'</td> 
                    <td>'.$listdata->email.'</td> 
                    <td>'.$listdata->mobile_no.'</td> 
                    <td>'.$listdata->amount.'</td> 	
                    <td>'.$listdata->transaction_id.'</td> 													
                    <td>'.$listdata->order_id.'</td> 	
                    <td>'.$listdata->payment_mode.'</td> 	
                    <td>'.$listdata->status.'</td> 	
                    </tr>  ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval,$from,$to){
    
        $makequery 	= "SELECT 
        u.user_id, 
        u.username, 
        concat(ifnull(u.first_name,''),' ',ifnull(u.middle_name,''),' ',ifnull(u.last_name,'')) AS player_name, 
        ifnull(u.mobile_no,'') AS mobile_no, 
        ifnull(u.email,'') AS email,
        kd.amount,
        kd.transaction_id,
        kd.order_id,
        kd.payment_mode,
        kd.status,
        kd.created_date as cdate
        from 
        users as u
        INNER JOIN fund_added_to_player AS kd ON (kd.user_id = u.user_id)
        where 
        kd.chip_type='Real'";
        
         if($searchval != ''){ $makequery .=" and  (u.`first_name` like '$searchval%' or u.`last_name` like '$searchval%' or u.`mobile_no` like '$searchval%' or u.`email` like '$searchval%' or u.`username` like '$searchval%')"; }
       if($from != ''){ $makequery .=" and  kd.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`created_date` <= '$to 23:59:59'"; }
        $makequery .= " ORDER BY u.user_id asc";

        $query=mysqli_query ($sql,$makequery);
        
        $num=mysqli_num_rows($query);
        
        return $num;
	
}

?>
