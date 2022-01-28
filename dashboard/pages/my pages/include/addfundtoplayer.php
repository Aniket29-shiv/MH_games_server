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
	$start =($_GET['page'] - 1) * 25;
	$pagenum = $_GET['page'];
} 


function totalpages($limit,$sql,$searchval,$from,$to) {
	
	
    $makequery="select users.* from accounts  LEFT JOIN users ON accounts.userid=users.user_id where 1=1 ";
    if($searchval != ''){ $makequery .=" and   (users.`first_name` like '$searchval%' or users.`last_name` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%' or users.`username` like '$searchval%')"; }
     if($from != ''){ $makequery .=" and  users.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  users.`created_date` <= '$to 23:59:59'"; }
    $query1=mysqli_query($sql,$makequery);
	
	$listdata = mysqli_num_rows($query1);
	
	$total_pages = ceil($listdata / $limit);
	
	return $total_pages;
	
	
}



$tpages = totalpages(25,$conn,$searchval,$from,$to);
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
    
        
    $makequery="select accounts.*,users.* from accounts  LEFT JOIN users ON accounts.userid=users.user_id where 1=1 ";
    if($searchval != ''){ $makequery .="  and (users.`first_name` like '$searchval%' or users.`last_name` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%' or users.`username` like '$searchval%')"; }
    if($from != ''){ $makequery .=" and  users.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  users.`created_date` <= '$to 23:59:59'"; }
    $makequery .= "   LIMIT $start,$limit";
   
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
                                 <td>'.$listdata->created_date.'</td> 
                                <td>'.$listdata->user_id.'</td> 
                                <td>'.$listdata->username.'</td> 
                                <td>'.$listdata->first_name.'</td> 
                                <td>'.$listdata->email.'</td> 
                                <td>'.$listdata->mobile_no.'</td> 
                                <td>
                                <input type="text" id="play_chips_'.$listdata->user_id.'"name="play_chips_'.$listdata->user_id.'" style="width:85%" autocomplete="off">
                                <span id="fre_'.$listdata->user_id.'" style="display: none;margin-left: 1%; color: red;text-align:center">Please entered Free Chips!.</span>
                                </td>
                                <td>
                                <input type="text" name="real_chips_'.$listdata->user_id.'" id="real_chips_'.$listdata->user_id.'"style="width:85%" autocomplete="off">
                                <span id="rel_'.$listdata->user_id.'" style="display: none;margin-left: 1%; color: red;text-align:center">Please entered Real Chips!.</span>
                                </td> 
                                <td>
                                <input type="hidden" name="acc_no[]"  value="'.$listdata->user_id.'"> 
                                <button name="submit" class="btn btn-primary btn-xs" onclick="add('.$listdata->user_id.');">Add</button> 
                                </td>
                                </tr>  ';
                                $x++;
        	    
        	}
        }
	
}



function numberofdata($sql,$searchval,$from,$to){
    
     $makequery="select users.* from accounts  LEFT JOIN users ON accounts.userid=users.user_id where 1=1 ";
    if($searchval != ''){ $makequery .="   and (users.`first_name` like '$searchval%' or users.`last_name` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%' or users.`username` like '$searchval%')"; }
  if($from != ''){ $makequery .=" and  users.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  users.`created_date` <= '$to 23:59:59'"; }
        //echo $makequery;
	$query=mysqli_query ($sql,$makequery);
	
     $num=mysqli_num_rows($query);
     
     return $num;
	
}

?>
