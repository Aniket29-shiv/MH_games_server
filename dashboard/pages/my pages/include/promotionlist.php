<?php

if(isset($_GET['did'])){
    $did=$_GET['did'];
    mysqli_query ($sql,"update `promotions` set deleted=1 where id='$did'");
    echo '<script>alert("Deleted Successfully")</script>';
    echo '<script>window.location.href="listpromotion.php"</script>';
}


 $start = 0;
$pagenum = 1;
  
if(isset($_GET['page'])) {
	$start =($_GET['page'] - 1) * 10;
	$pagenum = $_GET['page'];
} 


function totalpages($limit,$sql) {
	
	
    $makequery="select * from `promotions` where deleted != 1";
	$query1=mysqli_query($sql,$makequery);
	
	$listdata = mysqli_num_rows($query1);
	
	$total_pages = ceil($listdata / $limit);
	
	return $total_pages;
	
	
}



$tpages = totalpages(10,$conn);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages) {
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
    if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a  href=\"" . $reload . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a  href=\"" . $reload . "&amp;page=" . ($page - 1) . "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1\">1  ...</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if($i == $page) {
            $out.= "<li  class=\"page-item active\"><a href=''>" . $i . "</a></li>\n";
        } elseif($i == 1){
            $out.= "<li class='page-item'><a  href=\"" . $reload . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a  href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=" . $tpages . "\">...  " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a  href=\"" . $reload . "&amp;page=" . ($page + 1) . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$start,$limit){
    
    $makequery="select * from `promotions` where deleted != 1 LIMIT $start,$limit";
	$query=mysqli_query ($sql,$makequery);
	
        if($start == 0){
          $x=1;
        }else{
          $x=$start;
        }
        
	while($listdata=mysqli_fetch_object($query)){
            
            echo '<tr>
            <td>'.$x.'</td>
            <td>'.$listdata->title.'</td>
            <td><img src="../../../uploads/promotions/'.$listdata->simage.'"  style="width: 100px;" ></td>';
            if($listdata->status == 'S'){
            echo '<td><a class="btn btn-success statusl" data-id="'.$listdata->id.'" id="live'.$listdata->id.'">LIVE</a> <a class="btn btn-danger statuss" data-id="'.$listdata->id.'" style="display:none;" id="stop'.$listdata->id.'">Stop</a></td>';
            }else{
            echo '<td><a class="btn btn-danger statuss" data-id="'.$listdata->id.'" id="stop'.$listdata->id.'">Stop</a> <a class="btn btn-success statusl" data-id="'.$listdata->id.'" style="display:none;" id="live'.$listdata->id.'">Live</a></td>';
            }
           echo '<td><a href="addpromotion.php?eid='.$listdata->id.'" class="btn btn-primary">Edit</a></td>';
            echo '<td><a onclick="return confirm(';
            echo "'Are you sure you want to delete'";
            echo ')" href="?did='.$listdata->id.'"><i class="fa fa-times"></i></a></td>';    
            echo '</tr> ';
	    $x++;
	    
	}
	
}

?>
