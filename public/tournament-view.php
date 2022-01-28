<?
include ('database.php');
$famID=$_GET['famID'];

$query="SELECT * FROM tournament WHERE tournament_id=".$famID;

$result_tour 	= $conn->query($query);
$rowtour 		= $result_tour->fetch_assoc();


$famSDate 		=$rowtour['start_date'];
$famTime 		=$rowtour['start_time'];
$famType		=$rowtour['title'];
$famPlayer		=$rowtour['no_of_player'];
$famReg 		=$rowtour['reg_start_date'];
$famRegtime 	=$rowtour['reg_start_time'];
$famEnd 		=$rowtour['reg_end_date'];
$famRegendtime	=$rowtour['reg_end_time'];
$famFee 		=$rowtour['entry_fee'];
$famPosition	=$rowtour['famPosition'];
$famPrice 		=$rowtour['price'];
$famDesc 		=$rowtour['description'];


$sqlallprice="SELECT * FROM price_distribution WHERE tournament_id='".$famID."'";
$result = $conn->query($sqlallprice);

?>
 <style type = "text/css">
     .scroll {
        display:block;
        border: 1px solid ;
        padding:5px;
        margin-top:5px;
        width:400px;
        height:100px;
        overflow:scroll;
     }
         
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h3 class="modal-title" id="fam_id" align="center"><strong><?php echo $famType;?></strong></h3>
</div>
<div class="modal-body">
    <form id="form1" method="post">
                <div class="container">
	<div class="row">
		<div class="col-lg-5">
			<p>
				Tournament Start Date : <?php echo $famSDate;?><br>
				Tournament Start Time :  <?php echo $famTime;?><br>
				Game Type:    <?php if($famFee=='Free'){echo $famFee;}else{echo "Paid";}?><br>
				Number Of Playes:   <?php echo $famPlayer;?><br>
			</p>
		</div>
		<div class="col-lg-5">
			Registeration Date & Time: <?php echo $famReg;?>, <?php echo $famRegtime;?> <br>
			End Date & Time: <?php echo $famEnd;?>, <?php echo $famRegendtime; ?><br>
			Entry Fees: <?php echo $famFee;?><br>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-5">
			<h3>Price Distribution:</h3>
				<div class="ex3 table-responsive scroll" >
						<table style="text-align:center;" class="table table-bordered table-hover">
							<thead>
								<th>Positions</th>
								<th>Price</th>
								<th>Players</th>
							</thead>
							<tbody>
								<tr>
								    <?php 
								    while($row=$result->fetch_assoc()){
								        ?>
									<td><?php echo $row['position'];?></td>
									<td><?php echo $row['price'];?></td>
									<td><?php echo $row['no_players'];?></td>
									
								
									
									<!--<td><?php //echo $famPrice;?></td>
									<td><?php //echo $famPlyrs;?></td>-->
									
								</tr>
									<?php } ?>
							</tbody>
						</table>
				</div>
		</div>
		<div class="col-lg-5" >
			<h3>Description:</h3>
<div class="ex3 scroll"  ><?php echo $famDesc;?></div>
		</div>
	</div>
	<div class="row"><br></div>
	<div class="row">
		<div class="col-lg-6">
			<p style="border: 1px solid #c6c5c5;background: #eaeaea;font-size: xx-large;">
			    <?php 
			    date_default_timezone_set("Asia/Kolkata");
			    $dt = new DateTime();
     echo $dt->format('l, F j, Y H:i:sa');?>
				
			</p>
		</div>
		<!--<div class="col-lg-6">
			<button name="btnSubmit" type="submit" class="btn btn-success">Join Now</button>
		</div>-->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p>
				All tournaments prices are subject to number of players joined and played the tournaments.<br>
				<strong>Price Distribution:</strong>Company keeps all rights to distribute or cancel or modify any time without any notification.
			</p>
		</div>
	</div>
</div>
        
    </form>
</div>

