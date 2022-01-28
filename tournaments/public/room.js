
function Room(name) {
	this.players = [];
	this.tables = [];
	this.name = name;
	this.tableLimit = 4;
	this.pl = null;
	//	this.pl_groups = [];
};

/* Room.prototype.addGrp = function(table) {
	this.pl_groups.push(table);
};

Room.prototype.removeGrp = function(table) {
	var tableIndex = -1;
	for(var i = 0; i < this.pl_groups.length; i++){
		if(this.pl_groups[i].id == table.id){
			tableIndex = i;
			break;
		}
	}
	this.pl_groups.remove(tableIndex);
}; */

Room.prototype.addPlayer = function (player) {
	for (var i = 0; i < this.players.length; i++) {
		if (this.players[i].id == player.id) {
			this.players.remove(i);
			break;
		}
	}
	this.players.push(player);
};

Room.prototype.removePlayer = function (player) {
	var playerIndex = -1;
	for (var i = 0; i < this.players.length; i++) {
		if (this.players[i].id == player.id) {
			playerIndex = i;
			break;
		}
	}
	if (playerIndex != -1) {
		this.players.remove(playerIndex);
	}

};

Room.prototype.addTable = function (table) {
	this.tables.push(table);
};

Room.prototype.removeTable = function (table) {
	var tableIndex = -1;
	for (var i = 0; i < this.tables.length; i++) {
		if (this.tables[i].id == table.id) {
			tableIndex = i;
			break;
		}
	}
	this.tables.remove(tableIndex);
};

Room.prototype.removeTableById = function (id) {
	var tableIndex = -1;
	for (var i = 0; i < this.tables.length; i++) {
		if (this.tables[i].id == id) {
			tableIndex = i;
			break;
		}
	}
	if (tableIndex >= 0)
		this.tables.remove(tableIndex);
};


Room.prototype.getPlayer = function (playerId) {
	//console.log("\n get player ");
	var player = null;
	for (var i = 0; i < this.players.length; i++) {
		//console.log("\n this.players.length "+this.players.length);
		if (this.players[i].id == playerId) {
			//console.log("\n playerId "+playerId);
			player = this.players[i];
			//console.log("\n playerId "+player);
			break;
		}
	}
	return player;
};

Room.prototype.getPlayerByName = function (name, groupId) {
	//console.log("\n get player ");
	var player = null;
	for (var i = 0; i < this.players.length; i++) {
		//console.log("\n this.players.length "+this.players.length);
		if (this.players[i].name == name && this.players[i].tableID == groupId) {
			//console.log("\n playerId "+playerId);
			player = this.players[i];
			//console.log("\n playerId "+player);
			break;
		}
	}
	return player;
};

Room.prototype.getTable = function (tableId) {
	var table = null;
	for (var i = 0; i < this.tables.length; i++) {
		if (this.tables[i].id == tableId) {
			table = this.tables[i];
			break;
		}
	}
	return table;
};


module.exports = Room;