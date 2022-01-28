$(document).ready(function(){
var joined = 0;
	/* $(".sit-popup").click(function(){
		$(".table-popup").show(300);
	}); */
	//console.log(account_bal);
	//console.log(joined_table);
	$("#top_player_sit").click(function(){
	 if(tableid != 0 && loggeduser != ""){
	if(account_bal > 0){
		//if(joined ==0)
		if(joined_table == false)
		{
			$(".table-popup").show(300);
			//$("#top_player_loader").css('display','none');
			joined = 1;
		}
		}else { 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
				}
	}
	});
	$("#bottom_player_sit").click(function(){
	if(tableid != 0 && loggeduser != ""){
	if(account_bal > 0){
		//if(joined ==0)
		if(joined_table == false)
		{
			$(".table-popup").show(300);
			//$("#bottom_player_loader").css('display','none');
			joined = 1;
		}
		}else { 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
				}
		}
	});
	$(".btn-cancel").click(function(){
		$(".table-popup").hide();
	});
	$(".close-declpop").click(function(){
		$(".declare-table").hide();
	});
	$(".declare-but").click(function(){
		$(".declare-table").show();
	});
	
	
});


$(document).ready(function(){
	$(".discard-arrow").click(function(e){
		e.preventDefault();
        e.stopPropagation();
		$(".discard-cards").fadeToggle();
	});
	$('.discard-cards').click( function(e) {
        e.stopPropagation();
    });
    $('body').click( function() {
       $('.discard-cards').hide();
    });
});


$(document).ready(function(){
	$(".openInfo").click(function(e){
		e.preventDefault();
        e.stopPropagation();
		$(".gameInfo").fadeToggle();
	});
	$('.gameInfo').click( function(e) {
        e.stopPropagation();
    });
    $('body').click( function() {
       $('.gameInfo').hide();
    });
	
	$(".fa-times").click(function(){
		$(".gameInfo").hide();
	});
});