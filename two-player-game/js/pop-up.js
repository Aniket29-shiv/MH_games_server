$(document).ready(function(){
	$(".sit-popup").click(function(){
		$(".table-popup").show(300);
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