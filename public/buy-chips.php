<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
if(!isset($_SESSION['logged_user'])) {
     
     header("Location:sign-in.php");
}else{
    
    $loggeduser =  $_SESSION['logged_user'];
    include 'database.php';
     include 'function.php';
    
    $sqlquery = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
    $result = $conn->query($sqlquery);
    
    if ($result->num_rows > 0) {
        
    	while($row = $result->fetch_assoc()){
    	    
    		$play_chips = $row['play_chips'];
    		$real_chips = $row['real_chips'];
    	}
    	
    }else {
    
        echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
        header("Location:index.php");
    }
 
 //===================Check active payment gateway
        $sqlget = "SELECT status FROM payment_gateway where id=1";
        $resultq = $conn->query($sqlget);
        $rowq = $resultq->fetch_assoc();
        $cashfreestatus = $rowq['status'];
        $sqlget1 = "SELECT status FROM payment_gateway where id=2";
        $resultq1 = $conn->query($sqlget1);
        $rowq1 = $resultq1->fetch_assoc();
        $paytmstatus = $rowq1['status'];

//echo "==========================".$cashfreestatus."===========".$paytmstatus;
?>

<?php
		
			$query_view = "SELECT user_id,first_name, last_name, email, mobile_no FROM users where username = '".$loggeduser."'";
			//echo"--sql---".$query_view."---<br>";
		
	        $result= mysqli_query($conn, $query_view);
	        
			if ($result->num_rows > 0){
				
				while($row = $result->fetch_assoc()){
				 
				    $user_id=$row['user_id'];
					$first_name=$row['first_name'];
					$last_name=$row['last_name'];
					$email = $row['email']; 
					$mobile = $row['mobile_no'];
					$name=$first_name." ".$last_name;
    				$full_name=$first_name.$last_name;
    				$returnUrl=$mainurl."public/response.php";
				}

			} 
			
			
			
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
	
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script>
	    $(document).ready(function() {
	        //alert('hi');
	        var cstatus='<?php echo  $cashfreestatus;?>';
	        var pstatus='<?php echo  $paytmstatus;?>';
	    if(cstatus == 'active' && pstatus == 'active'){   
            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
           });
	    }else{
	        if(pstatus == 'active'){
	             $("#cashdiv").removeClass("active");
                 $("#paydiv").addClass("active");
	        }
	    
	    }
});
	</script>
	<style>
	    
	    
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5A55A3;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
.errormsgp{
    background: red;
    color: white;
    text-align: center;
    width: 31%;
    margin-left: 42%;
    padding: 5px;
}
	</style>
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
							<h5 class="color-white">Play Chips :</h5>
							<h4><b><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?></b></h4>
							<h5 class="color-white"> Money :</h5>
							<h4><b><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
                <?php if($_GET['e'] == 1){?>
                    <p class="errormsgp">Coupon Code Not Valid</p>
                <?php } ?>
                 <?php if($_GET['e'] == 2){?>
                    <p class="errormsgp">Coupon Code Already Used</p>
                <?php } ?>
                 <?php if(isset($_GET['m'])){
                 $maxamount=$_GET['m'];
                 ?>
                    <p class="errormsgp">Maximum <?php echo $maxamount; ?> amount  is Allowed For used  coupon code</p>
                <?php } ?>
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
					
							
							
							 <div class="col-xs-9 bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
                  <?php if($cashfreestatus == 'active'){?>
                <a href="#" class="list-group-item <?php if($cashfreestatus == 'active'){ echo 'active';}?> text-center">
                  <br/>Cashfree
                </a>
                <?php }   
                if($paytmstatus == 'active'){?>
                <a href="#" class="list-group-item  <?php if($cashfreestatus != 'active'){ echo 'active';}?> text-center">
                  <br/>PayTM
                </a>
                <?php }?>
               
              </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
               
                <div id="cashdiv" class="bhoechie-tab-content active">
                    <center>
                       <?php if($full_name==""){?>
				   
				   <span style="font-size: 14px;
    color: #feae35;" >Please Compelete Your Profile Personal Details To Add Money
				  <a href="my-profile.php"><button style="color: #fff;
    background: -webkit-linear-gradient(#ffa31a, #cc7a00);
    border: none;
    padding: 3px 17px;
    margin: 15px 0px;" >Edit Profile</button></a></span>
				   <?php }?>
                      	<form method="post" action="request.php">
								<table border="1">
									<tbody>
									
										
										<tr>
											<td style="color:black;">Enter Amount *  (between 5 to 10000): &nbsp;&nbsp;&nbsp;</td>
											<td>
                                            <input title="TXN_AMOUNT" tabindex="10" type="number" name="orderAmount" min="5" max="10000" style="width:90%" required>
                                                
											</td>
										</tr>
											<tr>
											<td style="color:black;">Enter Coupon Code : &nbsp;&nbsp;&nbsp;</td>
											<td>
                                            <input title="Coupon Code" tabindex="10" type="text" name="couponcode" min="5" max="10000" style="width:90%">
                                                
											</td>
										</tr>
										<tr>
											<td>Using Cashfree</td>
											<td>
											    
											    <?php if($full_name!=""){?>
											    
											    <input value="Add Money" type="submit"	class="btn btn-primary"  onclick=""  style="width:90%">
											    
											    <?php }else{ ?>
											    
											    <input value="Add Money" type="submit" disabled	class="btn btn-primary" onclick=""   style="width:90%">
											    
											   <?php }?>
											   
											</td>
										</tr>
									</tbody>
								</table>
								
								<input title="Mobile_No" tabindex="10" type="hidden" value="<?php echo $mobile; ?>" name="customerPhone" required>
								<input title="EMAIL" tabindex="10" type="hidden" value="<?php echo $email; ?>" name="customerEmail" required>
								<input title="Login User" tabindex="10" type="hidden" value="<?php echo $user_id; ?>" name="loginuser" required>
								<input  type="hidden"  class="form-control" name="orderCurrency" value="INR" placeholder="Enter Currency here (Ex. INR)"/>
								<input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="orderNote" autocomplete="off" value="Real">
						<input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="customerName" autocomplete="off" value="<?php echo $name; ?>">
								  <input type="hidden" class="form-control" name="returnUrl" placeholder="Enter the URL to which customer will be redirected (Ex. www.example.com)" value="<?php echo $returnUrl; ?>"/>
							<input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="orderId" autocomplete="off" value="<?php echo  rand(10000000,99999999)?>">
						</form>
                    </center>
                </div>
                
                <div id="paydiv" class="bhoechie-tab-content">
                    <center>
                      
                      <form method="post" action="pgRedirect.php">
								<table border="1">
									<tbody>
										
										<tr>
											<td style="color:black;">Enter Amount *  (between 5 to 10000): &nbsp;&nbsp;&nbsp;</td>
											<td>
                                            <input title="TXN_AMOUNT" tabindex="10" type="number" name="TXN_AMOUNT" min="5" max="10000" style="width:85%;" required>
                                                
											</td>
										</tr>
										
									    <tr>
											<td style="color:black;">Enter Coupon Code : &nbsp;&nbsp;&nbsp;</td>
											<td>
                                            <input title="couponcode" tabindex="10" type="text" name="couponcode"  style="width:90%">
                                                
											</td>
										</tr>
										
										<tr>
											<td>Using PayTM</td>
											<td><input value="Add Money" type="submit"	class="btn btn-primary" onclick="" style="width:85%;" ></td>
										</tr>
									</tbody>
								</table>
								
								<input title="Mobile_No" tabindex="10" type="hidden" value="<?php echo $mobile; ?>" name="Mobile_No" required>
								<input title="EMAIL" tabindex="10" type="hidden" value="<?php echo $email; ?>" name="EMAIL" required>
								<input title="Login User" tabindex="10" type="hidden" value="<?php echo $user_id; ?>" name="loginuser" required>
								<input type="hidden" id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
								<input type="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
								<input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php echo $user_id; ?>">
								<input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo  "ORDS" . rand(10000,99999999)?>">
								
						</form>
                    </center>
                </div>
    
               	
							
							
							
							
							
							
							
							
							
							
							
							
						</div>
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