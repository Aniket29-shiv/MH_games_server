<?php

include 'config.php';

	$results = array();
    $current_date = date('Y/m/d H:i:s');

    $result_coupon_check = $connect->query("SELECT * FROM `coupons` where deleted='0' AND  DATE(valid_from) <= '".$current_date."' AND DATE(valid_to) >= '".$current_date."'");
	if($result_coupon_check->num_rows > 0 )
	{ 
	    while($row = $result_coupon_check->fetch_assoc())
    	{
			$results[] = array(
			'id' => $row['id'],
			'title' => $row['title'],
			'coupon' => $row['coupon'],
			'valid_from' => $row['valid_from'],
			'valid_to' => $row['valid_to'],
			'discount_type' => $row['discount_type'],
			'discount_val' => $row['discount_val'],
			'maxprice' => $row['maxprice']
			);
    	}
    	
    	echo json_encode(array('response' => 'true','message' => 'Coupon code exist','coupon_details' => $results));
	}
	else
	{
	    echo json_encode(array('response' => 'false','message' => 'This coupon code does not exist','coupon_details' => $results));
	}

	$conn->close();
?>