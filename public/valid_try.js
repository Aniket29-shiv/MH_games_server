function validateGroup()
{
	this.name = "VALIDATE";
	this.isValid = false;
};
		
validateGroup.prototype.validateGroupLimit = function(no_of_groups) {
	console.log("VALIDATING GROUP LIMIT");
	if(no_of_groups < 1)
	{
		//this.isValid = true;
		return true;
	}
	else return false;
};

/** Validate group if same cards but different suit (may include joker card)**/
validateGroup.prototype.validateSameCardSequence = function(card_group,joker_cards_arr,club_suit_cards) {
	console.log("VALIDATING GROUP If same cards but different suit");
	var card_name;
	var card_suit;
	console.log("\n Joker cards array "+JSON.stringify(joker_cards_arr));
	console.log("1st card name"+card_group[0].name+" suit "+card_group[0].suit);
	
	if(card_group.length == 3 || card_group.length == 4 )
	{
		card_name = card_group[0].name;
		card_suit = card_group[0].suit;
		for(var  i = 1; i < card_group.length; i++)
		{
			console.log("card name"+card_group[i].name+" suit "+card_group[i].suit);	
			if(card_group[i].name == card_name)
			{
				if(card_group[i].suit != card_suit)
				{
					if( i == (card_group.length-1))
					{
						return true;
					}
					else { continue; }
				}
				else { return false; }//break;}
			}//same card name
			else
			{
				for(var  j = 0; j < joker_cards_arr.length; j++)
				{
				console.log(joker_cards_arr[j].name +" compare to - "+card_name+" and "+joker_cards_arr[j].suit+" compare to "+ card_suit);
					if(joker_cards_arr[j].name == card_name && joker_cards_arr[j].suit == card_suit)
					{	
					console.log(" \n in j if "+j);
						if( i == (card_group.length-1))
						{
						console.log(" \n all compared ");
							return true;
						}
						//else {continue;}//return true;
					}
					//else { return false; }
				}
			}//not same card name but joker card
		}//ith for loop
	}
	else { return false;}
};

		/****----------------- Pure Sequence --------------------****/
/** Validate Pure Sequence group if different cards but same suit**/
validateGroup.prototype.validatePureSequence = function(card_group,joker_cards_arr,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards) 
{
console.log("VALIDATING PURE SEQUENCE If different cards but same suit");
	var card_name;
	var is_all_cards_with_same_suit = false;
	var card_suit;
	var is_joker = false;
	var index = -1;
	
	console.log("\n Joker cards array "+JSON.stringify(joker_cards_arr));
	//console.log("\n club_suit_cards array "+JSON.stringify(club_suit_cards));
	console.log("\n cards array with joker  "+JSON.stringify(card_group)+"----count---"+card_group.length);
	/* Check if any joker card included then remove it from group*/
	 for(var  i = 0; i < card_group.length; i++)
		{
		 for(var  j = 0; j < joker_cards_arr.length; j++)
		  {
			console.log(joker_cards_arr[j].name +" -"+joker_cards_arr[j].suit+" compare to "+card_group[i].name+"-"+ card_group[i].suit);
						
			 if(joker_cards_arr[j].name == card_group[i].name && joker_cards_arr[j].suit == card_group[i].suit)
				{	is_joker = true; }
				else { is_joker = false; }
		  }//joker_for
		}//outer for  
		
		if(is_joker !=true)
		{
			card_name = card_group[0].name;
			card_suit = card_group[0].suit;
			console.log("1st card name"+card_name+" suit "+card_suit);	
			//1. check if all cards with same suit
			for(var  i = 1; i < card_group.length; i++)
			{
				if(card_group[i].suit == card_suit)
					{
						if( i == (card_group.length-1))
						{
							is_all_cards_with_same_suit = true;
						}
						else { continue; }
					}
					else { is_all_cards_with_same_suit = false; }
			}
		
			/* get suit_array matching with card suit*/
			if(is_all_cards_with_same_suit == true )
			{
				if(card_suit == 'C')
				{
				console.log(" is C");
					return this.check_sequence_by_suit_id(card_group,club_suit_cards,'c');
				}
				if(card_suit == 'S')
				{
				console.log(" is S");
					return this.check_sequence_by_suit_id(card_group,spade_suit_cards,'s');
				}
				if(card_suit == 'H')
				{
				console.log(" is H");
					return this.check_sequence_by_suit_id(card_group,heart_suit_cards,'h');
				}
				if(card_suit == 'D')
				{
				console.log(" is D");
					return this.check_sequence_by_suit_id(card_group,diamond_suit_cards,'d');
				}
			}
			else { return false;}
		}//if no joker 
		else { return false;}
};

validateGroup.prototype.check_sequence_by_suit_id = function(player_card_group,suit_array_to_compare,str)
{
	console.log(" check_sequence_by_suit_id  of suit "+str);
	var temp = []; 
	var start_index = 0;
	var go_to_next_match = false;
	var i=0,j=0;
	/* var k = 0;
	
	if(i==0)
	{
		 k = (start_index-1);
	} */
	if(player_card_group.length>0)
	{
		temp.push.apply(temp,player_card_group);
	}
	if(temp.length >0)	
	{
		temp = temp.sort(function(a,b) 
		{
			return (a.suit_id < b.suit_id ? -1 : 1)
		});
		start_index = temp[0].suit_id;
		
		for(i = 0; i < temp.length;)// i++)
		{
		  for( j= (start_index-1); j < suit_array_to_compare.length;)// j++)
		   {
		   console.log("i "+i+"--"+j);
		   console.log(suit_array_to_compare[j].suit_id+"-- temp "+temp[i].suit_id);
		//  return true;
			if(suit_array_to_compare[j].suit_id == temp[i].suit_id )
				{
					if( i == (temp.length-1))
					{
					console.log("length end ");
						return true;
					}
					else 
					{ console.log("found match so continue"); 
					//continue; 
					//i++;
					go_to_next_match = true;
					break;
					}
				}
				else { console.log("no match break "); return false; }
		  }//inner for
		  if(go_to_next_match == true)
		  {
			i++;
			//j++;
			start_index++;
			//continue;
		  }
		}//outer for
	}
		
};
		/****----------------- Pure Sequence --------------------****/

/** Validate Pure Sequence group if different cards but same suit including joker**/
validateGroup.prototype.validateSubSequence = function(card_group,joker_cards_arr,club_suit_cards,spade_suit_cards,heart_suit_cards,diamond_suit_cards) 
{
	console.log("VALIDATING SUB SEQUENCE If different cards but same suit");
	
	var card_name;
	var is_all_cards_with_same_suit = false;
	var card_suit;
	var joker_count = 0;
	var index = -1;
	
	console.log("\n Joker cards array "+JSON.stringify(joker_cards_arr));
	//console.log("\n club_suit_cards array "+JSON.stringify(club_suit_cards));
	console.log("\n cards array with joker  "+JSON.stringify(card_group)+"----count---"+card_group.length+" joker_count "+joker_count);
	var temp1  = [];
	temp1.push.apply(temp1,card_group);
	var group_length  = 0;
	group_length = card_group.length;
	
	/* Check if any joker card included then remove it from group*/
	 for(var  i = 0; i < card_group.length; i++)
		{
		 for(var  j = 0; j < joker_cards_arr.length; j++)
		  {
			console.log(joker_cards_arr[j].name +" -"+joker_cards_arr[j].suit+" compare to "+card_group[i].name+"-"+ card_group[i].suit);
						
			 if(joker_cards_arr[j].name == card_group[i].name && joker_cards_arr[j].suit == card_group[i].suit)
				{
					joker_count++;
					index = i;
					if(index != -1)
					{
						card_group.remove(index);
						if( i == (card_group.length))
						{
							break;
						}
					}
				}
		  }//joker_for
		}//outer for  
		
		console.log("\n cards array after removed joker  "+JSON.stringify(card_group)+"----count---"+card_group.length+" joker_count "+joker_count);
		
		 card_name = card_group[0].name;
			card_suit = card_group[0].suit;
			console.log("1st card name"+card_name+" suit "+card_suit);	
			//1. check if all cards with same suit
			for(var  i = 1; i < card_group.length; i++)
			{
				if(card_group[i].suit == card_suit)
					{
						if( i == (card_group.length-1))
						{
							is_all_cards_with_same_suit = true;
						}
						else { continue; }
					}
					else { is_all_cards_with_same_suit = false; }
			} 
		
			/* get suit_array matching with card suit*/
			 if(is_all_cards_with_same_suit == true )
			{
				if(card_suit == 'C')
				{
				console.log(" is C");
					return this.check_sub_sequence_by_suit_id(card_group,club_suit_cards,'c',joker_count,temp1);
				}
				if(card_suit == 'S')
				{
				console.log(" is S");
					return this.check_sub_sequence_by_suit_id(card_group,spade_suit_cards,'s',joker_count,temp1);
				}
				if(card_suit == 'H')
				{
				console.log(" is H");
					return this.check_sub_sequence_by_suit_id(card_group,heart_suit_cards,'h',joker_count,temp1);
				}
				if(card_suit == 'D')
				{
				console.log(" is D");
					return this.check_sub_sequence_by_suit_id(card_group,diamond_suit_cards,'d',joker_count,temp1);
				}
			}
			else { return false;} 
		
};


validateGroup.prototype.check_sub_sequence_by_suit_id = function(player_card_group,suit_array_to_compare,str,joker_count,temp_card_array)
{
	console.log(" check_sub_sequence_by_suit_id  of suit "+str);
	var temp = []; 
	var start_index = 0;
	var go_to_next_match = false;
	var is_joker_match = false;
	var i=0,j=0;
	var no_of_jokers = joker_count;
	var next_index = 0;
	
	
	if(player_card_group.length>0)
	{
		temp.push.apply(temp,player_card_group);
	}
	if(temp.length >0)	
	{
		temp = temp.sort(function(a,b) 
		{
			return (a.suit_id < b.suit_id ? -1 : 1)
		});
		start_index = temp[0].suit_id;
		
		for(i = 0; i < temp.length;i++)
		{
			next_index = start_index+1;
			if(temp[i+1] == next_index)
			{
			
			}
			else
			{
				if(no_of_jokers > 0)
				{
					console.log("in else  if ");
					no_of_jokers--;
					start_index = next_index;
					i--;
					//go_to_next_match = true;
					//break;
				}
			}
			
		}
		
		//for(i = 0; i < temp.length;)
		for(i = 0; i < temp_card_array.length;)
		{
		  for( j= (start_index-1); j < suit_array_to_compare.length;)
		   {
		   console.log(suit_array_to_compare[j].suit_id+"-- temp "+temp[i].suit_id);
		
			if(suit_array_to_compare[j].suit_id == temp[i].suit_id )
				{
					if( i == (temp.length-1))
					{
					console.log("length end ");
						return true;
					}
					else 
					{
						console.log("found match so continue"); 
						go_to_next_match = true;
						break;
					}
				}
				else 
				{ 
				console.log("in else ");
					if(no_of_jokers > 0)
					{
					console.log("in else  if ");
						no_of_jokers--;
						go_to_next_match = true;
						//is_joker_match  = true;
						break;
					}
					else
					{
						console.log("in else else ");
						console.log("no match break "); 
						return false; 
					}
				}
		  }//inner for
		  if(go_to_next_match == true)
		  {
			i++;
			console.log("before index "+start_index);
			//if(is_joker_match!=true)
			{
			start_index++;
			}
			console.log("after  index "+start_index);
			}
		}//outer for
	}
		
};


module.exports = validateGroup;