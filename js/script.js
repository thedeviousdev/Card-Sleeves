$(document).ready(function() {
 	$(".game-select").chosen({no_results_text: "Oops, nothing found!"});

	$( ".form_search" ).submit(function( event ) {
	  event.preventDefault();
    var data = $(this).serialize();
    // alert(data);

	 	$.ajax({
		  method: "GET",
		  url: "game_detail.php",
		  data: data
		})
	  .done(function( msg ) {
	  	$(".search_result").html(msg);
	  });
	});

});

$(document).on('click', '.btn_add', function() {
		console.log('add');

		var game_id = $(this).data( "game_id" );

	 	$.ajax({
		  method: "GET",
		  url: "game_session.php",
		  data: { add_game: game_id}
		})
	  .done(function( msg ) {
	  	var search = $(".search_result").html();
	  	$(".search_result").html("");

	  	$(".current_games").append(search);
	    // alert( "Data Saved: " + msg );
	  });
	});