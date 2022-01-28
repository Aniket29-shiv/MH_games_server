<?php

function totalrefcommission($conn) {
        $refid =  $_SESSION['user_id'];
        $makequery="SELECT g.amount,g.status FROM `game_transactions` as g 
        left join users as u on u.user_id=g.user_id
        where  `chip_type`='real' and u.referral_code ='$refid'  ORDER BY g.`transaction_date`  DESC";
        
        $query=mysqli_query ($conn,$makequery);
        $winamountcommi=0;
      	while($listdata=mysqli_fetch_object($query)){
      	    
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
                
                if($listdata->status == 'Lost'){
                  $winamountcommi=$winamountcommi+number_format(($listdata->amount*($losscommi/100)),4);
                }
                if($listdata->status == 'Won'){
                  $winamountcommi=$winamountcommi+number_format(($listdata->amount*($wincommi/100)),4);
                }
                
                
    	}
    	
    	return $winamountcommi;
	
}


function totalrefwithdrawal($conn) {
        $refid =  $_SESSION['user_id'];
        $makequery="SELECT SUM(requested_amount) as reqamounttotal FROM `withdraw_refcommission_request` where user_id='$refid'";
        
        $query=mysqli_query($conn,$makequery);
        
      	$listdata=mysqli_fetch_object($query);
      	  $amount=$listdata->reqamounttotal;
    //   	if($amount == ''){
    //   	    $amount= $amount;
    //     }else{
    //       $amount=0; 
          
    //     }
       return $amount;
	
}


function balancerefcommission($conn) {
      $totalcommission= totalrefcommission($conn);
      $totalwithdraw= totalrefwithdrawal($conn);	
      $balamount=$totalcommission-$totalwithdraw;
      return $balamount;
}
?>