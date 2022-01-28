<!DOCTYPE html>
<html>
<head>
	<title>RummySahara</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="favicon.ico" rel="shortcut icon" type="image/ico">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style_six.css" rel="stylesheet">
	<script src="/jquery.js"></script>
	<script src="/socket.io/socket.io.js"></script>
	<style>
	#jokerimg span:last-child:after 
	{
       content: "\0004A"; 
       font-size: 150%; 
       padding-left: 10px; 
       float: right; 
       position: relative; 
       top: 15px 
	}

	.tl-info{
		font-size: 18px;
		color: white;
		position: absolute;
		top: 0px;
		left: 50%;
		display: none;
	}

	.tl-time {
		margin-right: 20px;
	}

	.overlay-middle {
		position: fixed;
	    top: 30%;
	    bottom: 0;
	    left: 0;
	    right: 0;    
	    display: none;
	    z-index: 1000;
	}
	.closepopup a {
		cursor: pointer;
	}
	</style>
</head>
<body>
	<div class="table-wrapper">
	<div class="table-playing">
		<img src="/table22.png">
		</div>
		
	<!--<img src="table22.png"  height="400px" alt="" style="position:absolute; margin-left: 4%; margin-top: 18%; z-index:-1">-->
	
	<!-- top menu start -->
	<div class="tl-menu">
		<ul>
			<li><a href="#" class="openInfo">Game Info</a></li>&nbsp;
			<li><a href="#." id="buy_chips">Buy Chips</a></li>
		</ul>
		<ul style="float:right">
			<li><a href="#." id="game_lobby">Lobby</a></li>&nbsp;
			<li><a href="#." id="help">Help</a></li>&nbsp;
			<li><a href="#" id="refresh">Refresh</a></li>&nbsp;
			<li><a class="button" href="#popup1" id="leave_confirm">Leave Table</a></li>
		</ul>
	</div>
	<!-- top menu end -->
	<div class="tl-info">
		<span class="tl-time">

		</span>
		<span class="tl-gamecount">

		</span>
	</div>
	<!-- game info start -->
	<div class="gameInfo">
		<div style="background:#474749; padding:2% 4%; color:#fff">
			<h4>Game Information</h4>
			<i class="fa fa-times" aria-hidden="true"></i>
		</div>
		<table>
			<tbody>
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
						<span>RummySahara says...</span>
						<a class="close" href="#" style="text-align:right">&times;</a>
					</div>
					<div class="closepopup" style="background:#231f20">
						<h5>Do you want to leave the game table ?</h5>
						<a id="leave_group">Yes</a>
						<a id="leave_group_cancel" href="#">No</a>
					</div>
				</div>
			</div>
		</div>
	<!-- close popup end -->
		<div id="popup-confirm" class="overlay-middle">
			<div class="popup">
				<div class="content">
					<div class="closepopup" style="background:#231f20">
						<h5><span id="confirm-msg"></span></h5>
						<a id="confirm-yes">Yes</a>
						<a id="confirm-no">No</a>
					</div>
				</div>
			</div>
		</div>
	<!-- top sit here button -->
	<div class="top-chair">
		<!--<div class="front-chair" id="player_4_chair"><img src="chair-4.png"/></div>-->
		<div class="male-user"><img style="display:none" id="player_4_male_player" src="male-4.png"/></div>
		 <div class="female-user"><img style="display:none" id="player_4_female_player" src="male-4.png"/></div> 
		 <div id="player_4_disconnect" style="position: absolute;
			    top: 29%;right: 40.2%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_4_status"></label> <!-- disconnected-->
		</div>
		<div class="sit"><img id="player_4_sit"   src="chair-456.png" ></div>
		<div class="front-dealer" style="display:none"  id="player_4_dealer"><img src="dealer-icon.png"></div>
		<div class="ct-loader" style="display:none" id="player_4_loader"><img src="buyin.gif"></div>
		<div id="player_4_counts">
			<div class="ct-fif-sec" style="color:#fff" id="player_4_count1">
				<span  id="player4turn"></span>
			</div>
			<div class="ct-twe-sec" style="color:#fff" id="player_4_count2">
				
			</div>
		</div>
	</div>
	<div class="player4" style="display:none;" id="player_4_details">
		<label id="player_4_name"><big><b></b></big></label><br>
		<label id="player_4_amount"><big><b></b></big></label>
		<label id="player_4_poolamount" style="display:none"></label>
	</div>
	<!-- top sit here button -->
	
	<!-- top right user start -->
	<div class="top-right-menu">
		<!--<div class="tr-chair" id="player_3_chair"><img src="chair-3.png"/></div>-->
		<div class="tr-female-user"><img id="player_3_female_player" style="display:none" src="female-3.png"/></div>
		<div class="tr-male-user"><img id="player_3_male_player" style="display:none" src="male-3.png"/></div> 
		<div id="player_3_disconnect" style="position: absolute;
			top: 30%;right: 18%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_3_status"></label>
		</div>
		<div class="tr-sit-here"><img id="player_3_sit" src="chair-33.png" /></div>
		<div class="tr-dealer"><img style="display:none"  id="player_3_dealer" src="dealer-icon.png"/></div>
		<div class="tr-loader"><img style="display:none"  id="player_3_loader" src="buyin.gif"></div>
		<div id="player_3_counts">
			<div class="tr-fif-sec" style="color:#fff"  id="player_3_count1">
				<span  id="player3turn"></span>
			</div>
			<div class="tr-twe-sec" style="color:#fff"  id="player_3_count2">
				
			</div>
		</div>
	</div>
	<div class="player3" style="display:none;" id="player_3_details">
		<label id="player_3_name"><big><b></b></big></label><br>
		<label id="player_3_amount"><big><b></b></big></label>
		<label id="player_3_poolamount" style="display:none"></label>
	</div>
	<!-- top right user start -->
	
	<!-- center right user start -->
	<div class="center-right-menu">
		<!--<div class="cr-chair" id="player_2_chair"><img src="chair-2.png"/></div>-->
		<div class="cr-female-user"><img id="player_2_female_player" style="display:none" src="female-2.png"/></div>
		<div class="cr-male-user"><img id="player_2_male_player" style="display:none" src="male-2.png"/></div>
		<div id="player_2_disconnect" style="position: absolute;
			        top: 59%;
    right: 6%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_2_status"></label> 
		</div>
		<div class="cr-sit-here"><img id="player_2_sit" src="chair-266.png" /></div>
		<div class="cr-dealer"><img style="display:none"  id="player_2_dealer" src="dealer-icon.png"/></div>
		<div class="cr-loader"><img style="display:none"  id="player_2_loader" src="buyin.gif"></div>
		<div id="player_2_counts">
			<div class="cr-fif-sec" style="color:#fff" id="player_2_count1">
				<span  id="player2turn"></span>
			</div>
			<div class="cr-twe-sec" style="color:#fff" id="player_2_count2">
				
			</div>
		</div>
	</div>
	<div class="player2" style="display:none;" id="player_2_details">
		<label id="player_2_name"><big><b></b></big></label><br>
		<label id="player_2_amount"><big><b></b></big></label>
		<label id="player_2_poolamount" style="display:none"></label>
	</div>
	<!-- center right user end -->
	
	<!-- top left user start -->
	<div class="top-left-menu">
		<!--<div class="tl-chair" id="player_5_chair"><img src="chair-5.png"/></div>-->
		<div class="tl-female-user"><img id="player_5_female_player" style="display:none" src="male-5.png"/></div>
		<div class="tl-male-user"><img id="player_5_male_player" style="display:none" src="male-5.png"/></div>
		<div id="player_5_disconnect" style="position: absolute;
			top: 30%;left: 32%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_5_status"></label> 
		</div>
		<div class="tl-sit-here"><img id="player_5_sit" src="chair-56.png" /></div>
		<div class="tl-dealer"><img style="display:none"  id="player_5_dealer" src="dealer-icon.png"/></div>
		<div class="tl-loader"><img src="buyin.gif" style="display:none"  id="player_5_loader"></div>
		<div id="player_5_counts">
			<div class="tl-fif-sec" style="color:#fff" id="player_5_count1">
				<span  id="player5turn"></span>
			</div>
			<div class="tl-twe-sec" style="color:#fff" id="player_5_count2">
				
			</div>
		</div>
	</div>
	<div class="player5" style="display:none;" id="player_5_details">
		<label id="player_5_name"><big><b></b></big></label><br>
		<label id="player_5_amount"><big><b></b></big></label>
		<label id="player_5_poolamount" style="display:none"></label>
	</div>
	<!-- top left user end -->
	
	<!-- center left user start -->
	<div class="center-left-menu">
		<!--<div class="cl-chair" id="player_6_chair"><img src="chair-6.png"/></div>-->
		<div class="cl-female-user" ><img id="player_6_female_player" style="display:none" src="male-6.png"/></div>
		<div class="cl-male-user"><img id="player_6_male_player" style="display:none" src="male-6.png"/></div>
		<div id="player_6_disconnect" style="position: absolute;
			top: 62%;left: 6%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_6_status"></label> 
		</div>
		<div class="cl-sit-here"><img id="player_6_sit" src="sithere_btnlf.png" /></div>
		<div class="cl-dealer" style="display:none"  id="player_6_dealer"><img src="dealer-icon.png"/></div>
		<div class="cl-loader" style="display:none"  id="player_6_loader"><img src="buyin.gif"></div>
		<div id="player_6_counts">
			<div class="cl-fif-sec" style="color:#fff" id="player_6_count1">
				<span  id="player6turn"></span>
			</div>
			<div class="cl-twe-sec" style="color:#fff" id="player_6_count2">
				
			</div>
		</div>
	</div> 
	<div class="player6" style="display:none;" id="player_6_details">
		<label id="player_6_name"><big><b></b></big></label><br>
		<label id="player_6_amount"><big><b></b></big></label>
		<label id="player_6_poolamount" style="display:none;"></label>
	</div>
	<!-- center left user end -->
		
	<!-- table cards -->
	<div class="waiting-msg dis-ib" id="div_msg" style="display:none">
			
	</div>
	<div class="table-content-wrapper">
		<div class="joker-card dis-ib">
				<img src="" id="joker_card"  style="display:none" > 
		</div>
		<div class="close-card dis-ib">
			<img src="" id="closed_cards"  style="display:none" > 
		</div>
		<div class="open-card dis-ib">
				<img src="" id="open_card"  style="display:none" > 
		</div>
		<div class="discard-arrow dis-ib" style="display:none" id="open_deck">
			<img src="arrow-right.png">
		</div>
		<div class="discard-cards dis-ib" id="discareded_open_cards">
		</div>
		<div class="finish-card dis-ib">
			<img src="" id="finish_card">  
		</div>

		<div class="player1_turn_card" style="display:none;">
			<label>Your Card</label>
			<img id="player1_turn_card" />
		</div>
		<div class="player2_turn_card" style="display:none;">
			<label></label>
			<img id="player2_turn_card" />
		</div>
		<div class="player3_turn_card" style="display:none;">
			<label></label>
			<img id="player3_turn_card" />
		</div>
		<div class="player4_turn_card" style="display:none;">
			<label></label>
			<img id="player4_turn_card" />
		</div>
		<div class="player5_turn_card" style="display:none;">
			<label></label>
			<img id="player5_turn_card" />
		</div>
		<div class="player6_turn_card" style="display:none;">
			<label></label>
			<img id="player6_turn_card" />
		</div>

	</div>
	<!-- table cards -->
	
	<!-- declare buttons -->
	<div class="content-buttons">
		<span id="msg"></span>
		<div class="declare-but" id="declare" style="display:none">
			<img src="declare.png">
		</div>
		<div class="discard-but" id="discard_card" style="display:none">
			<img src="discard-btn.png">
		</div>
		<div class="finish-but"  id="finish_game" style="display:none">
			<img src="finish.png">
		</div>
	</div>
	<!-- declare buttons -->
	
	<!-- declare popup start -->
	<div class="declare-table">
		<table class="table-bordered" id="game_summary" style="color:#fff">
			<tbody>
				<tr>
					<th style="padding:1% 4%" colspan="4">Tournament Title : <script> document.write(tournament_title);</script></th>
					<th class="close-declpop">Close</th>
				</tr>
				<tr>
					<th style="padding:1% 4%" colspan="5">You Declared &nbsp;<span id="seq"></span>   &nbsp; sequence.</th>
				</tr>
				<tr style="text-align:center;background:#ff4d4d;color:#404040;border-top:1px solid #fff;border-bottom:1px solid #fff" id="tr_summary">
					<th style="width:12%">User Name</th>
					<th style="width:10%">Show Status</th>
					<th style="width:70%">Results</th>
					<th>Game Score</th>
					<th>Amount Won</th>
				</tr>
			</body>
		</table>
	</div>
	<!-- declare popup end -->
	
	<!-- rummy cards start -->
	<div class="rummy-cards" id="images_parent">
		<div class="btn-group"  style="display:inline">
			<button id="group_cards" style="display:none">Group</button>
		</div>
		<div class="add-here-1"  style="display:inline">
				<button id="add_group1" style="display:none">Add Here</button>
		</div>
		<div class="group1" id="card_group1">
		</div>
		<div class="add-here-2"  style="display:inline">
				<button id="add_group2" style="display:none">Add Here</button>
		</div>
		<div class="group2" id="card_group2">
		</div>
		<div class="add-here-3"   style="display:inline">
				<button id="add_group3" style="display:none">Add Here</button>
		</div>
		<div class="group3" id="card_group3">
		</div>
		<div class="add-here-4"   style="display:inline">
				<button id="add_group4" style="display:none">Add Here</button>
			</div>
		<div class="group4" id="card_group4">
		</div>
		<div class="add-here-5"   style="display:inline">
				<button id="add_group5" style="display:none">Add Here</button>
			</div>
		<div class="group5" id="card_group5">
		</div>
		<div class="add-here-6"   style="display:inline">
				<button id="add_group6" style="display:none">Add Here</button>
			</div>
		<div class="group6" id="card_group6">
		</div>
		<div class="add-here-7"   style="display:inline">
				<button id="add_group7" style="display:none">Add Here</button>
			</div>
		<div class="group7" id="card_group7">
		</div>
		<div class="group_images" id="images" style="">
		</div>
		<div class="group_images" id="jokerimages" style="">
		</div>
	</div>
	<!-- rummy cards start -->
	
	<!-- bottom sit here button -->
	<div class="bottom-chair">
		<div class="bott-chair"  id="player_1_chair"><img src="chair-1.png"/></div>
		<div class="bott-female"><img  id="player_1_female_player" style="display:none" src="male-1.png"/></div>
		<div class="bott-male"><img id="player_1_male_player" style="display:none" src="male-1.png"/></div>
		<div id="player_1_disconnect" style="position: absolute;
			    bottom: 9%;
    left: 57%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_1_status"></label> 
		</div>
		<div class="bott-sit"><img  id="player_1_sit"  src="sithere_btn_btm.png" class="sit-popup" ></div>
		<div class="bot-dealer"  style="display:none"  id="player_1_dealer"><img src="dealer-icon.png"></div>
		<div class="cb-loader" style="display:none"  id="player_1_loader"><img src="buyin.gif"></div>
		<div class="count-down"  id="player_1_counts">
			<div class="cb-fif-sec" style="color:#fff" id="player_1_count1">
				<span  id="player1turn"></span>
			</div>
			<div class="cb-twe-sec" style="color:#fff" id="player_1_count2">
			</div>
		</div>
	</div>
	<div class="player1" style="display:none;" id="player_1_details">
		<label id="player_1_name"><big><b></b></big></label><br>
		<label id="player_1_amount"><big><b></b></big></label>
		<label id="player_1_poolamount" style="display:none"></label>
	</div>
	<!-- bottom sit here button -->
	
	<!-- sort drop button -->
	<div class="sort-drop-but">
		<div class="sort-but" id="sort_cards" style="display:none">
			<img src="sortbtn.png"/>
		</div>
		<div class="drop-but" style="display:none" id="drop_game">
			<img src="Dropbtn.png"/>
		</div>
	</div>
	<!-- sort drop button -->
	
	<!-- bottom menu start -->
	<!--<div class="bottom-menu">
		<div style="text-align:right">
			<i class="fa fa-volume-up" aria-hidden="true"></i>
			<i class="fa fa-signal" aria-hidden="true"></i>
			<label id="minutes">00</label><label> : </label><label id="seconds">00</label>
		</div>
	</div>-->
	<!-- bottom menu ends -->
	
	</div>
</body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>	
	<script type="text/javascript" src="/jquery.dragsort-0.5.2.min.js"></script>
	<!--<script src="countdown_six.js"></script>-->
<!--	<script src="pop-up_six.js"></script>-->
	<script>
			var joined_table=false;
			var tableid = -1;
			const MAX_GAMECOUNT = 6;
	 	$(function(){
			
			$("#player_1_count1").hide();
			$("#player_1_count2").hide();
			$("#player_2_count1").hide();
			$("#player_2_count2").hide();
			$("#player_3_count1").hide();
			$("#player_3_count2").hide();
			$("#player_4_count1").hide();
			$("#player_4_count2").hide();
			$("#player_5_count1").hide();
			$("#player_5_count2").hide();
			$("#player_6_count1").hide();
			$("#player_6_count2").hide();
			$("#finish_card").hide();
			$('#finish_card').attr("disabled", 'disabled');
			var btnclicked;

			var is_game_end = false;

		 	var random_group_roundno =0;
		
			var check_join_count = 10;
		 	var player_amount;
		 	var player_poolamount;
			var activity_timer_status=false;
		 	var user_assigned_cards = [];
		 	var activity_msg_count = 3;
		 	var player_turn = false;
		  	////used for return card if no discard within timer ////
		  	var picked_card_value;
		  	var picked_card_id;
			var discard_click = false ;
			var is_picked_card = false;
			var is_finished = false ;
			var next_turn = false ;
			var remove_obj;
			var is_open_close_picked = 0;
			var top_image,bottom_image,top_img_id,bottom_img_id;
			var ttt = false;
			var declare = 0;
			var is_opp_pl_discareded = false;
			var opp_pl_discareded;
			var browser_type = checkBrowser();
			var temp_closed_cards_arr = [];
			var temp_closed_cards_arr1 = [];
			var closed_card_src_temp;
			var closed_card_id_temp = 0;
			var selected_card_count=0;
		    var open_card_src,closed_card_src;
		    var selected_card_arr = [];
		    var selected_card_arr1 = [];
	        var selected_group_card_arr = [];
		    var click_count = 0; var margin_left = 25;
		    var vars = {};
		    var grp1 = [];var grp2 = [];var grp3 = [];var grp4 = [];
		    var grp5 = [];var grp6 = [];var grp7 = [];
		    var open_card_id;
		    var close_card_id;
		    var table_round_id = 0;
		    var card_click = [] ; var clicked_key; 
			var card_click_grp = []; var clicked_key_grp;
		    var prev_discard_key ;
		    var card_count ;
		    var open_data = '',close_data='';
		    var open_obj;
		    var is_sorted = false;
		    var is_grouped = false;
		    var initial_group = false;
		    var is_grouped_temp = false;
		    var initial_group_temp = false;
		    var discarded_open_arr = [];
		    var parent_group_id;
		    var selected_group_id;
		    var selected_card_id;
		    var is_declared = false ;
		    var is_other_declared = false ;
		    var is_game_started = false;
		    var is_game_dropped = false;
		    var socket=null;
		    var initial_open_card;
		    var player_having_turn = "";
		    var audio_shuffle = new Audio('sounds/SHUFFLE.wav');
		    var audio_open  = new Audio('sounds/CardPick-Discard.wav');
		    var audio_close  = new Audio('sounds/CardPick-Discard.wav');
		    var audio_discard  = new Audio('sounds/CardPick-Discard.wav');
		    var audio_player_turn_end  = new Audio('sounds/Turn.wav');
		    var audio_player_turn_ending  = new Audio('sounds/Player-Timer.wav');
		    var audio_player_winner  = new Audio('sounds/Winner.wav');
		    var is_refreshed = false;
		    var player_in_game = true;
			var poolamt=0;
			var join_count=0;
			var no_of_jokers=0;

			var sort_grp1 =[], sort_grp2 =[], sort_grp3 =[], sort_grp4 =[],
					sort_grp5 =[], sort_grp6 =[], sort_grp7 =[]; 
		  /**** Emit to server -
			1. on connect check if any other player already exist on table
			2. on connect check logged player already present on table 
			****/
			 $(document).keydown(function (e) {  
            return (e.which || e.keyCode) != 116;  
			});  

			socket= io.connect('http://rummysahara.com:8090');

		    socket.on('connect', function(){
				if(tournamentId != 0 && loggeduser != "")
				{
					socket.emit('check_if_joined_player',loggeduser,tournamentId);
				}
			});

		   	function checkBrowser()
			{
				var browser_type ;
				var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
					if(isOpera == true) { browser_type ="Opera Mini"; return browser_type;}
				// Firefox 1.0+
				var isFirefox = typeof InstallTrigger !== 'undefined';
					if(isFirefox == true) { browser_type ="Mozilla Firefox";  return browser_type;}
				// At least Safari 3+: "[object HTMLElementConstructor]"
				var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
					if(isSafari == true) { browser_type ="Safari"; return browser_type;}
				// Internet Explorer 6-11
				var isIE = /*@cc_on!@*/false || !!document.documentMode;
					if(isIE == true) { browser_type ="Internet Explorer";  return browser_type;}
				// Edge 20+
				var isEdge = !isIE && !!window.StyleMedia;
					if(isEdge == true) { browser_type ="Edge";  return browser_type;}
				// Chrome 1+
				var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
				//var isChrome = !!window.chrome && !!window.chrome.webstore;
					if(isChrome == true) { browser_type ="Google Chrome"; }
					return browser_type;
			}

			function detectOS() {
				var OSName="Unknown OS";
				if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
				if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
				if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
				if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

				return OSName;
			}

		socket.on('check_if_joined_player', function(tournamentid_listening)
		{
			console.log("\n IN check_if_joined_player");			

			if(tournamentId==tournamentid_listening)
			{
				is_finished = false;
				declare = 0;
				is_game_dropped=false;
				is_game_end = false;

				socket.emit('check_if_joined_player', loggeduser, tournamentId );
			}
		});
		
			/*  on joining table show connected player to appropriate sit */
			var player_name_array =[];
			var player_sit_array =[];
			var player_amount_array =[];
			var player_poolamount_array =[];
			var player_gender_array =[];

			var TOURNAMENT_GAME_STATUS_READY = "ready";
			var TOURNAMENT_GAME_STATUS_GAME = "game";


		    var changeTimeFormat = function (sec) {
		      minute = Math.floor(sec / 60);
		      sec = sec % 60;
		      return minute + ":" + (sec < 10 ? "0" : "") + sec;
		    }

			socket.on('tournament_time', function(data) {
				if( tournamentId == data.tournamentId && tableid > 0  ) {
					if( data.status == TOURNAMENT_GAME_STATUS_READY && is_game_end == false ) {
						$('#div_msg').html('<label style="color:white">Game will be started after '+ data.time +' seconds</label>');
						$('#div_msg').show();
						$('.tl-info').hide();
					} else if( data.status == TOURNAMENT_GAME_STATUS_GAME ) {						
						$('.tl-info').show();
						$('.tl-time').html(changeTimeFormat(data.time));
					}
				}
			});

			socket.on('show_game_count', function(grpid, gameCnt, maxCount) {
				if( tableid == grpid ) {
					$('.tl-gamecount').html(gameCnt + "/" + maxCount);
				}
			});			

			socket.on('tournament_gamestart', function(tournamentid_listening) {
				if(tournamentId==tournamentid_listening && is_game_end == false) {
					//$("#deal_id").html(recvd_random_group_roundno);
					//table_round_id = recvd_random_group_roundno;
					activity_timer_status = true;
					$("#Timer").text("");
					// $('#div_msg').empty();
					// $('#div_msg').hide();
					$(".declare-table").hide();												
					declare = 0;
					activity_timer_status=true;
					is_finished = false ;
					is_game_dropped = false;
					player_in_game = true;
					$("#restart_game_timer").text("");
					$("#side_joker").attr('src', ""); 
					$('#game_summary').find('td').remove();
					$('#game_summary tr:gt(3)').remove();
				}
			});
						
			/////displaying turn card on deck to both players to decide turn
			socket.on("six_pl_turn_card", function(data) 
			{
			console.log("\n --------DATA  in six_pl_turn_card"+JSON.stringify(data));

			console.log("\n ----"+tableid+"----"+table_round_id);
			 if(tableid==data.group_id)///check for same table
			  {
			    //if(table_round_id == data.round_no)///check for same table-round id
			    {
					var card_no_arr = [];
					var card_no_arr_temp = [];
					var card_path_arr = [];
					var card_path_arr_temp = [];
					var player_name_array_temp = [];var player_sit_array_temp = [];
					var player_amount_array_temp = [];var player_gender_array_temp = [];
					var player_card_no  = data.card_no;
					var index = -1;

					//console.log("\n player_card_no "+player_card_no);
					//console.log("\n after data.game_restart "+data.game_restart);

					card_no_arr.push.apply(card_no_arr,data.other_card_no);
					card_path_arr.push.apply(card_path_arr,data.other_card_path);
					
					for(var  i = 0; i < card_no_arr.length; i++) {
						var uName = $("#player_"+(i+1)+"_name").text();

						for(var j = 0; j < data.names.length; j++) {
							if(uName == data.names[j]) {
								$("#player"+(i+1)+"_turn_card").attr('src',card_path_arr[j]); 						
								$(".player"+(i+1)+"_turn_card").show(); 
							}
						}
					}

					for(var  i = 0; i < 6; i++)
					{						
						if(($("#player_"+(i+1)+"_name").text())==data.dealer)
						{
							$("#player_"+(i+1)+"_dealer").show();
						}
					}
					if(is_game_started == true)
					{
						is_game_started = false;
					}
				}
			  }
			});///firstcard ends 
			
		function hide_all_players_details()
		{
			for(var  i = 1; i < 7; i++)
			{
				$("#player_"+(i)+"_name").text("");
				$("#player_"+(i)+"_amount").text("");
				$("#player_"+(i)+"_details").hide();
				console.log("line 1095\n");
				$("#player_"+(i)+"_male_player").css('display','none');
				$("#player_"+(i)+"_female_player").css('display','none');
				$("#player_"+(i)+"_sit").hide();
			}

		}

		//// According to turn distribute both players their respective 13 hand cards with open ,joker and closed cards
			var open_arr_temp = [];
			socket.on("turn", function(data) 
			{
				if( is_game_end )
					return;

			 if(tableid == data.group_id)///check for same table
			 {
			  //if(table_round_id == data.round_no)
			  {
				var opp_player;							 
				$('#div_msg').empty();
				$('#div_msg').show();
				$(".declare-table").hide();
				console.log("turn hide");

				if(data.myturn) 
				{
					$('#div_msg').prepend("<span style='color:white;top:50%' class='label label-important'>You will Play First.</span>");
				} 
				else 
				{
					$('#div_msg').prepend("<span style='color:white;top:50%' class='label label-info'>Player  <b>"+data.turn_of_user+"  </b> will play first.</span>");
				}
				console.log("SHOW---------------- turn");

					var temp_count = 5;
					
					if(((data.closedcards_path).length)!=0)
					{temp_closed_cards_arr.push.apply(temp_closed_cards_arr,data.closedcards_path);}
					
						  var countdown = setInterval(function(){

						  	console.log(temp_count);
						  temp_count--;
						  if (temp_count == 0) {
						 		  clearInterval(countdown);  
								 $('#div_msg').hide();
								 $('#div_msg').empty();
								 console.log("HIDE---------------- turn");
								 $("#images").empty();
								 for(var  i = 0; i < 6; i++)
								 {
								   $(".player"+(i+1)+"_turn_card").hide();
								 }
								  
								user_assigned_cards.push.apply(user_assigned_cards, data.assigned_cards); 
								////// assign 13 cards to both players 
								$('#images_parent').append( $('#images') );
								show_player_hand_cards(data.assigned_cards,data.sidejokername);
								audio_shuffle.play();
									////// open and closed and side joker images
									 $("#open_card").show();
									 $("#closed_cards").show();
									 $("#joker_card").show();
									 $("#open_card").attr('src', data.opencard);  
									 initial_open_card = data.opencard1;
									 open_arr_temp.push(data.opencard1);
									 open_card_id=data.opencard_id;
									 $("#closed_cards").attr('src', "c3.jpg");  
									 $("#joker_card").attr('src', data.sidejoker);  
									 $("#open_deck").show();
									 
									temp_closed_cards_arr1 = [];
									temp_closed_cards_arr1.push.apply(temp_closed_cards_arr1,data.closedcards);
									closed_card_src_temp = data.closedcards[0].card_path;
									closed_card_id_temp = data.closedcards[0].id;
								}//temp count of 5 second ends 
							}, 1000);
				   }//check is same table-round id
				}//check is same table
			});///turn ends 

		function show_player_hand_cards(_cards,sidejokername)
		{
				console.log(" @@@@@@@@@ show_player_hand_cards @@@@@@@@@@@ ");
				console.log("\n -- "+JSON.stringify(_cards));
				var user_hand_arr = [];
				user_hand_arr.push.apply(user_hand_arr,_cards);
				$("#images").empty();
				$.each(user_hand_arr, function(k, v) 
				{
					if(k==0)
					{
						$("#images").append("<div><img id="+v.id+" src="+v.card_path+"></div>");
						if(v.name==sidejokername)
						 $("#jokerimages").append("<span id='jokerimg' />");
						
					}
					else
					{
						$("#images").append("<div><img id="+v.id+"  src="+v.card_path+"></div>");
						if(v.name==sidejokername)
						 $("#jokerimages").append("<span id='jokerimg' />");
						 
					}
					$("#sort_cards").show();
					
					$("#"+v.id).click(function() 
					{
					  if(player_in_game != false)
					  {
						if(($.inArray(v.id,card_click))>-1)
						{ 
							$("#"+v.id).css('border', ""); 
							idx = $.inArray(v.id,card_click);
							card_click.splice(idx, 1);
							card_click_grp.splice(idx, 1);
							/*
							card_click = jQuery.grep(card_click, function(value) {
							  return value != v.id;
							});*/
							selected_card_count--;
							groupCards(v.id,v,selected_card_count,0); 
						}
						else 
						{
							clicked_key = v.id;
							card_click.push(clicked_key);
							card_click_grp.push(0);
							$("#"+v.id).css('border', "solid 1px blue"); 
							selected_card_count++;
							groupCards(clicked_key,v,selected_card_count,1);
						}
						
						if( selected_card_count == 1 ) {
							clicked_key = card_click[0];
							clicked_key_grp = card_click_grp[0];
						}
						console.log("selected_card_count"+selected_card_count);
						if(selected_card_count > 1)
						{$("#group_cards").show();console.log("can do group");}
						else {$("#group_cards").hide();console.log("u can not group");}
							if($.trim($("#images").html())!='')
							{ 
							 card_count = $("#images").children().length;
							 }
							console.log('no_of_jokers'+no_of_jokers);
							console.log('card_count'+card_count);
							if(card_count==14  && player_turn==true && selected_card_count ==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
						$("#discard_card").unbind().on('click',function()
						{
							audio_discard.play();													
							 $('#discard_card').attr("disabled", 'disabled');
							  $("#discard_card").hide();													
							 $('#finish_game').attr("disabled", 'disabled');												
							 $('#drop_game').attr("disabled", 'disabled');
							$("#finish_game").hide();
							$("#drop_game").hide();
							$("#popup-confirm").hide();

							if(clicked_key!=prev_discard_key)
							{
								var src = $("#"+clicked_key).attr("src");
								console.log("discard CARD clicked_key "+clicked_key+" src "+src);
								var open_objj;
								for(var  i = 0; i < user_hand_arr.length; i++){	
									if(user_hand_arr[i].id == clicked_key){
											open_objj = user_hand_arr[i];
											break;
										}
									}
								console.log("discard CARD ----clicked_key "+clicked_key+" open obj "+open_objj);
								//discard("#",src,clicked_key,"#images", user_hand_arr[clicked_key],clicked_key,open_objj);
								discard("#",src,clicked_key,"#images", open_objj,clicked_key,open_objj);
								prev_discard_key = clicked_key;
							}
							selected_card_arr = [];
							selected_card_count = 0;
						});
						$("#finish_game").unbind().on('click',function()
						{
							var finish_card_obj;
								for(var  i = 0; i < user_hand_arr.length; i++){
									if(user_hand_arr[i].id == clicked_key){
											finish_card_obj = user_hand_arr[i];
											break;
										}
									}
							finish(finish_card_obj,clicked_key,0);
						});
					  }
					});
				});
		}///show_player_hand_cards ends 

		/////after discard/return ,update hand cards of player
		socket.on("update_hand_cards_six", function(data) 
		{
			console.log("UPDATING HAND CARDS AFTER DISCARD/RETURN");
			if(data.user==loggeduser)
			{
				if(tableid==data.group)
				{
					//if(table_round_id == data.round_id)
					{
						console.log("before discard/return HAND CARDS: "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						user_assigned_cards = [];
						user_assigned_cards.push.apply(user_assigned_cards,data.hand_cards);
						console.log("\n AFTER discard/return HAND CARDS:  "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						show_player_hand_cards(data.hand_cards,data.sidejokername); 
					}
				}
			}
		});
				

		/// function for alternate turns once turn end of a player
		/////show turn timer to other player on first ends 
		socket.on("timer_six", function(data) 
		{
			if(!(navigator.onLine))
			{
			//	alert("Connection Failed,Please Check your Internet connection..!");
			}
			if(tableid==data.group_id)///check for same table
			{
				//console.log(table_round_id + ":" + data.round_id);
			    //if(table_round_id == data.round_id)///check for same table-round id
			    {
			    	hide_all_players_turn_details();
			    	//alert("showing game turn timer");
			    	//console.log(" timer _details "+JSON.stringify(data));
			    	 if($.trim($("#images").html())!='')
					{ 
						card_count = $("#images").children().length;
						card_count =card_count - no_of_jokers;		
					}
					else
					{
						card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
						card_count =card_count - no_of_jokers;		
					}

						game_count = data.game_timer;
						extra_count = data.extra_time;
						player_having_turn  = data.turn_of_user;
						
						for(var  i = 1; i < 7; i++)
						{
							if(($("#player_"+(i)+"_name").text())==data.turn_of_user)
							{
								$("#player_"+(i)+"_count1").show();
								$("#player"+(i)+"turn").show();
								if( game_count >= 1 ) {
									$("#player"+(i)+"turn").text(game_count);
								} else {
									$("#player"+(i)+"turn").text("Ex: " + extra_count);
								}
								
								//$("#player_"+(i)+"_dealer").show();
							}//if-turn
						}//for
						if(data.myturn) 
						{
							player_turn = true;

							if(card_count == 13)
								{ $("#drop_game").show(); }
							else
								{ $("#drop_game").hide();
									$('#drop_game').attr("disabled", 'disabled');
								}

							console.log("-----------is_finished " + is_finished + "  is_other_declared " + is_other_declared);

							if(is_finished == true || is_other_declared == true)
								{
								 $('#drop_game').attr("disabled", 'disabled');
								$("#drop_game").hide(); }
											
							if(data.is_discard == true || data.is_declared == true || data.is_dropped == true || data.is_poolpoint == true)
								{ game_count = 1; extra_count = 1;} 

							if (game_count <= 1 && extra_count <= 1) 
								{
									audio_player_turn_end.play();
									is_open_close_picked = 0;
									$('#drop_game').attr("disabled", 'disabled');
									$("#drop_game").hide();
									ttt = false ;
									hide_all_add_here_buttons();
									selected_card_arr = [];
									selected_group_card_arr = [];
											
									data.is_discard = false;
									player_turn = false;
									is_other_declared = false;
									is_picked_card = false;
									
									$('#discard_card').attr("disabled", 'disabled');
									$("#discard_card").hide();
									$('#finish_game').attr("disabled", 'disabled');
									$("#finish_game").hide();

									$("#popup-confirm").hide();
									hide_all_players_turn_details();
								}
						}
						else
						{
							player_turn = false;
							$('#discard_card').attr("disabled", 'disabled');
							$("#drop_game").hide();
							if(data.is_discard == true || data.is_declared == true  || data.is_dropped == true || data.is_poolpoint == true)
							{ game_count = 1; extra_count = 1;} 
										
							if(game_count <= 1 && extra_count <= 1) 
							{
								audio_player_turn_end.play();
								data.is_discard = false;
								hide_all_players_turn_details();
							}
						}
						if(game_count < 5)
							{ audio_player_turn_ending.play();}
					}
						
			    }
		});//timer_six ends 

   		function hide_all_players_turn_details()
   		{
   			for(var  i = 1; i < 7; i++)
			{
				$("#player_"+(i)+"_count1").hide();
				//$("#player_"+(i)+"_dealer").hide();
			}			
		}//hide_all_players_turn_details ends 

		////// Sorting according to card-suit on sort_card button click
		$("#sort_cards").click(function()
		{
			if(player_in_game != false)
			{
				$("#sort_cards").hide();
				is_sorted = true;// to know sorting has done
			    var temp = []; 
				var temp_group1 = [],temp_group2 = [],temp_group3 = [],temp_group4 = [];
				if(user_assigned_cards.length == 13 || user_assigned_cards.length == 14)
				{
					temp.push.apply(temp,user_assigned_cards);
				}
				if(temp.length >0)	
				{
					temp = temp.sort(function(a,b) {
						return (a.suit < b.suit ? -1 : 1)
					});
					temp = temp.sort(function(a,b) {
						return (a.suit_id < b.suit_id ? -1 : 1)
					});
				
					$("#images").empty();
				
					$.each(temp, function(key, obj)
					{ 
						var div_name = obj.suit;
						if(div_name=='C')
							{grp1.push({v:obj,k:key});
							temp_group1.push(obj);}
						if(div_name=='S')
							{
							grp2.push({v:obj, k: key});
							temp_group2.push(obj);
							}
						if(div_name=='H')
							{
							grp3.push({v:obj, k: key});
							temp_group3.push(obj);
							}
						if(div_name=='D' || div_name=='Red_Joker' || div_name=='Black_Joker')
							{
							grp4.push({v:obj, k: key});
							temp_group4.push(obj);
							}
					});
				
					/// emit player groups after sort to server///
					socket.emit("update_player_groups_six",{player:loggeduser,group:tableid,round_id:table_round_id,group1:temp_group1,group2:temp_group2,group3:temp_group3,group4:temp_group4,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,parent_group:grp2});
				}
			}//if-player-in-game 
		});////sort_cards() ends 

		/* show player hand card groups after sort */
		socket.on("update_player_groups_six", function(data) 
		{
			show_player_hand_cards_after_sort(data.user,data.group,data.round_id,data.grp1_cards,data.grp2_cards,data.grp3_cards,data.grp4_cards,data.grp5_cards,data.grp6_cards,data.grp7_cards,data.sidejokername);
		});
			
		var add_card_obj;// = [];
		function show_player_hand_cards_after_sort(user,group,round_id,grp1_cards,grp2_cards,grp3_cards,grp4_cards,grp5_cards,grp6_cards,grp7_cards,sidejokername)
		{
				var src ;
				var card_count=0;
				var clicked_card_count=0;
				var card_click = [] ; var clicked_key;
				var card_click_grp = [] ; var clicked_key_grp;
				sort_grp1 =[], sort_grp2 =[], sort_grp3 =[], sort_grp4 =[],
					sort_grp5 =[], sort_grp6 =[], sort_grp7 =[]; 
			    var discard_obj = [];
				 console.log("Showing player card groups after sort");
			  console.log("\n grp1_cards "+grp1_cards.length);
			  
				$("#card_group1").empty();
				$("#card_group2").empty();
				$("#card_group3").empty();
				$("#card_group4").empty();
				$("#card_group5").empty();
				$("#card_group6").empty();
				$("#card_group7").empty();
				$("#images").empty();
			
			  if(user==loggeduser)
			  {
				if(tableid==group)
				{
				 	//if(table_round_id == round_id)
				  {

					$("#discard_card").unbind().on('click',function()
					{
						 //alert("hi")
						audio_discard.play();
						$('#discard_card').attr("disabled", 'disabled');
						$('#finish_game').attr("disabled", 'disabled');
						$('#drop_game').attr("disabled", 'disabled');
						$("#discard_card").hide();
						$("#finish_game").hide();
						$("#drop_game").hide();
						$("#popup-confirm").hide();
						
						hide_all_add_here_buttons();
						discard_click  = true ;
						next_turn = true;
						open_card_id = clicked_key;
						src=$("#"+clicked_key).attr("src");
						$("#open_card").attr('src', src);  
						ttt = false;
						if(open_card_id != "" && open_card_id != undefined && open_card_id != null){
						socket.emit("discard_fired_six",{discarded_user:loggeduser,group:tableid,round_id:table_round_id});
						
						for(var  i = 0; i < sort_grp1.length; i++)
						{
							if(sort_grp1[i].id == clicked_key)
							{
								open_obj = sort_grp1[i];
								break;
							}
						}
						discard_obj.push(open_obj);
						
						card_click = [];
						card_click_grp = [];
						clicked_card_count = 0;
                         
						socket.emit("show_open_card_six",{user: loggeduser,group:tableid,open_card_src:src,check:ttt,round_id:table_round_id,open_card_id:open_card_id,discard_card_data:open_card_id,discarded_open_data:discard_obj,is_sort:is_sorted,is_group:is_grouped,group_from_discarded:clicked_key_grp,is_initial_group:initial_group});
						}else{
							alert("Please select Card");
						}
						
						discard_obj = [];
						selected_card_arr = [];
						selected_group_card_arr = [];
					});
					$("#finish_game").unbind().on('click',function()
					{
						var finish_card_obj;
						var sort_grp_temp;
						if(clicked_key_grp == 1) {
							sort_grp_temp = sort_grp1;
						} else if(clicked_key_grp == 2) {
							sort_grp_temp = sort_grp2;
						} else if(clicked_key_grp == 3) {
							sort_grp_temp = sort_grp3;
						} else if(clicked_key_grp == 4) {
							sort_grp_temp = sort_grp4;
						} else if(clicked_key_grp == 5) {
							sort_grp_temp = sort_grp5;
						} else if(clicked_key_grp == 6) {
							sort_grp_temp = sort_grp6;
						} else if(clicked_key_grp == 7) {
							sort_grp_temp = sort_grp7;
						}
						for(var  i = 0; i < sort_grp_temp.length; i++){
						if(sort_grp_temp[i].id == clicked_key){
							finish_card_obj = sort_grp_temp[i];
							break;
							}
						}
						console.log("finish clicked grp 1 "+JSON.stringify(finish_card_obj)+"----"+clicked_key);
						finish(finish_card_obj,clicked_key,clicked_key_grp);
					});	

				   if(grp1_cards.length != 0)
				   {
				    sort_grp1.push.apply(sort_grp1,grp1_cards);
					console.log("--Group1 -"+JSON.stringify(sort_grp1));
					$.each(sort_grp1, function(key, obj)
					{
					  if(key==0)
						{
							$("#card_group1").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#card_group1").append("<img  width='8%' height='9%'  src='joker.png'>");
						}
					  else
						{
							$("#card_group1").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#card_group1").append("<img  width='8%' height='9%'  src='joker.png'>");
						} 
					$("#"+obj.id).click(function() 
						{
					      if(player_in_game != false)
						  {
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,1); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(1);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,1); 
								}

								if( clicked_card_count == 1 ) {
									clicked_key = card_click[0];
									clicked_key_grp = card_click_grp[0];
								}
								card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
								console.log("clicked_card_count GRP1 "+clicked_card_count);
							////ADD HERE 1
							if(clicked_card_count==1)
							{
							    parent_group_id =1;
							    selected_card_id = clicked_key; 
								for(var  i = 0; i < sort_grp1.length; i++)
								{
									if(sort_grp1[i].id == selected_card_id)
									{
										open_obj = sort_grp1[i];
										break;
									}
								}
								add_card_obj=open_obj;	
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							if(clicked_card_count>1)
							{
								console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
								console.log("can NOT do group");
								$("#group_cards").hide();
							}
						  }
						});
					});///1st grp
				}//1st grp not empty 
				if(grp2_cards.length != 0)
				{
				 console.log("-GROUP 2-"+JSON.stringify(grp2_cards));
				 sort_grp2.push.apply(sort_grp2,grp2_cards);
				 $.each(sort_grp2, function(key, obj)
				 {
					if(key==0)
					{
						$("#card_group2").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group2").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group2").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group2").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group2").css('margin-left', "7%"); 
					
					$("#"+obj.id).click(function() 
						{
						  if(player_in_game != false)
						  {
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,2);  
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(2);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,2); 
								}
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							////ADD HERE 2
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =2;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp2.length; i++)
								{
									if(sort_grp2[i].id == selected_card_id)
									{
										open_obj = sort_grp2[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
								console.log("clicked_card_count GRP2 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
								console.log("can NOT do group");
							$("#group_cards").hide();
							}
						  }//if-player-in-game
						});
				});//2nd grp
				}//2nd group
				if(grp3_cards.length != 0)
				{
				 console.log("-GROUP 3-"+JSON.stringify(grp3_cards));
				 sort_grp3.push.apply(sort_grp3,grp3_cards);
				 $.each(sort_grp3, function(key, obj)
				 {
					if(key==0)
					{
						$("#card_group3").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group3").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group3").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group3").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group3").css('margin-left', "7%"); 
					$("#"+obj.id).click(function() 
						{
						  if(player_in_game != false)
						  {
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,3); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(3);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,3); 
								}
								////ADD HERE 3
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =3;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp3.length; i++)
								{
									if(sort_grp3[i].id == selected_card_id)
									{
										open_obj = sort_grp3[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP3 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						  }
						});
				});//3rd group
				}//3rd
				if(grp4_cards.length != 0)
				{
				console.log("-GROUP 4-"+JSON.stringify(grp4_cards));
				sort_grp4.push.apply(sort_grp4,grp4_cards);
				$.each(sort_grp4, function(key, obj)
				{
				   if(key==0)
					{
						$("#card_group4").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
					//	if(obj.name==sidejokername)
						//$("#card_group4").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group4").append("<div><img id='"+obj.id+"'  src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group4").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group4").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						  if(player_in_game != false)
						  {
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,4); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									card_click_grp.push(4);
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,4);  
								}
								////ADD HERE 4
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								//parent_group_id =("card_group4");
								parent_group_id =4;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp4.length; i++)
								{
									if(sort_grp4[i].id == selected_card_id)
									{
										open_obj = sort_grp4[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP4 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						  }
						});
				});///4th group
				}//4th
				if(grp5_cards.length != 0)
				{
				console.log("-GROUP 5-"+JSON.stringify(grp5_cards));
				sort_grp5.push.apply(sort_grp5,grp5_cards);
				$.each(sort_grp5, function(key, obj)
				{
				    if(key==0)
					{
						$("#card_group5").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group5").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group5").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group5").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group5").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						 if(player_in_game != false)
						 {
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,5); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									card_click_grp.push(5);
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,5);  
								}
								////ADD HERE 4
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =5;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp5.length; i++)
								{
									if(sort_grp5[i].id == selected_card_id)
									{
										open_obj = sort_grp5[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP5 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						 }
						});
				});///5th group
				}//5th
				if(grp6_cards.length != 0)
				{
				console.log("-GROUP 6-"+JSON.stringify(grp6_cards));
				sort_grp6.push.apply(sort_grp6,grp6_cards);
				
				$.each(sort_grp6, function(key, obj)
				{
				   if(key==0)
					{
						$("#card_group6").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group6").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group6").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group6").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group6").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						if(player_in_game != false)
						 {
						card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,6); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(6);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,6);  
								}
								////ADD HERE 6
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =6;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp6.length; i++)
								{
									if(sort_grp6[i].id == selected_card_id)
									{
										open_obj = sort_grp6[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();								
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP6 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						}
						});
				});///4th group
				}//4th
				if(grp7_cards.length != 0)
				{
				console.log("-GROUP 7-"+JSON.stringify(grp7_cards));
				sort_grp7.push.apply(sort_grp7,grp7_cards);
				$.each(sort_grp7, function(key, obj)
				{
				   if(key==0)
					{
						$("#card_group7").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group7").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group7").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group7").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group7").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						if(player_in_game != false)
						 {
						card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,7); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(7);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,7); 
								}
								////ADD HERE 7
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =7;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp7.length; i++)
								{
									if(sort_grp7[i].id == selected_card_id)
									{
										open_obj = sort_grp7[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP4 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						}
						});
				});///7th group
				}//7th
					  }
					}
				  }
			}///show_cards_after_sort ends


		/* ------------   ADD HERE  start -----------*/
		$("#add_group1").click(function()
			{ add_here(1); });
		$("#add_group2").click(function()
			{ add_here(2); });
		$("#add_group3").click(function()
			{ add_here(3); });
		$("#add_group4").click(function()
			{ add_here(4); });
		$("#add_group5").click(function()
			{ add_here(5); });
		$("#add_group6").click(function()
			{ add_here(6); });
		$("#add_group7").click(function()
			{ add_here(7); });
			
		function add_here(btn_id)
		{
			
			 var chkcard=0;
			if(selected_card_id == 0){chkcard=1;}
			if(selected_card_id == ""){chkcard=1;}
			if(selected_card_id == null){chkcard=1;}
			if(selected_card_id == undefined){chkcard=1;}
			if(add_card_obj == ""){chkcard=1;}
			if(add_card_obj == null){chkcard=1;}
			if(add_card_obj == undefined){chkcard=1;}
			if (add_card_obj.length === 0){chkcard=1;}
			if (add_card_obj.length > 1){chkcard=1;}
			if (!add_card_obj){chkcard=1;}
			console.log("===========chkcard================="+chkcard);
			if(chkcard == 0){
			socket.emit("add_here_six",{player:loggeduser,group:tableid,round_id:table_round_id,selected_card:selected_card_id,selected_card_src:add_card_obj,add_to_group:btn_id,remove_from_group:parent_group_id});
				add_card_obj = "";
				selected_card_id="";
				
			$("#discard_card").hide();
			$("#finish_game").hide();
			$('#discard_card').attr("disabled", 'disabled');
			$('#finish_game').attr("disabled", 'disabled');

			setTimeout(()=>{				
				selected_card_arr = [];
				selected_group_card_arr = [];
				$("#group_cards").hide();
				hide_all_add_here_buttons();			
			}, 20);
			}else{
					add_card_obj = "";
                    selected_card_id="";
					$("#discard_card").hide();
					$("#finish_game").hide();
					$('#discard_card').attr("disabled", 'disabled');
					$('#finish_game').attr("disabled", 'disabled');

					setTimeout(()=>{				
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
					}, 20);
			}
		}//add_here ends 
		
		
		function add_here_drop(btn_id,pos)
		{
			
			 var chkcard=0;
			if(selected_card_id == 0){chkcard=1;}
			if(selected_card_id == ""){chkcard=1;}
			if(selected_card_id == null){chkcard=1;}
			if(selected_card_id == undefined){chkcard=1;}
			if(add_card_obj == ""){chkcard=1;}
			if(add_card_obj == null){chkcard=1;}
			if(add_card_obj == undefined){chkcard=1;}
			if (add_card_obj.length === 0){chkcard=1;}
			if (add_card_obj.length > 1){chkcard=1;}
			if (!add_card_obj){chkcard=1;}
			console.log("===========chkcard================="+chkcard);
			if(chkcard == 0){
				socket.emit("add_here_six_drop",{player:loggeduser,group:tableid,round_id:table_round_id,selected_card:selected_card_id,selected_card_src:add_card_obj,add_to_group:btn_id,remove_from_group:parent_group_id,position:pos});
					add_card_obj = "";
					selected_card_id="";
				$("#discard_card").hide();
				$("#finish_game").hide();
				$('#discard_card').attr("disabled", 'disabled');
				$('#finish_game').attr("disabled", 'disabled');

				setTimeout(()=>{				
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
				}, 20);
			}else{
				   add_card_obj = "";
					selected_card_id="";
				$("#discard_card").hide();
				$("#finish_game").hide();
				$('#discard_card').attr("disabled", 'disabled');
				$('#finish_game').attr("disabled", 'disabled');

				setTimeout(()=>{				
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
				}, 20);
			}
		}//add_here ends 

		function hide_all_add_here_buttons()
		{
				$("#add_group1").hide();
				$("#add_group2").hide();
				$("#add_group3").hide();
				$("#add_group4").hide();
				$("#add_group5").hide();
				$("#add_group6").hide();
				$("#add_group7").hide();
		}//hide_all_add_here_buttons ends

	/* ------------   ADD HERE  end -----------*/

	/* ------------   GROUP OF CARDS  Start -----------*/
	function groupCards(key, value,selected_card_count,clicked) 
	{
		//alert(" in groupCards");
		index = key;
		selectedCard = value;
		if (selected_card_count <1 && discard_click == false) 
			{ initial_group = false;}
		if (selected_card_count>1) 
			{ 
				//initial_group = true;
				is_sorted = false;
			}
				 				  
		console.log("\n making groups before"+JSON.stringify(selected_card_arr));
		if(clicked==1)
			{
			   selected_card_arr.push(selectedCard);
			}
			if(clicked==0)
			{
				selected_card_arr = jQuery.grep(selected_card_arr, function(value) {
				return value != selectedCard;});
			}
		console.log("\n after making groups "+JSON.stringify(selected_card_arr));
	}
			
	function group_of_group(key,value,selected_card_count,clicked,card_parent) 
	{
		console.log("\n key "+key+" value"+JSON.stringify(value)+" count "+selected_card_count+" select/unselect "+clicked+" parent no"+card_parent);
		index = key;
		selectedCard = value;
			   
		if (selected_card_count <1 && discard_click == false && is_grouped != true) 
			{ is_grouped = false;}
		if (selected_card_count>1) 
			{ 
				is_grouped = true;
				is_sorted = false;
				initial_group = false;
			} 
		if(clicked==1)
			{
				selected_card_arr.push(selectedCard);
				selected_group_card_arr.push(card_parent);
			}
		console.log("\n ***** selected_group_card_arr after group of group "+JSON.stringify(selected_group_card_arr));
		if(clicked==0)
			{
				selected_card_arr = jQuery.grep(selected_card_arr, function(value) {
				return value != selectedCard;});
					
				selected_group_card_arr = jQuery.grep(selected_group_card_arr, function(value) {
				return value != card_parent;});
			}
	}///group_of_group ends 

	$("#group_cards").click(function()
	{
		if(player_in_game != false)
		{
			$("#group_cards").hide();
			$("#sort_cards").hide();
			is_sorted = false;
					
			if( is_grouped == true)
				initial_group = false;
			else
				initial_group = true;

			grp1 = [];
			$.each(selected_card_arr, function(n, m) 
			{grp1.push(m);});
			console.log("GRP after intial group "+JSON.stringify(grp1));
				
			//if( is_grouped == true)
			//{
				grp2 = [];
				$.each(selected_group_card_arr, function(n, m) 
				{grp2.push(m);});
				console.log("GRP after group of group "+JSON.stringify(grp2));
			//}
				
			/// emit player groups after group to server///
			socket.emit("update_player_groups_six",{player:loggeduser,group:tableid,round_id:table_round_id,card_group:grp1,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,parent_group:grp2});
				
			selected_card_arr = [];
			selected_group_card_arr = [];
		}
	});//group_card click ends 
			
			
	socket.on("group_limit_six", function(data) 
	{
		if(data.user==loggeduser)
		{
			if(tableid==data.group)
			{
				//if(table_round_id == data.round_id)
				{
					alert("You can make only 7 groups");
				}
			}
		}	
	});
/* ------------   GROUP OF CARDS  End -----------*/

/**************** Open / Close card select start ********/
//// open card click
	$("#open_card").unbind().on('click',function()
	{
		console.log("OPEN CARD CLICKED ");
		if(player_turn==true )
		{			
			if( is_picked_card ) {
				alert("You can pick only 1 card at a time from open/close cards!");
				return;
			}

			hide_all_add_here_buttons();
			audio_open.play();
			open_card_src =$("#open_card").attr("src");
			if(open_card_src=='closedimg.bmp')
			{//alert("No Open Card/(s) available..!");
			}
			else 
			{				
				is_picked_card = true;
				var data_of_open_card;
				console.log("start open_data"+open_data);
				if(open_data !='')
				{
					data_of_open_card=open_data;
					console.log("***** open_data IF NOT BLANK "+JSON.stringify(data_of_open_card));
				}
				else
				{
					data_of_open_card=initial_open_card;
					console.log("***** open_data IF BLANK "+JSON.stringify(data_of_open_card));
				} 

				/* ANDY */
				selected_card_arr = [];
				selected_card_count = 0;
				card_click = [];
				card_click_grp = [];
				//initial_group = false;
				$("#group_cards").hide();	
				socket.emit("check_open_closed_pick_count_six",{user:player_having_turn,group:tableid,card:'open',card_data:data_of_open_card,path:open_card_src,round_id:table_round_id,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group});
			}
		}
		else
		{
			//show this alert message as tooltip near open card
			//alert("You do not have turn to select open card!");
		}
	});
	
	//close click 

	//// closed card click
	$("#closed_cards").unbind().on('click',function()
	{ 
		console.log("CLOSE  CARD CLICKED ");
		if(player_turn==true)
		{
			if( is_picked_card ) {
				alert("You can pick only 1 card at a time from open/close cards!");
				return;
			}

			hide_all_add_here_buttons();

			is_picked_card = true;
			audio_close.play();
				
			var data_of_closed_card;
			console.log("before card used by close array "+temp_closed_cards_arr1.length);
			data_of_closed_card = temp_closed_cards_arr1[0];
			closed_card_src = closed_card_src_temp;
			close_card_id = closed_card_id_temp;
					
			console.log("After USED CLOSED "+JSON.stringify(data_of_closed_card));
			console.log("After close card used path "+closed_card_src+" id "+close_card_id);

			/* ANDY */
			selected_card_arr = [];
			selected_card_count = 0;			
			card_click = [];			
			card_click_grp = [];
			//initial_group = false;
			$("#group_cards").hide();																
			socket.emit("check_open_closed_pick_count_six",{user:player_having_turn,group:tableid,card:'close',card_data:data_of_closed_card,path:closed_card_src,round_id:table_round_id,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group});
		}
		else
		{
		//show this alert message as tool-tip near open card
		//alert("You do not have turn to select close cards!");
		}
	});
	///select open/close card to continue game 
	socket.on("open_close_click_count_six", function(data) 
	{
		//alert("in event ");
			  if(tableid==data.group)///check for same table
			  {
			   //if(table_round_id == data.round_id)///check for same table-round id
			    {
			      if((data.pick_count)==0)
				   {
					
					var card_click = [] ; var clicked_key;
					var clicked_card_count = 0;
					var card_type = data.card;
					var appended_key = (($("#images").children().length));
					var  src , obj ; 
					var appended_group_div;
					var next_key;
					
					ttt = data.check ;
					if(card_type=='open')
					{
						src=$("#open_card").attr("src");
						open_card_src =$("#open_card").attr("src");
						picked_card_value = src;
						next_key = open_card_id;
						picked_card_id = open_card_id;
						is_open_close_picked = 1;
						
						obj = data.card_data.reduce(function(acc, cur, i) {
							acc[i] = cur;
						return acc;
						});
						remove_obj = obj;
						
						if(((data.open_arr).length)!=0)
						{
							discarded_open_arr = [];
							discarded_open_arr.push.apply(discarded_open_arr,data.open_arr);
						}
						console.log("Open Card Array "+discarded_open_arr.length+"--"+JSON.stringify(discarded_open_arr));
						
						if((discarded_open_arr.length)==0)
						{
							$("#open_card").attr('src', "closedimg.bmp");  
						}
						else
						{
							$("#open_card").attr('src', discarded_open_arr[(discarded_open_arr.length)-1].card_path);
						}
					}
					else if(card_type=='close')
					{
						src=data.path;
						open_card_src =$("#open_card").attr("src");
						picked_card_value = src;
						next_key = close_card_id;
						picked_card_id = data.card_data.id;
						is_open_close_picked = 1;
						remove_obj =data.card_data;
						if(((data.open_arr).length)!=0)
						{
							temp_closed_cards_arr1 = [];
							temp_closed_cards_arr1.push.apply(temp_closed_cards_arr1,data.open_arr);
							closed_card_src_temp = data.open_arr[0].card_path;
							closed_card_id_temp = data.open_arr[0].id;
							console.log("******************* open/close closed card array --"+JSON.stringify(temp_closed_cards_arr1));
						}else {closed_card_src_temp ="";closed_card_id_temp = 0;}
					}
					
						user_assigned_cards = [];
						if(data.hand_cards.length<=14)
						user_assigned_cards.push.apply(user_assigned_cards,data.hand_cards);
						if(appended_key!=0)
						{
						////showing updated hand cards(14) after open/close select-initial
						 if(data.hand_cards.length<=14)
						 show_player_hand_cards(data.hand_cards,data.sidejokername);
						}
						else
						{console.log("Update groups");}
					//}
				}
				else
				{
					alert("You have already picked card from either Close / Open Card ");
				}
			   }
			  }
	});///open/close card click 	

	/////after open selected - if it is joker card then message select close card
	socket.on("pick_close_card_six", function(data) 
	{
		if(data.user==loggeduser)
		{
			if(tableid==data.group)///check for same table
			{
				//if(table_round_id == data.round_id)///check for same table-round id
				{
					////show this message by using tooltip ////					
					is_picked_card = false;
					alert("You are trying to select Joker Card, Select Card From Closed Cards.");
				}
			}
		}
	});
				
				
	/////after open selected - if it is joker card then message select close card
	socket.on("disallow_pick_card_six", function(data) 
	{
		if(data.user==loggeduser)
	  {
		if(tableid==data.group)///check for same table
		{
			//if(table_round_id == data.round_id)///check for same table-round id
			{
				alert("You can pick only 1 card at a time from open/close cards!");
			}
		}
	  }
	});
/**************** Open / Close card select ends  ********/

/* ------------------ discard / show open card start --------------*/

///if selected open/close card ,discard card 
	function discard(clicked_card_id,clicked_card_src,key,parent,cardvalue,card_id,open_obj)//,checkvalue
	{
		if(card_id != "" && card_id != undefine && card_id != null){
					//alert("hi")
				var c = [];
				c.push(open_obj);
				console.log("open card data @ discard ---------"+JSON.stringify(open_data)); 
							  
				selected_card_arr = jQuery.grep(selected_card_arr, function(value) {
					return value != cardvalue;});
				selected_card_arr1 = jQuery.grep(selected_card_arr1, function(value) {
					return value != key;});
				is_open_close_picked = 0;
								
				var selected_card_arr11 = []; 
				$("#discard_card").hide();
				$("#finish_game").hide();
				$('#discard_card').attr("disabled", 'disabled');
				$('#finish_game').attr("disabled", 'disabled');
				discard_click  = true ;
				next_turn = true;
				console.log("open card id and path before discard"+open_card_id+"---"+$("#open_card").attr("src"));
				$("#open_card").attr('src', clicked_card_src);  
				open_card_id = key;
				console.log("open card id and path AFTER discard"+open_card_id+"---"+$("#open_card").attr("src"));
				ttt = false;
				selected_card_arr = [];
				selected_group_card_arr = [];
								
					socket.emit("discard_fired_six",{discarded_user:loggeduser,group:tableid,round_id:table_round_id});
					console.log("discard clicked by "+loggeduser);
					
					socket.emit("show_open_card_six",
						{
							user: loggeduser,group:tableid,open_card_src:clicked_card_src,check:ttt,round_id:table_round_id,open_card_id:open_card_id,discard_card_data:card_id,discarded_open_data:open_data,is_sort:is_sorted,is_group:is_grouped,group_from_discarded:0,is_initial_group:initial_group
						});
		}
	}//discard ends 

	/////after discard , show open card to other player
	socket.on("open_card_six", function(data) 
	{
		console.log("discard_open_cards "+JSON.stringify(data.discard_open_cards));
		if(tableid==data.group)///check for same table
		{
			//if(table_round_id == data.round_id)///check for same table-round id
			{
				$("#open_card").attr('src', data.path); 
				open_card_src =$("#open_card").attr("src");
				open_card_id = data.id;
				is_open_close_picked = 0;
				ttt = data.check;
				var temp = [];
				var temp1 = [];
				temp.push(data.discareded_open_card);
						
				console.log("OPEN DATA recvd  "+JSON.stringify(temp));
				open_data = temp;
				discard_click  = false ;
				$("#discareded_open_cards").empty();		
				
				console.log("\n data.discard_open_cards.length "+data.discard_open_cards.length+"--data--"+JSON.stringify(data.discard_open_cards));

				if(data.discard_open_cards.length>0)
				{
					$.each(data.discard_open_cards, function(k, v) 
					{
						$("#discareded_open_cards").append("<img width='10%' height='10%' src="+v.card_path+">");
					});
				}		
			}
		}
	});
/* ------------------ discard / show open card start --------------*/
	
/* ------------ Finish Start   -----------------*/
	function finish(finish_card_obj,key,parent)
	{
		$("#confirm-msg").html("Are you sure to finish?");
		$("#popup-confirm").show();

		$("#confirm-yes").unbind().click(function() {
			$("#popup-confirm").hide();							
			$("#finish_card").show(); 
			is_finished = true;
			$('#finish_game').attr("disabled", 'disabled');
			$('#discard_card').attr("disabled", 'disabled');
			$("#discard_card").hide();
			$("#finish_game").hide();
			hide_all_add_here_buttons();
						
			var parent_id = parent;
			console.log("\n &&&&&&& in finish"+JSON.stringify(finish_card_obj)+"-- parent --"+parent+" parent_id "+parent_id);
						
			socket.emit("show_finish_card_six",
				{
					player:loggeduser,group:tableid,round_id:table_round_id,finish_card_id:key,finish_card_obj:finish_card_obj,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,group_from_finished:parent_id,is_finished:is_finished
				});
						
				// $("#player1turn").hide();
				// $("#player2turn").hide();
				hide_all_players_turn_details();
				$('#declare').attr("disabled", 'disabled');
				$("#declare").show();
				$("#msg").empty();
				$("#msg").css('display', "inline-block"); 
				$("#msg").html("Group your cards and Declare...!");

				is_picked_card = false;
		});
	}///finish ends 
				
	socket.on("finish_card_six", function(data) 
	{
	   if(data.user==loggeduser)
		{
			if(tableid==data.group)
			{
			    //if(table_round_id == data.round_id)
				{
					$("#finish_card").show();
					$("#finish_card").attr('src', data.path); 
					// $("#player1turn").hide();
					// $("#player2turn").hide();
					hide_all_players_turn_details();
			    }
			}  
		}
	});
/* ------------ Finish Start   -----------------*/	
	$("#confirm-no").click(function() {
		$("#popup-confirm").hide();
	});
/*-------------- Drop Game start ---------------*/
	$("#drop_game").click(function()
	{		
		$("#confirm-msg").html("Are you sure to drop?");
		$("#popup-confirm").show();

		$("#confirm-yes").unbind().click(function() {
			$("#popup-confirm").hide();

			$('#drop_game').attr("disabled", 'disabled');
			if(player_turn==true)
			{
				$("#drop_game").hide();
				$("#drop_game").css('display','none');
				is_game_dropped = true;
				console.log(" Game Dropped by player "+loggeduser);
				
					socket.emit("drop_game_six",
					{
						user_who_dropped_game: loggeduser,group:tableid,round_id:table_round_id,/*amount:player_amount,*/is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group
					});
			}
		});
	});	

	socket.on('player_dropped_game', function(playername,tableid_recvd)
	{
		if($('.declare-table').is(':visible'))
		{
			$(".declare-table").hide();
			console.log("HIDEHIDE player_dropped_game");
		}
		if(tableid==tableid_recvd)
		{
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i)+"_name").text()) == playername)
				{
					$("#player_"+(i)+"_disconnect").css('display','block'); 
					$("#player_"+(i)+"_status").text("Dropped");
				}
				if(playername == loggeduser)
				{
					player_in_game = false;					
					$("#sort_cards").hide();
				}
			}
		}
	});

	
	socket.on('player_poollost_game', function(playername,tableid_recvd)
	{
		if($('.declare-table').is(':visible'))
		{
			$(".declare-table").hide();
			console.log("HIDEHIDE player_poollost_game");
		}
		if(tableid==tableid_recvd)
		{
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i)+"_name").text()) == playername)
				{
					$("#player_"+(i)+"_disconnect").css('display','block'); 
					$("#player_"+(i)+"_status").text("Lost");
				}
				if(playername == loggeduser)
				{
					player_in_game = false;
					$("#sort_cards").hide();
				}
			}
		}
	});
	////after player dropped game 
	socket.on("dropped_game_six", function(data) 
	{
		hide_all_add_here_buttons();
		console.log("\n dropped data "+JSON.stringify(data));
		$(".declare-table").show();
		var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
		$('#game_summary').find('td').remove();
		$('#game_summary tr:gt(3)').remove();

		var restart_timer = 10;
		var name; 
		var game_score =0 , amount_won =0;
		var player_grouped = false;
		var index = -1;
		var players_name_arr = [];
		var players_card_arr = [];
		var players_group_status_arr = [];
		var players_score_arr = [];
		var players_amount_arr = [];

		var pl_name_arr_temp = [];
		var pl_card_arr_temp = [];
		var pl_grp_status_arr_temp = [];
		var pl_score_arr_temp = [];
		var pl_amount_arr_temp = [];
		var temp_grps = [];

		players_name_arr.push.apply(players_name_arr,data.players);
		players_card_arr.push.apply(players_card_arr,data.players_cards);
		players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
		players_score_arr.push.apply(players_score_arr,data.players_score);
		players_amount_arr.push.apply(players_amount_arr,data.players_amount);

		for(var  i = 0; i < players_name_arr.length;)
		{
			if(players_name_arr[i] != loggeduser)
			{
				pl_name_arr_temp.push(players_name_arr[i]);
				pl_card_arr_temp.push(players_card_arr[i]);
				pl_grp_status_arr_temp.push(players_group_status_arr[i]);
				pl_score_arr_temp.push(players_score_arr[i]);
				pl_amount_arr_temp.push(players_amount_arr[i]);

				index = i;
				if(index != -1)
				{
					players_name_arr.splice(index, 1);
					players_card_arr.splice(index, 1);
					players_group_status_arr.splice(index, 1);
					players_score_arr.splice(index, 1);
					players_amount_arr.splice(index, 1);
				}
			}
			else
			{
				i++
				break;
			}
		}
		players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
		players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
		players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
		players_score_arr.push.apply(players_score_arr,pl_score_arr_temp);
		players_amount_arr.push.apply(players_amount_arr,pl_amount_arr_temp);

		//show popup to no of connnected players (playing game)
		//for(var k=1; k<=data.players.length; k++)
		for(var k=1; k<=players_name_arr.length; k++)
		{
			// if(k==1)
			// {
			// 	name = loggeduser;
			// 	game_score = 0;
			// 	amount_won = 0;
			// }
			// else
			// { 
			// 	name = data.players[k-1]; 
			// 	game_score = 0;
			// 	amount_won = 0;
			// }

			name = players_name_arr[k-1]; 
			game_score = players_score_arr[k-1];
			amount_won = players_amount_arr[k-1];

			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

			if(k==players_name_arr.length)
			{
				$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
									
				var joker_card_src = $("#joker_card").attr("src");	
				$("#side_joker").attr('src', joker_card_src); 
			}

			if(name==data.winner)
			{
				$('#win'+(k)+'').append('<img style="width: 40%" src="winner-rummy.jpg"/>');
			}

			if(loggeduser==data.winner)
			{
				audio_player_winner.play();
				$("#seq").text(" Valid ");
			}
			else { $("#seq").text(" Wrong "); }

			if(players_group_status_arr[k-1] == false)
			{
				if(players_card_arr[k-1].length>0)
				{
					$.each(players_card_arr[k-1], function(n,m)
					{
						if(n=0)
							$('#pl'+(k)+'cards1').append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
						else
							$('#pl'+(k)+'cards1').append('<img  id="'+m.id+'" src="' + m.card_path + '" />');  
					});
				}
			}
			else
			{
				temp_grps = [];
				temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
				if(temp_grps.length>0)
				{
					for(var p=1; p<=temp_grps.length; p++)
					{
						if(temp_grps[p-1].length>0)
						{
							$.each(temp_grps[p-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards'+p).append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards'+p).append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
							});
						}//if-pl-group-length not 0
					}
				}
			}	
		}//for ends 
					
		///clear data after game ends 
		clear_player_data_after_declare();
		hide_all_players_turn_details();
		$('#div_msg').show();
		declare = 2;
		console.log("***************declare"+declare);
	});///after player dropped game
	/*-------------- Drop Game start ---------------*/

/*******************  Declare game start *************/
$("#declare").click(function()
{
	$("#confirm-msg").html("Are you sure to declare?");
	$("#popup-confirm").show();

	$("#confirm-yes").unbind().click(function() {
		$("#popup-confirm").hide();
		$(".declare-table").show();

		$('#declare').attr("disabled", 'disabled');
		$("#declare").hide();
		$("#msg").hide();
		is_declared = true;
		
		socket.emit("declare_game_six",{user: loggeduser,group:tableid,round_id:table_round_id,amount:player_amount,is_declared:is_declared,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,auto_declare:false});
		if(declare == 1 )
		{
			declare = 2;
		}
	});
});///declare_click ends

///event to show wrong-declared player status publically
socket.on('player_declared_game', function(playername,tableid_recvd)
{
	if($('.declare-table').is(':visible'))
	{
		$(".declare-table").hide();
		console.log("HIDEHIDE player_declared_game");
	}
	if(tableid==tableid_recvd)
	{
		$("#finish_card").hide();
		$('#finish_card').attr("disabled", 'disabled');
		$("#finish_card").attr('src',""); 
		if(playername == loggeduser)
		{
			player_in_game = false;	
			$('#declare').attr("disabled", 'disabled');
			$("#declare").hide();			
			$("#sort_cards").hide();
			$("#msg").hide();

			is_picked_card = false;
			if(declare == 1 )
			{
				declare = 2;
			}
		}
		for(var  i = 1; i < 7; i++)
		{
			if(($("#player_"+(i)+"_name").text()) == playername)
			{
				$("#player_"+(i)+"_disconnect").css('display','block'); 
				$("#player_"+(i)+"_status").text("Invalid Declared");
			}
		}
	}
});
	
///event to show group cards message publically if any player declared valid sequence
socket.on('declared_six', function(data)
{
	if(data.user==loggeduser)
	{
		if(tableid==data.group)
		{
		    //if(table_round_id == data.round_id)
			{
				//if(data.game_status == "dropped"  || )
			    console.log("\n declared_user is  "+data.declared_user);
				$("#msg").empty();
				$("#msg").css('display', "inline-block"); 
				$("#msg").html("Player "+data.declared_user+" has declared game,group your cards and declare");
				$('#declare').attr("disabled", 'disabled');
				$("#declare").show();
				$("#drop_game").hide();
				declare = data.declare;
				// if(declare == 1 )
				{
					is_other_declared = true;//check and change here sbt 6-pl-condition
				}
			}
		}  
	}
});//declared ends 

////after player declared valid game 
socket.on("declared_data_six", function(data) 
{
	console.log("\n declared  data "+JSON.stringify(data));
	$(".declare-table").show();
	is_declared = false;
	$('#declare').attr("disabled", 'disabled');
	$("#declare").hide();
	$("#msg").hide();
	$("#tr_joker").hide();
	$("#tr_msg").hide();
	
	if(declare == 1 )
	{ declare = 2; }

	var name; 
	var game_score =0 , amount_won =0;
	var player_grouped = false;
	var index = -1;
	var players_name_arr = [];
	var players_card_arr = [];
	var players_group_status_arr = [];
	
	var pl_name_arr_temp = [];
	var pl_card_arr_temp = [];
	var pl_grp_status_arr_temp = [];
	var pl_score_arr_temp = [];
	var pl_amount_arr_temp = [];
	var temp_grps = [];

	players_name_arr.push.apply(players_name_arr,data.players);
	players_card_arr.push.apply(players_card_arr,data.players_cards);
	players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
	
	for(var  i = 0; i < players_name_arr.length;)
	{
		if(players_name_arr[i] != loggeduser)
		{
			pl_name_arr_temp.push(players_name_arr[i]);
			pl_card_arr_temp.push(players_card_arr[i]);
			pl_grp_status_arr_temp.push(players_group_status_arr[i]);
			
			index = i;
			if(index != -1)
			{
				players_name_arr.splice(index, 1);
				players_card_arr.splice(index, 1);
				players_group_status_arr.splice(index, 1);
			}
		}
		else
		{
			i++
			break;
		}
	}
	players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
	players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
	players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
	
	//show popup to no of connnected players (playing game)
	for(var k=1; k<=players_name_arr.length; k++)
	{
		name = players_name_arr[k-1]; 
		if(name == loggeduser)
		{
			game_score = 0;
			amount_won = '--';

			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards" style="text-align: center;"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

			if(players_group_status_arr[k-1] == false)
			{
				if(players_card_arr[k-1].length>0)
				{
					$.each(players_card_arr[k-1], function(n,m)
					{
						if(n=0)
							$('#pl'+(k)+'cards1').append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
						else
							$('#pl'+(k)+'cards1').append('<img  id="'+m.id+'" src="' + m.card_path + '" />');  
					});
				}
			}
			else
			{
				temp_grps = [];
				temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
				if(temp_grps.length>0)
				{
					for(var p=1; p<=temp_grps.length; p++)
					{
						if(temp_grps[p-1].length>0)
						{
							$.each(temp_grps[p-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards'+p).append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards'+p).append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
							});
						}//if-pl-group-length not 0
					}
				}
			}
		}
		else
		{
			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards" style="text-align: center;"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td><td style="text-align:center"><img style="width: 30%;" src="buyin.gif" /></td></tr>');
			$("#seq").text(" Valid ");

			$('#pl'+(k)+'cards'+1).append('<img  src="buyin.gif" />'); 
		}	
	}//for ends 
					
	///clear data after game ends 
	clear_player_data_after_declare();
	$('#div_msg').prepend('<label id="lbl_popup" style="color:white">To see Popup details </label><label id="click_here_popup" style="color:blue;text-decoration:underline">Click here</label><br>');
						
	$("#click_here_popup").click(function()
	{
		$(".declare-table").show();
	});
	$('#div_msg').show();
});///after player declared valid  game

////after  declared game -popup to all players
socket.on("declared_final_six", function(data) 
{

		console.log("\n declared  final data "+JSON.stringify(data));
		$(".declare-table").show();
		var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
		$('#game_summary').find('td').remove();
		$('#game_summary tr:gt(3)').remove();

		var restart_timer = 10;
		var name; 
		var game_score =0 , amount_won =0;
		var player_grouped = false;
		var index = -1;
		var players_name_arr = [];
		var players_card_arr = [];
		var players_group_status_arr = [];
		var players_score_arr = [];
		var players_amount_arr = [];
		var n=1;
		var pl_name_arr_temp = [];
		var pl_card_arr_temp = [];
		var pl_grp_status_arr_temp = [];
		var pl_score_arr_temp = [];
		var pl_amount_arr_temp = [];
		var temp_grps = [];
		
		players_name_arr.push.apply(players_name_arr,data.players);
		players_card_arr.push.apply(players_card_arr,data.players_cards);
		players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
		players_score_arr.push.apply(players_score_arr,data.players_score);
		players_amount_arr.push.apply(players_amount_arr,data.players_amount);

		for(var  i = 0; i < players_name_arr.length;)
		{
			if(players_name_arr[i] != loggeduser)
			{
				pl_name_arr_temp.push(players_name_arr[i]);
				pl_card_arr_temp.push(players_card_arr[i]);
				pl_grp_status_arr_temp.push(players_group_status_arr[i]);
				pl_score_arr_temp.push(players_score_arr[i]);
				pl_amount_arr_temp.push(players_amount_arr[i]);

				index = i;
				if(index != -1)
				{
					players_name_arr.splice(index, 1);
					players_card_arr.splice(index, 1);
					players_group_status_arr.splice(index, 1);
					players_score_arr.splice(index, 1);
					players_amount_arr.splice(index, 1);
				}
			}
			else
			{
				i++
				break;
			}
		}
		players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
		players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
		players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
		players_score_arr.push.apply(players_score_arr,pl_score_arr_temp);
		players_amount_arr.push.apply(players_amount_arr,pl_amount_arr_temp);

		//console.log("\n players_name_arr "+JSON.stringify(players_name_arr));
		//console.log("\n players_score_arr "+JSON.stringify(players_score_arr));

		for(var k=1; k<=players_name_arr.length; k++)
		{
			name = players_name_arr[k-1]; 
			//console.log("\n ....... displaying details of player "+name);
				game_score = players_score_arr[k-1];
				amount_won = players_amount_arr[k-1];
				if((players_score_arr[k-1]) != -1)
				{
					$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

					if(name==data.winner)
					{
						$('#win'+(k)+'').append('<img style="width: 40%" src="winner-rummy.jpg"/>');
					}

					if(loggeduser==data.winner)
					{
						audio_player_winner.play();
						$("#seq").text(" Valid ");
					}
					else { $("#seq").text(" Wrong "); }

					if(players_group_status_arr[k-1] == false)
					{
						if(players_card_arr[k-1].length>0)
						{
							$.each(players_card_arr[k-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards1').append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards1').append('<img  id="'+m.id+'" src="' + m.card_path + '" />');  
							});
						}
						
					}
					else
					{
						temp_grps = [];
						temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
						if(temp_grps.length>0)
						{
							for(var p=1; p<=temp_grps.length; p++)
							{
								if(temp_grps[p-1].length>0)
								{
									$.each(temp_grps[p-1], function(n,m)
									{
										if(n=0)
											$('#pl'+(k)+'cards'+p).append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
										else
											$('#pl'+(k)+'cards'+p).append('<img  id="'+m.id+'" src="' + m.card_path + '" />'); 
									});
								}//if-pl-group-length not 0
							}
						}
					}
				}
				else
				{
					$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td></tr>');

							$('#pl'+(k)+'cards'+1).append('<img  src="buyin.gif" />');
				}
				if(k==players_name_arr.length)
				{
						$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
											
						var joker_card_src = $("#joker_card").attr("src");	
						$("#side_joker").attr('src', joker_card_src); 
				}
		}//for ends 
					
		///clear data after game ends 
		// clear_data_if_disconnected_player();//clear data of player if disconnected
		clear_player_data_after_declare();
		hide_all_players_turn_details();
		$('#div_msg').show();
		declare = 2;
});////after  declared game -popup to all players
/*******************  Declare game ends *************/

/*******************  Clear / disable all buttons **************/
// function clear_player_data_after_declare(player_status)
// {
// 	if(player_status == true)
// 	{

// 	}
// }
/*******************  Clear / disable all buttons **************/

/*********** clear player details after game ends ********/
///clear data of  player
	function clear_player_data_after_declare()
	{
		$('#div_msg').empty();
		$("#images").empty();
		$("#msg").empty();
		$("#msg").hide();
		$("#open_deck").hide();
		$("#card_group1").empty();
		$("#card_group2").empty();
		$("#card_group3").empty();
		$("#card_group4").empty();
		$("#card_group5").empty();
		$("#card_group6").empty();
		$("#card_group7").empty();
		$("#discareded_open_cards").empty();
		$("#open_card").hide();
		$("#closed_cards").hide();
		$("#joker_card").hide();
		$("#open_card").attr('src','');  
		$("#closed_cards").attr('src', "");  
		$("#sort_cards").hide();
		$("#drop_game").hide();
		$("#finish_card").hide();
		$('#finish_card').attr("disabled", 'disabled');
		$('#drop_game').attr("disabled", 'disabled');
		open_card_src = '';
		closed_card_src = '';
		picked_card_value = '';
		$("#declare").hide();
		$("#discard_card").hide();
		$("#finish_game").hide();
		$("#group_cards").hide();
		$('#declare').attr("disabled", 'disabled');	
		$('#discard_card').attr("disabled", 'disabled');			
		$('#finish_game').attr("disabled", 'disabled');	
		random_group_roundno = 0;
		check_join_count = 10;
		selected_card_count=0;
		is_open_close_picked = 0;
		click_count = 0;
		activity_msg_count = 3;
		player_turn = false;
		discard_click = false ;
		next_turn = false ;
		remove_obj = null;
		ttt = false;
		initial_group = false;
		is_grouped_temp = false;
		initial_group_temp = false;
		is_sorted = false;
		is_grouped = false;
		open_data = '';
		close_data='';
		open_obj = "";
		user_assigned_cards = [];
		temp_closed_cards_arr = [];
		temp_closed_cards_arr1 = [];
		closed_card_src_temp = '';
		selected_card_arr = [];
		selected_card_arr1 = [];
		selected_group_card_arr = [];
		vars = {};
		grp1 = [];grp2 = [];grp3 = [];grp4 = [];
		grp5 = [];grp6 = [];grp7 = [];
		add_card_obj = "";
		is_declared = false ;
		is_other_declared = false ;
		parent_group_id = 0;
		selected_group_id = 0;
		selected_card_id = 0;
		discarded_open_arr = [];
		
		//clear_data_if_disconnected_player();
		for(var  i = 1; i < 7; i++)
		{
			$("#player_"+(i)+"_disconnect").hide();
			$("#player_"+(i)+"_dealer").hide();
		}
	}//// clear_player_data_after_declare() ends 
/* ANDY 20190529
function clear_data_if_disconnected_player()
{
	//alert("---");
	for(var  i = 1; i < 7; i++)
	{
		if(($("#player_"+(i)+"_status").text()) == "Disconnected")
		{
			$("#player_"+(i)+"_name").text("");
			$("#player_"+(i)+"_amount").text("");
			$("#player_"+(i)+"_details").hide();
			$("#player_"+(i)+"_sit").css('display','block');
			console.log("line 3727\n");
			$("#player_"+(i)+"_male_player").css('display','none');
			$("#player_"+(i)+"_female_player").css('display','none');

		}
	}
}//clear_data_if_disconnected_player() ends 
*/

socket.on('game_no_enough', function(playername, table_id){
	if(tableid == table_id && loggeduser == playername){
		alert("You have not enough points to continue");
		window.close();
	}
});
/*********** clear player details after game ends ********/

/***************************   Game Finished    *******************/
			
socket.on('game_finished_six', function(data)
{
	console.log("game_finished_six " + JSON.stringify(data));
	if(tableid==data.group)
	{
	    for(var i = 0; i < data.user.length; i++)
		{
			for(var j = 1; j < 7; j++) {
				if(($("#player_"+(j)+"_name").text()) == data.user[i])
				{
					$("#player_"+(j)+"_amount").text(data.amount[i]);	    		
				}
			}
		}
	}
});

socket.on('touranment_game_end', function(tournamentId_recvd, group, winner)
{
	console.log("touranment_game_end");
	if(tournamentId==tournamentId_recvd)
	{
		if(tableid==group) {			
			is_game_end = true;

			clear_player_data_after_declare();
			hide_all_players_turn_details();

			$(".declare-table").hide();
			console.log("HIDEHIDE touranment_game_end");

			if( winner == loggeduser ) {
				$('#div_msg').html("You have win this game. Please wait for next game.");
			} else {
				$('#div_msg').html(winner + " have win this game. You have loss. <br> Please wait until game finished for position.");

				tableid = 0;
			}
			$('#div_msg').show();
		}
	}
});

socket.on('tournament_position', function(data)
{
	console.log("tournament_position");
	if(tournamentId == data.tournamentId)
	{
		$(".declare-table").hide();
			console.log("HIDEHIDE tournament_position");

		status = data.title + " - You get " + data.position + " pos";
      	status += "(" + data.score + " points)";
		$('#div_msg').html(status);
		$('#div_msg').show();
	}
});
/***************************   Game Finished    *******************/

/*********** If Game has re-started again **************/
socket.on('update_amount_six', function(tournamentid_listening, tableid_listening,name_array,amount_array)
{
	if(checkPlayerExistInGame(loggeduser,name_array))//if logged player playing game again 
	{
		if(tournamentId==tournamentid_listening)
		{
			if( tableid == tableid_listening ) {
				for(var i = 0; i < name_array.length; i++) 
				{
					if(name_array[i] == loggeduser)
					{
						player_amount = amount_array[i];
					}
					for(var j = 0; j < name_array.length; j++) 
					{
						if(($("#player_"+(i+1)+"_name").text()) == name_array[j])
						{
							$("#player_"+(i+1)+"_amount").text(amount_array[j]);
						}
					}
				}
			}
		}
	}
});

function checkPlayerExistInGame(currentPlayer,player_name_array_server)
{
	var found = false;
	for(var i = 0; i < player_name_array_server.length; i++) 
	{
		if(player_name_array_server[i] == currentPlayer)
		{
			found = true;
			break;
		}
	}
	return found;
}//checkPlayerExistInGame ends 

/*********** If Game has re-started again **************/

/*********-----------------  Player Disconnect start -----------------************/
socket.on('player_disconnected_six', function(playername,tableid_recvd)
{
	if($('.declare-table').is(':visible'))
	{
		//$(".declare-table").hide();
		// console.log("HIDEHIDE player_disconnected_six");
	}
	if(tableid==tableid_recvd)
	{
		for(var  i = 1; i < 7; i++)
		{
			if(($("#player_"+(i)+"_name").text()) == playername)
			{
				// $("#player_"+(i)+"_male_player").css('display','none');
				// $("#player_"+(i)+"_female_player").css('display','none'); 
				$("#player_"+(i)+"_disconnect").css('display','block'); 
				$("#player_"+(i)+"_status").text("Disconnected");
			}
		}//for ends 
	}
});

/*********-----------------  Player Disconnect ends -----------------************/

/************.......... REFRESH START ..............*********/
	$('#refresh').click(function() 
		{
			//alert(activity_timer_status+"--joined_table--"+joined_table);
		 	is_refreshed = true;
		    console.log("\n ON REFRESH CLICK ");			
			//clear_player_data_after_declare();

			setTimeout( function() {
				location.reload();
			}, 100 );
		});

socket.on('player_reconnected_six', function(tournamentId_recvd, tableid_recvd,pl_names,player_sit_arr,players_amount,players_gender, players_playing)
	{
		console.log("player_reconnected_six\n");
		/*
		if($('.declare-table').is(':visible'))
		{
			$(".declare-table").hide();
		} */
		if(tournamentId==tournamentId_recvd && tableid == tableid_recvd )
		{
			var player_name_array = [];var player_sit_array = [];
			var player_amount_array = [];var player_gender_array = [];
			var player_name_array_temp = [];var player_sit_array_temp = [];
			var player_amount_array_temp = [];var player_gender_array_temp = [];
			var player_playing_array = [];var player_playing_array_temp = [];
			var index = -1;

			player_name_array.push.apply(player_name_array,pl_names);
			player_sit_array.push.apply(player_sit_array,player_sit_arr);
			player_amount_array.push.apply(player_amount_array,players_amount);
			player_gender_array.push.apply(player_gender_array,players_gender);
			player_playing_array.push.apply(player_playing_array,players_playing);

			for(var  i = 0; i < player_name_array.length;)
			{
				if(player_name_array[i] != loggeduser)
				{
					player_name_array_temp.push(player_name_array[i]);
					player_sit_array_temp.push(player_sit_array[i]);
					player_amount_array_temp.push(player_amount_array[i]);
					player_gender_array_temp.push(player_gender_array[i]);
					player_playing_array_temp.push(player_playing_array[i]);

					index = i;
					if(index != -1)
					{
						player_name_array.splice(index, 1);
						player_sit_array.splice(index, 1);
						player_amount_array.splice(index, 1);
						player_gender_array.splice(index, 1);
						player_playing_array.splice(index, 1);
					}
				}
				else
				{
					i++
					break;
				}
			}//for

			player_name_array.push.apply(player_name_array,player_name_array_temp);
			player_sit_array.push.apply(player_sit_array,player_sit_array_temp);
			player_amount_array.push.apply(player_amount_array,player_amount_array_temp);
			player_gender_array.push.apply(player_gender_array,player_gender_array_temp);
			player_playing_array.push.apply(player_playing_array,player_playing_array_temp);
			btnclicked = player_sit_array[0];

			hide_all_players_details();
			
			console.log("display players : player_reconnected_six\n");
			console.log("player_reconnected_six  player_sit_array:" + JSON.stringify(player_sit_array) + " \n");
			for(var  i = 0; i < player_name_array.length; i++)
			{
				$("#player_"+(i+1)+"_name").text(player_name_array[i]);
				$("#player_"+(i+1)+"_amount").text(player_amount_array[i]);
				if(player_gender_array[i] == 'Male')
				{ 
					$("#player_"+(i+1)+"_male_player").css('display','block');
					$("#player_"+(i+1)+"_female_player").css('display','none');					
				}
				else 
				{ 
					$("#player_"+(i+1)+"_male_player").css('display','none');
					$("#player_"+(i+1)+"_female_player").css('display','block'); 
				} 
				$("#player_"+(i+1)+"_details").show();

				if( player_playing_array[i] == false ) {
					$("#player_"+ (i+1)+"_disconnect").css('display','block'); 
					$("#player_"+ (i+1)+"_status").text("Waiting");
				}
			}
		}//same-table-id
    });
	
 socket.on('other_player_reconnected_six', function(playername,tournamentId_recvd, tableid_recvd,pl_amount,pl_gender)
	{
		//alert(playername+"--"+tableid_recvd+"--"+pl_amount+"--"+pl_gender);
		if(tournamentId==tournamentId_recvd && tableid == tableid_recvd)
		{
			console.log("display players : other_player_reconnected_six\n");
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i)+"_name").text()) == playername)
				{
					$("#player_"+(i)+"_disconnect").hide();
					$("#player_"+(i)+"_name").text(playername);
					$("#player_"+(i)+"_amount").text(pl_amount);
					$("#player_"+(i)+"_details").show();
					$("#player_"+(i)+"_sit").css('display','none');
					
					if(pl_gender == 'Male')
					{ $("#player_"+(i)+"_male_player").css('display','block'); }
					else { $("#player_"+(i)+"_female_player").css('display','block'); }
				}
			}
		}
	});
    /*** Show player data on refresh ***/
	socket.on("refresh_six", function(data) 
	{
		console.log("\n IN REFRESH EVENT  "+JSON.stringify(data));
		//console.log("\n finish data "+data.is_finish+"--obj-"+JSON.stringify(data.finish_obj));
		if(tournamentId == data.tournamentId && tableid == data.group_id)///check for same table
		{
			//table_round_id = data.round_no;
			//joined_table= data.is_joined_table;
			joined_table= true;
			activity_timer_status = true;
				
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i+1)+"_name").text())==data.dealer)
				{$("#player_"+(i+1)+"_dealer").show();}
			}
				
			$("#open_deck").show();
			if(data.is_grouped == false)
			{
				user_assigned_cards.push.apply(user_assigned_cards, data.assigned_cards); 
				$('#images_parent').append( $('#images') );
				show_player_hand_cards(data.assigned_cards,data.sidejokername);
			}
			else if(data.is_grouped == true)				
			{ is_grouped = true; }
					
			$("#open_card").show();
			$("#closed_cards").show();
			$("#joker_card").show();
				
			$("#closed_cards").attr('src', "c3.jpg");  
			$("#joker_card").attr('src', data.sidejoker);  
				
			var temp = [];
			temp.push(data.open_data);
			//console.log("OPEN DATA recvd  "+JSON.stringify(temp));
						
			if(data.open_length == 1)
			{
				initial_open_card = data.open_data;
				open_data = '';
			}
			else
			{
				open_data = data.open_data;
			} 
			//console.log("\n %%%%%%%%%% open data path "+data.opencard+" id "+data.opencard_id+" obj "+JSON.stringify(data.open_data));
				  
			if(data.is_finish == true)				
			{ 
				is_finished = true; 
				$("#finish_card").show();
				$("#finish_card").attr('src', data.finish_obj.card_path); 
				hide_all_players_turn_details();
						
				$("#declare").show();
				$("#msg").empty();
				$("#msg").css('display', "inline-block"); 
				$("#msg").html("Group your cards and Declare...!");
				$("#drop_game").hide();
			}
			if(data.open_data.length>0)
			{
				$("#open_card").attr('src', data.open_data[0].card_path);  
			}
			else
			{
				$("#open_card").attr('src', "closedimg.bmp");  
			}
			
			// if(data.close_cards.length>0)
			// {
			// 	temp_closed_cards_arr1[0]=data.close_cards[0];
			// 	closed_card_src_temp = data.close_cards[0].card_path;
			// 	closed_card_id_temp = data.close_cards[0].id;
			// }
			if(data.closedcards_path.length>0)
			{
				temp_closed_cards_arr1[0]=data.closedcards_path[0];
				closed_card_src_temp = data.closedcards_path[0].card_path;
				closed_card_id_temp = data.closedcards_path[0].id;
			}
			$("#discareded_open_cards").empty();		
			if(data.close_cards.length>0)
			{
				$.each(data.close_cards, function(k, v) 
					{
						$("#discareded_open_cards").append("<img width='10%' height='10%' src="+v.card_path+">");
					});
			}		
		} 
	}); 
/************.......... REFRESH ends  ..............*********/

/* ------------   Game leave / window close / refresh starts  -----------*/
		$("#leave_confirm").click(function()
		{
				if($.trim($('#div_msg').html())!=''){
					$('#div_msg').hide();
				}
		});
			
		$("#leave_group_cancel").click(function()
			{
				if($.trim($('#div_msg').html())!=''){
					$('#div_msg').show();
				}
		});
			
		var is_clicked = false;
		/////leaving group (manually clicked 'leave table' menu) ////
		$("#leave_group").click(function()
		{
				is_clicked = true;
				
			  if(!activity_timer_status)
			  {
				window.close();				
			  }
			  else
				{	
					$('#leave_group').prop('disabled', true);
				}
				
		});

		$(window).unload(function()
			{
			
			is_refreshed = false;
			});  

			socket.on("player_left_six_pl_game", function(data) 
			{
				//alert(data.game_restart);
		     console.log("--- in pl left ---"+socket.id);
			 console.log(" in player_left "+JSON.stringify(data));
			 var index = -1;

			 if(tableid==data.group)
			 {
			 	if($('.declare-table').is(':visible'))
					{
						var check_join_count = 3;
						var countdown1 = setInterval(function()
						{
							check_join_count--;
							if (check_join_count == 0)
								{
									clearInterval(countdown1);  
									$(".declare-table").hide();
									activity_timer_status=false;
								}
						}, 1000);
					}

				for(var  i = 0; i < 6; i++)
				{
					$("#player_"+(i+1)+"disconnect").hide();
				}
				is_finished = false ;
				 is_game_dropped = false;
				 console.log("\nANDY player_left_six_pl_game  declare:" + declare);
			 	declare = 0;
			 
			 	var count = 5; 
				$('#div_msg').empty();
				$('#div_msg').show();
				$('#div_msg').prepend(data.left_user+' has left the Game...!');//+"activity_timer_status"+activity_timer_status);
				// if(data.game_restart == true) {
				// console.log("\n player_name_array "+JSON.stringify(player_name_array));
				// 					console.log("\n player_sit_array "+JSON.stringify(player_sit_array));
				// 					console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
				// 					console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
				// 					for(var  j = 0; j < player_name_array.length;)
				// 					{
				// 						if(player_name_array[j] == data.left_user)
				// 						{
				// 							index = j;
				// 							if(index != -1)
				// 							{
				// 								player_name_array.splice(index, 1);
				// 								player_sit_array.splice(index, 1);
				// 								player_amount_array.splice(index, 1);
				// 								player_gender_array.splice(index, 1);
				// 							}
				// 						}
				// 						else
				// 						{
				// 							j++;
				// 							break;
				// 						}
				// 					}
				// 					console.log("\n after player_name_array "+JSON.stringify(player_name_array));
				// 					console.log("\n ----- player_sit_array "+JSON.stringify(player_sit_array));
				// 					console.log("\n ----- player_amount_array "+JSON.stringify(player_amount_array));
				// 					console.log("\n ----- player_gender_array "+JSON.stringify(player_gender_array));
				// 						}
				var countdown = setInterval(function(){
						  if (count == 0)
						   {
								  clearInterval(countdown);  
								 $('#div_msg').empty();
								if(data.joined_player == 1)
								{
									$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
								}
								else if(data.joined_player == 0)
								{
									$('#div_msg').hide();
								}
								/*
								if(data.game_restart == false) 
								{
									$("#player_"+(data.btn)+"_name").text("");
									$("#player_"+(data.btn)+"_amount").text("");
									$("#player_"+(data.btn)+"_details").hide();
									$("#player_"+(data.btn)+"_sit").css('display','block');
									$("#player_"+(data.btn)+"_loader").css('display','none');
									$("#player_"+(data.btn)+"_male_player").css('display','none');
									$("#player_"+(data.btn)+"_female_player").css('display','none');

								}
								else*/
								{
									for(var  i = 1; i < 7; i++)
									{
										if(($("#player_"+(i)+"_name").text()) == data.left_user)
										{
											$("#player_"+(i)+"_name").text("");
											$("#player_"+(i)+"_amount").text("");
											$("#player_"+(i)+"_details").hide();
											$("#player_"+(i)+"_sit").css('display','none');
											$("#player_"+(i)+"_loader").css('display','none');
											console.log("line 4232\n");
											$("#player_"+(i)+"_male_player").css('display','none');
											$("#player_"+(i)+"_female_player").css('display','none');
										}
									}
									// console.log("\n player_name_array "+JSON.stringify(player_name_array));
									// console.log("\n player_sit_array "+JSON.stringify(player_sit_array));
									// console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
									// console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
									// for(var  j = 0; j < player_name_array.length;)
									// {
									// 	if(player_name_array[j] == data.left_user)
									// 	{
									// 		index = j;
									// 		if(index != -1)
									// 		{
									// 			player_name_array.splice(index, 1);
									// 			player_sit_array.splice(index, 1);
									// 			player_amount_array.splice(index, 1);
									// 			player_gender_array.splice(index, 1);
									// 		}
									// 	}
									// 	else
									// 	{
									// 		j++
									// 		break;
									// 	}
									// }
									// console.log("\n after player_name_array "+JSON.stringify(player_name_array));
									// console.log("\n ----- player_sit_array "+JSON.stringify(player_sit_array));
									// console.log("\n ----- player_amount_array "+JSON.stringify(player_amount_array));
									// console.log("\n ----- player_gender_array "+JSON.stringify(player_gender_array));
								}
							}
							count--;
						  }, 1000);
					}//if same table 
			});//player_left ends 

/* ------------   Game leave / window close / refresh end  -----------*/

		socket.on('show_sixgame_data', function(players_joined,player_sit_arr,tournamentid_listening, tableid_listening, player_amount_arr,player_poolamount_arr,player_gender_arr,is_restart_game, players_playing)
			{
				
				console.log("\n show_sixgame_data IN check_if_joined_player sit array  "+JSON.stringify(player_sit_arr)+" amount array "+JSON.stringify(player_amount_arr)+" gender array "+JSON.stringify(player_gender_arr)+" players name array  "+JSON.stringify(players_joined));
				if(tournamentId==tournamentid_listening)
				{
					is_finished = false;

					tableid = tableid_listening;
					//table_round_id = roundId;
					//$("#deal_id").html(table_round_id);

					console.log("\nANDY show_sixgame_data  declare:" + declare);
					declare = 0;
					is_game_dropped=false;

					// if(is_game_started == true || is_restart_game == false)
					// {
					// 	$('#div_msg').empty(); 
					// }
					if(is_game_started == false)
					{
						for(var  i = 0; i < players_joined.length; i++)
						{
							if(loggeduser==players_joined[i])
							{  
								joined_table=true; 
								btnclicked = player_sit_arr[i];
								player_amount = player_amount_arr[i];
								player_gender = player_gender_arr[i];
							}
						}	
					} 
					if(is_restart_game == true){ is_game_started = true; }
					else { is_game_started = false; }

					if($('.declare-table').is(':visible'))
					{
						var check_join_count = 3;
						var countdown1 = setInterval(function(){
						check_join_count--;
						if (check_join_count == 0)
						{
							clearInterval(countdown1);  
							$(".declare-table").hide();
							activity_timer_status=false;
						}
					  }, 1000);
					}

					//ANDY if(is_game_started == false)
					{
						for(var  i = 1; i < 7; i++)
						{
							$("#player_"+(i)+"_name").text("");
							$("#player_"+(i)+"_amount").text("");
							$("#player_"+(i)+"_details").hide();
							console.log("line 4329\n");
							$("#player_"+(i)+"_male_player").css('display','none');
							$("#player_"+(i)+"_female_player").css('display','none');
							$("#player_"+(i)+"_sit").hide();
						}
						console.log("display players : show_sixgame_data\n");
						
						for(var  i = 0; i < players_joined.length; i++)
						{
							$("#player_"+(player_sit_arr[i])+"_loader").hide();
							$('#player_'+(player_sit_arr[i])+'_sit').css('display','none');
							$("#player_"+(player_sit_arr[i])+"_name").text(players_joined[i]);
							$("#player_"+(player_sit_arr[i])+"_amount").text(player_amount_arr[i]);
							$("#player_"+(player_sit_arr[i])+"_poolamount").text(player_poolamount_arr[i]);
							$("#player_"+(player_sit_arr[i])+"_details").show();

							console.log("\n " + player_gender_arr[i]);
							if(player_gender_arr[i] == 'Male')
							{ 
								$("#player_"+(player_sit_arr[i])+"_male_player").css('display','block');
								$("#player_"+(player_sit_arr[i])+"_female_player").css('display','none');					
							}
							else 
							{ 
								$("#player_"+(player_sit_arr[i])+"_male_player").css('display','none');
								$("#player_"+(player_sit_arr[i])+"_female_player").css('display','block'); 
							} 
							if($.trim($('#div_msg').html())=='' && players_joined.length ==1)
							{
								console.log("\ div_msg is empty ");
								$('#div_msg').prepend('<label style="color:white">Wait Till Game End!</label>');
								$('#div_msg').show();
							}
						
						}//for ends 
					}
				}
			});

			// Drag And Drop
			$("#card_group1, #card_group2, #card_group3, #card_group4, #card_group5, #card_group6, #card_group7").dragsort({ 
				dragSelector: "div",
				dragBetween: true,
				dragStart: dragStart,
				dragEnd: saveOrder });
			
			$("#images").dragsort({ dragSelector: "div", dragBetween: true });

			function getGroupIdFromTag( tagId ) {
				for(i = 1; i <= 7; i++) {
					if(tagId == ("card_group" + i))
						return i;
				}
				return 0;
			}	

			function dragStart() {
				var groupId = getGroupIdFromTag($(this).parent().attr('id'));
				if( groupId == 0 )
					return;
					
				parent_group_id = groupId;
				selected_card_id = $(this).children().attr('id');
				var sort_groups = [sort_grp1, sort_grp2, sort_grp3, sort_grp4, sort_grp5, sort_grp6, sort_grp7 ];
				for(var  i = 0; i < sort_groups[groupId - 1].length; i++)
				{
					if(sort_groups[groupId - 1][i].id == selected_card_id)
					{
						open_obj = sort_groups[groupId - 1][i];
						break;
					}
				}

				add_card_obj=open_obj;
			}
			function saveOrder() {	
				$('#discard_card').attr("disabled", 'disabled');
				$('#finish_game').attr("disabled", 'disabled');
				$("#discard_card").hide();
				$("#finish_game").hide();
				var groupId = getGroupIdFromTag($(this).parent().attr('id'));
				if( groupId == 0 )
					return;
				//if( groupId == parent_group_id )
					//return;
				
				$i=0;
				$('#card_group'+groupId).children('div').each(function(idx, val){
					   //alert(val);
					   if($(this).children('img').attr('id') == selected_card_id)
					   {
						 
						   //alert($i);
					      add_here_drop( groupId,$i );
					   }
					   $i++;
				})
				
				//add_here( groupId );
			};
			$("#closed_cards").dragsort({ dragSelector: "div", dragBetween: true});

		});//function ends 
	</script>		
	<script src="pop-up_six.js"></script>
</html>