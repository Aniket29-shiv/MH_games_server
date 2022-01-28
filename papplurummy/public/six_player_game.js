var another = require('./gameapp.js');
//var Room = require('./room.js');
 //var room = new Room("Test Room");
 var Table = require('./table.js');
 var Player = require("./player.js");

function sockets(socket,game,room) {
  	console.log("\n IN 6 PLAYER GAME CODE ");

  	socket.on('player_connecting_to_six_player_table', function(playername,tableid,btn_clicked)
   {
		console.log("\n IN player_connecting_to_six_player_table ");
		var table_index =0;
		console.log(" room name "+room.name);
		console.log(" room.tables[table_index]"+room.tables.length);
		table_index = another.data.test(room.tables,tableid);
		//table_index = another.data.getTableIndex(room.tables,tableid);
		console.log(" table_index"+table_index);
		
		if (room.tables[table_index].players.length == 0) 
			{
				socket.broadcast.emit('player_connecting_to_six_player_table',playername,tableid,btn_clicked);
			}
			else if (room.tables[table_index].players.length == 1) 
			{
				if (room.tables[table_index].players[0].name != playername) 
				{ 
					if(room.tables[table_index].user_click[0] == btn_clicked)
					{
						socket.emit('six_pl_sit_not_empty',room.tables[table_index].players[0].name,btn_clicked,tableid);			
					}
					else if(room.tables[table_index].user_click[1] == btn_clicked)
					{
						socket.emit('six_pl_sit_not_empty',room.tables[table_index].players[0].name,btn_clicked,tableid);			
					}
					else
					{
						socket.broadcast.emit('player_connecting_to_six_player_table',playername,tableid,btn_clicked);
					}
				}
			}
   });


  	 socket.on('player_not_connecting_to_six_player_table', function(playername,tableid,btn_clicked)
   {
   	var table_index =0;
		table_index = another.data.test(room.tables,tableid);
		if (room.tables[table_index].players.length == 0) 
			{
				socket.broadcast.emit('player_not_connecting_to_six_player_table',playername,tableid,btn_clicked);
			}
			else if (room.tables[table_index].players.length == 1) 
			{
				if (room.tables[table_index].players[0].name != playername) 
				{ 
					if(room.tables[table_index].user_click[0] != btn_clicked)
					{
						socket.broadcast.emit('player_not_connecting_to_six_player_table',playername,tableid,btn_clicked);			
					}
					else if(room.tables[table_index].user_click[1] != btn_clicked)
					{
						socket.broadcast.emit('player_not_connecting_to_six_player_table',playername,tableid,btn_clicked);			
					}
				}
			}
		
   });
   


}

module.exports = sockets;



 