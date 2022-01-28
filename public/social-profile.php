<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 include 'database.php';

    //===Full name split
    
    $splname= explode(" ", $_SESSION['name']);
    $fname=$splname[0];
    $lname=$splname[1];
    $_SESSION['fnamee']=$fname;
    $_SESSION['lnamee']=$lname;
 
   
    //==Pull data by email id
    
	$sql = "SELECT * FROM users WHERE email='".$_SESSION["email"]."'";
	$result = $conn->query($sql);
	$row=$result->fetch_assoc();
	
	$fnm=$row['first_name'];
	$lnm=$row['last_name'];
	$mob=$row['mobile_no'];
	$email=$row['email'];
	$gen=$row['gender'];
	$state=$row['state'];
	$usnm=strtolower($row['username']);
	$refcod=$row['referral_code'];
	
	$_SESSION['logged_user']=$usnm;
	
	
	//=========== Login Process==================
	
   if(!isset($_SESSION['logged_user'])){
      echo '<script type="text/javascript">window.location.href="sign-in.php";</script>';
     // header("Location:sign-in.php");
    
   }else{
     
        $loggeduser =  $_SESSION['logged_user'];
       
        
        $sql = "SELECT u.username, u.`mobile_no`, u.`email`, DATE_FORMAT(u.created_date,'%d/%m/%Y') as profile_created_date,acct.`play_chips`, acct.`real_chips`, acct.`redeemable_balance`, acct.`bonus`, acct.`player_club`, acct.`player_status` FROM users u left join accounts acct on u.user_id = acct.userid where acct.username = '".$loggeduser."'";
       //echo $sql;
       //exit();
        $result = $conn->query($sql);
        
        //print_r($result); die();
        
   if ($result->num_rows > 0) {
       
    	while($row = $result->fetch_assoc()){
    	    
    		$play_chips = $row['play_chips'];
    		$real_chips = $row['real_chips'];
    		$redem_bal = $row['redeemable_balance'];
    		$bonus = $row['bonus'];
    		$ace_level = $row['player_club'];
    		$created_date = $row['profile_created_date'];
    		$email = $row['email']; 
    		$mobile = $row['mobile_no'];
    		$player_status = $row['player_status'];
    	}

   }else {
       
    echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
     echo '<script type="text/javascript">window.location.href="sign-in.php";</script>';
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
		    <p style="text-align:center">
		    <?php
		    
		    
		    if(isset($_GET['u'])){
		         echo "<span style='text-align: center;color: white;background: green;padding: 8px;'>Profile Updated Successfully</span>"; 
		         echo "<script>setTimeout(\"location.href = 'point-lobby-rummy.php';\",5000);</script>";  
		    
		    }
		    
		    ?></p>
			<div class="container account-cont-wrapper">
		<!--		<div class="row user-name pb20">
					<div class="col-md-12">
						<div class="col-md-6 col-sm-5 black-bg">
							<h5 class="color-white">Welcome</h5>
							<h4><b><?php echo $loggeduser; ?></b></h4>
						</div>
						<div class="col-md-6 col-sm-7 black-bg">
							<h5 class="color-white">Free Money :</h5>
							<h4><b><?php if($play_chips!='') echo $play_chips; else echo 0; ?></b></h4>
							<h5 class="color-white">Real Money :</h5>
							<h4><b><?php if($real_chips!='') echo $real_chips; else echo 0; ?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
				<hr>
				 
				<div class="row account-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
						    <form action="edit.php" method="post">
							<h3 class="color-white text-center mt20"><b>My Account</b></h3>
							<div class="col-md-6">
								<div class="bg-grey">
									<h5 class="text-center mb0"><b>Profile Overview </b></h5>
									<hr class="mt0">
									<div>
									    
										  <label for="name">First Name</label>
            <input type="text" class="form-control input-sm" id="FirstName" placeholder="" value="<?php echo $fnm; ?>" name="FirstName" readonly>
										<label for="mobile">Mobile*</label>
            <input type="text" class="form-control input-sm" id="mobile" name="mobile"  placeholder="Mobile"  value ="<?php echo $mob;?>" required <?php if($mob!=" "){?>readonly="true"<?php } ?>>
            
		
				<label for="gender">Select Gender</label>
				<select id="gender" name="gender" class="form-control">
				    <option>Gender</option>
				    <option value="Male" <?php if($gen!='' && $gen=='Male'){?>selected = "true" <?php } ?>> Male</option>
				    <option value="Female" <?php if($gen!='' && $gen=='Female'){?> selected = "true" <?php } ?> >FeMale</option>
				</select>
          
            
										<label for="country">User Name*</label>
            <input type="text" class="form-control input-sm" id="username" placeholder="UserName" name="username"  value="<?php  echo $usnm; ?>" required readonly>
            
										
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="bg-grey">
									<h5 class="text-center mb0"><b>Profile Overview</b></h5>
									<hr class="mt0">
									<div>   
										<label for="lname">Last Name</label>
            <input type="text" class="form-control input-sm" id="LastName" placeholder="" name="LastName" value="<?php echo $lnm; ?>" readonly>
									 <label for="email">Email*</label>
            <input type="email" class="form-control input-sm" id="email" placeholder="" name="email" value="<?php echo $email;?>" readonly>
									 <label for="state">Select State*</label>
            <select class="form-control" name="state" id="state" required>
									<option value="">Select State</option>
									<option value="">Please select State</option><option value="Andaman and Nicobar Islands" <?php if($state!='' && $state=='Andaman and Nicobar Islands'){?> selected = "true" <?php } ?>>Andaman and Nicobar Islands</option>
												<option value="Andhra Pradesh" <?php if($state!='' && $state=='Andhra Pradesh'){?> selected = "true" <?php } ?>>Andhra Pradesh</option>
												<option value="Arunachal Pradesh" <?php if($state!='' && $state=='Arunachal Pradesh'){?> selected = "true" <?php } ?>>Arunachal Pradesh</option>
												<option value="Assam" <?php if($state!='' && $state=='Assam'){?> selected = "true" <?php } ?>>Assam</option>
												<option value="Bihar" <?php if($state!='' && $state=='Bihar'){?> selected = "true" <?php } ?>>Bihar</option>
												<option value="Chandigarh" <?php if($state!='' && $state=='Chandigarh'){?> selected = "true" <?php } ?>>Chandigarh</option>
												<option value="Chhattisgarh" <?php if($state!='' && $state=='Chhattisgarh'){?> selected = "true" <?php } ?>>Chhattisgarh</option>
												<option value="Dadra and Nagar Haveli" <?php if($state!='' && $state=='Dadra and Nagar Haveli'){?> selected = "true" <?php } ?>>Dadra and Nagar Haveli</option>
												<option value="Daman and Diu" <?php if($state!='' && $state=='Daman and Diu'){?> selected = "true" <?php } ?>>Daman and Diu</option>
												<option value="Delhi" <?php if($state!='' && $state=='Delhi'){?> selected = "true" <?php } ?>>Delhi</option>
												<option value="Goa" <?php if($state!='' && $state=='Goa'){?> selected = "true" <?php } ?>>Goa</option>
												<option value="Gujarat" <?php if($state!='' && $state=='Gujarat'){?> selected = "true" <?php } ?>>Gujarat</option>
												<option value="Haryana" <?php if($state!='' && $state=='Haryana'){?> selected = "true" <?php } ?>>Haryana</option>
												<option value="Himachal Pradesh" <?php if($state!='' && $state=='Himachal Pradesh'){?> selected = "true" <?php } ?>>Himachal Pradesh</option>
												<option value="Jammu and Kashmir" <?php if($state!='' && $state=='Jammu and Kashmir'){?> selected = "true" <?php } ?>>Jammu and Kashmir</option>
												<option value="Jharkhand" <?php if($state!='' && $state=='Jharkhand'){?> selected = "true" <?php } ?>>Jharkhand</option>
												<option value="Karnataka" <?php if($state!='' && $state=='Karnataka'){?> selected = "true" <?php } ?>>Karnataka</option>
												<option value="Kerala" <?php if($state!='' && $state=='Kerala'){?> selected = "true" <?php } ?>>Kerala</option>
												<option value="Lakshadweep" <?php if($state!='' && $state=='Lakshadweep'){?> selected = "true" <?php } ?>>Lakshadweep</option>
												<option value="Madhya Pradesh" <?php if($state!='' && $state=='Madhya Pradesh'){?> selected = "true" <?php } ?>>Madhya Pradesh</option>
												<option value="Maharashtra" <?php if($state!='' && $state=='Maharashtra'){?> selected = "true" <?php } ?>>Maharashtra</option>
												<option value="Manipur" <?php if($state!='' && $state=='Manipur'){?> selected = "true" <?php } ?>>Manipur</option>
												<option value="Meghalaya" <?php if($state!='' && $state=='Meghalaya'){?> selected = "true" <?php } ?>>Meghalaya</option>
												<option value="Mizoram" <?php if($state!='' && $state=='Mizoram'){?> selected = "true" <?php } ?>>Mizoram</option>
												<option value="Nagaland" <?php if($state!='' && $state=='Nagaland'){?> selected = "true" <?php } ?>>Nagaland</option>
												<option value="Orissa" <?php if($state!='' && $state=='Orissa'){?> selected = "true" <?php } ?>>Orissa</option>
												<option value="Puducherry" <?php if($state!='' && $state=='Puducherry'){?> selected = "true" <?php } ?>>Puducherry</option>
												<option value="Punjab" <?php if($state!='' && $state=='Punjab'){?> selected = "true" <?php } ?>>Punjab</option>
												<option value="Rajasthan" <?php if($state!='' && $state=='Rajasthan'){?> selected = "true" <?php } ?>>Rajasthan</option>
												<option value="Sikkim" <?php if($state!='' && $state=='Sikkim'){?> selected = "true" <?php } ?>>Sikkim</option>
												<option value="Tamil Nadu" <?php if($state!='' && $state=='Tamil Nadu'){?> selected = "true" <?php } ?>>Tamil Nadu</option>
												<option value="Telangana" <?php if($state!='' && $state=='Telangana'){?> selected = "true" <?php } ?>>Telangana</option>
												<option value="Tripura" <?php if($state!='' && $state=='Tripura'){?> selected = "true" <?php } ?>>Tripura</option>
												<option value="Uttarakhand" <?php if($state!='' && $state=='Uttarakhand'){?> selected = "true" <?php } ?>>Uttarakhand</option>
												<option value="Uttar Pradesh" <?php if($state!='' && $state=='Uttar Pradesh'){?> selected = "true" <?php } ?>>Uttar Pradesh</option>
												<option value="West Bengal" <?php if($state!='' && $state=='West Bengal'){?> selected = "true" <?php } ?>>West Bengal</option>
									<button class="btn btn-danger">SUBMIT</button>
									<p class="text-center">By signing up you accept you are 18+ and agree to our <a href="#.">T & C</a></p> 
								</select>
										<label for="referral">Referral Code</label>
            <input type="text" class="form-control input-sm" readonly="readonly"  id="referral" placeholder="" name="referral" value="<?php echo $refcod; ?>">
            
            <br>
										<input type="submit" class="btn btn-primary" value="Update"/>
									</div>
								</div>
							</div>
							
							
							
						</div>
						</form>
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