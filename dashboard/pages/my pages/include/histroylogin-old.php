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
        
    //	$num=0;
    	// $query1=mysqli_query($sql,'SELECT DISTINCT username FROM `login_history`');
    //	while($listdata1=mysqli_fetch_object($query1)){	 
    	    
           // $username=$listdata1->username;
            $makequery="select l.*,us.first_name,us.last_name  from login_history l  LEFT JOIN users us ON us.user_id=l.userid where  1=1";
            if($searchval != ''){ $makequery .=" and  (us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%'  or l.`email` like '$searchval%' or l.`username` like '$searchval%')"; }
            if($from != ''){ $makequery .=" and  l.logindate >= '$from 00:00:00'"; }
            if($to != ''){ $makequery .=" and  l.logindate <= '$to 23:59:59'"; }
           // $makequery .=" order by id desc";
           // echo  $makequery;
            $query1=mysqli_query($sql,$makequery);
           $num= mysqli_num_rows($query1);
            
          //  if(mysqli_num_rows($query1) > 0){$num++;}
            
    	//}
        
        
    	
    	$total_pages = ceil($num / $limit);
    	
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
    
    //$query1=mysqli_query($sql,'SELECT DISTINCT username FROM `login_history` LIMIT $start,$limit');
      if($start == 0){
          $x=1;
        }else{
          $x=$start+1;
        }
    
    //while($listdata1=mysqli_fetch_object($query1)){	 
    
            $username=$listdata1->username;  
            
            $makequery="select l.*,us.first_name,us.last_name  from login_history as l  LEFT JOIN users us ON us.user_id=l.userid where  1=1";
            
            if($searchval != ''){ $makequery .=" and  (us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%'  or l.`email` like '$searchval%' or l.`username` like '$searchval%')"; }
            if($from != ''){ $makequery .=" and  l.logindate >= '$from 00:00:00'"; }
            if($to != ''){ $makequery .=" and  l.logindate <= '$to 23:59:59'"; }
             $makequery .=" order by id desc LIMIT $start,$limit";
            
            
           //echo $makequery;
            
        	$query=mysqli_query ($sql,$makequery);
	
      
             if(mysqli_num_rows($query) > 0){     
                    
                   while( $listdata=mysqli_fetch_object($query)){
                    
                        echo '	<tr> 
                        <td>'.$x.'</td>
                        <td>'.$listdata->first_name.' '.$listdata->last_name.'</td>
                        <td>'.$listdata->email.'</td>
                        <td>'.$listdata->username.'</td>
                        <td>'.$listdata->ip.'</td>
                        <td>'.$listdata->city.'</td>
                        <td>'.$listdata->region.'</td>
                        <td>'.$listdata->county.'</td>
                        <td>'.$listdata->status.'</td>
                        <td>'.$listdata->logindate.'</td>
                        <td>'.$listdata->logouttime.'</td>
                        
                        </tr> ';
                        
                        $x++;
                   } 
            	
              }
   // }
	
}



function numberofdata($sql,$searchval,$from,$to){
    
    
     $makequery="select l.*,us.first_name,us.last_name  from login_history as l  LEFT JOIN users us ON us.user_id=l.userid where  1=1";
            
            if($searchval != ''){ $makequery .=" and  (us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%'  or l.`email` like '$searchval%' or l.`username` like '$searchval%')"; }
            if($from != ''){ $makequery .=" and  l.logindate >= '$from 00:00:00'"; }
            if($to != ''){ $makequery .=" and  l.logindate <= '$to 23:59:59'"; }
             $makequery .=" order by id desc";
            $query=mysqli_query ($sql,$makequery);
	
      
           $num=  mysqli_num_rows($query);
           return $num;
            
   /* $num=0;
       $query1=mysqli_query($sql,'SELECT DISTINCT username FROM `login_history` LIMIT $start,$limit');
      if($start == 0){
          $x=1;
        }else{
          $x=$start+1;
        }
    
    while($listdata1=mysqli_fetch_object($query1)){	 
    
            $username=$listdata1->username;  
            
            $makequery="select l.*,us.first_name,us.last_name  from login_history as l  LEFT JOIN users us ON us.user_id=l.userid where  l.username='$username'";
            
            if($searchval != ''){ $makequery .=" and  (us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%'  or l.`email` like '$searchval%' or l.`username` like '$searchval%')"; }
            if($from != ''){ $makequery .=" and  l.logindate >= '$from 00:00:00'"; }
            if($to != ''){ $makequery .=" and  l.logindate <= '$to 23:59:59'"; }
            $makequery .=" order by id desc limit 1";
            
            
           //echo $makequery;
            
        	$query=mysqli_query ($sql,$makequery);
	
      
             if(mysqli_num_rows($query) > 0){ 
                 $num++;
             }
    }
        
        return $num;*/
	
}

?>
