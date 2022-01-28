<?php
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

    $gamedomainlink='';
    $getipconf = "SELECT * FROM `ip_conf`  where id = 1 ";
    $resultipconf = $conn->query($getipconf);
    $rowipconf = $resultipconf->fetch_assoc();
    $tournamentdomainlink=$rowipconf['tlink'];


	
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
				<hr>
				<div class="row contact-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-7">
						<div class="row black-ft">
							<div class="col-md-12">
								<h3 class="color-white text-center mt20"><b>Tournaments</b></h3>
								<div class="tournaments-wrapper">
									<div class="col-md-12">
						<div class="box">							
							<div class="box-body">
								<div class="table-responsive" style="overflow-x: scroll;!important">
									<table id="tournament_list" class="table table-bordered"  style="background-color: white;font-size: 13px;">
										<thead>
											<tr>
												<th >Sr No.</th>
												<th>Name</th>
												
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
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->
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

		function join_tournament ( tour_id )  {
			$("#btnjoin_" + tour_id).hide();
			$.ajax({
				method: "POST",
	            url: 'tournaments-check.php',
	            data: {
	                action: "join",
	                tour_id: tour_id	                
	            },
				success:function(response){
					if( response == "success" ) {

					} else if( response == "money" ) {
						$(this).show();
						alert("You have not enough points.");
					} else if( response == "timeout" ) {
						$(this).show();
						alert("Registration Time out");
					} else {
						$(this).show();
						alert("Join Failed");
					}
	    		}
	    	});
		}

		function withdraw_tournament ( tour_id )  {
			$("#btnwithdraw_" + tour_id).hide();
			$.ajax({
				method: "POST",
	            url: 'tournaments-check.php',
	            data: {
	                action: "withdraw",
	                tour_id: tour_id
	            },
				success:function(response){
					if( response == "success" ) {
						
					} else if( response == "timeout" ) {
						$(this).show();
						alert("Registration Time out");
					} else {
						$(this).show();
						alert("withdraw Failed");
					}
	    		}
	    	});
		}

		function takeseat_tournament ( tour_id )  {
			var user = "<?php echo $loggeduser ?>";
			var w_six = window.open('<?php echo $tournamentdomainlink;?>/join_tournament?tournament_id='+tour_id+'&user='+user+'','Six Player Rummy','width=1000,height=655','_blank');
		}

		function detail_tournament ( tour_id )  {			
			$.ajax({
				url:"tournament-view.php?famID="+tour_id,
				cache:false,
				success:function(result){
	        		$(".modal-content").html(result);
	    		}
	    	});
		}

		function loadTable() {
			$.ajax({
	            method: "POST",
	            url: 'tournaments-check.php',
	            data: {
	                action: "list",
	            },
	            success: function (response) {
	            	data = JSON.parse(response);
					var tableContent = "";
					for (i = 0; i < data.length; i++) {
						var tourn = data[i];
						tableContent += "<tr>";
						tableContent += "<td>" + (i + 1) + "</td>";
						tableContent += "<td>" + tourn.title + "</td>";
						tableContent += "<td>" + tourn.entry_fee + "</td>";
						tableContent += "<td>" + tourn.price + "</td>";
						tableContent += "<td>" + tourn.players + "/" + tourn.all_players + "</td>";
						tableContent += "<td>" + tourn.start_date + "</td>";
						tableContent += "<td>" + tourn.start_time + "</td>";
						
						if( tourn.ended ) {
							tableContent += "<td><div class='btn btn-danger'>Completed</div></td>";
						} else {
							if( tourn.joined ) {
								if( tourn.started ) {
									tableContent += "<td><div id='btntakeseat_"+ tourn.id +"' class='btn btn-info' onClick='takeseat_tournament(" + tourn.id + ")'>Take Your Seat</div></td>";
								} else if( tourn.regtime ) {
									tableContent += "<td><div id='btnwithdraw_"+ tourn.id +"' class='btn btn-warning' onClick='withdraw_tournament(" + tourn.id + ")'>Withdraw</div></td>";
								} else {
									tableContent += "<td><div class='btn btn-info disabled'>Take Your Seat</div></td>";
								}
							} else {
								if( tourn.regtime ) {								
									tableContent += "<td><div id='btnjoin_"+ tourn.id +"' class='btn btn-success' onClick='join_tournament(" + tourn.id + ")'>Join</div></td>";
								} else if( tourn.started ) {
									tableContent += "<td><div class='btn btn-danger'>Completed</div></td>";
								} else {
									tableContent += "<td></td>";
								}
							}
						}


						tableContent += "<td><div class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' onClick='detail_tournament(" + tourn.id + ")'>Details</div></td>";
						tableContent += "</tr>";
					}
					$("#tournament_list > tbody").html(tableContent);
					
	            }
	        });
		}

		$(document).ready(function () {
			$('#tournament_list').DataTable({});

			loadTable();
			setInterval( loadTable , 2000 );
		});
		</script>
		
		
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content">

        </div>
    </div>
</div>
 <div class="tournaments-type">

</div>
     
</body>

</html>

