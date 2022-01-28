<!DOCTYPE html>
<html>
<head>
	<title>RummyStore</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="favicon.ico" rel="shortcut icon" type="image/ico">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="/socket.io/socket.io.js"></script>
	<script src="/jquery.js"></script>
	<script>
		  $(function ()
			{
				var socket = io.connect('http://localhost:8087');
				
				socket.on('connect', function(){
				
				});		 
			});
	</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<img src="storerummy-main-bg.png" width="100%" height="100%" alt="" style="position:absolute; top:0; z-index:-1">
	
	<!-- top menu start -->
	<div class="top-left-menu">
	<h2>Group Id: <script> document.write(grpid);</script></h2>
		<ul>
			<li><a href="#" class="openInfo">Game Info</a></li>&nbsp;
			<li><a href="../buy-chips.html">Buy Chips</a></li>
		</ul>
		<ul style="float:right">
			<li><a href="../point-lobby-rummy.html">Lobby</a></li>&nbsp;
			<li><a href="../account-contact-us.html">Help</a></li>&nbsp;
			<li><a href="rummy-game.html">Refresh</a></li>&nbsp;
			<li><a class="button" href="#popup1">Leave Table</a></li>
		</ul>
	</div>
	<!-- top menu end -->
	
	<!-- game info start -->
	<div class="gameInfo">
		<div style="background:#474749; padding:2% 4%; color:#fff">
			<h4>Game Information</h4>
			<i class="fa fa-times" aria-hidden="true"></i>
		</div>
		<table>
			<tbody>
				<tr>
					<td style="border:none">Table Name</td>
					<td style="border:none">: Rummy World</td>
				</tr>
				<tr>
					<td style="border:none">Game Varient</td>
					<td style="border:none">: Practise Game</td>
				</tr>
				<tr>
					<td style="border:none">Game Type</td>
					<td style="border:none">: Points Rummy</td>
				</tr>
				<tr>
					<td style="border:none">Deal Id</td>
					<td style="border:none">: AAFMF874</td>
				</tr>
				<tr>
					<td style="border:none">Points Value</td>
					<td style="border:none">: 5 point(s)</td>
				</tr>
				<tr>
					<td style="border:none">First Drop</td>
					<td style="border:none">: 20 points</td>
				</tr>
				<tr>
					<td style="border:none">Middle Drop</td>
					<td style="border:none">: 40 points</td>
				</tr>
				<tr>
					<td style="border:none">Full Counts</td>
					<td style="border:none">: 80 points</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- game info start -->
	
	<!-- close popup start -->
		<div id="popup1" class="overlay">
			<div class="popup">
				<div class="content">
					<div style="background:#474749; color:#fff">
						<span>RummyStore.com says...</span>
						<a class="close" href="#" style="text-align:right">&times;</a>
					</div>
					<div class="closepopup" style="background:#231f20">
						<h5>Do want to leave the game table ?</h5>
						<a  id="openandclose">Yes</a>
						<a id="close" href="#">No</a>
					</div>
				</div>
			</div>
		</div>
	<!-- close popup end -->
	
	<!-- top sit here button -->
	<div class="top-chair">
		<div class="front-chair"><img src="chair-4.png"/></div>
		<!-- <div class="male-user"><img src="images/male-4.png"/></div> -->
		<!-- <div class="female-user"><img src="images/female-4.png"/></div>  -->
		<!-- <div class="sit"><img src="images/sithere_btn.png" class="sit-popup"></div> -->
		<div class="ct-loader"><img src="buyin.gif"></div>
		<div class="front-dealer"><img src="dealer-icon.png"></div>
		<div>
			<div class="ct-fif-sec" style="color:#fff">
				15
			</div>
			<div class="ct-twe-sec" style="color:#fff">
				20
			</div>
		</div>
	</div>
	<!-- top sit here button -->
	
	<!-- table pop-up -->
	<div class="table-popup">
		<div>
			<table style="border:none; font-size:13px">
				<tbody>
					<tr>
						<td>Table Name</td>
						<td>: Rummy Season</td>
					</tr>
					<tr>
						<td>Game Type</td>
						<td>: Point Rummy</td>
					</tr>
					<tr>
						<td>Point Value</td>
						<td>: 5</td>
					</tr>
					<tr>
						<td>Min Required</td>
						<td>: 400</td>
					</tr>
					<tr>
						<td>Max Required</td>
						<td>: 4000</td>
					</tr>
					<tr>
						<td>Your Account Bal</td>
						<td>: 8000</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="dis-ib">
			<p class="dis-ib" style="width:70%; font-size:12px">How much would you like to bring amount on this table ?</p>
			<input type="text" style="width:28%"/>
		</div>
		<div style="font-size:12px; color:#ff3300">
			<p style="margin:0px">*Amount should be in min and max required.</p>
		</div>
		<div>
			<img src="buyinwindow-ok-btn.png" class="btn-ok">
			<img src="repoart-prob-cancel-btn.png" class="btn-cancel">
		</div>
	</div>
	<!-- table pop-up -->
	
	<!-- table cards -->
	<div class="table-content-wrapper">
		<div class="joker-card dis-ib">
			<img src="single-aces.png"/>
		</div>
		<div class="close-card dis-ib">
			<img src="single-aces.png"/>
		</div>
		<div class="open-card dis-ib">
			<img src="single-aces.png"/>
		</div>
		<div class="discard-arrow dis-ib">
			<img src="arrow-right.png">
		</div>
		<div class="discard-cards dis-ib">
			<img src="single-aces.png"/>
			<img src="single-aces.png"/>
			<img src="single-aces.png"/>
			<img src="single-aces.png"/>
			<img src="single-aces.png"/>
		</div>
		<div class="finish-card dis-ib">
			<img src="single-aces.png"/>
		</div>
	</div>
	<!-- table cards -->
	
	<!-- declare buttons -->
	<div class="content-buttons">
		<div class="declare-but">
			<img src="declare.png">
		</div>
		<div class="discard-but">
			<img src="discard-btn.png">
		</div>
		<div class="finish-but">
			<img src="finish.png">
		</div>
	</div>
	<!-- declare buttons -->
	
	<!-- declare popup start -->
	<div class="declare-table">
		<table class="table-bordered">
			<tbody>
				<tr>
					<td style="padding:1% 4%" colspan="4">Table Name : Rummy World</td>
					<td class="close-declpop">Close</td>
				</tr>
				<tr style="text-align:center; background:#ff3333">
					<td style="width:12%">User Name</td>
					<td>Show Status</td>
					<td>Results</td>
					<td>Game Score</td>
					<td>Amount Won</td>
				</tr>
				<tr style="text-align:center">
					<td>John Doe</td>
					<td><img src="winner-rummy.jpg" style="width:40%"></td>
					<td class="declare-cards" style="width:60%">
						<div class="decl-group1">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
						<div class="decl-group2">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
						<div class="decl-group3">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
						<div class="decl-group4">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
					</td>
					<td>0</td>
					<td>61.0</td>
				</tr>
				<tr style="text-align:center">
					<td>John Doe</td>
					<td><img src="winner-rummy.jpg" style="width:40%"></td>
					<td class="declare-cards" style="width:50%">
						<div class="decl-group1">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
						<div class="decl-group2">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
						<div class="decl-group3">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
						<div class="decl-group4">
							<img src="single-aces.png">
							<img src="single-aces.png">
							<img src="single-aces.png">
						</div>
					</td>
					<td>5</td>
					<td>70</td>
				</tr>
				<tr class="joker" style="text-align:center">
					<td>Joker</td>
					<td><img src="single-aces.png"></td>
					<td colspan="3" style="text-align:center; padding:2% 0%">Next game will start in : 10</td>
				</tr>
			</body>
		</table>
	</div>
	<!-- declare popup end -->
	
	<!-- rummy cards start -->
	<div class="rummy-cards">
		<!-- <div class="btn-group">
			<button>Group</button>
		</div> -->
		<div class="group1">
			<div class="add-here-1">
				<button>Add Here</button>
			</div>
			<div class="card1">
				<img src="single-aces.png"/>
			</div>
			<div class="card2">
				<img src="single-aces.png"/>
			</div>
		</div>
		<div class="group2">
			<div class="add-here-2">
				<button>Add Here</button>
			</div>
			<div class="card3">
				<img src="single-aces.png"/>
			</div>
			<div class="card4">
				<img src="single-aces.png"/>
			</div>
		</div>
		<div class="group3">
			<div class="add-here-3">
				<button>Add Here</button>
			</div>
			<div class="card5">
				<img src="single-aces.png"/>
			</div>
			<div class="card6">
				<img src="single-aces.png"/>
			</div>
		</div>
		<div class="group4">
			<div class="add-here-4">
				<button>Add Here</button>
			</div>
			<div class="card7">
				<img src="single-aces.png"/>
			</div>
			<div class="card8">
				<img src="single-aces.png"/>
			</div>
		</div>
		<div class="group5">
			<div class="add-here-5">
				<button>Add Here</button>
			</div>
			<div class="card9">
				<img src="single-aces.png"/>
			</div>
			<div class="card10">
				<img src="single-aces.png"/>
			</div>
		</div>
		<div class="group6">
			<div class="add-here-6">
				<button>Add Here</button>
			</div>
			<div class="card11">
				<img src="single-aces.png"/>
			</div>
			<div class="card12">
				<img src="single-aces.png"/>
			</div>
		</div>
		<div class="group7">
			<div class="add-here-7">
				<button>Add Here</button>
			</div>
			<div class="card13">
				<img src="single-aces.png"/>
			</div>
			<div class="card14">
				<img src="single-aces.png"/>
			</div>
		</div>
	</div>
	<!-- rummy cards start -->
	
	<!-- bottom sit here button -->
	<div class="bottom-chair">
		<div class="bott-chair"><img src="chair-1.png"/></div>
		<!-- <div class="bott-female"><img src="images/female-1.png"/></div> -->
		<div class="bott-male"><img src="male-1.png"/></div> 
		<!--<div class="bott-sit"><img src="images/sithere_btn.png" class="sit-popup"></div>-->
		<div class="bot-dealer"><img src="dealer-icon.png"></div>
		<!--<div class="bot-loader"><img src="images/buyin.gif"></div>-->
		<div class="count-down">
			<div class="fif-sec" style="color:#fff">
				15
			</div>
			<div class="twe-sec" style="color:#fff">
				20
			</div>
		</div>
	</div>
	<!-- bottom sit here button -->
	
	<!-- sort drop btton -->
	<div class="sort-drop-but">
		<div class="sort-but">
			<img src="sortbtn.png"/>
		</div>
		<div class="drop-but">
			<img src="Dropbtn.png"/>
		</div>
	</div>
	<!-- sort drop button -->
	
	<!-- bottom menu start -->
	<div class="bottom-menu">
		<div style="text-align:right">
			<i class="fa fa-volume-up" aria-hidden="true"></i>
			<i class="fa fa-signal" aria-hidden="true"></i>
			<label id="minutes">00</label><label> : </label><label id="seconds">00</label>
		</div>
	</div>
	<!-- bottom menu ends -->
</body>
	
	<script src="countdown.js"></script>
	<script src="pop-up.js"></script>
</html>