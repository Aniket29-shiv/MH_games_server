<?php

$message='';
$eid='';
$title='';
$subject='';
$emessage='';
$shortdescription='';

if(isset($_GET['did'])){
    $did=$_GET['did'];
    mysqli_query ($conn,"update `sms-template` set deleted=1 where id='$did'");
    echo '<script>alert("Deleted Successfully")</script>';
    echo '<script>window.location.href="sms-template.php"</script>';
}


if(isset($_GET['eid'])){
    
    $eid=$_GET['eid'];
    $makequery="select * from `sms-template` where id = '$eid'";
	$query=mysqli_query ($conn,$makequery);
    $listdata=mysqli_fetch_object($query);
    $title=$listdata->title;
  
    $emessage=$listdata->message;
   

}



if(isset($_POST['btnSubmit'])){
    
        $eid=$_POST['eid'];
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $emessage=$_POST['emessage'];
        $cdate=date('Y-m-d H:i:s');
       
        
        $reg=0;
        
        if($title == ''){$reg=1;$message="Title Required";}
        if($emessage == ''){$reg=1; $message="Message Required";}

       
       
          if($reg == 0){
          
             if($eid == ''){
                $makequery="INSERT INTO `sms-template`(`title`,  `message`) VALUES ('$title','$emessage')";
                	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="sms-template.php?status=1"</script>';
             }else{
                 $makequery="UPDATE `sms-template` SET `title`='$title',`message`='$emessage' where id='$eid'";
                	mysqli_query ($conn,$makequery);
            	echo '<script>window.location.href="sms-template.php?status=2"</script>';
             
             }
             
          }else{
               
               return false;
          }
      
							
}



  
    $start = 0;
    $pagenum = 1;

if(isset($_GET['page'])) {
	$start =($_GET['page'] - 1) * 25;
	$pagenum = $_GET['page'];
}


function totalpages($limit,$sql) {



    $makequery="select * from `sms-template`  where `deleted`!=1";
    $query1=mysqli_query($sql,$makequery);

	$listdata = mysqli_num_rows($query1);

	$total_pages = ceil($listdata / $limit);

	return $total_pages;


}



$tpages = totalpages(25,$conn);
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
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "\">" . $prevlabel . "</a>\n</li>";
    } else {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page - 1) . "\">" . $prevlabel . "</a>\n</li>";
    }

	if ($page >= 4) {
        $out.= "<li><a href=\"" . $reload . "&amp;page=1&amp;page=1\">1 ..</a>\n</li>";
    }

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out.= "<li  class='page-item active'><a class='page-link' href=''>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "\">" . $i . "</a>\n</li>";
        } else {
            $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n</li>";
        }
    }

    if ($page < ($tpages - $adjacents)) {
        $out.= "<li><a class='page-link' href=\"" . $reload . "&amp;page=" . $tpages . "\">.. " . $tpages . "</a>\n</li>";
    }
    // next
    if ($page < $tpages) {
        $out.= "<li class='page-item'><a class='page-link' href=\"" . $reload . "&amp;page=" . ($page + 1) . "\">" . $nextlabel . "</a>\n</li>";
    } else {
        $out.= "<li><span style='color:#ccc'>" . $nextlabel . "</span>\n</li>";
    }
    $out.= "";
    return $out;

}


function listpromotions($sql,$start,$limit){



    $makequery="select * from `sms-template`  where `deleted`!=1 ";
    $makequery .= " ORDER BY id desc LIMIT $start,$limit";


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
                        <td>'.$listdata->title.'</td>
                        <td>'.$listdata->message.'</td>';
                       
                       echo '<td><a href="?eid='.$listdata->id.'"><i class="fa fa-edit"></i></a></td>';
                    echo '<td><a onclick="return confirm(';
                    echo "'Are you sure you want to delete'";
                    echo ')" href="?did='.$listdata->id.'"><i class="fa fa-times"></i></a></td>';

                    echo '</tr> ';
    	    $x++;

    	}
    }

}



function numberofdata($sql){

      $makequery="select * from `sms-template`  where `deleted`!=1";

	$query=mysqli_query ($sql,$makequery);

     $num=mysqli_num_rows($query);

     return $num;

}


?>
