<!DOCTYPE html>
<html>
<head>
	<title>PappluRummy</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="favicon.ico" rel="shortcut icon" type="image/ico">
	<link href="css/font-awesome.min.css" rel="stylesheet"/>
	<link href="style.css" rel="stylesheet">
	<script src="/jquery.js"></script>
	<script src="/socket.io/socket.io.js"></script>
	<!--<script type="text/javascript" src="./node_datetime.js"></script>-->
	<style>
	<!--.jokerimg{
		margin-left: -4%; 		
		width:2% !important;
	}-->


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
	<script type="text/javascript">
	//function called when drag starts
		/*function dragIt(theEvent) {
		//tell the browser what to drag
		//alert(theEvent);
		theEvent.dataTransfer.setData("Text", theEvent.target.id);		
		}
		//function called when element drops
		function dropIt(theEvent) {
		//get a reference to the element being dragged
		var theData = theEvent.dataTransfer.getData("Text");
		alert(theData);
		//get the element
		var theDraggedElement = document.getElementById(theData);
		//add it to the drop element
		theEvent.target.append(theDraggedElement);
		alert(theEvent.target.id);
		//instruct the browser to allow the drop
		theEvent.preventDefault();
		}*/
	</script>
</head>
<body >
	<div class="table-wrapper">
		<!--<img src="/storerummy - latest.png" width="100%" height="auto">-->
		<div class="table-playing">
		<img src="/table22.png">
		</div>
		<!-- top menu start -->
		<div class="top-left-menu">
			<ul>
				<li><a href="#." class="openInfo">Game Info</a></li>
				<li><a href="#." id="buy_chips">Buy Chips</a></li>
				<li><a href="#." id="game_lobby">Lobby</a></li>
			</ul>
		</div>
		<div class="top-right-menu">
			<ul>
				<li><a href="#." id="help">Help</a></li>
				<li><a href="#" id="refresh">Refresh</a></li>
				<li><a class="button" href="#popup1" id="leave_confirm">Leave Table</a></li>
			</ul>
		</div>
		
		<!-- top menu end -->
	
		<!-- game info start -->
		<span style="display:none" id="table_id"><script> document.write(tableid);</script></span>
		<div class="gameInfo" scroll="no">
			<div style="background:#474749; padding:2% 4%; color:#fff">
				<h4>Game Information</h4>
				<i class="fa fa-times" aria-hidden="true"></i>
			</div>
			<table>
				<tbody>
					<tr>
						<td style="border:none">Table Name</td>
						<td style="border:none">: <script> document.write(table_name);</script></td>
					</tr>
					<tr>
						<td style="border:none">Game Varient</td>
						<td style="border:none">:  <script> document.write(game);
						</script></td>
					</tr>
					<tr>
						<td style="border:none">Game Type</td>
						<td style="border:none">: <script> document.write(game_type);</script></td>
					</tr>
					<tr>
						<td style="border:none">Deal Id</td>
						<td style="border:none">: <span id="deal_id"></span></td>
					</tr>
					<tr>
						<td style="border:none">Points Value</td>
						<td style="border:none">: <script> document.write(point_value);</script>point(s)</td>
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
					<div style="background:#4d94ff; color:#fff">
						<span>PappluRummy says...</span>
						<a class="close" href="#">&times;</a>
					</div>
					<div class="closepopup" style="background:linear-gradient(#808080,#474749)">
						<h5>Do want to leave the game table ?</h5>
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
		<!--<div class="front-chair" id="top_chair"><img src="chair-4.png"/></div>-->
		<div class="male-user" ><img style="display:none" id="top_male_player" src="male-4.png"/></div>
		<div class="female-user" ><img style="display:none" id="top_female_player" src="male-4.png"/></div>
		<div id="top_disconnect" style="position: absolute;
			margin-top: -47%;margin-left: 45.4%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none">
			disconnected
		</div>
		<div class="sit"><img id="top_player_sit"   src="sithere_btn.png" class="sit-popup"></div>
		<div class="ct-loader" style="display:none" id="top_player_loader"><img src="buyin.gif"></div>
		<div class="front-dealer" style="display:none"  id="top_player_dealer"><img src="dealer-icon.png"></div>
		<div  id="top_player_counts">
			<div class="ct-fif-sec" style="color:#fff" id="top_player_count1">
				<span  id="player1turn"></span>
			</div>
			<div class="ct-twe-sec" style="color:#fff" id="top_player_count2">
				
			</div>
		</div>
	</div>
	<div class="top-player" style="display:none" id="top_player_details">
		<label id="top_player_name"><big><b></b></big></label><br>
		<label id="top_player_amount"><big><b></b></big></label>
		<label id="top_player_poolamount" style="display:none"></label>
	</div>
	<!-- top sit here button -->
	
	<!-- table pop-up -->
	<div class="table-popup" id="table_popup">
		<div>
			<table style="border:none; font-size:13px">
				<tbody>
					<tr>
						<td>Table Name</td>
						<td>: <script> document.write(table_name);</script></td>
					</tr>
					<tr>
						<td>Game Type</td>
						<td>: <script> document.write(game_type);</script></td>
					</tr>
					<tr>
						<td>Point Value</td>
						<td>: <script> document.write(point_value);</script></td>
					</tr>
					<tr>
						<td>Min Required</td>
						<td>: 	<span  id="table_min_entry"><script> document.write(min_entry);</script> </span></td>
					</tr>
					<tr>
						<td>Max Required</td>
						<td>:  	<span  id="max_entry"><script> document.write(min_entry*10);</script></span></td>
					</tr>
					<tr>
						<td>Your Account Bal</td>
						<td>: <script> document.write(account_bal);</script></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="dis-ib">
			<p class="dis-ib" style="width:70%; font-size:12px">How much would you like to bring amount on this table ?</p>
			<input type="text" style="width:28%" id="amount" name="amount"/>
		</div>
		<div style="font-size:12px; color:#ff3300">
			<span id="user_account_msg" style="color:red;"></span>
			<p style="margin:0px">*Amount should be in min and max required.</p>
		</div>
		<div>
			<img src="buyinwindow-ok-btn.png" class="btn-ok" id="btn_ok">
			<img src="repoart-prob-cancel-btn.png" class="btn-cancel" id="btn_cancel">
		</div>
	</div>
	<!-- table pop-up -->	
	
	<!-- table cards -->
	<div class="waiting-msg dis-ib" id="div_msg" style="display:none">
			
	</div>
	<div class="table-content-wrapper" ><!-- style="display:none" -->
		<div class="joker-card dis-ib" >
			<img src="" id="joker_card"  style="display:none" > 
		</div>
		<div class="close-card dis-ib" >
			<img src="" id="closed_cards"  style="display:none" > 
		</div>
		<div class="open-card dis-ib" >
			<img src="" id="open_card"  style="display:none" draggable="true" ondragstart="dragIt(event);"> 
		</div>
		<div class="discard-arrow dis-ib" style="display:none" id="open_deck">
			<img src="arrow-right.png"> 
		</div>
		<div id="lablepapplu" class="papplu-card dis-ib" style="display:none;">
		          <label  style="font-size: 8px;" >Papplu Joker</label>
				<img src="" id="papplu_joker" style="display:none" > 
		</div>
		<div class="discard-cards dis-ib" id="discareded_open_cards">
			
		</div>
		<div class="finish-card dis-ib" >
			<img src="" id="finish_card">  
		</div>
		
		
	    <div class="your-first-card" style="display:none">
			<label>Your Card</label>
			<img id="player_turn_card" />
		</div>
		<div class="opponent-first-card" style="display:none">
			<label>Your Opponent Card</label>
			<img id="opp_player_turn_card"/>
		</div>
	</div>
	<!-- table cards -->
	
	<!-- declare buttons -->
	<div class="content-buttons" >
		<span id="msg"></span>
		<div class="declare-but" id="declare" style="display:none">
			<img src="declare.png">
		</div>
		<div class="discard-but" id="discard_card" style="display:none">
			<img src="discard-btn.png">
		</div>
		<div class="finish-but" id="finish_game" style="display:none">
			<img src="finish.png">
		</div>
	</div>
	<!-- declare buttons -->
	
	<!-- declare popup start -->
	<div class="declare-table">
		<table class="table-bordered" id="game_summary" style="color:#fff">
			<tbody>
				<tr>
					<th style="padding:1% 4%" colspan="4">Table Name : <script> document.write(table_name);</script></th>
					<th class="close-declpop">Close</th>
				</tr>
				<tr>
					<th style="padding:1% 4%" colspan="5">You Declared &nbsp;<span id="seq"></span>   &nbsp; sequence. </th>
					
				</tr>
				<tr style="text-align:center;background:#ff4d4d;color:#404040;border-top:1px solid #fff;border-bottom:1px solid #fff" id="tr_summary">
					<th style="width:12%">User Name</th>
					<th style="width:10%">Show Status</th>
					<th style="width:70%">Results</th>
					<th>Game Score</th>
					<th>Amount Won</th>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- declare popup end -->
	
	<!-- rummy cards start -->
	<div class="rummy-cards"  id="images_parent">
		<div class="btn-group"  style="display:inline">
			<button id="group_cards" style="display:none">Group</button>
		</div>
		<div class="add-here-1"  style="display:inline">
				<button id="add_group1" style="display:none">Add Here</button>
		</div>
		
		<div class="add-here-2"  style="display:inline">
				<button id="add_group2" style="display:none">Add Here</button>
		</div>
		
		<div class="add-here-3"   style="display:inline">
				<button id="add_group3" style="display:none">Add Here</button>
		</div>
		
		<div class="add-here-4"   style="display:inline">
				<button id="add_group4" style="display:none">Add Here</button>
			</div>
		
		<div class="add-here-5"   style="display:inline">
				<button id="add_group5" style="display:none">Add Here</button>
			</div>
		
		<div class="add-here-6"   style="display:inline">
				<button id="add_group6" style="display:none">Add Here</button>
			</div>
		
		<div class="add-here-7"   style="display:inline">
				<button id="add_group7" style="display:none">Add Here</button>
		</div>		
		<div class="group_images" id="images" style="position:relative">	
			<div></div>
		</div>
		<div class="joker" id="jokerimage" style="">	
		</div>
	</div>
	<div class="rummy-cards" >		
		<div id="list1">
			<div></div>
		</div>
		<div id="list2">
			<div></div>
		</div>
		<div id="list3">
			<div></div>
		</div>
		<div id="list4">
			<div></div>
		</div>
		<div id="list5">
			<div></div>
		</div>
		<div id="list6">
			<div></div>
		</div>
		<div id="list7">
			<div></div>
		</div>
	</div>
	<!-- rummy cards start -->
	
	<!-- bottom sit here button -->
	<div class="bottom-chair">
		<!--<div class="bott-chair" id="bottom_chair" ><img src="chair-1.png"/></div>-->
		<div class="bott-female" ><img id="bottom_female_player" style="display:none" src="female-1.png"/></div>
		<div class="bott-male" ><img id="bottom_male_player" style="display:none" src="male-1.png"/></div>
		<div id="bottom_disconnect" style="position: absolute;
			margin-top: -15%;margin-left: 31%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none">
			disconnected 
		</div>
		<div class="bott-sit"><img id="bottom_player_sit"  src="sithere_btn.png" class="sit-popup"></div>
		<div class="bot-dealer" style="display:none"  id="bottom_player_dealer"><img src="dealer-icon.png"></div>
		<div class="bot-loader" style="display:none"  id="bottom_player_loader"><img src="buyin.gif"></div>
		<div class="count-down"  id="bottom_player_counts">
			<div class="fif-sec" style="color:#fff" id="bottom_player_count1">
				<span  id="player2turn"></span>
			</div>
			<div class="twe-sec" style="color:#fff" id="bottom_player_count2">
				
			</div>
		</div>
	</div>
	<!-- bottom sit here button -->
	
	<!-- sort drop btton -->
	<div class="sort-drop-but" >
	 <div class="play-but" id="play_game" style="display:none"><img src="play.png"/></div>
		<div class="sort-but" id="sort_cards" style="display:none">
			<img src="sortbtn.png"/>
		</div>
		<div class="drop-but" style="display:none" id="drop_game">
			<img src="Dropbtn.png"/>
		</div>
	</div>
	<div class="bottom-player-name" style="display:none" id="bottom_player_details">
		<label id="bottom_player_name"><big><b></b></big></label><br>
		<label id="bottom_player_amount"><big><b></b></big></label>
		<label id="bottom_player_poolamount" style="display:none"></label>
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
	<!--<script src="countdown.js"></script>-->
	<script>
	 var joined_table=false; 

		$(function(){
		 var btnclicked;
		 var random_group_roundno =0;
		 var check_join_count = 10;
		 var player_amount;
		 var player_poolamount;
		 var activity_timer_status=false;
		  var user_assigned_cards = [];
		  var activity_msg_count = 3;
		  var player_turn = false;
		  var is_picked_card = false;
		  ////used for return card if no discard within timer ////
		  var picked_card_value;
		  var picked_card_id;
		  var discard_click = false ;
		 
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
		  var os_type = detectOS();
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
		  var no_of_jokers=0;
		  var flag=0;
		  var playerstartplay = false;

		  $("#play_game").on('click',function(){
			     
				$("#drop_game").hide();
				$("#play_game").hide();
				$('#play_game').attr("disabled", 'disabled');
                  socket.emit("play_btn_click_player_two",{
				       user_who_play_game: loggeduser,group:tableid,round_id:table_round_id,game_type:game_type
				  });
                                        
			});
	 		var sort_grp1 =[], sort_grp2 =[], sort_grp3 =[], sort_grp4 =[],
					sort_grp5 =[], sort_grp6 =[], sort_grp7 =[]; 

	
		 $(function () {  
        $(document).keydown(function (e) {  
            return (e.which || e.keyCode) != 116;  
        });  
    });  
	
		  $('#refresh').click(function() {
				//clear_player_data_after_declare();
				setTimeout( function() {
					location.reload();
				}, 100 );
			});

			
			socket= io.connect('http://rummysahara.com:3010');
			
				$("#player1turn").hide();
				$("#player2turn").hide();
				$("#top_player_count1").hide();
				$("#top_player_count2").hide();
				$("#bottom_player_count1").hide();
				$("#bottom_player_count2").hide();
				$("#finish_card").hide();
			
			/**** Emit to server -
			1. on connect check if any other player already exist on table
			2. on connect check logged player already present on table 
			****/
			
		   socket.on('connect', function(){
				if(tableid != 0 && loggeduser != ""){
				//console.log("------"+socket.id+"--"+loggeduser+"--"+tableid);
				socket.emit('user_opened_join_group',loggeduser,tableid);	
				console.log("------"+socket.id);
				//socket = socket.id;
				}
			});

		   socket.on('table_ip_restrict', function(playername, table_id) {
		   		if(tableid == table_id && loggeduser == playername){					
					alert("Another player from same ip joined table so please join another table to play game");
					window.close();
				}
		   });

		   socket.on('table_is_full', function(playername, table_id) {
		   		if(tableid == table_id && loggeduser == playername){					
					alert("Table is full.");
				}
		   });

		   socket.on('exist_player_seat', function(playername, table_id, sit_no) {
		   		if(tableid == table_id ){					
					alert("Player "+playername+" is already sited here.");
							is_refreshed = true;

							//clear_player_data_after_declare();

							setTimeout( function() {
							location.reload();
							}, 100 );
				}
		   });


			socket.on('game_no_enough', function(playername, table_id){
				if(tableid == table_id && loggeduser == playername){					
					//alert("You have not enough points to continue");
					window.close();
				}
			});
			
			socket.on('sit_not_empty', function(playername,sit_no,table_id)
			{
				if(tableid==table_id)
				{
					$("#table_popup").css('display','none');
					alert("Player "+playername+" is already sited here.");
					if(sit_no == 1)
					{
						$("#top_player_loader").css('display','none');
						if($('#top_player_details').is(':visible'))
						{
							$("#top_player_sit").css('display','none');
						}
						else
						{
							$("#top_player_sit").css('display','block');
						}
					}
					else if(sit_no == 2)
					{
						$("#bottom_player_loader").css('display','none');
						if($('#bottom_player_details').is(':visible'))
						{
							$("#bottom_player_sit").css('display','none');						
						}
						else
						{
							$("#bottom_player_sit").css('display','block');
						}
					}
				}
			});
			
			socket.on('player_disconnected', function(playername,tableid_recvd)
			   {
				
			   if($('.declare-table').is(':visible'))
				{
					$(".declare-table").hide();
				}
			   if(tableid==tableid_recvd)
					{
						if(($("#top_player_name").text()) == playername)
						{
							//$("#top_male_player").css('display','none'); 
							//$("#top_female_player").css('display','none'); 
							$("#top_disconnect").css('display','block'); 
						}
						if(($("#bottom_player_name").text()) == playername)
						{
							console.log("\nANDYANDYANDY 640");
							$("#bottom_male_player").css('display','none'); 
							$("#bottom_female_player").css('display','none'); 
							$("#bottom_disconnect").css('display','block'); 
						}
						
					}
			   });
			   
			socket.on('other_player_reconnected', function(playername,tableid_recvd,pl_amount,pl_gender,other_player)
			{
				if(tableid==tableid_recvd)
				{
						$("#top_disconnect").css('display','none'); 
						$("#bottom_disconnect").css('display','none'); 
						
					if(loggeduser!=playername && loggeduser!=other_player)
					{
						if(playername == $("#top_player_name").text())
						{
							$("#top_player_name").text(playername);
							$("#top_player_amount").text(pl_amount);
							$("#top_player_details").show();
							$("#top_player_sit").css('display','none');
					   
							if(pl_gender == 'Male')
								{ $("#top_male_player").css('display','block'); }
								else { $("#top_female_player").css('display','block'); }
						}
						else if(playername == $("#bottom_player_name").text())
						{
							$("#bottom_player_name").text(playername);
							$("#bottom_player_amount").text(pl_amount);
							$("#bottom_player_details").show();
							$("#bottom_player_sit").css('display','none');
					   
							if(pl_gender == 'Male')
								{ $("#bottom_male_player").css('display','block'); }
								else { $("#bottom_female_player").css('display','block'); }
						}
					}
					else
					{
						
						
						$("#top_player_name").text(playername);
						$("#top_player_amount").text(pl_amount);
						$("#top_player_details").show();
						$("#top_player_sit").css('display','none');
				   
						if(pl_gender == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
					}
				}
			});
			   
			socket.on('other_player_reconnected_pool', function(playername,tableid_recvd,pl_amount,player_poolamount,pl_gender,other_player)
			{
				if(tableid==tableid_recvd)
				{
						$("#top_disconnect").css('display','none'); 
						$("#bottom_disconnect").css('display','none'); 
						
					if(loggeduser!=playername && loggeduser!=other_player)
					{
						if(playername == $("#top_player_name").text())
						{
							$("#top_player_name").text(playername);
							$("#top_player_amountpool").text(player_poolamount);
							$("#top_player_amount").text(pl_amount);
							$("#top_player_details").show();
							$("#top_player_sit").css('display','none');
					   
							if(pl_gender == 'Male')
								{ $("#top_male_player").css('display','block'); }
								else { $("#top_female_player").css('display','block'); }
						}
						else if(playername == $("#bottom_player_name").text())
						{
							$("#bottom_player_name").text(playername);
							$("#bottom_player_poolamount").text(player_poolamount);
							$("#bottom_player_amount").text(pl_amount);
							$("#bottom_player_details").show();
							$("#bottom_player_sit").css('display','none');
					   
							if(pl_gender == 'Male')
								{ $("#bottom_male_player").css('display','block'); }
								else { $("#bottom_female_player").css('display','block'); }
						}
					}
					else
					{					
						$("#top_player_name").text(playername);
						$("#top_player_poolamount").text(player_poolamount);
						$("#top_player_amount").text(pl_amount);
						$("#top_player_details").show();
						$("#top_player_sit").css('display','none');
				   
						if(pl_gender == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
					}
				}
			});
		   socket.on('player_reconnected', function(playername,tableid_recvd,sit_no,amount,opp_player,opp_pl_amount,opp_pl_gender)
			{
			   console.log(" IN RECONNECT"+playername+"-tbl-"+tableid_recvd+"-sit-"+sit_no+"-amt-"+amount+"-opp -"+opp_player+"-opp amt-"+opp_pl_amount+"-opp gen -"+opp_pl_gender);
			   if($('.declare-table').is(':visible'))
				{
					$(".declare-table").hide();
				}
			   if(tableid==tableid_recvd)
					{
							$("#top_player_name").text(opp_player);
							$("#top_player_amount").text(opp_pl_amount);
							$("#top_player_details").show();
							$("#top_player_sit").css('display','none');
							
							$("#bottom_player_name").text(playername);
							$("#bottom_player_amount").text(amount);
							$("#bottom_player_details").show();
							$("#bottom_player_sit").css('display','none');
								
							if(opp_pl_gender == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
							
							if(player_gender == 'Male')
							{ $("#bottom_male_player").css('display','block'); }
							else { $("#bottom_female_player").css('display','block'); }
							
							
							
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
			/* show loader to other players if a player is connecting on same table - to avoid join collision*/
			socket.on('player_connecting_to_table', function(playername,tableid_recvd,btn_clicked)
			   {
			   	if(loggeduser!=playername && tableid==tableid_recvd)
					{
						if(btn_clicked == 1 ) 
						{
							$("#top_player_loader").css('display','block');
							$("#top_player_sit").css('display','none');
						}
						else if(btn_clicked == 2 )
						{	
							$("#bottom_player_loader").css('display','block');
							$("#bottom_player_sit").css('display','none');
						}
					}
			   });
				
		/* hide loader to other players if a player is dis-connecting on same table - to avoid join collision*/
		socket.on('player_not_connecting_to_table', function(playername,tableid_recvd,btn_clicked)
		{
			if(loggeduser!=playername && tableid==tableid_recvd)
					{
						if(btn_clicked == 1 ) 
						{
							$("#top_player_loader").css('display','none');
							$("#top_player_sit").css('display','block');
						}
						 if(btn_clicked == 2 )
						{	
							$("#bottom_player_loader").css('display','none');
							$("#bottom_player_sit").css('display','block');
						}
					}
		});
		
		/** get from server - on connect check if any other player already exist on table **/
		socket.on('user1_join_group_check', function(userjoined,btnclicked,groupid_listening,player_gender_recvd,player_amount_recvd,is_restart_game)
		{
			//alert("");
			console.log("\n player "+userjoined+"  gender ->"+player_gender_recvd+" sit no "+btnclicked+" amount "+player_amount_recvd+" -- is is_restart_game "+is_restart_game);
			is_finished = false;
			declare = 0;
			is_game_dropped=false;
				//console.log("\n  player "+userjoined+" joined at "+btnclicked);		
			if(is_game_started == true)				
			{$('#div_msg').empty();}
			if(is_restart_game == false)
			{
				$('#div_msg').empty(); 
			}

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
				$("#bottom_disconnect").hide();
				$("#top_disconnect").hide();
				
			  /* if(is_restart_game == true){ is_game_started = true; }
			  else { is_game_started = false; } */
				if(is_game_started == false){
				if(loggeduser==userjoined)
				{
					joined_table=true;
				} }
				if(is_restart_game == true){ is_game_started = true; }
			    else { is_game_started = false; }
			  //console.log("\n b4 show is_game_started "+is_game_started);
				if(tableid==groupid_listening && is_game_started == false)//is_restart_game == false)
				{
					if($.trim($("#div_msg").html())=='')
					 {
					   console.log("\ div_msg is empty ");
						$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
						$('#div_msg').show();
						
						if(btnclicked == 1 ) 
						{
							$("#top_player_name").text(userjoined);
							$("#top_player_amount").text(player_amount_recvd);
							$("#top_player_details").show();
							
							$("#top_player_loader").css('display','none');
							$("#top_player_sit").css('display','none');
							
							if(player_gender_recvd == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
							
							////clear in restart
							$("#bottom_player_name").text("");
							$("#bottom_player_amount").text("");
							$("#bottom_player_details").hide();
							console.log("\nANDYANDYANDY 928");
							$("#bottom_male_player").css('display','none');
							$("#bottom_female_player").css('display','none');
							$("#bottom_player_sit").css('display','block');  
						}
						else if(btnclicked == 2 )
						{	
							$("#bottom_player_name").text(userjoined);
							$("#bottom_player_amount").text(player_amount_recvd);
							$("#bottom_player_details").show();
							
							$("#bottom_player_loader").css('display','none');
							$("#bottom_player_sit").css('display','none');
							if(player_gender_recvd == 'Male')
							{ $("#bottom_male_player").css('display','block'); }
							else { $("#bottom_female_player").css('display','block'); }
							
							////clear in restart
						    $("#top_player_name").text("");
							$("#top_player_amount").text("");
							$("#top_player_details").hide();
							$("#top_male_player").css('display','none');
							$("#top_female_player").css('display','none');
							$("#top_player_sit").css('display','block'); 
						}
					}
					else
					 { 
					  console.log("\ div_msg not empty ");
					 $('#div_msg').empty();  $('#div_msg').hide();
					 
					 }
 				}
			});	
			
			socket.on('user1_join_group_check_pool', function(userjoined,btnclicked,groupid_listening,player_gender_recvd,player_amount_recvd,player_poolamount_recvd,is_restart_game)
			{
			//alert("");
			console.log("\n player "+userjoined+"  gender ->"+player_gender_recvd+" sit no "+btnclicked+" amount "+player_amount_recvd+" -- is is_restart_game "+is_restart_game);
			is_finished = false;
			declare = 0;
			is_game_dropped=false;
				//console.log("\n  player "+userjoined+" joined at "+btnclicked);		
			if(is_game_started == true)				
			{$('#div_msg').empty();}
			if(is_restart_game == false)
			{
				$('#div_msg').empty(); 
			}
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
				$("#bottom_disconnect").hide();
				$("#top_disconnect").hide();
				
			  /* if(is_restart_game == true){ is_game_started = true; }
			  else { is_game_started = false; } */
				if(is_game_started == false){
				if(loggeduser==userjoined)
				{
					joined_table=true;
				} }
				if(is_restart_game == true){ is_game_started = true; }
			    else { is_game_started = false; }
			  //console.log("\n b4 show is_game_started "+is_game_started);
				if(tableid==groupid_listening && is_game_started == false)//is_restart_game == false)
				{
					if($.trim($("#div_msg").html())=='')
					 {
					 console.log("\ div_msg is empty ");
						$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
						$('#div_msg').show();
						
						if(btnclicked == 1 ) 
						{
							$("#top_player_name").text(userjoined);							
							$("#top_player_poolamount").text(player_poolamount_recvd);
							$("#top_player_amount").text(player_amount_recvd);
							$("#top_player_details").show();
							
							$("#top_player_loader").css('display','none');
							$("#top_player_sit").css('display','none');
							
							if(player_gender_recvd == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
							
							////clear in restart
							$("#bottom_player_name").text("");
							$("#bottom_player_amount").text("");
							$("#bottom_player_poolamount").text("");
							$("#bottom_player_details").hide();
							console.log("\nANDYANDYANDY 1031");
							$("#bottom_male_player").css('display','none');
							$("#bottom_female_player").css('display','none');
							$("#bottom_player_sit").css('display','block');  
						}
						else if(btnclicked == 2 )
						{	
							$("#bottom_player_name").text(userjoined);
							$("#bottom_player_poolamount").text(player_poolamount_recvd);
							$("#bottom_player_amount").text(player_amount_recvd);
							$("#bottom_player_details").show();
							
							$("#bottom_player_loader").css('display','none');
							$("#bottom_player_sit").css('display','none');
							if(player_gender_recvd == 'Male')
							{ $("#bottom_male_player").css('display','block'); }
							else { $("#bottom_female_player").css('display','block'); }
							
							////clear in restart
						    $("#top_player_name").text("");
							$("#top_player_amount").text("");
							$("#top_player_poolamount").text("");
							$("#top_player_details").hide();
							$("#top_male_player").css('display','none');
							$("#top_female_player").css('display','none');
							$("#top_player_sit").css('display','block'); 
						}
					}
					else
					 { 
					  console.log("\ div_msg not empty ");
					 $('#div_msg').empty();  $('#div_msg').hide();
					 
					 }
 				}
			});	
			socket.on('user1_join_group_check_watch', function(userjoined,btnclicked,groupid_listening,player_gender_recvd,player_amount_recvd,is_restart_game)
			{
				console.log("\n player watching "+userjoined+"  gender ->"+player_gender_recvd+" sit no "+btnclicked+" amount "+player_amount_recvd);
				if(loggeduser!=userjoined)
				{
				is_finished = false;
				declare = 0;
				is_game_dropped=false;
				//console.log("\n  player "+userjoined+" joined at "+btnclicked);		
				if(is_game_started == true)				
				{$('#div_msg').empty();}
			
				$("#bottom_disconnect").hide();
				$("#top_disconnect").hide();
			
				if(is_restart_game == true){ is_game_started = true; }
			    else { is_game_started = false; }
			  //console.log("\n b4 show is_game_started "+is_game_started);
				if(tableid==groupid_listening && is_game_started == false)//is_restart_game == false)
				{
					if($.trim($("#div_msg").html())=='')
					 {
						$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
						$('#div_msg').show();
						
						if(btnclicked == 1 ) 
						{
							$("#top_player_name").text(userjoined);
							$("#top_player_amount").text(player_amount_recvd);
							$("#top_player_details").show();
							
							$("#top_player_loader").css('display','none');
							$("#top_player_sit").css('display','none');
							
							if(player_gender_recvd == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
							
							////clear in restart
							$("#bottom_player_name").text("");
							$("#bottom_player_amount").text("");
							$("#bottom_player_details").hide();
							console.log("\nANDYANDYANDY 1109");
							$("#bottom_male_player").css('display','none');
							$("#bottom_female_player").css('display','none');
							$("#bottom_player_sit").css('display','block');  
						}
						else if(btnclicked == 2 )
						{	
							$("#bottom_player_name").text(userjoined);
							$("#bottom_player_amount").text(player_amount_recvd);
							$("#bottom_player_details").show();
							
							$("#bottom_player_loader").css('display','none');
							$("#bottom_player_sit").css('display','none');
							if(player_gender_recvd == 'Male')
							{ $("#bottom_male_player").css('display','block'); }
							else { $("#bottom_female_player").css('display','block'); }
							
							////clear in restart
						    $("#top_player_name").text("");
							$("#top_player_amount").text("");
							$("#top_player_details").hide();
							$("#top_male_player").css('display','none');
							$("#top_female_player").css('display','none');
							$("#top_player_sit").css('display','block'); 
						}
					}
					else
					 { $('#div_msg').empty();  $('#div_msg').hide();}
 				}
				}
			});	
			
			socket.on('user1_join_group_check_watch_pool', function(userjoined,btnclicked,groupid_listening,player_gender_recvd,player_amount_recvd,player_poolamount_recvd,is_restart_game)
			{
				console.log("\n player watching "+userjoined+"  gender ->"+player_gender_recvd+" sit no "+btnclicked+" amount "+player_amount_recvd);
				if(loggeduser!=userjoined)
				{
				is_finished = false;
				declare = 0;
				is_game_dropped=false;
				//console.log("\n  player "+userjoined+" joined at "+btnclicked);		
				if(is_game_started == true)				
				{$('#div_msg').empty();}
			
				$("#bottom_disconnect").hide();
				$("#top_disconnect").hide();
			
				if(is_restart_game == true){ is_game_started = true; }
			    else { is_game_started = false; }
			  //console.log("\n b4 show is_game_started "+is_game_started);
				if(tableid==groupid_listening && is_game_started == false)//is_restart_game == false)
				{
					if($.trim($("#div_msg").html())=='')
					 {
						$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
						$('#div_msg').show();
						
						if(btnclicked == 1 ) 
						{
							$("#top_player_name").text(userjoined);
							$("#top_player_poolamount").text(player_poolamount_recvd);
							$("#top_player_amount").text(player_amount_recvd);
							$("#top_player_details").show();
							
							$("#top_player_loader").css('display','none');
							$("#top_player_sit").css('display','none');
							
							if(player_gender_recvd == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
							
							////clear in restart
							$("#bottom_player_name").text("");
							$("#bottom_player_poolamount").text("");
							$("#bottom_player_amount").text("");
							$("#bottom_player_details").hide();
							console.log("\nANDYANDYANDY 1185");
							$("#bottom_male_player").css('display','none');
							$("#bottom_female_player").css('display','none');
							$("#bottom_player_sit").css('display','block');  
						}
						else if(btnclicked == 2 )
						{	
							$("#bottom_player_name").text(userjoined);
							$("#bottom_player_poolamount").text(player_poolamount_recvd);
							$("#bottom_player_amount").text(player_amount_recvd);
							$("#bottom_player_details").show();
							$("#bottom_player_loader").css('display','none');
							$("#bottom_player_sit").css('display','none');
							if(player_gender_recvd == 'Male')
							{ $("#bottom_male_player").css('display','block'); }
							else { $("#bottom_female_player").css('display','block'); }
							
							////clear in restart
						    $("#top_player_name").text("");
							$("#top_player_amount").text("");
							$("#top_player_poolamount").text("");
							$("#top_player_details").hide();
							$("#top_male_player").css('display','none');
							$("#top_female_player").css('display','none');
							$("#top_player_sit").css('display','block'); 
						}
					}
					else
					 { $('#div_msg').empty();  $('#div_msg').hide();}
 				}
				}
			});
			//$('#top_player_sit').click(function()
			$("#top_player_sit").unbind().on('click',function()
			{
			 if(tableid == 0 && loggeduser == "")
			{
				alert("Please Login to website  to Play Game");
			}
			else
			{
			if(is_game_started == false){
			btnclicked = 1;
			 if(account_bal > 0){
				
				$('#user_account_msg').text("");
				if(joined_table == true )
				{
					$("#top_player_loader").css('display','none');
					$("#top_player_sit").css('display','block');
				}
				else {
				$("#top_player_loader").css('display','block');
				$("#top_player_sit").css('display','none');
				//socket.emit('player_connecting_to_table', loggeduser,btnclicked,tableid); 
				socket.emit('player_connecting_to_table', loggeduser,tableid,btnclicked); 
				}
				check_join_count = 10;
				var countdown1 = setInterval(function(){
					check_join_count--;
					if (check_join_count == 0 && joined_table==false)
					{
						clearInterval(countdown1);  
						$("#table_popup").css('display','none');
						$("#top_player_loader").css('display','none');
						$("#top_player_sit").css('display','block');
						socket.emit('player_not_connecting_to_table', loggeduser,tableid,btnclicked);
					}
					}, 1000);
				}else { 
				$("#table_popup").css('display','none');
				}
				}
			  }
			});
			
			//$('#bottom_player_sit').click(function()
			$("#bottom_player_sit").unbind().on('click',function()
			{
			 if(tableid == 0 && loggeduser == "")
			{
				alert("Please Login to website  to Play Game");
			}
			else
			{
			if(is_game_started == false){
			btnclicked = 2;
			  if(account_bal > 0){
				$('#user_account_msg').text("");
				if(joined_table == true )
				{
					$("#bottom_player_loader").css('display','none');
					$("#bottom_player_sit").css('display','block');
				}
				else {
					$("#bottom_player_loader").css('display','block');
					$("#bottom_player_sit").css('display','none');
					socket.emit('player_connecting_to_table', loggeduser,tableid,btnclicked); 
				}
					///check if not clicked OK (not joined) within 10 sec then close/hide popup
				check_join_count = 10;
				var countdown2 = setInterval(function(){
					check_join_count--;
					if (check_join_count == 0 && joined_table==false)
					{
						clearInterval(countdown2);  
						$("#table_popup").css('display','none');
						$("#bottom_player_loader").css('display','none');
						$("#bottom_player_sit").css('display','block');
						socket.emit('player_not_connecting_to_table', loggeduser,tableid,btnclicked);
					}
					}, 1000);
				}
				else { 
				$("#table_popup").css('display','none');
				}
				}
			  }
			});
			
			//$('#btn_cancel').click(function()
			$("#btn_cancel").unbind().on('click',function()
			{
				if(btnclicked == 1 )
					{
						$("#top_player_loader").css('display','none');
						$("#top_player_sit").css('display','block');
						socket.emit('player_not_connecting_to_table', loggeduser,tableid,btnclicked);
					}
				else if(btnclicked == 2 )
					{	
						$("#bottom_player_loader").css('display','none');
						$("#bottom_player_sit").css('display','block');
						socket.emit('player_not_connecting_to_table', loggeduser,tableid,btnclicked);
					}
			});
			
			//$('#btn_ok').click(function()
			$("#btn_ok").unbind().on('click',function()
			{
				
				
				//browser_type = checkBrowser();
				//os_type = detectOS();
				if(joined_table==false)
				{
					var max_entry = parseInt(min_entry*10);
					var entered_amount = $("#amount").val();
					var account_val = parseInt(account_bal);
					if(entered_amount == '')
					{
						if(max_entry <= account_val)
						{player_amount = max_entry;}
						else
						{
							/* $('#user_account_msg').text("Enter valid amount.");
							$("#table_popup").css('display','show');
							player_amount = 0; */
							if(account_val >= min_entry)
							{player_amount =account_bal;}
							else
							{
								alert("You don't have sufficient balance to play game.");
								$("#table_popup").css('display','none');
								$("#btn_cancel").trigger("click");
								return;
							}
						}
					}
					else {player_amount = parseInt(entered_amount); }
				
					if(player_amount > 0)
					{
						joined_table=true;
						$("#table_popup").css('display','none');
						
						if(btnclicked == 1 ) 
						{
							$("#top_player_name").text(loggeduser);
							$("#top_player_amount").text(player_amount);
							$("#top_player_details").show();
							$("#top_player_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
						}
						else if(btnclicked == 2 )
						{	
						
							$("#bottom_player_name").text(loggeduser);
							$("#bottom_player_amount").text(player_amount);
							$("#bottom_player_details").show();
							
							$("#bottom_player_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#bottom_male_player").css('display','block'); }
							else { $("#bottom_female_player").css('display','block'); }
						}
						if($.trim($("#div_msg").html())=='')
						 {
							   $('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
							   $('#div_msg').show();
							  socket.emit('user1_join_group', loggeduser,btnclicked,tableid,random_group_roundno,1,player_amount,player_gender,browser_type, os_type,user_id,joined_table);  
						 }
						else
						 {
							socket.emit('user1_join_group', loggeduser,btnclicked,tableid,random_group_roundno,2,player_amount,player_gender,browser_type, os_type,user_id,joined_table); 
						 }
					}//if(player_amount > 0) ends 
				}
				else
				  {
					// if(btnclicked == 1 )
					// { $('#top_player_sit').prop('disabled', true); }
					// else if(btnclicked == 2 )
					// { $('#bottom_player_sit').prop('disabled', true); }
					}
				   //return false;	
				
				   //return false;	
			});
			
			/*Validation if amount entered */
			$("#amount").blur(function(){
			var entered_amount = parseInt($("#amount").val());
			var max_entry = parseInt(min_entry*10);
			var table_min_entry  = parseInt(min_entry);
			var user_account_bal = parseInt(account_bal);
			
			if(entered_amount >= table_min_entry)
			{
			  if((entered_amount < user_account_bal) || (entered_amount == user_account_bal))
				{
					if((entered_amount < max_entry))
					{
						$('#user_account_msg').text("");
					}
					else 
					{
						$("#amount").val('');
						$('#user_account_msg').text("Amount must be in between max entry and min entry");
					}
				}
				else 
					{
						$("#amount").val('');
						$('#user_account_msg').text("Enter valid amount.");
					}
			}
			else
			{
				$("#amount").val('');
				$('#user_account_msg').text("Enter amount greater than min entry.");
			}
			
			check_join_count = 10;
				var countdown3 = setInterval(function(){
				  check_join_count--;
					if (check_join_count == 0 && joined_table==false)
					{
						clearInterval(countdown3);
						$("#table_popup").hide();
						if(btnclicked == 1 )
						{
							$("#top_player_loader").css('display','none');
							$("#top_player_sit").css('display','block');
						}
						else if(btnclicked == 2 )
						{	
							$("#bottom_player_loader").css('display','none');
							$("#bottom_player_sit").css('display','block');
						}
					}
					}, 1000);
		});
		
		/*  on joining table show connected player to appropriate sit */
			socket.on('user1_join_group', function(username_recvd,user,tableid_listening,recvd_random_group_roundno,activity_timer,amount,gender,is_restart_game,activity_timer_client_side_needed,is_joined_table, other_name, other_amount)
			{			
				console.log("%%%%%%% is_restart_game"+is_restart_game+" activity_timer "+activity_timer+" --- "+activity_timer_client_side_needed);
				console.log("\n in user join grp is_finished "+is_finished+" declare "+declare+" is_game_dropped "+is_game_dropped);
				
				if(is_restart_game == true){ 
				is_game_started = true; 
				joined_table = is_joined_table;
				}else {is_game_started = false;}
				
			  if(tableid==tableid_listening){
				if(activity_timer==-1 )//&& is_restart_game == false)
				 {
				 console.log(" \n @@@@@@ ONLY 1 PLAYER SO WAITING MSG ------ ");
					  $('#div_msg').html('<label style="color:white">Waiting for another Player to join Table!</label>');
					  $('#div_msg').show();
						if(user==1)
						{
							$("#top_player_sit").css('display','none');
							$("#top_player_loader").css('display','none');
							
							if(is_restart_game == false){
							$("#top_player_name").text(username_recvd);
							$("#top_player_amount").text(amount);
							$("#top_player_details").show();
							if(gender == 'Male')
							{ $("#top_male_player").css('display','block'); }
							else { $("#top_female_player").css('display','block'); }
							}
						}
						else {
							$("#bottom_player_sit").css('display','none');						
							$("#bottom_player_loader").css('display','none');
							if(is_restart_game == false){
							$("#bottom_player_name").text(username_recvd);
							$("#bottom_player_amount").text(amount);
							$("#bottom_player_details").show();
							
							if(gender == 'Male')
							{ $("#bottom_male_player").css('display','block'); }
							else { $("#bottom_female_player").css('display','block'); }
							}
						}
					  
					}
				else
				 {					
				 		//console.log("\n user "+user+" amt "+amount+" gen "+gender+" recvd  uname "+username_recvd);
				 		clear_player_data_after_declare();

						$('#div_msg').empty();
						$('#div_msg').show();
						$('#div_msg').prepend(' <label style="color:white" id="Timer"></label><br>');
						$("#Timer").text('Activity will start within '+activity_timer +' seconds..!');


						
						if (activity_timer == 1) {
							 $("#deal_id").html(recvd_random_group_roundno);
							 table_round_id = recvd_random_group_roundno;
							 activity_timer_status = true;
							 $("#Timer").text("");
						}

						console.log("\n ANDYANDY is_finished "+is_finished+" declare "+declare+" is_game_dropped "+is_game_dropped);
						console.log("\n activity_timer " + activity_timer + "  activity_timer_client_side_needed "+activity_timer_client_side_needed);
						if(is_finished == true || declare == 2 || is_game_dropped == true)
						{
							$("#restart_game_timer").text('Game will start within '+activity_timer +' seconds..!');
							activity_timer_status=false;
							if (activity_timer == 1) {
									$(".declare-table").hide();
									///clear declare popup  data 
									$("#div_msg").empty();
									declare = 0;
									//activity_timer_status=false;
									activity_timer_status=true;
									is_finished = false ;
									is_game_dropped = false;
									$("#restart_game_timer").text("");
									$("#side_joker").attr('src', ""); 
									$('#game_summary').find('td').remove();
									$('#game_summary tr:gt(3)').remove();
								}
						}
						else
						{
						if (activity_timer == activity_timer_client_side_needed /*ANDY && is_restart_game == false*/) {
							console.log("\n\n ANDYANDY user " + user + "  " + loggeduser + ":" + username_recvd + " (" + gender +":" + player_gender +") " + amount + ":" + other_amount);
						
						 	$("#top_player_sit").css('display','none');
							$("#top_player_loader").css('display','none');	
						    $("#bottom_player_sit").css('display','none');						
							$("#bottom_player_loader").css('display','none');	

						$("#top_player_name").text(other_name);
						$("#top_player_amount").text(other_amount);

						$("#bottom_player_name").text(loggeduser);
						$("#bottom_player_amount").text(amount);
						
						$("#top_player_details").show();
						$("#bottom_player_details").show();

						if(gender == 'Male')
						{ $("#top_male_player").css('display','block');
							$("#top_female_player").css('display','none');}
						else { $("#top_male_player").css('display','none');$("#top_female_player").css('display','block'); } 
						
						if(player_gender == 'Male')
						{ $("#bottom_male_player").css('display','block');
							$("#bottom_female_player").css('display','none');}
						else { $("#bottom_male_player").css('display','none');$("#bottom_female_player").css('display','block'); } 
					 }///if timer==10
					 }///is finished
				}//else 
				}
			});
			
		socket.on('update_amount', function(username_recvd,tableid_listening,amount,opp_player,opp_player_amount)
			{
			 if(loggeduser==username_recvd)
			  {
			    if(tableid==tableid_listening)
			    {
						$("#top_player_amount").text(opp_player_amount);
						$("#bottom_player_amount").text(amount); 
						player_amount = amount;///update amount value after game restart 
				
					
			    }
		      }
			});
			socket.on('update_poolamount', function(username_recvd,tableid_listening,amount,poolamount,opp_player,opp_player_amount,opp_player_poolamount)
			{
				 if(loggeduser==username_recvd)
				  {
					if(tableid==tableid_listening)
					{							
								$("#top_player_poolamount").text(opp_player_poolamount);
								$("#bottom_player_poolamount").text(poolamount); 
							
								$("#top_player_amount").text(opp_player_amount);
								$("#bottom_player_amount").text(amount); 
							
							player_amount = amount;///update amount value after game restart 
							player_poolamount=poolamount;
						
					}
				  }
			});

			  socket.on('update_amount_other', function(username_recvd,tableid_listening,amount,opp_player,opp_player_amount)
			{
			console.log("\n logged player "+loggeduser+"-recvd nm --"+username_recvd+"- t name --"+$("#top_player_name").text()+"- amt --"+amount+"--b name -"+$("#bottom_player_name").text()+"--opp_player_amount-"+opp_player_amount);
			  if(loggeduser!=username_recvd && loggeduser!=opp_player)
				{
					if(tableid==tableid_listening)
					{
						if(($("#top_player_name").text()) == username_recvd)
						{
							$("#top_player_amount").text(amount);
							$("#bottom_player_amount").text(opp_player_amount); 
						}
						else //if(($("#bottom_player_name").text()) == opp_player)
						{
							$("#top_player_amount").text(opp_player_amount);
							$("#bottom_player_amount").text(amount); 
						}
						
					}
		        }
			}); 
			socket.on('update_pool_amount_other', function(username_recvd,tableid_listening,amount,poolamount,opp_player,opp_player_amount,opp_player_poolamount)
			{
			console.log("\n logged player "+loggeduser+"-recvd nm --"+username_recvd+"- t name --"+$("#top_player_name").text()+"- amt --"+amount+"--b name -"+$("#bottom_player_name").text()+"--opp_player_amount-"+opp_player_amount);
			  if(loggeduser!=username_recvd && loggeduser!=opp_player)
				{
					if(tableid==tableid_listening)
					{
						if(($("#top_player_name").text()) == username_recvd)
						{
							
								$("#top_player_poolamount").text(poolamount);
								$("#bottom_player_poolamount").text(opp_player_poolamount); 
							
								$("#top_player_amount").text(amount);
								$("#bottom_player_amount").text(opp_player_amount);
							
						}
						else //if(($("#bottom_player_name").text()) == opp_player)
						{
								
								$("#top_player_poolamount").text(opp_player_poolamount);
								$("#bottom_player_poolamount").text(poolamount); 
							
								$("#top_player_amount").text(opp_player_amount);
								$("#bottom_player_amount").text(amount); 
							
						}
						
					}
		        }
			}); 
			/***************************  GAME HAS STARTED   ********************************/
			
			/////displaying turn card on deck to both players to decide turn
			socket.on("firstcard", function(data) 
			{
			 if(tableid==data.group_id)///check for same table
			  {
			    if(table_round_id == data.round_no)///check for same table-round id
			    {			    	
					/* $("#images").append("<div><label style='color:white'>Your Card :</label> <img width='10%' height='9%' style='margin-left: 0%;' src="+data.card+"><br><label style='color:white'>Opponent player card : </label><img style='margin-top: 0%;margin-left: 0%;' width='10%' height='9%' src="+data.opp_pl_card+"></div>"); */
					$('.your-first-card').show();
					$("#player_turn_card").attr('src',data.card); 
					//$("#player_turn_card").attr('src',data.opp_pl_card); 
					$('.opponent-first-card').show();
					$("#opp_player_turn_card").attr('src',data.opp_pl_card); 
					//$("#opp_player_turn_card").attr('src',data.card); 
					
				}
			  }
			});///firstcard ends 
			
			//// According to turn distribute both players their respective 13 hand cards with open ,joker and closed cards
				var open_arr_temp = [];
			socket.on("turn", function(data) 
			{
			 console.log(" in TURN ----------");
			 if(tableid == data.group_id)///check for same table
			 {
			  if(table_round_id == data.round_no)
			{
				var opp_player;							 
				$('#div_msg').empty();
				$(".declare-table").hide();
				if(data.myturn) {
				
				  $("#div_msg").prepend("<span style='color:white;top:50%' class='label label-important'>You will Play First.</span>");
				  if(($("#top_player_name").text())==data.turn_of_user)
					{$("#bottom_player_dealer").show();}
					else
					{$("#top_player_dealer").show(); }
				  } 
				   else 
				   {
					if(($("#top_player_name").text())==data.turn_of_user)
					{
						opp_player =  $("#bottom_player_name").text();
						$("#top_player_dealer").show(); 
					}
					else
					{
						opp_player =  $("#top_player_name").text();
						$("#bottom_player_dealer").show();
					}
					  $("#div_msg").prepend("<span style='color:white;top:50%' class='label label-info'>Player  <b>"+opp_player+"  </b> will play first.</span>");
				   }
					var temp_count = 5;
					
					if(((data.closedcards_path).length)!=0)
					{temp_closed_cards_arr.push.apply(temp_closed_cards_arr,data.closedcards_path);}
					
						  var countdown = setInterval(function(){
						  temp_count--;
						  if (temp_count == 0) {
						 		  clearInterval(countdown);  
								 $('#div_msg').hide();
								 $('#div_msg').empty();
								 $("#images").empty();
								 $('.your-first-card').hide();
								 $('.opponent-first-card').hide();
								 
								user_assigned_cards.push.apply(user_assigned_cards, data.assigned_cards); 
								////// assign 13 cards to both players 
								$('#images_parent').append( $('#images') );
								show_player_hand_cards(data.assigned_cards,data.sidejokername);
								audio_shuffle.play();
								console.log("JOker=================="+data.sidejoker);
								
								console.log("PAppluJOker=================="+data.papplu_joker_card);
									////// open and closed and side joker images
									 if(data.opencard != ''){
										$("#open_card").show();
									}
									 $("#open_card").attr('src', data.opencard);
									 $("#closed_cards").show();
									 $("#joker_card").show();
									 
									   
									 $("#open_card").attr('src', data.opencard);  
									 initial_open_card = data.opencard1;
									 open_arr_temp.push(data.opencard1);
									 open_card_id=data.opencard_id;
									 $("#closed_cards").attr('src', "c3.jpg");  
									 $("#joker_card").attr('src', data.sidejoker);  
									 if(data.papplu_joker_card != '' && data.papplu_joker_card != null){
									 $("#lablepapplu").show();
									 $("#papplu_joker").show();
									 $("#papplu_joker").attr('src', data.papplu_joker_card);
									 }
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
			
		
		
			$("#open_card").unbind().on('click',function()
			{
			console.log("OPEN CARD CLICKED ");
			
			if(player_turn==true)
			{

                 if(game_type=='Papplu Rummy' && playerstartplay == false){
            	    alert("Please click play button first ");
		             return;
                }			
				if( is_picked_card ) {
					alert("You can pick only 1 card at a time from open/close cards!");
					return;
				}

				//audio_open  = new Audio('sounds/CardPick-Discard.wav');
				audio_open.play();
				
				/* audio_shuffle.pause();
				audio_shuffle.currentTime = 0; */
				
				//audio_close.pause();
				//audio_close.currentTime = 0;
				hide_all_add_here_buttons();

				//if(data.open_close_pick_count==0)
				open_card_src =$("#open_card").attr("src");
					if(open_card_src=='closedimg.bmp')
					{//alert("No Open Card/(s) available..!");
					}
					else {
						
					is_picked_card = true;
					var data_of_open_card;
					// data_of_open_card=data.opencard1;
					 console.log("start open_data"+open_data);
					/*if(open_data =='undefined'){open_data ='empty';} */
						 if(open_data !='')
						{
							data_of_open_card=open_data;
							console.log("***** open_data IF NOT BLANK "+JSON.stringify(data_of_open_card));
						}
						else
						{
						//data_of_open_card=data.opencard1;
						data_of_open_card=initial_open_card;
						console.log("***** open_data IF BLANK "+JSON.stringify(data_of_open_card));
						} 
						/* console.log("***** open_data in open click lenght "+open_arr_temp.length+"--data--"+JSON.stringify(open_arr_temp));
						if(open_arr_temp.length!=0)
						{
							data_of_open_card=open_arr_temp[(open_arr_temp.length-1)];
						}
								console.log("***** open_data in open click"+JSON.stringify(data_of_open_card));  */					

						/* ANDY */
						selected_card_arr = [];
						card_click = [];
						card_click_grp = [];
						selected_card_count = 0;
						//initial_group = false;
						$("#group_cards").hide();
						socket.emit("check_open_closed_pick_count",{user:player_having_turn,group:tableid,card:'open',card_data:data_of_open_card,path:open_card_src,round_id:table_round_id,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group});
							}
						 /* else 
						{
						//show this alert message as tooltip near open card
						 alert("You can pick only 1 card at a time from open/close cards!");
						 } */
						
				}
				else
				{
				//show this alert message as tooltip near open card
				//alert("You do not have turn to select open card!");
				}
			});
				

	//// closed card click
	$("#closed_cards").unbind().on('click',function()
	{ 
		if(player_turn==true)
		{	
		    if(game_type=='Papplu Rummy' && playerstartplay == false){
            	alert("Please click play button first ");
				return;
            }
			
			if( is_picked_card ) {
				alert("You can pick only 1 card at a time from open/close cards!");
				return;
			}
			is_picked_card = true;
			console.log("CLOSE  CARD CLICKED ");

				//audio_close  = new Audio('sounds/CardPick-Discard.wav');
				audio_close.play();

				hide_all_add_here_buttons();
				/* audio_shuffle.pause();
				audio_shuffle.currentTime = 0; */
				
				//audio_open.pause();
				//audio_open.currentTime = 0;
				
				
			//if(data.open_close_pick_count==0)
			//{
				/* if(temp_closed_cards_arr.length==0)
				{
				//alert("No Close Card/(s) available..!");
				}
				else
				{ */
				var data_of_closed_card;
				console.log("before card used by close array "+temp_closed_cards_arr1.length);
					/* if(temp_closed_cards_arr1.length==0)
					{
					data_of_closed_card = data.closedcards[0];
					closed_card_src =data.closedcards[0].card_path;
					close_card_id=data.closedcards[0].id;
					}
					else
					{
					data_of_closed_card = temp_closed_cards_arr1[0];
					closed_card_src = closed_card_src_temp;
					close_card_id = closed_card_id_temp;
					} */
					data_of_closed_card = temp_closed_cards_arr1[0];
					closed_card_src = closed_card_src_temp;
					close_card_id = closed_card_id_temp;
					
				console.log("After USED CLOSED "+JSON.stringify(data_of_closed_card));
				console.log("After close card used path "+closed_card_src+" id "+close_card_id);

				/* ANDY */
				selected_card_arr = [];
				card_click = [];
				card_click_grp = [];
				selected_card_count = 0;
				//initial_group = false;
				$("#group_cards").hide();							
				socket.emit("check_open_closed_pick_count",{user:player_having_turn,group:tableid,card:'close',card_data:data_of_closed_card,path:closed_card_src,round_id:table_round_id,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group});
						
										
				//}
			//}
		//else {alert("You can pick only 1 card at a time from open/close cards!");}
		}
		else
		{
		//show this alert message as tool-tip near open card
		//alert("You do not have turn to select close cards!");
		}
	});
											
			/*** Show player data on refresh ***/
			socket.on("refresh", function(data) 
			{
			console.log("\n IN REFRESH EVENT  ");
			console.log("\n finish data "+data.is_finish+"--obj-"+JSON.stringify(data.finish_obj));
			 if(tableid == data.group_id)///check for same table
			{
				table_round_id = data.round_no;
				joined_table= data.is_joined_table;
				
				if(($("#top_player_name").text())==data.dealer)
					{$("#top_player_dealer").show();}
					else if(($("#bottom_player_name").text())==data.dealer)
					{$("#bottom_player_dealer").show(); }
				
				$("#open_deck").show();
				 
				if(data.is_grouped == false)
				{
					user_assigned_cards.push.apply(user_assigned_cards, data.assigned_cards); 
					////// assign 13 cards to both players 
					$('#images_parent').append( $('#images') );
					show_player_hand_cards(data.assigned_cards,data.sidejokername);
				}
				else if(data.is_grouped == true)				
				{ is_grouped = true; is_sort=false; }
					
					$("#open_card").show();
					$("#closed_cards").show();
					$("#joker_card").show();
					$("#papplu_joker").show();
					$("#papplu_joker").attr('src', data.papplujoker); 
					$("#lablepapplu").show();
						
						
					$("#closed_cards").attr('src', "c3.jpg");  
					$("#joker_card").attr('src', data.sidejoker);  
				
					var temp = [];
					temp.push(data.open_data);
					console.log("OPEN DATA recvd  "+JSON.stringify(temp));
						
						
				  if(data.open_length == 1)
				  {
					//initial_open_card = temp;
					initial_open_card = data.open_data;
					open_data = '';
				  }
				  else
				  {
					open_data = data.open_data;
					//open_data = temp;
				  } 
				  console.log("\n %%%%%%%%%% open data path "+data.opencard+" id "+data.opencard_id+" obj "+JSON.stringify(data.open_data));
				  
				  if(data.is_finish == true)				
					{ 
						is_finished = true; 
						$("#finish_card").show();
						$("#finish_card").attr('src', data.finish_obj.card_path); 
						$("#player1turn").hide();
						$("#player2turn").hide();
						
						$("#declare").show();
						$("#msg").empty();
						$("#msg").css('display', "inline-block"); 
						$("#msg").html("Group your cards and Declare...!");
					}
					if(data.open_data.length>0)
					{
						$("#open_card").attr('src', data.open_data[0].card_path);  
						//open_card_id=data.open_data[0].id;
					}
					else
					{
						$("#open_card").attr('src', "closedimg.bmp");  
					}
					if(data.close_cards.length>0)
					{
						temp_closed_cards_arr1[0]=data.close_cards[0];
						closed_card_src_temp = data.close_cards[0].card_path;
						closed_card_id_temp = data.close_cards[0].id;
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
			
			function show_player_hand_cards(_cards,sidejokername)
			{
				console.log(" @@@@@@@@@ show_player_hand_cards @@@@@@@@@@@ ");
				console.log("\n -- "+JSON.stringify(_cards));
				var user_hand_arr = [];			 
				user_hand_arr.push.apply(user_hand_arr,_cards);
				$("#images").empty();
				//audio_shuffle  = new Audio('sounds/SHUFFLE.wav');
				//audio_shuffle.play();
			
				/* audio_open.pause();
				audio_open.currentTime = 0;
				
				audio_close.pause();
				audio_close.currentTime = 0; */
				for(var i=0;i<user_hand_arr.length;i++)
				{
					if(user_hand_arr[i].name==sidejokername)
					$("#"+user_hand_arr[i].id).css('border', "solid 1px blue"); 
				}				
				$.each(user_hand_arr, function(k, v) 
				{
					//audio.load();
					
					if(k==0)
					{
						$("#images").append("<div><img  width='10%' height='10%' id="+v.id+" src="+v.card_path+"></div>");
						//if(v.name==sidejokername)
						// $("#images").append("<img  id='joker' class='jokerimg' src='joker.png'>");
						//$("#"+v.id).css('border', "solid 2px red"); 
					}
					else 
					{
						$("#images").append("<div><img height='10%' width='10%' id="+v.id+"  src="+v.card_path+"></div>");
						//if(v.name==sidejokername)
						// $("#images").append("<img id='joker' class='jokerimg' src='joker.png'>");
						//$("#"+v.id).css('border', "solid 2px red"); 
					}
					$("#sort_cards").show();
					//$("#drop_game").show();
					
					$("#"+v.id).click(function() 
					{
						if(($.inArray(v.id,card_click))>-1)
						{ 
							/*if(v.name==sidejokername)
							$("#"+v.id).css('border', "solid 2px red"); 
							if(v.name!=sidejokername)*/
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

						if(selected_card_count > 1)
						{$("#group_cards").show();console.log("can do group");}
						else {$("#group_cards").hide();console.log("u can not group");}
							if($.trim($("#images").html())!='')
							{ 
							 card_count = $("#images").children().length;														
							}
							if(card_count==14  && player_turn==true && selected_card_count ==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else
							{
								 console.log('card_count'+card_count);
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
							}


						$("#discard_card").unbind().on('click',function()
						{
							//audio_discard  = new Audio('sounds/CardPick-Discard.wav');
							audio_discard.play();
							player_turn = false; //ANDY
							/* 
							audio_shuffle.pause();
							audio_shuffle.currentTime = 0; */
							$('#discard_card').attr("disabled", 'disabled');
							$('#finish_game').attr("disabled", 'disabled');
							$('#drop_game').attr("disabled", 'disabled');
							
							$("#discard_card").hide();
							$("#finish_game").hide();
							$("#drop_game").hide();
							$("#popup-confirm").hide();

							if(clicked_key!=prev_discard_key)
							{
								var src = $("#"+clicked_key).attr("src");
								console.log("discard CARD clicked_key "+clicked_key+" src "+src);
								/* discard("#",src,clicked_key,"#images",
								hand_cards[k]); */
								var open_objj;
								for(var  i = 0; i < user_hand_arr.length; i++){	
									if(user_hand_arr[i].id == clicked_key){
											open_objj = user_hand_arr[i];
											break;
										}
									}
								console.log("discard CARD ----clicked_key "+clicked_key+" open obj "+JSON.stringify(open_objj));
								//discard("#",src,clicked_key,"#images", user_hand_arr[clicked_key],clicked_key,open_objj);
								discard("#",src,clicked_key,"#images", open_objj,clicked_key,open_objj);
								//hand_cards[clicked_key],hand_cards[k]);
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
					});
				});

				
			}///show_player_hand_cards ends 
										
			/// function for alternate turns once turn end of a player
			/////show turn timer to other player on first ends 
			socket.on("timer", function(data) 
			{
			   if($("#open_card").attr('src') != ''){
				$("#open_card").show();
			  }
			  if(data.papplu_joker_card !=''){
					$("#lablepapplu").show();
					$("#papplu_joker").show();
					$("#papplu_joker").attr('src', data.papplu_joker_card);  
			  }else{
				  $("#lablepapplu").hide();
					$("#papplu_joker").hide();
					$("#papplu_joker").attr('src', '');
			  }
			     console.log("Tmer enter"+game_type);
			     console.log("========player_start_play================"+data.player_start_play);
			     console.log("========player_play_btn================"+data.player_play_btn);
			     console.log("========player_drop_btn================"+data.player_drop_btn);
			     console.log("========player_turn_only_first================"+data.player_turn_only_first);
			   
				if(!(navigator.onLine))
				{
				//	alert("Connection Failed,Please Check your Internet connection..!");
				}
			//console.log(" pl table "+tableid+" with pl round id "+table_round_id);
			//console.log("\n Received timer for table "+data.group_id+" with round id "+data.round_id);
			  if(tableid==data.group_id)///check for same table
			    { 
			    if(table_round_id == data.round_id)///check for same table-round id
			    {
				//console.log("table and round id same ");
				  if($.trim($("#images").html())!='')
					{ 
						card_count = $("#images").children().length;
						card_count =card_count - no_of_jokers;		
					}
					else
					{
						card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
						card_count =card_count - no_of_jokers;		
					}
						
						game_count = data.game_timer;
						extra_count = data.extra_time;
						 playerstartplay=data.player_start_play;
									if(data.myturn) 
									{
									  console.log("========I Am in my turn===============");
									player_having_turn  = data.turn_of_user;
									 if(data.turn_of_user == ($("#top_player_name").text()))
									{
										player_turn = true;
										
										if(card_count == 13 && game_type!='Deal Rummy')
										{
										   console.log("========I Am in not equal to deal ruummy===============");
										     
												     

														  

														   if(data.player_turn_only_first == false){
															  console.log("========I Am in Show Play Button================"+data.player_turn_only_first);


																if(data.player_start_play == true) {
																	$("#drop_game").hide();
																	$("#play_game").hide();
																	$('#play_game').attr("disabled", 'disabled');
																} else{
																	$("#drop_game").show();
																	$("#play_game").show();
																}


															}else{

                                                             console.log("========I Am in turn true===============");
																$("#drop_game").hide();
																$("#play_game").hide();
																$('#play_game').attr("disabled", 'disabled');
															}
												
										}else{ 
										$("#play_game").hide();
			                             $('#play_game').attr("disabled", 'disabled');
										   $("#drop_game").hide();
										   $('#drop_game').attr("disabled", 'disabled');
											
										}
										
											if( game_count >= 1 ) {
												$("#player1turn").text(game_count);
											} else {
												$("#player1turn").text("Ex: " + extra_count);
											}
										
										
											$("#player1turn").show();
											$("#top_player_count1").show();

											if(is_finished == true || is_other_declared == true)
											{ $("#drop_game").hide();
											$('#drop_game').attr("disabled", 'disabled');}
											
											if(game_count < 5)
											{ audio_player_turn_ending.play();}
											
											if(data.is_discard == true || data.is_declared == true || data.is_dropped == true)
											{ game_count = 1; extra_count = 1;} 
										
											if (game_count == 2) {
												if(is_finished == true || is_other_declared == true)
													{
														//check_if_not_declared();
													}
											}
										
										if (game_count <= 1 && extra_count <= 1) 
										{
											audio_player_turn_end.play();
											//check_if_not_discarded(picked_card_value,discard_click,	is_open_close_picked,remove_obj,picked_card_id);
											is_open_close_picked = 0;
											$('#drop_game').attr("disabled", 'disabled');
											$("#drop_game").hide();
											ttt = false ;
											hide_all_add_here_buttons();
											selected_card_arr = [];
											selected_group_card_arr = [];
											
											data.is_discard = false;
											player_turn = false;
											//is_finished = false;
											is_other_declared = false;
											is_picked_card = false;

											$("#discard_card").hide();
											$('#finish_game').attr("disabled", 'disabled');
											$("#finish_game").hide();
											$("#player1turn").text('');
											$("#player1turn").hide();
											$("#top_player_count1").hide();	
											
											$("#popup-confirm").hide();
										}
									  }///if-turn-inner if
									  else 
									   {
									        console.log(" turn is true and at bottom pl ");
										    player_turn = true;
										
											if(card_count == 13 && game_type!='Deal Rummy')
											{
											  console.log("========I Am in not equal to deal ruummy===============");
										       
												     console.log("========I Am in papplu ruummy===============");

														   playerstartplay=data.player_start_play;

														   if(data.player_turn_only_first == false){
															  console.log("========I Am in Show Play Button================"+data.player_turn_only_first);


																if(data.player_start_play == true) {
																	$("#drop_game").hide();
																	$("#play_game").hide();
																	$('#play_game').attr("disabled", 'disabled');
																} else{
																	$("#drop_game").show();
																	$("#play_game").show();
																}


															}else{

                                                             console.log("========I Am in turn true===============");
																$("#drop_game").hide();
																$("#play_game").hide();
																$('#play_game').attr("disabled", 'disabled');
															}
												
											}
											else
											{ 
											   $("#play_game").hide();
			                                   $('#play_game').attr("disabled", 'disabled');
												$('#drop_game').attr("disabled", 'disabled');
												$("#drop_game").hide(); 
											}
										
											if( game_count >= 1 ) {
												$("#player2turn").text(game_count);
											} else {
												$("#player2turn").text("Ex: " + extra_count);
											}
											
											$("#player2turn").show();
											$("#bottom_player_count1").show();
										
											if(is_finished == true || is_other_declared == true)
											{ 
											  $('#drop_game').attr("disabled", 'disabled'); 
											  $("#drop_game").hide();
											}
											
										    if(game_count < 5)
											{ audio_player_turn_ending.play();}
											
											if(data.is_discard == true || data.is_declared == true || data.is_dropped == true)
											{ game_count = 1; extra_count = 1;}
										
										    if (game_count == 2) {
										if(is_finished == true || is_other_declared == true)
											{
												//check_if_not_declared();
											}}
											if (game_count <= 1 && extra_count <= 1) 
											{
											audio_player_turn_end.play();
											//check_if_not_discarded(picked_card_value,discard_click,	is_open_close_picked,remove_obj,picked_card_id);
											is_open_close_picked = 0;
											$('#drop_game').attr("disabled", 'disabled');
											$("#drop_game").hide();
											ttt = false ;
											hide_all_add_here_buttons();
											selected_card_arr = [];
											selected_group_card_arr = [];
											
											data.is_discard = false;
											player_turn = false;
											//is_finished = false;
											is_other_declared = false;
											is_picked_card = false;

											$('#discard_card').attr("disabled", 'disabled');
											$("#discard_card").hide();
											$('#finish_game').attr("disabled", 'disabled');
											$("#finish_game").hide();
											$("#player2turn").text('');
											$("#player2turn").hide();
											$("#bottom_player_count1").hide();			

											$("#popup-confirm").hide();								
										 }
										}///if-turn-inner else
									}////outer if player turn ends
									else
									{ 
										player_turn = false;
										$('#drop_game').attr("disabled", 'disabled');
										$("#drop_game").hide();
										$("#play_game").hide();
		                                $('#play_game').attr("disabled", 'disabled');
									  if(data.turn_of_user == ($("#top_player_name").text()))
									  {
												console.log(" turn is false and at top pl ");
												if( game_count >= 1 ) {
													$("#player2turn").text(game_count);
												} else {
													$("#player2turn").text("Ex: " + extra_count);
												}
												$("#player2turn").show();
												$("#bottom_player_count1").show();
										
												if(game_count < 5)
												{ audio_player_turn_ending.play();}
											
												if(data.is_discard == true || data.is_declared == true  || data.is_dropped == true)
												{ game_count = 1; extra_count = 1;} 
										
										       if (game_count <= 1 && extra_count <= 1) 
										       {
												 audio_player_turn_end.play();
												 data.is_discard = false;
												 $("#player2turn").text('');
												 $("#player2turn").hide();
												 $("#bottom_player_count1").hide();
												}
										}///if-no-turn-inner if
									  else 
									   {
												if( game_count >= 1 ) {
													$("#player1turn").text(game_count);
												} else {
													$("#player1turn").text("Ex: " + extra_count);
												}
												
										        $("#player1turn").show();
										        $("#top_player_count1").show();
										
												if(game_count < 5)
												{ audio_player_turn_ending.play();}
											
												 if(data.is_discard == true || data.is_declared == true  || data.is_dropped == true)
												 { game_count = 1; extra_count = 1;}
										 
												 if (game_count <= 1 && extra_count <= 1) 
													{
														  audio_player_turn_end.play();
														  data.is_discard = false;
														  $("#player1turn").text('');
														  $("#player1turn").hide();
														  $("#top_player_count1").hide();
													}
									    }///if-no-turn-inner else 
									}////outer else player no turn ends
					}//check is same table-round id
				
				     
				}//check is same table
				
			});///timer_ends
		    
			///select open/close card to continue game 
			socket.on("open_close_click_count", function(data) 
			{	
			  if(tableid==data.group)///check for same table
			  {
			   if(table_round_id == data.round_id)///check for same table-round id
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

				  //if(data.user==loggeduser)
				  //{
					ttt = data.check ;
					if(card_type=='open')
					{
					//console.log("card is open");
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
						
						//if(((data.open_arr).toString())!='')
						if(((data.open_arr).length)!=0)
						{
							discarded_open_arr = [];
							discarded_open_arr.push.apply(discarded_open_arr,data.open_arr);
							//open_card_src_temp = data.open_arr[0].card_path;
							//open_card_id_temp = data.open_arr[0].id;
						}
						console.log("Open Card Array "+discarded_open_arr.length+"--"+JSON.stringify(discarded_open_arr));
						
						if((discarded_open_arr.length)==0)
						{
							$("#open_card").attr('src', "closedimg.bmp");  
						}
						else
						{
							//$("#open_card").attr('src', discarded_open_arr[0].path);  
							$("#open_card").attr('src', discarded_open_arr[(discarded_open_arr.length)-1].card_path);
								/* $("#discareded_open_cards").empty();							
								$.each(discarded_open_arr, function(k, v) 
										{
											$("#discareded_open_cards").append("<img width='10%' height='10%' id="+v.id+" src="+v.card_path+">");
										}); */
							
						}
					}
						else if(card_type=='close')
						{
							src=data.path;
							open_card_src =$("#open_card").attr("src");
							picked_card_value = src;
							next_key = close_card_id;
							//picked_card_id = close_card_id;
							picked_card_id = data.card_data.id;
							is_open_close_picked = 1;
							/* obj = (data.card_data).reduce(function(acc, cur, i) {
							if(i=0)
								{acc[i] = cur;}
							return acc;
							});
							remove_obj = obj; */
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
						
						//console.log("open/close selected before "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						
						user_assigned_cards = [];
						 if(data.hand_cards.length<=14)
						user_assigned_cards.push.apply(user_assigned_cards,data.hand_cards);
						//console.log("open/close selected AFTER "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						
						if(appended_key!=0)
						{
						////showing updated hand cards(14) after open/close select-initial
						  if(data.hand_cards.length<=14)
						 show_player_hand_cards(data.hand_cards,data.sidejokername);
						}
						else
						{console.log("Update groups");}
					}
				}
				else
				{
					alert("You have already picked card from either Close / Open Card ");
				}
			   }
			  
			});///open/close card click 
			
			///if selected open/close card ,discard card 
			function discard(clicked_card_id,clicked_card_src,key,parent,cardvalue,card_id,open_obj)//,checkvalue
				 {
				 console.log("\nANDYANDYANDY cardvalue"+JSON.stringify(cardvalue));
				//c.push(cardvalue);
				 var c = [];
				 c.push(open_obj);
				 //open_data  = c;
				  console.log("open card data @ discard ---------"+JSON.stringify(open_data)); 
				  
					selected_card_arr = jQuery.grep(selected_card_arr, function(value) {
					return value != cardvalue;});
					selected_card_arr1 = jQuery.grep(selected_card_arr1, function(value) {
					return value != key;});
					is_open_close_picked = 0;
					
					/* var obj = c.reduce(function(acc, cur, i) {
						if(i=0)
							{acc[i] = cur;}
						return acc;
						});
					var removeItem = obj;
					console.log("user hand cards before discard"+JSON.stringify(user_assigned_cards));
					user_assigned_cards = jQuery.grep(user_assigned_cards, function(value) {
					return value != removeItem;
					});
					console.log("user hand cards AFTER discard"+JSON.stringify(user_assigned_cards)); */
					var selected_card_arr11 = []; 
					$('#discard_card').attr("disabled", 'disabled');
				 	$("#discard_card").hide();
					$('#finish_game').attr("disabled", 'disabled');
					$("#finish_game").hide();
					discard_click  = true ;
					next_turn = true;
					console.log("open card id and path before discard"+open_card_id+"---"+$("#open_card").attr("src"));
					$("#open_card").attr('src', clicked_card_src);  
					open_card_id = key;
					console.log("open card id and path AFTER discard"+open_card_id+"---"+$("#open_card").attr("src"));
					
					/* selected_card_arr11.push(key);
					$.each(selected_card_arr11, function(n, m) 
					{
					 var image = $(parent).children(clicked_card_id+m);
					 image.remove();
					}); */
					ttt = false;
					selected_card_arr = [];
					selected_group_card_arr = [];
					
					socket.emit("discard_fired",{discarded_user:loggeduser,group:tableid,round_id:table_round_id});
					console.log("discard clicked by "+loggeduser);
					 socket.emit("show_open_card",{user: loggeduser,group:tableid,open_card_src:clicked_card_src,check:ttt,round_id:table_round_id,open_card_id:open_card_id,discard_card_data:card_id,discarded_open_data:open_data,is_sort:is_sorted,is_group:is_grouped,group_from_discarded:0,is_initial_group:initial_group});
				}//discard ends 
				
				/////after discard , show open card to other player
				function drop(event) {
					event.preventDefault();
					var data = event.dataTransfer.getData("Text");
					event.target.appendChild(document.getElementById(data));
					document.getElementById("demo").innerHTML = "The p element was dropped";
				}
				socket.on("open_card", function(data) 
				{
					console.log("discard_open_cards "+JSON.stringify(data.discard_open_cards));
				  if(tableid==data.group)///check for same table
				  {
					if(table_round_id == data.round_id)///check for same table-round id
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
						//open_arr_temp.push(temp);
						//console.log("OPEN DATA recvd after OPP PL discard "+open_data);
						discard_click  = false ;
						
						$("#discareded_open_cards").empty();		
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
				
				
				/////after open selected - if it is joker card then message select close card
				socket.on("pick_close_card", function(data) 
				{
				if(data.user==loggeduser)
				  {
					if(tableid==data.group)///check for same table
					{
						if(table_round_id == data.round_id)///check for same table-round id
						{
						////show this message by using tooltip ////
						is_picked_card = false;
						 alert("You are trying to select Joker Card, Select Card From Closed Cards.");
						}
					}
				  }
				});
				
				
				/////after open selected - if it is joker card then message select close card
				socket.on("disallow_pick_card", function(data) 
				{
				if(data.user==loggeduser)
				  {
					if(tableid==data.group)///check for same table
					{
						if(table_round_id == data.round_id)///check for same table-round id
						{
							alert("You can pick only 1 card at a time from open/close cards!");
						}
					}
				  }
				});
				
				/////after discard/return ,update hand cards of player
				socket.on("update_hand_cards", function(data) 
				{
				console.log("UPDATING HAND CARDS AFTER DISCARD/RETURN");
				  if(data.user==loggeduser)
				  {
					if(tableid==data.group)
					{
					  if(table_round_id == data.round_id)
					  {
						console.log("before discard/return HAND CARDS: "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						user_assigned_cards = [];
						user_assigned_cards.push.apply(user_assigned_cards,data.hand_cards);
						console.log("\n AFTER discard/return HAND CARDS:  "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						///if initial images -no sort/group done
						//if((($("#images").children().length)) != 0)
						//{ show_player_hand_cards(user_assigned_cards); } 
						//show_player_hand_cards(user_assigned_cards); 
						show_player_hand_cards(data.hand_cards,data.sidejokername); 
					  }
					}
				  }
				});
				
				////return picked card to open if no discard within timer 
				 function check_if_not_discarded(p_value,is_discard,is_open_close_picked,obj,card_id)
				 {
					if(ttt == true)
					{
						is_open_close_picked = 0;
						$('#drop_game').attr("disabled", 'disabled');
						$("#drop_game").hide();
						//show back to open
						if(is_discard==false && is_finished == false)
						{
						 console.log("is_discard  "+is_discard+" is_finished "+is_finished);
							$("#open_card").attr('src', p_value);  
							var div_id = $('#images_parent').find('img[id="'+card_id+'"]').closest('div').attr('id');
							var img_id = $('#images_parent').find('img[id="'+card_id+'"]').attr('id');
							console.log(" div_id after sort from remove "+ div_id);
							//var image = $("#"+div_id).children("#"+img_id);
							//image.remove();
							 var c = [];
							c.push(obj);
							ttt = false ;
							/* var removeItem = obj;
							user_assigned_cards = jQuery.grep(user_assigned_cards, function(value) {
							return value != removeItem; 
							$("#discard_card").hide();
							$("#finish_game").hide();
						});*/
							$('#discard_card').attr("disabled", 'disabled');
							$("#discard_card").hide();
							$('#finish_game').attr("disabled", 'disabled');
							$("#finish_game").hide();
							hide_all_add_here_buttons();
								
							var grp_discard_no;
							if(is_sorted == false && is_grouped == false && initial_group == false)
							{ grp_discard_no = 0; }
							else 
							{ 
								//grp_discard_no = 4; 
							  if(div_id == 'list1')
								grp_discard_no = 1; 
							  if(div_id == 'list2')
								grp_discard_no = 2; 
							  if(div_id == 'list3')
								grp_discard_no = 3; 
							  if(div_id == 'list4')
								grp_discard_no = 4; 
							  if(div_id == 'list5')
								grp_discard_no = 5; 
							  if(div_id == 'list6')
								grp_discard_no = 6; 
							  if(div_id == 'list7')
								grp_discard_no = 7; 
							}
							selected_card_arr = [];
							selected_group_card_arr = [];
						socket.emit("show_open_card",{user: loggeduser,group:tableid,open_card_src:p_value,check:ttt,round_id:table_round_id,open_card_id:card_id,discard_card_data:card_id,discarded_open_data:c,is_sort:is_sorted,is_group:is_grouped,group_from_discarded:grp_discard_no,is_initial_group:initial_group});
						}
					 }
				}///check_if_not_discarded ends 
				
				$("#confirm-no").click(function() {
					$("#popup-confirm").hide();
				});
			
			   $("#drop_game").click(function()
			   {
			   	$("#confirm-msg").html("Are you sure to drop?");
				$("#popup-confirm").show();

				$("#confirm-yes").unbind().click(function() {
					$("#popup-confirm").hide();
				     if(player_turn==true)
					 {
						$('#drop_game').attr("disabled", 'disabled');
						$("#drop_game").hide();
						is_game_dropped = true;
						console.log(" Game Dropped by player "+loggeduser);
											
							socket.emit("drop_game",{user_who_dropped_game: loggeduser,group:tableid,round_id:table_round_id,/*amount:player_amount,*/is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,game_type:game_type});					
					  }
				});
				  
			   });			  
			   
			////// Sorting according to card-suit on sort_card button click
			$("#sort_cards").click(function()
			  {
				$("#sort_cards").hide();
				is_sorted = true;// to know sorting has done
			    var temp = []; 
				var temp_group1 = [],temp_group2 = [],temp_group3 = [],temp_group4 = [];
				if(user_assigned_cards.length == 13 || user_assigned_cards.length == 14)
				{
					temp.push.apply(temp,user_assigned_cards);
				}
				if(temp.length >0)	{
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
				// console.log("sort send group " + tableid);
				socket.emit("update_player_groups_sort",{player:loggeduser,group:tableid,round_id:table_round_id,group1:temp_group1,group2:temp_group2,group3:temp_group3,group4:temp_group4,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,parent_group:grp2});
				
				}
			});////sort_cards() ends 
			
			/* show player hand card groups after sort */
			socket.on("update_player_groups_sort", function(data) 
			{
				show_player_hand_cards_after_sort(data.user,data.group,data.round_id,data.grp1_cards,data.grp2_cards,data.grp3_cards,data.grp4_cards,data.grp5_cards,data.grp6_cards,data.grp7_cards,data.sidejokername);
			});
			
			 var add_card_obj;// = [];
			function show_player_hand_cards_after_sort(user,group,round_id,grp1_cards,grp2_cards,grp3_cards,grp4_cards,grp5_cards,grp6_cards,grp7_cards,sidejokername)
			{
				var src ;
				var card_count=0;
				var clicked_card_count=0;			
			    var discard_obj = [];				    
				var card_click = [] ; var clicked_key;
				var card_click_grp = [] ; var clicked_key_grp;			
			  console.log("Showing player card groups after sort");
			  console.log("\n grp1_cards "+grp1_cards.length);
				  sort_grp1 = [];
				  sort_grp2 = [];
				  sort_grp3 = [];
				  sort_grp4 = [];
				  sort_grp5 = [];
				  sort_grp6 = [];
				  sort_grp7 = [];
			  
				$("#list1").empty();
				$("#list2").empty();
				$("#list3").empty();
				$("#list4").empty();
				$("#list5").empty();
				$("#list6").empty();
				$("#list7").empty();
				$("#images").empty();
				
				//console.log("\n user "+ user + "  " + loggeduser);
				console.log("\n group "+ tableid + "  " + group);
				//console.log("\n round "+ table_round_id + "  " + round_id);
			  if(user==loggeduser)
			  {
				if(tableid==group)
				{
				 if(table_round_id == round_id)
				  {

				  	//$("#discard_card").click(function()
					$("#discard_card").unbind().on('click',function()
					{
						audio_discard.play();
						player_turn = false; //ANDY

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
						//src=$("#"+obj.v.id).attr("src");
						src=$("#"+clicked_key).attr("src");
						$("#open_card").attr('src', src);  
						/* selected_card_arr1.push(obj.v.id);
						$.each(selected_card_arr1, function(n, m) 
						{
						   var image = $("#card_group1").children("#"+m);
							image.remove();
						}); */
						ttt = false;
						
						socket.emit("discard_fired",{discarded_user:loggeduser,group:tableid,round_id:table_round_id});
						
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

						for(var  i = 0; i < sort_grp_temp.length; i++)
						{
							if(sort_grp_temp[i].id == clicked_key)
							{
								open_obj = sort_grp_temp[i];
								break;
							}
						}
						discard_obj.push(open_obj);
						//add_card_obj.push(open_obj);
						//add_card_obj=open_obj;

						card_click = [];
						card_click_grp = [];
						clicked_card_count = 0;

						socket.emit("show_open_card",{user: loggeduser,group:tableid,open_card_src:src,check:ttt,round_id:table_round_id,open_card_id:open_card_id,discard_card_data:open_card_id,discarded_open_data:discard_obj,is_sort:is_sorted,is_group:is_grouped,group_from_discarded:clicked_key_grp,is_initial_group:initial_group});
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
						console.log("finish clicked grp" + clicked_key_grp + " " +JSON.stringify(finish_card_obj)+"----"+clicked_key);
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
							$("#list1").append("<div><img id='"+obj.id+"'src="+obj.card_path+"></div>");
							//add_here(1);
							//$("#card_group1").append("<div><img id='"+obj.id+"' src="+obj.card_path+"  ></div>");
							//if(obj.name==sidejokername)
							//$("#card_group1").append("<img  class='jokerimg' src='joker.png'>");
						}else
						{
							//$("#card_group1").append("<div><img id='"+obj.id+"' src="+obj.card_path+"  ></div>");
							$("#list1").append("<div><img id='"+obj.id+"'src="+obj.card_path+"></div>");
							//add_here(btn_id);
							//if(obj.name==sidejokername)
							//$("#card_group1").append("<img  class='jokerimg' src='joker.png'>");
						}
					  $("#"+obj.id).click(function() 
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
							card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
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
								if(($("#list2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#list3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#list4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#list5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#list6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#list7").children().length) != 0)
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
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
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
							$("#list2").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#card_group2").append("<img  class='jokerimg' src='joker.png'>");
						}else
						{
							$("#list2").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#card_group2").append("<img  class='jokerimg' src='joker.png'>");
						}
					$("#list2").css('margin-left', "1%"); 
					
					$("#"+obj.id).click(function() 
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

								if( clicked_card_count == 1 ) {
									clicked_key = card_click[0];
									clicked_key_grp = card_click_grp[0];
								}

							card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
							////ADD HERE 2
							if(clicked_card_count==1)
							{
								//parent_group_id =("card_group2");
								parent_group_id =2;
								selected_card_id = clicked_key;
								//console.log("clicked_card_count "+clicked_card_count+" selected_card_id "+selected_card_id);
								for(var  i = 0; i < sort_grp2.length; i++)
								{
									if(sort_grp2[i].id == selected_card_id)
									{
										open_obj = sort_grp2[i];
										break;
									}
								}
								//console.log("\n open_obj "+open_obj);
								add_card_obj=open_obj;
								//console.log("\n add_card_obj "+add_card_obj);
								if(($("#list1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#list3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#list4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#list5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#list6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#list7").children().length) != 0)
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
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
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
							$("#list3").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#list3").append("<img class='jokerimg' src='joker.png'>");
						}else
						{
							$("#list3").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#list3").append("<img  class='jokerimg' src='joker.png'>");
						}
					$("#list3").css('margin-left', "1%"); 
					$("#"+obj.id).click(function() 
						{
							card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
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
								//parent_group_id =("list3");
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
								if(($("#list1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#list2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#list4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#list5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#list6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#list7").children().length) != 0)
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
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
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
							$("#list4").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							//$("#list4").append("<img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list4").append("<img  class='jokerimg' src='joker.png'>");
						}else
						{
							$("#list4").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							//$("#list4").append("<img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list4").append("<img  class='jokerimg' src='joker.png'>");
						}
					$("#list4").css('margin-left', "1%");
					$("#"+obj.id).click(function() 
						{
						
						card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
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
									card_click_grp.push(4);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,4);  
								}
								////ADD HERE 4
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								//parent_group_id =("list4");
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
								if(($("#list1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#list2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#list3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#list5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#list6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#list7").children().length) != 0)
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
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
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
							$("#list5").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							//$("#list5").append("<img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list5").append("<img class='jokerimg' src='joker.png'>");
						}else
						{
							$("#list5").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							//$("#list5").append("<img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list5").append("<img class='jokerimg' src='joker.png'>");
						}
					$("#list5").css('margin-left', "1%");
					$("#"+obj.id).click(function() 
						{
						
						card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
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
									card_click_grp.push(5);
									$("#"+obj.id).css('border', "solid 1px blue"); 
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
								if(($("#list1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#list2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#list3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#list4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#list6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#list7").children().length) != 0)
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
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
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
							$("#list6").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							flag=6;
							//$("#list6").append("<img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list6").append("<img  class='jokerimg' src='joker.png'>");
						}else
						{
							$("#list6").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							flag=6;
							//$("#list6").append("<img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list6").append("<img class='jokerimg' src='joker.png'>");
						}
					$("#list6").css('margin-left', "1%");
					$("#"+obj.id).click(function() 
						{
						
						card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
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
								if(($("#list1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#list2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#list3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#list4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#list5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#list7").children().length) != 0)
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
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
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
							flag=7;
							$("#list7").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							//$("#list7").append("<img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list7").append("<img class='jokerimg'  src='joker.png'>");
						}else
						{
							$("#list7").append("<div><img id='"+obj.id+"'  width='8%' height='9%'  src="+obj.card_path+"></div>");
							flag=7;
							//$("#list7").append("<img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+">");
							//if(obj.name==sidejokername)
							//$("#list7").append("<img class='jokerimg' src='joker.png'>");
						}
					$("#list7").css('margin-left', "1%");
					$("#"+obj.id).click(function() 
						{
						   card_count= ($("#list1").children().length)+($("#list2").children().length)+($("#list3").children().length)+($("#list4").children().length)+($("#list5").children().length)+($("#list6").children().length)+($("#list7").children().length);
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
								if(($("#list1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#list2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#list3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#list4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#list5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#list6").children().length) != 0)
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
								$('#discard_card').attr("disabled", 'disabled');
								$("#discard_card").hide();
								$('#finish_game').attr("disabled", 'disabled');
								$("#finish_game").hide();
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
			if(flag==6)
				add_here(6);
			else if(flag==7)
				add_here(7);
			 function add_here(btn_id)
			{
				//alert(1);
				socket.emit("add_here",{player:loggeduser,group:tableid,round_id:table_round_id,selected_card:selected_card_id,selected_card_src:add_card_obj,add_to_group:btn_id,remove_from_group:parent_group_id});
				add_card_obj = "";
				console.log('1');
					
				$('#discard_card').attr("disabled", 'disabled');
				$("#discard_card").hide();
				$('#finish_game').attr("disabled", 'disabled');
				$("#finish_game").hide();

				setTimeout(()=>{	
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
				}, 20);
			}//add_here ends 

 function add_here_drop(btn_id,posi)
			{
				//alert(posi);
				socket.emit("add_here_drop",{player:loggeduser,group:tableid,round_id:table_round_id,selected_card:selected_card_id,selected_card_src:add_card_obj,add_to_group:btn_id,remove_from_group:parent_group_id,position:posi});
				add_card_obj = "";
				console.log('1');
					
				$('#discard_card').attr("disabled", 'disabled');
				$("#discard_card").hide();
				$('#finish_game').attr("disabled", 'disabled');
				$("#finish_game").hide();

				setTimeout(()=>{	
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
				}, 20);
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
				console.log("\n ****** selected_group_card_arr after group of group "+JSON.stringify(selected_group_card_arr));
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
				
				if( is_grouped == true)
				{
					grp2 = [];
					$.each(selected_group_card_arr, function(n, m) 
					{grp2.push(m);});
					console.log("GRP after group of group "+JSON.stringify(grp2));
				}
				
				/// emit player groups after group to server///
				socket.emit("update_player_groups_sort",{player:loggeduser,group:tableid,round_id:table_round_id,card_group:grp1,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,parent_group:grp2});
				
				selected_card_arr = [];
				selected_group_card_arr = [];
					
			});//group_card click ends 
			
			
			socket.on("group_limit", function(data) 
			{
			 if(data.user==loggeduser)
			  {
				if(tableid==data.group)
				{
				 if(table_round_id == data.round_id)
				  {
					alert("You can make only 7 groups");
				  }
				}
			  }	
			});
			/* ------------   GROUP OF CARDS  End -----------*/
			
			/* ------------ Finish Start   -----------------*/
			function finish(finish_card_obj,key,parent)
				 {
				 	$("#confirm-msg").html("Are you sure to finish?");
					$("#popup-confirm").show();

					$("#confirm-yes").unbind().click(function() {
						$("#popup-confirm").hide();
						$("#finish_card").show(); 
						is_finished = true;
						$('#discard_card').attr("disabled", 'disabled');
						$("#discard_card").hide();
						$('#finish_game').attr("disabled", 'disabled');
						$("#finish_game").hide();
						hide_all_add_here_buttons();
						
						var parent_id = parent;
						console.log("\n &&&&&&& in finish"+JSON.stringify(finish_card_obj)+"-- parent --"+parent+" parent_id "+parent_id);
						
						socket.emit("show_finish_card",{player:loggeduser,group:tableid,round_id:table_round_id,finish_card_id:key,finish_card_obj:finish_card_obj,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,group_from_finished:parent_id,is_finished:is_finished});
						
						$("#top_player_count1").hide();
						$("#top_player_count2").hide();
						$("#bottom_player_count1").hide();
						$("#bottom_player_count2").hide();
						
						$('#declare').attr("disabled", 'disabled');
						$("#declare").show();
						$("#msg").empty();
						$("#msg").css('display', "inline-block"); 
						$("#msg").html("Group your cards and Declare...!");


						is_picked_card = false;
					});
					//$("#declare_div").show();
				}///finish ends 
				
				socket.on("finish_card", function(data) 
				{
				  if(data.user==loggeduser)
			      {
					if(tableid==data.group)
					{
					  if(table_round_id == data.round_id)
					  {
						$("#finish_card").show();
						$("#finish_card").attr('src', data.path); 
						$("#top_player_count1").hide();
						$("#top_player_count2").hide();
						$("#bottom_player_count1").hide();
						$("#bottom_player_count2").hide();
					   }
					}  
				  }
				});
			/* ------------ Finish Start   -----------------*/	
			
			/** ----------- Declare (1 player )Start  ------------------**/
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
						
						socket.emit("declare_game",{user: loggeduser,group:tableid,round_id:table_round_id,amount:player_amount,is_declared:is_declared,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,auto_declare:false,game_type:game_type});
						
						if(declare == 1 )
						{
							declare = 2;
						}
					});
					
				});///declare_click ends
				
				///If finished but not declared after turn ends - auto declare 
				function check_if_not_declared()
				{
					if(is_declared == true)
					{
						console.log("\n After finish player declared game within turn/timer.");
					}
					else
					{
						console.log("\n After finish player NOT declared game within turn/timer.");
						$('#declare').attr("disabled", 'disabled');
						$("#declare").hide();
						$("#msg").hide();
						is_declared = true;
						
						socket.emit("declare_game",{user: loggeduser,group:tableid,round_id:table_round_id,amount:player_amount,is_declared:is_declared,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,auto_declare:true});
						is_declared = false;
						$(".declare-table").show();
						
						if(declare == 1 )
						{
							declare = 2;
						}
					
					}
				}//check_if_not_declared() ends 
				
				socket.on('declared', function(data){
				console.log("\n in ------------- declared  "+data.declared_user);
				 if(data.user==loggeduser)
			      {
					if(tableid==data.group)
					{
					  if(table_round_id == data.round_id)
					  {
					  console.log("\n declared_user is  "+data.declared_user);

						$("#msg").empty();
						$("#msg").css('display', "inline-block"); 
						declare = data.declare;							
						if( data.declared_user != loggeduser)  {
							$("#msg").html("Player "+data.declared_user+" has declared game,group your cards and declare");
							$('#declare').attr("disabled", 'disabled');
							$("#declare").show();
							if(declare == 1 )
							{
								is_other_declared = true;
							}
						} 
					   }
					}  
				  }
				});//declared ends 
				
				socket.on("declared_data", function(data) 
				{
					console.log("\n showing cards of declared player ");
					$(".declare-table").show();
					is_declared = false;
					$("#declare").hide();
					$("#msg").hide();
					$('#game_summary').find('td').remove();
					$('#game_summary tr:gt(3)').remove();

					$("#top_player_count1").hide();
					$("#top_player_count2").hide();
					$("#bottom_player_count1").hide();
					$("#bottom_player_count2").hide();

					if(declare == 1 )
						{
							declare = 2;
						}
						var i=0; var name; var win_ponits , lost_points = 0;
						$("#tr_joker").hide();
						$("#tr_msg").hide();
						for(var k=0; k<2; k++)
						{
							i = i+1;
							if(i==1)
							{
								name = loggeduser;
								/* win_ponits = 100;
								lost_points = 0; */
								win_ponits = '--';
								lost_points = '--';
							}
							else
							{ 
								name = data.opp_user; 
/* 								win_ponits = 0;
								lost_points = -100; */
								win_ponits = '--';
								lost_points = '--';
							}

							if(data.declared==1) 
							{
								$('#game_summary').append('<tr><td style="text-align:center">'+name+'</td><td></td><td id="player'+(i)+'_cards" class="declare-cards"></td><td style="text-align:center">'+win_ponits+'</td><td></td></tr>');
								//$('#player'+(i)+'_cards').insertBefore( "#tr_joker" );
								if(i==1)
								{
								  $('#player'+(i)+'_cards').append('<div id="cards1" class="decl-group1"></div><div id="cards2" class="decl-group2"></div><div id="cards3" class="decl-group3"></div><div id="cards4" class="decl-group4"></div><div id="cards5" class="decl-group5"></div><div id="cards6" class="decl-group6"></div><div id="cards7" class="decl-group7"></div>');
								    
								/* if(is_sorted == false && is_grouped == false && initial_group == false)
								{
									if(data.grp1_cards.length>0)
									{
										$.each(data.grp1_cards, function(n,m){
											if(n=0)
											$('#cards1').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
											else
											$('#cards1').append('<img width="5%" height="5%"  src="' + m.card_path + '" />'); 
										});
									}
								}
								else */
								{
								  if(data.grp1_cards.length>0)
									{
										$.each(data.grp1_cards, function(n,m){
											if(n=0)
											$('#cards1').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
											else
											$('#cards1').append('<img width="5%" height="5%"  src="' + m.card_path + '" />'); 
										});
									}
									if(data.grp2_cards && data.grp2_cards.length>0)
									{
										$.each(data.grp2_cards, function(n,m){
											if(n=0)
											$('#cards2').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
											else
											$('#cards2').append('<img width="5%" height="5%"  src="' + m.card_path + '" />');
										});
									}
									if(data.grp3_cards && data.grp3_cards.length>0)
									{
										$.each(data.grp3_cards, function(n,m){
												if(n=0)
												$('#cards3').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
												else
												$('#cards3').append('<img width="5%" height="5%"  src="' + m.card_path + '" />');
											});
									}
									if(data.grp4_cards && data.grp4_cards.length>0)
									{
										$.each(data.grp4_cards, function(n,m){
											if(n=0)
											$('#cards4').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
											else
											$('#cards4').append('<img width="5%" height="5%"  src="' + m.card_path + '" />');
										});
									}
									if(data.grp5_cards && data.grp5_cards.length>0)
									{
										$.each(data.grp5_cards, function(n,m){
											if(n=0)
											$('#cards5').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
											else
											$('#cards5').append('<img width="5%" height="5%"  src="' + m.card_path + '" />');
										});
									}
									if(data.grp6_cards && data.grp6_cards.length>0)
									{
										$.each(data.grp6_cards, function(n,m){
											if(n=0)
											$('#cards6').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
											else
											$('#cards6').append('<img width="5%" height="5%"  src="' + m.card_path + '" />');
										});
									}
									if(data.grp7_cards && data.grp7_cards.length>0)
									{
										$.each(data.grp7_cards, function(n,m){
											if(n=0)
											$('#cards7').append('<img width="5%" height="5%" src="' + m.card_path + '" />'); 
											else
											$('#cards7').append('<img width="5%" height="5%"  src="' + m.card_path + '" />');
										});
									}
								  }//if groups are done
								}
								else
								{
								$('#player'+(i)+'_cards').append('<img style="margin-left: 35%;height:40%" src="buyin.gif" />');
								}
									
							}
							else if(data.declared==2)
							{
								$('#game_summary').append('<tr><td>'+(i)+'</td><td style="text-align:center">'+name+'</td><td><div id="pl'+(i)+'cards1" class="decl-group1"></div><div id="pl'+(i)+'cards2" class="decl-group1"></div><div id="pl'+(i)+'cards3" class="decl-group1"></div><div id="pl'+(i)+'cards4" class="decl-group1"></div><div id="pl'+(i)+'cards5" class="decl-group1"></div><div id="pl'+(i)+'cards6" class="decl-group1"></div><div id="pl'+(i)+'cards7" class="decl-group1"></div></td><td style="text-align:center">'+win_ponits+'</td></tr>');
								
							}
						}//for
						
						clear_player_data_after_declare();
						
						$("#div_msg").show();
						$('#div_msg').prepend('<label id="lbl_popup" style="color:white">To see Popup details </label><label id="click_here_popup" style="color:blue;text-decoration:underline">Click here</label><br>');
						
						$("#click_here_popup").click(function(){
							$(".declare-table").show();
							});
				});/////after declared (a player)show pop-up 
				
				////after 2nd player declares game 
				socket.on("declared_final", function(data) 
				{
				console.log(" declared_final "+JSON.stringify(data));
				//if(declare == 1 )
						//{
							declare = 2;
						//}
				console.log("\n After 2nd player declared , showing cards of both players ");
					$(".declare-table").show();
					var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
					$('#game_summary').find('td').remove();
					$('#game_summary tr:gt(3)').remove();

					$("#top_player_count1").hide();
					$("#top_player_count2").hide();
					$("#bottom_player_count1").hide();
					$("#bottom_player_count2").hide();

					var restart_timer = 10;
					var i=0; var name; 
					var game_score =0 , amount_won =0;
					var current_player_grouped = data.user_grouped;
					var other_player_grouped = data.other_grouped;
					
						for(var k=0; k<2; k++)
						{
							i = i+1;
							if(i==1)
							{
								name = loggeduser;
								game_score = data.game_score;
								amount_won = data.amount_won;
							}
							else
							{ 
								name = data.opp_user; 
								game_score = data.opp_game_score;
								amount_won = data.opp_amount_won;
							}
							if(data.declared==2)
							{
								$('#game_summary').append('<tr id="tr_cards'+(i)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(i)+'"></td><td class="declare-cards"><div id="pl'+(i)+'cards1" class="decl-group1"></div><div id="pl'+(i)+'cards2" class="decl-group2"></div><div id="pl'+(i)+'cards3" class="decl-group3"></div><div id="pl'+(i)+'cards4" class="decl-group4"></div><div id="pl'+(i)+'cards5" class="decl-group5"></div><div id="pl'+(i)+'cards6" class="decl-group6"></div><div id="pl'+(i)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');
								
								if(i==2)
								{
									$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
									$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Papplu Joker</th><th><img id="papplu_card" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
							var papplu_joker_card_src = $("#papplu_joker").attr("src");
						    $("#papplu_card").attr('src',papplu_joker_card_src); 
									var joker_card_src = $("#joker_card").attr("src");	
									$("#side_joker").attr('src', joker_card_src); 
								}
									if(i==1 && name==data.prev_pl)
									{
										$('#win'+(i)+'').append('<img style="width: 50%" src="winner-rummy.jpg"/>');
										//audio_player_winner.play();
									}
									if(i==2 && name==data.prev_pl)
									{
										$('#win'+(i)+'').append('<img style="width: 50%" src="winner-rummy.jpg"/>');
										//audio_player_winner.play();
									}
									if(loggeduser==data.prev_pl)
									{
										audio_player_winner.play();
										$("#seq").text(" Valid ");
									}
									else {$("#seq").text(" Wrong ");}
								if(i==1)
								{
								  if(current_player_grouped == false)
								   {
										if(data.grp1_cards.length>0)
										{
											$.each(data.grp1_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />');  
											});
										}
								    }
									else
								    {
									   if(data.grp1_cards.length>0)
										{
											$.each(data.grp1_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); 
											});
										}
										if(data.grp2_cards.length>0)
										{
											$.each(data.grp2_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp3_cards.length>0)
										{
											$.each(data.grp3_cards, function(n,m){
													if(n=0)
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />'); 
													else
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />');
												});
										}
										if(data.grp4_cards.length>0)
										{
											$.each(data.grp4_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp5_cards.length>0)
										{
											$.each(data.grp5_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp6_cards.length>0)
										{
											$.each(data.grp6_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp7_cards.length>0)
										{
											$.each(data.grp7_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />');
											});
										}
									  }//grouped
									}
									else
									{
									  if(other_player_grouped == false)
								      {
										if(data.grp1.length>0)
										{
											$.each(data.grp1, function(n,m){
											if(n=0)
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }
											else
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }  
											});
										}
								      }
									  else
								      {
										if(data.grp1.length>0)
										{
											$.each(data.grp1, function(n,m){
											if(n=0)
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }
											else
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }
										});
										}
										if(data.grp2.length>0)
										{
											$.each(data.grp2, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp3.length>0)
										{
											$.each(data.grp3, function(n,m){
													if(n=0)
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />'); 
													else
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />');
												});
										}
										if(data.grp4.length>0)
										{
											$.each(data.grp4, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp5.length>0)
										{
											$.each(data.grp5, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp6.length>0)
										{
											$.each(data.grp6, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp7.length>0)
										{
											$.each(data.grp7, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />');
											});
										}
									  }//grouped
									}//else 
							}
						}
						console.log("2nd declares "+btnclicked+player_amount+player_gender);
						///clear data after game ends 
						clear_player_data_after_declare();
						//btnclicked = 0;
						$('#div_msg').show();
				});///after 2nd player declared game
				
				////after player dropped game 
				socket.on("dropped_game", function(data) 
				{
					hide_all_add_here_buttons();
				    console.log(" dropped_game "+JSON.stringify(data));
				
					is_game_dropped = true;
					$(".declare-table").show();
					var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
					$('#game_summary').find('td').remove();
					$('#game_summary tr:gt(3)').remove();

					$("#top_player_count1").hide();
					$("#top_player_count2").hide();
					$("#bottom_player_count1").hide();
					$("#bottom_player_count2").hide();

					var restart_timer = 10;
					var i=0; var name; 
					var game_score =0 , amount_won =0;
					var current_player_grouped = data.user_grouped;
					var other_player_grouped = data.other_grouped;
					
						for(var k=0; k<2; k++)
						{
							i = i+1;
							if(i==1)
							{
								name = loggeduser;
								game_score = data.game_score;
								amount_won = data.amount_won;
							}
							else
							{ 
								name = data.opp_user; 
								game_score = data.opp_game_score;
								amount_won = data.opp_amount_won;
							}
							
								$('#game_summary').append('<tr id="tr_cards'+(i)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(i)+'"></td><td class="declare-cards"><div id="pl'+(i)+'cards1" class="decl-group1"></div><div id="pl'+(i)+'cards2" class="decl-group2"></div><div id="pl'+(i)+'cards3" class="decl-group3"></div><div id="pl'+(i)+'cards4" class="decl-group4"></div><div id="pl'+(i)+'cards5" class="decl-group5"></div><div id="pl'+(i)+'cards6" class="decl-group6"></div><div id="pl'+(i)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');
								
								if(i==2)
								{
									$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
									$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Papplu Joker</th><th><img id="papplu_card" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
							var papplu_joker_card_src = $("#papplu_joker").attr("src");
						    $("#papplu_card").attr('src',papplu_joker_card_src); 
									var joker_card_src = $("#joker_card").attr("src");	
									$("#side_joker").attr('src', joker_card_src); 
								}
									if(i==1 && name==data.prev_pl)
									{
										$('#win'+(i)+'').append('<img style="width: 50%" src="winner-rummy.jpg"/>');
										
										//audio_player_winner.play();
									}
									if(i==2 && name==data.prev_pl)
									{
										$('#win'+(i)+'').append('<img style="width: 50%" src="winner-rummy.jpg"/>');
										//audio_player_winner.play();
									}
									if(loggeduser==data.prev_pl)
									{
										audio_player_winner.play();
										$("#seq").text(" Valid ");
									}
									else { $("#seq").text(" Wrong "); }
								if(i==1)
								{
								  if(current_player_grouped == false)
								   {
										if(data.grp1_cards.length>0)
										{
											$.each(data.grp1_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />');  
											});
										}
								    }
									else
								    {
									   if(data.grp1_cards.length>0)
										{
											$.each(data.grp1_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); 
											});
										}
										if(data.grp2_cards.length>0)
										{
											$.each(data.grp2_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp3_cards.length>0)
										{
											$.each(data.grp3_cards, function(n,m){
													if(n=0)
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />'); 
													else
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />');
												});
										}
										if(data.grp4_cards.length>0)
										{
											$.each(data.grp4_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp5_cards.length>0)
										{
											$.each(data.grp5_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp6_cards.length>0)
										{
											$.each(data.grp6_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp7_cards.length>0)
										{
											$.each(data.grp7_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />');
											});
										}
									  }//grouped
									}
									else
									{
									  if(other_player_grouped == false)
								      {
										if(data.grp1.length>0)
										{
											$.each(data.grp1, function(n,m){
											if(n=0)
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }
											else
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }  
											});
										}
								      }
									  else
								      {
										if(data.grp1.length>0)
										{
											$.each(data.grp1, function(n,m){
											if(n=0)
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }
											else
											{ 
											$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); }
										});
										}
										if(data.grp2.length>0)
										{
											$.each(data.grp2, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp3.length>0)
										{
											$.each(data.grp3, function(n,m){
													if(n=0)
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />'); 
													else
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />');
												});
										}
										if(data.grp4.length>0)
										{
											$.each(data.grp4, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards4').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp5.length>0)
										{
											$.each(data.grp5, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp6.length>0)
										{
											$.each(data.grp6, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp7.length>0)
										{
											$.each(data.grp7, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />');
											});
										}
									  }//grouped
									}//else 
							
						}
						
						///clear data after game ends 
						clear_player_data_after_declare();
						$("#player1turn").text("");
						$("#player1turn").hide();
						$("#top_player_count1").hide();
						$("#player2turn").text("");
						$("#player2turn").hide();
						$("#top_player_count2").hide();
						//$(".declare-table").hide();
						$('#div_msg').show();
						declare = 2;
				});///after player dropped game
				socket.on("dropped_pool_game", function(data) 
				{
					console.log(" dropped_game "+JSON.stringify(data));				
					$(".declare-table").show();
					var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
					$('#game_summary').find('td').remove();
					$('#game_summary tr:gt(3)').remove();

					$("#top_player_count1").hide();
					$("#top_player_count2").hide();
					$("#bottom_player_count1").hide();
					$("#bottom_player_count2").hide();

					var restart_timer = 10;
					var i=0; var name; 
					var game_score =0 , amount_won =0;
					var current_player_grouped = data.user_grouped;
					var other_player_grouped = data.other_grouped;
					
						for(var k=0; k<2; k++)
						{
							i = i+1;
							if(i==1)
							{
								name = loggeduser;
								game_score = data.game_score;
								amount_won = data.amount_won;	
								poolamount_won=data.poolamount_won;
							}
							else
							{ 
								name = data.opp_user; 
								game_score = data.opp_game_score;
								amount_won = data.opp_amount_won;
								poolamount_won=data.opp_poolamount_won;
							}
							
								$('#game_summary').append('<tr id="tr_cards'+(i)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(i)+'"></td><td class="declare-cards"><div id="pl'+(i)+'cards1" class="decl-group1"></div><div id="pl'+(i)+'cards2" class="decl-group2"></div><div id="pl'+(i)+'cards3" class="decl-group3"></div><div id="pl'+(i)+'cards4" class="decl-group4"></div><div id="pl'+(i)+'cards5" class="decl-group5"></div><div id="pl'+(i)+'cards6" class="decl-group6"></div><div id="pl'+(i)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');
								
								if(i==2)
								{
									$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
									$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Papplu Joker</th><th><img id="papplu_card" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
							var papplu_joker_card_src = $("#papplu_joker").attr("src");
						    $("#papplu_card").attr('src',papplu_joker_card_src); 
									var joker_card_src = $("#joker_card").attr("src");	
									$("#side_joker").attr('src', joker_card_src); 
								}
									if(i==1 && name==data.prev_pl)
									{
										$('#win'+(i)+'').append('<img style="width: 50%" src="winner-rummy.jpg"/>');
										
										//audio_player_winner.play();
									}
									if(i==2 && name==data.prev_pl)
									{
										$('#win'+(i)+'').append('<img style="width: 50%" src="winner-rummy.jpg"/>');
										//audio_player_winner.play();
									}
									if(loggeduser==data.prev_pl)
									{
										audio_player_winner.play();
										$("#seq").text(" Valid ");
									}
									else { $("#seq").text(" Wrong "); }
								if(i==1)
								{
								  if(current_player_grouped == false)
								   {
										if(data.grp1_cards.length>0)
										{
											$.each(data.grp1_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards1').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards1').append('<img  src="' + m.card_path + '" />');  
											});
										}
								    }
									else
								    {
									   if(data.grp1_cards.length>0)
										{
											$.each(data.grp1_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards1').append('<img  src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards1').append('<img  src="' + m.card_path + '" />'); 
											});
										}
										if(data.grp2_cards.length>0)
										{
											$.each(data.grp2_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards2').append('<img  src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp3_cards.length>0)
										{
											$.each(data.grp3_cards, function(n,m){
													if(n=0)
													$('#pl'+(i)+'cards3').append('<img  src="' + m.card_path + '" />'); 
													else
													$('#pl'+(i)+'cards3').append('<img src="' + m.card_path + '" />');
												});
										}
										if(data.grp4_cards.length>0)
										{
											$.each(data.grp4_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards4').append('<img  src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards4').append('<img  src="' + m.card_path + '" />');
											});
										}
										if(data.grp5_cards.length>0)
										{
											$.each(data.grp5_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards5').append('<img  src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards5').append('<img  src="' + m.card_path + '" />');
											});
										}
										if(data.grp6_cards.length>0)
										{
											$.each(data.grp6_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards6').append('<img  src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards6').append('<img   src="' + m.card_path + '" />');
											});
										}
										if(data.grp7_cards.length>0)
										{
											$.each(data.grp7_cards, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards7').append('<img  src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards7').append('<img  src="' + m.card_path + '" />');
											});
										}
									  }//grouped
									}
									else
									{
									  if(other_player_grouped == false)
								      {
										if(data.grp1.length>0)
										{
											$.each(data.grp1, function(n,m){
											if(n=0)
											{ 
											$('#pl'+(i)+'cards1').append('<img  src="' + m.card_path + '" />'); }
											else
											{ 
											$('#pl'+(i)+'cards1').append('<img  src="' + m.card_path + '" />'); }  
											});
										}
								      }
									  else
								      {
										if(data.grp1.length>0)
										{
											$.each(data.grp1, function(n,m){
											if(n=0)
											{ 
											$('#pl'+(i)+'cards1').append('<img  src="' + m.card_path + '" />'); }
											else
											{ 
											$('#pl'+(i)+'cards1').append('<img  src="' + m.card_path + '" />'); }
										});
										}
										if(data.grp2.length>0)
										{
											$.each(data.grp2, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards2').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards2').append('<img  src="' + m.card_path + '" />');
											});
										}
										if(data.grp3.length>0)
										{
											$.each(data.grp3, function(n,m){
													if(n=0)
													$('#pl'+(i)+'cards3').append('<img  src="' + m.card_path + '" />'); 
													else
													$('#pl'+(i)+'cards3').append('<img  src="' + m.card_path + '" />');
												});
										}
										if(data.grp4.length>0)
										{
											$.each(data.grp4, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards4').append('<img  src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards4').append('<img  src="' + m.card_path + '" />');
											});
										}
										if(data.grp5.length>0)
										{
											$.each(data.grp5, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards5').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp6.length>0)
										{
											$.each(data.grp6, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards6').append('<img src="' + m.card_path + '" />');
											});
										}
										if(data.grp7.length>0)
										{
											$.each(data.grp7, function(n,m){
												if(n=0)
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />'); 
												else
												$('#pl'+(i)+'cards7').append('<img src="' + m.card_path + '" />');
											});
										}
									  }//grouped
									}//else 
							
						}
						
						///clear data after game ends 
						clear_player_data_after_declare();
						$("#player1turn").text("");
						$("#player1turn").hide();
						$("#top_player_count1").hide();
						$("#player2turn").text("");
						$("#player2turn").hide();
						$("#top_player_count2").hide();
						//$(".declare-table").hide();
						$('#div_msg').show();
						declare = 2;
				});
				///clear data of declared player
				function clear_player_data_after_declare()
				{
						$("#div_msg").empty();
						$("#images").empty();
						$("#msg").empty();
						$("#msg").hide();
						$("#open_deck").hide();
						$("#list1").empty();
						$("#list2").empty();
						$("#list3").empty();
						$("#list4").empty();
						$("#list5").empty();
						$("#list6").empty();
						$("#list7").empty();
						$("#discareded_open_cards").empty();
						$("#open_card").hide();
						$("#closed_cards").hide();
						$("#joker_card").hide();
						$("#open_card").attr('src','');  
						$("#closed_cards").attr('src', "");  
						
						$("#papplu_joker").hide();
		                 $("#lablepapplu").hide();
						  $("#papplu_joker").attr('src', ''); 
						
						$("#sort_cards").hide();
						$('#drop_game').attr("disabled", 'disabled');
						$("#drop_game").hide();
						$('#finish_card').attr("disabled", 'disabled');
						$("#finish_card").hide();
						$("#top_player_dealer").hide();
						$("#bottom_player_dealer").hide();
						
						open_card_src = '';
						closed_card_src = '';
						picked_card_value = '';
						$('#declare').attr("disabled", 'disabled');
						$("#declare").hide();
						$('#discard_card').attr("disabled", 'disabled');
						$("#discard_card").hide();
						$('#finish_game').attr("disabled", 'disabled');
						$("#finish_game").hide();
						$("#group_cards").hide();
						
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
						$("#bottom_disconnect").hide();
						$("#top_disconnect").hide();
				}//// clear_player_data_after_declare() ends 
			/** ----------- Declare (1 player )Start  ------------------**/

			
			/***************************  GAME HAS STARTED   ********************************/
			
			/***************************   Game Finished    *******************/
			
			socket.on('game_finished', function(data)
			{
			 if(data.user==loggeduser)
				  {
					if(tableid==data.group)
					{
					  if(table_round_id == data.round_id)
					  {


						$("#top_player_count1").hide();
						$("#top_player_count2").hide();
						$("#bottom_player_count1").hide();
						$("#bottom_player_count2").hide();

					  	console.log("\n\n GAME FINISHED AND RESTART \n\n");
						
							socket.emit('user1_join_group', loggeduser,btnclicked,tableid,random_group_roundno,0,player_amount,player_gender,browser_type, os_type,user_id,true); 
						
					  }
					}
				  }
			});
			/***************************   Game Finished    *******************/
			
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
			//	is_refreshed = false;
			});  
			
			$("#leave_confirm").click(function()
			{
				if($.trim($("#div_msg").html())!=''){
					$("#div_msg").hide();
				}
			});
			
			$("#leave_group_cancel").click(function()
			{
				if($.trim($("#div_msg").html())!=''){
					$("#div_msg").show();
				}
			});
			
			$("#game_lobby").click(function()
			{
				/* alert("Show lobby");
				window.location=('/public/point-lobby-rummy.php'); */
			});
			
			
			socket.on("player_left", function(data) 
			{
			console.log("--- in pl left ---"+socket.id);
			console.log(" in player_left "+JSON.stringify(data));
			 if(tableid==data.group)
			 {
			 
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
						$("#bottom_disconnect").hide();
						$("#top_disconnect").hide();
						
						
			 is_finished = false ;
			 is_game_dropped = false;
			 declare = 0;
			 
			 	var count = 5; 
				$("#div_msg").empty();
				$("#div_msg").show();
				$('#div_msg').prepend(data.left_user+' has left the Game...!');
				var countdown = setInterval(function(){
						  if (count == 0) {
								  clearInterval(countdown);  
								 $("#div_msg").empty();
								 
								 if(data.joined_player == 1)
								 {
								      $("#lablepapplu").hide();
										$("#papplu_joker").hide();
										$("#papplu_joker").attr('src',''); 
									$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
									
									if(data.btn==1)
									{
										$("#top_player_sit").css('display','block');
										$("#top_player_loader").css('display','none');
										$("#top_player_name").text('');
										$("#top_player_details").hide();
										$("#top_male_player").css('display','none');
										$("#top_female_player").css('display','none');
									}
									else
									{
										$("#top_player_sit").css('display','none');
										$("#top_player_loader").css('display','none');
										$("#top_player_name").text(loggeduser);
										$("#top_player_amount").text(player_amount);
										$("#top_player_details").show();
										
										if(player_gender == 'Male')
											{ $("#top_male_player").css('display','block'); }
										else { $("#top_female_player").css('display','block'); }
										
										$("#bottom_player_sit").css('display','block');
										$("#bottom_player_loader").css('display','none');
										$("#bottom_player_name").text('');
										$("#bottom_player_details").hide();
										console.log("\nANDYANDYANDY 5552");
										$("#bottom_male_player").css('display','none');
										$("#bottom_female_player").css('display','none');
									}
								 }
								 else 
								 if(data.joined_player == 0)
								 {
									$("#div_msg").hide();
									//if(data.btn==1)
									if(data.left_user == $("#top_player_name").text())
									{
										$("#top_player_sit").css('display','block');
										$("#top_player_loader").css('display','none');
										$("#top_player_name").text('');
										$("#top_player_details").hide();
										$("#top_male_player").css('display','none');
										$("#top_female_player").css('display','none');
									}
								   else if(data.left_user == $("#bottom_player_name").text())
								   {
										$("#bottom_player_sit").css('display','block');
										$("#bottom_player_loader").css('display','none');
										$("#bottom_player_name").text('');
										$("#bottom_player_details").hide();
										console.log("\nANDYANDYANDY 5577");
										$("#bottom_male_player").css('display','none');
										$("#bottom_female_player").css('display','none');
									} 
								 }
								}
							count--;
						  }, 1000);
						
							$("#top_player_sit").css('display','block');
							$("#top_player_loader").css('display','none');
							$("#top_player_name").text('');
							$("#top_player_details").hide();
							$("#top_male_player").css('display','none');
							$("#top_female_player").css('display','none');
					}//if same table 
			});//player_left ends 
			
			socket.on("player_left_watch", function(data) 
			{
			console.log("\n player_left_watch "+JSON.stringify(data));
				if(loggeduser!=data.left_user && loggeduser!=data.joined_player)
				{
					if(tableid==data.group)
					{
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
						$("#bottom_disconnect").hide();
						$("#top_disconnect").hide();
						
						is_finished = false ;
						is_game_dropped = false;
						declare = 0;
			 
						var count = 2; 
						$("#div_msg").empty();
						$("#div_msg").show();
						$('#div_msg').prepend(data.left_user+' has left the Game...!');
						var countdown = setInterval(function(){
						if (count == 0) 
						{
							clearInterval(countdown);  
							$("#div_msg").empty();
							$("#div_msg").show();
							$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
					
							if(data.left_user == $("#top_player_name").text())
									{
										$("#top_player_sit").css('display','block');
										$("#top_player_loader").css('display','none');
										$("#top_player_name").text('');
										$("#top_player_details").hide();
										$("#top_male_player").css('display','none');
										$("#top_female_player").css('display','none');
									}
								   else if(data.left_user == $("#bottom_player_name").text())
								   {
										$("#bottom_player_sit").css('display','block');
										$("#bottom_player_loader").css('display','none');
										$("#bottom_player_name").text('');
										$("#bottom_player_details").hide();
										console.log("\nANDYANDYANDY 5648");
										$("#bottom_male_player").css('display','none');
										$("#bottom_female_player").css('display','none');
									} 
						}
							count--;
						}, 1000);
						
							
					}//if same table 
				}//watch-player
			});
			
			
			//socket.on("low_balance", function(data) 
			socket.on("low_balance", function(username_s,grpid_s,pl_amount_taken_s,is_restart_game) 
			{
			$(".declare-table").hide();
				if(is_restart_game == true){ is_game_started = true; }
			 if(username_s==loggeduser)
			 {
				alert("You do not have sufficient balance to play game.");
				joined_table = false;////in order need to update (add) amount as player left game 
				//window.close(); get amount and update to db -emit to server 
				$("#div_msg").empty();
				$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
				}
				else
				{
				alert("other left ");
				$("#div_msg").empty();
				$('#div_msg').prepend('<label style="color:white">Waiting for another Player to join Table!</label>');
				}
				 if($("#top_player_name").text() == username_s)
									{
										$("#top_player_loader").css('display','none');
										$("#top_player_sit").css('display','block');
										$("#top_male_player").css('display','none');
										$("#top_female_player").css('display','none');
										$("#top_player_details").hide();
									}
								else  if($("#bottom_player_name").text() == username_s)
									{	
										$("#bottom_player_loader").css('display','none');
										$("#bottom_player_sit").css('display','block');
										console.log("\nANDYANDYANDY 5693");
										$("#bottom_male_player").css('display','none');
										$("#bottom_female_player").css('display','none');
										$("#bottom_player_details").hide();
									} 
			});
			
			socket.on('show_game_data', function(tableid_from_server,player1_name,player2_name,player1_amt,player2_amt,player1_position,player2_position,player1_gender,player2_gender)
			{
				console.log(tableid+"--"+player1_name+"--"+player2_name+"--"+player1_amt+"--"+player2_amt+"--"+player1_position+"--"+player2_position+"--"+player1_gender+"--"+player2_gender);
				
				if(tableid==tableid_from_server)
				{
					if(loggeduser==player1_name) {
						btnclicked = player1_position;
						player_amount = player1_amt;
						player_gender = player1_gender;
					} else if(loggeduser==player2_name) {
						btnclicked = player2_position;
						player_amount = player2_amt;
						player_gender = player2_gender;
					}
					if(loggeduser!=player1_name && loggeduser!=player2_name)
					{
					console.log("\n DISPLAYING GAME DAT TO OTHER PLAYER WATCHING");
						$('#div_msg').empty();
						$('#div_msg').hide();
						
							$("#top_player_sit").css('display','none');
							$("#top_player_loader").css('display','none');
							
							$("#bottom_player_sit").css('display','none');						
							$("#bottom_player_loader").css('display','none');
							
							
							
							/*****  1st player playing *******/
							if(player1_position == 1)
							{
								$("#top_player_name").text(player1_name);
								$("#top_player_amount").text(player1_amt);
								$("#top_player_details").show();
								if(player1_gender == 'Male')
								{ $("#top_male_player").css('display','block'); }
								else { $("#top_female_player").css('display','block'); }
							}
							else  if(player1_position == 2)
							{
								$("#bottom_player_name").text(player1_name);
								$("#bottom_player_amount").text(player1_amt);
								$("#bottom_player_details").show();
								
								if(player1_gender == 'Male')
								{ $("#bottom_male_player").css('display','block'); }
								else { $("#bottom_female_player").css('display','block'); }
							} 
							/*****  2nd player playing *******/
							if(player2_position == 1)
							{
								$("#top_player_name").text(player2_name);
								$("#top_player_amount").text(player2_amt);
								$("#top_player_details").show();
								if(player2_gender == 'Male')
								{ $("#top_male_player").css('display','block'); }
								else { $("#top_female_player").css('display','block'); }
							}
							else if(player2_position == 2)
							{
								$("#bottom_player_name").text(player2_name);
								$("#bottom_player_amount").text(player2_amt);
								$("#bottom_player_details").show();
								
								if(player2_gender == 'Male')
								{ $("#bottom_male_player").css('display','block'); }
								else { $("#bottom_female_player").css('display','block'); }
							}
					}//if-other-player-than-playing-players
				}///if-same-table
			});
			socket.on('show_pool_game_data', function(tableid_from_server,player1_name,player2_name,player1_amt,player1_poolamt,player2_amt,player2_poolamt,player1_position,player2_position,player1_gender,player2_gender)
			{
				console.log(tableid+"--"+player1_name+"--"+player2_name+"--"+player1_amt+"--"+player2_amt+"--"+player1_position+"--"+player2_position+"--"+player1_gender+"--"+player2_gender);
				
				if(tableid==tableid_from_server)
				{
					if(loggeduser==player1_name) {
						btnclicked = player1_position;
						player_amount = player1_amt;
						player_gender = player1_gender;
					} else if(loggeduser==player2_name) {
						btnclicked = player2_position;
						player_amount = player2_amt;
						player_gender = player2_gender;
					}
					if(loggeduser!=player1_name && loggeduser!=player2_name)
					{
					console.log("\n DISPLAYING GAME DAT TO OTHER PLAYER WATCHING");
						$('#div_msg').empty();
						$('#div_msg').hide();
						
							$("#top_player_sit").css('display','none');
							$("#top_player_loader").css('display','none');
							
							$("#bottom_player_sit").css('display','none');						
							$("#bottom_player_loader").css('display','none');
							
							
							
							/*****  1st player playing *******/
							if(player1_position == 1)
							{
								$("#top_player_name").text(player1_name);
								$("#top_player_poolamount").text(player1_poolamt);
								$("#top_player_amount").text(player1_amt);
								$("#top_player_details").show();
								if(player1_gender == 'Male')
								{ $("#top_male_player").css('display','block'); }
								else { $("#top_female_player").css('display','block'); }
							}
							else  if(player1_position == 2)
							{
								$("#bottom_player_name").text(player1_name);
								$("#bottom_player_poolamount").text(player1_poolamt);
								$("#bottom_player_amount").text(player1_amt);
								$("#bottom_player_details").show();								
								if(player1_gender == 'Male')
								{ $("#bottom_male_player").css('display','block'); }
								else { $("#bottom_female_player").css('display','block'); }
							} 
							/*****  2nd player playing *******/
							if(player2_position == 1)
							{
								$("#top_player_name").text(player2_name);
								$("#top_player_poolamount").text(player2_poolamt);
								$("#top_player_amount").text(player2_amt);
								$("#top_player_details").show();
								if(player2_gender == 'Male')
								{ $("#top_male_player").css('display','block'); }
								else { $("#top_female_player").css('display','block'); }
							}
							else if(player2_position == 2)
							{
								$("#bottom_player_name").text(player2_name);
								$("#bottom_player_amount").text(player2_amt);
								$("#bottom_player_poolamount").text(player2_poolamt);
								$("#bottom_player_details").show();
								
								if(player2_gender == 'Male')
								{ $("#bottom_male_player").css('display','block'); }
								else { $("#bottom_female_player").css('display','block'); }
							}
					}//if-other-player-than-playing-players
				}///if-same-table
			});	


			$("#list1, #list2, #list3, #list4, #list5, #list6, #list7").dragsort({ 
				dragSelector: "div",
				dragBetween: true,
				dragStart: dragStart,
				dragEnd: saveOrder });
			
			$("#images").dragsort({ dragSelector: "div", dragBetween: true });

			function getGroupIdFromTag( tagId ) {
				for(i = 1; i <= 7; i++) {
					if(tagId == ("list" + i))
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
				var groupId = getGroupIdFromTag($(this).parent().attr('id'));
				//alert(groupId);
				if( groupId == 0 )
					return;
				//if( groupId == parent_group_id )
					//return;
				
				$i=1;
				    $('#list'+groupId).children('div').each(function(idx, val){
					   //alert(val);
					   if($(this).children('img').attr('id') == selected_card_id)
					   {
						 
						   //alert($i);
					      add_here_drop( groupId,$i );
					   }
					   $i++;
					})
			};
			$("#closed_cards").dragsort({ dragSelector: "div", dragBetween: true});
		
		});//function ends 
		
	</script>
	
</html>

<script src="pop-up.js"></script>