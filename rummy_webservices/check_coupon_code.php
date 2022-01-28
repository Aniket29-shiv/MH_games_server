<?php

error_reporting(0);
include 'config.php';

$couponCode = $_GET['couponCode'];
$userId = $_GET['userId'];

	$results = array();


    $result_coupon_check = $connect->query("SELECT * FROM `coupons` where coupon='".$couponCode."' AND `deleted` = '0'");
    //echo "SELECT * FROM `coupons` where coupon='".$couponCode."' AND `deleted` = '0'";
	if($result_coupon_check->num_rows > 0 )
	{ 
        $row = $result_coupon_check->fetch_assoc();
        
        $reusable = $row['reusable'];
        
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
        
        if ($reusable == 0)
        {
            $sql1 = "SELECT id FROM `coupon_used_by_player` WHERE  `couponcode` = '".$couponCode."' and `user_id`='".$userId."' and `status` ='SUCCESS'";
            $result1 = $connect->query($sql1);
        
            if ($result1->num_rows > 0)
            {
                echo json_encode(array('response' => 'false','message' => 'This coupon code is already used'));
            }
            else
            {
                echo json_encode(array('response' => 'true','message' => 'Coupon code exist','coupon_details' => $results));
            }
        }
        else
        {
            echo json_encode(array('response' => 'true','message' => 'Coupon code exist','coupon_details' => $results));
        }
	}
	else
	{
	    echo json_encode(array('response' => 'false','message' => 'This coupon code is invalid'));
	}

	$connect->close();
?>