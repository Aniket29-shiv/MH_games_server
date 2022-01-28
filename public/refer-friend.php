<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
 if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
{
$loggeduser =  $_SESSION['logged_user'];
include 'database.php';
	//include('Classes/class.phpmailer.php');
	include 'php/Mail.php';
include 'php/Mail/mime.php' ;
include('email/sendEmail.php');
$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
	}	
}
else {
echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
header("Location:index.php");
}


$sql1 = "SELECT * FROM users  where username = '".$loggeduser."'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
$userid=$row1['user_id'];



$message='';

    //========Sended Mail
    if(isset($_POST['send'])){
        
        $message2=$_POST['message'];
        $uid=$_POST['uid'];
        $emails=$_POST['emails'];
        $emailarray = explode (",", $emails);  
        $cdate=date('Y-m-d H:i:s');
        $loggeduser =  $_SESSION['logged_user'];
        
        if($emails != ''){
                    
                    
                    foreach ( $emailarray as $email){ 
                        
                        $emailforsend=trim($email);
                         $subject="Refferal Link From  Rummysahara. ";
                        //===Sende Mail INsered
                        $sql2 = "INSERT INTO `referral_send`( `referral_id`, `ref_username`, `receiver`, `subject`, `content`, `date`) VALUES ('".$uid."','".$loggeduser."','".$emailforsend."','".$subject."','".$message2."','".$cdate."')";
                        $conn->query($sql2);
                        
                      
                        //==================old email send
                           
                            $to=$emailforsend;
                            $message1='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
                            <div style="background:#ffffff;padding:20px">
                            <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
                            <div style=" text-align:center;">
                            <a href="'.MAINLINK.'">
                            <img src="'.LOGO.'" style="width:150px;" />
                            </a>
                            </div>
                            </div>			  
                            <div>
                            <p style="margin:0px 0px 10px 0px">
                            <p>Hi,</p><br />
                          
                            <p>  '.$message2.'</p>
                             <p>Thank you,</p>
                            <a href="'.MAINLINK.'">
                            <p>Team RummySahara</p>
                            </a>
                            </div>
                            <div>
                            </div>
                            </div>
                            </div>';
                           if(bulkMail($to,$subject,$message1)){
                        
                               $message .="Email Sending Successfully-".$to."</ br>";   
                           }else{
                                 $message .="Email  Sending  UnSuccessfully-".$to."</ br>";   
                           }
                            
                    } 
                    
                   
        }else{
            $message="Email ID Required";
               
                 
        }
    }
?>
</DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">	
		<link href="../css/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
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
				</div>or paste it into the address bar of your browser-->
				<?php if($message != ''){?>
				<p style="text-align:center;"><span style="background: #c3e2c3; padding: 6px;"><?php echo $message;?></span></p>
				<?php }?>
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row">
							<h3 class="color-black text-center mt20"><b>Refer A Friend</b></h3>
							<div class="bg-grey">
								<h5 style="margin-left:10px;">Reference Link :
								<a href="<?php echo MAINLINK;?>/public/registration.php?referral_id=<?php echo $userid;?>"  style="color:black;"><?php echo MAINLINK;?>/public/registration.php?referral_id=<?php echo $userid;?></a>
								
								<p  style="color:black;margin-left:10px;">* Share This Link On Social Media Sites By Just Copy And Paste With Your Friend &amp; Colleague.</p>
								</br>
								Share : <a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo MAINLINK;?>/public/registration.php?referral_id=<?php echo $userid;?>"><img src="../images/facebook.jpg" style="width:28px; margin-left: 5px;"></a></h5>
								<hr>
								<p style="color:black; margin-left:5px;padding:5px;">Invite Friends By Sending Mails :</p>	
								<form id="" action="" method="post">
								    <div class="col-md-12">
								        
								        <div class="col-md-2">
								        	<label style="color:white;margin-top:54px;">Message</label>
								        </div>
								        
								        <div class="col-md-10 account-cont-wrapper1" ><textarea class="mt20 textarea" style="color:black!important;height:96px; width:100%;" name="message"  readonly="readonly"><?php echo $_SESSION['logged_user'];?> has invited you to join rummysahara.com to become a member of rummysahara.com. Click the link below. </p><p style="text-align: center; margin-top: 38px;"><span style=" background: #a50b0b;padding: 12px;"><a href="<?php echo MAINLINK;?>public/registration.php?referral_id=<?php echo $userid;?>" target="_blank" rel="noreferrer" style="color: white;">Click Here</a></span></textarea>
								        </div>
								
									
									</div>
									
									<div class="col-md-12">
								        <div class="col-md-2">	<label style="color:white;margin-top:54px;">To</label></div>
								          <div class="col-md-10">
								              <textarea  name="emails" placeholder="Add Multiple Email IDs Seperated With ',' and Without Space." style="color:black;height:96px; width:100%; margin-top: 18px;"></textarea>
								            </div>
									</div>
									 <div class="col-md-12" style="text-align:center;">
									     <input type="hidden"  name="uid" value="<?php echo $userid; ?>">
								        <input type="submit"  style="margin-top: 19px;width: 10%;"   class="btn btn-primary" name="send" value="Send">
									</div>
								</form>
								</div>
								
									
									</div>
								<div class="col-md-12 col-sm-7" style="margin-top:94px;">
						<div class="row">
									<div class="table-responsive " style="height: 500px;background: white;overflow: auto;">
									<table class="table table-bordered"  style='background-color: white;font-size: 13px;'>
										<thead>
											<tr style='background-color: wheat;'>
												<th style="width:1%;text-align:center;font-size: 12px;">Sr No</th>
											<!--	<th style="width:1%;text-align:center;font-size: 12px;">Referral Username</th>
												<th style="width:1%;text-align:center;font-size: 12px;">Referral Name</th>-->
												<!--	<td><?php //echo $row['ref_username']; ?></td>
												<td><?php //echo $row['refrral_name']; ?></td>-->
												<th style="width:1%;text-align:center;font-size: 12px;"> Username</th>
												<th style="width:1%;text-align:center;font-size: 12px;"> Name</th>
												<th style="width:1%;text-align:center;font-size: 12px;"> Bonus</th>
												<th style="width:1%;text-align:center;font-size: 12px;">Date</th>
										
											</tr>
										</thead>
										<tbody >
											<?php 
											
										 $query1  = "select * from `referral_bonus` where `referral_id` ='".$userid."'";
	                                        	$result2 = $conn->query($query1);
												$i=1;
											if($result2->num_rows > 0){
													while($row = $result2->fetch_assoc())
													{
													    
													
											?>
											<tr> 
												<td><?php echo $i; ?></td>
												
											
												<td><?php echo $row['username']; ?></td>
												<td><?php echo $row['user_full_name']; ?></td>
												<td><?php echo $row['ref_bonus']; ?></td>
												<td><?php echo $row['date']; ?></td>
											</tr>
										
										<?php	} }else{ ?>
										<tr> 
												<td colspan="5"><span style="color:red;">Sorry! Data Not Found.</span></td>
												</tr>
										
										
										<?php	}  ?>
											 
										</tbody>
									</table>
								</div>
								
								
							</div>
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
		<script src="../js/bootstrap3-wysihtml5.all.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		});
	</script>
	 <script>
	$(function () {	$(".textarea").wysihtml5();	});
   </script>
</html>
<?php } ?>