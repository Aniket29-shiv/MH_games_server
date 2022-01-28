<?php
error_reporting(0);
include 'config.php';
//$myObj = new \stdClass();
$final_array = []; 

        $page = $_GET['page'];
		$userId = $_GET['user_id'];
		$limit = 50;
		
		//Counting the total item available in the database 
$total = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM fund_added_to_player where user_id = '".$userId."'"));

//We can go atmost to page number total/limit
$page_limit = $total/$limit; 

    //Calculating start for every given page number 
    $start = ($page - 1) * $limit;

		$sql = "SELECT * FROM fund_added_to_player where user_id = '".$userId."' ORDER BY id DESC limit $start, $limit";
		$result = $connect->query($sql);
		
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc())
			{
				 $final_array []= [
									"id" => $row['id'],
									"amount" => $row['amount'],
									"created_date" => $row['created_date'],
									"chip_type" => $row['chip_type'],
									"transaction_id" => $row['transaction_id'],
									"payment_mode" => $row['payment_mode'],
									"amount" => $row['amount'],
									"order_id" => $row['order_id'],
									"status" =>$row['status']
								  ];
			}//while
			$j = json_encode($final_array, JSON_HEX_QUOT);
			//echo $j;
			echo json_encode(array('status'=>"success",'cash_transaction_details'=>$final_array,'message'=>"Record found",'total_record'=>$total));
		
		}
		else
		{
			 $final_array []= ["record_status" => "No Records Found."];
			//echo json_encode($final_array);
			echo json_encode(array('status' => "false",'message'=>"No record found",'total_record'=>$total));
		}
//echo json_encode($myObj);

$connect->close();
?>