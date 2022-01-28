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
	

    $makequery="SELECT u.id FROM `notifications` as e 
left join `users` as u on u.username=e.username where 1= 1";
    if($searchval != ''){ $makequery .=" and e.send_type='$searchval'"; }
    $makequery .= " ORDER BY e.created_date desc";
    
     
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
    
        
  $makequery="SELECT e.*,u.username FROM `notifications` as e 
left join `users` as u on u.username=e.username where  1= 1";
    if($searchval != ''){ $makequery .=" and e.send_type='$searchval'"; }
   
    $makequery .= " ORDER BY e.created_date desc LIMIT $start,$limit";
    
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
                        <td>'.$listdata->send_type.'</td> 
                        <td>'.date('d-m-Y H:i:s',strtotime($listdata->created_date)).'</td> 
                        <td>'.$listdata->name.'</td> 
                        <td>'.$listdata->username.'</td> 
                        <td>'.$listdata->title.'</td> 
                        <td>'.$listdata->description.'</td> 
                        <td>'.$listdata->status.'</td>';
                       if($listdata->is_read == 1){ 
                           echo '<td><span style="color:green;">Read</span></td>';
                           echo '<td>'.$listdata->read_count.'</td>';
                           
                       }else{ 
                           echo '<td><span style="color:red;">Pending</span></td>';
                           echo '<td><span style="color:red;">Pending</span></td>';
                           
                       } 
                        echo '</tr> ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval){
    
      $makequery="SELECT u.name FROM `notifications` as e 
left join `users` as u on u.username=e.username where  1= 1";
    if($searchval != ''){ $makequery .=" and e.send_type='$searchval'"; }
   
    $makequery .= " ORDER BY e.created_date desc";
	$query=mysqli_query ($sql,$makequery);
	
     $num=mysqli_num_rows($query);
     
     return $num;
	
}

?>
