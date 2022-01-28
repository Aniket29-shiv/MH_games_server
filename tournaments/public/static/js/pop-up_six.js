$(document).ready(function(){
	var joined = 0;
	$("#btn_cancel").click(function(){
		$(".table-popup").hide();
	});
	$(".close-declpop").click(function(){
		$(".declare-table").hide();
	});

	$(".sit").click(function(){
		//$(".table-popup").show(300);
		if(tableid != 0 && loggeduser != "")
		{
			if(account_bal > 0)
			{
				if(joined_table == false)
				{
					$(".table-popup").show(300);
					joined = 1;
				}
			}else 
			{ 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
			}
		}
	});
	$(".tr-sit-here").click(function(){
		if(tableid != 0 && loggeduser != "")
		{
			if(account_bal > 0)
			{
				if(joined_table == false)
				{
					$(".table-popup").show(300);
					joined = 1;
				}
			}else 
			{ 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
			}
		}
	});
	$(".cr-sit-here").click(function(){
		if(tableid != 0 && loggeduser != "")
		{
			if(account_bal > 0)
			{
				if(joined_table == false)
				{
					$(".table-popup").show(300);
					joined = 1;
				}
			}else 
			{ 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
			}
		}
	});
	$(".cl-sit-here").click(function(){
		if(tableid != 0 && loggeduser != "")
		{
			if(account_bal > 0)
			{
				if(joined_table == false)
				{
					$(".table-popup").show(300);
					joined = 1;
				}
			}else 
			{ 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
			}
		}
	});
	$(".tl-sit-here").click(function(){
		if(tableid != 0 && loggeduser != "")
		{
			if(account_bal > 0)
			{
				if(joined_table == false)
				{
					$(".table-popup").show(300);
					joined = 1;
				}
			}else 
			{ 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
			}
		}
	});
	$(".bott-sit").click(function(){
		if(tableid != 0 && loggeduser != "")
		{
			if(account_bal > 0)
			{
				if(joined_table == false)
				{
					$(".table-popup").show(300);
					joined = 1;
				}
			}else 
			{ 
				$("#table_popup").css('display','none');
				alert("You don't have sufficient balance to play game.");
			}
		}
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