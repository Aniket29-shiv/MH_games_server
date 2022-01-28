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
	
	
    $makequery="SELECT 
							kd.*, kd.id as kycid,
							u.username, 
						u.first_name,u.middle_name,u.last_name, 
							u.mobile_no AS mobile_no, 
							u.email AS email
							
						
					from 
							users as u
							INNER JOIN user_kyc_details AS kd ON (kd.userid = u.user_id) ";
    if($searchval != ''){ $makequery .=" where  ( u.`first_name` like '$searchval%' or  u.`last_name` like '$searchval%' or  u.`mobile_no` like '$searchval%' or  u.`email` like '$searchval%' or  u.`username` like '$searchval%')"; }
      if($from != ''){ $makequery .=" and  kd.`updated_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`updated_date` <= '$to 23:59:59'"; }
     $makequery .= " ORDER BY kd.updated_date  desc ";
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
    
        
  	
    $makequery="SELECT 
							kd.*, kd.id as kycid,
							u.username, 
						u.first_name,u.middle_name,u.last_name, 
							u.mobile_no AS mobile_no, 
							u.email AS email
							
						
					from 
							users as u
							INNER JOIN user_kyc_details AS kd ON (kd.userid = u.user_id) ";
    if($searchval != ''){ $makequery .=" where  ( u.`first_name` like '$searchval%' or  u.`last_name` like '$searchval%' or  u.`mobile_no` like '$searchval%' or  u.`email` like '$searchval%' or  u.`username` like '$searchval%')"; }
    if($from != ''){ $makequery .=" and  kd.`updated_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`updated_date` <= '$to 23:59:59'"; }
     $makequery .= " ORDER BY kd.updated_date  desc LIMIT $start,$limit";
   
    
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
                         <td>'.$listdata->updated_date.'</td> 
                        <td>'.$listdata->first_name.' '.$listdata->middle_name.' '.$listdata->last_name.'</td>
                        <td>'.$listdata->username.'</td>';
                        
                        if($listdata->email_status == 'Verified'){ echo '<td><span style="color:blue;">'.$listdata->email.'</span></td>';  }else{  echo '<td><span style="color:red;">'.$listdata->email.'</span></td>';  } 
                        if($listdata->mobile_status == 'Verified'){ echo '<td><span style="color:blue;">'.$listdata->mobile_no.'</span></td>';  }else{  echo '<td><span style="color:red;">'.$listdata->mobile_no.'</span></td>';  } 
                        
                        if($listdata->id_proof_url == ''){
                            echo '<td><span style="color:red;">No File</span></td>'; 
                            echo '<td><span style="color:red;">No File</span></td>'; 
                        }else{
                            if($listdata->id_proof_status == 'Verified'){
                                
                           echo '<td><span style="color:red;"><a href="../../../my-account/'.$listdata->id_proof_url.'" download><button class="btn btn-primary btn-xs">Download</button></a></span></td>'; 
                           echo '<td><span style="color:blue;">Verified</span></td>'; 
                           
                         }else
                         {
                               echo '<td><a href="../../../my-account/'.$listdata->id_proof_url.'" download  ><button class="btn btn-primary btn-xs">Download</button></a>
                               </td>'; 
                           echo '<td><a class="btn btn-success idproofverify"  style="padding: 2px 8px;" id="idproof'.$listdata->kycid.'" data-id="'.$listdata->kycid.'">Verify</a> <span id="idproofv'.$listdata->kycid.'" style="color:blue; display:none;">Verified</span></td>'; 
                         }
                         
                        }
                        
                         
                        
                        
                        if($listdata->pan_card_url == ''){
                            echo '<td><span style="color:red;">No File</span></td>'; 
                            echo '<td><span style="color:red;">No File</span></td>'; 
                        }else{
                   
                         if($listdata->pan_status == 'Verified'){
                           echo '<td><span style="color:red;"><a href="../../../my-account/'.$listdata->pan_card_url.'" download><button class="btn btn-primary btn-xs">Download</button></a></span></td>'; 
                           echo '<td><span style="color:blue;">Verified</span></td>'; 
                         }else
                         {
                               echo '<td ><a href="../../../my-account/'.$listdata->pan_card_url.'" download><button class="btn btn-primary btn-xs">Download</button></a></td>'; 
                               echo '<td><a class="btn btn-success panproofverify" style="padding: 2px 8px;" id="panproof'.$listdata->kycid.'"  data-id="'.$listdata->kycid.'">Verify</a> <span id="panproofv'.$listdata->kycid.'" style="color:blue; display:none;">Verified</span></td>'; 
                         }
                        }
                       
                        echo '</tr> ';
    	    $x++;
    	    
    	}
    }
	
}



function numberofdata($sql,$searchval,$from,$to){
    
    $makequery="SELECT 
							kd.*, kd.id as kycid,
							u.username, 
						u.first_name,u.middle_name,u.last_name, 
							u.mobile_no AS mobile_no, 
							u.email AS email
							
						
					from 
							users as u
							INNER JOIN user_kyc_details AS kd ON (kd.userid = u.user_id) ";
    if($searchval != ''){ $makequery .=" where  ( u.`first_name` like '$searchval%' or  u.`last_name` like '$searchval%' or  u.`mobile_no` like '$searchval%' or  u.`email` like '$searchval%' or  u.`username` like '$searchval%')"; }
    if($from != ''){ $makequery .=" and  kd.`updated_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`updated_date` <= '$to 23:59:59'"; }
     $makequery .= " ORDER BY kd.updated_date  desc";
	$query=mysqli_query ($sql,$makequery);
	
     $num=mysqli_num_rows($query);
     
     return $num;
	
}

?>
