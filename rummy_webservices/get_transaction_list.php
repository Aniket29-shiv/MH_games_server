<?php
error_reporting(0);
include 'config.php';
//$myObj = new \stdClass();
$final_array = []; 

        $page = $_GET['page'];
		$name = $_GET['name'];
		$limit = 50;
		
		//Counting the total item available in the database 
$total = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM game_transactions where player_name = '".$name."'"));

//We can go atmost to page number total/limit
$page_limit = $total/$limit; 

    //Calculating start for every given page number 
    $start = ($page - 1) * $limit;

		$sql = "SELECT * FROM game_transactions where player_name = '".$name."' ORDER BY id DESC limit $start, $limit";
		$result = $connect->query($sql);
		
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc())
			{
				 $final_array []= [
									"id" => $row['id'],
									"game_transaction_id" => $row['game_transaction_id'],
									"game_type" => $row['game_type'],
									"table_id" => $row['table_id'],
									"table_name" => $row['table_name'],
									"round_no" => $row['round_no'],
									"status" => $row['status'],
									"amount" => $row['amount'],
									"transaction_date" => $row['transaction_date'],
									"record_status" =>""
								  ];
			}//while
			$j = json_encode($final_array, JSON_HEX_QUOT);
			//echo $j;
			echo json_encode(array('status'=>"success",'game_transaction_details'=>$final_array,'message'=>"Record found",'total_record'=>$total));
		
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