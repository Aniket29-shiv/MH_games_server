socket.on('player_connecting_to_six_player_table', function (playername, tableid, btn_clicked) {

	console.log("\n IN 6 PLAYER GAME CODE ");
	var table_index = 0;
	table_index = getTableIndex(room.tables, tableid);
	if (table_index == - 1)
		return;
	if (room.tables[table_index].players.length == 0) {
		socket.broadcast.emit('player_connecting_to_table', playername, tableid, btn_clicked);
	}
	else if (room.tables[table_index].players.length == 1) {
		if (room.tables[table_index].players[0].name != playername) {
			if (room.tables[table_index].user_click[0] == btn_clicked) {
				socket.emit('sit_not_empty', room.tables[table_index].players[0].name, btn_clicked, tableid);
			}
			else if (room.tables[table_index].user_click[1] == btn_clicked) {
				socket.emit('sit_not_empty', room.tables[table_index].players[0].name, btn_clicked, tableid);
			}
			else {
				socket.broadcast.emit('player_connecting_to_table', playername, tableid, btn_clicked);
			}
		}
	}
});