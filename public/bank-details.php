<?php
	include 'database.php';
	session_start();
	if(!isset($_SESSION['logged_user'])) 
	{
	header("Location:sign-in.php");
	}
	else {
	$loggeduser =  $_SESSION['logged_user'];
	include 'database.php';

	$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc())
		{
			$play_chips = $row['play_chips'];
			$real_chips = $row['real_chips'];
				$fullname=	$row['first_name'] ." ".$row['last_name'];
		}
	}

 	$status = '';
	if($_GET){ 
	  $status = $_GET['status']; 
	}   
	$user_id = $_SESSION['user_id'];
	
	if(isset($_POST['btnSubmit'])){
		$pageData = $_POST;
		
		$sql = "SELECT bd.*,us.first_name,us.last_name FROM bank_details bd LEFT JOIN users us ON bd.user_id=us.user_id where bd.user_id = '".$user_id."'";  
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
			if($pageData['bank_name']!='' && $pageData['account_no']!=''&&$pageData['ifsc_code']!='')
			{ 
					$user_id = $_SESSION['user_id'];
					 
					$updated_on = date("Y-m-d H:i:s");
					$query_update = "update bank_details set bank_name='{$pageData['bank_name']}',account_no='{$pageData['account_no']}',ifsc_code='{$pageData['ifsc_code']}',updated_on='{$updated_on}' where user_id={$user_id} "; 
					$update_result = $conn->query($query_update);
						 
						if($update_result){
							header("Location:bank-details.php?status=1");
						}else{
							header("Location:bank-details.php?status=2");
						} 
			}
		}//update if exist 
		else
		{
			if($pageData['bank_name']!='' && $pageData['account_no']!=''&&$pageData['ifsc_code']!='')
			{ 
					$user_id = $_SESSION['user_id'];
					 
					$updated_on = date("Y-m-d H:i:s");
					$query = "insert into bank_details(`user_id`, `bank_name`, `account_no`, `ifsc_code`, `ctearted_on`, `updated_on`) values ( '".$user_id."','".$pageData['bank_name']."','".$pageData['account_no']."','".$pageData['ifsc_code']."','".$updated_on."','".$updated_on."')"; 
					$update_result = $conn->query($query);
						 
						if($update_result){
							header("Location:bank-details.php?status=1");
						}else{
							header("Location:bank-details.php?status=2");
						} 
			}
		}//insert 
	}
	if($user_id){
	
		$sql = "SELECT bd.*,us.first_name,us.last_name FROM bank_details bd LEFT JOIN users us ON bd.user_id=us.user_id where bd.user_id = '".$user_id."'";  
		$result = $conn->query($sql);
			if ($result->num_rows > 0) {
		while($row1 = $result->fetch_assoc())
		{
			$bank_name = $row1['bank_name'];
			$account_no = $row1['account_no'];
			$ifsc_code = $row1['ifsc_code'];
	
		}
		
	
			}
	} 



$conn->close();

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
			<!--	<div class="row user-name pb20">
					<div class="col-md-12">
						<div class="col-md-6 col-sm-5 black-bg">
							<h5 class="color-white">Welcome</h5>
							<h4><b><?php echo $loggeduser; ?></b></h4>
						</div>
						<div class="col-md-6 col-sm-7 black-bg">
							<h5 class="color-white">Free Money :</h5>
							<h4><b><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?></b></h4>
							<h5 class="color-white">Real Money :</h5>
							<h4><b><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
				<div class="row point-rummy-wrapper mt20">
					<?php include 'leftbar.php'; ?>
			<!-- Main content -->
			<div class="col-md-9">
				<div class="row">
					<!--<div class="box-header text-center with-border">
						<h3 class="box-title">Bank Details</h3>
					</div>-->
					<h3 class="color-white text-center mt20"><b>Bank Details</b></h3>
					<div class="col-xs-12">
						<div class="box">
							<div class="box-body bankDet-wrapper">
								<div class="row">
										<?php  if($status==1){ ?> 
							 <div class="alert alert-success alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> Record Updated.....!
							</div>  
							
						<?php }if($status==2){ ?> 
							 <div class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Fail....!</strong>  Error Occured...!
							</div>   
						<?php } ?>
						<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 details-wrapper">
										<div class="mt25" style="border:1px solid #404040;border-radius:8px;    background: wheat">
											<form acion="" method="post" name="bank_form" id="bank_form">
											<br/>
												<label>Member Name</label>:<?php echo $fullname;
											 ?>
												<br>
												<label>Bank Name</label>:
												<input type="text" name="bank_name" placeholder="Bank Name" autocomplete="off" value="<?php echo $bank_name;?>" required>
												<label>A/C No</label>:
												<input type="text" name="account_no" placeholder="Account No" autocomplete="off" required value="<?php echo $account_no;?>">
												<label>IFSC Code</label>:
												<input type="text" name="ifsc_code" placeholder="IFSC Code" autocomplete="off" required value="<?php echo $ifsc_code;?>">
												<?php if(($account_no)==''){ ?>
												<div class="text-center">
													<button class="btn" name="btnSubmit" style="margin:25px;border:none">Submit</button>
												</div>
												<?php } ?>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
		</div>
				<hr>
			</div>
		</div>
	</main>
	<footer>
		<div id="footer"></div>
	</footer>
</body>
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		 });
	</script>
</html>
<?php } ?>