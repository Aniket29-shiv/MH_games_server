function drop_game() {
	var dropped_player = data.user_who_dropped_game;

	console.log("\n ***** GAME DROPPED ");
	console.log("\n \n dropped_player " + dropped_player);
	console.log("\n *****");

	var group = data.group;
	var round_id = data.round_id;
	var player = room.getPlayer(socket.id);
	var table_index = 0;
	table_index = getTableIndex(room.tables, group);
	if (table_index == - 1) {
		console.log("\n drop_game");
		return;
	}
	var player_amount = data.amount;
	var group1 = [], group2 = [], group3 = [], group4 = [], group5 = [], group6 = [], group7 = [];
	var is_sorted = data.is_sort;
	var is_grouped = data.is_group;
	var is_initial_grouped = data.is_initial_group;
	var opponent_player;
	var dropped_player_grouped = false;
	var other_player_grouped = false;
	var oth_player_status, first_player_status;
	var dropped_pl_score = 0, opp_pl_score = 0;
	var dropped_pl_won_amount = 0, opp_pl_won_amount = 0;
	var score = 0;

	var winner_won_amount = 0;
	var company_commision_amount = 0;
	var table_player_capacity = 0;
	table_player_capacity = room.tables[table_index].playerCapacity;

	console.log("\n dropped user " + dropped_player + " did sorting " + is_sorted + " initial grouping " + is_initial_grouped + " grouping " + is_grouped);

	if (room.tables[table_index].round_id == round_id) {
		if (room.tables[table_index].players[0].name == dropped_player) {
			//room.tables[table_index].players[0].dropped = true;
			room.tables[table_index].players[0].is_dropped_game = true;
			room.tables[table_index].players[1].is_dropped_game = true;

			room.tables[table_index].players[0].game_status = "Lost";
			room.tables[table_index].players[1].game_status = "Won";

			opponent_player = room.tables[table_index].players[1].name;
			dropped_player_grouped = room.tables[table_index].players[0].is_grouped;
			other_player_grouped = room.tables[table_index].players[1].is_grouped;
		}
		if (room.tables[table_index].players[1].name == dropped_player) {
			//room.tables[table_index].players[1].dropped = true;
			room.tables[table_index].players[1].is_dropped_game = true;
			room.tables[table_index].players[0].is_dropped_game = true;

			room.tables[table_index].players[1].game_status = "Lost";
			room.tables[table_index].players[0].game_status = "Won";

			opponent_player = room.tables[table_index].players[0].name;
			dropped_player_grouped = room.tables[table_index].players[1].is_grouped;
			other_player_grouped = room.tables[table_index].players[0].is_grouped;
		}

		oth_player_status = room.tables[table_index].players[0].status;
		first_player_status = room.tables[table_index].players[1].status;

		if (room.tables[table_index].players[0].name == dropped_player) {
			console.log(" \n oth DROPPED game " + room.tables[table_index].player1_name + " pl1 amt " + room.tables[table_index].players[0].amount_playing + " pl2 " + room.tables[table_index].player2_name + " pl2 amt " + room.tables[table_index].players[1].amount_playing);
			console.log(" \n  before add ------> turn_count " + room.tables[table_index].players[0].turn_count);
			room.tables[table_index].players[0].turn_count++;
			console.log(" \n  After add ------> turn_count " + room.tables[table_index].players[0].turn_count);

			if ((room.tables[table_index].players[0].turn_count) == 1) { score = 20; }
			else if ((room.tables[table_index].players[0].turn_count) > 1) { score = 40; }

			room.tables[table_index].players[0].game_score = score;
			room.tables[table_index].players[1].game_score = 0;

			room.tables[table_index].players[0].amount_won = -(+((score * table_point_value).toFixed(3)));
			room.tables[table_index].players[0].amount_playing = +((room.tables[table_index].players[0].amount_playing - (score * table_point_value)).toFixed(3));

			if (table_game == 'Free Game') {
				room.tables[table_index].players[1].amount_won = (+((score * table_point_value).toFixed(3)));
				room.tables[table_index].players[1].amount_playing = +((room.tables[table_index].players[1].amount_playing + (score * table_point_value)).toFixed(3));
			}
			if (table_game == 'Cash Game') {
				winner_won_amount = score * table_point_value;
				company_commision_amount = (winner_won_amount * company_commision) / 100;
				winner_won_amount = winner_won_amount - company_commision_amount;
				room.tables[table_index].players[1].amount_won = +((winner_won_amount).toFixed(3));
				room.tables[table_index].players[1].amount_playing = +((room.tables[table_index].players[1].amount_playing + (winner_won_amount)).toFixed(3));

				/********* Inserting commision details to 'company_balance' table ******/
				player_name = player_name = room.tables[table_index].player1_name + ',' + room.tables[table_index].player2_name;
				commision_query = "INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('" + room.tables[table_index].id + "','" + room.tables[table_index].round_id + "','" + table_player_capacity + "','" + game_type + "','" + company_commision + "','" + (score * table_point_value) + "','" + company_commision_amount + "','" + player_name + "',now())";
				con.query(commision_query, function (err1, result) { });

			}



			room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
			room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;
			room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
			room.tables[table_index].player2_name = room.tables[table_index].players[0].name;

			/** Players game status**/
			room.tables[table_index].player1_game_status = "Won";
			room.tables[table_index].player2_game_status = "Lost";
			/** Players User Id**/
			room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
			room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;


			transaction_id = Math.floor(Math.random() * 100000000000000);
			/**** Inserting Transaction Details to database once game end/restarted ****/
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				insert_query = "insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values(" + room.tables[table_index].players[i].user_id + "," + transaction_id + ",'" + game_type + "','" + chip_type + "','" + room.tables[table_index].id + "','" + table_name + "','" + room.tables[table_index].round_id + "','" + room.tables[table_index].players[i].name + "','" + room.tables[table_index].players[i].game_status + "','" + winner_won_amount + "','" + dt + "')";

				con.query(insert_query, function (err1, result) { });
			}
			var table_open_cards = []; var table_close_cards = [];
			var player_card_group1 = []; var player_card_group2 = []; var player_card_group3 = []; var player_card_group4 = [];
			var player_card_group5 = []; var player_card_group6 = []; var player_card_group7 = [];
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
				if (room.tables[table_index].players[i].card_group1.length != 0) {
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
				}

				var update_game_details = "update game_details set `group1`='" + player_card_group1 + "',`group2`='" + player_card_group2 + "',`group3`='" + player_card_group3 + "',`group4`='" + player_card_group4 + "',`group5`='" + player_card_group5 + "',`group6`='" + player_card_group6 + "',`group7`='" + player_card_group7 + "',`close_cards`='" + table_close_cards + "',`open_card`='" + table_open_cards + "'  WHERE `user_id`='" + room.tables[table_index].players[i].name + "' and `group_id`='" + room.tables[table_index].id + "' and `round_id`='" + room.tables[table_index].round_id + "'";
				con.query(update_game_details, function (err, result) {
					if (err) throw err;
					else { console.log(result.affectedRows + " record(s) updated of game_details"); }
				});
			}//for ends 


			console.log(" \n GAME DROPPED pl1 " + room.tables[table_index].player1_name + " pl1 amt " + room.tables[table_index].player1_amount + " pl2 " + room.tables[table_index].player2_name + " pl2 amt " + room.tables[table_index].player2_amount);

			//console.log(" \n	 both pl status "+oth_player_status+"---1st st -"+first_player_status);
			/** Amount Updated after game end of player (if disconnected)**/
			if (first_player_status == "disconnected") {
				update_balance_after_declare(room.tables[table_index].players[1].name, group, room.tables[table_index].players[1].amount_playing, false);
			}


			if (is_sorted == true || is_grouped == true || is_initial_grouped == true) { dropped_player_grouped = true; }
			else { dropped_player_grouped = false; }

			//1st player - no group and 2nd player - no group
			if (dropped_player_grouped == false && other_player_grouped == false) {

				console.log("\n in 0 1st group- false , 2nd group - false");
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].hand, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].hand, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].hand, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].hand, prev_pl: opponent_player, user_grouped: other_player_grouped, other_grouped: dropped_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}
			}
			//1st player - grouped and 2nd player - no group
			if (dropped_player_grouped == true && other_player_grouped == false) {
				console.log("\n in 0  1st group- true , 2nd group - false");
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].card_group1, grp2_cards: room.tables[table_index].players[0].card_group2, grp3_cards: room.tables[table_index].players[0].card_group3, grp4_cards: room.tables[table_index].players[0].card_group4, grp5_cards: room.tables[table_index].players[0].card_group5, grp6_cards: room.tables[table_index].players[0].card_group6, grp7_cards: room.tables[table_index].players[0].card_group7, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].hand, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].hand, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].card_group1, grp2: room.tables[table_index].players[0].card_group2, grp3: room.tables[table_index].players[0].card_group3, grp4: room.tables[table_index].players[0].card_group4, grp5: room.tables[table_index].players[0].card_group5, grp6: room.tables[table_index].players[0].card_group6, grp7: room.tables[table_index].players[0].card_group7, prev_pl: opponent_player, user_grouped: other_player_grouped, other_grouped: dropped_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}
			}
			//1st player - no group and 2nd player - grouped
			if (dropped_player_grouped == false && other_player_grouped == true) {
				console.log("\n in 0  1st group- false , 2nd group - true");
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].hand, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].card_group1, grp2: room.tables[table_index].players[1].card_group2, grp3: room.tables[table_index].players[1].card_group3, grp4: room.tables[table_index].players[1].card_group4, grp5: room.tables[table_index].players[1].card_group5, grp6: room.tables[table_index].players[1].card_group6, grp7: room.tables[table_index].players[1].card_group7, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].card_group1, grp2_cards: room.tables[table_index].players[1].card_group2, grp3_cards: room.tables[table_index].players[1].card_group3, grp4_cards: room.tables[table_index].players[1].card_group4, grp5_cards: room.tables[table_index].players[1].card_group5, grp6_cards: room.tables[table_index].players[1].card_group6, grp7_cards: room.tables[table_index].players[1].card_group7, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].hand, prev_pl: opponent_player, user_grouped: other_player_grouped, other_grouped: dropped_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}

			}
			//both player - grouped
			if (dropped_player_grouped == true && other_player_grouped == true) {
				console.log("\n 1st in 0  group- true , 2nd group - true");
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].card_group1, grp2_cards: room.tables[table_index].players[0].card_group2, grp3_cards: room.tables[table_index].players[0].card_group3, grp4_cards: room.tables[table_index].players[0].card_group4, grp5_cards: room.tables[table_index].players[0].card_group5, grp6_cards: room.tables[table_index].players[0].card_group6, grp7_cards: room.tables[table_index].players[0].card_group7, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].card_group1, grp2: room.tables[table_index].players[1].card_group2, grp3: room.tables[table_index].players[1].card_group3, grp4: room.tables[table_index].players[1].card_group4, grp5: room.tables[table_index].players[1].card_group5, grp6: room.tables[table_index].players[1].card_group6, grp7: room.tables[table_index].players[1].card_group7, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].card_group1, grp2_cards: room.tables[table_index].players[1].card_group2, grp3_cards: room.tables[table_index].players[1].card_group3, grp4_cards: room.tables[table_index].players[1].card_group4, grp5_cards: room.tables[table_index].players[1].card_group5, grp6_cards: room.tables[table_index].players[1].card_group6, grp7_cards: room.tables[table_index].players[1].card_group7, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].card_group1, grp2: room.tables[table_index].players[0].card_group2, grp3: room.tables[table_index].players[0].card_group3, grp4: room.tables[table_index].players[0].card_group4, grp5: room.tables[table_index].players[0].card_group5, grp6: room.tables[table_index].players[0].card_group6, grp7: room.tables[table_index].players[0].card_group7, prev_pl: opponent_player, user_grouped: other_player_grouped, other_grouped: dropped_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}
			}


		}//0th player dropped 
		else {
			console.log(" \n 1st DROPPED game " + room.tables[table_index].player1_name + " pl1 amt " + room.tables[table_index].players[0].amount_playing + " pl2 " + room.tables[table_index].player2_name + " pl2 amt " + room.tables[table_index].players[1].amount_playing);
			console.log(" \n  before add ------> turn_count " + room.tables[table_index].players[1].turn_count);
			room.tables[table_index].players[1].turn_count++;
			console.log(" \n  After add ------> turn_count " + room.tables[table_index].players[1].turn_count);

			if ((room.tables[table_index].players[1].turn_count) == 1) { score = 20; }
			else if ((room.tables[table_index].players[1].turn_count) > 1) { score = 40; }

			room.tables[table_index].players[1].game_score = score;
			room.tables[table_index].players[0].game_score = 0;
			room.tables[table_index].players[1].amount_won = -(+((score * table_point_value).toFixed(3)));
			//room.tables[table_index].players[0].amount_won = (+((score * table_point_value).toFixed(3)));

			//room.tables[table_index].players[0].amount_playing = +((room.tables[table_index].players[0].amount_playing+(score * table_point_value)).toFixed(3));
			room.tables[table_index].players[1].amount_playing = +((room.tables[table_index].players[1].amount_playing - (score * table_point_value)).toFixed(3));

			if (table_game == 'Free Game') {
				room.tables[table_index].players[0].amount_won = (+((score * table_point_value).toFixed(3)));
				room.tables[table_index].players[0].amount_playing = +((room.tables[table_index].players[1].amount_playing + (score * table_point_value)).toFixed(3));
			}
			if (table_game == 'Cash Game') {
				winner_won_amount = score * table_point_value;
				company_commision_amount = (winner_won_amount * company_commision) / 100;
				winner_won_amount = winner_won_amount - company_commision_amount;
				room.tables[table_index].players[0].amount_won = +((winner_won_amount).toFixed(3));
				room.tables[table_index].players[0].amount_playing = +((room.tables[table_index].players[0].amount_playing + (winner_won_amount)).toFixed(3));

				/********* Inserting commision details to 'company_balance' table ******/
				player_name = player_name = room.tables[table_index].player1_name + ',' + room.tables[table_index].player2_name;
				commision_query = "INSERT INTO `company_balance`(`table_id`, `round_id`, `player_capacity`, `game_type`, `commission`, total_amount,`amount`, `players_name`, `date`) VALUES ('" + room.tables[table_index].id + "','" + room.tables[table_index].round_id + "','" + table_player_capacity + "','" + game_type + "','" + company_commision + "','" + (score * table_point_value) + "','" + company_commision_amount + "','" + player_name + "',now())";
				con.query(commision_query, function (err1, result) { });
			}


			room.tables[table_index].player1_amount = room.tables[table_index].players[1].amount_playing;
			room.tables[table_index].player2_amount = room.tables[table_index].players[0].amount_playing;
			room.tables[table_index].player1_name = room.tables[table_index].players[1].name;
			room.tables[table_index].player2_name = room.tables[table_index].players[0].name;

			room.tables[table_index].player1_game_status = "Lost";
			room.tables[table_index].player2_game_status = "Won";

			room.tables[table_index].player1_user_id = room.tables[table_index].players[1].user_id;
			room.tables[table_index].player2_user_id = room.tables[table_index].players[0].user_id;

			console.log(" \N GAME DROPPED pl1 " + room.tables[table_index].player1_name + " pl1 amt " + room.tables[table_index].player1_amount + " pl2 " + room.tables[table_index].player2_name + " pl2 amt " + room.tables[table_index].player2_amount);

			transaction_id = Math.floor(Math.random() * 100000000000000);
			/**** Inserting Transaction Details to database once game end/restarted ****/
			for (var i = 0; i < room.tables[table_index].players.length; i++) {
				insert_query = "insert into game_transactions(user_id,`game_transaction_id`, game_type,chip_type,`table_id`,table_name, `round_no`, `player_name`, `status`, `amount`, `transaction_date`)values(" + room.tables[table_index].players[i].user_id + "," + transaction_id + ",'" + game_type + "','" + chip_type + "','" + room.tables[table_index].id + "','" + table_name + "','" + room.tables[table_index].round_id + "','" + room.tables[table_index].players[i].name + "','" + room.tables[table_index].players[i].game_status + "','" + winner_won_amount + "','" + dt + "')";

				con.query(insert_query, function (err1, result) { });
			}
			var table_open_cards = []; var table_close_cards = [];
			var player_card_group1 = []; var player_card_group2 = []; var player_card_group3 = []; var player_card_group4 = [];
			var player_card_group5 = []; var player_card_group6 = []; var player_card_group7 = [];
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
				if (room.tables[table_index].players[i].card_group1.length != 0) {
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
				}

				var update_game_details = "update game_details set `group1`='" + player_card_group1 + "',`group2`='" + player_card_group2 + "',`group3`='" + player_card_group3 + "',`group4`='" + player_card_group4 + "',`group5`='" + player_card_group5 + "',`group6`='" + player_card_group6 + "',`group7`='" + player_card_group7 + "',`close_cards`='" + table_close_cards + "',`open_card`='" + table_open_cards + "'  WHERE `user_id`='" + room.tables[table_index].players[i].name + "' and `group_id`='" + room.tables[table_index].id + "' and `round_id`='" + room.tables[table_index].round_id + "'";
				con.query(update_game_details, function (err, result) {
					if (err) throw err;
					else { console.log(result.affectedRows + " record(s) updated in game details "); }
				});
			}//for ends 

			if (is_sorted == true || is_grouped == true || is_initial_grouped == true) { dropped_player_grouped = true; }
			else { dropped_player_grouped = false; }

			/** Amount Updated after game end of player (if disconnected)**/
			if (oth_player_status == "disconnected") {
				update_balance_after_declare(room.tables[table_index].players[0].name, group, room.tables[table_index].players[0].amount_playing, false);
			}


			//1st player - no group and 2nd player - no group
			if (dropped_player_grouped == false && other_player_grouped == false) {
				console.log("\n 1st in 1  group- false , 2nd group - false");
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].hand, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].hand, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].hand, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].hand, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
			}
			//1st player - grouped and 2nd player - no group
			if (dropped_player_grouped == true && other_player_grouped == false) {
				console.log("\n 1st in 1  group- true , 2nd group - false");
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].card_group1, grp2_cards: room.tables[table_index].players[1].card_group2, grp3_cards: room.tables[table_index].players[1].card_group3, grp4_cards: room.tables[table_index].players[1].card_group4, grp5_cards: room.tables[table_index].players[1].card_group5, grp6_cards: room.tables[table_index].players[1].card_group6, grp7_cards: room.tables[table_index].players[1].card_group7, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].hand, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].hand, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].card_group1, grp2: room.tables[table_index].players[1].card_group2, grp3: room.tables[table_index].players[1].card_group3, grp4: room.tables[table_index].players[1].card_group4, grp5: room.tables[table_index].players[1].card_group5, grp6: room.tables[table_index].players[1].card_group6, grp7: room.tables[table_index].players[1].card_group7, prev_pl: opponent_player, user_grouped: other_player_grouped, other_grouped: dropped_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
			}
			//1st player - no group and 2nd player - grouped
			if (dropped_player_grouped == false && other_player_grouped == true) {
				console.log("\n 1st in 1  group- false , 2nd group - true");
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].hand, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].card_group1, grp2: room.tables[table_index].players[0].card_group2, grp3: room.tables[table_index].players[0].card_group3, grp4: room.tables[table_index].players[0].card_group4, grp5: room.tables[table_index].players[0].card_group5, grp6: room.tables[table_index].players[0].card_group6, grp7: room.tables[table_index].players[0].card_group7, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].card_group1, grp2_cards: room.tables[table_index].players[0].card_group2, grp3_cards: room.tables[table_index].players[0].card_group3, grp4_cards: room.tables[table_index].players[0].card_group4, grp5_cards: room.tables[table_index].players[0].card_group5, grp6_cards: room.tables[table_index].players[0].card_group6, grp7_cards: room.tables[table_index].players[0].card_group7, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].hand, prev_pl: opponent_player, user_grouped: other_player_grouped, other_grouped: dropped_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
			}
			//both player - grouped
			if (dropped_player_grouped == true && other_player_grouped == true) {
				console.log("\n 1st in 1  group- true , 2nd group - true");
				if (first_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[1].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[1].card_group1, grp2_cards: room.tables[table_index].players[1].card_group2, grp3_cards: room.tables[table_index].players[1].card_group3, grp4_cards: room.tables[table_index].players[1].card_group4, grp5_cards: room.tables[table_index].players[1].card_group5, grp6_cards: room.tables[table_index].players[1].card_group6, grp7_cards: room.tables[table_index].players[1].card_group7, opp_user: (room.tables[table_index].players[0].name), grp1: room.tables[table_index].players[0].card_group1, grp2: room.tables[table_index].players[0].card_group2, grp3: room.tables[table_index].players[0].card_group3, grp4: room.tables[table_index].players[0].card_group4, grp5: room.tables[table_index].players[0].card_group5, grp6: room.tables[table_index].players[0].card_group6, grp7: room.tables[table_index].players[0].card_group7, prev_pl: opponent_player, user_grouped: dropped_player_grouped, other_grouped: other_player_grouped, game_score: room.tables[table_index].players[1].game_score, amount_won: room.tables[table_index].players[1].amount_won, opp_game_score: room.tables[table_index].players[0].game_score, opp_amount_won: room.tables[table_index].players[0].amount_won });
				}
				if (oth_player_status != "disconnected") {
					io.sockets.connected[(room.tables[table_index].players[0].id)].emit("dropped_game", { user: dropped_player, declared: 2, group: group, grp1_cards: room.tables[table_index].players[0].card_group1, grp2_cards: room.tables[table_index].players[0].card_group2, grp3_cards: room.tables[table_index].players[0].card_group3, grp4_cards: room.tables[table_index].players[0].card_group4, grp5_cards: room.tables[table_index].players[0].card_group5, grp6_cards: room.tables[table_index].players[0].card_group6, grp7_cards: room.tables[table_index].players[0].card_group7, opp_user: (room.tables[table_index].players[1].name), grp1: room.tables[table_index].players[1].card_group1, grp2: room.tables[table_index].players[1].card_group2, grp3: room.tables[table_index].players[1].card_group3, grp4: room.tables[table_index].players[1].card_group4, grp5: room.tables[table_index].players[1].card_group5, grp6: room.tables[table_index].players[1].card_group6, grp7: room.tables[table_index].players[1].card_group7, prev_pl: opponent_player, user_grouped: other_player_grouped, other_grouped: dropped_player_grouped, game_score: room.tables[table_index].players[0].game_score, amount_won: room.tables[table_index].players[0].amount_won, opp_game_score: room.tables[table_index].players[1].game_score, opp_amount_won: room.tables[table_index].players[1].amount_won });
				}
			}
		}//1st -player -dropped 

	}//same-table-round-id
});