$(document).ready(function(){
	$(".btn-cancel").click(function(){
		$(".table-popup").hide();
	});
	$(".close-declpop").click(function(){
		$(".declare-table").hide();
	});
	$(".declare-but").click(function(){
		$(".declare-table").show();
	});
	$(".sit").click(function(){
		$(".table-popup").show(300);
	});
	$(".tr-sit-here").click(function(){
		$(".table-popup").show(300);
	});
	$(".cr-sit-here").click(function(){
		$(".table-popup").show(300);
	});
	$(".cl-sit-here").click(function(){
		$(".table-popup").show(300);
	});
	$(".tl-sit-here").click(function(){
		$(".table-popup").show(300);
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