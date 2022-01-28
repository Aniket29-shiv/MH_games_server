function validateGroup() {
	this.name = "VALIDATE";
	this.isValid = false;
};

validateGroup.prototype.validateGroupLimit = function (no_of_groups) {
	console.log("VALIDATING GROUP LIMIT");
	if (no_of_groups < 1) {
		return true;
	}
	else return false;
};

validateGroup.prototype.validateAllJoker = function (player_card_group, joker_cards_arr) {
	var card_group = [];
	card_group.push.apply(card_group, player_card_group);
	var isJoker;
	for (var i = 0; i < card_group.length; i++) {
		isJoker = false;
		for (var j = 0; j < joker_cards_arr.length; j++) {
			if (joker_cards_arr[j].name == card_group[i].name && joker_cards_arr[j].suit == card_group[i].suit) {
				isJoker = true;
				break;
			}
		}

		if (!isJoker)
			return false;
	}//ith for loop

	return true;
};

/** Validate group if same cards but different suit (may include joker card)**/
validateGroup.prototype.validateSameCardSequence = function (player_card_group, joker_cards_arr) {
	console.log("VALIDATING GROUP If same cards but different suit");
	var card_name;
	var card_suit;

	var card_group = [];
	card_group.push.apply(card_group, player_card_group);

	if (card_group.length == 3 || card_group.length == 4) {
		var idx = card_group.length - 1;

		for (var i = 0; i < card_group.length; i++) {
			var isJoker = false;
			for (var j = 0; j < joker_cards_arr.length; j++) {
				if (joker_cards_arr[j].name == card_group[i].name && joker_cards_arr[j].suit == card_group[i].suit) {
					isJoker = true;
					break;
				}
			}
			if (!isJoker) {
				idx = i;
				break;
			}
		}
		card_name = card_group[idx].name;
		card_suit = card_group[idx].suit;
		for (var i = idx + 1; i < card_group.length; i++) {
			if (card_group[i].name == card_name) {
				if (card_group[i].suit == card_suit) {
					return false;
				}
			}//same card name
			else {
				var isJoker = false;
				for (var j = 0; j < joker_cards_arr.length; j++) {
					if (joker_cards_arr[j].name == card_group[i].name && joker_cards_arr[j].suit == card_group[i].suit) {
						isJoker = true;
						break;
					}
				}
				if (!isJoker)
					return false;
			}//not same card name but joker card
		}//ith for loop
	}
	else { return false; }

	return true;
};

/****----------------- Pure Sequence --------------------****/
/** Validate Pure Sequence group if different cards but same suit**/
validateGroup.prototype.validatePureSequence = function (player_card_group, two_joker_cards_arr, club_suit_cards, spade_suit_cards, heart_suit_cards, diamond_suit_cards, joker_cards_arr) {
	console.log("VALIDATING PURE SEQUENCE If different cards but same suit");
	var card_name;
	var is_all_cards_with_same_suit = false;
	var card_suit;
	var is_printed_joker = false;
	var no_joker_included = false;
	var is_suit_joker_included = false;
	var joker_count = 0;
	var index = -1;
	var card_group = [];

	card_group.push.apply(card_group, player_card_group);
	if (card_group.length >= 3) {
		//console.log("\n cards array with/without joker  "+JSON.stringify(card_group)+"----count---"+card_group.length);

		/* Check if red/black joker card included then no pure sequence - go to next group(sub-sequence)*/
		for (var i = 0; i < card_group.length; i++) {
			for (var j = 0; j < two_joker_cards_arr.length; j++) {
				if (two_joker_cards_arr[j].name == card_group[i].name && two_joker_cards_arr[j].suit == card_group[i].suit) { is_printed_joker = true; }
				else { is_printed_joker = false; }
			}//joker_for
		}//outer for  

		/* If no BLACK/RED Joker */
		if (is_printed_joker != true) {
			card_name = card_group[0].name;
			card_suit = card_group[0].suit;

			/** Check if it includes any joker card ***/
			/* Check if any joker card included then remove it from group*/
			for (var i = 0; i < card_group.length; i++) {
				for (var j = 0; j < joker_cards_arr.length; j++) {
					if (joker_cards_arr[j].name == card_group[i].name && joker_cards_arr[j].suit == card_group[i].suit) {
						if (card_group[i].suit == card_suit) {
							is_suit_joker_included = true;
							joker_count++;
						}
						else { return false; }
					}
					else {
						no_joker_included = true;
					}
				}//joker_for
			}//outer for 

			if (is_suit_joker_included == true || no_joker_included == true) {
				//1. check if all cards with same suit
				for (var i = 1; i < card_group.length; i++) {
					if (card_group[i].suit == card_suit) {
						if (i == (card_group.length - 1)) {
							is_all_cards_with_same_suit = true;
						}
						else { continue; }
					}
					else { is_all_cards_with_same_suit = false; }
				}

			}
			else { return false; }

			/* get suit_array matching with card suit*/
			if (is_all_cards_with_same_suit == true) {
				if (card_suit == 'C') {
					if (this.check_sequence_by_suit_id(card_group, club_suit_cards, 'c', is_suit_joker_included, joker_count)) {
						return true;
					} else if (this.make_A_card_as_14(card_group)) {
						var ret = this.check_sequence_by_suit_id(card_group, club_suit_cards, 'c', is_suit_joker_included, joker_count);
						this.make_A_card_as_1(card_group);
						return ret;
					}
				}
				if (card_suit == 'S') {
					if (this.check_sequence_by_suit_id(card_group, spade_suit_cards, 's', is_suit_joker_included, joker_count)) {
						return true;
					} else if (this.make_A_card_as_14(card_group)) {
						var ret = this.check_sequence_by_suit_id(card_group, spade_suit_cards, 's', is_suit_joker_included, joker_count);
						this.make_A_card_as_1(card_group);
						return ret;
					}
				}
				if (card_suit == 'H') {
					if (this.check_sequence_by_suit_id(card_group, heart_suit_cards, 'h', is_suit_joker_included, joker_count)) {
						return true;
					} else if (this.make_A_card_as_14(card_group)) {
						var ret = this.check_sequence_by_suit_id(card_group, heart_suit_cards, 'h', is_suit_joker_included, joker_count);
						this.make_A_card_as_1(card_group);
						return ret;
					}
				}
				if (card_suit == 'D') {
					if (this.check_sequence_by_suit_id(card_group, diamond_suit_cards, 'd', is_suit_joker_included, joker_count)) {
						return true;
					} else if (this.make_A_card_as_14(card_group)) {
						var ret = this.check_sequence_by_suit_id(card_group, diamond_suit_cards, 'd', is_suit_joker_included, joker_count);
						this.make_A_card_as_1(card_group);
						return ret;
					}
				}
			}
			else { return false; }
		}//if no joker 
		else { return false; }

	} else { return false; }
};

validateGroup.prototype.check_sequence_by_suit_id = function (player_card_group, suit_array_to_compare, str, is_same_suit_joker_included, joker_count) {

	var temp = [];
	var start_index = 0;
	var last_index = 0;
	var go_to_next_match = false;
	var is_joker_match = false;
	var i = 0, j = 0;
	var no_of_jokers = joker_count;
	var jj = 0;
	var temp1 = [];

	if (player_card_group.length > 0) {
		temp.push.apply(temp, player_card_group);
	}
	if (temp.length > 0) {
		/* Check if King And Ace card included in sequence */
		//console.log("\n Before ace-king check "+JSON.stringify(temp));
		//Andy this.check_sequence_contains_KA_cards(temp);
		//console.log("\n AFTER ace-king check "+JSON.stringify(temp));

		temp = temp.sort(function (a, b) {
			//return (a.suit_id < b.suit_id ? -1 : 1)
			return (a.suit_id - b.suit_id)
		});
		//console.log("\n AFTER SORT  "+JSON.stringify(temp));
		start_index = temp[0].suit_id;
		last_index = temp[temp.length - 1].suit_id;

		if (is_same_suit_joker_included == false) {
			for (i = 0; i < temp.length;) {
				for (j = (start_index - 1); j < suit_array_to_compare.length;) {
					if (suit_array_to_compare[j].suit_id == temp[i].suit_id) {
						if (i == (temp.length - 1)) {
							return true;
						}
						else {
							go_to_next_match = true;
							break;
						}
					}
					else {
						return false;
					}
				}//inner for
				if (go_to_next_match == true) {
					i++;
					start_index++;
				}
			}//outer for
		}//if_joker_card
		else {
			for (j = (start_index - 1); j < last_index; j++) {
				temp1[i] = suit_array_to_compare[j];
				i++;
			}
			for (i = 0; i < (temp1.length);) {
				for (j = jj; j < (temp.length);) {
					if (temp1[i].suit_id == temp[j].suit_id) {
						if (i == (temp1.length - 1)) {
							return true;
						}
						else {
							go_to_next_match = true;
							is_joker_match = true;
							break;
						}
					}
					else { return false; }
				}//inner for
				if (go_to_next_match == true) {
					i++;
					if (is_joker_match == true) {
						jj++;
					}
				}
			}//outer for 
		}//same_suit_joker_included
	}

};
/****----------------- Pure Sequence --------------------****/

/** Validate Pure Sequence group if different cards but same suit including joker**/
validateGroup.prototype.validateSubSequence = function (player_card_group, joker_cards_arr, club_suit_cards, spade_suit_cards, heart_suit_cards, diamond_suit_cards) {
	console.log("VALIDATING SUB SEQUENCE If different cards but same suit");

	var card_name;
	var is_all_cards_with_same_suit = false;
	var card_suit;
	var joker_count = 0;
	var index = -1;
	var card_group = [];
	var temp1 = [];
	var group_length = 0;

	card_group.push.apply(card_group, player_card_group);
	temp1.push.apply(temp1, card_group);
	group_length = card_group.length;
	if (group_length >= 3) {

		/* Check if any joker card included then remove it from group*/
		for (var i = 0; i < card_group.length; i++) {
			for (var j = 0; j < joker_cards_arr.length; j++) {
				if (joker_cards_arr[j].name == card_group[i].name && joker_cards_arr[j].suit == card_group[i].suit) {
					joker_count++;
					index = i;
					if (index != -1) {
						card_group.remove(index);
						if (i == (card_group.length)) {
							break;
						}
					}
				}
			}//joker_for
		}//outer for  

		if (card_group.length != 0) {
			card_name = card_group[0].name;
			card_suit = card_group[0].suit;

			//1. check if all cards with same suit
			for (var i = 1; i < card_group.length; i++) {
				if (card_group[i].suit == card_suit) {
					if (i == (card_group.length - 1)) {
						is_all_cards_with_same_suit = true;
					}
					else { continue; }
				}
				else { is_all_cards_with_same_suit = false; }
			}
		}
		else { return false; }

		/* get suit_array matching with card suit*/
		if (is_all_cards_with_same_suit == true) {
			if (card_suit == 'C') {
				if (this.check_sub_sequence_by_suit_id(card_group, club_suit_cards, 'c', joker_count, temp1)) {
					return true;
				} else if (this.make_A_card_as_14(card_group)) {
					var ret = this.check_sub_sequence_by_suit_id(card_group, club_suit_cards, 'c', joker_count, temp1);;
					this.make_A_card_as_1(card_group);
					return ret;
				}
			}
			if (card_suit == 'S') {
				if (this.check_sub_sequence_by_suit_id(card_group, spade_suit_cards, 's', joker_count, temp1)) {
					return true;
				} else if (this.make_A_card_as_14(card_group)) {
					var ret = this.check_sub_sequence_by_suit_id(card_group, spade_suit_cards, 's', joker_count, temp1);
					this.make_A_card_as_1(card_group);
					return ret;
				}
			}
			if (card_suit == 'H') {
				if (this.check_sub_sequence_by_suit_id(card_group, heart_suit_cards, 'h', joker_count, temp1)) {
					return true;
				} else if (this.make_A_card_as_14(card_group)) {
					var ret = this.check_sub_sequence_by_suit_id(card_group, heart_suit_cards, 'h', joker_count, temp1);
					this.make_A_card_as_1(card_group);
					return ret;
				}
			}
			if (card_suit == 'D') {
				if (this.check_sub_sequence_by_suit_id(card_group, diamond_suit_cards, 'd', joker_count, temp1)) {
					return true;
				} else if (this.make_A_card_as_14(card_group)) {
					var ret = this.check_sub_sequence_by_suit_id(card_group, diamond_suit_cards, 'd', joker_count, temp1);
					this.make_A_card_as_1(card_group);
					return ret;
				}
			}
		}
		else { return false; }

	} else { return false; }

};
validateGroup.prototype.check_sub_sequence_by_suit_id = function (player_card_group, suit_array_to_compare, str, joker_count, temp_card_array) {
	var temp = [];
	var start_index = 0;
	var last_index = 0;
	var go_to_next_match = false;
	var is_joker_match = false;
	var i = 0, j = 0;
	var no_of_jokers = joker_count;
	var next_index = 0;
	var jj = 0;
	var temp1 = [];


	if (player_card_group.length > 0) {
		temp.push.apply(temp, player_card_group);
	}
	if (temp.length > 0) {
		//console.log("\n Before SUB ace-king check "+JSON.stringify(temp));
		//Andy this.check_sequence_contains_KA_cards(temp);
		//console.log("\n AFTER SUB ace-king check "+JSON.stringify(temp));		
		temp = temp.sort(function (a, b) {
			//return (a.suit_id < b.suit_id ? -1 : 1)
			return (a.suit_id - b.suit_id)
		});
		start_index = temp[0].suit_id;
		last_index = temp[temp.length - 1].suit_id;

		for (j = (start_index - 1); j < last_index; j++) {
			temp1[i] = suit_array_to_compare[j];
			i++;
		}
		for (i = 0; i < (temp1.length);) {
			for (j = jj; j < (temp.length);) {
				if (temp1[i].suit_id == temp[j].suit_id) {
					if (i == (temp1.length - 1)) {
						return true;
					}
					else {
						go_to_next_match = true;
						is_joker_match = true;
						break;
					}
				}
				else if (no_of_jokers > 0) {
					no_of_jokers--;
					go_to_next_match = true;
					is_joker_match = false;
					break;
				}
				else { return false; }
			}//inner for
			if (go_to_next_match == true) {
				i++;
				if (is_joker_match == true) {
					jj++;
				}
			}
		}//outer for 
	}
};
/*** Check If Sequence (Pure/Sub) includes K as well as A card ***/
validateGroup.prototype.check_sequence_contains_KA_cards = function (player_card_group) {
	var aceIdx = -1, kingIdx = -1;
	for (var j = 0; j < player_card_group.length; j++) {
		if (player_card_group[j].name == 'Ace') {
			aceIdx = j;
		} else if (player_card_group[j].name == 'King') {
			kingIdx = j;
		}//found-A-card
	}//check if A card

	if (aceIdx != -1 && kingIdx != -1) {
		player_card_group.remove(aceIdx);
	}
};


/*** Check If Sequence (Pure/Sub) includes A card and make 14 ***/
validateGroup.prototype.make_A_card_as_14 = function (player_card_group) {
	for (var j = 0; j < player_card_group.length; j++) {
		if (player_card_group[j].name == 'Ace') {
			player_card_group[j].suit_id = 14;
			return true;
		}
	}//check if A card

	return false;
};

/*** Check If Sequence (Pure/Sub) includes A card and make 1 ***/
validateGroup.prototype.make_A_card_as_1 = function (player_card_group) {
	for (var j = 0; j < player_card_group.length; j++) {
		if (player_card_group[j].name == 'Ace') {
			player_card_group[j].suit_id = 1;
			return true;
		}
	}//check if A card

	return false;
};

module.exports = validateGroup;