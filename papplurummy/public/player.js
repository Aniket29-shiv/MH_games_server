function Player(playerID) {
	this.id = "";//playerID;
	this.name = "";
	this.socket_id = "";
	this.tableID = "";
	this.hand = [];
	this.status = "available";
	//this.turnFinished = "";
	this.turnFinished = false;
	this.ip_address = "";
	this.isp = "";
	this.os_type = "";
	this.device_name = "";
	this.browser_using = "";
	this.group_joined = [];
	this.open_close_selected_count = 0;
	this.open_cards = [];
	this.turn = false;
	this.declared = false;
	this.is_grouped = false;
	this.gameFinished = false;
	this.card_group1 = [], this.card_group2 = [], this.card_group3 = [], this.card_group4 = [], this.card_group5 = [], this.card_group6 = [], this.card_group7 = [];
	this.amount_playing = 0;
	this.poolamount_playing = 0;
	this.is_declared_valid_sequence = false;
	this.game_score = 0;
	this.amount_won = 0;
	this.papplu_card_total = 0;
	this.poolamount_won = 0;
	this.amount_won_db = 0;
	this.poolamount_won_db = 0;
	//this.dropped = false;
	//this.turn_count =1;
	this.turn_count = 0;
	this.is_dropped_game = false;
	this.game_status = "";
	this.user_id = 0;
	this.player_reconnected = false;
	this.is_turn = false;
	this.is_joined_table = false;
	this.game_display_status = "Live";

	/**** new added for 6 player game ***/
	this.hand_cards_id = [];
	this.game_declared_status = "Invalid";

	this.extra_time = 30;
	this.freeturn = 0;
	this.player_start_play = false;
	
	this.player_turn_only_first = false;
	
};
Player.prototype.addGroup = function (group) {
	this.group_joined.push(group);
};

Player.prototype.removeGroup = function (group) {
	var groupIndex = -1;
	for (var i = 0; i < this.group_joined.length; i++) {
		if (this.group_joined[i].id == group.id) {
			groupIndex = i;
			break;
		}
	}
	this.group_joined.remove(groupIndex);
};

Player.prototype.setID = function (playerID) {
	this.id = playerID;
};
Player.prototype.setName = function (name) {
	this.name = name;
};

Player.prototype.getName = function () {
	return this.name;
};


Player.prototype.setTurn = function (turn) {
	this.turn = turn;
};

Player.prototype.getTurn = function () {
	return this.turn;
};
Player.prototype.setSocket_id = function (socket_id) {
	this.socket_id = socket_id;
};

Player.prototype.getSocket_id = function () {
	return this.socket_id;
};
Player.prototype.setIp = function (ip_address) {
	this.ip_address = ip_address;
};

Player.prototype.getIp = function () {
	return this.ip_address;
};
Player.prototype.setIsp = function (isp) {
	this.isp = isp;
};

Player.prototype.getIsp = function () {
	return this.isp;
};
Player.prototype.setOS = function (os_type) {
	this.os_type = os_type;
};

Player.prototype.getOS = function () {
	return this.os_type;
};
Player.prototype.setDevice = function (device_name) {
	this.device_name = device_name;
};

Player.prototype.getDevice = function () {
	return this.device_name;
};

Player.prototype.setBrowser = function (browser_using) {
	this.browser_using = browser_using;
};

Player.prototype.getBrowser = function () {
	return this.browser_using;
};

Player.prototype.setTableID = function (tableID) {
	this.tableID = tableID;
};

Player.prototype.getTableID = function () {
	return this.tableID;
};

Player.prototype.setCards = function (cards) {
	this.cards = cards;
};

Player.prototype.getCard = function () {
	return this.cards;
};

Player.prototype.setStatus = function (status) {
	this.status = status;
};

Player.prototype.isAvailable = function () {
	return this.status === "available";
};

Player.prototype.isInTable = function () {
	return this.status === "intable";
};

Player.prototype.isPlaying = function () {
	return this.status === "playing";
};

module.exports = Player;