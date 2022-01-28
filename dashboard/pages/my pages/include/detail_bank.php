<?php

    $searchval='';
   
    
    
    if(isset($_GET['searchval'])){ $searchval=$_GET['searchval'];}
  

    $start = 0;
    $pagenum = 1;
  
if(isset($_GET['page'])) {
	$start =($_GET['page'] - 1) * 25;
	$pagenum = $_GET['page'];
} 


function totalpages($limit,$sql,$searchval) {
	
	
    $makequery="select bd.*,us.username,us.first_name,us.middle_name,us.last_name from bank_details bd LEFT JOIN users us ON bd.user_id=us.user_id ";
    if($searchval != ''){ $makequery .=" where ( us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%' or us.`mobile_no` like '$searchval%' or us.`email` like '$searchval%' or us.`username` like '$searchval%')"; }
     $makequery .= " ORDER BY us.user_id asc";
    $query1=mysqli_query($sql,$makequery);
	
	$listdata = mysqli_num_rows($query1);
	
	$total_pages = ceil($listdata / $limit);
	
	return $total_pages;
	
	
}



$tpages = totalpages(25,$conn,$searchval);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages,$searchval) {
    
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
   if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "&amp;searchval=" . $searchval . "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;searchval=" . $searchval . "&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "&amp;searchval=" . $searchval . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "&amp;searchval=" . $searchval . "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "&amp;searchval=" . $searchval . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$start,$limit,$searchval){
    
        
      $makequery="select bd.*,us.username,us.first_name,us.middle_name,us.last_name from bank_details bd LEFT JOIN users us ON bd.user_id=us.user_id ";
    if($searchval != ''){ $makequery .=" where ( us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%' or us.`mobile_no` like '$searchval%' or us.`email` like '$searchval%' or us.`username` like '$searchval%')"; }
     $makequery .= " ORDER BY us.user_id asc LIMIT $start,$limit";
       
	$query=mysqli_query ($sql,$makequery);
	
        if($start == 0){
          $x=1;
        }else{
          $x=$start+1;
        }
    if(mysqli_num_rows(	$query) > 0){     
            
    	while($listdata=mysqli_fetch_object($query)){
                $fullname=$listdata->first_name.' '.$listdata->middle_name.' '.$listdata->last_name;
                    echo '<tr>
                    <td>'.$x.'</td> 
                    <td>'.$listdata->username.'</td> 
                    <td>'.$listdata->first_name.' '.$listdata->middle_name.' '.$listdata->last_name.'</td>
                    <td>'.$listdata->bank_name.'</td> 
                    <td>'.$listdata->account_no.'</td> 
                    <td>'.$listdata->ifsc_code.'</td> 
                    <td>
                    <a href="update_bank_details.php?user_id='.$listdata->user_id.'&user_name='.$fullname.'"><button class="btn btn-info btn-xs">Edit</button></a>
                    </td>
                    </tr> ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval){
    
        $makequery="select bd.*,us.username,us.first_name,us.middle_name,us.last_name from bank_details bd LEFT JOIN users us ON bd.user_id=us.user_id ";
    if($searchval != ''){ $makequery .=" where ( us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%' or us.`mobile_no` like '$searchval%' or us.`email` like '$searchval%' or us.`username` like '$searchval%')"; }
     $makequery .= " ORDER BY us.user_id";
	$query=mysqli_query ($sql,$makequery);
	
     $num=mysqli_num_rows($query);
     
     return $num;
	
}

?>
