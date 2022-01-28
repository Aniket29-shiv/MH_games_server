 
 var socket = io.connect('http://localhost:8087');
		  var btnclicked,random_group_roundno;
		  var joined_group=false;
		 
			socket.on('connect', function(){
			//alert("connected");
				socket.emit('user_opened_join_group',username,grpid);
			});		 
		   		
				
			socket.on('user1_join_group_check', function(userjoined,btnclicked,groupid_listening){
			//alert("jjlljlkj"+"user set"+username+"user joined"+userjoined);
			if(username==userjoined)
			{
				joined_group=true;
			} 
				if(grpid==groupid_listening)
				{
					if($.trim($("#div_msg").html())=='')
					 {
						$('#div_msg').prepend(userjoined+' has joined...!<br/> '+' Waiting for other user to join group!');
						if(btnclicked==1)
						{
							$("#join1").hide();
							$("#user1name").text(userjoined);
						}
						else {
						   $("#join2").hide();
						   $("#user2name").text(userjoined);
							}
					  
					}
					else
					 {$('#div_msg').empty();  }
 				}
			});	
		
			$('#join1').click(function()
			{
				btnclicked = 1;
				if(joined_group==false)
				{
					joined_group=true;
					if($.trim($("#div_msg").html())=='')
					 { 
						//$('#div_msg').prepend('Waiting for other user to join group!');
						$('#div_msg').prepend(username+' has joined...!<br/> '+' Waiting for other user to join group!');
						$("#user1name").text(username);
					 }
					 else
					 {
						random_group_roundno = Math.floor(Math.random() * 100);
						  $('#div_msg').empty();
						  //$('#div_msg').prepend('Activity will start within 10 seconds..!!');
						  $('#div_msg').prepend(' <label id="Timer"></label>');
							$(function(){
							  var count = 10;
							  var countdown = setInterval(function(){
							  $("#Timer").text('Activity will start within '+count +' seconds..!');
							  if (count == 0) {
									  clearInterval(countdown); 
									  $("#grp_round_no").html(random_group_roundno);
									  $("#Timer").hide();	
									  $('#div_msg').hide();
									 
									  var imges = this.drawImages((this._shuffleImages(all_images)), 1, "", 1);
								      $.each(imges, function(k, v) {
										 $("#images").append("<div style='margin-top:2px; margin-left:10px; float: left; z-index:1'><img width='55px' height='55px' src="+v.card_path+"></div>");
										});
										
										 $('#buttons').prepend(' <button id="close_img" type="submit" style="width:120px;height:40px;margin: 110px 106px 62px 400px;">Close Images</button>&nbsp;<button id="open_img" type="submit" style=width:120px;height:40px;">Open Images</button>');
									}
								count--;
							  }, 1000);
							});
							$("#user1name").text($("#user2name").text());
							$("#user2name").text(username);
					 }
					 
					  socket.emit('user1_join_group', username,btnclicked,grpid,random_group_roundno);
					  $("#join1").hide();
					  //$("#user1name").text(username);
				  }
				  else
				  {
					alert("You have already joined to the group...!");
				  }
				  return false;
			});
			
			_shuffleImages = function(all_images) {
			  var i = 5, j, tempi, tempj;
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
			
			drawImages = function(all_images, amount, hand, initial) {
				var cards = [];
				cards = all_images.slice(0, amount);
				all_images.splice(0, amount);
				if (!initial) {
				  hand.push.apply(hand, cards); 
				}
				return cards;
			  }
			  
			  
			  
			$('#join2').click(function()
			{
				btnclicked = 2;
				if(joined_group==false)
				{
					joined_group=true;
				
					if($.trim($("#div_msg").html())=='')
					 {
						  //$('#div_msg').prepend('Waiting for other user to join group!');
						  $('#div_msg').prepend(username+' has joined...!<br/> '+' Waiting for other user to join group!');
						  //$("#user2name").text(username);
					 }
					else
					 {
						  random_group_roundno = Math.floor(Math.random() * 100);	
						  $('#div_msg').empty();
						  //$('#div_msg').prepend('Activity will start within 10 seconds..!!');
						 $('#div_msg').prepend(' <label id="Timer"></label>');
							$(function(){
							  var count = 10;
							  var countdown = setInterval(function(){
							  $("#Timer").text('Activity will start within '+count +' seconds..!');
							  if (count == 0) {
										  clearInterval(countdown);  
										  $("#grp_round_no").html(random_group_roundno);
										  $("#Timer").hide();	
										  $('#div_msg').hide();
										  var p = this._shuffleImages(all_images);
										  var imges = this.drawImages(p, 1, "", 1);
										  $.each(imges, function(k, v) {
										     $("#images").append("<div style='margin-top:2px; margin-left:10px; float: left; z-index:1'><img width='55px' height='55px' src="+v.card_path+"></div>");
										   });
										  $('#buttons').prepend(' <button id="close_img" type="submit" style="width:120px;height:40px;margin: 110px 106px 62px 400px;">Close Images</button>&nbsp;<button id="open_img" type="submit" style=width:120px;height:40px;">Open Images</button>');
									}
								count--;
							  }, 1000);
							});
							
							//$("#user1name").text($("#user2name").text());
							//$("#user2name").text(username);
					}
					socket.emit('user1_join_group', username,btnclicked,grpid,random_group_roundno);
					  $("#join2").hide();
					   $("#user2name").text(username);
					  //alert("user at button 1 : --- "+$("#user1name").text()+"user at button 2 : --- "+$("#user2name").text());
					 }
				 else
				  {
					alert("You have already joined to the group...!");
				  }
				   return false;
			});
			
			socket.on('user1_join_group', function(username_recvd,user,groupid_listening,recvd_random_group_roundno)
			{
			if(grpid==groupid_listening){
				if($.trim($("#div_msg").html())=='')
				 {
					//$('#div_msg').prepend('Waiting for other user to join group!');
					$('#div_msg').prepend(username_recvd+' has joined...!<br/> '+' Waiting for other user to join group!');
						if(user==1)
						{
						$("#join1").hide();
				      $("#user1name").text(username_recvd);
						}
 					 else {
					   $("#join2").hide();
				       $("#user2name").text(username_recvd);
					 }
					  
					}
				else
				 {
					$('#div_msg').empty();
					  //$('#div_msg').prepend('Activity will start within 10 seconds..!!');
					  $('#div_msg').prepend(' <label id="Timer"></label>');
						$(function(){
						  var count = 10;
						  var countdown = setInterval(function(){
						  $("#Timer").text('Activity will start within '+count +' seconds..!');
						  if (count == 0) {
								  clearInterval(countdown);  
								 $("#grp_round_no").html(recvd_random_group_roundno);
								 $("#Timer").hide();	
								 $('#div_msg').hide();
								 
								  var imges = this.drawImages((this._shuffleImages(all_images)), 1, "", 1);
								  $.each(imges, function(k, v) {
										 $("#images").append("<div style='margin-top:2px; margin-left:10px; float: left; z-index:1'><img width='55px' height='55px' src="+v.card_path+"></div>");
										});
									$('#buttons').prepend(' <button id="close_img" type="submit" style="width:120px;height:40px;margin: 110px 106px 62px 400px;">Close Images</button>&nbsp;<button id="open_img" type="submit" style=width:120px;height:40px;">Open Images</button>');
								}
							count--;
						  }, 1000);
						});
					 if(user==1)
						{
						$("#join1").hide();
				      $("#user1name").text(username_recvd);
					  }
 					 else {
					   $("#join2").hide();
				       //user2name").text(username);
					   $("#user2name").text($("#user1name").text());
					   $("#user1name").text(username_recvd);
					 }
				}
				}
			});
			
			/////leaving group ////
			$("#leave_group").click(function()
			{
			  
			});
			