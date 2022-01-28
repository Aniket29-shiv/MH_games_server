 <?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//include '../../lock.php';
include("config.php");

 $username='';
 $fullname='';
 $email='';
 $mobile='';
 $user_id='';
 
    if(isset($_GET['username'])){
        
        $username=$_GET['username'];
     
        $sql = "select `user_id`,`first_name`,`last_name`,  `email`, `mobile_no` from users where username='$username'";			
        $result = mysqli_query($conn,$sql);
        $getdata=mysqli_fetch_object($result);
        $fullname=$getdata->first_name." ".$getdata->last_name;
        $email=$getdata->email;
        $mobile=$getdata->mobile_no;
         $user_id=$getdata->user_id;
        
     }
       
	
	
	
	//============================Net Profit Paymment============================================
	/*$sql = "select sum(commission) AS amount from game_transactions where game_type='money'";			
	$result = $conn->query($sql);
	$row = $result->fetch_row();
	$amount = $row[0];*/	

	
	
 ?>

 <!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MBChess Admin Panel</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">
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
<style>
.intext{
    padding: 5px 0px;
   
    text-align: center;
    font-size: 20px;
    font-weight: 500;   
}
 
 .txtsymbol{
    float: left;
    padding: 0px;
    font-size: 21px;
    margin: 7px;
 }
</style>

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
				<h1>Report Card</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a>
					</li>
					<li class="active">Report Card</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				<!-- Info boxes -->
					<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
						    <div class="box-header with-border">
								<h3 class="box-title">Search User</h3>
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
							<form method="get">
						
                    
                        <div class="col-md-6 col-xs-6">
                        <div class="dropdown" style="width:100%;">
                        	<input type="text"   name="username" id="uname" value=""  autocomplete="off" class="typeahead tm-input form-control tm-input-info"   style="padding:5px 0px; width:100%">
										
                        </div>
                        </div>
                        
                         <div class="col-md-1 col-xs-3">
                        
                       <input type="submit" class="btn btn-primary" name="search1" value="Search">
						  
                        </div>
                         <div class="col-md-1 col-xs-3">
                       
						    <a href="report_card.php"  class="btn btn-danger">Cancel</a>
                       
                        </div>
                        
                        	<div class="box-footer with-border" style="text-align:right;">	</div>
							
						</form>
							</div>
								</div>
									</div>
                    <?php if($username != ''){?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box point-lobby-wrapper">
                                <div class="box-header with-border">
                                <h3 class="box-title">User Details</h3>
                                </div>
                                <hr style="border:0.5px solid; margin-top: 0px;">
                              
                                
                                
                                    <div class="col-md-5 col-xs-12">
                                        <div class="" style="width:100%;">
                                       <i class="fa fa-user txtsymbol" aria-hidden="true"></i>
                                           <input type="text" disabled="disabled"   value="<?php echo $fullname;?>" class="form-control intext"   style="padding:5px 0px; width:80%">
                                        
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-xs-12">
                                        <div class="" style="width:100%;">
                                      <i class="fa fa-envelope txtsymbol" aria-hidden="true"></i>
                                            <input type="text" disabled="disabled"  value="<?php echo $email;?>" class="form-control intext"   style="padding:5px 0px; width:80%">			
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 col-xs-12">
                                        <div class="" style="width:100%;">
                                        <i class="fa fa-phone txtsymbol" aria-hidden="true"></i> 
                                           <input type="text"  disabled="disabled"  value="<?php echo $mobile;?>" class="form-control intext"   style="padding:5px 0px; width:80%">			
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="box-footer with-border" style="text-align:right;">	</div>
                                
                               
                            </div>
                        </div>
                    </div>
                    <?php }?>
				<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Games</span><hr style=" border: 1px solid;">
								<span class="info-box-number"> 
								<?php 
								
                                    $totalgame = "SELECT round_no FROM `game_transactions` where (`chip_type`='real' or `chip_type`='Real')";	
                                    if($username != ''){  $totalgame .= " and `player_name`='$username' ";	}
                                    $totalgame .= " group by `round_no` ";
                                    //echo $totalgame;
                                    $resultgame = mysqli_query($conn,$totalgame);
                                    $numgame=mysqli_num_rows( $resultgame);
                                    if($numgame > 0){ echo $numgame; }else{ echo 0; }
                               
								?>
							   </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
					<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Lost In Game</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querylost = "SELECT sum(amount) as lostamount FROM `game_transactions`  where  (`chip_type`='real' or `chip_type`='Real') and `status`='Lost'";	
                                    if($username != ''){  $querylost .= " and `player_name`='$username' ";	}
                                    $resultlost = mysqli_query($conn,$querylost);
                                    $getlost=mysqli_fetch_object( $resultlost);
                                    if($getlost->lostamount > 0){ echo number_format($getlost->lostamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Win In Game</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querywin = "SELECT sum(amount) as winamount FROM `game_transactions`  whereand  (`chip_type`='real' or `chip_type`='Real') and `status`='Won'";	
                                    if($username != ''){  $querywin .= " and `player_name`='$username' ";	}
                                   // echo $querywin;
                                    $resultwin = mysqli_query($conn,$querywin);
                                    $getwin=mysqli_fetch_object( $resultwin);
                                    if($getwin->winamount > 0){ echo number_format($getwin->winamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Commission</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querycommission = "SELECT sum(amount) as commissionamount FROM `company_balance`  where 1=1 ";	
                                    if($username != ''){  $querycommission .= " and `players_name` like '%$username%' ";	}
                                   // echo $querycommission;
                                    $resultcommission = mysqli_query($conn,$querycommission);
                                    $getcommission=mysqli_fetch_object( $resultcommission);
                                    if($getcommission->commissionamount > 0){ echo number_format($getcommission->commissionamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Tournament Fees</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querytfees = "SELECT sum(fees) as feesamount FROM `join_tournaments`";	
                                    if($user_id != ''){  $querytfees .= " where `player_id`='$user_id' ";	}
                                   //echo $querytfees;
                                    $resultfees = mysqli_query($conn,$querytfees);
                                    $gettfees=mysqli_fetch_object( $resultfees);
                                    if($gettfees->feesamount > 0){ echo number_format($gettfees->feesamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Tournament Won</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                        $querytwon = "SELECT sum(score) as twonamount FROM `tournament_transaction`";	
                                        if($user_id != ''){  $querytwon .= " where `player_id`='$user_id' ";	}
                                        //echo $querytwon;
                                        $resulttwon = mysqli_query($conn,$querytwon);
                                        $gettwon=mysqli_fetch_object( $resulttwon);
                                        if($gettwon->twonamount > 0){ echo number_format($gettwon->twonamount,2); }else{ echo number_format(0,2); }
                               
								    ?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Available Bonus</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querybonus = "SELECT sum(bonus) as bonusamount FROM `accounts` ";	
                                    if($user_id != ''){  $querybonus .= " where  `userid`='$user_id' ";	}
                                    //echo $querycommission;
                                    $resultbonus = mysqli_query($conn,$querybonus);
                                    $getbonus=mysqli_fetch_object( $resultbonus);
                                    if($getbonus->bonusamount > 0){ echo number_format($getbonus->bonusamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Available Balance</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querybalance = "SELECT sum(real_chips) as balanceamount FROM `accounts` ";	
                                    if($user_id != ''){  $querybalance .= " where  `userid`='$user_id' ";	}
                                   // echo $querycommission;
                                    $resultbalance = mysqli_query($conn,$querybalance);
                                    $getbalance=mysqli_fetch_object( $resultbalance);
                                    if($getbalance->balanceamount > 0){ echo number_format($getbalance->balanceamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Bonus</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querytbonus = "SELECT sum(amount) as bonusamount FROM `fund_added_to_player` where payment_mode='Bonus' and  (`chip_type`='real' or `chip_type`='Real') ";	
                                    if($user_id != ''){  $querytbonus .= " where  `user_id`='$user_id' ";	}
                                    //echo $querycommission;
                                    $resulttotalbonus = mysqli_query($conn,$querytbonus);
                                    $gettotalbonus=mysqli_fetch_object( $resulttotalbonus);
                                    if($gettotalbonus->bonusamount > 0){ echo number_format($gettotalbonus->bonusamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Added Balance</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryaddbalance = "SELECT sum(amount) as totaladded  FROM `fund_added_to_player` where  (`chip_type`='real' or `chip_type`='Real')  ";	
                                    if($user_id != ''){  $queryaddbalance .= " and `user_id`='$user_id' ";	}
                                   // echo $queryaddbalance;
                                    $resultaddbalance = mysqli_query($conn,$queryaddbalance);
                                    $getaddbalance=mysqli_fetch_object( $resultaddbalance);
                                    if($getaddbalance->totaladded > 0){ echo number_format($getaddbalance->totaladded,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Payment Paytm</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryaccepted = "SELECT sum(amount) as acceptedamount FROM `fund_added_to_player` where `payment_mode`='Paytm' and (`chip_type`='real' or `chip_type`='Real')";	
                                    if($user_id != ''){  $queryaccepted .= " and `user_id`='$user_id' ";	}
                                    //echo $querycommission;
                                    $resultaccepted = mysqli_query($conn,$queryaccepted);
                                    $getaccepted=mysqli_fetch_object( $resultaccepted);
                                    if($getaccepted->acceptedamount > 0){ echo number_format($getaccepted->acceptedamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Payment CashFree</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryaccepted = "SELECT sum(amount) as acceptedamount FROM `fund_added_to_player` where `payment_mode`='Cashfree' and (`chip_type`='real' or `chip_type`='Real')";	
                                    if($username != ''){  $queryaccepted .= " and `player_id`='$username' ";	}
                                    //echo $querycommission;
                                    $resultaccepted = mysqli_query($conn,$queryaccepted);
                                    $getaccepted=mysqli_fetch_object( $resultaccepted);
                                    if($getaccepted->acceptedamount > 0){ echo number_format($getaccepted->acceptedamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
							<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Payment Net Banking</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryaccepted = "SELECT sum(amount) as acceptedamount FROM `fund_added_to_player` where (`payment_mode`='NB' or`payment_mode`= 'NET_BANKING') and (`chip_type`='real' or `chip_type`='Real')";	
                                    if($user_id != ''){  $queryaccepted .= " and `user_id`='$user_id' ";	}
                                    //echo $querycommission;
                                    $resultaccepted = mysqli_query($conn,$queryaccepted);
                                    $getaccepted=mysqli_fetch_object( $resultaccepted);
                                    if($getaccepted->acceptedamount > 0){ echo number_format($getaccepted->acceptedamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Payment Redeem</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryaccepted = "SELECT sum(amount) as acceptedamount FROM `fund_added_to_player` where `payment_mode`='Redeem' and (`chip_type`='real' or `chip_type`='Real')";	
                                    if($user_id != ''){  $queryaccepted .= " and `user_id`='$user_id' ";	}
                                    //echo $querycommission;
                                    $resultaccepted = mysqli_query($conn,$queryaccepted);
                                    $getaccepted=mysqli_fetch_object( $resultaccepted);
                                    if($getaccepted->acceptedamount > 0){ echo number_format($getaccepted->acceptedamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
					<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Payment Signup</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryaccepted = "SELECT sum(amount) as acceptedamount FROM `fund_added_to_player` where `payment_mode`='signup' and (`chip_type`='real' or `chip_type`='Real')";	
                                    if($user_id != ''){  $queryaccepted .= " and `user_id`='$user_id' ";	}
                                    //echo $querycommission;
                                    $resultaccepted = mysqli_query($conn,$queryaccepted);
                                    $getaccepted=mysqli_fetch_object( $resultaccepted);
                                    if($getaccepted->acceptedamount > 0){ echo number_format($getaccepted->acceptedamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Payment Admin</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryaccepted = "SELECT sum(amount) as acceptedamount FROM `fund_added_to_player` where `payment_mode`='Admin' and (`chip_type`='real' or `chip_type`='Real')";	
                                    if($user_id != ''){  $queryaccepted .= " and `user_id`='$user_id' ";	}
                                    //echo $querycommission;
                                    $resultaccepted = mysqli_query($conn,$queryaccepted);
                                    $getaccepted=mysqli_fetch_object( $resultaccepted);
                                    if($getaccepted->acceptedamount > 0){ echo number_format($getaccepted->acceptedamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
					
					
					
					
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Paid Amount</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querypaid = "SELECT sum(requested_amount) as paidamount FROM `withdraw_request` where `status`='Paid'";	
                                    if($userid != ''){  $querypaid .= " and `user_id`='$userid' ";	}
                                    //echo $querypaid;
                                    $resultpaid = mysqli_query($conn,$querypaid);
                                    $getpaid=mysqli_fetch_object( $resultpaid);
                                    if($getpaid->paidamount > 0){ echo number_format($getpaid->paidamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
					
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Withdraw Pending/Inprocess</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $querypending = "SELECT sum(requested_amount) as pendingamount FROM `withdraw_request` where (`status`='Process' or `status`='Pending')";	
                                    if($userid != ''){  $querypending .= " and `user_id`='$userid' ";	}
                                   // echo $querycommission;
                                    $resultpending = mysqli_query($conn,$querypending);
                                    $getpending=mysqli_fetch_object( $resultpending);
                                    if($getpending->pendingamount > 0){ echo number_format($getpending->pendingamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
					
						<div class="col-md-4 col-sm-6 col-xs-12" >
						<div class="info-box" style=" padding: 14px;background: #cddfef;">
							<div class=""> <span class="info-box-text">Total Reversed/Reserved</span><hr style=" border: 1px solid;">
								<span class="info-box-number">₹ &nbsp;
									<?php 
								
                                    $queryreserved = "SELECT sum(requested_amount) as reservedamount FROM `withdraw_request` where (`status`='Reversed' or `status`='Reserved')";	
                                    if($userid != ''){  $queryreserved .= " and `user_id`='$userid' ";	}
                                   // echo $querycommission;
                                    $resultreserved = mysqli_query($conn,$queryreserved);
                                    $getreserved=mysqli_fetch_object( $resultreserved);
                                    if($getreserved->reservedamount > 0){ echo number_format($getreserved->reservedamount,2); }else{ echo number_format(0,2); }
                               
								?>&nbsp;/-</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					
					
					
					
					<!-- /.col -->
				</div>
	
			
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
	<script src="../../bower_components/Chart.js/Chart.js"></script>
	
	<script src="../../dist/js/demo.js"></script>
	<script src="../../js/bar.js"></script>
	<script src="../../js/jquery.rotapie.js"></script>
	 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	<script>
		$(function(){
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
			});
			
		$(function(){
				$('#pie').rotapie({
					slices: [
						{ color: '#dd4b39 ', percentage: 23 }, // If color not set, slice will be transparant.
						{ color: '#00a65a ', percentage: 18 }, // Font color to render percentage defaults to 'color' but can be overriden by setting 'fontColor'.
						{ color: '#f39c12 ', percentage: 16 },
						{ color: '#00c0ef ', percentage: 20 },
						{ color: '#3c8dbc ', percentage: 14 },
						{ color: '#d2d6de ', percentage: 9 },
					],
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
					/*
					beforeAnimate: function (nextIndex, settings) {
						var canvas = this;
						return false; // Cancel rotation
					},
					afterAnimate: function(settings){
						var canvas = this;
						var index = settings.sliceIndex; // Retrieve current index.
					}
					*/
				});
			});
	</script>
		<script type="text/javascript">
              $(document).ready(function() {
                var tagApi = $(".tm-input").tagsManager();
            
            
                jQuery(".typeahead").typeahead({
                  name: 'username',
                  displayKey: 'name',
                  source: function (query, process) {
                    return $.get('ajaxpro_username.php', { query: query }, function (data) {
                      data = $.parseJSON(data);
                      return process(data);
                    });
                  },
                  afterSelect :function (item){
                    //tagApi.tagsManager("username", item);
                    $('#uname').val(item);
                  }
                });
              });
</script>
</body>

</html>