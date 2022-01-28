var express = require('express');
var app = express();
var server = require('http').createServer(app);
var mysql = require('mysql');
var bodyParser = require('body-parser');
var fs = require('fs');
var datetime = require('node-datetime');
var urlencodedParser = bodyParser.urlencoded({ extended: false });
var session = require('express-session');
var cookieParser = require('cookie-parser');
var io = require('socket.io').listen(server);
var MemoryStore = session.MemoryStore;
var Player = require("./player.js");
var Room = require('./room.js');
var room = new Room("Test Room");
var Table = require('./table.js');
var Utils = require('./utils.js');
var validateGroup = require('./validateGroup.js');
const EXTRA_TIME = 45;
utils = new Utils();

app.set('view engine', 'jade');
app.use(cookieParser());
app.use(session({ secret: "SESSIONSECRET", saveUninitialized: false, resave: false, cookie: { expires: 30 * 86400 * 1000 } }));
var sess;
app.use(urlencodedParser);
app.use(express.static(__dirname + '/views'));
app.use(express.static(__dirname + '/static')); 
app.use(express.static(__dirname + '/static/cards')); //// for cards  group
app.use(express.static(__dirname + '/static/images'));
app.use(express.static(__dirname + '/static/css'));
app.use(express.static(__dirname + '/static/js'))


var device = require('express-device');
app.use(device.capture());

//database connection
var con = mysql.createConnection({
	host: "localhost",
	user: "rummysah_db",
	password: "Admin@123",
	database : "rummysah_db"
});

var device_name;
var no_of_tables;
var company_commision =0;
var user_id="";
var table_player_capacity="";

//Six player game variables 
var pamount=[];
var ip_restriction = true;

setInterval(refreshIpRestriction, 3000);

function refreshIpRestriction() {
	con.query('SELECT `permission` FROM ip_restriction', [], function (err, result, fields) {
		if (err) {
		 	console.log(err);
		} else {
			if( result.length > 0 ) {
				if( result[0].permission == "Yes" ) {
					ip_restriction = true;
				} else {
					ip_restriction = false;
				}
			}
		}
	});
}

function KolkataTime() {	
	var KolkataOffsetTime = ( 330 - (new Date().getTimezoneOffset() * -1));
	var date = datetime.create(new Date(Date.now() + KolkataOffsetTime * 60000));
	return date.format('Y/m/d H:M:S');
}

// Loading game_app's index page - index.html
app.get('/', function (req, res) {
	device_name = req.device.type.toUpperCase();
	req.session.destroy(); 
	req.session  = null;
 
});

/********************** Joined Table details page starts  *********************/ 

app.get('/join_table', function (req, res) {

	device_name = req.device.type.toUpperCase();
	var uname = req.query.user;
	var table_id = req.query.table_id;	
	var player_balance =0;
	var poolamount;

	if(uname != "" && table_id != 0)
	{
	   
		
		var qry= "SELECT user_id FROM `users`  where `username` ='"+uname+"' ";
		con.query(qry, function(err, user, userfields)
		{
		   if (err) {
		 	console.log(err);
		   } else {
			 if(user.length!=0){ user_id=user[0].user_id; }
		   }
		});
		var qry= "SELECT `table_id`, `table_name`, `game_type`, `point_value`, `min_entry`, `status`, `player_capacity`, `game`, `table_type`, `pool`, `table_no` FROM `player_table`  where `table_id` = "+table_id;
		con.query(qry, function(err, result, fields)
		{
		    if (err) {
		 	console.log(err);
		        } else {
			
					if(result.length!=0){
					
						table_player_capacity = result[0].player_capacity;
						con.query("SELECT acct.*,u.gender FROM `accounts` acct left outer join users u on u.user_id = acct.userid where u.`username`='"+uname+"'", function(err1, rows, fields1) 
						{
						    if (err1) {
							   console.log("/join_table============Error Occured"+err1);
							} else {
							
								if(rows.length!=0){
									
									//geting balace of user from table
									if((result[0].game)=='Cash Game'){ player_balance = rows[0].real_chips;}else if((result[0].game)=='Free Game'){ player_balance = rows[0].play_chips; }
									//checking siting capacity
								    if(table_player_capacity == 2){
									   res.render('two_pl_rummy', {tableid:table_id,table_name:result[0].table_name,game_type:result[0].game_type,point_value:result[0].point_value,min_entry:result[0].min_entry*4,loggeduser:uname,user_account_bal:player_balance,player_gender:rows[0].gender,user_id:rows[0].userid,game:result[0].game,poolamount:0});
									}else if(table_player_capacity == 6){
									  res.render('six_pl_rummy', {tableid:table_id,table_name:result[0].table_name,game_type:result[0].game_type,point_value:result[0].point_value,min_entry:result[0].min_entry*4,loggeduser:uname,user_account_bal:player_balance,player_gender:rows[0].gender,user_id:rows[0].userid,game:result[0].game,poolamount:0});
									}
								}else{
									if(table_player_capacity == 2)
									{res.render('two_pl_rummy', {tableid:0,table_name:"",game_type:"",point_value:0,min_entry:0,loggeduser:"",user_account_bal:0,player_gender:"",user_id:0,game:"",poolamount:0});}
									else if(table_player_capacity == 6)
									{res.render('six_pl_rummy', {tableid:0,table_name:"",game_type:"",point_value:0,min_entry:0,loggeduser:"",user_account_bal:0,player_gender:"",user_id:0,game:"",poolamount:0});}
								}
							}
						});
					}else{
					  console.log("/join_table============Error Occured==table not Found="+qry);
					}
			}	
		});
		
		    con.query("SELECT count(`table_id`) as tables FROM `player_table`",function(er,result1,fields)  
			{ 
			    if (er) {
					console.log(er);
				} else {
				no_of_tables = result1[0].tables;
				}
			});		
	}else {
		res.render('two_pl_rummy', {tableid:0,table_name:"",game_type:"",point_value:0,min_entry:0,loggeduser:"",user_account_bal:0,player_gender:"",user_id:0});
	}
});

/********************** Joined Table details page ends  *********************/ 

app.get('/game_summary', function (req, res) {
	
	var user  = req.query.user;
	var group = req.query.grpid;
	if(user != "" && group != 0){
	    var qry= "SELECT  `group1`, `group2`, `group3`, `group4`, `group5`, `group6`, `group7` FROM `game_details`  where user_id = '"+user+"' and group_id = "+group;
		con.query(qry, function(err, result, fields)
		{
			if(err) {
			   console.log("/game_summary================Error Occured In Query=============== "+err);
			}else{
	           res.render('game_summary', {user:user,grpid:group,grp1:JSON.stringify(result[0].group1),grp2:JSON.stringify(result[0].group2),grp3:JSON.stringify(result[0].group3),grp4:JSON.stringify(result[0].group4),grp5:JSON.stringify(result[0].group5),grp6:JSON.stringify(result[0].group6),grp7:JSON.stringify(result[0].group7)}); 
			}
		}); 
	}else{
	   console.log("/game_summary================Error Occured In Query===========User= "+user+"====group="+group);
	}
});

app.get('/ping', function(req, res) {
    res.send('pong');
});


/********************** Socket connection ********************/
var used = 0;
var no_of_players_joined =0;
var table = null ;
var testing = false;
 
 io.on('connection', function(socket){
 	
 	var Ip = socket.request.connection.remoteAddress;
	var valid = new validateGroup();
    console.log('Player connected from IP Address:  ' +Ip+" Socket ID "+socket.id);
	
	var joker_cards = [];
	var restart_game = false;
	var club_suit_cards = [];
	var spade_suit_cards = [];
	var heart_suit_cards = [];
	var diamond_suit_cards = [];
	var timer  = 0;
	var declare_timer  = 0;
	var playing_again = false;
    var transaction_id = 0;
	var game_type = "";
			
			//Get club suit cards array from database
			con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards` WHERE `suit` LIKE 'c'",function(er,rc,fields)  
			{ 
			    if(er){
				 console.log("/connection================Error Occured In Query (SELECT * FROM `cards` WHERE `suit` LIKE 'c')=============== "+er);
				}else{
					for(var i = 0; i < rc.length; i++) {
						var suit_id = rc[i].suit_id;
						var bsame = false;
						for(var j = 0; j < club_suit_cards.length; j++) { 
						   if( suit_id == club_suit_cards[j].suit_id ){ bsame = true; break;}
						}
						if( !bsame ){ club_suit_cards.push(rc[i]);}
					}

					club_suit_cards = club_suit_cards.sort(function (a, b) {
						return (a.suit_id - b.suit_id)
					});
					var temp = {
						id: club_suit_cards[0].id,
						card_path: club_suit_cards[0].card_path,
						game_points: club_suit_cards[0].game_points,					
						name: club_suit_cards[0].name,
						points: club_suit_cards[0].points,
						sub_id: club_suit_cards[0].sub_id,
						suit: club_suit_cards[0].suit,
						suit_id: 14
					};
					club_suit_cards.push(temp);		
                }				
			});		
			
			//Get Spade suit cards array from database
			con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards` WHERE `suit` LIKE 's'",function(er,rc,fields)  
			{ 
			    if(er){
				 console.log("/connection================Error Occured In Query (SELECT * FROM `cards` WHERE `suit` LIKE 's')=============== "+er);
				}else{
					for(var i = 0; i < rc.length; i++) {
						var suit_id = rc[i].suit_id;
						var bsame = false;
						for(var j = 0; j < spade_suit_cards.length; j++) {
							if( suit_id == spade_suit_cards[j].suit_id ){ bsame = true; break;}
						}
						if( !bsame ){ spade_suit_cards.push(rc[i]);}
					}
					spade_suit_cards = spade_suit_cards.sort(function (a, b) { return (a.suit_id - b.suit_id)});	
					var temp = {
						id: spade_suit_cards[0].id,
						card_path: spade_suit_cards[0].card_path,
						game_points: spade_suit_cards[0].game_points,					
						name: spade_suit_cards[0].name,
						points: spade_suit_cards[0].points,
						sub_id: spade_suit_cards[0].sub_id,
						suit: spade_suit_cards[0].suit,
						suit_id: 14
					};
					spade_suit_cards.push(temp);	
				}
			});	
			//Get Heart suit cards array from database
			con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards` WHERE `suit` LIKE 'h'",function(er,rc,fields)  
			{ 
			    if(er){
				  console.log("/connection================Error Occured In Query (SELECT * FROM `cards` WHERE `suit` LIKE 'h')=============== "+er);
				}else{
					for(var i = 0; i < rc.length; i++) {
						var suit_id = rc[i].suit_id;
						var bsame = false;
						for(var j = 0; j < heart_suit_cards.length; j++) {
							if( suit_id == heart_suit_cards[j].suit_id ){ bsame = true; break;}
						}
						if( !bsame ){heart_suit_cards.push(rc[i]);}
					}
					heart_suit_cards = heart_suit_cards.sort(function (a, b) { return (a.suit_id - b.suit_id) });
					var temp = {
						id: heart_suit_cards[0].id,
						card_path: heart_suit_cards[0].card_path,
						game_points: heart_suit_cards[0].game_points,					
						name: heart_suit_cards[0].name,
						points: heart_suit_cards[0].points,
						sub_id: heart_suit_cards[0].sub_id,
						suit: heart_suit_cards[0].suit,
						suit_id: 14
					};
					heart_suit_cards.push(temp);	
				}
			});	
			//Get Diamond suit cards array from database **/
			con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards` WHERE `suit` LIKE 'd'",function(er,rc,fields)  
			{ 
			    if(er){
				  console.log("/connection================Error Occured In Query (SELECT * FROM `cards` WHERE `suit` LIKE 'h')=============== "+er);
				}else{
				
					for(var i = 0; i < rc.length; i++) {
						var suit_id = rc[i].suit_id;
						var bsame = false;
						for(var j = 0; j < diamond_suit_cards.length; j++) {
							if( suit_id == diamond_suit_cards[j].suit_id ){ bsame = true; break;}
						}
						if( !bsame ){ diamond_suit_cards.push(rc[i]);}
					}
					diamond_suit_cards = diamond_suit_cards.sort(function (a, b) { return (a.suit_id - b.suit_id)});
					var temp = {
						id: diamond_suit_cards[0].id,
						card_path: diamond_suit_cards[0].card_path,
						game_points: diamond_suit_cards[0].game_points,					
						name: diamond_suit_cards[0].name,
						points: diamond_suit_cards[0].points,
						sub_id: diamond_suit_cards[0].sub_id,
						suit: diamond_suit_cards[0].suit,
						suit_id: 14
					};
					diamond_suit_cards.push(temp);	
				}
			});	
			
		    //get company commision from database and assign to variable
			con.query("SELECT commission FROM `commission` ",function(er,result,fields)  
			{ 
				if(er){ 
					console.log("/connection================Error Occured In Query (SELECT * FROM `commission)=============== "+er);
				}else{
					if(result.length!=0){ company_commision = result[0].commission;}
				}
			});	
			
			function revertPoints(username, amount, table_game) {
			
				if(username != '' && username != null){
					con.query("SELECT `play_chips`, `real_chips` FROM `accounts` where username='"+username+"'",function(er,result,fields)  
					{ 
					    if(er){ 
					       console.log("/revertPoints================Error Occured In Query (SELECT * FROM `accounts` where username='"+username+"')=============== "+er);
				        }else{
								if(result.length!=0)
								{
									console.log("UPDATING PLAYER AMOUNT WHEN LEFT AFTER RESTART OF "+username +" PLAYING AMOUNT WAS "+amount);
									    if(table_game == 'Free Game')
										{
												player_play_chips = result[0].play_chips;
												console.log("player_play_chips "+player_play_chips+"\n");
												console.log("pl_amount_taken "+amount+"\n");
												new_chips = player_play_chips + amount;
												var update_amount = "UPDATE accounts SET play_chips = "+new_chips+" where username='"+username+"'";
												console.log("update query line 388==reverpoint func free=="+update_amount);
												con.query(update_amount, function (err, result) {
												if (err) {console.log(err);}
												else {console.log(result.affectedRows + " record(s) after Play chips(Free game) update of "+username);}
												});
											
										}
										if(table_game == 'Cash Game')
										{
												player_play_chips = result[0].real_chips;
										
												console.log("player_play_chips "+player_play_chips+"\n");
												console.log("pl_amount_taken "+amount+"\n");
												new_chips = player_play_chips + amount;
												var update_amount = "UPDATE accounts SET real_chips = "+new_chips+" where username='"+username+"'";
												console.log("update query line 388==reverpoint func cash=="+update_amount);
												con.query(update_amount, function (err, result) {
												if (err) {console.log(err);}
												else {console.log(result.affectedRows + " record(s) after Real chips(Paid game) update of "+username);}
												});
											
										}
								}
						}
					});
				}else{
				  console.log("/connection->revertPoints================Error Occured===========Username Not Found== ");
				}
			}

			function revertBonus(username, amount, table_game) {
			
			    if(username != '' && username != null){
				
					con.query("SELECT `bonus` FROM `accounts` where username='"+username+"'",function(er,result,fields)  
					{
                        if(er){
						console.log("/connection->revertBonus================Error Occured in Query===SELECT * FROM `accounts` where username='"+username+"========error== "+er);
                        }else{						
							if(result.length!=0){
							
								if(table_game == 'Cash Game'){
								
									player_bonus = result[0].bonus;
									if( player_bonus > 0 ) {
										amount = amount * 0.2;
										if(player_bonus < amount)
										amount = player_bonus;
										
										player_bonus -= amount;
										var update_amount = "UPDATE accounts SET bonus="+player_bonus+", redeemable_balance=redeemable_balance+"+ amount +" where username='"+username+"'";
										console.log("update query line 388==reverbonus func free=="+update_amount);
										//get company commision from database and assign to variable
										con.query(update_amount, function (err, result) {
										if (err) {console.log(err);}
										else {}
										});
									}
								}
							}
						}
					});
					
				}else{
				  console.log("/connection->revertBonus================Error Occured===========Username Not Found== ");
				}
			}
	
			socket.on('disconnect', function () {
			
				var left_player_status = "";
				var table_index =0;
				var table_player_capacity = 0;

				console.log("\n DISCONNECT \n");
				console.log("\n player "+socket.username +" gender "+socket.gender+" disconnecting , connected players(sockets) ");
				console.log("\n socket.id"+socket.id+"--socket.tableid--"+socket.tableid);
				console.log("\n player seat no "+socket.btn_clicked);

				var player = room.getPlayer(socket.id);
				if(player != null)
		        {
					table_index = getTableIndex(room.tables,player.tableID);
					
					if (table_index == - 1) { console.log("\n disconnect"); return;	}
					
					table_player_capacity = room.tables[table_index].playerCapacity;
					
					console.log("\n--------table players capacity "+room.tables[table_index].playerCapacity);
                    room.tables[table_index].removeSocket(socket.id);
					
					if(table_player_capacity == 2){
						if (room.tables[table_index].players.length >= 1 && room.tables[table_index].players[0].name == socket.username)
						{ 
							console.log("\n 0th player.name "+room.tables[table_index].players[0].name+" st "+room.tables[table_index].players[0].status);
							left_player_status = room.tables[table_index].players[0].status;
						}else  if (room.tables[table_index].players.length == 2 && room.tables[table_index].players[1].name == socket.username){ 
							console.log("\n 1st player.name "+room.tables[table_index].players[1].name+" st "+room.tables[table_index].players[1].status); 
							left_player_status = room.tables[table_index].players[1].status;
						}
					}else if(table_player_capacity == 6){
						for (var i = 0; i < room.tables[table_index].players.length; i++) 
						{
							if (room.tables[table_index].players[i].name == socket.username)
							{ 
								console.log("\n  player.name "+room.tables[table_index].players[i].name+" status "+room.tables[table_index].players[i].status);
								left_player_status = room.tables[table_index].players[i].status;
							}
						}
						if( left_player_status == "") {
							for (var i = 0; i < room.tables[table_index].six_usernames.length; i++) 
							{
								if (room.tables[table_index].six_usernames[i] == socket.username)
								{ 
									console.log("\n  player.name "+room.tables[table_index].six_usernames[i]+" status Waiting");
									left_player_status = "waiting";
								}
							}
						}
					}
				
                }
				var gen_index = 0;
				var click_index = 0;
				//Two Player Disconnect	
				if(player && left_player_status == "playing" && table_player_capacity == 2)
				{
					console.log("player.status "+player.status);
					player.status = "disconnected";
					/**** If two are playing game , one disconnected then show that player status as disconnected ***/
					if (room.tables[table_index].players.length == 2) 
					{
						if(socket.username != '' && socket.username != null && socket.username != "undefined"){
							if(room.tables[table_index].players[0]){
								if (room.tables[table_index].players[0].name == socket.username)
								{ 					
									room.tables[table_index].players[0].player_reconnected = false;
									room.tables[table_index].players[0].status = "disconnected"; 
											
								}
							}
							if(room.tables[table_index].players[1]){
								if (room.tables[table_index].players[1].name == socket.username){ 
									
										room.tables[table_index].players[1].status = "disconnected";
										room.tables[table_index].players[1].player_reconnected = false;
									
								}
							}
						}
					}	
					if(player.name != null){
					   if(player.tableID != '' && player.tableID != null && player.tableID != "undefined"){
						 socket.broadcast.emit('player_disconnected',player.name,player.tableID);
					   }
					}
					
					console.log("\n disconnecting player status when playing game "+player.status);			
				}else if(player && left_player_status == "intable" && table_player_capacity == 2){
					console.log("player.status "+player.status);
					player.status = "available";
					//console.log("\n disconnecting player status when on table not playing game "+player.status);
					
					room.tables[table_index].removePlayer(player);
					room.tables[table_index].readyToPlayCounter--;
					room.tables[table_index].status = "available"; 
					clearInterval(room.tables[table_index].game_countdown);  
					room.tables[table_index].restart_timer = true;
					
					console.log("conn players "+room.tables[table_index].usernames.toString());
					console.log("conn players click "+room.tables[table_index].user_click.toString());
					console.log("conn players gender "+room.tables[table_index].player_gender.toString());
					console.log("conn players amount "+room.tables[table_index].player_amount.toString());
					/**  DO CHANGES HERE ***/
					var idx = 0;
					if(room.tables[table_index].usernames[0]==socket.username) {
						idx = 0;
					} else if(room.tables[table_index].usernames[1]==socket.username) { 
						idx = 1;
					}
					amount = room.tables[table_index].player_amount[idx];

					room.tables[table_index].usernames.splice(idx, 1);
					room.tables[table_index].user_click.splice(idx, 1);
					room.tables[table_index].player_gender.splice(idx, 1);
					room.tables[table_index].player_amount.splice(idx, 1);
					room.tables[table_index].player_poolamount.splice(idx, 1);

					console.log("\N AFTER DELETE ");
					console.log("conn players "+room.tables[table_index].usernames.toString());
					console.log("conn players click "+room.tables[table_index].user_click.toString());
					console.log("conn players gender "+room.tables[table_index].player_gender.toString());
					console.log("conn players amount "+room.tables[table_index].player_amount.toString());
					//console.log("\n after disconnected player status  "+player.status);
                    
					removePlayerFromTable(socket.username, room.tables[table_index].id);
					revertPoints(socket.username, amount, room.tables[table_index].table_game);
					console.log("REVERT 520");

					if(room.tables[table_index].players.length == 1)
					{
						if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
						{
					
								io.sockets.connected[(room.tables[table_index].players[0].id)].emit('user1_join_group_check',room.tables[table_index].usernames[0],room.tables[table_index].user_click[0],room.tables[table_index].id,room.tables[table_index].player_gender[0],room.tables[table_index].player_amount[0],false);
						}
					}
					socket.leave(socket.room);
				}

				//Six Player Disconnect	
				var gen_index_six = -1;
				var click_index_six = -1;
				var amount = 0;
				var table_game;
				if(player && left_player_status == "playing" && table_player_capacity == 6)
				{
					console.log("player.status "+player.status);
					player.status = "disconnected";
					
					for (var i = 0; i < room.tables[table_index].players.length; i++) 
					{
					 if (room.tables[table_index].players[i].name == socket.username)
						{ 
							room.tables[table_index].players[i].status = "disconnected"; 
							room.tables[table_index].players[i].player_reconnected = false;
						}
					}	
					
					if(player.name != '' && player.name != null && player.name != "undefined"){
						socket.broadcast.emit('player_disconnected_six',player.name,player.tableID);
						console.log("\n disconnecting player status when playing six-player-game "+player.status);	
					}else{
					  console.log("\n disconnecting player status line number 616 === 'player_disconnected_six'"+player.status);
					}	
					
				}else if(player && ( left_player_status == "intable" || left_player_status == "waiting" ) && table_player_capacity == 6)
				{
				
					console.log("player.status "+player.status);
					player.status = "available";
					console.log("\n disconnecting player status when on table not playing 6pl game "+player.status);
					
					console.log("conn players "+room.tables[table_index].six_usernames.toString());
					console.log("conn players click "+room.tables[table_index].six_user_click.toString());
					console.log("conn players gender "+room.tables[table_index].six_player_gender.toString());
					console.log("conn players amount "+room.tables[table_index].six_player_amount.toString());
					
					table_game = room.tables[table_index].table_game;

					for (var i = 0; i < room.tables[table_index].six_usernames.length; i++) 
					{
						if(socket.username == room.tables[table_index].six_usernames[i])
						{ 
							click_index_six = room.tables[table_index].six_user_click[i];
							if(left_player_status == "waiting")
								amount = room.tables[table_index].six_player_amount[i];

							room.tables[table_index].six_usernames.splice(i, 1);
							room.tables[table_index].six_user_click.splice(i, 1);
							room.tables[table_index].six_player_gender.splice(i, 1);
							room.tables[table_index].six_player_amount.splice(i, 1);
							room.tables[table_index].six_player_poolamount.splice(i, 1);
							break;
						}
					}

					for (var j = 0; j < room.tables[table_index].players_names.length; j++)
					{
						if(socket.username == room.tables[table_index].players_names[j])
						{
							room.tables[table_index].players_names.remove(j);

							if(left_player_status == "intable")
								amount = room.tables[table_index].players_amounts[j];
							room.tables[table_index].players_amounts.remove(j);
							room.tables[table_index].players_poolamounts.remove(j);
							break;
						}
					}
					
					revertPoints(socket.username, amount, table_game); 
					console.log("REVERT 607");

					console.log("\n AFTER DELETE SIX PL Game data ");
					console.log("conn players "+room.tables[table_index].six_usernames.toString());
					console.log("conn players click "+room.tables[table_index].six_user_click.toString());
					console.log("conn players gender "+room.tables[table_index].six_player_gender.toString());
					console.log("conn players amount "+room.tables[table_index].six_player_amount.toString());

					room.tables[table_index].removePlayer(player);
					room.tables[table_index].readyToPlayCounter--;
					if(room.tables[table_index].players.length == 0)
					{
						console.log(" \n in disconnect  if 0 players -----------------");
						room.tables[table_index].status = "available";
						clearInterval(room.tables[table_index].game_countdown_six); 				
					}
					
					if(room.tables[table_index].players.length <2)
					{
						console.log(" \n in disconnect  if less than 2 players -----------------");
						room.tables[table_index].restart_game_six = false;
					}

					console.log("\n after disconnected player status  "+player.status);			
					if(socket.username){
					socket.broadcast.emit("player_left_six_pl_game", { left_user:socket.username,btn:click_index_six,group:room.tables[table_index].id,joined_player:0,game_restart:room.tables[table_index].restart_game_six});	
					}else{
					console.log("\n player_left_six_pl_game=====error=700");		
					}
					if(room.tables[table_index].players.length == 1)
					{
						if(room.tables[table_index].players[0].id != ''){
							
							if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
							{
					              io.sockets.connected[(room.tables[table_index].players[0].id)].emit('check_if_joined_player',
								room.tables[table_index].six_usernames,room.tables[table_index].six_user_click,room.tables[table_index].id,
								room.tables[table_index].six_player_amount,room.tables[table_index].six_player_gender,false);
							}
						}else{
						 console.log("\n check_if_joined_player=====error=706");
						}
					}

					removePlayerFromTable( socket.username, room.tables[table_index].id );
					
					socket.leave(socket.room);

					if(room.tables[table_index].players.length < 2 ) {
						room.tables[table_index].activity_timer_set = false;				
					}

					if(room.tables[table_index].players.length == 0 ) {
						room.removeTable(room.tables[table_index]);	
					}
				}

				if(player){room.removePlayer(player);}
			});
				
	        //before join to table check if player is already exist on that table 
			socket.on('player_exist_in_table', function(playername,tableid){ var player = new Player(); });

			socket.on('player_connecting_to_table', function(playername,tableid,btn_clicked)
			{
			    var table_index =0;
			    if (!playername) { console.log("\n player_connecting_to_table==========playername Error occured="); return;	}
				if (!tableid) { console.log("\n player_connecting_to_table==========tableid Error occured="); return;	}
				if (table_index == - 1) { console.log("\n player_connecting_to_table"); return;	}
				
				table_index = getTableIndex(room.tables,tableid);
				
				if( ip_restriction ) {
					for(i = 0; i < room.tables[table_index].players.length; i++ ) {
						    if(room.tables[table_index].players[i].getIp() == Ip) {
							   console.log("\n same ip");
							   if(playername){ socket.emit('table_ip_restrict',playername,tableid);}else{console.log("\n table_ip_restrict===error=765");
							}
							return;	
						}
					}
				}

				con.query("SELECT `table_id`, `table_name`, `game_type`, `min_entry`,  `player_capacity`, `game` FROM `player_table`  where `table_id`='"+tableid+"'",function(er,result_table,fields)  
				{ 
				    if(er){
					console.log(er);
					}else{
						if(result_table.length!=0)
						{ 
							room.tables[table_index].table_name = result_table[0].table_name;
							room.tables[table_index].table_point_value = 0; //result_table[0].point_value;
							room.tables[table_index].table_min_entry = result_table[0].min_entry;
							room.tables[table_index].table_game = result_table[0].game;
							room.tables[table_index].chip_type = result_table[0].game == "Free Game" ? "free" : "real";
							room.tables[table_index].game_type = result_table[0].game_type;
							room.tables[table_index].playerCapacity = result_table[0].player_capacity; 
							console.log("\n ----------------------player_capacity -------------------"+room.tables[table_index].playerCapacity);
						}
					}
				});
				
				if (room.tables[table_index].players.length == 0) 
				{
					if(playername){
					  socket.broadcast.emit('player_connecting_to_table',playername,tableid,btn_clicked);
					}else{
					  console.log("\n player_connecting_to_table====error==791");
					}
				}
				else if (room.tables[table_index].players.length == 1) 
				{
					if (room.tables[table_index].players[0].name != playername) 
					{ 
						if(room.tables[table_index].user_click[0] == btn_clicked)
						{
						   if(room.tables[table_index].players[0].name != ''){
							socket.emit('sit_not_empty',room.tables[table_index].players[0].name,btn_clicked,tableid);
							}else{
								 console.log("\n sit_not_empty====error==803");
							}					
						}
						else if(room.tables[table_index].user_click[1] == btn_clicked)
						{
							if(room.tables[table_index].players[0].name != ''){
							   socket.emit('sit_not_empty',room.tables[table_index].players[0].name,btn_clicked,tableid);
							}else{
								 console.log("\n sit_not_empty====error==811");
							}						
						}
						else
						{
							if(playername){
							socket.broadcast.emit('player_connecting_to_table',playername,tableid,btn_clicked);
							}else{
								 console.log("\n player_connecting_to_table====error==819");
							}
						}
					}
				}
					
				//socket.broadcast.emit('player_connecting_to_table',playername,tableid,btn_clicked);
				
			});

			socket.on('player_not_connecting_to_table', function(playername,tableid,btn_clicked)
			{
				var table_index =0;
					table_index = getTableIndex(room.tables,tableid);
					if (table_index == - 1) {
						console.log("\n player_not_connecting_to_table");
						return;	
					}		
					if (room.tables[table_index].players.length == 0) 
						{
							if(playername){
							socket.broadcast.emit('player_not_connecting_to_table',playername,tableid,btn_clicked);
							}else{
									 console.log("\n player_not_connecting_to_table====error==842");
							}
						}
						else if (room.tables[table_index].players.length == 1) 
						{
							if (room.tables[table_index].players[0].name != playername) 
							{ 
								if(room.tables[table_index].user_click[0] != btn_clicked)
								{
									if(playername){
										  socket.broadcast.emit('player_not_connecting_to_table',playername,tableid,btn_clicked);		
									   }else{
										console.log("\n player_not_connecting_to_table====error==854");
									  }
								}
								else if(room.tables[table_index].user_click[1] != btn_clicked)
								{
									if(playername){
									   socket.broadcast.emit('player_not_connecting_to_table',playername,tableid,btn_clicked);	
									}else{
										console.log("\n player_not_connecting_to_table====error==863");
									}						
								}
							}
						}
					//socket.broadcast.emit('player_not_connecting_to_table',playername,tableid,btn_clicked);
			});
   
			socket.on('user_opened_join_group', function(username,grpid)
			{
				var player;
				var open_data;
				var temp_arr = [];
				var open_id = 0;
				var open_path = "";
				var open_data_arr;
				var table_index =0;
				table_index = getTableIndex(room.tables,grpid);
				if (table_index == - 1) {
					console.log("\n user_opened_join_group");
					table = new Table(grpid);
					room.addTable(table);
					table_index = getTableIndex(room.tables,grpid);
				}
				
				console.log("\n ---- user_opened_join_group "+used+username+grpid+"---"+room.tables[table_index].usernames.toString() +room.tables[table_index].player_gender.toString());
				if(username!==null || username===undefined || username!="")
					{
						if(room.tables[table_index].usernames.length>0)// && group_rooms.length>0)
						{
							if(room.tables[table_index].usernames.length == 1)
							{
								if(room.tables[table_index].usernames[0]!=username)// && group_rooms[0]==grpid)
								{ 
									 if (room.tables[table_index].players.length == 1) 
									{
											console.log("------ name array size  1 --- table player count (1) --> "+room.tables[table_index].players.length);
											if(room.tables[table_index].usernames[0]){
											 socket.emit('user1_join_group_check',room.tables[table_index].usernames[0],room.tables[table_index].user_click[0],grpid,room.tables[table_index].player_gender[0],room.tables[table_index].player_amount[0],restart_game);
											}else{
											 console.log("\n user1_join_group_check====error==900");
											}					 
								    }else{
									   console.log("------ name array size  1 --- table player count(2) -->  "+room.tables[table_index].players.length);
										if (room.tables[table_index].players.length == 2) 
										{
										console.log("checking if player was playing game IN user_opened_join_group");
										if (room.tables[table_index].players[0].name == username)
										{ 
											console.log("1 is there , oth pl ");
											if((room.tables[table_index].players[0].status) == "disconnected")
											{
												console.log(" found player 0th position ");
												room.tables[table_index].players[0].id = socket.id;

												socket.username = username;
												socket.tableid = grpid;
												socket.gender = room.tables[table_index].player_gender[0];
												socket.btn_clicked = room.tables[table_index].user_click[0];

												room.tables[table_index].players[0].status = "playing";
												room.tables[table_index].players[0].player_reconnected = true;

												room.addPlayer(room.tables[table_index].players[0]);
												if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												{
				                                  socket.broadcast.emit('other_player_reconnected',username,room.tables[table_index].id,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[0],room.tables[table_index].players[1].name);
												}else{
												  console.log("\n other_player_reconnected====error==931");
												}	
												if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												{
													socket.emit('player_reconnected',username,room.tables[table_index].id,room.tables[table_index].user_click[1],room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].name,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[1]);	
												}else{
												  console.log("\n user1_join_group_check====error==900");
												}
												console.log("\n tbl open card length "+room.tables[table_index].open_card_obj_arr.length+" -data -"+JSON.stringify(room.tables[table_index].open_card_obj_arr));

												
												if(room.tables[table_index].open_card_status == "discard")
												{
													if(room.tables[table_index].open_card_obj_arr.length==0)
													{
														open_id = 0;
														open_path ="";
														open_data_arr = [];
													}
													else
													{
														temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
														open_data = temp_arr;
														open_id = open_data.id;
														open_path =open_data.card_path;
														open_data_arr = open_data;
													}
												}
												else {
												
													if(room.tables[table_index].open_card_obj_arr.length==0)
													{
														open_id = 0;
														open_path ="";
														open_data_arr = [];
													}
													else
													{
														open_data = room.tables[table_index].open_card_obj_arr[0];
														open_id = open_data.id;
														open_path =open_data.card_path;
														open_data_arr = open_data;
													}
													
												}
												
									 
												console.log("\n open data "+JSON.stringify(open_data));
												if(room.tables[table_index].players[0].is_grouped == false)
												{
													if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												   {
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[0].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[1].name,open_close_pick_count:room.tables[table_index].players[0].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[0].is_grouped,is_finish:room.tables[table_index].players[0].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[0].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
													}
												}
												else
												{
												   if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												   {
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[0].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[1].name,open_close_pick_count:room.tables[table_index].players[0].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[0].is_grouped,is_finish:room.tables[table_index].players[0].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[0].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
													
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:username,group:room.tables[table_index].id,round_id:room.tables[table_index].round_id,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
												   }
												}
											}					
										}
										else  if (room.tables[table_index].players[1].name == username)
										{ 
										  console.log("1 is there , 1st pl ");
										  if(room.tables[table_index].players[1]){
											if((room.tables[table_index].players[1].status) == "disconnected")
											{
												console.log(" found player 1st position ");
												room.tables[table_index].players[1].id = socket.id;
												socket.username = username;									
												socket.tableid = grpid;
												socket.gender = room.tables[table_index].player_gender[1];
												socket.btn_clicked = room.tables[table_index].user_click[1];

												room.tables[table_index].players[1].status = "playing";
												room.tables[table_index].players[1].player_reconnected = true;
												
												room.addPlayer(room.tables[table_index].players[1]);

												socket.broadcast.emit('other_player_reconnected',username,room.tables[table_index].id,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[0],room.tables[table_index].players[0].name);	
												
												socket.emit('player_reconnected',username,room.tables[table_index].id,room.tables[table_index].user_click[1],room.tables[table_index].players[1].amount_playing,room.tables[table_index].players[0].name,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[1]);	
												//emit data with open card,close,hand cards,side joker
												console.log("\n tbl open card length "+room.tables[table_index].open_card_obj_arr.length+" -data -"+JSON.stringify(room.tables[table_index].open_card_obj_arr));
												
												
												if(room.tables[table_index].open_card_status == "discard")
												{
													
													if(room.tables[table_index].open_card_obj_arr.length==0)
													{
														open_id = 0;
														open_path ="";
														open_data_arr = [];
													}
													else
													{
														temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
														open_data = temp_arr;
														open_id = open_data.id;
														open_path =open_data.card_path;
														open_data_arr = open_data;
													}
												}
												else 
												{
													if(room.tables[table_index].open_card_obj_arr.length==0)
													{
														open_id = 0;
														open_path ="";
														open_data_arr = [];
													}
													else
													{
														open_data = room.tables[table_index].open_card_obj_arr[0];
														open_id = open_data.id;
														open_path =open_data.card_path;
														open_data_arr = open_data;
													}
												}
												
												console.log("\n open data "+JSON.stringify(open_data));
												if(room.tables[table_index].players[1].id != '' && room.tables[table_index].players[1].id != null && room.tables[table_index].players[1].id != undefined)
												{
													if(room.tables[table_index].players[1].is_grouped == false)
													{
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[1].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[0].name,open_close_pick_count:room.tables[table_index].players[1].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[1].is_grouped,is_finish:room.tables[table_index].players[1].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[1].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
													}
													else
													{
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[1].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[0].name,open_close_pick_count:room.tables[table_index].players[1].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[1].is_grouped,is_finish:room.tables[table_index].players[1].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[1].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
														
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:username,group:room.tables[table_index].id,round_id:room.tables[table_index].round_id,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
													}
												}
											}					
										  }
										}
											if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												{
											  socket.emit('show_game_data',room.tables[table_index].id,room.tables[table_index].players[0].name,room.tables[table_index].players[1].name,room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].amount_playing,room.tables[table_index].user_click[0],room.tables[table_index].user_click[1],room.tables[table_index].player_gender[1],room.tables[table_index].player_gender[0]);
											}
										}
									  }
									 //}//used -1
								
							    }
								
						    }else if(room.tables[table_index].usernames.length == 2)
							{
							//if(usernames[0]!=username )
							if(room.tables[table_index].usernames[0]!=username)// && group_rooms[0]==grpid)
							{ 
							  // if(used ==1)
								//{
								console.log("------ size 2 --- "+room.tables[table_index].players.length);
								if(room.tables[table_index].players[0].name != ''){
								 if (room.tables[table_index].players.length == 1) 
								  {
									socket.emit('user1_join_group_check',room.tables[table_index].usernames[0],room.tables[table_index].user_click[0],grpid,room.tables[table_index].player_gender[0],room.tables[table_index].player_amount[0],restart_game);
								  }	
								  else
								  {
									if (room.tables[table_index].players.length == 2) 
									{
									console.log("checking if player was playing game IN user_opened_join_group");
									if (room.tables[table_index].players[0].name == username)
									{ 
									
									console.log("2 are  there , o match oth pl  ");
										if((room.tables[table_index].players[0].status) == "disconnected")
										{
											console.log(" found player 0th position ");
											room.tables[table_index].players[0].id = socket.id;
											socket.username = username;									
											socket.tableid = grpid;
											socket.gender = room.tables[table_index].player_gender[0];
											socket.btn_clicked = room.tables[table_index].user_click[0];

											room.tables[table_index].players[0].status = "playing";
											room.tables[table_index].players[0].player_reconnected = true;

											room.addPlayer(room.tables[table_index].players[0]);
											
											socket.broadcast.emit('other_player_reconnected',username,room.tables[table_index].id,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[0],room.tables[table_index].players[1].name);
												
											socket.emit('player_reconnected',username,room.tables[table_index].id,room.tables[table_index].user_click[1],room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].name,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[1]);	
											
											console.log("\n tbl open card length "+room.tables[table_index].open_card_obj_arr.length+" -data -"+JSON.stringify(room.tables[table_index].open_card_obj_arr));
											
											
											if(room.tables[table_index].open_card_status == "discard")
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
													open_data = temp_arr;
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											}
											else 
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													open_data = room.tables[table_index].open_card_obj_arr[0];
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											}
											console.log("\n open data "+JSON.stringify(open_data));
											if(room.tables[table_index].players[0].is_grouped == false)
											{
												if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												{
													if(room.tables[table_index].players[1].status == "disconnected")
													{
														
														io.sockets.connected[(room.tables[table_index].players[0].id)].emit('player_disconnected',room.tables[table_index].players[1].name,room.tables[table_index].id);
													}
													
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[0].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[1].name,open_close_pick_count:room.tables[table_index].players[0].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[0].is_grouped,is_finish:room.tables[table_index].players[0].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[0].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
												}
											
											}
											else
											{
												if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												{
													if(room.tables[table_index].players[1].status == "disconnected")
													{
														io.sockets.connected[(room.tables[table_index].players[0].id)].emit('player_disconnected',room.tables[table_index].players[1].name,room.tables[table_index].id);
													}
													
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[0].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[1].name,open_close_pick_count:room.tables[table_index].players[0].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[0].is_grouped,is_finish:room.tables[table_index].players[0].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[0].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
												
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:username,group:room.tables[table_index].id,round_id:room.tables[table_index].round_id,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
												}
											}
										}					
									}
									else  if (room.tables[table_index].players[1].name == username)
									{ 
									console.log("2 are  there , o match 1st pl  " + room.tables[table_index].players[1].status);
										if((room.tables[table_index].players[1].status) == "disconnected")
										{
											console.log(" found player 1st position ");
											room.tables[table_index].players[1].id = socket.id;
											socket.username = username;
											
											socket.tableid = grpid;
											socket.gender = room.tables[table_index].player_gender[1];
											socket.btn_clicked = room.tables[table_index].user_click[1];

											room.tables[table_index].players[1].status = "playing";
											room.tables[table_index].players[1].player_reconnected = true;

											room.addPlayer(room.tables[table_index].players[1]);
											
											socket.broadcast.emit('other_player_reconnected',username,room.tables[table_index].id,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[1],room.tables[table_index].players[0].name);	
											
											socket.emit('player_reconnected',username,room.tables[table_index].id,room.tables[table_index].user_click[1],room.tables[table_index].players[1].amount_playing,room.tables[table_index].players[0].name,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[0]);	
											//emit data with open card,close,hand cards,side joker
											
											console.log("\n tbl open card length "+room.tables[table_index].open_card_obj_arr.length+" -data -"+JSON.stringify(room.tables[table_index].open_card_obj_arr));
											
										
											if(room.tables[table_index].open_card_status == "discard")
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
													open_data = temp_arr;
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											}
											else 
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													open_data = room.tables[table_index].open_card_obj_arr[0];
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											}
											console.log("\n open data "+JSON.stringify(open_data));
											
											if(room.tables[table_index].players[1].is_grouped == false)
											{
												if(room.tables[table_index].players[1].id != '' && room.tables[table_index].players[1].id != null && room.tables[table_index].players[1].id != undefined)
												{
													if(room.tables[table_index].players[0].status == "disconnected")
													{
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit('player_disconnected',room.tables[table_index].players[0].name,room.tables[table_index].id);
													}
													io.sockets.connected[(room.tables[table_index].players[1].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[1].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[0].name,open_close_pick_count:room.tables[table_index].players[1].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[1].is_grouped,is_finish:room.tables[table_index].players[1].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[1].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
												   
											    }
											}
											else
											{
												if(room.tables[table_index].players[1].id != '' && room.tables[table_index].players[1].id != null && room.tables[table_index].players[1].id != undefined)
												{
													if(room.tables[table_index].players[0].status == "disconnected")
													{
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit('player_disconnected',room.tables[table_index].players[0].name,room.tables[table_index].id);
													}
													io.sockets.connected[(room.tables[table_index].players[1].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[1].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[0].name,open_close_pick_count:room.tables[table_index].players[1].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[1].is_grouped,is_finish:room.tables[table_index].players[1].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[1].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
												
													io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:username,group:room.tables[table_index].id,round_id:room.tables[table_index].round_id,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
												}   
											
											}
										}					
									}
									
										socket.emit('show_game_data',room.tables[table_index].id,room.tables[table_index].players[0].name,room.tables[table_index].players[1].name,room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].amount_playing,room.tables[table_index].user_click[0],room.tables[table_index].user_click[1],room.tables[table_index].player_gender[1],room.tables[table_index].player_gender[0]);
									}
								  }
								  }
								// }//used -1
								}
								else if(room.tables[table_index].usernames[1]!=username )
								//else if(usernames[1]!=username && group_rooms[0]==grpid)
								{
								//if(used ==1)
								//{
								console.log("------size --- "+room.tables[table_index].players.length);
								 if (room.tables[table_index].players.length == 1) 
								  {
									if(room.tables[table_index].usernames[1]){
									socket.emit('user1_join_group_check',room.tables[table_index].usernames[1],room.tables[table_index].user_click[1],grpid,room.tables[table_index].player_gender[1],room.tables[table_index].player_amount[1],restart_game);
									}
								  }	
								  else
								  {
									if (room.tables[table_index].players.length == 2) 
									{
									console.log("checking if player was playing game IN user_opened_join_group");
									if (room.tables[table_index].players[0].name == username)
									{ 
									console.log("2 are  there , 1 match oth pl  ");
										if((room.tables[table_index].players[0].status) == "disconnected")
										{
											console.log(" found player 0th position ");
											room.tables[table_index].players[0].id = socket.id;
											socket.username = username;
											
											socket.tableid = grpid;
											socket.gender = room.tables[table_index].player_gender[0];
											socket.btn_clicked = room.tables[table_index].user_click[0];

											room.tables[table_index].players[0].status = "playing";
											room.tables[table_index].players[0].player_reconnected = true;

											room.addPlayer(room.tables[table_index].players[0]);
											if(room.tables[table_index].players[0]){
												socket.broadcast.emit('other_player_reconnected',username,room.tables[table_index].id,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[0],room.tables[table_index].players[1].name);
													
												socket.emit('player_reconnected',username,room.tables[table_index].id,room.tables[table_index].user_click[0],room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].name,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[1]);	
												
												console.log("\n tbl open card length "+room.tables[table_index].open_card_obj_arr.length+" -data -"+JSON.stringify(room.tables[table_index].open_card_obj_arr));
											}
										
											 if(room.tables[table_index].open_card_status == "discard")
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
													open_data = temp_arr;
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											}
											else 
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													open_data = room.tables[table_index].open_card_obj_arr[0];
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											 }
											console.log("\n open data "+JSON.stringify(open_data));
											if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
												{
													if(room.tables[table_index].players[0].is_grouped == false)
												{
													
													if(room.tables[table_index].players[1].status == "disconnected")
													{
														io.sockets.connected[(room.tables[table_index].players[0].id)].emit('player_disconnected',room.tables[table_index].players[1].name,room.tables[table_index].id);
													}
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[0].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[1].name,open_close_pick_count:room.tables[table_index].players[0].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[0].is_grouped,is_finish:room.tables[table_index].players[0].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[0].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
												}
												else
												{
													if(room.tables[table_index].players[1].status == "disconnected")
													{
														io.sockets.connected[(room.tables[table_index].players[0].id)].emit('player_disconnected',room.tables[table_index].players[1].name,room.tables[table_index].id);
													}
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[0].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[1].name,open_close_pick_count:room.tables[table_index].players[0].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[0].is_grouped,is_finish:room.tables[table_index].players[0].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[0].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
													
													io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:username,group:room.tables[table_index].id,round_id:room.tables[table_index].round_id,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
												}
											}
										}					
									}
									else  if (room.tables[table_index].players[1].name == username)
									{ 
									    
										console.log("2 are  there , 1 match 1st pl  : " + room.tables[table_index].players[1].status);
										if((room.tables[table_index].players[1].status) == "disconnected")
										{
											console.log(" found player 1st position ");
											room.tables[table_index].players[1].id = socket.id;
											socket.username = username;
											
											socket.tableid = grpid;
											socket.gender = room.tables[table_index].player_gender[1];
											socket.btn_clicked = room.tables[table_index].user_click[1];

											room.tables[table_index].players[1].status = "playing";
											room.tables[table_index].players[1].player_reconnected = true;

											room.addPlayer(room.tables[table_index].players[1]);
											if(room.tables[table_index].players[1]){
												socket.broadcast.emit('other_player_reconnected',username,room.tables[table_index].id,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[1],room.tables[table_index].players[0].name);	
												
												socket.emit('player_reconnected',username,room.tables[table_index].id,room.tables[table_index].user_click[0],room.tables[table_index].players[1].amount_playing,room.tables[table_index].players[0].name,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[0]);	
												//emit data with open card,close,hand cards,side joker
											}
											console.log("\n tbl open card length "+room.tables[table_index].open_card_obj_arr.length+" -data -"+JSON.stringify(room.tables[table_index].open_card_obj_arr));
											
											
											if(room.tables[table_index].open_card_status == "discard")
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
													open_data = temp_arr;
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											}
											else
											{
												if(room.tables[table_index].open_card_obj_arr.length==0)
												{
													open_id = 0;
													open_path ="";
													open_data_arr = [];
												}
												else
												{
													open_data = room.tables[table_index].open_card_obj_arr[0];
													open_id = open_data.id;
													open_path =open_data.card_path;
													open_data_arr = open_data;
												}
											}
											console.log("\n open data "+JSON.stringify(open_data));
											if(room.tables[table_index].players[1].id != '' && room.tables[table_index].players[1].id != null && room.tables[table_index].players[1].id != undefined)
												{
													if(room.tables[table_index].players[1].is_grouped == false)
													{
														if(room.tables[table_index].players[0].status == "disconnected")
														{
															io.sockets.connected[(room.tables[table_index].players[1].id)].emit('player_disconnected',room.tables[table_index].players[0].name,room.tables[table_index].id);
														}
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[1].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[0].name,open_close_pick_count:room.tables[table_index].players[1].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[1].is_grouped,is_finish:room.tables[table_index].players[1].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[1].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
													}
													else
													{
														if(room.tables[table_index].players[0].status == "disconnected")
														{
															io.sockets.connected[(room.tables[table_index].players[1].id)].emit('player_disconnected',room.tables[table_index].players[0].name,room.tables[table_index].id);
														}
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit("refresh", { group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[1].hand,opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,opp_user:room.tables[table_index].players[0].name,open_close_pick_count:room.tables[table_index].players[1].open_close_selected_count,round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,sidejokername:room.tables[table_index].side_joker_card_name,open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,close_cards:room.tables[table_index].open_cards,is_grouped:room.tables[table_index].players[1].is_grouped,is_finish:room.tables[table_index].players[1].is_player_finished,finish_obj:room.tables[table_index].finish_card_object,is_joined_table:room.tables[table_index].players[1].is_joined_table,dealer:room.tables[table_index].dealer_name,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name});
													
														io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:username,group:room.tables[table_index].id,round_id:room.tables[table_index].round_id,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
												    }
											}
										
										}					
									}
									
										socket.emit('show_game_data',room.tables[table_index].id,room.tables[table_index].players[0].name,room.tables[table_index].players[1].name,room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].amount_playing,room.tables[table_index].user_click[0],room.tables[table_index].user_click[1],room.tables[table_index].player_gender[1],room.tables[table_index].player_gender[0]);
									}
								  }
								 //}//used -1
								}
							}
						} 
						
						
					    con.query("SELECT `table_id`, `table_name`, `game_type`, `min_entry`,  `player_capacity`, `game` FROM `player_table`  where `table_id`='"+grpid+"'",function(er,result_table,fields)  
						{ 
						    if (er) {
								console.log(er);
							} else {
								if(result_table.length!=0)
								{ 
									room.tables[table_index].table_name = result_table[0].table_name;
									room.tables[table_index].table_point_value = result_table[0].point_value;
									room.tables[table_index].table_min_entry = result_table[0].min_entry;
									room.tables[table_index].table_game = result_table[0].game;
									room.tables[table_index].chip_type = result_table[0].game == "Free Game" ? "free" : "real";
									room.tables[table_index].game_type = result_table[0].game_type;
								}
							}
						});
					}
			});

	socket.on('user1_join_group', function(username,userno,grpid,round_no,join_count,amount,gender,browser_type, os_type,player_user_id,is_joined_table)
	{
		var player ;
		var arr = [];
		var random_group_roundno;var player_play_chips,new_chips;//,room.tables[table_index].table_min_entry;
		var play_game = true;// false;
		var tt;
		var group = 0;
		var roundno = 0;
		var player1turn,player2turn=false;
		var turn_of_player;
		var restart_count = 0;
		//var user_id =0;
		var table_index = 0;
		var pl_amount_taken = 0;		
		var cards = [];
		var cards_without_joker = [];
			
		console.log("\n Player "+username+" has joined at seat no "+userno+" with amount "+amount+", player gender "+gender+" , using browser "+browser_type+" joint count "+join_count+" \n");

		if(username!==null || username===undefined)
        {
			table_index = getTableIndex(room.tables,grpid);
			console.log("\n table_index -----"+table_index);
			if (table_index == - 1) {
				console.log("\n user1_join_group");
				table = new Table(grpid);
				room.addTable(table);
				table_index = getTableIndex(room.tables,grpid);
			}
			
			if (room.tables[table_index].players.length == 2)  {
				console.log("\n table_is_full");
				if(username){
				socket.emit('table_is_full',username,grpid);
				}
				return;
			} else {
				for(i = 0; i < room.tables[table_index].user_click.length; i++) {
					if( room.tables[table_index].user_click[i] == userno ) {
						console.log("\n exist player in seat " + userno);
						if(userno){
						  socket.emit('exist_player_seat',room.tables[table_index].usernames[i],grpid, userno);
						}
						return;
					}
				}
			}
            
			if(username){
			socket.emit('takeseat',username,grpid);	
            }			
			
			if(socket.id){
			 // player = new Player(socket.id);
			}
			//socket.username = username;  
			//player.setName(username);	
            player = new Player();
			socket.username = username; 
            var socketid = socket.id;
 			player.setID(socketid);
			player.setName(username);			
			
			room.addPlayer(player);//player added to Socket room
			console.log("pl in room "+room.players.length+"--"+room.players[0].id); 
			
			socket.tableid = grpid;
			socket.gender = gender;
			socket.btn_clicked = userno;

			room.tables[table_index].addPlayer(player); 
			room.tables[table_index].addSocket(socket.id);
			
			if(join_count != 0){
			 pl_amount_taken = amount;
			}else if(join_count == 0){
				if(username == room.tables[table_index].player1_name)
				{pl_amount_taken = room.tables[table_index].player1_amount;}
				else if(username == room.tables[table_index].player2_name)
				{ pl_amount_taken = room.tables[table_index].player2_amount; }
			}
			
			//set player's properties
			console.log("\n %%%%%%% if game restart and player status AFTER JOIN "+player.status);
			player.status = "intable";
			console.log("\n %%%%%%% player status AFTER JOIN "+player.status);
			
			//player.tableID = table.id;////check here and if needed add as room.tables[table_index].id
			player.tableID = room.tables[table_index].id;
			player.setIp(Ip);
			player.setIsp("");
			player.setOS(os_type);
			player.setDevice(device_name);
			player.setBrowser(browser_type);
			player.user_id = player_user_id;
			player.is_joined_table = is_joined_table;
			
			console.log("\n --------------------------- is_joined_table "+is_joined_table);
			
			console.log("\n player.user_id AFTER JOIN "+player.user_id);
			
			if(join_count != 0){
				player.amount_playing = getFixedNumber(amount);
			}
			
			socket.join(socket.room); 
			console.log("\n before add GEN "+JSON.stringify(room.tables[table_index].player_gender));
			room.tables[table_index].player_gender.push(gender);
			console.log("\n after add GEN "+JSON.stringify(room.tables[table_index].player_gender));
			room.tables[table_index].player_amount.push(pl_amount_taken);
			
			room.tables[table_index].user_click.push(userno);
			
			console.log("\n No of players "+room.tables[table_index].usernames.length+" on table:- "+grpid+" and are :- "+room.tables[table_index].usernames.toString());
			if(room.tables[table_index].usernames.length > 0)
			{
				for (var i = 0; i < room.tables[table_index].usernames.length; i++)
				{
					 if(username == room.tables[table_index].usernames[i]) 
					 {
					// socket.emit('disconnect');
						//usernames.splice(i, 1);
					 }
					 else { room.tables[table_index].usernames.push(username);}
				}
			}
			else 
			{ room.tables[table_index].usernames.push(username); }
			console.log("\n After joined , No of players "+room.tables[table_index].usernames.length+" on table:- "+grpid+" and are :- "+room.tables[table_index].usernames.toString()+"--"+room.tables[table_index].players.toString());
			console.log("\n table details "+room.tables[table_index].players[0].name+" "+room.tables[table_index].players[0].id+"---"+player.id);
			
			/* Game has restarted , check no of players connected before game start **/
			if(join_count == 0)
			{
			   console.log("Game has started again - "+room.tables[table_index].readyToPlayCounter+" check tbl length "+room.tables[table_index].players.length);
				if (room.tables[table_index].players.length == 2) 
				{
					console.log("2 players exist , checking are same as previously playing ");		
						if (room.tables[table_index].players[0].id == player.id)
							{
								room.tables[table_index].readyToPlayCounter++;
							}
						 else if (room.tables[table_index].players[1].id == player.id)
							{
								room.tables[table_index].readyToPlayCounter++;
							}
				} 
				console.log("No of players after restart game checked :"+room.tables[table_index].readyToPlayCounter);
			   if (room.tables[table_index].players.length == 1) 
				{
					if (room.tables[table_index].players[0].name == username)
						{
							 join_count = 1;
							 restart_count = 1;
							  playing_again = true;
						}
						else if (room.tables[table_index].players[1].name == username)
						{
							join_count = 1;
							restart_count = 1;
							 playing_again = true;
						}
				}
				if(room.tables[table_index].readyToPlayCounter == 2 )
				{ join_count = 2; }
				
				if(join_count == 2)
				{ restart_game = true; }
				console.log("join count after game restarted "+join_count+" so is restart game :- "+restart_game);
			}////join_count == 0 (game_restart) ends
			
		///////////////////////////////////////////////////
			
			
		//check according to player balance is he/she able to play game or not
		// if(restart_game == true || playing_again ==true)
		 if(restart_game == true)
		{
						room.tables[table_index].players[0].amount_playing = getFixedNumber(room.tables[table_index].player1_amount);
						room.tables[table_index].players[1].amount_playing = getFixedNumber(room.tables[table_index].player2_amount); 
						
			
			        var check_amount_for_restart=room.tables[table_index].table_min_entry * 4;
					
			        if(room.tables[table_index].players[0].amount_playing >= check_amount_for_restart){
						play_game = true;
					}else{
					    play_game = false;
                    }
			
					

		
					if(room.tables[table_index].players[1].amount_playing >= (room.tables[table_index].table_min_entry*4))
					{
					  play_game = true;
					}
					else
					{
					  play_game = false;

					}
						
					
					
			}
		
		var table_game = room.tables[table_index].table_game;
		console.log("Check Player's ("+username+") balance before game start / restart ");
		//check whether entered amount is greater than table min entry 
		if(play_game == true)
		{
		 console.log("Player "+username+" has sufficient balance and can play game "+"\n");
		   //update account balance (play_chips) of player after joined table 
		   //if(restart_game != true || playing_again !=true)
		   if(restart_game != true && playing_again !=true)
		   {
		   
			 con.query("SELECT `play_chips`,`real_chips` FROM `accounts` where username='"+username+"'",function(er,result,fields)  
			{
                if (er) {
								console.log(er);
							} else {			
					if(result.length!=0)
					{
							if(table_game == 'Free Game')
							{
							 player_play_chips = result[0].play_chips;
							 if(player_play_chips>0 && player_play_chips > pl_amount_taken || player_play_chips == pl_amount_taken)
								{
									
										new_chips = player_play_chips - pl_amount_taken;
										var update_amount = "UPDATE accounts SET play_chips = "+new_chips+" where username='"+username+"'";
										con.query(update_amount, function (err, result) {
										if (err) {console.log(err);}
										else {console.log(result.affectedRows + " record(s) after play chips (free game) update of "+username);}
										});
								}
							 }//if free game
							if(table_game == 'Cash Game')
							{
							   player_play_chips = result[0].real_chips;
							 if(player_play_chips >0 && player_play_chips > pl_amount_taken || player_play_chips == pl_amount_taken)
								{
									new_chips = player_play_chips - pl_amount_taken;
									var update_amount = "UPDATE accounts SET real_chips = "+new_chips+" where username='"+username+"'";
									con.query(update_amount, function (err, result) {
									if (err) {console.log(err);}
									else {console.log(result.affectedRows + " record(s) after real chips (paid game) update of "+username);}
									});
								}
							 }
					}
				}
			}); 
		  }
		}else{
			
		  console.log("Emit :- Player "+username+" don't have sufficient balance , so can not play game."+"\n");
		
		}
		
		///////////////////////////////////////////////////
		
			console.log(" after joined Updating database - player "+username+" join to which table");
			
			con.query("SELECT `user_id` FROM `user_tabel_join` where username='"+username+"' and joined_table ='"+grpid+"'",function(er,result,fields)  
			{ 
			
			    if (er) {
					console.log(er);
				} else {
					if(result.length==0)
					{
						var qry1= "SELECT user_id FROM `users`  where `username` ='"+username+"' ";		
						con.query(qry1, function(err, user, userfields)
						{
							if(err){
							console.log("==========Error======="+qry1);
							}else{
								console.log(qry1);
								if(user.length!=0)
								{
									user_id=user[0].user_id;
									console.log("user id"+user_id);
									var query="insert into user_tabel_join( `user_id`,`username`,`game_type`,`chip_type`,`player_capacity`, `joined_table`,`amount_to_revert`,`min_entry`) values('"+user_id+"','"+username+"','"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].playerCapacity+"','"+grpid+"','"+pl_amount_taken+"','"+room.tables[table_index].table_min_entry+"')";
									con.query(query, function(err1, result)
									{
										if (err1) {
											console.log(err1);
										}
										
									});
									
								}
							}
						});
						
					}
				}
			});	

            if(join_count==1)
			{
				console.log("\n JOIN COUNT 1 username  "+username+" sit no "+userno+" grp id "+grpid);	
				console.log("A player "+username+" has joined (join_count = 1 ) , waiting for another player .");
				console.log("Player "+username+" status: "+player.status+"\n");
				room.tables[table_index].activity_timer = -1;
				if(restart_count !=1){
				
				if(username){
					socket.broadcast.emit('user1_join_group',username,userno,grpid,round_no,room.tables[table_index].activity_timer,pl_amount_taken,gender,playing_again,0, 0, 0);//,restart_game);
					socket.emit('user1_join_group',username,userno,grpid,round_no,room.tables[table_index].activity_timer,pl_amount_taken,gender,playing_again,0, 0, 0);//,restart_game);
				}
				
				}
				
				console.log("Player CNT "+room.tables[table_index].connectedSocket()+"\n");
				if(restart_count ==1 && room.tables[table_index].connectedSocket() == 1 /*ANDY && clients_connected.length ==1 */)
				{
				console.log(" \n game restart but only 1 player ");
				    if(username){
					   socket.broadcast.emit('user1_join_group_check_watch',username,userno,grpid,gender,pl_amount_taken,false);
					}
					if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
					{
					  io.sockets.connected[(room.tables[table_index].players[0].id)].emit('user1_join_group_check',username,userno,grpid,gender,pl_amount_taken,false);
					}
					if(room.tables[table_index].players[0].name == room.tables[table_index].player1_name)
					    {
							room.tables[table_index].players[0].amount_playing = getFixedNumber(room.tables[table_index].player1_amount);
							room.tables[table_index].players[0].game_status = room.tables[table_index].player1_game_status;
							room.tables[table_index].players[0].user_id = room.tables[table_index].player1_user_id;
						}
						else if(room.tables[table_index].players[0].name == room.tables[table_index].player2_name)
						{
							room.tables[table_index].players[0].amount_playing = getFixedNumber(room.tables[table_index].player2_amount); 
							room.tables[table_index].players[0].game_status = room.tables[table_index].player2_game_status;
							room.tables[table_index].players[0].user_id = room.tables[table_index].player2_user_id;
						}
				}
				console.log("before ++  No of players:-  in join-1 "+room.tables[table_index].readyToPlayCounter);
				
				room.tables[table_index].readyToPlayCounter++;
				
				console.log("on Table:"+grpid+" No of players:-  in join-1 "+room.tables[table_index].readyToPlayCounter+" no_of_players_joined "+room.tables[table_index].no_of_players_joined+"\n");
			}
			else if(join_count==2)
			{
				console.log("\n 2nd player "+username+" has joined to global.table "+grpid+" (join_count = 2)"+" restart_game "+restart_game);	
				var temp_count = 5;
				
				
				console.log("\n no_of_players_joined "+room.tables[table_index].no_of_players_joined+" No of players before join 2 :- "+room.tables[table_index].readyToPlayCounter+"\n");
				
				if(restart_game == false){
					room.tables[table_index].readyToPlayCounter++;no_of_players_joined=0;}
				    console.log("on Table:"+grpid+"  after join 2  No of players:- "+room.tables[table_index].readyToPlayCounter+"\n");
				
				if(room.tables[table_index].readyToPlayCounter == 2)
				{
					//cards without joker for turn
					con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards` where `id` < 53",function(er,result,fields)  
					{  
						cards_without_joker.push.apply(cards_without_joker, result); 
					});	

					con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards`", function(err1, rows, fields1) 
					{ 
					    if (err1) {
							console.log(err1);
						} else {
						cards.push.apply(cards, rows); 
						}
					}); 

					console.log("\n cards length "+cards.length);
				
					console.log("In Join-2 on Table:"+grpid+" No of players:- "+room.tables[table_index].readyToPlayCounter);
					console.log("and are : "+room.tables[table_index].players[0].name+","+room.tables[table_index].players[1].name +"\n");
					
					//random_group_roundno = Math.floor(Math.random() * 100);//2-digit-no
					//random_group_roundno =  Math.floor(100000 + Math.random() * 900000);//6-digit-no
					random_group_roundno =  Math.floor(100000000 + Math.random() * 900000000);//6-digit-no
					//room.tables[table_index].activity_timer = 10;
					room.tables[table_index].activity_timer = room.tables[table_index].timer_array[0];
					/** Note: change this value according to activity timer**/
					room.tables[table_index].activity_timer_client_side_needed= room.tables[table_index].timer_array[0];
					console.log("Game will start after "+room.tables[table_index].activity_timer+" seconds"+"\n");
					console.log('restart_game'+restart_game);
					
					if(restart_game == true)
					{
						for (var i = 0; i < room.tables[table_index].players.length; i++)
						 {
						 	var sql_amt = "UPDATE user_tabel_join SET round_id = '0' , amount_to_revert = '"+room.tables[table_index].players[i].amount_playing+"' where username='"+room.tables[table_index].players[i].name+"' and joined_table ='"+grpid+"'";
							con.query(sql_amt, function (err, result) {
							console.log(sql_amt);
							if (err) throw err;
							else {
							console.log(result.affectedRows + " record(s) updated in user table join");}
							});
						 }
						if(room.tables[table_index].players[0].name == room.tables[table_index].player1_name)
					    {
							room.tables[table_index].players[0].amount_playing = getFixedNumber(room.tables[table_index].player1_amount);
							room.tables[table_index].players[0].game_status = room.tables[table_index].player1_game_status;
							room.tables[table_index].players[0].user_id = room.tables[table_index].player1_user_id;
						}
						else if(room.tables[table_index].players[0].name == room.tables[table_index].player2_name)
						{
							room.tables[table_index].players[0].amount_playing = getFixedNumber(room.tables[table_index].player2_amount); 
							room.tables[table_index].players[0].game_status = room.tables[table_index].player2_game_status;
							room.tables[table_index].players[0].user_id = room.tables[table_index].player2_user_id;
						}
						if(room.tables[table_index].players[1].name == room.tables[table_index].player1_name)
					    {
							room.tables[table_index].players[1].amount_playing = getFixedNumber(room.tables[table_index].player1_amount);
							room.tables[table_index].players[1].game_status = room.tables[table_index].player1_game_status;
							room.tables[table_index].players[1].user_id = room.tables[table_index].player1_user_id;
						}
						else if(room.tables[table_index].players[1].name == room.tables[table_index].player2_name)
						{
							room.tables[table_index].players[1].amount_playing = getFixedNumber(room.tables[table_index].player2_amount); 
							room.tables[table_index].players[1].game_status = room.tables[table_index].player2_game_status;
							room.tables[table_index].players[1].user_id = room.tables[table_index].player2_user_id;
						}
						if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
						{
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_amount",room.tables[table_index].players[0].name,grpid,room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].name,room.tables[table_index].players[1].amount_playing);
						}
						if(room.tables[table_index].players[1].id != '' && room.tables[table_index].players[1].id != null && room.tables[table_index].players[1].id != undefined)
						{
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_amount",room.tables[table_index].players[1].name,grpid,room.tables[table_index].players[1].amount_playing,room.tables[table_index].players[0].name,room.tables[table_index].players[0].amount_playing);
						}
						if(room.tables[table_index].players[0].name){
						 socket.broadcast.emit("update_amount_other",room.tables[table_index].players[0].name,grpid,room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].name,room.tables[table_index].players[1].amount_playing);
						}
					}
					  
					   
				    room.tables[table_index].round_id = random_group_roundno;
					console.log("\n"+"Round id generated for table "+grpid+" is: "+random_group_roundno+" (table.round_id) is "+room.tables[table_index].round_id);
					
					console.log("\n ********** GAME RESTART "+restart_game+" -- room.tables[table_index].restart_timer -- "+room.tables[table_index].restart_timer+"--room.tables[table_index].activity_timer--"+room.tables[table_index].activity_timer);
					clearInterval(room.tables[table_index].game_countdown); 
					room.tables[table_index].activity_timer = room.tables[table_index].timer_array[0];
					room.tables[table_index].restart_timer = false;
					
					console.log("\n check room.tables[table_index].restart_timer -- "+room.tables[table_index].restart_timer+"--room.tables[table_index].activity_timer--"+room.tables[table_index].activity_timer);
					
					room.tables[table_index].game_countdown = setInterval(function()
					{
						var pl_name ,pl_IP ,pl_Isp, pl_OS, pl_device_name, pl_sock, pl_browser;
						var startingPlayerID ;
						var startingPlayerName ;
						var query;
						var p1_handcards = [];var p2_handcards = [];var closecards = [];
						var opp_pl_name ;
						
						
						var table_index = getTableIndex(room.tables,grpid);
						if (table_index == - 1) {
							console.log("GameCountDown Failed");
							return;
						}
				
					 	if(room.tables[table_index].restart_timer == true)
						{
							room.tables[table_index].activity_timer = room.tables[table_index].timer_array[0];
							clearInterval(room.tables[table_index].game_countdown);
							room.tables[table_index].restart_timer = false;
						}
						 
						 
					  	if (room.tables[table_index].players.length == 2) 
					  	{
						    if(room.tables[table_index].players[0].name){
					  		   socket.broadcast.emit('show_game_data',room.tables[table_index].id,room.tables[table_index].players[0].name,room.tables[table_index].players[1].name,room.tables[table_index].players[0].amount_playing,room.tables[table_index].players[1].amount_playing,room.tables[table_index].user_click[0],room.tables[table_index].user_click[1],room.tables[table_index].player_gender[0],room.tables[table_index].player_gender[1]);
					        }
							if(username){
									if(room.tables[table_index].players[1].status != "disconnected"){
										if(room.tables[table_index].players[1].id != '' && room.tables[table_index].players[1].id != null && room.tables[table_index].players[1].id != undefined)
						                {
											if(restart_game != true)
											{
												io.sockets.connected[(room.tables[table_index].players[1].id)].emit('user1_join_group',username,userno,grpid,random_group_roundno,room.tables[table_index].activity_timer,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[0],restart_game,room.tables[table_index].activity_timer_client_side_needed,is_joined_table, room.tables[table_index].players[0].name, room.tables[table_index].players[0].amount_playing);
											}
											else
											{
												io.sockets.connected[(room.tables[table_index].players[1].id)].emit('user1_join_group',username,userno,grpid,random_group_roundno,room.tables[table_index].activity_timer,room.tables[table_index].players[1].amount_playing,room.tables[table_index].player_gender[0],restart_game,room.tables[table_index].activity_timer_client_side_needed,is_joined_table, room.tables[table_index].players[0].name, room.tables[table_index].players[0].amount_playing );
											}
										}
									}
									if(room.tables[table_index].players[0].status != "disconnected"){
										if(room.tables[table_index].players[0].id != '' && room.tables[table_index].players[0].id != null && room.tables[table_index].players[0].id != undefined)
						                {
											if(restart_game != true)
											{
											//console.log("\n if 0 restart_game "+restart_game);
											  if(room.tables[table_index].players[0].id){
												io.sockets.connected[(room.tables[table_index].players[0].id)].emit('user1_join_group',username,userno,grpid,random_group_roundno,room.tables[table_index].activity_timer,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[1],restart_game,room.tables[table_index].activity_timer_client_side_needed,is_joined_table, room.tables[table_index].players[1].name, room.tables[table_index].players[1].amount_playing);
											  }
											}
											else
											{
											//console.log("\n else 0 restart_game "+restart_game);
											   if(room.tables[table_index].players[0].id){
												io.sockets.connected[(room.tables[table_index].players[0].id)].emit('user1_join_group',username,userno,grpid,random_group_roundno,room.tables[table_index].activity_timer,room.tables[table_index].players[0].amount_playing,room.tables[table_index].player_gender[1],restart_game,room.tables[table_index].activity_timer_client_side_needed,is_joined_table, room.tables[table_index].players[1].name, room.tables[table_index].players[1].amount_playing );
											   }
											}
										}
									}
							}
							console.log("Activity_timer :"+room.tables[table_index].activity_timer);
	
							room.tables[table_index].activity_timer--;
							restart_game = false;
						 
							if (room.tables[table_index].activity_timer == 0) 
							{	
								for (var i = 0; i < room.tables[table_index].players.length; i++)
								{
									var sql_amt = "UPDATE user_tabel_join SET round_id = '"+room.tables[table_index].round_id+"' , amount_to_revert = '"+room.tables[table_index].players[i].amount_playing+"' where username='"+room.tables[table_index].players[i].name+"' and joined_table ='"+grpid+"'";
									con.query(sql_amt, function (err, result) {
									console.log(sql_amt);
									if (err) throw err;							
									else {
									console.log(result.affectedRows + " record(s) updated after player left group");}
									});
								}
								//as 2 players connected change table status from 'available' to 'unavailable'
								room.tables[table_index].status = "unavailable";
								console.log("table "+grpid+" status: "+room.tables[table_index].status+"\n");
								//as 2 players connected change player status from 'intable' to 'playing'
								for (var i = 0; i < room.tables[table_index].players.length; i++)
								{
									room.tables[table_index].players[i].status = "playing";
									console.log("Player "+room.tables[table_index].players[i].name+" status: "+room.tables[table_index].players[i].status);
								}
						
					 
								/** Exchange players position and gender data **/
								/* temp_click = user_click[0];
								user_click[0] = user_click[1];
								user_click[1] = temp_click; 
							
								temp_gender = player_gender[0];
								player_gender[0] = player_gender[1];
								player_gender[1] = temp_gender; */
								
								//console.log("\n after swap sit array ---> "+user_click.toString());
								console.log("Activity_timer =="+room.tables[table_index].activity_timer+" So game will start now."+"\n");
								clearInterval(room.tables[table_index].game_countdown);  
							
							 
								/*************** GAME RESTART CLEAR ALL DATA ***********/
								clear_all_data_before_game_start(room.tables[table_index]);
								//restart_game = false;
								/* con.query("SELECT * FROM `cards`", function(err1, rows, fields1) 
								{ 
									cards.push.apply(cards, rows); 
								}); */
								/*************** GAME RESTART CLEAR ALL DATA ***********/
								
								console.log("Comparing 2 random cards assigned to each player to Decide TURN"+"\n");
								//assign turn card to user1
								var card1 = drawImages((shuffleImages(cards_without_joker)), 1, "", 1);
								console.log("Card assigned to player 1- "+room.tables[table_index].players[0].name+" is "+card1[0].card_path);
								//assign turn card to user2
								var card2 = drawImages((shuffleImages(cards_without_joker)), 1, "", 1);
								console.log("Card assigned to player 2- "+room.tables[table_index].players[1].name+" is "+card2[0].card_path+"\n");
							
								if(card2.length>0 && card1.length>0)
								{
									console.log("turn card name 1st"+card1[0].name+" 2nd "+card2[0].name);
									console.log("turn card points 1st"+card1[0].points+" 2nd "+card2[0].points);
									console.log("turn card sub_id 1st"+card1[0].sub_id+" 2nd "+card2[0].sub_id);
									if(card2[0].name!=card1[0].name)
									{
										if(card2[0].points>card1[0].points)
										{
											startingPlayerID = room.tables[table_index].players[1].id;
											startingPlayerName = room.tables[table_index].players[1].name;
										}
										else {
										startingPlayerID = room.tables[table_index].players[0].id;
										startingPlayerName = room.tables[table_index].players[0].name;
										}
									}
									else
									{
										if(card2[0].sub_id>card1[0].sub_id)
										{
											startingPlayerID = room.tables[table_index].players[1].id;
											startingPlayerName = room.tables[table_index].players[1].name;
										}
										else {
										startingPlayerID = room.tables[table_index].players[0].id;
										startingPlayerName = room.tables[table_index].players[0].name;
										}
									}
								}

								room.tables[table_index].startingPlayerID = startingPlayerID;
								room.tables[table_index].startingPlayerName = startingPlayerName;
								if (room.tables[table_index].players[0].id == startingPlayerID)
								{ 
									room.tables[table_index].dealer_name = room.tables[table_index].players[1].name;
									console.log("\n"+"Player 1 "+room.tables[table_index].players[0].name+"has TURN");
								}
								if (room.tables[table_index].players[1].id == startingPlayerID)
								{ 
									room.tables[table_index].dealer_name = room.tables[table_index].players[0].name;
									console.log("\n"+"Player 2 "+room.tables[table_index].players[1].name+"has TURN"); 
								}	 
								////assign 13 hand cards to player 1 
								room.tables[table_index].players[0].hand = drawImages((shuffleImages(cards)), 13, "", 1);
								console.log("\n"+"Player 1 "+room.tables[table_index].players[0].name+" hand cards count "+ room.tables[table_index].players[0].hand.length);
								console.log("Player 1 "+room.tables[table_index].players[0].name+" hand cards :"+JSON.stringify(room.tables[table_index].players[0].hand));
								for (var i = 0; i < room.tables[table_index].players[0].hand.length; i++)
								{
									p1_handcards.push(room.tables[table_index].players[0].hand[i].id);
								}
				
								////assign 13 hand cards to player 2 
							
								room.tables[table_index].players[1].hand = drawImages((shuffleImages(cards)), 13, "", 1);
								console.log("\n"+"Player 2 "+room.tables[table_index].players[1].name+" hand cards count "+ room.tables[table_index].players[1].hand.length);
								console.log("Player 2 "+room.tables[table_index].players[1].name+" hand cards: "+JSON.stringify(room.tables[table_index].players[1].hand));
								for (var i = 0; i < room.tables[table_index].players[1].hand.length; i++)
								{
									p2_handcards.push(room.tables[table_index].players[1].hand[i].id);
								}
								////assign open card to both players
								var player1_opencard = drawImages((shuffleImages(cards)), 1, "", 1);
									console.log("\n"+"Assigned Open card is: "+player1_opencard[0].card_path+" id is: "+player1_opencard[0].id);
								var player_open_card_id = ''//player1_opencard[0].id;
								//room.tables[table_index].open_cards.push({id:(player1_opencard[0].id),path:(player1_opencard[0].card_path)});
								//room.tables[table_index].open_cards.push(player1_opencard);
								room.tables[table_index].open_cards=player1_opencard;
								room.tables[table_index].open_card_obj_arr = [];
								room.tables[table_index].open_card_obj_arr.push(player1_opencard);
								room.tables[table_index].open_card_status = "initial";
								//room.tables[table_index].open_card_obj_arr.push=player1_opencard;
								
								////assign joker card to both players
								//drawImages(all_images, amount, hand, initial)
								var joker_card = drawImages((shuffleImages(cards)), 1, "", 1);
								
									console.log("Assigned Side-Joker card is: "+joker_card[0].card_path);
									console.log("Assigned Side-Joker card name is: "+joker_card[0].name);
									room.tables[table_index].side_joker_card = joker_card[0].card_path;
									room.tables[table_index].side_joker_card_name = joker_card[0].name;
									
								var joker_qry = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where points = 0 or points = "+joker_card[0].points+" and id not in ("+joker_card[0].id+")";
								if( joker_card[0].points == 0 ) {
									joker_qry = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where points = 0 or points = 14 and id not in ("+joker_card[0].id+")";
								}
								con.query(joker_qry,function(er,result,fields)  
								{ 
								
								    if (er) {
										console.log(er);
									} else {
													//console.log("Joker Cards are: 1 " +JSON.stringify(joker_cards));
										joker_cards = [];
										joker_cards.push.apply(joker_cards,result); 
										//console.log("Joker Cards are: 2 " +JSON.stringify(joker_cards));
										room.tables[table_index].joker_cards.push.apply(room.tables[table_index].joker_cards,joker_cards);
										console.log("===================table.joker_cards===================== "+JSON.stringify(room.tables[table_index].joker_cards));
									}
								
								});	

                             //=============Papplu joker===============
								 var papplusuitid='';
								  var papplusuit='';
								  if(joker_card[0].suit_id == 13){
								    papplusuitid=1;
									 papplusuit=joker_card[0].suit;
								  } else if(joker_card[0].suit_id == 0){
								   papplusuitid=2;
								   papplusuit='S';
								  }else{
								   papplusuitid=joker_card[0].suit_id+1;
								    papplusuit=joker_card[0].suit;
								  }
								var papplu_joker_qry = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where  suit_id = "+papplusuitid+" and suit = '"+papplusuit+"'";
								console.log("=========================table.papplu_joker_qry ====================================="+papplu_joker_qry);
								con.query(papplu_joker_qry,function(er,result,fields)  
								{ 
								     if (er) {
										console.log(er);
									} else {
										room.tables[table_index].papplu_joker_card = result[0].card_path;
										room.tables[table_index].papplu_joker_card_name = result[0].name;
										room.tables[table_index].papplu_joker_card_id = result[0].id;
										console.log("=========================table.Papplujoker_cards in user join func ====================================="+room.tables[table_index].papplu_joker_card);
										
										
										joker_cards.push.apply(joker_cards,result); 
										//console.log("Joker Cards are: 2 " +JSON.stringify(joker_cards));
										room.tables[table_index].joker_cards.push.apply(room.tables[table_index].joker_cards,joker_cards);
										console.log("===================table.papplu=====joker_cards===================== "+JSON.stringify(room.tables[table_index].joker_cards));
									}
								});	
																
								
								
								var joker_qry1 = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where points = 0 ";
								con.query(joker_qry1,function(er,result,fields)  
								{ 
								     if (er) {
										console.log(er);
									} else {
										//joker_cards.push.apply(joker_cards,result); 
										room.tables[table_index].pure_joker_cards.push.apply(room.tables[table_index].pure_joker_cards,result);
										console.log("table.pure_joker_cards "+JSON.stringify(room.tables[table_index].pure_joker_cards));
								    }
								
								});		
								
								var close_card_count = 106 - 2 - 13 * 2;
								////assign closed cards to both players
								var closed_cards = drawImages((shuffleImages(cards)), close_card_count, "", 1);
									console.log("\n"+"Assigned closed cards count "+ closed_cards.length);
									console.log("Assigned closed cards: ");
								for (var i = 0; i < closed_cards.length; i++)
									{
										closecards.push(closed_cards[i].id);
										room.tables[table_index].closed_cards_arr.push(closed_cards[i]);
										}
									//console.log("\n table close cards array "+JSON.stringify(room.tables[table_index].closed_cards_arr));
								console.log("\n"+"Inserting player and assigned card details to database."+"\n");
								//inserting player details and card details to database  
								group = grpid;
								roundno = random_group_roundno;
								for (var i = 0; i < room.tables[table_index].players.length; i++)
								{
									pl_name = (room.tables[table_index].players[i].name);
									pl_IP = (room.tables[table_index].players[i].getIp());
									pl_Isp = (room.tables[table_index].players[i].getIsp());
									pl_OS = (room.tables[table_index].players[i].getOS());
									pl_device_name = (room.tables[table_index].players[i].getDevice());
									pl_sock  = (room.tables[table_index].players[i].id);
									pl_browser = (room.tables[table_index].players[i].getBrowser());
									
									if(i==0)
									{
										query="insert into game_details(`user_id`, `group_id`, `round_id`, `socket_id`, `ip_address`, `isp`, `os_type`, `device_name`,browser_using,`hand_cards`,`close_cards`, `open_card`) values('"+room.tables[table_index].players[i].name +"','"+group+"','"+roundno+"','"+pl_sock+"','"+pl_IP+"','"+pl_Isp+"','"+pl_OS+"','"+pl_device_name+"','"+pl_browser+"','"+p1_handcards+"','"+closecards+"','"+player1_opencard[0].id+"');";
									}
									else
									{ 
										query="insert into game_details(`user_id`, `group_id`, `round_id`, `socket_id`, `ip_address`, `isp`, `os_type`, `device_name`,browser_using, `hand_cards`,`close_cards`, `open_card`)values('"+room.tables[table_index].players[i].name +"','"+group+"','"+roundno+"','"+pl_sock+"','"+pl_IP+"','"+pl_Isp+"','"+pl_OS+"','"+pl_device_name+"','"+pl_browser+"','"+p2_handcards+"','"+closecards+"','"+player1_opencard[0].id+"');";
									}
									con.query(query, function(err1, result){
										
										 if (err1) {
										  console.log(err1);
									    } 
										
									}); 
								}//for-insert-db
				
								/* Emitting players turn card and other details*/
								//console.log("Emitting assigned card details to players. "+room.tables[table_index].players[0].name+","+room.tables[table_index].players[1].name+" with round id "+roundno+" and table id "+group);
								
							
								for (var i = 0; i < room.tables[table_index].players.length; i++) 
								{
								if (room.tables[table_index].players[i].id === startingPlayerID)
									{
										room.tables[table_index].players[i].turn = true;
										if(room.tables[table_index].players[0].turn == true)
										{ opp_pl_name = room.tables[table_index].players[1].name;} 
										else { opp_pl_name = room.tables[table_index].players[0].name;} 
										
									    if(room.tables[table_index].players[i]){
											if(room.tables[table_index].players[i].status != "disconnected")
											{
												if(room.tables[table_index].players[i].id != '' && room.tables[table_index].players[i].id != null && room.tables[table_index].players[i].id != undefined)
						                        {
											
													if(i==0)
													{
														io.sockets.connected[(room.tables[table_index].players[i].id)].emit("firstcard", { card: card1[0].card_path,opp_pl_card: card2[0].card_path ,group_id:group,round_no:roundno}); 
													}
													else if(i==1)
													{
															io.sockets.connected[(room.tables[table_index].players[i].id)].emit("firstcard", { card: card2[0].card_path,opp_pl_card: card1[0].card_path ,group_id:group,round_no:roundno}); 
													}
													
												console.log("=========================table.Papplujoker_cards in turn user join func====================================="+room.tables[table_index].papplu_joker_card);
													
													   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("turn", { myturn: true,group_id:group,assigned_cards:room.tables[table_index].players[i].hand,opencard:'',opencard_id:player_open_card_id,
													closedcards_path:room.tables[table_index].closed_cards_arr,closedcards:closed_cards,turn_of_user:room.tables[table_index].players[i].name,opp_user:opp_pl_name,opencard1:'',sidejoker:joker_card[0].card_path,sidejokername:joker_card[0].name,
													open_close_pick_count:room.tables[table_index].players[i].open_close_selected_count,round_no:roundno,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name});
													
												}
											}
										}
									}
									else
									{
										room.tables[table_index].players[i].turn = false;
										if(room.tables[table_index].players[0].turn == true)
										{ opp_pl_name = room.tables[table_index].players[1].name;} 
										else { opp_pl_name = room.tables[table_index].players[0].name;} 
										if(room.tables[table_index].players[i].id != '' && room.tables[table_index].players[i].id != null && room.tables[table_index].players[i].id != undefined)
						                {
											if(room.tables[table_index].players[i].status != "disconnected")
											{
												
												
												if(i==0)
												{
													io.sockets.connected[(room.tables[table_index].players[i].id)].emit("firstcard", { card: card1[0].card_path,opp_pl_card: card2[0].card_path ,group_id:group,round_no:roundno}); 
												}
												else if(i==1)
												{
														io.sockets.connected[(room.tables[table_index].players[i].id)].emit("firstcard", { card: card2[0].card_path,opp_pl_card: card1[0].card_path ,group_id:group,round_no:roundno}); 
												}
											    console.log("=========================table.Papplujoker_cards in turn  second layer user join func====================================="+room.tables[table_index].papplu_joker_card);
											
											    io.sockets.connected[(room.tables[table_index].players[i].id)].emit("turn", { myturn: false,group_id:group,assigned_cards:room.tables[table_index].players[i].hand,opencard:'',opencard_id:player_open_card_id,closedcards_path:room.tables[table_index].closed_cards_arr,closedcards:closed_cards,turn_of_user:room.tables[table_index].players[i].name,opp_user:opp_pl_name,opencard1:'',sidejoker:joker_card[0].card_path,sidejokername:joker_card[0].name,open_close_pick_count:room.tables[table_index].players[i].open_close_selected_count,round_no:roundno,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name});
											
											
											}
										}
									}
								}//turn card for 
				            
								//set 5 seconds delay then emit turn timer after cards distributed to both players 
								room.tables[table_index].countdown_tcount = temp_count;
								room.tables[table_index].countdown_timer = setInterval(function()
								{
									room.tables[table_index].countdown_tcount--;
									if (room.tables[table_index].countdown_tcount == 0)
									{
										clearInterval(room.tables[table_index].countdown_timer);  
										emitTurnTimer(room.tables[table_index].startingPlayerID,room.tables[table_index].startingPlayerName,
											room.tables[table_index].id,room.tables[table_index].timer_array[1],false,roundno,amount);
									}
								}, 1000);
			  				}//activity-timer-0-ends
		   				}////if-2pl-condition
		 			}, 1000);
				}////if table has 2 players 
	  		}//join-2-condition
	 	}//main-outer-if
	}); 
	

	
		// var second_player_count = 1;
	function emitTurnTimer(pl_id,name,group,timer,is_discard,roundid,player_amount)
	{
		//console.log("Emitting Timer with turn to table : "+group+" for round id "+roundid); 
		console.log("\n Turn of Player : "+name); 
		
		var player = room.getPlayer(socket.id);
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n emitTurnTimer");
			return;	
		}
		room.tables[table_index].is_finish = false;
		console.log("\n IN EMIT TIMER FUNCTION table.players.length  : "+room.tables[table_index].players.length); 
		if(room.tables[table_index].players.length == 2 )
		{
			//var test_grp  = false;
			room.tables[table_index].turnTimer = setInterval(function()
			{
				var player_id = pl_id;
				var opp_player_id;
				var opp_player;
				var is_discard = false;
				var is_finished_game = false;
				var is_declared = false;
				var is_dropped = false;
				var turn_player_status,opp_player_status;
				var opp_player_amount = 0;
				var player_group_count = 0;
				var is_player_grouped = false;
				var go_to_final_timer = false;
				var extra_time = 0;
				var table_index = getTableIndex(room.tables,group);
				var player_start_play = false;
				var player_turn_only_first = false;
				if (table_index == - 1) {
					console.log("\n emitTurnTimer");
					return;	
				}

				if(room.tables[table_index].players[0].player_reconnected == true)
				{
					if((room.tables[table_index].players[0].status) == "playing")
					{
						room.tables[table_index].players[0].id = room.tables[table_index].players[0].id;
						if((room.tables[table_index].players[0].is_turn) == true)
						{ player_id = room.tables[table_index].players[0].id; }
					}
				}
				if(room.tables[table_index].players[1].player_reconnected == true)
				{
					if((room.tables[table_index].players[1].status) == "playing")
					{
						room.tables[table_index].players[1].id = room.tables[table_index].players[1].id;
						if((room.tables[table_index].players[1].is_turn) == true)
						{ player_id = room.tables[table_index].players[1].id; }
					}
				} 

				

				if (room.tables[table_index].players[0].name == name)
				{ 
					room.tables[table_index].players[0].is_turn = true;
					room.tables[table_index].players[1].is_turn = false;
										
					extra_time = room.tables[table_index].players[0].extra_time;
					is_finished_game = room.tables[table_index].players[0].gameFinished;
					if(is_finished_game == true)
					{
						room.tables[table_index].is_finish = true;
						//timer = declare_timer;
						timer = room.tables[table_index].timer_array[2];
						extra_time = 0;
						room.tables[table_index].players[0].is_player_finished = true;
					}
					else
					{
						opp_player_id = room.tables[table_index].players[1].id;
						opp_player = room.tables[table_index].players[1].name;
						opp_player_status = room.tables[table_index].players[1].status;
						opp_player_amount = room.tables[table_index].players[1].amount_playing;
					}
					is_discard = room.tables[table_index].players[0].turnFinished;
					is_declared = room.tables[table_index].players[0].declared;
					is_dropped = room.tables[table_index].players[0].is_dropped_game;
					turn_player_status = room.tables[table_index].players[0].status;
					is_player_grouped = room.tables[table_index].players[0].is_grouped;
					player_start_play = room.tables[table_index].players[0].player_start_play;
                    player_turn_only_first = room.tables[table_index].players[0].player_turn_only_first;
				}
				if (room.tables[table_index].players[1].name == name)
				{ 
					room.tables[table_index].players[1].is_turn = true;
					room.tables[table_index].players[0].is_turn = false;
										
					extra_time = room.tables[table_index].players[1].extra_time;

					is_finished_game = room.tables[table_index].players[1].gameFinished;
					if(is_finished_game == true)
					{
						room.tables[table_index].is_finish = true;
						//timer = declare_timer;
						timer = room.tables[table_index].timer_array[2];
						extra_time = 0;
						room.tables[table_index].players[1].is_player_finished = true;
					}
					else
					{
						opp_player_id = room.tables[table_index].players[0].id;
						opp_player = room.tables[table_index].players[0].name;
						opp_player_status = room.tables[table_index].players[0].status;
						opp_player_amount = room.tables[table_index].players[0].amount_playing;
					}
					is_discard = room.tables[table_index].players[1].turnFinished ;
					is_declared = room.tables[table_index].players[1].declared;
					is_dropped = room.tables[table_index].players[1].is_dropped_game;
					turn_player_status = room.tables[table_index].players[1].status;
				
					is_player_grouped = room.tables[table_index].players[1].is_grouped;
					player_start_play = room.tables[table_index].players[1].player_start_play;
                    player_turn_only_first = room.tables[table_index].players[1].player_turn_only_first;
				}	
				
				
				 for (var i = 0; i < 2; i++) {
				      if (room.tables[table_index].players[i].name == name)
        			  {
					    if(extra_time == 1){
						     room.tables[table_index].players[i].player_turn_only_first=true;
							 
								 
									if( room.tables[table_index].players[i].player_start_play == false) {
												drop_game_func(room.tables[table_index].players[i].name , group, roundid, false, false, false);
												//drop_game_six_papplu_func(room.tables[table_index].players[i].name , group, roundid, false, false, false);
												room.tables[table_index].players[i].freeturn = 0;
												room.tables[table_index].players[i].player_turn_only_first=false;
												
									}
								
								
						   }
					  }
				}
				
				//emit timer to player who has TURN
				if(player_id){
					if(turn_player_status != "disconnected"){
						//console.log("\n in timer 1st Player status : "+name); 
						if( io.sockets.connected[player_id] )
							io.sockets.connected[player_id].emit("timer", { id:player_id,myturn:true,turn_of_user:name,group_id:group,game_timer:timer, extra_time: extra_time, is_discard:is_discard,round_id:roundid,is_declared:is_declared,is_dropped:is_dropped,player_start_play:player_start_play,player_turn_only_first:player_turn_only_first,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name});
					}
					//emit timer to player who DON'T have TURN
					 if(opp_player_status != "disconnected"){
						//console.log("\n in timer 2nd Player status : "+opp_player); 
						if( io.sockets.connected[opp_player_id] )
							io.sockets.connected[opp_player_id].emit("timer", { id:opp_player_id,myturn:false,turn_of_user:opp_player,group_id:group,game_timer:timer,extra_time: extra_time, is_discard:is_discard,round_id:roundid,is_declared:is_declared,is_dropped:is_dropped,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name});
					}
				}
			    is_finished_game = false;
				room.tables[table_index].players[0].gameFinished = false;
				room.tables[table_index].players[1].gameFinished = false;
								
				if( timer > 0 ) {
					timer--;
				} else {
					extra_time = 0;
					if( room.tables[table_index].is_finish == false ) {
						if (room.tables[table_index].players[0].id == player_id)
						{
							if( room.tables[table_index].players[0].extra_time > 0 ) {
								room.tables[table_index].players[0].extra_time --;
								extra_time = room.tables[table_index].players[0].extra_time;
							}
						} else if(room.tables[table_index].players[1].id == player_id) {
							if( room.tables[table_index].players[1].extra_time > 0 ) {
								room.tables[table_index].players[1].extra_time --;
								extra_time = room.tables[table_index].players[1].extra_time;
							}
						}
					}
				}
				
				
				if(is_declared == true || is_dropped == true){ go_to_final_timer = true; }
				
				if(is_discard == true || is_declared == true || is_dropped == true)
				{
					if (room.tables[table_index].players[0].id == player_id)
					 	{ room.tables[table_index].players[0].freeturn = 0; }
					if (room.tables[table_index].players[1].id == player_id)
					 	{ room.tables[table_index].players[1].freeturn = 0; } 
					timer = 0; 
					extra_time = 0;
				} 
				if (timer == 0 && extra_time == 0) 
				{
					
					if(room.tables[table_index].players[0].id == player_id){
						console.log("\n turn ends of o pl before ++ "+room.tables[table_index].players[0].turn_count);
						room.tables[table_index].players[0].turn_count++; 
						console.log("\n turn ends of o pl After ++ "+room.tables[table_index].players[0].turn_count);
					}
					if(room.tables[table_index].players[1].id == player_id){
						console.log("\n turn ends of o pl before ++ "+room.tables[table_index].players[1].turn_count);
						room.tables[table_index].players[1].turn_count++; 
						console.log("\n turn ends of o pl After ++ "+room.tables[table_index].players[1].turn_count);
					} 
					
					
					room.tables[table_index].isfirstTurn = false;
				
					if (room.tables[table_index].players[0].is_turn == true){ 
						room.tables[table_index].players[0].is_turn = false;
						room.tables[table_index].players[1].is_turn = true;
					}else if (room.tables[table_index].players[1].is_turn == true){ 
						room.tables[table_index].players[1].is_turn = false; 
						room.tables[table_index].players[0].is_turn = true;
					} 
				
					
					if(is_discard == false && is_declared == false && is_dropped == false && room.tables[table_index].is_finish == false)
					 {
						if(room.tables[table_index].players[0].name == name){ 
							if( room.tables[table_index].players[0].open_close_selected_count == 1 )
							return_open_card(0,player_id,name,group,roundid,room.tables[table_index].players[0].hand,room.tables[table_index].temp_open_object,turn_player_status);

							room.tables[table_index].players[0].freeturn++;
						}else if(room.tables[table_index].players[1].name == name){ 
							if( room.tables[table_index].players[1].open_close_selected_count == 1 )
							return_open_card(1,player_id,name,group,roundid,room.tables[table_index].players[1].hand,room.tables[table_index].temp_open_object,turn_player_status);
							
							room.tables[table_index].players[1].freeturn++;
						}
					 }
					 
					is_discard = false;
					is_finished_game = false;
					 
					room.tables[table_index].players[0].turnFinished = false;
					room.tables[table_index].players[1].turnFinished = false;
					 
					room.tables[table_index].players[0].gameFinished = false;
					room.tables[table_index].players[1].gameFinished = false;
					 
					if(room.tables[table_index].is_finish == true && is_declared == false){
						go_to_final_timer = true;
						console.log("\n --- DECLARED ---- emitTurnTimer " + name);
						
							declare_papplu_game_data(data.user,data.group,data.round_id,data.pl_amount_taken,data.is_sort,data.is_group,data.is_initial_group,room.tables[table_index].table_point_value,room.tables[table_index].game_type,room.tables[table_index].table_name);
						
							
					 }
					 clearInterval(room.tables[table_index].turnTimer); 
					
					if((room.tables[table_index].players[0].status) == "disconnected"){
						if(room.tables[table_index].players[0].player_reconnected == true)
						{
							room.tables[table_index].players[0].id = room.tables[table_index].players[0].id;
							room.tables[table_index].players[0].status = "playing";
						}
					}else if((room.tables[table_index].players[1].status) == "disconnected"){
						if(room.tables[table_index].players[1].player_reconnected == true)
						{
							room.tables[table_index].players[1].id = room.tables[table_index].players[1].id;
							room.tables[table_index].players[1].status = "playing";
						}
					}  
				
					 console.log("\n Turn to Next Player : "+opp_player); 
					if( go_to_final_timer != true){
						timer = room.tables[table_index].timer_array[1];
						console.log("\n NOT DECLARED SO TIMER 10 ");
						emitTurnTimer(opp_player_id,opp_player,group,timer,false,roundid,opp_player_amount);
					}else{
						console.log("\n DECLARED SO TIMER 15 ");
						emitFinalTimer(opp_player_id,opp_player,group,room.tables[table_index].timer_array[2],false,roundid,opp_player_amount, name);
					}
				}
			}, 1000);
		}//if 2 players 
	}// emitTurnTimer() ends
	
	function return_open_card(pl_index,pl_id,pl_name,pl_group,round_id,pl_hand_cards,temp_open_object,player_status)
	{
		console.log("\n AUTO DISCARD ");
		console.log("\n "+ JSON.stringify(temp_open_object));
		
		var pl_grp_arr = [];
		var table_index =0;
		table_index = getTableIndex(room.tables,pl_group);
		if (table_index == - 1) { console.log("\n return_open_card");return;	}
		
		if(room.tables[table_index].players[pl_index].is_grouped != true){
			pl_hand_cards = removeFromHandCards(pl_hand_cards,temp_open_object.id);
			//send updated hand cards 
			if(player_status != "disconnected"){
			    if(room.tables[table_index].players[pl_index].id != ''){
				   io.sockets.connected[(room.tables[table_index].players[pl_index].id)].emit("update_hand_cards", { user:pl_name,group:pl_group,round_id:round_id,hand_cards:pl_hand_cards,sidejokername:room.tables[table_index].side_joker_card_name});	
			    }
			}
		}else{
			
			pl_grp_arr = get_player_groups(pl_index,pl_group);
			for(var n=0; n<pl_grp_arr.length; n++){
				removeFromSortedHandCards(pl_grp_arr[n],temp_open_object.id,0);
			}
			if(player_status != "disconnected"){
			    if(room.tables[table_index].players[pl_index].id != '' && room.tables[table_index].players[pl_index].id != null && room.tables[table_index].players[pl_index].id != undefined)
				{
				   io.sockets.connected[(room.tables[table_index].players[pl_index].id)].emit("update_player_groups_sort", { user:pl_name,group:pl_group,round_id:round_id,grp1_cards:room.tables[table_index].players[pl_index].card_group1,grp2_cards:room.tables[table_index].players[pl_index].card_group2,grp3_cards:room.tables[table_index].players[pl_index].card_group3,grp4_cards:room.tables[table_index].players[pl_index].card_group4,grp5_cards:room.tables[table_index].players[pl_index].card_group5,grp6_cards:room.tables[table_index].players[pl_index].card_group6,grp7_cards:room.tables[table_index].players[pl_index].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
			    }
			}
		}
		room.tables[table_index].open_card_obj_arr = [];
		room.tables[table_index].open_card_obj_arr.push(temp_open_object);
		room.tables[table_index].open_card_status = "discard";
			
		room.tables[table_index].players[pl_index].open_close_selected_count = 0;
		oth_player_status = room.tables[table_index].players[0].status;
		first_player_status = room.tables[table_index].players[1].status;
		if(room.tables[table_index].players[0].id != ''){
			if(oth_player_status != "disconnected")
			{
				io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_card", { path:temp_open_object.card_path,check:true,id:temp_open_object.id,discareded_open_card:temp_open_object,group:pl_group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards });
			}
		}
		if(room.tables[table_index].players[1].id != ''){
			if(first_player_status != "disconnected"){
				io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_card", { path:temp_open_object.card_path,check:true,id:temp_open_object.id,discareded_open_card:temp_open_object,group:pl_group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards});
			}
		}
		
	}//return_open_card() ends
	
	function emitFinalTimer(pl_id,name,group,final_timer,is_discard,roundid,opp_player_amount, declared_user)
	{
		console.log("\n 2nd Player declared game. SHOWING FINAL TIMER "+final_timer);
		var player = room.getPlayer(socket.id);
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) { console.log("\n emitFinalTimer");return; }
		
		if(room.tables[table_index].players.length == 2 ){
			//var test_grp  = false;
		    room.tables[table_index].finalTimer = setInterval(function(){
				var player_id = pl_id;
				var opp_player_id;
				var opp_player;
				var is_discard = false;
				var is_finished_game = false;
				var is_declared = false;
				var is_dropped = false;
				var turn_player_status,opp_player_status;
				var player_group_count = 0;
				var is_player_grouped = false;
				var oppIdx = 0;
				var table_index = getTableIndex(room.tables, group);
				
				if (table_index == - 1) { console.log("\n emitFinalTimer");return;}
				
			    console.log("\n emitting final timer ");
				if (room.tables[table_index].players[0].name == name){ 
					player_id = room.tables[table_index].players[0].id;
					opp_player_id = room.tables[table_index].players[1].id;
					opp_player = room.tables[table_index].players[1].name;
					is_declared = room.tables[table_index].players[0].declared;
					is_dropped = room.tables[table_index].players[0].is_dropped_game;
					turn_player_status = room.tables[table_index].players[0].status;
					opp_player_status = room.tables[table_index].players[1].status;
					//player_group_count = get_player_group_count(0,group);
					//test_grp = room.tables[table_index].players[0].is_grouped;
					is_player_grouped = room.tables[table_index].players[0].is_grouped;

					oppIdx = 1;
				}
				
				if (room.tables[table_index].players[1].name == name){ 
					player_id = room.tables[table_index].players[1].id;
					opp_player_id = room.tables[table_index].players[0].id;
					opp_player = room.tables[table_index].players[0].name;
					is_declared = room.tables[table_index].players[1].declared;
					is_dropped = room.tables[table_index].players[1].is_dropped_game;
					turn_player_status = room.tables[table_index].players[1].status;
					opp_player_status = room.tables[table_index].players[0].status;
					/* player_group_count = get_player_group_count(1,group);
					test_grp = room.tables[table_index].players[1].is_grouped; */
					is_player_grouped = room.tables[table_index].players[1].is_grouped;

					oppIdx = 0;
				}	
				console.log("final Timer  : "+final_timer + " is_declared " + is_declared + " is_dropped " + is_dropped + " turn_player_status " + turn_player_status ); 
				if(player_id){
					if(turn_player_status != "disconnected" && io.sockets.connected[player_id]){
						if(!(is_declared || is_dropped))
							io.sockets.connected[player_id].emit("declared", { user:name,group:group,round_id:roundid,declared_user:declared_user ,declare:room.tables[table_index].declared});	
					
						io.sockets.connected[player_id].emit("timer", { id:player_id,myturn:true,turn_of_user:name,group_id:group,game_timer:final_timer,is_discard:is_discard,round_id:roundid,is_declared:is_declared,is_dropped:is_dropped,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name});
					}
				}
				//emit timer to player who DON'T have TURN
				if(opp_player_id){
					if(opp_player_status != "disconnected" && io.sockets.connected[opp_player_id]){
						if(!(is_declared || is_dropped)) {
							var oppPlayer = room.tables[table_index].players[oppIdx];
							if(oppPlayer.is_grouped == false)
							{
								io.sockets.connected[opp_player_id].emit("declared_data", { user:opp_player,opp_user:name,declared:1,group:group,grp1_cards:room.tables[table_index].players[oppIdx].hand});
							}
							else
							{ 
								io.sockets.connected[opp_player_id].emit("declared_data", { user:opp_player,opp_user:name,declared:1,group:group,grp1_cards:room.tables[table_index].players[oppIdx].card_group1,grp2_cards:room.tables[table_index].players[oppIdx].card_group2,grp3_cards:room.tables[table_index].players[oppIdx].card_group3,grp4_cards:room.tables[table_index].players[oppIdx].card_group4,grp5_cards:room.tables[table_index].players[oppIdx].card_group5,grp6_cards:room.tables[table_index].players[oppIdx].card_group6,grp7_cards:room.tables[table_index].players[oppIdx].card_group7});
							}
						}
						
						io.sockets.connected[opp_player_id].emit("timer", { id:opp_player_id,myturn:false,turn_of_user:opp_player,group_id:group,game_timer:final_timer,is_discard:is_discard,round_id:roundid,is_declared:is_declared,is_dropped:is_dropped,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name});
					}
				}
				

				final_timer--;
				if(is_declared == true || is_dropped == true){	final_timer = 0; } 
				if(final_timer == 0)
				{
				
					if(is_dropped == false){
						if(is_declared == false ){
							console.log("\n --- DECLARED ---- emitFinalTimer " + name);
							
									//declare_papplu_game_data(data.user,data.group,data.round_id,data.pl_amount_taken,data.is_sort,data.is_group,data.is_initial_group,room.tables[table_index].table_point_value,room.tables[table_index].game_type,room.tables[table_index].table_name);
							
						} 
					}
					
				    console.log("........ GAME FINISHED .........");
				    room.tables[table_index].players[0].declared = false;
					room.tables[table_index].players[1].declared = false;
					room.tables[table_index].players[0].is_dropped_game = false;
					room.tables[table_index].players[1].is_dropped_game = false;
					room.tables[table_index].status = "available";
					
                    if(room.tables[table_index].players[0].id != ''){
							 if((room.tables[table_index].players[0].status !="disconnected")){
								io.sockets.connected[(room.tables[table_index].players[0].id)].emit("game_finished", {user:room.tables[table_index].players[0].name,group:group,round_id:roundid }); 
								
								    
									   if( room.tables[table_index].players[0].amount_playing < (room.tables[table_index].table_min_entry * 4) ) {
										io.sockets.connected[(room.tables[table_index].players[0].id)].emit("game_no_enough", room.tables[table_index].players[0].name, group);
									   }
									
								
							 } else {
								removePlayerFromTable(room.tables[table_index].players[0].name, group);
								revertPoints(room.tables[table_index].players[0].name, room.tables[table_index].players[0].amount_playing, room.tables[table_index].table_game);
								console.log("REVERT 4346");
							 }
					 }
					
					if(room.tables[table_index].players[1].id != ''){
						 if((room.tables[table_index].players[1].status !="disconnected"))
						 {
							io.sockets.connected[(room.tables[table_index].players[1].id)].emit("game_finished", {user:room.tables[table_index].players[1].name,group:group,round_id:roundid }); 
							   
									if( room.tables[table_index].players[1].amount_playing < (room.tables[table_index].table_min_entry * 4) ) {
									io.sockets.connected[(room.tables[table_index].players[1].id)].emit("game_no_enough", room.tables[table_index].players[1].name, group);
								   }
								
						 } else {
							removePlayerFromTable(room.tables[table_index].players[1].name, group);
							revertPoints(room.tables[table_index].players[1].name, room.tables[table_index].players[1].amount_playing, room.tables[table_index].table_game);
							console.log("REVERT 4357");
						 }
					 }
					 room.tables[table_index].players = [];
					 room.tables[table_index].readyToPlayCounter = 0;
					 room.tables[table_index].player_amount =[];
					 room.tables[table_index].usernames = [];
					 room.tables[table_index].user_click = [];
					 room.tables[table_index].player_gender = [];
                     room.tables[table_index].isfirstTurn = true;
                     clearInterval(room.tables[table_index].finalTimer); 
					}
				}, 1000);				
		}	
	}
	
	////check open_close_selected_count and allow to pick open/close card 
	socket.on("check_open_closed_pick_count", function(data) {	
		   console.log("\n "+data.card+" card selected by player "+data.user+" on table "+data.group+" for round id "+data.round_id);
			var table_index =0;
			var user = data.user;
			var group = data.group;
			var player = room.getPlayer(socket.id);
			table_index = getTableIndex(room.tables,group);
			if (table_index == - 1) { console.log("\n check_open_closed_pick_count"); return;}
			var temp_open_array  = [];
			var card_type = data.card;
			var card_taken = false;
			var round_id = data.round_id;
			var obj;
		    var is_sorted = data.is_sort;
			var is_grouped = data.is_group;
			var is_initial_grouped = data.is_initial_group;			
			var oth_player_status,first_player_status;
			var is_joker = false;
			var next_key = 13;
			var select_player='';
			
			var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card <= 13){
			
			if(room.tables[table_index].players[selected_user].is_turn == true){
			console.log("\n open/close click is_sorted "+is_sorted+" is_grouped "+is_grouped+" is_initial_grouped "+is_initial_grouped);
			
			if(card_type=='open'){
			  
				is_joker = checkIfJokerCard(room.tables[table_index].joker_cards,data.card_data[0].id);
				console.log("\n is selected card is joker--> "+is_joker);
				
				if( room.tables[table_index].isfirstTurn )
				is_joker = false;
				
			    obj = data.card_data.reduce(function(acc, cur, i) { acc[i] = cur; return acc; }); 
            }
			
			if(card_type=='close'){
				/*** When closed card array get empty ***/
				//1. add last card of open array to temp open array
				//2. remove last card from open 
				//3. add all rest cards from open to close array 
				//4. clear open array and add temp card to open array
				//5. shuffle new array before use 
				
				if(room.tables[table_index].closed_cards_arr.length==0)
				{
					console.log("\n CLOSED EMPTY open =="+JSON.stringify(room.tables[table_index].open_cards));
					//1
					temp_open_array.push(room.tables[table_index].open_cards[(room.tables[table_index].open_cards.length)-1]);
                    //2
					room.tables[table_index].open_cards = removeOpenCard(room.tables[table_index].open_cards,temp_open_array[0].id);
					//3
					room.tables[table_index].closed_cards_arr.push.apply(room.tables[table_index].closed_cards_arr,room.tables[table_index].open_cards);
					//4
					room.tables[table_index].open_cards = [];
					room.tables[table_index].open_cards.push.apply(room.tables[table_index].open_cards,temp_open_array);
					//5
					room.tables[table_index].closed_cards_arr = shuffleClosedCards(room.tables[table_index].closed_cards_arr);
				}
				if(room.tables[table_index].closed_cards_arr.length>0){ obj = room.tables[table_index].closed_cards_arr[0]; }
			}	
			
			//room.tables[table_index].temp_open_object = obj;	
			
			//console.log("\n \n obj value"+JSON.stringify(obj));
			
			if(room.tables[table_index].round_id == round_id)
			{
			////check disconnected status of players 
				oth_player_status = room.tables[table_index].players[0].status;
				first_player_status = room.tables[table_index].players[1].status;
				
				    if(room.tables[table_index].players[0].name == user){ 
				
				        if((room.tables[table_index].players[0].open_close_selected_count == 0)){
					
						    if(is_joker !=true){
						
									
								
								if(is_grouped == true || is_initial_grouped == true){
								         var pushstatus=0;
											if(room.tables[table_index].players[0].card_group7){
												if(room.tables[table_index].players[0].card_group7.length > 0){
													room.tables[table_index].players[0].card_group7.push(obj);
													pushstatus=1;
												}
											}
											if(pushstatus == 0){
												if(room.tables[table_index].players[0].card_group6){
													if(room.tables[table_index].players[0].card_group6.length > 0){
														room.tables[table_index].players[0].card_group6.push(obj);
														pushstatus=1;
													}
											    }
											}
											if(pushstatus == 0){
												if(room.tables[table_index].players[0].card_group5){
													if(room.tables[table_index].players[0].card_group5.length > 0){
														room.tables[table_index].players[0].card_group5.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[0].card_group4){
													if(room.tables[table_index].players[0].card_group4.length > 0){
														room.tables[table_index].players[0].card_group4.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[0].card_group3){
													if(room.tables[table_index].players[0].card_group3.length > 0){
														room.tables[table_index].players[0].card_group3.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[0].card_group2){
													if(room.tables[table_index].players[0].card_group2.length > 0){
														room.tables[table_index].players[0].card_group2.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[0].card_group1){
													if(room.tables[table_index].players[0].card_group1.length > 0){
														room.tables[table_index].players[0].card_group1.push(obj);
														pushstatus=1;
													}
											    }
											}
									
								}else{
									if(is_sorted == false && is_grouped == false && is_initial_grouped == false) {
									room.tables[table_index].players[0].hand.push(obj);
								    }else{
										if(is_sorted == true){
										  room.tables[table_index].players[0].card_group4.push(obj);
										}
									}
								}
								if(card_type=='open'){
									//console.log("\n Before Use Open Card, array "+JSON.stringify(room.tables[table_index].open_cards));
									room.tables[table_index].open_cards = removeOpenCard(room.tables[table_index].open_cards,data.card_data[0].id);
									room.tables[table_index].open_card_obj_arr = [];
									if(room.tables[table_index].players[0].id != ''){
										if(oth_player_status != "disconnected"){
										  io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,open_arr:room.tables[table_index].open_cards,card:'open',check:true,hand_cards:room.tables[table_index].players[0].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
										////after sort send card groups 
										if(is_sorted == true || is_grouped == true || is_initial_grouped == true){
											if(oth_player_status != "disconnected"){
											   io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:user,group:group,round_id:round_id,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
											}
										} 
									}
									if(room.tables[table_index].players[1].id != ''){
										 if(first_player_status != "disconnected"){
										io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,open_arr:room.tables[table_index].open_cards,card:'open',check:false,hand_cards:room.tables[table_index].players[1].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
									}
								}
								if(card_type=='close'){
									//console.log("\n Before Use Close Card ,array "+room.tables[table_index].closed_cards_arr.length+"==="+JSON.stringify(room.tables[table_index].closed_cards_arr));
									if(room.tables[table_index].closed_cards_arr.length > 0){
										room.tables[table_index].closed_cards_arr = removeCloseCard(room.tables[table_index].closed_cards_arr,obj.id);
									}
									
									if(room.tables[table_index].closed_cards_arr.length > 0){
										room.tables[table_index].closed_cards_arr = shuffleClosedCards(room.tables[table_index].closed_cards_arr);
									}
									//console.log("\n After Used Close Card ,array "+room.tables[table_index].closed_cards_arr.length+"==="+JSON.stringify(room.tables[table_index].closed_cards_arr));
									if(room.tables[table_index].players[0].id != ''){
										if(oth_player_status != "disconnected"){
										io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:obj,path:obj.card_path,pick_count:0,open_arr:room.tables[table_index].closed_cards_arr,card:'close',check:true,hand_cards:room.tables[table_index].players[0].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
										////after sort send card groups 
										if(is_sorted == true || is_grouped == true || is_initial_grouped == true){
											if(oth_player_status != "disconnected"){
											io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:user,group:group,round_id:round_id,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
											}
										}
									}
									
									if(room.tables[table_index].players[1].id != ''){
										if(first_player_status != "disconnected"){
										io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:obj,path:obj.card_path,pick_count:0
										,open_arr:room.tables[table_index].closed_cards_arr,card:'close',check:false,hand_cards:room.tables[table_index].players[1].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
									}
								}
								
								room.tables[table_index].players[0].open_close_selected_count = 1;
								room.tables[table_index].temp_open_object = obj;
							}else{
							    if(room.tables[table_index].players[0].id != ''){
								   io.sockets.connected[(room.tables[table_index].players[0].id)].emit("pick_close_card", {user:user,group:group,round_id:round_id});
								}
							}
						}else{
							if(room.tables[table_index].players[0].id != ''){
							  io.sockets.connected[(room.tables[table_index].players[0].id)].emit("disallow_pick_card", {user:user,group:group,round_id:round_id});
							}
						}
					}else if(room.tables[table_index].players[1].name == user){
					    if((room.tables[table_index].players[1].open_close_selected_count == 0)){
						
						    if(is_joker !=true){
							
								
								
								if(is_grouped == true || is_initial_grouped == true){
									var pushstatus1=0;
											if(room.tables[table_index].players[1].card_group7){
												if(room.tables[table_index].players[1].card_group7.length > 0){
													room.tables[table_index].players[1].card_group7.push(obj);
													pushstatus1=1;
												}
											}
											if(pushstatus1 == 0){
												if(room.tables[table_index].players[1].card_group6){
													if(room.tables[table_index].players[1].card_group6.length > 0){
														room.tables[table_index].players[1].card_group6.push(obj);
														pushstatus1=1;
													}
											    }
											}
											if(pushstatus1 == 0){
												if(room.tables[table_index].players[1].card_group5){
													if(room.tables[table_index].players[1].card_group5.length > 0){
														room.tables[table_index].players[1].card_group5.push(obj);
														pushstatus1=1;
													}
											    }
											}
											
											if(pushstatus1 == 0){
												if(room.tables[table_index].players[1].card_group4){
													if(room.tables[table_index].players[1].card_group4.length > 0){
														room.tables[table_index].players[1].card_group4.push(obj);
														pushstatus1=1;
													}
											    }
											}
											
											if(pushstatus1 == 0){
												if(room.tables[table_index].players[1].card_group3){
													if(room.tables[table_index].players[1].card_group3.length > 0){
														room.tables[table_index].players[1].card_group3.push(obj);
														pushstatus1=1;
													}
											    }
											}
											
											if(pushstatus1 == 0){
												if(room.tables[table_index].players[1].card_group2){
													if(room.tables[table_index].players[1].card_group2.length > 0){
														room.tables[table_index].players[1].card_group2.push(obj);
														pushstatus1=1;
													}
											    }
											}
											
											
											if(pushstatus1 == 0){
												if(room.tables[table_index].players[1].card_group1){
													if(room.tables[table_index].players[1].card_group1.length > 0){
														room.tables[table_index].players[1].card_group1.push(obj);
														pushstatus1=1;
													}
											    }
											}
									
								}else{
									if(is_sorted == false && is_grouped == false && is_initial_grouped == false){
								      room.tables[table_index].players[1].hand.push(obj);
								    }else{
										if(is_sorted == true){
											room.tables[table_index].players[1].card_group4.push(obj);
										}
									}
								}
								if(card_type=='open'){
									room.tables[table_index].open_cards = removeOpenCard(room.tables[table_index].open_cards,data.card_data[0].id);
									room.tables[table_index].open_card_obj_arr = [];
									if(room.tables[table_index].players[1].id != ''){
										if(first_player_status != "disconnected"){
											io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,open_arr:room.tables[table_index].open_cards,card:'open',check:true,hand_cards:room.tables[table_index].players[1].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
										if(is_sorted == true || is_grouped == true || is_initial_grouped == true){
											if(first_player_status != "disconnected"){
											 io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:user,group:group,round_id:round_id,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
											}
										} 
									}
									
									if(room.tables[table_index].players[0].id != ''){
										 if(oth_player_status != "disconnected"){
										io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,open_arr:room.tables[table_index].open_cards,card:'open',check:false,hand_cards:room.tables[table_index].players[0].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
									}
								}
								
								if(card_type=='close'){
								
									if(room.tables[table_index].closed_cards_arr.length > 0){
										room.tables[table_index].closed_cards_arr = removeCloseCard(room.tables[table_index].closed_cards_arr,obj.id);
									}
									if(room.tables[table_index].closed_cards_arr.length > 0){
										room.tables[table_index].closed_cards_arr = shuffleClosedCards(room.tables[table_index].closed_cards_arr);
									}	
									if(room.tables[table_index].players[1].id != ''){
										if(first_player_status != "disconnected"){
										io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:obj,path:obj.card_path,pick_count:0,open_arr:room.tables[table_index].closed_cards_arr,card:'close',check:true,hand_cards:room.tables[table_index].players[1].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
										//after sort send card groups
										if(is_sorted == true || is_grouped == true || is_initial_grouped == true){
											if(first_player_status != "disconnected"){
											  io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:user,group:group,round_id:round_id,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
											}
										} 
									}
									
									if(room.tables[table_index].players[0].id != ''){
										 if(oth_player_status != "disconnected"){
										io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:obj,path:obj.card_path,pick_count:0
										,open_arr:room.tables[table_index].closed_cards_arr,card:'close',check:false,hand_cards:room.tables[table_index].players[0].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name});
										}
									}
								}
								room.tables[table_index].players[1].open_close_selected_count = 1;	
								room.tables[table_index].temp_open_object = obj;
							}else{
								   if(room.tables[table_index].players[1].id != ''){
									io.sockets.connected[(room.tables[table_index].players[1].id)].emit("pick_close_card", {user:user,group:group,round_id:round_id});
									}
							}
						}else{
							    if(room.tables[table_index].players[1].id != ''){
								  io.sockets.connected[(room.tables[table_index].players[1].id)].emit("disallow_pick_card", {user:user,group:group,round_id:round_id});
								}
					    }
				    }//-pl-1ends
			}else { 
			//console.log("you don't have turn so you can not pick open/close card"); 
			console.log("Table with specified round id not exist."); 
			}
			
			}else{
			if(room.tables[table_index].players[select_player].id != ''){
								  io.sockets.connected[(room.tables[table_index].players[select_player].id)].emit("disallow_pick_card", {user:user,group:group,round_id:round_id});
								}
		    }
		}else{
			if(room.tables[table_index].players[select_player].id != ''){
								  io.sockets.connected[(room.tables[table_index].players[select_player].id)].emit("disallow_pick_card", {user:user,group:group,round_id:round_id});
								}
		}
	});
	
	socket.on("discard_fired", function(data) {	
		console.log("discard event fired by Player "+data.discarded_user+" on table "+data.group+" for round id "+data.round_id);
		var user_whos_discarded = data.discarded_user;
		var player = room.getPlayer(socket.id);
		var group = data.group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) { console.log("\n discard_fired"); return; }
		
		var round_id = data.round_id;
		
		if(room.tables[table_index].round_id == round_id)
		{
			if(room.tables[table_index].players.length == 2 )
			{
				if(room.tables[table_index].players[0].name == user_whos_discarded){
					room.tables[table_index].players[0].turnFinished = true;
				}else{
					room.tables[table_index].players[1].turnFinished = true;
				} 
			}////table-2-players-condition
		}
	});//discard_fired ends 
	
	//// show discarded card to open card ///
	socket.on("show_open_card", function(data) {	
	        console.log("After discard display open card to Player "+data.user+" on table "+data.group+" for round id "+data.round_id);
			var user_who_discarded = data.user;
			var group = data.group;
			var player = room.getPlayer(socket.id);
			var table_index =0;
			table_index = getTableIndex(room.tables,group);
			if (table_index == - 1) {
				console.log("\n show_open_card");
				return;	
			}
			var open_card_path = data.open_card_src;
			var open_card_id = data.open_card_id;
			var discareded_return_card = data.discard_card_data;
			var discareded_open_card = data.discarded_open_data;
			var is_sorted = data.is_sort;
			var is_grouped = data.is_group;
			var group_from_discarded = data.group_from_discarded;
			var remove_from_group;
			var discard_data_temp;
			var is_initial_grouped = data.is_initial_group;
			var round_id = data.round_id;
			var oth_player_status,first_player_status;
			
			var check1 = data.check;
			
			var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
			
			console.log("\n^^^^^^^^^^^&&&&&&"+group_from_discarded);
							
		if(total_hand_card > 13){
			
			
			if(room.tables[table_index].round_id == round_id)
			{
				if(room.tables[table_index].players.length == 2 ){
					oth_player_status = room.tables[table_index].players[0].status;
					first_player_status = room.tables[table_index].players[1].status;
				  
					if(room.tables[table_index].players[0].name == user_who_discarded)
					{
						if(is_sorted == false && is_grouped == false && is_initial_grouped == false){
							discard_data_temp = getDiscardFromHandCards(room.tables[table_index].players[0].hand,discareded_return_card);
							room.tables[table_index].open_card_obj_arr = [];
							room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
							room.tables[table_index].open_card_status = "discard";
							room.tables[table_index].open_cards.push(discard_data_temp);
							room.tables[table_index].players[0].hand = removeFromHandCards(room.tables[table_index].players[0].hand,discareded_return_card);
						}
						
						if(is_sorted == true || is_grouped == true || is_initial_grouped == true){
							console.log("\n^^^^^^^^^^^&&&&&&"+group_from_discarded);
							
							if(group_from_discarded == 0)
							{ remove_from_group = room.tables[table_index].players[0].card_group4;}
							if(group_from_discarded == 1)
							{ remove_from_group = room.tables[table_index].players[0].card_group1;}
							if(group_from_discarded == 2)
							{ remove_from_group = room.tables[table_index].players[0].card_group2;}
							if(group_from_discarded == 3)
							{ remove_from_group = room.tables[table_index].players[0].card_group3;}
							if(group_from_discarded == 4)
							{ remove_from_group = room.tables[table_index].players[0].card_group4;}
							if(group_from_discarded == 5)
							{ remove_from_group = room.tables[table_index].players[0].card_group5;}
							if(group_from_discarded == 6)
							{ remove_from_group = room.tables[table_index].players[0].card_group6;}
							if(group_from_discarded == 7)
							{ remove_from_group = room.tables[table_index].players[0].card_group7;}
							
							discard_data_temp = getDiscardFromSortGroupCards(remove_from_group,discareded_return_card,group_from_discarded);
							room.tables[table_index].open_card_obj_arr = [];
							room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
							room.tables[table_index].open_card_status = "discard";
							room.tables[table_index].open_cards.push(discard_data_temp);
							remove_from_group= removeFromSortedHandCards(remove_from_group,discareded_return_card,group_from_discarded);
						}
						 
						//show open card 
						if(room.tables[table_index].players[1].id != ''){
							if(first_player_status != "disconnected"){
							  io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_card", { path:open_card_path,check:check1,id:open_card_id,discareded_open_card:discard_data_temp,group:group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards});	
							}
						}
						
						if(room.tables[table_index].players[0].id != ''){
							 if(oth_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_card", { path:open_card_path,check:check1,id:open_card_id,discareded_open_card:discard_data_temp,group:group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards});	
							}
						}
						room.tables[table_index].players[0].open_close_selected_count = 0;
						if(room.tables[table_index].players[0].id != ''){
							if(is_sorted == false && is_grouped == false && is_initial_grouped == false){
								//send updated hand cards 
								if(oth_player_status != "disconnected"){
								  io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_hand_cards", { user:user_who_discarded,group:group,round_id:data.round_id,hand_cards:room.tables[table_index].players[0].hand,sidejokername:room.tables[table_index].side_joker_card_name});	
								}
							}
							if(is_sorted == true || is_grouped == true || is_initial_grouped == true){
								if(oth_player_status != "disconnected"){
								  io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:user_who_discarded,group:group,round_id:data.round_id,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
								}
							} 
						}
					}else if(room.tables[table_index].players[1].name == user_who_discarded){
					
						if(is_sorted == false && is_grouped == false && is_initial_grouped == false){
							discard_data_temp = getDiscardFromHandCards(room.tables[table_index].players[1].hand,discareded_return_card);
							room.tables[table_index].open_card_obj_arr = [];
							room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
							room.tables[table_index].open_card_status = "discard";
							room.tables[table_index].open_cards.push(discard_data_temp);
							room.tables[table_index].players[1].hand = removeFromHandCards(room.tables[table_index].players[1].hand,discareded_return_card);
						}
						
						if(is_sorted == true  || is_grouped == true || is_initial_grouped == true){
							 console.log("^^^^^^^^^^^&&&&&&"+group_from_discarded);
						  
							if(group_from_discarded == 0)
							{ remove_from_group = room.tables[table_index].players[1].card_group4;}
							if(group_from_discarded == 1)
							{ remove_from_group = room.tables[table_index].players[1].card_group1;}
							if(group_from_discarded == 2)
							{ remove_from_group = room.tables[table_index].players[1].card_group2;}
							if(group_from_discarded == 3)
							{ remove_from_group = room.tables[table_index].players[1].card_group3;}
							if(group_from_discarded == 4)
							{ remove_from_group = room.tables[table_index].players[1].card_group4;}
							if(group_from_discarded == 5)
							{ remove_from_group = room.tables[table_index].players[1].card_group5;}
							if(group_from_discarded == 6)
							{ remove_from_group = room.tables[table_index].players[1].card_group6;}
							if(group_from_discarded == 7)
							{ remove_from_group = room.tables[table_index].players[1].card_group7;}
							
							discard_data_temp = getDiscardFromSortGroupCards(remove_from_group,discareded_return_card,group_from_discarded);
							room.tables[table_index].open_card_obj_arr = [];
							room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
							room.tables[table_index].open_card_status = "discard";
							room.tables[table_index].open_cards.push(discard_data_temp);
							remove_from_group= removeFromSortedHandCards(remove_from_group,discareded_return_card,group_from_discarded);
						}
						
						//show open card  
						if(room.tables[table_index].players[0].id != ''){
							 if(oth_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_card", { path:open_card_path,check:check1,id:open_card_id,discareded_open_card:discard_data_temp,group:group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards });
							}
						}
						if(room.tables[table_index].players[1].id != ''){
							 if(first_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_card", { path:open_card_path,check:check1,id:open_card_id,discareded_open_card:discard_data_temp,group:group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards});
							}
						}
						if(room.tables[table_index].players[1].id != ''){
								room.tables[table_index].players[1].open_close_selected_count = 0;
								if(is_sorted == false && is_grouped == false && is_initial_grouped == false){
									//send updated hand cards 
									if(first_player_status != "disconnected"){
									  io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_hand_cards", { user:user_who_discarded,group:group,round_id:data.round_id,hand_cards:room.tables[table_index].players[1].hand,sidejokername:room.tables[table_index].side_joker_card_name});	
									}
								}
								if(is_sorted == true || is_grouped == true || is_initial_grouped == true){
									if(first_player_status != "disconnected"){
									  io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:user_who_discarded,group:group,round_id:data.round_id,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
									}
								} 
						}
					}
				}
		    }
		}			
	});
	
	////update player group after sort or group///
	socket.on("update_player_groups_sort", function(data) 
	{
		var player = room.getPlayer(socket.id);
		var player_playing = data.player;
		var round = data.round_id;
		var table_index =0;
		console.log("sort group1 : " + data.group);
		table_index = getTableIndex(room.tables,data.group);
		if (table_index == - 1) {
			console.log("\n update_player_groups_sort");
			return;	
		}
		var is_sorted = data.is_sort;
		var is_grouped = data.is_group;
		var is_initial_group = data.is_initial_group;
		console.log("\n  is_sorted "+ is_sorted+" is_grouped "+is_grouped+" is_initial_group "+is_initial_group);
		var oth_player_status,first_player_status;
		
		if(room.tables[table_index].round_id == round)
			{
			  if(room.tables[table_index].players.length == 2 )
			  {
			  oth_player_status = room.tables[table_index].players[0].status;
			  first_player_status = room.tables[table_index].players[1].status;
			  
				if(room.tables[table_index].players[0].name == player_playing)
				{
				room.tables[table_index].players[0].is_grouped = true; 
				
				 var total_hand_card=0;
				        if(room.tables[table_index].players[0].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[0].card_group1.length;
						}
						if(room.tables[table_index].players[0].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[0].card_group2.length;
						}
						if(room.tables[table_index].players[0].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[0].card_group3.length;
						}
						if(room.tables[table_index].players[0].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[0].card_group4.length;
						}
						if(room.tables[table_index].players[0].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[0].card_group5.length;
						}
						if(room.tables[table_index].players[0].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[0].card_group6.length;
						}
						if(room.tables[table_index].players[0].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[0].card_group7.length;
						}
						
			           
				 
						
			            if(total_hand_card == 0){
							if(is_sorted == true)
							{
							/* Updated groups after sort to room.tables[table_index].respective player*/
							room.tables[table_index].players[0].card_group1 = data.group1;
							room.tables[table_index].players[0].card_group2 = data.group2;
							room.tables[table_index].players[0].card_group3 = data.group3;
							room.tables[table_index].players[0].card_group4 = data.group4;
							}
						}
					if(is_initial_group == true)
					{
						var i=0;var n;
						var card_group = data.card_group;
						console.log(" \n card_group"+JSON.stringify(card_group));
						/* Check empty group and add cards to it*/
						check_player_empty_group(0,data.group,card_group);
						/* remove those cards from player hand cards and get remaining into other group*/
						if( card_group != null ) {
							for(var  i = 0; i < card_group.length; i++)
							{
								room.tables[table_index].players[0].hand = removeFromHandCards(room.tables[table_index].players[0].hand,card_group[i].id);
							}
						}
						/* add rem cards to next empty / last  group */
						add_cards_to_last_group(0,data.group,room.tables[table_index].players[0].hand);
					}
					if(is_grouped == true)
					{
						var card_group = data.card_group;
						var parent_group = data.parent_group;
						var remove_from_group;
						var group_no;
						
						console.log(" \n card_group"+JSON.stringify(card_group));
						/* Check empty group and add cards to it*/
						group_no = check_player_empty_group(0,data.group,card_group);
						if(group_no != 8)
						{
							/* remove cards from resp. groups */
							console.log(" \n parent_group 0th pl "+ parent_group.length+" is "+JSON.stringify( parent_group)+" 1st "+ parent_group[0]);
							var i,j;
							for(i = 0; i <= parent_group.length; i++)
							//for(var  i = 0; i <= 7; i++)
							{
							console.log(i+" in for \n "+parent_group[i]);
								if(parent_group[i] == 1)
								{ remove_from_group = room.tables[table_index].players[0].card_group1;}
								if(parent_group[i] == 2)
								{ remove_from_group = room.tables[table_index].players[0].card_group2;}
								if(parent_group[i] == 3)
								{ remove_from_group = room.tables[table_index].players[0].card_group3;}
								if(parent_group[i] == 4)
								{ remove_from_group = room.tables[table_index].players[0].card_group4;}
								if(parent_group[i] == 5)
								{ remove_from_group = room.tables[table_index].players[0].card_group5;}
								if(parent_group[i] == 6)
								{ remove_from_group = room.tables[table_index].players[0].card_group6;}
								if(parent_group[i] == 7)
								{ remove_from_group = room.tables[table_index].players[0].card_group7;}
								
								if( card_group != null ) {
									for(j = 0; j < card_group.length; j++)
									{
									console.log(" in 2nd for \n "+card_group[j]);
										remove_from_group= removeFromSortedHandCards(remove_from_group,card_group[j].id,parent_group[i]);
									}
								}
							}
						}
						else
						{
							if(oth_player_status != "disconnected"){
								if(room.tables[table_index].players[0].id != ''){
								 io.sockets.connected[(room.tables[table_index].players[0].id)].emit("group_limit", { user:player_playing,group:room.tables[table_index].id,round_id:round});
								 }
							}
						}
					}
					/* send updated groups to respective player*/
					 if(oth_player_status != "disconnected"){
						 console.log("sort group : " + room.tables[table_index].id);
						if(room.tables[table_index].players[0].id != ''){
					         io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:player_playing,group:room.tables[table_index].id,round_id:round,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
					    }
					}
				}
				if(room.tables[table_index].players[1].name == player_playing)
				{
				room.tables[table_index].players[1].is_grouped = true; 
				
				
				 var total_hand_card=0;
				        if(room.tables[table_index].players[1].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[1].card_group1.length;
						}
						if(room.tables[table_index].players[1].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[1].card_group2.length;
						}
						if(room.tables[table_index].players[1].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[1].card_group3.length;
						}
						if(room.tables[table_index].players[1].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[1].card_group4.length;
						}
						if(room.tables[table_index].players[1].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[1].card_group5.length;
						}
						if(room.tables[table_index].players[1].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[1].card_group6.length;
						}
						if(room.tables[table_index].players[1].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[1].card_group7.length;
						}
						
			           
				 
						
			            if(total_hand_card == 0){
							 if(is_sorted == true)
								{
								/* Updated groups after sort to table.respective player*/
								room.tables[table_index].players[1].card_group1 = data.group1;
								room.tables[table_index].players[1].card_group2 = data.group2;
								room.tables[table_index].players[1].card_group3 = data.group3;
								room.tables[table_index].players[1].card_group4 = data.group4;
								}
						}
					if(is_initial_group == true)
					{
					var i=1; var available_grp_id;
					var empty_group;
					var card_group = data.card_group;
					   /* Check empty group and Update groups after group to table.respective player*/
					   check_player_empty_group(1,data.group,data.card_group);
					   /* remove those cards from player hand cards and get remaining into other group*/
					   if( card_group != null ) {
							for(var  i = 0; i < card_group.length; i++)
							{
								room.tables[table_index].players[1].hand = removeFromHandCards(room.tables[table_index].players[1].hand,card_group[i].id);
							}
						}
						/* add rem cards to next empty group */
						//check_player_empty_group(1,data.group,room.tables[table_index].players[1].hand);
						add_cards_to_last_group(1,data.group,room.tables[table_index].players[1].hand);
						
					}
					if(is_grouped == true)
					{
						var card_group = data.card_group;
						var parent_group = data.parent_group;
						var remove_from_group;
						var group_no;
						
						console.log(" \n card_group "+JSON.stringify(card_group));
						/* Check empty group and add cards to it*/
						group_no = check_player_empty_group(1,data.group,card_group);
						if(group_no != 8)
						{
							/* remove cards from resp. groups */
							console.log(" \n parent_group 1st pl "+ parent_group.length+" is "+JSON.stringify( parent_group)+" 1st "+ parent_group[0]);
							var i,j;
							for(i = 0; i <= parent_group.length; i++)
							//for(var  i = 0; i <= 7; i++)
							{
							console.log(" in for \n "+parent_group[i]);
								if(parent_group[i] == 1)
								{ remove_from_group = room.tables[table_index].players[1].card_group1;}
								if(parent_group[i] == 2)
								{ remove_from_group = room.tables[table_index].players[1].card_group2;}
								if(parent_group[i] == 3)
								{ remove_from_group = room.tables[table_index].players[1].card_group3;}
								if(parent_group[i] == 4)
								{ remove_from_group = room.tables[table_index].players[1].card_group4;}
								if(parent_group[i] == 5)
								{ remove_from_group = room.tables[table_index].players[1].card_group5;}
								if(parent_group[i] == 6)
								{ remove_from_group = room.tables[table_index].players[1].card_group6;}
								if(parent_group[i] == 7)
								{ remove_from_group = room.tables[table_index].players[1].card_group7;}
								
								if(card_group != null) {
									for(j = 0; j < card_group.length; j++)
									{
									console.log(" in 2nd for \n "+card_group[j]);
										remove_from_group= removeFromSortedHandCards(remove_from_group,card_group[j].id,parent_group[i]);
									}
								}
							}
						}
						else
						{
						 if(first_player_status != "disconnected"){
						    if(room.tables[table_index].players[1].id != ''){
						     io.sockets.connected[(room.tables[table_index].players[1].id)].emit("group_limit", { user:player_playing,group:room.tables[table_index].id,round_id:round});
							 }
						}
						}
					}
					/* send updated groups to respective player*/
					 if(first_player_status != "disconnected"){
						console.log("sort group : " + room.tables[table_index].id);
						if(room.tables[table_index].players[1].id != ''){
					       io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:player_playing,group:room.tables[table_index].id,round_id:round,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
					    }
					}
				}
			  }
			}
	});
	
	////add here on single card select if card groups 
	socket.on("add_here", function(data) 
	{
		var player = room.getPlayer(socket.id);
		var player_playing = data.player;
		var round = data.round_id;
		var table_index =0;
		table_index = getTableIndex(room.tables,data.group);
		if (table_index == - 1) {
			console.log("\n add_here");
			return;	
		}
		var group_from_remove = data.remove_from_group;
		var group_to_add = data.add_to_group;
		var card_to_remove = data.selected_card;
		var selected_card_src = data.selected_card_src;
		var oth_player_status,first_player_status;
		
		////check here whether sorting or grouping done for groups 
		console.log("\n GROUP FROM REMOVE "+group_from_remove+" ADD TO GROUP "+group_to_add+" CARD IS "+JSON.stringify(selected_card_src));
		var add_to_group,remove_from_group;
					
		if(room.tables[table_index].round_id == round)
			{
			  if(room.tables[table_index].players.length == 2 )
			  {
			   oth_player_status = room.tables[table_index].players[0].status;
			   first_player_status = room.tables[table_index].players[1].status;
			  
				if(room.tables[table_index].players[0].name == player_playing)
				{
				////define group from remove card
				if(group_from_remove == 1)
				{ remove_from_group = room.tables[table_index].players[0].card_group1;}
				if(group_from_remove == 2)
				{ remove_from_group = room.tables[table_index].players[0].card_group2;}
				if(group_from_remove == 3)
				{ remove_from_group = room.tables[table_index].players[0].card_group3;}
				if(group_from_remove == 4)
				{ remove_from_group = room.tables[table_index].players[0].card_group4;} 
				if(group_from_remove == 5)
				{ remove_from_group = room.tables[table_index].players[0].card_group5;} 
				if(group_from_remove == 6)
				{ remove_from_group = room.tables[table_index].players[0].card_group6;} 
				if(group_from_remove == 7)
				{ remove_from_group = room.tables[table_index].players[0].card_group7;} 
				
				////define group to which add card
				if(group_to_add == 1)
				{ add_to_group = room.tables[table_index].players[0].card_group1;}
				if(group_to_add == 2)
				{ add_to_group = room.tables[table_index].players[0].card_group2;}
				if(group_to_add == 3)
				{ add_to_group = room.tables[table_index].players[0].card_group3;}
				if(group_to_add == 4)
				{ add_to_group = room.tables[table_index].players[0].card_group4;} 
				if(group_to_add == 5)
				{ add_to_group = room.tables[table_index].players[0].card_group5;} 
				if(group_to_add == 6)
				{ add_to_group = room.tables[table_index].players[0].card_group6;} 
				if(group_to_add == 7)
				{ add_to_group = room.tables[table_index].players[0].card_group7;} 
				
					//remove from group of image clicked
					
					console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					remove_from_group= removeFromSortedHandCards(remove_from_group,card_to_remove,group_from_remove);
					console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					//add card to selected group
					console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					add_to_group.push(selected_card_src);
					console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					 if(oth_player_status != "disconnected"){
						if(room.tables[table_index].players[0].id != ''){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:player_playing,group:room.tables[table_index].id,round_id:round,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
						}
					}
				}
				if(room.tables[table_index].players[1].name == player_playing)
				{
				  ////define group from remove card
					if(group_from_remove == 1)
					{ remove_from_group = room.tables[table_index].players[1].card_group1;}
					if(group_from_remove == 2)
					{ remove_from_group = room.tables[table_index].players[1].card_group2;}
					if(group_from_remove == 3)
					{ remove_from_group = room.tables[table_index].players[1].card_group3;}
					if(group_from_remove == 4)
					{ remove_from_group = room.tables[table_index].players[1].card_group4;} 
					if(group_from_remove == 5)
					{ remove_from_group = room.tables[table_index].players[1].card_group5;} 
					if(group_from_remove == 6)
					{ remove_from_group = room.tables[table_index].players[1].card_group6;} 
					if(group_from_remove == 7)
					{ remove_from_group = room.tables[table_index].players[1].card_group7;} 
					////define group to which add card
					if(group_to_add == 1)
					{ add_to_group = room.tables[table_index].players[1].card_group1;}
					if(group_to_add == 2)
					{ add_to_group = room.tables[table_index].players[1].card_group2;}
					if(group_to_add == 3)
					{ add_to_group = room.tables[table_index].players[1].card_group3;}
					if(group_to_add == 4)
					{ add_to_group = room.tables[table_index].players[1].card_group4;} 
					if(group_to_add == 5)
					{ add_to_group = room.tables[table_index].players[1].card_group5;} 
					if(group_to_add == 6)
					{ add_to_group = room.tables[table_index].players[1].card_group6;} 
					if(group_to_add == 7)
					{ add_to_group = room.tables[table_index].players[1].card_group7;} 
				//remove from group of image clicked
					console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[1].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					remove_from_group= removeFromSortedHandCards(remove_from_group,card_to_remove,group_from_remove);
					console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[1].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					//add card to selected group
					console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[1].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					add_to_group.push(selected_card_src);
					console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[1].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					
					 if(first_player_status != "disconnected"){
					    if(room.tables[table_index].players[1].id != ''){
					       io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:player_playing,group:room.tables[table_index].id,round_id:round,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
						}
					}
				}
			  }
			}
	});//add_here ends 
	
	
	
	socket.on("add_here_drop", function(data) 
	{
		var player = room.getPlayer(socket.id);
		var player_playing = data.player;
		var round = data.round_id;
		var position = data.position;
		var table_index =0;
		table_index = getTableIndex(room.tables,data.group);
		if (table_index == - 1) {
			console.log("\n add_here");
			return;	
		}
		var group_from_remove = data.remove_from_group;
		var group_to_add = data.add_to_group;
		var card_to_remove = data.selected_card;
		var selected_card_src = data.selected_card_src;
		var oth_player_status,first_player_status;
		
		////check here whether sorting or grouping done for groups 
		console.log("\n GROUP FROM REMOVE "+group_from_remove+" ADD TO GROUP "+group_to_add+" CARD IS "+JSON.stringify(selected_card_src));
		var add_to_group,remove_from_group;
					
		if(room.tables[table_index].round_id == round)
			{
			  if(room.tables[table_index].players.length == 2 )
			  {
			   oth_player_status = room.tables[table_index].players[0].status;
			   first_player_status = room.tables[table_index].players[1].status;
			  
				if(room.tables[table_index].players[0].name == player_playing)
				{
				////define group from remove card
				if(group_from_remove == 1)
				{ remove_from_group = room.tables[table_index].players[0].card_group1;}
				if(group_from_remove == 2)
				{ remove_from_group = room.tables[table_index].players[0].card_group2;}
				if(group_from_remove == 3)
				{ remove_from_group = room.tables[table_index].players[0].card_group3;}
				if(group_from_remove == 4)
				{ remove_from_group = room.tables[table_index].players[0].card_group4;} 
				if(group_from_remove == 5)
				{ remove_from_group = room.tables[table_index].players[0].card_group5;} 
				if(group_from_remove == 6)
				{ remove_from_group = room.tables[table_index].players[0].card_group6;} 
				if(group_from_remove == 7)
				{ remove_from_group = room.tables[table_index].players[0].card_group7;} 
				
				////define group to which add card
				if(group_to_add == 1)
				{ add_to_group = room.tables[table_index].players[0].card_group1;}
				if(group_to_add == 2)
				{ add_to_group = room.tables[table_index].players[0].card_group2;}
				if(group_to_add == 3)
				{ add_to_group = room.tables[table_index].players[0].card_group3;}
				if(group_to_add == 4)
				{ add_to_group = room.tables[table_index].players[0].card_group4;} 
				if(group_to_add == 5)
				{ add_to_group = room.tables[table_index].players[0].card_group5;} 
				if(group_to_add == 6)
				{ add_to_group = room.tables[table_index].players[0].card_group6;} 
				if(group_to_add == 7)
				{ add_to_group = room.tables[table_index].players[0].card_group7;} 
				
					//remove from group of image clicked
					
					console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					remove_from_group= removeFromSortedHandCards(remove_from_group,card_to_remove,group_from_remove);
					console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					//add card to selected group
					console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					//add_to_group.push(selected_card_src);
					add_to_group.splice(position, 0, selected_card_src);
					console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					 if(oth_player_status != "disconnected"){
						if(room.tables[table_index].players[0].id != ''){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("update_player_groups_sort", { user:player_playing,group:room.tables[table_index].id,round_id:round,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
						}
					}
				}
				if(room.tables[table_index].players[1].name == player_playing)
				{
				  ////define group from remove card
					if(group_from_remove == 1)
					{ remove_from_group = room.tables[table_index].players[1].card_group1;}
					if(group_from_remove == 2)
					{ remove_from_group = room.tables[table_index].players[1].card_group2;}
					if(group_from_remove == 3)
					{ remove_from_group = room.tables[table_index].players[1].card_group3;}
					if(group_from_remove == 4)
					{ remove_from_group = room.tables[table_index].players[1].card_group4;} 
					if(group_from_remove == 5)
					{ remove_from_group = room.tables[table_index].players[1].card_group5;} 
					if(group_from_remove == 6)
					{ remove_from_group = room.tables[table_index].players[1].card_group6;} 
					if(group_from_remove == 7)
					{ remove_from_group = room.tables[table_index].players[1].card_group7;} 
					////define group to which add card
					if(group_to_add == 1)
					{ add_to_group = room.tables[table_index].players[1].card_group1;}
					if(group_to_add == 2)
					{ add_to_group = room.tables[table_index].players[1].card_group2;}
					if(group_to_add == 3)
					{ add_to_group = room.tables[table_index].players[1].card_group3;}
					if(group_to_add == 4)
					{ add_to_group = room.tables[table_index].players[1].card_group4;} 
					if(group_to_add == 5)
					{ add_to_group = room.tables[table_index].players[1].card_group5;} 
					if(group_to_add == 6)
					{ add_to_group = room.tables[table_index].players[1].card_group6;} 
					if(group_to_add == 7)
					{ add_to_group = room.tables[table_index].players[1].card_group7;} 
				//remove from group of image clicked
					console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[1].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					remove_from_group= removeFromSortedHandCards(remove_from_group,card_to_remove,group_from_remove);
					console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[1].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					//add card to selected group
					console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[1].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					//add_to_group.push(selected_card_src);
					add_to_group.splice(position, 0, selected_card_src);
					console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[1].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
					
					 if(first_player_status != "disconnected"){
					    if(room.tables[table_index].players[1].id != ''){
					       io.sockets.connected[(room.tables[table_index].players[1].id)].emit("update_player_groups_sort", { user:player_playing,group:room.tables[table_index].id,round_id:round,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
						}
					}
				}
			  }
			}
	});//add_here ends 
	
	function check_player_empty_group(player_id,group,card_group)
	{
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n check_player_empty_group");
			return;	
		}
		var i = player_id;
		var empty_group;
		for(var k=1; k<=7; k++)
		{
			if(room.tables[table_index].players[i].card_group1.length == 0)
				{
					room.tables[table_index].players[i].card_group1 = card_group;
					n=1;
					break;
				}
				if(room.tables[table_index].players[i].card_group2.length == 0)
				{
					room.tables[table_index].players[i].card_group2 = card_group;
					n=2;
					break;
				}
				if(room.tables[table_index].players[i].card_group3.length == 0)
				{
					room.tables[table_index].players[i].card_group3 = card_group;
					n=3;
					break;
				}
				if(room.tables[table_index].players[i].card_group4.length == 0)
				{
					room.tables[table_index].players[i].card_group4 = card_group;
					n=4;
					break;
				}
				if(room.tables[table_index].players[i].card_group5.length == 0)
				{
					room.tables[table_index].players[i].card_group5 = card_group;
					n=5;
					break;
				}
				if(room.tables[table_index].players[i].card_group6.length == 0)
				{
					room.tables[table_index].players[i].card_group6 = card_group;
					n=6;
					break;
				}
				else
				{
					n =8;
				}
				if(room.tables[table_index].players[i].card_group7.length == 0)
				{
					room.tables[table_index].players[i].card_group7 = card_group;
					n=7;
					break;
				} 
		}
		console.log("After group created, card group no "+n);
		return n;
	}//check_player_empty_group ends 
	
	function add_cards_to_last_group(player_id,group,card_group)
	{
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n add_cards_to_last_group");
			return;	
		}
		var i = player_id;
		room.tables[table_index].players[i].card_group7 = card_group;
		console.log("After group created, card group no "+n+" updated.");
	}

	function update_game_details_func(table_index) {
	
		var table_open_cards = [];var table_close_cards = [];
		//rem-open-cards
		for (var i = 0; i < room.tables[table_index].open_cards.length; i++){
			table_open_cards.push(room.tables[table_index].open_cards[i].id);
		}
		console.log("\n table_open_cards id array ----------> "+JSON.stringify(table_open_cards));
		//rem-closed-cards
		for (var i = 0; i < room.tables[table_index].closed_cards_arr.length; i++){
			table_close_cards.push(room.tables[table_index].closed_cards_arr[i].id);
		}
		console.log("\n table_close_cards id array ----------> "+JSON.stringify(table_close_cards));
		for (var i = 0; i < room.tables[table_index].players.length; i++){
		  
			var player_card_group1 = [];var player_card_group2 = [];var player_card_group3 = [];var player_card_group4 = [];
			var player_card_group5 = [];var player_card_group6 = [];var player_card_group7 = [];
			if(room.tables[table_index].players[i].card_group1.length != 0)
			{
			   
				for (var j = 0; j < room.tables[table_index].players[i].card_group1.length; j++)
				{
				  
					player_card_group1.push(room.tables[table_index].players[i].card_group1[j].id);
				}
			}
			if(room.tables[table_index].players[i].card_group2.length != 0)
			{
			   
				for (var j = 0; j < room.tables[table_index].players[i].card_group2.length; j++)
				{
					player_card_group2.push(room.tables[table_index].players[i].card_group2[j].id);
				}
			}
			if(room.tables[table_index].players[i].card_group3.length != 0)
			{
			  
				for (var j = 0; j < room.tables[table_index].players[i].card_group3.length; j++)
				{
					player_card_group3.push(room.tables[table_index].players[i].card_group3[j].id);
				}
			}
			if(room.tables[table_index].players[i].card_group4.length != 0)
			{
			   
				for (var j = 0; j < room.tables[table_index].players[i].card_group4.length; j++)
				{
					player_card_group4.push(room.tables[table_index].players[i].card_group4[j].id);
				}
			}
			if(room.tables[table_index].players[i].card_group5.length != 0)
			{
			   
				for (var j = 0; j < room.tables[table_index].players[i].card_group5.length; j++)
				{
					player_card_group5.push(room.tables[table_index].players[i].card_group5[j].id);
				}
			}
			if(room.tables[table_index].players[i].card_group6.length != 0)
			{
			   
				for (var j = 0; j < room.tables[table_index].players[i].card_group6.length; j++)
				{
					player_card_group6.push(room.tables[table_index].players[i].card_group6[j].id);
				}
			}
			if(room.tables[table_index].players[i].card_group7.length != 0)
			{
			  
				for (var j = 0; j < room.tables[table_index].players[i].card_group7.length; j++)
				{
					player_card_group7.push(room.tables[table_index].players[i].card_group7[j].id);
				}
			}
			

			var update_game_details = "update game_details set `group1`='"+player_card_group1+"',`group2`='"+player_card_group2+"',`group3`='"+player_card_group3+"',`group4`='"+player_card_group4+"',`group5`='"+player_card_group5+"',`group6`='"+player_card_group6+"',`group7`='"+player_card_group7+"',`close_cards`='"+table_close_cards+"',`open_card`='"+table_open_cards+"'  WHERE `user_id`='"+room.tables[table_index].players[i].name+"' and `group_id`='"+room.tables[table_index].id+"' and `round_id`='"+room.tables[table_index].round_id+"' ORDER BY id DESC LIMIT 1";
			con.query(update_game_details, function (err, result) 
			{
				if (err){ console.log("\n update_game_details Error========================"+update_game_details);}else { console.log(result.affectedRows + " record(s) updated of game_details");}
			});
		}//for ends 
	}
	
	//// show  selected card to finish  card ///
	socket.on("show_finish_card", function(data)
	{	
		var player = room.getPlayer(socket.id);
		var player_playing = data.player;
		var group = data.group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n show_finish_card");
			return;	
		}
		var finished_card = data.finish_card_obj;
		
		room.tables[table_index].finish_card_object = finished_card;
		
		console.log("\n finish OBJ ==="+JSON.stringify(finished_card));
				
		var finished_card_id = data.finish_card_id;
		var round = data.round_id;
		var finish_card_path = finished_card.card_path;
		var is_sorted = data.is_sort;
		var is_grouped = data.is_group;
		var is_initial_grouped = data.is_initial_group;
		var group_from_finished = data.group_from_finished;
		var is_finished = data.is_finished;
		var remove_from_group;
		var oth_player_status,first_player_status;
		
		console.log("\n __________________ finish OBJ ==="+JSON.stringify(room.tables[table_index].finish_card_object)+"--is finished --->"+is_finished);
		
		console.log("\n **** FINISH IS SORT "+is_sorted+" is grp of grp "+is_grouped+" is intial grp "+is_initial_grouped);
		console.log("\n finish FROM GRP "+data.group_from_finished+"==="+JSON.stringify(finished_card)+" is_finished "+is_finished);
		

var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.player)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card > 13){
        		
		if(room.tables[table_index].round_id == round)
		{
		  if(room.tables[table_index].players.length == 2 )
		  {
			oth_player_status = room.tables[table_index].players[0].status;
			first_player_status = room.tables[table_index].players[1].status;
		    
			for (var i = 0; i < room.tables[table_index].players.length; i++) 
			{
			  if(room.tables[table_index].players[i].name == player_playing)
			   {
				room.tables[table_index].players[i].gameFinished = true;
			     console.log("\n Player Name "+room.tables[table_index].players[i].name+" is finished "+room.tables[table_index].players[i].gameFinished);
				//// Remove finish card from hand cards//////
				/* 1. Initial if no sort / group */
			    if(is_sorted == false && is_grouped == false && is_initial_grouped == false)
				{
				  console.log("Before finish by Player "+room.tables[table_index].players[i].name+" hand cards: "+room.tables[table_index].players[i].hand.length+" are "+JSON.stringify(room.tables[table_index].players[i].hand));
				
					room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,finished_card_id);
						
			      console.log("After Finish by Player "+room.tables[table_index].players[i].name+" hand cards : "+room.tables[table_index].players[i].hand.length+" are "+JSON.stringify(room.tables[table_index].players[i].hand));
			    }
				if(is_sorted == false && is_grouped == false && is_initial_grouped == false)
				{
					//send updated hand cards 
					if(room.tables[table_index].players[i].id != ''){
						 if(room.tables[table_index].players[i].status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_hand_cards", { user:player_playing,group:group,round_id:round,hand_cards:room.tables[table_index].players[i].hand,sidejokername:room.tables[table_index].side_joker_card_name});	
						}
					}
				}
				
				/* 2. If sort / group */
				if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
					 {
					    if(group_from_finished == 1)
						{ remove_from_group = room.tables[table_index].players[i].card_group1;}
						if(group_from_finished == 2)
						{ remove_from_group = room.tables[table_index].players[i].card_group2;}
						if(group_from_finished == 3)
						{ remove_from_group = room.tables[table_index].players[i].card_group3;}
						if(group_from_finished == 4)
						{ remove_from_group = room.tables[table_index].players[i].card_group4;}
						if(group_from_finished == 5)
						{ remove_from_group = room.tables[table_index].players[i].card_group5;}
						if(group_from_finished == 6)
						{ remove_from_group = room.tables[table_index].players[i].card_group6;}
						if(group_from_finished == 7)
						{ remove_from_group = room.tables[table_index].players[i].card_group7;}
						
						if( remove_from_group ) {
							console.log("\n SORTING/GROUP Before finish by Player "+room.tables[table_index].players[i].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
							
							remove_from_group= removeFromSortedHandCards(remove_from_group,finished_card_id,group_from_finished);
							
							console.log("\n SORTING AFTER finish by Player "+room.tables[table_index].players[i].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						}
					  }
					  if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
					  {
					   if(room.tables[table_index].players[i].status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_sort", { user:player_playing,group:group,round_id:round,grp1_cards:room.tables[table_index].players[i].card_group1,grp2_cards:room.tables[table_index].players[i].card_group2,grp3_cards:room.tables[table_index].players[i].card_group3,grp4_cards:room.tables[table_index].players[i].card_group4,grp5_cards:room.tables[table_index].players[i].card_group5,grp6_cards:room.tables[table_index].players[i].card_group6,grp7_cards:room.tables[table_index].players[i].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
						}
					  } 
					  
				//// emit finish card to both players 
				if(room.tables[table_index].players[0].id != ''){
					 if(oth_player_status != "disconnected"){
					   io.sockets.connected[(room.tables[table_index].players[0].id)].emit("finish_card", { user:room.tables[table_index].players[0].name,group:group,round_id:round,path:finish_card_path});	
					}
				}
				if(room.tables[table_index].players[1].id != ''){
					 if(first_player_status != "disconnected"){
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("finish_card", { user:room.tables[table_index].players[1].name,group:group,round_id:round,path:finish_card_path});	
					}
				}
			}
		   }//for ends 
	 	  }
		  }
		}
	});//show_finish_card ends 
	
	
	socket.on("declare_game", function(data) {	
		var group = data.group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n declare_game");
			return;	
		}
		
		
		var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card <= 13){
			
			if(room.tables[table_index].players[selected_user].is_turn == true){
		
		             console.log("\n declared game of type "+room.tables[table_index].game_type);
		
		        declare_papplu_game_data(data.user,data.group,data.round_id,data.pl_amount_taken,data.is_sort,data.is_group,data.is_initial_group,room.tables[table_index].table_point_value,room.tables[table_index].game_type,room.tables[table_index].table_name);
		    }else{
				return;
			}
		}else{
				return;
		}
			
	});//declare_game ends
	

	function drop_game_func(dropped_player, group, round_id, is_sorted, is_grouped, is_initial_grouped) {
			console.log("\n ***** GAME DROPPED =============dropped_player "+dropped_player);
			var player = room.getPlayer(socket.id);
			var table_index =0;
			table_index = getTableIndex(room.tables,group);
			if (table_index == - 1) { console.log("\n drop_game"); return;}
			var dt = KolkataTime();
            var table_game = room.tables[table_index].table_game;
			
			var group1 = [],group2 = [],group3 = [],group4 = [],group5 = [],group6 = [],group7 = []; 
			
			var opponent_player;
			var dropped_player_grouped = false;
			var other_player_grouped = false;
			var oth_player_status,first_player_status;
			var dropped_pl_score =0, opp_pl_score =0;
			var dropped_pl_won_amount =0, opp_pl_won_amount =0;
			var score =0;
			var players_name="";
			var winner_won_amount = 0;
			var company_commision_amount=0;
			var table_player_capacity = 0;
			table_player_capacity = room.tables[table_index].playerCapacity;
			
			console.log("\n dropped user "+dropped_player+" did sorting "+is_sorted+" initial grouping "+is_initial_grouped+" grouping "+is_grouped);
			
			if(room.tables[table_index].round_id == round_id)
			{
				if(room.tables[table_index].players[0].name == dropped_player)
				{
					//room.tables[table_index].players[0].dropped = true;
					room.tables[table_index].players[0].is_dropped_game = true;
					room.tables[table_index].players[1].is_dropped_game = true;
					
					room.tables[table_index].players[0].game_status = "Lost";
					room.tables[table_index].players[1].game_status = "Won";
					room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
					room.tables[table_index].player2_name = room.tables[table_index].players[0].name;
					
					opponent_player = room.tables[table_index].players[1].name;
					dropped_player_grouped = room.tables[table_index].players[0].is_grouped;
					other_player_grouped = room.tables[table_index].players[1].is_grouped;
				}
				if(room.tables[table_index].players[1].name == dropped_player)
				{
					//room.tables[table_index].players[1].dropped = true;
					room.tables[table_index].players[1].is_dropped_game = true;
					room.tables[table_index].players[0].is_dropped_game = true;

					
					room.tables[table_index].players[1].game_status = "Lost";
					room.tables[table_index].players[0].game_status = "Won";
					room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
					room.tables[table_index].player2_name = room.tables[table_index].players[0].name;
					
					opponent_player = room.tables[table_index].players[0].name;
					dropped_player_grouped = room.tables[table_index].players[1].is_grouped;
					other_player_grouped = room.tables[table_index].players[0].is_grouped;
				}
				
				oth_player_status= room.tables[table_index].players[0].status;
				first_player_status = room.tables[table_index].players[1].status;
				/*First joined user dropped the game*/
			    if(room.tables[table_index].players[0].name == dropped_player)
				{
					
					
					console.log(" \n oth DROPPED game "+room.tables[table_index].player1_name+" pl1 amt "+room.tables[table_index].players[0].amount_playing+" pl2 "+room.tables[table_index].player2_name+" pl2 amt "+room.tables[table_index].players[1].amount_playing);
					room.tables[table_index].players[0].turn_count++;
                    room.tables[table_index].isfirstTurn = false;
					
					score= room.tables[table_index].table_min_entry;
					
					console.log("\n TEmp Score TWo Player drop =============================="+score);
					room.tables[table_index].players[0].game_score = score; 
					room.tables[table_index].players[1].game_score = 0;
					room.tables[table_index].players[0].amount_won = getFixedNumber(-(+((score))));
					room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing-(score))));
					revertBonus(room.tables[table_index].players[0].name, score, table_game);
					if(table_game == 'Free Game'){
						room.tables[table_index].players[1].amount_won = getFixedNumber(+((score)));
						room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing+(score))));
					}
					if(table_game == 'Cash Game'){
						winner_won_amount = score;
						company_commision_amount=(winner_won_amount*company_commision)/100;
						winner_won_amount = winner_won_amount-company_commision_amount;
						room.tables[table_index].players[1].amount_won = getFixedNumber(+((winner_won_amount)));
						room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing+(winner_won_amount))));

						/********* Inserting commision details to 'company_balance' table ******/
						players_name=room.tables[table_index].player1_name+","+room.tables[table_index].player2_name;
						commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+players_name+"',now())";
						con.query(commision_query, function(err1, result){
							 if (err1) {
										console.log(err1);
							} 
							
							
							}); 
					}
						
						
					room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
					room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;
						
					/** Players game status**/
					room.tables[table_index].player1_game_status = "Won";
					room.tables[table_index].player2_game_status = "Lost";
					/** Players User Id**/
					room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
					room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;
						
						
					transaction_id = Math.floor(Math.random() * 100000000000000);
					/**** Inserting Transaction Details to database once game end/restarted ****/
					/*For lost amount*/
					console.log("Qry=====================1");
					insert_query="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,`table_name`, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[0].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[0].name+"','"+room.tables[table_index].players[0].game_status+"','"+(room.tables[table_index].players[0].amount_won * -1)+"','"+dt+"')";
					con.query(insert_query, function(err1, result){
					    if (err1) {
							console.log(err1);
						} 
					}); 
					/*For wining amount*/
					console.log("Qry=====================2");
					insert_query1="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,`table_name`, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[1].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[1].name+"','"+room.tables[table_index].players[1].game_status+"','"+room.tables[table_index].players[1].amount_won+"','"+dt+"')";
					con.query(insert_query1, function(err1, result){
					 if (err1) {
							console.log(err1);
						} 
					});
						
					update_game_details_func(table_index);
					console.log("\n GAME DROPED by pl2 "+room.tables[table_index].player2_name+" with "+room.tables[table_index].player2_amount+" Winner is pl1 "+room.tables[table_index].player1_name+" with "+room.tables[table_index].player1_amount);
					
					/** Amount Updated after game end of player (if disconnected)**/
					if(first_player_status == "disconnected"){
					// update_balance_after_declare(room.tables[table_index].players[1].name,group,room.tables[table_index].players[1].amount_playing,false);
					// removePlayerFromTable( room.tables[table_index].players[1].name, group );
					}
						
						
					if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
					{dropped_player_grouped = true;}
					else {dropped_player_grouped = false;}
						
						//1st player - no group and 2nd player - no group
					if(dropped_player_grouped == false && other_player_grouped == false){

						console.log("\n in 0 1st group- false , 2nd group - false");
						if(room.tables[table_index].players[0].id != ''){
							if(oth_player_status != "disconnected"){
								io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
							}
						}
						if(room.tables[table_index].players[1].id != ''){
							if(first_player_status != "disconnected"){
								io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:opponent_player,user_grouped:other_player_grouped,other_grouped:dropped_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
							}
						}
					}
					  //1st player - grouped and 2nd player - no group
					if(dropped_player_grouped == true && other_player_grouped == false)
					{
					    console.log("\n in 0  1st group- true , 2nd group - false");
					    if(room.tables[table_index].players[0].id != ''){
						  if(oth_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
							}
						}
						if(room.tables[table_index].players[1].id != ''){
							if(first_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:opponent_player,user_grouped:other_player_grouped,other_grouped:dropped_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
							}
						}
					}
					  //1st player - no group and 2nd player - grouped
					if(dropped_player_grouped == false && other_player_grouped == true)
					{
					    console.log("\n in 0  1st group- false , 2nd group - true");
					   if(room.tables[table_index].players[0].id != ''){
						   if(oth_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
							}
						}
						if(room.tables[table_index].players[1].id != ''){
							if(first_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:opponent_player,user_grouped:other_player_grouped,other_grouped:dropped_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
							}
						}
						
					}
					  //both player - grouped
					if(dropped_player_grouped == true && other_player_grouped == true)
					{ 
					    console.log("\n 1st in 0  group- true , 2nd group - true");
					  
							if(room.tables[table_index].players[0].id != ''){
								  if(oth_player_status != "disconnected"){
									io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
								  }
							}
							if(room.tables[table_index].players[1].id != ''){
								  if(first_player_status != "disconnected"){
									io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:opponent_player,user_grouped:other_player_grouped,other_grouped:dropped_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
									}
							}
					}
					   
					  
				}else{
					console.log(" \n 1st DROPPED game "+room.tables[table_index].player1_name+" pl1 amt "+room.tables[table_index].players[0].amount_playing+" pl2 "+room.tables[table_index].player2_name+" pl2 amt "+room.tables[table_index].players[1].amount_playing);
					room.tables[table_index].players[1].turn_count++;
					room.tables[table_index].isfirstTurn = false;
						
					score=0;
					if(room.tables[table_index].players[1].player_start_play == true){
					  score=room.tables[table_index].table_min_entry*2;
					}else{
					  score= room.tables[table_index].table_min_entry;
					}
					room.tables[table_index].players[1].game_score = score; 
					room.tables[table_index].players[0].game_score = 0;
					room.tables[table_index].players[1].amount_won = getFixedNumber(-(+((score))));
					room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing-(score))));
					revertBonus(room.tables[table_index].players[1].name, score, table_game);
						
					if(table_game == 'Free Game'){
						room.tables[table_index].players[0].amount_won = getFixedNumber(+((score)));
						room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing+(score))));
					}
					if(table_game == 'Cash Game'){
						winner_won_amount = score;
						company_commision_amount=(winner_won_amount*company_commision)/100;
						winner_won_amount = winner_won_amount-company_commision_amount;
						room.tables[table_index].players[0].amount_won = getFixedNumber(+((winner_won_amount)));
						room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing+(winner_won_amount))));

						/********* Inserting commision details to 'company_balance' table ******/
						players_name=room.tables[table_index].player1_name+","+room.tables[table_index].player2_name;
						commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+players_name+"',now())";
						console.log(commision_query);
						con.query(commision_query, function(err1, result){
						 if (err1) {
							console.log(err1);
						} 	
							
						});  
					}
                        

					room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
					room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;

					room.tables[table_index].player1_game_status = "Lost";
					room.tables[table_index].player2_game_status = "Won";
				
					room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
					room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;
						
					//console.log(" \N GAME DROPPED pl1 "+room.tables[table_index].player1_name+" pl1 amt "+room.tables[table_index].player1_amount+" pl2 "+room.tables[table_index].player2_name+" pl2 amt "+room.tables[table_index].player2_amount);
					console.log("\n GAME DROPED by pl1 "+room.tables[table_index].player1_name+" with "+room.tables[table_index].player1_amount+" Winner is pl2 "+room.tables[table_index].player2_name+" with "+room.tables[table_index].player2_amount);
					
					transaction_id = Math.floor(Math.random() * 100000000000000);
					/**** Inserting Transaction Details to database once game end/restarted ****/					
					/*For wining amount*/
					console.log("Qry=====================3");
					insert_query="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[0].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[0].name+"','"+room.tables[table_index].players[0].game_status+"','"+room.tables[table_index].players[0].amount_won+"','"+dt+"')";
					con.query(insert_query, function(err1, result){
					 if (err1) {
							console.log(err1);
						} 
					}); 
					/*For lost amount*/
					console.log("Qry=====================4");
					insert_query1="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[1].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[1].name+"','"+room.tables[table_index].players[1].game_status+"','"+(room.tables[table_index].players[1].amount_won * -1)+"','"+dt+"')";
					con.query(insert_query1, function(err1, result){
					 if (err1) {
							console.log(err1);
						} 
					}); 
						
					update_game_details_func(table_index);

					if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
					{dropped_player_grouped = true;}
					else {dropped_player_grouped = false;}
					
					/** Amount Updated after game end of player (if disconnected)**/
					if(oth_player_status == "disconnected"){
					// update_balance_after_declare(room.tables[table_index].players[0].name,group,room.tables[table_index].players[0].amount_playing,false);
					// removePlayerFromTable( room.tables[table_index].players[0].name, group );
					}
						
						
						//1st player - no group and 2nd player - no group
				    if(dropped_player_grouped == false && other_player_grouped == false)
				    {
					  console.log("\n 1st in 1  group- false , 2nd group - false");
					  
					  
					  if(room.tables[table_index].players[1].id != ''){
					   if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
						if(room.tables[table_index].players[0].id != ''){
						if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
				    }
					  //1st player - grouped and 2nd player - no group
					  if(dropped_player_grouped == true && other_player_grouped == false)
					  {
					  console.log("\n 1st in 1  group- true , 2nd group - false");
					   if(room.tables[table_index].players[1].id != ''){
					    if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
						if(room.tables[table_index].players[0].id != ''){
						if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:opponent_player,user_grouped:other_player_grouped,other_grouped:dropped_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
					  }
					  //1st player - no group and 2nd player - grouped
					  if(dropped_player_grouped == false && other_player_grouped == true)
					  {
					  console.log("\n 1st in 1  group- false , 2nd group - true");
					  if(room.tables[table_index].players[1].id != ''){
							  if(first_player_status != "disconnected"){
								io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
								}
						}
						if(room.tables[table_index].players[0].id != ''){
								if(oth_player_status != "disconnected"){
								io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:opponent_player,user_grouped:other_player_grouped,other_grouped:dropped_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
								}
						}
					  }
					  //both player - grouped
					   if(dropped_player_grouped == true && other_player_grouped == true)
					  { 
					  console.log("\n 1st in 1  group- true , 2nd group - true");
					  if(room.tables[table_index].players[1].id != ''){
						  if(first_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:opponent_player,user_grouped:dropped_player_grouped,other_grouped:other_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						  }
					  }
					  if(room.tables[table_index].players[0].id != ''){
						  if(oth_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user:dropped_player,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:opponent_player,user_grouped:other_player_grouped,other_grouped:dropped_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						  }
					  }
					  
					  
					}
					}//1st -player -dropped 
					
					room.tables[table_index].papplu_joker_card = "";
					room.tables[table_index].papplu_joker_card_name = "";
					room.tables[table_index].papplu_joker_card_id="";
			}//same-table-round-id
	}

	
	socket.on("drop_game", function(data) 
	{
		var group = data.group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n declare_game_six");
			return;	
		}		
		console.log("\n Six player Game declared of type "+room.tables[table_index].game_type);
	     var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user_who_dropped_game)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card <= 13){
			
			if(room.tables[table_index].players[selected_user].is_turn == true){
		     drop_game_func(data.user_who_dropped_game, data.group, data.round_id, data.is_sort, data.is_group, data.is_initial_group);
			}else{
				return;
			}
		}else{
			return;
		}
	});//drop_game ends 
		
	var declared_groups_array =[];
	var declared_groups_array_papplu =[];
	var declared_groups_array_status =[];
	var declared_invalid_groups_array =[];
	
    function declare_papplu_game_data(declared_player,group,round_id,pl_amount_taken,is_sort,is_group,is_initial_group,table_point_value,game_type)
	{
			var declared_user = declared_player;
			var group = group;
			var table_index =0;
			table_index = getTableIndex(room.tables,group);
			if (table_index == - 1) {
				console.log("\n declare_Papplu_game_data");
				return;	
			}
			
			var dt = KolkataTime();

			var table_game = room.tables[table_index].table_game;
			var round_id = round_id;
			var player = room.getPlayer(socket.id);
			var player_amount = pl_amount_taken;
			var group1 = [],group2 = [],group3 = [],group4 = [],group5 = [],group6 = [],group7 = []; 
			var is_sorted = is_sort;
			var is_grouped = is_group;
			var is_initial_grouped = is_initial_group;
			var player_declared;
			var declared_player_grouped = false;
			var other_declared_player_grouped = false;
			var oth_player_status,first_player_status;
			var group_count = 0;
			var is_pure_valid = false;
			var is_sub_valid = false;
			var is_3rd_valid = false;
			var is_pure = 0;
			var is_sub_sequence =0;
			var is_3rd_sequence =0;
			var is_invalid = 0;
			var winner_won_amount = 0;
			var company_commision_amount=0;
			var table_player_capacity = 0;
			table_player_capacity = room.tables[table_index].playerCapacity;

			console.log("\n declared user in deal rummy "+declared_user+" did sorting "+is_sorted+" initial grouping "+is_initial_grouped+" grouping "+is_grouped);
			
			if(room.tables[table_index].round_id == round_id)
			{
				if(room.tables[table_index].players[0].name == declared_user)
				{ room.tables[table_index].players[0].declared = true; }
				if(room.tables[table_index].players[1].name == declared_user)
				{ room.tables[table_index].players[1].declared = true; }
				
				oth_player_status= room.tables[table_index].players[0].status;
				first_player_status = room.tables[table_index].players[1].status;
                if(room.tables[table_index].declared==0)
				 {
					room.tables[table_index].declared = 1; 
				 }
				 else if(room.tables[table_index].declared==1)
				 { 
					room.tables[table_index].declared= 2; 
				 }
			 
				 if(room.tables[table_index].declared==1)
				 {
			              console.log("\n ......... one player Declared...........");
			 
		if(room.tables[table_index].players[0].name == declared_user)
		{
		
				/***************** Validate Player 1 Declaration **********/
				 declared_groups_array = [];  
				 group_count = get_player_group_count(0,group);
				 //console.log("p1 group_count "+group_count); 
				 
			    if(group_count == 0) {
				  room.tables[table_index].is_declared_valid_sequence = false;
			    }else {
					 if(!valid.validateGroupLimit(group_count))
				    {
					 console.log("\n\n declared_groups_array od p1 --> "+JSON.stringify(declared_groups_array)+"--- arr count --"+declared_groups_array.length);
					    for(var n=0; n<declared_groups_array.length;n++)
					   	{
							is_pure_valid = valid.validatePureSequence(declared_groups_array[n],room.tables[table_index].pure_joker_cards,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards,room.tables[table_index].joker_cards);
							if(!is_pure_valid)
							{
								is_sub_valid = valid.validateSubSequence(declared_groups_array[n],room.tables[table_index].joker_cards,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards);
								if(!is_sub_valid)
								{
									is_3rd_valid = valid.validateSameCardSequence(declared_groups_array[n],room.tables[table_index].joker_cards);
									
									if(!is_3rd_valid)
									{
										if( !valid.validateAllJoker(declared_groups_array[n],room.tables[table_index].joker_cards) ) {
											is_invalid++;
											declared_groups_array_status[n] = "Invalid";
										} else {
											declared_groups_array_status[n] = "Joker";
										}
										declared_groups_array_status[n] = "Invalid";
									}
									else
									{
										is_3rd_sequence++;
										declared_groups_array_status[n] = "Third";
									}
								}
								else 
								{ 
									is_sub_sequence++; 
									declared_groups_array_status[n] = "Sub";
								}
							}
							else 
							{
								is_pure++;
								declared_groups_array_status[n] = "Pure";
							}
					   }//for 
					}else{
					   room.tables[table_index].is_declared_valid_sequence = false;
					}
					  
					    console.log("\n declared_groups_array_status p1 "+JSON.stringify(declared_groups_array_status));
					  
					if(is_invalid > 0){
					
						room.tables[table_index].is_declared_valid_sequence = false;
						
					} else{
					
						if(is_pure >= 2 ) {
						
							room.tables[table_index].is_declared_valid_sequence = true;
							
						}else{
						
							if(is_pure == 1 ){
							
								for(var n=0; n<declared_groups_array_status.length;){
								
										if(declared_groups_array_status[n] == "Sub")
										{
											room.tables[table_index].is_declared_valid_sequence = true;
											break;
										}
										else
										{
											if( n == (declared_groups_array_status.length))
											{ break;}
											else { n++; continue; }
										}
								}
							}//if pure 1
						}//else no 2 pure 
					}
					  
					declared_groups_array = [];
					declared_groups_array_status = [];
				}//check-valid-if-all-have-min-3-cards
				   
				  console.log(" \n is_declared_valid_sequence of p1 "+room.tables[table_index].is_declared_valid_sequence);
				   if(room.tables[table_index].is_declared_valid_sequence == false)
					{
						//room.tables[table_index].declared= 2; 
						room.tables[table_index].players[1].declared = true;
						
						room.tables[table_index].players[0].is_declared_valid_sequence = false;
						room.tables[table_index].players[1].is_declared_valid_sequence = true;
						
						room.tables[table_index].players[0].game_status = "Lost";
						room.tables[table_index].players[1].game_status = "Won";
						room.tables[table_index].player1_game_status = "Won";
						room.tables[table_index].player2_game_status = "Lost";
						
						room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
						room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;
						
						
					}else{
						//room.tables[table_index].declared= 2; 
						//room.tables[table_index].players[0].declared = true;
						room.tables[table_index].players[1].declared = true;
						room.tables[table_index].players[0].is_declared_valid_sequence = true;
						room.tables[table_index].players[1].is_declared_valid_sequence = false;
						
						room.tables[table_index].players[1].game_status = "Lost";
						room.tables[table_index].players[0].game_status = "Won";
						room.tables[table_index].player2_game_status = "Won";
						room.tables[table_index].player1_game_status = "Lost";
						
						room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
						room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;
					}
					
				   // *********Validate Player 1 Declaration **********
					if(room.tables[table_index].declared==1)
					{
						player_declared = room.tables[table_index].players[0].name;
						var prev_declared_player;
						var declared_pl_score =0, opp_pl_score =0;
						var declared_pl_won_amount =0, opp_pl_won_amount =0;
						var score = 0;
							
							
						if(room.tables[table_index].players[0].name == declared_user){ 
							prev_declared_player = room.tables[table_index].players[1].name; 
							declared_player_grouped = room.tables[table_index].players[1].is_grouped;
						}else{ 
							prev_declared_player = room.tables[table_index].players[0].name;
							declared_player_grouped = room.tables[table_index].players[0].is_grouped;
						}
							//if(room.tables[table_index].players[0].name == declared_user){
							if(room.tables[table_index].is_declared_valid_sequence == false)
							{
							    declared_groups_array_papplu =[];
							    var grpcount=get_player_group_count_papplu(1,group);
								room.tables[table_index].players[1].papplu_card_total=0;
								console.log("\n\n declared_groups_array of p1 true sequence================================================================ --> "+JSON.stringify(declared_groups_array_papplu)); 
								if(grpcount > 0){
									for(var n=0; n<declared_groups_array_papplu.length; n++){
										var card_group = [];
										card_group.push.apply(card_group, declared_groups_array_papplu[n]);
										for (var o = 0; o < card_group.length; o++)
										{
											if(room.tables[table_index].papplu_joker_card == card_group[o].card_path && room.tables[table_index].papplu_joker_card_name == card_group[o].name)
											{
											
												room.tables[table_index].players[1].papplu_card_total=room.tables[table_index].players[1].papplu_card_total+1;
											}

										  console.log("\n\n DAtaaaaaaa====="+room.tables[table_index].papplu_joker_card+"=========== --> "+card_group[o].card_path+"==suit="+room.tables[table_index].papplu_joker_card_name+"==="+card_group[o].suit+"\n"); 
										}
									}
								}else{
									
										for(var c=0;c< room.tables[table_index].players[1].hand.length;c++){
											if(room.tables[table_index].papplu_joker_card == room.tables[table_index].players[1].hand[c].card_path && room.tables[table_index].papplu_joker_card_name == room.tables[table_index].players[1].hand[c].name)
											{
											
												room.tables[table_index].players[1].papplu_card_total=room.tables[table_index].players[1].papplu_card_total+1;
											}
										}
								}
								console.log("\n\n Papplu  ========DAtaaaaaaa====="+room.tables[table_index].players[1].papplu_card_total+"=========== -->\n "); 
								
						        temp_score=0;
								if(room.tables[table_index].players[0].player_start_play == true){
							   
									 if(room.tables[table_index].players[1].papplu_card_total == 2){
									 
									   temp_score = room.tables[table_index].table_min_entry*4;
									 
									 }else if(room.tables[table_index].players[1].papplu_card_total == 1){
									 
									     temp_score = room.tables[table_index].table_min_entry*3;
									   
									 }else{
									 
									    temp_score = room.tables[table_index].table_min_entry*2;
									  
									 }
									 
								}else{
								 temp_score = room.tables[table_index].table_min_entry;
								}
								room.tables[table_index].players[0].game_score = temp_score; 
								room.tables[table_index].players[1].game_score = 0;
								room.tables[table_index].players[0].amount_won = getFixedNumber(-(+((temp_score))));
								score = temp_score;
								room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing-( temp_score))));
								revertBonus(room.tables[table_index].players[0].name, getFixedNumber(temp_score), table_game);
								
								if(table_game == 'Free Game'){
									room.tables[table_index].players[1].amount_won = getFixedNumber(+(score));
									room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing+(score))));
								}
								if(table_game == 'Cash Game'){
									winner_won_amount = score;
									company_commision_amount=(winner_won_amount*company_commision)/100;
									winner_won_amount = winner_won_amount-company_commision_amount;
									room.tables[table_index].players[1].amount_won = getFixedNumber(+((winner_won_amount)));
									room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing+(winner_won_amount))));

									/********* Inserting commision details to 'company_balance' table ******/
									players_name=room.tables[table_index].players[0].name+','+room.tables[table_index].players[1].name;
									commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+players_name+"',now())";
									con.query(commision_query, function(err1, result){}); 
								}
								room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
								room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;
								room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
								room.tables[table_index].player2_name = room.tables[table_index].players[0].name;							
								
								transaction_id = Math.floor(Math.random() * 100000000000000);
								/**** Inserting Transaction Details to database once game end/restarted ****/
								console.log("Qry=====================33");
								insert_query="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[0].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[0].name+"','"+room.tables[table_index].players[0].game_status+"','"+(room.tables[table_index].players[0].amount_won*-1)+"','"+dt+"')";
								con.query(insert_query, function(err1, result){
								    if (err1) {
										console.log(err1);
									} 
								}); 
								/*For lost amount*/
								console.log("Qry=====================34");
								insert_query1="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[1].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[1].name+"','"+room.tables[table_index].players[1].game_status+"','"+room.tables[table_index].players[1].amount_won+"','"+dt+"')";
								con.query(insert_query1, function(err1, result){
								    if (err1) {
										console.log(err1);
									} 
								}); 
								update_game_details_func(table_index);

							}else if(room.tables[table_index].is_declared_valid_sequence == true){
								///////// Calculate opp player game score and lost amount ///////////
								
								declared_groups_array_papplu =[];
								var grpcount=get_player_group_count_papplu(0,group);
								room.tables[table_index].players[0].papplu_card_total=0;
								if(grpcount > 0){
								   for(var n=0; n<declared_groups_array_papplu.length; n++)
									{
										var card_group = [];
										card_group.push.apply(card_group, declared_groups_array_papplu[n]);
										for (var o = 0; o < card_group.length; o++)
										{
											if(room.tables[table_index].papplu_joker_card == card_group[o].card_path && room.tables[table_index].papplu_joker_card_name == card_group[o].name)
											{
											
												room.tables[table_index].players[0].papplu_card_total=room.tables[table_index].players[0].papplu_card_total+1;
											}

										}
									}
									console.log("\n\n Papplu  ========DAtaaaaaaa====="+room.tables[table_index].players[0].papplu_card_total+"=========== -->\n "); 
								}else{
									
										for(var c=0;c< room.tables[table_index].players[0].hand.length;c++){
											if(room.tables[table_index].papplu_joker_card == room.tables[table_index].players[0].hand[c].card_path && room.tables[table_index].papplu_joker_card_name == room.tables[table_index].players[0].hand[c].name)
											{
											
												room.tables[table_index].players[0].papplu_card_total=room.tables[table_index].players[0].papplu_card_total+1;
											}
										}
								}
						        score=0;
								if(room.tables[table_index].players[1].player_start_play == true){
							   
									 if(room.tables[table_index].players[0].papplu_card_total == 2){
									 
									 score = room.tables[table_index].table_min_entry*4;
									 
									 }else if(room.tables[table_index].players[0].papplu_card_total == 1){
									 
									   score = room.tables[table_index].table_min_entry*3;
									   
									 }else{
									 
									  score = room.tables[table_index].table_min_entry*2;
									  
									 }
									 
								}else{
								 score = room.tables[table_index].table_min_entry;
								}
								
								
								
								prev_declared_player = room.tables[table_index].players[0].name; 
								room.tables[table_index].players[0].game_score = 0; 
								room.tables[table_index].players[1].game_score = score;
								room.tables[table_index].players[1].amount_won = getFixedNumber(-(+(score)));
								room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing-(score))));
								revertBonus(room.tables[table_index].players[1].name, getFixedNumber(score), table_game);
														
								if(table_game == 'Free Game'){
									room.tables[table_index].players[0].amount_won = getFixedNumber(+(score));
									room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing+(score))));
								}
								if(table_game == 'Cash Game')
								{
									winner_won_amount = score;
									company_commision_amount=(winner_won_amount*company_commision)/100;
									winner_won_amount = winner_won_amount-company_commision_amount;
									room.tables[table_index].players[0].amount_won = getFixedNumber(+((winner_won_amount)));
									room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing+(winner_won_amount))));

									/********* Inserting commision details to 'company_balance' table ******/
									players_name=room.tables[table_index].players[0].name+','+room.tables[table_index].players[1].name;
									commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+players_name+"',now())";
									con.query(commision_query, function(err1, result){
										
										 if (err1) {
											console.log(err1);
										} 
									}); 
								}
								room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
								room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;
								room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
								room.tables[table_index].player2_name = room.tables[table_index].players[0].name;	
								
								transaction_id = Math.floor(Math.random() * 100000000000000);
								/**** Inserting Transaction Details to database once game end/restarted ****/
								console.log("Qry=====================35");
								insert_query="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[0].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[0].name+"','"+room.tables[table_index].players[0].game_status+"','"+room.tables[table_index].players[0].amount_won+"','"+dt+"')";
								con.query(insert_query, function(err1, result){
								 if (err1) {
							console.log(err1);
						} ;
								
								}); 
								/*For lost amount*/
								console.log("Qry=====================36");
								insert_query1="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[1].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[1].name+"','"+room.tables[table_index].players[1].game_status+"','"+(room.tables[table_index].players[1].amount_won*-1)+"','"+dt+"')";
								con.query(insert_query1, function(err1, result){
									if (err1) {
									console.log(err1);
									} 
								}); 

								update_game_details_func(table_index);

					        }//valid-true ends 
					
						/** Amount Updated after game end of player (if disconnected)**/
						if(first_player_status == "disconnected"){
						// update_balance_after_declare(room.tables[table_index].players[1].name,group,room.tables[table_index].players[1].amount_playing,false);
						// removePlayerFromTable( room.tables[table_index].players[1].name, group );
						}
						
					 if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
						{other_declared_player_grouped = true;}
						else {other_declared_player_grouped = false;}
						//1st player - no group and 2nd player - no group
					  if(other_declared_player_grouped == false && declared_player_grouped == false)
					  {
					  
					  console.log("\n in 0 1st group- false , 2nd group - false");
					    if(room.tables[table_index].players[0].id != ''){
					    if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
						if(room.tables[table_index].players[1].id != ''){
						if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:prev_declared_player,user_grouped:declared_player_grouped,other_grouped:other_declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
					  }
					  //1st player - grouped and 2nd player - no group
					  if(other_declared_player_grouped == true && declared_player_grouped == false)
					  {
					    console.log("\n in 0  1st group- true , 2nd group - false");
					    if(room.tables[table_index].players[0].id != ''){
					    if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
						if(room.tables[table_index].players[1].id != ''){
						if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:prev_declared_player,user_grouped:declared_player_grouped,other_grouped:other_declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
					  }
					  //1st player - no group and 2nd player - grouped
					  if(other_declared_player_grouped == false && declared_player_grouped == true)
					  {
					    console.log("\n in 0  1st group- false , 2nd group - true");
					    if(room.tables[table_index].players[0].id != ''){
					    if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
						if(room.tables[table_index].players[1].id != ''){
						if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:prev_declared_player,user_grouped:declared_player_grouped,other_grouped:other_declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
						
					  }
					  //both player - grouped
					   if(other_declared_player_grouped == true && declared_player_grouped == true)
					  { 
					  console.log("\n 1st in 0  group- true , 2nd group - true");
					  if(room.tables[table_index].players[0].id != ''){
						  if(oth_player_status != "disconnected"){
							io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						  }
					  }
						  if(room.tables[table_index].players[1].id != ''){
							  if(first_player_status != "disconnected"){
								io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:prev_declared_player,user_grouped:declared_player_grouped,other_grouped:other_declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
								}
							}
					   }
					  		
					}//declared-1-1st
				}//oth-declared
			  else if(room.tables[table_index].players[1].name == declared_user)
				{ 
				  player_declared = room.tables[table_index].players[1].name;
				  
				/***************** Validate Player 2 Declaration **********/
				 declared_groups_array = [];	  
				 group_count = get_player_group_count(1,group);
				 //console.log("p2 group_count "+group_count); 
				 
				  if(group_count == 0)
				  {
					room.tables[table_index].is_declared_valid_sequence = false;
				  }//invalid
				  else
				  {
					if(!valid.validateGroupLimit(group_count))
				    {
					    console.log("\n\n declared_groups_array of p2 --> "+JSON.stringify(declared_groups_array)+"--- arr count --"+declared_groups_array.length);
						for(var n=0; n<declared_groups_array.length;n++)
					    {					
						 	is_pure_valid = valid.validatePureSequence(declared_groups_array[n],room.tables[table_index].pure_joker_cards,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards,room.tables[table_index].joker_cards);
							if(!is_pure_valid)
							{
								is_sub_valid = valid.validateSubSequence(declared_groups_array[n],room.tables[table_index].joker_cards,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards);
								if(!is_sub_valid)
								{
									is_3rd_valid = valid.validateSameCardSequence(declared_groups_array[n],room.tables[table_index].joker_cards);
									if(!is_3rd_valid)
									{
										if( !valid.validateAllJoker(declared_groups_array[n],room.tables[table_index].joker_cards) ) {
											is_invalid++;
											declared_groups_array_status[n] = "Invalid";
										} else {
											declared_groups_array_status[n] = "Joker";
										}
									}
									else
									{
										is_3rd_sequence++;
										declared_groups_array_status[n] = "Third";
									}
								}
								else 
								{
									is_sub_sequence++; 
									declared_groups_array_status[n] = "Sub";
								}
							}
							else 
							{
								is_pure++;
								declared_groups_array_status[n] = "Pure";
							}
					   }//for 
					}else{ room.tables[table_index].is_declared_valid_sequence = false; }
					  
					
					 // console.log("\n player 2 valid status--> pure sq - no "+is_pure+" sub-sq - no "+is_sub_sequence+" 3rd valid sq count "+is_3rd_sequence +" invalid count "+is_invalid);
					  console.log("\n declared_groups_array_status p2 "+JSON.stringify(declared_groups_array_status));
						
					  if(is_invalid > 0) {
					  
						room.tables[table_index].is_declared_valid_sequence = false;
						
					  }else{
					  
						if(is_pure >= 2 ){
						
							room.tables[table_index].is_declared_valid_sequence = true;
							
						} else{
						
							    if(is_pure == 1 ){
							   
								   for(var n=0; n<declared_groups_array_status.length;)
									{
										if(declared_groups_array_status[n] == "Sub" )
										{
											room.tables[table_index].is_declared_valid_sequence = true;
											break;
										}
										else
										{
											if( n == (declared_groups_array_status.length))
											{break;}
											else { n++;continue; }
										}
									}
								}//pure-1
						}//else pure-2
					  }
					  declared_groups_array = [];
					  declared_groups_array_status = [];
				   }//check-valid-if-all-have-min-3-cards
				   
				   console.log(" \n is_declared_valid_sequence of p2 "+room.tables[table_index].is_declared_valid_sequence);
				  
				    if(room.tables[table_index].is_declared_valid_sequence == false)
					{
						room.tables[table_index].players[0].declared = true;
						
						room.tables[table_index].players[1].is_declared_valid_sequence = false;					
						room.tables[table_index].players[0].is_declared_valid_sequence = true;
						
						room.tables[table_index].players[1].game_status = "Lost";
						room.tables[table_index].players[0].game_status = "Won";
						room.tables[table_index].player2_game_status = "Won";
						room.tables[table_index].player1_game_status = "Lost";
						
						room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
						room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;
					}
					else
					{
						//room.tables[table_index].players[1].declared = true;
						room.tables[table_index].players[0].declared = true;
						
						room.tables[table_index].players[1].is_declared_valid_sequence = true;
						room.tables[table_index].players[0].is_declared_valid_sequence = false;
						
						room.tables[table_index].players[0].game_status = "Lost";
						room.tables[table_index].players[1].game_status = "Won";
						room.tables[table_index].player1_game_status = "Won";
						room.tables[table_index].player2_game_status = "Lost";
						
						room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
						room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;
					}
				    /***************** Validate Player 2 Declaration **********/
					   
						if(room.tables[table_index].declared==1)
						{

							if(room.tables[table_index].players[0].name == declared_user)
							{ 
								prev_declared_player = room.tables[table_index].players[1].name; 
								declared_player_grouped = room.tables[table_index].players[1].is_grouped;
							}
							else
							{ 
					prev_declared_player = room.tables[table_index].players[0].name;
					declared_player_grouped = room.tables[table_index].players[0].is_grouped;
				}
				
						if(room.tables[table_index].is_declared_valid_sequence == false)
						{
						
						declared_groups_array_papplu =[];
						     var grpcount=get_player_group_count_papplu(0,group);
							 room.tables[table_index].players[0].papplu_card_total=0;
								
                                if(grpcount > 0){
							  	    console.log("\n\n declared_groups_array of p1 true sequence================================================================ --> "+JSON.stringify(declared_groups_array_papplu)); 
									for(var n=0; n<declared_groups_array_papplu.length; n++)
									{
										var card_group = [];
										card_group.push.apply(card_group, declared_groups_array_papplu[n]);
										for (var o = 0; o < card_group.length; o++)
										{
											if(room.tables[table_index].papplu_joker_card == card_group[o].card_path && room.tables[table_index].papplu_joker_card_name == card_group[o].name)
											{
											
												room.tables[table_index].players[0].papplu_card_total=room.tables[table_index].players[0].papplu_card_total+1;
											}

										  console.log("\n\n DAtaaaaaaa====="+room.tables[table_index].papplu_joker_card+"=========== --> "+card_group[o].card_path+"==suit="+room.tables[table_index].papplu_joker_card_name+"==="+card_group[o].suit+"\n"); 
										}
									}
									console.log("\n\n Papplu  ========DAtaaaaaaa====="+room.tables[table_index].players[0].papplu_card_total+"=========== -->\n "); 
								}else{
									
										for(var c=0;c< room.tables[table_index].players[0].hand.length;c++){
											if(room.tables[table_index].papplu_joker_card == room.tables[table_index].players[0].hand[c].card_path && room.tables[table_index].papplu_joker_card_name == room.tables[table_index].players[0].hand[c].name)
											{
										
												room.tables[table_index].players[0].papplu_card_total=room.tables[table_index].players[0].papplu_card_total+1;
											}
										}
								}
							         score=0;
							                if(room.tables[table_index].players[1].player_start_play == true){
										   
										         if(room.tables[table_index].players[0].papplu_card_total == 2){
												 
											    score = room.tables[table_index].table_min_entry*4;
												 
												 }else if(room.tables[table_index].players[0].papplu_card_total == 1){
												 
												   score = room.tables[table_index].table_min_entry*3;
												   
												 }else{
												 
												  score = room.tables[table_index].table_min_entry*2;
												  
												 }
												 
											}else{
											 score = room.tables[table_index].table_min_entry;
											}
							
							room.tables[table_index].players[1].game_score = score; 
							room.tables[table_index].players[0].game_score = 0;
							room.tables[table_index].players[1].amount_won = getFixedNumber(-(+(score)));
							room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing-(score))));

							revertBonus(room.tables[table_index].players[1].name, getFixedNumber(score), table_game);
															
							if(table_game == 'Free Game')
								{
									room.tables[table_index].players[0].amount_won = getFixedNumber(+(score));
									room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing+(score))));
								}
								if(table_game == 'Cash Game')
								{
									winner_won_amount = score;
									company_commision_amount=(winner_won_amount*company_commision)/100;
									winner_won_amount = winner_won_amount-company_commision_amount;
									room.tables[table_index].players[0].amount_won = getFixedNumber(+((winner_won_amount)));
									room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing+(winner_won_amount))));

									/********* Inserting commision details to 'company_balance' table ******/
									players_name=room.tables[table_index].players[0].name+','+room.tables[table_index].players[1].name;
									commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+players_name+"',now())";
									con.query(commision_query, function(err1, result){
										
										 if (err1) {
											console.log(err1);
										} 
									}); 
								}

							room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
							room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;
							room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
							room.tables[table_index].player2_name = room.tables[table_index].players[0].name;
							
							transaction_id = Math.floor(Math.random() * 100000000000000);
							/**** Inserting Transaction Details to database once game end/restarted ****/
							console.log("Qry=====================37");
							insert_query="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[0].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[0].name+"','"+room.tables[table_index].players[0].game_status+"','"+room.tables[table_index].players[0].amount_won+"','"+dt+"')";
						con.query(insert_query, function(err1, result){
						 if (err1) {
							console.log(err1);
						} 
						
						}); 
						/*For lost amount*/
						console.log("Qry=====================38");
						insert_query1="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[1].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[1].name+"','"+room.tables[table_index].players[1].game_status+"','"+(room.tables[table_index].players[1].amount_won*-1)+"','"+dt+"')";
						con.query(insert_query1, function(err1, result){
						 if (err1) {
							console.log(err1);
						} 
						}); 
							
							//console.log("\n after declare p1 "+room.tables[table_index].players[0].amount_playing+" p2 "+room.tables[table_index].players[1].amount_playing);
						update_game_details_func(table_index);

						}
						else
						{
						     declared_groups_array_papplu =[];
						      var grpcount=get_player_group_count_papplu(1,group);
							  room.tables[table_index].players[1].papplu_card_total=0;
							     if(grpcount > 0){
										console.log("\n\n declared_groups_array of p1 true sequence================================================================ --> "+JSON.stringify(declared_groups_array_papplu)); 
										for(var n=0; n<declared_groups_array_papplu.length; n++)
										{
											var card_group = [];
											card_group.push.apply(card_group, declared_groups_array_papplu[n]);
											for (var o = 0; o < card_group.length; o++)
											{
												if(room.tables[table_index].papplu_joker_card == card_group[o].card_path && room.tables[table_index].papplu_joker_card_name == card_group[o].name)
												{
												
													room.tables[table_index].players[1].papplu_card_total=room.tables[table_index].players[1].papplu_card_total+1;
												}

											  console.log("\n\n DAtaaaaaaa====="+room.tables[table_index].papplu_joker_card+"=========== --> "+card_group[o].card_path+"==suit="+room.tables[table_index].papplu_joker_card_name+"==="+card_group[o].suit+"\n"); 
											}
										}
								console.log("\n\n Papplu  ========DAtaaaaaaa====="+room.tables[table_index].players[1].papplu_card_total+"=========== -->\n "); 
								}else{
									
										for(var c=0;c< room.tables[table_index].players[1].hand.length;c++){
											if(room.tables[table_index].papplu_joker_card == room.tables[table_index].players[1].hand[c].card_path && room.tables[table_index].papplu_joker_card_name == room.tables[table_index].players[1].hand[c].name)
											{
											
												room.tables[table_index].players[1].papplu_card_total=room.tables[table_index].players[1].papplu_card_total+1;
											}
										}
								}
							         score=0;
							                if(room.tables[table_index].players[0].player_start_play == true){
										   
										         if(room.tables[table_index].players[1].papplu_card_total == 2){
												 
											    score = room.tables[table_index].table_min_entry*4;
												 
												 }else if(room.tables[table_index].players[1].papplu_card_total == 1){
												 
												   score = room.tables[table_index].table_min_entry*3;
												   
												 }else{
												 
												  score = room.tables[table_index].table_min_entry*2;
												  
												 }
												 
											}else{
											 score = room.tables[table_index].table_min_entry;
											}
							
						
						
						
						prev_declared_player = room.tables[table_index].players[1].name; 
						room.tables[table_index].players[1].game_score = 0; 
						room.tables[table_index].players[0].game_score = score;
						room.tables[table_index].players[0].amount_won = getFixedNumber(-(+(score)));
						room.tables[table_index].players[0].amount_playing = getFixedNumber(+((room.tables[table_index].players[0].amount_playing-(score))));

						revertBonus(room.tables[table_index].players[0].name, getFixedNumber(score), table_game);								
						
							if(table_game == 'Free Game')
							{
								room.tables[table_index].players[1].amount_won = getFixedNumber(+(score));
								room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing+(score))));
							}
							if(table_game == 'Cash Game')
							{
								winner_won_amount = score;
								company_commision_amount=(winner_won_amount*company_commision)/100;
								winner_won_amount = winner_won_amount-company_commision_amount;
								room.tables[table_index].players[1].amount_won = getFixedNumber(+((winner_won_amount)));
								room.tables[table_index].players[1].amount_playing = getFixedNumber(+((room.tables[table_index].players[1].amount_playing+(winner_won_amount))));

								/********* Inserting commision details to 'company_balance' table ******/
								players_name=room.tables[table_index].players[0].name+','+room.tables[table_index].players[1].name;
								commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+players_name+"',now())";
								con.query(commision_query, function(err1, result){
									
									 if (err1) {
							console.log(err1);
						} 
									
								}); 
							}

						room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
						room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;
						room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
						room.tables[table_index].player2_name = room.tables[table_index].players[0].name;
							
						transaction_id = Math.floor(Math.random() * 100000000000000);
						/**** Inserting Transaction Details to database once game end/restarted ****/
						console.log("Qry=====================39");
						insert_query="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[0].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[0].name+"','"+room.tables[table_index].players[0].game_status+"','"+(room.tables[table_index].players[0].amount_won*-1)+"','"+dt+"')";
						con.query(insert_query, function(err1, result){
						 if (err1) {
							console.log(err1);
						} 
						}); 
						/*For lost amount*/
						console.log("Qry=====================40");
						insert_query1="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[1].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[1].name+"','"+room.tables[table_index].players[1].game_status+"','"+room.tables[table_index].players[1].amount_won+"','"+dt+"')";
						con.query(insert_query1, function(err1, result){
						 if (err1) {
							console.log(err1);
						} 
						}); 
						//console.log("\n after BOTH declare p1 "+table.players[0].amount_playing+" p2 "+table.players[1].amount_playing);				
						
						update_game_details_func(table_index);

						}
				   
				   /** Amount Updated after game end of player (if disconnected)**/
						if(oth_player_status == "disconnected"){
						// update_balance_after_declare(room.tables[table_index].players[0].name,group,room.tables[table_index].players[0].amount_playing,false);
						// removePlayerFromTable( room.tables[table_index].players[0].name, group );
						}
						
						if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
						{other_declared_player_grouped = true;}
						else {other_declared_player_grouped = false;}
						
						//1st player - no group and 2nd player - no group
					  if(other_declared_player_grouped == false && declared_player_grouped == false)
					  {
					  console.log("\n 1st in 1  group- false , 2nd group - false");
					    if(room.tables[table_index].players[1].id != ''){
					    if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
						if(room.tables[table_index].players[0].id != ''){
						if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
					  }
					  //1st player - grouped and 2nd player - no group
					  if(other_declared_player_grouped == true && declared_player_grouped == false)
					  {
					  console.log("\n 1st in 1  group- true , 2nd group - false");
					  if(room.tables[table_index].players[1].id != ''){
					    if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].hand,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
						if(room.tables[table_index].players[0].id != ''){
						if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].hand,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:prev_declared_player,user_grouped:declared_player_grouped,other_grouped:other_declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
					  }
					  //1st player - no group and 2nd player - grouped
					  if(other_declared_player_grouped == false && declared_player_grouped == true)
					  {
					  console.log("\n 1st in 1  group- false , 2nd group - true");
					    if(room.tables[table_index].players[1].id != ''){
					    if(first_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].hand,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
						}
						}
						if(room.tables[table_index].players[0].id != ''){
						if(oth_player_status != "disconnected"){
						io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].hand,prev_pl:prev_declared_player,user_grouped:declared_player_grouped,other_grouped:other_declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
						}
						}
					  }
					  //both player - grouped
					   if(other_declared_player_grouped == true && declared_player_grouped == true)
					  { 
					  console.log("\n 1st in 1  group- true , 2nd group - true");
						  if(room.tables[table_index].players[1].id != ''){
							  if(first_player_status != "disconnected"){
								io.sockets.connected[(room.tables[table_index].players[1].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[1].card_group1,grp2_cards:room.tables[table_index].players[1].card_group2,grp3_cards:room.tables[table_index].players[1].card_group3,grp4_cards:room.tables[table_index].players[1].card_group4,grp5_cards:room.tables[table_index].players[1].card_group5,grp6_cards:room.tables[table_index].players[1].card_group6,grp7_cards:room.tables[table_index].players[1].card_group7,opp_user:(room.tables[table_index].players[0].name),grp1:room.tables[table_index].players[0].card_group1,grp2:room.tables[table_index].players[0].card_group2,grp3:room.tables[table_index].players[0].card_group3,grp4:room.tables[table_index].players[0].card_group4,grp5:room.tables[table_index].players[0].card_group5,grp6:room.tables[table_index].players[0].card_group6,grp7:room.tables[table_index].players[0].card_group7,prev_pl:prev_declared_player,user_grouped:other_declared_player_grouped,other_grouped:declared_player_grouped,game_score:room.tables[table_index].players[1].game_score,amount_won:room.tables[table_index].players[1].amount_won,opp_game_score:room.tables[table_index].players[0].game_score,opp_amount_won:room.tables[table_index].players[0].amount_won});
							  }
						  }
						  if(room.tables[table_index].players[0].id != ''){
							  if(oth_player_status != "disconnected"){
								io.sockets.connected[(room.tables[table_index].players[0].id)].emit("declared_final", { user:declared_user,declared:2,group:group,grp1_cards:room.tables[table_index].players[0].card_group1,grp2_cards:room.tables[table_index].players[0].card_group2,grp3_cards:room.tables[table_index].players[0].card_group3,grp4_cards:room.tables[table_index].players[0].card_group4,grp5_cards:room.tables[table_index].players[0].card_group5,grp6_cards:room.tables[table_index].players[0].card_group6,grp7_cards:room.tables[table_index].players[0].card_group7,opp_user:(room.tables[table_index].players[1].name),grp1:room.tables[table_index].players[1].card_group1,grp2:room.tables[table_index].players[1].card_group2,grp3:room.tables[table_index].players[1].card_group3,grp4:room.tables[table_index].players[1].card_group4,grp5:room.tables[table_index].players[1].card_group5,grp6:room.tables[table_index].players[1].card_group6,grp7:room.tables[table_index].players[1].card_group7,prev_pl:prev_declared_player,user_grouped:declared_player_grouped,other_grouped:other_declared_player_grouped,game_score:room.tables[table_index].players[0].game_score,amount_won:room.tables[table_index].players[0].amount_won,opp_game_score:room.tables[table_index].players[1].game_score,opp_amount_won:room.tables[table_index].players[1].amount_won});
							  }
						  }
					}
				 
				 }//declare-1-2nd
				}//2nd_declared
			}//declare-1 ends 
			
			room.tables[table_index].papplu_joker_card = "";
			room.tables[table_index].papplu_joker_card_name = "";
			room.tables[table_index].papplu_joker_card_id="";
		}//round ends 
	}//declare_papplu_game_data
	
	function get_player_group_count(player_id,group)
	{
		var group_count = 0;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n get_player_group_count");
			return;	
		}

		var i=0;
		var a=0;			
		
		 if(room.tables[table_index].players[player_id].card_group1.length !=0 )
		 {
			if(room.tables[table_index].players[player_id].card_group1.length >=3)
			{
				group_count++;
				declared_groups_array[i] = room.tables[table_index].players[player_id].card_group1;
				i++;
			}
			else if(!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group1,room.tables[table_index].joker_cards)) {
				a++;					
			}			
		 }
		 if(room.tables[table_index].players[player_id].card_group2.length !=0)
		 {
		 	if(room.tables[table_index].players[player_id].card_group2.length >=3)
			{				
				group_count++;
				declared_groups_array[i] = room.tables[table_index].players[player_id].card_group2;
				i++;
			}
			else if(!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group2,room.tables[table_index].joker_cards)) {
				a++;					
			}	
		 }
		 if(room.tables[table_index].players[player_id].card_group3.length !=0 )
		 {
		 	if(room.tables[table_index].players[player_id].card_group3.length >=3)
			{
				group_count++;	
				declared_groups_array[i] = room.tables[table_index].players[player_id].card_group3;
				i++;
			}
			else if(!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group3,room.tables[table_index].joker_cards)) {
				a++;					
			}		
		}
		 if(room.tables[table_index].players[player_id].card_group4.length !=0)
		{
		 if(room.tables[table_index].players[player_id].card_group4.length >=3)
			{
				group_count++;
				declared_groups_array[i] = room.tables[table_index].players[player_id].card_group4;
				i++;
			}
			else if(!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group4,room.tables[table_index].joker_cards)) {
				a++;					
			}			
		 }
		 if(room.tables[table_index].players[player_id].card_group5.length !=0)
		 {
		 if(room.tables[table_index].players[player_id].card_group5.length >=3)
			{
				group_count++;
				declared_groups_array[i] = room.tables[table_index].players[player_id].card_group5;
				i++;
			}
			else if(!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group5,room.tables[table_index].joker_cards)) {
				a++;					
			}
		 }
		 if(room.tables[table_index].players[player_id].card_group6.length !=0 )
		 {
		 	if(room.tables[table_index].players[player_id].card_group6.length >=3)
			{
				group_count++;
				declared_groups_array[i] = room.tables[table_index].players[player_id].card_group6;
				i++;
			}
			else if(!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group6,room.tables[table_index].joker_cards)) {
				a++;					
			}
		 }
		if(room.tables[table_index].players[player_id].card_group7.length !=0)
		{	
			if(room.tables[table_index].players[player_id].card_group7.length >=3)
			{
				group_count++;
				declared_groups_array[i] = room.tables[table_index].players[player_id].card_group7;
				i++;
			}
			else if(!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group7,room.tables[table_index].joker_cards)) {
				a++;					
			}	

		}		
				//console.log("** declared_groups_array ** "+JSON.stringify(declared_groups_array)+" a->"+a+" group_count "+group_count);
		if( a > 0)				
			return 0;

		return group_count;
		
	}


function get_player_group_count_papplu(player_id,group)
	{
		var group_count = 0;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n get_player_group_count");
			return;	
		}

		var i=0;
		var a=0;			
		
		 if(room.tables[table_index].players[player_id].card_group1.length !=0 )
		 {
			
				group_count++;
				declared_groups_array_papplu[i] = room.tables[table_index].players[player_id].card_group1;
				i++;
						
		 }
		 if(room.tables[table_index].players[player_id].card_group2.length !=0)
		 {
		 					
				group_count++;
				declared_groups_array_papplu[i] = room.tables[table_index].players[player_id].card_group2;
				i++;
			
		 }
		 if(room.tables[table_index].players[player_id].card_group3.length !=0 )
		 {
		 	
				group_count++;	
				declared_groups_array_papplu[i] = room.tables[table_index].players[player_id].card_group3;
				i++;
				
		}
		 if(room.tables[table_index].players[player_id].card_group4.length !=0)
		{
		 
				group_count++;
				declared_groups_array_papplu[i] = room.tables[table_index].players[player_id].card_group4;
				i++;
					
		 }
		 if(room.tables[table_index].players[player_id].card_group5.length !=0)
		 {
		
				group_count++;
				declared_groups_array_papplu[i] = room.tables[table_index].players[player_id].card_group5;
				i++;
			
		 }
		 if(room.tables[table_index].players[player_id].card_group6.length !=0 )
		 {
		 	
				group_count++;
				declared_groups_array_papplu[i] = room.tables[table_index].players[player_id].card_group6;
				i++;
			
		 }
		if(room.tables[table_index].players[player_id].card_group7.length !=0)
		{	
			
				group_count++;
				declared_groups_array_papplu[i] = room.tables[table_index].players[player_id].card_group7;
				i++;
				

		}		
				console.log("** declared_groups_array_papplu ** "+JSON.stringify(declared_groups_array_papplu)+" a-> group_count "+group_count);
		

		return group_count;
		
	}
	
	function get_opp_player_group_count(player_id,group)
	{
		var group_count = 0;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n get_opp_player_group_count");
			return;	
		}
		var a=0;
		var i =0;
		declared_groups_array =[];
		
		 if(room.tables[table_index].players[player_id].card_group1.length !=0 )
		 {
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group1;
			//console.log("\n declared_groups_array if 1 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group2.length !=0)
		 {
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group2;
			//console.log("\n declared_groups_array if 2 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group3.length !=0 )
		 {
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group3;
			//console.log("\n declared_groups_array if 3 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group4.length !=0)
		 {
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group4;
			//console.log("\n declared_groups_array if 4 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group5.length !=0)
		 {
		 	declared_groups_array[i] = room.tables[table_index].players[player_id].card_group5;
			//console.log("\n declared_groups_array if 5 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group6.length !=0 )
		 {
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group6;
			//console.log("\n declared_groups_array if 6 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group7.length !=0)
		 {	
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group7;
			//console.log("\n declared_groups_array if 7 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
			i++;
		 }		
		return group_count; 
		
	}
	
	//// Player left group  ///
	socket.on("player_left", function(data) {	
	 //socket.leave(socket.room);
	});
	
	function update_balance_after_declare(declared_player,grpid,player_amount,is_declared)
	{
	    if(declared_player != '' && declared_player != null && grpid != 0 && player_amount > 0){
			var table_min_entry,player_play_chips,new_chips,table_game;
			var update_amount;
			
			console.log("Update balance " + declared_player + "  amount " + player_amount);
			con.query("SELECT `min_entry`,`game` FROM `player_table`  where `table_id`='"+grpid+"'",function(er,result_table,fields)  
			{ 
			
			     if (er) {
							console.log(er);
			    }else{ 
					if(result_table.length!=0)
					{ 
						table_min_entry = result_table[0].min_entry;
						table_game = result_table[0].game;
					}
			    }
			});
				
			con.query("SELECT `play_chips`,`real_chips` FROM `accounts` where username='"+declared_player+"'",function(er,result,fields)  
			{ 
			
			     if (er) {
							console.log(er);
			    }else{ 
					if(result.length!=0)
					{
							if(table_game == 'Free Game'){
								player_play_chips = result[0].play_chips;
								new_chips = player_play_chips + player_amount; 
								update_amount = "UPDATE accounts SET play_chips = "+new_chips+" where username='"+declared_player+"'";
							}
							if(table_game == 'Cash Game'){
								player_play_chips = result[0].real_chips;
								new_chips = player_play_chips + player_amount; 
								console.log("player_chip=" + player_play_chips);
								update_amount = "UPDATE accounts SET real_chips = "+new_chips+" where username='"+declared_player+"'";
							}
								
							con.query(update_amount, function (err, result) {
							if (err) {console.log(err);}
							else {console.log(result.affectedRows + " record(s) after amount update on game ends of if disconnected "+declared_player);}
							}); 
							
					}
				}
			});
			
		}
	}
	
	function get_player_groups(player_id,group)
	{
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n get_player_groups");
			return;	
		}
		var player_groups_array =[];
		var i=0;
		
		 if(room.tables[table_index].players[player_id].card_group1.length !=0 )
		 {
			player_groups_array[i] = room.tables[table_index].players[player_id].card_group1;
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group2.length !=0)
		 {
			player_groups_array[i] = room.tables[table_index].players[player_id].card_group2;
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group3.length !=0 )
		 {
			player_groups_array[i] = room.tables[table_index].players[player_id].card_group3;
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group4.length !=0)
		 {
			player_groups_array[i] = room.tables[table_index].players[player_id].card_group4;
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group5.length !=0)
		 {
			player_groups_array[i] = room.tables[table_index].players[player_id].card_group5;
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group6.length !=0 )
		 {
			player_groups_array[i] = room.tables[table_index].players[player_id].card_group6;
			i++;
		 }
		 if(room.tables[table_index].players[player_id].card_group7.length !=0)
		 {
			player_groups_array[i] = room.tables[table_index].players[player_id].card_group7;
		 }		
		return player_groups_array; 
		
	}
	
	////clear all fields before game start / restart 
	function clear_all_data_before_game_start(table)
	{
			joined_table=false;
			grp_round_no = 0;
			round_no_arr = [];
			card_images = [];
			timer  = table.timer_array[1];
			p1_group1 = [],p1_group2 = [],p1_group3 = [],p1_group4 = [],p1_group5 = [],p1_group6 = [],p1_group7 = []; 

			//remove from table 
			table.closed_cards_arr = [];
			table.open_cards = [];
			table.declared = 0; 
			table.p1_group1 = [];
			table.p1_group2 = [];
			table.p1_group3 = [];
			table.p1_group4 = [];
			table.p1_group5 = [];
			table.p1_group6 = [];
			table.p1_group7 = []; 
			//ANDY table.readyToPlayCounter = 0;
			table.joker_cards = [];
			
			table.pure_joker_cards = [];
			table.open_card_status = "";
			table.is_player_finished = false;
			table.temp_open_object  = "";
			table.finish_card_object  = "";
			table.dealer_name = "";
			table.papplu_joker_card = "";
	       table.papplu_joker_card_name = "";
		   table.papplu_joker_card_id="";
			
			if(table.players.length >= 2 )
			{
				for (var i = 0; i < table.players.length; i++)
				{
					table.players[i].turn = false;
					table.players[i].open_close_selected_count = 0;
					table.players[i].declared = false;
					table.players[i].hand = [];
					table.players[i].gameFinished = false;
					table.players[i].turnFinished= false;
					table.players[i].is_grouped = false;
					table.players[i].is_player_finished = false;
					table.players[i].is_joined_table = false;
					table.players[i].player_start_play = false;
					table.players[i].player_turn_only_first = false;
					
					table.players[i].papplu_card_total = 0;
					table.players[i].card_group1  = [];
					table.players[i].card_group2  = [];
					table.players[i].card_group3  = [];
					table.players[i].card_group4  = [];
					table.players[i].card_group5  = [];
					table.players[i].card_group6  = [];
					table.players[i].card_group7  = [];
					
					//table.players[i].status  = "available";
				}	
			}
			else if(table.players.length == 1 )
			{
				var player = room.getPlayer(socket.id);
				if(table.players[0].id == player.id)
				{
					table.players[0].turn = false;
					table.players[0].open_close_selected_count = 0;
					table.players[0].declared = false;
					table.players[0].hand = [];
					table.players[0].gameFinished = false;
					table.players[0].turnFinished= false;
					table.players[0].is_grouped = false;
					table.players[0].is_player_finished = false;
					table.players[0].is_joined_table = false;
					table.players[0].player_start_play = false;
					table.players[0].player_turn_only_first = false;
					table.players[0].papplu_card_total = 0;
					table.players[0].card_group1  = [];
					table.players[0].card_group2  = [];
					table.players[0].card_group3  = [];
					table.players[0].card_group4  = [];
					table.players[0].card_group5  = [];
					table.players[0].card_group6  = [];
					table.players[0].card_group7  = [];
					//table.players[0].status  = "available";
				}
				else if(table.players[1].id == player.id)
				{
					table.players[1].turn = false;
					table.players[1].open_close_selected_count = 0;
					table.players[1].declared = false;
					table.players[1].hand = [];
					table.players[1].gameFinished = false;
					table.players[1].turnFinished= false;
					table.players[1].is_grouped = false;
					table.players[1].is_player_finished = false;
					table.players[1].is_joined_table = false;
					table.players[1].player_start_play = false;
					table.players[1].player_turn_only_first = false;
					table.players[1].papplu_card_total = 0;
					table.players[1].card_group1  = [];
					table.players[1].card_group2  = [];
					table.players[1].card_group3  = [];
					table.players[1].card_group4  = [];
					table.players[1].card_group5  = [];
					table.players[1].card_group6  = [];
					table.players[1].card_group7  = [];
					//table.players[1].status  = "available";
				}
			}
	}//clear_all_data_before_game_start ends 




	/**************************  6 Player functions  start ***********************************/

	/******* Check for player alread joined on table and display it ******/
 	socket.on('check_if_joined_player', function(username,grpid)
    {
		var player;
		var open_data;
		var temp_arr = [];
		var player_names = [];
		var open_id = 0;
		var open_path = "";
		var open_data_arr;
		var table_index =0;
		table_index = getTableIndex(room.tables,grpid);
		if (table_index == - 1) {
			console.log("\n check_if_joined_player");
			table = new Table(grpid);
			room.addTable(table);
			table_index = getTableIndex(room.tables,grpid);
		}

		console.log(" \n restart_game_six "+room.tables[table_index].restart_game_six + " tableIdx:" + table_index + " grpid:" + grpid);
		if(username!==null || username===undefined)
		{
			if(room.tables[table_index].players.length>0)
			{
				if(room.tables[table_index].players.length == 1)
				{
					console.log(" \n check_if_joined_player only 1 player ");
					socket.emit('check_if_joined_player',room.tables[table_index].six_usernames,
						room.tables[table_index].six_user_click,grpid,
						room.tables[table_index].six_player_amount,room.tables[table_index].six_player_gender,
						room.tables[table_index].restart_game_six);
				}else if(room.tables[table_index].players.length >=2){
					console.log(" \n check_if_joined_player >=2 players ");

					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						player_names[i] = room.tables[table_index].players[i].name;
					}

					socket.emit('show_sixgame_data',room.tables[table_index].six_usernames,
							room.tables[table_index].six_user_click,grpid,
							room.tables[table_index].six_player_amount,room.tables[table_index].six_player_poolamount,
							room.tables[table_index].six_player_gender,
							room.tables[table_index].restart_game_six, player_names);

					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						//console.log(" \n i==>"+i);
						if (room.tables[table_index].players[i].name == username)
						{ 
							if((room.tables[table_index].players[i].status) == "disconnected")
							{

								room.tables[table_index].players[i].id = socket.id;
								socket.username = username;
								
								socket.tableid = grpid;
								socket.gender = room.tables[table_index].six_player_gender[i];
								socket.btn_clicked = room.tables[table_index].six_user_click[i];

								room.tables[table_index].players[i].status = "playing";
								room.tables[table_index].players[i].player_reconnected = true;

								room.addPlayer(room.tables[table_index].players[i]);
								//console.log(" \n pl gender ---> "+room.tables[table_index].six_player_gender[i]);	

								socket.broadcast.emit('other_player_reconnected_six',
								username,room.tables[table_index].id,
								room.tables[table_index].players[i].amount_playing,
								room.tables[table_index].six_player_gender[i]);
						

								var player_playing = [];
								for (var k = 0; k < room.tables[table_index].six_usernames.length; k++)
								{
									player_playing[k] = false;
									for(var j = 0; j < room.tables[table_index].players.length; j++) {
										if(room.tables[table_index].six_usernames[k] == room.tables[table_index].players[j].name ) {
											player_playing[k] = true;
										}
									}
								}
								
							    if(room.tables[table_index].id){
									socket.emit('player_reconnected_six',room.tables[table_index].id,
									room.tables[table_index].six_usernames,room.tables[table_index].six_user_click,
									room.tables[table_index].six_player_amount,room.tables[table_index].six_player_gender, player_playing);
								}
								
								if(room.tables[table_index].open_card_status == "discard")
								{
										if(room.tables[table_index].open_card_obj_arr.length==0)
										{
											open_id = 0;
											open_path ="";
											open_data_arr = [];
										}else{
											temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
											open_data = temp_arr;
											open_id = open_data.id;
											open_path =open_data.card_path;
											open_data_arr = open_data;
										}
								}else{
										if(room.tables[table_index].open_card_obj_arr.length==0)
										{
											open_id = 0;
											open_path ="";
											open_data_arr = [];
										}else{
											open_data = room.tables[table_index].open_card_obj_arr[0];
											open_id = open_data.id;
											open_path =open_data.card_path;
											open_data_arr = open_data;
										}
								}
								
								console.log("\n open data "+JSON.stringify(open_data));
			
								if(room.tables[table_index].players[i].id != ''){
										if(room.tables[table_index].players[i].is_grouped == false)
										{
											io.sockets.connected[(room.tables[table_index].players[i].id)].emit("refresh_six",
											{ 	group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[i].hand,
												opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,
												open_close_pick_count:room.tables[table_index].players[i].open_close_selected_count,
												round_no:room.tables[table_index].round_id,
												sidejokername:room.tables[table_index].side_joker_card_name,
												open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,
												close_cards:room.tables[table_index].open_cards,
												is_grouped:room.tables[table_index].players[i].is_grouped,
												is_finish:room.tables[table_index].players[i].is_player_finished,
												finish_obj:room.tables[table_index].finish_card_object,
												is_joined_table:room.tables[table_index].players[i].is_joined_table,
												dealer:room.tables[table_index].dealer_name,sidejoker:room.tables[table_index].side_joker_card,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name
											});
										}else{
											io.sockets.connected[(room.tables[table_index].players[i].id)].emit("refresh_six",
											{ 
												group_id:room.tables[table_index].id,assigned_cards:room.tables[table_index].players[i].hand,
												opencard:open_path,opencard_id:open_id,closedcards_path:room.tables[table_index].closed_cards_arr,
												open_close_pick_count:room.tables[table_index].players[i].open_close_selected_count,
												round_no:room.tables[table_index].round_id,sidejoker:room.tables[table_index].side_joker_card,papplujoker:room.tables[table_index].papplu_joker_card,papplujokername:room.tables[table_index].papplu_joker_card_name,
												sidejokername:room.tables[table_index].side_joker_card_name,
												open_data:open_data_arr,open_length:room.tables[table_index].open_cards.length,
												close_cards:room.tables[table_index].open_cards,
												is_grouped:room.tables[table_index].players[i].is_grouped,
												is_finish:room.tables[table_index].players[i].is_player_finished,
												finish_obj:room.tables[table_index].finish_card_object,
												is_joined_table:room.tables[table_index].players[i].is_joined_table,
												dealer:room.tables[table_index].dealer_name
											});
											
											io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six", 
											{ 
												user:username,group:room.tables[table_index].id,round_id:room.tables[table_index].round_id,
												grp1_cards:room.tables[table_index].players[i].card_group1,
												grp2_cards:room.tables[table_index].players[i].card_group2,
												grp3_cards:room.tables[table_index].players[i].card_group3,
												grp4_cards:room.tables[table_index].players[i].card_group4,
												grp5_cards:room.tables[table_index].players[i].card_group5,
												grp6_cards:room.tables[table_index].players[i].card_group6,
												grp7_cards:room.tables[table_index].players[i].card_group7,
												sidejokername:room.tables[table_index].side_joker_card_name										
											});
										}
								
										if((room.tables[table_index].players[i].game_display_status) == "dropped"){
											socket.emit('player_dropped_game',username,room.tables[table_index].id);
											socket.broadcast.emit('player_dropped_game',username,room.tables[table_index].id);
										}else if((room.tables[table_index].players[i].game_display_status) == "wrong_declared"){
											socket.emit('player_declared_game',username,room.tables[table_index].id);
											socket.broadcast.emit('player_declared_game',username,room.tables[table_index].id);
										}
										
								}
								
								for (var j = 0; j < room.tables[table_index].players.length; j++)
								{
								   if(room.tables[table_index].players[j]){
										if (room.tables[table_index].players[j].name != username)
										{ 
											if((room.tables[table_index].players[j].status) == "disconnected" )
											{
												socket.emit('player_disconnected_six',room.tables[table_index].players[j].name,room.tables[table_index].id);
											} 
											else if((room.tables[table_index].players[j].game_display_status) == "dropped")
											{
												socket.emit('player_dropped_game',room.tables[table_index].players[j].name,room.tables[table_index].id);
											}
											else if((room.tables[table_index].players[j].game_display_status) == "wrong_declared")
											{
												socket.emit('player_declared_game',room.tables[table_index].players[j].name,room.tables[table_index].id);
											}
										}
									}
									
								}

								if(room.tables[table_index].players[i].game_display_status != "Live") {
									if( ( room.tables[table_index].declared == 1 && room.tables[table_index].is_declared_valid_sequence )
										 || room.tables[table_index].declared == 2 ) {
										player_name_array = [];
										player_final_card_groups_array = [];
										player_score_array = [];
										player_won_amount_array = [];
										player_group_status_array = [];
										var won_player = "";
										for (var k = 0; k < room.tables[table_index].players.length; k++) {
											if(room.tables[table_index].players[k].game_display_status != "Live")
								  			{
												player_name_array.push(room.tables[table_index].players[k].name);
												player_grouped = room.tables[table_index].players[k].is_grouped;
												player_group_status_array.push(player_grouped);
												player_card_groups_array=[];
												is_player_grouped_temp = false;
												if(player_grouped ==false)
												{
													is_player_grouped_temp = false;
													player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].hand);
												}
												else
												{
													is_player_grouped_temp = true;
													{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1);}
													{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2);}
													{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3);}
													{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4);}
													{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5);}
													{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6);}
													{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7);}
												}
												player_final_card_groups_array.push(player_card_groups_array);
												player_score_array.push(room.tables[table_index].players[k].game_score);
												console.log("\n player won amount_won "+room.tables[table_index].players[k].amount_won);
												player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
											}
											else
											{
												player_name_array.push(room.tables[table_index].players[k].name);
												player_group_status_array.push(false);
												player_card_groups_array=[];
												player_final_card_groups_array.push(player_card_groups_array);
												player_score_array.push(-1);
												player_won_amount_array.push(-1);
											}
										}//inner-for ends
										
										if(room.tables[table_index].players[i].id != ''){
										io.sockets.connected[(room.tables[table_index].players[i].id)].emit("declared_final_six",
										{
											players: player_name_array, declared: 2, group: grpid, winner: won_player,
											group_status: player_group_status_array, players_cards: player_final_card_groups_array,
											players_score: player_score_array, players_amount: player_won_amount_array
										});
										}
									} 
								}
							}
						}
					}
				}

			}

			con.query("SELECT `table_id`, `table_name`, `game_type`,  `min_entry`,  `player_capacity`, `game` FROM `player_table`  where `table_id`='"+grpid+"'",function(er,result_table,fields)  
				{ 
				
				     if (er) {
							console.log(er);
			        }else{ 
						if(result_table.length!=0)
						{ 
							room.tables[table_index].table_name = result_table[0].table_name;
							room.tables[table_index].table_point_value = result_table[0].point_value;
							room.tables[table_index].table_min_entry = result_table[0].min_entry;
							room.tables[table_index].table_game = result_table[0].game;
							room.tables[table_index].chip_type = result_table[0].game == "Free Game" ? "free" : "real";
							room.tables[table_index].game_type = result_table[0].game_type;
							room.tables[table_index].playerCapacity = result_table[0].player_capacity; 
							//..console.log("\n ----------------------player_capacity -------------------"+room.tables[table_index].playerCapacity);
						}
					}
				});
		}
	});
	
	socket.on('player_connecting_to_six_player_table', function(playername,tableid,btn_clicked)
	{
		//..console.log("\n IN player_connecting_to_six_player_table ");
		var table_index =0;
		table_index = getTableIndex(room.tables,tableid);
		if (table_index == - 1) {
			console.log("\n player_connecting_to_six_player_table");
			return;	
		}
		
		if( ip_restriction ) {
			for(i = 0; i < room.tables[table_index].players.length; i++ ) {
				if(room.tables[table_index].players[i].getIp() == Ip) {
					console.log("\n same ip");
					if(playername){
					socket.emit('table_ip_restrict',playername,tableid);
					}
					return;	
				}
			}
		}
		
		
		if (room.tables[table_index].players.length == 0) 
			{
			    if(playername){
				socket.broadcast.emit('player_connecting_to_six_player_table',playername,tableid,btn_clicked);
				}
			}else if (room.tables[table_index].players.length <=6){
				if (room.tables[table_index].players[0].name != playername) 
				{ 
					if(room.tables[table_index].six_user_click[0] == btn_clicked)
					{
					   if(room.tables[table_index].players[0]){
						socket.emit('six_pl_sit_not_empty',room.tables[table_index].players[0].name,btn_clicked,tableid);	
                       }						
					}
					else if(room.tables[table_index].six_user_click[1] == btn_clicked)
					{
					    if(room.tables[table_index].players[0]){
						socket.emit('six_pl_sit_not_empty',room.tables[table_index].players[0].name,btn_clicked,tableid);	
                       }						
					}
					else
					{
					    if(playername){
						socket.broadcast.emit('player_connecting_to_six_player_table',playername,tableid,btn_clicked);
						 }
					}
				}
			}
     });


  	socket.on('player_not_connecting_to_six_player_table', function(playername,tableid,btn_clicked)
    {
   		var table_index =0;
		table_index = getTableIndex(room.tables,tableid);
		if (table_index == - 1) {
			console.log("\n player_not_connecting_to_six_player_table");
			return;	
		}
		if (room.tables[table_index].players.length == 0) 
			{
			    if(playername){
				socket.broadcast.emit('player_not_connecting_to_six_player_table',playername,tableid,btn_clicked);
				}
			}
			else if (room.tables[table_index].players.length <=6) 
			{
				if (room.tables[table_index].players[0].name != playername) 
				{ 
					if(room.tables[table_index].six_user_click[0] != btn_clicked)
					{
					    if(playername){
						socket.broadcast.emit('player_not_connecting_to_six_player_table',playername,tableid,btn_clicked);
                        }						
					}
					else if(room.tables[table_index].six_user_click[1] != btn_clicked)
					{
					    if(playername){
						  socket.broadcast.emit('player_not_connecting_to_six_player_table',playername,tableid,btn_clicked);	
                        }						
					}
				}
			}
		
   });
    
	socket.on('player_join_table', function(username,userno,grpid,round_no,join_count,amount,gender,browser_type,os_type,player_user_id,is_joined_table)
	{
		var player ;
		var arr = [];
		var random_group_roundno;var player_play_chips,new_chips;//,room.tables[table_index].table_min_entry;
		var play_game = true;// false;
		var tt;
		var group = 0;
		var roundno = 0;
		var player1turn,player2turn=false;
		var turn_of_player;
		var restart_count = 0;
		var player_playing = [];
		//var user_id =0;
		var table_index = 0;
		var bNewJoin = true;		
		var pl_amount_taken = 0;	
		var cards_six = [];
		var cards_without_joker_six = [];

		console.log("\n Player "+username+" has joined at seat no "+userno+" with amount "+amount+", player gender "+gender+" , using browser "+browser_type+" joint count "+join_count+" \n");

		if(username!==null || username===undefined)
        {			
			table_index = getTableIndex(room.tables,grpid);
			if (table_index == - 1) {
				console.log("\n player_join_table");
				table = new Table(grpid);
				room.addTable(table);
				table_index = getTableIndex(room.tables,grpid);
			}
			
			if (room.tables[table_index].players.length == 6)  {
				console.log("\n table_is_full");
				if(username){
				socket.emit('table_is_full',username,grpid);
				}
				return;
			} else {
				for(i = 0; i < room.tables[table_index].six_user_click.length; i++) {
					if( room.tables[table_index].six_user_click[i] == userno ) {
						console.log("\n exist player in seat " + userno);
						if(userno){
						 socket.emit('exist_player_seat',room.tables[table_index].six_usernames[i],grpid, userno);
						}
						return;
					}
				}
			}

			/*player = new Player(socket.id);
			socket.username = username;  
			player.setName(username);*/
			player = new Player();
			socket.username = username; 
            var socketid = socket.id;
 			player.setID(socketid);
			player.setName(username);
			
			room.addPlayer(player);//player added to Socket room
			
			socket.tableid = grpid;
			socket.gender = gender;
			socket.btn_clicked = userno;			

			console.log("--------------TEST------------------");
			console.log("is_joined_table = " + is_joined_table + "  username = " + username );
			if( is_joined_table == false ) {
				var table_game = room.tables[table_index].table_game;
				console.log("table_game = " + table_game);
				con.query("SELECT `play_chips`,`real_chips` FROM `accounts` where username='"+username+"'",function(er,result,fields)  
				{ 
				
				     if (er) {
							console.log(er);
			        }else{ 
						if(result.length!=0)
						{
							if(table_game == 'Free Game')
							{
								player_play_chips = result[0].play_chips;				
								if(player_play_chips>0 && player_play_chips >= amount)
								{
									console.log("player_play_chips "+player_play_chips+"\n");
									console.log("amount "+amount+"\n");
									new_chips = player_play_chips - amount;
									var update_amount = "UPDATE accounts SET play_chips = "+new_chips+" where username='"+username+"'";
									console.log("update query 4"+update_amount);
									con.query(update_amount, function (err, result) {
									if (err) {console.log(err);}
									else {console.log(result.affectedRows + " record(s) after play chips (free game) update of "+username);}
									});
								}
							}//if free game
							
							if(table_game == 'Cash Game')
							{
								player_play_chips = result[0].real_chips;
								if(player_play_chips>0 && player_play_chips >= amount)
								{
									console.log("\n player_play_chips "+player_play_chips+"\n");
									console.log("amount "+amount+"\n");
									new_chips = player_play_chips - amount;
									var update_amount = "UPDATE accounts SET real_chips = "+new_chips+" where username='"+username+"'";
									console.log("update query 4"+update_amount);
									con.query(update_amount, function (err, result) {
									if (err) {console.log(err);}
									else {console.log(result.affectedRows + " record(s) after real chips (paid game) update of "+username);}
									});
								}
							}
						}
					}
				}); 
				is_joined_table = true;
			}
			console.log("--------------TEST END---------------");

			console.log("\nPlayer Names: " + JSON.stringify(room.tables[table_index].players_names));
			console.log("\nPlayer Amount: " + JSON.stringify(room.tables[table_index].players_amounts));
			room.tables[table_index].addPlayer(player); 
			room.tables[table_index].addSocket(socket.id);
			
			if(join_count != 0){
			  pl_amount_taken = amount;
			}else if(join_count == 0){
				for (var i = 0; i < room.tables[table_index].players_names.length; i++)
				{
					if(username == room.tables[table_index].players_names[i])
				    { pl_amount_taken = room.tables[table_index].players_amounts[i]; }
				}
			}
			
			//set player's properties
			player.status = "intable";
			player.tableID = room.tables[table_index].id;
			player.setIp(Ip);
			player.setIsp("");
			player.setOS(os_type);
			player.setDevice(device_name);
			player.setBrowser(browser_type);
			player.user_id = player_user_id;
			player.is_joined_table = is_joined_table;
			
			if(join_count != 0){player.amount_playing = getFixedNumber(amount);}
			
			socket.join(socket.room); 
			room.tables[table_index].six_player_gender.push(gender);
			room.tables[table_index].six_player_amount.push(pl_amount_taken);
			console.log("\njoin_count:" + join_count +" SixPlayer Amount: " + JSON.stringify(room.tables[table_index].six_player_amount));
			room.tables[table_index].six_user_click.push(userno);
			console.log("room.tables[table_index].activity_timer_six"+room.tables[table_index].activity_timer_six);
			console.log("\n No of players "+ room.tables[table_index].players.length+" on table:- "+grpid);
			room.tables[table_index].six_usernames.push(username); 
			console.log("\n After joined , No of players "+room.tables[table_index].six_usernames.length+" on table:- "+grpid+" and are :- "+room.tables[table_index].six_usernames+"--"+room.tables[table_index].players);
			//..console.log("\n table details "+room.tables[table_index].players[0].name+" "+room.tables[table_index].players[0].id+"---"+player.id);
			for (var i = 0; i < room.tables[table_index].players.length; i++){
				player_playing[i] = room.tables[table_index].players[i].name;
			}
			
			/* Game has restarted , check no of players connected before game start **/
			////////////// chnage as per 6 players when restart ----------------------- REM DO LATER 
			if(join_count == 0)
			{				
			//..console.log("6-player-Game has started again - "+room.tables[table_index].readyToPlayCounter+" check tbl length "+room.tables[table_index].players.length);
				if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
				{
					//..console.log("2 or more  players exist in 6-player-Game, checking are same as previously playing ");		
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						if (room.tables[table_index].players[i].id == player.id)
						{
							room.tables[table_index].readyToPlayCounter++;
						}	
					}
				} 
				//..console.log("No of players after restart game checked :"+room.tables[table_index].readyToPlayCounter);
			   if (room.tables[table_index].players.length == 1) 
				{
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						if (room.tables[table_index].players[i].name == username)
						{
							join_count = 1;
							restart_count = 1;
						}
					}
				}
				//if(room.tables[table_index].readyToPlayCounter == 2 )
				if(room.tables[table_index].readyToPlayCounter >=2 && room.tables[table_index].readyToPlayCounter <=6)
				{ join_count = 2; }
				
				if(join_count == 2)
				{ room.tables[table_index].restart_game_six = true; }
				console.log("join count after game restarted "+join_count+" so is restart game :- "+room.tables[table_index].restart_game_six);
				
			}else{
				join_count=room.tables[table_index].players.length;
				console.log('join count'+join_count);
				for (var j = 0; j < room.tables[table_index].players.length; j++)
				{
					all_player_status = room.tables[table_index].players[j].status;
					if(all_player_status != "disconnected")
					{
						/** Players Names**/
						room.tables[table_index].players_names[j] =room.tables[table_index].players[j].name;
						/** Players amount playing (virtual)**/
						room.tables[table_index].players_amounts[j] = room.tables[table_index].players[j].amount_playing;
						/** Players User Id**/
						room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
						/** Players game status**/						
					}
				}
			} 
			

		//check according to player balance is he/she able to play game or not
		 if(room.tables[table_index].restart_game_six == true)
		   {
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					room.tables[table_index].players[i].amount_playing = getFixedNumber(room.tables[table_index].players_amounts[i]);
					
					if(room.tables[table_index].players[i].amount_playing >= (room.tables[table_index].table_min_entry*4))
					{ play_game = true; }
					else
					{ play_game = false; }
					
				}
			}


     		
				
			con.query("SELECT `user_id` FROM `user_tabel_join` where username='"+username+"' and joined_table ='"+grpid+"'",function(er,result,fields)  
			{ 
			
			     if (er) {
							console.log(er);
			    }else{ 
					if(result.length==0)
					{
						var qry1= "SELECT user_id FROM `users`  where `username` ='"+username+"' ";		
						con.query(qry1, function(err, user, userfields)
						{
							console.log(qry1);
							if(user.length!=0)
							{
								user_id=user[0].user_id;
								console.log("user id"+user_id);
								var query="insert into user_tabel_join( `user_id`,`username`,`game_type`,`chip_type`,`player_capacity`, `joined_table`,`amount_to_revert`,`min_entry`) values('"+user_id+"','"+username+"','"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].playerCapacity+"','"+grpid+"','"+pl_amount_taken+"','"+room.tables[table_index].table_min_entry+"')";
								con.query(query, function(err1, result)
								{console.log(query);	});
								
							}
						});
						
					}
				}
			});	
           
		   if(join_count==1)
			{
				console.log("\n JOIN COUNT 1 username  "+username+" sit no "+userno+" grp id "+grpid);	
				console.log("A player "+username+" has joined (join_count = "+join_count+" ) , waiting for another player .");
				console.log("Player "+username+" status: "+player.status+"\n");
				room.tables[table_index].activity_timer_six = -1;
				console.log("restart_count"+restart_count);
				if(restart_count !=1){
				   if(username){
					socket.broadcast.emit('player_join_table',username, player_playing,userno,grpid,round_no,room.tables[table_index].activity_timer_six,pl_amount_taken,gender,false,0);
					socket.emit('player_join_table',username, player_playing,userno,grpid,round_no,room.tables[table_index].activity_timer_six,pl_amount_taken,gender,false,0);
					}
				}
				
				if(restart_count ==1 && room.tables[table_index].connectedSocket() == 1)
				{
					/*** CHNAGE ACCORDING TO 6 PLAYERS ****/
					
					console.log(room.tables[table_index].six_usernames);
					if(room.tables[table_index].players[0].id != ''){
					         io.sockets.connected[(room.tables[table_index].players[0].id)].emit('check_if_joined_player',room.tables[table_index].six_usernames,
							room.tables[table_index].six_user_click,grpid,room.tables[table_index].six_player_amount,room.tables[table_index].six_player_gender,false);
					}
					
					for (var j = 0; j < room.tables[table_index].players_names.length; j++)
		      		{
		      			if(room.tables[table_index].players[0].name == room.tables[table_index].players_names[j])
					    {
							room.tables[table_index].players[0].amount_playing = getFixedNumber(room.tables[table_index].players_amounts[j]);
							room.tables[table_index].players[0].game_status = room.tables[table_index].players_final_status[j];
							room.tables[table_index].players[0].user_id = room.tables[table_index].players_user_id[j];
						}
		      		}
				}
				
				room.tables[table_index].readyToPlayCounter++;
				//..console.log("on Table:"+grpid+" No of players:-  in join-1 "+room.tables[table_index].readyToPlayCounter+" no_of_players_joined "+room.tables[table_index].no_of_players_joined+"\n");
			}else if(join_count>=2){
				console.log("\n 2nd player "+username+" has joined to global.table "+grpid+" (join_count = 2)"+" restart_game_six "+room.tables[table_index].restart_game_six);	
				var temp_count = 5;
				if(room.tables[table_index].restart_game_six == false){
					room.tables[table_index].readyToPlayCounter++;
					no_of_players_joined=0;
				}
				//..console.log("on Table:"+grpid+"  after join 2  No of players:- "+room.tables[table_index].readyToPlayCounter+"\n");
				if( !room.tables[table_index].isAvailable() ) {
					room.tables[table_index].activity_timer_six = -2;
					if(username){
					socket.broadcast.emit('player_join_table',username, player_playing,userno,grpid,round_no,room.tables[table_index].activity_timer_six,pl_amount_taken,gender,false,0);
					socket.emit('player_join_table_wait', grpid);
					}
				} else if(room.tables[table_index].readyToPlayCounter >=2 && room.tables[table_index].readyToPlayCounter <=6){					
					con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards` where `id` < 53",function(er,result,fields)  
					{ 
					    if (er) {
							console.log(er);
			            }else{ 
						cards_without_joker_six.push.apply(cards_without_joker_six, result); 
						}
					});	

					con.query("SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM `cards`", function(err1, rows, fields1) 
					{ 
					     if (err1) {
							console.log(err1);
			             }else{ 
						   cards_six.push.apply(cards_six , rows); 
						 }
					}); 
					
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						console.log("Player "+room.tables[table_index].players[i].name+" status: "+room.tables[table_index].players[i].status);
					}
					
					//..console.log("\n --------------- room.tables[table_index].activity_timer_set "+room.tables[table_index].activity_timer_set);
					random_group_roundno =  Math.floor(100000000 + Math.random() * 900000000);//6-digit-no
					if(room.tables[table_index].activity_timer_set == false){
						room.tables[table_index].activity_timer_six = room.tables[table_index].six_player_timer_array[0];
						room.tables[table_index].activity_timer_client_side_needed_six= room.tables[table_index].six_player_timer_array[0];
						room.tables[table_index].activity_timer_set = true;
					}
					if(room.tables[table_index].activity_timer_set == false){
					console.log("Game will start after "+room.tables[table_index].activity_timer_six+" seconds"+"\n");
					}
					
					room.tables[table_index].round_id = random_group_roundno;
					console.log("\n"+"Round id generated for table "+grpid+" is: "+random_group_roundno+" (table.round_id) is "+room.tables[table_index].round_id);
					
					//..console.log("\n ********** GAME RESTART "+restart_game_six+" -- room.tables[table_index].restart_game_six -- "+room.tables[table_index].restart_game_six+"--room.tables[table_index].activity_timer_six--"+room.tables[table_index].activity_timer_six);
					clearInterval(room.tables[table_index].game_countdown_six); 
					if(room.tables[table_index].activity_timer_set == false){
						room.tables[table_index].activity_timer_six = room.tables[table_index].six_player_timer_array[0];
						room.tables[table_index].activity_timer_set = true;
					}
					room.tables[table_index].restart_game_six = false;
					
					if(room.tables[table_index].activity_timer_running == false)
					{
						//console.log("\n .......... activity_timer_running b4 countdown --  "+room.tables[table_index].activity_timer_running);
						room.tables[table_index].game_countdown_six = setInterval(function()
						{
							var startingPlayerID ;
							var startingPlayerName ;
							var dealer_player_name ;
							var query;
							var p1_handcards = [];var p2_handcards = [];var closecards = [];
							var opp_pl_name ;
							var pl_name;
							var pl_IP;
							var pl_Isp;
							var pl_OS;
							var pl_device_name;
							var pl_sock;
							var pl_browser;
							//console.log("\n .......... in countdown -- activity_timer_running "+room.tables[table_index].activity_timer_running);
							//room.tables[table_index].activity_timer_running = true;
							var table_index = getTableIndex(room.tables,grpid);
							if (table_index == - 1) {
								console.log("GameCountDown Failed");
								return;
							}

							if(room.tables[table_index].restart_game_six == true)
							{
								room.tables[table_index].activity_timer_six = room.tables[table_index].six_player_timer_array[0];
								clearInterval(room.tables[table_index].game_countdown_six);
								room.tables[table_index].restart_game_six = false;
							}
							//  if (room.tables[table_index].players.length == 2) 
							if(room.tables[table_index].readyToPlayCounter >=2 && room.tables[table_index].readyToPlayCounter <=6)
							{
								
				
								//ANDY 2019/05/22 if( room.tables[table_index].restart_game_six == false)
								{
									//console.log("@@@@@@@@@@@@@@@@@@@@@@@@@@@room.tables[table_index].six_user_click"+room.tables[table_index].six_user_click);
									socket.emit('player_join_table',
									room.tables[table_index].six_usernames, player_playing, room.tables[table_index].six_user_click,grpid,random_group_roundno,room.tables[table_index].activity_timer_six,room.tables[table_index].six_player_amount,
									room.tables[table_index].six_player_gender,room.tables[table_index].restart_game_six,room.tables[table_index].activity_timer_client_side_needed_six,is_joined_table);

									socket.broadcast.emit('player_join_table',
									room.tables[table_index].six_usernames, player_playing, room.tables[table_index].six_user_click,grpid,random_group_roundno,room.tables[table_index].activity_timer_six,room.tables[table_index].six_player_amount,
									room.tables[table_index].six_player_gender,room.tables[table_index].restart_game_six,room.tables[table_index].activity_timer_client_side_needed_six,is_joined_table);
								}
								
								

								if(room.tables[table_index].restart_game_six == true)/////CHNAGES NEEDED 
								{
									for (var i = 0; i < room.tables[table_index].players.length; i++)
									{
										var sql_amt = "UPDATE user_tabel_join SET round_id = '0' , amount_to_revert = '"+room.tables[table_index].players[i].amount_playing+"' where username='"+room.tables[table_index].players[i].name+"' and joined_table ='"+grpid+"'";
										con.query(sql_amt, function (err, result) {
										if (err) throw err;
										else {}});
									}					
									
									for (var j = 0; j < room.tables[table_index].players.length; j++)
									{
										for (var i = 0; i < room.tables[table_index].players_names.length; i++)
										{
											//console.log("\n BEFORE UPDATE amt of "+room.tables[table_index].players[j].name+" -->"+room.tables[table_index].players[j].amount_playing);
											if(room.tables[table_index].players[j].name == room.tables[table_index].players_names[i])
											{
												room.tables[table_index].players[j].amount_playing = getFixedNumber(room.tables[table_index].players_amounts[i]);
												room.tables[table_index].players[j].game_status = room.tables[table_index].players_final_status[i];
												room.tables[table_index].players[j].user_id = room.tables[table_index].players_user_id[i];
											}
										}
										//console.log("\n updated amt of "+room.tables[table_index].players[j].name+" -->"+room.tables[table_index].players[j].amount_playing);
									}

									//console.log("\n ---------- amount updated aftre restart "+room.tables[table_index].players_names+"---"+room.tables[table_index].players_amounts);
									for (var j = 0; j < room.tables[table_index].players.length; j++)
									{
									    if(room.tables[table_index].players[j].id != ''){
										io.sockets.connected[(room.tables[table_index].players[j].id)].emit("update_amount_six",
											grpid,room.tables[table_index].players_names,room.tables[table_index].players_amounts);
											}
									}
								}
									// console.log("room.tables[table_index].activity_timer_six :"+room.tables[table_index].activity_timer_six);

								room.tables[table_index].activity_timer_six--;
								if (room.tables[table_index].activity_timer_six == 0) 
								{
						
									for (var i = 0; i < room.tables[table_index].players.length; i++)
									{
										var sql_amt = "UPDATE user_tabel_join SET round_id = '"+room.tables[table_index].round_id+"' , amount_to_revert = '"+room.tables[table_index].players[i].amount_playing+"' where username='"+room.tables[table_index].players[i].name+"' and joined_table ='"+grpid+"'";
										con.query(sql_amt, function (err, result) {
										if (err) throw err;
										else {
										console.log(sql_amt);
										}
										});
									}
									room.tables[table_index].restart_game_six = false;

									
										//as 2 players connected change table status from 'available' to 'unavailable'
									room.tables[table_index].status = "unavailable";
									//..console.log("table "+grpid+" status: "+room.tables[table_index].status+"\n");
									//as 2 players connected change player status from 'intable' to 'playing'
									for (var i = 0; i < room.tables[table_index].players.length; i++)
									{
										if( room.tables[table_index].players[i].status != "disconnected")
											room.tables[table_index].players[i].status = "playing";
										console.log("Player "+room.tables[table_index].players[i].name+" status: "+room.tables[table_index].players[i].status);
									}
									console.log("Activity_timer =="+room.tables[table_index].activity_timer_six+" So game will start now."+"\n");
									clearInterval(room.tables[table_index].game_countdown_six);  
							 
									/*************** GAME RESTART CLEAR ALL DATA ***********/
									clear_all_data_before_game_start(room.tables[table_index]);
									/*************** GAME RESTART CLEAR ALL DATA ***********/
									
									//..console.log("Comparing random cards assigned to each player to Decide TURN"+"\n");
									var c1,c2,c3,c4,c5,c6;
									var card_arr_points = [];
									var card_arr_sub_id = [];
									var card_arr_name = [];
									var card_arr_path = [];
									var pl_seq_arr = [];
									var prev_card=0;

									for (var i = 0; i < room.tables[table_index].players.length; i++)
									{
										c1 = drawImages((shuffleImages(cards_without_joker_six)), 1, "", 1);
										if(i==0){	prev_card = c1[0].points; }
										if(c1[0].points == prev_card)
										{
											c1 = drawImages((shuffleImages(cards_without_joker_six)), 1, "", 1);
											prev_card = c1[0].points;
										}
									
										//need to change here for different turn card 
										//..console.log("Card assigned to player 1- "+room.tables[table_index].players[i].name+" is "+c1[0].card_path);
										card_arr_points.push(c1[0].points);
										card_arr_sub_id.push(c1[0].sub_id);
										card_arr_name.push(c1[0].name);
										card_arr_path.push(c1[0].card_path);
									}
									//..console.log("\n card_arr_points "+JSON.stringify(card_arr_points));
									//..console.log("\n card_arr_sub_id "+JSON.stringify(card_arr_sub_id));

									var card_name = card_arr_name[0];
									var is_all_cards_with_same_name = false;
									var max_card,last_card_index;
									for(var  i = 1; i < card_arr_name.length; i++)
									{
										if(card_arr_name[i].suit == card_name)
											{
												if( i == (card_arr_name.length-1))
												{
													is_all_cards_with_same_name = true;
												}
												else { continue; }
											}
											else { is_all_cards_with_same_name = false; }
									}
									if(is_all_cards_with_same_name == false)
									{
										max_card= indexOfMax(card_arr_points);
										last_card_index = indexOfLast(card_arr_points);
										//console.log("\n --------- max_card if diff name ==> "+max_card);
										startingPlayerID = room.tables[table_index].players[max_card].id;
										startingPlayerName = room.tables[table_index].players[max_card].name;
										dealer_player_name = room.tables[table_index].players[last_card_index].name;
									}
									else
									{
										max_card = indexOfMax(card_arr_sub_id);
										last_card_index = indexOfLast(card_arr_sub_id);
										//console.log("\n --------- max_card if same name ==> "+max_card);	
										startingPlayerID = room.tables[table_index].players[max_card].id;
										startingPlayerName = room.tables[table_index].players[max_card].name;
										dealer_player_name = room.tables[table_index].players[last_card_index].name;
									}

									room.tables[table_index].startingPlayerID = startingPlayerID;
									room.tables[table_index].startingPlayerName = startingPlayerName;
									console.log("players b4 seq making function  "+room.tables[table_index].six_usernames.toString());
									room.tables[table_index].pl_seq_arr =  getPlayerSequence(room.tables[table_index].six_usernames,startingPlayerName);

									//..console.log("\n startingPlayerID"+startingPlayerID+" -- name --"+startingPlayerName);	
									console.log("\n"+"Player "+startingPlayerName+" has TURN");	
									console.log("\n"+"Player "+dealer_player_name+" is a Dealer.");	
									room.tables[table_index].dealer_name = dealer_player_name;
									
									console.log('card_arr_path'+card_arr_path);

									////assign 13 hand cards to player 1 - player 6 --- (joined players )
									for (var i = 0; i < room.tables[table_index].players.length; i++) 
									{
										room.tables[table_index].players[i].hand = drawImages((shuffleImages(cards_six)), 13, "", 1);
									}
									
									for (var i = 0; i < room.tables[table_index].players.length; i++) 
									{
										for (var j = 0; j < room.tables[table_index].players[i].hand.length; j++)
										{
											room.tables[table_index].players[i].hand_cards_id.push(room.tables[table_index].players[i].hand[j].id);
										}					
									}	
                                   									
									////assign open card to both players
									var player1_opencard = drawImages((shuffleImages(cards_six)), 1, "", 1);
									console.log("\n"+"Assigned Open card is: "+player1_opencard[0].card_path+" id is: "+player1_opencard[0].id);
									var player_open_card_id = player1_opencard[0].id;
									room.tables[table_index].open_cards=player1_opencard;
									room.tables[table_index].open_card_obj_arr = [];
									room.tables[table_index].open_card_obj_arr.push(player1_opencard);
									room.tables[table_index].open_card_status = "initial";
									
				 
				 					////assign joker card to both players
									var joker_card = drawImages((shuffleImages(cards_six)), 1, "", 1);
										console.log("Assigned Side-Joker card is: "+joker_card[0].card_path);
										room.tables[table_index].side_joker_card = joker_card[0].card_path;
										room.tables[table_index].side_joker_card_name = joker_card[0].name;
										
										
									
																						
										
									var joker_qry = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where points = 0 or points = "+joker_card[0].points+" and id not in ("+joker_card[0].id+")";
									if( joker_card[0].points == 0 ) {
										joker_qry = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where points = 0 or points = 14 and id not in ("+joker_card[0].id+")";
									}
									con.query(joker_qry,function(er,result,fields)  
									{ 
										 if (er) {
													console.log(er);
										}else{ 
										joker_cards = [];
										joker_cards.push.apply(joker_cards,result); 
										room.tables[table_index].joker_cards.push.apply(room.tables[table_index].joker_cards,joker_cards);
										}
									});	
									
									//=============Papplu joker===============
									
									var papplusuitid='';
									var papplusuit='';
									if(joker_card[0].suit_id == 13){
									papplusuitid=1;
									papplusuit=joker_card[0].suit;
									} else if(joker_card[0].suit_id == 0){
									papplusuitid=2;
									papplusuit='S';
									}else{
									papplusuitid=joker_card[0].suit_id+1;
									papplusuit=joker_card[0].suit;
									}
												
                                 var papplu_joker_qry = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where  suit_id = "+papplusuitid+" and suit = '"+papplusuit+"'";
								console.log("=========================table.papplu_joker_qry ====================================="+papplu_joker_qry);
								
								con.query(papplu_joker_qry,function(er,result,fields)  
								{ 
								   if(er){
								       console.log("===================Error In Papplu jopker Query===================== "+papplu_joker_qry);
								   }else{
								    room.tables[table_index].papplu_joker_card = result[0].card_path;
									room.tables[table_index].papplu_joker_card_name = result[0].name;
									room.tables[table_index].papplu_joker_card_id = result[0].id;
									console.log("=========================table.Papplujoker_cards in user join func ====================================="+room.tables[table_index].papplu_joker_card);
								    joker_cards.push.apply(joker_cards,result); 
									//console.log("Joker Cards are: 2 " +JSON.stringify(joker_cards));
									room.tables[table_index].joker_cards.push.apply(room.tables[table_index].joker_cards,joker_cards);
									console.log("===================table.papplu==joker_cards===================== "+JSON.stringify(room.tables[table_index].joker_cards));
								   // finishRequest(result);
									}
								});	
                                    
																	
									console.log("\n"+"Start=================."+"\n");
									var joker_qry1 = "SELECT `id`, `sub_id`, `name`, `suit`, `game_points`, `points`, `card_path`, `suit_id` FROM cards where points = 0 ";
									con.query(joker_qry1,function(er,result,fields)  
									{ 
									
									     if (er) {
													console.log(er);
										}else{ 
									    console.log("\n"+"in=================."+"\n");
										// room.tables[table_index].pure_joker_cards_six.push.apply(room.tables[table_index].pure_joker_cards_six,result);
										// console.log("table.pure_joker_cards_six "+JSON.stringify(room.tables[table_index].pure_joker_cards_six));
										room.tables[table_index].pure_joker_cards.push.apply(room.tables[table_index].pure_joker_cards,result);
										//console.log("table.pure_joker_cards "+JSON.stringify(room.tables[table_index].pure_joker_cards));
									    }
									
									});		
									console.log("\n"+"out=================."+"\n");
									
									var close_card_count = 106 - 2 - 13 * room.tables[table_index].players.length;
									////assign closed cards to all 6  players
									var closed_cards = drawImages((shuffleImages(cards_six)), close_card_count, "", 1);
										//console.log("\n"+"Assigned closed cards count "+ closed_cards.length);
										//console.log("Assigned closed cards: ");
									for (var i = 0; i < closed_cards.length; i++)
									{
										closecards.push(closed_cards[i].id);
										room.tables[table_index].closed_cards_arr.push(closed_cards[i]);
									}
										// console.log("\n table close cards array "+JSON.stringify(room.tables[table_index].closed_cards_arr));
									//..console.log("\n"+"Inserting player and assigned card details to database."+"\n");

									//inserting player details and card details to database  
									group = grpid;
									roundno = random_group_roundno;
									for (var i = 0; i < room.tables[table_index].players.length; i++)
									{
										pl_name = (room.tables[table_index].players[i].name);
										pl_IP = (room.tables[table_index].players[i].getIp());
										pl_Isp = (room.tables[table_index].players[i].getIsp());
										pl_OS = (room.tables[table_index].players[i].getOS());
										pl_device_name = (room.tables[table_index].players[i].getDevice());
										pl_sock  = (room.tables[table_index].players[i].id);
										pl_browser = (room.tables[table_index].players[i].getBrowser());
										
										query="insert into game_details(`user_id`, `group_id`, `round_id`, `socket_id`, `ip_address`, `isp`, `os_type`, `device_name`,browser_using,`hand_cards`,`close_cards`, `open_card`) values('"+room.tables[table_index].players[i].name +"','"+group+"','"+roundno+"','"+pl_sock+"','"+pl_IP+"','"+pl_Isp+"','"+pl_OS+"','"+pl_device_name+"','"+pl_browser+"','"+room.tables[table_index].players[i].hand_cards_id+"','"+closecards+"','"+player1_opencard[0].id+"');";
										con.query(query, function(err1, result){ if (err1) {console.log(err1);} }); 
										
									}//for-insert-db
				
									/* Emitting players turn card and other details*/
									//..console.log("Emitting assigned card details to players. "+room.tables[table_index].players[0].name+","+room.tables[table_index].players[1].name+" with round id "+roundno+" and table id "+group);
									
									//var finishRequest = function(result) {
										for (var i = 0; i < room.tables[table_index].players.length; i++) 
										{
										
											
										    if(room.tables[table_index].players[i].id != ''){
													if (room.tables[table_index].players[i].id === startingPlayerID)
													{
													
														room.tables[table_index].players[i].turn = true;
														if(room.tables[table_index].players[0].turn == true)
														{ opp_pl_name = room.tables[table_index].players[1].name;} 
														else { opp_pl_name = room.tables[table_index].players[0].name;} 
														
														if(room.tables[table_index].players[i].status != "disconnected")
														{
															if(is_all_cards_with_same_name == false)
															{ //card_arr_points
																io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card", 
																{ card_no:card_arr_points[i],card:card_arr_path[i],other_card_path:card_arr_path ,
																other_card_no:card_arr_points ,group_id:group,round_no:roundno,dealer:dealer_player_name,game_restart:room.tables[table_index].restart_game_six}); 
															}
															else
															{
																io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card", 
																{ card_no:card_arr_sub_id[i],card:card_arr_path[i],other_card_path:card_arr_path ,
																other_card_no:card_arr_sub_id ,group_id:group,round_no:roundno,dealer:dealer_player_name,game_restart:room.tables[table_index].restart_game_six}); 
															}	
															
															console.log("=========================table.Papplujoker_cards in turn player join table ====================================="+room.tables[table_index].papplu_joker_card);
															
																io.sockets.connected[(room.tables[table_index].players[i].id)].emit("turn", 
																{ myturn: true,group_id:group,assigned_cards:room.tables[table_index].players[i].hand,
																	opencard:'',opencard_id:player_open_card_id,
																	closedcards_path:room.tables[table_index].closed_cards_arr,closedcards:closed_cards,
																	turn_of_user:startingPlayerName,opp_user:opp_pl_name,
																	opencard1:'',sidejoker:joker_card[0].card_path,
																	open_close_pick_count:room.tables[table_index].players[i].open_close_selected_count,
																	round_no:roundno,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name
																});
															
														}
													}
													else
													{
														room.tables[table_index].players[i].turn = false;
														if(room.tables[table_index].players[0].turn == true)
														{ opp_pl_name = room.tables[table_index].players[1].name;} 
														else { opp_pl_name = room.tables[table_index].players[0].name;} 
														
														if(room.tables[table_index].players[i].status != "disconnected")
														{
															if(is_all_cards_with_same_name == false)
															{
																io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card", 
																{ card_no:card_arr_points[i],card:card_arr_path[i],other_card_path:card_arr_path ,
																other_card_no:card_arr_points ,group_id:group,round_no:roundno,dealer:dealer_player_name}); 
															}
															else
															{
																io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card", 
																{ card_no:card_arr_sub_id[i],card:card_arr_path[i],other_card_path:card_arr_path ,
																other_card_no:card_arr_sub_id ,group_id:group,round_no:roundno,dealer:dealer_player_name}); 
															}	
														
														    console.log("=========================table.Papplujoker_cards in turn player join table ====================================="+room.tables[table_index].papplu_joker_card);
														
														
															io.sockets.connected[(room.tables[table_index].players[i].id)].emit("turn",
															{ myturn: false,group_id:group,assigned_cards:room.tables[table_index].players[i].hand,
																opencard:'',opencard_id:player_open_card_id,
																closedcards_path:room.tables[table_index].closed_cards_arr,closedcards:closed_cards,
																turn_of_user:startingPlayerName,opp_user:opp_pl_name,
																opencard1:'',sidejoker:joker_card[0].card_path,sidejokername:joker_card[0].name,
																open_close_pick_count:room.tables[table_index].players[i].open_close_selected_count,
																round_no:roundno,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name
															});
														
														
														}
													}
													
											}
										}//turn card for 
									//}
									
									
									
				
									//set 5 seconds delay then emit turn timer after cards distributed to both players 
									room.tables[table_index].countdown_tcount = temp_count;
									room.tables[table_index].countdown_timer = setInterval(function()
									{
										room.tables[table_index].countdown_tcount--;
										if (room.tables[table_index].countdown_tcount == 0)
										{
											clearInterval(room.tables[table_index].countdown_timer);  
											room.tables[table_index].no_of_live_players = get_remaining_no_of_playing_players(group);
											emitTurnTimerSix(room.tables[table_index].startingPlayerID,room.tables[table_index].startingPlayerName,
												room.tables[table_index].id, room.tables[table_index].six_player_timer_array[1],false,
												roundno, amount,
												room.tables[table_index].pl_seq_arr);
										}
									}, 1000);
			  					}//activity-timer-0-ends
		   					}////if-2pl-condition
		 				}, 1000);
					}//timer-once-started
	  			}////if table has 2 players 
	  		}//join-2-condition
	 	}//main-outer-if
	});  
  

	function getPlayerSequence(player_name_array,startingPlayerName)
	{
		var player_name_arr = [];
		var player_name_arr_temp = [];
		player_name_arr.push.apply(player_name_arr,player_name_array);

		for(var  i = 0; i < player_name_arr.length;)
			{
				if(player_name_arr[i] != startingPlayerName)
				{
					
					player_name_arr_temp.push(player_name_arr[i]);
					index = i;
					if(index != -1)
						{
							player_name_arr.splice(index, 1);
						}
				}
				else
				{
					i++
					break;
				}
			}
		player_name_arr.push.apply(player_name_arr,player_name_arr_temp);

		//console.log("\n $$$$$$$$$$$$$$$$$$$$$$$$$$$$ PLAYER NAMES SEQUENCE ARRAY -----"+JSON.stringify(player_name_arr));
		return player_name_arr;
	}//getPlayerSequence ends
	
	
	var first_player_count_six = 1;
	var second_player_count_six = 1;
	//// showing timer alternate to players ////
	function emitTurnTimerSix(pl_id,name,group,timer,is_discard,roundid,player_amount,pl_seq_arr)
	{
		//console.log("Emitting Timer with turn to table : "+group+" for round id "+roundid); 
		console.log("\n Turn of Player : "+name); 
		var player = room.getPlayer(socket.id);
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) { console.log("\n emitTurnTimerSix"); return;	}	
		
		room.tables[table_index].is_finish = false;
		
		if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
		{
			room.tables[table_index].turnTimer = setInterval(function()
			{

				var player_id = pl_id;
				var opp_player_id;
				var opp_player;
				var is_discard = false;
				var is_finished_game = false;
				var is_declared = false;
				var is_dropped = false;
				var declare = 0;
				var turn_player_status,opp_player_status;
				var opp_player_amount = 0;
				var player_group_count = 0;
				var is_player_grouped = false;
				var go_to_final_timer = false;
				var next_turn_index = 0;
				var next_turn_player;
				var game_status;
				var extra_time = 0;
				var player_turn_only_first = false;

				var table_index = getTableIndex(room.tables,group);
				if (table_index == - 1) { console.log("\n emitTurnTimerSix error"); return;	}	
				
				
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					if(room.tables[table_index].players[i].player_reconnected == true)
					{
						//console.log(" \n player re-connected "+room.tables[table_index].players[i].name);
						if((room.tables[table_index].players[i].status) == "playing")
						{
							room.tables[table_index].players[i].id = room.tables[table_index].players[i].id;
							if((room.tables[table_index].players[i].is_turn) == true){ player_id = room.tables[table_index].players[i].id; }
						}
					}
				}

			
				
				
				
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					if (room.tables[table_index].players[i].name == name)
				 	{ 
						 room.tables[table_index].players[i].is_turn = true;
						
						 extra_time = room.tables[table_index].players[i].extra_time;

				 		is_finished_game = room.tables[table_index].players[i].gameFinished;
				 		if(is_finished_game == true)
				 		{
				 			room.tables[table_index].players[i].is_player_finished = true;
				 		}

				 		is_discard = room.tables[table_index].players[i].turnFinished;
						is_declared = room.tables[table_index].players[i].declared;
						is_dropped = room.tables[table_index].players[i].is_dropped_game;
						turn_player_status = room.tables[table_index].players[i].status;
						is_player_grouped = room.tables[table_index].players[i].is_grouped;
						game_status = room.tables[table_index].players[i].game_status;
						player_start_play = room.tables[table_index].players[i].player_start_play;

						player_turn_only_first = room.tables[table_index].players[i].player_turn_only_first;
						//game_status = room.tables[table_index].game_finished_status ? "Won" : "";
				 	}
				 	else
				 	{
				 		room.tables[table_index].players[i].is_turn = false;
				 	}
				}		
                 
				console.log("===================extra_time===================== "+extra_time);
        		console.log("===================player_start_play===================== "+player_start_play);
        								 
				 for (var i = 0; i < room.tables[table_index].players.length; i++) {
				      if (room.tables[table_index].players[i].name == name)
        			  {
						  console.log("===================room.tables[table_index].players[i].name===================== "+room.tables[table_index].players[i].name);
        		
						   if(extra_time == 1){
							
						            room.tables[table_index].players[i].player_turn_only_first=true;
							 
								 
									if( room.tables[table_index].players[i].player_start_play == false) {
										
												drop_game_six_func(room.tables[table_index].players[i].name , group, roundid, false, false, false);
												//drop_game_six_papplu_func(room.tables[table_index].players[i].name , group, roundid, false, false, false);
												room.tables[table_index].players[i].freeturn = 0;
												 room.tables[table_index].players[i].player_turn_only_first=false;
												
									}
								
								
						   }
					  }
				}
				
				

				next_turn_player = next_turn_of_player(group,name,pl_seq_arr);	
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					
				   //emit timer to player who has TURN
					if (room.tables[table_index].players[i].name == name)
        			{ 
				       
						//console.log("===================table.joker_cards===================== "+JSON.stringify(room.tables[table_index].players[i].hand));
        				if(turn_player_status != "disconnected")
        				{
						  
							player_id = room.tables[table_index].players[i].id; 
							if(io.sockets.connected[player_id]) { 
								io.sockets.connected[player_id].emit("timer_six", 
								{ 
							         
									id:player_id,myturn:true,turn_of_user:name,group_id:group,game_timer:timer, extra_time: extra_time,is_discard:is_discard,
									round_id:roundid,is_declared:is_declared,is_dropped:is_dropped, is_poolpoint:false,player_start_play:player_start_play,
									player_turn_only_first:player_turn_only_first,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name
								});
							}
						}
					}
					else //emit timer to player who DON'T have TURN
					{
						opp_player_id = room.tables[table_index].players[i].id; // ANDY
						
						if(is_finished_game == true)
						{
							room.tables[table_index].is_finish = true;
							timer = room.tables[table_index].six_player_timer_array[2];
							extra_time = 0;
							console.log("finished " + opp_player_id);
						}
						else
						{							
							opp_player_status = room.tables[table_index].players[i].status;
							opp_player_amount = room.tables[table_index].players[i].amount_playing;
						}
						if(opp_player_status != "disconnected")
						{
							if(io.sockets.connected[opp_player_id]) {
								io.sockets.connected[opp_player_id].emit("timer_six", 
								{ 
									id:opp_player_id,myturn:false,turn_of_user:name,group_id:group,game_timer:timer, extra_time: extra_time,
									is_discard:is_discard,round_id:roundid,is_declared:is_declared,is_dropped:is_dropped,
									is_poolpoint:false,papplu_joker_card:room.tables[table_index].papplu_joker_card,papplu_joker_card_name:room.tables[table_index].papplu_joker_card_name
								});
							}
						}
					}
				}
				
				
			

			    is_finished_game = false;
			    //6-pl-change
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					room.tables[table_index].players[i].gameFinished = false;
				}
				 
				
					if( timer > 0 ) {
						timer--;
					} else {
						extra_time = 0;
						if( room.tables[table_index].is_finish == false ) {
							for (var i = 0; i < room.tables[table_index].players.length; i++)
							{
								if (room.tables[table_index].players[i].name == name)
								{ 
									if( room.tables[table_index].players[i].extra_time > 0 ) {
										room.tables[table_index].players[i].extra_time --;
										extra_time = room.tables[table_index].players[i].extra_time;
									}
								}
							} 
						}
					}
				
				
				if(is_dropped == true || is_declared == true)
				{
					//if(room.tables[table_index].no_of_live_players==1 || game_status == "Won")
					console.log("\n no of live players in turn timer "+room.tables[table_index].no_of_live_players);
					if(game_status == "Won" && room.tables[table_index].no_of_live_players >=0 )
					{
						console.log("\n start final timer.............");
						go_to_final_timer = true;}
					else
					{
						removePlayerFromTurnSequence(pl_seq_arr,name);
					}
				}
				if(is_discard == true || is_declared == true || is_dropped == true)
				{
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						if (room.tables[table_index].players[i].id == player_id)
						{
							room.tables[table_index].players[i].freeturn = 0;
						}
					}
					timer = 0; 					
					extra_time = 0;
				} 
				if (timer == 0 && extra_time == 0) 
				{

					//6-pl-change
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						if (room.tables[table_index].players[i].id == player_id)
						{ 
							if(is_declared == false && is_dropped == false)
							{

								room.tables[table_index].players[i].turn_count++;
								room.tables[table_index].isfirstTurn = false;
								//..console.log("\n  player "+name+" turn count ---> "+room.tables[table_index].players[i].turn_count);
							}
						}
					}
					
					if(room.tables[table_index].is_finish == true && is_declared == false)
					{
						go_to_final_timer = declare_papplu_game_data_six(name,group,roundid,opp_player_amount,false,is_player_grouped,false,room.tables[table_index].table_point_value,room.tables[table_index].game_type,room.tables[table_index].table_name);
						is_declared = true;
					}

					//6-pl-change
					if(is_discard == false && is_declared == false && is_dropped == false && room.tables[table_index].is_finish == false)
					{
						for (var j = 0; j < room.tables[table_index].players.length; j++)
		      			{
							if(room.tables[table_index].players[j].name == name )
							{ 
								if(room.tables[table_index].players[j].open_close_selected_count == 1)
									return_open_card_six(j,player_id,name,group,roundid,room.tables[table_index].players[j].hand,room.tables[table_index].temp_open_object,turn_player_status);

								room.tables[table_index].players[j].freeturn++;
							}
						}
					}
					is_discard = false;
					is_finished_game = false;
					 
					 //6-pl-change
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						if (room.tables[table_index].players[i].is_turn == true)
						{ 
							room.tables[table_index].players[i].is_turn = false;
						}
						room.tables[table_index].players[i].turnFinished = false;
					 	room.tables[table_index].players[i].gameFinished = false;
					}
					 
					clearInterval(room.tables[table_index].turnTimer); 

/** IMP**/					 //CHECK IF NEEDED THEN DO CHANGES HERE 
					//6-pl-change

				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					if((room.tables[table_index].players[i].status) == "disconnected")
					{
						if(room.tables[table_index].players[i].player_reconnected == true)
						{
							if((room.tables[table_index].players[i].status) == "playing")
							{
								room.tables[table_index].players[i].id = room.tables[table_index].players[i].id;
								room.tables[table_index].players[i].status = "playing";
							}
						}
					}
				}

				
				
					 console.log("\n Turn to Next Player : "+next_turn_player+" - go_to_final_timer - "+go_to_final_timer); 
						if( go_to_final_timer != true){
						
							timer = room.tables[table_index].timer_array[1];
							opp_player = next_turn_player;	
							for (var i = 0; i < room.tables[table_index].players.length; i++)
							{
								if (room.tables[table_index].players[i].name == next_turn_player)
							 	{
							 		opp_player_id = room.tables[table_index].players[i].id;
									opp_player_status = room.tables[table_index].players[i].status;
									opp_player_amount = room.tables[table_index].players[i].amount_playing;
							 	}
							 }
							//..console.log("\n Six Player game NOT DECLARED SO TIMER 10/30 ");
							emitTurnTimerSix(opp_player_id,opp_player,group,timer,false,roundid,opp_player_amount,pl_seq_arr);
						}else{
							
							    emitFinalTimerSix(player_id,name,group,room.tables[table_index].six_player_timer_array[2],false,roundid,opp_player_amount, name);
                            							
						}
				}
			}, 1000);
		}
	}// emitTurnTimerSix() ends 

	
	
	
	
	function next_turn_of_player(tableid,turn_player_name,player_sequence_array)
	{
		var table_index =0;
		table_index = getTableIndex(room.tables,tableid);
		if (table_index == - 1) {
			console.log("\n next_turn_of_player");
			return;	
		}	
		var next_turn_of_player_index;
		var next_turn_of_player = player_sequence_array[0];;
		for (var i = 0; i < player_sequence_array.length; i++) 
		{
        	if (player_sequence_array[i] == turn_player_name) 
        	{
        		if(i==(player_sequence_array.length-1))
        		{
        			next_turn_of_player = player_sequence_array[0];
        			//next_turn_of_player_index = 0;
        		}
            	else 
            	{
            		next_turn_of_player = player_sequence_array[i+1];
            		//next_turn_of_player_index = i+1;
            	}
        	}
    	}
		//return next_turn_of_player_index;
    	return next_turn_of_player;
	}

	function removePlayerFromTurnSequence(player_sequence_array,playername) 
	{
		var index = -1;
		for(var  i = 0; i < player_sequence_array.length; i++)
		{
			if(player_sequence_array[i] === playername)
			{
				index = i;
				break;
			}
		}
		if(index != -1)
		{	player_sequence_array.remove(index); }
	}
	
	function return_open_card_six(pl_index,pl_id,pl_name,pl_group,round_id,pl_hand_cards,temp_open_object,player_status)
	{
		//..console.log("\n AUTO DISCARD in Six player game ");
		var pl_grp_arr = [];
		var table_index =0;
		table_index = getTableIndex(room.tables,pl_group);
		if (table_index == - 1) {
			console.log("\n return_open_card_six");
			return;	
		}	
		var all_player_status;
		
		if(room.tables[table_index].players[pl_index].is_grouped != true) 
		{
			pl_hand_cards = removeFromHandCards(pl_hand_cards,temp_open_object.id);
			//send updated hand cards 
			if(player_status != "disconnected")
			{
			    if(room.tables[table_index].players[pl_index].id != ''){
				io.sockets.connected[(room.tables[table_index].players[pl_index].id)].emit("update_hand_cards_six",
				{ user:pl_name,group:pl_group,round_id:round_id,hand_cards:pl_hand_cards,sidejokername:room.tables[table_index].side_joker_card_name});	
				}
			}
		}
		else
		{
			//get_player_groups
			pl_grp_arr = get_player_groups(pl_index,pl_group);
			for(var n=0; n<pl_grp_arr.length; n++)
			{
				removeFromSortedHandCards(pl_grp_arr[n],temp_open_object.id,0);
			}
			if(player_status != "disconnected")
			{
			    if(room.tables[table_index].players[pl_index].id != ''){
					io.sockets.connected[(room.tables[table_index].players[pl_index].id)].emit("update_player_groups_six", 
					{ user:pl_name,group:pl_group,round_id:round_id,grp1_cards:room.tables[table_index].players[pl_index].card_group1,grp2_cards:room.tables[table_index].players[pl_index].card_group2,grp3_cards:room.tables[table_index].players[pl_index].card_group3,grp4_cards:room.tables[table_index].players[pl_index].card_group4,grp5_cards:room.tables[table_index].players[pl_index].card_group5,grp6_cards:room.tables[table_index].players[pl_index].card_group6,grp7_cards:room.tables[table_index].players[pl_index].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
				}
			}
		}
		room.tables[table_index].open_card_obj_arr = [];
		room.tables[table_index].open_card_obj_arr.push(temp_open_object);
		room.tables[table_index].open_cards.push(temp_open_object);
		room.tables[table_index].open_card_status = "discard";
			
		room.tables[table_index].players[pl_index].open_close_selected_count = 0;
		for (var j = 0; j < room.tables[table_index].players.length; j++)
		{
			all_player_status = room.tables[table_index].players[j].status;
			if(all_player_status != "disconnected")
			{
			    if(room.tables[table_index].players[j].id != ''){
					io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_card_six",
					{ 
						path:temp_open_object.card_path,check:true,id:temp_open_object.id,discareded_open_card:temp_open_object,
						group:pl_group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards 
					});
				}
			}
		}
	}//return_open_card_six() ends

	function emitFinalTimerSix(pl_id,name,group,final_timer,is_discard,roundid,opp_player_amount, declared_user)
	{
		var player = room.getPlayer(socket.id);
		var table_index =0;
		
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n emitFinalTimerSix");
			return;	
		}	

		if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
		{
		    room.tables[table_index].finalTimer = setInterval(function()
		    {
				var player_id = pl_id;
				var opp_player_id;
				var opp_player;
				var is_discard = false;
				var is_finished_game = false;
				var is_declared = false;
				var is_dropped = false;
				var turn_player_status,opp_player_status;
				var player_group_count = 0;
				var is_player_grouped = false;
				var is_found = false;
				var isAllFinished;
				var player_start_play = false;
			
				
				var player_turn_only_first = false;
				var table_index = getTableIndex(room.tables, group);
				if (table_index == - 1) {
					console.log("\n emitFinalTimerSix");
					return;
				}
				console.log("\n emitting final timer  "+final_timer+" to player "+name);
				isAllFinished = true;
				
				
				final_timer--;
				console.log("\n  in final timer ---> player "+name+" is_declared "+is_declared);
				if(isAllFinished)
				{
					final_timer = 0; 
				} 
				if (final_timer == 0)
				{					
				/** Auto declare if player get disconnected **/
					if(room.tables[table_index].game_type != 'Deal Rummy') {
						for (var i = 0; i < room.tables[table_index].players.length; i++)
						{
							if (room.tables[table_index].players[i].name != name)
							{ 
								is_declared = room.tables[table_index].players[i].declared;
								is_dropped = room.tables[table_index].players[i].is_dropped_game;
								is_poolpoint = room.tables[table_index].players[i].poolamount_playing <= 0 ? true : false;
								is_player_grouped = room.tables[table_index].players[i].is_grouped;
								
								if(is_dropped == false && is_declared == false)
								{
								   //declare_papplu_game_data_six(name,group,roundid,opp_player_amount,false,is_player_grouped,false,room.tables[table_index].table_point_value,room.tables[table_index].game_type,room.tables[table_index].table_name);
						            
								} 
							}
						}
					}
					console.log("........ GAME FINISHED ........."+room.tables[table_index].game_finished_status);

					if(room.tables[table_index].game_finished_status == true)
					{
						console.log("........ GAME FINISHED .........");
						console.log(room.tables[table_index].six_usernames);

						room.tables[table_index].status = "available";

						for (var i = 0; i < room.tables[table_index].six_usernames.length; i++) {
							var player = room.getPlayerByName( room.tables[table_index].six_usernames[i], group );
							if( !player ) {
								for(j = 0; j < room.tables[table_index].players.length; j++) {
									if( room.tables[table_index].six_usernames[i] == room.tables[table_index].players[j].name ) {
										player = room.tables[table_index].players[j];
										break;
									}
								}
							}

							if( player ) {
								var idx = room.tables[table_index].getPlayerIdx(player);
								if( idx != -1 ) {
									room.tables[table_index].players[idx].declared = false;
									room.tables[table_index].players[idx].is_dropped_game = false;

									room.tables[table_index].six_player_amount[i] = room.tables[table_index].players[idx].amount_playing;
									room.tables[table_index].six_player_poolamount[i] = room.tables[table_index].players[idx].poolamount_playing;
                                    if(room.tables[table_index].players[idx].id != ''){
										if((room.tables[table_index].players[idx].status !="disconnected"))
										{
											io.sockets.connected[(room.tables[table_index].players[idx].id)].emit("game_finished_six",
											{
												user:room.tables[table_index].players[idx].name,group:group,round_id:roundid,
												player_amount: room.tables[table_index].players[idx].amount_playing,
												player_poolamount: room.tables[table_index].players[idx].poolamount_playing,
												joined: 2
											});
											
												if( room.tables[table_index].players[idx].amount_playing < (room.tables[table_index].table_min_entry * 4) ) {
													io.sockets.connected[(room.tables[table_index].players[idx].id)].emit("game_no_enough", room.tables[table_index].players[idx].name, group); 
												}
												/*else{
												  removePlayerFromTable(room.tables[table_index].players[idx].name, group);
												  revertPoints(room.tables[table_index].players[idx].name, room.tables[table_index].players[idx].amount_playing, room.tables[table_index].table_game);
												}*/
											
										} else {
											removePlayerFromTable(room.tables[table_index].players[idx].name, group);
											revertPoints(room.tables[table_index].players[idx].name, room.tables[table_index].players[idx].amount_playing, room.tables[table_index].table_game);
											console.log("REVERT 12769");
										}
									}
								} else {
									console.log("GAME FINISHED six name :" + room.tables[table_index].six_usernames[i] + ":" + player.id);
									if( io.sockets.connected[player.id] ) {
										console.log("send six name :" + room.tables[table_index].six_usernames[i] + ":" + player.id);
										io.sockets.connected[player.id].emit("game_finished_six",
										{
											user:player.name,group:group,round_id:roundid,
											player_amount: room.tables[table_index].six_player_amount[i],
											joined: 2
										});
									}
								}
							}
						}

						
					room.tables[table_index].players = [];
					room.tables[table_index].readyToPlayCounter = 0;
					room.tables[table_index].game_declare_status = "Invalid";
					room.tables[table_index].activity_timer_set = false;
					room.tables[table_index].game_finished_status = true;
						 
					room.tables[table_index].six_player_amount =[];
					room.tables[table_index].six_usernames = [];
					room.tables[table_index].six_user_click = [];
					room.tables[table_index].six_player_gender = [];
					room.tables[table_index].game_finished_status = false;
					room.tables[table_index].game_calculation_done = false;

					room.tables[table_index].isfirstTurn = true;
					}
					clearInterval(room.tables[table_index].finalTimer); 
				}
			}, 1000);
			//room.tables[table_index].six_usernames = [];
		}	
	}//emitFinalTimerSix ends 
	
	socket.on("update_player_groups_six", function(data) 
	{
		var player = room.getPlayer(socket.id);
		var player_playing = data.player;
		var round = data.round_id;
		var table_index =0;
		table_index = getTableIndex(room.tables,data.group);
		if (table_index == - 1) {
			console.log("\n update_player_groups_six");
			return;	
		}	
		var is_sorted = data.is_sort;
		var is_grouped = data.is_group;
		var is_initial_group = data.is_initial_group;
		//..console.log("\n  is_sorted "+ is_sorted+" is_grouped "+is_grouped+" is_initial_group "+is_initial_group);
		var player_status;
		
		if(room.tables[table_index].round_id == round)
		{
			if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
			{
				//..console.log("\n pl length "+room.tables[table_index].players.length);
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					player_status = room.tables[table_index].players[i].status;
					//console.log("\n check "+room.tables[table_index].players[i].name+"--"+player_playing);

			  		if(room.tables[table_index].players[i].name == player_playing)
					{
						//console.log("\n in if  ");
						room.tables[table_index].players[i].is_grouped = true; 
						
						 var total_hand_card=0;
				        if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
						
			           
				 
						
			            if(total_hand_card == 0){
							if(is_sorted == true)
							{
								//console.log("\n in sorting  ");
							/* Updated groups after sort to room.tables[table_index].respective player*/
							room.tables[table_index].players[i].card_group1 = data.group1;
							room.tables[table_index].players[i].card_group2 = data.group2;
							room.tables[table_index].players[i].card_group3 = data.group3;
							room.tables[table_index].players[i].card_group4 = data.group4;
							}
						}
						if(is_initial_group == true)
						{
							//console.log("\n in is_initial_group  ");

							//var i=0;
							var n;
							var card_group = data.card_group;
							//console.log(" \n card_group"+JSON.stringify(card_group));
							/* Check empty group and add cards to it*/
							check_player_empty_group(i,data.group,card_group);
							/* remove those cards from player hand cards and get remaining into other group*/
							if( card_group != null) {
								for(var  j = 0; j < card_group.length; j++)
								{
									room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,card_group[j].id);
								}
							}
							/* add rem cards to next empty / last  group */
							add_cards_to_last_group(i,data.group,room.tables[table_index].players[i].hand);
						}
						if(is_grouped == true)
						{
							var card_group = data.card_group;
							var parent_group = data.parent_group;
							var remove_from_group;
							var group_no;
							
							//console.log(" \n card_group"+JSON.stringify(card_group));
							/* Check empty group and add cards to it*/
							group_no = check_player_empty_group(i,data.group,card_group);
							if(group_no != 8)
							{
								/* remove cards from resp. groups */
								//console.log(" \n parent_group 0th pl "+ parent_group.length+" is "+JSON.stringify( parent_group)+" 1st "+ parent_group[0]);
								var i,j;
								for(k = 0; k <= parent_group.length; k++)
								{
								//console.log(k+" in for \n "+parent_group[k]);
									if(parent_group[k] == 1)
									{ remove_from_group = room.tables[table_index].players[i].card_group1;}
									if(parent_group[k] == 2)
									{ remove_from_group = room.tables[table_index].players[i].card_group2;}
									if(parent_group[k] == 3)
									{ remove_from_group = room.tables[table_index].players[i].card_group3;}
									if(parent_group[k] == 4)
									{ remove_from_group = room.tables[table_index].players[i].card_group4;}
									if(parent_group[k] == 5)
									{ remove_from_group = room.tables[table_index].players[i].card_group5;}
									if(parent_group[k] == 6)
									{ remove_from_group = room.tables[table_index].players[i].card_group6;}
									if(parent_group[k] == 7)
									{ remove_from_group = room.tables[table_index].players[i].card_group7;}
									
									if(card_group != null) {
										for(j = 0; j < card_group.length; j++)
										{
											remove_from_group= removeFromSortedHandCards(remove_from_group,card_group[j].id,parent_group[k]);
										}
									}
								}
							}
							else
							{
							 	if(player_status != "disconnected")
							 	{
								    if(room.tables[table_index].players[i].id != ''){
										io.sockets.connected[(room.tables[table_index].players[i].id)].emit("group_limit_six",
										 { user:player_playing,group:room.tables[table_index].id,round_id:round});
									 }
								}
							}
						}
						/* send updated groups to respective player*/
					 	if(player_status != "disconnected")
					 	{
						   if(room.tables[table_index].players[i].id != ''){
								io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six", 
									{ user:player_playing,group:room.tables[table_index].id,round_id:round,
										grp1_cards:room.tables[table_index].players[i].card_group1,
										grp2_cards:room.tables[table_index].players[i].card_group2,
										grp3_cards:room.tables[table_index].players[i].card_group3,
										grp4_cards:room.tables[table_index].players[i].card_group4,
										grp5_cards:room.tables[table_index].players[i].card_group5,
										grp6_cards:room.tables[table_index].players[i].card_group6,
										grp7_cards:room.tables[table_index].players[i].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
							}
						}
					}
				}
			}
		}
	});//update_player_groups_six ends

////add here on single card select if card groups 
	socket.on("add_here_six", function(data) 
	{
		var player = room.getPlayer(socket.id);
		var player_playing = data.player;
		var round = data.round_id;
		var table_index =0;
		table_index = getTableIndex(room.tables,data.group);
		if (table_index == - 1) {
			console.log("\n add_here_six");
			return;	
		}	
		var group_from_remove = data.remove_from_group;
		var group_to_add = data.add_to_group;
		var card_to_remove = data.selected_card;
		var selected_card_src = data.selected_card_src;
		var player_status;
		
		////check here whether sorting or grouping done for groups 
		//..console.log("\n GROUP FROM REMOVE "+group_from_remove+" ADD TO GROUP "+group_to_add+" CARD IS "+JSON.stringify(selected_card_src));
		var add_to_group,remove_from_group;
					
		if(room.tables[table_index].round_id == round)
		{
			if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
			{
			  	for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					player_status = room.tables[table_index].players[i].status;
					if(room.tables[table_index].players[i].name == player_playing)
					{
						////define group from remove card
						if(group_from_remove == 1)
						{ remove_from_group = room.tables[table_index].players[i].card_group1;}
						if(group_from_remove == 2)
						{ remove_from_group = room.tables[table_index].players[i].card_group2;}
						if(group_from_remove == 3)
						{ remove_from_group = room.tables[table_index].players[i].card_group3;}
						if(group_from_remove == 4)
						{ remove_from_group = room.tables[table_index].players[i].card_group4;} 
						if(group_from_remove == 5)
						{ remove_from_group = room.tables[table_index].players[i].card_group5;} 
						if(group_from_remove == 6)
						{ remove_from_group = room.tables[table_index].players[i].card_group6;} 
						if(group_from_remove == 7)
						{ remove_from_group = room.tables[table_index].players[i].card_group7;} 
				
						////define group to which add card
						if(group_to_add == 1)
						{ add_to_group = room.tables[table_index].players[i].card_group1;}
						if(group_to_add == 2)
						{ add_to_group = room.tables[table_index].players[i].card_group2;}
						if(group_to_add == 3)
						{ add_to_group = room.tables[table_index].players[i].card_group3;}
						if(group_to_add == 4)
						{ add_to_group = room.tables[table_index].players[i].card_group4;} 
						if(group_to_add == 5)
						{ add_to_group = room.tables[table_index].players[i].card_group5;} 
						if(group_to_add == 6)
						{ add_to_group = room.tables[table_index].players[i].card_group6;} 
						if(group_to_add == 7)
						{ add_to_group = room.tables[table_index].players[i].card_group7;} 
				
						//remove from group of image clicked
						//console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						remove_from_group= removeFromSortedHandCards(remove_from_group,card_to_remove,group_from_remove);
						//console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						//add card to selected group
						//console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						add_to_group.push(selected_card_src);
						//console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						if(player_status != "disconnected")
						{
						    if(room.tables[table_index].players[i].id != ''){
							io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
						 	{ 
						 		user:player_playing,group:room.tables[table_index].id,round_id:round,
								 	grp1_cards:room.tables[table_index].players[i].card_group1,
								 	grp2_cards:room.tables[table_index].players[i].card_group2,
								 	grp3_cards:room.tables[table_index].players[i].card_group3,
								 	grp4_cards:room.tables[table_index].players[i].card_group4,
								 	grp5_cards:room.tables[table_index].players[i].card_group5,
								 	grp6_cards:room.tables[table_index].players[i].card_group6,
								 	grp7_cards:room.tables[table_index].players[i].card_group7,
									sidejokername:room.tables[table_index].side_joker_card_name
							});
							}
						}
					}
				}//for ends 
			}
		}
	});//add_here ends 
	
	
	socket.on("add_here_six_drop", function(data) 
	{
		var player = room.getPlayer(socket.id);
		var player_playing = data.player;
		var round = data.round_id;
		var position = data.position;
		var table_index =0;
		table_index = getTableIndex(room.tables,data.group);
		if (table_index == - 1) {
			console.log("\n add_here_six");
			return;	
		}	
		var group_from_remove = data.remove_from_group;
		var group_to_add = data.add_to_group;
		var card_to_remove = data.selected_card;
		var selected_card_src = data.selected_card_src;
		var player_status;
		
		////check here whether sorting or grouping done for groups 
		//..console.log("\n GROUP FROM REMOVE "+group_from_remove+" ADD TO GROUP "+group_to_add+" CARD IS "+JSON.stringify(selected_card_src));
		var add_to_group,remove_from_group;
					
		if(room.tables[table_index].round_id == round)
		{
			if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
			{
			  	for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					player_status = room.tables[table_index].players[i].status;
					if(room.tables[table_index].players[i].name == player_playing)
					{
						////define group from remove card
						if(group_from_remove == 1)
						{ remove_from_group = room.tables[table_index].players[i].card_group1;}
						if(group_from_remove == 2)
						{ remove_from_group = room.tables[table_index].players[i].card_group2;}
						if(group_from_remove == 3)
						{ remove_from_group = room.tables[table_index].players[i].card_group3;}
						if(group_from_remove == 4)
						{ remove_from_group = room.tables[table_index].players[i].card_group4;} 
						if(group_from_remove == 5)
						{ remove_from_group = room.tables[table_index].players[i].card_group5;} 
						if(group_from_remove == 6)
						{ remove_from_group = room.tables[table_index].players[i].card_group6;} 
						if(group_from_remove == 7)
						{ remove_from_group = room.tables[table_index].players[i].card_group7;} 
				
						////define group to which add card
						if(group_to_add == 1)
						{ add_to_group = room.tables[table_index].players[i].card_group1;}
						if(group_to_add == 2)
						{ add_to_group = room.tables[table_index].players[i].card_group2;}
						if(group_to_add == 3)
						{ add_to_group = room.tables[table_index].players[i].card_group3;}
						if(group_to_add == 4)
						{ add_to_group = room.tables[table_index].players[i].card_group4;} 
						if(group_to_add == 5)
						{ add_to_group = room.tables[table_index].players[i].card_group5;} 
						if(group_to_add == 6)
						{ add_to_group = room.tables[table_index].players[i].card_group6;} 
						if(group_to_add == 7)
						{ add_to_group = room.tables[table_index].players[i].card_group7;} 
				
						//remove from group of image clicked
						//console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						remove_from_group= removeFromSortedHandCards(remove_from_group,card_to_remove,group_from_remove);
						//console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						//add card to selected group
						//console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						//add_to_group.push(selected_card_src);
						add_to_group.splice(position, 0, selected_card_src);
						//console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						if(player_status != "disconnected")
						{
						    if(room.tables[table_index].players[i].id != ''){
							io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
						 	{ 
						 		user:player_playing,group:room.tables[table_index].id,round_id:round,
								 	grp1_cards:room.tables[table_index].players[i].card_group1,
								 	grp2_cards:room.tables[table_index].players[i].card_group2,
								 	grp3_cards:room.tables[table_index].players[i].card_group3,
								 	grp4_cards:room.tables[table_index].players[i].card_group4,
								 	grp5_cards:room.tables[table_index].players[i].card_group5,
								 	grp6_cards:room.tables[table_index].players[i].card_group6,
								 	grp7_cards:room.tables[table_index].players[i].card_group7,
									sidejokername:room.tables[table_index].side_joker_card_name
							});
							}
						}
					}
				}//for ends 
			}
		}
	});//add_here ends 


	////check open_close_selected_count and allow to pick open/close card 
	socket.on("check_open_closed_pick_count_six", function(data)
	{	
		//..console.log("\n "+data.card+" card selected by player "+data.user+" on table "+data.group+" for round id "+data.round_id);
		var table_index =0;
		var user = data.user;
		var group = data.group;
		var player = room.getPlayer(socket.id);
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n check_open_closed_pick_count_six");
			return;	
		}	
		var temp_open_array  = [];
		var card_type = data.card;
		var card_taken = false;
		var round_id = data.round_id;
		var obj;
		var is_sorted = data.is_sort;
		var is_grouped = data.is_group;
		var is_initial_grouped = data.is_initial_group;
		var player_status,all_player_status;
		var is_joker = false;
		var next_key = 13;
		var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card <= 13){
			
			if(room.tables[table_index].players[selected_user].is_turn == true){
			if(card_type=='open')
			{
			   
				is_joker = checkIfJokerCard(room.tables[table_index].joker_cards,data.card_data[0].id);
				console.log("\n is selected card is joker--> "+is_joker + "  firstTurn: " + room.tables[table_index].isfirstTurn);
				if( room.tables[table_index].isfirstTurn ) 
					is_joker = false;
				obj = data.card_data.reduce(function(acc, cur, i) 
				{
					acc[i] = cur;
					return acc;
				}); 
				
			}
			if(card_type=='close')
			{
					/*** When closed card array get empty ***/
					//1. add last card of open array to temp open array
					//2. remove last card from open 
					//3. add all rest cards from open to close array 
					//4. clear open array and add temp card to open array
					//5. shuffle new array before use 
					
				if(room.tables[table_index].closed_cards_arr.length==0)
				{
					//..console.log("\n CLOSED EMPTY open =="+JSON.stringify(room.tables[table_index].open_cards));
						//1
						//..console.log("\n temp open array when closed get empty before "+JSON.stringify(temp_open_array));
						temp_open_array.push(room.tables[table_index].open_cards[(room.tables[table_index].open_cards.length)-1]);
						//..console.log("\n temp open array when closed get empty after "+JSON.stringify(temp_open_array));
						//2
						room.tables[table_index].open_cards = removeOpenCard(room.tables[table_index].open_cards,temp_open_array[0].id);
						//3
						room.tables[table_index].closed_cards_arr.push.apply(room.tables[table_index].closed_cards_arr,room.tables[table_index].open_cards);
						//4
						room.tables[table_index].open_cards = [];
						room.tables[table_index].open_cards.push.apply(room.tables[table_index].open_cards,temp_open_array);
						//5
						room.tables[table_index].closed_cards_arr = shuffleClosedCards(room.tables[table_index].closed_cards_arr);
				}
				if(room.tables[table_index].closed_cards_arr.length>0)
				{
					obj = room.tables[table_index].closed_cards_arr[0];
				}
			}	
				
			//room.tables[table_index].temp_open_object = obj;	
			//..console.log("\n \n obj value"+JSON.stringify(obj));
				
			if(room.tables[table_index].round_id == round_id)
			{
			  if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
			{
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				  {
					player_status = room.tables[table_index].players[i].status;
					if(room.tables[table_index].players[i].name == user)
					  { 
						if((room.tables[table_index].players[i].open_close_selected_count == 0))
						  {
							if(is_joker !=true)
							 {
								
								
								if(is_grouped == true || is_initial_grouped == true)
								{
									//console.log("\n SORTING Before open/close selected Player "+room.tables[table_index].players[0].name+" GROUP7 cards: "+room.tables[table_index].players[0].card_group7.length+" are "+JSON.stringify(room.tables[table_index].players[0].card_group7));
										
										var pushstatus=0;
											if(room.tables[table_index].players[i].card_group7){
												if(room.tables[table_index].players[i].card_group7.length > 0){
													room.tables[table_index].players[i].card_group7.push(obj);
													pushstatus=1;
												}
											}
											if(pushstatus == 0){
												if(room.tables[table_index].players[i].card_group6){
													if(room.tables[table_index].players[i].card_group6.length > 0){
														room.tables[table_index].players[i].card_group6.push(obj);
														pushstatus=1;
													}
											    }
											}
											if(pushstatus == 0){
												if(room.tables[table_index].players[i].card_group5){
													if(room.tables[table_index].players[i].card_group5.length > 0){
														room.tables[table_index].players[i].card_group5.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[i].card_group4){
													if(room.tables[table_index].players[i].card_group4.length > 0){
														room.tables[table_index].players[i].card_group4.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[i].card_group3){
													if(room.tables[table_index].players[i].card_group3.length > 0){
														room.tables[table_index].players[i].card_group3.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[i].card_group2){
													if(room.tables[table_index].players[i].card_group2.length > 0){
														room.tables[table_index].players[i].card_group2.push(obj);
														pushstatus=1;
													}
											    }
											}
											
											
											if(pushstatus == 0){
												if(room.tables[table_index].players[i].card_group1){
													if(room.tables[table_index].players[i].card_group1.length > 0){
														room.tables[table_index].players[i].card_group1.push(obj);
														pushstatus=1;
													}
											    }
											}
											
										
									//console.log("\n Before open/close selected Player "+room.tables[table_index].players[0].name+" group7 cards: "+room.tables[table_index].players[0].card_group7.length+" are "+JSON.stringify(room.tables[table_index].players[0].card_group7));
								}else{
									if(is_sorted == false && is_grouped == false && is_initial_grouped == false)
									{
										//console.log("\n Before open/close selected Player "+room.tables[table_index].players[0].name+" hand cards: "+room.tables[table_index].players[0].hand.length+" are "+JSON.stringify(room.tables[table_index].players[0].hand));
											room.tables[table_index].players[i].hand.push(obj);
										//console.log("\n After used open/close card Player "+room.tables[table_index].players[0].name+" hand cards : "+room.tables[table_index].players[0].hand.length+" are "+JSON.stringify(room.tables[table_index].players[0].hand));
									}else{
										
										if(is_sorted == true)
										{
											//console.log("\n SORTING Before open/close selected Player "+room.tables[table_index].players[0].name+" GROUP4 cards: "+room.tables[table_index].players[0].card_group4.length+" are "+JSON.stringify(room.tables[table_index].players[0].card_group4));
												room.tables[table_index].players[i].card_group4.push(obj);
											//console.log("\n Before open/close selected Player "+room.tables[table_index].players[0].name+" group4 cards: "+room.tables[table_index].players[0].card_group4.length+" are "+JSON.stringify(room.tables[table_index].players[0].card_group4));
										}
									}										
								}
								if(card_type=='open')
								{
									//console.log("\n Before Use Open Card, array "+JSON.stringify(room.tables[table_index].open_cards));
									room.tables[table_index].open_cards = removeOpenCard(room.tables[table_index].open_cards,data.card_data[0].id);
									room.tables[table_index].open_card_obj_arr = [];
									
									for (var j = 0; j < room.tables[table_index].players.length; j++)
									{
									   if(room.tables[table_index].players[j].id != ''){
											all_player_status = room.tables[table_index].players[j].status;

											 if(all_player_status != "disconnected")
											{
												io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_close_click_count_six",
												 { 
													user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,
													open_arr:room.tables[table_index].open_cards,card:'open',check:true,
													hand_cards:room.tables[table_index].players[j].hand,round_id:round_id,sidejokername:room.tables[table_index].side_joker_card_name
												 });
											}
										}
									}

									//console.log("\n After Used Open Card, array "+JSON.stringify(room.tables[table_index].open_cards));
									// if(oth_player_status != "disconnected")
									// {
									// 	io.sockets.connected[(room.tables[table_index].players[i].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,open_arr:room.tables[table_index].open_cards,card:'open',check:true,hand_cards:room.tables[table_index].players[0].hand,round_id:round_id});
									// }
									////after sort send card groups 
									if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
									{
									   if(room.tables[table_index].players[i].id != ''){
										
											if(player_status != "disconnected")
											{
												   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six", { 
													user:user,group:room.tables[table_index].id,round_id:round_id,
													grp1_cards:room.tables[table_index].players[i].card_group1,
													grp2_cards:room.tables[table_index].players[i].card_group2,
													grp3_cards:room.tables[table_index].players[i].card_group3,
													grp4_cards:room.tables[table_index].players[i].card_group4,
													grp5_cards:room.tables[table_index].players[i].card_group5,
													grp6_cards:room.tables[table_index].players[i].card_group6,
													grp7_cards:room.tables[table_index].players[i].card_group7,sidejokername:room.tables[table_index].side_joker_card_name});
											}
										}
									} 
									// if(first_player_status != "disconnected")
									// {
									// 	io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,open_arr:room.tables[table_index].open_cards,card:'open',check:false,hand_cards:room.tables[table_index].players[1].hand,round_id:round_id});
									// }
								}//if-open-card
								if(card_type=='close')
								{
									//console.log("\n Before Use Close Card ,array "+room.tables[table_index].closed_cards_arr.length+"==="+JSON.stringify(room.tables[table_index].closed_cards_arr));
									if(room.tables[table_index].closed_cards_arr.length > 0)
									{
										room.tables[table_index].closed_cards_arr = removeCloseCard(room.tables[table_index].closed_cards_arr,obj.id);
									}
									if(room.tables[table_index].closed_cards_arr.length > 0)
									{
										room.tables[table_index].closed_cards_arr = shuffleClosedCards(room.tables[table_index].closed_cards_arr);
									}
									//console.log("\n After Used Close Card ,array "+room.tables[table_index].closed_cards_arr.length+"==="+JSON.stringify(room.tables[table_index].closed_cards_arr));
									for (var j = 0; j < room.tables[table_index].players.length; j++)
									{
									   if(room.tables[table_index].players[j].id != ''){
											all_player_status = room.tables[table_index].players[j].status;

											 if(all_player_status != "disconnected")
											{
												io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_close_click_count_six",
												 { 
													user:user,group:group,card:data.card,card_data:obj,
													path:obj.card_path,pick_count:0,open_arr:room.tables[table_index].closed_cards_arr,
													card:'close',check:true,hand_cards:room.tables[table_index].players[j].hand,round_id:round_id,
													sidejokername:room.tables[table_index].side_joker_card_name
												 });
											}
										}
									}
									// if(oth_player_status != "disconnected")
									// {
									// 	io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:obj,path:obj.card_path,pick_count:0,open_arr:room.tables[table_index].closed_cards_arr,card:'close',check:true,hand_cards:room.tables[table_index].players[0].hand,round_id:round_id});
									// }
									////after sort send card groups 
									if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
									{
									   if(room.tables[table_index].players[i].id != ''){
											if(player_status != "disconnected")
											{
											   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six", 
												{ user:user,group:room.tables[table_index].id,round_id:round_id,
													grp1_cards:room.tables[table_index].players[i].card_group1,
													grp2_cards:room.tables[table_index].players[i].card_group2,
													grp3_cards:room.tables[table_index].players[i].card_group3,
													grp4_cards:room.tables[table_index].players[i].card_group4,
													grp5_cards:room.tables[table_index].players[i].card_group5,
													grp6_cards:room.tables[table_index].players[i].card_group6,
													grp7_cards:room.tables[table_index].players[i].card_group7,
													sidejokername:room.tables[table_index].side_joker_card_name});
											}
										}
									}
									// if(first_player_status != "disconnected")
									// {
									// 	io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:obj,path:obj.card_path,pick_count:0
									// 		,open_arr:room.tables[table_index].closed_cards_arr,card:'close',check:false,hand_cards:room.tables[table_index].players[1].hand,round_id:round_id});
									// }
								}//if-close-card
							  room.tables[table_index].players[i].open_close_selected_count = 1;
							  room.tables[table_index].temp_open_object = obj;
							}else{
								if(room.tables[table_index].players[i].id != ''){
								   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("pick_close_card_six", {user:user,group:group,round_id:round_id});
								}
							   }
						}////pl-0-count ends
						 else
						  {
							 if(room.tables[table_index].players[i].id != ''){
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("disallow_pick_card_six", {user:user,group:group,round_id:round_id});
							}
						  }
					  }//pl-0 if ends
				  }//for ends 
			  }//pl-6-condition
			}//round-id ends 
			else
			{ 
				console.log("Table with specified round id not exist."); 
			}
			}else{
			if(room.tables[table_index].players[selected_user].id != ''){
							   io.sockets.connected[(room.tables[table_index].players[selected_user].id)].emit("disallow_pick_card_six", {user:user,group:group,round_id:round_id});
			}
		   }
		}else{
			if(room.tables[table_index].players[selected_user].id != ''){
							   io.sockets.connected[(room.tables[table_index].players[selected_user].id)].emit("disallow_pick_card_six", {user:user,group:group,round_id:round_id});
			}
		}
		
	});			
	
	socket.on("discard_fired_six", function(data)
	{	
		//..console.log("discard event fired by Player "+data.discarded_user+" on table "+data.group+" for round id "+data.round_id);
		var user_whos_discarded = data.discarded_user;
		var player = room.getPlayer(socket.id);
		var group = data.group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n discard_fired_six");
			return;	
		}		
		var round_id = data.round_id;
		
		if(room.tables[table_index].round_id == round_id)
		{
			if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
			{
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					if(room.tables[table_index].players[i].name == user_whos_discarded)
					{
						room.tables[table_index].players[i].turnFinished = true;
					}
				}
			}////table-2-players-condition
		}
	});//discard_fired ends 

	//// show discarded card to open card ///
	socket.on("show_open_card_six", function(data) 
	{	
		//..console.log("After discard display open card to Player "+data.user+" on table "+data.group+" for round id "+data.round_id);
	  if(data.user){
		var user_who_discarded = data.user;
	
		var group = data.group;
		var player = room.getPlayer(socket.id);
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n show_open_card_six");
			return;	
		}			
		var open_card_path = data.open_card_src;
		var open_card_id = data.open_card_id;
		var discareded_return_card = data.discard_card_data;
		var discareded_open_card = data.discarded_open_data;
		var is_sorted = data.is_sort;
		var is_grouped = data.is_group;
		var group_from_discarded = data.group_from_discarded;
		var remove_from_group;
		var discard_data_temp;
		var is_initial_grouped = data.is_initial_group;
		var round_id = data.round_id;
		var player_status,all_player_status;
			
		
		var check1 = data.check;
		
		var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
			
			 
		console.log("total_hand_card "+total_hand_card);
					
		if(total_hand_card > 13){
			
		console.log("total_hand_card2 "+total_hand_card);
		
		if(room.tables[table_index].round_id == round_id)
		{
		  if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
			{
			  for (var i = 0; i < room.tables[table_index].players.length; i++)
			  {
				player_status = room.tables[table_index].players[i].status;
			  
			  	if(room.tables[table_index].players[i].name == user_who_discarded)
				{
				  if(is_sorted == false && is_grouped == false && is_initial_grouped == false)
					{
						//console.log("Before discard/return by Player "+room.tables[table_index].players[0].name+" hand cards: "+room.tables[table_index].players[0].hand.length+" are "+JSON.stringify(room.tables[table_index].players[0].hand));
						discard_data_temp = getDiscardFromHandCards(room.tables[table_index].players[i].hand,discareded_return_card);
						
						room.tables[table_index].open_card_obj_arr = [];
						room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
						room.tables[table_index].open_card_status = "discard";
						 
						//console.log("Before return Open Card array "+JSON.stringify(room.tables[table_index].open_cards));
							room.tables[table_index].open_cards.push(discard_data_temp);
						//console.log("After return/discard Open Card array "+JSON.stringify(room.tables[table_index].open_cards)); 
			
						room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,discareded_return_card);
						
						//console.log("After discard/return by Player "+room.tables[table_index].players[0].name+" hand cards : "+room.tables[table_index].players[0].hand.length+" are "+JSON.stringify(room.tables[table_index].players[0].hand));
					}
 					if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
					{
						//if sorted but no discard from any group remove from last group - return as turn end
						if(group_from_discarded == 0)
						{ remove_from_group = room.tables[table_index].players[i].card_group4;}
						if(group_from_discarded == 1)
						{ remove_from_group = room.tables[table_index].players[i].card_group1;}
						if(group_from_discarded == 2)
						{ remove_from_group = room.tables[table_index].players[i].card_group2;}
						if(group_from_discarded == 3)
						{ remove_from_group = room.tables[table_index].players[i].card_group3;}
						if(group_from_discarded == 4)
						{ remove_from_group = room.tables[table_index].players[i].card_group4;}
						if(group_from_discarded == 5)
						{ remove_from_group = room.tables[table_index].players[i].card_group5;}
						if(group_from_discarded == 6)
						{ remove_from_group = room.tables[table_index].players[i].card_group6;}
						if(group_from_discarded == 7)
						{ remove_from_group = room.tables[table_index].players[i].card_group7;}
						
						//console.log("\n SORTING Before discard/return by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						
						discard_data_temp = getDiscardFromSortGroupCards(remove_from_group,discareded_return_card,group_from_discarded);
						
						room.tables[table_index].open_card_obj_arr = [];
						room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
						room.tables[table_index].open_card_status = "discard";
						
						//console.log("Before return Open Card array "+JSON.stringify(room.tables[table_index].open_cards));
							room.tables[table_index].open_cards.push(discard_data_temp);
						//console.log("After return/discard Open Card array "+JSON.stringify(room.tables[table_index].open_cards)); 
						
						remove_from_group= removeFromSortedHandCards(remove_from_group,discareded_return_card,group_from_discarded);
						
						//console.log("\n SORTING AFTER discard/return by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					}
					//show open card  
					// if(player_status != "disconnected")
					// {
					// 	io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_card", { path:open_card_path,check:check1,id:open_card_id,discareded_open_card:discard_data_temp,group:group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards});	
					// }
					for (var j = 0; j < room.tables[table_index].players.length; j++)
		      		{
					   if(room.tables[table_index].players[j].id != ''){
							all_player_status = room.tables[table_index].players[j].status;

							if(all_player_status != "disconnected")
							{
							
								io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_card_six",
								{ 
									path:open_card_path,check:check1,id:open_card_id,discareded_open_card:discard_data_temp,
									group:group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards
								});	
							}
						}
					}
					room.tables[table_index].players[i].open_close_selected_count = 0;
					if(is_sorted == false && is_grouped == false && is_initial_grouped == false)
					{
					   if(room.tables[table_index].players[i].id != ''){
							//send updated hand cards 
							if(player_status != "disconnected")
							{
								io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_hand_cards_six", 
								{ 
									user:user_who_discarded,group:group,round_id:data.round_id,
									hand_cards:room.tables[table_index].players[i].hand,sidejokername:room.tables[table_index].side_joker_card_name
								});	
							}
						}
					}
					 if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
					{
					   if(room.tables[table_index].players[i].id != ''){
							if(player_status != "disconnected")
							{
								io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six", 
									{ 
										user:user_who_discarded,group:room.tables[table_index].id,round_id:data.round_id,
										grp1_cards:room.tables[table_index].players[i].card_group1,
										grp2_cards:room.tables[table_index].players[i].card_group2,
										grp3_cards:room.tables[table_index].players[i].card_group3,
										grp4_cards:room.tables[table_index].players[i].card_group4,
										grp5_cards:room.tables[table_index].players[i].card_group5,
										grp6_cards:room.tables[table_index].players[i].card_group6,
										grp7_cards:room.tables[table_index].players[i].card_group7,
										sidejokername:room.tables[table_index].side_joker_card_name
									});
							}
						}
					} 
				}
			  }//for ends
			}
		  }	
		}
	  }
	});//show-open-card ends 

	//// show  selected card to finish  card ///
	socket.on("show_finish_card_six", function(data)
	{	
		var player = room.getPlayer(socket.id);
		if(player){
				var player_playing = data.player;
				var group = data.group;
				var table_index =0;
				table_index = getTableIndex(room.tables,group);
				if (table_index == - 1) {
					console.log("\n show_finish_card_six");
					return;	
				}			
				var finished_card = data.finish_card_obj;
				room.tables[table_index].finish_card_object = finished_card;
				var finished_card_id = data.finish_card_id;
				var round = data.round_id;
				var finish_card_path = finished_card.card_path;
				var is_sorted = data.is_sort;
				var is_grouped = data.is_group;
				var is_initial_grouped = data.is_initial_group;
				var group_from_finished = data.group_from_finished;
				var is_finished = data.is_finished;
				var remove_from_group;
				var player_status,all_player_status;
				
				// console.log("\n finish OBJ ==="+JSON.stringify(finished_card));
				// console.log("\n __________________ finish OBJ ==="+JSON.stringify(room.tables[table_index].finish_card_object)+"--is finished --->"+is_finished);
				// console.log("\n **** FINISH IS SORT "+is_sorted+" is grp of grp "+is_grouped+" is intial grp "+is_initial_grouped);
				// console.log("\n finish FROM GRP "+data.group_from_finished+"==="+JSON.stringify(finished_card)+" is_finished "+is_finished);
				var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.player)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card > 13){
					
				 if(room.tables[table_index].round_id == round)
				 {
				  if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
				  {
					for (var i = 0; i < room.tables[table_index].players.length; i++) 
					{
						player_status = room.tables[table_index].players[i].status;

						if(room.tables[table_index].players[i].name == player_playing)
						{
							room.tables[table_index].players[i].gameFinished = true;
							 //..console.log("\n Player Name "+room.tables[table_index].players[i].name+" is finished "+room.tables[table_index].players[i].gameFinished);
							//// Remove finish card from hand cards//////
							/* 1. Initial if no sort / group */
							 if(is_sorted == false && is_grouped == false && is_initial_grouped == false)
							{
								//..console.log("Before finish by Player "+room.tables[table_index].players[i].name+" hand cards: "+room.tables[table_index].players[i].hand.length+" are "+JSON.stringify(room.tables[table_index].players[i].hand));
						
									room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,finished_card_id);
								
								//..console.log("After Finish by Player "+room.tables[table_index].players[i].name+" hand cards : "+room.tables[table_index].players[i].hand.length+" are "+JSON.stringify(room.tables[table_index].players[i].hand));
							}
							if(is_sorted == false && is_grouped == false && is_initial_grouped == false)
							{
							   if(room.tables[table_index].players[i].id != ''){
									//send updated hand cards 
									if(room.tables[table_index].players[i].status != "disconnected")
									{
										io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_hand_cards_six", 
										{ 
											user:player_playing,group:group,round_id:round,hand_cards:room.tables[table_index].players[i].hand,sidejokername:room.tables[table_index].side_joker_card_name
										});	
									}
								}
							}
						
						/* 2. If sort / group */
						if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
							 {
								if(group_from_finished == 1)
								{ remove_from_group = room.tables[table_index].players[i].card_group1;}
								if(group_from_finished == 2)
								{ remove_from_group = room.tables[table_index].players[i].card_group2;}
								if(group_from_finished == 3)
								{ remove_from_group = room.tables[table_index].players[i].card_group3;}
								if(group_from_finished == 4)
								{ remove_from_group = room.tables[table_index].players[i].card_group4;}
								if(group_from_finished == 5)
								{ remove_from_group = room.tables[table_index].players[i].card_group5;}
								if(group_from_finished == 6)
								{ remove_from_group = room.tables[table_index].players[i].card_group6;}
								if(group_from_finished == 7)
								{ remove_from_group = room.tables[table_index].players[i].card_group7;}
								
								//..console.log("\n SORTING/GROUP Before finish by Player "+room.tables[table_index].players[i].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
								
								remove_from_group= removeFromSortedHandCards(remove_from_group,finished_card_id,group_from_finished);
								
								//..console.log("\n SORTING AFTER finish by Player "+room.tables[table_index].players[i].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
							  }
							  if(is_sorted == true || is_grouped == true || is_initial_grouped == true)
							  {
							     if(room.tables[table_index].players[i].id != ''){
										if(room.tables[table_index].players[i].status != "disconnected")
										{
											io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
											 { 
												user:player_playing,group:group,round_id:round,
												grp1_cards:room.tables[table_index].players[i].card_group1,
												grp2_cards:room.tables[table_index].players[i].card_group2,
												grp3_cards:room.tables[table_index].players[i].card_group3,
												grp4_cards:room.tables[table_index].players[i].card_group4,
												grp5_cards:room.tables[table_index].players[i].card_group5,
												grp6_cards:room.tables[table_index].players[i].card_group6,
												grp7_cards:room.tables[table_index].players[i].card_group7,
												sidejokername:room.tables[table_index].side_joker_card_name
											 });
										}
										
									}	
							  } 
							  
						//// emit finish card to both players 
						for (var j = 0; j < room.tables[table_index].players.length; j++)
						{
						    if(room.tables[table_index].players[j].id != ''){
								all_player_status = room.tables[table_index].players[j].status;
								if(all_player_status != "disconnected")
								{
									io.sockets.connected[(room.tables[table_index].players[j].id)].emit("finish_card_six",
									{ 
										user:room.tables[table_index].players[j].name,group:group,round_id:round,path:finish_card_path
									});	
								}
							}
						}		
					}
				   }//for ends 
				  }
				 }
		    }
		}
	});//show_finish_card_six ends 

	function drop_game_six_func(dropped_player, group, round_id, is_sorted, is_grouped, is_initial_grouped) {
		//var dropped_player = data.user_who_dropped_game;
			
		console.log("\n ***** GAME DROPPED by player "+dropped_player);
				
		//var group = data.group;
		//var round_id = data.round_id;
		var player = room.getPlayer(socket.id);
		if(dropped_player){
		    if(player){
					var table_index =0;
					table_index = getTableIndex(room.tables,group);
					if (table_index == - 1) {
						console.log("\n drop_game_six");
						return;	
					}
					
					var dt = KolkataTime();		
					var table_game = room.tables[table_index].table_game;
					//var player_amount = data.amount;
					var group1 = [],group2 = [],group3 = [],group4 = [],group5 = [],group6 = [],group7 = []; 
					//var is_sorted = data.is_sort;
					//var is_grouped = data.is_group;
					//var is_initial_grouped = data.is_initial_group;
					var won_player;
					var won_player_grouped = false;
					var won_player_index = 0;
					var dropped_player_grouped = false;
					var dropped_pl_score =0, opp_pl_score =0;
					var dropped_pl_won_amount =0, opp_pl_won_amount =0;
					var temp_score = 0;
					var score =0;
					var player_status,all_player_status;
					var player_grouped = false;
					var player_name_array = [];
					var player_group_status_array = [];
					var player_final_card_groups_array = [];
					var player_card_groups_array = [];
					var player_score_array = [];
					var player_won_amount_array = [];
					var is_player_grouped_temp = false;
					var winner_won_amount = 0;
					var company_commision_amount=0;
					var table_player_capacity = 0;
					table_player_capacity = room.tables[table_index].playerCapacity;
					//..console.log("\n dropped user "+dropped_player+" did sorting "+is_sorted+" initial grouping "+is_initial_grouped+" grouping "+is_grouped);
						
					if(room.tables[table_index].round_id == round_id)
					{
						if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
						{
							for (var i = 0; i < room.tables[table_index].players.length; i++)
							{
								player_status = room.tables[table_index].players[i].status;
								if(room.tables[table_index].players[i].name == dropped_player)
								{
									//..console.log("\n game dropped  by "+dropped_player+" so 1st / 2nd drop - turn count  "+room.tables[table_index].players[i].turn_count);
									room.tables[table_index].players[i].is_dropped_game = true;
									dropped_player_grouped = room.tables[table_index].players[i].is_grouped;
									room.tables[table_index].players[i].game_status = "Lost";
									room.tables[table_index].players[i].game_display_status = "dropped";
									
									
									room.tables[table_index].players[i].turn_count++;

									room.tables[table_index].isfirstTurn = false;
									
										
												
									temp_score= room.tables[table_index].table_min_entry;
									
									room.tables[table_index].players[i].game_score = temp_score;
									room.tables[table_index].players[i].amount_won = getFixedNumber(-(+((temp_score))));
									room.tables[table_index].players[i].amount_won_db = getFixedNumber(+((temp_score)));
									room.tables[table_index].players[i].amount_playing = getFixedNumber(+(room.tables[table_index].players[i].amount_playing-(temp_score)));
									revertBonus(room.tables[table_index].players[i].name, getFixedNumber(temp_score), table_game);
									room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players)-1;
												
										
									if(room.tables[table_index].no_of_live_players ==1)
									{
										//check index of live player and assign to j and end game as did in 2-pl-game
										for (var j = 0; j < room.tables[table_index].players.length; j++)
										{
											if(room.tables[table_index].players[j].game_display_status == "Live")
											{
												room.tables[table_index].players[j].is_dropped_game = true;
												room.tables[table_index].players[j].game_status = "Won";
												won_player = room.tables[table_index].players[j].name;
												won_player_grouped = room.tables[table_index].players[j].is_grouped;
												won_player_index = j;
											}
										}
										
										
										room.tables[table_index].players[won_player_index].papplu_card_total=0;
										console.log("\n\n Papplu  ========DAtaaaaaaa=== Before====="+room.tables[table_index].players[won_player_index].papplu_card_total+"=========== -->\n "); 
										declared_groups_array_papplu =[];
										var grpcount=get_player_group_count_papplu(won_player_index,group);
										
									if(grpcount > 0){	
										for(var n=0; n<declared_groups_array_papplu.length; n++)
										{
											var card_group = [];
											card_group.push.apply(card_group, declared_groups_array_papplu[n]);
											for (var o = 0; o < card_group.length; o++) {
												if(room.tables[table_index].papplu_joker_card == card_group[o].card_path && room.tables[table_index].papplu_joker_card_name == card_group[o].name){
												room.tables[table_index].players[won_player_index].papplu_card_total=room.tables[table_index].players[won_player_index].papplu_card_total+1;
												}

											}
										}
										console.log("\n\n Papplu  ========DAtaaaaaaa====="+room.tables[table_index].players[won_player_index].papplu_card_total+"=========== -->\n "); 
									}else{
								
											for(var c=0;c< room.tables[table_index].players[won_player_index].hand.length;c++){
											if(room.tables[table_index].papplu_joker_card == room.tables[table_index].players[won_player_index].hand[c].card_path && room.tables[table_index].papplu_joker_card_name == room.tables[table_index].players[won_player_index].hand[c].name)
											{
											
												room.tables[table_index].players[won_player_index].papplu_card_total=room.tables[table_index].players[won_player_index].papplu_card_total+1;
											}
										}
									}

										//do calculation of score and display popups
										room.tables[table_index].players[won_player_index].game_score = 0;
										for (var j = 0; j < room.tables[table_index].players.length; j++)
										{
											if(room.tables[table_index].players[j].game_status != 'Won'){
												var temp_score = 0;
												if(room.tables[table_index].players[j].game_display_status == "dropped")
												{
													temp_score = room.tables[table_index].players[j].game_score; 
													//score = score + parseInt(temp_score);
												}else{
													
													if(room.tables[table_index].players[j].player_start_play == true){
											   
														 if(room.tables[table_index].players[won_player_index].papplu_card_total == 2){
														 
															temp_score = room.tables[table_index].table_min_entry*4;
														 
														 }else if(room.tables[table_index].players[won_player_index].papplu_card_total == 1){
														 
															temp_score = room.tables[table_index].table_min_entry*3;
														   
														 }else{
														 
															temp_score = room.tables[table_index].table_min_entry*2;
														  
														 }
													 
													}else{
													 temp_score = room.tables[table_index].table_min_entry;
													}
													score = score + parseInt(temp_score);
													room.tables[table_index].players[j].game_score = temp_score; 
													room.tables[table_index].players[j].amount_won = getFixedNumber(-(+(temp_score)));
													room.tables[table_index].players[j].amount_won_db = getFixedNumber(+(temp_score));
													room.tables[table_index].players[j].amount_playing = getFixedNumber(+((room.tables[table_index].players[j].amount_playing-(temp_score))));

													revertBonus(room.tables[table_index].players[j].name, getFixedNumber(temp_score), table_game);
												}
											}
										}

										console.log("\n winnner "+room.tables[table_index].players[won_player_index].name+" before calculate amount_playing   "+room.tables[table_index].players[won_player_index].amount_playing);
										console.log("\n Score **************++++++++++++++++***********************************************"+score);
										    score =0;
											for (var j = 0; j < room.tables[table_index].players.length; j++)
										    {
												  temp_score =0;
												  temp_score = room.tables[table_index].players[j].game_score; 
												  score = score + parseInt(temp_score);
											}
															
												if(table_game == 'Free Game')
												{
													room.tables[table_index].players[won_player_index].game_score = score;
													room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+((score)));
													room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+((score)));
													room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing+(score))));
													winner_won_amount = room.tables[table_index].players[won_player_index].amount_won;
												}
												if(table_game == 'Cash Game')
												{
													room.tables[table_index].players[won_player_index].game_score = score - (score*company_commision)/100;
													winner_won_amount = score;
													company_commision_amount=(winner_won_amount*company_commision)/100;
													winner_won_amount = winner_won_amount-company_commision_amount;
													room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+((winner_won_amount)));
													room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+((winner_won_amount)));
													room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing+(winner_won_amount))));

													//console.log("\n commision ---------------------->>"+JSON.stringify(room.tables[table_index].six_usernames));
													/********* Inserting commision details to 'company_balance' table ******/
													commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+getPlayerNames(table_index)+"',now())";
													console.log(commision_query);
													con.query(commision_query, function(err1, result){
														
														 if (err1) {
																	console.log(err1);
														} 
													}); 
												}
														
										console.log("\n after  calculate winnner amount_playing   "+room.tables[table_index].players[won_player_index].amount_playing);
										
										
										transaction_id = Math.floor(Math.random() * 100000000000000);
										room.tables[table_index].players_names = [];
										room.tables[table_index].players_amounts = [];
										room.tables[table_index].players_user_id = [];
										room.tables[table_index].players_final_status = [];
										//--------------
										for (var j = 0; j < room.tables[table_index].players.length; j++)
										{
											all_player_status = room.tables[table_index].players[j].status;
											// if(all_player_status != "disconnected")
											{
												/** Players Names**/
												room.tables[table_index].players_names[j] = room.tables[table_index].players[j].name;
												/** Players amount playing (virtual)**/
												room.tables[table_index].players_amounts[j] = room.tables[table_index].players[j].amount_playing;
												/** Players User Id**/
												room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
												/** Players game status**/
												if(room.tables[table_index].players[j].name == won_player)
												{
													room.tables[table_index].players_final_status[j] = "Won";
												}
												else
												{
													room.tables[table_index].players_final_status[j] = "Lost";										
												}
												
												
												var amounttransactiondeposit=room.tables[table_index].players[j].game_score;
												
												console.log("Qry=====================41");
												insert_query3="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[j].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[j].name+"','"+room.tables[table_index].players[j].game_status+"','"+amounttransactiondeposit+"','"+dt+"')";
												console.log(insert_query3);
												con.query(insert_query3, function(err1, result){
													if( err1 ) { console.log("\nGameTransaction SQL Error: " + err1);} 
													else { console.log("\nGameTransaction 15314" + insert_query3); }
												});
											}
										}

										room.tables[table_index].players[won_player_index].game_score = 0;

										console.log("\n VIRTUAL DATA NEEDED WHILE RESTART ");
										console.log("\n player_name_array "+JSON.stringify(room.tables[table_index].players_names));
										console.log("\n player_group_status_array "+JSON.stringify(room.tables[table_index].players_final_status));
										console.log("\n player_user_id_array "+JSON.stringify(room.tables[table_index].players_user_id));
										console.log("\n player_won_amount_array "+JSON.stringify(room.tables[table_index].players_amounts));

										
										
										update_game_details_func(table_index);

										/** Amount Updated after game end of player (if disconnected)**/
										for (var j = 0; j < room.tables[table_index].players.length; j++)
										{
											if(room.tables[table_index].players[j].name != dropped_player)
											{
												all_player_status = room.tables[table_index].players[j].status;

												//console.log("\nANDYANDYANDY1 " + room.tables[table_index].players[j].name + " : " + all_player_status + " : " + room.tables[table_index].players[j].amount_playing);
												if(all_player_status == "disconnected")
												{
													//update_balance_after_declare(room.tables[table_index].players[j].name,group, room.tables[table_index].players[j].amount_playing,false);
													
													// removePlayerFromTable( room.tables[table_index].players[j].name, group );
												}
											}
										}

										for (var j = 0; j < room.tables[table_index].players.length; j++)
										{
										   if(room.tables[table_index].players[j].id){
													all_player_status = room.tables[table_index].players[j].status;
													if(all_player_status != "disconnected")
													{
														// room.tables[table_index].players[j].status = "intable";
														// console.log("status: intable");
														player_name_array = [];
														//player_card_groups_array=[];
														player_final_card_groups_array=[];
														player_score_array=[];
														player_won_amount_array=[];
														player_group_status_array=[];
													  for (var k = 0; k < room.tables[table_index].players.length; k++)
													  {
														player_name_array.push(room.tables[table_index].players[k].name);
														player_grouped = room.tables[table_index].players[k].is_grouped;
														player_group_status_array.push(player_grouped);
														player_card_groups_array=[];
														is_player_grouped_temp = false;
														if(player_grouped ==false)
														{
															is_player_grouped_temp = false;
															player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].hand);
															
														}
														else
														{
															is_player_grouped_temp = true;
															//if(room.tables[table_index].players[k].card_group1.length>0)
															{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1);}
															//if(room.tables[table_index].players[k].card_group2.length>0)
															{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2);}
															//if(room.tables[table_index].players[k].card_group3.length>0)
															{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3);}
															//if(room.tables[table_index].players[k].card_group4.length>0)
															{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4);}
															//if(room.tables[table_index].players[k].card_group5.length>0)
															{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5);}
															//if(room.tables[table_index].players[k].card_group6.length>0)
															{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6);}
															//if(room.tables[table_index].players[k].card_group7.length>0)
															{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7);}
															
															
														}
														player_final_card_groups_array.push(player_card_groups_array);
													
														player_score_array.push(room.tables[table_index].players[k].game_score);
														player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
													  }//inner-for ends 

													  
													  if(room.tables[table_index].players[j].id != ''){
														io.sockets.connected[(room.tables[table_index].players[j].id)].emit("dropped_game_six",
														 { 
															players:player_name_array,declared:2,group:group,winner:won_player,
															group_status:player_group_status_array,players_cards:player_final_card_groups_array,
															players_score:player_score_array,players_amount:player_won_amount_array
														 });
													  }
													}//disconnect
											}
										}//outer-for
										room.tables[table_index].papplu_joker_card = "";
	      room.tables[table_index].papplu_joker_card_name = "";
		  room.tables[table_index].papplu_joker_card_id="";
									room.tables[table_index].game_finished_status = true;
									}//only-1-live-player-so-game-ends
									else
									{
									   if(dropped_player){
											//if(player_status != "disconnected")
											{
												socket.emit('player_dropped_game',dropped_player,group);
												socket.broadcast.emit('player_dropped_game',dropped_player,group);
											}
										}
									}
								}
							}//for
						}	
					}//same-table-round-id	
		    }
		}
	}

	/*****  Dropped Game by Player **********/
	socket.on("drop_game_six", function(data) 
	{	
	   var group = data.group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n declare_game_six");
			return;	
		}		
		console.log("\n Six player Game declared of type "+room.tables[table_index].game_type);
	     var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user_who_dropped_game)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card <= 13){
			
			if(room.tables[table_index].players[selected_user].is_turn == true){
			   if(data.user_who_dropped_game){
				drop_game_six_func(data.user_who_dropped_game, data.group, data.round_id, data.is_sort, data.is_group, data.is_initial_group);
				}
			}
		}
	});//drop_game ends 
	
	
	socket.on("play_btn_click_player", function(data)
	{	
	    if(data.user_who_play_game){
			//..console.log("discard event fired by Player "+data.discarded_user+" on table "+data.group+" for round id "+data.round_id);
			  if(data.user_who_play_game == null || data.user_who_play_game == '' || data.user_who_play_game == 'undefine')	{
				 console.log("\n play_btn_click_player");
				return;
			  }
			var user_whos_discarded = data.user_who_play_game;
			var player = room.getPlayer(socket.id);
			var group = data.group;
			var table_index =0;
			table_index = getTableIndex(room.tables,group);
			if (table_index == - 1) {
				console.log("\n discard_fired_six");
				return;	
			}
			
			var round_id = data.round_id;
			
			if(room.tables[table_index].round_id == round_id)
			{
				if(room.tables[table_index].players.length >=2 && room.tables[table_index].players.length <=6)
				{
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						if(room.tables[table_index].players[i].name == user_whos_discarded)
						{
							room.tables[table_index].players[i].player_start_play = true;
						}
					}
				}////table-2-players-condition
			}
		}
	});
	
	socket.on("play_btn_click_player_two", function(data)
	{	
	
	    if(data.user_who_play_game){
			//..console.log("discard event fired by Player "+data.discarded_user+" on table "+data.group+" for round id "+data.round_id);
			if(data.user_who_play_game == null || data.user_who_play_game == '' || data.user_who_play_game == 'undefine')	{
				 console.log("\n play_btn_click_player");
				return;
			  }
			var user_whos_play = data.user_who_play_game;
			var player = room.getPlayer(socket.id);
			var group = data.group;
			var table_index =0;
			table_index = getTableIndex(room.tables,group);
			if (table_index == - 1) {
				console.log("\n discard_fired_six");
				return;	
			}		
			var round_id = data.round_id;
			
			if(room.tables[table_index].round_id == round_id)
			{
				if(room.tables[table_index].players.length ==2)
				{
					for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						if(room.tables[table_index].players[i].name == user_whos_play)
						{
							room.tables[table_index].players[i].player_start_play = true;
						}
					}
				}////table-2-players-condition
			}
		}
	});
	
	
	socket.on("declare_game_six", function(data) 
	{
	
		var group = data.group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n declare_game_six");
			return;	
		}		
		console.log("\n Six player Game declared of type "+room.tables[table_index].game_type);
	     var total_hand_card=0;	
			var selected_user='';
			for (var i = 0; i < room.tables[table_index].players.length; i++)
			{

				if(room.tables[table_index].players[i].name == data.user)
				{ 
					selected_user=i;
					   if(room.tables[table_index].players[i].card_group1){
					    total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group1.length;
						}
						if(room.tables[table_index].players[i].card_group2){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group2.length;
						}
						if(room.tables[table_index].players[i].card_group3){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group3.length;
						}
						if(room.tables[table_index].players[i].card_group4){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group4.length;
						}
						if(room.tables[table_index].players[i].card_group5){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group5.length;
						}
						if(room.tables[table_index].players[i].card_group6){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group6.length;
						}
						if(room.tables[table_index].players[i].card_group7){
						total_hand_card=total_hand_card+room.tables[table_index].players[i].card_group7.length;
						}
			            if(total_hand_card < 13){
				         total_hand_card=total_hand_card+room.tables[table_index].players[i].hand.length;
						}

				}
			}
		if(total_hand_card <= 13){
			
			if(room.tables[table_index].players[selected_user].is_turn == true){
				 if(data.user){
				   declare_papplu_game_data_six(data.user,data.group,data.round_id,data.pl_amount_taken,data.is_sort,data.is_group,data.is_initial_group,room.tables[table_index].table_point_value,room.tables[table_index].game_type,room.tables[table_index].table_name);
				 }
			}
		}
		
	});//declare_game ends 
	 
	
	function get_remaining_no_of_playing_players(group)
	{
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n get_remaining_no_of_playing_players");
			return;	
		}			
		var status;
		var live_players = 0;
		for (var i = 0; i < room.tables[table_index].players.length; i++)
		{
			status = room.tables[table_index].players[i].game_display_status;			
			if(status == "Live")
			{
				live_players++;
			}
		}
		return live_players;
	}
	
    function declare_papplu_game_data_six(declared_player,group,round_id,pl_amount_taken,is_sort,is_group,is_initial_group,table_point_value,game_type)
	{
	    var player = room.getPlayer(socket.id);
	   if(player){
		var declared_user = declared_player;
		var group = group;
		var table_index =0;
		table_index = getTableIndex(room.tables,group);
		if (table_index == - 1) {
			console.log("\n declare_Papplu_game_data_six");
			return false;	
		}
		
		var dt = KolkataTime();

		var table_game = room.tables[table_index].table_game;
		var round_id = round_id;
		
		var player_amount = pl_amount_taken;
		var group1 = [],group2 = [],group3 = [],group4 = [],group5 = [],group6 = [],group7 = []; 
		var is_sorted = is_sort;
		var is_grouped = is_group;
		var is_initial_grouped = is_initial_group;
		var player_declared;
		var declared_player_grouped = false;
		var other_declared_player_grouped = false;
		var oth_player_status,first_player_status;
		var group_count = 0;
		var is_pure_valid = false;
		var is_sub_valid = false;
		var is_3rd_valid = false;
		var is_pure = 0;
		var is_sub_sequence =0;
		var is_3rd_sequence =0;
		var is_invalid = 0;
		var player_status,all_player_status,player_game_status;
		var won_player;
		var won_player_grouped = false;
		var won_player_index = 0;
		var player_name_array = [];
		var player_group_status_array = [];
		var player_final_card_groups_array = [];
		var player_card_groups_array = [];
		var player_score_array = [];
		var player_won_amount_array = [];
		var is_player_grouped_temp = false;
		var winner_won_amount = 0;
		var company_commision_amount=0;
		var table_player_capacity = 0;
		var retValid = false;
		table_player_capacity = room.tables[table_index].playerCapacity;

		console.log("\n declared user in six-pl-game of type deal rummy "+declared_user+" did sorting "+is_sorted+" initial grouping "+is_initial_grouped+" grouping "+is_grouped);
			
		if(room.tables[table_index].round_id == round_id)
		{
			if(room.tables[table_index].declared==0 && room.tables[table_index].game_declare_status == "Valid")
			{
				room.tables[table_index].declared = 1; 
			}
			if(room.tables[table_index].declared==0)
			{
				console.log("\n ......... one player Declared...........");
			 	for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					player_status = room.tables[table_index].players[i].status;
					if(room.tables[table_index].players[i].name == declared_user)
					{
						room.tables[table_index].players[i].declared = true; 
						/***************** Validate declared Player groups  **********/
						declared_groups_array = [];  
						group_count = get_player_group_count(i,group);
						if(group_count == 0)
						{
							room.tables[table_index].is_declared_valid_sequence = false;
						}//invalid
						else
				  		{
							if(!valid.validateGroupLimit(group_count))
				     		{
					 			//console.log("\n\n declared_groups_array od p1 --> "+JSON.stringify(declared_groups_array)+"--- arr count --"+declared_groups_array.length);
					   			for(var n=0; n<declared_groups_array.length;n++)
					   			{
									is_pure_valid = valid.validatePureSequence(declared_groups_array[n],room.tables[table_index].pure_joker_cards,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards,room.tables[table_index].joker_cards);
									if(!is_pure_valid)
									{
										is_sub_valid = valid.validateSubSequence(declared_groups_array[n],room.tables[table_index].joker_cards,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards);
										if(!is_sub_valid)
										{
											is_3rd_valid = valid.validateSameCardSequence(declared_groups_array[n],room.tables[table_index].joker_cards);
											if(!is_3rd_valid)
											{
												if( !valid.validateAllJoker(declared_groups_array[n],room.tables[table_index].joker_cards) ) {
													is_invalid++;
													declared_groups_array_status[n] = "Invalid";
												} else {
													declared_groups_array_status[n] = "Joker";
												}
											}
											else
											{
												is_3rd_sequence++;
												declared_groups_array_status[n] = "Third";
											}
										}
										else 
										{ 
											is_sub_sequence++; 
											declared_groups_array_status[n] = "Sub";
										}
									}
									else 
									{
										is_pure++;
										declared_groups_array_status[n] = "Pure";
									}
					  			}//for 
					 		}//group-limit
					  		else
					 		{ 
					 			room.tables[table_index].is_declared_valid_sequence = false; 
					 		}
					  		console.log("\n declared_groups_array_status of player "+JSON.stringify(declared_groups_array_status));
					  
						  	if(is_invalid > 0)
						  	{
								room.tables[table_index].is_declared_valid_sequence = false;
						  	}
						  	else
						  	{
						  		if(is_pure >= 2 )
						  		{
									room.tables[table_index].is_declared_valid_sequence = true;
						  		}
						  		else
						  		{
						  			if(is_pure == 1 )
						  			{
									  for(var n=0; n<declared_groups_array_status.length;)
									    {
											if(declared_groups_array_status[n] == "Sub")
											{
												room.tables[table_index].is_declared_valid_sequence = true;
												break;
											}
											else
											{
												if( n == (declared_groups_array_status.length))
												{ break;}
												else { n++; continue; }
											}
										}
									}//if pure 1
								}//else no 2 pure 
						 	}
					  
					 	 	declared_groups_array = [];
					  		declared_groups_array_status = [];
				  	 	}//check-valid-if-all-have-min-3-cards
/////////////////remove later				  	 	
						//room.tables[table_index].is_declared_valid_sequence = true;
				  	 	console.log(" \n is_declared_valid_sequence  "+room.tables[table_index].is_declared_valid_sequence);
				  	 	if(room.tables[table_index].is_declared_valid_sequence == false)
						{
							room.tables[table_index].players[i].is_declared_valid_sequence = false;
							room.tables[table_index].players[i].game_status = "Lost";
							room.tables[table_index].players[i].game_display_status = "wrong_declared";
							/*** If wrong declare then check no of live players and according to set 'declared' value ***/
							room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players)-1;
							if(room.tables[table_index].no_of_live_players ==1)
							{
								room.tables[table_index].declared= 1; 
							}
							else
							{
							   if(declared_user){
									if(player_status != "disconnected")
									{
										socket.emit('player_declared_game',declared_user,group);
										socket.broadcast.emit('player_declared_game',declared_user,group);
										return_open_card_six(i,room.tables[table_index].players[i].id,declared_user,group,
											round_id,room.tables[table_index].players[i].hand,
											room.tables[table_index].temp_open_object,player_status);
									}
								}
							}
						}else
						{
							retValid = true;
							room.tables[table_index].players[i].is_declared_valid_sequence = true;
							room.tables[table_index].players[i].game_status = "Won";
							room.tables[table_index].players[i].game_display_status = "valid_declared";
							won_player = room.tables[table_index].players[i].name;
							won_player_grouped = room.tables[table_index].players[i].is_grouped;
							room.tables[table_index].players[i].game_declared_status = "Valid";
							room.tables[table_index].game_declare_status= "Valid";
							//won_player_index = i;
						}
						if(room.tables[table_index].is_declared_valid_sequence == true)
						{
							room.tables[table_index].declared = 1; 
						}
					}//if-of-declared-player
				}//for-ends
			}//intial-table-declare-0 ends 
			
			if(room.tables[table_index].declared==1)
			{
				console.log("\n DECALRE 1 IN DEAL RUMMY - SIX -PL GAME ");
				var prev_declared_player;
				var declared_pl_score =0, opp_pl_score =0;
				var declared_pl_won_amount =0, opp_pl_won_amount =0;
				var score = 0;
				
				console.log("\n ......... declared_user ("+declared_user+") ...........");
				for (var i = 0; i < room.tables[table_index].players.length; i++)
				{
					player_status = room.tables[table_index].players[i].status;
					if(room.tables[table_index].players[i].name == declared_user)
					{
						room.tables[table_index].players[i].declared = true; 

						if(room.tables[table_index].is_declared_valid_sequence == false)
						{
							 console.log("\n ....==================++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++Enterred in Valid False========================================================....");
							for (var j = 0; j < room.tables[table_index].players.length; j++)
							{
								//console.log("\n ........ player "+room.tables[table_index].players[j].name+" _GAME-status "+room.tables[table_index].players[j].game_display_status);
								if(room.tables[table_index].no_of_live_players ==1)
								{
									if(room.tables[table_index].players[j].game_display_status == "Live")
									{
										room.tables[table_index].players[j].declared = true;
										room.tables[table_index].players[j].game_status = "Won";
										room.tables[table_index].players[j].game_display_status = "winnner";
										won_player = room.tables[table_index].players[j].name;
										won_player_grouped = room.tables[table_index].players[j].is_grouped;
										won_player_index = j;
										room.tables[table_index].game_finished_status = true;
									}else if(room.tables[table_index].players[j].game_display_status == "winnner")
									{
										room.tables[table_index].game_calculation_done = true;
									}
								}
							}
						 if(room.tables[table_index].game_calculation_done == false)
							{	
						        //====Papplu card total find=========================
								
							    room.tables[table_index].players[won_player_index].papplu_card_total=0;
                                console.log("\n\n Papplu  ========DAtaaaaaaa=== Before====="+room.tables[table_index].players[won_player_index].papplu_card_total+"=========== -->\n "); 
								console.log("===================won_player_index===================== "+won_player_index);
								declared_groups_array_papplu = [];  
								var grpcount=get_player_group_count_papplu(won_player_index,group);
								console.log("===================grpcount===================== "+grpcount);
								console.log("===================declared_groups_array_papplu===================== "+JSON.stringify(declared_groups_array_papplu));
								if(grpcount > 0){
									console.log("===================Enter In GrpCouin >  0===================== "+grpcount);
									for(var n=0; n<declared_groups_array_papplu.length; n++)
									{
										var card_group = [];
										card_group.push.apply(card_group, declared_groups_array_papplu[n]);
										console.log("===================card_group Array===================== "+JSON.stringify(card_group));
								
										for (var o = 0; o < card_group.length; o++) {
											console.log("\n =============="+o+"================="+room.tables[table_index].papplu_joker_card+"============================"+card_group[o].card_path+"========= ");
									
											if(room.tables[table_index].papplu_joker_card == card_group[o].card_path && room.tables[table_index].papplu_joker_card_name == card_group[o].name){
												
												room.tables[table_index].players[won_player_index].papplu_card_total=room.tables[table_index].players[won_player_index].papplu_card_total+1;
											
											}

										}
									}
									
								}else{
								console.log("===================Enter In GrpCouin === 0===================== "+grpcount);
										for(var c=0;c< room.tables[table_index].players[won_player_index].hand.length;c++){
											if(room.tables[table_index].papplu_joker_card == room.tables[table_index].players[won_player_index].hand[c].card_path && room.tables[table_index].papplu_joker_card_name == room.tables[table_index].players[won_player_index].hand[c].name)
											{
											
												room.tables[table_index].players[won_player_index].papplu_card_total=room.tables[table_index].players[won_player_index].papplu_card_total+1;
											}
										}
								}
								
								console.log("\n\n Papplu  ========DAtaaaaaaa====="+room.tables[table_index].players[won_player_index].papplu_card_total+"=========== -->\n "); 
								//====Papplu card total find End============================
								
								score =0;
								room.tables[table_index].players[won_player_index].game_score = 0;
								for (var j = 0; j < room.tables[table_index].players.length; j++)
								{
									    var temp_score = 0;
										// if(room.tables[table_index].players[j].game_display_status == "wrong_declared")
										if(room.tables[table_index].players[j].game_display_status != "winnner")
										{
											
											if(room.tables[table_index].players[j].game_display_status == "dropped")
											{
												temp_score=room.tables[table_index].players[j].game_score; 
												score = score + parseInt(temp_score);
											}else{
												  
												   if(room.tables[table_index].players[j].player_start_play == true){
												   
														 if(room.tables[table_index].players[won_player_index].papplu_card_total == 2){
														 
														 temp_score = room.tables[table_index].table_min_entry*4;
														 
														 }else if(room.tables[table_index].players[won_player_index].papplu_card_total == 1){
														 
														   temp_score = room.tables[table_index].table_min_entry*3;
														   
														 }else{
														 
														  temp_score = room.tables[table_index].table_min_entry*2;
														  
														 }
														 
													}else{
													 temp_score = room.tables[table_index].table_min_entry;
													}
													score = score + parseInt(temp_score);
													room.tables[table_index].players[j].game_score = temp_score; 
													room.tables[table_index].players[j].amount_won = getFixedNumber(-(+(temp_score)));
													room.tables[table_index].players[j].amount_won_db = getFixedNumber(+(temp_score));
													room.tables[table_index].players[j].amount_playing = getFixedNumber(+((room.tables[table_index].players[j].amount_playing-(temp_score))));
													revertBonus(room.tables[table_index].players[j].name, getFixedNumber(temp_score), table_game);
											
											}
										}
								}
								console.log("\n -------------- winnner --------------"+won_player);
								console.log("\n winnner "+room.tables[table_index].players[won_player_index].name+" before calculate amount_playing   "+room.tables[table_index].players[won_player_index].amount_playing);

								if(table_game == 'Free Game')
								{
									room.tables[table_index].players[won_player_index].game_score = score;																		
									room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+(score));
									room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+(score));
									room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing+(score))));
									winner_won_amount = room.tables[table_index].players[won_player_index].amount_won;
								}
								if(table_game == 'Cash Game')
								{									
									room.tables[table_index].players[won_player_index].game_score = score - (score*company_commision)/100;
									winner_won_amount = score;
									company_commision_amount=(winner_won_amount*company_commision)/100;
									winner_won_amount = winner_won_amount-company_commision_amount;
									room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+((winner_won_amount)));
									room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+((winner_won_amount)));
									room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing+(winner_won_amount))));

									//console.log("\n commision ---------------------->>"+JSON.stringify(room.tables[table_index].six_usernames));
									/********* Inserting commision details to 'company_balance' table ******/
									commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+(score)+"','"+company_commision_amount+"','"+getPlayerNames(table_index)+"',now())";
									con.query(commision_query, function(err1, result){ 
									if (err1) {
												console.log(err1);
									}
									}); 
								}
								
								
								console.log("\n after  calculate winnner amount_playing   "+room.tables[table_index].players[won_player_index].amount_playing);	
								/** Amount Updated after game end of player (if disconnected)**/
								for (var j = 0; j < room.tables[table_index].players.length; j++)
								{
										if(room.tables[table_index].players[j].name != declared_user)
										{
											all_player_status = room.tables[table_index].players[j].status;
											//console.log("\nANDYANDYANDY7 " + room.tables[table_index].players[j].name + " : " + all_player_status);
											if(all_player_status == "disconnected")
											{
												//update_balance_after_declare(room.tables[table_index].players[j].name,group, room.tables[table_index].players[j].amount_playing,false);
												//removePlayerFromTable( room.tables[table_index].players[j].name, group );
											}
										}
								}//for-db-amount-update
							}//if-false
							transaction_id = Math.floor(Math.random() * 100000000000000);
							room.tables[table_index].players_names = [];
							room.tables[table_index].players_amounts = [];
							room.tables[table_index].players_user_id = [];
							room.tables[table_index].players_final_status = [];
							for (var j = 0; j < room.tables[table_index].players.length; j++)
			      			{
			      				all_player_status = room.tables[table_index].players[j].status;
		      					// if(all_player_status != "disconnected")
							    {
									//room.tables[table_index].players[j].status = "intable";
									//console.log("status: intable");

			      					room.tables[table_index].players_names[j] = room.tables[table_index].players[j].name;
									room.tables[table_index].players_amounts[j] = room.tables[table_index].players[j].amount_playing;
									room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
									if(room.tables[table_index].players[j].name == won_player)
									{
										room.tables[table_index].players_final_status[j] = "Won";
									}
									else
									{
										room.tables[table_index].players_final_status[j] = "Lost";										
									}		
console.log("Qry=====================51");									
									insert_query3="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,`table_name`, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[j].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[j].name+"','"+room.tables[table_index].players[j].game_status+"','"+(room.tables[table_index].players[j].game_score)+"','"+dt+"')";
									console.log(insert_query3);
									con.query(insert_query3, function(err1, result){
										if( err1 ) {console.log("\nGameTransaction SQL Error: " + err1);} 
										else { console.log("\nGameTransaction 18697 " + insert_query3); }
									});						
								}
							}	
							room.tables[table_index].players[won_player_index].game_score = 0;

							if(room.tables[table_index].game_calculation_done == true)
							{	
								update_game_details_func(table_index);

							}//if-false

							if(room.tables[table_index].game_calculation_done == false)
							{
								for (var j = 0; j < room.tables[table_index].players.length; j++)
								{
								    if(room.tables[table_index].players[j].id != ''){
											all_player_status = room.tables[table_index].players[j].status;
											if(all_player_status != "disconnected")
											{
												player_name_array = [];
												player_final_card_groups_array=[];
												player_score_array=[];
												player_won_amount_array=[];
												player_group_status_array=[];
												for (var k = 0; k < room.tables[table_index].players.length; k++)
												{
													player_name_array.push(room.tables[table_index].players[k].name);
													player_grouped = room.tables[table_index].players[k].is_grouped;
													player_group_status_array.push(player_grouped);
													player_card_groups_array=[];
													is_player_grouped_temp = false;
													if(player_grouped ==false)
													{
														is_player_grouped_temp = false;
														player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].hand);
													}
													else
													{
														is_player_grouped_temp = true;
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7);}
													}
													player_final_card_groups_array.push(player_card_groups_array);
													player_score_array.push(room.tables[table_index].players[k].game_score);
													player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
												}//inner-for ends 
												
												io.sockets.connected[(room.tables[table_index].players[j].id)].emit("declared_final_six",
												{ 
													players:player_name_array,declared:2,group:group,winner:won_player,
														group_status:player_group_status_array,players_cards:player_final_card_groups_array,
														players_score:player_score_array,players_amount:player_won_amount_array
												});
											}//disconnect
									}
								}//outer-for
							}
						}else if(room.tables[table_index].is_declared_valid_sequence == true)
						{
							
							
							room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players)-1;
							room.tables[table_index].players[i].game_display_status = "declared";

							for (var j = 0; j < room.tables[table_index].players.length; j++)
							{
								if(room.tables[table_index].players[j].game_declared_status == "Valid")
								{
									
									room.tables[table_index].players[j].declared = true;
									room.tables[table_index].players[j].game_status = "Won";
									won_player = room.tables[table_index].players[j].name;
									won_player_grouped = room.tables[table_index].players[j].is_grouped;
									won_player_index = j;
								}
							}
							
							    //=========Papplu joker find=======================
								    declared_groups_array_papplu = [];  
									var grpcount=get_player_group_count_papplu(won_player_index,group);
									room.tables[table_index].players[won_player_index].papplu_card_total=0;
									if(grpcount > 0){
										for(var n=0; n<declared_groups_array_papplu.length; n++)
										{
											var card_group = [];
											card_group.push.apply(card_group, declared_groups_array_papplu[n]);
											
											for (var o = 0; o < card_group.length; o++) {
												console.log("\n =============="+o+"================="+room.tables[table_index].papplu_joker_card+"============================"+card_group[o].card_path+"========= ");
									
												if(room.tables[table_index].papplu_joker_card == card_group[o].card_path && room.tables[table_index].papplu_joker_card_name == card_group[o].name){
													room.tables[table_index].players[won_player_index].papplu_card_total=room.tables[table_index].players[won_player_index].papplu_card_total+1;
												
												}

											}
										}
									}else{
								
										for(var c=0;c< room.tables[table_index].players[won_player_index].hand.length;c++){
											if(room.tables[table_index].papplu_joker_card == room.tables[table_index].players[won_player_index].hand[c].card_path && room.tables[table_index].papplu_joker_card_name == room.tables[table_index].players[won_player_index].hand[c].name)
											{
											
												room.tables[table_index].players[won_player_index].papplu_card_total=room.tables[table_index].players[won_player_index].papplu_card_total+1;
											}
										}
									}
								//=========Papplu joker findEnd=======================
							   
							for (var j = 0; j < room.tables[table_index].players.length; j++)
							{
								temp_score=0;
								
								if(room.tables[table_index].players[j].name != declared_user)
								{
										
									if(room.tables[table_index].players[j].game_display_status == "dropped")
									{
									   console.log("\n =================================Dropeed User============================"+room.tables[table_index].players[j].name+"========= ");
										temp_score=room.tables[table_index].players[j].game_score; 
										
									}else{
										
											//console.log("\n ---- in if "+room.tables[table_index].players[j].name+" --- decl pl - "+declared_user);
											//room.tables[table_index].players[i].is_declared_valid_sequence = false;
											room.tables[table_index].players[j].game_status = "Lost";
											room.tables[table_index].players[j].game_display_status = "wrong_declared";
											
											        if(room.tables[table_index].players[j].player_start_play == true){
												   
														 if(room.tables[table_index].players[won_player_index].papplu_card_total == 2){
														 
														 temp_score = room.tables[table_index].table_min_entry*4;
														 
														 }else if(room.tables[table_index].players[won_player_index].papplu_card_total == 1){
														 
														   temp_score = room.tables[table_index].table_min_entry*3;
														   
														 }else{
														 
														  temp_score = room.tables[table_index].table_min_entry*2;
														  
														 }
														 
													}else{
													 temp_score = room.tables[table_index].table_min_entry;
													}
											
											console.log("\n USer Temp Score================"+room.tables[table_index].players[j].name+"=============== "+temp_score);	
											
											room.tables[table_index].players[j].game_score = temp_score; 
											room.tables[table_index].players[j].amount_won = getFixedNumber(-(+(temp_score)));
											room.tables[table_index].players[j].amount_won_db = getFixedNumber(+((temp_score)));
											room.tables[table_index].players[j].amount_playing = getFixedNumber(+((room.tables[table_index].players[j].amount_playing-(temp_score))));
											console.log("\n USer Amount Playing======================================================================="+room.tables[table_index].players[j].name+"=============== "+room.tables[table_index].players[j].amount_playing);	
											revertBonus(room.tables[table_index].players[j].name, getFixedNumber(temp_score), table_game);
								    }
								
								
								}
							}

							declared_groups_array = [];
					  		declared_groups_array_status = [];	
					  		//if(room.tables[table_index].no_of_live_players ==0)
								//{
									console.log("\n $$$$$$$$$ WINNNER AMOUNT CALCULATION ");
									console.log("\n winnner "+room.tables[table_index].players[won_player_index].name+" before calculate amount_playing   "+room.tables[table_index].players[won_player_index].amount_playing);
									var temp_amt = 0;
									for (var k = 0; k < room.tables[table_index].players.length; k++)
									{
										score = score + parseInt(room.tables[table_index].players[k].game_score);
									}
									console.log("\n Total Score================"+room.tables[table_index].players[won_player_index].name+"=============== "+score);	
									
									room.tables[table_index].players[won_player_index].game_score = 0;
									
									if(table_game == 'Cash Game')
									{
										winner_won_amount = score;
										temp_amt = winner_won_amount;
										company_commision_amount=(winner_won_amount*company_commision)/100;
										winner_won_amount = winner_won_amount-company_commision_amount;
										room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+((winner_won_amount)));
										room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+((winner_won_amount)));
										room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing+(winner_won_amount))));

										/********* Inserting commision details to 'company_balance' table ******/
										commision_query="INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount, `amount`, `players_name`, `date`) VALUES ('"+room.tables[table_index].id+"','"+room.tables[table_index].round_id+"','"+table_player_capacity+"','"+room.tables[table_index].game_type+"','"+company_commision+"','"+temp_amt+"','"+company_commision_amount+"','"+getPlayerNames(table_index)+"',now())";
										con.query(commision_query, function(err1, result){ 

										        if (err1) {
														console.log(err1);
												} 

										}); 
									}
									if(table_game == 'Free Game')
									{
										winner_won_amount = score;
										room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+((winner_won_amount)));
										room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+((winner_won_amount)));
										room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing+(winner_won_amount))));
									}
									console.log("\n after  calculate winnner amount_won   "+room.tables[table_index].players[won_player_index].amount_won);	
								 	console.log("\n after  calculate winnner amount_playing   "+room.tables[table_index].players[won_player_index].amount_playing);	

									transaction_id = Math.floor(Math.random() * 100000000000000);
								 	room.tables[table_index].players_names = [];
									room.tables[table_index].players_amounts = [];
									room.tables[table_index].players_user_id = [];
									room.tables[table_index].players_final_status = [];
									for (var j = 0; j < room.tables[table_index].players.length; j++)
			      					{
			      						all_player_status = room.tables[table_index].players[j].status;
				      					// if(all_player_status != "disconnected")
									    {
				      						room.tables[table_index].players_names[j] = room.tables[table_index].players[j].name;
											room.tables[table_index].players_amounts[j] = room.tables[table_index].players[j].amount_playing;
											room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
											if(room.tables[table_index].players[j].name == won_player)
											{
												room.tables[table_index].players_final_status[j] = "Won";
											}
											else
											{
												room.tables[table_index].players_final_status[j] = "Lost";
												console.log("Qry=====================53");
												insert_query3="insert into game_transactions(`user_id`,`game_transaction_id`, `game_type`,`chip_type`,`table_id`,`table_name`, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[j].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[j].name+"','"+room.tables[table_index].players[j].game_status+"','"+(room.tables[table_index].players[j].game_score)+"','"+dt+"')";
												console.log(insert_query3);
												con.query(insert_query3, function(err1, result){
													    if( err1 ) {
														console.log("\nGameTransaction SQL Error: " + err1);
														}else {
															//console.log("\nGameTransaction 18943 " + insert_query3); 
														}
												});

											}
										}
									}	
								
									//console.log("\n round while insert db "+room.tables[table_index].round_id);
									/**** Inserting Transaction Details to database once game end/restarted ****/
									/*For winning amount */
								console.log("Qry=====================52");
								insert_query1="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[won_player_index].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+room.tables[table_index].chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[won_player_index].name+"','"+room.tables[table_index].players[won_player_index].game_status+"','"+winner_won_amount+"','"+dt+"')";
								console.log(insert_query1);
								con.query(insert_query1, function(err1, result){
									if( err1 ) {
										console.log("\nGameTransaction SQL Error: " + err1);
										} 
									else { //console.log("\nGameTransaction 18957 " + insert_query);
									 }
								});

								update_game_details_func(table_index);

									/** Amount Updated after game end of player (if disconnected)**/
									for (var j = 0; j < room.tables[table_index].players.length; j++)
									{
										if(room.tables[table_index].players[j].name != declared_user)
										{
											if(room.tables[table_index].players[j].game_display_status != "Live")
											{
											   all_player_status = room.tables[table_index].players[j].status;
											//console.log("\nANDYANDYANDY8 " + room.tables[table_index].players[j].name + " : " + all_player_status);
												if(all_player_status == "disconnected")
												{
													//update_balance_after_declare(room.tables[table_index].players[j].name,group, room.tables[table_index].players[j].amount_playing,false);
													//removePlayerFromTable( room.tables[table_index].players[j].name, group );
												}
											}
										}
									}//for-db-amount-update
								//}//if-0-players
								for (var j = 0; j < room.tables[table_index].players.length; j++)
								{
									//console.log("\n ==== in for calculating virtual data  --------------");
									//console.log("\n pl name "+room.tables[table_index].players[j].name);
									//console.log("\n ........ player_GAME-status "+room.tables[table_index].players[j].game_display_status);
									if(room.tables[table_index].players[j].id != ''){
											all_player_status = room.tables[table_index].players[j].status;
											if(all_player_status != "disconnected")
											{
												//room.tables[table_index].players[j].status = "intable";
												//console.log("status: intable");
												player_name_array = [];
												player_final_card_groups_array=[];
												player_score_array=[];
												player_won_amount_array=[];
												player_group_status_array=[];
												for (var k = 0; k < room.tables[table_index].players.length; k++)
												{
													if(room.tables[table_index].players[k].game_display_status != "Live")
													{
													player_name_array.push(room.tables[table_index].players[k].name);
													player_grouped = room.tables[table_index].players[k].is_grouped;
													player_group_status_array.push(player_grouped);
													player_card_groups_array=[];
													is_player_grouped_temp = false;
													if(player_grouped ==false)
													{
														is_player_grouped_temp = false;
														player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].hand);
													}
													else
													{
														is_player_grouped_temp = true;
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6);}
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7);}
													}
													player_final_card_groups_array.push(player_card_groups_array);
													player_score_array.push(room.tables[table_index].players[k].game_score);
													//console.log("\n player won amount_won "+room.tables[table_index].players[k].amount_won);
													player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
													}
													else
													{
														player_name_array.push(room.tables[table_index].players[k].name);
														player_group_status_array.push(false);
														player_card_groups_array=[];
														player_final_card_groups_array.push(player_card_groups_array);
														player_score_array.push(-1);
														player_won_amount_array.push(-1);
													}
												}//inner-for ends 
												if(room.tables[table_index].players[j].game_display_status != "Live")
												{
													//console.log("\n ^^^^^^^^^^^^^ Emitting DATA TO PLAYERS ");
													io.sockets.connected[(room.tables[table_index].players[j].id)].emit("declared_final_six",
													{ 
														players:player_name_array,declared:2,group:group,winner:won_player,
														group_status:player_group_status_array,players_cards:player_final_card_groups_array,
														players_score:player_score_array,players_amount:player_won_amount_array
													});
												}
											}//disconnect
									}
								}//outer-for
								//if(room.tables[table_index].no_of_live_players ==1)
								//if(room.tables[table_index].no_of_live_players ==0)
								{
									room.tables[table_index].papplu_joker_card = "";
	                                room.tables[table_index].papplu_joker_card_name = "";
									 room.tables[table_index].papplu_joker_card_id="";
									room.tables[table_index].game_finished_status = true;
								}
						}//if-sequence-true(valid)
					}
				
				    }//for ends - decl - 1 - block
				
				room.tables[table_index].papplu_joker_card = "";
	            room.tables[table_index].papplu_joker_card_name = "";
				
									 room.tables[table_index].papplu_joker_card_id="";
			    }//declare-1-ends
		    }//round ends 
		
		
		return retValid;
	   }
	}//declare_papplu_game_data
	
	
	socket.on("test", function(data) {
		console.log("\nANDYANDY TEST " + data.left_user + "--" + data.is_refreshed +  "--" + data.is_clicked +  "--" + data.activity_timer_status +  "--" + data.joined_table + "--" + data.player_amount);
	});

	//// Player left six_player_rummy_game  ///
	socket.on("player_left_six_pl_game", function(data) {	
	
	});	


	function removePlayerFromTable( username_left, tableId ) {
		var query="DELETE FROM `user_tabel_join` WHERE `username`='"+username_left+"' and joined_table ='"+tableId+"'";
		con.query(query, function(err, result)
		{			
			 if (err) {
							console.log(err);
			    }
		});
	}
	/**************************  6 Player functions  end ***********************************/
	
	function indexOfMax(arr) 
	{
   	 if (arr.length === 0)
     { return -1; }
		var max = arr[0];
    	var maxIndex = 0;
		for (var i = 1; i < arr.length; i++) 
		{
        	if (arr[i] > max) 
        	{
            	maxIndex = i;
            	max = arr[i];
        	}
    	}
		//return max;
    	return maxIndex;
	}//indexOfMax ends 

	function indexOfLast(arr) 
	{
   	 if (arr.length === 0)
     { return -1; }
		var last = arr[0];
    	var lastIndex = 0;
		for (var i = 1; i < arr.length; i++) 
		{
        	if (arr[i] < last) 
        	{
            	lastIndex = i;
            	last = arr[i];
        	}
    	}
		return lastIndex;
	}//indexOfLast ends 


	});/////socket ends 
	
	
	function getFixedNumber(x) {
		return Number.parseFloat( Number.parseFloat(x).toFixed(2) );
	}

	var get_random_no = function (length) {
    return Math.floor(Math.pow(14, length-1) + Math.random() * (Math.pow(14, length) - Math.pow(14, length-1) - 1));
	}

	function removeUser(user_arr,usernm) {
	var index = -1;
			for(var  i = 0; i < user_arr.length; i++){
				if(user_arr[i] === usernm){
					index = i;
					break;
				}
			}
			if(index != -1){
				user_arr.remove(index);
			}
	
	}
	
	function removeGroup(group_arr,grpid) {
	var index = -1;
			for(var  i = 0; i < group_arr.length; i++){
				if(group_arr[i] === grpid){
					index = i;
					break;
				}
			}
			if(index != -1){
				group_arr.remove(index);
			}
	
	}
	
	function removePlayerAmount(amount_arr,amt) {
	var index = -1;
			for(var  i = 0; i < amount_arr.length; i++){
				if(amount_arr[i] === amt){
					index = i;
					break;
				}
			}
			if(index != -1){
				amount_arr.remove(index);
			}
	}
	
	
	////used to remove discarded/returned card from player hand cards array
	function removeFromHandCards(handcard_arr,card) {
	//console.log(card);
	var index = -1;
			for(var  i = 0; i < handcard_arr.length; i++){
			//console.log("**********"+handcard_arr[i].id+"==="+card);		
			//	if(handcard_arr[i].id== card){
			//console.log("**********"+handcard_arr[i].id+"==="+card);		
				if(handcard_arr[i].id== card){
					index = i;
					break;
				}
			}
			if(index != -1){
				handcard_arr.remove(index);
				console.log("*****AFTER REMOVE HAND *****"+JSON.stringify(handcard_arr));	
			}
	return handcard_arr;
	}
	
	function getDiscardFromHandCards(handcard_arr,card) {
	var index;
			for(var  i = 0; i < handcard_arr.length; i++){
				if(handcard_arr[i].id== card){
					index = handcard_arr[i];
					break;
				}
			}
	return index;
	}
	
	function getDiscardFromSortGroupCards(sortcard_arr,card,group_no) {
	//console.log("^^^^^^^^^^"+sortcard_arr.length+"---"+card+"---"+group_no);
	var index;
			for(var  i = 0; i < sortcard_arr.length; i++){
				if(group_no == 0)
				{
					if(sortcard_arr[i].id == card)
					{
						index = sortcard_arr[i];
						break;
					}
				}
				else
				{
					if(sortcard_arr[i].id == card)
					{
						index = sortcard_arr[i];
						break;
					}
				}
			}
	return index;
	}
	
	////used to remove discarded/returned card from player sorted hand cards array
	function removeFromSortedHandCards(handcard_arr,card,group_no) {
	//console.log(card+" grp no "+group_no);
	if( handcard_arr == null)
		return [];
	var index = -1;
			for(var  i = 0; i < handcard_arr.length; i++){
				if(group_no == 0)
				{
					if(handcard_arr[i].id == card)
					{
						//console.log("**********"+handcard_arr[i].id+"==="+card);	
						index = i;
						break;
					}
				}
				else
				{
					if(handcard_arr[i].id == card)
					{
						//console.log("**********"+handcard_arr[i].id+"==="+card);	
						index = i;
						break;
					}
				}
			}
			if(index != -1){
				//console.log("*****BEFORE REMOVE SORT  *****"+JSON.stringify(handcard_arr));	
				handcard_arr.remove(index);
				//console.log("\n \n *****AFTER REMOVE SORT  *****"+JSON.stringify(handcard_arr));	
			}
	return handcard_arr;
	}
	
	function removeFromGrpArr(group_arr,grpid) {
	var index = -1;
	//console.log(group_arr.length+"----  "+group_arr);
			for(var  i = 0; i < group_arr.length; i++){
				if(group_arr[i] === grpid){
				//console.log(index);
					index = i;
					break;
				}
			}
			if(index != -1){
			//console.log("b4 rem"+group_arr.length);
				group_arr.remove(index);
			//console.log("aftre rem"+group_arr.length);
			}
			//console.log("final   "+group_arr.length);
		return group_arr;
	}
	function removeOpenCard(opencard_arr,card) {
	 //console.log("check card exist "+card);
	//console.log("removing used open card (by id) from open card array"+JSON.stringify(opencard_arr));
	var index = -1;
			for(var  i = 0; i < opencard_arr.length; i++){
		//console.log("***"+opencard_arr[i].id+"----"+card);		
				if(opencard_arr[i].id == card){
					index = i;
					break;
				}
			}
			if(index != -1){
				opencard_arr.remove(index);
			
			}
	return opencard_arr;
	}
	
	
	function removeCloseCard(closecard_arr,card) {
	var index = -1;
			for(var  i = 0; i < closecard_arr.length; i++){
				if(closecard_arr[i].id == card){
					index = i;
					break;
				}
			}
			if(index != -1){
				closecard_arr.remove(index);
			}
		return closecard_arr;
	}
	
	function checkIfJokerCard(joker_card_arr,joker_card_id)
	{
		var is_joker_card = false;
		
		for(var  i = 0; i < joker_card_arr.length; i++)
		{
			//console.log("**********"+joker_card_arr[i].id+"==="+joker_card_id);	
				if(joker_card_arr[i].id == joker_card_id)
				{
					is_joker_card = true;
					break;
				}
		}
		
		return is_joker_card;
	}//checkIfJokerCard ends 

	function getPlayerNames(table_index) 
	{
		if( room.tables[table_index].players.length == 0 )
			return "";
		
		var names = room.tables[table_index].players[0].name;
		for( i = 1; i < room.tables[table_index].players.length; i++ ) {
		    if(room.tables[table_index].players[i]){
			names = names + "," + room.tables[table_index].players[i].name;
			}
		}

		return names;
	}
	
	/*** Get Table Index on which player is playing for multiple table **/
	function getTableIndex(table_arr,table_id)
	{
		var index = -1;
		for(var  i = 0; i < table_arr.length; i++)
		{
			//console.log("**********"+table_arr[i].id+"==="+table_id);	
				if(table_arr[i].id == table_id)
				{
					index = i;
					break;
				}
		}
		if( index == -1 ) {
			console.log("Table not found");
		}
		return index;
	}//getTableIndex ends 

		function shuffleImages(all_images) {
			  var i = all_images.length, j, tempi, tempj;
			  if (i === 0) return false;
			  while (--i) {
				 j = Math.floor(Math.random() * (i + 1));
				 tempi = all_images[i];
				 tempj = all_images[j];
				 all_images[i] = tempj;
				 all_images[j] = tempi;
			   }
			  return all_images;
			}
			
			function shuffleClosedCards(closed_cards) {
			  var i = closed_cards.length, j, tempi, tempj;
			  if (i === 0) return false;
			  while (--i) {
				 j = Math.floor(Math.random() * (i + 1));
				 tempi = closed_cards[i];
				 tempj = closed_cards[j];
				 closed_cards[i] = tempj;
				 closed_cards[j] = tempi;
			   }
			  return closed_cards;
			}
			
			function drawImages(all_images, amount, hand, initial) {
			//console.log("\n --------- all_images length in draw "+all_images.length);
				var temp_cards = [];
				temp_cards = all_images.slice(0, amount);
				all_images.splice(0, amount);
				if (!initial) {
				  hand.push.apply(hand, temp_cards); 
				}
				return temp_cards;
			  }
			  
			  function createSampleTables(amount) {
			 	var tableList = [];
				for(var i = 0; i < amount; i++){
					var table = new Table((i + 1));
					table.setName("Test Table" + (i + 1));
					table.status = "available";
					tableList.push(table);
			//		console.log("--------------"+tableList.length+JSON.stringify(tableList));
				}
				return tableList;
			}
	
/********************** Socket connection ********************/

server.listen(3010, 'rummysahara.com',{
  'heartbeat interval': 2,
  'heartbeat timeout' : 5
});

