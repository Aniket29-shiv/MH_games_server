<?php

echo "fsdfdsfgdsgdg";exit;
session_start();
 
 if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
{
$loggeduser =  $_SESSION['logged_user'];
include 'database.php';

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
//$conn->close();

 $sqluser="select user_id from users where username='".$loggeduser."'"; 
$resultusr=$conn->query($sqluser);
$rowusr=$resultusr->fetch_assoc();
$userid=$rowusr['user_id'];

 $sqchkusr="select player_id,tournament_id,	created_time from join_tournaments where player_id='".$userid."'";
$result11=$conn->query($sqchkusr);
$rowusrr=$result11->fetch_assoc();
$joinp=$rowusrr['player_id'];
 $tiddee= $rowusrr['tournament_id'];
 $joindate=$rowusrr['created_time'];
?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <div class="tournaments-type">

        </div>
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
				<hr>
				<div class="row contact-wrapper mt20">
					<div class="col-md-3 col-sm-4">
						<nav>
							<div class="dropdown over-hid">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									Rummy Lobby
									<i class="fa fa-angle-down ml15" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li><a href="point-lobby-rummy.php">Point Rummy</a></li><hr class="mt0 mb0">
									<li><a href="pool-lobby-rummy.php">Pool Rummy</a></li><hr class="mt0 mb0">
									<li><a href="deal_lobby_rummy.php">Deal Rummy</a></li><hr class="mt0 mb0">
									
								</ul>
							</div>
							<hr class="mt0 mb0">
							<div class="dropdown over-hid">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									Free Rummy Lobby
									<i class="fa fa-angle-down ml15" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li><a href="point-fun-games.php">Point Rummy</a></li><hr class="mt0 mb0">
									<li><a href="pool-fun-games.php">Pool Rummy</a></li><hr class="mt0 mb0">
									<li><a href="deal_rummy_fun.php">Deal Rummy</a></li><hr class="mt0 mb0">
									
								</ul>
							</div>
							<hr class="mt0 mb0">
							<ul>
								<li><a href="#" class="over-hid">Tournaments</a></li><hr class="mt0 mb0">
							</ul>
							<div class="dropdown over-hid">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									My Account
									<i class="fa fa-angle-down ml15" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li><a href="my-account.php" class="over-hid">My Account</a></li><hr class="mt0 mb0">
									<li><a href="my-profile.php">My Profile</a></li><hr class="mt0 mb0">
									<li><a href="buy-chips.php">Add Money</a></li><hr class="mt0 mb0">
									<li><a href="change-password.php">Change Password</a></li><hr class="mt0 mb0">
									<li><a href="my-transactions.php">My Transactions</a></li><hr class="mt0 mb0">
									<li><a href="withdrawals.php">Withdrawals</a></li><hr class="mt0 mb0">
									<li><a href="bank-details.php">Bank Details</a></li><hr class="mt0 mb0">
									<li><a href="update-kyc.php">Update KYC</a></li>
								</ul>
							</div>
							<hr class="mt0 mb0">
							<ul>
								<li><a href="account-contact-us.php" class="over-hid">Help & Support</a></li>
							</ul>
						</nav>
					</div>
					<div class="col-md-9 col-sm-7">
						<div class="row">
							<div class="col-md-12">
								<h3 class="color-white text-center mt20"><b>Tournaments</b></h3>
								<div class="tournaments-wrapper">
									<div class="col-md-12">
						<div class="box">							
							<div class="box-body">
								<div class="table-responsive" style="overflow-x: scroll;!important">
								<form method="post" id="formuser" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<table id="user_details" class="table table-bordered"  style='background-color: white;font-size: 13px;'">
										<thead>
											<tr>
												<th >Sr No.</th>
												<th>Name</th>
												<th>Image</th>
												<th style="width:20%;">Entry Fee</th>
												<th>Price</th>
												<th>Joined</th>
												<th style="width:25%;">Start Date</th>
												<th style="width:20%;">Start Time</th>
											
												<th>Action</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
                                            	include ('lock.php');
	
	//$query = "SELECT t.tournament_id,t.title,t.price as 'Price',t.title,t.start_date,t.start_time,t.reg_start_date,t.reg_start_time,t.reg_end_time,t.entry_fee,t.no_of_player,t.description,t.file,t.created_date,t.updated_date,p.price,p.position,p.no_players FROM tournament t LEFT JOIN price_distribution p ON t.tournament_id = p.tournament_id";
	
	$query="Select * from tournament order by tournament_id desc";
	
	$result = $conn->query($query); 
											$i=1; if($result->num_rows > 0){ 
												while($row=$result->fetch_assoc()){ 
											                                     $turrid=$row['tournament_id'];
											                                    
											                                     
             $sqlallprice="Select count(*) as 'total' from join_tournaments where tournament_id='".$row['tournament_id']."'";
                $result1 = $conn->query($sqlallprice);
                $row1=$result1->fetch_assoc();
                $noofplys=$row1['total'];
                        ?>
											<tr>
												<td><?php echo $i; ?></td> 
														<td><?php echo $row['title']; ?></td> 
											<td><img src="<?php echo $row['file']; ?>" alt=""  width="80"></td> 
														 
												<td id=""><?php echo $row['entry_fee']; ?></td> 
								                <td><?php echo $row['price']; ?></td>
								                <td><?php echo $noofplys; ?>/<?php echo $row['no_of_player']; ?></td>
								                 <td><?php echo $row['start_date']; ?></td>
								                <td><?php echo $row['start_time']; ?></td>
								                <input type="hidden" name="tournament_id" value="<?php echo $row['tournament_id']?>">
								                
								                <!--<td><?php $now = date("G:i:s");echo $now;?></td>-->
								                <td>
								                    <?php
								                   $now = date("H:i:s");
								                    $date=date('Y-m-d');
								                  
		   // echo $row['reg_end_time']."==" .$now ; exit;
								                  
                                               if($row['reg_end_time'] >$now && $row['reg_end_date'] == $date){
                                                   
                                                 
                                                   if($joinp!=$userid && $tiddee!=$turrid  ){
                                          
                                                  
                                                  ?>
                                                  <button name="btnSubmit" type="submit" id="add" class="btn btn-success" data-id="<?php echo $row['tournament_id'];?>" data-time="<?php echo $row['start_time']; ?>" data-title="<?php echo $row['title']; ?>" data-player="<?php echo $row['no_of_player']; ?>" data-reg="<?php echo $row['reg_start_date']; ?>" data-rtime="<?php echo $row['reg_start_time']; ?>" data-end="<?php echo $row['reg_start_date']; ?>" data-fee="<?php echo $row['entry_fee'] ?>"  data-price="<?php echo $row['price'] ?>" data-plyrs="<?php echo $row['no_players'] ?>" data-startdate="<?php echo $row['start_date'] ?>" data-desc="<?php echo $row['description'] ?>"data-regendtime="<?php echo $row['reg_end_time'] ?>">Join</button>
                                                
                                                <?  }else if($joinp==$userid && $tiddee!=$turrid ){
                                                    ?>
                                                    <button name="btnSubmit" type="submit" id="add" class="btn btn-success" data-id="<?php echo $row['tournament_id'];?>" data-time="<?php echo $row['start_time']; ?>" data-title="<?php echo $row['title']; ?>" data-player="<?php echo $row['no_of_player']; ?>" data-reg="<?php echo $row['reg_start_date']; ?>" data-rtime="<?php echo $row['reg_start_time']; ?>" data-end="<?php echo $row['reg_start_date']; ?>" data-fee="<?php echo $row['entry_fee'] ?>"  data-price="<?php echo $row['price'] ?>" data-plyrs="<?php echo $row['no_players'] ?>" data-startdate="<?php echo $row['start_date'] ?>" data-desc="<?php echo $row['description'] ?>"data-regendtime="<?php echo $row['reg_end_time'] ?>"> Join</button>
                                               <? }
                                                
                                                
                                                else if($joinp==$userid && $tiddee==$turrid){?>
                                                 
                                                 <button name="btnwithdraw" type="submit" id="add1" class=" btn btn-warning">Withdraw</button>
                                                  <?php 
                                                }
                                                include ('lock.php');
	//include ('config.php');
                  if(isset($_POST['btnSubmit']) ){
                      
                                         $tid=$row['tournament_id'];
                                        $fee=$row['entry_fee'];
                                    $created_time= date('Y-m-d H:i:s');
                               
                                    
                                    if($fee=='Free'){
                                        
            $query="INSERT INTO `join_tournaments`(`player_id`, `tournament_id`, `fees`, `created_time`) VALUES ('".$userid."','$tid','$fee','$created_time')";
                                    }
                                    else{
                                     
                  $sqlpaychip="select real_chips from accounts where userid='".$userid."'"; 
                    
                    	$resultchip = $conn->query($sqlpaychip);
                    	$rowchip=$resultchip->fetch_assoc();
                    	$realchipval=$rowchip['real_chips'];
                    	
                    	if($realchipval==0){
                    	    
                    	    echo '<script language="javascript">';
                        echo 'alert("You do not have sufficent points")';
                            echo '</script>';
                            exit;
                            header("Location:tournaments.php");
                            
                    	}
                    	else{
                    	    
                    	    
                    	    $valuereal=$realchipval-$fee;
                    	  //echo  $valuereal;exit;
                    	      $queryup="update accounts set real_chips= '".$valuereal."' where userid='".$userid."'" ;  
                  $resultrel = $conn->query($queryup);
                    	
        	
     
  $query="INSERT INTO `join_tournaments`(`player_id`, `tournament_id`, `fees`, `created_time`) VALUES ('".$userid."','$tid','$fee','$created_time')"; 
 // echo $query; }
                                   } }
		$result = $conn->query($query);
		$tournament_id = $conn->insert_id;
		if($result){
		    
		//    echo "inserted successfully";
		     
		    ?>
		     
		    <?php
		}else{?>
		    
			<? echo "not inserted successfully";
		}
                                                  }
                                                  
                                   if(isset($_POST['btnwithdraw']))  {
                                       
                                       
                  $sqljoinid="select id, fees from join_tournaments where player_id ='".$userid."' "  ; 
                  
                  $resultid=$conn->query($sqljoinid);
                  
                  $row=$resultid->fetch_assoc();
                  $joinid=$row['id'];
                  $feee=$row['fees'];
                  
                $sqlpaychip1="select real_chips from accounts where userid='".$userid."'"; 
                    
                    	$resultchip1 = $conn->query($sqlpaychip1);
                    	$rowchip1=$resultchip1->fetch_assoc();
                    	$realchipval1=$rowchip1['real_chips'];
                    	
                   	$valuereal1=$realchipval1+$feee; 
                    	
                  $sqldeljoin="delete from join_tournaments where id='".$joinid."'";
                  $resultdel=$conn->query($sqldeljoin);
                  
                  $sqlup="update accounts set real_chips ='".$valuereal1."' where userid='".$userid."'" ;
                                       
                                   $resultdelll=$conn->query($sqlup);   
                                   
                                   }             
                                                  
                                                  
                                               }
              
                                 if($row['start_time']==$now && $row['reg_start_date'] == $date ){
                                    
                                
                                              ?>      
                                             <button class="btn btn-info" >Take a Seat</button>       
                                               <? }
                                                   if($row['start_time']<$now)
                                                  {?>
                                                 <button class="btn btn-danger" disabled>Time Up!!</button>
                                                   <?php }?>
                                                  </td>
								              <td>
	<a class="modalLink" href="#myModal" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row['tournament_id'];?>" data-time="<?php echo $row['start_time']; ?>" data-title="<?php echo $row['title']; ?>" data-player="<?php echo $row['no_of_player']; ?>" data-reg="<?php echo $row['reg_start_date']; ?>" data-rtime="<?php echo $row['reg_start_time']; ?>" data-end="<?php echo $row['reg_start_date']; ?>" data-fee="<?php echo $row['entry_fee'] ?>"  data-price="<?php echo $row['price'] ?>" data-plyrs="<?php echo $row['no_players'] ?>" data-startdate="<?php echo $row['start_date'] ?>" data-desc="<?php echo $row['description'] ?>"data-regendtime="<?php echo $row['reg_end_time'] ?>"><button class="btn btn-primary btn-sm">Details</button></a>
												
											</td>	
											</tr> 
											<?php $i++; } }  ?>
										</tbody>
									</table>
							
								</div>
							</div>
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
				</form>
				<!-- /.row -->
			</section>
			<!-- /.content -->
		</div><?php } $conn->close();?>
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
	



    
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/dataTables.bootstrap.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		});
	</script>
	
	<script>
		$(function(){
			
					$('#user_details').DataTable(
					    
					    {
} 
					    )
					    
			});
				      function theFunction (id) {
							          
     var answer = confirm('Are you sure you want to delete this?');
if (answer)
{
    alert('yes'+id);
  console.log('yes');
  window.location = "tournament-del.php?id="+id;
}
else
{
    alert('No'+id);
  console.log('cancel');
}
    }
			
	</script>
	
	
			<script>
		
	 $('.modalLink').click(function(){
	 
    var famID=$(this).attr('data-id');
    var famTime=$(this).attr('data-time');
    var famType=$(this).attr('data-title');
    var famPlayer=$(this).attr('data-player');
    var famReg=$(this).attr('data-reg');
    var famRegtime=$(this).attr('data-rtime');
    var famEnd=$(this).attr('data-end');
    var famFee=$(this).attr('data-fee');
   // var famPosition=$(this).attr('data-position');
    var famPrice=$(this).attr('data-price');
    var famPlyrs=$(this).attr('data-plyrs');
    var famDesc=$(this).attr('data-desc');
    var famSDate=$(this).attr('data-startdate');
    var famRegendtime=$(this).attr('data-regendtime');
  
   // alert(famID);
    
    $.ajax({url:"tournament-view.php?famID="+famID+"&famTime="+famTime+"&famType="+famType+"&famPlayer="+famPlayer+"&famReg="+famReg+"&famRegtime="+famRegtime+"&famEnd="+famEnd+"&famFee="+famFee+"&famPrice="+famPrice+"&famPlyrs="+famPlyrs+"&famSDate="+famSDate+"&famDesc="+famDesc+"&famRegendtime="+famRegendtime,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});
		</script>
		
		
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true" data-keyboard="false">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content">

        </div>
    </div>
</div>

			<script>
		
	 $('#add').click(function(){
	 
    var famID=$(this).attr('data-id');
    var famTime=$(this).attr('data-time');
    var famType=$(this).attr('data-title');
    var famPlayer=$(this).attr('data-player');
    var famReg=$(this).attr('data-reg');
    var famRegtime=$(this).attr('data-rtime');
    var famEnd=$(this).attr('data-end');
    var famFee=$(this).attr('data-fee');
   // var famPosition=$(this).attr('data-position');
    var famPrice=$(this).attr('data-price');
    var famPlyrs=$(this).attr('data-plyrs');
    var famDesc=$(this).attr('data-desc');
    var famSDate=$(this).attr('data-startdate');
    var famRegendtime=$(this).attr('data-regendtime');
  
   // alert(famID);
    
    $.ajax({url:"tournaments.php?famID="+famID+"&famTime="+famTime+"&famType="+famType+"&famPlayer="+famPlayer+"&famReg="+famReg+"&famRegtime="+famRegtime+"&famEnd="+famEnd+"&famFee="+famFee+"&famPrice="+famPrice+"&famPlyrs="+famPlyrs+"&famSDate="+famSDate+"&famDesc="+famDesc+"&famRegendtime="+famRegendtime,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});
		</script>

</body>

</html>

