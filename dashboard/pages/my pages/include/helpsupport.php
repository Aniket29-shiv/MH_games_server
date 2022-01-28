<?php

   $searchval='';
   $statusval='';
    
    
     if(isset($_GET['searchval'])){ $searchval=$_GET['searchval'];}
     if(isset($_GET['statusval'])){ $statusval=$_GET['statusval'];}
  

    $start = 0;
    $pagenum = 1;
  
    if(isset($_GET['page'])) {
    	$start =($_GET['page'] - 1) * 25;
    	$pagenum = $_GET['page'];
    } 
    
    
    function totalpages($limit,$sql,$searchval,$statusval) {
    	
    	
        $makequery="select 	* from 	user_help_support as h inner join users as u on(h.name = u.username)";
        if($searchval != ''){ $makequery .=" and  h.`name` like '$searchval%'"; }
        if($statusval != ''){ $makequery .=" and  h.`status` = '$statusval'"; }
         $makequery .= " ORDER BY h.id desc";
        $query1=mysqli_query($sql,$makequery);
    	
    	$listdata = mysqli_num_rows($query1);
    	
    	$total_pages = ceil($listdata / $limit);
    	
    	return $total_pages;
    	
    	
    }



$tpages = totalpages(25,$conn,$searchval,$statusval);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages,$searchval,$statusval) {
    
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
   if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "&amp;statusval=" . $statusval . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "&amp;searchval=" . $searchval . "&amp;statusval=" . $statusval . "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;searchval=" . $searchval . "&amp;statusval=" . $statusval . "&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;searchval=" . $searchval . "&amp;statusval=" . $statusval . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "&amp;searchval=" . $searchval . "&amp;statusval=" . $statusval . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "&amp;searchval=" . $searchval . "&amp;statusval=" . $statusval . "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "&amp;searchval=" . $searchval . "&amp;statusval=" . $statusval . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$start,$limit,$searchval,$statusval){
    
        
    $makequery="select 	* from 	user_help_support as h inner join users as u on(h.name = u.username)";
    if($searchval != ''){ $makequery .=" and  h.`name` like '$searchval%'"; }
     if($statusval != ''){ $makequery .=" and  h.`status` = '$statusval'"; }
     $makequery .= " ORDER BY h.id desc LIMIT $start,$limit";
    
    
  
    
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
                <td>'.$listdata->username.'</td> 
                <td>'.$listdata->subject.'</td> 
                <td>'.$listdata->message.'</td> 
                <td id="statustxt'.$listdata->id.'">'.$listdata->status.'</td> 	
                <td>'.$listdata->lastreply.'</td>
                ';
                
                    if ($listdata->status == 'pending') {	
                        
                    echo '<td><a class="btn btn-primary msgstatus" data-id="'.$listdata->id.'" data-status="Open" id="obutton'.$listdata->id.'">Open</a></td>';
                    echo '<td>Pending</td>';
                    
                     } elseif($listdata->status == 'Open') {
                    
                   echo '<td><a class="btn btn-danger msgstatus"   data-id="'.$listdata->id.'" data-status="Close" id="obutton'.$listdata->id.'">Close</a></td>';
                    echo '<td><a class="btn btn-primary"   href="msgdetail.php?mid='.$listdata->id.'">Details</a></td>';
                     }else{
                     echo '<td><span style="color:red;">Closed</span></td>';
                    echo '<td><a class="btn btn-primary"   href="msgdetail.php?mid='.$listdata->id.'">Details</a></td>';
                     } 	
                     
                echo '</td> </tr>  ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval,$statusval){
      $makequery="select 	* from 	user_help_support as h inner join users as u on(h.name = u.username)";
    if($searchval != ''){ $makequery .=" and  h.`name` like '$searchval%'"; }
    if($statusval != ''){ $makequery .=" and  h.`status` = '$statusval'"; }
     $makequery .= " ORDER BY h.id desc";
	$query=mysqli_query ($sql,$makequery);
	
     $num=mysqli_num_rows($query);
     
     return $num;
	
}

?>
