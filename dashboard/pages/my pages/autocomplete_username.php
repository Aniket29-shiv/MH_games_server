<?php
include 'config.php';
	$keyword = strval($_POST['query']);
	$search_param = "{$keyword}%";

	$sql = mysqli_query($conn,"SELECT * FROM users WHERE username LIKE '%$search_param%'");
	
	if (mysqli_num_rows($sql) > 0) {
		while($row = mysqli_fetch_assoc($sql)) {
		$countryResult[] = $row["username"];
		}
		echo json_encode($countryResult);
	}
	$conn->close();
?>

