<?php

    $searchval='';
   $from1='';
    $from='';
    $to='';
    $to1='';
    
    
    if(isset($_GET['searchval'])){ $searchval=trim($_GET['searchval']);}
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
	
	
    $makequery="select users.`user_id`,users.`created_date`, users.`first_name`, users.`last_name`, users.`mobile_no`, users.`email` , users.`username`, accounts.play_chips, accounts.real_chips from users LEFT JOIN accounts ON users.user_id=accounts.userid where 1=1";
      if($searchval != ''){ $makequery .=" and  (users.`username` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%')"; }
      if($from != ''){ $makequery .=" and  users.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  users.`created_date` <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY user_id desc";
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
    
        
    //$makequery="select users.`user_id`,users.`created_date`, users.`first_name`, users.`last_name`, users.`mobile_no`, users.`email` , users.`username`, accounts.play_chips, accounts.real_chips from users LEFT JOIN accounts ON users.user_id=accounts.userid where 1=1";
    $makequery="select users.`user_id`,users.`created_date`, users.`first_name`, users.`last_name`,users.login_status, users.`mobile_no`, users.`email` , users.`username`, accounts.play_chips, accounts.real_chips from users LEFT JOIN accounts ON users.user_id=accounts.userid where 1=1";
      if($searchval != ''){ $makequery .=" and  (users.`username` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%')"; }
      if($from != ''){ $makequery .=" and  users.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  users.`created_date` <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY user_id desc LIMIT $start,$limit";
    
    
   // echo $makequery;
    
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
                        
                        <td>'.$listdata->created_date.'</td> 
                        <td>'.$listdata->first_name.' '.$listdata->last_name.'</td> 
                        <td>'.$listdata->mobile_no.'</td> 
                        <td>'.$listdata->email.'</td> 
                        <td>'.$listdata->username.'</td> 
                        <td>'.$listdata->play_chips.'</td> 
                        <td>'.$listdata->real_chips.'</td> 
                        <td>
                        <a href="editplayer.php?eid='.$listdata->user_id.'" id="edit_row_'.$listdata->user_id.'"><i class="glyphicon glyphicon-edit" title="Edit"  aria-hidden="true"></i></a>&nbsp 
                        <a href="#" id="save_row_'.$listdata->user_id.'" style="display:none"><i class="glyphicon glyphicon-save" title="Save"  aria-hidden="true"></i></a>&nbsp 
                        </td>';
                         echo '<td><a onclick="return confirm(';
		echo "'Are you sure you want to delete? If onece you delete user then all records perment deleted.'";
		echo ')" href="?did='.$listdata->user_id.'"><i class="glyphicon glyphicon-trash" title="Delete" aria-hidden="true"></i></a></td>';   
		if($listdata->login_status == 0){
		  echo '<td><a data-id="'.$listdata->user_id.'" class="btn btn-danger lstatus">Block</a></td>';  
		}else{
		    echo '<td><a data-id="'.$listdata->user_id.'" class="btn btn-success lstatus">UnBlock</a></td>';  
		}
		
                        echo '</tr> ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval,$from,$to){
    
     $makequery="select users.`user_id`,users.`created_date`, users.`first_name`, users.`last_name`, users.`mobile_no`, users.`email` , users.`username`, accounts.play_chips, accounts.real_chips from users LEFT JOIN accounts ON users.user_id=accounts.userid where 1=1";
      if($searchval != ''){ $makequery .=" and  (users.`username` like '$searchval%' or users.`mobile_no` like '$searchval%' or users.`email` like '$searchval%')"; }
      if($from != ''){ $makequery .=" and  users.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  users.`created_date` <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY user_id desc";

	$query=mysqli_query ($sql,$makequery);
	
     $num=mysqli_num_rows($query);
     
     return $num;
	
}



//===============================Delete USer============================
if(isset($_GET['did'])){
    $did=$_GET['did'];
    if($did != ''){
    mysqli_query ($conn,"DELETE FROM `users` WHERE user_id='$did'");
    mysqli_query ($conn,"DELETE FROM `accounts` WHERE userid='$did'");
    mysqli_query ($conn,"DELETE FROM `user_kyc_details` WHERE userid='$did'");
    echo '<script>alert("User  Deleted Successfully");</script>';
    echo '<script>window.location.href="player-details.php"</script>';
        
    }

}
?>
