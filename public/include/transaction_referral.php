<?php

    $game='';
    $from1='';
    $from='';
    $to='';
    $to1='';
    $chiptype='real';
    $status='';
    $losscommi=0;
    $wincommi=0;
    $refid =  $_SESSION['user_id'];
   
    if(isset($_GET['game'])){ $game=$_GET['game'];}
   if(isset($_GET['status'])){ $status=$_GET['status'];}
    if(isset($_GET['from'])){
        
        $from1=$_GET['from'];
        if($from1 != ''){ $from=date('Y-m-d',strtotime($from1));}
        
    }
     if(isset($_GET['to'])){ 
         
         $to1=$_GET['to'];
         if($to1 != ''){ $to=date('Y-m-d',strtotime($to1));}
         
     }
   
    $getquery="SELECT * FROM `referal_commission` where userid='$refid'";
    $get=mysqli_query($conn,$getquery); 
    if(mysqli_num_rows($get) > 0){
    
    $listdata1=mysqli_fetch_object($get);
    $losscommi=$listdata1->commission;
    $wincommi=$listdata1->wincommission;
    
    }else{
    $getquery="SELECT * FROM `referal_commission` where userid=0";
    $get=mysqli_query($conn,$getquery); 
    $listdata1=mysqli_fetch_object($get);
    $losscommi=$listdata1->commission;
    $wincommi=$listdata1->wincommission;
    }
   
   


    $start = 0;
    $pagenum = 1;
  
if(isset($_GET['page'])) {
	$start =($_GET['page'] - 1) * 25;
	$pagenum = $_GET['page'];
} 


function totalpages($limit,$sql,$game,$from,$to,$status,$refid) {

   $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g 
    left join users as u on u.user_id=g.user_id
    where  `chip_type`='real' and u.referral_code ='$refid' ";
   
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date` DESC";
    
    
    $query1=mysqli_query($sql,$makequery);
    
	
	$listdata = mysqli_num_rows($query1);
	
	$total_pages = ceil($listdata / $limit);
	
	return $total_pages;
	
	
}



$tpages = totalpages(25,$conn,$game,$from,$to,$status,$refid);
$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages;

function paginate($reload, $page, $tpages,$game,$from,$to,$status,$refid) {
    
    $adjacents = 2;
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $out = "";
    // previous
   if ($page == 1) {
        $out.= "<li><span>" . $prevlabel . "</span>\n</li>";
    } elseif ($page == 2) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;refid=" . $refid . "&amp;game=" . $game . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;status=" . $status . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "&amp;refid=" . $refid . "&amp;game=" . $game . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;status=" . $status . "\">" . $prevlabel . "</a>\n</li>";
    }
	
	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;refid=" . $refid . "&amp;game=" . $game . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;status=" . $status . "&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;refid=" . $refid . "&amp;game=" . $game . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;status=" . $status . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "&amp;refid=" . $refid . "&amp;game=" . $game . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;status=" . $status . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "&amp;refid=" . $refid . "&amp;game=" . $game . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;status=" . $status . "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "&amp;refid=" . $refid . "&amp;game=" . $game . "&amp;from=" . $from . "&amp;to=" . $to . "&amp;status=" . $status . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;
    
}


function listpromotions($sql,$game,$from,$to,$status,$refid,$losscommi,$wincommi) {

    $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g 
    left join users as u on u.user_id=g.user_id
    where  `chip_type`='real' and u.referral_code ='$refid' ";
   
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC";
  // echo $makequery;
    
	$query=mysqli_query ($sql,$makequery);
	
        
    if(mysqli_num_rows(	$query) > 0){   
        
       
        
            
    	while($listdata=mysqli_fetch_object($query)){
    	    
                 
                    echo '<tr>
                   <td>'.$listdata->transaction_date.'</td>
                    <td>'.$listdata->round_no.'</td> 
                    <td>'.$listdata->table_name.'</td>
                    <td>'.$listdata->player_name.'</td> 
                    <td>'.$listdata->game_type.'</td> 
                    <td>'.$listdata->status.'</td> 
                    <td>'.number_format($listdata->amount,2).'</td> 
                     ';
                    if($listdata->status == 'Lost'){
                     echo  '<td>'.number_format(($listdata->amount*($losscommi/100)),4).'</td> ';
                    }
                    if($listdata->status == 'Won'){
                         echo  '<td>'.number_format(($listdata->amount*($wincommi/100)),4).'</td> ';
                    }
                        
                    
                    echo '</tr>  ';
                   
    	    
    	}
    }
	
}



function numberofdata($sql,$game,$from,$to,$status,$refid) {

    $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g 
    left join users as u on u.user_id=g.user_id
    where  `chip_type`='real' and u.referral_code ='$refid' ";
   
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC";
        
        $query=mysqli_query ($sql,$makequery);
        
        $num=mysqli_num_rows($query);
        
        return $num;
	
}

function losscomm($sql,$game,$from,$to,$status,$refid,$losscommi) {

  $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g 
    left join users as u on u.user_id=g.user_id
    where  `chip_type`='real' and u.referral_code ='$refid'and g.status='Lost' ";
   
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC";
        //echo $makequery;
        $query=mysqli_query ($sql,$makequery);
        $lossamountcommi=0;
      	while($listdata=mysqli_fetch_object($query)){
                
                  $losscom= $listdata->amount*($losscommi/100);
                      
    	     $lossamountcommi= $lossamountcommi+$losscom;
    	}
    	
    	return $lossamountcommi;
	
}


function wincomm($sql,$game,$from,$to,$status,$refid,$wincommi) {

    $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g 
    left join users as u on u.user_id=g.user_id
    where  `chip_type`='real' and u.referral_code ='$refid' and g.status='Won' ";
   
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    //if($status != ''){ $makequery .=" and g.`status`='$status'"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`  DESC";
        
        $query=mysqli_query ($sql,$makequery);
        $winamountcommi=0;
      	while($listdata=mysqli_fetch_object($query)){
      	    
      	   
             $wincom= $listdata->amount*($wincommi/100);
             //echo $wincom.'<br />';
             $winamountcommi= $winamountcommi+$wincom;
    	}
    	
    	return $winamountcommi;
	
}



  function userlist($conn){
            $getquery="SELECT `user_id`, `username` FROM `users`  order by username asc";
            //echo $getquery;
              $get=mysqli_query($conn,$getquery);
               while($listdata=mysqli_fetch_object($get)){
               echo '<option value="'.$listdata->user_id.'">'.$listdata->username.'</option>';
               }
            
        
        }
?>
