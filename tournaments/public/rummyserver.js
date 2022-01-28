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
var room = new Room("Tournament");
var Table = require('./table.js');
var Utils = require('./utils.js');
var validateGroup = require('./validateGroup.js');

var valid = new validateGroup();

const EXTRA_TIME = 30;
const TOURNAMENT_STATUS_CREAT = "create";
const TOURNAMENT_STATUS_START = "start";
const TOURNAMENT_STATUS_END = "end";

const TOURNAMENT_GAME_STATUS_READY = "ready";
const TOURNAMENT_GAME_STATUS_GAME = "game";

//const TOURNAMENT_READYTIME = 20;
const TOURNAMENT_READYTIME = 59;
const TOURNAMENT_GAMETIME = 45 * 60;

const TOURNAMENT_PLAYER_PER_TABLE = 6;		//6

const TOURNAMENT_ROUND_CNT = 6;		//6

const TOURNAMENT_POINTS = 480;

const GAME_STATUS_START = "start";
const GAME_STATUS_END = "end";

//var file1 = require('./six_player_game')(io);
utils = new Utils();

app.set('view engine', 'jade');

app.use(cookieParser());
app.use(session({ secret: "SESSIONSECRET", saveUninitialized: false, resave: false, cookie: { expires: 30 * 86400 * 1000 } }));
//app.use(session({ secret: 'secured', store: new MemoryStore({ reapInterval: 60000 * 10 }) }));
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
var os = require('os');

//database connection
var con = mysql.createConnection({
	host: "localhost",
	user: "rummysah_db",
	password: "Admin@123",
	database: "rummysah_db"
});


var tournaments = {};
var tournaments_msg = {};
var uname;
var device_name, os_type;
var company_commision = 0;
var chip_type = "real";
var user_id = "";
var table_player_capacity = "";
/************* Six player game variables ************/
var cards_six = [];
var cards_without_joker_six = [];
var orgin_cards_six = [];

/************* Six player game variables ************/

function KolkataTime() {
	var KolkataOffsetTime = (330 - (new Date().getTimezoneOffset() * -1));
	var date = datetime.create(new Date(Date.now() + KolkataOffsetTime * 60000));
	return date.format('Y/m/d H:M:S');
}


// Loading game_app's index page - index.html
app.get('/', function (req, res) {
	device_name = req.device.type.toUpperCase();
	os_type = os.platform();
	req.session.destroy();
	req.session = null;

});

//con.query('UPDATE tournament SET status=? WHERE tournament_id=?', [TOURNAMENT_STATUS_CREAT, 34], function (err1, results, fields) { });
/********************** Joined Table details page starts  *********************/

app.get('/join_tournament', function (req, res) {

	device_name = req.device.type.toUpperCase();
	os_type = os.platform();
	uname = req.query.user;
	var tournament_id = req.query.tournament_id;
	console.log("\n Player  " + uname + " is using OS of type " + os_type + " on device " + device_name);

	var player_balance = 0;

	if (uname != "" && tournament_id != 0) {
		console.log("Player - " + uname + " joining to tournament from  - " + tournament_id);
		var qry = "SELECT user_id, gender FROM `users`  where `username` ='" + uname + "' ";
		con.query(qry, function (err, user, userfields) {
			if(err){
				console.log(err);
			}else{
				if (user.length != 0) {
					con.query('SELECT * FROM tournament WHERE tournament_id=?', [tournament_id], function (err1, results, fields) {
						if(err1){
							console.log(err1);
						}else{
						    if (results.length > 0)
							res.render('six_pl_rummy', { tournament_id: tournament_id, tournament_title: results[0].title, loggeduser: uname, player_gender: user[0].gender, user_id: user[0].userid });
					
					    }
					});
				}
			}
		});
	}
});

/********************** Joined Table details page ends  *********************/

app.get('/game_summary', function (req, res) {
	console.log("loading game summary page ");
	var user = req.query.user;
	var group = req.query.grpid;
	var qry = "SELECT * FROM `game_details`  where user_id = '" + user + "' and group_id = " + group;
	con.query(qry, function (err, result, fields) {
		if (err) { console.log(err); }

		res.render('game_summary', { user: user, grpid: group, grp1: JSON.stringify(result[0].group1), grp2: JSON.stringify(result[0].group2), grp3: JSON.stringify(result[0].group3), grp4: JSON.stringify(result[0].group4), grp5: JSON.stringify(result[0].group5), grp6: JSON.stringify(result[0].group6), grp7: JSON.stringify(result[0].group7) });
	});
});

app.get('/ping', function (req, res) {
	res.send('pong');
});

/********************** Socket connection ********************/
var clients_connected = [];

var cards_without_joker = [];
var joker_cards = [];
var club_suit_cards = [];
var spade_suit_cards = [];
var heart_suit_cards = [];
var diamond_suit_cards = [];
var transaction_id = 0;


function saveTournamentTransaction(tournamentId, playerId, position, score) {
	var transaction = {
		"tournament_id": tournamentId,
		"player_id": playerId,
		"position": position,
		"score": score,
		"taken_date": KolkataTime(),
		"entry_date": new Date(tournaments[tournamentId].startTime)
	}
	con.query('INSERT INTO tournament_transaction SET ?', transaction, function (error, results, fields) {
		if (error) {
			console.log(error);
		} else {
		}
	});

	if (score > 0) {
		con.query('UPDATE accounts SET real_chips = real_chips + ? WHERE userid = ?', [score, playerId], function (error, results, fields) {
			if (error) {
				console.log(error);
			} else {
			}
		});
	}
}

function getTournamentScores(tournamentId) {
	con.query('SELECT * FROM price_distribution WHERE tournament_id=? ORDER BY position ASC', [tournamentId], function (error, results, fields) {
		if (error) {
			return;
		} else {
			for (i = 0; i < results.length; i++) {
				tournaments[tournamentId].scores[results[i].position] = {
					score: results[i].price,
					count: results[i].no_players
				};
			}
			//console.log("tournament created: " + tournament_id);
		}
	});
}

function makeGameTables(tournamentId) {
	var tournament = tournaments[tournamentId];

	if (tournament.current_stage > 1) {
		var indexs = [];
		var k = 0;
		for (i = 0; i < tournament.player_status.length; i++) {
			if (tournament.player_status[i].stage <= tournament.current_stage)
				indexs[k++] = i;
		}

		/// MAKE RANDOM ////    
		var temp;
		for (i = 0; i < indexs.length; i++) {
			var j = Math.floor((Math.random() * indexs.length));
			temp = indexs[i];
			indexs[i] = indexs[j];
			indexs[j] = temp;
		}
		////////////////////       
		var gameCnt = Math.ceil(tournament.current_stage / TOURNAMENT_PLAYER_PER_TABLE);
		tournament.current_tables = gameCnt;

		for (i = 0; i < gameCnt * TOURNAMENT_PLAYER_PER_TABLE; i++) {
			var grpId = tournamentId * 1000 + i;

			var table = room.getTable(grpId);
			if (table) {
				if (table.turnTimer != 0)
					clearInterval(table.turnTimer);
			}

			room.removeTableById(grpId);
		}

		for (i = 0; i < gameCnt; i++) {
			var grpId = tournamentId * 1000 + i;
			table = new Table(tournamentId, grpId);
			room.addTable(table);
			table_index = getTableIndex(room.tables, grpId);

			room.tables[table_index].status = "available";
			room.tables[table_index].playerCapacity = 6;
			room.tables[table_index].gameCnt = TOURNAMENT_ROUND_CNT;

			var leftPlayers = TOURNAMENT_PLAYER_PER_TABLE;
			if (i == gameCnt - 1) {
				leftPlayers = tournament.current_stage % TOURNAMENT_PLAYER_PER_TABLE;
				if (leftPlayers == 0) {
					leftPlayers = TOURNAMENT_PLAYER_PER_TABLE;
				}
			}
			for (j = 0; j < leftPlayers; j++) {
				var idx = i * TOURNAMENT_PLAYER_PER_TABLE + j;
				var username = tournament.players[indexs[idx]];
				var gender = tournament.genders[indexs[idx]];
				var player_user_id = tournament.players_id[indexs[idx]];

				player = new Player();
				var scoketidpl=tournament.players_socketid[i];
				player.setID(scoketidpl);
				player.setName(username);
				//set player's properties
				player.status = "disconnected";

				player.tableID = room.tables[table_index].id;
				player.user_id = player_user_id;
				player.is_joined_table = true;
				player.amount_playing = TOURNAMENT_POINTS;

				room.tables[table_index].players.push(player);
				room.tables[table_index].six_player_gender.push(gender);
				room.tables[table_index].six_player_amount.push(TOURNAMENT_POINTS);
				room.tables[table_index].six_user_click.push(j + 1);
				room.tables[table_index].six_usernames.push(username);
			}

			for (j = 0; j < leftPlayers; j++) {
				var idx = i * TOURNAMENT_PLAYER_PER_TABLE + j;
				var username = tournament.players[indexs[idx]];
				var socketid = tournament.players_socketid[indexs[idx]];
				if (socketid != 0 && io.sockets.connected[socketid]) {
					io.sockets.connected[socketid].emit('check_if_joined_player', tournamentId);
				}
			}
		}

		if (tournament.current_stage % TOURNAMENT_PLAYER_PER_TABLE == 1) {
			room.tables[table_index].status = GAME_STATUS_END;
			tournament.player_status[indexs[tournament.current_stage - 1]].stage = Math.ceil(tournament.current_stage / TOURNAMENT_PLAYER_PER_TABLE);
		}
	} else {
		for (i = 0; i < tournament.player_status.length; i++) {
			if (tournament.player_status[i].stage == 1) {

				var socketid = tournament.players_socketid[i];
				var score = tournament.scores[1] === undefined ? 0 : tournament.scores[1].score;
				if (socketid != 0 && io.sockets.connected[socketid]) {
					io.sockets.connected[socketid].emit('tournament_position', { tournamentId: tournamentId, title: tournament.title, position: 1, score: score });
				}

				saveTournamentTransaction(tournamentId, tournament.players_id[i], 1, score);

				con.query('UPDATE tournament SET status=? WHERE tournament_id=?', [TOURNAMENT_STATUS_END, tournamentId], function (err1, results, fields) {
					if(err1){
						console.log(err1);
					}
				});

				console.log("Tournament Ended: " + tournamentId);
			}
		}

		delete tournaments[tournamentId];

		return false;
	}

	return true;
}


function checkTournamentStageOver(tournamentId) {

	for (j = 0; j < tournaments[tournamentId].current_tables; j++) {
		var tableId = tournamentId * 1000 + j;
		var table_index = getTableIndex(room.tables, tableId);
		if (table_index >= 0 &&
			room.tables[table_index].status != GAME_STATUS_END) {
			return false;
		}
	}

	return true;
}

function gotoNextStage(tournamentId) {
	if (!checkTournamentStageOver(tournamentId))
		return;

	var tournament = tournaments[tournamentId];
	//if (tournament.score_record == false) 
	{
		tournament.score_record = true;

		var losers = [];
		var idx = 0;
		for (i = 0; i < tournament.player_status.length; i++) {
			if (tournament.player_status[i].stage == tournament.current_stage)
				losers[idx++] = i;
		}

		losers.sort(function (i, j) {
			var pl1 = tournament.player_status[i];
			var pl2 = tournament.player_status[j];

			if (pl1.points < pl2.points) {
				return -1;
			} else if (pl1.points == pl2.points) {
				return 0;
			}
			return 1;
		});

		idx = 0;
		for (i = 0; i < losers.length; i++) {
			var position = tournament.current_stage - i;
			tournament.player_status[losers[i]].position = position;

			var playerCnt = tournament.scores[position] === undefined ? 0 : tournament.scores[position].count;
			var score = tournament.scores[position] === undefined ? 0 : tournament.scores[position].score;

			var socketid = tournament.players_socketid[losers[idx + i]];
			if (socketid != 0 && io.sockets.connected[socketid]) {
				io.sockets.connected[socketid].emit('tournament_position', { tournamentId: tournamentId, title: tournament.title, position: position, score: score });
			}

			saveTournamentTransaction(tournamentId, tournament.players_id[losers[idx + i]], position, score);
		}
	}

	console.log("Make Game Table");

	tournament.current_stage = Math.ceil(tournament.current_stage / TOURNAMENT_PLAYER_PER_TABLE);
	if (makeGameTables(tournamentId)) {
		tournament.status = TOURNAMENT_GAME_STATUS_READY;
		tournament.time = TOURNAMENT_READYTIME;
	}
}


function makeGameEnd(tournamentId, table_index) {
	if (room.tables[table_index].status == GAME_STATUS_END)
		return;

	room.tables[table_index].status = GAME_STATUS_END;

	clearInterval(room.tables[table_index].turnTimer);
	clearInterval(room.tables[table_index].finalTimer);
	room.tables[table_index].turnTimer = 0;
	room.tables[table_index].finalTimer = 0;

	setWinnerToNextStage(tournamentId, table_index);
}

function getIndexofPlayerInTournament(tournamentId, username) {
	var tournament = tournaments[tournamentId];
	if (tournament) {
		for (var j = 0; j < tournament.players.length; j++) {
			if (tournament.players[j] == username)
				return j;
		}
	}
	return -1;
}

function setWinnerToNextStage(tournamentId, table_index) {
	if (table_index < 0)
		return;
	var maxVal = 0;
	var winner;
	var tournament = tournaments[tournamentId];

	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		if (room.tables[table_index].players[i].amount_playing > maxVal) {
			winner = room.tables[table_index].players[i].name;
			maxVal = room.tables[table_index].players[i].amount_playing;
		} else if (room.tables[table_index].players[i].amount_playing == maxVal) {
			//need to evaluate
		}

		idx = getIndexofPlayerInTournament(tournamentId, room.tables[table_index].players[i].name);
		if (idx >= 0) {
			tournament.player_status[idx].points = room.tables[table_index].players[i].amount_playing;
		}
	}

	room.tables[table_index].winner = winner;
	idx = getIndexofPlayerInTournament(tournamentId, winner);
	tournament.player_status[idx].stage = Math.ceil(tournament.current_stage / TOURNAMENT_PLAYER_PER_TABLE);

	io.emit("touranment_game_end", tournamentId, room.tables[table_index].id, winner);
}

function createTournament(tournament_id, tournamentTitle, tournamentDate) {
	tournaments[tournament_id] = {
		title: tournamentTitle,
		status: TOURNAMENT_GAME_STATUS_READY,
		players_id: [],
		players: [],
		players_socketid: [],
		player_status: [],
		genders: [],
		current_stage: 0,
		current_tables: 0,
		scores: [],
		score_record: true,
		startTime: tournamentDate,
		time: TOURNAMENT_READYTIME
	};

	con.query('SELECT join_tournaments.*, users.username, users.gender FROM join_tournaments JOIN users WHERE users.user_id = join_tournaments.player_id AND tournament_id=?', [tournament_id], function (error, results, fields) {
		if (error) {
			return;
		} else {
			console.log("tournament created: " + tournament_id + " " + results.length);

			for (i = 0; i < results.length; i++) {
				var initial_status = {
					stage: results.length,
					points: 0,
					position: 0
				};
				tournaments[tournament_id].players_id[i] = results[i].player_id;
				tournaments[tournament_id].players[i] = results[i].username;
				tournaments[tournament_id].player_status[i] = initial_status;
				tournaments[tournament_id].players_socketid[i] = 0;
				tournaments[tournament_id].genders[i] = results[i].gender;
			}
			tournaments[tournament_id].current_stage = results.length;

			if (tournaments[tournament_id].current_stage > 1) {
				getTournamentScores(tournament_id);
				makeGameTables(tournament_id);
			} else {
				delete tournaments[tournament_id];
			}
			con.query('UPDATE tournament SET status=? WHERE tournament_id=?', [TOURNAMENT_STATUS_START, tournament_id], function (err1, results, fields) {
				if(err1){
				   console.log(err1);
			    }
			});
		}
	});
}

function tournamentTimer() {
	con.query('SELECT * FROM tournament WHERE status=?', [TOURNAMENT_STATUS_CREAT], function (err1, tourna, fields) {
		if (err1) {
		} else {
			for (i = 0; i < tourna.length; i++) {
				var nowTime = Date.now();
				var startTimeStr = tourna[i].start_date;
				var startDate = new Date(Date.parse(startTimeStr));
				var strTime = tourna[i].start_time.split(":");
				if (strTime.length == 3) {
					startDate.setHours(strTime[0]);
					startDate.setMinutes(strTime[1]);
					startDate.setSeconds(strTime[2]);
				}
				var startTime = startDate.valueOf();
				if (nowTime >= startTime) {
					// start tournament
					createTournament(tourna[i].tournament_id, tourna[i].title, startTime);

					io.emit('tournament_update', { tournamentId: tourna[i].tournament_id });
				}
			}
		}
	});
	Object.keys(tournaments).forEach(function (tournamentId) {
		io.emit('tournament_time', { tournamentId: tournamentId, status: tournaments[tournamentId].status, time: tournaments[tournamentId].time });
		if (tournaments[tournamentId].time > 0) {
			tournaments[tournamentId].time--;
		} else {
			if (tournaments[tournamentId].status == TOURNAMENT_GAME_STATUS_READY) {
				tournaments[tournamentId].status = TOURNAMENT_GAME_STATUS_GAME;
				tournaments[tournamentId].time = TOURNAMENT_GAMETIME;
				for (i = 0; i < tournaments[tournamentId].current_tables; i++) {
					var tableId = tournamentId * 1000 + i;
					var table_index = getTableIndex(room.tables, tableId);
					if (table_index >= 0) {
						var cards_six = [];
						cards_six.push.apply(cards_six, orgin_cards_six);
						random_group_roundno = Math.floor(100000000 + Math.random() * 900000000);//6-digit-no

						if (room.tables[table_index].players.length > 1)
							startGame(table_index, tableId, cards_six, random_group_roundno, true);
					}
				}
				io.emit('tournament_gamestart', tournamentId);
			} else if (tournaments[tournamentId].status == TOURNAMENT_GAME_STATUS_GAME) {
				tournaments[tournamentId].status = TOURNAMENT_GAME_STATUS_READY;
				tournaments[tournamentId].time = TOURNAMENT_READYTIME;

				for (j = 0; j < tournaments[tournamentId].current_tables; j++) {
					var tableId = tournamentId * 1000 + j;
					var table_index = getTableIndex(room.tables, tableId);
					if (table_index >= 0) {
						makeGameEnd(tournamentId, table_index);
					}
				}

				gotoNextStage(tournamentId);
			}
		}
	});
}


function check_player_empty_group(player_id, group, card_group) {
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n check_player_empty_group");
		return;
	}
	var i = player_id;
	var empty_group;
	for (var k = 1; k <= 7; k++) {
		       if(room.tables[table_index].players[i].card_group1){
			    if(room.tables[table_index].players[i].card_group1.length == 0)
				{
					//room.tables[table_index].players[i].card_group1 = card_group;
					n=1;
					break;
				}
				}
				if(room.tables[table_index].players[i].card_group2){
				if(room.tables[table_index].players[i].card_group2.length == 0)
				{
					//room.tables[table_index].players[i].card_group2 = card_group;
					n=2;
					break;
				}
				}
				if(room.tables[table_index].players[i].card_group3){
				if(room.tables[table_index].players[i].card_group3.length == 0)
				{
					//room.tables[table_index].players[i].card_group3 = card_group;
					n=3;
					break;
				}
				}
				if(room.tables[table_index].players[i].card_group4){
				if(room.tables[table_index].players[i].card_group4.length == 0)
				{
					//room.tables[table_index].players[i].card_group4 = card_group;
					n=4;
					break;
				}
				}
				if(room.tables[table_index].players[i].card_group5){
				if(room.tables[table_index].players[i].card_group5.length == 0)
				{
					//room.tables[table_index].players[i].card_group5 = card_group;
					n=5;
					break;
				}
				}
				if(room.tables[table_index].players[i].card_group6){
				if(room.tables[table_index].players[i].card_group6.length == 0)
				{
					//room.tables[table_index].players[i].card_group6 = card_group;
					n=6;
					break;
				}else
				{
					n =8;
				}
				}
				if(room.tables[table_index].players[i].card_group7){
				if(room.tables[table_index].players[i].card_group7.length == 0)
				{
					//room.tables[table_index].players[i].card_group7 = card_group;
					n=7;
					break;
				} 
				}
	}
	console.log("After group created, card group no " + n);
	return n;
}//check_player_empty_group ends 

function add_cards_to_last_group(player_id, group, card_group) {
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n add_cards_to_last_group");
		return;
	}
	var i = player_id;
	room.tables[table_index].players[i].card_group7 = card_group;
	console.log("After group created, card group no " + n + " updated.");
}


function update_game_details_func(table_index) {
	var table_open_cards = []; var table_close_cards = [];
	//rem-open-cards
	for (var i = 0; i < room.tables[table_index].open_cards.length; i++) {
		table_open_cards.push(room.tables[table_index].open_cards[i].id);
	}
	console.log("\n table_open_cards id array ----------> " + JSON.stringify(table_open_cards));
	//rem-closed-cards
	for (var i = 0; i < room.tables[table_index].closed_cards_arr.length; i++) {
		table_close_cards.push(room.tables[table_index].closed_cards_arr[i].id);
	}
	console.log("\n table_close_cards id array ----------> " + JSON.stringify(table_close_cards));
	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		var player_card_group1 = []; var player_card_group2 = []; var player_card_group3 = []; var player_card_group4 = [];
		var player_card_group5 = []; var player_card_group6 = []; var player_card_group7 = [];  var p1_handcards = [];
		
			if(room.tables[table_index].players[i].hand){
				for (var j = 0; j < room.tables[table_index].players[i].hand.length; j++)
				{
					p1_handcards.push(room.tables[table_index].players[i].hand[j].id);
					
				}
			}
		
		if(room.tables[table_index].players[i].card_group1){
				if(room.tables[table_index].players[i].card_group1.length != 0)
				{
					for (var j = 0; j < room.tables[table_index].players[i].card_group1.length; j++)
					{
						player_card_group1.push(room.tables[table_index].players[i].card_group1[j].id);
					}
				}
			}
			if(room.tables[table_index].players[i].card_group2){
				if(room.tables[table_index].players[i].card_group2.length != 0)
				{
					for (var j = 0; j < room.tables[table_index].players[i].card_group2.length; j++)
					{
						player_card_group2.push(room.tables[table_index].players[i].card_group2[j].id);
					}
				}
			}
			if(room.tables[table_index].players[i].card_group3){
				if(room.tables[table_index].players[i].card_group3.length != 0)
				{
					for (var j = 0; j < room.tables[table_index].players[i].card_group3.length; j++)
					{
						player_card_group3.push(room.tables[table_index].players[i].card_group3[j].id);
					}
				}
			}
			if(room.tables[table_index].players[i].card_group4){
				if(room.tables[table_index].players[i].card_group4.length != 0)
				{
					for (var j = 0; j < room.tables[table_index].players[i].card_group4.length; j++)
					{
						player_card_group4.push(room.tables[table_index].players[i].card_group4[j].id);
					}
				}
			}
			if(room.tables[table_index].players[i].card_group5){
				if(room.tables[table_index].players[i].card_group5.length != 0)
				{
					for (var j = 0; j < room.tables[table_index].players[i].card_group5.length; j++)
					{
						player_card_group5.push(room.tables[table_index].players[i].card_group5[j].id);
					}
				}
			}
			if(room.tables[table_index].players[i].card_group6){
				if(room.tables[table_index].players[i].card_group6.length != 0)
				{
					for (var j = 0; j < room.tables[table_index].players[i].card_group6.length; j++)
					{
						player_card_group6.push(room.tables[table_index].players[i].card_group6[j].id);
					}
				}
			}
			if(room.tables[table_index].players[i].card_group7){
				if(room.tables[table_index].players[i].card_group7.length != 0)
				{
					for (var j = 0; j < room.tables[table_index].players[i].card_group7.length; j++)
					{
						player_card_group7.push(room.tables[table_index].players[i].card_group7[j].id);
					}
				}
			}
		/*if (room.tables[table_index].players[i].card_group1.length != 0) {
			for (var j = 0; j < room.tables[table_index].players[i].card_group1.length; j++) {
				player_card_group1.push(room.tables[table_index].players[i].card_group1[j].id);
			}
		}
		if (room.tables[table_index].players[i].card_group2.length != 0) {
			for (var j = 0; j < room.tables[table_index].players[i].card_group2.length; j++) {
				player_card_group2.push(room.tables[table_index].players[i].card_group2[j].id);
			}
		}
		if (room.tables[table_index].players[i].card_group3.length != 0) {
			for (var j = 0; j < room.tables[table_index].players[i].card_group3.length; j++) {
				player_card_group3.push(room.tables[table_index].players[i].card_group3[j].id);
			}
		}
		if (room.tables[table_index].players[i].card_group4.length != 0) {
			for (var j = 0; j < room.tables[table_index].players[i].card_group4.length; j++) {
				player_card_group4.push(room.tables[table_index].players[i].card_group4[j].id);
			}
		}
		if (room.tables[table_index].players[i].card_group5.length != 0) {
			for (var j = 0; j < room.tables[table_index].players[i].card_group5.length; j++) {
				player_card_group5.push(room.tables[table_index].players[i].card_group5[j].id);
			}
		}
		if (room.tables[table_index].players[i].card_group6.length != 0) {
			for (var j = 0; j < room.tables[table_index].players[i].card_group6.length; j++) {
				player_card_group6.push(room.tables[table_index].players[i].card_group6[j].id);
			}
		}
		if (room.tables[table_index].players[i].card_group7.length != 0) {
			for (var j = 0; j < room.tables[table_index].players[i].card_group7.length; j++) {
				player_card_group7.push(room.tables[table_index].players[i].card_group7[j].id);
			}
		}*/
var update_game_details = "update game_details set `group1`='"+player_card_group1+"',`group2`='"+player_card_group2+"',`group3`='"+player_card_group3+"',`group4`='"+player_card_group4+"',`group5`='"+player_card_group5+"',`group6`='"+player_card_group6+"',`group7`='"+player_card_group7+"',`close_cards`='"+table_close_cards+"',`open_card`='"+table_open_cards+"',`joker`='"+room.tables[table_index].side_joker_card+"',`hand_cards`='"+p1_handcards+"'  WHERE `user_id`='"+room.tables[table_index].players[i].name+"' and `group_id`='"+room.tables[table_index].id+"' and `round_id`='"+room.tables[table_index].round_id+"' ORDER BY id DESC LIMIT 1";
			
		//var update_game_details = "update game_details set `group1`='" + player_card_group1 + "',`group2`='" + player_card_group2 + "',`group3`='" + player_card_group3 + "',`group4`='" + player_card_group4 + "',`group5`='" + player_card_group5 + "',`group6`='" + player_card_group6 + "',`group7`='" + player_card_group7 + "',`close_cards`='" + table_close_cards + "',`open_card`='" + table_open_cards + "'  WHERE `user_id`='" + room.tables[table_index].players[i].name + "' and `group_id`='" + room.tables[table_index].id + "' and `round_id`='" + room.tables[table_index].round_id + "'";
		con.query(update_game_details, function (err, result) {
			if (err) throw err;
			else { console.log(result.affectedRows + " record(s) updated of game_details"); }
		});
	}//for ends 
}


var declared_groups_array = [];
var declared_groups_array_status = [];
var declared_invalid_groups_array = [];

function get_player_group_count(player_id, group) {
	var group_count = 0;
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n get_player_group_count");
		return;
	}

	var i = 0;
	var a = 0;

	if (room.tables[table_index].players[player_id].card_group1.length != 0) {
		if (room.tables[table_index].players[player_id].card_group1.length >= 3) {
			group_count++;
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group1;
			i++;
		}
		else if (!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group1, room.tables[table_index].joker_cards)) {
			a++;
		}
	}
	if (room.tables[table_index].players[player_id].card_group2.length != 0) {
		if (room.tables[table_index].players[player_id].card_group2.length >= 3) {
			group_count++;
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group2;
			i++;
		}
		else if (!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group2, room.tables[table_index].joker_cards)) {
			a++;
		}
	}
	if (room.tables[table_index].players[player_id].card_group3.length != 0) {
		if (room.tables[table_index].players[player_id].card_group3.length >= 3) {
			group_count++;
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group3;
			i++;
		}
		else if (!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group3, room.tables[table_index].joker_cards)) {
			a++;
		}
	}
	if (room.tables[table_index].players[player_id].card_group4.length != 0) {
		if (room.tables[table_index].players[player_id].card_group4.length >= 3) {
			group_count++;
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group4;
			i++;
		}
		else if (!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group4, room.tables[table_index].joker_cards)) {
			a++;
		}
	}
	if (room.tables[table_index].players[player_id].card_group5.length != 0) {
		if (room.tables[table_index].players[player_id].card_group5.length >= 3) {
			group_count++;
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group5;
			i++;
		}
		else if (!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group5, room.tables[table_index].joker_cards)) {
			a++;
		}
	}
	if (room.tables[table_index].players[player_id].card_group6.length != 0) {
		if (room.tables[table_index].players[player_id].card_group6.length >= 3) {
			group_count++;
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group6;
			i++;
		}
		else if (!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group6, room.tables[table_index].joker_cards)) {
			a++;
		}
	}
	if (room.tables[table_index].players[player_id].card_group7.length != 0) {
		if (room.tables[table_index].players[player_id].card_group7.length >= 3) {
			group_count++;
			declared_groups_array[i] = room.tables[table_index].players[player_id].card_group7;
			i++;
		}
		else if (!valid.validateAllJoker(room.tables[table_index].players[player_id].card_group7, room.tables[table_index].joker_cards)) {
			a++;
		}

	}
	//console.log("** declared_groups_array ** "+JSON.stringify(declared_groups_array)+" a->"+a+" group_count "+group_count);
	if (a > 0)
		return 0;

	return group_count;

}

function get_opp_player_group_count(player_id, group) {
	var group_count = 0;
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n get_opp_player_group_count");
		return;
	}
	var a = 0;
	var i = 0;
	declared_groups_array = [];

	if (room.tables[table_index].players[player_id].card_group1.length != 0) {
		declared_groups_array[i] = room.tables[table_index].players[player_id].card_group1;
		//console.log("\n declared_groups_array if 1 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
		i++;
		group_count=group_count+1;
	}
	if (room.tables[table_index].players[player_id].card_group2.length != 0) {
		declared_groups_array[i] = room.tables[table_index].players[player_id].card_group2;
		//console.log("\n declared_groups_array if 2 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
		i++;
		group_count=group_count+1;
	}
	if (room.tables[table_index].players[player_id].card_group3.length != 0) {
		declared_groups_array[i] = room.tables[table_index].players[player_id].card_group3;
		//console.log("\n declared_groups_array if 3 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
		i++;
		group_count=group_count+1;
	}
	if (room.tables[table_index].players[player_id].card_group4.length != 0) {
		declared_groups_array[i] = room.tables[table_index].players[player_id].card_group4;
		//console.log("\n declared_groups_array if 4 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
		i++;
		group_count=group_count+1;
	}
	if (room.tables[table_index].players[player_id].card_group5.length != 0) {
		declared_groups_array[i] = room.tables[table_index].players[player_id].card_group5;
		//console.log("\n declared_groups_array if 5 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
		i++;
		group_count=group_count+1;
	}
	if (room.tables[table_index].players[player_id].card_group6.length != 0) {
		declared_groups_array[i] = room.tables[table_index].players[player_id].card_group6;
		//console.log("\n declared_groups_array if 6 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
		i++;
		group_count=group_count+1;
	}
	if (room.tables[table_index].players[player_id].card_group7.length != 0) {
		declared_groups_array[i] = room.tables[table_index].players[player_id].card_group7;
		//console.log("\n declared_groups_array if 7 "+declared_groups_array.length+" ==> "+JSON.stringify(declared_groups_array));
		i++;
		group_count=group_count+1;
	}
	return group_count;

}

function get_player_groups(player_id, group) {
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n get_player_groups");
		return;
	}
	var player_groups_array = [];
	var i = 0;

	if (room.tables[table_index].players[player_id].card_group1.length != 0) {
		player_groups_array[i] = room.tables[table_index].players[player_id].card_group1;
		i++;
	}
	if (room.tables[table_index].players[player_id].card_group2.length != 0) {
		player_groups_array[i] = room.tables[table_index].players[player_id].card_group2;
		i++;
	}
	if (room.tables[table_index].players[player_id].card_group3.length != 0) {
		player_groups_array[i] = room.tables[table_index].players[player_id].card_group3;
		i++;
	}
	if (room.tables[table_index].players[player_id].card_group4.length != 0) {
		player_groups_array[i] = room.tables[table_index].players[player_id].card_group4;
		i++;
	}
	if (room.tables[table_index].players[player_id].card_group5.length != 0) {
		player_groups_array[i] = room.tables[table_index].players[player_id].card_group5;
		i++;
	}
	if (room.tables[table_index].players[player_id].card_group6.length != 0) {
		player_groups_array[i] = room.tables[table_index].players[player_id].card_group6;
		i++;
	}
	if (room.tables[table_index].players[player_id].card_group7.length != 0) {
		player_groups_array[i] = room.tables[table_index].players[player_id].card_group7;
	}
	return player_groups_array;

}

////clear all fields before game start / restart 
function clear_all_data_before_game_start(table) {
	joined_table = false;
	uname = '';
	grp_round_no = 0;
	round_no_arr = [];
	card_images = [];
	timer = table.timer_array[1];
	p1_group1 = [], p1_group2 = [], p1_group3 = [], p1_group4 = [], p1_group5 = [], p1_group6 = [], p1_group7 = [];

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
	table.temp_open_object = "";
	table.finish_card_object = "";
	table.dealer_name = "";

	for (var i = 0; i < table.players.length; i++) {
		table.players[i].turn = false;
		table.players[i].open_close_selected_count = 0;
		table.players[i].declared = false;
		table.players[i].hand = [];
		table.players[i].gameFinished = false;
		table.players[i].turnFinished = false;
		table.players[i].is_grouped = false;
		table.players[i].is_player_finished = false;
		//table.players[i].is_joined_table = false;
		table.players[i].card_group1 = [];
		table.players[i].card_group2 = [];
		table.players[i].card_group3 = [];
		table.players[i].card_group4 = [];
		table.players[i].card_group5 = [];
		table.players[i].card_group6 = [];
		table.players[i].card_group7 = [];

		//table.players[i].status  = "available";
	}
}//clear_all_data_before_game_start ends 


function startGame(table_index, group, cards_six, roundno, bFirstRound) {
	var startingPlayerID;
	var startingPlayerName;
	var card1, card2;
	var query;
	var p1_handcards = []; var p2_handcards = []; var closecards = [];
	var opp_pl_name;
	room.tables[table_index].countdown_tcount = 5;
	var temp_click, temp_gender;
	var dealer_player_name;

	//as 2 players connected change table status from 'available' to 'unavailable'
	// room.tables[table_index].status = "unavailable";
	room.tables[table_index].round_id = group;
	//..console.log("table "+grpid+" status: "+room.tables[table_index].status+"\n");
	//as 2 players connected change player status from 'intable' to 'playing'
	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		if (room.tables[table_index].players[i].id == 0) {
			room.tables[table_index].players[i].status = "disconnected";
		}

		if (room.tables[table_index].players[i].status != "disconnected") {
			room.tables[table_index].players[i].status = "playing";
		} else {
			io.emit('player_disconnected_six', room.tables[table_index].players[i].name, group);
		}
		console.log("Player " + room.tables[table_index].players[i].name + " status: " + room.tables[table_index].players[i].status);
	}

	/*************** GAME RESTART CLEAR ALL DATA ***********/
	clear_all_data_before_game_start(room.tables[table_index]);
	/*************** GAME RESTART CLEAR ALL DATA ***********/

	//..console.log("Comparing random cards assigned to each player to Decide TURN"+"\n");
	var c1, c2, c3, c4, c5, c6;
	var card_arr_points = [];
	var card_arr_sub_id = [];
	var card_arr_name = [];
	var card_arr_path = [];
	var prev_card = 0;

	var cards_six_temp = [];
	cards_six_temp.push.apply(cards_six_temp, cards_without_joker_six);
	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		c1 = drawImages((shuffleImages(cards_six_temp)), 1, "", 1);
		if (i == 0) { prev_card = c1[0].points; }
		if (c1[0].points == prev_card) {
			c1 = drawImages((shuffleImages(cards_six_temp)), 1, "", 1);
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
	var max_card, last_card_index;
	for (var i = 1; i < card_arr_name.length; i++) {
		if (card_arr_name[i].suit == card_name) {
			if (i == (card_arr_name.length - 1)) {
				is_all_cards_with_same_name = true;
			}
			else { continue; }
		}
		else { is_all_cards_with_same_name = false; }
	}
	if (is_all_cards_with_same_name == false) {
		max_card = indexOfMax(card_arr_points);
		last_card_index = indexOfLast(card_arr_points);
		//console.log("\n --------- max_card if diff name ==> "+max_card);
		startingPlayerID = room.tables[table_index].players[max_card].id;
		startingPlayerName = room.tables[table_index].players[max_card].name;
		dealer_player_name = room.tables[table_index].players[last_card_index].name;
	}
	else {
		max_card = indexOfMax(card_arr_sub_id);
		last_card_index = indexOfLast(card_arr_sub_id);
		//console.log("\n --------- max_card if same name ==> "+max_card);	
		startingPlayerID = room.tables[table_index].players[max_card].id;
		startingPlayerName = room.tables[table_index].players[max_card].name;
		dealer_player_name = room.tables[table_index].players[last_card_index].name;
	}
	room.tables[table_index].startingPlayerID = startingPlayerID;
	room.tables[table_index].startingPlayerName = startingPlayerName;
	console.log("players b4 seq making function  " + room.tables[table_index].six_usernames.toString());
	room.tables[table_index].pl_seq_arr = getPlayerSequence(room.tables[table_index].six_usernames, startingPlayerName);

	//..console.log("\n startingPlayerID"+startingPlayerID+" -- name --"+startingPlayerName);	
	console.log("\n" + "Player " + startingPlayerName + " has TURN");
	console.log("\n" + "Player " + dealer_player_name + " is a Dealer.");
	room.tables[table_index].dealer_name = dealer_player_name;

	console.log('card_arr_path' + card_arr_path);

	////assign 13 hand cards to player 1 - player 6 --- (joined players )
	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		room.tables[table_index].players[i].hand = drawImages((shuffleImages(cards_six)), 13, "", 1);
		//console.log("\n"+"Player "+room.tables[table_index].players[i].name+" hand cards count "+ room.tables[table_index].players[i].hand.length);
		//console.log("Player  "+room.tables[table_index].players[i].name+" hand cards :"+JSON.stringify(room.tables[table_index].players[i].hand));
	}
	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		for (var j = 0; j < room.tables[table_index].players[i].hand.length; j++) {
			room.tables[table_index].players[i].hand_cards_id.push(room.tables[table_index].players[i].hand[j].id);
		}
	}
	////assign open card to both players
	var player1_opencard = drawImages((shuffleImages(cards_six)), 1, "", 1);
	//..console.log("\n"+"Assigned Open card is: "+player1_opencard[0].card_path+" id is: "+player1_opencard[0].id);
	var player_open_card_id = player1_opencard[0].id;
	room.tables[table_index].open_cards = player1_opencard;
	room.tables[table_index].open_card_obj_arr = [];
	room.tables[table_index].open_card_obj_arr.push(player1_opencard);
	room.tables[table_index].open_card_status = "initial";

	////assign joker card to both players
	var joker_card = drawImages((shuffleImages(cards_six)), 1, "", 1);
	//..console.log("Assigned Side-Joker card is: "+joker_card[0].card_path);
	room.tables[table_index].side_joker_card = joker_card[0].card_path;
	room.tables[table_index].side_joker_card_name = joker_card[0].name;
	var joker_qry = "SELECT * FROM cards where points = 0 or points = " + joker_card[0].points + " and id not in (" + joker_card[0].id + ")";
	if (joker_card[0].points == 0) {
		joker_qry = "SELECT * FROM cards where points = 0 or points = 14 and id not in (" + joker_card[0].id + ")";
	}
	con.query(joker_qry, function (er, result, fields) {
		    if(er){
				console.log(er);
			}else{
				joker_cards = [];
				joker_cards.push.apply(joker_cards, result);
				room.tables[table_index].joker_cards.push.apply(room.tables[table_index].joker_cards, joker_cards);
			}
	
	});

	var joker_qry1 = "SELECT * FROM cards where points = 0 ";
	con.query(joker_qry1, function (er, result, fields) {
		    if(er){
				console.log(er);
			}else{
		      room.tables[table_index].pure_joker_cards.push.apply(room.tables[table_index].pure_joker_cards, result);
			}
		
	});

	var close_card_count = 106 - 2 - 13 * room.tables[table_index].players.length;
	////assign closed cards to all 6  players
	var closed_cards = drawImages((shuffleImages(cards_six)), close_card_count, "", 1);
	//console.log("\n"+"Assigned closed cards count "+ closed_cards.length);
	//console.log("Assigned closed cards: ");
	for (var i = 0; i < closed_cards.length; i++) {
		closecards.push(closed_cards[i].id);
		room.tables[table_index].closed_cards_arr.push(closed_cards[i]);
	}
	// console.log("\n table close cards array "+JSON.stringify(room.tables[table_index].closed_cards_arr));
	//..console.log("\n"+"Inserting player and assigned card details to database."+"\n");

	//inserting player details and card details to database  

	/* Emitting players turn card and other details*/
	//..console.log("Emitting assigned card details to players. "+room.tables[table_index].players[0].name+","+room.tables[table_index].players[1].name+" with round id "+roundno+" and table id "+group);
	var player_names = [];
	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		player_names[i] = room.tables[table_index].players[i].name;
		room.tables[table_index].players[i].game_display_status = "Live";
		room.tables[table_index].players[i].freeturn = 0;

		room.tables[table_index].players[i].turnFinished = false;
		room.tables[table_index].players[i].gameFinished = false;
		room.tables[table_index].players[i].declared = false;
		room.tables[table_index].players[i].is_dropped_game = false;
		room.tables[table_index].players[i].is_grouped = false;
		room.tables[table_index].players[i].game_status = "";
		room.tables[table_index].players[i].game_score = 0;
		room.tables[table_index].players[i].amount_won = 0;
		room.tables[table_index].players[i].is_declared_valid_sequence = false;
		room.tables[table_index].players[i].extra_time = EXTRA_TIME;
	}

	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		if (room.tables[table_index].players[i].name === startingPlayerName) {
			room.tables[table_index].players[i].turn = true;
			if (room.tables[table_index].players[0].turn == true) { opp_pl_name = room.tables[table_index].players[1].name; }
			else { opp_pl_name = room.tables[table_index].players[0].name; }

			if (room.tables[table_index].players[i].status != "disconnected") {
				if (is_all_cards_with_same_name == false) { //card_arr_points
					io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card",
						{
							names: player_names, card_no: card_arr_points[i], card: card_arr_path[i], other_card_path: card_arr_path,
							other_card_no: card_arr_points, group_id: group, round_no: roundno, dealer: dealer_player_name, game_restart: room.tables[table_index].restart_game_six
						});
				}
				else {
					if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != ''){
					io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card",
						{
							names: player_names, card_no: card_arr_sub_id[i], card: card_arr_path[i], other_card_path: card_arr_path,
							other_card_no: card_arr_sub_id, group_id: group, round_no: roundno, dealer: dealer_player_name, game_restart: room.tables[table_index].restart_game_six
						});
					}
				}
                  if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != ''){
				   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("turn",
					{
						myturn: true, group_id: group, assigned_cards: room.tables[table_index].players[i].hand,
						opencard: player1_opencard[0].card_path, opencard_id: player_open_card_id,
						closedcards_path: room.tables[table_index].closed_cards_arr, closedcards: closed_cards,
						turn_of_user: startingPlayerName, opp_user: opp_pl_name,
						opencard1: player1_opencard, sidejoker: joker_card[0].card_path,
						open_close_pick_count: room.tables[table_index].players[i].open_close_selected_count,
						round_no: roundno
					});
				  }
                if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != ''){
				  io.sockets.connected[(room.tables[table_index].players[i].id)].emit('show_game_count', group, TOURNAMENT_ROUND_CNT - room.tables[table_index].gameCnt + 1, TOURNAMENT_ROUND_CNT);
				}
			
			}
		}
		else {
			room.tables[table_index].players[i].turn = false;
			if (room.tables[table_index].players[0].turn == true) { opp_pl_name = room.tables[table_index].players[1].name; }
			else { opp_pl_name = room.tables[table_index].players[0].name; }

			if (room.tables[table_index].players[i].status != "disconnected") {
				if (is_all_cards_with_same_name == false) {
					io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card",
						{
							names: player_names, card_no: card_arr_points[i], card: card_arr_path[i], other_card_path: card_arr_path,
							other_card_no: card_arr_points, group_id: group, round_no: roundno, dealer: dealer_player_name
						});
				}
				else {
					if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != ''){
					    io.sockets.connected[(room.tables[table_index].players[i].id)].emit("six_pl_turn_card",
						{
							names: player_names, card_no: card_arr_sub_id[i], card: card_arr_path[i], other_card_path: card_arr_path,
							other_card_no: card_arr_sub_id, group_id: group, round_no: roundno, dealer: dealer_player_name
						});
					}
				}
				
				
              if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != ''){
				   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("turn",
					{
						myturn: false, group_id: group, assigned_cards: room.tables[table_index].players[i].hand,
						opencard: player1_opencard[0].card_path, opencard_id: player_open_card_id,
						closedcards_path: room.tables[table_index].closed_cards_arr, closedcards: closed_cards,
						turn_of_user: startingPlayerName, opp_user: opp_pl_name,
						opencard1: player1_opencard, sidejoker: joker_card[0].card_path, sidejokername: joker_card[0].name,
						open_close_pick_count: room.tables[table_index].players[i].open_close_selected_count,
						round_no: roundno
					});
			  }


                if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != ''){
				    io.sockets.connected[(room.tables[table_index].players[i].id)].emit('show_game_count', group, TOURNAMENT_ROUND_CNT - room.tables[table_index].gameCnt + 1, TOURNAMENT_ROUND_CNT);
			    }
			
			}
		}
	}//turn card for 

	//set 5 seconds delay then emit turn timer after cards distributed to both players 
	/*
	if (bFirstRound) {
		room.tables[table_index].no_of_live_players = get_remaining_no_of_playing_players(group);
		emitTurnTimerSix(startingPlayerID, startingPlayerName, group, room.tables[table_index].six_player_timer_array[1], false, roundno, pl_seq_arr);
	} else*/ {

		room.tables[table_index].countdown_timer = setInterval(function () {
			room.tables[table_index].countdown_tcount--;
			if (room.tables[table_index].countdown_tcount == 0) {
				clearInterval(room.tables[table_index].countdown_timer);
				room.tables[table_index].no_of_live_players = get_remaining_no_of_playing_players(group);
				console.log("1189  no_of_live_players " + room.tables[table_index].no_of_live_players);
				emitTurnTimerSix(room.tables[table_index].startingPlayerID, room.tables[table_index].startingPlayerName, group, room.tables[table_index].six_player_timer_array[1], false,
					room.tables[table_index].round_id, room.tables[table_index].pl_seq_arr);
			}
		}, 1000);
	}
}


function get_remaining_no_of_playing_players(group) {
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n get_remaining_no_of_playing_players");
		return;
	}
	var status;
	var live_players = 0;
	for (var i = 0; i < room.tables[table_index].players.length; i++) {
		status = room.tables[table_index].players[i].game_display_status;
		if (status == "Live") {
			live_players++;
		}
	}
	return live_players;
}


function getPlayerSequence(player_name_array, startingPlayerName) {
	var player_name_arr = [];
	var player_name_arr_temp = [];
	player_name_arr.push.apply(player_name_arr, player_name_array);

	for (var i = 0; i < player_name_arr.length;) {
		if (player_name_arr[i] != startingPlayerName) {

			player_name_arr_temp.push(player_name_arr[i]);
			index = i;
			if (index != -1) {
				player_name_arr.splice(index, 1);
			}
		}
		else {
			i++
			break;
		}
	}
	player_name_arr.push.apply(player_name_arr, player_name_arr_temp);

	//console.log("\n $$$$$$$$$$$$$$$$$$$$$$$$$$$$ PLAYER NAMES SEQUENCE ARRAY -----"+JSON.stringify(player_name_arr));
	return player_name_arr;
}//getPlayerSequence ends
var first_player_count_six = 1;
var second_player_count_six = 1;
//// showing timer alternate to players ////
function emitTurnTimerSix(pl_id, name, group, timer, is_discard, roundid, pl_seq_arr) {
	//console.log("Emitting Timer with turn to table : "+group+" for round id "+roundid); 
	console.log("\n Turn of Player : " + name);

	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n emitTurnTimerSix Failed");
		return;
	}
	room.tables[table_index].is_finish = false;
	//..console.log("\n IN EMIT TIMER FUNCTION table.players.length  : "+room.tables[table_index].players.length); 
	if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
		room.tables[table_index].turnTimer = setInterval(function () {
			var player_id = pl_id;
			var opp_player_id;
			var opp_player;
			var is_discard = false;
			var is_finished_game = false;
			var is_declared = false;
			var is_dropped = false;
			var game_round_id = roundid;
			var turn_player_status, opp_player_status;
			var opp_player_amount = 0;
			var is_player_grouped = false;
			var go_to_final_timer = false;
			var next_turn_player;
			var game_status;
			var extra_time = 0;

			var table_index = getTableIndex(room.tables, group);
			if (table_index == - 1) {
				console.log("\n emitTurnTimer_pool");
				return;
			}
			////if player was disconected and get re-connected  ////
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				if (room.tables[table_index].players[i].player_reconnected == true) {
					//console.log(" \n player re-connected "+room.tables[table_index].players[i].name);
					if ((room.tables[table_index].players[i].status) == "playing") {
						// room.tables[table_index].players[i].id = room.tables[table_index].players[i].id;
						// if ((room.tables[table_index].players[i].is_turn) == true) { player_id = room.tables[table_index].players[i].id; }
					}
				}
			}

			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				if (room.tables[table_index].players[i].freeturn >= 3) {
					drop_game_six_func(room.tables[table_index].players[i].name, group, game_round_id);
					room.tables[table_index].players[i].freeturn = 0;
				}
			}

			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				if (room.tables[table_index].players[i].name == name) {
					room.tables[table_index].players[i].is_turn = true;

					extra_time = room.tables[table_index].players[i].extra_time;

					is_finished_game = room.tables[table_index].players[i].gameFinished;
					if (is_finished_game == true) {
						room.tables[table_index].players[i].is_player_finished = true;
					}

					is_discard = room.tables[table_index].players[i].turnFinished;
					is_declared = room.tables[table_index].players[i].declared;
					is_dropped = room.tables[table_index].players[i].is_dropped_game;
					turn_player_status = room.tables[table_index].players[i].status;
					is_player_grouped = room.tables[table_index].players[i].is_grouped;
					game_status = room.tables[table_index].players[i].game_status;
				}
				else {
					room.tables[table_index].players[i].is_turn = false;
				}
			}


			//..console.log("\n turn of player ---> "+name);
			//console.log("\n pl_seq_arr ---> "+JSON.stringify(pl_seq_arr));
			next_turn_player = next_turn_of_player(group, name, pl_seq_arr);

			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				//emit timer to player who has TURN
				if (room.tables[table_index].players[i].name == name) {
					if (turn_player_status != "disconnected") {
						player_id = room.tables[table_index].players[i].id; // ANDY
						if (io.sockets.connected[player_id]) {
							io.sockets.connected[player_id].emit("timer_six",
								{
									id: player_id, myturn: true, turn_of_user: name, group_id: group, game_timer: timer, extra_time: extra_time, is_discard: is_discard,
									round_id: game_round_id, is_declared: is_declared, is_dropped: is_dropped, is_poolpoint: false
								});
						}
					}
				}
				else //emit timer to player who DON'T have TURN
				{
					opp_player_id = room.tables[table_index].players[i].id; // ANDY
					if (is_finished_game == true) {
						room.tables[table_index].is_finish = true;
						timer = room.tables[table_index].six_player_timer_array[2];
						extra_time = 0;
						console.log("finished " + opp_player_id);
					}
					else {
						opp_player_status = room.tables[table_index].players[i].status;
						opp_player_amount = room.tables[table_index].players[i].amount_playing;
					}
					if (opp_player_status != "disconnected") {
						if (io.sockets.connected[opp_player_id]) {
							io.sockets.connected[opp_player_id].emit("timer_six",
								{
									id: opp_player_id, myturn: false, turn_of_user: name, group_id: group, game_timer: timer, extra_time: extra_time,
									is_discard: is_discard, round_id: game_round_id, is_declared: is_declared, is_dropped: is_dropped, is_poolpoint: false
								});
						}
					}
				}
			}

			is_finished_game = false;
			//6-pl-change
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				room.tables[table_index].players[i].gameFinished = false;
			}

			if (timer > 0) {
				timer--;
			} else {
				extra_time = 0;
				if (room.tables[table_index].is_finish == false) {
					for (var i = 0; i < room.tables[table_index].players.length; i++) {
						if (room.tables[table_index].players[i].name == name) {
							if (room.tables[table_index].players[i].extra_time > 0) {
								room.tables[table_index].players[i].extra_time--;
								extra_time = room.tables[table_index].players[i].extra_time;
							}
						}
					}
				}
			}

			if (is_dropped == true || is_declared == true) {
				//if(room.tables[table_index].no_of_live_players==1 || game_status == "Won")
				console.log("\n no of live players in turn timer " + room.tables[table_index].no_of_live_players);
				if (game_status == "Won" && room.tables[table_index].no_of_live_players >= 0) {
					console.log("\n start final timer.............");
					go_to_final_timer = true;
				}
				else {
					removePlayerFromTurnSequence(pl_seq_arr, name);
				}
			}
			if (is_discard == true || is_declared == true || is_dropped == true) {
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					if (room.tables[table_index].players[i].name == name) {
						room.tables[table_index].players[i].freeturn = 0;
					}
				}
				timer = 0;
				extra_time = 0;
			}
			if (timer == 0 && extra_time == 0) {

				//6-pl-change
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					if (room.tables[table_index].players[i].name == name) {
						if (is_declared == false && is_dropped == false) {

							room.tables[table_index].players[i].turn_count++;
							room.tables[table_index].isfirstTurn = false;
							//..console.log("\n  player "+name+" turn count ---> "+room.tables[table_index].players[i].turn_count);
						}
					}
				}

				if (room.tables[table_index].is_finish == true && is_declared == false) {
					//go_to_final_timer = true;
					go_to_final_timer = declare_game_data_six(name, group, game_round_id, opp_player_amount, false, is_player_grouped, false, room.tables[table_index].table_point_value, room.tables[table_index].game_type, room.tables[table_index].table_name);

					is_declared = true;
				}

				//6-pl-change
				if (is_discard == false && is_declared == false && is_dropped == false && room.tables[table_index].is_finish == false) {
					for (var j = 0; j < room.tables[table_index].players.length; j++) {
						if (room.tables[table_index].players[j].name == name) {

							if (room.tables[table_index].players[j].open_close_selected_count == 1)
								return_open_card_six(j, player_id, name, group, game_round_id, room.tables[table_index].players[j].hand, room.tables[table_index].temp_open_object, turn_player_status);

							room.tables[table_index].players[j].freeturn++;
						}
					}
				}
				is_discard = false;
				is_finished_game = false;

				//6-pl-change
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					if (room.tables[table_index].players[i].is_turn == true) {
						room.tables[table_index].players[i].is_turn = false;
					}
					room.tables[table_index].players[i].turnFinished = false;
					room.tables[table_index].players[i].gameFinished = false;
				}

				clearInterval(room.tables[table_index].turnTimer);
				room.tables[table_index].turnTimer = 0;

				/** IMP**/					 //CHECK IF NEEDED THEN DO CHANGES HERE 
				//6-pl-change

				// console.log("\n Turn to Next Player : "+opp_player+" - go_to_final_timer - "+go_to_final_timer); 
				if (go_to_final_timer != true) {
					timer = room.tables[table_index].timer_array[1];
					opp_player = next_turn_player;
					for (var i = 0; i < room.tables[table_index].players.length; i++) {
						if (room.tables[table_index].players[i].name == next_turn_player) {
							opp_player_id = room.tables[table_index].players[i].id;
							opp_player_status = room.tables[table_index].players[i].status;
							opp_player_amount = room.tables[table_index].players[i].amount_playing;
						}
					}
					//..console.log("\n Six Player game NOT DECLARED SO TIMER 10/30 ");
					emitTurnTimerSix(opp_player_id, opp_player, group, timer, false, game_round_id, pl_seq_arr);
				}
				else {
					//console.log("\n Six Player game DECLARED SO TIMER 15/45 ");
					//console.log(" \n room.tables[table_index].no_of_live_players ---- when emit final timer "+room.tables[table_index].no_of_live_players);
					//do changes here 			
					//room.tables[table_index].no_of_live_players = get_remaining_no_of_playing_players(group);
					console.log("\n ------------------" + room.tables[table_index].no_of_live_players);
					console.log("\n ---- room.tables[table_index].game_finished_status---" + room.tables[table_index].game_finished_status);
					//if(room.tables[table_index].no_of_live_players == 1 && game_status == "Won")
					if (room.tables[table_index].no_of_live_players <= 1 && game_status == "Won" && room.tables[table_index].game_finished_status == true) {
						console.log(" \n -----in if --------");
						emitFinalTimerSix(player_id, name, group, room.tables[table_index].six_player_timer_array[2], false, game_round_id, opp_player_amount, name);
					}
					else {
						console.log(" \n -----in else  --------");
						/*
						for (var i = 0; i < room.tables[table_index].players.length; i++) {
							if (room.tables[table_index].players[i].name != name)//&& room.tables[table_index].players[i].game_display_status == "Live"
							{
								emitFinalTimerSix(room.tables[table_index].players[i].id, room.tables[table_index].players[i].name, group, room.tables[table_index].six_player_timer_array[2], false, game_round_id, opp_player_amount, name);
							}
						}*/
						emitFinalTimerSix(player_id, name, group, room.tables[table_index].six_player_timer_array[2], false, game_round_id, opp_player_amount, name);
					}
				}
			}
		}, 1000);
	}
}// emitTurnTimerSix() ends 

function next_turn_of_player(tableid, turn_player_name, player_sequence_array) {
	var table_index = 0;
	table_index = getTableIndex(room.tables, tableid);
	if (table_index == - 1) {
		console.log("\n next_turn_of_player");
		return;
	}
	var next_turn_of_player_index;
	var next_turn_of_player;
	for (var i = 0; i < player_sequence_array.length; i++) {
		if (player_sequence_array[i] == turn_player_name) {
			if (i == (player_sequence_array.length - 1)) {
				next_turn_of_player = player_sequence_array[0];
				//next_turn_of_player_index = 0;
			}
			else {
				next_turn_of_player = player_sequence_array[i + 1];
				//next_turn_of_player_index = i+1;
			}
		}
	}
	//return next_turn_of_player_index;
	return next_turn_of_player;
}

function removePlayerFromTurnSequence(player_sequence_array, playername) {
	var index = -1;
	for (var i = 0; i < player_sequence_array.length; i++) {
		if (player_sequence_array[i] === playername) {
			index = i;
			break;
		}
	}
	if (index != -1) { player_sequence_array.remove(index); }
}

function return_open_card_six(pl_index, pl_id, pl_name, pl_group, round_id, pl_hand_cards, temp_open_object, player_status) {
	//..console.log("\n AUTO DISCARD in Six player game ");
	var pl_grp_arr = [];
	var table_index = 0;
	table_index = getTableIndex(room.tables, pl_group);
	if (table_index == - 1) {
		console.log("\n return_open_card_six");
		return;
	}
	var all_player_status;

	if (room.tables[table_index].players[pl_index].is_grouped != true) {
		pl_hand_cards = removeFromHandCards(pl_hand_cards, temp_open_object.id);
		//send updated hand cards 
		if (player_status != "disconnected") {
			if(room.tables[table_index].players[pl_index].id && room.tables[table_index].players[pl_index].id != ''){
			io.sockets.connected[(room.tables[table_index].players[pl_index].id)].emit("update_hand_cards_six",
				{ user: pl_name, group: pl_group, round_id: round_id, hand_cards: pl_hand_cards, sidejokername: room.tables[table_index].side_joker_card_name });
		
		    }
		}
	}
	else {
		//get_player_groups
		pl_grp_arr = get_player_groups(pl_index, pl_group);
		for (var n = 0; n < pl_grp_arr.length; n++) {
			removeFromSortedHandCards(pl_grp_arr[n], temp_open_object.id, 0);
		}
		if (player_status != "disconnected") {
			if(room.tables[table_index].players[pl_index].id && room.tables[table_index].players[pl_index].id != ''){
			    io.sockets.connected[(room.tables[table_index].players[pl_index].id)].emit("update_player_groups_six",
				{ user: pl_name, group: pl_group, round_id: round_id, grp1_cards: room.tables[table_index].players[pl_index].card_group1, grp2_cards: room.tables[table_index].players[pl_index].card_group2, grp3_cards: room.tables[table_index].players[pl_index].card_group3, grp4_cards: room.tables[table_index].players[pl_index].card_group4, grp5_cards: room.tables[table_index].players[pl_index].card_group5, grp6_cards: room.tables[table_index].players[pl_index].card_group6, grp7_cards: room.tables[table_index].players[pl_index].card_group7, sidejokername: room.tables[table_index].side_joker_card_name });
		    }
		}
	}
	room.tables[table_index].open_card_obj_arr = [];
	room.tables[table_index].open_card_obj_arr.push(temp_open_object);
	room.tables[table_index].open_cards.push(temp_open_object);
	room.tables[table_index].open_card_status = "discard";

	room.tables[table_index].players[pl_index].open_close_selected_count = 0;
	for (var j = 0; j < room.tables[table_index].players.length; j++) {
		all_player_status = room.tables[table_index].players[j].status;
		if (all_player_status != "disconnected") {
			
			if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != ''){
			   io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_card_six",
				{
					path: temp_open_object.card_path, check: true, id: temp_open_object.id, discareded_open_card: temp_open_object,
					group: pl_group, round_id: round_id, discard_open_cards: room.tables[table_index].open_cards
				});
			}
		}
	}
}//return_open_card_six() ends

function emitFinalTimerSix(pl_id, name, group, final_timer, is_discard, roundid, opp_player_amount, declared_user) {
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n emitFinalTimerSix");
		return;
	}

	if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {

		room.tables[table_index].finalTimer = setInterval(function () {
			var player_id = pl_id;
			var is_discard = false;
			var is_declared = false;
			var is_dropped = false;
			var game_round_id = roundid;
			var turn_player_status;
			var is_player_grouped = false;
			var isAllFinished;

			var table_index = getTableIndex(room.tables, group);
			if (table_index == - 1) {
				console.log("\n emitFinalTimerSix");
				return;
			}
			console.log("\n emitting final timer  " + final_timer + " to player " + name);
			isAllFinished = true;
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				if (room.tables[table_index].players[i].name != name) {
					player_id = room.tables[table_index].players[i].id;
					is_declared = room.tables[table_index].players[i].declared;
					is_dropped = room.tables[table_index].players[i].is_dropped_game;
					turn_player_status = room.tables[table_index].players[i].status;
					is_player_grouped = room.tables[table_index].players[i].is_grouped;

					console.log("Player " + room.tables[table_index].players[i].name + " isDeclared " + is_declared + " Dropped " + is_dropped);
					isAllFinished = isAllFinished && (is_declared || is_dropped);

					if (turn_player_status != "disconnected") {
						if (io.sockets.connected[player_id]) {
							if (!(is_declared || is_dropped)) {
								io.sockets.connected[player_id].emit("declared_six",
									{
										user: room.tables[table_index].players[i].name, group: group, round_id: game_round_id,
										declared_user: declared_user, declare: room.tables[table_index].declared
									});
							}
							io.sockets.connected[player_id].emit("timer_six",
								{
									id: player_id, myturn: true, turn_of_user: room.tables[table_index].players[i].name, group_id: group, game_timer: final_timer,
									is_discard: is_discard, round_id: game_round_id, is_declared: is_declared, is_dropped: is_dropped, is_poolpoint: false
								});
						}
					}
				}
			}

			/** Auto declare if player get disconnected **/
			/*
			if (is_dropped == false) {
				if (is_declared == false && turn_player_status == "disconnected") {
					declare_game_data_six(name, group, game_round_id, opp_player_amount, false, is_player_grouped, false, room.tables[table_index].table_point_value, room.tables[table_index].game_type, room.tables[table_index].table_name);
					is_declared = true;
				}
			}*/
			/** Auto declare if player get disconnected **/

			final_timer--;
			console.log("\n  in final timer ---> player " + name + " is_declared " + is_declared);
			if (isAllFinished) {
				final_timer = 0;
			}
			if (final_timer == 0) {

				clearInterval(room.tables[table_index].finalTimer);

				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					if (room.tables[table_index].players[i].name != name) {
						is_declared = room.tables[table_index].players[i].declared;
						is_dropped = room.tables[table_index].players[i].is_dropped_game;
						is_poolpoint = room.tables[table_index].players[i].poolamount_playing <= 0 ? true : false;
						is_player_grouped = room.tables[table_index].players[i].is_grouped;
						if (is_dropped == false && is_declared == false) {
							declare_game_data_six(room.tables[table_index].players[i].name, group, game_round_id, opp_player_amount, false, is_player_grouped, false, room.tables[table_index].table_point_value, room.tables[table_index].game_type, room.tables[table_index].table_name);
						}
					}
				}
				console.log("........ GAME FINISHED ........." + room.tables[table_index].game_finished_status);

				if (room.tables[table_index].game_finished_status == true) {

					room.tables[table_index].gameCnt--;
					console.log("........ GAME FINISHED .........");
					console.log(room.tables[table_index].six_usernames);

					room.tables[table_index].status = "available";

					for (var i = 0; i < room.tables[table_index].six_usernames.length; i++) {
						var idx = room.tables[table_index].getPlayerIdxFromName(room.tables[table_index].six_usernames[i]);
						if (idx != -1) {
							room.tables[table_index].players[idx].declared = false;
							room.tables[table_index].players[idx].is_dropped_game = false;
							room.tables[table_index].players[idx].game_display_status = "Live";
							room.tables[table_index].players[idx].turn_count = 0;
							room.tables[table_index].players[idx].game_declared_status = "Invalid";
							room.tables[table_index].six_player_amount[i] = room.tables[table_index].players[idx].amount_playing;
						}
					}

					for (var idx = 0; idx < room.tables[table_index].players.length; idx++) {
						if ((room.tables[table_index].players[idx].status != "disconnected")) {
							if(room.tables[table_index].players[idx].id && room.tables[table_index].players[idx].id != ''){
							   io.sockets.connected[(room.tables[table_index].players[idx].id)].emit("game_finished_six",
								{
									user: room.tables[table_index].six_usernames, group: group, round_id: game_round_id,
									amount: room.tables[table_index].six_player_amount,
									joined: 0
								});
							}
						}
					}

					if (room.tables[table_index].gameCnt > 0) {
						room.tables[table_index].game_declare_status = "Invalid";
						room.tables[table_index].activity_timer_set = false;
						room.tables[table_index].game_finished_status = false;
						room.tables[table_index].game_calculation_done = false;

						room.tables[table_index].isfirstTurn = true;

						setTimeout(function () {
							con.query("SELECT * FROM `cards`", function (err1, rows, fields1) {
								if(err1){
									console.log(err1);
								}else{
									var table_index = getTableIndex(room.tables, group);
									var cards_six = [];
									cards_six.push.apply(cards_six, rows);
									var tableId = room.tables[table_index].id;
									var tournamentId = room.tables[table_index].tournamentId;
									random_group_roundno = Math.floor(100000000 + Math.random() * 900000000);//6-digit-no
									io.emit('tournament_gamestart', tournamentId);
									startGame(table_index, tableId, cards_six, random_group_roundno, true);
								}
							});
						}, 3000);
					} else { // 6 game end
						room.tables[table_index].status = GAME_STATUS_END;
						setWinnerToNextStage(room.tables[table_index].tournamentId, table_index);

						gotoNextStage(room.tables[table_index].tournamentId);
					}
				}

			}
		}, 1000);
		//room.tables[table_index].six_usernames = [];
	}
}//emitFinalTimerSix ends 


function drop_game_six_func(dropped_player, group, round_id) {
	//var dropped_player = data.user_who_dropped_game;

	console.log("\n ***** GAME DROPPED by player " + dropped_player);

	//var group = data.group;
	//var round_id = data.round_id;
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n drop_game_six");
		return;
	}

	var dt = KolkataTime();
	var won_player;
	var won_player_grouped = false;
	var won_player_index = 0;
	var dropped_player_grouped = false;
	var dropped_pl_score = 0, opp_pl_score = 0;
	var dropped_pl_won_amount = 0, opp_pl_won_amount = 0;
	var temp_score = 0;
	var score = 0;
	var player_status, all_player_status;
	var player_grouped = false;
	var player_name_array = [];
	var player_group_status_array = [];
	var player_final_card_groups_array = [];
	var player_card_groups_array = [];
	var player_score_array = [];
	var player_won_amount_array = [];
	var is_player_grouped_temp = false;
	var winner_won_amount = 0;
	var company_commision_amount = 0;
	var table_player_capacity = 0;
	table_player_capacity = room.tables[table_index].playerCapacity;
	//..console.log("\n dropped user "+dropped_player+" did sorting "+is_sorted+" initial grouping "+is_initial_grouped+" grouping "+is_grouped);

	//if (room.tables[table_index].round_id == round_id) {
	if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
		for (var i = 0; i < room.tables[table_index].players.length; i++) {
			player_status = room.tables[table_index].players[i].status;
			if (room.tables[table_index].players[i].name == dropped_player) {
				//..console.log("\n game dropped  by "+dropped_player+" so 1st / 2nd drop - turn count  "+room.tables[table_index].players[i].turn_count);
				room.tables[table_index].players[i].is_dropped_game = true;
				dropped_player_grouped = room.tables[table_index].players[i].is_grouped;
				room.tables[table_index].players[i].game_status = "Lost";
				room.tables[table_index].players[i].game_display_status = "dropped";

				room.tables[table_index].players[i].turn_count++;

				room.tables[table_index].isfirstTurn = false;

				if ((room.tables[table_index].players[i].turn_count) == 1) { temp_score = 20; }
				else if ((room.tables[table_index].players[i].turn_count) > 1) { temp_score = 40; }

				room.tables[table_index].players[i].game_score = temp_score;
				room.tables[table_index].players[i].amount_won = getFixedNumber(-(+((temp_score * room.tables[table_index].table_point_value))));
				room.tables[table_index].players[i].amount_won_db = getFixedNumber(+((temp_score * room.tables[table_index].table_point_value)));
				room.tables[table_index].players[i].amount_playing = getFixedNumber(+(room.tables[table_index].players[i].amount_playing - (temp_score * room.tables[table_index].table_point_value)));

				//no_of_live_players = get_remaining_no_of_playing_players(group);
				//..console.log("\n in drop game no of live players before drop "+room.tables[table_index].no_of_live_players);
				room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players) - 1;
				console.log("1801  no_of_live_players " + room.tables[table_index].no_of_live_players);
				//..console.log("\n AFTER  no of live players before drop "+room.tables[table_index].no_of_live_players);
				//CHECK NO OF PLAYERS STILL REM(LIVE) ACCORDING TO GET FOLLOWING STATUS
				if (room.tables[table_index].no_of_live_players == 1) {
					room.tables[table_index].game_finished_status = true;
					//check index of live player and assign to j and end game as did in 2-pl-game
					for (var j = 0; j < room.tables[table_index].players.length; j++) {
						if (room.tables[table_index].players[j].game_display_status == "Live") {
							room.tables[table_index].players[j].is_dropped_game = true;
							room.tables[table_index].players[j].game_status = "Won";
							won_player = room.tables[table_index].players[j].name;
							won_player_grouped = room.tables[table_index].players[j].is_grouped;
							won_player_index = j;
						}
					}

					//do calculation of score and display popups
					for (var j = 0; j < room.tables[table_index].players.length; j++) {
						// if (room.tables[table_index].players[j].game_display_status == "dropped") 
						{
							//console.log("\n drop 1st / 2nd - turn count  "+room.tables[table_index].players[j].turn_count);
							console.log("\n --------- before calculate of player " + room.tables[table_index].players[j].name + "  amount_playing   " + room.tables[table_index].players[j].amount_playing);
							temp_score = room.tables[table_index].players[j].game_score;
							score = score + parseInt(temp_score);
							console.log("\n --------- after calculate  of player " + room.tables[table_index].players[j].name + "  amount_playing   " + room.tables[table_index].players[j].amount_playing);
						}
					}

					console.log("\n winnner " + room.tables[table_index].players[won_player_index].name
						+ " before calculate amount_playing   " + room.tables[table_index].players[won_player_index].amount_playing);

					room.tables[table_index].players[won_player_index].game_score = 0;
					room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+(score));
					room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+(score));
					room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing + score)));
					winner_won_amount = room.tables[table_index].players[won_player_index].amount_won;

					console.log("\n after  calculate winnner amount_playing   " + room.tables[table_index].players[won_player_index].amount_playing);

					transaction_id = Math.floor(Math.random() * 100000000000000);
					room.tables[table_index].players_names = [];
					room.tables[table_index].players_amounts = [];
					room.tables[table_index].players_user_id = [];
					room.tables[table_index].players_final_status = [];
					//--------------
					for (var j = 0; j < room.tables[table_index].players.length; j++) {
						all_player_status = room.tables[table_index].players[j].status;
						// if (all_player_status != "disconnected") 
						{
							/** Players Names**/
							room.tables[table_index].players_names[j] = room.tables[table_index].players[j].name;
							/** Players amount playing (virtual)**/
							room.tables[table_index].players_amounts[j] = room.tables[table_index].players[j].amount_playing;
							/** Players User Id**/
							room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
							/** Players game status**/
							if (room.tables[table_index].players[j].name == won_player) {
								room.tables[table_index].players_final_status[j] = "Won";
							}
							else {
								room.tables[table_index].players_final_status[j] = "Lost";
								insert_query3 = "insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values(" + room.tables[table_index].players[j].user_id + "," + transaction_id + ",'" + room.tables[table_index].game_type + "','" + chip_type + "','" + room.tables[table_index].id + "','" + room.tables[table_index].table_name + "','" + room.tables[table_index].round_id + "','" + room.tables[table_index].players[j].name + "','" + room.tables[table_index].players[j].game_status + "','" + (score) + "','" + dt + "')";
								console.log(insert_query3);
								con.query(insert_query3, function (err1, result) {
                                if(err1){
									console.log(err1);
								}
                                
									});
							}
						}
					}
					console.log("\n VIRTUAL DATA NEEDED WHILE RESTART ");
					console.log("\n player_name_array " + JSON.stringify(room.tables[table_index].players_names));
					console.log("\n player_group_status_array " + JSON.stringify(room.tables[table_index].players_final_status));
					console.log("\n player_user_id_array " + JSON.stringify(room.tables[table_index].players_user_id));
					console.log("\n player_won_amount_array " + JSON.stringify(room.tables[table_index].players_amounts));

					//--------------


					/**** Inserting Transaction Details to database once game end/restarted ****/
					/*for (var i = 0; i < room.tables[table_index].players.length; i++)
					{
						insert_query="insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[i].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[i].name+"','"+room.tables[table_index].players[i].game_status+"','"+(score * room.tables[table_index].table_point_value)+"','"+dt+"')";
						console.log(insert_query);
						con.query(insert_query, function(err1, result){}); 
					}*/
					/*For winning amount */
					insert_query = "insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values(" + room.tables[table_index].players[won_player_index].user_id + "," + transaction_id + ",'" + room.tables[table_index].game_type + "','" + chip_type + "','" + room.tables[table_index].id + "','" + room.tables[table_index].table_name + "','" + room.tables[table_index].round_id + "','" + room.tables[table_index].players[won_player_index].name + "','" + room.tables[table_index].players[won_player_index].game_status + "','" + winner_won_amount + "','" + dt + "')";
					console.log(insert_query);
					con.query(insert_query, function (err1, result) {
                        if(err1){
									console.log(err1);
						}
					});
					/*For Lost amount */

					update_game_details_func(table_index);

					for (var j = 0; j < room.tables[table_index].players.length; j++) {
						all_player_status = room.tables[table_index].players[j].status;
						if (all_player_status != "disconnected") {
							player_name_array = [];
							//player_card_groups_array=[];
							player_final_card_groups_array = [];
							player_score_array = [];
							player_won_amount_array = [];
							player_group_status_array = [];
							for (var k = 0; k < room.tables[table_index].players.length; k++) {
								player_name_array.push(room.tables[table_index].players[k].name);
								player_grouped = room.tables[table_index].players[k].is_grouped;
								player_group_status_array.push(player_grouped);
								player_card_groups_array = [];
								is_player_grouped_temp = false;
								if (player_grouped == false) {
									is_player_grouped_temp = false;
									player_card_groups_array.push.apply(player_card_groups_array, room.tables[table_index].players[k].hand);
									//console.log("\n player_card_groups_array  push.apply "+JSON.stringify(player_card_groups_array));
									//player_card_groups_array = [];
									//player_card_groups_array.push(room.tables[table_index].players[k].hand);
									//console.log("\n player_card_groups_array  only push "+JSON.stringify(player_card_groups_array));
									//break;
								}
								else {
									is_player_grouped_temp = true;
									//if(room.tables[table_index].players[k].card_group1.length>0)
									{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1); }
									//if(room.tables[table_index].players[k].card_group2.length>0)
									{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2); }
									//if(room.tables[table_index].players[k].card_group3.length>0)
									{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3); }
									//if(room.tables[table_index].players[k].card_group4.length>0)
									{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4); }
									//if(room.tables[table_index].players[k].card_group5.length>0)
									{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5); }
									//if(room.tables[table_index].players[k].card_group6.length>0)
									{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6); }
									//if(room.tables[table_index].players[k].card_group7.length>0)
									{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7); }

									/*player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].card_group1);
									player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].card_group2);
									player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].card_group3);
									player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].card_group4);
									player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].card_group5);
									player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].card_group6);
									player_card_groups_array.push.apply(player_card_groups_array,room.tables[table_index].players[k].card_group7);*/
								}
								player_final_card_groups_array.push(player_card_groups_array);
								// if(is_player_grouped_temp == false)
								// {
								// 	player_final_card_groups_array.push(player_card_groups_array);
								// }
								// else
								// {
								// 	player_final_card_groups_array.push.apply(player_final_card_groups_array,player_card_groups_array);	
								// }
								player_score_array.push(room.tables[table_index].players[k].game_score);
								player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
							}//inner-for ends 

							//break;
							//  	console.log("\n player_name_array "+JSON.stringify(player_name_array));
							// console.log("\n player_group_status_array "+JSON.stringify(player_group_status_array));
							// console.log("\n player_final_card_groups_array "+JSON.stringify(player_final_card_groups_array));
							// console.log("\n player_score_array "+JSON.stringify(player_score_array));
							// console.log("\n player_won_amount_array "+JSON.stringify(player_won_amount_array));
                            if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != ''){
							    io.sockets.connected[(room.tables[table_index].players[j].id)].emit("dropped_game_six",
								{
									players: player_name_array, declared: 2, group: group, winner: won_player,
									group_status: player_group_status_array, players_cards: player_final_card_groups_array,
									players_score: player_score_array, players_amount: player_won_amount_array
								});
							}
								
						}//disconnect
					}//outer-for
				}//only-1-live-player-so-game-ends
				else {
					//if (player_status != "disconnected") 
					{
						io.emit('player_dropped_game', dropped_player, group);
					}
				}
			}
		}//for
	}
	//}//same-table-round-id	
}

function declare_game_data_six(declared_player, group, round_id, pl_amount_taken, is_sort, is_group, is_initial_group, table_point_value, game_type) {
	var declared_user = declared_player;
	var group = group;
	var round_id = round_id;
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n declare_game_data_six");
		return;
	}

	var dt = KolkataTime();
	var table_game = room.tables[table_index].table_game;
	var group_count = 0;
	var is_pure_valid = false;
	var is_sub_valid = false;
	var is_3rd_valid = false;
	var is_pure = 0;
	var is_sub_sequence = 0;
	var is_3rd_sequence = 0;
	var is_invalid = 0;
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
	var company_commision_amount = 0;
	var player_status, all_player_status, player_game_status;
	var table_player_capacity = 0;
	var retValid = false;
	table_player_capacity = room.tables[table_index].playerCapacity;


	//if (room.tables[table_index].round_id == round_id) 
	{
		if (room.tables[table_index].declared == 0) {
			room.tables[table_index].declared = 1;
		}
		else if (room.tables[table_index].declared == 1 && room.tables[table_index].game_declare_status == "Valid") {
			room.tables[table_index].declared = 2;
		}
		if (room.tables[table_index].declared == 1) {
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				player_status = room.tables[table_index].players[i].status;

				if (room.tables[table_index].players[i].name == declared_user) {
					room.tables[table_index].players[i].declared = true;

					declared_groups_array = [];
					group_count = get_player_group_count(i, group);
					if (group_count == 0) {
						room.tables[table_index].is_declared_valid_sequence = false;
					}//invalid
					else {
						if (!valid.validateGroupLimit(group_count)) {
							//console.log("\n\n declared_groups_array of p1 --> "+JSON.stringify(declared_groups_array)
							//+"--- arr count --"+declared_groups_array.length); 
							for (var n = 0; n < declared_groups_array.length; n++) {
								is_pure_valid = valid.validatePureSequence(declared_groups_array[n], room.tables[table_index].pure_joker_cards, club_suit_cards, spade_suit_cards, heart_suit_cards, diamond_suit_cards, room.tables[table_index].joker_cards);
								if (!is_pure_valid) {
									is_sub_valid = valid.validateSubSequence(declared_groups_array[n], room.tables[table_index].joker_cards, club_suit_cards, spade_suit_cards, heart_suit_cards, diamond_suit_cards);
									if (!is_sub_valid) {
										is_3rd_valid = valid.validateSameCardSequence(declared_groups_array[n], room.tables[table_index].joker_cards);
										if (!is_3rd_valid) {
											if (!valid.validateAllJoker(declared_groups_array[n], room.tables[table_index].joker_cards)) {
												is_invalid++;
												declared_groups_array_status[n] = "Invalid";
											} else {
												declared_groups_array_status[n] = "Joker";
											}
										}
										else {
											is_3rd_sequence++;
											declared_groups_array_status[n] = "Third";
										}
									}
									else {
										is_sub_sequence++;
										declared_groups_array_status[n] = "Sub";
									}
								}
								else {
									is_pure++;
									declared_groups_array_status[n] = "Pure";
								}
							}//for
						}////if-group-limit ends
						else {
							room.tables[table_index].is_declared_valid_sequence = false;
						}
						console.log(" \n is_declared_valid_sequence of player " + room.tables[table_index].players[i].name +
							" is ---> " + JSON.stringify(declared_groups_array_status));
						if (is_invalid > 0) {
							room.tables[table_index].is_declared_valid_sequence = false;
						}
						else {
							if (is_pure >= 2) {
								room.tables[table_index].is_declared_valid_sequence = true;
							}
							else {
								if (is_pure == 1) {
									for (var n = 0; n < declared_groups_array_status.length;) {
										if (declared_groups_array_status[n] == "Sub") {
											room.tables[table_index].is_declared_valid_sequence = true;
											break;
										}
										else {
											if (n == (declared_groups_array_status.length)) { break; }
											else { n++; continue; }
										}
									}
								}//if pure 1
							}//else no 2 pure 
						}
						declared_groups_array = [];
						declared_groups_array_status = [];
					}//3-cards-group-condition
					console.log(" \n is_declared_valid_sequence of player " + room.tables[table_index].players[i].name +
						" is ---> " + room.tables[table_index].is_declared_valid_sequence);
					////////////////////////////////REMOVE later  for testing 
					//room.tables[table_index].is_declared_valid_sequence = true;

					if (room.tables[table_index].is_declared_valid_sequence == false) {
						room.tables[table_index].players[i].is_declared_valid_sequence = false;
						room.tables[table_index].players[i].game_status = "Lost";
						room.tables[table_index].players[i].game_display_status = "wrong_declared";

						temp_score = 80;
						//score = 80;
						room.tables[table_index].players[i].game_score = temp_score;
						room.tables[table_index].players[i].amount_won = getFixedNumber(-(+((temp_score * room.tables[table_index].table_point_value))));
						room.tables[table_index].players[i].amount_won_db = getFixedNumber(+(((temp_score * room.tables[table_index].table_point_value))));
						room.tables[table_index].players[i].amount_playing = getFixedNumber(+((room.tables[table_index].players[i].amount_playing - (temp_score * room.tables[table_index].table_point_value))));
						/*** If wrong declare then check no of live players and according to set 'declared' value ***/
						console.log("\n no of live players before wrong declare  " + room.tables[table_index].no_of_live_players);
						room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players) - 1;
						console.log("\n no of live players AFTER wrong declare  " + room.tables[table_index].no_of_live_players);
						console.log("2125  no_of_live_players " + room.tables[table_index].no_of_live_players);
						if (room.tables[table_index].no_of_live_players == 1) {
							room.tables[table_index].declared = 2;
							room.tables[table_index].players[i].declared= false;
							console.log("\n room.tables[table_index].players[i].declared ==if  " + room.tables[table_index].no_of_live_players);
						}
						else {
							console.log("\n room.tables[table_index].players[i].declared ==else  " + room.tables[table_index].no_of_live_players);
					
							if (player_status != "disconnected") {
								io.emit('player_declared_game', declared_user, group);
								return_open_card_six(i, room.tables[table_index].players[i].id, declared_user, group,
									round_id, room.tables[table_index].players[i].hand,
									room.tables[table_index].temp_open_object, player_status);
							}
						}
					}
					else {
						retValid = true;
						//change as per 6 -pl - condition 
						room.tables[table_index].players[i].is_declared_valid_sequence = true;
						room.tables[table_index].players[i].game_status = "Won";
						room.tables[table_index].players[i].game_display_status = "valid_declared";
						won_player = room.tables[table_index].players[i].name;
						won_player_grouped = room.tables[table_index].players[i].is_grouped;
						room.tables[table_index].players[i].game_declared_status = "Valid";
						room.tables[table_index].game_declare_status = "Valid";
						won_player_index = i;
						//room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players)-1;


						/*CHECK-REMOVE*/							//if not needed remove it 
						console.log("\n no of live players before valid declare  " + room.tables[table_index].no_of_live_players);
						room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players) - 1;
						console.log("\n no of live players AFTER Valid declare  " + room.tables[table_index].no_of_live_players);
						console.log("2156  no_of_live_players " + room.tables[table_index].no_of_live_players);

						for (var i = 0; i < room.tables[table_index].players.length; i++) {
							if (room.tables[table_index].players[i].name != declared_user) {
								room.tables[table_index].players[i].is_declared_valid_sequence = false;
								room.tables[table_index].players[i].game_status = "Lost";
							}
						}
						room.tables[table_index].players_names = [];
						room.tables[table_index].players_amounts = [];
						room.tables[table_index].players_user_id = [];
						room.tables[table_index].players_final_status = [];
						for (var j = 0; j < room.tables[table_index].players.length; j++) {
							all_player_status = room.tables[table_index].players[j].status;
							if (all_player_status != "disconnected") {
								room.tables[table_index].players_names[j] = room.tables[table_index].players[j].name;
								room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
								if (room.tables[table_index].players[j].name == won_player) {
									room.tables[table_index].players_final_status[j] = "Won";
								}
								else {
									room.tables[table_index].players_final_status[j] = "Lost";
								}
							}
						}
						if (room.tables[table_index].declared == 1) {
							// player_declared = room.tables[table_index].players[i].name;
							for (var j = 0; j < room.tables[table_index].players.length; j++) {
								all_player_status = room.tables[table_index].players[j].status;
								//console.log("\n all_player_status "+all_player_status);
								player_game_status = room.tables[table_index].players[j].game_display_status;
								if (room.tables[table_index].players[j].name != declared_user) {
									if (all_player_status != "disconnected" && player_game_status == "Live") {
										
										if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != ''){
										   io.sockets.connected[(room.tables[table_index].players[j].id)].emit("declared_six",
											{
												user: room.tables[table_index].players[j].name, group: group, round_id: round_id,
												declared_user: declared_user, declare: room.tables[table_index].declared
											});
										}
									}

								}
							}

							if (player_status != "disconnected") {
								player_name_array = [];
								player_final_card_groups_array = [];
								player_score_array = [];
								player_won_amount_array = [];
								player_group_status_array = [];
								for (var k = 0; k < room.tables[table_index].players.length; k++) {
									if (room.tables[table_index].players[k].game_display_status != "Live") {
										player_name_array.push(room.tables[table_index].players[k].name);
										player_grouped = room.tables[table_index].players[k].is_grouped;
										player_group_status_array.push(player_grouped);
										player_card_groups_array = [];
										is_player_grouped_temp = false;
										if (player_grouped == false) {
											is_player_grouped_temp = false;
											player_card_groups_array.push.apply(player_card_groups_array, room.tables[table_index].players[k].hand);
										}
										else {
											is_player_grouped_temp = true;
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7); }
										}
										player_final_card_groups_array.push(player_card_groups_array);
										player_score_array.push(room.tables[table_index].players[k].game_score);
										player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
									}
									else {
										player_name_array.push(room.tables[table_index].players[k].name);
										player_group_status_array.push(false);
										player_card_groups_array = [];
										player_final_card_groups_array.push(player_card_groups_array);
										player_score_array.push(-1);
										player_won_amount_array.push(-1);
									}
								}//inner-for ends 
                                if(room.tables[table_index].players[won_player_index].id && room.tables[table_index].players[won_player_index].id != ''){
								    io.sockets.connected[(room.tables[table_index].players[won_player_index].id)].emit("declared_final_six",
									{
										players: player_name_array, declared: 2, group: group, winner: won_player,
										group_status: player_group_status_array, players_cards: player_final_card_groups_array,
										players_score: player_score_array, players_amount: player_won_amount_array
									});
								}
							}//disconnect
						}
					}//sequence-true
				}//player-declared
			}//for
			console.log("\n ......... one player (" + declared_user + ") Declared Six player game ...........");

		}//declare-1 ends 
		/*************************************** OTHER DECLARED ********************************/
		if (room.tables[table_index].declared == 2) {
			console.log("\n .... Left Players Declared game (if 1 has declared wrong / valid sequence).......");
			var prev_declared_player;
			var declared_pl_score = 0, opp_pl_score = 0;
			var declared_pl_won_amount = 0, opp_pl_won_amount = 0;
			var score = 0;
			var temp_score = 0;

			console.log("\n ......... declared_user (" + declared_user + ") ...........");

			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				player_status = room.tables[table_index].players[i].status;

				//console.log("\n  no of live players "+room.tables[table_index].no_of_live_players);

				if (room.tables[table_index].players[i].name == declared_user && room.tables[table_index].players[i].declared== false) {
					room.tables[table_index].players[i].declared = true;
					if (room.tables[table_index].is_declared_valid_sequence == false) {
						for (var j = 0; j < room.tables[table_index].players.length; j++) {
							console.log("\n ........ player " + room.tables[table_index].players[j].name + " _GAME-status " + room.tables[table_index].players[j].game_display_status);
							if (room.tables[table_index].no_of_live_players == 1) {
								if (room.tables[table_index].players[j].game_display_status == "Live") {
									room.tables[table_index].players[j].declared = true;
									room.tables[table_index].players[j].game_status = "Won";
									room.tables[table_index].players[j].game_display_status = "winnner";
									won_player = room.tables[table_index].players[j].name;
									won_player_grouped = room.tables[table_index].players[j].is_grouped;
									won_player_index = j;
									room.tables[table_index].game_finished_status = true;
									//room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players)-1;
								}
								else if (room.tables[table_index].players[j].game_display_status == "winnner") {
									room.tables[table_index].game_calculation_done = true;
								}
							}
						}

						console.log("\n \n --------------------------- room.tables[table_index].game_finished_status " + room.tables[table_index].game_finished_status);
						//do calculation of score and display popups
						if (room.tables[table_index].game_calculation_done == false) {

							console.log("\n -------------- winnner --------------" + won_player);
							console.log("\n winnner " + room.tables[table_index].players[won_player_index].name
								+ " before calculate amount_playing   " + room.tables[table_index].players[won_player_index].amount_playing);

							room.tables[table_index].players[won_player_index].game_score = 0;
							for (var j = 0; j < room.tables[table_index].players.length; j++) {
								score = score + room.tables[table_index].players[j].game_score;
							}

							room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+((score * room.tables[table_index].table_point_value)));
							room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+((score * room.tables[table_index].table_point_value)));
							room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing + (score * room.tables[table_index].table_point_value))));
							winner_won_amount = room.tables[table_index].players[won_player_index].amount_won;

							console.log("\n after  calculate winnner amount_playing   " + room.tables[table_index].players[won_player_index].amount_playing);

						}//if-false

						transaction_id = Math.floor(Math.random() * 100000000000000);
						room.tables[table_index].players_names = [];
						room.tables[table_index].players_amounts = [];
						room.tables[table_index].players_user_id = [];
						room.tables[table_index].players_final_status = [];
						for (var j = 0; j < room.tables[table_index].players.length; j++) {
							all_player_status = room.tables[table_index].players[j].status;
							if (all_player_status != "disconnected") {
								room.tables[table_index].players_names[j] = room.tables[table_index].players[j].name;
								room.tables[table_index].players_amounts[j] = room.tables[table_index].players[j].amount_playing;
								room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
								if (room.tables[table_index].players[j].name == won_player) {
									room.tables[table_index].players_final_status[j] = "Won";
								}
								else {
									room.tables[table_index].players_final_status[j] = "Lost";
								}
							}
						}
						if (room.tables[table_index].game_calculation_done == true) {
							update_game_details_func(table_index);
						}//if-false

						if (room.tables[table_index].game_calculation_done == false) {
							for (var j = 0; j < room.tables[table_index].players.length; j++) {
								all_player_status = room.tables[table_index].players[j].status;
								if (all_player_status != "disconnected") {
									player_name_array = [];
									player_final_card_groups_array = [];
									player_score_array = [];
									player_won_amount_array = [];
									player_group_status_array = [];
									for (var k = 0; k < room.tables[table_index].players.length; k++) {
										player_name_array.push(room.tables[table_index].players[k].name);
										player_grouped = room.tables[table_index].players[k].is_grouped;
										player_group_status_array.push(player_grouped);
										player_card_groups_array = [];
										is_player_grouped_temp = false;
										if (player_grouped == false) {
											is_player_grouped_temp = false;
											player_card_groups_array.push.apply(player_card_groups_array, room.tables[table_index].players[k].hand);
										}
										else {
											is_player_grouped_temp = true;
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7); }
										}
										player_final_card_groups_array.push(player_card_groups_array);
										player_score_array.push(room.tables[table_index].players[k].game_score);
										player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
									}//inner-for ends 
									 if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != '')
									 {
								
									    io.sockets.connected[(room.tables[table_index].players[j].id)].emit("declared_final_six",
										{
											players: player_name_array, declared: 2, group: group, winner: won_player,
											group_status: player_group_status_array, players_cards: player_final_card_groups_array,
											players_score: player_score_array, players_amount: player_won_amount_array
										});
									 }
								}//disconnect
							}//outer-for
						}
					}//is_declared_valid_sequence-false
					else if (room.tables[table_index].is_declared_valid_sequence == true) {
						console.log("\n -------------- VALID GAME DECLARED --------------");
						console.log("\n -------" + room.tables[table_index].players[i].game_display_status);
						console.log("\n no of live players before valid_declared in decl-2  " + room.tables[table_index].no_of_live_players);
						room.tables[table_index].no_of_live_players = (room.tables[table_index].no_of_live_players) - 1;
						console.log("\n no of live players after valid_declared in decl-2  " + room.tables[table_index].no_of_live_players);
						console.log("2387  no_of_live_players " + room.tables[table_index].no_of_live_players);
						room.tables[table_index].players[i].game_display_status = "declared";


						console.log("\n room.tables[table_index].no_of_live_players " + room.tables[table_index].no_of_live_players);
						//if(room.tables[table_index].no_of_live_players ==1)
						if (room.tables[table_index].no_of_live_players == 0) {
							console.log("\n -----------------************** ");
							room.tables[table_index].game_finished_status = true;
						}

						var final_score = 0;
						var p = 0;
						declared_groups_array = [];
						group_count = get_opp_player_group_count(i, group);
						console.log("declared group array=============player "+room.tables[table_index].players[i].name+" group_count "+group_count+" declared_groups_array.length "+declared_groups_array.length+"--> "+JSON.stringify(declared_groups_array)); 
						
							if(group_count == 0){
								if(room.tables[table_index].players[i].hand){
								   if(room.tables[table_index].players[i].hand.length != 0){
									   declared_groups_array[0] = room.tables[table_index].players[i].hand;
									   group_count=group_count+1;
								   }
								}
							}
							
						console.log("declared group array=============player "+room.tables[table_index].players[i].name+" group_count "+group_count+" declared_groups_array.length "+declared_groups_array.length+"--> "+JSON.stringify(declared_groups_array)); 
						
						//console.log("player "+room.tables[table_index].players[i].name+" group_count "+group_count+" declared_groups_array.length "+declared_groups_array.length+"--> "+JSON.stringify(declared_groups_array)); 
						declared_invalid_groups_array = [];
						for (var n = 0; n < declared_groups_array.length; n++) {
							is_pure_valid = valid.validatePureSequence(declared_groups_array[n], room.tables[table_index].pure_joker_cards, club_suit_cards, spade_suit_cards, heart_suit_cards, diamond_suit_cards, room.tables[table_index].joker_cards);
							if (!is_pure_valid) {
								is_sub_valid = valid.validateSubSequence(declared_groups_array[n], room.tables[table_index].joker_cards, club_suit_cards, spade_suit_cards, heart_suit_cards, diamond_suit_cards);
								if (!is_sub_valid) {
									is_3rd_valid = valid.validateSameCardSequence(declared_groups_array[n], room.tables[table_index].joker_cards);
									if (!is_3rd_valid) {
										if (!valid.validateAllJoker(declared_groups_array[n], room.tables[table_index].joker_cards)) {
											is_invalid++;
											declared_groups_array_status[n] = "Invalid";
										} else {
											declared_groups_array_status[n] = "Joker";
										}
										declared_invalid_groups_array[n] = declared_groups_array[n];
									}
									else {
										is_3rd_sequence++;
										declared_groups_array_status[n] = "Third";
										declared_invalid_groups_array[n] = declared_groups_array[n];
									}
								}
								else {
									is_sub_sequence++;
									declared_groups_array_status[n] = "Sub";
									declared_invalid_groups_array[n] = declared_groups_array[n];
								}
							}
							else {
								is_pure++;
								declared_groups_array_status[n] = "Pure";
								declared_invalid_groups_array[n] = declared_groups_array[n];
							}
						}//for 

						var your_score = 0, opp_score = 0;
						var your_amount = 0, opp_amount = 0;
						var group = [];
						var temp_group = [];
						var index = -1;
						var other_declared_sequence = false;
						score = 0;


						/* If opp player is also having valid sequence then calculation by 2 */
						if (is_invalid == 0 && is_pure >= 2) {
							console.log("\n BOTH DECL - FIRST PURE 2 , INVALID 0 ");
							other_declared_sequence = true;
							if (other_declared_sequence == true) {
								temp_score = 2;
								score = 0;
							}
						}
						else if (is_invalid == 0 && is_pure == 1) {
							console.log("\n BOTH DECL - FIRST PURE 1 , INVALID 0 ");
							for (var n = 0; n < declared_groups_array_status.length;) {
								if (declared_groups_array_status[n] == "Sub") {
									other_declared_sequence = true;
									temp_score = 2;
									score = 0;
									break;
								}
								else {
									if (n == (declared_groups_array_status.length)) { break; }
									else { n++; continue; }
								}
							}
						}//pure-1
						else {
							if (is_pure >= 1) {
								console.log("\n BOTH DECL - FIRST PURE 1 INVALID !=0 ");
								/* if 1 or more pure sequence and if sub sequence - do not consider for calculation */
								for (var n = 0; n < declared_groups_array_status.length;) {
									if (declared_groups_array_status[n] == "Pure") {
										declared_invalid_groups_array.remove(n);
										declared_groups_array_status.remove(n);
									}
									else if (declared_groups_array_status[n] == "Sub") {
										declared_invalid_groups_array.remove(n);
										declared_groups_array_status.remove(n);
									}
									else if (declared_groups_array_status[n] == "Third") {
										if (is_pure > 1) {
											declared_invalid_groups_array.remove(n);
											declared_groups_array_status.remove(n);
										}
										else if (is_sub_sequence >= 1 && is_pure >= 1) {
											declared_invalid_groups_array.remove(n);
											declared_groups_array_status.remove(n);
										} else {
											n++;
										}
									}
									else {
										n++;
									}
								}//for
							}

							if (declared_invalid_groups_array.length > 0) {
								for (var k = 0; k < declared_invalid_groups_array.length; k++) {
									group = [];
									group = declared_invalid_groups_array[k];
									temp_group = [];
									temp_group.push.apply(temp_group, group);

									for (var i = 0; i < temp_group.length; i++) {
										for (var j = 0; j < room.tables[table_index].joker_cards.length; j++) {
											if (room.tables[table_index].joker_cards[j].name == temp_group[i].name && room.tables[table_index].joker_cards[j].suit == temp_group[i].suit) {
												temp_group.remove(i);
												i--;
												break;
											}
										}//joker_for
									}//outer for  
									for (var n = 0; n < temp_group.length; n++) {
										temp_score = temp_score + parseInt(temp_group[n].game_points);
										console.log("\n calculating SCORE if any pure " + temp_score);
									}
								}
								console.log("\n %%%%%%%%%%%%%% FINAL SCORE " + temp_score);
								if (temp_score >= 80) {
									temp_score = 80;
									score = 0;
									// your_amount = (80 * room.tables[table_index].table_point_value);
									// opp_amount = 80 * room.tables[table_index].table_point_value;
								}
								else {
									temp_score = temp_score;
									score = 0;
									// your_amount = (score * room.tables[table_index].table_point_value);
									// opp_amount = score * room.tables[table_index].table_point_value;
								}
							}
						}//if-not-valid
						console.log("\n --------decl player score -->" + temp_score);

						for (var j = 0; j < room.tables[table_index].players.length; j++) {
							//if(room.tables[table_index].no_of_live_players ==1)
							{
								//if(room.tables[table_index].players[j].game_display_status == "Live")
								if (room.tables[table_index].players[j].game_declared_status == "Valid") {
									room.tables[table_index].players[j].declared = true;
									room.tables[table_index].players[j].game_status = "Won";
									won_player = room.tables[table_index].players[j].name;
									won_player_grouped = room.tables[table_index].players[j].is_grouped;
									won_player_index = j;
								}
							}
						}
						console.log("\n -------------- winnner --------------" + won_player);
						for (var j = 0; j < room.tables[table_index].players.length; j++) {
							if (room.tables[table_index].players[j].name == declared_user) {
								room.tables[table_index].players[j].game_score = temp_score;
								room.tables[table_index].players[j].amount_won = getFixedNumber(-(+((temp_score * room.tables[table_index].table_point_value))));
								room.tables[table_index].players[j].amount_won_db = getFixedNumber(+((temp_score * room.tables[table_index].table_point_value)));
								room.tables[table_index].players[j].amount_playing = getFixedNumber(+((room.tables[table_index].players[j].amount_playing - (temp_score * room.tables[table_index].table_point_value))));
							}
						}


						declared_groups_array = [];
						declared_groups_array_status = [];



						if (room.tables[table_index].no_of_live_players == 0) {
							console.log("\n $$$$$$$$$ WINNNER AMOUNT CALCULATION ");
							console.log("\n winnner " + room.tables[table_index].players[won_player_index].name
								+ " before calculate amount_playing   " + room.tables[table_index].players[won_player_index].amount_playing);
							var temp_amt = 0;
							for (var k = 0; k < room.tables[table_index].players.length; k++) {
								if (room.tables[table_index].players[k].name != won_player) {
									declared_pl_score = room.tables[table_index].players[k].game_score;
									room.tables[table_index].players[won_player_index].game_score = 0;
									winner_won_amount = (declared_pl_score * room.tables[table_index].table_point_value);
									temp_amt = (declared_pl_score * room.tables[table_index].table_point_value);

									room.tables[table_index].players[won_player_index].amount_won = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_won + (winner_won_amount))));
									room.tables[table_index].players[won_player_index].amount_won_db = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_won_db + (winner_won_amount))));
									room.tables[table_index].players[won_player_index].amount_playing = getFixedNumber(+((room.tables[table_index].players[won_player_index].amount_playing + (winner_won_amount))));
									winner_won_amount = room.tables[table_index].players[won_player_index].amount_won;
								}
							}
							console.log("\n after  calculate winnner amount_won   " + room.tables[table_index].players[won_player_index].amount_won);
							console.log("\n after  calculate winnner amount_playing   " + room.tables[table_index].players[won_player_index].amount_playing);
							if (table_game == 'Cash Game') {
								/********* Inserting commision details to 'company_balance' table ******/
								commision_query = "INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount, `amount`, `players_name`, `date`) VALUES ('" + room.tables[table_index].id + "','" + room.tables[table_index].round_id + "','" + table_player_capacity + "','" + room.tables[table_index].game_type + "','" + company_commision + "','" + temp_amt + "'," + company_commision_amount + "','" + room.tables[table_index].six_usernames + "',now())";
								con.query(commision_query, function (err1, result) {
                                  if(err1){
									console.log(err1);
								}

									});
							}

							transaction_id = Math.floor(Math.random() * 100000000000000);
							room.tables[table_index].players_names = [];
							room.tables[table_index].players_amounts = [];
							room.tables[table_index].players_user_id = [];
							room.tables[table_index].players_final_status = [];
							for (var j = 0; j < room.tables[table_index].players.length; j++) {
								all_player_status = room.tables[table_index].players[j].status;
								if (all_player_status != "disconnected") {
									room.tables[table_index].players_names[j] = room.tables[table_index].players[j].name;
									room.tables[table_index].players_amounts[j] = room.tables[table_index].players[j].amount_playing;
									room.tables[table_index].players_user_id[j] = room.tables[table_index].players[j].user_id;
									if (room.tables[table_index].players[j].name == won_player) {
										room.tables[table_index].players_final_status[j] = "Won";
									}
									else {
										room.tables[table_index].players_final_status[j] = "Lost";
										insert_query3 = "insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values(" + room.tables[table_index].players[j].user_id + "," + transaction_id + ",'" + room.tables[table_index].game_type + "','" + chip_type + "','" + room.tables[table_index].id + "','" + room.tables[table_index].table_name + "','" + room.tables[table_index].round_id + "','" + room.tables[table_index].players[j].name + "','" + room.tables[table_index].players[j].game_status + "','" + (score * room.tables[table_index].table_point_value) + "','" + dt + "')";
										console.log(insert_query3);
										con.query(insert_query3, function (err1, result) { 
										
										if(err1){
									       console.log(err1);
								         }
										});
									}
								}
							}


							console.log("\n round while insert db " + room.tables[table_index].round_id);
							/**** Inserting Transaction Details to database once game end/restarted ****/
							/*for (var i = 0; i < room.tables[table_index].players.length; i++)
							{
								insert_query="insert into game_transactions(user_id,`game_transaction_id`,game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values("+room.tables[table_index].players[i].user_id+","+transaction_id+",'"+room.tables[table_index].game_type+"','"+chip_type+"','"+room.tables[table_index].id+"','"+room.tables[table_index].table_name+"','"+room.tables[table_index].round_id+"','"+room.tables[table_index].players[i].name+"','"+room.tables[table_index].players[i].game_status+"','"+(score * room.tables[table_index].table_point_value)+"','"+dt+"')";
								con.query(insert_query, function(err1, result){}); 
							}*/
							/*For winning amount */
							insert_query = "insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values(" + room.tables[table_index].players[won_player_index].user_id + "," + transaction_id + ",'" + room.tables[table_index].game_type + "','" + chip_type + "','" + room.tables[table_index].id + "','" + room.tables[table_index].table_name + "','" + room.tables[table_index].round_id + "','" + room.tables[table_index].players[won_player_index].name + "','" + room.tables[table_index].players[won_player_index].game_status + "','" + winner_won_amount + "','" + dt + "')";
							console.log(insert_query);
							con.query(insert_query, function (err1, result) {

                             if(err1){
									       console.log(err1);
								         }


								});

							update_game_details_func(table_index);

							/** Amount Updated after game end of player (if disconnected)**/
						}//if-0-players

						for (var j = 0; j < room.tables[table_index].players.length; j++) {
							console.log("\n ==== in for calculating virtual data  --------------" + room.tables[table_index].players.length);
							//console.log("\n ........ player_GAME-status "+room.tables[table_index].players[j].game_display_status);
							all_player_status = room.tables[table_index].players[j].status;
							if (all_player_status != "disconnected") {
								player_name_array = [];
								player_final_card_groups_array = [];
								player_score_array = [];
								player_won_amount_array = [];
								player_group_status_array = [];
								for (var k = 0; k < room.tables[table_index].players.length; k++) {
									console.log("\n player " + room.tables[table_index].players[k].name + " status " + room.tables[table_index].players[k].game_display_status);
									if (room.tables[table_index].players[k].game_display_status != "Live") {
										player_name_array.push(room.tables[table_index].players[k].name);
										player_grouped = room.tables[table_index].players[k].is_grouped;
										player_group_status_array.push(player_grouped);
										player_card_groups_array = [];
										is_player_grouped_temp = false;
										if (player_grouped == false) {
											is_player_grouped_temp = false;
											player_card_groups_array.push.apply(player_card_groups_array, room.tables[table_index].players[k].hand);
										}
										else {
											is_player_grouped_temp = true;
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6); }
											{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7); }
										}
										player_final_card_groups_array.push(player_card_groups_array);
										player_score_array.push(room.tables[table_index].players[k].game_score);
										console.log("\n player won amount_won " + room.tables[table_index].players[k].amount_won);
										player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
									}
									else {
										player_name_array.push(room.tables[table_index].players[k].name);
										player_group_status_array.push(false);
										player_card_groups_array = [];
										player_final_card_groups_array.push(player_card_groups_array);
										player_score_array.push(-1);
										player_won_amount_array.push(-1);
									}
								}//inner-for ends 
								if (room.tables[table_index].players[j].game_display_status != "Live") {
									console.log("\n ^^^^^^^^^^^^^ Emitting DATA TO PLAYERS ");
									 if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != '')
									 {
								
									    io.sockets.connected[(room.tables[table_index].players[j].id)].emit("declared_final_six",
										{
											players: player_name_array, declared: 2, group: group, winner: won_player,
											group_status: player_group_status_array, players_cards: player_final_card_groups_array,
											players_score: player_score_array, players_amount: player_won_amount_array
										});
										
									 }
								}
							}//disconnect
						}//outer-for
					}//is_declared_valid_seq-true
				}
			}//for ends 
		}//declared-2-ends
	}//round ends 
	return retValid;
}//declare_game_data ends 


//cards without joker for turn
con.query("SELECT * FROM `cards` where `id` < 53", function (er, result, fields) {
	cards_without_joker.push.apply(cards_without_joker, result);
});
/** Get club suit cards array from database **/
con.query("SELECT * FROM `cards` WHERE `suit` LIKE 'c'", function (er, rc, fields) {
	
	
	if(er){
		console.log(er);
	}else{
			for (var i = 0; i < rc.length; i++) {
				var suit_id = rc[i].suit_id;
				var bsame = false;
				for (var j = 0; j < club_suit_cards.length; j++) {
					if (suit_id == club_suit_cards[j].suit_id) {
						bsame = true;
						break;
					}
				}
				if (!bsame)
					club_suit_cards.push(rc[i]);
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

/** Get Spade suit cards array from database **/
con.query("SELECT * FROM `cards` WHERE `suit` LIKE 's'", function (er, rc, fields) {
	
	if(er){
		console.log(er);
	}else{
			for (var i = 0; i < rc.length; i++) {
				var suit_id = rc[i].suit_id;
				var bsame = false;
				for (var j = 0; j < spade_suit_cards.length; j++) {
					if (suit_id == spade_suit_cards[j].suit_id) {
						bsame = true;
						break;
					}
				}
				if (!bsame)
					spade_suit_cards.push(rc[i]);
			}

			spade_suit_cards = spade_suit_cards.sort(function (a, b) {
				return (a.suit_id - b.suit_id)
			});
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
/** Get Heart suit cards array from database **/
con.query("SELECT * FROM `cards` WHERE `suit` LIKE 'h'", function (er, rc, fields) {
	for (var i = 0; i < rc.length; i++) {
		var suit_id = rc[i].suit_id;
		var bsame = false;
		for (var j = 0; j < heart_suit_cards.length; j++) {
			if (suit_id == heart_suit_cards[j].suit_id) {
				bsame = true;
				break;
			}
		}
		if (!bsame)
			heart_suit_cards.push(rc[i]);
	}

	heart_suit_cards = heart_suit_cards.sort(function (a, b) {
		return (a.suit_id - b.suit_id)
	});
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
});
/** Get Diamond suit cards array from database **/
con.query("SELECT * FROM `cards` WHERE `suit` LIKE 'd'", function (er, rc, fields) {
	
	if(er){
		console.log(er);
	}else{
		for (var i = 0; i < rc.length; i++) {
			var suit_id = rc[i].suit_id;
			var bsame = false;
			for (var j = 0; j < diamond_suit_cards.length; j++) {
				if (suit_id == diamond_suit_cards[j].suit_id) {
					bsame = true;
					break;
				}
			}
			if (!bsame)
				diamond_suit_cards.push(rc[i]);
		}

		diamond_suit_cards = diamond_suit_cards.sort(function (a, b) {
			return (a.suit_id - b.suit_id)
		});
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

/************* for 6-player-game *********/

//get company commision from database and assign to variable 

con.query("SELECT * FROM `commission` ", function (er, result, fields) {
	
	if(er){
		console.log(er);
	}else{
		if (result.length != 0) {
			company_commision = result[0].commission;
		}
	}
});

//cards without joker for turn
con.query("SELECT * FROM `cards` where `id` < 53", function (er, result, fields) {
	if(er){
		console.log(er);
	}else{
	  cards_without_joker_six.push.apply(cards_without_joker_six, result);
	}
});

con.query("SELECT * FROM `cards`", function (err1, rows, fields1) {
	if(err1){
		console.log(err1);
	}else{
	orgin_cards_six.push.apply(orgin_cards_six, rows);
	}
});

setInterval(tournamentTimer, 1000);

io.on('connection', function (socket) {
	// var S = require('./six_player_game.js');
	// var ss = new S(socket);


	var Ip = socket.request.connection.remoteAddress;
	console.log('Player connected from IP Address:  ' + Ip + " Socket ID " + socket.id);

	/************* for 6-player-game *********/
	socket.on('disconnect', function () {
		var left_player_status = "";
		var table_index = 0;
		var tournamentId = 0;
		var table_player_capacity = 0;

		console.log("\n player " + socket.username + " gender " + socket.gender + " disconnecting , connected players(sockets) " + clients_connected.length);
		console.log("\n socket.id" + socket.id + "--socket.tableid--" + socket.tableid);
		console.log("\n player seat no " + socket.btn_clicked);

		var player = room.getPlayer(socket.id);
		if (player) {
			table_index = getTableIndex(room.tables, player.tableID);
			if (table_index == - 1) {
				console.log("\n disconnect");
				return;
			}
			table_player_capacity = room.tables[table_index].playerCapacity;

			tournamentId = room.tables[table_index].tournamentId;
			console.log("\n--------table players capacity " + room.tables[table_index].playerCapacity);

			//console.log("\n player.name "+player.getName()+" and status "+player.status+"--tbl index--"+table_index+"--player.tableID--"+player.tableID);
			if (table_player_capacity == 6) {
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					if (room.tables[table_index].players[i].name == socket.username) {
						console.log("\n  player.name " + room.tables[table_index].players[i].name + " status " + room.tables[table_index].players[i].status);
						left_player_status = room.tables[table_index].players[i].status;
					}
				}
			}

			console.log("tournamentId " + tournamentId + " username " + socket.username);
			var playerIdx = getIndexofPlayerInTournament(tournamentId, socket.username);
			if (playerIdx >= 0) {
				tournaments[tournamentId].players_socketid[playerIdx] = 0;
			}
		}////if-player ends 

		if (player && table_player_capacity == 6) {
			console.log("player.status " + player.status);
			player.status = "disconnected";
			/**** If playing game , after player disconnected then show that player status as disconnected ***/
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				if (room.tables[table_index].players[i].name == socket.username) {
					room.tables[table_index].players[i].status = "disconnected";
					room.tables[table_index].players[i].player_reconnected = false;
				}
			}
			socket.broadcast.emit('player_disconnected_six', player.name, player.tableID);
			console.log("\n disconnecting player status when playing six-player-game " + player.status);
		}

		if (player)
			room.removePlayer(player);
	});

	/**************************  6 Player functions  start ***********************************/

	/******* Check for player alread joined on table and display it ******/
	socket.on('check_if_joined_player', function (username, tournamentId) {
		var player;
		var open_data;
		var temp_arr = [];
		var player_names = [];
		var open_id = 0;
		var open_path = "";
		var open_data_arr;
		var table_index = 0;

		var grpid = getTableIdOfTournament(username, tournamentId);

		if (grpid == -1)
			return;

		table_index = getTableIndex(room.tables, grpid);
		if (table_index == -1)
			return;

		var playerIdx = getIndexofPlayerInTournament(tournamentId, username);
		if (playerIdx >= 0) {
			tournaments[tournamentId].players_socketid[playerIdx] = socket.id;
		}
		console.log(" \n room.tables[table_index].restart_game_six " + room.tables[table_index].restart_game_six + " tableIdx:" + table_index + " grpid:" + grpid);
		if (username !== null || username === undefined) {
			if (room.tables[table_index].players.length > 0) {

				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					player_names[i] = room.tables[table_index].players[i].name;
				}

				socket.emit('show_sixgame_data', room.tables[table_index].six_usernames,
					room.tables[table_index].six_user_click, tournamentId, grpid,
					room.tables[table_index].six_player_amount, room.tables[table_index].six_player_poolamount,
					room.tables[table_index].six_player_gender,
					room.tables[table_index].restart_game_six, player_names);

				socket.username = username;
				socket.tableid = grpid;

				if (room.tables[table_index].winner != "") {
					socket.emit("touranment_game_end", tournamentId, grpid, room.tables[table_index].winner);
				} else if (room.tables[table_index].players.length == 1) {
					room.tables[table_index].players[0].id = socket.id;
					socket.emit("touranment_game_end", tournamentId, grpid, room.tables[table_index].players[0].name);
				}
				else if (room.tables[table_index].players.length >= 2) {
					socket.emit('show_game_count', grpid, TOURNAMENT_ROUND_CNT - room.tables[table_index].gameCnt + 1, TOURNAMENT_ROUND_CNT);

					for (var i = 0; i < room.tables[table_index].players.length; i++) {
						//console.log(" \n i==>"+i);
						if (room.tables[table_index].players[i].name == username) {
							if ((room.tables[table_index].players[i].status) == "disconnected") {

								room.tables[table_index].players[i].id = socket.id;

								socket.gender = room.tables[table_index].six_player_gender[i];
								socket.btn_clicked = room.tables[table_index].six_user_click[i];

								room.tables[table_index].players[i].status = "playing";
								room.tables[table_index].players[i].player_reconnected = true;

								room.addPlayer(room.tables[table_index].players[i]);
								//console.log(" \n pl gender ---> "+room.tables[table_index].six_player_gender[i]);	

								socket.broadcast.emit('other_player_reconnected_six',
									username, tournamentId, room.tables[table_index].id,
									room.tables[table_index].players[i].amount_playing,
									room.tables[table_index].six_player_gender[i]);
								/*IMP*/								//add code for wat					

								var player_playing = [];
								for (var k = 0; k < room.tables[table_index].six_usernames.length; k++) {
									player_playing[k] = false;
									for (var j = 0; j < room.tables[table_index].players.length; j++) {
										if (room.tables[table_index].six_usernames[k] == room.tables[table_index].players[j].name) {
											player_playing[k] = true;
										}
									}
								}

								socket.emit('player_reconnected_six', tournamentId, room.tables[table_index].id,
									room.tables[table_index].six_usernames, room.tables[table_index].six_user_click,
									room.tables[table_index].six_player_amount, room.tables[table_index].six_player_gender, player_playing);


								//console.log("\n tbl open card length "+room.tables[table_index].open_card_obj_arr.length+" -data -"+JSON.stringify(room.tables[table_index].open_card_obj_arr));
								if (tournaments[tournamentId].status == TOURNAMENT_GAME_STATUS_GAME) {

									if (room.tables[table_index].open_card_status == "discard") {
										if (room.tables[table_index].open_card_obj_arr.length == 0) {
											open_id = 0;
											open_path = "";
											open_data_arr = [];
										}
										else {
											temp_arr.push(room.tables[table_index].open_card_obj_arr[0]);
											open_data = temp_arr;
											open_id = open_data.id;
											open_path = open_data.card_path;
											open_data_arr = open_data;
										}
									}
									else {
										if (room.tables[table_index].open_card_obj_arr.length == 0) {
											open_id = 0;
											open_path = "";
											open_data_arr = [];
										}
										else {
											open_data = room.tables[table_index].open_card_obj_arr[0];
											open_id = open_data.id;
											open_path = open_data.card_path;
											open_data_arr = open_data;
										}
									}
									console.log("\n open data " + JSON.stringify(open_data));

									//console.log("\n dealer "+room.tables[table_index].dealer_name);
									//console.log("\n is player "+username+" joined table -->"+room.tables[table_index].players[i].is_joined_table);
									if (room.tables[table_index].players[i].is_grouped == false) {
                                     if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
									 {
										io.sockets.connected[(room.tables[table_index].players[i].id)].emit("refresh_six",
											{
												tournamentId: tournamentId, group_id: room.tables[table_index].id, assigned_cards: room.tables[table_index].players[i].hand,
												opencard: open_path, opencard_id: open_id, closedcards_path: room.tables[table_index].closed_cards_arr,
												open_close_pick_count: room.tables[table_index].players[i].open_close_selected_count,
												round_no: room.tables[table_index].round_id, sidejoker: room.tables[table_index].side_joker_card,
												sidejokername: room.tables[table_index].side_joker_card_name,
												open_data: open_data_arr, open_length: room.tables[table_index].open_cards.length,
												close_cards: room.tables[table_index].open_cards,
												is_grouped: room.tables[table_index].players[i].is_grouped,
												is_finish: room.tables[table_index].players[i].is_player_finished,
												finish_obj: room.tables[table_index].finish_card_object,
												is_joined_table: room.tables[table_index].players[i].is_joined_table,
												dealer: room.tables[table_index].dealer_name
											});
									 }
									}
									else {
										
										if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
									    {
										io.sockets.connected[(room.tables[table_index].players[i].id)].emit("refresh_six",
											{
												tournamentId: tournamentId, group_id: room.tables[table_index].id, assigned_cards: room.tables[table_index].players[i].hand,
												opencard: open_path, opencard_id: open_id, closedcards_path: room.tables[table_index].closed_cards_arr,
												open_close_pick_count: room.tables[table_index].players[i].open_close_selected_count,
												round_no: room.tables[table_index].round_id, sidejoker: room.tables[table_index].side_joker_card,
												sidejokername: room.tables[table_index].side_joker_card_name,
												open_data: open_data_arr, open_length: room.tables[table_index].open_cards.length,
												close_cards: room.tables[table_index].open_cards,
												is_grouped: room.tables[table_index].players[i].is_grouped,
												is_finish: room.tables[table_index].players[i].is_player_finished,
												finish_obj: room.tables[table_index].finish_card_object,
												is_joined_table: room.tables[table_index].players[i].is_joined_table,
												dealer: room.tables[table_index].dealer_name
											});
									 }
                                        if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
									    {
										   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
											{
												user: username, group: room.tables[table_index].id, round_id: room.tables[table_index].round_id,
												grp1_cards: room.tables[table_index].players[i].card_group1,
												grp2_cards: room.tables[table_index].players[i].card_group2,
												grp3_cards: room.tables[table_index].players[i].card_group3,
												grp4_cards: room.tables[table_index].players[i].card_group4,
												grp5_cards: room.tables[table_index].players[i].card_group5,
												grp6_cards: room.tables[table_index].players[i].card_group6,
												grp7_cards: room.tables[table_index].players[i].card_group7,
												sidejokername: room.tables[table_index].side_joker_card_name
											});
										}
									}
									if ((room.tables[table_index].players[i].game_display_status) == "dropped") {
										socket.emit('player_dropped_game', username, room.tables[table_index].id);
										socket.broadcast.emit('player_dropped_game', username, room.tables[table_index].id);
									}
									else if ((room.tables[table_index].players[i].game_display_status) == "wrong_declared") {
										socket.emit('player_declared_game', username, room.tables[table_index].id);
										socket.broadcast.emit('player_declared_game', username, room.tables[table_index].id);
									}

									for (var j = 0; j < room.tables[table_index].players.length; j++) {
										if (room.tables[table_index].players[j].name != username) {
											if ((room.tables[table_index].players[j].status) == "disconnected") {
												socket.emit('player_disconnected_six', room.tables[table_index].players[j].name, room.tables[table_index].id);
											}
											else if ((room.tables[table_index].players[j].game_display_status) == "dropped") {
												socket.emit('player_dropped_game', room.tables[table_index].players[j].name, room.tables[table_index].id);
											}
											else if ((room.tables[table_index].players[j].game_display_status) == "wrong_declared") {
												socket.emit('player_declared_game', room.tables[table_index].players[j].name, room.tables[table_index].id);
											}
										}
									}

									if (room.tables[table_index].players[i].game_display_status != "Live") {
										if ((room.tables[table_index].declared == 1 && room.tables[table_index].is_declared_valid_sequence)
											|| room.tables[table_index].declared == 2) {
											player_name_array = [];
											player_final_card_groups_array = [];
											player_score_array = [];
											player_won_amount_array = [];
											player_group_status_array = [];
											var won_player = "";
											for (var k = 0; k < room.tables[table_index].players.length; k++) {
												console.log("\n player " + room.tables[table_index].players[k].name + " status " + room.tables[table_index].players[k].game_display_status);
												if (room.tables[table_index].players[k].game_display_status != "Live") {
													player_name_array.push(room.tables[table_index].players[k].name);
													player_grouped = room.tables[table_index].players[k].is_grouped;
													player_group_status_array.push(player_grouped);
													player_card_groups_array = [];
													is_player_grouped_temp = false;
													if (player_grouped == false) {
														is_player_grouped_temp = false;
														player_card_groups_array.push.apply(player_card_groups_array, room.tables[table_index].players[k].hand);
													}
													else {
														is_player_grouped_temp = true;
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group1); }
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group2); }
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group3); }
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group4); }
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group5); }
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group6); }
														{ player_card_groups_array.push(room.tables[table_index].players[k].card_group7); }
													}
													player_final_card_groups_array.push(player_card_groups_array);
													player_score_array.push(room.tables[table_index].players[k].game_score);
													console.log("\n player won amount_won " + room.tables[table_index].players[k].amount_won);
													player_won_amount_array.push(room.tables[table_index].players[k].amount_won);
												}
												else {
													player_name_array.push(room.tables[table_index].players[k].name);
													player_group_status_array.push(false);
													player_card_groups_array = [];
													player_final_card_groups_array.push(player_card_groups_array);
													player_score_array.push(-1);
													player_won_amount_array.push(-1);
												}
											}//inner-for ends
											if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
											{
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

			}

			/* ANDY
			con.query("SELECT * FROM `player_table`  where `table_id`='" + grpid + "'", function (er, result_table, fields) {
				if (result_table.length != 0) {
					room.tables[table_index].table_name = result_table[0].table_name;
					room.tables[table_index].table_point_value = result_table[0].point_value;
					room.tables[table_index].table_min_entry = result_table[0].min_entry;
					room.tables[table_index].table_game = result_table[0].game;
					room.tables[table_index].game_type = result_table[0].game_type;
					room.tables[table_index].playerCapacity = result_table[0].player_capacity;
					//..console.log("\n ----------------------player_capacity -------------------"+room.tables[table_index].playerCapacity);
				}
			});*/
		}
	});

	////update player group after sort or group///
	socket.on("update_player_groups_six", function (data) {
		var player_playing = data.player;
		var round = data.round_id;
		var table_index = 0;
		table_index = getTableIndex(room.tables, data.group);
		if (table_index == - 1) {
			console.log("\n update_player_groups_six");
			return;
		}
		var is_sorted = data.is_sort;
		var is_grouped = data.is_group;
		var is_initial_group = data.is_initial_group;
		//..console.log("\n  is_sorted "+ is_sorted+" is_grouped "+is_grouped+" is_initial_group "+is_initial_group);
		var player_status;

		//if (room.tables[table_index].round_id == round) 
		{
			if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
				//..console.log("\n pl length "+room.tables[table_index].players.length);
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					player_status = room.tables[table_index].players[i].status;
					//console.log("\n check "+room.tables[table_index].players[i].name+"--"+player_playing);

					if (room.tables[table_index].players[i].name == player_playing) {
						//console.log("\n in if  ");
						room.tables[table_index].players[i].is_grouped = true;
						
						
						if (is_grouped == true) {
							var card_group = data.card_group;
							var parent_group = data.parent_group;
							var remove_from_group;
							var group_no;

							group_no = check_player_empty_group(i, data.group, card_group);
							if (group_no != 8) {
								var i, j;
								for (k = 0; k <= parent_group.length; k++) {
									
									if (parent_group[k] == 1) { remove_from_group = room.tables[table_index].players[i].card_group1; }
									if (parent_group[k] == 2) { remove_from_group = room.tables[table_index].players[i].card_group2; }
									if (parent_group[k] == 3) { remove_from_group = room.tables[table_index].players[i].card_group3; }
									if (parent_group[k] == 4) { remove_from_group = room.tables[table_index].players[i].card_group4; }
									if (parent_group[k] == 5) { remove_from_group = room.tables[table_index].players[i].card_group5; }
									if (parent_group[k] == 6) { remove_from_group = room.tables[table_index].players[i].card_group6; }
									if (parent_group[k] == 7) { remove_from_group = room.tables[table_index].players[i].card_group7; }

									if (card_group != null) {
										for (j = 0; j < card_group.length; j++) {
											
											//remove_from_group = removeFromSortedHandCards(remove_from_group, card_group[j].id, parent_group[k]);
										remove_from_group= removeFromSortedHandCardsUpdate(remove_from_group,card_group[j].id,parent_group[k],group_no,card_group[j],table_index,i);
													
										
										}
									}
								}
							}
							else {
								if (player_status != "disconnected") {
									io.sockets.connected[(room.tables[table_index].players[i].id)].emit("group_limit_six",
										{ user: player_playing, group: room.tables[table_index].id, round_id: round });
								}
							}
						}else{
							if (is_initial_group == true) {
							
								var n;
								var card_group = data.card_group;
									var parent_group = data.parent_group;
							     var remove_from_group;
								group_no =check_player_empty_group(i, data.group, card_group);
								
								if(parent_group.length  > 0){
									var i, j;
								   for (k = 0; k <= parent_group.length; k++) {
									
										if (parent_group[k] == 1) { remove_from_group = room.tables[table_index].players[i].card_group1; }
										if (parent_group[k] == 2) { remove_from_group = room.tables[table_index].players[i].card_group2; }
										if (parent_group[k] == 3) { remove_from_group = room.tables[table_index].players[i].card_group3; }
										if (parent_group[k] == 4) { remove_from_group = room.tables[table_index].players[i].card_group4; }
										if (parent_group[k] == 5) { remove_from_group = room.tables[table_index].players[i].card_group5; }
										if (parent_group[k] == 6) { remove_from_group = room.tables[table_index].players[i].card_group6; }
										if (parent_group[k] == 7) { remove_from_group = room.tables[table_index].players[i].card_group7; }

										if (card_group != null) {
											for (j = 0; j < card_group.length; j++) {
												
												//remove_from_group = removeFromSortedHandCards(remove_from_group, card_group[j].id, parent_group[k]);
											
											   remove_from_group= removeFromSortedHandCardsUpdate(remove_from_group,card_group[j].id,parent_group[k],group_no,card_group[j],table_index,i);
											
											}
										}
								    }
								}
								
								if (card_group != null) {
									for (var j = 0; j < card_group.length; j++) {
										room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand, card_group[j].id);
										/*04-05-2021 */
									room.tables[table_index].players[i].card_group1.push(card_group[j]);
									/*04-05-2021 */
									}
								}
								add_cards_to_last_group(i, data.group, room.tables[table_index].players[i].hand);
						    }else{
								
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
											room.tables[table_index].players[i].card_group1 = data.group1;
											if( data.group1 != null) {
												for(var  j = 0; j < data.group1.length; j++)
												{
													room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,data.group1[j].id);
												}
											}
											room.tables[table_index].players[i].card_group2 = data.group2;
											if( data.group2 != null) {
												for(var  j = 0; j < data.group2.length; j++)
												{
													room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,data.group2[j].id);
												}
											}
											room.tables[table_index].players[i].card_group3 = data.group3;
											if( data.group3 != null) {
												for(var  j = 0; j < data.group3.length; j++)
												{
													room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,data.group3[j].id);
												}
											}
											room.tables[table_index].players[i].card_group4 = data.group4;
											if( data.group4 != null) {
												for(var  j = 0; j < data.group4.length; j++)
												{
													room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand,data.group4[j].id);
												}
											}
										}
									}
						
							}
						}
						/* send updated groups to respective player*/
						if (player_status != "disconnected") {
							
						  if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
								{
									user: player_playing, group: room.tables[table_index].id, round_id: round,
									grp1_cards: room.tables[table_index].players[i].card_group1,
									grp2_cards: room.tables[table_index].players[i].card_group2,
									grp3_cards: room.tables[table_index].players[i].card_group3,
									grp4_cards: room.tables[table_index].players[i].card_group4,
									grp5_cards: room.tables[table_index].players[i].card_group5,
									grp6_cards: room.tables[table_index].players[i].card_group6,
									grp7_cards: room.tables[table_index].players[i].card_group7, sidejokername: room.tables[table_index].side_joker_card_name
								});
							}
						}
					}
				}
			}
		}
	});//update_player_groups_six ends

	////add here on single card select if card groups 
	socket.on("add_here_six", function (data) {
		var player_playing = data.player;
		var round = data.round_id;
		var table_index = 0;
		table_index = getTableIndex(room.tables, data.group);
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
		var add_to_group, remove_from_group;

		//if (room.tables[table_index].round_id == round) 
		{
			if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					player_status = room.tables[table_index].players[i].status;
					if (room.tables[table_index].players[i].name == player_playing) {
						////define group from remove card
						if (group_from_remove == 1) { remove_from_group = room.tables[table_index].players[i].card_group1; }
						if (group_from_remove == 2) { remove_from_group = room.tables[table_index].players[i].card_group2; }
						if (group_from_remove == 3) { remove_from_group = room.tables[table_index].players[i].card_group3; }
						if (group_from_remove == 4) { remove_from_group = room.tables[table_index].players[i].card_group4; }
						if (group_from_remove == 5) { remove_from_group = room.tables[table_index].players[i].card_group5; }
						if (group_from_remove == 6) { remove_from_group = room.tables[table_index].players[i].card_group6; }
						if (group_from_remove == 7) { remove_from_group = room.tables[table_index].players[i].card_group7; }

						////define group to which add card
						if (group_to_add == 1) { add_to_group = room.tables[table_index].players[i].card_group1; }
						if (group_to_add == 2) { add_to_group = room.tables[table_index].players[i].card_group2; }
						if (group_to_add == 3) { add_to_group = room.tables[table_index].players[i].card_group3; }
						if (group_to_add == 4) { add_to_group = room.tables[table_index].players[i].card_group4; }
						if (group_to_add == 5) { add_to_group = room.tables[table_index].players[i].card_group5; }
						if (group_to_add == 6) { add_to_group = room.tables[table_index].players[i].card_group6; }
						if (group_to_add == 7) { add_to_group = room.tables[table_index].players[i].card_group7; }

						//remove from group of image clicked
						//console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						remove_from_group = removeFromSortedHandCards(remove_from_group, card_to_remove, group_from_remove);
						//console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						//add card to selected group
						//console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						add_to_group.push(selected_card_src);
						//console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						if (player_status != "disconnected") {
							
							if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
								{
									user: player_playing, group: room.tables[table_index].id, round_id: round,
									grp1_cards: room.tables[table_index].players[i].card_group1,
									grp2_cards: room.tables[table_index].players[i].card_group2,
									grp3_cards: room.tables[table_index].players[i].card_group3,
									grp4_cards: room.tables[table_index].players[i].card_group4,
									grp5_cards: room.tables[table_index].players[i].card_group5,
									grp6_cards: room.tables[table_index].players[i].card_group6,
									grp7_cards: room.tables[table_index].players[i].card_group7,
									sidejokername: room.tables[table_index].side_joker_card_name
								});
							}
						}
					}
				}//for ends 
			}
		}
	});//add_here ends 
	
	
	
	socket.on("add_here_six_drop", function (data) {
		var player_playing = data.player;
		var round = data.round_id;
		var position = data.position;
		var table_index = 0;
		table_index = getTableIndex(room.tables, data.group);
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
		var add_to_group, remove_from_group;

		//if (room.tables[table_index].round_id == round) 
		{
			if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					player_status = room.tables[table_index].players[i].status;
					if (room.tables[table_index].players[i].name == player_playing) {
						////define group from remove card
						if (group_from_remove == 1) { remove_from_group = room.tables[table_index].players[i].card_group1; }
						if (group_from_remove == 2) { remove_from_group = room.tables[table_index].players[i].card_group2; }
						if (group_from_remove == 3) { remove_from_group = room.tables[table_index].players[i].card_group3; }
						if (group_from_remove == 4) { remove_from_group = room.tables[table_index].players[i].card_group4; }
						if (group_from_remove == 5) { remove_from_group = room.tables[table_index].players[i].card_group5; }
						if (group_from_remove == 6) { remove_from_group = room.tables[table_index].players[i].card_group6; }
						if (group_from_remove == 7) { remove_from_group = room.tables[table_index].players[i].card_group7; }

						////define group to which add card
						if (group_to_add == 1) { add_to_group = room.tables[table_index].players[i].card_group1; }
						if (group_to_add == 2) { add_to_group = room.tables[table_index].players[i].card_group2; }
						if (group_to_add == 3) { add_to_group = room.tables[table_index].players[i].card_group3; }
						if (group_to_add == 4) { add_to_group = room.tables[table_index].players[i].card_group4; }
						if (group_to_add == 5) { add_to_group = room.tables[table_index].players[i].card_group5; }
						if (group_to_add == 6) { add_to_group = room.tables[table_index].players[i].card_group6; }
						if (group_to_add == 7) { add_to_group = room.tables[table_index].players[i].card_group7; }

						//remove from group of image clicked
						//console.log("\n ADD HERE b4 remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						remove_from_group = removeFromSortedHandCards(remove_from_group, card_to_remove, group_from_remove);
						//console.log("\n ADD HERE after remove by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
						//add card to selected group
						//console.log("\n ADD HERE b4 ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						//add_to_group.push(selected_card_src);
						add_to_group.splice(position, 0, selected_card_src);
						//console.log("\n ADD HERE after ADD by Player "+room.tables[table_index].players[0].name+" cards: "+add_to_group.length+" are "+JSON.stringify(add_to_group));
						if (player_status != "disconnected") {
							
							if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
								{
									user: player_playing, group: room.tables[table_index].id, round_id: round,
									grp1_cards: room.tables[table_index].players[i].card_group1,
									grp2_cards: room.tables[table_index].players[i].card_group2,
									grp3_cards: room.tables[table_index].players[i].card_group3,
									grp4_cards: room.tables[table_index].players[i].card_group4,
									grp5_cards: room.tables[table_index].players[i].card_group5,
									grp6_cards: room.tables[table_index].players[i].card_group6,
									grp7_cards: room.tables[table_index].players[i].card_group7,
									sidejokername: room.tables[table_index].side_joker_card_name
								});
							}
						}
					}
				}//for ends 
			}
		}
	});//add_here ends 

	////check open_close_selected_count and allow to pick open/close card 
	socket.on("check_open_closed_pick_count_six", function (data) {
		//..console.log("\n "+data.card+" card selected by player "+data.user+" on table "+data.group+" for round id "+data.round_id);
		var table_index = 0;
		var user = data.user;
		var group = data.group;
		table_index = getTableIndex(room.tables, group);

		if (table_index == -1) {
			console.log("\n check_open_closed_pick_count_six");
			return;
		}
		var temp_open_array = [];
		var card_type = data.card;
		var card_taken = false;
		var round_id = data.round_id;
		var obj;
		var is_sorted = data.is_sort;
		var is_grouped = data.is_group;
		var is_initial_grouped = data.is_initial_group;
		var player_status, all_player_status;
		var is_joker = false;
		var next_key = 13;
		
		
		var total_hand_card=0;	
		var selected_user='';
		for (var i = 0; i < room.tables[table_index].players.length; i++)
		{
					
			if(room.tables[table_index].players[i].name == user)
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

    if(room.tables[table_index].players[selected_user].is_turn == true)
	{			

		//..console.log("\n using selected card"+JSON.stringify(data.card_data));
		//..console.log("\n open/close click is_sorted "+is_sorted+" is_grouped "+is_grouped+" is_initial_grouped "+is_initial_grouped);

		if (card_type == 'open') {
			is_joker = checkIfJokerCard(room.tables[table_index].joker_cards, data.card_data[0].id);
			console.log("\n is selected card is joker--> " + is_joker + "  firstTurn: " + room.tables[table_index].isfirstTurn);
			if (room.tables[table_index].isfirstTurn)
				is_joker = false;
			obj = data.card_data.reduce(function (acc, cur, i) {
				acc[i] = cur;
				return acc;
			});
		}
		if (card_type == 'close') {
			/*** When closed card array get empty ***/
			//1. add last card of open array to temp open array
			//2. remove last card from open 
			//3. add all rest cards from open to close array 
			//4. clear open array and add temp card to open array
			//5. shuffle new array before use 

			if (room.tables[table_index].closed_cards_arr.length == 0) {
				//..console.log("\n CLOSED EMPTY open =="+JSON.stringify(room.tables[table_index].open_cards));
				//1
				//..console.log("\n temp open array when closed get empty before "+JSON.stringify(temp_open_array));
				temp_open_array.push(room.tables[table_index].open_cards[(room.tables[table_index].open_cards.length) - 1]);
				//..console.log("\n temp open array when closed get empty after "+JSON.stringify(temp_open_array));
				//2
				room.tables[table_index].open_cards = removeOpenCard(room.tables[table_index].open_cards, temp_open_array[0].id);
				//3
				room.tables[table_index].closed_cards_arr.push.apply(room.tables[table_index].closed_cards_arr, room.tables[table_index].open_cards);
				//4
				room.tables[table_index].open_cards = [];
				room.tables[table_index].open_cards.push.apply(room.tables[table_index].open_cards, temp_open_array);
				//5
				room.tables[table_index].closed_cards_arr = shuffleClosedCards(room.tables[table_index].closed_cards_arr);
			}
			if (room.tables[table_index].closed_cards_arr.length > 0) {
				obj = room.tables[table_index].closed_cards_arr[0];
			}
		}

		//room.tables[table_index].temp_open_object = obj;	
		//..console.log("\n \n obj value"+JSON.stringify(obj));

		//if (room.tables[table_index].round_id == round_id) 
		{
			if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
				for (var i = 0; i < room.tables[table_index].players.length; i++) {
					player_status = room.tables[table_index].players[i].status;
					if (room.tables[table_index].players[i].name == user) {
						if ((room.tables[table_index].players[i].open_close_selected_count == 0)) {
							if (is_joker != true) {
								
								
								if (is_grouped == true || is_initial_grouped == true) {
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
											
										//room.tables[table_index].players[i].card_group7.push(obj);
								}else{
									if (is_sorted == false && is_grouped == false && is_initial_grouped == false) {
										room.tables[table_index].players[i].hand.push(obj);
									}else{
										   
										if (is_sorted == true) {
										  room.tables[table_index].players[i].card_group4.push(obj);
										}
									}
								}
								if (card_type == 'open') {
									//console.log("\n Before Use Open Card, array "+JSON.stringify(room.tables[table_index].open_cards));
									room.tables[table_index].open_cards = removeOpenCard(room.tables[table_index].open_cards, data.card_data[0].id);
									room.tables[table_index].open_card_obj_arr = [];

									for (var j = 0; j < room.tables[table_index].players.length; j++) {
										all_player_status = room.tables[table_index].players[j].status;

										if (all_player_status != "disconnected") {
											
											if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != '')
									        {
											 io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_close_click_count_six",
												{
													user: user, group: group, card: data.card, card_data: data.card_data, path: data.path, pick_count: 0,
													open_arr: room.tables[table_index].open_cards, card: 'open', check: true,
													hand_cards: room.tables[table_index].players[j].hand, round_id: round_id, sidejokername: room.tables[table_index].side_joker_card_name
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
									if (is_sorted == true || is_grouped == true || is_initial_grouped == true) {
										if (player_status != "disconnected") {
											if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
									        {
											   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
												{
													user: user, group: room.tables[table_index].id, round_id: round_id,
													grp1_cards: room.tables[table_index].players[i].card_group1,
													grp2_cards: room.tables[table_index].players[i].card_group2,
													grp3_cards: room.tables[table_index].players[i].card_group3,
													grp4_cards: room.tables[table_index].players[i].card_group4,
													grp5_cards: room.tables[table_index].players[i].card_group5,
													grp6_cards: room.tables[table_index].players[i].card_group6,
													grp7_cards: room.tables[table_index].players[i].card_group7, sidejokername: room.tables[table_index].side_joker_card_name
												});
											}
										}
									}
									// if(first_player_status != "disconnected")
									// {
									// 	io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:data.card_data,path:data.path,pick_count:0,open_arr:room.tables[table_index].open_cards,card:'open',check:false,hand_cards:room.tables[table_index].players[1].hand,round_id:round_id});
									// }
								}//if-open-card
								if (card_type == 'close') {
									//console.log("\n Before Use Close Card ,array "+room.tables[table_index].closed_cards_arr.length+"==="+JSON.stringify(room.tables[table_index].closed_cards_arr));
									if (room.tables[table_index].closed_cards_arr.length > 0) {
										room.tables[table_index].closed_cards_arr = removeCloseCard(room.tables[table_index].closed_cards_arr, obj.id);
									}
									if (room.tables[table_index].closed_cards_arr.length > 0) {
										room.tables[table_index].closed_cards_arr = shuffleClosedCards(room.tables[table_index].closed_cards_arr);
									}
									//console.log("\n After Used Close Card ,array "+room.tables[table_index].closed_cards_arr.length+"==="+JSON.stringify(room.tables[table_index].closed_cards_arr));
									for (var j = 0; j < room.tables[table_index].players.length; j++) {
										all_player_status = room.tables[table_index].players[j].status;

										if (all_player_status != "disconnected") {
											if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != '')
									        {
											   io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_close_click_count_six",
												{
													user: user, group: group, card: data.card, card_data: obj,
													path: obj.card_path, pick_count: 0, open_arr: room.tables[table_index].closed_cards_arr,
													card: 'close', check: true, hand_cards: room.tables[table_index].players[j].hand, round_id: round_id,
													sidejokername: room.tables[table_index].side_joker_card_name
												});
											}
										}
									}
									// if(oth_player_status != "disconnected")
									// {
									// 	io.sockets.connected[(room.tables[table_index].players[0].id)].emit("open_close_click_count", { user:user,group:group,card:data.card,card_data:obj,path:obj.card_path,pick_count:0,open_arr:room.tables[table_index].closed_cards_arr,card:'close',check:true,hand_cards:room.tables[table_index].players[0].hand,round_id:round_id});
									// }
									////after sort send card groups 
									if (is_sorted == true || is_grouped == true || is_initial_grouped == true) {
										if (player_status != "disconnected") {
											
											if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
									        {
											   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
												{
													user: user, group: room.tables[table_index].id, round_id: round_id,
													grp1_cards: room.tables[table_index].players[i].card_group1,
													grp2_cards: room.tables[table_index].players[i].card_group2,
													grp3_cards: room.tables[table_index].players[i].card_group3,
													grp4_cards: room.tables[table_index].players[i].card_group4,
													grp5_cards: room.tables[table_index].players[i].card_group5,
													grp6_cards: room.tables[table_index].players[i].card_group6,
													grp7_cards: room.tables[table_index].players[i].card_group7,
													sidejokername: room.tables[table_index].side_joker_card_name
												});
												
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
							}//not joker
							else {
								if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
								{
								  io.sockets.connected[(room.tables[table_index].players[i].id)].emit("pick_close_card_six", { user: user, group: group, round_id: round_id });
							    }
							}
						}////pl-0-count ends
						else {
							if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("disallow_pick_card_six", { user: user, group: group, round_id: round_id });
						    }
						}
					}//pl-0 if ends
				}//for ends 
			}//pl-6-condition
		}//round-id ends 	


    }else{
		if(room.tables[table_index].players[selected_user].id && room.tables[table_index].players[selected_user].id != '')
		{
		   io.sockets.connected[(room.tables[table_index].players[selected_user].id)].emit("disallow_pick_card_six", { user: user, group: group, round_id: round_id });
		}
	}
	}else{
		if(room.tables[table_index].players[selected_user].id && room.tables[table_index].players[selected_user].id != '')
		{
		   io.sockets.connected[(room.tables[table_index].players[selected_user].id)].emit("disallow_pick_card_six", { user: user, group: group, round_id: round_id });
		}
	}
		
	});

	socket.on("discard_fired_six", function (data) {
		//..console.log("discard event fired by Player "+data.discarded_user+" on table "+data.group+" for round id "+data.round_id);
		var user_whos_discarded = data.discarded_user;
		var group = data.group;
		var table_index = 0;
		table_index = getTableIndex(room.tables, group);
		if (table_index == - 1) {
			console.log("\n discard_fired_six");
			return;
		}
		var round_id = data.round_id;

		//if (room.tables[table_index].round_id == round_id) {
		if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				if (room.tables[table_index].players[i].name == user_whos_discarded) {
					room.tables[table_index].players[i].turnFinished = true;
				}
			}
		}////table-2-players-condition
		//}
	});//discard_fired ends 

	//// show discarded card to open card ///
	socket.on("show_open_card_six", function (data) {
		//..console.log("After discard display open card to Player "+data.user+" on table "+data.group+" for round id "+data.round_id);
		var user_who_discarded = data.user;
		var group = data.group;
		var table_index = 0;
		table_index = getTableIndex(room.tables, group);
		if (table_index == - 1) {
			console.log("\n show_open_card_six");
			return;
		}
		if(data.open_card_id == "" || data.open_card_id == undefined || data.open_card_id == null){
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
		var player_status, all_player_status;
     
		//..console.log("\n DISCARDED card id "+(discareded_return_card)+" discareded_open_card "+JSON.stringify(discareded_open_card));
		//..console.log("\n **** SORT/GROUP check IS SORT "+is_sorted+" is grp of grp "+is_grouped+" is intial grp "+is_initial_grouped);
		//..console.log("\n DISCARD FROM GRP "+data.group_from_discarded+"==="+JSON.stringify(discareded_return_card));

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
			
		console.log("\n total_hand_card========================"+total_hand_card);			
	if(total_hand_card > 13){
       		
		//if (room.tables[table_index].round_id == round_id) {
		if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				player_status = room.tables[table_index].players[i].status;

				if (room.tables[table_index].players[i].name == user_who_discarded) {
					if (is_sorted == false && is_grouped == false && is_initial_grouped == false) {
						//console.log("Before discard/return by Player "+room.tables[table_index].players[0].name+" hand cards: "+room.tables[table_index].players[0].hand.length+" are "+JSON.stringify(room.tables[table_index].players[0].hand));
						discard_data_temp = getDiscardFromHandCards(room.tables[table_index].players[i].hand, discareded_return_card);

						room.tables[table_index].open_card_obj_arr = [];
						room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
						room.tables[table_index].open_card_status = "discard";

						//console.log("Before return Open Card array "+JSON.stringify(room.tables[table_index].open_cards));
						room.tables[table_index].open_cards.push(discard_data_temp);
						//console.log("After return/discard Open Card array "+JSON.stringify(room.tables[table_index].open_cards)); 

						room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand, discareded_return_card);

						//console.log("After discard/return by Player "+room.tables[table_index].players[0].name+" hand cards : "+room.tables[table_index].players[0].hand.length+" are "+JSON.stringify(room.tables[table_index].players[0].hand));
					}
					if (is_sorted == true || is_grouped == true || is_initial_grouped == true) {
						//if sorted but no discard from any group remove from last group - return as turn end
						if (group_from_discarded == 0) { remove_from_group = room.tables[table_index].players[i].card_group4; }
						if (group_from_discarded == 1) { remove_from_group = room.tables[table_index].players[i].card_group1; }
						if (group_from_discarded == 2) { remove_from_group = room.tables[table_index].players[i].card_group2; }
						if (group_from_discarded == 3) { remove_from_group = room.tables[table_index].players[i].card_group3; }
						if (group_from_discarded == 4) { remove_from_group = room.tables[table_index].players[i].card_group4; }
						if (group_from_discarded == 5) { remove_from_group = room.tables[table_index].players[i].card_group5; }
						if (group_from_discarded == 6) { remove_from_group = room.tables[table_index].players[i].card_group6; }
						if (group_from_discarded == 7) { remove_from_group = room.tables[table_index].players[i].card_group7; }

						//console.log("\n SORTING Before discard/return by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));

						discard_data_temp = getDiscardFromSortGroupCards(remove_from_group, discareded_return_card, group_from_discarded);

						room.tables[table_index].open_card_obj_arr = [];
						room.tables[table_index].open_card_obj_arr.push(discard_data_temp);
						room.tables[table_index].open_card_status = "discard";

						//console.log("Before return Open Card array "+JSON.stringify(room.tables[table_index].open_cards));
						room.tables[table_index].open_cards.push(discard_data_temp);
						//console.log("After return/discard Open Card array "+JSON.stringify(room.tables[table_index].open_cards)); 

						remove_from_group = removeFromSortedHandCards(remove_from_group, discareded_return_card, group_from_discarded);

						//console.log("\n SORTING AFTER discard/return by Player "+room.tables[table_index].players[0].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					}
					//show open card  
					// if(player_status != "disconnected")
					// {
					// 	io.sockets.connected[(room.tables[table_index].players[1].id)].emit("open_card", { path:open_card_path,check:check1,id:open_card_id,discareded_open_card:discard_data_temp,group:group,round_id:round_id,discard_open_cards:room.tables[table_index].open_cards});	
					// }
					for (var j = 0; j < room.tables[table_index].players.length; j++) {
						all_player_status = room.tables[table_index].players[j].status;

						if (all_player_status != "disconnected") {
							if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[j].id)].emit("open_card_six",
								{
									path: open_card_path, check: check1, id: open_card_id, discareded_open_card: discard_data_temp,
									group: group, round_id: round_id, discard_open_cards: room.tables[table_index].open_cards
								});
							}
						}
					}
					room.tables[table_index].players[i].open_close_selected_count = 0;
					if (is_sorted == false && is_grouped == false && is_initial_grouped == false) {
						//send updated hand cards 
						if (player_status != "disconnected") {
							if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							    io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_hand_cards_six",
								{
									user: user_who_discarded, group: group, round_id: data.round_id,
									hand_cards: room.tables[table_index].players[i].hand, sidejokername: room.tables[table_index].side_joker_card_name
								});
							}
						}
					}
					if (is_sorted == true || is_grouped == true || is_initial_grouped == true) {
						if (player_status != "disconnected") {
							
							if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
								{
									user: user_who_discarded, group: room.tables[table_index].id, round_id: data.round_id,
									grp1_cards: room.tables[table_index].players[i].card_group1,
									grp2_cards: room.tables[table_index].players[i].card_group2,
									grp3_cards: room.tables[table_index].players[i].card_group3,
									grp4_cards: room.tables[table_index].players[i].card_group4,
									grp5_cards: room.tables[table_index].players[i].card_group5,
									grp6_cards: room.tables[table_index].players[i].card_group6,
									grp7_cards: room.tables[table_index].players[i].card_group7,
									sidejokername: room.tables[table_index].side_joker_card_name
								});
							}
						}
					}
				}
			}//for ends
		}
		
		}
		//}
	});//show-open-card ends 

	//// show  selected card to finish  card ///
	socket.on("show_finish_card_six", function (data) {
		var player_playing = data.player;
		var group = data.group;
		var table_index = 0;
		table_index = getTableIndex(room.tables, group);
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
		var player_status, all_player_status;

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
			
		console.log("\n total_hand_card========================"+total_hand_card);			
	if(total_hand_card > 13){
        if(room.tables[table_index].players[selected_user].is_turn == true)
	    {		
		if (room.tables[table_index].players.length >= 2 && room.tables[table_index].players.length <= 6) {
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				player_status = room.tables[table_index].players[i].status;

				if (room.tables[table_index].players[i].name == player_playing) {
					room.tables[table_index].players[i].gameFinished = true;
					//..console.log("\n Player Name "+room.tables[table_index].players[i].name+" is finished "+room.tables[table_index].players[i].gameFinished);
					//// Remove finish card from hand cards//////
					/* 1. Initial if no sort / group */
					if (is_sorted == false && is_grouped == false && is_initial_grouped == false) {
						//..console.log("Before finish by Player "+room.tables[table_index].players[i].name+" hand cards: "+room.tables[table_index].players[i].hand.length+" are "+JSON.stringify(room.tables[table_index].players[i].hand));

						room.tables[table_index].players[i].hand = removeFromHandCards(room.tables[table_index].players[i].hand, finished_card_id);

						//..console.log("After Finish by Player "+room.tables[table_index].players[i].name+" hand cards : "+room.tables[table_index].players[i].hand.length+" are "+JSON.stringify(room.tables[table_index].players[i].hand));
					}
					if (is_sorted == false && is_grouped == false && is_initial_grouped == false) {
						//send updated hand cards 
						if (room.tables[table_index].players[i].status != "disconnected") {
							if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_hand_cards_six",
								{
									user: player_playing, group: group, round_id: round, hand_cards: room.tables[table_index].players[i].hand, sidejokername: room.tables[table_index].side_joker_card_name
								});
							}
						}
					}

					/* 2. If sort / group */
					if (is_sorted == true || is_grouped == true || is_initial_grouped == true) {
						if (group_from_finished == 1) { remove_from_group = room.tables[table_index].players[i].card_group1; }
						if (group_from_finished == 2) { remove_from_group = room.tables[table_index].players[i].card_group2; }
						if (group_from_finished == 3) { remove_from_group = room.tables[table_index].players[i].card_group3; }
						if (group_from_finished == 4) { remove_from_group = room.tables[table_index].players[i].card_group4; }
						if (group_from_finished == 5) { remove_from_group = room.tables[table_index].players[i].card_group5; }
						if (group_from_finished == 6) { remove_from_group = room.tables[table_index].players[i].card_group6; }
						if (group_from_finished == 7) { remove_from_group = room.tables[table_index].players[i].card_group7; }

						//..console.log("\n SORTING/GROUP Before finish by Player "+room.tables[table_index].players[i].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));

						remove_from_group = removeFromSortedHandCards(remove_from_group, finished_card_id, group_from_finished);

						//..console.log("\n SORTING AFTER finish by Player "+room.tables[table_index].players[i].name+" cards: "+remove_from_group.length+" are "+JSON.stringify(remove_from_group));
					}
					if (is_sorted == true || is_grouped == true || is_initial_grouped == true) {
						if (room.tables[table_index].players[i].status != "disconnected") {
							
							if(room.tables[table_index].players[i].id && room.tables[table_index].players[i].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[i].id)].emit("update_player_groups_six",
								{
									user: player_playing, group: group, round_id: round,
									grp1_cards: room.tables[table_index].players[i].card_group1,
									grp2_cards: room.tables[table_index].players[i].card_group2,
									grp3_cards: room.tables[table_index].players[i].card_group3,
									grp4_cards: room.tables[table_index].players[i].card_group4,
									grp5_cards: room.tables[table_index].players[i].card_group5,
									grp6_cards: room.tables[table_index].players[i].card_group6,
									grp7_cards: room.tables[table_index].players[i].card_group7,
									sidejokername: room.tables[table_index].side_joker_card_name
								});
							}
						}
					}

					//// emit finish card to both players 
					for (var j = 0; j < room.tables[table_index].players.length; j++) {
						all_player_status = room.tables[table_index].players[j].status;
						if (all_player_status != "disconnected") {
							if(room.tables[table_index].players[j].id && room.tables[table_index].players[j].id != '')
							{
							   io.sockets.connected[(room.tables[table_index].players[j].id)].emit("finish_card_six",
								{
									user: room.tables[table_index].players[j].name, group: group, round_id: round, path: finish_card_path
								});
							}
						}
					}
				}
			}//for ends 
		}
		//}
	}
	}
	});//show_finish_card_six ends 

	/*****  Dropped Game by Player **********/
	socket.on("drop_game_six", function (data) {
		
		var group = data.group;
		var table_index = 0;
		table_index = getTableIndex(room.tables, group);
		if (table_index == - 1) {
			console.log("\n declare_game_six");
			return;
		}
		
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
			
			
					
	    if(total_hand_card == 13){
		   if(room.tables[table_index].players[selected_user].is_turn == true){
		        drop_game_six_func(data.user_who_dropped_game, data.group, data.round_id);
		    }else{
			return;
		   }
	   }else{
		return;
	   }
	});//drop_game ends 
	socket.on("declare_game_six", function (data) {
		var group = data.group;
		var table_index = 0;
		table_index = getTableIndex(room.tables, group);
		if (table_index == - 1) {
			console.log("\n declare_game_six");
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
			
			
					
	    if(total_hand_card == 13){
		   //if(room.tables[table_index].players[selected_user].is_turn == true){
			   
				console.log("\n Six player Game declared of type " + room.tables[table_index].game_type);
				declare_game_data_six(data.user, data.group, data.round_id, data.pl_amount_taken, data.is_sort, data.is_group, data.is_initial_group, room.tables[table_index].table_point_value, room.tables[table_index].game_type, room.tables[table_index].table_name);
			
		   //}else{
			//return;
		   //}
	   }else{
		return;
	   }
	
	});//declare_game ends 

 });/////socket ends 


/**************************  6 Player functions  end ***********************************/

function indexOfMax(arr) {
	if (arr.length === 0) { return -1; }
	var max = arr[0];
	var maxIndex = 0;
	for (var i = 1; i < arr.length; i++) {
		if (arr[i] > max) {
			maxIndex = i;
			max = arr[i];
		}
	}
	//return max;
	return maxIndex;
}//indexOfMax ends 

function indexOfLast(arr) {
	if (arr.length === 0) { return -1; }
	var last = arr[0];
	var lastIndex = 0;
	for (var i = 1; i < arr.length; i++) {
		if (arr[i] < last) {
			lastIndex = i;
			last = arr[i];
		}
	}
	return lastIndex;
}//indexOfLast ends 

var get_random_no = function (length) {
	return Math.floor(Math.pow(14, length - 1) + Math.random() * (Math.pow(14, length) - Math.pow(14, length - 1) - 1));
}

function removeUser(user_arr, usernm) {
	var index = -1;
	for (var i = 0; i < user_arr.length; i++) {
		if (user_arr[i] === usernm) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		user_arr.remove(index);
	}

}

function removeGroup(group_arr, grpid) {
	var index = -1;
	for (var i = 0; i < group_arr.length; i++) {
		if (group_arr[i] === grpid) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		group_arr.remove(index);
	}

}

function removePlayerAmount(amount_arr, amt) {
	var index = -1;
	for (var i = 0; i < amount_arr.length; i++) {
		if (amount_arr[i] === amt) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		amount_arr.remove(index);
	}
}


////used to remove discarded/returned card from player hand cards array
function removeFromHandCards(handcard_arr, card) {
	//console.log(card);
	var index = -1;
	for (var i = 0; i < handcard_arr.length; i++) {
		//console.log("**********"+handcard_arr[i].id+"==="+card);		
		//	if(handcard_arr[i].id== card){
		//console.log("**********"+handcard_arr[i].id+"==="+card);		
		if (handcard_arr[i].id == card) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		handcard_arr.remove(index);
		console.log("*****AFTER REMOVE HAND *****" + JSON.stringify(handcard_arr));
	}
	return handcard_arr;
}

function getDiscardFromHandCards(handcard_arr, card) {
	var index;
	for (var i = 0; i < handcard_arr.length; i++) {
		if (handcard_arr[i].id == card) {
			index = handcard_arr[i];
			break;
		}
	}
	return index;
}

function getDiscardFromSortGroupCards(sortcard_arr, card, group_no) {
	//console.log("^^^^^^^^^^"+sortcard_arr.length+"---"+card+"---"+group_no);
	var index;
	for (var i = 0; i < sortcard_arr.length; i++) {
		if (group_no == 0) {
			if (sortcard_arr[i].id == card) {
				index = sortcard_arr[i];
				break;
			}
		}
		else {
			if (sortcard_arr[i].id == card) {
				index = sortcard_arr[i];
				break;
			}
		}
	}
	return index;
}

////used to remove discarded/returned card from player sorted hand cards array
function removeFromSortedHandCards(handcard_arr, card, group_no) {
	//console.log(card+" grp no "+group_no);
	var index = -1;
	for (var i = 0; i < handcard_arr.length; i++) {
		if (group_no == 0) {
			if (handcard_arr[i].id == card) {
				//console.log("**********"+handcard_arr[i].id+"==="+card);	
				index = i;
				break;
			}
		}
		else {
			if (handcard_arr[i].id == card) {
				//console.log("**********"+handcard_arr[i].id+"==="+card);	
				index = i;
				break;
			}
		}
	}
	if (index != -1) {
		//console.log("*****BEFORE REMOVE SORT  *****"+JSON.stringify(handcard_arr));	
		handcard_arr.remove(index);
		//console.log("\n \n *****AFTER REMOVE SORT  *****"+JSON.stringify(handcard_arr));	
	}
	return handcard_arr;
}

function removeFromSortedHandCardsUpdate(handcard_arr,card,group_no,add_group,add_data,table_index,playerid) {
		
	//console.log(card+" grp no "+group_no);
	if( handcard_arr == null)
		return [];
	    var index = -1;
			for(var  i = 0; i < handcard_arr.length; i++){
				if(group_no == 0)
				{
					if(handcard_arr[i].id != "" && handcard_arr[i].id != undefined){
						if(handcard_arr[i].id == card)
						{
							//console.log("**********"+handcard_arr[i].id+"==="+card);	
							index = i;
							break;
						}
					}
				}
				else
				{
					if(handcard_arr[i].id != "" && handcard_arr[i].id != undefined){
					
					if(handcard_arr[i].id == card)
					{
						//console.log("**********"+handcard_arr[i].id+"==="+card);	
						index = i;
						break;
					}
					}
				}
			}
			if(index != -1){
				//console.log("*****BEFORE REMOVE SORT  *****"+JSON.stringify(handcard_arr));	
				handcard_arr.remove(index);
				console.log("\n \n *****Add To Group==="+add_group+"*****"+JSON.stringify(add_data));
				if(add_group == 1){ room.tables[table_index].players[playerid].card_group1.push(add_data);}
				if(add_group == 2){ room.tables[table_index].players[playerid].card_group2.push(add_data);}
				if(add_group == 3){ room.tables[table_index].players[playerid].card_group3.push(add_data);}
				if(add_group == 4){ room.tables[table_index].players[playerid].card_group4.push(add_data);}
				if(add_group == 5){ room.tables[table_index].players[playerid].card_group5.push(add_data);}
				if(add_group == 6){ room.tables[table_index].players[playerid].card_group6.push(add_data);}
				if(add_group == 7){ room.tables[table_index].players[playerid].card_group7.push(add_data);}
				//console.log("\n \n *****AFTER REMOVE SORT  *****"+JSON.stringify(handcard_arr));	
			}
	  return handcard_arr;
	}
	

function removeFromGrpArr(group_arr, grpid) {
	var index = -1;
	//console.log(group_arr.length+"----  "+group_arr);
	for (var i = 0; i < group_arr.length; i++) {
		if (group_arr[i] === grpid) {
			//console.log(index);
			index = i;
			break;
		}
	}
	if (index != -1) {
		//console.log("b4 rem"+group_arr.length);
		group_arr.remove(index);
		//console.log("aftre rem"+group_arr.length);
	}
	//console.log("final   "+group_arr.length);
	return group_arr;
}
function removeOpenCard(opencard_arr, card) {
	//console.log("check card exist "+card);
	//console.log("removing used open card (by id) from open card array"+JSON.stringify(opencard_arr));
	var index = -1;
	for (var i = 0; i < opencard_arr.length; i++) {
		//console.log("***"+opencard_arr[i].id+"----"+card);		
		if (opencard_arr[i].id == card) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		opencard_arr.remove(index);

	}
	return opencard_arr;
}


function removeCloseCard(closecard_arr, card) {
	var index = -1;
	for (var i = 0; i < closecard_arr.length; i++) {
		if (closecard_arr[i].id == card) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		closecard_arr.remove(index);
	}
	return closecard_arr;
}

function checkIfJokerCard(joker_card_arr, joker_card_id) {
	var is_joker_card = false;
	for (var i = 0; i < joker_card_arr.length; i++) {
		//console.log("**********"+joker_card_arr[i].id+"==="+joker_card_id);	
		if (joker_card_arr[i].id == joker_card_id) {
			is_joker_card = true;
			break;
		}
	}
	return is_joker_card;
}//checkIfJokerCard ends 

/*** Get Table Index on which player is playing for multiple table **/
function getTableIndex(table_arr, table_id) {
	var index = -1;
	for (var i = 0; i < table_arr.length; i++) {
		//console.log("**********"+table_arr[i].id+"==="+table_id);	
		if (table_arr[i].id == table_id) {
			index = i;
			break;
		}
	}
	if (index == -1) {
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
	var cards = [];
	cards = all_images.slice(0, amount);
	all_images.splice(0, amount);
	if (!initial) {
		hand.push.apply(hand, cards);
	}
	return cards;
}

function getTableIdOfTournament(username, tournamentId) {
	var ret = -1;
	Object.keys(tournaments).forEach(function (id) {
		for (j = 0; j < tournaments[id].current_tables; j++) {
			var tableId = tournamentId * 1000 + j;
			var table_index = getTableIndex(room.tables, tableId);
			if (table_index >= 0) {
				for (k = 0; k < room.tables[table_index].players.length; k++) {
					if (room.tables[table_index].players[k].name == username) {
						ret = tableId;
					}
				}
			}
		}
	});

	return ret;
}

function getFixedNumber(x) {
	return Number.parseFloat(Number.parseFloat(x).toFixed(2));
}

function createSampleTables(amount) {
	var tableList = [];
	for (var i = 0; i < amount; i++) {
		var table = new Table((i + 1));
		table.setName("Test Table" + (i + 1));
		table.status = "available";
		tableList.push(table);
		//		console.log("--------------"+tableList.length+JSON.stringify(tableList));
	}
	return tableList;
}
/********************** Socket connection ********************/

server.listen(8090, 'rummysahara.com', {
	'heartbeat interval': 2,
	'heartbeat timeout': 5
});

