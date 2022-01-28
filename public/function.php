<?php


function getgatewaydetail($conn,$colm,$id){
    
   
     $sql = "SELECT $colm FROM payment_gateway where id=1";
    $result = $conn->query($sql);
   $row = $result->fetch_assoc();
   $play_chips = $row[$colm];
      
    return $play_chips;

}

?>