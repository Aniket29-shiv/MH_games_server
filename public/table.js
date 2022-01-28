//Game = require('./game.js'); -----use if needed later 
var Utils = require("./utils.js");
var utils = new Utils();
//Player = require("./player.js");

Array.prototype.remove = function (from, to) {
	var rest = this.slice((to || from) + 1 || this.length);
	this.length = from < 0 ? this.length + from : from;
	return this.push.apply(this, rest);
};

function Table(tableID) {
	this.id = tableID;
	this.name = "";
	this.table_name = "";
	this.table_game = "";
	this.chip_type = "";
	this.table_point_value = 0;
	this.table_min_entry = 0;
	this.game_type = "";
	this.status = "available";
	this.players = [];
	this.playersID = [];
	this.readyToPlayCounter = 0;
	this.playerLimit = 2;
	this.pack = [];
	this.cardsOnTable = [];
	this.declared = 0;
	this.actionCard = false;
	this.requestActionCard = false;
	this.penalisingActionCard = false;
	this.forcedDraw = 0;
	this.open_cards = [];
	this.open_card_obj_arr = [];
	this.open_card_status = "";
	this.closed_cards_arr = [];
	this.suiteRequest = "";
	this.numberRequest = "";
	this.p1_group1 = [], this.p1_group2 = [], this.p1_group3 = [], this.p1_group4 = [], this.p1_group5 = [], this.p1_group6 = [], this.p1_group7 = [];
	//this.playerObj = null;
	this.round_id = 0;
	this.auto_declare = false;
	this.side_joker_card = "";
	this.side_joker_card_name = "";
	this.joker_cards = [];
	this.pure_joker_cards = [];
	this.is_player_finished = false;
	this.player1_amount = 0;
	this.player2_amount = 0;
	this.player1_poolamount = 0;
	this.player2_poolamount = 0;
	this.player1_name = "";
	this.player2_name = "";
	this.is_new_round = true;
	this.is_declared_valid_sequence = false;
	this.no_of_players_joined = 0;
	this.is_paid_game = "";/* use if needed */
	this.player1_game_status = "";
	this.player2_game_status = "";
	this.player1_user_id = 0;
	this.player2_user_id = 0;
	this.restart_timer = false;
	this.temp_open_object = "";
	this.finish_card_object = "";
	/* On live change timer here sequence is - activity-timer , turn timer , declare timer */
	this.timer_array = [15, 30, 45];
	this.usernames = [];
	this.user_click = [];
	this.player_gender = [];
	this.player_amount = [];
	this.player_poolamount = [];
	this.dealer_name = "";
	this.playerCapacity = 0;

	/****** for SIX player game ******/
	this.six_player_timer_array = [15, 30, 45];
	this.six_usernames = [];
	this.six_user_click = [];
	this.six_player_gender = [];
	this.six_player_amount = [];
	this.six_player_poolamount = [];
	this.players_playing = [];
	this.player_waiting = [];
	this.activity_timer_running = false;
	this.activity_timer_set = false;


	this.open_cards_six = [];
	this.open_card_obj_arr_six = [];
	this.open_card_status_six = "";
	this.closed_cards_arr_six = [];
	this.side_joker_card_six = "";
	this.joker_cards_six = [];
	this.pure_joker_cards_six = [];
	this.round_id_six = 0;//not used if need use /check
	this.players_playing_sequence = [];
	this.no_of_live_players = 0;

	//needed while inserting details to game_transactions table and for restart 
	this.players_names = [];
	this.players_amounts = [];
	this.players_poolamounts = [];
	this.players_final_status = [];
	this.players_user_id = [];
	this.game_declare_status = "Invalid";
	this.game_finished_status = false;
	this.game_calculation_done = false;
	/****** for SIX player game ******/

	this.isfirstTurn = true;
	this.game_countdown = 0;
	this.game_countdown_six = 0;
	this.restart_game_six = false;
	this.clients_connected = [];

	this.activity_timer = 0;
	this.activity_timer_client_side_needed = 0;

	this.activity_timer_six = 0;
	this.activity_timer_client_side_needed_six = 0;

	this.turnTimer = 0;
	this.finalTimer = 0;

	this.countdown_timer = 0;
	this.countdown_tcount = 0;

	this.startingPlayerID = "";
	this.startingPlayerName = "";

	this.pl_seq_arr = [];
	this.is_finish = false;
};

Table.prototype.progressRound = function (player) {
	for (var i = 0; i < this.players.length; i++) {
		this.players[i].turnFinished = false;
		if (this.players[i].id == player.id) { //when player is the same that plays, end their turn
			player.turnFinished = true;
		}
	}
}

Table.prototype.setName = function (name) {
	this.name = name;
};

Table.prototype.getName = function () {
	return this.name;
};

Table.prototype.setStatus = function (status) {
	this.status = status;
};

Table.prototype.isAvailable = function () {
	return this.status === "available";
};

Table.prototype.isFull = function () {
	return this.status === "full";
};

Table.prototype.isPlaying = function () {
	return this.status === "playing";
};

Table.prototype.getPlayerIdx = function (player) {
	for (var i = 0; i < this.players.length; i++) {
		if (this.players[i].id == player.id) {
			return i;
		}
	}
	return -1;
};

Table.prototype.addPlayer = function (player) {
	if (this.status === "available") {
		//console.log("\n @@@@@@ in add player function -> count "+this.players.length);
		var found = false;
		for (var i = 0; i < this.players.length; i++) {
			if (this.players[i].id == player.id) {
				found = true;
				break;
			}
		}
		//console.log("\n ADDING PLAYER TO TABLE "+found+" count "+this.players.length);
		if (!found) {
			this.players.push(player); this.no_of_players_joined++;
			//console.log("\n FOUND FALSE SO ADD  PLAYER TO TABLE AND count "+this.players.length);
			if (this.players.length == this.playerLimit) {
				for (var i = 0; i < this.players.length; i++) {
					if (this.players[i].status != "disconnected")
						this.players[i].status = "intable";
				}
			}
			return true;
		}
	}
	return false;
};

Table.prototype.removePlayer = function (player) {
	var index = -1;
	for (var i = 0; i < this.players.length; i++) {
		if (this.players[i].id === player.id) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		this.players.remove(index);
	}
};


Table.prototype.addSocket = function (socketid) {
	var found = false;
	for (var i = 0; i < this.clients_connected.length; i++) {
		if (this.clients_connected[i] == socketid) {
			found = true;
			break;
		}
	}
	//console.log("\n ADDING PLAYER TO TABLE "+found+" count "+this.players.length);
	if (!found) {
		this.clients_connected.push(socketid);
		return true;
	}
	return false;
};

Table.prototype.removeSocket = function (socketid) {
	var index = -1;
	for (var i = 0; i < this.clients_connected.length; i++) {
		if (this.clients_connected[i] === socketid) {
			index = i;
			break;
		}
	}
	if (index != -1) {
		this.clients_connected.splice(index, 1);
	}
};

Table.prototype.connectedSocket = function () {
	return this.clients_connected.length;
}

Table.prototype.isTableAvailable = function () {////change  here is grp availbale 
	if ((this.playerLimit >= this.players.length) && (this.status === "available")) {
		return true;
	} else {
		return false;
	}
	//return (this.playerLimit > this.players.length);
};

Table.prototype.createMessageObject = function () {
	var table = this;
	var TableMessage = function () {
		this.id = table.id;
		this.name = table.name;
		this.status = table.status;
		this.players = table.players;
		this.playerLimit = table.playerLimit;
	};

	return new TableMessage();
};

module.exports = Table;