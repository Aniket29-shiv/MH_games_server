<?php
include '../../lock.php';
include("config.php");
$sql = "select count(user_id) AS total_user from users";			
	$result 	= $conn->query($sql);
	if($result->num_rows > 0)
	{		
		while($row = $result->fetch_assoc())
		{			
			$total_user = $row['total_user'];
		}
	}
 ?> 
 <?php
	//Dashboard Latest Player Details start
	$latest_player = "select username,concat(ifnull(first_name,''),' ',ifnull(middle_name,''),' ',ifnull(last_name,'')) AS player_name,
					mobile_no,email	from users order by user_id desc limit 10";
			
	$player_result 	= $conn->query($latest_player);
	//Dashboard Latest game Details end
		$latest_game = "	SELECT `id`, `table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, `total_amount`, `amount`, `players_name`, `date` FROM `company_balance` order by date desc limit 10";
			
	$latestgametran 	= $conn->query($latest_game);
	

	
	//Dashboard Latest request Details start
	$latest_request = "select 
							name,					
							subject,
							message
			from 
					user_help_support order by id desc limit 5";
			
	$request_result 	= $conn->query($latest_request);	
	//Dashboard Latest request Details end
	
	//Dashboard Latest request Details start
	$latest_tranasaction = "select f.id,f.order_id,f.transaction_id,f.payment_mode,u.username
			from fund_added_to_player f, users u where u.user_id=f.user_id order by f.id desc limit 10";
					
	$tranasaction_result 	= $conn->query($latest_tranasaction);
	//Dashboard Latest request Details end
	
	//Dashboard Latest request Details start

	$latest_withdrawal = "select w.requested_amount,u.username from withdraw_request w,users u where u.user_id=w.user_id order by w.transaction_id desc limit 10";				
	$withdrawal_result 	= $conn->query($latest_withdrawal);
	
	//Dashboard Latest request Details end
	
	//Dashboard Collected Paymment
	$sql = "select sum(amount) AS total_amount from fund_added_to_player where chip_type='Real'";			
	$result = $conn->query($sql);
	$row = $result->fetch_row();
	$totalamount = $row[0];	
	/*if($result->num_rows > 0)
	{		
		while($row = $result->fetch_assoc())
		{			
			$total_user = $row['total_amount'];
		}
	}*/
	
	
	//Dashboard Collected Paymment
	$sql = "select sum(amount) AS admin_amount from fund_added_to_player where chip_type='Real' And payment_mode='Admin'";			
	$result = $conn->query($sql);
	$row = $result->fetch_row();
	$adminamount = $row[0];	
	/*if($result->num_rows > 0)
	{		
		while($row = $result->fetch_assoc())
		{			
			$total_user = $row['total_amount'];
		}
	}*/
	
	
	
	//Net Profit Paymment
	$sql = "select sum(amount) AS amount from company_balance";			
	$result = $conn->query($sql);
	$row = $result->fetch_row();
	$amount = $row[0];	
	/*if($result->num_rows > 0)
	{		
		while($row = $result->fetch_assoc())
		{			
			$total_user = $row['total_amount'];
		}
	}*/


function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}
function random_color() {
    return '#'.random_color_part() . random_color_part() . random_color_part();
}
//===============================================Login History=============================
$regionarray=array();
$regionhead=array();
$querylogin=mysqli_query($conn,"SELECT * FROM `login_history`");
$numloginrecord=mysqli_num_rows($querylogin);
$querystate=mysqli_query($conn,"SELECT DISTINCT(region) FROM `login_history`");
while($listdata=mysqli_fetch_object($querystate)){
    $region=$listdata->region;
   
    $querys=mysqli_query($conn,"SELECT * FROM `login_history` where region='$region';");
    $numlogins=mysqli_num_rows($querys);
    $percount=100*($numlogins/$numloginrecord);
    $randcolor=random_color();
    $region=$listdata->region;
    // echo $listdata->region.'=='.random_color().'=='.$percount.'<br />';
     $age = array("color"=>$randcolor, "percentage"=>$percount);
     array_push($regionarray,$age);
     $age1 = array("state"=>$region, "color"=>$randcolor);
     array_push($regionhead,$age1);
}

$jsonarrayregion=json_encode($regionarray);
//print_r($jsonarrayregion);

	
 ?>

 <!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>RummyCash Admin Panel</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
	
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
	<link type="text/css" rel="stylesheet" href="../../css/bar-chart.css" />
	
	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<div id="header"></div>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="sidebar-menu" data-widget="tree" id="sidebar-menu"></div>
			</section>
		</aside>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>Dashboard</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a>
					</li>
					<li class="active">Dashboard</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
							<div class="info-box-content"> <span class="info-box-text">Collected Paymment</span>
								<span class="info-box-number">₹ <?php echo $totalamount-$adminamount;?><small></small></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-inr" aria-hidden="true"></i></span>
						
						<div class="info-box-content"> <span class="info-box-text">Added to player</span>
								<span class="info-box-number">₹ <?php echo $adminamount;?><small></small></span>
							</div>
						
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<!-- fix for small devices only -->
					<div class="clearfix visible-sm-block"></div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
							<div class="info-box-content"> <span class="info-box-text">Net Profit</span>
								<span class="info-box-number">₹ <?php echo round($amount,2);?><small></small></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="info-box"> <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
							<div class="info-box-content"> <span class="info-box-text">Total Players</span>
								<span class="info-box-number"><?php echo $total_user;?></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
				</div>
				
					<div class="row">
					<!-- Left col -->
					<div class="col-md-12">
						<!-- MAP & BOX PANE -->
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Latest Players</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.box-header -->
							<div class="box-body no-padding">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div style="height:250px;overflow-y:scroll">
											<div class="table-responsive">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>Sr No</th>
															<th>Round</th>
															<th>Capacity</th>
																<th>Game Type</th>
															<th>Total Amount</th>
															<th>Commission</th>
															<th>Player Name</th>
															<th>Date</th>
														</tr>
													</thead>
													<tbody>
														<?php
														
														if($latestgametran->num_rows > 0)
														{	$i = 1;
															while($row1 = $latestgametran->fetch_assoc())
															{
																
															
													?>			
																<tr>
																	<td><?php echo $i ;?></td>
																	<td><?php echo $row1['round_id'] ;?></td>
																	<td><?php echo $row1['player_capacity'] ;?></td>
																	<td><?php echo $row1['game_type'] ;?></td>
																	<td><?php echo $row1['total_amount'] ;?></td>
																	<td><?php echo $row1['amount'] ;?></td>
																	<td><?php echo $row1['players_name'] ;?></td>
																	<td><?php echo $row1['date'] ;?></td>
																</tr>
													<?php		
															$i++;}
														}
													?>
													
													</tbody>
												</table>
											</div>
										</div>
										<!-- /.col -->
									</div>
								</div>
								<!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
				<!-- /.row -->
				<!--<div class="row">
					<div class="col-md-12">
						<div class="box">
							<div class="box-header with-border">
								<h3 class="box-title">Monthly Active Users</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
							
							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
										<p class="text-center">	<strong>Jan, 2016 - Dec, 2016</strong>
										</p>
										<div id="chart">
											<ul id="numbers">
												<li style="margin-top:-20px"><span>10000</span>
												</li>
												<li><span>5000</span>
												</li>
												<li><span>1000</span>
												</li>
												<li><span>500</span>
												</li>
												<li><span>100</span>
												</li>
												<li><span>10</span>
												</li>
												<li><span>0</span>
												</li>
											</ul>
											<ul id="bars">
												<li>
													<div data-percentage="56" class="bar"></div><span>Jan</span>
												</li>
												<li>
													<div data-percentage="33" class="bar"></div><span>Feb </span>
												</li>
												<li>
													<div data-percentage="89" class="bar"></div><span>Mar </span>
												</li>
												<li>
													<div data-percentage="44" class="bar"></div><span>Apr </span>
												</li>
												<li>
													<div data-percentage="76" class="bar"></div><span>May </span>
												</li>
												<li>
													<div data-percentage="32" class="bar"></div><span>Jun </span>
												</li>
												<li>
													<div data-percentage="67" class="bar"></div><span>Jul </span>
												</li>
												<li>
													<div data-percentage="91" class="bar"></div><span>Aug </span>
												</li>
												<li>
													<div data-percentage="73" class="bar"></div><span>Sep </span>
												</li>
												<li>
													<div data-percentage="81" class="bar"></div><span>Oct </span>
												</li>
												<li>
													<div data-percentage="23" class="bar"></div><span>Nov </span>
												</li>
												<li>
													<div data-percentage="58" class="bar"></div><span>Dec </span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							
							</div>
						</div>
					
					</div>
					
				</div>-->
				<!-- /.row -->
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<div class="col-md-12">
						<!-- MAP & BOX PANE -->
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Latest Players</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.box-header -->
							<div class="box-body no-padding">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div style="height:250px;overflow-y:scroll">
											<div class="table-responsive">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>Sr No</th>
															<th>User Name</th>
															<th>Full Name</th>
															<th>Mobile No.</th>
															<th>Email</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if($player_result->num_rows > 0)
														{	$i = 1;
															while($row = $player_result->fetch_assoc())
															{
																
																$username 		= $row['username'];
																$player_name    = $row['player_name'];
																$mobile_no  	= $row['mobile_no'];
																$email  		= $row['email'];
													?>			
																<tr>
																	<td><?php echo $i ;?></td>
																	<td><?php echo $username ;?></td>
																	<td><?php echo $player_name ;?></td>
																	<td><?php echo $mobile_no ;?></td>
																	<td><?php echo $email ;?></td>
																</tr>
													<?php		
															$i++;}
														}
													?>
													
													</tbody>
												</table>
											</div>
										</div>
										<!-- /.col -->
									</div>
								</div>
								<!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-6">
						<!-- DIRECT CHAT -->
						<div class="box box-warning direct-chat direct-chat-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Recent Request</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
									<button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"> <i class="fa fa-comments"></i>
									</button>
								</div>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<!-- Contacts are loaded here -->
								<div>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>User Name</th>
												<th>Subject</th>
												<th>Message</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if($request_result->num_rows > 0)
												{	$i = 1;
													while($row = $request_result->fetch_assoc())
													{
														
														$username 		= $row['name'];
														$subject        = $row['subject'];
														$message        = $row['message'];
											?>			
														<tr>															
															<td><?php echo $username ;?></td>
															<td><?php echo $subject ;?></td>
															<td><?php echo $message ;?></td>
														</tr>
											<?php		
													$i++;}
												}
											?>
											<!--<tr>
												<td>Sara Doe</td>
												<td>Lorem Ipsum</td>
												<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
											</tr>-->
										</tbody>
									</table>
								</div>
							
								<!-- /.direct-chat-pane -->
							</div>
							<div class="box-footer clearfix"> 
								<a href="help_support.php" class="btn btn-sm btn-info btn-flat pull-left" style="margin-left:30px;">More Details</a>
							</div>
							<!-- /.box-body -->
						</div>
						<!--/.direct-chat -->
					</div>
					<!-- /.col -->
				
					<!-- /.col -->
					<div class="col-md-6 col-sm-6">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Login Chart By State</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="text-align:center">
								<div id="pie"></div>
							</div>
							<div>
								<ul class="chart-legend clearfix" style="padding:15px">
								    <?php  
								    
								    foreach ($regionhead as $value){ 
                                      
                                      echo '<li style="display:inline-block"><i class="fa fa-circle-o " style="color:'.$value['color'].'"></i> '.$value['state'].'</li>';
                                    } 
								    
								    ?>
									<!--<li style="display:inline-block"><i class="fa fa-circle-o text-red"></i> Chrome</li>
									<li style="display:inline-block"><i class="fa fa-circle-o text-green"></i> IE</li>
									<li style="display:inline-block"><i class="fa fa-circle-o text-yellow"></i> FireFox</li>
									<li style="display:inline-block"><i class="fa fa-circle-o text-aqua"></i> Safari</li>
									<li style="display:inline-block"><i class="fa fa-circle-o text-light-blue"></i> Opera</li>
									<li style="display:inline-block"><i class="fa fa-circle-o text-gray"></i> Navigator</li>-->
								</ul>
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>
				<!-- /.row -->
				<div class="row">
					<!-- TABLE: LATEST ORDERS -->
					<div class="col-md-8 col-sm-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Latest Transactions</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-bordered no-margin">
										<thead>
											<tr>
												<th>Sr.No</th>
												<th>Id</th>
												<th>User Name</th>
												<th>Order Id</th>
												<th>Transaction Id</th>
												<th style="text-align:center">Payment Method</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if($tranasaction_result->num_rows > 0)
												{	$i = 1;
													while($row = $tranasaction_result->fetch_assoc())
													{
														
														$username = $row['username'];
														$id = $row['id'];
														$order_id = $row['order_id'];
														$transaction_id  = $row['transaction_id'];
														$payment_mode  = $row['payment_mode'];
											?>	
													<tr>	
														<td><?php echo $i; ?></td>
														<td><?php echo $id; ?></td>
														<td><?php echo $username; ?></td>
														<td><?php echo $order_id; ?></td>
														<td><?php echo $transaction_id; ?></td>
														<td><?php echo $payment_mode; ?></td>
													</tr>
											<?php		
													$i++;}
												}
											?>
											<!--<tr>
												<td><a href="pages/examples/invoice.html">OR9842</a>
												</td>
												<td>Rs. 500</td>
												<td><span class="label label-success">Success</span>
												</td>
												<td style="text-align:center">
													<img src="../../dist/img/credit/visa.png" alt="Visa">
													<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
													<img src="../../dist/img/credit/paypal2.png" alt="Paypal">
													<img src="../../dist/img/credit/cirrus.png" alt="Cirrus">
												</td>
											</tr>
											<tr>
												<td><a href="pages/examples/invoice.html">OR1848</a>
												</td>
												<td>Rs. 200</td>
												<td><span class="label label-warning">Success</span>
												</td>
												<td style="text-align:center">
													<img src="../../dist/img/credit/visa.png" alt="Visa">
													<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
													<img src="../../dist/img/credit/paypal2.png" alt="Paypal">
													<img src="../../dist/img/credit/cirrus.png" alt="Cirrus">
												</td>
											</tr>
											<tr>
												<td><a href="pages/examples/invoice.html">OR7429</a>
												</td>
												<td>Rs. 2400</td>
												<td><span class="label label-danger">Success</span>
												</td>
												<td style="text-align:center">
													<img src="../../dist/img/credit/visa.png" alt="Visa">
													<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
													<img src="../../dist/img/credit/paypal2.png" alt="Paypal">
													<img src="../../dist/img/credit/cirrus.png" alt="Cirrus">
												</td>
											</tr>
											<tr>
												<td><a href="pages/examples/invoice.html">OR7429</a>
												</td>
												<td>Rs. 350</td>
												<td><span class="label label-info">Processing</span>
												</td>
												<td style="text-align:center">
													<img src="../../dist/img/credit/visa.png" alt="Visa">
													<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
													<img src="../../dist/img/credit/paypal2.png" alt="Paypal">
													<img src="../../dist/img/credit/cirrus.png" alt="Cirrus">
												</td>
											</tr>
											<tr>
												<td><a href="pages/examples/invoice.html">OR1848</a>
												</td>
												<td>Rs. 2560</td>
												<td><span class="label label-warning">Pending</span>
												</td>
												<td style="text-align:center">
													<img src="../../dist/img/credit/visa.png" alt="Visa">
													<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
													<img src="../../dist/img/credit/paypal2.png" alt="Paypal">
													<img src="../../dist/img/credit/cirrus.png" alt="Cirrus">
												</td>
											</tr>
											<tr>
												<td><a href="pages/examples/invoice.html">OR7429</a>
												</td>
												<td>Rs. 500</td>
												<td><span class="label label-danger">Failed</span>
												</td>
												<td style="text-align:center">
													<img src="../../dist/img/credit/visa.png" alt="Visa">
													<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
													<img src="../../dist/img/credit/paypal2.png" alt="Paypal">
													<img src="../../dist/img/credit/cirrus.png" alt="Cirrus">
												</td>
											</tr>
											<tr>
												<td><a href="pages/examples/invoice.html">OR9842</a>
												</td>
												<td>Rs. 100</td>
												<td><span class="label label-success">Success</span>
												</td>
												<td style="text-align:center">
													<img src="../../dist/img/credit/visa.png" alt="Visa">
													<img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
													<img src="../../dist/img/credit/paypal2.png" alt="Paypal">
													<img src="../../dist/img/credit/cirrus.png" alt="Cirrus">
												</td>
											</tr>-->
										</tbody>
									</table>
								</div>
								<!-- /.table-responsive -->
							</div>
							<!-- /.box-body -->
							<div class="box-footer clearfix"> <a href="add-fund-account.php" class="btn btn-sm btn-info btn-flat pull-left">Add fund to player account</a>
								<a href="fund_transfer_to_player.php" class="btn btn-sm btn-default btn-flat pull-right">View All Transactions</a>
							</div>
							<!-- /.box-footer -->
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="box box-primary">
							<div class="box-header with-border">
								<!--<h3 class="box-title">Recently Withdrawal Request</h3>-->
								<h3 class="box-title">Recent Withdrawal</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
									<!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
								</div>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>User Name</th>
												<th>Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if($withdrawal_result->num_rows > 0)
												{	$i = 1;
													while($row = $withdrawal_result->fetch_assoc())
													{
														
														$username = $row['username'];
														$requested_amount = $row['requested_amount'];
											?>
														<tr>
															<td><?php  echo $username; ?></td>
															<td><?php  echo $requested_amount; ?></td>
														</tr>
											<?php		
													$i++;}
												}
											?>
											<!--<tr>
												<td>Alexander Pierce</td>
												<td>500</td>
											</tr>
											<tr>
												<td>Norman Jane</td>
												<td>300</td>
											</tr>
											<tr>
												<td>John Doe</td>
												<td>100</td>
											</tr>
											<tr>
												<td>Sarah Nadia</td>
												<td>400</td>
											</tr>
											<tr>
												<td>Alexander Nora</td>
												<td>200</td>
											</tr>-->
										</tbody>
									</table>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer text-center"> <a href="withdrawal-request.php" class="uppercase">View All Withdrawals</a>
							</div>
							<!-- /.box-footer -->
						</div>
						<!-- /.box -->
					</div>
				</div>
				<!-- /.box -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<div id="footer"></div>
		</footer>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark" id="dashboard-settings"></aside>
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->
	<!-- jQuery 3 -->
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- SlimScroll -->
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- ChartJS -->
	<script src="../../bower_components/chart.js/Chart.js"></script>
	
	<script src="../../dist/js/demo.js"></script>
	<script src="../../js/bar.js"></script>
	<script src="../../js/jquery.rotapie.js"></script>
	<script>
		$(function(){
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
			});
			
		$(function(){
				$('#pie').rotapie({
					slices: <?php echo $jsonarrayregion;?>,
				    sliceIndex: 0, // Start index selected slice.
					deltaAngle: 0.2, // The rotation angle in radians between frames, smaller number equals slower animation.
					minRadius: 100, // Radius of unselected slices, can be set to percentage of container width i.e. '50%'
					maxRadius: 110, // Radius of selected slice, can be set to percentage of container width i.e. '45%'
					minInnerRadius: 30, // Smallest radius inner circle when animated, set to 0 to disable inner circle, can be set to percentage of container width i.e. '35%'
					maxInnerRadius: 45, // Normal radius inner circle, set to 0 to disable inner circle, can be set to percentage of container width i.e. '30%'
					innerColor: '#fff', // Background color inner circle. 
					minFontSize: 20, // Smallest fontsize percentage when animated, set to 0 to disable percentage display, can be set to percentage of container width i.e. '20%'
					maxFontSize: 30, // Normal fontsize percentage, set to 0 to disable percentage display, can be set to percentage of container width i.e. '10%'
					fontYOffset: 0, // Vertically offset the percentage display with this value, can be set to percentage of container width i.e. '-10%'
					fontFamily: 'Times New Roman', // FontFamily percentage display.
					fontWeight: 'bold', // FontWeight percentage display.
					decimalPoint: '.', // Can be set to comma or other symbol.
					clickable: true // If set to true a user can select a different slice by clicking on it. 
				});
			});
	</script>
</body>

</html>