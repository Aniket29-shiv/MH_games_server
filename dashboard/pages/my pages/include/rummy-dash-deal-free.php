<?php

    $joker='';
    $players='';
    $bet='';
    $status='';
    
    
    if(isset($_GET['joker'])){ $joker=$_GET['joker'];}
    if(isset($_GET['players'])){ $players=$_GET['players'];}
    if(isset($_GET['bet'])){ $bet=$_GET['bet'];}
    if(isset($_GET['status'])){ $status=$_GET['status'];}


    $start = 0;
    $pagenum = 1;
  
if(isset($_GET['page'])) {
	$start =($_GET['page'] - 1) * 10;
	$pagenum = $_GET['page'];
} 


function totalpages($limit,$sql,$joker,$players,$bet,$status) {
	
	
    $makequery="select * from player_table where game='Free Game' AND game_type='Deal Rummy' ";
    if($joker != ''){ $makequery .=" and `joker_type`='$joker'"; }
    if($players != ''){ $makequery .=" and `player_capacity`='$players'"; }
    if($bet != ''){ 
          
            if($bet == 'low'){   $makequery .= " and `min_entry` <= 100";}
            if($bet == 'medium'){   $makequery .= " and `min_entry` >= 101 and `min_entry` <= 1000";}
            if($bet == 'high'){   $makequery .= " and `min_entry` >= 1001";}
            
            
    }
    if($status != ''){ $makequery .=" and `table_status`='$status'"; }
    
    $makequery .= " ORDER BY table_id DESC";
    $query1=mysqli_query($sql,$makequery);
	
	$listdata = mysqli_num_rows($query1);
	
	$total_pages = ceil($listdata / $limit);
	
	return $total_pages;
	
	
}



$tpages = totalpages(10,$conn,$joker,$players,$bet,$status);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages,$joker,$players,$bet,$status) {
    
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
   if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;joker=" . $joker . "&amp;players=" . $players . "&amp;bet=" . $bet. "&amp;status=" . $status. "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "&amp;joker=" . $joker . "&amp;players=" . $players . "&amp;bet=" . $bet. "&amp;status=" . $status. "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;joker=" . $joker . "&amp;players=" . $players . "&amp;bet=" . $bet. "&amp;status=" . $status. "&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;joker=" . $joker . "&amp;players=" . $players . "&amp;bet=" . $bet. "&amp;status=" . $status. "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "&amp;joker=" . $joker . "&amp;players=" . $players . "&amp;bet=" . $bet. "&amp;status=" . $status. "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "&amp;joker=" . $joker . "&amp;players=" . $players . "&amp;bet=" . $bet. "&amp;status=" . $status. "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "&amp;joker=" . $joker . "&amp;players=" . $players . "&amp;bet=" . $bet. "&amp;status=" . $status. "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$start,$limit,$joker,$players,$bet,$status){
    
    $makequery="select * from player_table where game='Free Game' AND game_type='Deal Rummy' ";
    if($joker != ''){ $makequery .=" and `joker_type`='$joker'"; }
    if($players != ''){ $makequery .=" and `player_capacity`='$players'"; }
    if($bet != ''){ 
          
            if($bet == 'low'){   $makequery .= " and `min_entry` <= 100";}
            if($bet == 'medium'){   $makequery .= " and `min_entry` >= 101 and `min_entry` <= 1000";}
            if($bet == 'high'){   $makequery .= " and `min_entry` >= 1001";}
            
            
    }
    if($status != ''){ $makequery .=" and `table_status`='$status'"; }
    $makequery .= " ORDER BY table_id DESC LIMIT $start,$limit";
    
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
                <td>'.$listdata->table_name.'</td>
                <td>'.$listdata->joker_type.'</td>
                <td>'.$listdata->point_value.'</td>
                <td>'.$listdata->min_entry.'</td>
                <td>'.$listdata->status.'</td>
                <td>'.$listdata->player_capacity.'</td>  
                ';
                
                if($listdata->table_status == 'S'){
                    
                    echo '<td><a class="btn btn-success statusl" data-id="'.$listdata->table_id.'" id="live'.$listdata->table_id.'">LIVE</a> 
                    <a class="btn btn-danger statuss" data-id="'.$listdata->table_id.'" style="display:none;" id="stop'.$listdata->table_id.'">Stop</a></td>';
                    
                }else{
                    
                    echo '<td><a class="btn btn-danger statuss" data-id="'.$listdata->table_id.'" id="stop'.$listdata->table_id.'">Stop</a> 
                    <a class="btn btn-success statusl" data-id="'.$listdata->table_id.'" style="display:none;" id="live'.$listdata->table_id.'">Live</a></td>';
                    
                }
                  echo '<td><a onclick="return confirm(';
		echo "'Are you sure you want to delete?'";
		echo ')" href="?did='.$listdata->table_id.'"><i class="glyphicon glyphicon-trash" title="Delete" aria-hidden="true"></i></a></td>';  
               /* if($listdata->table_status=='S'){ 
                    
                echo '<a href="#"> <button class="btn btn-default">Stop</button></a> <a href="table_action.php?live='.$listdata->table_id.'&page=dash-point-free-rummy.php"><button class="btn btn-success">Live</button> </a>';
                
                }else{ 
                    
                echo '<a href="table_action.php?stop='.$listdata->table_id.'&page=dash-point-free-rummy.php"> <button class="btn btn-danger">Stop</button></a><a href="#"><button class="btn btn-default">Live</button></a>';
                
                 } */
                 
               echo '</tr> ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$joker,$players,$bet,$status){
    
    $makequery="select * from player_table where game='Free Game' AND game_type='Deal Rummy' ";
    if($joker != ''){ $makequery .=" and `joker_type`='$joker'"; }
    if($players != ''){ $makequery .=" and `player_capacity`='$players'"; }
    if($bet != ''){ 
          
            if($bet == 'low'){   $makequery .= " and `min_entry` <= 100";}
            if($bet == 'medium'){   $makequery .= " and `min_entry` >= 101 and `min_entry` <= 1000";}
            if($bet == 'high'){   $makequery .= " and `min_entry` >= 1001";}
            
            
    }
    if($status != ''){ $makequery .=" and `table_status`='$status'"; }
    $makequery .= " ORDER BY table_id DESC";
    
	$query=mysqli_query ($sql,$makequery);
	
     $num=mysqli_num_rows($query);
     
     return $num;
	
}
//=====Delete==============
    if(isset($_GET['did'])){
        $did=$_GET['did'];
        if($did != ''){
         $query=mysqli_query ($conn,"DELETE FROM `player_table` WHERE table_id='$did'");
         echo '<script>alert("Table  Deleted Successfully");</script>';
          echo '<script>window.location.href="dash-deal-free-rummy.php"</script>';
        }
    }
?>
